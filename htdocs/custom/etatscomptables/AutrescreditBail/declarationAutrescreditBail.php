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
      .f { text-align:right }
      .inlineStr { text-align:left }
      .n { text-align:right }
      .s { text-align:left }
      td.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style1 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style1 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style2 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style2 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style3 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style3 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style4 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style4 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style5 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style5 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style6 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style6 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style7 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style7 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style8 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style8 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style9 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style9 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style10 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style10 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style11 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style11 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style12 { vertical-align:top; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style12 { vertical-align:top; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style13 { vertical-align:top; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style13 { vertical-align:top; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style14 { vertical-align:top; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style14 { vertical-align:top; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style15 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style15 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style16 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style16 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style17 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style17 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style18 { vertical-align:top; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style18 { vertical-align:top; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style19 { vertical-align:top; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style19 { vertical-align:top; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style20 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style20 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style21 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style21 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style22 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style22 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style23 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style23 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style24 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style24 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style25 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style25 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style26 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style26 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style27 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style27 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style28 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style28 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style29 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style29 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style30 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style30 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style31 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style31 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style32 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style32 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style33 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style33 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style34 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style34 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style35 { vertical-align:top; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style35 { vertical-align:top; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style36 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style36 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style37 { vertical-align:top; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style37 { vertical-align:top; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style38 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style38 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style39 { vertical-align:top; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style39 { vertical-align:top; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style40 { vertical-align:top; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style40 { vertical-align:top; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style41 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style41 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style42 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style42 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style43 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style43 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style44 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style44 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style45 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style45 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style46 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style46 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style47 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style47 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style48 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style48 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style49 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style49 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style50 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style50 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      table.sheet0 col.col0 { width:57.61111045pt }
      table.sheet0 col.col1 { width:95.56666557pt }
      table.sheet0 col.col2 { width:71.84444362pt }
      table.sheet0 col.col3 { width:69.13333254pt }
      table.sheet0 col.col4 { width:59.64444376pt }
      table.sheet0 col.col5 { width:63.71111038pt }
      table.sheet0 col.col6 { width:60.32222153pt }
      table.sheet0 col.col7 { width:60.9999993pt }
      table.sheet0 col.col8 { width:46.76666613pt }
      table.sheet0 col.col9 { width:59.64444376pt }
      table.sheet0 col.col10 { width:59.64444376pt }
      table.sheet0 col.col11 { width:33.8888885pt }
      table.sheet0 col.col12 { width:33.8888885pt }
      table.sheet0 col.col13 { width:49.47777721pt }
      table.sheet0 col.col14 { width:49.47777721pt }
      table.sheet0 .column13 { visibility:collapse; display:none }
      table.sheet0 tr { height:16.363636363636pt }
      table.sheet0 tr.row0 { height:20pt }
      table.sheet0 tr.row1 { height:15pt }
      table.sheet0 tr.row2 { height:16.363636363636pt }
      table.sheet0 tr.row3 { height:60pt }
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
      table.sheet0 tr.row24 { height:21pt }
    </style>
  </head>

  <body>

 

<form method="POST" action="confirmeAutrescreditBail.php">
 
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
        <col class="col13">
        <col class="col14">
        <center>
        
        <input type="date" required name="autrecreditBail248"  id="autrecreditBail248" value="<?php if(isset($autrecreditBail248)){ echo $autrecreditBail248;} ?>"  placeholder ="Année" required style="margin-top: 18px;font-size:95%; background: #ededed; font-weight:bolder; padding: 8px 15px 8px 15px; border: block; ">
        <input type="hidden" name="check"  value="true">
        </center>
        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style3" colspan="13">TABLEAU DES LOCATIONS ET BAUX AUTRES QUE LE CREDIT-BAIL</td> 
          </tr>
          <tr class="row1">
            <td class="column0 style5 f"></td>
            <td class="column1 style6 null"></td>
            <td class="column2 style6 null"></td>
            <td class="column3 style6 null"></td>
            <td class="column4 style6 null"></td>
            <td class="column5 style6 null"></td>
            <td class="column6 style6 null"></td>
            <td class="column7 style6 null"></td>
            <td class="column8 style6 null"></td>
            <td class="column9 style6 null"></td>
            <td class="column10 style7 null"></td>
            <td class="column11 style7 null"></td>
            <td class="column12 style8 f"></td>  
          </tr>
          <tr class="row2">
            <td class="column0 style10 s style16" rowspan="2">Nature du bien loué</td>
            <td class="column1 style11 s style17" rowspan="2">Lieu de situation</td>
            <td class="column2 style11 s style17" rowspan="2">Nom et prénoms</td>
            <td class="column3 style11 s style17" rowspan="2">Raison sociale</td>
            <td class="column4 style11 s style17" rowspan="2">Adresse du propriétaire</td>
            <td class="column5 style11 s style17" rowspan="2">N° IF du propriétaire</td>
            <td class="column6 style11 s style17" rowspan="2">CIN du propriétaire</td>
            <td class="column7 style11 s style17" rowspan="2">CE du propriétaire</td>
            <td class="column8 style12 s style18" rowspan="2">Date de conclusion de l'acte de location</td>
            <td class="column9 style12 s style18" rowspan="2">Montant annuel de location</td>
            <td class="column10 style12 s style18" rowspan="2">Montant du loyer compris dans les charges de l'exercice</td>
            <td class="column11 style13 s style14" colspan="2">Nature du contrat (1)</td>        
          </tr>
          <tr class="row3">
            <td class="column11 style19 s">Bail ordinaire</td>
            <td class="column12 style19 s">Leasing(Nème période) (1)</td>       
          </tr>
          <tr class="row4">
            <td class="column0 style20 s">1</td>
            <td class="column1 style21 s">2</td>
            <td class="column2 style21 s">3</td>
            <td class="column3 style21 n">4</td>
            <td class="column4 style21 n">5</td>
            <td class="column5 style21 n">6</td>
            <td class="column6 style21 n">7</td>
            <td class="column7 style21 n">8</td>
            <td class="column8 style21 n">9</td>
            <td class="column9 style21 n">10</td>
            <td class="column10 style21 n">11</td>
            <td class="column11 style21 n">12</td>
            <td class="column12 style21 n">13</td>      
          </tr>



          
          <tr class="row5">
                <?php
                for ($i = 0; $i <= 13; $i++) {
                    if ($i === 8) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 9 || $i === 10) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
                ?>
            </tr>

          <tr class="row6">
          <?php
                for ($i = 14; $i <= 26; $i++) {
                    if ($i === 22) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 23 || $i === 24) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>
          </tr>
          <tr class="row7">
          <?php
                for ($i = 27; $i <= 39; $i++) {
                    if ($i === 35) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 36 || $i === 37) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>   
          </tr>
          <tr class="row8">
          <?php
                for ($i = 40; $i <= 52; $i++) {
                    if ($i === 48) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 49 || $i === 50) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>   
          </tr>
          <tr class="row9">
          <?php
                for ($i = 53; $i <= 65; $i++) {
                    if ($i === 61) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 62 || $i === 63) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>        
          </tr>
          <tr class="row10">
          <?php
                for ($i = 66; $i <= 78; $i++) {
                    if ($i === 74) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 75 || $i === 76) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>    
          </tr>
          <tr class="row11">
          <?php
                for ($i = 79; $i <= 91; $i++) {
                    if ($i === 87) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 88 || $i === 89) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>     
          </tr>
          <tr class="row12">
          <?php
                for ($i = 92; $i <= 104; $i++) {
                    if ($i === 100) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 101 || $i === 102) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>   
          </tr>
          <tr class="row13">
          <?php
                for ($i = 105; $i <= 117; $i++) {
                    if ($i === 113) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 114 || $i === 115) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>       
          </tr>
          <tr class="row14">
          <?php
                for ($i = 118; $i <= 130; $i++) {
                    if ($i === 126) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 127 || $i === 128) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?> 
          </tr>
          <tr class="row15">
          <?php
                for ($i = 131; $i <= 143; $i++) {
                    if ($i === 139) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 140 || $i === 141) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>
          </tr>
          <tr class="row16">
          <?php
                for ($i = 144; $i <= 156; $i++) {
                    if ($i === 152) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 153 || $i === 154) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>
          </tr>
          <tr class="row17">
          <?php
                for ($i = 157; $i <= 169; $i++) {
                    if ($i === 165) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 166 || $i === 167) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>
          </tr>
          <tr class="row18">
          <?php
                for ($i = 170; $i <= 182; $i++) {
                    if ($i === 178) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 179 || $i === 180) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>
          </tr>
          <tr class="row19">
          <?php
                for ($i = 183; $i <= 195; $i++) {
                    if ($i === 191) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 192 || $i === 193) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>
          </tr>
          <tr class="row20">
          <?php
                for ($i = 196; $i <= 208; $i++) {
                    if ($i === 204) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 205 || $i === 206) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>
          </tr>
          <tr class="row21">
          <?php
                for ($i = 209; $i <= 221; $i++) {
                    if ($i === 217) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 218 || $i === 219) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>
          </tr>
          <tr class="row22">
          <?php
                for ($i = 222; $i <= 234; $i++) {
                    if ($i === 230) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 231 || $i === 232) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>
          </tr>
          <tr class="row23">
          <?php
                for ($i = 235; $i <= 247; $i++) {
                    if ($i === 243) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="date" required style="width: 52px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else if ($i === 244 || $i === 245) {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="number" required style="width: 61px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    } else {
                        echo '<td class="column' . ($i + 2) . ' style22 null"><input min="0" type="text" required style="width: 115px;" name="autrecreditBail' . $i . '" id="autrecreditBail' . $i . '" value="';
                        if (isset(${"autrecreditBail" . $i})) {
                            echo ${"autrecreditBail" . $i};
                        }
                        echo '" /></td>' . "\n";
                    }
                }
            ?>
          </tr>
          <!-- <tr class="row24">
            <td class="column0 style41 null"></td>
            <td class="column1 style42 null"></td>
            <td class="column2 style43 s">Total</td>
            <td class="column3 style44 null"></td>
            <td class="column4 style44 null"></td>
            <td class="column5 style44 null"></td>
            <td class="column6 style44 null"></td>
            <td class="column7 style45 null"></td>
            <td class="column8 style46 s">-</td>
            <td class="column9 style47 f">0.00</td>
            <td class="column10 style47 f">0.00</td>
            <td class="column11 style46 s">-</td>
            <td class="column12 style46 s">-</td>
            <td class="column13 style48 s">GrasDroite</td>
          </tr> -->
        </tbody>
    </table>
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

  </body>
</html>
