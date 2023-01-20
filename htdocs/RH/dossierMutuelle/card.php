<?php

require '../../main.inc.php';
require_once '../../vendor/autoload.php';



if (!$user->rights->salaries->read) {
	accessforbidden("you don't have right for this page");
}


$action = GETPOST('action', 'alpha');
$cancel = GETPOST('cancel', 'alpha');
$id = GETPOST('id', 'alpha');
$userId = GETPOST('user', 'alpha');
$somme = GETPOST('somme', 'alpha');
$date_de_depot  = GETPOST('date_de_depot', 'date');

if ( $action != 'create' && $action != 'add' && (empty($id) || !is_numeric($id))){
    echo "<script>window.location.href='/RH/dossierMutuelle/list.php';</script>";
    exit;
}

$cnss = array();;
$sql = "SELECT ef.matricule, c.userid, u.firstName, u.lastName, c.somme, date(c.date_creation) as date_creation, c.date_de_depot, c.valide, date(c.date_validation) as date_validation, c.solde, date(c.date_solde) as date_solde  FROM llx_dossier_maladie_mutuelle as c LEFT JOIN llx_user as u on u.rowid = c.userid LEFT JOIN llx_user_extrafields as ef ON u.rowid = ef.fk_object where c.id=$id";
$res = $db->query($sql);
if ($res->num_rows) {
    $row = $res->fetch_assoc();
    foreach ($row as $key => $value) {
        $cnss[$key] = $value;
    }
}



$mydate = getdate(date("U"));
$month =  $mydate['mon'];
$year = $mydate['year'];
$day = $mydate['mday'];
if (strlen($month) == 1) {
	$month = '0' . $month;
}

if ($action == 'view'){
    $text = "Consulter dossiers mutuelle";

}elseif ($action =='edit'){
    $text = "Modifier dossiers mutuelle";

}else if($action == 'create'){
    $text = "Ajouter dossiers mutuelle";
 
}
if ($action == 'add'){
    $sql = "INSERT INTO `llx_dossier_maladie_mutuelle` (`userid`, `somme`, `date_de_depot`) VALUES ($userId, $somme, '$date_de_depot');";
    $res = $db->query($sql);
    if ($res){
        $sql1="SELECT id FROM llx_dossier_maladie_mutuelle ORDER BY id DESC LIMIT 1";
        $res1 = $db->query($sql1);
        $result = $res1->fetch_assoc();
        $id = $result['id'];   
        header("Location: ".$_SERVER['PHP_SELF'].'?id='.$id.'&action=view');
    }else{
        header("Location: ".$_SERVER['PHP_SELF'].'?action=create');
    }


}elseif ($action =='update'){
    $sql = "update `llx_dossier_maladie_mutuelle` set somme = $somme , userid = $userId,date_de_depot = '$date_de_depot' WHERE id=$id";
    $res = $db->query($sql);
    header("Location: ".$_SERVER['PHP_SELF'].'?id='.$id.'&action=view');

}else if($action == 'validate'){
    $date = date('d-m-y h:i:s');
    $sql = "update `llx_dossier_maladie_mutuelle` set valide = 1 , date_validation = '$date'  WHERE id=$id";
    $res = $db->query($sql);
    header("Location: ".$_SERVER['PHP_SELF'].'?id='.$id.'&action=view');
 
}else if($action == 'solder'){
    $date = date('d-m-y h:i:s');
    $sql = "update `llx_dossier_maladie_mutuelle` set solde = 1 , date_solde = '$date'  WHERE id=$id";
    $res = $db->query($sql);
    header("Location: ".$_SERVER['PHP_SELF'].'?id='.$id.'&action=view');
}else if($action == 'delete'){
    $sql = "update `llx_dossier_maladie_mutuelle` set deleted = 1 WHERE id=$id";
    $res = $db->query($sql);
    header("Location: /RH/dossierMutuelle/list.php");
}



// $text = "List des dossiers cnss";

llxHeader("", "$text");

print_barre_liste($text, $page, $_SERVER["PHP_SELF"], $param, $sortfield, $sortorder, '', $num, $nbtotalofrecords, 'setup', 0, $morehtmlright.' '.$newcardbutton, '', $limit, 0, 0, 1);

print '<form id="cnssForm" action="' . $_SERVER["PHP_SELF"].'?id='.$id.'" method="POST">';
	print '<input type="hidden" name="token" value="' . newToken() . '">';


if ($action == 'view'){
    print '<div class="tabBar tabBarWithBottom">';
    if ($cnss["valide"] == 0 && $cnss["solde"] == 0){
        print '<div class="statusref"><span class="badge  badge-status0 badge-status" title="Brouillon (à valider)">Brouillon (à valider)</span></div>';
    }else if ($cnss["valide"] == 1 && $cnss["solde"] == 0){
        print '<div class="statusref"><span class="badge  badge-status7 badge-status" title="Validé (à Solder)">Validé (à solder)</span></div>';
    }else if ($cnss["valide"] == 1 && $cnss["solde"] == 1){
        print '<div class="statusref"><span class="badge  badge-status4 badge-status" title="Soldé">Soldé</span></div>';
    }


    print '<table class="border centpercent">';
		print '<tbody>';
        print '<tr>
            <td>Nom Complet</td>
            <td>'.$cnss["lastName"].' '. $cnss["firstName"].'</td>
		</tr>';

        print '<tr>
            <td>Date de dépôt</td>
            <td>'.$cnss["date_de_depot"].'</td>
        </tr>';
        print '<tr>
            <td>Validé</td>';
            if($cnss["valide"] == 1){
                $valide = '<td>Oui Au '.$cnss["date_validation"].'</td>';
            }else{
                $valide = "<td>Non</td>";
            }
        print "$valide";    

        print '
            <tr>
            <td>Soldé</td>';
            if($cnss["solde"] == 1){
                $solde = '<td>Oui Au '.$cnss["date_solde"].'</td>';
            }else{
                $solde = "<td>Non</td>";
            }
        print "$solde"; 
        print '
        <tr>
            <td>Somme</td>
            <td>'.$cnss["somme"].'</td>
        </tr>';
        print '</tbody>';
		print '</table>';
		print '</div>';

}else if ($action == 'edit'){
    print '<input type="hidden" name="action" value="update">';
    print '<table class="border centpercent">';
		print '<tbody>';

		print '<tr>';
		print '<td class="titlefield fieldrequired">'.$langs->trans("User").'</td>';
		print '<td>';
        print img_picto('', 'user').$form->select_dolusers($cnss['userid'], 'user', 0, '', 0, '', '', '0,'.$conf->entity, 0, 0, $morefilter, 0, '', 'minwidth200 maxwidth500');
		print '</td>';
		print '</tr>';
        print "
            <tr>
                <td>Somme</td>
                <td><input required type='number' step='.1' name='somme' value='".$cnss['somme']."'/></td>
            </tr>";
        print "
            <tr>
                <td>Date de dépôt</td>
                <td><input required  name='date_de_depot' type='date' value='".$cnss["date_de_depot"]."'/></td>
            </tr>";
        print '</tbody></table>';

}else if ($action == 'create'){
	print '<input type="hidden" name="action" value="add">';
    print '<table class="border centpercent">';
		print '<tbody>';

		print '<tr>';
		print '<td class="titlefield fieldrequired">'.$langs->trans("User").'</td>';
		print '<td>';
        print img_picto('', 'user').$form->select_dolusers('' , 'user', 0, '', 0, '', '', '0,'.$conf->entity, 0, 0, $morefilter, 0, '', 'minwidth200 maxwidth500');
		print '</td>';
		print '</tr>';
        print "
        <tr>
            <td>Somme</td>
            <td><input required step='.01' name='somme' type='number'/></td>
		</tr>";
        print "
        <tr>
            <td>Date de dépôt</td>
            <td><input required  name='date_de_depot' type='date'/></td>
		</tr>";
        print '</tbody></table>';
}


print "<div style='margin-top: 10px;'>";
if ($action == 'view'){
    if ($cnss["valide"] == 0)
    {        
        print "
                <input type='hidden' name='action' value='edit'>
                <button type='submit' name='validate' class='button-custom mdf'>Modifier</button>
                <button type='button' name='validate' onclick='showConfirmation(".'"Veuillez vraiment valider ce dossier", "Valider"'.")' class='button-custom'>Valider</button>
                <button type='button' name='delete' onclick='showConfirmation(".'"Veuillez vraiment supprimer ce dossier", "Supprimer"'.")' class='button-custom dlt'>Supprimer</button>";
         
    }
    else if ($cnss["solde"] == 0)
    {
        print "
            <button type='button' onclick='showConfirmation(".'"Veuillez vraiment solder ce dossier", "Solder"'.")' name='solder' class='button-custom'>Solder</button>
        ";
    }
    print "</div>";
}else if ($action == 'edit' || $action == 'create'){
    print "
    <button type='submit' class='button-custom'>Enregistrer</button>
    <button type='button' onclick='window.location.href=".'"/RH/dossierMutuelle/list.php"'. "'class='button-custom cnl'>Annuler</button>
    </div>
    </form>";
}


print '<div id="overflow">';
print "
    <div id='confirmationModal'>
        <input type='hidden' id='deletedRubId'/>
        <div class='confirmation-title'>
            <h2>Voulez-vous supprimer cette rubrique</h2>
        </div>
        <div class='confirmation-footer'>
            <button type='button' class='confirm'>Supprimer</button>
            <button type='button' class='cancel'>Annuler</button>
        </div>
    </div>';
 <style>
div.tabBarWithBottom tr:nth-child(odd) {
    background: #e9e9e9 !important;
}
 #overflow{
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: #2e2e2ebd;
    overflow: unset;
}
#confirmationModal{
    padding: 18px;
    border-radius: 8px;
    height: 120px;
    background-color: #e7e7e7;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none;
    flex-direction: column;
    justify-content: space-between;
}
#confirmationModal button{
    border: 0;
    border-radius: 0.25em;
    background: initial;
    color: #fff;
    font-size: 16px;
    padding: 9px;
    cursor: pointer;
}
#confirmationModal button.confirm{
    background-color: #548734;
}
#confirmationModal button.cancel{
    background-color: #dc3741;
}
#confirmationModal .confirmation-footer{
    display: flex;
    justify-content: space-evenly;
}
    .button-custom{
        display: inline-block;
        padding: 7px 14px;
        width: auto;
        background: none;
        overflow: visible;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        transition: all .1s ease-out;
        font-size: 14px;
        font-weight: 600;
        color: inherit;
        /* line-height: 40px; */
        letter-spacing: 1px;
        text-decoration: none;
        text-transform: uppercase;
        white-space: nowrap;
        border-radius: 4px;
        border-style: solid;
        border-width: 1px;
        background-color: #4caf50;
        color: #fff;
        border-color: #4caf50;
        cursor: pointer;
    
    }
    .button-custom;hover{
        opacity: 0.85;
        cursor: pointer;
        transform: scale(1.025);
    }
    .dlt{
        background-color: #f44336;
        color: #fff;
        border-color: #f44336;
    }
    .mdf{
        background-color: #ffb300;
        color: #fff;
        border-color: #ffb300;
    }
    .cnl{
        background-color: #af4c4c;
        border-color: #af4c4c;
    }

 </style>";
 ?>
 <script>
 function showConfirmation(message, confirm) {
    $("html, body").css({
        overflow: "hidden",
    });
    $("#overflow").css("display", "block");
    $("#confirmationModal").css("display", "flex");
    $("#confirmationModal .confirmation-title").html("<h2>"+message+"</h2>");
    $("#confirmationModal .confirm").html(confirm);
}
$("#confirmationModal").on('click', ".confirm", function(event) {
    if ($(this).text() == 'Valider'){
        $("#cnssForm").append('<input type="hidden" name="action" value="validate" />');
    }else if ($(this).text() == 'Solder'){
            $("#cnssForm").append('<input type="hidden" name="action" value="solder" />'); 
    }else if ($(this).text() == 'Modifier'){
        $("#cnssForm").append('<input type="hidden" name="action" value="edit" />'); 
    }else if($(this).text() == 'Supprimer'){
        $("#cnssForm").append('<input type="hidden" name="action" value="delete" />'); 
    }
    $("#cnssForm").submit();
});
// cancel supprission
$("#confirmationModal").on('click', ".cancel", function() {
        $("#confirmationModal").css("display", "none");
        $("#overflow").css("display", "none");
        $('html, body').css({
            overflow: 'auto',
        });
    });
 </script> 