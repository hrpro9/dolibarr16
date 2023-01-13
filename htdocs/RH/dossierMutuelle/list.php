<?php

require '../../main.inc.php';
require_once '../../vendor/autoload.php';



if (!$user->rights->salaries->read) {
	accessforbidden("you don't have right for this page");
}


$action = GETPOST('action', 'alpha');
$type = GETPOST('type', 'alpha');
$all = GETPOST('all', 'alpha');



$mydate = getdate(date("U"));
$month = (GETPOST('month') != '') ? GETPOST('month') : $mydate['mon'];
$year = (GETPOST('year') != '') ? GETPOST('year') : $mydate['year'];
$day = $mydate['mday'];
if (strlen($month) == 1) {
	$month = '0' . $month;
}

if ($action == 'filter') {
	$dateFiltre = GETPOST('date');
	$year = explode('-', $dateFiltre)[0];
	$month = explode('-', $dateFiltre)[1];
}

if ($all){
    $dateFilter = " 1";
}else{
    $dateFilter = " MONTH(c.date_de_depot) = $month and YEAR(c.date_de_depot) = $year";
}
$where = ' where deleted = 0 and';
if($type == 'br'){
    $where .= "  c.valide = 0 and c.solde = 0 and".$dateFilter;
    
}else if ($type == 'valide'){
    $where .= "  c.valide = 1 and c.solde = 0 and".$dateFilter;
    
}else if ($type == 'solde'){
    $where .= "  c.valide = 1 and c.solde = 1 and".$dateFilter;
}else{
    $where .= $dateFilter;
}
$sort = " order by c.date_de_depot DESC";


$cnss = array();
$sql = "SELECT c.id, ef.matricule, c.userid, u.firstName, u.lastName, c.somme, c.date_de_depot, DATE(c.date_creation) as date_creation, c.valide, DATE(c.date_validation) as date_validation, c.solde, DATE(c.date_solde) as date_solde FROM llx_dossier_maladie_mutuelle as c LEFT JOIN llx_user as u on u.rowid = c.userid LEFT JOIN llx_user_extrafields as ef ON u.rowid = ef.fk_object".$where.$sort;
$res = $db->query($sql);
if ($res->num_rows) {
    while ($row = $res->fetch_assoc()){
        $values = array();
        foreach ($row as $key => $value) {
            $values[$key] = $value;
        }
        array_push($cnss, $values);
    }
}




$text = "List des dossiers mutuelle";

llxHeader("", "$text");

print_barre_liste($text, $page, $_SERVER["PHP_SELF"], $param, $sortfield, $sortorder, '', $num, $nbtotalofrecords, 'setup', 0, $morehtmlright.' '.$newcardbutton, '', $limit, 0, 0, 1);


datefilter();



print '
<section class="tab-con">
<h1>'.$text.'</h1>

  <div class="tbl-header">
    <table cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
        <th>Date de dépôt</th>
        <th>matricule</th>
        <th>Nom Complet</th>
        <th>Validé</th>
        <th>Date validation</th>
        <th>soldé</th>
        <th>Date Soldé</th>
        <th>Somme</th>
        </tr>
      </thead>
    </table>
  </div>
  <div class="tbl-content">
    <table cellpadding="0" cellspacing="0" border="0">
    <tbody>
    ';

        foreach ($cnss as $dos) {
            print '
            <tr>
                <td><a href="/RH/dossierMutuelle/card.php?action=view&id='.$dos["id"].'">'.$dos["date_de_depot"].'</a></td>
                <td>'.$dos["matricule"].'</td>
                
                <td><a href="/RH/Users/card.php?id='.$dos["userid"].'">'.$dos["lastName"].' '.$dos["firstName"].'</a></td>
                <td>'.$dos["valide"].'</td>
                <td>'. (empty($dos["date_validation"])? '_' : $dos["date_validation"]).'</td>
                <td>'.$dos["solde"].'</td>
                <td>'. (empty($dos["date_solde"])? '_' : $dos["date_solde"]).'</td>
                <td>'.$dos["somme"].' DH</td>
            </tr>
            ';
        }
 print '       

        
 </tbody>
 </table>
</div>
</section>';


 print "
 <style>
     section.tab-con  {
        background: -webkit-linear-gradient(left, #25c481, #25b7c4);
        background: linear-gradient(to right, #25c481, #25b7c4);
        font-family: 'Roboto', sans-serif;
     }
     section.tab-con  a{
         color:#fff;
     }
     section.tab-con th:nth-child(even),section.tab-con td:nth-child(even) {
        background: rgba(0, 0, 0, .08);
   }
    section.tab-con tbody tr:nth-child(odd) {
        background: rgba(0, 0, 0, .08);
   }
th, 
     h1{
     font-size: 30px;
     color: #fff;
     text-transform: uppercase;
     font-weight: 300;
     text-align: center;
     margin-bottom: 15px;
     }
     table{
     width:100%;
     table-layout: fixed;
     }
     .tbl-header{
     background-color: rgba(255,255,255,0.3);
     }
     .tbl-content{
        max-height: 686px;
        overflow-x:auto;
        margin-top: 0px;
        border: 1px solid rgba(255,255,255,0.3);
     }
     th{
     padding: 20px 15px;
     text-align: left;
     font-weight: 600;
     font-size: 14px;
     color: #fff;
     text-transform: uppercase;
     }
     td{
     padding: 15px;
     text-align: left;
     vertical-align:middle;
     font-weight: 500;
     font-size: 14px;
     color: #fff;
     border-bottom: solid 1px rgba(255,255,255,0.1);
     }
     thead th{
        color:#433f3f;
    }
 
 
     @import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);
 
 
     
     /* for custom scrollbar for webkit browser*/
 
     ::-webkit-scrollbar {
         width: 6px;
     } 
     ::-webkit-scrollbar-track {
         -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
     } 
     ::-webkit-scrollbar-thumb {
         -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
     }

     
     .date-container .inp-wrapper {
        align-items: center;
		display: flex;
		gap: 1.2em;
		justify-content: center;
	}
	.date-container label {
		color: #0f1e32;
		display: block;
		font-weight: 600;
	}
	.date-container input[type='date'] {
		font-size: 14px;
		padding: 4px;
		color: #242831;
		border: 1px solid rgb(7, 108, 147);
		outline: none;
    	border-radius: 0.2em;
	}
	.date-container ::-webkit-calendar-picker-indicator {
		background-color: #7eceee;
		padding: 0.2em;
		cursor: pointer;
		border-radius: 0.1em;
	}
		
	@media only screen and (min-width: 977px) {
		div.div-table-responsive {
			width: calc(100vw - 285px) !important;
			overflow-x: scroll !important;
		}
	}
	.dropdown ul{
		position: absolute;
		top: 11px;
		left: 1px;
		width: 175px;
	}
 
 </style>
 <script>
	$(document).ready(function(){
		$('#date').val('" . $year . "-" . $month . "');	
	});
</script>";
 

//filter by date
function datefilter()
{
    global $type, $all;
    $checked = $all == 1 ? 'checked': '';
	print '<div class="center">';
	print '<form id="frmfilter" action="' . $_SERVER["PHP_SELF"] . '?type='.$type.'" method="POST">';
	print '<input type="hidden" name="token" value="' . newToken() . '">';
	print '<input type="hidden" name="action" value="filter">';

	// Show navigation bar
	$nav = '<div class="date-container">
				<div class="inp-wrapper">
					<div class="date-wrapper">
						<input type="month" id="date" name="date">
					</div>
                    <span>ALL</span> <input type="checkbox" name="all" id="all" '.$checked.' value="1">
					<button style="cursor:pointer;" type="submit" name="button_search_x" value="x" class="bordertransp"><span class="fa fa-search"></span></button>
				</div>
			</div>';
	print $nav;

	print '</form>';
	print '</div>';
}

?>