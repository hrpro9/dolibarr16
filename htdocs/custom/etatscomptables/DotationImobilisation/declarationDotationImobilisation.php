
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
     for ($i = 0; $i <= 247; $i++) {
        ${'autrecreditBail' . $i} = $_POST['autrecreditBail' . $i];
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
  print '<input type="hidden" name="model" value="Autrecreditbail">';
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
  $filedir = DOL_DATA_ROOT . '/billanLaisse/Autrecreditbail/';
  $urlsource = $_SERVER['PHP_SELF'] . '';
  $genallowed = 0;
  $delallowed = 1;
  $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

 

  if ($societe !== null && isset($societe->default_lang)) {
    print $formfile->showdocuments('Autrecreditbail', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
  } else {
    print $formfile->showdocuments('Autrecreditbail', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
  }

}


// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/Autrecreditbail/';
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
      .f { text-align:center }
      .inlineStr { text-align:center }
      .n { text-align:center }
      .s { text-align:center }
      td.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      th.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      td.style1 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style1 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style2 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style2 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style3 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style3 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style4 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style4 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style5 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style5 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style6 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style6 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style7 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style7 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style8 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style8 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style9 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style9 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style10 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style10 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style11 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style11 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style12 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style12 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style13 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style13 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style14 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style14 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style15 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style15 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style16 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      th.style16 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      td.style17 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      th.style17 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      td.style18 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      th.style18 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      td.style19 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      th.style19 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      td.style20 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style20 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style21 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style21 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style22 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style22 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style23 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      th.style23 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      td.style24 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style24 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style25 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style25 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style26 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style26 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style27 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style27 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style28 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:#D8D8D8 }
      th.style28 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:#D8D8D8 }
      td.style29 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:#D8D8D8 }
      th.style29 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:#D8D8D8 }
      td.style30 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:#D8D8D8 }
      th.style30 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:#D8D8D8 }
      td.style31 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style31 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style32 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style32 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style33 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style33 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style34 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style34 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style35 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      th.style35 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      td.style36 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      th.style36 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      td.style37 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      th.style37 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      td.style38 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      th.style38 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      td.style39 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style39 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style40 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#C0C0C0 }
      th.style40 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#C0C0C0 }
      td.style41 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style41 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style42 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#C0C0C0 }
      th.style42 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#C0C0C0 }
      td.style43 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#D8D8D8; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style43 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#D8D8D8; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style44 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style44 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style45 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#C0C0C0 }
      th.style45 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#C0C0C0 }
      td.style46 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style46 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style47 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style47 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style48 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style48 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style49 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style49 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style50 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style50 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style51 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style51 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style52 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style52 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style53 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style53 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style54 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style54 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style55 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style55 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style56 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style56 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style57 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style57 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style58 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style58 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style59 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      th.style59 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      td.style60 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style60 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style61 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      th.style61 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      td.style62 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style62 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style63 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style63 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style64 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style64 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style65 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style65 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style66 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style66 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style67 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style67 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style68 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style68 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style69 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style69 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style70 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      th.style70 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      td.style71 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      th.style71 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      td.style72 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style72 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style73 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style73 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style74 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      th.style74 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      td.style75 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      th.style75 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      td.style76 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      th.style76 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
      td.style77 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style77 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style78 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style78 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style79 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style79 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style80 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style80 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style81 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style81 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style82 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style82 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style83 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:14pt; background-color:#D8D8D8 }
      th.style83 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:14pt; background-color:#D8D8D8 }
      td.style84 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:14pt; background-color:#D8D8D8 }
      th.style84 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:14pt; background-color:#D8D8D8 }
      td.style85 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:14pt; background-color:#D8D8D8 }
      th.style85 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:14pt; background-color:#D8D8D8 }
      td.style86 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      th.style86 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      td.style87 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style87 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style88 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style88 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style89 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style89 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style90 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style90 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style91 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style91 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style92 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style92 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style93 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style93 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style94 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style94 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style95 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style95 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style96 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style96 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style97 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style97 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style98 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style98 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style99 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style99 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style100 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style100 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style101 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style101 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style102 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style102 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style103 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style103 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style104 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style104 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style105 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style105 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style106 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style106 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style107 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style107 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style108 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style108 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style109 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style109 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style110 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style110 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style111 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style111 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style112 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style112 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style113 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style113 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style114 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:7pt; background-color:white }
      th.style114 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:7pt; background-color:white }
      td.style115 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      th.style115 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      td.style116 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      th.style116 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      td.style117 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style117 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style118 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      th.style118 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:10pt; background-color:white }
      td.style119 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      th.style119 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      td.style120 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      th.style120 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      td.style121 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      th.style121 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Tahoma'; font-size:10pt; background-color:white }
      td.style122 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:white }
      th.style122 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:8pt; background-color:white }
      table.sheet0 col.col0 { width:119.96666529pt }
      table.sheet0 col.col1 { width:50.83333275pt }
      table.sheet0 col.col2 { width:56.25555491pt }
      table.sheet0 col.col3 { width:68.45555477pt }
      table.sheet0 col.col4 { width:58.96666599pt }
      table.sheet0 col.col5 { width:28.46666634pt }
      table.sheet0 col.col6 { width:37.95555512pt }
      table.sheet0 col.col7 { width:59.64444376pt }
      table.sheet0 col.col8 { width:58.96666599pt }
      table.sheet0 col.col9 { width:86.07777679pt }
      table.sheet0 col.col10 { width:49.47777721pt }
      table.sheet0 col.col11 { width:46.76666613pt }
      table.sheet0 col.col12 { width:44.05555505pt }
      table.sheet0 col.col13 { width:44.05555505pt }
      table.sheet0 col.col14 { width:197.91110884pt }
      table.sheet0 col.col15 { width:54.89999937pt }
      table.sheet0 col.col16 { width:51.51111052pt }
      table.sheet0 col.col17 { width:54.89999937pt }
      table.sheet0 col.col18 { width:56.93333268pt }
      table.sheet0 col.col19 { width:49.47777721pt }
      table.sheet0 col.col20 { width:49.47777721pt }
      table.sheet0 col.col21 { width:49.47777721pt }
      table.sheet0 col.col22 { width:49.47777721pt }
      table.sheet0 col.col23 { width:0pt }
      table.sheet0 col.col24 { width:0pt }
      table.sheet0 col.col25 { width:0pt }
      table.sheet0 col.col26 { width:49.47777721pt }
      table.sheet0 col.col27 { width:49.47777721pt }
      table.sheet0 col.col28 { width:49.47777721pt }
      table.sheet0 col.col29 { width:49.47777721pt }
      table.sheet0 col.col30 { width:49.47777721pt }
      table.sheet0 col.col31 { width:49.47777721pt }
      table.sheet0 col.col32 { width:49.47777721pt }
      table.sheet0 col.col33 { width:49.47777721pt }
      table.sheet0 col.col34 { width:49.47777721pt }
      table.sheet0 col.col35 { width:49.47777721pt }
      table.sheet0 col.col36 { width:49.47777721pt }
      table.sheet0 col.col37 { width:49.47777721pt }
      table.sheet0 col.col38 { width:49.47777721pt }
      table.sheet0 col.col39 { width:49.47777721pt }
      table.sheet0 col.col40 { width:49.47777721pt }
      table.sheet0 col.col41 { width:49.47777721pt }
      table.sheet0 col.col42 { width:49.47777721pt }
      table.sheet0 col.col43 { width:49.47777721pt }
      table.sheet0 col.col44 { width:49.47777721pt }
      table.sheet0 col.col45 { width:49.47777721pt }
      table.sheet0 col.col46 { width:49.47777721pt }
      table.sheet0 col.col47 { width:49.47777721pt }
      table.sheet0 col.col48 { width:49.47777721pt }
      table.sheet0 col.col49 { width:49.47777721pt }
      table.sheet0 col.col50 { width:49.47777721pt }
      table.sheet0 col.col51 { width:49.47777721pt }
      table.sheet0 col.col52 { width:49.47777721pt }
      table.sheet0 col.col53 { width:49.47777721pt }
      table.sheet0 col.col54 { width:203.333331pt }
      table.sheet0 col.col55 { width:49.47777721pt }
      table.sheet0 col.col56 { width:42pt }
      table.sheet0 col.col57 { width:42pt }
      table.sheet0 .column22 { visibility:collapse; display:none }
      table.sheet0 .column23 { visibility:collapse; display:none }
      table.sheet0 .column24 { visibility:collapse; display:none }
      table.sheet0 .column25 { visibility:collapse; display:none }
      table.sheet0 tr { height:13.636363636364pt }
      table.sheet0 tr.row0 { height:22.5pt }
      table.sheet0 tr.row1 { height:21pt }
      table.sheet0 tr.row2 { height:16.5pt }
      table.sheet0 tr.row3 { height:21pt }
      table.sheet0 tr.row4 { height:14.25pt }
      table.sheet0 tr.row5 { height:15.75pt }
      table.sheet0 tr.row6 { height:10.5pt }
      table.sheet0 tr.row7 { height:15.75pt }
      table.sheet0 tr.row8 { height:4.5pt }
      table.sheet0 tr.row9 { height:13.636363636364pt }
      table.sheet0 tr.row10 { height:13.636363636364pt }
      table.sheet0 tr.row11 { height:9pt }
      table.sheet0 tr.row12 { height:3.75pt }
      table.sheet0 tr.row13 { height:14pt }
      table.sheet0 tr.row14 { height:14pt }
      table.sheet0 tr.row15 { height:14pt }
      table.sheet0 tr.row16 { height:14pt }
      table.sheet0 tr.row17 { height:14pt }
      table.sheet0 tr.row18 { height:14pt }
      table.sheet0 tr.row19 { height:14pt }
      table.sheet0 tr.row20 { height:14pt }
      table.sheet0 tr.row21 { height:14pt }
      table.sheet0 tr.row22 { height:14pt }
      table.sheet0 tr.row23 { height:14pt }
      table.sheet0 tr.row24 { height:14pt }
      table.sheet0 tr.row25 { height:14pt }
      table.sheet0 tr.row26 { height:14pt }
      table.sheet0 tr.row27 { height:14pt }
      table.sheet0 tr.row28 { height:14pt }
      table.sheet0 tr.row29 { height:14pt }
      table.sheet0 tr.row30 { height:14pt }
      table.sheet0 tr.row31 { height:14pt }
      table.sheet0 tr.row32 { height:14pt }
      table.sheet0 tr.row33 { height:16pt }
      table.sheet0 tr.row34 { height:16pt }
      table.sheet0 tr.row35 { height:16pt }
      table.sheet0 tr.row36 { height:16pt }
      table.sheet0 tr.row37 { height:14pt }
      table.sheet0 tr.row38 { height:14pt }
      table.sheet0 tr.row39 { height:14pt }
      table.sheet0 tr.row40 { height:14pt }
      table.sheet0 tr.row41 { height:14pt }
      table.sheet0 tr.row42 { height:18pt }
      table.sheet0 tr.row43 { height:14pt }
      table.sheet0 tr.row44 { height:14pt }
      table.sheet0 tr.row45 { height:14pt }
      table.sheet0 tr.row46 { height:14pt }
      table.sheet0 tr.row47 { height:14pt }
      table.sheet0 tr.row48 { height:14pt }
      table.sheet0 tr.row49 { height:14pt }
      table.sheet0 tr.row50 { height:14pt }
      table.sheet0 tr.row51 { height:14pt }
      table.sheet0 tr.row52 { height:14pt }
      table.sheet0 tr.row53 { height:14pt }
      table.sheet0 tr.row54 { height:14pt }
      table.sheet0 tr.row55 { height:14pt }
      table.sheet0 tr.row56 { height:14pt }
      table.sheet0 tr.row57 { height:14pt }
      table.sheet0 tr.row58 { height:14pt }
      table.sheet0 tr.row59 { height:14pt }
      table.sheet0 tr.row60 { height:14pt }
      table.sheet0 tr.row61 { height:14pt }
      table.sheet0 tr.row62 { height:14pt }
      table.sheet0 tr.row63 { height:14pt }
      table.sheet0 tr.row64 { height:14pt }
      table.sheet0 tr.row65 { height:14pt }
      table.sheet0 tr.row66 { height:14pt }
      table.sheet0 tr.row67 { height:14pt }
      table.sheet0 tr.row68 { height:14pt }
      table.sheet0 tr.row69 { height:14pt }
      table.sheet0 tr.row70 { height:14pt }
      table.sheet0 tr.row71 { height:14pt }
      table.sheet0 tr.row72 { height:14pt }
      table.sheet0 tr.row73 { height:14pt }
      table.sheet0 tr.row74 { height:14pt }
      table.sheet0 tr.row75 { height:14pt }
      table.sheet0 tr.row76 { height:14pt }
      table.sheet0 tr.row77 { height:14pt }
      table.sheet0 tr.row78 { height:14pt }
      table.sheet0 tr.row79 { height:14pt }
      table.sheet0 tr.row80 { height:14pt }
      table.sheet0 tr.row81 { height:14pt }
      table.sheet0 tr.row82 { height:14pt }
      table.sheet0 tr.row83 { height:14pt }
      table.sheet0 tr.row84 { height:14pt }
      table.sheet0 tr.row85 { height:14pt }
      table.sheet0 tr.row86 { height:14pt }
      table.sheet0 tr.row87 { height:14pt }
      table.sheet0 tr.row88 { height:14pt }
      table.sheet0 tr.row89 { height:14pt }
      table.sheet0 tr.row90 { height:14pt }
      table.sheet0 tr.row91 { height:14pt }
      table.sheet0 tr.row92 { height:14pt }
      table.sheet0 tr.row93 { height:14pt }
      table.sheet0 tr.row94 { height:14pt }
      table.sheet0 tr.row95 { height:14pt }
      table.sheet0 tr.row96 { height:14pt }
      table.sheet0 tr.row97 { height:14pt }
      table.sheet0 tr.row98 { height:14pt }
      table.sheet0 tr.row99 { height:14pt }
      table.sheet0 tr.row100 { height:14pt }
      table.sheet0 tr.row101 { height:14pt }
      table.sheet0 tr.row102 { height:14pt }
      table.sheet0 tr.row103 { height:14pt }
      table.sheet0 tr.row104 { height:14pt }
      table.sheet0 tr.row105 { height:14pt }
      table.sheet0 tr.row106 { height:14pt }
      table.sheet0 tr.row107 { height:14pt }
      table.sheet0 tr.row108 { height:14pt }
      table.sheet0 tr.row109 { height:14pt }
      table.sheet0 tr.row110 { height:14pt }
      table.sheet0 tr.row111 { height:14pt }
      table.sheet0 tr.row112 { height:14pt }
      table.sheet0 tr.row113 { height:14pt }
      table.sheet0 tr.row114 { height:14pt }
      table.sheet0 tr.row115 { height:14pt }
      table.sheet0 tr.row116 { height:14pt }
      table.sheet0 tr.row117 { height:14pt }
      table.sheet0 tr.row118 { height:14pt }
      table.sheet0 tr.row119 { height:14pt }
      table.sheet0 tr.row120 { height:14pt }
      table.sheet0 tr.row121 { height:14pt }
      table.sheet0 tr.row122 { height:14pt }
      table.sheet0 tr.row123 { height:14pt }
      table.sheet0 tr.row124 { height:14pt }
      table.sheet0 tr.row125 { height:14pt }
      table.sheet0 tr.row126 { height:14pt }
      table.sheet0 tr.row127 { height:14pt }
      table.sheet0 tr.row128 { height:14pt }
      table.sheet0 tr.row129 { height:14pt }
      table.sheet0 tr.row130 { height:14pt }
      table.sheet0 tr.row131 { height:14pt }
      table.sheet0 tr.row132 { height:14pt }
      table.sheet0 tr.row133 { height:14pt }
      table.sheet0 tr.row134 { height:14pt }
      table.sheet0 tr.row135 { height:14pt }
      table.sheet0 tr.row136 { height:14pt }
      table.sheet0 tr.row137 { height:14pt }
      table.sheet0 tr.row138 { height:14pt }
      table.sheet0 tr.row139 { height:14pt }
      table.sheet0 tr.row140 { height:14pt }
      table.sheet0 tr.row141 { height:14pt }
      table.sheet0 tr.row142 { height:14pt }
      table.sheet0 tr.row143 { height:14pt }
      table.sheet0 tr.row144 { height:14pt }
      table.sheet0 tr.row145 { height:14pt }
      table.sheet0 tr.row146 { height:14pt }
      table.sheet0 tr.row147 { height:14pt }
      table.sheet0 tr.row148 { height:14pt }
      table.sheet0 tr.row149 { height:14pt }
      table.sheet0 tr.row150 { height:14pt }
      table.sheet0 tr.row151 { height:14pt }
      table.sheet0 tr.row152 { height:14pt }
      table.sheet0 tr.row153 { height:14pt }
      table.sheet0 tr.row154 { height:14pt }
      table.sheet0 tr.row155 { height:14pt }
      table.sheet0 tr.row156 { height:14pt }
      table.sheet0 tr.row157 { height:14pt }
      table.sheet0 tr.row158 { height:14pt }
      table.sheet0 tr.row159 { height:14pt }
      table.sheet0 tr.row160 { height:14pt }
      table.sheet0 tr.row161 { height:14pt }
      table.sheet0 tr.row162 { height:14pt }
      table.sheet0 tr.row163 { height:14pt }
      table.sheet0 tr.row164 { height:14pt }
      table.sheet0 tr.row165 { height:14pt }
      table.sheet0 tr.row166 { height:14pt }
      table.sheet0 tr.row167 { height:14pt }
      table.sheet0 tr.row168 { height:14pt }
      table.sheet0 tr.row169 { height:14pt }
      table.sheet0 tr.row170 { height:14pt }
      table.sheet0 tr.row171 { height:14pt }
      table.sheet0 tr.row172 { height:14pt }
      table.sheet0 tr.row173 { height:14pt }
      table.sheet0 tr.row174 { height:14pt }
      table.sheet0 tr.row175 { height:14pt }
      table.sheet0 tr.row176 { height:14pt }
      table.sheet0 tr.row177 { height:14pt }
      table.sheet0 tr.row178 { height:14pt }
      table.sheet0 tr.row179 { height:14pt }
      table.sheet0 tr.row180 { height:14pt }
      table.sheet0 tr.row181 { height:14pt }
      table.sheet0 tr.row182 { height:14pt }
      table.sheet0 tr.row183 { height:14pt }
      table.sheet0 tr.row184 { height:14pt }
      table.sheet0 tr.row185 { height:14pt }
      table.sheet0 tr.row186 { height:14pt }
      table.sheet0 tr.row187 { height:14pt }
      table.sheet0 tr.row188 { height:14pt }
      table.sheet0 tr.row189 { height:14pt }
      table.sheet0 tr.row190 { height:14pt }
      table.sheet0 tr.row191 { height:14pt }
      table.sheet0 tr.row192 { height:14pt }
      table.sheet0 tr.row193 { height:14pt }
      table.sheet0 tr.row194 { height:14pt }
      table.sheet0 tr.row195 { height:14pt }
      table.sheet0 tr.row196 { height:14pt }
      table.sheet0 tr.row197 { height:14pt }
      table.sheet0 tr.row198 { height:14pt }
      table.sheet0 tr.row199 { height:14pt }
      table.sheet0 tr.row200 { height:14pt }
      table.sheet0 tr.row201 { height:11.25pt }
      table.sheet0 tr.row202 { height:14pt }
    </style>
  </head>

  <body>

    <center>
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
        <col class="col17">
        <col class="col18">
        <col class="col19">
        <col class="col20">
        <col class="col21">
        <col class="col22">
        <col class="col23">
        <col class="col24">
        <col class="col25">
        <col class="col26">
        <col class="col27">
        <col class="col28">
        <col class="col29">
        <col class="col30">
        <col class="col31">
        <col class="col32">
        <col class="col33">
        <col class="col34">
        <col class="col35">
        <col class="col36">
        <col class="col37">
        <col class="col38">
        <col class="col39">
        <col class="col40">
        <col class="col41">
        <col class="col42">
        <col class="col43">
        <col class="col44">
        <col class="col45">
        <col class="col46">
        <col class="col47">
        <col class="col48">
        <col class="col49">
        <col class="col50">
        <col class="col51">
        <col class="col52">
        <col class="col53">
        <col class="col54">
        <col class="col55">
        <col class="col56">
        <col class="col57">
        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style3" colspan="10">ETAT DE DOTATIONS AUX AMORTISSEMENTS RELATIFS AUX IMMOBILISATIONS</td>
            <td class="column10 style4 null"></td>
            <td class="column11 style5 null"></td>
            <td class="column12 style4 null"></td>
            <td class="column13 style4 null"></td>
            <td class="column14 style4 null"></td>
            <td class="column15 style4 null"></td>
            <td class="column16 style4 null"></td>
            <td class="column22 style7 null"></td>
            <td class="column23 style7 null"></td>
            <td class="column24 style7 null"></td>
            <td class="column25 style7 null"></td>
          </tr>
          <tr class="row6">
            <td class="column0 style8 null"></td>
            <td class="column1 style9 null"></td>
            <td class="column2 style9 null"></td>
            <td class="column3 style26 null"></td>
            <td class="column4 style27 null"></td>
            <td class="column5 style22 null"></td>
            <td class="column6 style13 null"></td>
            <td class="column7 style14 null"></td>
            <td class="column8 style10 null"></td>
            <td class="column9 style15 null"></td>
            <td class="column10 style16 null"></td>
            <td class="column11 style17 null"></td>
            <td class="column12 style16 null"></td>
            <td class="column13 style16 null"></td>
            <td class="column14 style16 null"></td>
            <td class="column15 style16 null"></td>
            <td class="column16 style16 null"></td>      
            <td class="column22 style19 null"></td>
            <td class="column23 style19 null"></td>
            <td class="column24 style19 null"></td>
            <td class="column25 style19 null"></td>

          </tr>
          <tr class="row7">
            <td class="column0 style28 s">Total</td>
            <td class="column1 style29 null"></td>
            <td class="column2 style30 f">0.00</td>
            <td class="column3 style31 null"></td>
            <td class="column4 style30 f">0.00</td>
            <td class="column5 style32 null"></td>
            <td class="column6 style33 null"></td>
            <td class="column7 style30 f">0.00</td>
            <td class="column8 style30 f">0.00</td>
            <td class="column9 style34 null"></td>
            <td class="column10 style35 null"></td>
            <td class="column11 style36 null"></td>
            <td class="column12 style35 null"></td>
            <td class="column13 style35 null"></td>
            <td class="column14 style35 null"></td>
            <td class="column15 style35 null"></td>
            <td class="column16 style35 null"></td>
           
            <td class="column22 style38 null"></td>
            <td class="column23 style38 null"></td>
            <td class="column24 style38 null"></td>
            <td class="column25 style38 null"></td>

          </tr>
          <tr class="row8">
            <td class="column0 style39 s style41" rowspan="5">Immobilisations concernées</td>
            <td class="column1 style39 s style41" rowspan="5">Date d'entrée (1)</td>
            <td class="column2 style39 s style41" rowspan="5">Prix d'acquisition (2)</td>
            <td class="column3 style39 s style41" rowspan="5">Valeur comptable après réévaluation</td>
            <td class="column4 style39 s style41" rowspan="5">Amortissements antérieurs (3)</td>
            <td class="column5 style39 s style41" rowspan="5">Taux en %</td>
            <td class="column6 style39 s style41" rowspan="5">Durée en années (4)</td>
            <td class="column7 style39 s style41" rowspan="5">Amortissements de l'exercice</td>
            <td class="column8 style39 s style41" rowspan="5">Cumul amortissements (col. 4 + col. 7)</td>
            <td class="column9 style39 s style41" rowspan="5">Observations (5)</td>
            <td class="column10 style4 null"></td>
           
            
            <td class="column22 style7 null"></td>
            <td class="column23 style7 null"></td>
            <td class="column24 style7 null"></td>
            <td class="column25 style7 null"></td>

          </tr>
         
       
          <tr class="row186">
          
        
            
    
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>
         

          </tr>
          <tr class="row187">
          
    
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>
         

          </tr>
          <tr class="row188">
           

            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>
         
          </tr>
          <tr class="row189">
   
     
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>


          </tr>
          <tr class="row190">
            <td class="column0 style46 null"></td>
            <td class="column1 style47 null"></td>
            <td class="column2 style48 null"></td>
            <td class="column3 style49 null"></td>
            <td class="column4 style50 f"></td>
            <td class="column5 style51 null"></td>
            <td class="column6 style52 f">#VALUE!</td>
            <td class="column7 style50 f">0.00</td>
            <td class="column8 style50 f">0.00</td>
            <td class="column9 style48 null"></td>
         
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>
         

          </tr>
          <tr class="row191">
            <td class="column0 style46 null"></td>
            <td class="column1 style47 null"></td>
            <td class="column2 style48 null"></td>
            <td class="column3 style49 null"></td>
            <td class="column4 style50 f"></td>
            <td class="column5 style51 null"></td>
            <td class="column6 style52 f">#VALUE!</td>
            <td class="column7 style50 f">0.00</td>
            <td class="column8 style50 f">0.00</td>
            <td class="column9 style48 null"></td>
            
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>
       
          </tr>
        
      
          <tr class="row194">
            <td class="column0 style46 null"></td>
            <td class="column1 style47 null"></td>
            <td class="column2 style48 null"></td>
            <td class="column3 style49 null"></td>
            <td class="column4 style50 f"></td>
            <td class="column5 style51 null"></td>
            <td class="column6 style52 f">#VALUE!</td>
            <td class="column7 style50 f">0.00</td>
            <td class="column8 style50 f">0.00</td>
            <td class="column9 style48 null"></td>
    
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>
      

          </tr>
          <tr class="row195">
            <td class="column0 style46 null"></td>
            <td class="column1 style47 null"></td>
            <td class="column2 style48 null"></td>
            <td class="column3 style49 null"></td>
            <td class="column4 style50 f"></td>
            <td class="column5 style51 null"></td>
            <td class="column6 style52 f">#VALUE!</td>
            <td class="column7 style50 f">0.00</td>
            <td class="column8 style50 f">0.00</td>
            <td class="column9 style48 null"></td>
   
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>
          

          </tr>
          <tr class="row196">
            <td class="column0 style46 null"></td>
            <td class="column1 style47 null"></td>
            <td class="column2 style48 null"></td>
            <td class="column3 style49 null"></td>
            <td class="column4 style50 f"></td>
            <td class="column5 style51 null"></td>
            <td class="column6 style52 f">#VALUE!</td>
            <td class="column7 style50 f">0.00</td>
            <td class="column8 style50 f">0.00</td>
            <td class="column9 style48 null"></td>
     
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>
            

          </tr>
          <tr class="row197">
            <td class="column0 style46 null"></td>
            <td class="column1 style47 null"></td>
            <td class="column2 style48 null"></td>
            <td class="column3 style49 null"></td>
            <td class="column4 style50 f"></td>
            <td class="column5 style51 null"></td>
            <td class="column6 style52 f">#VALUE!</td>
            <td class="column7 style50 f">0.00</td>
            <td class="column8 style50 f">0.00</td>
            <td class="column9 style48 null"></td>
        
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>
           

          </tr>
          <tr class="row198">
            <td class="column0 style46 null"></td>
            <td class="column1 style47 null"></td>
            <td class="column2 style48 null"></td>
            <td class="column3 style49 null"></td>
            <td class="column4 style50 f"></td>
            <td class="column5 style51 null"></td>
            <td class="column6 style52 f">#VALUE!</td>
            <td class="column7 style50 f">0.00</td>
            <td class="column8 style50 f">0.00</td>
            <td class="column9 style48 null"></td>
    
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>
        

          </tr>
          <tr class="row199">
            <td class="column0 style46 null"></td>
            <td class="column1 style47 null"></td>
            <td class="column2 style48 null"></td>
            <td class="column3 style49 null"></td>
            <td class="column4 style50 f"></td>
            <td class="column5 style51 null"></td>
            <td class="column6 style52 f">#VALUE!</td>
            <td class="column7 style50 f">0.00</td>
            <td class="column8 style50 f">0.00</td>
            <td class="column9 style48 null"></td>
          
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>
      

          </tr>
          <tr class="row200">
            <td class="column0 style46 null"></td>
            <td class="column1 style47 null"></td>
            <td class="column2 style48 null"></td>
            <td class="column3 style49 null"></td>
            <td class="column4 style50 f"></td>
            <td class="column5 style51 null"></td>
            <td class="column6 style52 f">#VALUE!</td>
            <td class="column7 style50 f">0.00</td>
            <td class="column8 style50 f">0.00</td>
            <td class="column9 style48 null"></td>
           
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style7 f">#DIV/0!</td>
            <td class="column23 style7 f">0</td>
         

          </tr>
          <tr class="row201">
            <td class="column0 style109 null"></td>
            <td class="column1 style110 null"></td>
            <td class="column2 style111 null"></td>
            <td class="column3 style112 null"></td>
            <td class="column4 style112 null"></td>
            <td class="column5 style110 null"></td>
            <td class="column6 style110 null"></td>
            <td class="column7 style112 null"></td>
            <td class="column8 style112 null"></td>
            <td class="column9 style110 null"></td>
            <td class="column10 style113 null"></td>
            <td class="column11 style77 null"></td>
            <td class="column12 style53 null"></td>
            <td class="column13 style53 null"></td>
            <td class="column14 style53 null"></td>
            <td class="column15 style53 null"></td>
            <td class="column16 style53 null"></td>
            <td class="column17 style107 null"></td>
            <td class="column18 style107 null"></td>
            
            <td class="column22 style80 null"></td>
            <td class="column23 style80 null"></td>
            <td class="column24 style80 null"></td>
            <td class="column25 style80 null"></td>

          </tr>
          
        
        </tbody>
    </table>
    </center>

    
  </body>
</html>
