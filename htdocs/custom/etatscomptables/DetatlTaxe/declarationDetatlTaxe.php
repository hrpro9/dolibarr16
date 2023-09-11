<?php
// Load Dolibarr environment
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
llxHeader("", "");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    for ($i = 0; $i <= 48; $i++) {
        ${'detatTaxe' . $i} = $_POST['detatTaxe' . $i];
    }
    
}

$object = new User($db);
$id=$user->id;
function GenerateDocuments()
{
	global $day, $month, $year, $start, $prev_year;
	print '<form id="frmgen" name="builddoc" method="post">';
	print '<input type="hidden" name="token" value="' . newToken() . '">';
	print '<input type="hidden" name="action" value="builddoc">';
	print '<input type="hidden" name="model" value="Detailtaxe">';
	print '<div class="right"  style="margin-bottom: 100px; margin-right: 20%;">
	<input type="submit" id="btngen" class="button" name="save" value="génerer">';
	print '</form>';
}
function ShowDocuments()
{
	global $db, $object, $conf, $month, $prev_year, $societe, $showAll, $prev_month, $prev_year, $start;
	print '<div class="fichecenter"><divclass="fichehalfleft">';
	$formfile = new FormFile($db);
	$subdir ='';
	$filedir = DOL_DATA_ROOT . '/billanLaisse/Detailtaxe/'; 
	$urlsource = $_SERVER['PHP_SELF'] . '';
	$genallowed = 0;
	$delallowed = 1;
	$modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

	if ($societe !== null && isset($societe->default_lang)) {
		print $formfile->showdocuments('Detailtaxe', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
	} else {
		print $formfile->showdocuments('Detailtaxe', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
	}

}
// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/Detailtaxe/';
$permissiontoadd = 1;
$donotredirect = 1;

include DOL_DOCUMENT_ROOT . '/core/actions_builddoc.inc.php';

?>





<!DOCTYPE html>

<html>
<head>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title></title>
	<meta name="generator" content="LibreOffice 7.4.2.3 (Linux)"/>
	<meta name="author" content="Microsoft Office User"/>
	<meta name="created" content="2023-08-09T15:38:35"/>
	<meta name="changedby" content="Microsoft Office User"/>
	<meta name="changed" content="2023-08-09T15:38:56"/>
	<meta name="AppVersion" content="16.0300"/>
	
</head>

<body>
<center>
<form method="POST" action="confirmDetatlTaxe.php">
<table align="center" cellspacing="0" border="0">
	<colgroup width="280"></colgroup>
	<colgroup span="5" width="124"></colgroup>
    <center>
        <input type="date" name="detatTaxe48"  id="detatTaxe48" value="<?php if(isset($detatTaxe48)){ echo $detatTaxe48;} ?>"  placeholder ="Année" required style="margin-top: 18px;font-size:95%; background: #ededed; font-weight:bolder; padding: 8px 15px 8px 15px; border: block; ">
        <input type="hidden" name="check"  value="true">
        </center>
        <tr>
		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=5 height="26" align="center" valign=bottom><b><font face="Calibri" size=4>DETAIL DE LA TAXE SUR LA VALEUR AJOUTEE</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td height="31" align="left" valign=middle><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=middle><b><font face="Calibri"><br></font></b></td>
		<td align="right" valign=middle><b><font face="Calibri"></font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 height="73" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Nature</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Solde au début de l'exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Opérations comptables de l'exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Déclarations TVA de l'exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Solde fin d'exercice</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font face="Calibri">1</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdval="2" sdnum="1033;"><b><i><font face="Calibri">2</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdval="3" sdnum="1033;"><b><i><font face="Calibri">3</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font face="Calibri">(1 + 2 - 3 = 4)</font></i></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="33" align="left" valign=middle><b><font face="Calibri">A. T.V.A. Facturée</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><b><font face="Calibri">
        <input min="0" type="text" required style="width: 130px;" name="detatTaxeValeur1" id="detatTaxeValeur1" value="<?php if (isset($detatTaxeValeur1)) { echo $detatTaxeValeur1; } ?>">
        <br></font></b></td>
		<td align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><b><font face="Calibri">
        <input min="0" type="text" required style="width: 130px;" name="detatTaxeValeur2" id="detatTaxeValeur2" value="<?php if (isset($detatTaxeValeur2)) { echo $detatTaxeValeur2; } ?>">
        <br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"></font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow" color="#FFFFFF">GrasGauche</font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="33" align="left" valign=middle><b><font face="Calibri">B. T.V.A. Récuperable</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">
        </font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"></font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow" color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="33" align="left" valign=middle><font face="Calibri">- sur charges</font></td> 
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"></font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"></font></td>
		<td align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">
        <input min="0" type="text" required style="width: 130px;" name="detatTaxeValeur3" id="detatTaxeValeur3" value="<?php if (isset($detatTaxeValeur3)) { echo $detatTaxeValeur3; } ?>">
        <br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="33" align="left" valign=middle><font face="Calibri">- sur immobilisations</font></td> 
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"></font></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">
        <input min="0" type="text" required style="width: 130px;" name="detatTaxeValeur4" id="detatTaxeValeur4" value="<?php if (isset($detatTaxeValeur4)) { echo $detatTaxeValeur4; } ?>">
        <br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="33" align="left" valign=middle><b><font face="Calibri">C. T.V.A. dûe ou crédit de T.V.A = (A - B)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"></font></b></td> 
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"></font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow" color="#FFFFFF">GrasGauche</font></td>
	</tr>
	<tr>
		<td height="17" align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td height="17" align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=5 height="26" align="center" valign=bottom><b><font face="Calibri" size=4>DETAIL DE LA TAXE SUR LA VALEUR AJOUTEE</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td height="31" align="left" valign=middle><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=middle><b><font face="Calibri"><br></font></b></td>
		<td align="right" valign=middle><b><font face="Calibri"></font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow"><br></font></td>
	</tr>

	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 height="25" align="center" valign=bottom bgcolor="#FBE5D6"><b><i><font face="Calibri" size=>TVA - Déclarations de l'exercice<br>(Ce tableau ne fait pas partie de la liasse. Il est destiné à vous aider à remplir ce tableau)</font></i></b></td>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="113" align="center" valign=middle bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>Mois</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>TVA Facturée</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>TVA Récupérable sur charges</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>TVA Récupérable sur immobilisations</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>Crédit M-1</font></i></b></td>
		
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Janvier</font></i></b></td>
        <?php
            for ($i = 0; $i <= 3; $i++) {

            echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><input min="0" type="text" required style="width: 130px;" name="detatTaxe' . $i . '" id="detatTaxe' . $i . '" value="';
            if (isset(${"detatTaxe" . $i})) {
                echo ${"detatTaxe" . $i};
            }
            echo '" /></td>' . "\n"; 
            }
        ?>
		
	</tr>
	<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Février</font></i></b></td>
    <?php
            for ($i = 4; $i <=7; $i++) {

                echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><input min="0" type="text" required style="width: 130px;" name="detatTaxe' . $i . '" id="detatTaxe' . $i . '" value="';
                if (isset(${"detatTaxe" . $i})) {
                    echo ${"detatTaxe" . $i};
                }
                echo '" /></td>' . "\n";  
            }
        ?>
	</tr>
	<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Mars</font></i></b></td>
	<?php
            for ($i =8; $i <=11; $i++) {
                echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><input min="0" type="text" required style="width: 130px;" name="detatTaxe' . $i . '" id="detatTaxe' . $i . '" value="';
                if (isset(${"detatTaxe" . $i})) {
                    echo ${"detatTaxe" . $i};
                }
                echo '" /></td>' . "\n";  
            }
        ?>
	</tr>
	<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Avril</font></i></b></td>
	<?php
            for ($i =12; $i <=15; $i++) {
                echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><input min="0" type="text" required style="width: 130px;" name="detatTaxe' . $i . '" id="detatTaxe' . $i . '" value="';
                if (isset(${"detatTaxe" . $i})) {
                    echo ${"detatTaxe" . $i};
                }
                echo '" /></td>' . "\n";  
            }
        ?>	
	</tr>
	<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Mai</font></i></b></td>
	<?php
            for ($i =16; $i <=19; $i++) {
                echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><input min="0" type="text" required style="width: 130px;" name="detatTaxe' . $i . '" id="detatTaxe' . $i . '" value="';
                if (isset(${"detatTaxe" . $i})) {
                    echo ${"detatTaxe" . $i};
                }
                echo '" /></td>' . "\n";  
            }
        ?>
	</tr>
	<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Juin</font></i></b></td>
	<?php
            for ($i =20; $i <=23; $i++) {
                echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><input min="0" type="text" required style="width: 130px;" name="detatTaxe' . $i . '" id="detatTaxe' . $i . '" value="';
                if (isset(${"detatTaxe" . $i})) {
                    echo ${"detatTaxe" . $i};
                }
                echo '" /></td>' . "\n";  
            }
        ?>
	</tr>
	<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Juillet</font></i></b></td>
    <?php
            for ($i =24; $i <=27; $i++) {
                echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><input min="0" type="text" required style="width: 130px;" name="detatTaxe' . $i . '" id="detatTaxe' . $i . '" value="';
                if (isset(${"detatTaxe" . $i})) {
                    echo ${"detatTaxe" . $i};
                }
                echo '" /></td>' . "\n";  
            }
        ?>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Août</font></i></b></td>
        <?php
            for ($i =28; $i <=31; $i++) {
                echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><input min="0" type="text" required style="width: 130px;" name="detatTaxe' . $i . '" id="detatTaxe' . $i . '" value="';
                if (isset(${"detatTaxe" . $i})) {
                    echo ${"detatTaxe" . $i};
                }
                echo '" /></td>' . "\n";  
            }
        ?>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Septembre</font></i></b></td>
        <?php
            for ($i =32; $i <=35; $i++) {
                echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><input min="0" type="text" required style="width: 130px;" name="detatTaxe' . $i . '" id="detatTaxe' . $i . '" value="';
                if (isset(${"detatTaxe" . $i})) {
                    echo ${"detatTaxe" . $i};
                }
                echo '" /></td>' . "\n";  
            }
        ?>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Octobre</font></i></b></td>
        <?php
            for ($i =36; $i <=39; $i++) {
                echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><input min="0" type="text" required style="width: 130px;" name="detatTaxe' . $i . '" id="detatTaxe' . $i . '" value="';
                if (isset(${"detatTaxe" . $i})) {
                    echo ${"detatTaxe" . $i};
                }
                echo '" /></td>' . "\n";  
            }
        ?>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Novembre</font></i></b></td>
        <?php
            for ($i =40; $i <=43; $i++) {
                echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><input min="0" type="text" required style="width: 130px;" name="detatTaxe' . $i . '" id="detatTaxe' . $i . '" value="';
                if (isset(${"detatTaxe" . $i})) {
                    echo ${"detatTaxe" . $i};
                }
                echo '" /></td>' . "\n";  
            }
        ?>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Décembre</font></i></b></td>
        <?php
            for ($i =44; $i <=47; $i++) {
                echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><input min="0" type="text" required style="width: 130px;" name="detatTaxe' . $i . '" id="detatTaxe' . $i . '" value="';
                if (isset(${"detatTaxe" . $i})) {
                    echo ${"detatTaxe" . $i};
                }
                echo '" /></td>' . "\n";  
            }
        ?>
	</tr>
	<!-- <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="22" align="center" valign=top bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>Totaux</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#FBE5D6" sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri" size=3>0.00</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#FBE5D6" sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri" size=3>0.00</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#FBE5D6" sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri" size=3>0.00</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#FBE5D6" sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri" size=3>0.00</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#FBE5D6" sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri" size=3>0.00</font></i></b></td>
	</tr> -->
</table>
<center>
    <button type="submit" name="chargement" 
    style="margin-top: 18px;background: #4B99AD;padding: 8px 15px 8px 15px;border: none;color: #fff;">Chargement</button><br> 
   
    
</form>



<div style="width: 650px; margin: 0 auto; text-align: center;">
    <!-- <div style="margin-top: 10px;margin-right : 80px;">
      <?php  GenerateDocuments(); ?>
    </div> -->

    <div style="margin-top: 10px;margin-left : 80px;">
      <?php   ShowDocuments(); ?>
    </div>
</div>

</center>
<!-- ************************************************************************** -->
</body>

</html>
