<?php

require_once 'codePassageComptableFiscal.php';



  $object = new User($db);
  $id=$user->id;
  
  function GenerateDocuments($dateChoisist)
 {
    global $day, $month, $year, $start, $prev_year;
    print '<form id="frmgen" name="builddoc" method="post">';
    print '<input type="hidden" name="token" value="' . newToken() . '">';
    print '<input type="hidden" name="action" value="builddoc">';
    print '<input type="hidden" name="model" value="PassageComptableFiscal">';
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
      $filedir = DOL_DATA_ROOT . '/billanLaisse/PassageComptableFiscal/';
      $urlsource = $_SERVER['PHP_SELF'] . '';
      $genallowed = 0;
      $delallowed = 1;
      $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

   

    if ($societe !== null && isset($societe->default_lang)) {
      print $formfile->showdocuments('PassageComptableFiscal', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
    } else {
        print $formfile->showdocuments('PassageComptableFiscal', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
    }

   //  print $formfile->showdocuments('Passif', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
  }

  

  llxHeader("", ""); 


  
// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/PassageComptableFiscal/';
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
	<meta name="created" content="2023-08-29T11:32:10"/>
	<meta name="changedby" content="Microsoft Office User"/>
	<meta name="changed" content="2023-08-29T11:32:59"/>
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
     
    <br>
      <?php
        $date=(!empty($dateChoisis))?$dateChoisis:'?';
        echo'<input type="text"  style="text-align:center;font-weight:bold;" value="Année chargé : '.$date.'"disabled/>';
      ?> <br><br> 
<table align="center" cellspacing="0" border="0">
	<colgroup width="460"></colgroup>
	<colgroup width="121"></colgroup>
	<colgroup width="130"></colgroup>

	
	<tr>
		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=3 height="26" align="center" valign=bottom><b><font face="Calibri" size=4>PASSAGE DU RESULTAT NET COMPTABLE AU RESULTAT NET FISCAL</font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow"><br></font></b></td>
		<td align="center" valign=middle><b><font face="Arial Narrow"><br></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td height="33" align="left" valign=middle><b><font face="Calibri"><br></font></b></td>
		<td align="center" valign=middle><b><font face="Calibri"><br></font></b></td>
		<td align="right" valign=middle sdnum="1033;0;#,##0.00"><b><font face="Calibri"></font></b></td>
		<td align="left" valign=middle><b><font face="Arial Narrow"><br></font></b></td>
		<td align="center" valign=middle><b><font face="Arial Narrow"><br></font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="36" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">INTITULES</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Montant</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Montant</font></b></td>
		<td align="left" valign=middle><b><font face="Arial Narrow"><br></font></b></td>
	
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><b><u><font face="Calibri">I. RESULTAT NET COMPTABLE</font></u></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Bénéfice net</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($BN_MP)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Perte nette</font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($PN_MM)?></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#D9D9D9"><b><u><font face="Calibri">II. REINTEGRATIONS FISCALES</font></u></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#D9D9D9" sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IIRF_MP)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow"><br></font></b></td>	
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><b><font face="Calibri">1. Courantes</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($C1_MP)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow"><br></font></b></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- RRR obtenus des exercice anterieurs</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($RODEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Autres charges des exercice anterieurs</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($ACDEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Impots et taxes des exercices anterieurs</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($IETDEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Charges de personnel exercices anterieurs</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($CDPEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Dotation d'exploitation exercices anterieurs</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($DDEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Charges d'interet des exercices anterieurs</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($CDDEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Pertes de changes exercice anterieurs</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($PDCEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
		
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Autres charges financieres exercice anterieurs</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($ACFEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Achats revendus de marchandises des exercices anterieurs</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($ARDMDEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Achats de matieres et de fournitures des exercices anterieurs</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($ADMEDFDEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Cadeaux non deductibles</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br> <?php readMontant($CND_MP)?> </font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Dons non deductible</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br> <?php readMontant($DND_MP)?> </font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>


	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><b><font face="Calibri">2. Non courantes</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"> <?php readMontant($NC2_MP)?> </font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>

    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Cotisation Minimale</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($CM_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Impot sur le resultat</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($ISLR_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Creances devenues irrecouvrables</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($CDI_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Subventions accordees exercice anterieurs</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($SAEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Penalites et amandes fiscales</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($PEAF_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Autres charges non courant des exercices ant</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($ACNCDEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Dotations non courantes exercices anterieurs</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($DNCEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Contribution sociale de solidarité sur les bénéfices (C.S.S)</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($DNCEA_MP)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#D9D9D9"><b><u><font face="Calibri">III. DEDUCTIONS FISCALES</font></u></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#D9D9D9" sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#D9D9D9" sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IIIDF_MM)?></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><b><font face="Calibri">1. Courantes</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($CIII_MM)?></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Dividendes et produits de participation</font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($DEPDP_MM)?></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Ind.retard (Loi 32-10) compt.non encaissées</font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($IRCNE_MM)?></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br>- Ind.retard (Loi 32-10) compt.non payées en N</font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br><?php readMontant($IRCNPEN_MM)?></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>

	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><b><font face="Calibri">2.  Non courantes</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($NCIII_MM)?></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
		</tr>

	<tr>
	<?php
	
	for ($i = 1; $i <=3; $i++) {
		if($i==1)
		{
			echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><input required min="0" type="text" required style="width: 459px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
		}
		else{
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
		}  
	}                 
    ?>
	</tr>
	<tr>
<?php
	for ($i = 4; $i <=6; $i++) {
		if($i==4)
		{
			echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><input required min="0" type="text" required style="width: 459px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
		}
		else{
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
		}  
	}                 
    ?>
</tr>
<?php
	for ($i = 7; $i <=9; $i++) {
		if($i==7)
		{
			echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><input required min="0" type="text" required style="width: 459px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
		}
		else{
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
		}  
	}                 
    ?>

	

	
   
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="right" valign=bottom><b><font face="Calibri">Total</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($Total_MP)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($Total_MM)?></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><b><u><font face="Calibri">IV. RESULTAT BRUT FISCAL</font></u></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">Montant</font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Bénéfice brut si T1 &gt; T2 (A)</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($BBSI_MM)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left" valign=bottom><font face="Calibri">Déficit brut fiscal si T2 &gt; T1 (B)</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($DBFSI_MM)?></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><b><u><font face="Calibri">V. REPORTS DEFICITAIRES IMPUTES  (C)  (1)</font></u></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($VRDIC_MM)?></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Exercice n-4 (2015)</font></td>
		
			
	<?php
	for ($i = 10; $i <=10; $i++) {
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
	}                 
    ?>

		
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Exercice n-3 (2016)</font></td>
		
		<?php
	for ($i = 11; $i <=11; $i++) {
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
	}                 
    ?>
		
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Exercice n-2 (2017)</font></td>
	
		<?php
	for ($i = 12; $i <=12; $i++) {
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
	}                 
    ?>
		
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Exercice n-1 (2018)</font></td>

		<?php
	for ($i = 13; $i <=13; $i++) {
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
	}                 
    ?>
		
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Amort fiscalement différés imputés</font></td>
	
		<?php
	for ($i = 14; $i <=14; $i++) {
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
	}                 
    ?>
		
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><b><u><font face="Calibri">VI. RESULTAT NET FISCAL</font></u></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Bénéfice net fiscal  (A-C)</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($BNFAC_MM)?><br></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">ou déficit net fiscal  (B)</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($VRDIC_MM)?></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">Montant</font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><b><u><font face="Calibri">VII. CUMUL DES AMORTISSEMENTS FISCALEMENT DIFFERES</font></u></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
	
		<?php
	for ($i = 15; $i <=15; $i++) {
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
	}                 
    ?>
		
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><b><u><font face="Calibri">VIII. CUMUL DES DEFICITS FISCAUX RESTANT A REPORTER</font></u></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($VIICDDFRAR_MM)?></font></b></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Exercice n-4 (2015)</font></td>
		
		<?php
	for ($i = 16; $i <=16; $i++) {
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
	}                 
    ?>
		
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Exercice n-3 (2016)</font></td>
	
		<?php
	for ($i = 17; $i <=17; $i++) {
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
	}                 
    ?>
		
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Exercice n-2 (2017)</font></td>
		
		<?php
	for ($i = 18; $i <=18; $i++) {
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
	}                 
    ?>
		
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><b><font face="Arial Narrow" color="#FF0000"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">Exercice n-1 (2018)</font></td>
		
		<?php
	for ($i = 19; $i <=19; $i++) {
			echo '<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 125px;" name="PassageCom' . $i . '" id="PassageCom' . $i . '" value="';
			if (isset(${"PassageCom" . $i})) {
				echo ${"PassageCom" . $i};
			}
			echo '" /><br></font></td>' . "\n";
	}                 
    ?>
		
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
	</tr>
	
</table>
</form>
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
