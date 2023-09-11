<?php

require_once 'codeESG.php'; 

$object = new User($db);
$id=$user->id;

function GenerateDocuments($dateChoisist)
{
 global $day, $month, $year, $start, $prev_year;
 print '<form id="frmgen" name="builddoc" method="post">';
 print '<input type="hidden" name="token" value="' . newToken() . '">';
 print '<input type="hidden" name="action" value="builddoc">';
 print '<input type="hidden" name="model" value="Esg">';
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
   $filedir = DOL_DATA_ROOT . '/billanLaisse/Esg/';
   $urlsource = $_SERVER['PHP_SELF'] . '';
   $genallowed = 0;
   $delallowed = 1;
   $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));



 if ($societe !== null && isset($societe->default_lang)) {
   print $formfile->showdocuments('Esg', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
 } else {
	 print $formfile->showdocuments('Esg', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
 }

//  print $formfile->showdocuments('Passif', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
}

llxHeader("", "");


// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/Esg/';
$permissiontoadd = 1;
$donotredirect = 1;

include DOL_DOCUMENT_ROOT . '/core/actions_builddoc.inc.php';
     
  
?>
<!DOCTYPE html>

<html>
<head>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title></title>
	
	<style type="text/css">

	</style>
	
</head>

<body>
<center>
<form method="POST" >
<select name="date_select" required>
     <option value="">Choisis date</option>
      <?php affichageAnnees()?>
    </select>
    <button type="submit" name="chargement" 
    style="margin-top: 18px;background: #4B99AD;padding: 8px 15px 8px 15px;border: none;color: #fff;">Chargement</button><br>  
 
    <br>
    <?php

    $date=(!empty($dateChoisis))?$dateChoisis:'?';
    
    echo'<input type="text" style="text-align:center;font-weight:bold;" value="Année chargé : '.$date.'"disabled/>';
   
    ?>
  <br><br> 
</center>
<table align="center" cellspacing="0" border="0">
	<colgroup width="24"></colgroup>
	<colgroup width="22"></colgroup>
	<colgroup width="24"></colgroup>
	<colgroup width="395"></colgroup>
	<colgroup span="2" width="124"></colgroup>
	<colgroup width="84"></colgroup>
	<colgroup width="105"></colgroup>
	<tr>
		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=6 height="26" align="center" valign=bottom><b><font face="Calibri" size=4>ETAT DES SOLDES INTERMEDIAIRES DE GESTION (E.S.G)</font></b></td>

		<td align="left" valign=bottom><font face="Arial"><br></font></td>
	</tr>
	<tr>
		<td height="17" align="left" valign=bottom><font face="Arial"><br></font></td>
		<td align="left" valign=bottom><font face="Arial"><br></font></td>
		<td align="left" valign=bottom><font face="Arial"><br></font></td>
		<td align="left" valign=bottom><font face="Arial"><br></font></td>
		<td align="left" valign=bottom><font face="Arial"><br></font></td>
		<td align="left" valign=bottom><font face="Arial"><br></font></td>
		<td align="left" valign=bottom><font face="Arial"><br></font></td>
		<td align="left" valign=bottom><font face="Arial"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Arial"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Arial"><br></font></td>
		<td align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Arial"><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Arial"><br></font></td>
		<td align="left" valign=bottom><font face="Arial"><br></font></td>
		<td align="left" valign=bottom><font face="Arial"><br></font></td>
	</tr>
	<tr>
		<td height="7" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Arial"><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Arial"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Arial"><br></font></td>
		<td align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Arial"><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Arial"><br></font></td>
		<td align="right" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Arial"><br></font></b></td>
		<td align="left" valign=bottom><font face="Arial"><br></font></td>
		<td align="left" valign=bottom><font face="Arial"><br></font></td>
	</tr>
	<tr>
		<td align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 height="37" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Eléments</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 2px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Exercice Précédent</font></b></td>
		<td align="left" valign=bottom><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Exercice N-2</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="1" sdnum="1033;0;0"><font face="Calibri" size=1>1</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Ventes de marchandises (en l'état )</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venteMarch_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venteMarch_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venteMarch_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="2" sdnum="1033;0;0"><font face="Calibri">2</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> -</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Achats revendus de marchandises</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achatReMarch_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achatReMarch_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achatReMarch_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri">I</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> =</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><b><font face="Calibri">MARGES BRUTES SUR VENTES EN L'ETAT</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($marchB_E)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($marchB_EP)?></font></b></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($marchB_E2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri">II</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> +</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">PRODUCTION DE L'EXERCICE (3+4+5)</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($prodExe_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($prodExe_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($prodExe_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="3" sdnum="1033;0;0"><font face="Calibri">3</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Ventes de biens et services produits</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($venteServ_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($venteServ_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($venteServ_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="4" sdnum="1033;0;0"><font face="Calibri">4</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Variation de stocks de produits</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($varStock_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($varStock_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($varStock_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="5" sdnum="1033;0;0"><font face="Calibri">5</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Immobilisations produites par l'entreprise pour elle même</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($immobiProd_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($immobiProd_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($immobiProd_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri">III</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> -</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">CONSOMMATION DE L'EXERCICE (6+7)</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($ConsExe_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($ConsExe_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($ConsExe_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="6" sdnum="1033;0;0"><font face="Calibri">6</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Achats consommés de matières et fournitures</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($achatCons_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($achatCons_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($achatCons_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="7" sdnum="1033;0;0"><font face="Calibri">7</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Autres charges externes</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($autreCharge_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($autreCharge_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($autreCharge_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri">IV</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> =</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><b><font face="Calibri">VALEUR AJOUTEE ( I+II+III )</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($valAjout_E)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($valAjout_EP)?></font></b></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($valAjout_E2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="8" sdnum="1033;0;0"><font face="Calibri">8</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> +</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Subventions d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($subExp_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($subExp_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($subExp_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri">V</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="9" sdnum="1033;0;0"><font face="Calibri">9</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> -</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Impôts et taxes</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($impotTaxe_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($impotTaxe_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($impotTaxe_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="10" sdnum="1033;0;0"><font face="Calibri">10</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> -</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Charges de personnel</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($chargePers_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($chargePers_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($chargePers_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> =</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">EXCEDENT BRUT D'EXPLOITATION ( E.B.E )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($ExcedentB_E)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($ExcedentB_EP)?></font></b></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($ExcedentB_E2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="11" sdnum="1033;0;0"><font face="Calibri">11</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> +</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Autres produits d'exploitation</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($autresProd_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($autresProd_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($autresProd_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="12" sdnum="1033;0;0"><font face="Calibri">12</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> -</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Autres charges d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($autresCharg_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($autresCharg_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($autresCharg_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="13" sdnum="1033;0;0"><font face="Calibri">13</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> +</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Reprises d'exploitation: transfert de charges</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($reprisesExpl_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($reprisesExpl_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($reprisesExpl_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="14" sdnum="1033;0;0"><font face="Calibri">14</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> -</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Dotations d'exploitation</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($dotationExpl_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($dotationExpl_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($dotationExpl_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri">VI</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> =</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><b><font face="Calibri">RESULTAT D'EXPLOITATION ( + ou - )</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($resultatExpl_E)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($resultatExpl_EP)?></font></b></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($resultatExpl_E2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri">VII</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">RESULTAT FINANCIER</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($resultatFin_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($resultatFin_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($resultatFin_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri">VIII</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> =</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><b><font face="Calibri">RESULTAT COURANT ( + ou - )</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($resultatCrt_E)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($resultatCrt_EP)?></font></b></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($resultatCrt_E2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri">IX</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">RESULTAT NON COURANT ( + ou - )</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($resultatNonCrt_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($resultatNonCrt_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($resultatNonCrt_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="15" sdnum="1033;0;0"><font face="Calibri">15</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> -</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Impôts sur les resultats</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($impotRest_E)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($impotRest_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($impotRest_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri">X</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> =</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><b><font face="Calibri">RESULTAT NET DE L'EXERCICE ( + ou - )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($resultatNetExe_E)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($resultatNetExe_EP)?></font></b></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($resultatNetExe_E2)?></font></b></td>
	</tr>
	<tr>
		<td height="18" align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=middle><font face="Calibri"><br></font></td>
	</tr>
	<tr>
		<td align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="1" sdnum="1033;0;0"><font face="Calibri">1</font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0"><b><font face="Calibri">RESULTAT NET DE L'EXERCICE ( + ou - )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" ><?php readmontant($resultatNetExe_E)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" ><?php readmontant($resultatNetExe_EP)?></font></b></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" ><?php readmontant($resultatNetExe_E2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle><i><font face="Calibri">- Benefice (+)</font></i></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri"><?php readmontant($benefice_E)?></font></i></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri"><?php readmontant($benefice_EP)?></font></i></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri"><?php readmontant($benefice_E2)?></font></i></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle><i><font face="Calibri">- Perte      (-)</font></i></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri"><?php readmontant($perte_E)?></font></i></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri"><?php readmontant($perte_EP)?></font></i></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri"><?php readmontant($perte_E2)?></font></i></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="2" sdnum="1033;0;0"><font face="Calibri">2</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> +</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Dotations d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($datatExpl_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($datatExpl_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($datatExpl_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="3" sdnum="1033;0;0"><font face="Calibri">3</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> +</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Dotations financières</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($dotationfin_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($dotationfin_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($dotationfin_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="4" sdnum="1033;0;0"><font face="Calibri">4</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> +</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Dotations non courantes</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($dotationNonCour_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($dotationNonCour_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($dotationNonCour_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="5" sdnum="1033;0;0"><font face="Calibri">5</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> -</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Reprises d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($reprExpl_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($reprExpl_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($reprExpl_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="6" sdnum="1033;0;0"><font face="Calibri">6</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> -</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Reprises financières</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($repriseFin_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($repriseFin_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($repriseFin_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="7" sdnum="1033;0;0"><font face="Calibri">7</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> -</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Reprises non courantes</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($repNonCour_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($repNonCour_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($repNonCour_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="8" sdnum="1033;0;0"><font face="Calibri">8</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> -</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Produits des cession des immobilisations</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($prodImmb_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($prodImmb_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($prodImmb_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="9" sdnum="1033;0;0"><font face="Calibri">9</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><font face="Calibri"> +</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Valeurs nettes des immobilisations cédées</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($valNetImmb_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($valNetImmb_EP)?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readmontant($valNetImmb_E2)?></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri">I</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><b><font face="Calibri">CAPACITE D'AUTOFINANCEMENT  ( C.A.F )</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($CAF_E)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($CAF_EP)?></font></b></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($CAF_E2)?></font></b></td>
	</tr>
	<tr>
		<td  style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="10" sdnum="1033;0;0"><font face="Calibri">10</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0"><b><font face="Calibri"> -</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri">Distributions de bénéfices</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">
		<?php
            for ($i = 1; $i <=1; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="esg' . $i . '" id="esg' . $i . '" value="';
                if (isset(${"esg" . $i})) {
                    echo ${"esg" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
		<br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">
		<?php
            for ($i = 2; $i <=2; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="esg' . $i . '" id="esg' . $i . '" value="';
                if (isset(${"esg" . $i})) {
                    echo ${"esg" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
		<br></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">
		<?php
            for ($i =3; $i <=3; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="esg' . $i . '" id="esg' . $i . '" value="';
                if (isset(${"esg" . $i})) {
                    echo ${"esg" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
		<br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri">II</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle sdnum="1033;0;0"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle sdnum="1033;0;#,##0.00"><b><font face="Calibri">AUTOFINANCEMENT</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($autofin_E)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($autofin_EP)?></font></b></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readmontant($autofin_E2)?></font></b></td>
	</tr>
</table>

</form>

<div style="width: 650px; margin: 0 auto; text-align: center;">
  <div style="margin-top: 10px;margin-right : 80px;">
    <?php GenerateDocuments($dateChoisis); ?>
  </div>

  <div style="margin-top: -90px;margin-left : 80px;">
    <?php ShowDocuments(); ?>
  </div>
</div>

</body>

</html>
