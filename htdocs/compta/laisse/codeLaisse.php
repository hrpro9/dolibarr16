<?php

// Load Dolibarr environment
require_once '../../main.inc.php';
require_once '../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
require_once 'functionDeclarationLaisse.php';



  // ----------------------> $....N1 = Exercice Précédent && $....N2 = Exercice N-2
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
  $diminutionDF=$diminutionDFN1=$diminutionDFN2=0; //Diminution des dettes de financement
  $ecartsDCP=$ecartsDCPN1=$ecartsDCPN2=0; //ECARTS DE CONVERSION - PASSIF ( e )
  $totalABCDE=$totalABCDEN1=$totalABCDEN2=0; //TOTAL  I  ( a + b + c + d + e )
  $fournisseursECR=$fournisseursECRN1=$fournisseursECRN2=0; // Fournisseurs et comptes rattachés
  $ClientsCAVA=$ClientsCAVAN1=$ClientsCAVAN2=0; // Clients créditeurs, avances et acomptes
  $personnel=$personnelN1=$personnelN2=0; //Personnel
  $organismesS=$organismesSN1=$organismesSN2=0; //Organismes sociaux
  $etat=$etatN1=$etatN2=0;
  $comptesD=$comptesDN1=$comptesDN2=0; //Comptes d'associés
  $autresCr=$autresCrN1=$autresCrN2=0; //Autres créanciers
  $comptesDRP=$comptesDRPN1=$comptesDRPN2=0; // Comptes de regularisation - passif
  $dettesDPC=$dettesDPCN1=$dettesDPCN2=0;//DETTES DU PASSIF CIRCULANT ( f )
  $autresPPREC=$autresPPRECN1=$autresPPRECN2=0; // AUTRES PROVISIONS POUR RISQUES ET CHARGES ( g )
  $ecartsDCP=$ecartsDCPN1=$ecartsDCPN2=0; // ECARTS DE CONVERSION - PASSIF ( h ) (Elem. Circul.)
  $totalFGH=$totalFGHN1=$totalFGHN2=0; // TOTAL  II  ( f + g + h )
  $creditsDE=$creditsDEN1=$creditsDEN2=0; // Crédits d'escompte
  $creditDT=$creditDTN1=$creditDTN2=0; // Crédit de trésorerie
  $banquesSC=$banquesSCN1=$banquesSCN2=0; //Banques ( soldes créditeurs )
  $tresorerie=$tresorerieN1=$tresorerieN2=0; // TRESORERIE PASSIF
  $totalIII=$totalIIIN1=$totalIIIN2=0; // TOTAL  III
  $total_I_II_III=$total_I_II_IIIN1=$total_I_II_IIIN2=0; // TOTAL   I+II+III
  $dateChoisis=0;
  $dateChoisis=(isset($_POST['chargement']))?$_POST['date_select']:0;
  if(!isset($_POST['chargement']))
  {
    $dateChoisis=GETPOST('valeurdatechoise');
  }
//   $dateChoisis=2022;
  
  $sql="SELECT * FROM llx_accounting_bookkeeping";
  $rest=$db->query($sql);
  foreach( $rest as $row )
  { 
    $datetime = new DateTime($row['doc_date']);
    $dateCreation = $datetime->format('Y');
    $numero_compte = $row['numero_compte'];
    $montant = $row['montant']; 
    switch ($numero_compte) {
    //   case "1119":list($aCapita, $aCapitaN1, $aCapitaN2)=calculateMontant($dateCreation, $dateChoisis, $aCapita,$aCapitaN1, $aCapitaN2,'1119');break;
      case "611":list($aCapita, $aCapitaN1, $aCapitaN2)=calculateMontant($dateCreation, $dateChoisis, $aCapita,$aCapitaN1, $aCapitaN2,'611');break;
      case "112":list($PrimeDFD, $PrimeDFDN1, $PrimeDFDN2)=calculateMontant($dateCreation, $dateChoisis, $PrimeDFD,$PrimeDFDN1, $PrimeDFDN2,'112');break;
      case "113":list($EcartsR, $EcartsRN1, $EcartsRN2)=calculateMontant($dateCreation, $dateChoisis, $EcartsR,$EcartsRN1, $EcartsRN2,'113');break;
      case "114":list($reserveL, $reserveLN1, $reserveLN2)=calculateMontant($dateCreation,$dateChoisis, $reserveL,$reserveLN1, $reserveLN2,'114');break;
      case "115":list($autresR, $autresRN1, $autresRN2)=calculateMontant($dateCreation,$dateChoisis, $autresR,$autresRN1, $autresRN2,'115');break;
      case "116":list($ReportN, $ReportNN1, $ReportNN2)=calculateMontant($dateCreation,$dateChoisis, $ReportN,$ReportNN1, $ReportNN2,'116');break;
      case "118":list($resultatNID, $resultatNIDN1, $resultatNIDN2)=calculateMontant($dateCreation,$dateChoisis, $resultatNID,$resultatNIDN1, $resultatNIDN2,'118');break;
      case "6":list($resultatNL6, $resultatNL6N1, $resultatNL6N2)=calculateMontant($dateCreation,$dateChoisis, $resultatNL6,$resultatNL6N1, $resultatNL6N2,'6');break;
      case "7":list($resultatNL7, $resultatNL7N1, $resultatNL7N2)=calculateMontant($dateCreation,$dateChoisis, $resultatNL7,$resultatNL7N1, $resultatNL7N2,'7');break;
      case "131":list($SubventionsD, $SubventionsDN1, $SubventionsDN2)=calculateMontant($dateCreation,$dateChoisis, $SubventionsD,$SubventionsDN1, $SubventionsDN2,'131');break;
      case "135":list($provisionsR, $provisionsRN1, $provisionsRN2)=calculateMontant($dateCreation,$dateChoisis, $provisionsR,$provisionsRN1, $provisionsRN2,'135');break;
      case "141":list($empruntsO, $empruntsON1, $empruntsON2)=calculateMontant($dateCreation,$dateChoisis, $empruntsO,$empruntsON1, $empruntsON2,'141');break;
      case "148":list($autresDF, $autresDFN1, $autresDFN2)=calculateMontant($dateCreation,$dateChoisis, $autresDF,$autresDFN1, $autresDFN2,'148');break;
      case "151":list($provisionsPR, $provisionsPRN1, $provisionsPRN2)=calculateMontant($dateCreation,$dateChoisis, $provisionsPR,$provisionsPRN1, $provisionsPRN2,'151');break;
      case "155":list($autresP, $autresPN1, $autresPN2)=calculateMontant($dateCreation,$dateChoisis, $autresP,$autresPN1, $autresPN2,'155');break;
      case "171" :list($augmentationDCI, $augmentationDCIN1, $augmentationDCIN2)=calculateMontant($dateCreation,$dateChoisis, $augmentationDCI,$augmentationDCIN1, $augmentationDCIN2,'171');break; 
      case "172" :list($diminutionDF, $diminutionDFN1, $diminutionDFN2)=calculateMontant($dateCreation,$dateChoisis, $diminutionDF,$diminutionDFN1, $diminutionDFN2,'172');break; 
      case "441" :list($fournisseursECR, $fournisseursECRN1, $fournisseursECRN2)=calculateMontant($dateCreation,$dateChoisis, $fournisseursECR,$fournisseursECRN1, $fournisseursECRN2,'441');break; 
      case "442" :list($ClientsCAVA, $ClientsCAVAN1, $ClientsCAVAN2)=calculateMontant($dateCreation,$dateChoisis, $ClientsCAVA,$ClientsCAVAN1, $ClientsCAVAN2,'442');break;
      case "443" :list($personnel, $personnelN1,$personnelN2)=calculateMontant($dateCreation,$dateChoisis, $personnel,$personnelN1, $personnelN2,'443');break;
      case "444" :list($organismesS, $organismesSN1, $organismesSN2)=calculateMontant($dateCreation,$dateChoisis, $organismesS,$organismesSN1, $organismesSN2,'444');break;
      case "445" :list($etat, $etatN1, $etatN2)=calculateMontant($dateCreation,$dateChoisis, $etat,$etatN1, $etatN2,'445');break;
      case "446" :list($comptesD, $comptesDN1, $comptesDN2)=calculateMontant($dateCreation,$dateChoisis, $comptesD,$comptesDN1, $comptesDN2,'446');break;
      case "448" :list($autresCr, $autresCrN1, $autresCrN2)=calculateMontant($dateCreation,$dateChoisis, $autresCr,$autresCrN1, $autresCrN2,'448');break;
      case "449" :list($comptesDRP, $comptesDRPN1, $comptesDRPN2)=calculateMontant($dateCreation,$dateChoisis, $comptesDRP,$comptesDRPN1, $comptesDRPN2,'449');break;
      case "45" :list($autresPPREC, $autresPPRECN1, $autresPPRECN2)=calculateMontant($dateCreation,$dateChoisis, $autresPPREC,$autresPPRECN1, $autresPPRECN2,'45');break;
      case "47" :list($ecartsDCP, $ecartsDCPN1, $ecartsDCPN2)=calculateMontant($dateCreation,$dateChoisis,$ecartsDCP,$ecartsDCPN1,$ecartsDCPN2,'47');break;
      case "552" :list($creditsDE, $creditsDEN1, $creditsDEN2)=calculateMontant($dateCreation,$dateChoisis,$creditsDE,$creditsDEN1,$creditsDEN2,'552');break;
      case "553" :list($creditDT, $creditDTN1, $creditDTN2)=calculateMontant($dateCreation,$dateChoisis,$creditDT,$creditDTN1,$creditDTN2,'553');break;
      case "554" :list($banquesSC, $banquesSCN1, $banquesSCN2)=calculateMontant($dateCreation,$dateChoisis,$banquesSC,$banquesSCN1,$banquesSCN2,'554');break;
    }
   // ----------------------> Exercice
   $capitauxPropres=$CapitalSocialPersonnel+$aCapita+$cAppele+$DVerse+$PrimeDFD+$EcartsR+$reserveL+$autresR+$resultatNID+$resultatNL;
   $CapitalSocialPersonnel=(-$aCapita+$cAppele);
   $resultatNL=(-$resultatNL7-$resultatNL6);
   $totalCP= $capitauxPropres;
   $capitauxPA=$SubventionsD+ $provisionsR;
   $dettesDF=$empruntsO+$autresDF;
   $provisionsDPREC=$provisionsPR+$provisionsPC;
   $ecartsDCP=$augmentationDCI+$diminutionDF;
   $totalABCDE=$totalCP+$capitauxPA+$dettesDF+$provisionsDPREC+$ecartsDCP;
   $dettesDPC=$fournisseursECR+$ClientsCAVA+$organismesS+$organismesS+$etat+$comptesD+$autresCr+$comptesDRP;
   $totalFGH=$dettesDPC+$autresPPREC+$ecartsDCP;
   $tresorerie=$creditsDE+$creditDT+$banquesSC;
   $totalIII= $tresorerie;
   $total_I_II_III= $totalABCDE+$totalFGH+$totalIII;
   // ----------------------> Exercice Précédent
   $capitauxPropresN1=$CapitalSocialPersonnelN1+$aCapitaN1+$cAppeleN1+$DVerseN1+$PrimeDFDN1+$EcartsRN1+$reserveLN1+$autresRN1+$resultatNIDN1+$resultatNLN1;
   $CapitalSocialPersonnelN1=(-$aCapitaN1+$cAppeleN1);
   $resultatNLN1=(-$resultatNL7N1-$resultatNL6N1);
   $totalCPN1=$capitauxPropresN1;
   $capitauxPAN1=$SubventionsDN1+ $provisionsRN1;
   $dettesDFN1=$empruntsON1+$autresDFN1;
   $provisionsDPRECN1=$provisionsPRN1+$provisionsPCN1;
   $ecartsDCPN1=$augmentationDCIN1+$diminutionDFN1;
   $totalABCDEN1=$totalCPN1+$capitauxPAN1+$dettesDFN1+$provisionsDPRECN1+$ecartsDCPN1;
   $dettesDPCN1=$fournisseursECRN1+$ClientsCAVAN1+$organismesSN1+$organismesSN1+$etatN1+$comptesDN1+$autresCrN1+$comptesDRPN1;
   $totalFGHN1=$dettesDPCN1+$autresPPRECN1+=$ecartsDCPN1;
   $tresorerieN1=$creditsDEN1+$creditDTN1+$banquesSCN1;
   $totalIIIN1=$tresorerieN1;
   $total_I_II_IIIN1=$totalABCDEN1+$totalFGHN1+$totalIIIN1;
   // ----------------------> Exercice N-2
   $capitauxPropresN2=$CapitalSocialPersonnelN2+$aCapitaN2+$cAppeleN2+$DVerseN2+$PrimeDFDN2+$EcartsRN2+$reserveLN2+$autresRN2+$resultatNIDN2+$resultatNLN2;
   $CapitalSocialPersonnelN2=(-$aCapitaN2+$cAppeleN2);
   $resultatNLN2=(-$resultatNL7N2-$resultatNL6N2);
   $totalCPN2= $capitauxPropresN2;
   $capitauxPAN2=$SubventionsDN2+ $provisionsRN2;
   $dettesDFN2=$empruntsON2+$autresDFN2;
   $provisionsDPRECN2=$provisionsPRN2+$provisionsPCN2;
   $ecartsDCPN2=$augmentationDCIN2+$diminutionDFN2;
   $totalABCDEN2=$totalCPN2+$capitauxPAN2+$dettesDFN2+$provisionsDPRECN2+$ecartsDCPN2;
   $dettesDPCN2=$fournisseursECRN2+$ClientsCAVAN2+$organismesSN2+$organismesSN2+$etatN2+$comptesDN2+$autresCrN2+$comptesDRPN2;
   $totalFGHN2=$dettesDPCN2+$autresPPRECN2+=$ecartsDCPN2;
   $tresorerieN2=$creditsDEN2+$creditDTN2+$banquesSCN2;
   $totalIIIN2=$tresorerieN2;
   $total_I_II_IIIN2=$totalABCDEN2+$totalFGHN2+$totalIIIN2;

  
  }





?>