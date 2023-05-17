<?php
  // Load Dolibarr environment
  require '../../main.inc.php';
  require_once '../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
  llxHeader("", ""); 

  $capitauxPropres=$capitauxPropresN1=$capitauxPropresN2=0; // CAPITAUX PROPRES
  $CapitalSocialPersonnel=$CapitalSocialPersonnelN1=$CapitalSocialPersonnelN2=0; // Capital social ou personnel (1)
  $aCapita=$aCapitaN1=$aCapitaN2=0; // Actionnaires, capital souscrit non appelé  dont versé
  $cAppele=$cAppeleN1=$cAppeleN2=0; // Capital appelé 
  $DVerse=$DVerseN1=$DVerseN2=0; // Moins : Dont versé 
  $PrimeDFD=$PrimeDFDN1=$PrimeDFDN2=0; // Prime d'emission, de fusion, d'apport
  $EcartsR=$EcartsRN1=$EcartsRN2=0; // Ecarts de reévaluation
  $reserveL=$reserveLN1=$reserveLN2=0; // Réserve légale
  $autresR=$autresRN1=$autresRN2=0; // Autres reserves
  $ReportN=$ReportNN1=$ReportNN2=0;// Report à nouveau (2)
  $resultatNID=$resultatNIDN1=$resultatNIDN2=0; // Résultat nets en instance d'affectation (2)
  $resultatNL=$resultatNLN1=$resultatNLN2=$resultatNL6=$resultatNL6N1=$resultatNL6N2=$resultatNL7=$resultatNL7N1=$resultatNL7N2=0; // Résultat net de l'exercice (2)
  $totalCP= $totalCPN1= $totalCPN2=0; // TOTAL DES CAPITAUX PROPRES ( a )
  $SubventionsD=$SubventionsDN1=$SubventionsDN2=0; // Subventions d'investissement
  $provisionsR=$provisionsRN1=$provisionsRN2=0; // Provisions réglementées
  $capitauxPA=$capitauxPAN1=$capitauxPAN2=0; // CAPITAUX PROPRES ASSIMILES ( b )
  $empruntsO=$empruntsON1=$empruntsON2=0; // Emprunts obligataires
  $autresDF=$autresDFN1=$autresDFN2=0; // Autres dettes de financement
  $dettesDF=$dettesDFN1=$dettesDFN2=0; // DETTES DE FINANCEMENT ( c )
  $provisionsPR=$provisionsPRN1=$provisionsPRN2=0; // Provisions pour risques
  $provisionsPC=$provisionsPCN1=$provisionsPCN2=0; // Provisions pour charges
  $provisionsDPREC=$provisionsDPRECN1=$provisionsDPRECN2=0; // PROVISIONS DURABLES POUR RISQUES ET CHARGES ( d )
  $augmentationDCI=$augmentationDCIN1=$augmentationDCIN2=0; // Augmentation des créances immobilisées


  if(isset($_POST['chargement'])){
   $dateChoisis=$_POST['date_select'];
  }
  
  function affichageAnnees(){
    $anneeDebut = date('Y');
    $anneeFin = 2015;
    for ($annee = $anneeDebut; $annee >= $anneeFin; $annee--) {  
      echo '<option value="' . $annee . '">' . $annee . '</option>';
    }
  }
  function readMontant($name){
    $name=!empty($name)?$name:0;
    echo number_format($name,2);
  }
  function montantCalcul($code_compt)
  {
    global $db; // Assurez-vous que la variable $db est accessible dans cette fonction 
    $sql = "SELECT SUM(montant) AS montant FROM llx_accounting_bookkeeping WHERE numero_compte LIKE '$code_compt%'";
    $rest = $db->query($sql);
    $row = ((object)($rest))->fetch_assoc();
    $mont = 0; // Initialisez la variable $mont pour éviter une erreur si aucune valeur n'est trouvée
    $mont = $row['montant'];
    return $mont;
  }

  $sql="SELECT * FROM llx_accounting_bookkeeping";
  $rest=$db->query($sql);
  foreach( $rest as $row )
  { 
    $anneeDebut = (!empty($dateChoisis))?$dateChoisis:date('Y');
    $datetime = new DateTime($row['date_creation']);
    $dateCreation = $datetime->format('Y');
    if($dateCreation==$anneeDebut)
    {
      $numero_compte=$row['numero_compte'];
      $montant=$row['montant'];
      switch($numero_compte)
      {
          case "1119" : $aCapita=montantCalcul('1119');break;
          case "0" :  $cAppele=montantCalcul('0');break;
          case "0" :  $DVerse=montantCalcul('0');break;
          case "112" :  $PrimeDFD=montantCalcul('112');break;
          case "113" :  $EcartsR=montantCalcul('113');break;
          case "114" :  $reserveL=montantCalcul('114');break;
          case "115" :  $autresR=montantCalcul('155');break;
          case "116" :  $ReportN=montantCalcul('116');break;
          case "118" :  $resultatNID=montantCalcul('118');break;
          case "6" :  $resultatNL6=montantCalcul('6');break;
          case "7" :  $resultatNL7=montantCalcul('7');break;
          case "131" :  $SubventionsD=montantCalcul('131');break;
          case "135" :  $provisionsR=montantCalcul('135');break;
          case "141" :  $empruntsO=montantCalcul('141');break;
          case "148" :  $autresDF=montantCalcul('148');break;
          case "151" :  $provisionsPR=montantCalcul('151');break;
          case "155" :  $provisionsPC=montantCalcul('155');break;
          case "171" :  $augmentationDCI=montantCalcul('171');break;
          
         
          default : $default=$montant;break;
      }
      $capitauxPropres=0;
      $CapitalSocialPersonnel=(-$aCapita+$cAppele);
      $resultatNL=(-$resultatNL7-$resultatNL6);
      $totalCP=$CapitalSocialPersonnel+$aCapita+$cAppele+$DVerse+$PrimeDFD+$EcartsR+$reserveL+$autresR+$resultatNID+$resultatNL;
      $capitauxPA=$SubventionsD+ $provisionsR;
      $dettesDF=$empruntsO+$autresDF;
      $provisionsDPREC=$provisionsPR+$provisionsPC;
    }else if($dateCreation==($anneeDebut-1)){
      $numero_compte=$row['numero_compte'];
      $montant=$row['montant'];
      switch($numero_compte)
      {
        case "1119" : $aCapitaN1=montantCalcul('1119');break;
        case "0" :  $cAppeleN1=montantCalcul('0');break;
        case "0" :  $DVerseN1=montantCalcul('0');break;
        case "112" :  $PrimeDFDN1=montantCalcul('112');break;
        case "113" :  $EcartsRN1=montantCalcul('113');break;
        case "114" :  $reserveLN1=montantCalcul('114');break;
        case "115" :  $autresRN1=montantCalcul('155');break;
        case "116" :  $ReportNN1=montantCalcul('116');break;
        case "118" :  $resultatNIDN1=montantCalcul('118');break;
        case "6" :  $resultatNL6N1=montantCalcul('6');break;
        case "7" :  $resultatNL7N1=montantCalcul('7');break;
        case "131" :  $SubventionsDN1=montantCalcul('131');break;
        case "135" :  $provisionsRN1=montantCalcul('135');break;
        case "141" :  $empruntsON1=montantCalcul('141');break;
        case "148" :  $autresDFN1=montantCalcul('148');break;
        case "151" :  $provisionsPRN1=montantCalcul('151');break;
        case "155" :  $provisionsPCN1=montantCalcul('155');break;
        case "171" :  $augmentationDCIN1=montantCalcul('171');break;
        
        default : $default=$montant;break;
      }
      $capitauxPropresN1=0;
      $CapitalSocialPersonnelN1=(-$aCapitaN1+$cAppeleN1);
      $resultatNLN1=(-$resultatNL7N1-$resultatNL6N1);
      $totalCPN1=$CapitalSocialPersonnelN1+$aCapitaN1+$cAppeleN1+$DVerseN1+$PrimeDFDN1+$EcartsRN1+$reserveLN1+$autresRN1+$resultatNIDN1+$resultatNLN1;
      $capitauxPAN1=$SubventionsDN1+ $provisionsRN1;
      $dettesDFN1=$empruntsON1+$autresDFN1;
      $provisionsDPRECN1=$provisionsPRN1+$provisionsPCN1;
    }else if($dateCreation==($anneeDebut-2)){
      $numero_compte=$row['numero_compte'];
      $montant=$row['montant'];
      switch($numero_compte)
      {
        case "1119" : $aCapitaN2=montantCalcul('1119');break;
        case "0" :  $cAppeleN2=montantCalcul('0');break;
        case "0" :  $DVerseN2=montantCalcul('0');break;
        case "112" :  $PrimeDFDN2=montantCalcul('112');break;
        case "113" :  $EcartsRN2=montantCalcul('113');break;
        case "114" :  $reserveLN2=montantCalcul('114');break;
        case "115" :  $autresRN2=montantCalcul('155');break;
        case "116" :  $ReportNN2=montantCalcul('116');break;
        case "118" :  $resultatNIDN2=montantCalcul('118');break;
        case "6" :  $resultatNL6N2=montantCalcul('6');break;
        case "7" :  $resultatNL7N2=montantCalcul('7');break;
        case "131" :  $SubventionsDN2=montantCalcul('131');break;
        case "135" :  $provisionsRN2=montantCalcul('135');break;
        case "141" :  $empruntsON2=montantCalcul('141');break;
        case "148" :  $autresDFN2=montantCalcul('148');break;
        case "151" :  $provisionsPRN2=montantCalcul('151');break;
        case "155" :  $provisionsPCN2=montantCalcul('155');break;
        case "171" :  $augmentationDCIN2=montantCalcul('171');break;

        default : $default=$montant;break;
      }
      $capitauxPropresN2=0;
      $CapitalSocialPersonnelN2=(-$aCapitaN2+$cAppeleN2);
      $resultatNLN2=(-$resultatNL7N2-$resultatNL6N2);
      $totalCPN2=$CapitalSocialPersonnelN2+$aCapitaN2+$cAppeleN2+$DVerseN2+$PrimeDFDN2+$EcartsRN2+$reserveLN2+$autresRN2+$resultatNIDN2+$resultatNLN2;
      $capitauxPAN2=$SubventionsDN2+ $provisionsRN2;
      $dettesDFN2=$empruntsON2+$autresDFN2;
      $provisionsDPRECN2=$provisionsPRN2+$provisionsPCN2;
    } 


  }
  
  
  

   

  
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
    <form method="POST" >
     <select name="date_select"><?php affichageAnnees()?></select>
     <button type="submit" name="chargement" style="margin-top: 18px;background: #4B99AD;padding: 8px 15px 8px 15px;border: none;color: #fff;">Chargement</button><br>  
    </form>
    <br>
      <?php
        $date=(!empty($dateChoisis))?$dateChoisis:date('Y');
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
        <tbody style="text-align: center;">
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
            <td class="column4 style82 f"></td>
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
            <td class="column3 style53 null"><?php readMontant(($capitauxPropres*-1*-1))?></td>
            <td class="column4 style52 null"><?php readMontant(($capitauxPropresN1*-1*-1))?></td>
            <td class="column5 style8 null"></td>
            <td class="column6 style51 null"><?php readMontant(($capitauxPropresN2*-1*-1))?></td>
          </tr>
          <tr class="row4">
            <td class="column0 style59 s">Capital social ou personnel (1)</td>
            <td class="column1 style58 null"></td>
            <td class="column2 style57 null"></td>
            <td class="column3 style50 null"><?php readMontant(($CapitalSocialPersonnel*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($CapitalSocialPersonnelN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($CapitalSocialPersonnelN2*-1*-1))?></td>
          </tr>
          <tr class="row5">
            <td class="column0 style26 s">moins : Actionnaires, capital souscrit non appelé    dont versé</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"><?php readMontant(($aCapita*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($aCapitaN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($aCapitaN2*-1*-1))?></td>
          </tr>
          <tr class="row6">
            <td class="column0 style26 s">Moins : Capital appelé </td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"><?php readMontant(($cAppele*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($cAppeleN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($cAppeleN2*-1*-1))?></td>
          </tr>
          <tr class="row7">
            <td class="column0 style26 s">Moins : Dont versé </td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"><?php readMontant(($DVerse*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($DVerseN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($DVerseN2*-1*-1))?></td>
          </tr>
          <tr class="row8">
            <td class="column0 style26 s">Prime d'emission, de fusion, d'apport</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"><?php readMontant(($PrimeDFD*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($PrimeDFDN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($PrimeDFDN2*-1*-1))?></td>
          </tr>
          <tr class="row9">
            <td class="column0 style26 s">Ecarts de reévaluation</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"><?php readMontant(($EcartsR*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($EcartsRN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($EcartsRN2*-1*-1))?></td>
          </tr>
          <tr class="row10">
            <td class="column0 style26 s">Réserve légale</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"><?php readMontant(($reserveL*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($reserveLN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($reserveLN2*-1*-1))?></td>
          </tr>
          <tr class="row11">
            <td class="column0 style26 s">Autres reserves</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"><?php readMontant(($autresR*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($autresRN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($autresRN2*-1*-1))?></td>
          </tr>
          <tr class="row12">
            <td class="column0 style26 s">Report à nouveau (2)</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"><?php readMontant(($ReportN*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($ReportNN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($ReportNN2*-1*-1))?></td>
          </tr>
          <tr class="row13">
            <td class="column0 style26 s">Résultat nets en instance d'affectation (2)</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"><?php readMontant(($resultatNID*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($resultatNIDN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($resultatNIDN2*-1*-1))?></td>
          </tr>
          <tr class="row14">
            <td class="column0 style20 s">Résultat net de l'exercice (2)</td>
            <td class="column1 style19 null"></td>
            <td class="column2 style18 null"></td>
            <td class="column3 style23 null"><?php readMontant(($resultatNL*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($resultatNLN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($resultatNLN2*-1*-1))?></td>
          </tr>
          <tr class="row15">
            <td class="column0 style47 s">TOTAL DES CAPITAUX PROPRES ( a )</td>
            <td class="column1 style46 null"></td>
            <td class="column2 style45 null"></td>
            <td class="column3 style23 null"><?php readMontant(($totalCP*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($totalCPN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($totalCPN2*-1*-1))?></td>
          </tr>
          <tr class="row16">
            <td class="column0 style47 s">CAPITAUX PROPRES ASSIMILES ( b )</td>
            <td class="column1 style46 null"></td>
            <td class="column2 style45 null"></td>
            <td class="column3 style23 null"><?php readMontant(($capitauxPA*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($capitauxPAN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($capitauxPAN2*-1*-1))?></td>
          </tr>
          <tr class="row17">
            <td class="column0 style73 s">Subventions d'investissement</td>
            <td class="column1 style72 null"></td>
            <td class="column2 style71 null"></td>
            <td class="column3 style23 null"><?php readMontant(($SubventionsD*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($SubventionsDN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($SubventionsDN2*-1*-1))?></td>
          </tr>
          <tr class="row18">
            <td class="column0 style26 s">Provisions réglementées</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"><?php readMontant(($provisionsR*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($provisionsRN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($provisionsRN2*-1*-1))?></td>
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
            <td class="column3 style23 null"><?php readMontant(($dettesDF*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($dettesDFN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($dettesDFN2*-1*-1))?></td>
          </tr>
          <tr class="row21">
            <td class="column0 style59 s">Emprunts obligataires</td>
            <td class="column1 style58 null"></td>
            <td class="column2 style57 null"></td>
            <td class="column3 style23 null"><?php readMontant(($empruntsO*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($empruntsON1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($empruntsON2*-1*-1))?></td>
          </tr>
          <tr class="row22">
            <td class="column0 style26 s">Autres dettes de financement</td>
            <td class="column1 style25 null"></td>
            <td class="column2 style24 null"></td>
            <td class="column3 style23 null"><?php readMontant(($autresDF*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($autresDFN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($autresDFN2*-1*-1))?></td>
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
             <td class="column3 style23 null"><?php readMontant(($provisionsDPREC*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($provisionsDPRECN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($provisionsDPRECN2*-1*-1))?></td>
          </tr>
          <tr class="row25">
            <td class="column0 style29 s">Provisions pour risques</td>
            <td class="column1 style58 null"></td>
            <td class="column2 style57 null"></td>
            <td class="column3 style23 null"><?php readMontant(($provisionsPR*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($provisionsPRN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($provisionsPRN2*-1*-1))?></td>
          </tr>
          <tr class="row26">
            <td class="column0 style61 s">Provisions pour charges</td>
            <td class="column1 style19 null"></td>
            <td class="column2 style18 null"></td>
            <td class="column3 style23 null"><?php readMontant(($provisionsPC*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($provisionsPCN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($provisionsPCN2*-1*-1))?></td>
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
            <td class="column3 style23 null"><?php readMontant(($augmentationDCI*-1*-1))?></td>
            <td class="column4 style22 null"><?php readMontant(($augmentationDCIN1*-1*-1))?></td>
            <td class="column5 style15 null"></td>
            <td class="column6 style21 null"><?php readMontant(($augmentationDCIN2*-1*-1))?></td>
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