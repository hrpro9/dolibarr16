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
    for ($i = 0; $i <= 107; $i++) {
        ${'RDimmobilisation' . $i} = $_POST['RDimmobilisation' . $i];
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
  print '<input type="hidden" name="model" value="Retratsdimm">';
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
    $filedir = DOL_DATA_ROOT . '/billanLaisse/Retratsdimm/';
    $urlsource = $_SERVER['PHP_SELF'] . '';
    $genallowed = 0;
    $delallowed = 1;
    $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

 

  if ($societe !== null && isset($societe->default_lang)) {
    print $formfile->showdocuments('Retratsdimm', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
  } else {
      print $formfile->showdocuments('Retratsdimm', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
  }

}

// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/billanLaisse/Retratsdimm/';
$permissiontoadd = 1;
$donotredirect = 1;

include DOL_DOCUMENT_ROOT . '/core/actions_builddoc.inc.php';

?>


<!DOCTYPE >
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
      td.style1 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style1 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style2 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style2 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style3 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style3 { vertical-align:bottom; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style4 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style4 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style5 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style5 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style6 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style6 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style8 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style8 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style9 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      th.style9 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:11pt; background-color:white }
      td.style10 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style10 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style11 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style11 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style12 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style12 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style13 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style13 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style14 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style14 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style15 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style15 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style16 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style16 { vertical-align:bottom; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style17 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style17 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style18 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style18 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style19 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style19 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style20 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style20 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style21 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style21 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style22 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style22 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style23 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style23 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style24 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style24 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style25 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style25 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      table.sheet0 col.col0 { width:63.71111038pt }
      table.sheet0 col.col1 { width:76.58888801pt }
      table.sheet0 col.col2 { width:72.52222139pt }
      table.sheet0 col.col3 { width:72.52222139pt }
      table.sheet0 col.col4 { width:72.52222139pt }
      table.sheet0 col.col5 { width:72.52222139pt }
      table.sheet0 col.col6 { width:72.52222139pt }
      table.sheet0 col.col7 { width:72.52222139pt }
      table.sheet0 col.col8 { width:49.47777721pt }
      table.sheet0 col.col9 { width:14.91111094pt }
      table.sheet0 col.col10 { width:49.47777721pt }
      table.sheet0 tr { height:13.636363636364pt }
      table.sheet0 tr.row0 { height:20pt }
      table.sheet0 tr.row1 { height:27pt }
      table.sheet0 tr.row2 { height:38.25pt }
      table.sheet0 tr.row21 { height:19.5pt }
    </style>
  </head>

  <body>

  <center>
<form method="POST" action="confirmeRetratsDimmobilistion.php">

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


        <center>
        <input type="date" name="RDimmobilisation108" placeholder ="Année" required style="margin-top: 18px;font-size:95%; background: #ededed; font-weight:bolder; padding: 8px 15px 8px 15px; border: block; ">
        <input type="hidden" name="check"  value="true">
        </center>



        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style3" colspan="6">TABLEAU DES PLUS OU MOINS VALUES SUR CESSIONS OU RETRAITS D'IMMOBILISATIONS</td>

          </tr>
          
          <tr class="row1">
            <td class="column0 style5 f"></td>
            <td class="column1 style6 null"></td>
            <td class="column2 style7 null"></td>
            <td class="column3 style8 s"></td>
            <td class="column4 style9 f"></td>
            <td class="column5 style7 null"></td>
            <!-- <td class="column6 style7 null"></td>
            <td class="column7 style10 f"></td> -->

          </tr>
          
          <tr class="row2">
            <td class="column0 style12 s">Date de cession ou de retrait</td>
            <td class="column1 style12 s">Compte principal</td>
            <td class="column2 style12 s">Montant brut</td>
            <td class="column3 style12 s">Amortissements cumulés</td>
            <td class="column4 style13 s">Valeur nette d'amortissement</td>
            <td class="column5 style12 s">Produit de cession</td>
            <!-- <td class="column6 style12 s">Plus values</td>
            <td class="column7 style12 s">Moins values</td> -->

          </tr> 
          <tr class="row3">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation0" id="RDimmobilisation0" oninput="sumValues()" value="<?php if(isset($RDimmobilisation0)){ echo $RDimmobilisation0;} ?>" /></td>
            <td class="column1 style16 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation1" id="RDimmobilisation1" oninput="sumValues()" value="<?php if(isset($RDimmobilisation1)){ echo $RDimmobilisation1;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation2" id="RDimmobilisation2" oninput="sumValues()" value="<?php if(isset($RDimmobilisation2)){ echo $RDimmobilisation2;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation3" id="RDimmobilisation2" oninput="sumValues()" value="<?php if(isset($RDimmobilisation3)){ echo $RDimmobilisation3;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation4" id="RDimmobilisation2" oninput="sumValues()" value="<?php if(isset($RDimmobilisation4)){ echo $RDimmobilisation4;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation5" id="RDimmobilisation2" oninput="sumValues()" value="<?php if(isset($RDimmobilisation5)){ echo $RDimmobilisation5;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->

          </tr>
          <tr class="row4">
          <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation6" id="RDimmobilisation6" oninput="sumValues()" value="<?php if(isset($RDimmobilisation6)){ echo $RDimmobilisation6;} ?>" /></td>
            <td class="column1 style16 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation7" id="RDimmobilisation7" oninput="sumValues()" value="<?php if(isset($RDimmobilisation7)){ echo $RDimmobilisation7;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;"  placeholder="0" required name="RDimmobilisation8" id="RDimmobilisation8" oninput="sumValues()" value="<?php if(isset($RDimmobilisation8)){ echo $RDimmobilisation8;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;"  placeholder="0" required name="RDimmobilisation9" id="RDimmobilisation9" oninput="sumValues()" value="<?php if(isset($RDimmobilisation9)){ echo $RDimmobilisation9;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;"  placeholder="0" required name="RDimmobilisation10" id="RDimmobilisation10" oninput="sumValues()" value="<?php if(isset($RDimmobilisation10)){ echo $RDimmobilisation10;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;"  placeholder="0" required name="RDimmobilisation11" id="RDimmobilisation11" oninput="sumValues()" value="<?php if(isset($RDimmobilisation11)){ echo $RDimmobilisation11;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row5">
          <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation12" id="RDimmobilisation12" oninput="sumValues()" value="<?php if(isset($RDimmobilisation12)){ echo $RDimmobilisation12;} ?>" /></td>
            <td class="column2 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation13" id="RDimmobilisation13" oninput="sumValues()" value="<?php if(isset($RDimmobilisation13)){ echo $RDimmobilisation13;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;"  placeholder="0" required name="RDimmobilisation14" id="RDimmobilisation14" oninput="sumValues()" value="<?php if(isset($RDimmobilisation14)){ echo $RDimmobilisation14;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;"  placeholder="0" required name="RDimmobilisation15" id="RDimmobilisation15" oninput="sumValues()" value="<?php if(isset($RDimmobilisation15)){ echo $RDimmobilisation15;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;"  placeholder="0" required name="RDimmobilisation16" id="RDimmobilisation16" oninput="sumValues()" value="<?php if(isset($RDimmobilisation16)){ echo $RDimmobilisation16;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;"  placeholder="0" required name="RDimmobilisation17" id="RDimmobilisation17" oninput="sumValues()" value="<?php if(isset($RDimmobilisation17)){ echo $RDimmobilisation17;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row6">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation18" id="RDimmobilisation18" oninput="sumValues()" value="<?php if(isset($RDimmobilisation18)){ echo $RDimmobilisation18;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation19" id="RDimmobilisation19" oninput="sumValues()" value="<?php if(isset($RDimmobilisation19)){ echo $RDimmobilisation19;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation20" id="RDimmobilisation20" oninput="sumValues()" value="<?php if(isset($RDimmobilisation20)){ echo $RDimmobilisation20;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation21" id="RDimmobilisation21" oninput="sumValues()" value="<?php if(isset($RDimmobilisation21)){ echo $RDimmobilisation21;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation22" id="RDimmobilisation22" oninput="sumValues()" value="<?php if(isset($RDimmobilisation22)){ echo $RDimmobilisation22;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation23" id="RDimmobilisation23" oninput="sumValues()" value="<?php if(isset($RDimmobilisation23)){ echo $RDimmobilisation23;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row7">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation24" id="RDimmobilisation24" oninput="sumValues()" value="<?php if(isset($RDimmobilisation24)){ echo $RDimmobilisation24;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation25" id="RDimmobilisation25" oninput="sumValues()" value="<?php if(isset($RDimmobilisation25)){ echo $RDimmobilisation25;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation26" id="RDimmobilisation26" oninput="sumValues()" value="<?php if(isset($RDimmobilisation26)){ echo $RDimmobilisation26;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation27" id="RDimmobilisation27" oninput="sumValues()" value="<?php if(isset($RDimmobilisation27)){ echo $RDimmobilisation27;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation28" id="RDimmobilisation28" oninput="sumValues()" value="<?php if(isset($RDimmobilisation28)){ echo $RDimmobilisation28;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation29" id="RDimmobilisation29" oninput="sumValues()" value="<?php if(isset($RDimmobilisation29)){ echo $RDimmobilisation29;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row8">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation30" id="RDimmobilisation30" oninput="sumValues()" value="<?php if(isset($RDimmobilisation30)){ echo $RDimmobilisation30;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation31" id="RDimmobilisation31" oninput="sumValues()" value="<?php if(isset($RDimmobilisation31)){ echo $RDimmobilisation31;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation32" id="RDimmobilisation32" oninput="sumValues()" value="<?php if(isset($RDimmobilisation32)){ echo $RDimmobilisation32;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation33" id="RDimmobilisation33" oninput="sumValues()" value="<?php if(isset($RDimmobilisation33)){ echo $RDimmobilisation33;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation34" id="RDimmobilisation34" oninput="sumValues()" value="<?php if(isset($RDimmobilisation34)){ echo $RDimmobilisation34;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation35" id="RDimmobilisation35" oninput="sumValues()" value="<?php if(isset($RDimmobilisation35)){ echo $RDimmobilisation35;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row9">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation36" id="RDimmobilisation36" oninput="sumValues()" value="<?php if(isset($RDimmobilisation36)){ echo $RDimmobilisation36;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation37" id="RDimmobilisation37" oninput="sumValues()" value="<?php if(isset($RDimmobilisation37)){ echo $RDimmobilisation37;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation38" id="RDimmobilisation38" oninput="sumValues()" value="<?php if(isset($RDimmobilisation38)){ echo $RDimmobilisation38;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation39" id="RDimmobilisation39" oninput="sumValues()" value="<?php if(isset($RDimmobilisation39)){ echo $RDimmobilisation39;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation40" id="RDimmobilisation40" oninput="sumValues()" value="<?php if(isset($RDimmobilisation40)){ echo $RDimmobilisation40;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation41" id="RDimmobilisation41" oninput="sumValues()" value="<?php if(isset($RDimmobilisation41)){ echo $RDimmobilisation41;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row10">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation42" id="RDimmobilisation42" oninput="sumValues()" value="<?php if(isset($RDimmobilisation42)){ echo $RDimmobilisation42;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation43" id="RDimmobilisation43" oninput="sumValues()" value="<?php if(isset($RDimmobilisation43)){ echo $RDimmobilisation43;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation44" id="RDimmobilisation44" oninput="sumValues()" value="<?php if(isset($RDimmobilisation44)){ echo $RDimmobilisation44;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation45" id="RDimmobilisation45" oninput="sumValues()" value="<?php if(isset($RDimmobilisation45)){ echo $RDimmobilisation45;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation46" id="RDimmobilisation46" oninput="sumValues()" value="<?php if(isset($RDimmobilisation46)){ echo $RDimmobilisation46;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation47" id="RDimmobilisation47" oninput="sumValues()" value="<?php if(isset($RDimmobilisation47)){ echo $RDimmobilisation47;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row11">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation48" id="RDimmobilisation48" oninput="sumValues()" value="<?php if(isset($RDimmobilisation48)){ echo $RDimmobilisation48;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation49" id="RDimmobilisation49" oninput="sumValues()" value="<?php if(isset($RDimmobilisation49)){ echo $RDimmobilisation49;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation50" id="RDimmobilisation50" oninput="sumValues()" value="<?php if(isset($RDimmobilisation50)){ echo $RDimmobilisation50;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation51" id="RDimmobilisation51" oninput="sumValues()" value="<?php if(isset($RDimmobilisation51)){ echo $RDimmobilisation51;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation52" id="RDimmobilisation52" oninput="sumValues()" value="<?php if(isset($RDimmobilisation52)){ echo $RDimmobilisation52;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation53" id="RDimmobilisation53" oninput="sumValues()" value="<?php if(isset($RDimmobilisation53)){ echo $RDimmobilisation53;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row12">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation54" id="RDimmobilisation54" oninput="sumValues()" value="<?php if(isset($RDimmobilisation54)){ echo $RDimmobilisation54;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation55" id="RDimmobilisation55" oninput="sumValues()" value="<?php if(isset($RDimmobilisation55)){ echo $RDimmobilisation55;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation56" id="RDimmobilisation56" oninput="sumValues()" value="<?php if(isset($RDimmobilisation56)){ echo $RDimmobilisation56;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation57" id="RDimmobilisation57" oninput="sumValues()" value="<?php if(isset($RDimmobilisation57)){ echo $RDimmobilisation57;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation58" id="RDimmobilisation58" oninput="sumValues()" value="<?php if(isset($RDimmobilisation58)){ echo $RDimmobilisation58;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation59" id="RDimmobilisation59" oninput="sumValues()" value="<?php if(isset($RDimmobilisation59)){ echo $RDimmobilisation59;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row13">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation60" id="RDimmobilisation60" oninput="sumValues()" value="<?php if(isset($RDimmobilisation60)){ echo $RDimmobilisation60;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation61" id="RDimmobilisation61" oninput="sumValues()" value="<?php if(isset($RDimmobilisation61)){ echo $RDimmobilisation61;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation62" id="RDimmobilisation62" oninput="sumValues()" value="<?php if(isset($RDimmobilisation62)){ echo $RDimmobilisation62;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation63" id="RDimmobilisation63" oninput="sumValues()" value="<?php if(isset($RDimmobilisation63)){ echo $RDimmobilisation63;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation64" id="RDimmobilisation64" oninput="sumValues()" value="<?php if(isset($RDimmobilisation64)){ echo $RDimmobilisation64;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation65" id="RDimmobilisation65" oninput="sumValues()" value="<?php if(isset($RDimmobilisation65)){ echo $RDimmobilisation65;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row14">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation66" id="RDimmobilisation66" oninput="sumValues()" value="<?php if(isset($RDimmobilisation66)){ echo $RDimmobilisation66;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation67" id="RDimmobilisation67" oninput="sumValues()" value="<?php if(isset($RDimmobilisation67)){ echo $RDimmobilisation67;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation68" id="RDimmobilisation68" oninput="sumValues()" value="<?php if(isset($RDimmobilisation68)){ echo $RDimmobilisation68;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation69" id="RDimmobilisation69" oninput="sumValues()" value="<?php if(isset($RDimmobilisation69)){ echo $RDimmobilisation69;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation70" id="RDimmobilisation70" oninput="sumValues()" value="<?php if(isset($RDimmobilisation70)){ echo $RDimmobilisation70;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation71" id="RDimmobilisation71" oninput="sumValues()" value="<?php if(isset($RDimmobilisation71)){ echo $RDimmobilisation71;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row15">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation72" id="RDimmobilisation72" oninput="sumValues()" value="<?php if(isset($RDimmobilisation72)){ echo $RDimmobilisation72;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation73" id="RDimmobilisation73" oninput="sumValues()" value="<?php if(isset($RDimmobilisation73)){ echo $RDimmobilisation73;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation74" id="RDimmobilisation74" oninput="sumValues()" value="<?php if(isset($RDimmobilisation74)){ echo $RDimmobilisation74;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation75" id="RDimmobilisation75" oninput="sumValues()" value="<?php if(isset($RDimmobilisation75)){ echo $RDimmobilisation75;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation76" id="RDimmobilisation76" oninput="sumValues()" value="<?php if(isset($RDimmobilisation76)){ echo $RDimmobilisation76;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation77" id="RDimmobilisation77" oninput="sumValues()" value="<?php if(isset($RDimmobilisation77)){ echo $RDimmobilisation77;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row16">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation78" id="RDimmobilisation78" oninput="sumValues()" value="<?php if(isset($RDimmobilisation78)){ echo $RDimmobilisation78;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation79" id="RDimmobilisation79" oninput="sumValues()" value="<?php if(isset($RDimmobilisation79)){ echo $RDimmobilisation79;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation80" id="RDimmobilisation80" oninput="sumValues()" value="<?php if(isset($RDimmobilisation80)){ echo $RDimmobilisation80;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation81" id="RDimmobilisation81" oninput="sumValues()" value="<?php if(isset($RDimmobilisation81)){ echo $RDimmobilisation81;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation82" id="RDimmobilisation82" oninput="sumValues()" value="<?php if(isset($RDimmobilisation82)){ echo $RDimmobilisation82;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation83" id="RDimmobilisation83" oninput="sumValues()" value="<?php if(isset($RDimmobilisation83)){ echo $RDimmobilisation83;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row17">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation84" id="RDimmobilisation84" oninput="sumValues()" value="<?php if(isset($RDimmobilisation84)){ echo $RDimmobilisation84;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation85" id="RDimmobilisation85" oninput="sumValues()" value="<?php if(isset($RDimmobilisation85)){ echo $RDimmobilisation85;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation86" id="RDimmobilisation86" oninput="sumValues()" value="<?php if(isset($RDimmobilisation86)){ echo $RDimmobilisation86;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation87" id="RDimmobilisation87" oninput="sumValues()" value="<?php if(isset($RDimmobilisation87)){ echo $RDimmobilisation87;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation88" id="RDimmobilisation88" oninput="sumValues()" value="<?php if(isset($RDimmobilisation88)){ echo $RDimmobilisation88;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation89" id="RDimmobilisation89" oninput="sumValues()" value="<?php if(isset($RDimmobilisation89)){ echo $RDimmobilisation89;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row18">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation90" id="RDimmobilisation90" oninput="sumValues()" value="<?php if(isset($RDimmobilisation90)){ echo $RDimmobilisation90;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation91" id="RDimmobilisation91" oninput="sumValues()" value="<?php if(isset($RDimmobilisation91)){ echo $RDimmobilisation91;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation92" id="RDimmobilisation92" oninput="sumValues()" value="<?php if(isset($RDimmobilisation92)){ echo $RDimmobilisation92;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation93" id="RDimmobilisation93" oninput="sumValues()" value="<?php if(isset($RDimmobilisation93)){ echo $RDimmobilisation93;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation94" id="RDimmobilisation94" oninput="sumValues()" value="<?php if(isset($RDimmobilisation94)){ echo $RDimmobilisation94;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation95" id="RDimmobilisation95" oninput="sumValues()" value="<?php if(isset($RDimmobilisation95)){ echo $RDimmobilisation95;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row19">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation96" id="RDimmobilisation96" oninput="sumValues()" value="<?php if(isset($RDimmobilisation96)){ echo $RDimmobilisation96;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation97" id="RDimmobilisation97" oninput="sumValues()" value="<?php if(isset($RDimmobilisation97)){ echo $RDimmobilisation97;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation98" id="RDimmobilisation98" oninput="sumValues()" value="<?php if(isset($RDimmobilisation98)){ echo $RDimmobilisation98;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation99" id="RDimmobilisation99" oninput="sumValues()" value="<?php if(isset($RDimmobilisation99)){ echo $RDimmobilisation99;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation100" id="RDimmobilisation100" oninput="sumValues()" value="<?php if(isset($RDimmobilisation100)){ echo $RDimmobilisation100;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation101" id="RDimmobilisation101" oninput="sumValues()" value="<?php if(isset($RDimmobilisation101)){ echo $RDimmobilisation101;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <tr class="row20">
            <td class="column0 style15 null"><input  type="date" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation102" id="RDimmobilisation102" oninput="sumValues()" value="<?php if(isset($RDimmobilisation102)){ echo $RDimmobilisation102;} ?>" /></td>
            <td class="column4 style17 null"><input  type="text" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder=" " required name="RDimmobilisation103" id="RDimmobilisation103" oninput="sumValues()" value="<?php if(isset($RDimmobilisation103)){ echo $RDimmobilisation103;} ?>" /></td>
            <td class="column5 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0"required name="RDimmobilisation104" id="RDimmobilisation104" oninput="sumValues()" value="<?php if(isset($RDimmobilisation104)){ echo $RDimmobilisation104;} ?>" /></td>
            <td class="column2 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation105" id="RDimmobilisation105" oninput="sumValues()" value="<?php if(isset($RDimmobilisation105)){ echo $RDimmobilisation105;} ?>" /></td>
            <td class="column3 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation106" id="RDimmobilisation106" oninput="sumValues()" value="<?php if(isset($RDimmobilisation106)){ echo $RDimmobilisation106;} ?>" /></td>
            <td class="column4 style17 null"><input  type="number" min="0" step="any" style="width: :63.71111038pt;text-align:center;" placeholder="0" required name="RDimmobilisation107" id="RDimmobilisation107" oninput="sumValues()" value="<?php if(isset($RDimmobilisation107)){ echo $RDimmobilisation107;} ?>" /></td>
            <!-- <td class="column6 style18 f">0.00 </td>
            <td class="column7 style18 f">0.00 </td> -->
          </tr>
          <!-- <tr class="row21">
            <td class="column0 style19 null"></td>
            <td class="column1 style20 s">Total</td>
            <td class="column2 style21 f">0.00</td>
            <td class="column3 style21 f">0.00</td>
            <td class="column4 style21 f">0.00</td>
            <td class="column5 style21 f">0.00</td>
            <td class="column6 style21 f">0.00</td>
            <td class="column7 style21 f">0.00</td>
          </tr> -->
  
 
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

</center>

    
  </body>
</html>
