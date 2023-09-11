<?php
// Load Dolibarr environment
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
llxHeader("", ""); 


$returnpage=GETPOST('model');




if($returnpage=="Retratsdimm")
{ 
    $url = DOL_URL_ROOT . '/custom/etatscomptables/Retratsdimm/declarationRetratsDimmobilistion.php';
    echo"<script>window.location.href='$url';</script>";
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check=$_POST['check']??'';
    if( $check == 'true')
    {
    // Retrieve the form data
    for ($i = 0; $i <= 108; $i++) {
        ${'RDimmobilisation' . $i} = $_POST['RDimmobilisation' . $i];
    }

    function ValuesPlus($Plusvalue1,$Plusvalue2){ $PlusValues=($Plusvalue1>$Plusvalue2)?$Plusvalue1 - $Plusvalue2 : 0;   return  $PlusValues; }
    function ValuesMoins($Plusvalue1,$Plusvalue2){ $PlusValues=($Plusvalue1>$Plusvalue2)?$Plusvalue1 - $Plusvalue2 : 0; return  $PlusValues; }

    $PlusValues1= ValuesPlus($RDimmobilisation5,$RDimmobilisation4);
    $MoinsValues1= ValuesMoins($RDimmobilisation4,$RDimmobilisation5);
    $PlusValues2= ValuesPlus($RDimmobilisation11,$RDimmobilisation10);
    $MoinsValues2= ValuesMoins($RDimmobilisation10,$RDimmobilisation11);
    $PlusValues3= ValuesPlus($RDimmobilisation17,$RDimmobilisation16) ;
    $MoinsValues3=ValuesMoins($RDimmobilisation16,$RDimmobilisation17) ;
    $PlusValues4= ValuesPlus($RDimmobilisation23,$RDimmobilisation22) ;
    $MoinsValues4=ValuesMoins($RDimmobilisation22,$RDimmobilisation23);
    $PlusValues5= ValuesPlus($RDimmobilisation29,$RDimmobilisation28) ;
    $MoinsValues5=ValuesMoins($RDimmobilisation28,$RDimmobilisation29) ;
    $PlusValues6= ValuesPlus($RDimmobilisation35,$RDimmobilisation34);
    $MoinsValues6=ValuesMoins($RDimmobilisation34,$RDimmobilisation35) ;
    $PlusValues7= ValuesPlus($RDimmobilisation41,$RDimmobilisation40);
    $MoinsValues7=ValuesMoins($RDimmobilisation40,$RDimmobilisation41);
    $PlusValues8= ValuesPlus($RDimmobilisation47,$RDimmobilisation46);
    $MoinsValues8=ValuesMoins($RDimmobilisation46,$RDimmobilisation47);
    $PlusValues9= ValuesPlus($RDimmobilisation53,$RDimmobilisation52);
    $MoinsValues9=ValuesMoins($RDimmobilisation52,$RDimmobilisation53);
    $PlusValues10= ValuesPlus($RDimmobilisation59,$RDimmobilisation58);
    $MoinsValues10=ValuesMoins($RDimmobilisation58,$RDimmobilisation59);
    $PlusValues11= ValuesPlus($RDimmobilisation65,$RDimmobilisation64);
    $MoinsValues11=ValuesMoins($RDimmobilisation64,$RDimmobilisation65);
    $PlusValues12= ValuesPlus($RDimmobilisation71,$RDimmobilisation70);
    $MoinsValues12=ValuesMoins($RDimmobilisation70,$RDimmobilisation71);
    $PlusValues13= ValuesPlus($RDimmobilisation77,$RDimmobilisation76);
    $MoinsValues13=ValuesMoins($RDimmobilisation76,$RDimmobilisation77);
    $PlusValues14= ValuesPlus($RDimmobilisation83,$RDimmobilisation82);
    $MoinsValues14=ValuesMoins($RDimmobilisation82,$RDimmobilisation83);
    $PlusValues15= ValuesPlus($RDimmobilisation89,$RDimmobilisation88);
    $MoinsValues15=ValuesMoins($RDimmobilisation88,$RDimmobilisation89);
    $PlusValues16= ValuesPlus($RDimmobilisation95,$RDimmobilisation94);
    $MoinsValues16=ValuesMoins($RDimmobilisation94,$RDimmobilisation95);
    $PlusValues17= ValuesPlus($RDimmobilisation101,$RDimmobilisation100);
    $MoinsValues17=ValuesMoins($RDimmobilisation100,$RDimmobilisation101);
    $PlusValues18= ValuesPlus($RDimmobilisation107,$RDimmobilisation106);
    $MoinsValues18=ValuesMoins($RDimmobilisation106,$RDimmobilisation107);
    //Montant brut
    $sum1=$RDimmobilisation2+$RDimmobilisation8+$RDimmobilisation14+$RDimmobilisation20+$RDimmobilisation26+$RDimmobilisation32+$RDimmobilisation38+$RDimmobilisation44+$RDimmobilisation50
    +$RDimmobilisation56+$RDimmobilisation62+$RDimmobilisation68+$RDimmobilisation74+$RDimmobilisation80+$RDimmobilisation86+$RDimmobilisation92+$RDimmobilisation98+$RDimmobilisation98+$RDimmobilisation104;
    // Amortissements cumulés
    $sum2=$RDimmobilisation3+$RDimmobilisation9+$RDimmobilisation15+$RDimmobilisation21+$RDimmobilisation27+$RDimmobilisation33+$RDimmobilisation39+$RDimmobilisation45+$RDimmobilisation51
    +$RDimmobilisation57+$RDimmobilisation63+$RDimmobilisation69+$RDimmobilisation75+$RDimmobilisation81+$RDimmobilisation87+$RDimmobilisation93+$RDimmobilisation99+$RDimmobilisation98+$RDimmobilisation105;
    // Valeur nette d'amortissement
    $sum3=$RDimmobilisation4+$RDimmobilisation10+$RDimmobilisation16+$RDimmobilisation22+$RDimmobilisation28+$RDimmobilisation34+$RDimmobilisation40+$RDimmobilisation46+$RDimmobilisation52+$RDimmobilisation58+$RDimmobilisation64+$RDimmobilisation70+$RDimmobilisation76
    +$RDimmobilisation82+$RDimmobilisation88+$RDimmobilisation94+$RDimmobilisation100+$RDimmobilisation106;
    // Produit de cession
    $sum4=$RDimmobilisation5+$RDimmobilisation11+$RDimmobilisation17+$RDimmobilisation23+$RDimmobilisation29+$RDimmobilisation35+$RDimmobilisation41+$RDimmobilisation47+$RDimmobilisation53+$RDimmobilisation59+$RDimmobilisation65+$RDimmobilisation71+$RDimmobilisation77
    +$RDimmobilisation83+$RDimmobilisation89+$RDimmobilisation95+$RDimmobilisation101+$RDimmobilisation107;
    // Plus values
    $sum5=$PlusValues1+ $PlusValues2+ $PlusValues3+$PlusValues4+$PlusValues5+$PlusValues6+$PlusValues7+$PlusValues8+$PlusValues9+$PlusValues10+$PlusValues11+$PlusValues12+$PlusValues13+$PlusValues14
    + $PlusValues15+$PlusValues16+$PlusValues17+$PlusValues18;
   // Moins values
    $sum6= $MoinsValues1+ $MoinsValues2 +$MoinsValues3+$MoinsValues4+$MoinsValues5+$MoinsValues6+$MoinsValues7+$MoinsValues8+$MoinsValues9+$MoinsValues10+$MoinsValues11+$MoinsValues12+$MoinsValues13+$MoinsValues14
    + $MoinsValues15+$MoinsValues16+$MoinsValues17+$MoinsValues18;

    $data = "<?php ";

    for ($i = 0; $i <= 108; $i++) {
        ${'RDimmobilisation' . $i} = $_POST['RDimmobilisation' . $i];
 

        if (is_string(${'RDimmobilisation' . $i})) {
          // If the value is a string, add double quotes around it
          $data .= '$RDimmobilisation' . $i . ' = "' . ${'RDimmobilisation' . $i} . "\";\n";
        }
        else {
            $data .= '$RDimmobilisation' . $i . ' = ' . ${'RDimmobilisation' . $i} . ";\n";
        }
    }
    for ($i = 1; $i <= 18; $i++) {
      
        $data .= '$PlusValues' . $i . ' = ' . ${'PlusValues' . $i} . ";\n";   
        $data .= '$MoinsValues' . $i . ' = ' . ${'MoinsValues' . $i} . ";\n"; 
    }
    $data .= '$sum1 = ' . $sum1 . ";\n";
    $data .= '$sum2 = ' . $sum2 . ";\n";
    $data .= '$sum3 = ' . $sum3 . ";\n";
    $data .= '$sum4 = ' . $sum4 . ";\n";
    $data .= '$sum5 = ' . $sum5 . ";\n";
    $data .= '$sum6 = ' . $sum6 . ";\n"; 
    $data .= "?>";
    $selectedDate = new DateTime($RDimmobilisation108);
    $year = $selectedDate->format('Y'); // Extract the year value
    // Now, the variable $year will contain the year value "2023"
    $nomFichier = 'RetratsDimmobilisation_fichier_'. $year.'.php';
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
    print '<input type="hidden" name="model" value="Retratsdimm">';
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


<form method="POST" action="declarationRetratsDimmobilistion.php">
    <?php
    // Loop to create the hidden input fields
    for ($i = 0; $i <= 107; $i++) {
        $RDimmobilisation = ${'RDimmobilisation' . $i};
      echo '<input type="hidden" name="RDimmobilisation' . $i . '" value="' . $RDimmobilisation . '" />';
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
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <col class="col7">
        <col class="col8">
        <col class="col9">
        <col class="col10">
        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style3" colspan="8">TABLEAU DES PLUS OU MOINS VALUES SUR CESSIONS OU RETRAITS D'IMMOBILISATIONS</td>

          </tr>
          <tr class="row1">
            <td class="column0 style5 f"></td>
            <td class="column1 style6 null"></td>
            <td class="column2 style7 null"></td>
            <td class="column3 style8 s"></td>
            <td class="column4 style9 f"></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style7 null"></td>
            <td class="column7 style10 f"></td>

          </tr>
          <tr class="row2">
            <td class="column0 style12 s">Date de cession ou de retrait</td>
            <td class="column1 style12 s">Compte principal</td>
            <td class="column2 style12 s">Montant brut</td>
            <td class="column3 style12 s">Amortissements cumulés</td>
            <td class="column4 style13 s">Valeur nette d'amortissement</td>
            <td class="column5 style12 s">Produit de cession</td>
            <td class="column6 style12 s">Plus values</td>
            <td class="column7 style12 s">Moins values</td>

          </tr>
          <tr class="row3">
            <td class="column0 style15 null"><?php echo $RDimmobilisation0;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation1;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation2;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation3;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation4;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation5;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues1;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues1;?> </td>

          </tr>
          <tr class="row4">
            <td class="column0 style15 null"><?php echo $RDimmobilisation6;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation7;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation8;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation9;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation10;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation11;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues2;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues2;?> </td>

          </tr>
          <tr class="row5">
            <td class="column0 style15 null"><?php echo $RDimmobilisation12;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation13;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation14;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation15;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation16;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation17;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues3;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues3;?> </td>

          </tr>
          <tr class="row6">
            <td class="column0 style15 null"><?php echo $RDimmobilisation18;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation19;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation20;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation21;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation22;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation23;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues4;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues4;?> </td>

          </tr>
          <tr class="row7">
            <td class="column0 style15 null"><?php echo $RDimmobilisation24;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation25;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation26;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation27;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation28;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation29;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues5;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues5;?> </td>

          </tr>
          <tr class="row8">
            <td class="column0 style15 null"><?php echo $RDimmobilisation30;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation31;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation32;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation33;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation34;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation35;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues6;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues6;?> </td>
          </tr>
          <tr class="row9">
            <td class="column0 style15 null"><?php echo $RDimmobilisation36;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation37;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation38;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation39;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation40;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation41;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues7;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues7;?> </td>
          </tr>
          <tr class="row10">
            <td class="column0 style15 null"><?php echo $RDimmobilisation42;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation43;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation44;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation45;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation46;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation47;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues8;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues8;?> </td>
          </tr>
          <tr class="row11">
            <td class="column0 style15 null"><?php echo $RDimmobilisation48;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation49;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation5;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation51;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation52;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation53;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues9;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues9;?> </td>
          </tr>
          <tr class="row12">
            <td class="column0 style15 null"><?php echo $RDimmobilisation54;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation55;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation56;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation57;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation58;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation59;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues10;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues10;?> </td>
          </tr>
          <tr class="row13">
            <td class="column0 style15 null"><?php echo $RDimmobilisation60;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation61;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation62;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation63;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation64;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation65;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues11;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues11;?> </td>
          </tr>
          <tr class="row14">
            <td class="column0 style15 null"><?php echo $RDimmobilisation66;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation67;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation68;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation69;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation70;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation71;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues12;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues12;?> </td>
          </tr>
          <tr class="row15">
            <td class="column0 style15 null"><?php echo $RDimmobilisation72;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation73;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation74;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation75;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation76;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation77;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues13;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues13;?> </td>
          </tr>
          <tr class="row16">
            <td class="column0 style15 null"><?php echo $RDimmobilisation78;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation79;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation80;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation81;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation82;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation83;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues14;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues14;?> </td>
          </tr>
          <tr class="row17">
            <td class="column0 style15 null"><?php echo $RDimmobilisation84;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation85;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation86;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation87;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation88;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation89;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues15;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues15;?> </td>
          </tr>
          <tr class="row18">
            <td class="column0 style15 null"><?php echo $RDimmobilisation90;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation91;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation92;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation93;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation94;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation95;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues16;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues16;?> </td>
          </tr>
          <tr class="row19">
            <td class="column0 style15 null"><?php echo $RDimmobilisation96;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation97;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation98;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation99;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation100;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation101;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues17;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues17;?> </td>
          </tr>
          <tr class="row20">
            <td class="column0 style15 null"><?php echo $RDimmobilisation102;?></td>
            <td class="column1 style16 null"><?php echo $RDimmobilisation103;?></td>
            <td class="column2 style17 null"><?php echo $RDimmobilisation104;?></td>
            <td class="column3 style17 null"><?php echo $RDimmobilisation105;?></td>
            <td class="column4 style17 null"><?php echo $RDimmobilisation106;?></td>
            <td class="column5 style17 null"><?php echo $RDimmobilisation107;?></td>
            <td class="column6 style18 f"><?php echo $PlusValues18;?></td>
            <td class="column7 style18 f"><?php echo $MoinsValues18;?> </td>
          </tr>
          <tr class="row21">
            <td class="column0 style19 null"></td>
            <td class="column1 style20 s">Total</td>
            <td class="column2 style21 f"><?php echo $sum1;?></td>
            <td class="column3 style21 f"><?php echo $sum2;?></td>
            <td class="column4 style21 f"><?php echo $sum3;?></td>
            <td class="column5 style21 f"><?php echo $sum4;?></td>
            <td class="column6 style21 f"><?php echo $sum5;?></td>
            <td class="column7 style21 f"><?php echo $sum6;?></td>
          </tr>
  
 
        </tbody>
</table>
    </center>






  



</body>
</html>