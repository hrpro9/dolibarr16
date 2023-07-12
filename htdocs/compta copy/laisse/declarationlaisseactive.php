<?php

require_once 'codeLaisseActive.php';
    // Load Dolibarr environment
 

    $object = new User($db);
    $id=$user->id;
    
  function GenerateDocuments($dateChoisist)
  {
     global $day, $month, $year, $start, $prev_year;
     print '<form id="frmgen" name="builddoc" method="post">';
     print '<input type="hidden" name="token" value="' . newToken() . '">';
     print '<input type="hidden" name="action" value="builddoc">';
     print '<input type="hidden" name="model" value="Active">';
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
       $filedir = DOL_DATA_ROOT . '/billanLaisse/billan_Active/';
       $urlsource = $_SERVER['PHP_SELF'] . '';
       $genallowed = 0;
       $delallowed = 1;
       $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));
 
    
 
     if ($societe !== null && isset($societe->default_lang)) {
       print $formfile->showdocuments('Active', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
     } else {
         print $formfile->showdocuments('Active', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
     }
 
    //  print $formfile->showdocuments('Passif', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
   }
 

    llxHeader("", "");

    
  
// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/billan_Active/';
$permissiontoadd = 1;
$donotredirect = 1;

include DOL_DOCUMENT_ROOT . '/core/actions_builddoc.inc.php';
     
  



    
  

?>

<!DOCTYPE html>
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
      td.style1 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style1 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style2 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:12pt; background-color:white }
      th.style2 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:12pt; background-color:white }
      td.style3 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style3 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style4 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style4 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style5 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style5 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style6 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style6 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style7 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:11pt; background-color:white }
      th.style7 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Tahoma'; font-size:11pt; background-color:white }
      td.style8 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style8 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style9 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style9 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style10 { vertical-align:bottom; text-align:center; padding-right:0px; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style10 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style11 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style11 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style12 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style12 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style13 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style13 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style14 { vertical-align:bottom; text-align:center; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style14 { vertical-align:bottom; text-align:center; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style15 { vertical-align:bottom; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style15 { vertical-align:bottom; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style16 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style16 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style17 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style17 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style18 { vertical-align:bottom; text-align:center; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style18 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style19 { vertical-align:bottom; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style19 { vertical-align:bottom; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style20 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style20 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style21 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style21 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style22 { vertical-align:bottom; text-align:center; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style22 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style23 { vertical-align:bottom; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style23 { vertical-align:bottom; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style24 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style24 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style25 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style25 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style26 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style26 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style27 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style27 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style28 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style28 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style29 { vertical-align:bottom; text-align:center; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style29 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style30 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#808080 }
      th.style30 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#808080 }
      td.style31 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style31 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style32 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style32 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style33 { vertical-align:bottom; text-align:center; padding-right:0px; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style33 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style34 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style34 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style35 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style35 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style36 { vertical-align:bottom; text-align:center; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style36 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style37 { vertical-align:bottom; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style37 { vertical-align:bottom; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style38 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style38 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style39 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style39 { vertical-align:bottom; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style40 { vertical-align:bottom; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style40 { vertical-align:bottom; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style41 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style41 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style42 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style42 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style43 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style43 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style44 { vertical-align:bottom; text-align:center; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style44 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style45 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#808080 }
      th.style45 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#808080 }
      td.style46 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style46 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style47 { vertical-align:bottom; text-align:center; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style47 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style48 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#808080 }
      th.style48 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#808080 }
      td.style49 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style49 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style50 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style50 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style51 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style51 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style52 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style52 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style53 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style53 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style54 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      th.style54 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      td.style55 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      th.style55 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      td.style56 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      th.style56 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      td.style57 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      th.style57 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      td.style58 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      th.style58 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      td.style59 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      th.style59 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      td.style60 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      th.style60 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      td.style61 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      th.style61 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      td.style62 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      th.style62 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      td.style63 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      th.style63 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      td.style64 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      th.style64 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#D8D8D8 }
      td.style65 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:11pt; background-color:white }
      th.style65 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:11pt; background-color:white }
      td.style66 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style66 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style67 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style67 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style68 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style68 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style69 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style69 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style70 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:16pt; background-color:white }
      th.style70 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:16pt; background-color:white }
      td.style71 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      th.style71 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      td.style72 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      th.style72 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      table.sheet0 col.col0 { width:211.46666424pt }
      table.sheet0 col.col1 { width:42pt }
      table.sheet0 col.col2 { width:42pt }
      table.sheet0 col.col3 { width:42pt }
      table.sheet0 col.col4 { width:42pt }
      table.sheet0 col.col5 { width:42pt }
      table.sheet0 col.col6 { width:42pt }
      table.sheet0 tr { height:16.363636363636pt }
      table.sheet0 tr.row0 { height:22pt }
      table.sheet0 tr.row3 { height:32pt }
      table.sheet0 tr.row29 { height:17pt }
      table.sheet0 tr.row30 { height:17pt }
      table.sheet0 tr.row46 { height:17pt }
      table.sheet0 tr.row47 { height:17pt }
      table.sheet0 tr.row51 { height:17pt }
      table.sheet0 tr.row52 { height:17pt }
    </style>
  </head>

  <body>

<center>
  <form method="POST" >
    <select name="date_select"><?php affichageAnnees()?></select>
    <button type="submit" name="chargement" 
    style="margin-top: 18px;background: #4B99AD;padding: 8px 15px 8px 15px;border: none;color: #fff;">Chargement</button><br>  
  </form>
    <br>
    <?php

    $date=(!empty($dateChoisis))?$dateChoisis:date('Y');
    
    echo'<input type="text" style="text-align:center;font-weight:bold;" value="Année chargé : '.$date.'"disabled/>';
   
    ?>
  <br><br> 
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines" >
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <tbody style="text-align: center;">
          <tr class="row0">
            <td class="column0 style72 s style71" colspan="5">BILAN - ACTIF</td>
            <td class="column5 style70 null"></td>
            <td class="column6 style70 null"></td>
          </tr>
          <tr class="row1">
            <td class="column0 style68 null"></td>
            <td class="column1 style69 null"></td>
            <td class="column2 style68 null"></td>
            <td class="column3 style67 null"></td>
            <td class="column5 style65 null"></td>
            <td class="column6 style65 null"></td>
          </tr>
          <tr class="row2">
            <td class="column0 style64 null style58" rowspan="2"></td>
            <td class="column1 style63 s style61" colspan="3">Exercice</td>
            <td class="column4 style60 s style55" rowspan="2">Exercice Précédent</td>
            <td class="column5 style12 null"></td>
            <td class="column6 style59 s style54" rowspan="2">Exercice N-2</td>
          </tr>
          <tr class="row3">
            <td class="column1 style57 s">Brut</td>
            <td class="column2 style57 s">Amort. &amp; Prov.</td>
            <td class="column3 style56 s">Net</td>
            <td class="column5 style12 null"></td>
          </tr>
          <tr class="row4">
            <td class="column0 style53 s">IMMOBILISATION EN NON VALEUR ( a )</td>
            <td class="column1 style27 null"><?php readMontant($immNonVal_B)?></td>
            <td class="column2 style27 null"><?php readMontant($immNonVal_AP)?></td>
            <td class="column3 style38 null"><?php readMontant($immNonVal_net)?></td>
            <td class="column4 style28 null"><?php readMontant($immNonVal_EP)?></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style27 null"><?php readMontant($immNonVal_E2)?></td>
          </tr>
          <tr class="row5">
            <td class="column0 style19 s">Frais préliminaires</td>
            <td class="column1 style52 null"><?php readMontant($fraisP_B)?></td>
            <td class="column2 style16 null"><?php readMontant($fraisP_AP*-1)?></td>
            <td class="column3 style18 null"><?php readMontant($fraisP_B-($fraisP_AP*-1))?></td>
            <td class="column4 style17 null"><?php readMontant($fraisP_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style16 null"><?php readMontant($fraisP_E2)?></td>
          </tr>
          <tr class="row6">
            <td class="column0 style19 s">Charges à repartir sur plusieurs exercices</td>
            <td class="column1 style16 null"><?php readMontant($chargesR_B)?></td>
            <td class="column2 style16 null"><?php readMontant($chargesR_AP*-1)?></td>
            <td class="column3 style18 null"><?php readMontant($chargesR_B-($chargesR_AP*-1))?></td>
            <td class="column4 style17 null"><?php readMontant($chargesR_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style16 null"><?php readMontant($chargesR_E2)?></td>
          </tr>
          <tr class="row7">
            <td class="column0 style15 s">Primes de remboursement des obligations</td>
            <td class="column1 style11 null"><?php readMontant($primesR_B)?></td>
            <td class="column2 style11 null"><?php readMontant($primesR_AP*-1)?></td>
            <td class="column3 style14 null"><?php readMontant($primesR_B-($primesR_AP*-1))?></td>
            <td class="column4 style13 null"><?php readMontant($primesR_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style11 null"><?php readMontant($primesR_E2)?></td>
          </tr>
          <tr class="row8">
            <td class="column0 style27 s">IMMOBILISATIONS INCORPORELLES ( b )</td>
            <td class="column1 style27 null"><?php readMontant($immIncor_B)?></td>
            <td class="column2 style27 null"><?php readMontant($immIncor_AP)?></td>
            <td class="column3 style38 null"><?php readMontant($immIncor_net)?></td>
            <td class="column4 style28 null"><?php readMontant($immIncor_EP)?></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style27 null"><?php readMontant($immIncor_E2)?></td>
          </tr>
          <tr class="row9">
            <td class="column0 style19 s">Immobilisations en recherche et développement</td>
            <td class="column1 style16 null"><?php readMontant($immReche_B)?></td>
            <td class="column2 style16 null"><?php readMontant($immReche_AP)?></td>
            <td class="column3 style18 null"><?php readMontant($immReche_B-$immReche_AP)?></td>  
            <td class="column4 style17 null"><?php readMontant($immReche_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style16 null"><?php readMontant($immReche_E2)?></td>
          </tr>
          <tr class="row10">
            <td class="column0 style19 s">Brevets, marques, droits et valeurs similaires</td>
            <td class="column1 style16 null"><?php readMontant($BMD_B)?></td>
            <td class="column2 style16 null"><?php readMontant($BMD_AP)?></td>
            <td class="column3 style18 null"><?php readMontant($BMD_B-$BMD_AP)?></td>
            <td class="column4 style17 null"><?php readMontant($BMD_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style16 null"><?php readMontant($BMD_E2)?></td>
          </tr>
          <tr class="row11">
            <td class="column0 style19 s">Fonds commercial</td>
            <td class="column1 style16 null"><?php readMontant($fondsC_B)?></td>
            <td class="column2 style16 null"><?php readMontant($fondsC_AP)?></td>
            <td class="column3 style18 null"><?php readMontant($fondsC_B-$fondsC_AP)?></td>
            <td class="column4 style17 null"><?php readMontant($fondsC_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style16 null"><?php readMontant($fondsC_E2)?></td>
          </tr>
          <tr class="row12">
            <td class="column0 style15 s">Autres immobilisations incorporelles</td>
            <td class="column1 style11 null"><?php readMontant($autresImmoInc_B)?></td>
            <td class="column2 style11 null"><?php readMontant($autresImmoInc_AP)?></td>
            <td class="column3 style14 null"><?php readMontant($autresImmoInc_B-$autresImmoInc_AP)?></td>
            <td class="column4 style13 null"><?php readMontant($autresImmoInc_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style11 null"><?php readMontant($autresImmoInc_E2)?></td>
          </tr>
          <tr class="row13">
            <td class="column0 style27 s">IMMOBILISATIONS CORPORELLES ( c )</td>
            <td class="column1 style27 null"><?php readMontant($immCor_B)?></td>
            <td class="column2 style27 null"><?php readMontant($immCor_AP)?></td>
            <td class="column3 style38 null"><?php readMontant($immCor_net)?></td>
            <td class="column4 style28 null"><?php readMontant($immCor_EP)?></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style27 null"><?php readMontant($immCor_E2)?></td>
          </tr>
          <tr class="row14">
            <td class="column0 style37 s">Terrains</td>
            <td class="column1 style34 null"><?php readMontant($terrains_B)?></td>
            <td class="column2 style34 null"><?php readMontant($terrains_AP)?></td>
            <td class="column3 style36 null"><?php readMontant($terrains_B-$terrains_AP)?></td>
            <td class="column4 style35 null"><?php readMontant($terrains_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($terrains_E2)?></td>
          </tr>
          <tr class="row15">
            <td class="column0 style19 s">Constructions</td>
            <td class="column1 style16 null"><?php readMontant($cons_B)?></td>
            <td class="column2 style16 null"><?php readMontant($cons_AP)?></td>
            <td class="column3 style18 null"><?php readMontant($cons_B-$cons_AP)?></td>
            <td class="column4 style35 null"><?php readMontant($cons_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($cons_E2)?></td>
          </tr>
          <tr class="row16">
            <td class="column0 style19 s">Installations techniques, matériel et outillage</td>
            <td class="column1 style16 null"><?php readMontant($instalTechMat_B)?></td>
            <td class="column2 style16 null"><?php readMontant($instalTechMat_AP)?></td>
            <td class="column3 style18 null"><?php readMontant($instalTechMat_B-$instalTechMat_AP)?></td>
            <td class="column4 style35 null"><?php readMontant($instalTechMat_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($instalTechMat_E2)?></td>
          </tr>
          <tr class="row17">
            <td class="column0 style19 s">Matériel de transport</td>
            <td class="column1 style16 null"><?php readMontant($matTransp_B)?></td>
            <td class="column2 style16 null"><?php readMontant($matTransp_AP)?></td>
            <td class="column3 style18 null"><?php readMontant($matTransp_B-$matTransp_AP)?></td>
            <td class="column4 style35 null"><?php readMontant($matTransp_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($matTransp_E2)?></td>
          </tr>
          <tr class="row18">
            <td class="column0 style19 s">Mobiliers, matériel de bureau et aménagements divers</td>
            <td class="column1 style16 null"><?php readMontant($mobMatAmenag_B)?></td>
            <td class="column2 style16 null"><?php readMontant($mobMatAmenag_AP)?></td>
            <td class="column3 style18 null"><?php readMontant($mobMatAmenag_B-$mobMatAmenag_AP)?></td>
            <td class="column4 style35 null"><?php readMontant($mobMatAmenag_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($mobMatAmenag_E2)?></td>
          </tr>
          <tr class="row19">
            <td class="column0 style19 s">Autres immobilisations corporelles</td>
            <td class="column1 style16 null"><?php readMontant($autresImmoCor_B)?></td>
            <td class="column2 style16 null"><?php readMontant($autresImmoCor_AP)?></td>
            <td class="column3 style18 null"><?php readMontant($autresImmoCor_B-$autresImmoCor_AP)?></td>
            <td class="column4 style35 null"><?php readMontant($autresImmoCor_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($autresImmoCor_E2)?></td>
          </tr>
          <tr class="row20">
            <td class="column0 style15 s">Immobilisations corporelles en cours</td>
            <td class="column1 style11 null"><?php readMontant($immCorEnCours_B)?></td>
            <td class="column2 style11 null"><?php readMontant($immCorEnCours_AP)?></td>
            <td class="column3 style14 null"><?php readMontant($immCorEnCours_B-$immCorEnCours_AP)?></td>
            <td class="column4 style13 null"><?php readMontant($immCorEnCours_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style11 null"><?php readMontant($immCorEnCours_E2)?></td>
          </tr>
          <tr class="row21">
            <td class="column0 style27 s">IMMOBILISATIONS FINANCIERES ( d )</td>
            <td class="column1 style27 null"><?php readMontant($immFin_B)?></td>
            <td class="column2 style27 null"><?php readMontant($immFin_AP)?></td>
            <td class="column3 style38 null"><?php readMontant($immFin_net)?></td>
            <td class="column4 style28 null"><?php readMontant($immFin_EP)?></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style27 null"><?php readMontant($immFin_E2)?></td>
          </tr>
          <tr class="row22">
            <td class="column0 style37 s">Prêts immobilisés</td>
            <td class="column1 style34 null"><?php readMontant($pretsImm_B)?></td>
            <td class="column2 style34 null"><?php readMontant($pretsImm_AP*-1)?></td>
            <td class="column3 style36 null"><?php readMontant($pretsImm_B-($pretsImm_AP*-1))?></td>
            <td class="column4 style35 null"><?php readMontant($pretsImm_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($pretsImm_E2)?></td>
          </tr>
          <tr class="row23">
            <td class="column0 style19 s">Autres créances financières</td>
            <td class="column1 style16 null"><?php readMontant($autresCreFin_B)?></td>
            <td class="column2 style16 null"><?php readMontant($autresCreFin_AP*-1)?></td>
            <td class="column3 style18 null"><?php readMontant($autresCreFin_B-($autresCreFin_AP*-1))?></td>
            <td class="column4 style17 null"><?php readMontant($autresCreFin_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style16 null"><?php readMontant($autresCreFin_E2)?></td>
          </tr>
          <tr class="row24">
            <td class="column0 style19 s">Titres de participation</td>
            <td class="column1 style16 null"><?php readMontant($titresP_B)?></td>
            <td class="column2 style16 null"><?php readMontant($titresP_AP*-1)?></td>
            <td class="column3 style18 null"><?php readMontant($titresP_B-($titresP_AP*-1))?></td>
            <td class="column4 style17 null"><?php readMontant($titresP_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style16 null"><?php readMontant($titresP_E2)?></td>
          </tr>
          <tr class="row25">
            <td class="column0 style15 s">Autres titres immobilisés</td>
            <td class="column1 style11 null"><?php readMontant($autresTitrImm_B)?></td>
            <td class="column2 style51 null"><?php readMontant($autresTitrImm_AP*-1)?></td>
            <td class="column3 style14 null"><?php readMontant($autresTitrImm_B-($autresTitrImm_AP*-1))?></td>
            <td class="column4 style13 null"><?php readMontant($autresTitrImm_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style11 null"><?php readMontant($autresTitrImm_E2)?></td>
          </tr>
          <tr class="row26">
            <td class="column0 style27 s">ECARTS DE CONVERSION - ACTIF ( e )</td>
            <td class="column1 style38 null"><?php readMontant($ecratsConv_B)?></td>
            <td class="column2 style30 null"></td>
            <td class="column3 style50 null"><?php readMontant($ecratsConv_net)?></td>
            <td class="column4 style28 null"><?php readMontant($ecratsConv_EP)?></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style27 null"><?php readMontant($ecratsConv_E2)?></td>
          </tr>
          <tr class="row27">
            <td class="column0 style23 s">Diminution des créances immobilisées</td>
            <td class="column1 style49 null"><?php readMontant($dimCreImm_B)?></td>
            <td class="column2 style48 null"></td>
            <td class="column3 style47 null"><?php readMontant($dimCreImm_B-0)?></td>
            <td class="column4 style21 null"><?php readMontant($dimCreImm_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style20 null"><?php readMontant($dimCreImm_E2)?></td>
          </tr>
          <tr class="row28">
            <td class="column0 style15 s">Augmentation des dettes de financement</td>
            <td class="column1 style46 null"><?php readMontant($augDetFinc_B)?></td>
            <td class="column2 style45 null"></td>
            <td class="column3 style44 null"><?php readMontant($augDetFinc_B-0)?></td>
            <td class="column4 style13 null"><?php readMontant($augDetFinc_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style11 null"><?php readMontant($augDetFinc_E2)?></td>
          </tr>
          <tr class="row29">
            <td class="column0 style10 s">TOTAL  I   ( a + b + c + d + e )</td>
            <td class="column1 style6 null"><?php readMontant($total1_B)?></td>
            <td class="column2 style6 null"><?php readMontant($total1_AP)?></td>
            <td class="column3 style9 null"><?php readMontant($total1_net)?></td>
            <td class="column4 style8 null"><?php readMontant($total1_EP)?></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style6 null"><?php readMontant($total1_E2)?></td>
          </tr>
          <tr class="row30">
            <td class="column0 style41 s">STOCKS ( f )</td>
            <td class="column1 style41 null"><?php readMontant($stocks_B)?></td>
            <td class="column2 style41 null"><?php readMontant($stocks_AP)?></td>
            <td class="column3 style43 null"><?php readMontant($stocks_net)?></td>
            <td class="column4 style42 null"><?php readMontant($stocks_EP)?></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style41 null"><?php readMontant($stocks_E2)?></td>
          </tr>
          <tr class="row31">
            <td class="column0 style37 s">Marchandises</td>
            <td class="column1 style34 null"><?php readMontant($march_B)?></td>
            <td class="column2 style34 null"><?php readMontant($march_AP*-1)?></td>
            <td class="column3 style36 null"><?php readMontant($march_B-($march_AP*-1))?></td>
            <td class="column4 style35 null"><?php readMontant($march_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($march_E2)?></td>
          </tr>
          <tr class="row32">
            <td class="column0 style19 s">Matières et fournitures consommables</td>
            <td class="column1 style16 null"><?php readMontant($matFournCon_B)?></td>
            <td class="column2 style16 null"><?php readMontant($matFournCon_AP*-1)?></td>
            <td class="column3 style18 null"><?php readMontant($matFournCon_B-($matFournCon_AP*-1))?></td>
            <td class="column4 style17 null"><?php readMontant($matFournCon_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style16 null"><?php readMontant($matFournCon_E2)?></td>
          </tr>
          <tr class="row33">
            <td class="column0 style19 s">Produits en cours</td>
            <td class="column1 style16 null"><?php readMontant($prodC_B)?></td>
            <td class="column2 style16 null"><?php readMontant($prodC_AP*-1)?></td>
            <td class="column3 style18 null"><?php readMontant($prodC_B-($prodC_AP*-1))?></td>
            <td class="column4 style17 null"><?php readMontant($prodC_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style16 null"><?php readMontant($prodC_E2)?></td>
          </tr>
          <tr class="row34">
            <td class="column0 style19 s">Produits intermédiaires et produits residuels</td>
            <td class="column1 style16 null"><?php readMontant($prodIntrProd_B)?></td>
            <td class="column2 style16 null"><?php readMontant($prodIntrProd_AP*-1)?></td>
            <td class="column3 style18 null"><?php readMontant($prodIntrProd_B-($prodIntrProd_AP*-1))?></td>
            <td class="column4 style17 null"><?php readMontant($prodIntrProd_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style16 null"><?php readMontant($prodIntrProd_E2)?></td>
          </tr>
          <tr class="row35">
            <td class="column0 style40 s">Produits finis</td>
            <td class="column1 style11 null"><?php readMontant($prodFinis_B)?></td>
            <td class="column2 style11 null"><?php readMontant($prodFinis_AP*-1)?></td>
            <td class="column3 style14 null"><?php readMontant($prodFinis_B-($prodFinis_AP*-1))?></td>
            <td class="column4 style13 null"><?php readMontant($prodFinis_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style11 null"><?php readMontant($prodFinis_E2)?></td>
          </tr>
          <tr class="row36">
            <td class="column0 style39 s">CREANCES DE L'ACTIF CIRCULANT ( g )</td>
            <td class="column1 style27 null"><?php readMontant($creActifCircl_B)?></td>
            <td class="column2 style27 null"><?php readMontant($creActifCircl_AP)?></td>
            <td class="column3 style38 null"><?php readMontant($creActifCircl_net)?></td>
            <td class="column4 style28 null"><?php readMontant($creActifCircl_EP)?></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style27 null"><?php readMontant($creActifCircl_E2)?></td>
          </tr>
          <tr class="row37">
            <td class="column0 style37 s">Fournisseurs débiteurs, avances et acomptes</td>
            <td class="column1 style34 null"><?php readMontant($fournDAA_B)?></td>
            <td class="column2 style34 null"><?php readMontant($fournDAA_AP*-1)?></td>
            <td class="column3 style36 null"><?php readMontant($fournDAA_B-($fournDAA_AP*-1))?></td>
            <td class="column4 style35 null"><?php readMontant($fournDAA_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($fournDAA_E2)?></td>
          </tr>
          <tr class="row38">
            <td class="column0 style19 s">Clients et comptes rattachés</td>
            <td class="column1 style16 null"><?php readMontant($clientCR_B)?></td>
            <td class="column2 style16 null"><?php readMontant($clientCR_AP*-1)?></td>
            <td class="column3 style18 null"><?php readMontant($clientCR_B-($clientCR_AP*-1))?></td>
            <td class="column4 style35 null"><?php readMontant($clientCR_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($clientCR_E2)?></td>
          </tr>
          <tr class="row39">
            <td class="column0 style19 s">Personnel</td>
            <td class="column1 style16 null"><?php readMontant($persl_B)?></td>
            <td class="column2 style16 null"><?php readMontant($persl_AP*-1)?></td>
            <td class="column3 style18 null"><?php readMontant($persl_B-($persl_AP*-1))?></td>
            <td class="column4 style35 null"><?php readMontant($persl_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($persl_E2)?></td>
          </tr>
          <tr class="row40">
            <td class="column0 style19 s">Etat</td>
            <td class="column1 style16 null"><?php readMontant($etat_B)?></td>
            <td class="column2 style16 null"><?php readMontant($etat_AP*-1)?></td>
            <td class="column3 style18 null"><?php readMontant($etat_B-($etat_AP*-1))?></td>
            <td class="column4 style35 null"><?php readMontant($etat_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($etat_E2)?></td>
          </tr>
          <tr class="row41">
            <td class="column0 style19 s">Comptes d'associés</td>
            <td class="column1 style16 null"><?php readMontant($comptAss_B)?></td>
            <td class="column2 style16 null"><?php readMontant($comptAss_AP*-1)?></td>
            <td class="column3 style18 null"><?php readMontant($comptAss_B-($comptAss_AP*-1))?></td>
            <td class="column4 style35 null"><?php readMontant($comptAss_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($comptAss_E2)?></td>
          </tr>
          <tr class="row42">
            <td class="column0 style19 s">Autres débiteurs</td>
            <td class="column1 style16 null"><?php readMontant($autresDebit_B)?></td>
            <td class="column2 style16 null"><?php readMontant($autresDebit_AP)?></td>
            <td class="column3 style18 null"><?php readMontant($autresDebit_B-($autresDebit_AP*-1))?></td>
            <td class="column4 style35 null"><?php readMontant($autresDebit_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style34 null"><?php readMontant($autresDebit_E2)?></td>
          </tr>
          <tr class="row43">
            <td class="column0 style15 s">Comptes de régularisation actif</td>
            <td class="column1 style11 null"><?php readMontant($comptRegAct_B)?></td>
            <td class="column2 style11 null"><?php readMontant($comptRegAct_AP*-1)?></td>
            <td class="column3 style14 null"><?php readMontant($comptRegAct_B-($comptRegAct_AP*-1))?></td>
            <td class="column4 style13 null"><?php readMontant($comptRegAct_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style11 null"><?php readMontant($comptRegAct_E2)?></td>
          </tr>
          <tr class="row44">
            <td class="column0 style31 s">TITRES ET VALEURS DE PLACEMENT ( h )</td>
            <td class="column1 style31 null"><?php readMontant($titreValPlace_B)?></td>
            <td class="column2 style31 null"><?php readMontant($titreValPlace_AP*-1)?></td>
            <td class="column3 style33 null"><?php readMontant($titreValPlace_B-($titreValPlace_AP*-1))?></td>
            <td class="column4 style32 null"><?php readMontant($titreValPlace_EP)?></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style31 null"><?php readMontant($titreValPlace_E2)?></td>
          </tr>
          <tr class="row45">
            <td class="column0 style27 s">ECART DE CONVERSION - ACTIF ( i )<span style="color:#000000; font-family:'Calibri'; font-size:11pt"> (Elém. Circul.)</span></td>
            <td class="column1 style27 null"><?php readMontant($ecratConverAct_B)?></td>
            <td class="column2 style30 null"></td>
            <td class="column3 style29 null"><?php readMontant($ecratConverAct_B-0)?></td>
            <td class="column4 style28 null"><?php readMontant($ecratConverAct_EP)?></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style27 null"><?php readMontant($ecratConverAct_E2)?></td>
          </tr>
          <tr class="row46">
            <td class="column0 style10 s">TOTAL  II   (  f + g + h + i )</td>
            <td class="column1 style6 null"><?php readMontant($total2_B)?></td>
            <td class="column2 style6 null"><?php readMontant($total2_AP)?></td>
            <td class="column3 style9 null"><?php readMontant($total2_net)?></td>
            <td class="column4 style8 null"><?php readMontant($total2_EP)?></td>
            <td class="column5 style7 null"></td> 
            <td class="column6 style6 null"><?php readMontant($total2_E2)?></td>
          </tr>
          <tr class="row47">
            <td class="column0 style24 s">TRESORERIE - ACTIF</td>
            <td class="column1 style24 null"><?php readMontant($tresorAct_B)?></td>
            <td class="column2 style24 null"><?php readMontant($tresorAct_AP)?></td>
            <td class="column3 style26 null"><?php readMontant($tresorAct_net)?></td>
            <td class="column4 style25 null"><?php readMontant($tresorAct_EP)?></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style24 null"><?php readMontant($tresorAct_E2)?></td>
          </tr>
          <tr class="row48">
            <td class="column0 style23 s">Chèques et valeurs à encaisser</td>
            <td class="column1 style20 null"><?php readMontant($chqValEnc_B)?></td>
            <td class="column2 style20 null"><?php readMontant($chqValEnc_AP*-1)?></td>
            <td class="column3 style22 null"><?php readMontant($chqValEnc_B-($chqValEnc_AP*-1))?></td>
            <td class="column4 style21 null"><?php readMontant($chqValEnc_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style20 null"><?php readMontant($chqValEnc_E2)?></td>
          </tr>
          <tr class="row49">
            <td class="column0 style19 s">Banques, T.G &amp; CP</td>
            <td class="column1 style16 null"><?php readMontant($banqTGCP_B)?></td>
            <td class="column2 style16 null"><?php readMontant($banqTGCP_AP*-1)?></td>
            <td class="column3 style18 null"><?php readMontant($banqTGCP_B-($banqTGCP_AP*-1))?></td>
            <td class="column4 style17 null"><?php readMontant($banqTGCP_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style16 null"><?php readMontant($banqTGCP_E2)?></td>
          </tr>

      
       

          <tr class="row50">
            <td class="column0 style15 s">Caisses, régies d'avances et accréditifs</td>
            <td class="column1 style11 null"><?php readMontant($caissRegAv_B)?></td>
            <td class="column2 style11 null"><?php readMontant($caissRegAv_AP*-1)?></td>
            <td class="column3 style14 null"><?php readMontant($caissRegAv_B-($caissRegAv_AP*-1))?></td>
            <td class="column4 style13 null"><?php readMontant($caissRegAv_EP)?></td>
            <td class="column5 style12 null"></td>
            <td class="column6 style11 null"><?php readMontant($caissRegAv_E2)?></td>
          </tr>
          <tr class="row51">
            <td class="column0 style10 s">TOTAL  III</td>
            <td class="column1 style6 null"><?php readMontant($total3_B)?></td>
            <td class="column2 style6 null"><?php readMontant($total3_AP)?></td>
            <td class="column3 style9 null"><?php readMontant($total3_net)?></td>
            <td class="column4 style8 null"><?php readMontant($total3_EP)?></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style6 null"><?php readMontant($total3_E2)?></td>
          </tr>
          <tr class="row52">
            <td class="column0 style5 s">TOTAL GENERAL  I+II+III</td>
            <td class="column1 style1 null"><?php readMontant($totalGen_B)?></td>
            <td class="column2 style1 null"><?php readMontant($totalGen_AP)?></td>
            <td class="column3 style4 null"><?php readMontant($totalGen_net)?></td>
            <td class="column4 style3 null"><?php readMontant($totalGen_EP)?></td>
            <td class="column5 style2 null"></td>
            <td class="column6 style1 null"><?php readMontant($totalGen_E2)?></td>
          </tr>
        </tbody>
    </table>
</center>
    
<div style="width: 650px; margin: 0 auto; text-align: center;">
  <div style="margin-top: 10px;margin-right : 80px;">
    <?php GenerateDocuments($dateChoisis); ?>
  </div>

  <div style="margin-top: -90px;margin-left : 80px;">
    <?php ShowDocuments(); ?>
  </div>
</div>





    </body>

</html>