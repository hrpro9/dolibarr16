<?php

require_once 'codeFinancementEx.php';



  $object = new User($db);
  $id=$user->id;
  
  function GenerateDocuments($dateChoisist)
 {
    global $day, $month, $year, $start, $prev_year;
    print '<form id="frmgen" name="builddoc" method="post">';
    print '<input type="hidden" name="token" value="' . newToken() . '">';
    print '<input type="hidden" name="action" value="builddoc">';
    print '<input type="hidden" name="model" value="FinancementEx">';
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
      $filedir = DOL_DATA_ROOT . '/billanLaisse/FinancementEx/';
      $urlsource = $_SERVER['PHP_SELF'] . '';
      $genallowed = 0;
      $delallowed = 1;
      $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

   

    if ($societe !== null && isset($societe->default_lang)) {
      print $formfile->showdocuments('FinancementEx', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
    } else {
        print $formfile->showdocuments('FinancementEx', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
    }

   //  print $formfile->showdocuments('Passif', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
  }

  

  llxHeader("", ""); 


  
// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/FinancementEx/';
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
	<meta name="created" content="2023-06-19T09:50:17"/>
	<meta name="changedby" content="Microsoft Office User"/>
	<meta name="changed" content="2023-06-19T09:51:03"/>
	<meta name="AppVersion" content="16.0300"/>
	
	
	
</head>

<body>
<center>
    <form method="POST" >
     <select name="date_select" required>
     <option value="">Choisis date</option>
      <?php affichageAnnees()?>
    </select>
     <button type="submit" name="chargement" style="margin-top: 18px;background: #4B99AD;padding: 8px 15px 8px 15px;border: none;color: #fff;">Chargement</button><br>  
    </form>
    <br>
      <?php
        $date=(!empty($dateChoisis))?$dateChoisis:'?';
        echo'<input type="text"  style="text-align:center;font-weight:bold;" value="Année chargé : '.$date.'"disabled/>';
      ?> <br><br> 
<table cellspacing="0" border="0">
	<colgroup width="19"></colgroup>
	
	
	<tr>
		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=6 height="38" align="center" valign=middle><b><font size=4>TABLEAU DE FINANCEMENT DE L'EXERCICE</font></b></td>
		<td align="left" valign=middle><font face="Arial" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><font size=2><br></font></td>
		<td align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><font size=2><br></font></td>
		<td align="left" valign=bottom><font size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	
	<tr>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=middle bgcolor="#D9D9D9"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" rowspan=3 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>Masses</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>Exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=top bgcolor="#D9D9D9"><b><font size=2>Exercice précédent</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=bottom bgcolor="#D9D9D9"><b><font size=2>Variations a-b</font></b></td>
		<td align="left" valign=bottom><b><font face="Arial" size=2><br></font></b></td>
		
		</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="18" align="left" valign=middle bgcolor="#D9D9D9"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><font size=2>Emplois</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><font size=2>Ressources</font></b></td>
		<td align="left" valign=bottom><b><font face="Arial" size=2><br></font></b></td>
		
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=middle bgcolor="#D9D9D9"><b><font size=2><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><font size=2>a</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><font size=2>b</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><font size=2>c</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><font size=2>d</font></b></td>
		<td align="left" valign=bottom><b><font face="Arial" size=2><br></font></b></td>
	
	</tr>
	<tr>
		<td height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><b><font size=2>I-SYNTHESE DES MASSES DU BILAN</font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="right" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="1" sdnum="1033;"><font size=2>1</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>  Financement Permanent</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($FP_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($FP_EP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($FP_VE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($FP_VR)?></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="2" sdnum="1033;"><font size=2>2</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>  Moins actif immobilisé</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($MAI_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($MAI_EP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($MAI_VE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($MAI_VR)?></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="3" sdnum="1033;"><font size=2>3</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>  = Fonds de roulement fonctionnel (1-2) (A)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($FDRF_E)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($FDRF_EP)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($FDRF_VE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($FDRF_VR)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="4" sdnum="1033;"><font size=2>4</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>  Actif circulant</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($AC_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($AC_EP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($AC_VE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($AC_VR)?></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="5" sdnum="1033;"><font size=2>5</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>  Moins passif circulant</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($MPC_E)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($MPC_EP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($MPC_VE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($MPC_VR)?></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
    </tr>	
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="6" sdnum="1033;"><font size=2>6</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>  = Besoin de financement global (4-5) (B)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($BDFG_E)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($BDFG_EP)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($BDFG_VE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($BDFG_VR)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="7" sdnum="1033;"><font size=2>7</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>  TRESORERIE NETTE (Actif-Passif) = A-B</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($BDFG_E)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($BDFG_E)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($BDFG_E)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($BDFG_E)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td align="left" valign=bottom><font size=2><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><b><font size=2>II- EMPLOIS ET RESSOURCES</font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="right" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000" height="23" align="left" valign=middle bgcolor="#D9D9D9"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D9D9D9"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" colspan=2 align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font size=2>Exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font size=2>Exercice précédent</font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
	
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="22" align="left" valign=middle bgcolor="#D9D9D9"><font size=2><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D9D9D9"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font size=2>Emplois</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font size=2>Ressources</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font size=2>Emplois</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font size=2>Ressources</font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=2><br></font></td>
	</tr>
	<tr>
		<td height="5" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>I- RESSOURCES STABLES DE L'EXERCICE (FLUX)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Autofinancement (A)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($AU_ER)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($AU_EPR)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Capacité d'autofinancement</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($CDA_ER)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($CDA_EPR)?></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>- Distributions de bénéfices</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Cessions et reductions d'immobilisations (B)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($CERDI_ER)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($CERDI_EPR)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Cessions d'immobilisations incorporelles</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($CDII_ER)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($CDII_EPR*-1)?></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Cessions d'immobilisations corporelles</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($CDIC_ER)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($CDIC_EPR*-1)?></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Cessions d'immobilisations financières</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($CDIF_ER)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($CDIF_EPR*-1)?></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Récupérations sur créances immobilisées</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Augmentation des capitaux propres et assimiles (C)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($ADCPEA_ER)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($ADCPEA_EPR)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Augmentation du capital , apports</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($ADCA_ER)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($ADCA_EPR)?></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Subventions d'investissement</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($SDI_ER)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2><?php readMontant($SDI_EPR)?></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Augmentation des dettes de financement (D) (1)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom><b><font size=2>TOTAL I - RESSOURCES STABLES (A+B+C+D)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($TRS_ER)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($TRS_EPR)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td height="6" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom><b><font size=2>II- EMPLOIS STABLES DE L'EXERCICE (FLUX)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Acquisitions et augmentations d'immobilisations (E)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Acquisitions d'immobilisations incorporelles</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Acquisitions d'immobilisation corporelles</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Acquisitions d'immobilisation financières</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Augmentation des créances immobilisées</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Remboursement des capitaux propres (F)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Remboursements des dettes de financement (G)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Emplois en non valeurs (H)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($EENV_EE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>TOTAL II - EMPLOIS STABLES (E+F+G+H)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($TOTALIIEMPLOISSTABLES_EE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($TOTALIIEMPLOISSTABLES_ER)?><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($TOTALIIEMPLOISSTABLES_EPE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($TOTALIIEMPLOISSTABLES_EPR)?><br></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td height="7" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>III- VARIATION DU BESOIN DE FINANCEMENT GLOBAL (B.F.G)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($VDBDFG_EE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($VDBDFG_ER)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($VDBDFG_EPE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($VDBDFG_EPR)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>IV- VARIATION DE LA TRESORERIE</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($VDLT_EE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($VDLT_ER)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($VDLT_EPE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($VDLT_EPR)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>TOTAL GENERAL</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($TOTALGENERAL_EE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($TOTALGENERAL_ER)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($TOTALGENERAL_EPE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php readMontant($TOTALGENERAL_EPR)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
		<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	</tr>

</table>
</center>

        
<div style="width: 650px; margin: 0 auto; text-align: center;">
  <div style="margin-top: 10px;margin-right : 80px;">
    <?php  GenerateDocuments($dateChoisis); ?>
  </div>

  <div style="margin-top: -90px;margin-left : 80px;">
    <?php   ShowDocuments(); ?>
  </div>
</div>


<!-- ************************************************************************** -->
</body>

</html>
