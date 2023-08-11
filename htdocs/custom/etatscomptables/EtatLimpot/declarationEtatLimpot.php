
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
            for ($i = 0; $i <= 29; $i++) {
                ${'Etatlimpot' . $i} = $_POST['Etatlimpot' . $i];
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
        print '<input type="hidden" name="model" value="Etatlimpot">';
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
        $filedir = DOL_DATA_ROOT . '/billanLaisse/Etatlimpot/';
        $urlsource = $_SERVER['PHP_SELF'] . '';
        $genallowed = 0;
        $delallowed = 1;
        $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

        if ($societe !== null && isset($societe->default_lang)) {
            print $formfile->showdocuments('Etatlimpot', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
        } else {
            print $formfile->showdocuments('Etatlimpot', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
        }

        }
        // Actions to build doc
        $action = GETPOST('action', 'aZ09');
        $upload_dir = DOL_DATA_ROOT . '/billanLaisse/Etatlimpot/';
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
	<meta name="created" content="2023-06-19T10:20:37"/>
	<meta name="changedby" content="Microsoft Office User"/>
	<meta name="changed" content="2023-06-19T10:21:00"/>
	<meta name="AppVersion" content="16.0300"/>
	
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Calibri"; font-size:small }
		a.comment-indicator:hover + comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em;  } 
		a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em;  } 
		comment { display:none;  } 
	</style>
	
</head>

<body>
<center>
<form method="POST" action="confirmEtatLimpot.php">
<table cellspacing="0" border="0">
	<colgroup width="31"></colgroup>
	<colgroup width="415"></colgroup>
	<colgroup width="89"></colgroup>
	<colgroup width="107"></colgroup>
      <center>
        <input type="date" name="Etatlimpot29"  id="Etatlimpot29" value="<?php if(isset($Etatlimpot29)){ echo $Etatlimpot29;} ?>"  placeholder ="Année" required style="margin-top: 18px;font-size:95%; background: #ededed; font-weight:bolder; padding: 8px 15px 8px 15px; border: block; ">
        <input type="hidden" name="check"  value="true">
        </center>
	<tr>
		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=4 height="48" align="center" valign=bottom><b><font size=4>ETAT POUR LE CALCUL DE L'IMPOT SUR LES SOCIETES -<br>ENTREPRISES ENCOURAGEES</font></b></td>
		</tr>
	<tr>
		<td height="34" align="right" valign=middle sdval="0" sdnum="1033;"><b><font size=2></font></b></td>
		<td align="left" valign=middle><font size=2><br></font></td>
		<td align="left" valign=middle><font size=2><br></font></td>
		<td align="right" valign=middle><b><font size=2></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="20" align="center" valign=top bgcolor="#D9D9D9"><b><font size=2>Nature des Produits</font></b></td>
		<td style="border-top: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top bgcolor="#D9D9D9"><b><font size=2>Taux</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top bgcolor="#D9D9D9"><b><font size=2>Montant</font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 height="20" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font size=2>1</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font size=2>2</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font size=2>3</font></i></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle sdval="1" sdnum="1033;"><b><font size=2>1</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><b><font size=2>CA taxable</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot0" id="Etatlimpot0"  value="<?php if(isset($Etatlimpot0)){ echo $Etatlimpot0;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle sdval="2" sdnum="1033;"><b><font size=2>2</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><b><font size=2>CA exonéré à 100%</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot1" id="Etatlimpot1"  value="<?php if(isset($Etatlimpot1)){ echo $Etatlimpot1;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle sdval="3" sdnum="1033;"><b><font size=2>3</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><b><font size=2>CA soumis au taux réduit</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0.00%"><b><font size=2><input type="text" min="0"  style="width: 100.71111038pt;" name="Etatlimpot2" id="Etatlimpot2"  value="<?php if(isset($Etatlimpot2)){ echo $Etatlimpot2;} ?>"  placeholder=" " required " /><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><b><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot3" id="Etatlimpot3"  value="<?php if(isset($Etatlimpot3)){ echo $Etatlimpot3;} ?>"  placeholder="0" required " /><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#A4ABB7" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><input type="text" min="0"  style="width: 100.71111038pt;" name="Etatlimpot4" id="Etatlimpot4"  value="<?php if(isset($Etatlimpot4)){ echo $Etatlimpot4;} ?>"  placeholder="" required " /><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot5" id="Etatlimpot5"  value="<?php if(isset($Etatlimpot5)){ echo $Etatlimpot5;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#A4ABB7" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><input type="text" min="0"  style="width: 100.71111038pt;" name="Etatlimpot6" id="Etatlimpot6"  value="<?php if(isset($Etatlimpot6)){ echo $Etatlimpot6;} ?>"  placeholder=" " required " /><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot7" id="Etatlimpot7"  value="<?php if(isset($Etatlimpot7)){ echo $Etatlimpot7;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#A4ABB7" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><input type="text" min="0"  style="width: 100.71111038pt;" name="Etatlimpot8" id="Etatlimpot8"  value="<?php if(isset($Etatlimpot8)){ echo $Etatlimpot8;} ?>"  placeholder="" required " /><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot9" id="Etatlimpot9"  value="<?php if(isset($Etatlimpot9)){ echo $Etatlimpot9;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#A4ABB7" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><input type="text" min="0"  style="width: 100.71111038pt;" name="Etatlimpot10" id="Etatlimpot10"  value="<?php if(isset($Etatlimpot10)){ echo $Etatlimpot10;} ?>"  placeholder="" required " /><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot11" id="Etatlimpot11"  value="<?php if(isset($Etatlimpot11)){ echo $Etatlimpot11;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#A4ABB7" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><input type="text" min="0"  style="width: 100.71111038pt;" name="Etatlimpot12" id="Etatlimpot12"  value="<?php if(isset($Etatlimpot12)){ echo $Etatlimpot12;} ?>"  placeholder=" " required " /><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot13" id="Etatlimpot13"  value="<?php if(isset($Etatlimpot13)){ echo $Etatlimpot13;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle sdval="4" sdnum="1033;"><b><font size=2>4</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><b><font size=2>Autres produits taxables</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><b><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot14" id="Etatlimpot14"  value="<?php if(isset($Etatlimpot14)){ echo $Etatlimpot14;} ?>"  placeholder="0" required " /><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font size=2>Autres produits d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot15" id="Etatlimpot15"  value="<?php if(isset($Etatlimpot15)){ echo $Etatlimpot15;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font size=2>Produits financiers</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot16" id="Etatlimpot16"  value="<?php if(isset($Etatlimpot16)){ echo $Etatlimpot16;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font size=2>Subventions</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot17" id="Etatlimpot17"  value="<?php if(isset($Etatlimpot17)){ echo $Etatlimpot17;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3"><font size=2><input type="text" min="0"  style="width: 300.71111038pt;" name="Etatlimpot18" id="Etatlimpot18"  value="<?php if(isset($Etatlimpot18)){ echo $Etatlimpot18;} ?>"  placeholder=" " required " /><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot19" id="Etatlimpot19"  value="<?php if(isset($Etatlimpot19)){ echo $Etatlimpot19;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3"><font size=2><input type="text" min="0"  style="width: 300.71111038pt;" name="Etatlimpot20" id="Etatlimpot20"  value="<?php if(isset($Etatlimpot20)){ echo $Etatlimpot20;} ?>"  placeholder=" " required " /><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot21" id="Etatlimpot21"  value="<?php if(isset($Etatlimpot21)){ echo $Etatlimpot21;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3"><font size=2><input type="text" min="0"  style="width: 300.71111038pt;" name="Etatlimpot22" id="Etatlimpot22"  value="<?php if(isset($Etatlimpot22)){ echo $Etatlimpot22;} ?>"  placeholder=" " required " /><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot23" id="Etatlimpot23"  value="<?php if(isset($Etatlimpot23)){ echo $Etatlimpot23;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3"><font size=2><input type="text" min="0"  style="width: 300.71111038pt;" name="Etatlimpot24" id="Etatlimpot24"  value="<?php if(isset($Etatlimpot24)){ echo $Etatlimpot24;} ?>"  placeholder=" " required " /><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot25" id="Etatlimpot25"  value="<?php if(isset($Etatlimpot25)){ echo $Etatlimpot25;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3"><font size=2><input type="text" min="0"  style="width: 300.71111038pt;" name="Etatlimpot26" id="Etatlimpot26"  value="<?php if(isset($Etatlimpot26)){ echo $Etatlimpot26;} ?>"  placeholder=" " required " /><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot27" id="Etatlimpot27"  value="<?php if(isset($Etatlimpot27)){ echo $Etatlimpot27;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>
	<!-- <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle sdval="5" sdnum="1033;"><b><font size=2>5</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><b><font size=2>Dénominateur (1 + 2 + 3 + 4)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
	</tr> -->
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="center" valign=middle sdval="6" sdnum="1033;"><b><font size=2>6</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><b><font size=2>Montant de l'impôt sur les sociétés (IS) dû</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#C0C0C0" sdnum="1033;0;0.00%"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><input type="number" min="0"  style="width: 100.71111038pt;" name="Etatlimpot28" id="Etatlimpot28"  value="<?php if(isset($Etatlimpot28)){ echo $Etatlimpot28;} ?>"  placeholder="0" required " /><br></font></td>
	</tr>

</table>
<!-- ************************************************************************** -->
</body>
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
</html>
