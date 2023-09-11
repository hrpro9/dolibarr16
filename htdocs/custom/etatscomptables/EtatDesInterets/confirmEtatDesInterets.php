<?php
// Load Dolibarr environment
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
llxHeader("", ""); 


$returnpage=GETPOST('model');
if($returnpage=="Etatdesinterets")
{ 
    $url = DOL_URL_ROOT . '/custom/etatscomptables/EtatDesInterets/declarationEtatDesInterets.php';
    echo"<script>window.location.href='$url';</script>";
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $check=$_POST['check']??'';
  if( $check == 'true')
  {
    // Retrieve the form data
    for ($i = 0; $i <= 181; $i++) {
        ${'etatDesInterets' . $i} = $_POST['etatDesInterets' . $i];
    }

    // $sum1=$etatDesInterets9+$etatDesInterets25+$etatDesInterets40+$etatDesInterets55+$etatDesInterets70+$etatDesInterets85+$etatDesInterets100
    // +$etatDesInterets115+$etatDesInterets130+$etatDesInterets145+$etatDesInterets160+$etatDesInterets175;
    // $sum2=$etatDesInterets10+$etatDesInterets26+$etatDesInterets41+$etatDesInterets56+$etatDesInterets71+$etatDesInterets86+$etatDesInterets101
    // +$etatDesInterets116+$etatDesInterets131+$etatDesInterets146+$etatDesInterets161+$etatDesInterets176;
    // $sum3=$etatDesInterets11+$etatDesInterets27+$etatDesInterets42+$etatDesInterets57+$etatDesInterets72+$etatDesInterets87+$etatDesInterets102
    // +$etatDesInterets117+$etatDesInterets132+$etatDesInterets147+$etatDesInterets162+$etatDesInterets177;
    // $sum4=$etatDesInterets12+$etatDesInterets28+$etatDesInterets43+$etatDesInterets58+$etatDesInterets73+$etatDesInterets88+$etatDesInterets103
    // +$etatDesInterets118+$etatDesInterets133+$etatDesInterets148+$etatDesInterets163+$etatDesInterets178;
    // $sum5=$etatDesInterets14+$etatDesInterets29+$etatDesInterets44+$etatDesInterets59+$etatDesInterets74+$etatDesInterets89+$etatDesInterets104
    // +$etatDesInterets119+$etatDesInterets134+$etatDesInterets149+$etatDesInterets164+$etatDesInterets179;

    // $sum6=$etatDesInterets5+$etatDesInterets21+$etatDesInterets36+$etatDesInterets51+$etatDesInterets66+$etatDesInterets81+$etatDesInterets96
    // +$etatDesInterets111+$etatDesInterets126+$etatDesInterets141+$etatDesInterets156+$etatDesInterets171;

    $sum1=INTVAL($etatDesInterets9) +INTVAL($etatDesInterets25) +INTVAL($etatDesInterets40) +INTVAL($etatDesInterets55) +INTVAL($etatDesInterets70) +INTVAL($etatDesInterets85) +INTVAL($etatDesInterets100
    ) +INTVAL($etatDesInterets115) +INTVAL($etatDesInterets130) +INTVAL($etatDesInterets145) +INTVAL($etatDesInterets160) +INTVAL($etatDesInterets175);
   $sum2=INTVAL($etatDesInterets10) +INTVAL($etatDesInterets26) +INTVAL($etatDesInterets41) +INTVAL($etatDesInterets56) +INTVAL($etatDesInterets71) +INTVAL($etatDesInterets86) +INTVAL($etatDesInterets101
    ) +INTVAL($etatDesInterets116) +INTVAL($etatDesInterets131) +INTVAL($etatDesInterets146) +INTVAL($etatDesInterets161) +INTVAL($etatDesInterets176);
    $sum3=INTVAL($etatDesInterets11) +INTVAL($etatDesInterets27) +INTVAL($etatDesInterets42) +INTVAL($etatDesInterets57) +INTVAL($etatDesInterets72) +INTVAL($etatDesInterets87) +INTVAL($etatDesInterets102
    ) +INTVAL($etatDesInterets117) +INTVAL($etatDesInterets132) +INTVAL($etatDesInterets147) +INTVAL($etatDesInterets162) +INTVAL($etatDesInterets177);
    $sum4=INTVAL($etatDesInterets12) +INTVAL($etatDesInterets28) +INTVAL($etatDesInterets43) +INTVAL($etatDesInterets58) +INTVAL($etatDesInterets73) +INTVAL($etatDesInterets88) +INTVAL($etatDesInterets103
    ) +INTVAL($etatDesInterets118) +INTVAL($etatDesInterets133) +INTVAL($etatDesInterets148) +INTVAL($etatDesInterets163) +INTVAL($etatDesInterets178);
    $sum5=INTVAL($etatDesInterets14) +INTVAL($etatDesInterets29) +INTVAL($etatDesInterets44) +INTVAL($etatDesInterets59) +INTVAL($etatDesInterets74) +INTVAL($etatDesInterets89) +INTVAL($etatDesInterets104
    ) +INTVAL($etatDesInterets119) +INTVAL($etatDesInterets134) +INTVAL($etatDesInterets149) +INTVAL($etatDesInterets164) +INTVAL($etatDesInterets179);

   $sum6=INTVAL($etatDesInterets5) +INTVAL($etatDesInterets21) +INTVAL($etatDesInterets36) +INTVAL($etatDesInterets51) +INTVAL($etatDesInterets66) +INTVAL($etatDesInterets81) +INTVAL($etatDesInterets96
    ) +INTVAL($etatDesInterets111) +INTVAL($etatDesInterets126) +INTVAL($etatDesInterets141) +INTVAL($etatDesInterets156) +INTVAL($etatDesInterets171);


    $data = "<?php ";

    for ($i = 0; $i <= 181; $i++) {
        ${'etatDesInterets' . $i} = $_POST['etatDesInterets' . $i];
        if(${'etatDesInterets' . $i}==$etatDesInterets181)
        {

            $selectedDate = new DateTime($etatDesInterets181);
            $year = $selectedDate->format('Y');
            $data .= '$etatDesInterets' . $i . ' = ' . $year . ";\n";   

        }
        else if (is_string(${'etatDesInterets' . $i})) {
            // If the value is a string, add double quotes around it
            $data .= '$etatDesInterets' . $i . ' = "' . ${'etatDesInterets' . $i} . "\";\n";
        }
        else {
            $data .= '$etatDesInterets' . $i . ' = ' . ${'etatDesInterets' . $i} . ";\n";  
        }
      
    }
    $data .= '$sum1 = ' . $sum1 . ";\n";
    $data .= '$sum2 = ' . $sum2 . ";\n";
    $data .= '$sum3 = ' . $sum3 . ";\n";
    $data .= '$sum4 = ' . $sum4 . ";\n";
    $data .= '$sum5 = ' . $sum5 . ";\n";
    $data .= '$sum6 = ' . $sum6 . ";\n";
    $data .= "?>";
    $selectedDate = new DateTime($etatDesInterets181);
    $year = $selectedDate->format('Y'); // Extract the year value
    // Now, the variable $year will contain the year value "2023"
    $nomFichier = 'etatDesInterets_fichier_'. $year.'.php';
    // Écrire les données dans le nouveau fichier
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
  print '<input type="hidden" name="model" value="Etatdesinterets">';
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
  $filedir = DOL_DATA_ROOT . '/billanLaisse/Etatdesinterets/';
  $urlsource = $_SERVER['PHP_SELF'] . '';
  $genallowed = 0;
  $delallowed = 1;
  $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

 

  if ($societe !== null && isset($societe->default_lang)) {
    print $formfile->showdocuments('Etatdesinterets', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
  } else {
    print $formfile->showdocuments('Etatdesinterets', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
  }

}


// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/Etatdesinterets/';
$permissiontoadd = 1;
$donotredirect = 1;

include DOL_DOCUMENT_ROOT . '/core/actions_builddoc.inc.php';



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="generator" content="PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet">
      <meta name="author" content="Microsoft Office User" />
    <style type="text/css">
      html { font-family:Calibri, Arial, Helvetica, sans-serif; font-size:11pt; background-color:white }
      a.comment-indicator:hover + div.comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em }
      a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em }
      div.comment { display:none }
      table { border-collapse:collapse; page-break-after:always }
      .gridlines td { border:1px dotted black }
      .gridlines th { border:1px dotted black }
      .b { text-align:center }
      .e { text-align:center }
      .f { text-align:right }
      .inlineStr { text-align:left }
      .n { text-align:right }
      .s { text-align:left }
      td.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      th.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      td.style1 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style1 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style2 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style2 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style3 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style3 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style4 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style4 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style5 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style5 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style6 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style6 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style8 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style8 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style9 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style9 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style10 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      th.style10 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      td.style11 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style11 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style12 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style12 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style13 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style13 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style14 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style14 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style15 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:9pt; background-color:#D8D8D8 }
      th.style15 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:9pt; background-color:#D8D8D8 }
      td.style16 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style16 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style17 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style17 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style18 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style18 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style19 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style19 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style20 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style20 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style21 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:9pt; background-color:#D8D8D8 }
      th.style21 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:9pt; background-color:#D8D8D8 }
      td.style22 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style22 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style23 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; text-decoration:underline; font-style:italic; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style23 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; text-decoration:underline; font-style:italic; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style24 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; text-decoration:underline; font-style:italic; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style24 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; text-decoration:underline; font-style:italic; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style25 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style25 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style26 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style26 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style27 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style27 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style28 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style28 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style29 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style29 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style30 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style30 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style31 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style31 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style32 { vertical-align:top; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style32 { vertical-align:top; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style33 { vertical-align:top; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style33 { vertical-align:top; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style34 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; text-decoration:underline; font-style:italic; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style34 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; text-decoration:underline; font-style:italic; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style35 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style35 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style36 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style36 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style37 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style37 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style38 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style38 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style39 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style39 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style40 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style40 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style41 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style41 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style42 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style42 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style43 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style43 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      table.sheet0 col.col0 { width:91.49999895pt }
      table.sheet0 col.col1 { width:91.49999895pt }
      table.sheet0 col.col2 { width:83.36666571pt }
      table.sheet0 col.col3 { width:41.34444397pt }
      table.sheet0 col.col4 { width:41.34444397pt }
      table.sheet0 col.col5 { width:50.83333275pt }
      table.sheet0 col.col6 { width:121.32222083pt }
      table.sheet0 col.col7 { width:96.92222111pt }
      table.sheet0 col.col8 { width:31.17777742pt }
      table.sheet0 col.col9 { width:50.83333275pt }
      table.sheet0 col.col10 { width:50.83333275pt }
      table.sheet0 col.col11 { width:50.83333275pt }
      table.sheet0 col.col12 { width:50.83333275pt }
      table.sheet0 col.col13 { width:50.83333275pt }
      table.sheet0 col.col14 { width:49.47777721pt }
      table.sheet0 col.col15 { width:0pt }
      table.sheet0 col.col16 { width:49.47777721pt }
      table.sheet0 .column15 { visibility:collapse; display:none }
      table.sheet0 tr { height:13.636363636364pt }
      table.sheet0 tr.row0 { height:36pt }
      table.sheet0 tr.row1 { height:26.25pt }
      table.sheet0 tr.row2 { height:25.5pt }
      table.sheet0 tr.row3 { height:25.5pt }
      table.sheet0 tr.row4 { height:12.75pt }
      table.sheet0 tr.row5 { height:18.75pt }
      table.sheet0 tr.row6 { height:18.75pt }
      table.sheet0 tr.row7 { height:18.75pt }
      table.sheet0 tr.row8 { height:18.75pt }
      table.sheet0 tr.row9 { height:18.75pt }
      table.sheet0 tr.row10 { height:12.75pt }
      table.sheet0 tr.row11 { height:18.75pt }
      table.sheet0 tr.row12 { height:18.75pt }
      table.sheet0 tr.row13 { height:18.75pt }
      table.sheet0 tr.row14 { height:18.75pt }
      table.sheet0 tr.row15 { height:18.75pt }
      table.sheet0 tr.row16 { height:21pt }
    </style>
  </head>

  <body>
  <center>
<form method="POST" action="declarationEtatDesInterets.php">
    <?php
    // Loop to create the hidden input fields
    for ($i = 0; $i <= 181; $i++) {
        $etatDesInterets = ${'etatDesInterets' . $i};
      echo '<input type="hidden" name="etatDesInterets' . $i . '" value="' . $etatDesInterets . '" />';
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
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0">
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <col class="col7">
        <col class="col8">
        <col class="col9">
        <col class="col10">
        <col class="col11">
        <col class="col12">
        <col class="col13">
        <col class="col14">
        <col class="col15">
        <col class="col16">
        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style4" colspan="15">ETAT DES INTERETS DES EMPRUNTS CONTRACTES AUPRES DES ASSOCIES ET DES TIERS<br />
AUTRES QUE LES ORGANISMES DE BANQUE OU DE CREDIT</td>
            <td class="column15 style5 null"></td>
   
          </tr>
          <tr class="row1">
            <td class="column0 style7 f"></td>
            <td class="column1 style7 null"></td>
            <td class="column2 style8 null"></td>
            <td class="column3 style8 null"></td>
            <td class="column4 style8 null"></td>
            <td class="column5 style9 s"></td>
            <td class="column6 style10 f"></td>
            <td class="column7 style8 null"></td>
            <td class="column8 style8 null"></td>
            <td class="column9 style8 null"></td>
            <td class="column10 style8 null"></td>
            <td class="column11 style11 null"></td>
            <td class="column12 style11 null"></td>
            <td class="column13 style8 null"></td>
            <td class="column14 style12 f"></td>
            <td class="column15 style8 null"></td>
   
          </tr>
          <tr class="row2">
            <td class="column0 style14 s style20" rowspan="2">Nom et prénoms</td>
            <td class="column1 style14 s style20" rowspan="2">Raison sociale</td>
            <td class="column2 style14 s style20" rowspan="2">Adresse</td>
            <td class="column3 style14 s style20" rowspan="2">IF</td>
            <td class="column4 style14 s style20" rowspan="2">N° CIN</td>
            <td class="column5 style14 s style20" rowspan="2">Montant du prêt</td>
            <td class="column6 style14 s style20" rowspan="2">Date du prêt</td>
            <td class="column7 style15 s style21" rowspan="2">Durée du prêt en mois</td>
            <td class="column8 style14 s style20" rowspan="2">Taux d'intérêt annuel</td>
            <td class="column9 style14 s style20" rowspan="2">Charge financière globale</td>
            <td class="column10 style16 s style17" colspan="2">Remboursement exercices antérieurs</td>
            <td class="column12 style16 s style17" colspan="2">Remboursement exercice actuel</td>
            <td class="column14 style14 s style20" rowspan="2">Observations</td>
            <td class="column15 style18 null"></td>
   
          </tr>
          <tr class="row3">
            <td class="column10 style22 s">Principal</td>
            <td class="column11 style22 s">Intérêt</td>
            <td class="column12 style22 s">Principal</td>
            <td class="column13 style22 s">Intérêt</td>
            <td class="column15 style18 null"></td>
   
          </tr>
          <tr class="row4">
          <?php
                for ($i = 0; $i <= 15; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'etatDesInterets' . $i}.'</td>' . "\n";
                }
            ?>
   
          </tr>
          <tr class="row5">
          <?php
                for ($i = 16; $i <= 30; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'etatDesInterets' . $i}.'</td>' . "\n";
                }
            ?>
   
          </tr>
          <tr class="row6">
          <?php
                for ($i = 31; $i <= 45; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'etatDesInterets' . $i}.'</td>' . "\n";
                }
            ?>
   
          </tr>
          <tr class="row7">
       <?php
                for ($i = 46; $i <= 60; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'etatDesInterets' . $i}.'</td>' . "\n";
                }
            ?>
          </tr>
          <tr class="row8">
          <?php
                for ($i = 61; $i <= 75; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'etatDesInterets' . $i}.'</td>' . "\n";
                }
            ?>
          </tr>
        <tr class="row9">
           <?php
                for ($i = 76; $i <= 90; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'etatDesInterets' . $i}.'</td>' . "\n";
                }
            ?>
          </tr>
           <tr class="row10">
           <?php
                for ($i = 91; $i <= 105; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'etatDesInterets' . $i}.'</td>' . "\n";
                }
            ?>
          </tr>
          <tr class="row11">
          <?php
                for ($i = 106; $i <= 120; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'etatDesInterets' . $i}.'</td>' . "\n";
                }
            ?>
          </tr>
          <tr class="row12">
          <?php
                for ($i = 121; $i <= 135; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'etatDesInterets' . $i}.'</td>' . "\n";
                }
            ?>
          </tr>
           <tr class="row13">
           <?php
                for ($i = 136; $i <= 150; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'etatDesInterets' . $i}.'</td>' . "\n";
                }
            ?>
          </tr>
          <tr class="row14">
          <?php
                for ($i = 151; $i <= 165; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'etatDesInterets' . $i}.'</td>' . "\n";
                }
            ?>
          </tr>
          <tr class="row15">
          <?php
                for ($i = 166; $i <= 180; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'etatDesInterets' . $i}.'</td>' . "\n";
                }
            ?>
          </tr>
          <tr class="row16">
            <td class="column0 style36 null"></td>
            <td class="column1 style37 null"></td>
            <td class="column2 style38 s">Total</td>
            <td class="column3 style39 null"></td>
            <td class="column4 style39 null"></td>
            <td class="column5 style40 f"><?php echo $sum6;?></td>
            <td class="column6 style41 null"></td>
            <td class="column7 style41 null"></td>
            <td class="column8 style41 null"></td>
            <td class="column9 style40 f"><?php echo $sum1;?></td>
            <td class="column10 style40 f"><?php echo $sum2;?></td>
            <td class="column11 style40 f"><?php echo $sum3;?></td>
            <td class="column12 style40 f"><?php echo $sum4;?></td>
            <td class="column13 style40 f"><?php echo $sum5;?></td>
            <td class="column14 style41 null"></td>
     
           
          </tr> 
        </tbody>
    </table>
  </center>
  </body>
</html>
