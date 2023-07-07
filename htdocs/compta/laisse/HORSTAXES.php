<?php

require_once 'codeLaisseHORSTAXES.php';

$object = new User($db);
$id=$user->id;

function GenerateDocuments($dateChoisist)
{
  global $day, $month, $year, $start, $prev_year;
  print '<form id="frmgen" name="builddoc" method="post">';
  print '<input type="hidden" name="token" value="' . newToken() . '">';
  print '<input type="hidden" name="action" value="builddoc">';
  print '<input type="hidden" name="model" value="HorsTaxes">';
  print '<input type="hidden" name="valeurdatechoise" value="'.$dateChoisist.'">';
  print '<div class="right"  style="margin-bottom: 100px; margin-right: 20%;">
  <input type="submit" id="btngen" class="button" name="save" value="génerer">';
  print '</form>';
}


function ShowDocuments()
{
	global $db, $object, $conf, $month, $prev_year, $societe, $showAll, $prev_month, $prev_year, $start;
	print '<div class="fichecenter"><divclass="fichehalfleft">';
	$formfile = new FormFile($db);
	$subdir = '';
	$filedir = DOL_DATA_ROOT . '/billanLaisse/HorsTaxes/';
	$urlsource = $_SERVER['PHP_SELF'] . '';
	$genallowed = 0;
	$delallowed = 1;
	$modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

 

  if ($societe !== null && isset($societe->default_lang)) {
	print $formfile->showdocuments('HorsTaxes', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
  } else {
	  print $formfile->showdocuments('HorsTaxes', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
  }

 //  print $formfile->showdocuments('Passif', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
}

llxHeader("", "");

// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/HorsTaxes/';
$permissiontoadd = 1;
$donotredirect = 1;

include DOL_DOCUMENT_ROOT . '/core/actions_builddoc.inc.php';


?>


<!DOCTYPE html>

<html>
<head>
</head>

<body>
<center>


<form method="POST" >
	<select name="date_select"><?php affichageAnnees()?></select>
	<button type="submit" name="chargement" 
	style="margin-top: 18px;background: #4B99AD;padding: 8px 15px 8px 15px;border: none;color: #fff;">Chargement</button><br>  
</form>
<br>
    <?php
    $date=(!empty($dateChoisis))?$dateChoisis:date('Y');
    echo'<input type="text" style="text-align:center;font-weight:bold;" value="Année chargé : '.$date.'"disabled/>';
    ?>
<br><br> 



<table align="center" cellspacing="0" border="0">
	<colgroup span="2" width="28"></colgroup>
	<colgroup width="250"></colgroup>
	<colgroup span="4" width="124"></colgroup>
	<colgroup width="84"></colgroup>
	<colgroup width="123"></colgroup>
	<tr>
		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=7 height="26" align="center" valign=bottom sdnum="1033;0;H:MM"><b><font face="Calibri" size=4>COMPTE DE PRODUITS ET CHARGES ( HORS TAXES )</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td height="24" align="left" valign=bottom><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=bottom><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=bottom><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><font face="Calibri"><br></font></td>
		<td align="right" valign=bottom><b><font face="Calibri"></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Opérations</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Totaux de l'exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Exercice précédent</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Exercice N-2</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="60" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Eléments</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Propres à l'exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Concernant les exercices précédents</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;0"><b><i><font face="Calibri">1</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;0"><b><i><font face="Calibri">2</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;0"><b><i><font face="Calibri">3 = 1 + 2</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;0"><b><i><font face="Calibri">4</font></i></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;0"><b><i><font face="Calibri">4</font></i></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=20 height="360" align="center" valign=middle><b><font face="Calibri">EXPLOITATION</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">I - PRODUITS D'EXPLOITATION</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($prExPaLex)?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($reExTchCLExPr)?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($reExTchToEx)?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($reExTchExPre)?></font></i></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($reExTchExN2)?></font></i></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Ventes de marchandises</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($veMarchPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($veMarchCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($veMarchToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($veMarchExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($veMarchExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Ventes de biens et services produits</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venBSPPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venBSPCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venBSPToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venBSPExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venBSPExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdnum="1033;0;#,##0.00"><i><font face="Calibri">Chiffres d'affaires</font></i></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($chAffPaLex)?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($chAffCLExPr)?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($chAffToEx)?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($chAffExPre)?></font></i></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($chAffExN2)?></font></i></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Variation de stock de produits</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($varSyProPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($varSyProCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($varSyProToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($varSyProExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($varSyProExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Immobilisations produites pour l'Ese p/elle même</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imPrLePaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imPrLeCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imPrLeToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imPrLeExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imPrLeExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Subvention d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subEXPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subEXCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subEXToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subEXExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subEXExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Autres produits d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrExPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrExCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrExToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrExExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrExExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Reprises d'exploitation; transfert de charges</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reExTchPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reExTchCLExPr)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reExTchToEx)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reExTchExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reExTchExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">TOTAL  I</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIPaLex)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalICLExPr)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIToEx)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">II - CHARGES D'EXPLOITATION</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Achats revendus de marchandises</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Achat consommes de matières et de fournitures</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achCMDPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achCMDCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achCMDToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achCMDExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achCMDExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Autres charges externes</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($autChExPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($autChExCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($autChExToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($autChExExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($autChExExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Impôts et taxes</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imetPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imetCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imetToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imetExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imetExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Charges de personnel</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($chPrPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($chPrCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($chPrToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($chPrExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($chPrExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Autres charges d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auChExPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auChExCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auChExToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auChExExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auChExExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Dotations d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($dExPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($dExCLExPr)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($dExToEx)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($dExExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($dExExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">TOTAL  II</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIIPaLex)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIICLExPr)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIIToEx)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIIExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIIExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">III - RESULTAT D'EXPLOITATION  ( I - II )</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($reExI_IIToEx)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($reExI_IIExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($reExI_IIExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=13 height="234" align="center" valign=middle><b><font face="Calibri">FINANCIER</font></b></td>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">IV - PRODUITS FINANCIERS</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Produits des titres de partic. et autres titres immo.</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($prTPPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($prTPCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($prTPToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($prTPExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($prTPExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Gains de change</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($gaChPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($gaChCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($gaChToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($gaChExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($gaChExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Intérêts et autres produits financiers</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($inAPFPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($inAPFCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($inAPFToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($inAPFExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($inAPFExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Reprises financières; transfert de charges</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reFTChPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reFTChCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reFTChToEx)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reFTChExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reFTChExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">TOTAL  IV</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIVPaLex)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIVCLExPr)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIVToEx)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIVExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIVExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">V - CHARGES FINANCIERES</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Charges d'intérêts</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($chiPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($chiCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($chiToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($chiExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($chiExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Pertes de changes</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($peChPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($peChCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($peChToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($peChExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($peChExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Autres charges financières</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auChFPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auChFCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auChFToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auChFExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auChFExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Dotations financières</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($doFPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($doFCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($doFToEx)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($doFExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($doFExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">TOTAL  V</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalVPaLex)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalVCLExPr)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalVToEx)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalVExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalVExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">VI - RESULTAT FINANCIER ( IV - V )</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($reFToEx)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($reFExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($reFExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">VII - RESULTAT COURANT ( III - V I)</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($reCoToEx)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($reCoExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($reCoExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">VII - RESULTAT COURANT ( Report )</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($reTCToEx)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($reTCExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($reTCExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=14 height="252" align="center" valign=middle><b><font face="Calibri">NON COURANT</font></b></td>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">VIII - PRODUITS NON COURANTS</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Produits des cessions d'immobilisations</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($proDCIPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($proDCICLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($proDCIToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($proDCIExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($proDCIExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Subventions d'équilibre</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subDEPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subDECLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subDEToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subDEExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subDEExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Reprises sur subventions d'investissement</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reSDPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reSDCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reSDToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reSDExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reSDExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Autres produits non courants</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrCPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrCCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrCToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrCExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrCExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Reprises non courantes; transferts de charges</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reCTCPaLex)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reCTCCLExPr)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reCTCToEx)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reCTCExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reCTCExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">TOTAL  VIII</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalVIIIPaLex)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalVIIICLExPr)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalVIIIToEx)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalVIIIExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalVIIIExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">IX - CHARGES NON COURANTES</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Valeurs nettes d'amortis. des immos cédées</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($vaNAICPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($vaNAICCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($vaNAICToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($vaNAICExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($vaNAICExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Subventions accordées</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($suAcPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($suAcCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($suAcToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($suAcExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($suAcExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Autres charges non courantes</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auCNCPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auCNCCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auCNCToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auCNCExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auCNCExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Dotations non courantes aux amortiss. et prov.</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($daCAPPaLex)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($daCAPCLExPr)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($daCAPToEx)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($daCAPExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($daCAPExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">TOTAL  IX</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIXPaLex)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIXCLExPr)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIXToEx)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIXExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIXExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">X - RESULTAT NON COURANT ( VIII- IV )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($XReNCToEx)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($XReNCExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($XReNCExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">XI - RESULTAT AVANT IMPOTS ( VII+ X )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xiResulAIToEx)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xiResulAIExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xiResulAIExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">XII - IMPOTS SUR LES RESULTATS </font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($xiiIMSLRPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($xiiIMSLRCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xiiIMSLRToEx)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xiiIMSLRExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xiiIMSLRExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">XIII - RESULTAT NET ( XI - XII )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xiiReNToEx)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xiiReNExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xiiReNExN2)?></font></b></td>
	</tr>
	<tr>
		<td height="18" align="left" valign=bottom><font face="Calibri" color="#C0C0C0"><br></font></td>
		<td align="left" valign=bottom><b><font face="Calibri" color="#C0C0C0"><br></font></b></td>
		<td align="left" valign=bottom><font face="Calibri" color="#C0C0C0"><br></font></td>
		<td align="left" valign=bottom><font face="Calibri" color="#C0C0C0"><br></font></td>
		<td align="left" valign=bottom><font face="Calibri" color="#C0C0C0"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri" color="#C0C0C0"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri" color="#C0C0C0"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri" color="#C0C0C0"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">XIV - TOTAL DES PRODUITS ( I + IV + VIII )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xivToDPrToEx)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xivToDPrExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xivToDPrExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">XV - TOTAL DES CHARGES ( II + V + IX + XII )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xvToDCHToEx)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xvToDCHExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xvToDCHExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">XVI - RESULTAT NET ( XIV - XV )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xviReNToEx)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xviReNExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($xviReNExN2)?></font></b></td>
	</tr>
	
</table>

</center>
<!-- ************************************************************************** -->
      
<div style="width: 650px; margin: 0 auto; text-align: center;">
    <div style="margin-top: 10px;margin-right : 80px;">
      <?php  GenerateDocuments($dateChoisis); ?>
    </div>

    <div style="margin-top: -90px;margin-left : 80px;">
      <?php   ShowDocuments(); ?>
    </div>
  </div>
</body>

</html>
