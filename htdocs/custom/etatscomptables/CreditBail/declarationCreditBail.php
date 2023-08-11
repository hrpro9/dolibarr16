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




  for ($i = 0; $i <= 197; $i++) {
    ${'valeur' . $i} = $_POST['valeur' . $i];
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
  print '<input type="hidden" name="model" value="CreditBail">';
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
<style>

</style>
<form method="POST" action="confirmeCreditbail.php">
    <table align="center" border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">
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
        <center>

      

        <input type="date" name="valeur198" placeholder ="Année" required style="margin-top: 18px;font-size:95%; background: #ededed; font-weight:bolder; padding: 8px 15px 8px 15px; border: block; ">
        <input type="hidden" name="check"  value="true">
      </center>
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
            <td class="column0 style21 null"><input name="valeur0" type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required id="valeur0" oninput="sumValues()" value="<?php if(isset($valeur0)){ echo $valeur0;} ?>" /></td>
            <td class="column1 style22 null"><input name="valeur1" type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required id="valeur1" oninput="sumValues()" value="<?php if(isset($valeur1)){ echo $valeur1;} ?>" /></td>
            <td class="column2 style21 null"><input name="valeur2" type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required id="valeur2" oninput="sumValues()" value="<?php if(isset($valeur2)){ echo $valeur2;} ?>"/></td>
            <td class="column3 style23 null"><input name="valeur3" type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required id="valeur3" oninput="sumValues()" value="<?php if(isset($valeur3)){ echo $valeur3;} ?>"/></td>
            <td class="column4 style21 null"><input name="valeur4" type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required id="valeur4" oninput="sumValues()" value="<?php if(isset($valeur4)){ echo $valeur4;} ?>"/></td>
            <td class="column5 style23 null"><input name="valeur5" type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required id="valeur5" oninput="sumValues()" value="<?php if(isset($valeur5)){ echo $valeur5;} ?>"/></td>
            <td class="column6 style23 null"><input name="valeur6" type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required id="valeur6" oninput="sumValues()" value="<?php if(isset($valeur6)){ echo $valeur6;} ?>"/></td>
            <td class="column7 style23 null"><input name="valeur7" type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required id="valeur7" oninput="sumValues()" value="<?php if(isset($valeur7)){ echo $valeur7;} ?>"/></td>
            <td class="column8 style23 null"><input name="valeur8" type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required id="valeur8" oninput="sumValues()" value="<?php if(isset($valeur8)){ echo $valeur8;} ?>"/></td>
            <td class="column9 style23 null"><input name="valeur9" type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required id="valeur9" oninput="sumValues()" value="<?php if(isset($valeur9)){ echo $valeur9;} ?>"/></td>
            <td class="column10 style23 null"><input name="valeur10" type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required id="valeur10" oninput="sumValues()" value="<?php if(isset($valeur10)){ echo $valeur10;} ?>"/></td>
          </tr>
          <tr class="row6">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur11" id="valeur11" oninput="sumValues()" value="<?php if(isset($valeur11)){ echo $valeur11;} ?>"/></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur12" id="valeur12" oninput="sumValues()" value="<?php if(isset($valeur12)){ echo $valeur12;} ?>"/></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur13" id="valeur13" oninput="sumValues()" value="<?php if(isset($valeur13)){ echo $valeur13;} ?>"/></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur14" id="valeur14" oninput="sumValues()" value="<?php if(isset($valeur14)){ echo $valeur14;} ?>"/></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur15" id="valeur15" oninput="sumValues()" value="<?php if(isset($valeur15)){ echo $valeur15;} ?>"/></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur16" id="valeur16" oninput="sumValues()" value="<?php if(isset($valeur16)){ echo $valeur16;} ?>"/></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur17" id="valeur17" oninput="sumValues()" value="<?php if(isset($valeur17)){ echo $valeur17;} ?>"/></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur18" id="valeur18" oninput="sumValues()" value="<?php if(isset($valeur18)){ echo $valeur18;} ?>"/></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur19" id="valeur19" oninput="sumValues()" value="<?php if(isset($valeur19)){ echo $valeur19;} ?>"/></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur20" id="valeur20" oninput="sumValues()" value="<?php if(isset($valeur20)){ echo $valeur20;} ?>"/></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur21" id="valeur21" oninput="sumValues()" value="<?php if(isset($valeur21)){ echo $valeur21;} ?>"/></td>
          </tr>
          <tr class="row7">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required  name="valeur22" id="valeur22" oninput="sumValues()" value="<?php if(isset($valeur22)){ echo $valeur22;} ?>"/></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required  name="valeur23" id="valeur23" oninput="sumValues()" value="<?php if(isset($valeur23)){ echo $valeur23;} ?>"/></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required  name="valeur24" id="valeur24" oninput="sumValues()" value="<?php if(isset($valeur24)){ echo $valeur24;} ?>"/></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required  name="valeur25" id="valeur25" oninput="sumValues()" value="<?php if(isset($valeur25)){ echo $valeur25;} ?>"/></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required  name="valeur26" id="valeur26" oninput="sumValues()" value="<?php if(isset($valeur26)){ echo $valeur26;} ?>"/></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required  name="valeur27" id="valeur27" oninput="sumValues()" value="<?php if(isset($valeur27)){ echo $valeur27;} ?>"/></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required  name="valeur28" id="valeur28" oninput="sumValues()" value="<?php if(isset($valeur28)){ echo $valeur28;} ?>"/></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required  name="valeur29" id="valeur29" oninput="sumValues()" value="<?php if(isset($valeur29)){ echo $valeur29;} ?>"/></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required  name="valeur30" id="valeur30" oninput="sumValues()" value="<?php if(isset($valeur30)){ echo $valeur30;} ?>"/></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required  name="valeur31" id="valeur31" oninput="sumValues()" value="<?php if(isset($valeur31)){ echo $valeur31;} ?>"/></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required  name="valeur32" id="valeur32" oninput="sumValues()" value="<?php if(isset($valeur32)){ echo $valeur32;} ?>"/></td>
          </tr>
        
          <tr class="row8">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur33" id="valeur33" oninput="sumValues()" value="<?php if(isset($valeur33)){ echo $valeur33;} ?>"/></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur34" id="valeur34" oninput="sumValues()" value="<?php if(isset($valeur34)){ echo $valeur34;} ?>"/></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur35" id="valeur35" oninput="sumValues()" value="<?php if(isset($valeur35)){ echo $valeur35;} ?>"/></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur36" id="valeur36" oninput="sumValues()" value="<?php if(isset($valeur36)){ echo $valeur36;} ?>"/></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur37" id="valeur37" oninput="sumValues()" value="<?php if(isset($valeur37)){ echo $valeur37;} ?>"/></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur38" id="valeur38" oninput="sumValues()" value="<?php if(isset($valeur38)){ echo $valeur38;} ?>"/></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur39" id="valeur39" oninput="sumValues()" value="<?php if(isset($valeur39)){ echo $valeur39;} ?>"/></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur40" id="valeur40" oninput="sumValues()" value="<?php if(isset($valeur40)){ echo $valeur40;} ?>"/></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur41" id="valeur41" oninput="sumValues()" value="<?php if(isset($valeur41)){ echo $valeur41;} ?>"/></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur42" id="valeur42" oninput="sumValues()" value="<?php if(isset($valeur42)){ echo $valeur42;} ?>"/></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur43" id="valeur43" oninput="sumValues()" value="<?php if(isset($valeur43)){ echo $valeur43;} ?>"/></td>
          </tr>
          
          <tr class="row9">
                <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt; text-align: center;" placeholder=" " required name="valeur44" id="valeur44" oninput="sumValues()" value="<?php if (isset($valeur44)) { echo $valeur44; } ?>" /></td>
                <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt; text-align: center;" placeholder="0" required name="valeur45" id="valeur45" oninput="sumValues()" value="<?php if (isset($valeur45)) { echo $valeur45; } ?>" /></td>
                <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt; text-align: center;" placeholder="0" required name="valeur46" id="valeur46" oninput="sumValues()" value="<?php if (isset($valeur46)) { echo $valeur46; } ?>" /></td>
                <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt; text-align: center;" placeholder="0" required name="valeur47" id="valeur47" oninput="sumValues()" value="<?php if (isset($valeur47)) { echo $valeur47; } ?>" /></td>
                <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt; text-align: center;" placeholder="0" required name="valeur48" id="valeur48" oninput="sumValues()" value="<?php if (isset($valeur48)) { echo $valeur48; } ?>" /></td>
                <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt; text-align: center;" placeholder="0" required name="valeur49" id="valeur49" oninput="sumValues()" value="<?php if (isset($valeur49)) { echo $valeur49; } ?>" /></td>
                <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt; text-align: center;" placeholder="0" required name="valeur50" id="valeur50" oninput="sumValues()" value="<?php if (isset($valeur50)) { echo $valeur50; } ?>" /></td>
                <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt; text-align: center;" placeholder="0" required name="valeur51" id="valeur51" oninput="sumValues()" value="<?php if (isset($valeur51)) { echo $valeur51; } ?>" /></td>
                <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt; text-align: center;" placeholder="0" required name="valeur52" id="valeur52" oninput="sumValues()" value="<?php if (isset($valeur52)) { echo $valeur52; } ?>" /></td>
                <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt; text-align: center;" placeholder="0" required name="valeur53" id="valeur53" oninput="sumValues()" value="<?php if (isset($valeur53)) { echo $valeur53; } ?>" /></td>
                <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt; text-align: center;" placeholder=" " required name="valeur54" id="valeur54" oninput="sumValues()" value="<?php if (isset($valeur54)) { echo $valeur54; } ?>" /></td>
            </tr>

          
            <tr class="row10">
              <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur55" id="valeur55" oninput="sumValues()" value="<?php if (isset($valeur55)) { echo $valeur55; } ?>" /></td>
              <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur56" id="valeur56" oninput="sumValues()" value="<?php if (isset($valeur56)) { echo $valeur56; } ?>" /></td>
              <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur57" id="valeur57" oninput="sumValues()" value="<?php if (isset($valeur57)) { echo $valeur57; } ?>" /></td>
              <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur58" id="valeur58" oninput="sumValues()" value="<?php if (isset($valeur58)) { echo $valeur58; } ?>" /></td>
              <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur59" id="valeur59" oninput="sumValues()" value="<?php if (isset($valeur59)) { echo $valeur59; } ?>" /></td>
              <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur60" id="valeur60" oninput="sumValues()" value="<?php if (isset($valeur60)) { echo $valeur60; } ?>" /></td>
              <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur61" id="valeur61" oninput="sumValues()" value="<?php if (isset($valeur61)) { echo $valeur61; } ?>" /></td>
              <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur62" id="valeur62" oninput="sumValues()" value="<?php if (isset($valeur62)) { echo $valeur62; } ?>" /></td>
              <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur63" id="valeur63" oninput="sumValues()" value="<?php if (isset($valeur63)) { echo $valeur63; } ?>" /></td>
              <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur64" id="valeur64" oninput="sumValues()" value="<?php if (isset($valeur64)) { echo $valeur64; } ?>" /></td>
              <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur65" id="valeur65" oninput="sumValues()" value="<?php if (isset($valeur65)) { echo $valeur65; } ?>" /></td>
            </tr>

            <tr class="row11">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur66" id="valeur66" oninput="sumValues()" value="<?php if (isset($valeur66)) { echo $valeur66; } ?>" /></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur67" id="valeur67" oninput="sumValues()" value="<?php if (isset($valeur67)) { echo $valeur67; } ?>" /></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur68" id="valeur68" oninput="sumValues()" value="<?php if (isset($valeur68)) { echo $valeur68; } ?>" /></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur69" id="valeur69" oninput="sumValues()" value="<?php if (isset($valeur69)) { echo $valeur69; } ?>" /></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur70" id="valeur70" oninput="sumValues()" value="<?php if (isset($valeur70)) { echo $valeur70; } ?>" /></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur71" id="valeur71" oninput="sumValues()" value="<?php if (isset($valeur71)) { echo $valeur71; } ?>" /></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur72" id="valeur72" oninput="sumValues()" value="<?php if (isset($valeur72)) { echo $valeur72; } ?>" /></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur73" id="valeur73" oninput="sumValues()" value="<?php if (isset($valeur73)) { echo $valeur73; } ?>" /></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur74" id="valeur74" oninput="sumValues()" value="<?php if (isset($valeur74)) { echo $valeur74; } ?>" /></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur75" id="valeur75" oninput="sumValues()" value="<?php if (isset($valeur75)) { echo $valeur75; } ?>" /></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur76" id="valeur76" oninput="sumValues()" value="<?php if (isset($valeur76)) { echo $valeur76; } ?>" /></td>
            </tr>

            <tr class="row12">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur77" id="valeur77" oninput="sumValues()" value="<?php if (isset($valeur77)) { echo $valeur77; } ?>" /></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur78" id="valeur78" oninput="sumValues()" value="<?php if (isset($valeur78)) { echo $valeur78; } ?>" /></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur79" id="valeur79" oninput="sumValues()" value="<?php if (isset($valeur79)) { echo $valeur79; } ?>" /></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur80" id="valeur80" oninput="sumValues()" value="<?php if (isset($valeur80)) { echo $valeur80; } ?>" /></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur81" id="valeur81" oninput="sumValues()" value="<?php if (isset($valeur81)) { echo $valeur81; } ?>" /></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur82" id="valeur82" oninput="sumValues()" value="<?php if (isset($valeur82)) { echo $valeur82; } ?>" /></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur83" id="valeur83" oninput="sumValues()" value="<?php if (isset($valeur83)) { echo $valeur83; } ?>" /></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur84" id="valeur84" oninput="sumValues()" value="<?php if (isset($valeur84)) { echo $valeur84; } ?>" /></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur85" id="valeur85" oninput="sumValues()" value="<?php if (isset($valeur85)) { echo $valeur85; } ?>" /></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur86" id="valeur86" oninput="sumValues()" value="<?php if (isset($valeur86)) { echo $valeur86; } ?>" /></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur87" id="valeur87" oninput="sumValues()" value="<?php if (isset($valeur87)) { echo $valeur87; } ?>" /></td>
            </tr>

            <tr class="row13">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur88" id="valeur88" oninput="sumValues()" value="<?php if (isset($valeur88)) { echo $valeur88; } ?>" /></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur89" id="valeur89" oninput="sumValues()" value="<?php if (isset($valeur89)) { echo $valeur89; } ?>" /></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur90" id="valeur90" oninput="sumValues()" value="<?php if (isset($valeur90)) { echo $valeur90; } ?>" /></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur91" id="valeur91" oninput="sumValues()" value="<?php if (isset($valeur91)) { echo $valeur91; } ?>" /></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur92" id="valeur92" oninput="sumValues()" value="<?php if (isset($valeur92)) { echo $valeur92; } ?>" /></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur93" id="valeur93" oninput="sumValues()" value="<?php if (isset($valeur93)) { echo $valeur93; } ?>" /></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur94" id="valeur94" oninput="sumValues()" value="<?php if (isset($valeur94)) { echo $valeur94; } ?>" /></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur95" id="valeur95" oninput="sumValues()" value="<?php if (isset($valeur95)) { echo $valeur95; } ?>" /></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur96" id="valeur96" oninput="sumValues()" value="<?php if (isset($valeur96)) { echo $valeur96; } ?>" /></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur97" id="valeur97" oninput="sumValues()" value="<?php if (isset($valeur97)) { echo $valeur97; } ?>" /></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur98" id="valeur98" oninput="sumValues()" value="<?php if (isset($valeur98)) { echo $valeur98; } ?>" /></td>
            </tr>

            <tr class="row14">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur99" id="valeur99" oninput="sumValues()" value="<?php if (isset($valeur99)) { echo $valeur99; } ?>" /></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur100" id="valeur100" oninput="sumValues()" value="<?php if (isset($valeur100)) { echo $valeur100; } ?>" /></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur101" id="valeur101" oninput="sumValues()" value="<?php if (isset($valeur101)) { echo $valeur101; } ?>" /></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur102" id="valeur102" oninput="sumValues()" value="<?php if (isset($valeur102)) { echo $valeur102; } ?>" /></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur103" id="valeur103" oninput="sumValues()" value="<?php if (isset($valeur103)) { echo $valeur103; } ?>" /></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur104" id="valeur104" oninput="sumValues()" value="<?php if (isset($valeur104)) { echo $valeur104; } ?>" /></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur105" id="valeur105" oninput="sumValues()" value="<?php if (isset($valeur105)) { echo $valeur105; } ?>" /></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur106" id="valeur106" oninput="sumValues()" value="<?php if (isset($valeur106)) { echo $valeur106; } ?>" /></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur107" id="valeur107" oninput="sumValues()" value="<?php if (isset($valeur107)) { echo $valeur107; } ?>" /></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur108" id="valeur108" oninput="sumValues()" value="<?php if (isset($valeur108)) { echo $valeur108; } ?>" /></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur109" id="valeur109" oninput="sumValues()" value="<?php if (isset($valeur109)) { echo $valeur109; } ?>" /></td>
            </tr>

            <tr class="row15">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur110" id="valeur110" oninput="sumValues()" value="<?php if (isset($valeur110)) { echo $valeur110; } ?>" /></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur111" id="valeur111" oninput="sumValues()" value="<?php if (isset($valeur111)) { echo $valeur111; } ?>" /></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur112" id="valeur112" oninput="sumValues()" value="<?php if (isset($valeur112)) { echo $valeur112; } ?>" /></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur113" id="valeur113" oninput="sumValues()" value="<?php if (isset($valeur113)) { echo $valeur113; } ?>" /></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur114" id="valeur114" oninput="sumValues()" value="<?php if (isset($valeur114)) { echo $valeur114; } ?>" /></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur115" id="valeur115" oninput="sumValues()" value="<?php if (isset($valeur115)) { echo $valeur115; } ?>" /></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur116" id="valeur116" oninput="sumValues()" value="<?php if (isset($valeur116)) { echo $valeur116; } ?>" /></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur117" id="valeur117" oninput="sumValues()" value="<?php if (isset($valeur117)) { echo $valeur117; } ?>" /></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur118" id="valeur118" oninput="sumValues()" value="<?php if (isset($valeur118)) { echo $valeur118; } ?>" /></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur119" id="valeur119" oninput="sumValues()" value="<?php if (isset($valeur119)) { echo $valeur119; } ?>" /></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur120" id="valeur120" oninput="sumValues()" value="<?php if (isset($valeur120)) { echo $valeur120; } ?>" /></td>
            </tr>

            
            <tr class="row16">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur121" id="valeur121" oninput="sumValues()" value="<?php if (isset($valeur121)) { echo $valeur121; } ?>" /></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur122" id="valeur122" oninput="sumValues()" value="<?php if (isset($valeur122)) { echo $valeur122; } ?>" /></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur123" id="valeur123" oninput="sumValues()" value="<?php if (isset($valeur123)) { echo $valeur123; } ?>" /></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur124" id="valeur124" oninput="sumValues()" value="<?php if (isset($valeur124)) { echo $valeur124; } ?>" /></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur125" id="valeur125" oninput="sumValues()" value="<?php if (isset($valeur125)) { echo $valeur125; } ?>" /></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur126" id="valeur126" oninput="sumValues()" value="<?php if (isset($valeur126)) { echo $valeur126; } ?>" /></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur127" id="valeur127" oninput="sumValues()" value="<?php if (isset($valeur127)) { echo $valeur127; } ?>" /></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur128" id="valeur128" oninput="sumValues()" value="<?php if (isset($valeur128)) { echo $valeur128; } ?>" /></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur129" id="valeur129" oninput="sumValues()" value="<?php if (isset($valeur129)) { echo $valeur129; } ?>" /></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur130" id="valeur130" oninput="sumValues()" value="<?php if (isset($valeur130)) { echo $valeur130; } ?>" /></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur131" id="valeur131" oninput="sumValues()" value="<?php if (isset($valeur131)) { echo $valeur131; } ?>" /></td>
            </tr>

            <tr class="row17">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur132" id="valeur132" oninput="sumValues()" value="<?php if (isset($valeur132)) { echo $valeur132; } ?>" /></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur133" id="valeur133" oninput="sumValues()" value="<?php if (isset($valeur133)) { echo $valeur133; } ?>" /></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur134" id="valeur134" oninput="sumValues()" value="<?php if (isset($valeur134)) { echo $valeur134; } ?>" /></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur135" id="valeur135" oninput="sumValues()" value="<?php if (isset($valeur135)) { echo $valeur135; } ?>" /></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur136" id="valeur136" oninput="sumValues()" value="<?php if (isset($valeur136)) { echo $valeur136; } ?>" /></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur137" id="valeur137" oninput="sumValues()" value="<?php if (isset($valeur137)) { echo $valeur137; } ?>" /></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur138" id="valeur138" oninput="sumValues()" value="<?php if (isset($valeur138)) { echo $valeur138; } ?>" /></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur139" id="valeur139" oninput="sumValues()" value="<?php if (isset($valeur139)) { echo $valeur139; } ?>" /></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur140" id="valeur140" oninput="sumValues()" value="<?php if (isset($valeur140)) { echo $valeur140; } ?>" /></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur141" id="valeur141" oninput="sumValues()" value="<?php if (isset($valeur141)) { echo $valeur141; } ?>" /></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur142" id="valeur142" oninput="sumValues()" value="<?php if (isset($valeur142)) { echo $valeur142; } ?>" /></td>
            </tr>

            <tr class="row18">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur143" id="valeur143" oninput="sumValues()" value="<?php if (isset($valeur143)) { echo $valeur143; } ?>" /></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur144" id="valeur144" oninput="sumValues()" value="<?php if (isset($valeur144)) { echo $valeur144; } ?>" /></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur145" id="valeur145" oninput="sumValues()" value="<?php if (isset($valeur145)) { echo $valeur145; } ?>" /></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur146" id="valeur146" oninput="sumValues()" value="<?php if (isset($valeur146)) { echo $valeur146; } ?>" /></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur147" id="valeur147" oninput="sumValues()" value="<?php if (isset($valeur147)) { echo $valeur147; } ?>" /></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur148" id="valeur148" oninput="sumValues()" value="<?php if (isset($valeur148)) { echo $valeur148; } ?>" /></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur149" id="valeur149" oninput="sumValues()" value="<?php if (isset($valeur149)) { echo $valeur149; } ?>" /></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur150" id="valeur150" oninput="sumValues()" value="<?php if (isset($valeur150)) { echo $valeur150; } ?>" /></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur151" id="valeur151" oninput="sumValues()" value="<?php if (isset($valeur151)) { echo $valeur151; } ?>" /></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur152" id="valeur152" oninput="sumValues()" value="<?php if (isset($valeur152)) { echo $valeur152; } ?>" /></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur153" id="valeur153" oninput="sumValues()" value="<?php if (isset($valeur153)) { echo $valeur153; } ?>" /></td>
            </tr>

            
            <tr class="row19">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur154" id="valeur154" oninput="sumValues()" value="<?php if (isset($valeur154)) { echo $valeur154; } ?>" /></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur155" id="valeur155" oninput="sumValues()" value="<?php if (isset($valeur155)) { echo $valeur155; } ?>" /></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur156" id="valeur156" oninput="sumValues()" value="<?php if (isset($valeur156)) { echo $valeur156; } ?>" /></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur157" id="valeur157" oninput="sumValues()" value="<?php if (isset($valeur157)) { echo $valeur157; } ?>" /></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur158" id="valeur158" oninput="sumValues()" value="<?php if (isset($valeur158)) { echo $valeur158; } ?>" /></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur159" id="valeur159" oninput="sumValues()" value="<?php if (isset($valeur159)) { echo $valeur159; } ?>" /></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur160" id="valeur160" oninput="sumValues()" value="<?php if (isset($valeur160)) { echo $valeur160; } ?>" /></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur161" id="valeur161" oninput="sumValues()" value="<?php if (isset($valeur161)) { echo $valeur161; } ?>" /></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur162" id="valeur162" oninput="sumValues()" value="<?php if (isset($valeur162)) { echo $valeur162; } ?>" /></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur163" id="valeur163" oninput="sumValues()" value="<?php if (isset($valeur163)) { echo $valeur163; } ?>" /></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur164" id="valeur164" oninput="sumValues()" value="<?php if (isset($valeur164)) { echo $valeur164; } ?>" /></td>
            </tr>

            <tr class="row20">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur165" id="valeur165" oninput="sumValues()" value="<?php if (isset($valeur165)) { echo $valeur165; } ?>" /></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur166" id="valeur166" oninput="sumValues()" value="<?php if (isset($valeur166)) { echo $valeur166; } ?>" /></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur167" id="valeur167" oninput="sumValues()" value="<?php if (isset($valeur167)) { echo $valeur167; } ?>" /></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur168" id="valeur168" oninput="sumValues()" value="<?php if (isset($valeur168)) { echo $valeur168; } ?>" /></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur169" id="valeur169" oninput="sumValues()" value="<?php if (isset($valeur169)) { echo $valeur169; } ?>" /></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur170" id="valeur170" oninput="sumValues()" value="<?php if (isset($valeur170)) { echo $valeur170; } ?>" /></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur171" id="valeur171" oninput="sumValues()" value="<?php if (isset($valeur171)) { echo $valeur171; } ?>" /></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur172" id="valeur172" oninput="sumValues()" value="<?php if (isset($valeur172)) { echo $valeur172; } ?>" /></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur173" id="valeur173" oninput="sumValues()" value="<?php if (isset($valeur173)) { echo $valeur173; } ?>" /></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur174" id="valeur174" oninput="sumValues()" value="<?php if (isset($valeur174)) { echo $valeur174; } ?>" /></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur175" id="valeur175" oninput="sumValues()" value="<?php if (isset($valeur175)) { echo $valeur175; } ?>" /></td>
            </tr>

            <tr class="row21">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur176" id="valeur176" oninput="sumValues()" value="<?php if (isset($valeur176)) { echo $valeur176; } ?>" /></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur177" id="valeur177" oninput="sumValues()" value="<?php if (isset($valeur177)) { echo $valeur177; } ?>" /></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur178" id="valeur178" oninput="sumValues()" value="<?php if (isset($valeur178)) { echo $valeur178; } ?>" /></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur179" id="valeur179" oninput="sumValues()" value="<?php if (isset($valeur179)) { echo $valeur179; } ?>" /></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur180" id="valeur180" oninput="sumValues()" value="<?php if (isset($valeur180)) { echo $valeur180; } ?>" /></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur181" id="valeur181" oninput="sumValues()" value="<?php if (isset($valeur181)) { echo $valeur181; } ?>" /></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur182" id="valeur182" oninput="sumValues()" value="<?php if (isset($valeur182)) { echo $valeur182; } ?>" /></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur183" id="valeur183" oninput="sumValues()" value="<?php if (isset($valeur183)) { echo $valeur183; } ?>" /></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur184" id="valeur184" oninput="sumValues()" value="<?php if (isset($valeur184)) { echo $valeur184; } ?>" /></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur185" id="valeur185" oninput="sumValues()" value="<?php if (isset($valeur185)) { echo $valeur185; } ?>" /></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder=" " required name="valeur186" id="valeur186" oninput="sumValues()" value="<?php if (isset($valeur186)) { echo $valeur186; } ?>" /></td>
            </tr>

            <tr class="row22">
            <td class="column0 style21 null"><input type="text" min="0" step="any" style="width: 86.07777679pt;text-align:center;" placeholder=" " required name="valeur187" id="valeur187" oninput="sumValues()" value="<?php if (isset($valeur187)) { echo $valeur187; } ?>" /></td>
            <td class="column1 style22 null"><input type="date" min="0" step="any" style="width: 46.76666613pt;text-align:center;" placeholder="0" required name="valeur188" id="valeur188" oninput="sumValues()" value="<?php if (isset($valeur188)) { echo $valeur188; } ?>" /></td>
            <td class="column2 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur189" id="valeur189" oninput="sumValues()" value="<?php if (isset($valeur189)) { echo $valeur189; } ?>" /></td>
            <td class="column3 style23 null"><input type="number" min="0" step="any" style="width: 69.81111031pt;text-align:center;" placeholder="0" required name="valeur190" id="valeur190" oninput="sumValues()" value="<?php if (isset($valeur190)) { echo $valeur190; } ?>" /></td>
            <td class="column4 style21 null"><input type="number" min="0" step="any" style="width: 37.95555512pt;text-align:center;" placeholder="0" required name="valeur191" id="valeur191" oninput="sumValues()" value="<?php if (isset($valeur191)) { echo $valeur191; } ?>" /></td>
            <td class="column5 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur192" id="valeur192" oninput="sumValues()" value="<?php if (isset($valeur192)) { echo $valeur192; } ?>" /></td>
            <td class="column6 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur193" id="valeur193" oninput="sumValues()" value="<?php if (isset($valeur193)) { echo $valeur193; } ?>" /></td>
            <td class="column7 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur194" id="valeur194" oninput="sumValues()" value="<?php if (isset($valeur194)) { echo $valeur194; } ?>" /></td>
            <td class="column8 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur195" id="valeur195" oninput="sumValues()" value="<?php if (isset($valeur195)) { echo $valeur195; } ?>" /></td>
            <td class="column9 style23 null"><input type="number" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="0" required name="valeur196" id="valeur196" oninput="sumValues()" value="<?php if (isset($valeur196)) { echo $valeur196; } ?>" /></td>
            <td class="column10 style23 null"><input type="text" min="0" step="any" style="width: 59.64444376pt;text-align:center;" placeholder="   " required name="valeur197" id="valeur197" oninput="sumValues()" value="<?php if (isset($valeur197)) { echo $valeur197; } ?>" /></td>
            </tr>
          
          <!-- <tr class="row23">
            <td class="column0 style28 s">Total</td>
            <td class="column1 style29 null"></td>
            <td class="column2 style30 null"></td>
            <td class="column3 style31 f"><p id="result"></p></td>
            <td class="column4 style32 s">-</td>
            <td class="column5 style31 f" ><p id="result1"></p></td>
            <td class="column6 style31 f" ><p id="result2"></p></td>
            <td class="column7 style31 f" ><p id="result3"></p></td>
            <td class="column8 style31 f" ><p id="result4"></p></td>
            <td class="column9 style31 f" ><p id="result5"></p></td>
            <td class="column10 style32 s">-</td>
            <td class="column11 style7 s">GrasDroite</td>
          </tr>  -->
        </tbody>
    </table>
    <center>
    <button type="submit" name="chargement" 
    style="margin-top: 18px;background: #4B99AD;padding: 8px 15px 8px 15px;border: none;color: #fff;">Chargement</button><br> 
    </center>
    
</form>


<div style="width: 650px; margin: 0 auto; text-align: center;">
    <!-- <div style="margin-top: 10px;margin-right : 80px;">
      <?php  GenerateDocuments(); ?>
    </div> -->

    <div style="margin-top: 10px;margin-left : 80px;">
      <?php   ShowDocuments(); ?>
    </div>
  </div>

  </body>
</html>
