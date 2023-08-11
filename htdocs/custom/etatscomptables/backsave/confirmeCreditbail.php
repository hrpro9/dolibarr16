<?php
// Load Dolibarr environment
require_once '../../main.inc.php';
require_once '../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
llxHeader("", ""); 

$returnpage=GETPOST('model');

if($returnpage=="CreditBail")
{ 
    $url = DOL_URL_ROOT . '/custom/etatscomptables/declarationCreditBail.php';
    echo"<script>window.location.href='$url';</script>";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the form data
  
  $check=$_POST['check']??'';
  if( $check == 'true')
  {

    for ($i = 0; $i <= 198; $i++) {
        ${'valeur' . $i} = $_POST['valeur' . $i];
      }
      
    
      $sum = $valeur3 +  $valeur14 +$valeur25+ $valeur36+$valeur47+ $valeur58 + $valeur69+$valeur80+  $valeur91+$valeur102 +$valeur113+$valeur124+$valeur135+$valeur146+$valeur157+ $valeur168 +$valeur179 +  $valeur190;
      $sum1 =  $valeur5 + $valeur16+ $valeur27 + $valeur38+$valeur49+ $valeur60 + $valeur71+$valeur82+  $valeur84+$valeur104 +$valeur115+$valeur126+$valeur137+$valeur148+$valeur159+ $valeur170 +$valeur181 +  $valeur192;
      $sum2 =$valeur6+ $valeur17+$valeur28+$valeur39+$valeur50+ $valeur61 + $valeur72+$valeur83+  $valeur85+$valeur105 +$valeur116+$valeur127+$valeur138+$valeur149+$valeur160+ $valeur171 +$valeur182 +  $valeur193;
      $sum3 =$valeur7+ $valeur18+$valeur29;$valeur40+$valeur51+ $valeur62 + $valeur73+$valeur84+  $valeur86+$valeur106 +$valeur117+$valeur128+$valeur139+$valeur150+$valeur161+ $valeur172 +$valeur183 +  $valeur194;
      $sum4 =$valeur8+ $valeur19+$valeur30;$valeur41+$valeur52+ $valeur63 + $valeur74+$valeur85+  $valeur87+$valeur107 +$valeur118+$valeur129+$valeur140+$valeur151+$valeur162+ $valeur173 +$valeur184 +  $valeur195;
      $sum5 =$valeur9+ $valeur20+$valeur31;$valeur42+$valeur53+ $valeur64 + $valeur75+$valeur86+  $valeur88+$valeur108 +$valeur119+$valeur130+$valeur141+$valeur152+$valeur163+ $valeur174 +$valeur185 +  $valeur196;
    $data = '<?php' . "\n";
    // Loop to create variables $valeur70 to $valeur132 and add them to the $data string
    for ($i = 0; $i <= 197; $i++) {
      $Valeur45='';
      ${'Valeur' . $i} = $_POST['valeur' . $i];
      if(${'Valeur' . $i}==$Valeur45){
        $data .= '$Valeurajouter' . $i . ' = \'' . ${'Valeur' . $i} . "';\n";
      }else{
        $data .= '$Valeurajouter' . $i . ' = ' . ${'Valeur' . $i} . ";\n";
      }
    
    }

    $data .= '$sum = ' . $sum . ";\n";
    $data .= '$sum1 = ' . $sum1 . ";\n";
    $data .= '$sum2 = ' . $sum2 . ";\n";
    $data .= '$sum3 = ' . $sum3 . ";\n";
    $data .= '$sum4 = ' . $sum4 . ";\n";
    $data .= '$sum5 = ' . $sum5 . ";\n";
  
    
    $data .= "?>";
    
    
    $selectedDate = new DateTime($valeur198);
    $year = $selectedDate->format('Y'); // Extract the year value
    
    // Now, the variable $year will contain the year value "2023"
    
    
    $nomFichier = 'CreditBail_fichier_'. $year.'.php';
    
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
  print '<input type="hidden" name="model" value="CreditBail">';
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
    $filedir = DOL_DATA_ROOT . '/billanLaisse/CreditBail/';
    $urlsource = $_SERVER['PHP_SELF'] . '';
    $genallowed = 0;
    $delallowed = 1;
    $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

 

  if ($societe !== null && isset($societe->default_lang)) {
    print $formfile->showdocuments('CreditBail', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
  } else {
      print $formfile->showdocuments('CreditBail', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
  }

}









// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/CreditBail/';
$permissiontoadd = 1;
$donotredirect = 1;

include DOL_DOCUMENT_ROOT . '/core/actions_builddoc.inc.php';




?>




<!DOCTYPE >
<html>
  <head>
    
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
      td.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style1 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      th.style1 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      td.style2 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      th.style2 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      td.style3 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      th.style3 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      td.style4 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      th.style4 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      td.style5 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      th.style5 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      td.style6 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style6 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style8 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style8 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style9 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style9 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style10 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style10 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style11 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style11 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style12 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style12 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style13 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style13 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style14 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style14 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style15 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style15 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style16 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style16 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style17 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style17 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style18 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style18 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style19 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; font-style:italic; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style19 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; font-style:italic; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style20 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; font-style:italic; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style20 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; font-style:italic; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style21 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style21 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style22 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style22 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style23 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style23 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style24 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; text-decoration:underline; color:#0563C1; font-family:'Tahoma'; font-size:10pt; background-color:white }
      th.style24 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; text-decoration:underline; color:#0563C1; font-family:'Tahoma'; font-size:10pt; background-color:white }
      td.style25 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style25 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style26 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style26 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style27 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style27 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style28 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style28 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style29 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style29 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style30 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style30 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style31 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style31 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style32 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style32 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style33 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style33 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      table.sheet0 col.col0 { width:86.07777679pt }
      table.sheet0 col.col1 { width:46.76666613pt }
      table.sheet0 col.col2 { width:37.95555512pt }
      table.sheet0 col.col3 { width:69.81111031pt }
      table.sheet0 col.col4 { width:37.95555512pt }
      table.sheet0 col.col5 { width:59.64444376pt }
      table.sheet0 col.col6 { width:59.64444376pt }
      table.sheet0 col.col7 { width:59.64444376pt }
      table.sheet0 col.col8 { width:59.64444376pt }
      table.sheet0 col.col9 { width:59.64444376pt }
      table.sheet0 col.col10 { width:59.64444376pt }
      table.sheet0 col.col11 { width:49.47777721pt }
      table.sheet0 col.col12 { width:49.47777721pt }
      table.sheet0 .column11 { visibility:collapse; display:none }
      table.sheet0 tr { height:16.363636363636pt }
      table.sheet0 tr.row0 { height:22pt }
      table.sheet0 tr.row1 { height:15pt }
      table.sheet0 tr.row2 { height:16.363636363636pt }
      table.sheet0 tr.row3 { height:15pt }
      table.sheet0 tr.row4 { height:16.363636363636pt }
      table.sheet0 tr.row5 { height:16.363636363636pt }
      table.sheet0 tr.row6 { height:16.363636363636pt }
      table.sheet0 tr.row7 { height:16.363636363636pt }
      table.sheet0 tr.row8 { height:16.363636363636pt }
      table.sheet0 tr.row9 { height:16.363636363636pt }
      table.sheet0 tr.row10 { height:16.363636363636pt }
      table.sheet0 tr.row11 { height:16.363636363636pt }
      table.sheet0 tr.row12 { height:16.363636363636pt }
      table.sheet0 tr.row13 { height:16.363636363636pt }
      table.sheet0 tr.row14 { height:16.363636363636pt }
      table.sheet0 tr.row15 { height:16.363636363636pt }
      table.sheet0 tr.row16 { height:16.363636363636pt }
      table.sheet0 tr.row17 { height:16.363636363636pt }
      table.sheet0 tr.row18 { height:16.363636363636pt }
      table.sheet0 tr.row19 { height:16.363636363636pt }
      table.sheet0 tr.row20 { height:16.363636363636pt }
      table.sheet0 tr.row21 { height:16.363636363636pt }
      table.sheet0 tr.row22 { height:16.363636363636pt }
      table.sheet0 tr.row23 { height:15pt }
    </style>
  </head>

  <body>
<center>

<div > 
        <form method="POST" action="declarationCreditBail.php">
            <?php
            // Loop to create the hidden input fields
            for ($i = 0; $i <= 197; $i++) {
            $valeur = ${'valeur' . $i};
            echo '<input type="hidden" name="valeur' . $i . '" value="' . $valeur . '" />';
            }
            ?>
           <div >

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
            <!-- Code block for "oui" option -->
            <div id="ouiBlock"  style="display: none;">
                <!-- PHP code -->
              <center>
              <?php GenerateDocuments($year); ?>
              </center>
            </div>
            <!-- <script>
                function submitForm(event) {
                    event.preventDefault(); // Prevent form submission
                    // Replace "your_desired_page.php" with the URL of the page you want to redirect to
                    // Use JavaScript to redirect the page instead of mixing PHP and JavaScript
                    var url = "<?php echo DOL_URL_ROOT . '/custom/etatscomptables/declarationCreditBail.php'; ?>";
                    window.location.href = url;
                }

                // Attach the submitForm function to the form's submit event
                var form = document.querySelector('#frmgen');
                form.addEventListener('submit', submitForm);
            </script> -->





        

    </div> 


  


<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">
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
        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style3" colspan="11">TABLEAU DES BIENS EN CREDIT BAIL</td>
            <td class="column11 style4 null"></td>
          </tr>
          <tr class="row1">
            <td class="column0 style6 f"></td>
            <td class="column1 style7 null"></td>
            <td class="column2 style7 null"></td>
            <td class="column3 style7 null"></td>
            <td class="column4 style7 null"></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style7 null"></td>
            <td class="column7 style7 null"></td>
            <td class="column8 style7 null"></td>
            <td class="column9 style8 null"></td>
            <td class="column10 style9 f"></td>
            <td class="column11 style7 null"></td>
          </tr>
          <tr class="row2">
            <td class="column0 style11 s style16" rowspan="2">Rubriques</td>
            <td class="column1 style11 s style16" rowspan="2">Date de la 1ère échéance</td>
            <td class="column2 style11 s style16" rowspan="2">Durée du contrat en mois</td>
            <td class="column3 style11 s style16" rowspan="2">Valeur estimée du bien à la date du contrat</td>
            <td class="column4 style11 s style16" rowspan="2">Durée théorique d'amortis. du bien</td>
            <td class="column5 style11 s style16" rowspan="2">Cumul des exercices précédents des redevances</td>
            <td class="column6 style11 s style16" rowspan="2">Montant de l'exercice des redevances</td>
            <td class="column7 style12 s style13" colspan="2">Redevances restant à payer</td>
            <td class="column9 style11 s style16" rowspan="2">Prix d'achat résiduel en fin de contrat</td>
            <td class="column10 style11 s style16" rowspan="2">Observations</td>
            <td class="column11 style14 null"></td>
          </tr>
          <tr class="row3">
            <td class="column7 style17 s">à moins d'un an</td>
            <td class="column8 style18 s">à plus d'un an</td>
            <td class="column11 style14 null"></td>
          </tr>
          <tr class="row4">
            <td class="column0 style19 s">1</td>
            <td class="column1 style19 s">2</td>
            <td class="column2 style19 s">3</td>
            <td class="column3 style19 s">4</td>
            <td class="column4 style19 s">5</td>
            <td class="column5 style19 s">6</td>
            <td class="column6 style19 s">7</td>
            <td class="column7 style20 s">8</td>
            <td class="column8 style19 s">9</td>
            <td class="column9 style19 s">10</td>
            <td class="column10 style19 s">11</td>
            <td class="column11 style14 null"></td>
          </tr>
          <tr class="row5">
            <td class="column0 style21 null"><?php echo $valeur0;?></td>
            <td class="column1 style22 null"><?php echo $valeur1;?></td>
            <td class="column2 style21 null"><?php echo $valeur2;?></td>
            <td class="column3 style23 null"><?php echo $valeur3;?></td>
            <td class="column4 style21 null"><?php echo $valeur4;?></td>
            <td class="column5 style23 null"><?php echo $valeur5;?></td>
            <td class="column6 style23 null"><?php echo $valeur6;?></td>
            <td class="column7 style23 null"><?php echo $valeur7;?></td>
            <td class="column8 style23 null"><?php echo $valeur8;?></td>
            <td class="column9 style23 null"><?php echo $valeur9;?></td>
            <td class="column10 style23 null"><?php echo $valeur10;?></td>
          </tr>
          <tr class="row6">
            <td class="column0 style21 null"><?php echo $valeur11;?></td>
            <td class="column1 style22 null"><?php echo $valeur12;?></td>
            <td class="column2 style21 null"><?php echo $valeur13;?></td>
            <td class="column3 style23 null"><?php echo $valeur14;?></td>
            <td class="column4 style21 null"><?php echo $valeur15;?></td>
            <td class="column5 style23 null"><?php echo $valeur16;?></td>
            <td class="column6 style23 null"><?php echo $valeur17;?></td>
            <td class="column7 style23 null"><?php echo $valeur18;?></td>
            <td class="column8 style23 null"><?php echo $valeur19;?></td>
            <td class="column9 style23 null"><?php echo $valeur20;?></td>
            <td class="column10 style23 null"><?php echo $valeur21;?></td>
          </tr>
          <tr class="row7">
            <td class="column0 style21 null"><?php echo $valeur22;?></td>
            <td class="column1 style22 null"><?php echo $valeur23;?></td>
            <td class="column2 style21 null"><?php echo $valeur24;?></td>
            <td class="column3 style23 null"><?php echo $valeur25;?></td>
            <td class="column4 style21 null"><?php echo $valeur26;?></td>
            <td class="column5 style23 null"><?php echo $valeur27;?></td>
            <td class="column6 style23 null"><?php echo $valeur28;?></td>
            <td class="column7 style23 null"><?php echo $valeur29;?></td>
            <td class="column8 style23 null"><?php echo $valeur30;?></td>
            <td class="column9 style23 null"><?php echo $valeur31;?></td>
            <td class="column10 style23 null"><?php echo $valeur32;?></td>
          </tr>
          <tr class="row8">
            <td class="column0 style21 null"><?php echo $valeur33;?></td>
            <td class="column1 style22 null"><?php echo $valeur34;?></td>
            <td class="column2 style21 null"><?php echo $valeur35;?></td>
            <td class="column3 style23 null"><?php echo $valeur36;?></td>
            <td class="column4 style21 null"><?php echo $valeur37;?></td>
            <td class="column5 style23 null"><?php echo $valeur38;?></td>
            <td class="column6 style23 null"><?php echo $valeur39;?></td>
            <td class="column7 style23 null"><?php echo $valeur40;?></td>
            <td class="column8 style23 null"><?php echo $valeur41;?></td>
            <td class="column9 style23 null"><?php echo $valeur42;?></td>
            <td class="column10 style23 null"><?php echo $valeur43;?></td>
          </tr>
            <tr class="row9">
            <td class="column0 style21 null"><?php echo $valeur44;?></td>
            <td class="column1 style22 null"><?php echo $valeur45;?></td>
            <td class="column2 style21 null"><?php echo $valeur46;?></td>
            <td class="column3 style23 null"><?php echo $valeur47;?></td>
            <td class="column4 style21 null"><?php echo $valeur48;?></td>
            <td class="column5 style23 null"><?php echo $valeur49;?></td>
            <td class="column6 style23 null"><?php echo $valeur50;?></td>
            <td class="column7 style23 null"><?php echo $valeur51;?></td>
            <td class="column8 style23 null"><?php echo $valeur52;?></td>
            <td class="column9 style23 null"><?php echo $valeur53;?></td>
            <td class="column10 style23 null"><?php echo $valeur54;?></td>
        </tr>
            <tr class="row10">
            <td class="column0 style21 null"><?php echo $valeur55;?></td>
            <td class="column1 style22 null"><?php echo $valeur56;?></td>
            <td class="column2 style21 null"><?php echo $valeur57;?></td>
            <td class="column3 style23 null"><?php echo $valeur58;?></td>
            <td class="column4 style21 null"><?php echo $valeur59;?></td>
            <td class="column5 style23 null"><?php echo $valeur60;?></td>
            <td class="column6 style23 null"><?php echo $valeur61;?></td>
            <td class="column7 style23 null"><?php echo $valeur62;?></td>
            <td class="column8 style23 null"><?php echo $valeur63;?></td>
            <td class="column9 style23 null"><?php echo $valeur64;?></td>
            <td class="column10 style23 null"><?php echo $valeur65;?></td>
        </tr>
        <tr class="row11">
            <td class="column0 style21 null"><?php echo $valeur66;?></td>
            <td class="column1 style22 null"><?php echo $valeur67;?></td>
            <td class="column2 style21 null"><?php echo $valeur68;?></td>
            <td class="column3 style23 null"><?php echo $valeur69;?></td>
            <td class="column4 style21 null"><?php echo $valeur70;?></td>
            <td class="column5 style23 null"><?php echo $valeur71;?></td>
            <td class="column6 style23 null"><?php echo $valeur72;?></td>
            <td class="column7 style23 null"><?php echo $valeur73;?></td>
            <td class="column8 style23 null"><?php echo $valeur74;?></td>
            <td class="column9 style23 null"><?php echo $valeur75;?></td>
            <td class="column10 style23 null"><?php echo $valeur76;?></td>
         </tr>
         <tr class="row12">
            <td class="column0 style21 null"><?php echo $valeur77;?></td>
            <td class="column1 style22 null"><?php echo $valeur78;?></td>
            <td class="column2 style21 null"><?php echo $valeur79;?></td>
            <td class="column3 style23 null"><?php echo $valeur80;?></td>
            <td class="column4 style21 null"><?php echo $valeur81;?></td>
            <td class="column5 style23 null"><?php echo $valeur82;?></td>
            <td class="column6 style23 null"><?php echo $valeur83;?></td>
            <td class="column7 style23 null"><?php echo $valeur84;?></td>
            <td class="column8 style23 null"><?php echo $valeur85;?></td>
            <td class="column9 style23 null"><?php echo $valeur86;?></td>
            <td class="column10 style23 null"><?php echo $valeur87;?></td>
            </tr>
            <tr class="row13">
            <td class="column0 style21 null"><?php echo $valeur88;?></td>
            <td class="column1 style22 null"><?php echo $valeur89;?></td>
            <td class="column2 style21 null"><?php echo $valeur90;?></td>
            <td class="column3 style23 null"><?php echo $valeur91;?></td>
            <td class="column4 style21 null"><?php echo $valeur92;?></td>
            <td class="column5 style23 null"><?php echo $valeur93;?></td>
            <td class="column6 style23 null"><?php echo $valeur94;?></td>
            <td class="column7 style23 null"><?php echo $valeur95;?></td>
            <td class="column8 style23 null"><?php echo $valeur96;?></td>
            <td class="column9 style23 null"><?php echo $valeur97;?></td>
            <td class="column10 style23 null"><?php echo $valeur98;?></td>
            </tr>
            <tr class="row14">
            <td class="column0 style21 null"><?php echo $valeur99;?></td>
            <td class="column1 style22 null"><?php echo $valeur100;?></td>
            <td class="column2 style21 null"><?php echo $valeur101;?></td>
            <td class="column3 style23 null"><?php echo $valeur102;?></td>
            <td class="column4 style21 null"><?php echo $valeur103;?></td>
            <td class="column5 style23 null"><?php echo $valeur104;?></td>
            <td class="column6 style23 null"><?php echo $valeur105;?></td>
            <td class="column7 style23 null"><?php echo $valeur106;?></td>
            <td class="column8 style23 null"><?php echo $valeur107;?></td>
            <td class="column9 style23 null"><?php echo $valeur108;?></td>
            <td class="column10 style23 null"><?php echo $valeur109;?></td>
            </tr>
            <tr class="row15">
            <td class="column0 style21 null"><?php echo $valeur110;?></td>
            <td class="column1 style22 null"><?php echo $valeur111;?></td>
            <td class="column2 style21 null"><?php echo $valeur112;?></td>
            <td class="column3 style23 null"><?php echo $valeur113;?></td>
            <td class="column4 style21 null"><?php echo $valeur114;?></td>
            <td class="column5 style23 null"><?php echo $valeur115;?></td>
            <td class="column6 style23 null"><?php echo $valeur116;?></td>
            <td class="column7 style23 null"><?php echo $valeur117;?></td>
            <td class="column8 style23 null"><?php echo $valeur118;?></td>
            <td class="column9 style23 null"><?php echo $valeur119;?></td>
            <td class="column10 style23 null"><?php echo $valeur120;?></td>
            </tr>
            <tr class="row16">
            <td class="column0 style21 null"><?php echo $valeur121;?></td>
            <td class="column1 style22 null"><?php echo $valeur122;?></td>
            <td class="column2 style21 null"><?php echo $valeur123;?></td>
            <td class="column3 style23 null"><?php echo $valeur124;?></td>
            <td class="column4 style21 null"><?php echo $valeur125;?></td>
            <td class="column5 style23 null"><?php echo $valeur126;?></td>
            <td class="column6 style23 null"><?php echo $valeur127;?></td>
            <td class="column7 style23 null"><?php echo $valeur128;?></td>
            <td class="column8 style23 null"><?php echo $valeur129;?></td>
            <td class="column9 style23 null"><?php echo $valeur130;?></td>
            <td class="column10 style23 null"><?php echo $valeur131;?></td>
            </tr>
            <tr class="row17">
            <td class="column0 style21 null"><?php echo $valeur132;?></td>
            <td class="column1 style22 null"><?php echo $valeur133;?></td>
            <td class="column2 style21 null"><?php echo $valeur134;?></td>
            <td class="column3 style23 null"><?php echo $valeur135;?></td>
            <td class="column4 style21 null"><?php echo $valeur136;?></td>
            <td class="column5 style23 null"><?php echo $valeur137;?></td>
            <td class="column6 style23 null"><?php echo $valeur138;?></td>
            <td class="column7 style23 null"><?php echo $valeur139;?></td>
            <td class="column8 style23 null"><?php echo $valeur140;?></td>
            <td class="column9 style23 null"><?php echo $valeur141;?></td>
            <td class="column10 style23 null"><?php echo $valeur142;?></td>
            </tr>
            <tr class="row18">
            <td class="column0 style21 null"><?php echo $valeur143;?></td>
            <td class="column1 style22 null"><?php echo $valeur144;?></td>
            <td class="column2 style21 null"><?php echo $valeur145;?></td>
            <td class="column3 style23 null"><?php echo $valeur146;?></td>
            <td class="column4 style21 null"><?php echo $valeur147;?></td>
            <td class="column5 style23 null"><?php echo $valeur148;?></td>
            <td class="column6 style23 null"><?php echo $valeur149;?></td>
            <td class="column7 style23 null"><?php echo $valeur150;?></td>
            <td class="column8 style23 null"><?php echo $valeur151;?></td>
            <td class="column9 style23 null"><?php echo $valeur152;?></td>
            <td class="column10 style23 null"><?php echo $valeur153;?></td>
            </tr>
            <tr class="row19">
            <td class="column0 style21 null"><?php echo $valeur154;?></td>
            <td class="column1 style22 null"><?php echo $valeur155;?></td>
            <td class="column2 style21 null"><?php echo $valeur156;?></td>
            <td class="column3 style23 null"><?php echo $valeur157;?></td>
            <td class="column4 style21 null"><?php echo $valeur158;?></td>
            <td class="column5 style23 null"><?php echo $valeur159;?></td>
            <td class="column6 style23 null"><?php echo $valeur160;?></td>
            <td class="column7 style23 null"><?php echo $valeur161;?></td>
            <td class="column8 style23 null"><?php echo $valeur162;?></td>
            <td class="column9 style23 null"><?php echo $valeur163;?></td>
            <td class="column10 style23 null"><?php echo $valeur164;?></td>
            </tr>

            <tr class="row20">
            <td class="column0 style21 null"><?php echo $valeur165;?></td>
            <td class="column1 style22 null"><?php echo $valeur166;?></td>
            <td class="column2 style21 null"><?php echo $valeur167;?></td>
            <td class="column3 style23 null"><?php echo $valeur168;?></td>
            <td class="column4 style21 null"><?php echo $valeur169;?></td>
            <td class="column5 style23 null"><?php echo $valeur170;?></td>
            <td class="column6 style23 null"><?php echo $valeur171;?></td>
            <td class="column7 style23 null"><?php echo $valeur172;?></td>
            <td class="column8 style23 null"><?php echo $valeur173;?></td>
            <td class="column9 style23 null"><?php echo $valeur174;?></td>
            <td class="column10 style23 null"><?php echo $valeur175;?></td>
            </tr>
            <tr class="row21">
            <td class="column0 style21 null"><?php echo $valeur176;?></td>
            <td class="column1 style22 null"><?php echo $valeur177;?></td>
            <td class="column2 style21 null"><?php echo $valeur178;?></td>
            <td class="column3 style23 null"><?php echo $valeur179;?></td>
            <td class="column4 style21 null"><?php echo $valeur180;?></td>
            <td class="column5 style23 null"><?php echo $valeur181;?></td>
            <td class="column6 style23 null"><?php echo $valeur182;?></td>
            <td class="column7 style23 null"><?php echo $valeur183;?></td>
            <td class="column8 style23 null"><?php echo $valeur184;?></td>
            <td class="column9 style23 null"><?php echo $valeur185;?></td>
            <td class="column10 style23 null"><?php echo $valeur186;?></td>
            </tr>
            <tr class="row22">
            <td class="column0 style21 null"><?php echo $valeur187;?></td>
            <td class="column1 style22 null"><?php echo $valeur188;?></td>
            <td class="column2 style21 null"><?php echo $valeur189;?></td>
            <td class="column3 style23 null"><?php echo $valeur190;?></td>
            <td class="column4 style21 null"><?php echo $valeur191;?></td>
            <td class="column5 style23 null"><?php echo $valeur192;?></td>
            <td class="column6 style23 null"><?php echo $valeur193;?></td>
            <td class="column7 style23 null"><?php echo $valeur194;?></td>
            <td class="column8 style23 null"><?php echo $valeur195;?></td>
            <td class="column9 style23 null"><?php echo $valeur196;?></td>
            <td class="column10 style23 null"><?php echo $valeur197;?></td>
            </tr>
          
          
            


    
           <tr class="row23">
             <td class="column0 style28 s">Total</td>
             <td class="column1 style29 null"></td>
             <td class="column2 style30 null"></td>
            <td class="column3 style31 f"><?php echo $sum;?></td>
         <td class="column4 style32 s">-</td>
        <td class="column5 style31 f"><?php echo $sum1;?></td>
            <td class="column6 style31 f"><?php echo $sum2;?></td>
           <td class="column7 style31 f"><?php echo $sum3;?></td>
            <td class="column8 style31 f"><?php echo $sum4;?></td>
            <td class="column9 style31 f"><?php echo $sum5;?></td>
         <td class="column10 style32 s">-</td>
         <td class="column11 style7 s">GrasDroite</td>
           </tr>   
        </tbody>
</table>
  
</center>

<script>
  function navigateToAnotherPage() {
    // Replace 'url_of_another_page.html' with the actual URL of the page you want to navigate to
    window.location.href = "<?php echo DOL_URL_ROOT; ?>/custom/cheque/paiement_list.php";
  }
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



  </body>
</html>
