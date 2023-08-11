<?php
// Load Dolibarr environment
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
llxHeader("", "");



$returnpage=GETPOST('model');




if($returnpage=="TitresParticipation")
{ 
    $url = DOL_URL_ROOT . '/custom/etatscomptables/TitresParticipation/declarationTitresParticipation.php';
    echo"<script>window.location.href='$url';</script>";
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check=$_POST['check']??'';
    if( $check == 'true')
    {
    
    // Retrieve the form data
    for ($i = 0; $i <= 154; $i++) {
        ${'Participation' . $i} = $_POST['Participation' . $i];
    }

    $sum1=$Participation3+$Participation14+$Participation25+$Participation36+$Participation47+$Participation58+$Participation69+$Participation80+$Participation91+$Participation102+$Participation113+$Participation124+ $Participation135+$Participation146;
    $sum2=$Participation5+$Participation16+$Participation27+$Participation38+$Participation49+$Participation60+$Participation71+$Participation82+$Participation93+$Participation104+$Participation115+$Participation126+ $Participation137+$Participation148;
    $sum3=$Participation6+$Participation17+$Participation28+$Participation39+$Participation50+$Participation61+$Participation72+$Participation83+$Participation94+$Participation105+$Participation116+$Participation127+ $Participation138+$Participation149;
    $sum4=$Participation8+$Participation19+$Participation30+$Participation41+$Participation52+$Participation63+$Participation74+$Participation85+$Participation96+$Participation107+$Participation118+$Participation129+ $Participation140+$Participation151;
    $sum5=$Participation9+$Participation20+$Participation31+$Participation42+$Participation53+$Participation64+$Participation75+$Participation86+$Participation97+$Participation108+$Participation119+$Participation130+ $Participation141+$Participation152;
    $sum6=$Participation10+$Participation21+$Participation32+$Participation43+$Participation54+$Participation65+$Participation76+$Participation87+$Participation98+$Participation109+$Participation120+$Participation131+ $Participation142+$Participation153;



    $data = "<?php ";

    $selectedDate = new DateTime($Participation154);
    $year = $selectedDate->format('Y');

    for ($i = 0; $i <= 154; $i++) {
        ${'Participation' . $i} = $_POST['Participation' . $i];
      
        if (${'Participation' . $i} == $Participation154) {
            $data .= '$Participation' . $i . ' = ' . $year . ";\n";
        }else   if (is_string(${'Participation' . $i})) {
            // If the value is a string, add double quotes around it
            $data .= '$Participation' . $i . ' = "' . ${'Participation' . $i} . "\";\n";
        }
        else {
            $data .= '$Participation' . $i . ' = ' . ${'Participation' . $i} . ";\n";
        }
    }

    $data .= '$sum1 = ' . $sum1 . ";\n";
    $data .= '$sum2 = ' . $sum2 . ";\n";
    $data .= '$sum3 = ' . $sum3 . ";\n";
    $data .= '$sum4 = ' . $sum4 . ";\n";
    $data .= '$sum5 = ' . $sum5 . ";\n";
    $data .= '$sum6 = ' . $sum6 . ";\n"; 
    $data .= "?>";

    $nomFichier = 'TitresParticipation_fichier_'. $year.'.php';
    file_put_contents($nomFichier, $data);

}
}





$object = new User($db);
$id=$user->id;


function GenerateDocuments($year)
{
  global $day, $month, $year, $start, $prev_year;
  print '<form id="frmgen" name="builddoc" method="post">';
  print '<input type="hidden" name="token" value="' . newToken() . '">';
  print '<input type="hidden" name="action" value="builddoc">';
  print '<input type="hidden" name="model" value="TitresParticipation">';
  print '<input type="hidden" name="year" value="'.$year.'">';
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
    $filedir = DOL_DATA_ROOT . '/billanLaisse/TitresParticipation/';
    $urlsource = $_SERVER['PHP_SELF'] . '';
    $genallowed = 0;
    $delallowed = 1;
    $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

 

  if ($societe !== null && isset($societe->default_lang)) {
    print $formfile->showdocuments('TitresParticipation', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
  } else {
      print $formfile->showdocuments('TitresParticipation', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
  }

}


// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/TitresParticipation/';
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
	<meta name="created" content="2023-06-19T09:34:48"/>
	<meta name="changedby" content="Microsoft Office User"/>
	<meta name="changed" content="2023-06-19T09:35:54"/>
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
    <form method="POST" action="declarationTitresParticipation.php">
    <?php
    // Loop to create the hidden input fields
    for ($i = 0; $i <= 154; $i++) {
        $Participation = ${'Participation' . $i};
        echo '<input type="hidden" name="Participation' . $i . '" value="' . $Participation . '" />';
    }
    ?>     
    <div>
        <p style="display: inline; margin-top: 10px; font-size: 16px; color: black;">Confirmer :</p>
        <label for="oui">Oui</label>
        <input type="radio" name="sitec" id="oui" value="oui" required>
        <label for="non">Non</label>                    
        <input type="radio" name="sitec" id="non" value="non" required>

        <!-- Code block for "non" option -->
        <div id="nonBlock" style="display: none;">
            <button type="submit" name="chargement" style="margin-top: 18px; background: #4B99AD; padding: 8px 15px; border: none; color: #fff;">Modifier</button><br>
        </div>
    </div>
    </form>

    <!-- Code block for "oui" option -->
    <div id="ouiBlock" style="display: none;">
        <!-- PHP code -->
        <center>
            <?php GenerateDocuments($year); ?>
        </center>
    </div>

    <script>
        // Function to toggle the display of ouiBlock and nonBlock based on the selected radio button
        function toggleDisplay() {
            var ouiBlock = document.getElementById('ouiBlock');
            var nonBlock = document.getElementById('nonBlock');
            var ouiRadio = document.getElementById('oui');

            if (ouiRadio.checked) {
                ouiBlock.style.display = 'block';
                nonBlock.style.display = 'none';
            } else {
                ouiBlock.style.display = 'none';
                nonBlock.style.display = 'block';
            }
        }

        // Attach the toggleDisplay function to the click event of the radio buttons
        document.getElementById('oui').addEventListener('click', toggleDisplay);
        document.getElementById('non').addEventListener('click', toggleDisplay);
    </script>
<table cellspacing="0" border="0">
	<colgroup width="175"></colgroup>
	<colgroup width="84"></colgroup>
	<colgroup width="127"></colgroup>
	<colgroup width="107"></colgroup>
	<colgroup width="73"></colgroup>
	<colgroup span="2" width="107"></colgroup>
	<colgroup width="73"></colgroup>
	<colgroup span="2" width="107"></colgroup>
	<colgroup width="87"></colgroup>
	<tr>
		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=11 height="26" align="center" valign=middle><b><font size=4>TABLEAU DES TITRES DE PARTICIPATION</font></b></td>
		</tr>
	<tr>
		<td height="20" align="left" valign=middle><b><font size=2><br></font></b></td>
		<td align="left" valign=middle><b><font size=2><br></font></b></td>
		<td align="left" valign=middle><font size=2><br></font></td>
		<td align="left" valign=middle><font size=2><br></font></td>
		<td align="left" valign=middle><font size=2><br></font></td>
		<td align="left" valign=middle><font size=2><br></font></td>
		<td align="left" valign=middle><font size=2><br></font></td>
		<td align="left" valign=middle><font size=2><br></font></td>
		<td align="left" valign=middle><font size=2><br></font></td>
		<td align="left" valign=middle><b><font size=2><br></font></b></td>
		<td align="right" valign=middle><b><font size=2></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 height="58" align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>Raison sociale de la société émettrice</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>IF</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>Secteur d'activité</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>Capital social</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>Participation  au capital en %</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>Prix d'acquisition global</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>Valeur comptable nette</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=top bgcolor="#D9D9D9"><b><font size=2>  Extrait des derniers états de synthèse de la société émettrice</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>Produits inscrits au C.P.C de l'exercice</font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top bgcolor="#D9D9D9"><b><font size=2>Date de cloture</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top bgcolor="#D9D9D9"><b><font size=2>Situation nette</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top bgcolor="#D9D9D9"><b><font size=2>Résultat net</font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2 color="#FFFFFF">Raison</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2 color="#FFFFFF">IF</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font size=2>1</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font size=2>2</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font size=2>3</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font size=2>4</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font size=2>5</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font size=2>6</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font size=2>7</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font size=2>8</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font size=2>9</font></i></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation0;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation1;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation2;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation3;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation4;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation5;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation6;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation7;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation8;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation9;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation10;?><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation11;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation12;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation13;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation14;?><br></font></td> 
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation15;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation16;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation17;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation18;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation19;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation20;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation21;?><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation22;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation23;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation24;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation25;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation26;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation27;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation28;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation29;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation30;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation31;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation32;?><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation33;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation34;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation35;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation36;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation37;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation38;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation39;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation40;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation41;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation42;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation43;?><br></font></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation44;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation45;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation46;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation47;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation48;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation49;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation50;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation51;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation52;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation53;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation54;?><br></font></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation55;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation56;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation57;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation58;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation59;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation60;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation61;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation62;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation63;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation64;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation65;?><br></font></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation66;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation67;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation68;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation69;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation70;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation71;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation72;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation73;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation74;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation75;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation76;?><br></font></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation77;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation78;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation79;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation80;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation81;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation82;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation83;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation84;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation85;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation86;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation87;?><br></font></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation88;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation89;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation90;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation91;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation92;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation93;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation94;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation95;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation96;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation97;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation98;?><br></font></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation99;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation100;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation101;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation102;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation103;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation104;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation105;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation106;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation107;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation108;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation109;?><br></font></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation110;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation111;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation112;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation113;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation114;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation115;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation116;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation117;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation118;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation119;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation120;?><br></font></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation121;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation122;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation123;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation124;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation125;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation126;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation127;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation128;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation129;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation130;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation131;?><br></font></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation132;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation133;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation134;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation135;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation136;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation137;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation138;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation139;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation140;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation141;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation142;?><br></font></td>
	</tr>
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation143;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation144;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3"><font size=2><?php echo $Participation145;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation146;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;0.00%"><font size=2><?php echo $Participation147;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation148;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation149;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;M/D/YYYY"><font size=2><?php echo $Participation150;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation151;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation152;?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font size=2><?php echo $Participation153;?><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="21" align="center" valign=middle sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="center" valign=middle sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;#,##0.00"><b>Total</b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php echo $sum1;?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;#,##0.00"><b><font size=2>-</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php echo $sum2;?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php echo $sum3;?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;#,##0.00"><b><font size=2>-</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php echo $sum4;?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php echo $sum5;?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2><?php echo $sum6;?></font></b></td>
	</tr>
</table>
<!-- ************************************************************************** -->
</center>
</body>

</html>
