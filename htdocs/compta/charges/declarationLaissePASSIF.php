<?php
    // Load Dolibarr environment
    require '../../main.inc.php';
    require_once '../../vendor/autoload.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
    llxHeader("", "");
?>
<!DOCTYPE html>
<html lang="en">
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
      td.style1 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style1 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style2 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:12pt; background-color:white }
      th.style2 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:12pt; background-color:white }
      td.style3 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style3 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style4 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style4 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style5 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style5 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style6 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style6 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style7 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style7 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style8 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:11pt; background-color:white }
      th.style8 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:11pt; background-color:white }
      td.style9 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style9 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style10 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style10 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style11 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style11 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style12 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style12 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style13 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style13 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style14 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style14 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style15 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:10pt; background-color:white }
      th.style15 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:10pt; background-color:white }
      td.style16 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style16 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style17 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style17 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style18 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style18 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style19 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style19 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style20 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style20 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style21 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style21 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style22 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style22 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style23 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style23 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style24 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style24 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style25 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style25 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style26 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style26 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style27 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style27 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style28 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style28 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style29 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style29 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style30 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style30 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style31 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style31 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style32 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style32 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style33 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style33 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style34 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style34 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style35 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style35 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style36 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style36 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style37 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style37 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style38 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style38 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style39 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style39 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style40 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style40 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style41 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style41 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style42 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style42 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style43 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style43 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style44 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style44 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style45 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style45 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style46 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style46 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style47 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style47 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style48 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style48 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style49 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style49 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style50 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style50 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style51 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style51 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style52 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style52 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style53 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style53 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style54 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style54 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style55 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style55 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style56 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style56 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:3px double #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style57 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style57 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style58 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style58 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style59 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style59 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style60 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style60 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style61 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style61 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style62 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style62 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style63 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style63 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style64 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style64 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style65 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style65 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style66 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style66 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style67 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style67 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style68 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style68 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style69 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style69 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style70 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style70 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style71 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style71 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style72 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style72 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style73 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style73 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style74 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Arial Narrow'; font-size:11pt; background-color:white }
      th.style74 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Arial Narrow'; font-size:11pt; background-color:white }
      td.style75 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style75 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style76 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style76 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style77 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style77 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:2px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style78 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style78 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style79 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:#D8D8D8 }
      th.style79 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:#D8D8D8 }
      td.style80 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:#D8D8D8 }
      th.style80 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:#D8D8D8 }
      td.style81 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:11pt; background-color:white }
      th.style81 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:11pt; background-color:white }
      td.style82 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style82 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style83 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style83 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style84 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:16pt; background-color:white }
      th.style84 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:16pt; background-color:white }
      td.style85 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      th.style85 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      td.style86 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      th.style86 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:16pt; background-color:white }
      table.sheet0 col.col0 { width:227.05555295pt }
      table.sheet0 col.col1 { width:42pt }
      table.sheet0 col.col2 { width:42pt }
      table.sheet0 col.col3 { width:49.47777721pt }
      table.sheet0 col.col4 { width:171.47777581pt }
      table.sheet0 col.col5 { width:42pt }
      table.sheet0 col.col6 { width:50.15555498pt }
      table.sheet0 tr { height:16.363636363636pt }
      table.sheet0 tr.row0 { height:22pt }
      table.sheet0 tr.row30 { height:17pt }
      table.sheet0 tr.row31 { height:17pt }
      table.sheet0 tr.row42 { height:17pt }
      table.sheet0 tr.row43 { height:17pt }
      table.sheet0 tr.row47 { height:17pt }
      table.sheet0 tr.row48 { height:17pt }
    </style>
  </head>
<body>
    <center>

    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <tbody>
          <tr class="row0">
            <td class="column0 style86 s style85" colspan="5">BILAN - PASSIF</td>
            <td class="column5 style84 null"></td>
            <td class="column6 style84 null"></td>
          </tr>
          <tr class="row1">
            <td class="column0 style83 null"></td>
            <td class="column1 style83 null"></td>
            <td class="column2 style83 null"></td>
            <td class="column3 style81 null"></td>
            <td class="column4 style82 f">#REF!</td>
            <td class="column5 style81 null"></td>
            <td class="column6 style81 null"></td>
          </tr>
          <tr class="row2">
            <td class="column0 style80 null style79" colspan="3"></td>
            <td class="column3 style78 s">Exercice</td>
            <td class="column4 style77 s">Exercice Précédent</td>
            <td class="column5 style15 null"></td>
            <td class="column6 style76 s">Exercice N-2</td>
          </tr>
          <tr class="row3">
            <td class="column0 style47 s">CAPITAUX PROPRES</td>
            <td class="column1 style75 null"></td>
            <td class="column2 style74 null"></td>
            <td class="column3 style53 null"></td>
            <td class="column4 style52 null"></td>
            <td class="column5 style8 null"></td>
            <td class="column6 style51 null"></td>
          </tr>
          <tr class="row4">
            <td class="column0 style59 s">Capital social ou personnel (1)</td>
            <td class="column1 style58 null"></td>
            <td class="column2 style57 null"></td>
            <td class="column3 style50 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row5">
            <td class="column0 style26 s">moins : Actionnaires, capital souscrit non appelé    dont versé</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row6">
            <td class="column0 style26 s">Moins : Capital appelé </td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row7">
            <td class="column0 style26 s">Moins : Dont versé </td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row8">
            <td class="column0 style26 s">Prime d'emission, de fusion, d'apport</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row9">
            <td class="column0 style26 s">Ecarts de reévaluation</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row10">
            <td class="column0 style26 s">Réserve légale</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row11">
            <td class="column0 style26 s">Autres reserves</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row12">
            <td class="column0 style26 s">Report à nouveau (2)</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row13">
            <td class="column0 style26 s">Résultat nets en instance d'affectation (2)</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row14">
            <td class="column0 style20 s">Résultat net de l'exercice (2)</td>
            <td class="column1 style19 null"></td>
            <td class="column2 style18 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row15">
            <td class="column0 style47 s">TOTAL DES CAPITAUX PROPRES ( a )</td>
            <td class="column1 style46 null"></td>
            <td class="column2 style45 null"></td>
            <td class="column3 style53 null"></td>
            <td class="column4 style52 null"></td>
            <td class="column5 style8 null"></td>
            <td class="column6 style51 null"></td>
          </tr>
          <tr class="row16">
            <td class="column0 style47 s">CAPITAUX PROPRES ASSIMILES ( b )</td>
            <td class="column1 style46 null"></td>
            <td class="column2 style45 null"></td>
            <td class="column3 style53 null"></td>
            <td class="column4 style52 null"></td>
            <td class="column5 style8 null"></td>
            <td class="column6 style51 null"></td>
          </tr>
          <tr class="row17">
            <td class="column0 style73 s">Subventions d'investissement</td>
            <td class="column1 style72 null"></td>
            <td class="column2 style71 null"></td>
            <td class="column3 style50 null"></td>
            <td class="column4 style49 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style48 null"></td>
          </tr>
          <tr class="row18">
            <td class="column0 style26 s">Provisions réglementées</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style70 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row19">
            <td class="column0 style67 null"></td>
            <td class="column1 style69 null"></td>
            <td class="column2 style68 null"></td>
            <td class="column3 style64 null"></td>
            <td class="column4 style63 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style62 null"></td>
          </tr>
          <tr class="row20">
            <td class="column0 style47 s">DETTES DE FINANCEMENT ( c )</td>
            <td class="column1 style46 null"></td>
            <td class="column2 style45 null"></td>
            <td class="column3 style53 null"></td>
            <td class="column4 style52 null"></td>
            <td class="column5 style8 null"></td>
            <td class="column6 style51 null"></td>
          </tr>
          <tr class="row21">
            <td class="column0 style59 s">Emprunts obligataires</td>
            <td class="column1 style58 null"></td>
            <td class="column2 style57 null"></td>
            <td class="column3 style50 null"></td>
            <td class="column4 style49 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style48 null"></td>
          </tr>
          <tr class="row22">
            <td class="column0 style26 s">Autres dettes de financement</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row23">
            <td class="column0 style67 null"></td>
            <td class="column1 style66 null"></td>
            <td class="column2 style65 null"></td>
            <td class="column3 style64 null"></td>
            <td class="column4 style63 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style62 null"></td>
          </tr>
          <tr class="row24">
            <td class="column0 style47 s">PROVISIONS DURABLES POUR RISQUES ET CHARGES ( d )</td>
            <td class="column1 style46 null"></td>
            <td class="column2 style45 null"></td>
            <td class="column3 style53 null"></td>
            <td class="column4 style52 null"></td>
            <td class="column5 style8 null"></td>
            <td class="column6 style51 null"></td>
          </tr>
          <tr class="row25">
            <td class="column0 style29 s">Provisions pour risques</td>
            <td class="column1 style58 null"></td>
            <td class="column2 style57 null"></td>
            <td class="column3 style50 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row26">
            <td class="column0 style61 s">Provisions pour charges</td>
            <td class="column1 style19 null"></td>
            <td class="column2 style18 null"></td>
            <td class="column3 style60 null"></td>
            <td class="column4 style16 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style14 null"></td>
          </tr>
          <tr class="row27">
            <td class="column0 style41 s">ECARTS DE CONVERSION - PASSIF ( e )</td>
            <td class="column1 style40 null"></td>
            <td class="column2 style39 null"></td>
            <td class="column3 style32 null"></td>
            <td class="column4 style31 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style30 null"></td>
          </tr>
          <tr class="row28">
            <td class="column0 style59 s">Augmentation des créances immobilisées</td>
            <td class="column1 style58 null"></td>
            <td class="column2 style57 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row29">
            <td class="column0 style20 s">Diminution des dettes de financement</td>
            <td class="column1 style19 null"></td>
            <td class="column2 style18 null"></td>
            <td class="column3 style17 null"></td>
            <td class="column4 style16 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style14 null"></td>
          </tr>
          <tr class="row30">
            <td class="column0 style13 s">TOTAL  I  ( a + b + c + d + e )</td>
            <td class="column1 style12 null"></td>
            <td class="column2 style11 null"></td>
            <td class="column3 style38 null"></td>
            <td class="column4 style37 null"></td>
            <td class="column5 style8 null"></td>
            <td class="column6 style36 null"></td>
          </tr>
          <tr class="row31">
            <td class="column0 style56 s">DETTES DU PASSIF CIRCULANT ( f )</td>
            <td class="column1 style55 null"></td>
            <td class="column2 style54 null"></td>
            <td class="column3 style53 null"></td>
            <td class="column4 style52 null"></td>
            <td class="column5 style8 null"></td>
            <td class="column6 style51 null"></td>
          </tr>
          <tr class="row32">
            <td class="column0 style29 s">Fournisseurs et comptes rattachés</td>
            <td class="column1 style28 null"></td>
            <td class="column2 style27 null"></td>
            <td class="column3 style50 null"></td>
            <td class="column4 style49 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style48 null"></td>
          </tr>
          <tr class="row33">
            <td class="column0 style26 s">Clients créditeurs, avances et acomptes</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row34">
            <td class="column0 style26 s">Personnel</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row35">
            <td class="column0 style26 s">Organismes sociaux</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row36">
            <td class="column0 style26 s">Etat</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row37">
            <td class="column0 style26 s">Comptes d'associés</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row38">
            <td class="column0 style26 s">Autres créanciers</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row39">
            <td class="column0 style20 s">Comptes de regularisation - passif</td>
            <td class="column1 style19 null"></td>
            <td class="column2 style18 null"></td>
            <td class="column3 style17 null"></td>
            <td class="column4 style16 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style14 null"></td>
          </tr>
          <tr class="row40">
            <td class="column0 style47 s">AUTRES PROVISIONS POUR RISQUES ET CHARGES ( g )</td>
            <td class="column1 style46 null"></td>
            <td class="column2 style45 null"></td>
            <td class="column3 style44 null"></td>
            <td class="column4 style43 null"></td>
            <td class="column5 style8 null"></td>
            <td class="column6 style42 null"></td>
          </tr>
          <tr class="row41">
            <td class="column0 style41 s">ECARTS DE CONVERSION - PASSIF ( h )<span style="color:#000000; font-family:'Calibri'; font-size:10pt"> (Elem. Circul.)</span></td>
            <td class="column1 style40 null"></td>
            <td class="column2 style39 null"></td>
            <td class="column3 style32 null"></td>
            <td class="column4 style31 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style30 null"></td>
          </tr>
          <tr class="row42">
            <td class="column0 style13 s">TOTAL  II  ( f + g + h )</td>
            <td class="column1 style12 null"></td>
            <td class="column2 style11 null"></td>
            <td class="column3 style38 null"></td>
            <td class="column4 style37 null"></td>
            <td class="column5 style8 null"></td>
            <td class="column6 style36 null"></td>
          </tr>
          <tr class="row43">
            <td class="column0 style35 s">TRESORERIE PASSIF</td>
            <td class="column1 style34 null"></td>
            <td class="column2 style33 null"></td>
            <td class="column3 style32 null"></td>
            <td class="column4 style31 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style30 null"></td>
          </tr>
          <tr class="row44">
            <td class="column0 style29 s">Crédits d'escompte</td>
            <td class="column1 style28 null"></td>
            <td class="column2 style27 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row45">
            <td class="column0 style26 s">Crédit de trésorerie</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style22 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"></td>
          </tr>
          <tr class="row46">
            <td class="column0 style20 s">Banques ( soldes créditeurs )</td>
            <td class="column1 style19 null"></td>
            <td class="column2 style18 null"></td>
            <td class="column3 style17 null"></td>
            <td class="column4 style16 null"></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style14 null"></td>
          </tr>
          <tr class="row47">
            <td class="column0 style13 s">TOTAL  III</td>
            <td class="column1 style12 null"></td>
            <td class="column2 style11 null"></td>
            <td class="column3 style10 null"></td>
            <td class="column4 style9 null"></td>
            <td class="column5 style8 null"></td>
            <td class="column6 style7 null"></td>
          </tr>
          <tr class="row48">
            <td class="column0 style6 s">TOTAL   I+II+III</td>
            <td class="column1 style6 null"></td>
            <td class="column2 style5 null"></td>
            <td class="column3 style4 null"></td>
            <td class="column4 style3 null"></td>
            <td class="column5 style2 null"></td>
            <td class="column6 style1 null"></td>
          </tr>
        </tbody>
    </table>
    </center>

  </body>

</html>