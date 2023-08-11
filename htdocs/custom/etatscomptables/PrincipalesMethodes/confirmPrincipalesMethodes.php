<?php
    // Load Dolibarr environment
    require_once '../../../main.inc.php';
    require_once '../../../vendor/autoload.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
    llxHeader("", ""); 

    $returnpage=GETPOST('model');
    if($returnpage=="Principalesmethodes")
    { 
        $url = DOL_URL_ROOT . '/custom/etatscomptables/PrincipalesMethodes/declarationPrincipalesMethodes.php';
        echo"<script>window.location.href='$url';</script>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $check=$_POST['check']??'';
        if( $check == 'true')
        {
            // Retrieve the form data
            for ($i = 0; $i <=23; $i++) {
                ${'PrincipalesMethodes' . $i} = $_POST['PrincipalesMethodes' . $i];
            }
            


        
          $data = "<?php ";

          for ($i = 0; $i <= 23; $i++) {
            ${'PrincipalesMethodes' . $i} = $_POST['PrincipalesMethodes' . $i];
                if(${'PrincipalesMethodes' . $i}==$PrincipalesMethodes23)
                {
        
                    $selectedDate = new DateTime($PrincipalesMethodes23);
                    $year = $selectedDate->format('Y');
                    $data .= '$PrincipalesMethodes' . $i . ' = ' . $year . ";\n";   
        
                }else   if (is_string(${'PrincipalesMethodes' . $i})) {
                // If the value is a string, add double quotes around it
            $data .= '$PrincipalesMethodes' . $i . ' = "' . ${'PrincipalesMethodes' . $i} . "\";\n";
            }
            else {
                $data .= '$PrincipalesMethodes' . $i . ' = ' . ${'PrincipalesMethodes' . $i} . ";\n";  
            }
            
          }

          $data .= "?>";
          $selectedDate = new DateTime($PrincipalesMethodes23);
          $year = $selectedDate->format('Y'); // Extract the year value
          // Now, the variable $year will contain the year value "2023"
          $nomFichier = 'PrincipalesMethodes_fichier_'. $year.'.php';
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
    print '<input type="hidden" name="model" value="Principalesmethodes">';
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
    $filedir = DOL_DATA_ROOT . '/billanLaisse/Principalesmethodes/';
    $urlsource = $_SERVER['PHP_SELF'] . '';
    $genallowed = 0;
    $delallowed = 1;
    $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));
  
    if ($societe !== null && isset($societe->default_lang)) {
      print $formfile->showdocuments('Principalesmethodes', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
    } else {
        print $formfile->showdocuments('Principalesmethodes', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
    }
  
  }
  // Actions to build doc
  $action = GETPOST('action', 'aZ09');
  $upload_dir = DOL_DATA_ROOT . '/billanLaisse/Principalesmethodes/';
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
      td.style1 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style1 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style2 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style2 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style3 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style3 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style4 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      th.style4 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
      td.style5 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style5 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style6 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style6 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:10pt; background-color:white }
      th.style7 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial Narrow'; font-size:10pt; background-color:white }
      td.style8 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style8 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style9 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; text-decoration:underline; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style9 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; text-decoration:underline; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style10 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style10 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style11 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style11 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style12 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style12 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style13 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style13 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style14 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      th.style14 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:#D9E2F3 }
      td.style15 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style15 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style16 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      th.style16 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
      td.style17 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      th.style17 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
      td.style18 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:9pt; background-color:white }
      th.style18 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:9pt; background-color:white }
      td.style19 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:9pt; background-color:white }
      th.style19 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:9pt; background-color:white }
      td.style20 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style20 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:2px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      td.style21 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      th.style21 { vertical-align:middle; text-align:center; border-bottom:2px solid #000000 !important; border-top:2px solid #000000 !important; border-left:none #000000; border-right:2px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:14pt; background-color:white }
      table.sheet0 col.col0 { width:291.4444411pt }
      table.sheet0 col.col1 { width:173.51110912pt }
      table.sheet0 col.col2 { width:49.47777721pt }
      table.sheet0 col.col3 { width:47.4444439pt }
      table.sheet0 .column2 { visibility:collapse; display:none }
      table.sheet0 tr { height:13.636363636364pt }
      table.sheet0 tr.row0 { height:24.75pt }
      table.sheet0 tr.row1 { height:27.75pt }
      table.sheet0 tr.row2 { height:17pt }
      table.sheet0 tr.row3 { height:15pt }
      table.sheet0 tr.row4 { height:15pt }
      table.sheet0 tr.row5 { height:15pt }
      table.sheet0 tr.row6 { height:15pt }
      table.sheet0 tr.row7 { height:15pt }
      table.sheet0 tr.row8 { height:15pt }
      table.sheet0 tr.row9 { height:15pt }
      table.sheet0 tr.row10 { height:15pt }
      table.sheet0 tr.row11 { height:15pt }
      table.sheet0 tr.row12 { height:17pt }
      table.sheet0 tr.row13 { height:15pt }
      table.sheet0 tr.row14 { height:15pt }
      table.sheet0 tr.row15 { height:15pt }
      table.sheet0 tr.row16 { height:15pt }
      table.sheet0 tr.row17 { height:15pt }
      table.sheet0 tr.row18 { height:15pt }
      table.sheet0 tr.row19 { height:15pt }
      table.sheet0 tr.row20 { height:17pt }
      table.sheet0 tr.row21 { height:15pt }
      table.sheet0 tr.row22 { height:15pt }
      table.sheet0 tr.row23 { height:15pt }
      table.sheet0 tr.row24 { height:15pt }
      table.sheet0 tr.row25 { height:15pt }
      table.sheet0 tr.row26 { height:17pt }
      table.sheet0 tr.row27 { height:15pt }
      table.sheet0 tr.row28 { height:15pt }
      table.sheet0 tr.row29 { height:15pt }
      table.sheet0 tr.row30 { height:17pt }
      table.sheet0 tr.row31 { height:15pt }
      table.sheet0 tr.row32 { height:15pt }
      table.sheet0 tr.row33 { height:15pt }
      table.sheet0 tr.row34 { height:12.75pt }
    </style>
  </head>

  <body>
  <center>
<form method="POST" action="declarationPrincipalesMethodes.php">
    <?php
    // Loop to create the hidden input fields
    for ($i = 0; $i <= 23; $i++) {
        $PrincipalesMethodes = ${'PrincipalesMethodes' . $i};
      echo '<input type="hidden" name="PrincipalesMethodes' . $i . '" value="' . $PrincipalesMethodes . '" />';
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
        <tbody>
          <tr class="row0">
            <td class="column0 style20 s style21" colspan="2">PRINCIPALES METHODES D'EVALUATION SPECIFIQUES A L'ENTREPRISE</td>
            
          </tr>
          <tr class="row1">
            <td class="column0 style2 f"></td>
            <td class="column1 style3 f"></td>
            
          </tr>
          <tr class="row2">
            <td class="column0 style5 s">I. ACTIF IMMOBILISE</td>
            <td class="column1 style6 null"></td>
            <td class="column2 style7 s">GrasGauche</td>
          </tr>
          <tr class="row3">
            <td class="column0 style9 s">A. EVALUATION A L'ENTREE</td>
            <td class="column1 style10 null"></td>
            <td class="column2 style7 s">GrasGauche</td>
          </tr>
          <tr class="row4">
            <td class="column0 style11 s">1. Immobilisation en non-valeurs</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes0;?></td>
            
          </tr>
          <tr class="row5">
            <td class="column0 style11 s">2. Immobilisation incorporelles</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes1;?></td>
            
          </tr>
          <tr class="row6">
            <td class="column0 style11 s">3. Immobilisations corporelles</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes2;?></td>
            
          </tr>
          <tr class="row7">
            <td class="column0 style11 s">4. Immobilisations financières</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes3;?></td>
            
          </tr>
          <tr class="row8">
            <td class="column0 style9 s">B. CORRECTIONS DE VALEUR</td>
            <td class="column1 style10 null"></td>
            <td class="column2 style7 s">GrasGauche</td>
          </tr>
          <tr class="row9">
            <td class="column0 style11 s">1. Méthodes d'amortissements</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes4;?></td>
            
          </tr>
          <tr class="row10">
            <td class="column0 style11 s">2. Méthodes d'évaluation des provisions pour dépréciation</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes5;?></td>
            
          </tr>
          <tr class="row11">
            <td class="column0 style13 s">3. Méthodes de détermination des écarts de conversion - Actif</td>
            <td class="column1 style14 null"><?php echo $PrincipalesMethodes6;?></td>
            
          </tr>
          <tr class="row12">
            <td class="column0 style5 s">II. ACTIF CIRCULANT (Hors trésorerie)</td>
            <td class="column1 style6 null"></td>
            <td class="column2 style7 s">GrasGauche</td>
          </tr>
          <tr class="row13">
            <td class="column0 style9 s">A. EVALUATION A L'ENTREE</td>
            <td class="column1 style10 null"></td>
            <td class="column2 style7 s">GrasGauche</td>
          </tr>
          <tr class="row14">
            <td class="column0 style11 s">1. Stocks</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes7;?></td>
            
          </tr>
          <tr class="row15">
            <td class="column0 style11 s">2. Créances</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes8;?></td>
            
          </tr>
          <tr class="row16">
            <td class="column0 style11 s">3. Titres et valeurs de placement</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes9;?></td>
            
          </tr>
          <tr class="row17">
            <td class="column0 style9 s">B. CORRECTIONS DE VALEUR</td>
            <td class="column1 style15 null"></td>
            <td class="column2 style7 s">GrasGauche</td>
          </tr>
          <tr class="row18">
            <td class="column0 style11 s">1. Méthodes d'évaluation des provisions pour dépréciation</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes10;?></td>
            
          </tr>
          <tr class="row19">
            <td class="column0 style13 s">2. Méthodes de détermination des écarts de conversion - Actif</td>
            <td class="column1 style14 null"><?php echo $PrincipalesMethodes11;?></td>
            
          </tr>
          <tr class="row20">
            <td class="column0 style5 s">III. FINANCEMENT PERMANENT</td>
            <td class="column1 style6 null"></td>
            <td class="column2 style7 s">GrasGauche</td>
          </tr>
          <tr class="row21">
            <td class="column0 style11 s">1. Méthodes de réévaluation</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes12;?></td>
            
          </tr>
          <tr class="row22">
            <td class="column0 style11 s">2. Méthodes d'évaluation des provisions réglementées</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes13;?></td>
            
          </tr>
          <tr class="row23">
            <td class="column0 style11 s">3. Dettes de financement permanent</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes14;?></td>
            
          </tr>
          <tr class="row24">
            <td class="column0 style11 s">4. Méthodes d'évaluation des provisions durables pour risques et charges</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes15;?></td>
            
          </tr>
          <tr class="row25">
            <td class="column0 style13 s">5. Méthodes de détermination des écarts de conversion - Passif</td>
            <td class="column1 style14 null"><?php echo $PrincipalesMethodes16;?></td>
            
          </tr>
          <tr class="row26">
            <td class="column0 style5 s">IV. PASSIF CIRCULANT (Hors trésorerie)</td>
            <td class="column1 style6 null"></td>
            <td class="column2 style7 s">GrasGauche</td>
          </tr>
          <tr class="row27">
            <td class="column0 style11 s">1. Dettes du passif circulant</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes17;?></td>
            
          </tr>
          <tr class="row28">
            <td class="column0 style11 s">2. Méthodes d'évaluation des autres provisions pour risques et charges</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes18;?></td>
            
          </tr>
          <tr class="row29">
            <td class="column0 style13 s">3. Méthodes de détermination des écarts de conversion - Passif</td>
            <td class="column1 style14 null"><?php echo $PrincipalesMethodes19;?></td>
            
          </tr>
          <tr class="row30">
            <td class="column0 style17 s">V. TRESORERIE</td>
            <td class="column1 style10 null"></td>
            <td class="column2 style7 s">GrasGauche</td>
          </tr>
          <tr class="row31">
            <td class="column0 style11 s">1. Trésorerie - Actif</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes20;?></td>
            
          </tr>
          <tr class="row32">
            <td class="column0 style11 s">2. Trésorerie - Passif</td>
            <td class="column1 style12 null"><?php echo $PrincipalesMethodes21;?></td>        
          </tr>
          <tr class="row33">
            <td class="column0 style13 s">3. Méthodes d'évaluation des provisions pour dépréciation</td>
            <td class="column1 style14 null"><?php echo $PrincipalesMethodes22;?></td>     
          </tr>
          <tr class="row34">
            <td class="column0 style19 null"></td>
            <td class="column1 style18 null"></td>
            
          </tr>
        </tbody>
    </table>
  </body>
</html>
