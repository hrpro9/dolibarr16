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
            for ($i = 0; $i <= 6; $i++) {
                ${'Etatderogations' . $i} = $_POST['Etatderogations' . $i];
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
        print '<input type="hidden" name="model" value="Etatderogations">';
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
        $filedir = DOL_DATA_ROOT . '/billanLaisse/Etatderogations/';
        $urlsource = $_SERVER['PHP_SELF'] . '';
        $genallowed = 0;
        $delallowed = 1;
        $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

        if ($societe !== null && isset($societe->default_lang)) {
            print $formfile->showdocuments('Etatderogations', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
        } else {
            print $formfile->showdocuments('Etatderogations', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
        }

        }
        // Actions to build doc
        $action = GETPOST('action', 'aZ09');
        $upload_dir = DOL_DATA_ROOT . '/billanLaisse/Etatderogations/';
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
      td.style4 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style4 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style5 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style5 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style6 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style6 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style7 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style7 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style8 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style8 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style9 { vertical-align:top; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      th.style9 { vertical-align:top; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D8D8D8 }
      td.style10 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style10 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style11 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; text-decoration:underline; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style11 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; text-decoration:underline; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style12 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style12 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style13 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style13 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style14 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style14 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style15 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style15 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style16 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style16 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style17 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; text-decoration:underline; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style17 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; text-decoration:underline; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style18 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style18 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style19 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style19 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style20 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style20 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style21 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style21 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style22 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:9pt; background-color:white }
      th.style22 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:9pt; background-color:white }
      td.style23 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:9pt; background-color:white }
      th.style23 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:9pt; background-color:white }
      td.style24 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style24 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style25 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:9pt; background-color:white }
      th.style25 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:9pt; background-color:white }
      table.sheet0 col.col0 { width:201.97777546pt }
      table.sheet0 col.col1 { width:102.34444327pt }
      table.sheet0 col.col2 { width:102.34444327pt }
      table.sheet0 col.col3 { width:0pt }
      table.sheet0 col.col4 { width:49.47777721pt }
      table.sheet0 .column3 { visibility:collapse; display:none }
      table.sheet0 tr { height:16.363636363636pt }
      table.sheet0 tr.row0 { height:20pt }
      table.sheet0 tr.row1 { height:15pt }
      table.sheet0 tr.row2 { height:60pt }
      table.sheet0 tr.row3 { height:15pt }
      table.sheet0 tr.row4 { height:16.363636363636pt }
      table.sheet0 tr.row5 { height:16.363636363636pt }
      table.sheet0 tr.row6 { height:16.363636363636pt }
      table.sheet0 tr.row7 { height:16.363636363636pt }
      table.sheet0 tr.row8 { height:16.363636363636pt }
      table.sheet0 tr.row9 { height:16.363636363636pt }
      table.sheet0 tr.row10 { height:16.363636363636pt }
      table.sheet0 tr.row11 { height:15pt }
      table.sheet0 tr.row12 { height:16.363636363636pt }
      table.sheet0 tr.row13 { height:16.363636363636pt }
      table.sheet0 tr.row14 { height:16.363636363636pt }
      table.sheet0 tr.row15 { height:16.363636363636pt }
      table.sheet0 tr.row16 { height:16.363636363636pt }
      table.sheet0 tr.row17 { height:16.363636363636pt }
      table.sheet0 tr.row18 { height:16.363636363636pt }
      table.sheet0 tr.row23 { height:15pt }
      table.sheet0 tr.row29 { height:15pt }
    </style>
  </head>

  <body>
<center>
  <form method="POST" action="confirmEtatDerogations.php">
    <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <center>
        <input type="date" name="Etatderogations6"  id="Etatderogations6" value="<?php if(isset($Etatderogations6)){ echo $Etatderogations6;} ?>"  placeholder ="Année" required style="margin-top: 18px;font-size:95%; background: #ededed; font-weight:bolder; padding: 8px 15px 8px 15px; border: block; ">
        <input type="hidden" name="check"  value="true">
        </center>
        <tbody>
          <tr class="row0">
          <td class="column0 style1 s style3" colspan="3">ETAT DES DEROGATIONS 
          </td>  
          </tr>
          <tr class="row1">
            <td class="column0 style5 f"></td>
            <td class="column1">&nbsp;</td>
            <td class="column2 style7 f"></td>
           
          </tr>
          <tr class="row2">
            <td class="column0 style8 s">Indication des Dérogations </td>
            <td class="column1 style9 s">Justification des Dérogations</td>
            <td class="column2 style9 s">Influence des Dérogations sur le Patrimoine, la Situation Financière et les Résultats	</td>
           
          </tr>   
          <tr class="row4">
            <td class="column0 style14 null">I. Dérogations aux principes comptables fondamentaux</td>
            <?php
            for ($i = 0; $i <=1; $i++) {
                echo '<td class="column1 style15 null"><input min="0" type="text" required style="width: 125px;" name="Etatderogations' . $i . '" id="Etatderogations' . $i . '" value="';
                if (isset(${"Etatderogations" . $i})) {
                    echo ${"Etatderogations" . $i};
                }
                echo '" /></td>' . "\n";
            }                 
            ?>
           
          </tr>
          <tr class="row4">
            <td class="column0 style14 null">II. Dérogations aux méthodes d'évaluation</td>
            <?php
            for ($i = 2; $i <=3; $i++) {
                echo '<td class="column1 style15 null"><input min="0" type="text" required style="width: 125px;" name="Etatderogations' . $i . '" id="Etatderogations' . $i . '" value="';
                if (isset(${"Etatderogations" . $i})) {
                    echo ${"Etatderogations" . $i};
                }
                echo '" /></td>' . "\n";
            }
            ?>
          </tr>
          <tr class="row5">
            <td class="column0 style14 null">III. Dérogations aux règles d'établissement et de présentation des états de synthèse</td>
            <?php
            for ($i = 4; $i <=5; $i++) {
                echo '<td class="column1 style15 null"><input min="0" type="text" required style="width: 125px;" name="Etatderogations' . $i . '" id="Etatderogations' . $i . '" value="';
                if (isset(${"Etatderogations" . $i})) {
                    echo ${"Etatderogations" . $i};
                }
                echo '" /></td>' . "\n";
            }
            ?>
           
          </tr>

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
