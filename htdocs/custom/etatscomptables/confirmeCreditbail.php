<?php
// Load Dolibarr environment
require_once '../../main.inc.php';
require_once '../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
llxHeader("", "");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the form data

  $valeur0 = $_POST['valeur0'];
  $valeur1 = $_POST['valeur1'];
  $valeur2 = $_POST['valeur2'];
  $valeur3 = $_POST['valeur3'];
  $valeur4 = $_POST['valeur4'];
  $valeur5 = $_POST['valeur5'];
  $valeur6 = $_POST['valeur6'];
  $valeur7 = $_POST['valeur7'];
  $valeur8 = $_POST['valeur8'];
  $valeur9 = $_POST['valeur9'];
  $valeur10 = $_POST['valeur10'];
  $valeur11 = $_POST['valeur11'];

}




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
            <td class="column0 style6 f">#REF!</td>
            <td class="column1 style7 null"></td>
            <td class="column2 style7 null"></td>
            <td class="column3 style7 null"></td>
            <td class="column4 style7 null"></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style7 null"></td>
            <td class="column7 style7 null"></td>
            <td class="column8 style7 null"></td>
            <td class="column9 style8 null"></td>
            <td class="column10 style9 f">#REF!</td>
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

        

            <td class="column0 style21 null"><?php echo $valeur1;?></td>
            <td class="column1 style22 null"><?php echo $valeur2;?></td>
            <td class="column2 style21 null"><?php echo $valeur3;?></td>
            <td class="column3 style23 null"><?php echo $valeur4;?></td>
            <td class="column4 style21 null"><?php echo $valeur5;?></td>
            <td class="column5 style23 null"><?php echo $valeur6;?></td>
            <td class="column6 style23 null"><?php echo $valeur7;?></td>
            <td class="column7 style23 null"><?php echo $valeur8;?></td>
            <td class="column8 style23 null"><?php echo $valeur9;?></td>
            <td class="column9 style23 null"><?php echo $valeur10;?></td>
            <td class="column10 style23 null"><?php echo $valeur11;?></td>
          </tr>
          <tr class="row6">
            <td class="column0 style21 null"></td>
            <td class="column1 style22 null"></td>
            <td class="column2 style21 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style21 null"></td>
            <td class="column5 style23 null"></td>
            <td class="column6 style23 null"></td>
            <td class="column7 style23 null"></td>
            <td class="column8 style23 null"></td>
            <td class="column9 style23 null"></td>
            <td class="column10 style23 null"></td>
          </tr>
          <tr class="row7">
            <td class="column0 style21 null"></td>
            <td class="column1 style22 null"></td>
            <td class="column2 style21 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style21 null"></td>
            <td class="column5 style23 null"></td>
            <td class="column6 style23 null"></td>
            <td class="column7 style23 null"></td>
            <td class="column8 style23 null"></td>
            <td class="column9 style23 null"></td>
            <td class="column10 style23 null"></td>
          </tr>
          <tr class="row8">
            <td class="column0 style21 null"></td>
            <td class="column1 style22 null"></td>
            <td class="column2 style21 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style21 null"></td>
            <td class="column5 style23 null"></td>
            <td class="column6 style23 null"></td>
            <td class="column7 style23 null"></td>
            <td class="column8 style23 null"></td>
            <td class="column9 style23 null"></td>
            <td class="column10 style23 null"></td>
          </tr>
          <tr class="row9">
            <td class="column0 style21 null"></td>
            <td class="column1 style22 null"></td>
            <td class="column2 style21 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style21 null"></td>
            <td class="column5 style23 null"></td>
            <td class="column6 style23 null"></td>
            <td class="column7 style23 null"></td>
            <td class="column8 style23 null"></td>
            <td class="column9 style23 null"></td>
            <td class="column10 style23 null"></td>
          </tr>
          <tr class="row10">
            <td class="column0 style21 null"></td>
            <td class="column1 style22 null"></td>
            <td class="column2 style21 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style21 null"></td>
            <td class="column5 style23 null"></td>
            <td class="column6 style23 null"></td>
            <td class="column7 style23 null"></td>
            <td class="column8 style23 null"></td>
            <td class="column9 style23 null"></td>
            <td class="column10 style23 null"></td>
          </tr>
          <tr class="row11">
            <td class="column0 style21 null"></td>
            <td class="column1 style22 null"></td>
            <td class="column2 style21 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style21 null"></td>
            <td class="column5 style23 null"></td>
            <td class="column6 style23 null"></td>
            <td class="column7 style23 null"></td>
            <td class="column8 style23 null"></td>
            <td class="column9 style23 null"></td>
            <td class="column10 style23 null"></td>
          </tr>
          <tr class="row12">
            <td class="column0 style21 null"></td>
            <td class="column1 style22 null"></td>
            <td class="column2 style21 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style21 null"></td>
            <td class="column5 style23 null"></td>
            <td class="column6 style23 null"></td>
            <td class="column7 style23 null"></td>
            <td class="column8 style23 null"></td>
            <td class="column9 style23 null"></td>
            <td class="column10 style23 null"></td>
          </tr>
          <tr class="row13">
            <td class="column0 style21 null"></td>
            <td class="column1 style22 null"></td>
            <td class="column2 style21 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style21 null"></td>
            <td class="column5 style23 null"></td>
            <td class="column6 style23 null"></td>
            <td class="column7 style23 null"></td>
            <td class="column8 style23 null"></td>
            <td class="column9 style23 null"></td>
            <td class="column10 style23 null"></td>
            <td class="column11 style24 null"></td>
          </tr>
          <tr class="row14">
            <td class="column0 style21 null"></td>
            <td class="column1 style22 null"></td>
            <td class="column2 style21 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style21 null"></td>
            <td class="column5 style23 null"></td>
            <td class="column6 style23 null"></td>
            <td class="column7 style23 null"></td>
            <td class="column8 style23 null"></td>
            <td class="column9 style23 null"></td>
            <td class="column10 style23 null"></td>
          </tr>
          <tr class="row15">
            <td class="column0 style21 null"></td>
            <td class="column1 style22 null"></td>
            <td class="column2 style21 null"></td>
            <td class="column3 style23 null"></td>
            <td class="column4 style21 null"></td>
            <td class="column5 style23 null"></td>
            <td class="column6 style23 null"></td>
            <td class="column7 style23 null"></td>
            <td class="column8 style23 null"></td>
            <td class="column9 style23 null"></td>
            <td class="column10 style23 null"></td>
          </tr>
          <tr class="row16">
            <td class="column0 style25 null"></td>
            <td class="column1 style26 null"></td>
            <td class="column2 style25 null"></td>
            <td class="column3 style27 null"></td>
            <td class="column4 style25 null"></td>
            <td class="column5 style27 null"></td>
            <td class="column6 style27 null"></td>
            <td class="column7 style27 null"></td>
            <td class="column8 style27 null"></td>
            <td class="column9 style27 null"></td>
            <td class="column10 style27 null"></td>
          </tr>
          <tr class="row17">
            <td class="column0 style25 null"></td>
            <td class="column1 style26 null"></td>
            <td class="column2 style25 null"></td>
            <td class="column3 style27 null"></td>
            <td class="column4 style25 null"></td>
            <td class="column5 style27 null"></td>
            <td class="column6 style27 null"></td>
            <td class="column7 style27 null"></td>
            <td class="column8 style27 null"></td>
            <td class="column9 style27 null"></td>
            <td class="column10 style27 null"></td>

          </tr>
          <tr class="row18">
            <td class="column0 style25 null"></td>
            <td class="column1 style26 null"></td>
            <td class="column2 style25 null"></td>
            <td class="column3 style27 null"></td>
            <td class="column4 style25 null"></td>
            <td class="column5 style27 null"></td>
            <td class="column6 style27 null"></td>
            <td class="column7 style27 null"></td>
            <td class="column8 style27 null"></td>
            <td class="column9 style27 null"></td>
            <td class="column10 style27 null"></td>
          </tr>
          <tr class="row19">
            <td class="column0 style25 null"></td>
            <td class="column1 style26 null"></td>
            <td class="column2 style25 null"></td>
            <td class="column3 style27 null"></td>
            <td class="column4 style25 null"></td>
            <td class="column5 style27 null"></td>
            <td class="column6 style27 null"></td>
            <td class="column7 style27 null"></td>
            <td class="column8 style27 null"></td>
            <td class="column9 style27 null"></td>
            <td class="column10 style27 null"></td>
          </tr>
          <tr class="row20">
            <td class="column0 style25 null"></td>
            <td class="column1 style26 null"></td>
            <td class="column2 style25 null"></td>
            <td class="column3 style27 null"></td>
            <td class="column4 style25 null"></td>
            <td class="column5 style27 null"></td>
            <td class="column6 style27 null"></td>
            <td class="column7 style27 null"></td>
            <td class="column8 style27 null"></td>
            <td class="column9 style27 null"></td>
            <td class="column10 style27 null"></td>

          </tr>
          <tr class="row21">
            <td class="column0 style25 null"></td>
            <td class="column1 style26 null"></td>
            <td class="column2 style25 null"></td>
            <td class="column3 style27 null"></td>
            <td class="column4 style25 null"></td>
            <td class="column5 style27 null"></td>
            <td class="column6 style27 null"></td>
            <td class="column7 style27 null"></td>
            <td class="column8 style27 null"></td>
            <td class="column9 style27 null"></td>
            <td class="column10 style27 null"></td>

          </tr>
          <tr class="row22">
            <td class="column0 style25 null"></td>
            <td class="column1 style26 null"></td>
            <td class="column2 style25 null"></td>
            <td class="column3 style27 null"></td>
            <td class="column4 style25 null"></td>
            <td class="column5 style27 null"></td>
            <td class="column6 style27 null"></td>
            <td class="column7 style27 null"></td>
            <td class="column8 style27 null"></td>
            <td class="column9 style27 null"></td>
            <td class="column10 style27 null"></td>

          </tr>
          <tr class="row23">
            <td class="column0 style28 s">Total</td>
            <td class="column1 style29 null"></td>
            <td class="column2 style30 null"></td>
            <td class="column3 style31 f">0.00</td>
            <td class="column4 style32 s">-</td>
            <td class="column5 style31 f">0.00</td>
            <td class="column6 style31 f">0.00</td>
            <td class="column7 style31 f">0.00</td>
            <td class="column8 style31 f">0.00</td>
            <td class="column9 style31 f">0.00</td>
            <td class="column10 style32 s">-</td>
            <td class="column11 style7 s">GrasDroite</td>
          </tr>
        </tbody>
    </table>



    
    <center>

<div > 
  <form method="POST" action="declarationCreditBail.php">
        <input type="hidden" name="v1" value="<?php echo $valeur1; ?>" />
        <input type="hidden" name="v2" value="<?php echo $valeur2; ?>" />
        <input type="hidden" name="v3" value="<?php echo $valeur3; ?>" />
        <input type="hidden" name="v4" value="<?php echo $valeur4; ?>" />
        <input type="hidden" name="v5" value="<?php echo $valeur5; ?>" />
        <input type="hidden" name="v6" value="<?php echo $valeur6; ?>" />

        <p style="display: inline; margin-top:10px" >Confirmer : </p>
    <label  for="oui">oui</label>
    <input type="radio" name="sitec" id="oui" value="oui" required>

    <label for="non">non</label>
    <input type="radio" name="sitec" id="non" value="non" required>
</body>

        <!-- Code block for "oui" option -->
        <div id="ouiBlock" style="display: none;">
            <button type="submit" name="te" style="margin-top: 18px; background: #4B99AD; padding: 8px 15px 8px 15px; border: none; color: #fff;">telecharge</button><br>
        </div>

        <!-- Code block for "non" option -->
        <div id="nonBlock" style="display: none;">
            <button type="submit" name="chargement" style="margin-top: 18px; background: #4B99AD; padding: 8px 15px 8px 15px; border: none; color: #fff;">Go back to modify</button><br>
        </div>
    </form>
</div> 
</center>

<script>
    // Function to handle the change event of the radio buttons
    var ouiRadio = document.getElementById('oui');
    var nonRadio = document.getElementById('non');
    var ouiBlock = document.getElementById('ouiBlock');
    var nonBlock = document.getElementById('nonBlock');

    ouiRadio.addEventListener('change', function () {
        ouiBlock.style.display = 'block';
        nonBlock.style.display = 'none';
    });

    nonRadio.addEventListener('change', function () {
        ouiBlock.style.display = 'none';
        nonBlock.style.display = 'block';
    });
</script>


  </body>
</html>
