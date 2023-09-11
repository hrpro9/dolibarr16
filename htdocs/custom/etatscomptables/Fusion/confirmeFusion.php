<?php
// Load Dolibarr environment
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
llxHeader("", ""); 


$returnpage=GETPOST('model');




if($returnpage=="Fusion")
{ 
    $url = DOL_URL_ROOT . '/custom/etatscomptables/Fusion/declarationFusion.php';
    echo"<script>window.location.href='$url';</script>";
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $check=$_POST['check']??'';
  if( $check == 'true')
  {
        // Retrieve the form data
        for ($i = 0; $i <= 82; $i++) {
          ${'fusion' . $i} = $_POST['fusion' . $i];
      }

      $sum1=$fusion0+$fusion9+$fusion17+$fusion25+$fusion33+$fusion41+$fusion49+$fusion57+$fusion65+$fusion73;
      $sum2=$fusion1+$fusion10+$fusion18+$fusion26+$fusion34+$fusion42+$fusion50+$fusion58+$fusion66+$fusion74;
      $sum3=$fusion2+$fusion11+$fusion19+$fusion27+$fusion35+$fusion43+$fusion51+$fusion59+$fusion67+$fusion75;
      $sum4=$fusion3+$fusion12+$fusion20+$fusion28+$fusion36+$fusion44+$fusion52+$fusion60+$fusion68+$fusion76;
      $sum5=$fusion4+$fusion13+$fusion21+$fusion29+$fusion37+$fusion45+$fusion53+$fusion61+$fusion69+$fusion77;
      $sum6=$fusion5+$fusion14+$fusion22+$fusion30+$fusion38+$fusion46+$fusion54+$fusion62+$fusion70+$fusion78;
      $sum7=$fusion6+$fusion15+$fusion23+$fusion31+$fusion39+$fusion47+$fusion55+$fusion63+$fusion71+$fusion79;
      




  $data = "<?php ";

  for ($i = 0; $i <= 82; $i++) {
      ${'fusion' . $i} = $_POST['fusion' . $i];
      if(${'fusion' . $i}==$fusion82)
      {

        $selectedDate = new DateTime($fusion82);
        $year = $selectedDate->format('Y');
        $data .= '$fusion' . $i . ' = ' . $year . ";\n";   

      }else if(${'fusion' . $i}==$fusion8){
      }

      else if (is_string(${'fusion' . $i})) {
        // If the value is a string, add double quotes around it
        $data .= '$fusion' . $i . ' = "' . ${'fusion' . $i} . "\";\n";
      }
      else {
          $data .= '$fusion' . $i . ' = ' . ${'fusion' . $i} . ";\n";
      }

  
  }

  $data .= '$sum1 = ' . $sum1 . ";\n";
  $data .= '$sum2 = ' . $sum2 . ";\n";
  $data .= '$sum3 = ' . $sum3 . ";\n";
  $data .= '$sum4 = ' . $sum4 . ";\n";
  $data .= '$sum5 = ' . $sum5 . ";\n";
  $data .= '$sum6 = ' . $sum6 . ";\n"; 
  $data .= '$sum7 = ' . $sum7 . ";\n"; 
  $data .= "?>";
  $selectedDate = new DateTime($fusion82);
  $year = $selectedDate->format('Y'); // Extract the year value
  // Now, the variable $year will contain the year value "2023"
  $nomFichier = 'Fusion_fichier_'. $year.'.php';
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
    print '<input type="hidden" name="model" value="Fusion">';
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
    $filedir = DOL_DATA_ROOT . '/billanLaisse/Fusion/';
    $urlsource = $_SERVER['PHP_SELF'] . '';
    $genallowed = 0;
    $delallowed = 1;
    $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));
  
   
  
    if ($societe !== null && isset($societe->default_lang)) {
      print $formfile->showdocuments('Fusion', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
    } else {
      print $formfile->showdocuments('Fusion', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
    }
  
  }
  
  
  // Actions to build doc
  $action = GETPOST('action', 'aZ09');
  $upload_dir = DOL_DATA_ROOT . '/billanLaisse/Fusion/';
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
      td.style1 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style1 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style2 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style2 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style3 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style3 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style4 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style4 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style5 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style5 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style6 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style6 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style8 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style8 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style9 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style9 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style10 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style10 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style11 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style11 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style12 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style12 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style13 { vertical-align:top; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style13 { vertical-align:top; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style14 { vertical-align:top; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style14 { vertical-align:top; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style15 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style15 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style16 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style16 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style17 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style17 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style18 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style18 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style19 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style19 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style20 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style20 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style21 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style21 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style22 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style22 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style23 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style23 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style24 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style24 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style25 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style25 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style26 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style26 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style27 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style27 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style28 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style28 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style29 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-style:italic; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:white }
      th.style29 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-style:italic; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:white }
      td.style30 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style30 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style31 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-style:italic; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:white }
      th.style31 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-style:italic; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:white }
      td.style32 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:7pt; background-color:white }
      th.style32 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:7pt; background-color:white }
      td.style33 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:7pt; background-color:white }
      th.style33 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:7pt; background-color:white }
      td.style34 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style34 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style35 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style35 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      table.sheet0 col.col0 { width:12.87777763pt }
      table.sheet0 col.col1 { width:130.13333184pt }
      table.sheet0 col.col2 { width:59.64444376pt }
      table.sheet0 col.col3 { width:59.64444376pt }
      table.sheet0 col.col4 { width:59.64444376pt }
      table.sheet0 col.col5 { width:59.64444376pt }
      table.sheet0 col.col6 { width:59.64444376pt }
      table.sheet0 col.col7 { width:59.64444376pt }
      table.sheet0 col.col8 { width:59.64444376pt }
      table.sheet0 col.col9 { width:59.64444376pt }
      table.sheet0 col.col10 { width:0pt }
      table.sheet0 col.col11 { width:49.47777721pt }
      table.sheet0 .column10 { visibility:collapse; display:none }
      table.sheet0 tr { height:13.636363636364pt }
      table.sheet0 tr.row0 { height:27pt }
      table.sheet0 tr.row1 { height:27pt }
      table.sheet0 tr.row2 { height:90pt }
      table.sheet0 tr.row13 { height:24pt }
    </style>
  </head>

  <body>
 
  <center>

 
<form method="POST" action="declarationFusion.php">
    <?php
    // Loop to create the hidden input fields
    for ($i = 0; $i <= 82; $i++) {
        $fusion = ${'fusion' . $i};
      echo '<input type="hidden" name="fusion' . $i . '" value="' . $fusion . '" />';
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
        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style3" colspan="10">ETAT DES PLUS-VALUES CONSTATEES EN CAS DE FUSION</td>
            <td class="column10 style4 null"></td>
         
          </tr>
          <tr class="row1">
            <td class="column0 style6 f"></td>
            <td class="column1 style7 null"></td>
            <td class="column2 style7 null"></td>
            <td class="column3 style7 null"></td>
            <td class="column4 style7 null"></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style8 null"></td>
            <td class="column7 style9 null"></td>
            <td class="column8 style9 null"></td>
            <td class="column9 style10 f"></td>
            <td class="column10 style4 null"></td>
         
          </tr>
          <tr class="row2">
            <td class="column0 style11 s style11" colspan="2">Eléments</td>
            <td class="column2 style12 s">Valeur d'apport</td>
            <td class="column3 style12 s">Valeur nette comptable</td>
            <td class="column4 style12 s">Plus-value constatée et différée</td>
            <td class="column5 style12 s">Fraction de la plus-value rapportée aux exercices antérieurs (cumul) (2)</td>
            <td class="column6 style12 s">Fraction de la plus-value rapportée à l'exercice actuel</td>
            <td class="column7 style12 s">Cumul des plus-values rapportées</td>
            <td class="column8 style12 s">Solde des plus-values non imputées</td>
            <td class="column9 style12 s">Observations</td>
            <td class="column10 style13 null"></td>
         
          </tr>
          <tr class="row3">
            <td class="column0 style15 n">1</td>
            <td class="column1 style15 s">Terrain (1)</td>
            <?php
                for ($i = 0; $i < 9; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'. ${'fusion' . $i}.'</td>' . "\n";
                }
            ?>

         
          </tr>
          <tr class="row4">
            <td class="column0 style19 n">2</td>
            <td class="column1 style19 s">Constructions</td>
            <?php
                for ($i = 9; $i < 17; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'fusion' . $i}.'</td>' . "\n";
                }
            ?>
         
          </tr>
          <tr class="row5">
            <td class="column0 style19 n">3</td>
            <td class="column1 style19 s">Matériel et outillage</td>
            <?php
                for ($i = 17; $i < 25; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'fusion' . $i}.'</td>' . "\n";
                }
            ?>
         
          </tr>
          <tr class="row6">
            <td class="column0 style19 n">4</td>
            <td class="column1 style19 s">Matériel de transport</td>
            <?php
                for ($i = 25; $i < 33; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'fusion' . $i}.'</td>' . "\n";
                }
            ?>
         
          </tr>
          <tr class="row7">
            <td class="column0 style19 n">5</td>
            <td class="column1 style19 s">Agencements-Installations</td>
            <?php
                for ($i = 33; $i < 41; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'fusion' . $i}.'</td>' . "\n";
                }
            ?>
         
          </tr>
          <tr class="row8">
            <td class="column0 style19 n">6</td>
            <td class="column1 style19 s">Brevets</td>
            <?php
                for ($i = 41; $i < 49; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'fusion' . $i}.'</td>' . "\n";
                }
            ?>
         
          </tr>
          <tr class="row9">
            <td class="column0 style19 n">7</td>
            <td class="column1 style19 s">Autres éléments amortissables</td>
            <?php
                for ($i = 49; $i < 57; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'fusion' . $i}.'</td>' . "\n";
                }
            ?>
         
         
          </tr>
          <tr class="row10">
            <td class="column0 style19 n">8</td>
            <td class="column1 style19 s">Titres de participation</td>
            <?php
                for ($i = 57; $i < 65; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'fusion' . $i}.'</td>' . "\n";
                }
            ?>
         
          </tr>
          <tr class="row11">
            <td class="column0 style19 n">9</td>
            <td class="column1 style19 s">Fonds de commerce</td>
            <?php
                for ($i = 65; $i < 73; $i++) {
                    echo '<td class="column' . ($i + 2) . ' style16 null">'.${'fusion' . $i}.'</td>' . "\n";
                }
            ?>
         
          </tr>
          <tr class="row12">
            <td class="column0 style21 n">10</td>
            <td class="column1 style21 s">Autres éléments non amortissables</td>
            <?php
                for ($i = 73; $i < 81; $i++) {
                  echo '<td class="column' . ($i + 2) . ' style16 null">'.${'fusion' . $i}.'</td>' . "\n";
                }
            ?>
         
          </tr>
          <tr class="row13">
            <td class="column0 style23 null"></td>
            <td class="column1 style24 s">Total</td>
            <td class="column2 style25 f"><?php echo $sum1;?></td>
            <td class="column3 style25 f"><?php echo $sum2;?></td>
            <td class="column4 style25 f"><?php echo $sum3;?></td>
            <td class="column5 style25 f"><?php echo $sum4;?></td>
            <td class="column6 style25 f"><?php echo $sum5;?></td>
            <td class="column7 style25 f"><?php echo $sum6;?></td>
            <td class="column8 style25 f"><?php echo $sum7;?></td>
            <td class="column9 style26 s">-</td>
          </tr>
        </tbody>
    </table>
    
  
  </body>
</html>
