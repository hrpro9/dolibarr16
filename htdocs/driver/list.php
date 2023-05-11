<?php

require '../main.inc.php';

$action = (GETPOST('action', 'alpha') ? GETPOST('action', 'alpha') : 'view');
$idDriverEdited = GETPOST('id_driver', 'int');




if($action == 'delete'){
	$error = 0;	
	$id_driver = GETPOST('id', 'int');
	$db->begin();
	if (!$error) {   
		
		$sql = "update llx_driver set deleted = 1, fk_user_delete = $user->id where id = $id_driver";
		$result = $db->query($sql);
		if ($result){
			$db->commit();
			$action = '';
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$db->rollback();
			$action = 'view';
			setEventMessages("Veuillez réessayer chauffeur n'est pas Supprimer", null, 'errors');
		}

	}
}else if ($action == 'add') {
	$error = 0;	
	$firstname 	= GETPOST('firstname', 'text');
	$lastname 	= GETPOST('lastname', 'text');
	$cin 	= GETPOST('cin', 'text');

	if(GETPOSTISSET('cancelAdd')) {
		header("Location: ".$_SERVER["PHP_SELF"]);
		exit();
	}
	
	if (!GETPOST('firstname')) {
		setEventMessages("Le prenom est obligatoire", null, 'errors');
		$action = "create";
		$error++;
	}
	if (!GETPOST('lastname')) {
		setEventMessages("Le nom est obligatoire", null, 'errors');
		$action = "create";
		$error++;
	}
	if (!GETPOST('cin')) {
		setEventMessages("C.I.N est obligatoire", null, 'errors');
		$action = "create";
		$error++;
	}

	$db->begin();
	if (!$error) {	
		$sql = "insert into llx_driver (firstname,lastname, cin, created_at, fk_user_author) VALUES('$firstname', '$lastname', '$cin',  NOW(),  $user->id)";
		$result = $db->query($sql);
		if ($result){
			$db->commit();
			$action = '';
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$db->rollback();
			$action = 'create';
			setEventMessages("Veuillez réessayer chauffeur n'est pas creé", null, 'errors');
		}

	}
	
}else if($action == 'update'){
	$error = 0;	
	$firstname 	= GETPOST('firstname', 'text');
	$lastname 	= GETPOST('lastname', 'text');
	$cin 	= GETPOST('cin', 'text');
	$id 	= GETPOST('id', 'int');
	
	if(GETPOSTISSET('cancelEdit')) {
		header("Location: ".$_SERVER["PHP_SELF"]."?id=".$id);
		exit();
	}

	if (!GETPOST('firstname')) {
		setEventMessages("Le prenom est obligatoire", null, 'errors');
		$action = "create";
		$error++;
	}
	if (!GETPOST('lastname')) {
		setEventMessages("Le nom est obligatoire", null, 'errors');
		$action = "create";
		$error++;
	}
	if (!GETPOST('cin')) {
		setEventMessages("C.I.N est obligatoire", null, 'errors');
		$action = "create";
		$error++;
	}
	$db->begin();
	if (!$error) {
		
		$sql = "UPDATE llx_driver SET cin = '$cin', firstname = '$firstname', lastname = '$lastname' WHERE id = '$id'";
		$result = $db->query($sql);
		if ($result){
			$db->commit();
			$action = '';
			header("Location: ".$_SERVER['PHP_SELF']."?id=".$id);
		}else{
			$db->rollback();
			$action = '';
			setEventMessages("Veuillez réessayer chauffeur n'est pas modifié", null, 'errors');
		}

	}
}


llxHeader('', "Nos chauffeurs", "");


$drivers = array();
$sql = "select * from llx_driver where deleted = 0";
$res = $db->query($sql);
if ($res->num_rows) {
    while ($row = $res->fetch_assoc()) {
        array_push($drivers, [$row['id'], $row['firstname'], $row['lastname'], $row['cin']]);
    }
}


print "<h2>Nos chauffeurs</h2>";
print '<div class="fichecenter">';

if($action == "view"){
    print '<form action="' . $_SERVER['PHP_SELF'] . '?action=create" method="POST" style="margin-top: 20px;float: right;">' . "\n";
    print '<input type="hidden" name="action" value="create">';
    print '<button type="submit" class="btnAdd"><i class="fas fa-plus"></i></button>';
    print '</form>';

}

print '<table class="border allwidth">';
print "<tr>
        <th>C.I.N</th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Action</th>
    </tr>";
// Fiche en mode edition
if ($action == 'create') {

    print '<form action="' . $_SERVER['PHP_SELF'] .'" method="POST" style="margin-top: 74px;" name="formprod">' . "\n";
    print '<input type="hidden" name="token" value="' . newToken() . '">';
    print '<input type="hidden" name="action" value="add">';


    print '<tr>
            <td><input name="cin" type="text" required></td>
            <td><input name="firstname" type="text" required></td>
            <td><input name="lastname" type="text" required></td>';
    print '<td>
            <button type="submit" class="btnAdd add-green"><i class="fas fa-plus"></i></button>
            <button type="button" class="btnCancel" name="cancelAdd" onclick="cancel()"><i class="fas fa-ban"></i></button>
            </td>';
    print '</tr>';
    print '</form>';
}


foreach ($drivers as $key => $value) {

    print '<tr>';
    if($idDriverEdited == $value[0]){
        
        
        // Main official, simple, and not duplicated code
        print '<form id="frmEdit" action="' . $_SERVER['PHP_SELF'] .'" method="POST" style="margin-top: 74px;" name="formprod">';
        print '<input type="hidden" name="token" value="' . newToken() . '">';
        print '<input type="hidden" name="id" value="' . $value[0] . '">';
        print '<input type="hidden" id="action" name="action" value="update">';


        print '
            <td><input name="cin" type="text" value="'.$value[3].'" required></td>
            <td><input name="firstname" type="text" value="'.$value[1].'" required></td>
            <td><input name="lastname" type="text" value="'.$value[2].'" required></td>';
        print '
            <td>
                <button type="submit" class="btnEdit" ><i class="fas fa-edit"></i></button>
                <button type="button" class="btnCancel" name="cancelEdit" onclick="cancel()"><i class="fas fa-ban"></i></button>
            </td>
            </form>';
    }else{
        print '<form id="frmAction'.$value[0].'" action="' . $_SERVER['PHP_SELF'] . '?id=' . $value[0] .'" method="POST" style="margin-top: 74px;" name="formprod">';
        print '<input type="hidden" name="token" value="' . newToken() . '">';
        print '<input type="hidden" name="id_driver" value="' . $value[0] . '">';
        print '<input id="action'.$value[0].'" type="hidden" name="action">';
        print '<td>'.$value[3].'</td>';
        print '<td>'.$value[1].'</td>';
        print '<td>'.$value[2].'</td>';
        print '<td><button type="button" class="btnDelete" onclick="deleteDriver(\''.$value[0].'\', \''.$value[1]. ' ' .$value[2].'\')"><i class="fas fa-trash"></i></button>
        <button id="showedit" type="button" class="btnEdit" value="Modifier" onclick="editDriver(\''.$value[0].'\')"><i class="fa fa-pencil"></i></button></td></form>';
    }
    print '</tr>';
}
print '</div>';
print '</table>';


print '<div id="overflow"></div>
<div id="deleteConfirmation">
    <input type="hidden" id="deletedDriver"/>
	<div class="confirmation-title">
		<h2></h2>
	</div>
	<div class="confirmation-footer">
		<button class="confirm">Supprimer</button>
		<button class="cancel">Cancel</button>
	</div>
</div>';







print "
	<style>
	tr{
		text-align: center;
	}
	tr:nth-of-type(even) {
		background: #eeeeee;
	}
	tr:nth-of-type(odd) {
		background: #f7f7f7;
	}
	  
	th {
		background-color: #708090;
		color: white;
		font-weight: bold;
		padding: 0.5em 0.375em;
		text-align: center;
		border: 1px solid #aaa;
	}
	td{
		border-right: 1px solid #d5cccc7d;
		border-bottom: none;
		padding-top: 0;
		padding-top: 0px !important;
		border-bottom: none !important;
		height: auto;
	}



	.btnDelete{
		color: #fff;
		padding: 4px 6px;
		cursor: pointer;
		background-color: transparent;
		border: none;
		font-size: 15px;
	}
	.btnDelete i{
		color: #bd686d !important;
	}
	.btnCancel{
		color: #fff;
		padding: 4px 6px;
		cursor: pointer;
		background-color: transparent;
		border: none;
		font-size: 15px;
	}
	.btnCancel i{
		color: #bd686d !important;
	}
	.btnAdd{
		color: #fff;
		padding: 4px 6px;
		cursor: pointer;
		background-color: transparent;
		border: none;
		font-size: 28px;
	}
	.btnAdd i{
		color: #6b8190 !important;
		font-size: 21px;
	}
	.btnAdd.add-green i{
		color: #7ed972 !important;
		font-size: 18px;
	}
	.btnEdit{
		color: #53b360;
		padding: 4px 6px;
		cursor: pointer;
		background-color: transparent;
		border: none;
		font-size: 15px;
	}
	.btnEdit i{
		color: #7ed972;
	}
	.btnGenerate{
		color: #53b360;
		padding: 4px 6px;
		cursor: pointer;
		background-color: transparent;
		border: none;
		font-size: 15px;
	}
	.btnGenerate i{
		color: #d5b134;
	}




	#deleteConfirmation{
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
	#deleteConfirmation button{
		border: 0;
		border-radius: 0.25em;
		background: initial;
		color: #fff;
		font-size: 16px;
		padding: 9px;
		cursor: pointer;
	}
	#deleteConfirmation button.confirm{
		background-color: #548734;
	}
	#deleteConfirmation button.cancel{
		background-color: #dc3741;
	}
	#deleteConfirmation .confirmation-footer{
		display: flex;
		justify-content: space-evenly;
	}
	#overflow {
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
		background-color: #2e2e2ebd;
		overflow: unset;
	}


	</style>";


?>
<script>
    function deleteDriver(id, nom) {
        $('html, body').css({
            overflow: 'hidden',
        });
        $("#overflow").css("display", "block");
        $("#deleteConfirmation").css("display", "flex");
        $("#deleteConfirmation .confirmation-title").html("<h2 style='font-size: 18px;'>Voulez-vous supprimer chauffeur'" + nom + "'</h2>");
        $("#deletedDriver").val(id);
    }
    // cancel supprission
    $("#deleteConfirmation").on('click', ".cancel", function() {
        $("#deleteConfirmation").css("display", "none");
        $("#overflow").css("display", "none");
        $('html, body').css({
            overflow: 'auto',
        });
    });
    
    // confirm supprission
    $("#deleteConfirmation").on('click', ".confirm", function() {
        let id = $("#deletedDriver").val();

        $("#action"+id).val("delete");
        $("#frmAction"+id).submit();
    });


    // edit code bare
    function editDriver(id) {
        $("#action"+id).val("edit");

        $("#frmAction"+id).submit();

    };
    // cancel edit code bare
	function cancel() {
		window.location.href = '/driver/list.php';
	}



</script>
