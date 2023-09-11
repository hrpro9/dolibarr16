<?php

require_once 'codeEtatAffectation.php';



  $object = new User($db);
  $id=$user->id;
  
  function GenerateDocuments($dateChoisist)
 {
    global $day, $month, $year, $start, $prev_year;
    print '<form id="frmgen" name="builddoc" method="post">';
    print '<input type="hidden" name="token" value="' . newToken() . '">';
    print '<input type="hidden" name="action" value="builddoc">';
    print '<input type="hidden" name="model" value="EtatAffectation">';
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
      $filedir = DOL_DATA_ROOT . '/billanLaisse/EtatAffectation/';
      $urlsource = $_SERVER['PHP_SELF'] . '';
      $genallowed = 0;
      $delallowed = 1;
      $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

   

    if ($societe !== null && isset($societe->default_lang)) {
      print $formfile->showdocuments('EtatAffectation', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
    } else {
        print $formfile->showdocuments('EtatAffectation', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
    }

   //  print $formfile->showdocuments('Passif', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
  }

  

  llxHeader("", ""); 


  
// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/EtatAffectation/';
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
      td.style2 { vertical-align:middle; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style2 { vertical-align:middle; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style3 { vertical-align:middle; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style3 { vertical-align:middle; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style4 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style4 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style5 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style5 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style6 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style6 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style8 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style8 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style9 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style9 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style10 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style10 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style11 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style11 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style12 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style12 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style13 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style13 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style14 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style14 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style15 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style15 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style16 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style16 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style17 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style17 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style18 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style18 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style19 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style19 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style20 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style20 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style21 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style21 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style22 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style22 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style23 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style23 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style24 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style24 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style25 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style25 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style26 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style26 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style27 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style27 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style28 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style28 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style29 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style29 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style30 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style30 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style31 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style31 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style32 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style32 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style33 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style33 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style34 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style34 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style35 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style35 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style36 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style36 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style37 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style37 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      table.sheet0 col.col0 { width:176.2222202pt }
      table.sheet0 col.col1 { width:72.52222139pt }
      table.sheet0 col.col2 { width:176.2222202pt }
      table.sheet0 col.col3 { width:72.52222139pt }
      table.sheet0 col.col4 { width:0pt }
      table.sheet0 col.col5 { width:49.47777721pt }
      table.sheet0 col.col6 { width:49.47777721pt }
      table.sheet0 col.col7 { width:49.47777721pt }
      table.sheet0 col.col8 { width:0pt }
      table.sheet0 col.col9 { width:0pt }
      table.sheet0 col.col10 { width:49.47777721pt }
      table.sheet0 .column4 { visibility:collapse; display:none }
      table.sheet0 .column8 { visibility:collapse; display:none }
      table.sheet0 .column9 { visibility:collapse; display:none }
      table.sheet0 tr { height:16.363636363636pt }
      table.sheet0 tr.row0 { height:20pt }
      table.sheet0 tr.row1 { height:15pt }
      table.sheet0 tr.row3 { height:16.363636363636pt }
      table.sheet0 tr.row4 { height:16.363636363636pt }
      table.sheet0 tr.row5 { height:16.363636363636pt }
      table.sheet0 tr.row6 { height:16pt }
      table.sheet0 tr.row7 { height:16.363636363636pt }
      table.sheet0 tr.row8 { height:16.363636363636pt }
      table.sheet0 tr.row9 { height:16pt }
    </style>
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
        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style3" colspan="4">ETAT D'AFFECTATION DES RESULTATS INTERVENUE AU COURS DE L'EXERCICE</td>
            <td class="column4 style4 null"></td>
          </tr>
          <tr class="row1">
            <td class="column0 style7 f"></td>
            <td class="column1 style8 null"></td>
            <td class="column2 style9 null"></td>
            <td class="column3 style10 f"></td>
            <td class="column4 style11 null"></td>
            <td class="column8 style13 null"></td>
            <td class="column9 style13 null"></td>
          </tr>
          <tr class="row2">
            <td class="column0 style14 s">A. ORIGINE DES RESULTATS A AFFECTER</td>
            <td class="column1 style14 s">Montant</td>
            <td class="column2 style14 s">B. AFFECTATION DES RESULTATS</td>
            <td class="column3 style14 s">Montant</td>
            <td class="column4 style4 null"></td>
          </tr>
          <tr class="row3">
            <td class="column0 style15 n">
            <?php
            for ($i = 1; $i <=1; $i++) {
                echo '<input required min="0" type="text" required style="width: 225px;" name="etataffectation' . $i . '" id="etataffectation' . $i . '" value="';
                if (isset(${"etataffectation" . $i})) {
                    echo ${"etataffectation" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?></td>
            <td class="column1 style16 null"></td>
            <td class="column2 style17 s">- Réserve légale</td>
            <td class="column3 style18 f">
            <?php
            for ($i = 2; $i <=2; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="etataffectation' . $i . '" id="etataffectation' . $i . '" value="';
                if (isset(${"etataffectation" . $i})) {
                    echo ${"etataffectation" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
            </td>
            <td class="column4 style19 null"></td>
            <td class="column8 style6 null"></td>
            <td class="column9 style6 s">114</td>
          </tr>
          <tr class="row4">
            <td class="column0 style21 s">- Report à nouveau</td>
            <td class="column1 style22 f">
            <?php
            for ($i = 3; $i <=3; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="etataffectation' . $i . '" id="etataffectation' . $i . '" value="';
                if (isset(${"etataffectation" . $i})) {
                    echo ${"etataffectation" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
            </td>
            <td class="column2 style21 s">- Autres réserves</td>
            <td class="column3 style23 f">
            <?php
            for ($i = 4; $i <=4; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="etataffectation' . $i . '" id="etataffectation' . $i . '" value="';
                if (isset(${"etataffectation" . $i})) {
                    echo ${"etataffectation" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
            </td>
            <td class="column4 style19 null"></td>
            <td class="column8 style6 n">116</td>
            <td class="column9 style6 s">115</td>
          </tr>
          <tr class="row5">
            <td class="column0 style21 s">- Résultats nets en instance d'affectation</td>
            <td class="column1 style22 f">
              <?php
            for ($i = 5; $i <=5; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="etataffectation' . $i . '" id="etataffectation' . $i . '" value="';
                if (isset(${"etataffectation" . $i})) {
                    echo ${"etataffectation" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?></td>
            <td class="column2 style21 s">- Tantièmes</td>
            <td class="column3 style24 null">
            <?php
            for ($i = 6; $i <=6; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="etataffectation' . $i . '" id="etataffectation' . $i . '" value="';
                if (isset(${"etataffectation" . $i})) {
                    echo ${"etataffectation" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
            </td>
            <td class="column4 style19 null"></td>
            <td class="column8 style6 n">118</td>
            <td class="column9 style6 null"></td>
          </tr>
          <tr class="row6">
            <td class="column0 style21 s">- Résultat net de l'exercice N-1</td>
            <td class="column1 style22 f">
            <?php
            for ($i = 7; $i <=7; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="etataffectation' . $i . '" id="etataffectation' . $i . '" value="';
                if (isset(${"etataffectation" . $i})) {
                    echo ${"etataffectation" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
            </td>
            <td class="column2 style21 s">- Dividendes</td>
            <td class="column3 style23 f">
            <?php
            for ($i = 8; $i <=8; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="etataffectation' . $i . '" id="etataffectation' . $i . '" value="';
                if (isset(${"etataffectation" . $i})) {
                    echo ${"etataffectation" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
            </td>
            <td class="column4 style19 null"></td>
            <td class="column8 style6 n">119</td>
            <td class="column9 style25 n">446</td>
          </tr>
          <tr class="row7">
            <td class="column0 style21 s">- Prélèvements sur les réserves</td>
            <td class="column1 style23 null">
            <?php
            for ($i = 9; $i <=9; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="etataffectation' . $i . '" id="etataffectation' . $i . '" value="';
                if (isset(${"etataffectation" . $i})) {
                    echo ${"etataffectation" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
            </td>
            <td class="column2 style21 s">- Autres affectations</td>
            <td class="column3 style24 null">
            <?php
            for ($i = 10; $i <=10; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="etataffectation' . $i . '" id="etataffectation' . $i . '" value="';
                if (isset(${"etataffectation" . $i})) {
                    echo ${"etataffectation" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
            </td>
            <td class="column4 style19 null"></td>
            <td class="column8 style6 n">115</td>
            <td class="column9 style6 null"></td>
          </tr>
          <tr class="row8">
            <td class="column0 style26 s">- Autres prélèvements</td>
            <td class="column1 style27 null">
            <?php
            for ($i = 11; $i <=11; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="etataffectation' . $i . '" id="etataffectation' . $i . '" value="';
                if (isset(${"etataffectation" . $i})) {
                    echo ${"etataffectation" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
            </td>
            <td class="column2 style26 s">- Report à nouveau</td>
            <td class="column3 style28 f">
            <?php
            for ($i = 12; $i <=12; $i++) {
                echo '<input required min="0" type="text" required style="width: 125px;" name="etataffectation' . $i . '" id="etataffectation' . $i . '" value="';
                if (isset(${"etataffectation" . $i})) {
                    echo ${"etataffectation" . $i};
                }
                echo '" />' . "\n";
            }                 
        ?>
            </td>
            <td class="column4 style19 null"></td>
            <td class="column8 style6 null"></td>
          </tr>
          <tr class="row9">
            <td class="column0 style29 s">Total A</td>
            <td class="column1 style30 f"><?php readMontant($TotalA)?></td>
            <td class="column2 style29 s">Total B</td>
            <td class="column3 style30 f"><?php readMontant($TotalB)?></td>
            <td class="column4 style31 s">GrasDroite</td>
            <td class="column8 style6 null"></td>
            <td class="column9 style6 null"></td>
          </tr>
        
        </tbody>
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
  </body>
</html>
