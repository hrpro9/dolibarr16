<?php

require_once 'codeImmobilisationsFinancieres.php';



  $object = new User($db);
  $id=$user->id;
  
  function GenerateDocuments($dateChoisist)
 {
    global $day, $month, $year, $start, $prev_year;
    print '<form id="frmgen" name="builddoc" method="post">';
    print '<input type="hidden" name="token" value="' . newToken() . '">';
    print '<input type="hidden" name="action" value="builddoc">';
    print '<input type="hidden" name="model" value="ImmobilisationsFinancieres">';
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
      $filedir = DOL_DATA_ROOT . '/billanLaisse/ImmobilisationsFinancieres/';
      $urlsource = $_SERVER['PHP_SELF'] . '';
      $genallowed = 0;
      $delallowed = 1;
      $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

   

    if ($societe !== null && isset($societe->default_lang)) {
      print $formfile->showdocuments('ImmobilisationsFinancieres', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
    } else {
        print $formfile->showdocuments('ImmobilisationsFinancieres', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
    }

   //  print $formfile->showdocuments('Passif', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
  }

  

  llxHeader("", ""); 


  
// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/ImmobilisationsFinancieres/';
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
	<meta name="created" content="2023-08-29T11:33:20"/>
	<meta name="changedby" content="Microsoft Office User"/>
	<meta name="changed" content="2023-08-29T11:33:39"/>
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

	<tr>
		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=9 height="26" align="center" valign=bottom><b><font face="Calibri" size=5>TABLEAU DES IMMOBILISATIONS AUTRES QUE FINANCIERES</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>

	</tr>
	<tr>
		<td height="33" align="left" valign=middle><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=middle sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="right" valign=middle><b><font face="Calibri"></font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=middle><b><font face="Calibri"><br></font></b></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 height="68" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Nature</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Montant brut début exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Augmentation</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Diminution</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Montant brut fin exercice</font></b></td>
		<td align="center" valign=middle><font face="Arial Narrow"><br></font></td>
		<td align="center" valign=middle><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Acquisition</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Production par l'Etps pour elle même</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Virement</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Cession</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Retrait</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Virement</font></b></td>
		<td align="center" valign=middle><font face="Arial Narrow"><br></font></td>
		<td align="center" valign=middle><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="20" align="left" valign=bottom><b><font face="Calibri">IMMOBILISATION EN NON-VALEURS</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IENV_MBDE)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IENV_AA)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IENV_APPLPEM)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IENV_AV)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IENV_DC)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IENV_DR)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IENV_DV)?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IENV_MBFE)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Frais préliminaires</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($FP_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($FP_AA)?></font></td>

		<?php
            for ($i = 1; $i <=5; $i++) {
				if($i==1)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>

	
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($FP_MBFE)?></font></td>
		<td align="center" valign=middle sdval="211" sdnum="1033;"><font face="Arial Narrow"></font></td>
		<td align="center" valign=middle sdval="71411" sdnum="1033;"><font face="Arial Narrow"></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Charges à répartir sur plusieurs exercices</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($CARSPE_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($CARSPE_AA)?></font></td>
		<?php
            for ($i = 6; $i <=10; $i++) {
				if($i==6)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($CARSPE_MBFE)?></font></td>
		<td align="center" valign=middle sdval="212" sdnum="1033;"><font face="Arial Narrow"></font></td>
		<td align="center" valign=middle sdval="71412" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Primes de remboursement obligations</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($PDRO_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($PDRO_AA)?></font></td>
		<?php
            for ($i = 11; $i <=15; $i++) {
				if($i==11)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($PDRO_MBFE)?></font></td>
		<td align="center" valign=middle sdval="213" sdnum="1033;"><font face="Arial Narrow"></font></td>
		<td align="center" valign=middle sdval="71413" sdnum="1033;"><font face="Arial Narrow"></font></td>
	</tr>


	
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=bottom><b><font face="Calibri">IMMOBILISATIONS INCORPORELLES</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($II_MBDE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($II_AA)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($II_APPLPEM)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($II_AV)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($II_DC)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($II_DR)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($II_DV)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($II_MBFE)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Immobilisation en recherche et développement</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($IERED_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($IERED_AA)?></font></td>
		<?php
            for ($i = 16; $i <=20; $i++) {
				if($i==16)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($IERED_MBFE)?></font></td>
		<td align="center" valign=middle sdval="221" sdnum="1033;"><font face="Arial Narrow"></font></td>
		<td align="center" valign=middle sdval="71421" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Brevets, marques, droits et valeurs similaires</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($BMDEVS_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($BMDEVS_AA)?></font></td>
		<?php
            for ($i = 21; $i <=25; $i++) {
				if($i==21)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($BMDEVS_MBFE)?></font></td>
		<td align="center" valign=middle sdval="222" sdnum="1033;"><font face="Arial Narrow"></font></td>
		<td align="center" valign=middle sdval="71422" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Fonds commercial</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($FC_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($FC_AA)?></font></td>
		<?php
            for ($i = 26; $i <=30; $i++) {
				if($i==26)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($FC_MBFE)?></font></td>
		<td align="center" valign=middle sdval="223" sdnum="1033;"><font face="Arial Narrow"></font></td>
		<td align="center" valign=middle sdval="71423" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Autres immobilisations incorporelles</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($AII_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($AII_AA)?></font></td>
		<?php
            for ($i = 31; $i <=35; $i++) {
				if($i==31)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($AII_MBFE)?></font></td>
		<td align="center" valign=middle sdval="228" sdnum="1033;"><font face="Arial Narrow"></font></td>
		<td align="center" valign=middle sdval="71428" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=bottom><b><font face="Calibri">IMMOBILISATIONS CORPORELLES</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IC_MBDE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IC_AA)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IC_APPLPEM)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IC_AV)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IC_DC)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IC_DR)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IC_DV)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($IC_MBFE)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Terrains</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($T_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($T_AA)?></font></td>
		<?php
            for ($i = 36; $i <=40; $i++) {
				if($i==36)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($T_MBFE)?></font></td>
		<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="231" sdnum="1033;"></td>
		<td align="center" valign=middle sdval="71431" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Constructions</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($C_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($C_AA)?></font></td>
		<?php
            for ($i = 41; $i <=45; $i++) {
				if($i==41)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($C_MBFE)?></font></td>
		<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="232" sdnum="1033;"></td>
		<td align="center" valign=middle sdval="71432" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Installations techniques, matériel et outillage</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($ITMEO_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($ITMEO_AA)?></font></td>
		<?php
            for ($i = 46; $i <=50; $i++) {
				if($i==46)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($ITMEO_MBFE)?></font></td>
		<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="233" sdnum="1033;"></td>
		<td align="center" valign=middle sdval="71433" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Matériel de transport</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($MDT_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($MDT_AA)?></font></td>
		<?php
            for ($i = 51; $i <=55; $i++) {
				if($i==51)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($MDT_MBFE)?></font></td>
		<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="234" sdnum="1033;"></td>
		<td align="center" valign=middle sdval="71434" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Mobilier, matériel de bureau et aménagement</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($MMDBEA_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($MMDBEA_AA)?></font></td>
		<?php
            for ($i = 56; $i <=60; $i++) {
				if($i==56)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($MMDBEA_MBFE)?></font></td>
		<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="235" sdnum="1033;"></td>
		<td align="center" valign=middle sdval="71435" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Autres immobilisations corporelles</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($AIC_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($AIC_AA)?></font></td>
		<?php
            for ($i = 61; $i <=65; $i++) {
				if($i==61)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($AIC_MBFE)?></font></td>
		<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="238" sdnum="1033;"></td>
		<td align="center" valign=middle sdval="71438" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Immobilisations corporelles en cours</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($ICEC_MBDE)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($ICEC_AA)?></font></td>
		<?php
            for ($i = 66; $i <=70; $i++) {
				if($i==66)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($ICEC_MBFE)?></font></td>
		<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="239" sdnum="1033;"><font face="Arial"></font></td>
		<td align="center" valign=middle sdval="71439" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Matériel informatique</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($MI_MBDE)?></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($MI_AA)?></font></td>
		<?php
            for ($i = 71; $i <=75; $i++) {
				if($i==71)
				{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 219px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}
				else{
					echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><input required min="0" type="text" required style="width: 85px;" name="immobilisationFinancieres' . $i . '" id="immobilisationFinancieres' . $i . '" value="';
					if (isset(${"immobilisationFinancieres" . $i})) {
						echo ${"immobilisationFinancieres" . $i};
					}
					echo '" /><br></font></td>' . "\n";
				}  
            }                 
        ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($MI_MBFE)?></font></td>
		<td align="center" valign=middle sdval="2355" sdnum="1033;"><font face="Arial Narrow"></font></td>
		<td align="center" valign=middle sdval="714391" sdnum="1033;"><font face="Arial Narrow"></font></td>

	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="34" align="center" valign=middle><b><font face="Calibri" size=3>Total</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3><?php readMontant($T_MBDE)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3><?php readMontant($T_AA)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3><?php readMontant($T_APPLPEM)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3><?php readMontant($T_AV)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3><?php readMontant($T_DC)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3><?php readMontant($T_DR)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3><?php readMontant($T_DV)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3><?php readMontant($T_MBFE)?></font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=3><br></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" size=3><br></font></td>

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
