<?php


// Load Dolibarr environment
require_once '../../main.inc.php';
require_once '../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
require_once('functionDeclarationLaisse.php');




// 'E' : Exercice  / 'EP' : Exercice Precedent  / 'E2' :  Exercice n-2 

$dateChoisis=0;
$achatRevMarch_E=$achatRevMarch_EP=$achatRevMarch_E2=0; // Achats revendus de marchandises
$varStock_E=$varStock_EP=$varStock_E2=0; // Variation des stocks de marchandises
$total1_E=$total1_EP=$total1_E2=0; // Total 1
$achatConsMat_E=$achatConsMat_EP=$achatConsMat_E2=0; // Achats consommés de matières et fournitures
$achatMatPre1_E=$achatMatPre1_EP=$achatMatPre1_E2=$achatMatPre2_E=$achatMatPre2_EP=$achatMatPre2_E2=$achatMatPre3_E=$achatMatPre3_EP=$achatMatPre3_E2=$achatMatPre4_E=$achatMatPre4_EP=$achatMatPre4_E2=0; // Achats de matières premières
$varStockMat_E=$varStockMat_EP=$varStockMat_E2=0;// Variation des stocks de matières premières	
$achatMatFourn1_E=$achatMatFourn1_EP=$achatMatFourn1_E2=$achatMatFourn2_E=$achatMatFourn2_EP=$achatMatFourn2_E2=0;
$achatMatFourn3_E=$achatMatFourn3_EP=$achatMatFourn3_E2=$achatMatFourn4_E=$achatMatFourn4_EP=$achatMatFourn4_E2=0;
$achatMatFourn5_E=$achatMatFourn5_EP=$achatMatFourn5_E2=$achatMatFourn6_E=$achatMatFourn6_EP=$achatMatFourn6_E2=0; // Achats de matières et fournitures consommables et d'emballages
$varStockMatFourn1_E=$varStockMatFourn1_EP=$varStockMatFourn1_E2=$varStockMatFourn2_E=$varStockMatFourn2_EP=$varStockMatFourn2_E2=$varStockMatFourn3_E=$varStockMatFourn3_EP=$varStockMatFourn3_E2=0; // Variation des stocks de matières, fournitures et emballages
$achatNonStockMat1_E=$achatNonStockMat1_EP=$achatNonStockMat1_E2=$achatNonStockMat2_E=$achatNonStockMat2_EP=$achatNonStockMat2_E2=$achatNonStockMat3_E=$achatNonStockMat3_EP=$achatNonStockMat3_E2=0; // Achats non stockés de matières et de fournitures
$achatTravEtud1_E=$achatTravEtud1_EP=$achatTravEtud1_E2=$achatTravEtud2_E=$achatTravEtud2_EP=$achatTravEtud2_E2=$achatTravEtud3_E=$achatTravEtud3_EP=$achatTravEtud3_E2=0; // Achats de travaux, études et prestation de services
$autreCharg1_E=$autreCharg1_EP=$autreCharg1_E2=$autreCharg2_E=$autreCharg2_EP=$autreCharg2_E2=0; // Autres charges externes
$locatCharg1_E=$locatCharg1_EP=$locatCharg1_E2=$locatCharg2_E=$locatCharg2_EP=$locatCharg2_E2=$locatCharg3_E=$locatCharg3_EP=$locatCharg3_E2=0; // Locations et charges locatives
$redCred1_E=$redCred1_EP=$redCred1_E2=$redCred2_E=$redCred2_EP=$redCred2_E2=$redCred3_E=$redCred3_EP=$redCred3_E2=0; // Redevances de crédit-bail
$entreRepa1_E=$entreRepa1_EP=$entreRepa1_E2=$entreRepa2_E=$entreRepa2_EP=$entreRepa2_E2=$entreRepa3_E=$entreRepa3_EP=$entreRepa3_E2=0; // Entretient et réparations
$primeAssur1_E=$primeAssur1_EP=$primeAssur1_E2=$primeAssur2_E=$primeAssur2_EP=$primeAssur2_E2=$primeAssur3_E=$primeAssur3_EP=$primeAssur3_E2=0; //  Primes d'assurances
$remunePers1_E=$remunePers1_EP=$remunePers1_E2=$remunePers2_E=$remunePers2_EP=$remunePers2_E2=0; // Rémunérations du personnel extérieur à l'entreprise
$remuneInter1_E=$remuneInter1_EP=$remuneInter1_E2=$remuneInter2_E=$remuneInter2_EP=$remuneInter2_E2=$remuneInter3_E=$remuneInter3_EP=$remuneInter3_E2=0; // Rémunérations d'intermédiaires et honoraires
$redevBrevet1_E=$redevBrevet1_EP=$redevBrevet1_E2=$redevBrevet2_E=$redevBrevet2_EP=$redevBrevet2_E2=$redevBrevet3_E=$redevBrevet3_EP=$redevBrevet3_E2=0; // Redevances pour brevets, marque, droits ... 
$trans1_E=$trans1_EP=$trans1_E2=$trans2_E=$trans2_EP=$trans2_E2=$trans3_E=$trans3_EP=$trans3_E2=0; // Transports
$deplacMiss1_E=$deplacMiss1_EP=$deplacMiss1_E2=$deplacMiss2_E=$deplacMiss2_EP=$deplacMiss2_E2=0; // Déplacements, missions et réceptions	
$chagePers_E=$chagePers_EP=$chagePers_E2=0; // Charges de personnel
$remunePerso_E=$remunePerso_EP=$remunePerso_E2=0; // Rémunération du personnel
$chageSocial_E=$chageSocial_EP=$chageSocial_E2=0; // Charges sociales
$autreChargeExp_E=$autreChargeExp_EP=$autreChargeExp_E2=0; // Autres charges d'exploitation
$jetonPres_E=$jetonPres_EP=$jetonPres_E2=0; // Jetons de présence
$perteCre_E=$perteCre_EP=$perteCre_E2=0; // Pertes sur créances irrécouvrables
$autreChargFin_E=$autreChargFin_EP=$autreChargFin_E2=0; // Autres charges financières
$chargeNet_E=$chargeNet_EP=$chargeNet_E2=0; // Charges nettes sur cessions de titres et valeurs de placement
$autreChargN_E=$autreChargN_EP=$autreChargN_E2=0;// Autres charges non courantes
$penalMarch_E=$penalMarch_EP=$penalMarch_E2=0; // Pénalités sur marchés et débits
$rappelImpo_E=$rappelImpo_EP=$rappelImpo_E2=0; // Rappels d'impôts (autres qu'impôts sur les résultats)
$penalAmand_E=$penalAmand_EP=$penalAmand_E2=0; // Pénalités et amendes fiscales et pénales
$creanDeven_E=$creanDeven_EP=$creanDeven_E2=0; // Créances devenues irrécouvrables
$venteMarch_E=$venteMarch_EP=$venteMarch_E2=0; // Ventes de marchandises
$venteMarchMar_E=$venteMarchMar_EP=$venteMarchMar_E2=0; // Ventes de marchandises au Maroc
$venteMarchEtrg_E=$venteMarchEtrg_EP=$venteMarchEtrg_E2=0; // Ventes de marchandises à l'étranger
$venteBienServ_E=$venteBienServ_EP=$venteBienServ_E2=0; // Ventes des biens et services produits

$venteBienMar1_E=$venteBienMar1_EP=$venteBienMar1_E2=$venteBienMar2_E=$venteBienMar2_EP=$venteBienMar2_E2=0; // Ventes de biens au Maroc
$venteBienEtrg1_E=$venteBienEtrg1_EP=$venteBienEtrg1_E2=$venteBienEtrg2_E=$venteBienEtrg2_EP=$venteBienEtrg2_E2=0; // Ventes de biens à l'étranger
$venteServMar1_E=$venteServMar1_EP=$venteServMar1_E2=$venteServMar2_E=$venteServMar2_EP=$venteServMar2_E2=0; // Ventes des services au Maroc
$venteServEtrg1_E=$venteServEtrg1_EP=$venteServEtrg1_E2=$venteServEtrg2_E=$venteServEtrg2_EP=$venteServEtrg2_E2=0; // Ventes des services à l'étranger
$redevBrevet_E=$redevBrevet_EP=$redevBrevet_E2=0; // Redevances pour brevets, marques, droits ...
$varStockProd_E=$varStockProd_EP=$varStockProd_E2=0;// Variation des stocks de produits
$varStockProdC_E=$varStockProdC_EP=$varStockProdC_E2=0;// Variation des stocks de produits de produits en cours
$varStockBien_E=$varStockBien_EP=$varStockBien_E2=0;// Variation des stocks de biens produits
$varStockServ_E=$varStockServ_EP=$varStockServ_E2=0;// Variation des stocks de services en cours
$autreProd_E=$autreProd_EP=$autreProd_E2=0;// Autres produits d'exploitation
$jetoPre_E=$jetoPre_EP=$jetoPre_E2=0;// Jetons de présence reçus
$repriseExpl_E=$repriseExpl_EP=$repriseExpl_E2=0;// Reprises d'exploitation, transferts de charges
$repriseExpl_E=$repriseExpl_EP=$repriseExpl_E2=0;// Reprises
$transCharg_E=$transCharg_EP=$transCharg_E2=0;// Transferts de charges
$interetAutre_E=$interetAutre_EP=$interetAutre_E2=0;// Intérêts et autres produits financiers
$interetProd_E=$interetProd_EP=$interetProd_E2=0;// Intérêt et produits assimilés
$revenuCrean_E=$revenuCrean_EP=$revenuCrean_E2=0;// Revenus des créances rattachées à des participations
$produitNet_E=$produitNet_EP=$produitNet_E2=0;// Produits nets sur cessions de titres et valeurs de placement





$dateChoisis=0;
  $dateChoisis=(isset($_POST['chargement']))?$_POST['date_select']:0;

   if(!isset($_POST['chargement']))
  {
    $dateChoisis=GETPOST('valeurdatechoise');
  }


   $sql ="SELECT * FROM llx_accounting_bookkeeping";
   $result =$db->query($sql);

   foreach($result as $row){

    

    $datetime = new DateTime($row['doc_date']);
    $dateCreation = $datetime->format('Y');
    

    
      $numero_compte=$row['numero_compte'];
      $montant=$row['montant'];

      switch($numero_compte){
        case '711' : list($achatRevMarch_E,$achatRevMarch_EP,$achatRevMarch_E2) = calculateMontant($dateCreation,$dateChoisis,$achatRevMarch_E,$achatRevMarch_EP,$achatRevMarch_E2,'711'); break;
        case '6114' : list($varStock_E,$varStock_EP,$varStock_E) = calculateMontant($dateCreation,$dateChoisis,$varStock_E,$varStock_EP,$varStock_E2,'6114'); break;
        case '611' : list($total1_E,$total1_EP,$total1_E2) = calculateMontant($dateCreation,$dateChoisis,$total1_E,$total1_EP,$total1_E2,'611'); break;
        case '612' : list($achatConsMat_E,$achatConsMat_EP,$achatConsMat_E2) = calculateMontant($dateCreation,$dateChoisis,$achatConsMat_E,$achatConsMat_EP,$achatConsMat_E2,'612'); break;
        case '6121' : list($achatMatPre1_E,$achatMatPre1_EP,$achatMatPre1_E2) = calculateMontant($dateCreation,$dateChoisis,$achatMatPre1_E,$achatMatPre1_EP,$achatMatPre1_E2,'6121'); break;
        case '61281' : list($achatMatPre2_E,$achatMatPre2_EP,$achatMatPre2_E2) = calculateMontant($dateCreation,$dateChoisis,$achatMatPre2_E,$achatMatPre2_EP,$achatMatPre2_E2,'61281'); break;
        case '61291' : list($achatMatPre3_E,$achatMatPre3_EP,$achatMatPre3_E2) = calculateMontant($dateCreation,$dateChoisis,$achatMatPre3_E,$achatMatPre3_EP,$achatMatPre3_E2,'61291'); break;
        case '61298' : list($achatMatPre4_E,$achatMatPre4_EP,$achatMatPre4_E2) = calculateMontant($dateCreation,$dateChoisis,$achatMatPre4_E,$achatMatPre4_EP,$achatMatPre4_E2,'61298'); break;
		case '61241' : list($varStockMat_E,$varStockMat_EP,$varStockMat_E2) = calculateMontant($dateCreation,$dateChoisis,$varStockMat_E,$varStockMat_EP,$varStockMat_E2,'61241'); break;
		case '6122' : list($achatMatFourn1_E,$achatMatFourn1_EP,$achatMatFourn1_E2) = calculateMontant($dateCreation,$dateChoisis,$achatMatFourn1_E,$achatMatFourn1_EP,$achatMatFourn1_E2,'6122'); break;
		case '6123' : list($achatMatFourn2_E,$achatMatFourn2_EP,$achatMatFourn2_E2) = calculateMontant($dateCreation,$dateChoisis,$achatMatFourn2_E,$achatMatFourn2_EP,$achatMatFourn2_E2,'6123'); break;
		case '61282' : list($achatMatFourn3_E,$achatMatFourn3_EP,$achatMatFourn3_E2) = calculateMontant($dateCreation,$dateChoisis,$achatMatFourn3_E,$achatMatFourn3_EP,$achatMatFourn3_E2,'61282'); break;
		case '61292' : list($achatMatFourn4_E,$achatMatFourn4_EP,$achatMatFourn4_E2) = calculateMontant($dateCreation,$dateChoisis,$achatMatFourn4_E,$achatMatFourn4_EP,$achatMatFourn4_E2,'61292'); break;
		case '61283' : list($achatMatFourn5_E,$achatMatFourn5_EP,$achatMatFourn5_E2) = calculateMontant($dateCreation,$dateChoisis,$achatMatFourn5_E,$achatMatFourn5_EP,$achatMatFourn5_E2,'61283'); break;
		case '61293' : list($achatMatFourn6_E,$achatMatFourn6_EP,$achatMatFourn6_E2) = calculateMontant($dateCreation,$dateChoisis,$achatMatFourn6_E,$achatMatFourn6_EP,$achatMatFourn6_E2,'61293'); break;
		case '61242' : list($varStockMatFourn1_E,$varStockMatFourn1_EP,$varStockMatFourn1_E2) = calculateMontant($dateCreation,$dateChoisis,$varStockMatFourn1_E,$varStockMatFourn1_EP,$varStockMatFourn1_E2,'61242'); break;
		case '61243' : list($varStockMatFourn2_E,$varStockMatFourn2_EP,$varStockMatFourn2_E2) = calculateMontant($dateCreation,$dateChoisis,$varStockMatFourn2_E,$varStockMatFourn2_EP,$varStockMatFourn2_E2,'61243'); break;
		case '61244' : list($varStockMatFourn3_E,$varStockMatFourn3_EP,$varStockMatFourn3_E2) = calculateMontant($dateCreation,$dateChoisis,$varStockMatFourn3_E,$varStockMatFourn3_EP,$varStockMatFourn3_E2,'61244'); break;
		case '6125' : list($achatNonStockMat1_E,$achatNonStockMat1_EP,$achatNonStockMat1_E2) = calculateMontant($dateCreation,$dateChoisis,$achatNonStockMat1_E,$achatNonStockMat1_EP,$achatNonStockMat1_E2,'6125'); break;
		case '61285' : list($achatNonStockMat2_E,$achatNonStockMat2_EP,$achatNonStockMat2_E2) = calculateMontant($dateCreation,$dateChoisis,$achatNonStockMat2_E,$achatNonStockMat2_EP,$achatNonStockMat2_E2,'61285'); break;
		case '61295' : list($achatNonStockMat3_E,$achatNonStockMat3_EP,$achatNonStockMat3_E2) = calculateMontant($dateCreation,$dateChoisis,$achatNonStockMat3_E,$achatNonStockMat3_EP,$achatNonStockMat3_E2,'61295'); break;
		case '6126'  : list($achatTravEtud1_E,$achatTravEtud1_EP,$achatTravEtud1_E2) = calculateMontant($dateCreation,$dateChoisis,$achatTravEtud1_E,$achatTravEtud1_EP,$achatTravEtud1_E2,'6126'); break;
		case '61286'  : list($achatTravEtud2_E,$achatTravEtud2_EP,$achatTravEtud2_E2) = calculateMontant($dateCreation,$dateChoisis,$achatTravEtud2_E,$achatTravEtud2_EP,$achatTravEtud2_E2,'61286'); break;
		case '61296'  : list($achatTravEtud3_E,$achatTravEtud3_EP,$achatTravEtud3_E2) = calculateMontant($dateCreation,$dateChoisis,$achatTravEtud3_E,$achatTravEtud3_EP,$achatTravEtud3_E2,'61296'); break;
		case '613' : list($autreCharg1_E,$autreCharg1_EP,$autreCharg1_E2) = calculateMontant($dateCreation,$dateChoisis,$autreCharg1_E,$autreCharg1_EP,$autreCharg1_E2,'613'); break;
		case '614' : list($autreCharg2_E,$autreCharg2_EP,$autreCharg2_E2) = calculateMontant($dateCreation,$dateChoisis,$autreCharg2_E,$autreCharg2_EP,$autreCharg2_E2,'614'); break;
		case '6131' : list($locatCharg1_E,$locatCharg1_EP,$locatCharg1_E2) = calculateMontant($dateCreation,$dateChoisis,$locatCharg1_E,$locatCharg1_EP,$locatCharg1_E2,'6131'); break;
		case '61481' : list($locatCharg2_E,$locatCharg2_EP,$locatCharg2_E2) = calculateMontant($dateCreation,$dateChoisis,$locatCharg2_E,$locatCharg2_EP,$locatCharg2_E2,'61481'); break;
		case '61491' : list($locatCharg3_E,$locatCharg3_EP,$locatCharg3_E2) = calculateMontant($dateCreation,$dateChoisis,$locatCharg3_E,$locatCharg3_EP,$locatCharg3_E2,'61491'); break;
		case '6132' : list($redCred1_E,$redCred1_EP,$redCred1_E2) = calculateMontant($dateCreation,$dateChoisis,$redCred1_E,$redCred1_EP,$redCred1_E2,'6132'); break;
		case '61482' : list($redCred2_E,$redCred2_EP,$redCred2_E2) = calculateMontant($dateCreation,$dateChoisis,$redCred2_E,$redCred2_EP,$redCred2_E2,'61482'); break;
		case '64192' : list($redCred3_E,$redCred3_EP,$redCred3_E2) = calculateMontant($dateCreation,$dateChoisis,$redCred3_E,$redCred3_EP,$redCred3_E2,'64192'); break;
		case '6133' : list($entreRepa1_E,$entreRepa1_EP,$entreRepa1_E2) = calculateMontant($dateCreation,$dateChoisis,$entreRepa1_E,$entreRepa1_EP,$entreRepa1_E2,'6133'); break;
		case '61483' : list($entreRepa2_E,$entreRepa2_EP,$entreRepa2_E2) = calculateMontant($dateCreation,$dateChoisis,$entreRepa2_E,$entreRepa2_EP,$entreRepa2_E2,'61483'); break;
		case '61493' : list($entreRepa3_E,$entreRepa3_EP,$entreRepa3_E2) = calculateMontant($dateCreation,$dateChoisis,$entreRepa3_E,$entreRepa3_EP,$entreRepa3_E2,'61493'); break;
		case '6134' : list($primeAssur1_E,$primeAssur1_EP,$primeAssur1_E2) = calculateMontant($dateCreation,$dateChoisis,$primeAssur1_E,$primeAssur1_EP,$primeAssur1_E2,'6134'); break;
		case '61484' : list($primeAssur2_E,$primeAssur2_EP,$primeAssur2_E2) = calculateMontant($dateCreation,$dateChoisis,$primeAssur2_E,$primeAssur2_EP,$primeAssur2_E2,'61484'); break;
		case '61494' : list($primeAssur3_E,$primeAssur3_EP,$primeAssur3_E2) = calculateMontant($dateCreation,$dateChoisis,$primeAssur3_E,$primeAssur3_EP,$primeAssur3_E2,'61494'); break;
		case '6135' : list($remunePers1_E,$remunePers1_EP,$remunePers1_E2) = calculateMontant($dateCreation,$dateChoisis,$remunePers1_E,$remunePers1_EP,$remunePers1_E2,'6135'); break;
		case '61485' : list($remunePers2_E,$remunePers2_EP,$remunePers2_E2) = calculateMontant($dateCreation,$dateChoisis,$remunePers2_E,$remunePers2_EP,$remunePers2_E2,'61485'); break;
		case '6136' : list($remuneInter1_E,$remuneInter1_EP,$remuneInter1_E2) = calculateMontant($dateCreation,$dateChoisis,$remuneInter1_E,$remuneInter1_EP,$remuneInter1_E2,'6136'); break;
		case '61486' : list($remuneInter2_E,$remuneInter2_EP,$remuneInter2_E2) = calculateMontant($dateCreation,$dateChoisis,$remuneInter2_E,$remuneInter2_EP,$remuneInter2_E2,'61486'); break;
		case '61496' : list($remuneInter3_E,$remuneInter3_EP,$remuneInter3_E2) = calculateMontant($dateCreation,$dateChoisis,$remuneInter3_E,$remuneInter3_EP,$remuneInter3_E2,'61496'); break;
		case '6137' : list($redevBrevet1_E,$redevBrevet1_EP,$redevBrevet1_E2) = calculateMontant($dateCreation,$dateChoisis,$redevBrevet1_E,$redevBrevet1_EP,$redevBrevet1_E2,'6137'); break;
		case '61487' : list($redevBrevet2_E,$redevBrevet2_EP,$redevBrevet2_E2) = calculateMontant($dateCreation,$dateChoisis,$redevBrevet2_E,$redevBrevet2_EP,$redevBrevet2_E2,'61487'); break;
		case '61497' : list($redevBrevet3_E,$redevBrevet3_EP,$redevBrevet3_E2) = calculateMontant($dateCreation,$dateChoisis,$redevBrevet3_E,$redevBrevet3_EP,$redevBrevet3_E2,'61497'); break;
		case '6142' : list($trans1_E,$trans1_EP,$trans1_E2) = calculateMontant($dateCreation,$dateChoisis,$trans1_E,$trans1_EP,$trans1_E2,'6142'); break;
		case '61488' : list($trans2_E,$trans2_EP,$trans2_E2) = calculateMontant($dateCreation,$dateChoisis,$trans2_E,$trans2_EP,$trans2_E2,'61488'); break;
		case '61498' : list($trans3_E,$trans3_EP,$trans3_E2) = calculateMontant($dateCreation,$dateChoisis,$trans3_E,$trans3_EP,$trans3_E2,'61498'); break;
		case '6143' : list($deplacMiss1_E,$deplacMiss1_EP,$deplacMiss1_E2) = calculateMontant($dateCreation,$dateChoisis,$deplacMiss1_E,$deplacMiss1_EP,$deplacMiss1_E2,'6143'); break;
		case '61489' : list($deplacMiss2_E,$deplacMiss2_EP,$deplacMiss2_E2) = calculateMontant($dateCreation,$dateChoisis,$deplacMiss2_E,$deplacMiss2_EP,$deplacMiss2_E2,'61489'); break;
		case '617' : list($chagePers_E,$chagePers_EP,$chagePers_E2) = calculateMontant($dateCreation,$dateChoisis,$chagePers_E,$chagePers_EP,$chagePers_E2,'617'); break;
		case '6171' : list($remunePerso_E,$remunePerso_EP,$remunePerso_E2) = calculateMontant($dateCreation,$dateChoisis,$remunePerso_E,$remunePerso_EP,$remunePerso_E2,'6171'); break;
		case '6174' : list($chageSocial_E,$chageSocial_EP,$chageSocial_E2) = calculateMontant($dateCreation,$dateChoisis,$chageSocial_E,$chageSocial_EP,$chageSocial_E2,'6174'); break;
		case '618' : list($autreChargeExp_E,$autreChargeExp_EP,$autreChargeExp_E2) = calculateMontant($dateCreation,$dateChoisis,$autreChargeExp_E,$autreChargeExp_EP,$autreChargeExp_E2,'618'); break;
		case '6181' : list($jetonPres_E,$jetonPres_EP,$jetonPres_E2) = calculateMontant($dateCreation,$dateChoisis,$jetonPres_E,$jetonPres_EP,$jetonPres_E2,'6181'); break;
		case '6182' : list($perteCre_E,$perteCre_EP,$perteCre_E2) = calculateMontant($dateCreation,$dateChoisis,$perteCre_E,$perteCre_EP,$perteCre_E2,'6182'); break;
		case '638' : list($autreChargFin_E,$autreChargFin_EP,$autreChargFin_E2) = calculateMontant($dateCreation,$dateChoisis,$autreChargFin_E,$autreChargFin_EP,$autreChargFin_E2,'638'); break;
		case '6385' : list($chargeNet_E,$chargeNet_EP,$chargeNet_E2) = calculateMontant($dateCreation,$dateChoisis,$chargeNet_E,$chargeNet_EP,$chargeNet_E2,'6385'); break;
		case '658' : list($autreChargN_E,$autreChargN_EP,$autreChargN_E2) = calculateMontant($dateCreation,$dateChoisis,$autreChargN_E,$autreChargN_EP,$autreChargN_E2,'658'); break;
		case '6581' : list($penalMarch_E,$penalMarch_EP,$penalMarch_E2) = calculateMontant($dateCreation,$dateChoisis,$penalMarch_E,$penalMarch_EP,$penalMarch_E2,'6581'); break;
		case '6582' : list($rappelImpo_E,$rappelImpo_EP,$rappelImpo_E2) = calculateMontant($dateCreation,$dateChoisis,$rappelImpo_E,$rappelImpo_EP,$rappelImpo_E2,'6582'); break;
		case '6583' : list($penalAmand_E,$penalAmand_EP,$penalAmand_E2) = calculateMontant($dateCreation,$dateChoisis,$penalAmand_E,$penalAmand_EP,$penalAmand_E2,'6583'); break;
		case '6585' : list($creanDeven_E,$creanDeven_EP,$creanDeven_E2) = calculateMontant($dateCreation,$dateChoisis,$creanDeven_E,$creanDeven_EP,$creanDeven_E2,'6585'); break;
		case '711' : list($venteMarch_E,$venteMarch_EP,$venteMarch_E2) = calculateMontant($dateCreation,$dateChoisis,$venteMarch_E,$venteMarch_EP,$venteMarch_E2,'711'); break;
		case '7111' : list($venteMarchMar_E,$venteMarchMar_EP,$venteMarchMar_E2) = calculateMontant($dateCreation,$dateChoisis,$venteMarchMar_E,$venteMarchMar_EP,$venteMarchMar_E2,'7111'); break;
		case '7113' : list($venteMarchEtrg_E,$venteMarchEtrg_EP,$venteMarchEtrg_E2) = calculateMontant($dateCreation,$dateChoisis,$venteMarchEtrg_E,$venteMarchEtrg_EP,$venteMarchEtrg_E2,'7113'); break;
		case '712' : list($venteBienServ_E,$venteBienServ_EP,$venteBienServ_E2) = calculateMontant($dateCreation,$dateChoisis,$venteBienServ_E,$venteBienServ_EP,$venteBienServ_E2,'712'); break;
		case '7121' : list($venteBienMar1_E,$venteBienMar1_EP,$venteBienMar1_E2) = calculateMontant($dateCreation,$dateChoisis,$venteBienMar1_E,$venteBienMar1_EP,$venteBienMar1_E2,'7121'); break;
		case '71291' : list($venteBienMar2_E,$venteBienMar2_EP,$venteBienMar2_E2) = calculateMontant($dateCreation,$dateChoisis,$venteBienMar2_E,$venteBienMar2_EP,$venteBienMar2_E2,'71291'); break;
		case '7122' : list($venteBienEtrg1_E,$venteBienEtrg1_EP,$venteBienEtrg1_E2) = calculateMontant($dateCreation,$dateChoisis,$venteBienEtrg1_E,$venteBienEtrg1_EP,$venteBienEtrg1_E2,'7122'); break;
		case '71292' : list($venteBienEtrg2_E,$venteBienEtrg2_EP,$venteBienEtrg2_E2) = calculateMontant($dateCreation,$dateChoisis,$venteBienEtrg2_E,$venteBienEtrg2_EP,$venteBienEtrg2_E2,'71292'); break;
		case '7124' : list($venteServMar1_E,$venteServMar1_EP,$venteServMar1_E2) = calculateMontant($dateCreation,$dateChoisis,$venteServMar1_E,$venteServMar1_EP,$venteServMar1_E2,'7124'); break;
		case '71924' : list($venteServMar2_E,$venteServMar2_EP,$venteServMar2_E2) = calculateMontant($dateCreation,$dateChoisis,$venteServMar2_E,$venteServMar2_EP,$venteServMar2_E2,'71924'); break;
		case '7125' : list($venteServEtrg1_E,$venteServEtrg1_EP,$venteServEtrg1_E2) = calculateMontant($dateCreation,$dateChoisis,$venteServEtrg1_E,$venteServEtrg1_EP,$venteServEtrg1_E2,'7125'); break;
		case '71925' : list($venteServEtrg2_E,$venteServEtrg2_EP,$venteServEtrg2_E2) = calculateMontant($dateCreation,$dateChoisis,$venteServEtrg2_E,$venteServEtrg2_EP,$venteServEtrg2_E2,'71925'); break;
		case '713' : list($varStockProd_E,$varStockProd_EP,$varStockProd_E2) = calculateMontant($dateCreation,$dateChoisis,$varStockProd_E,$varStockProd_EP,$varStockProd_E2,'713'); break;
		case '7131' : list($varStockProdC_E,$varStockProdC_EP,$varStockProdC_E2) = calculateMontant($dateCreation,$dateChoisis,$varStockProdC_E,$varStockProdC_EP,$varStockProdC_E2,'7131'); break;
		case '7132' : list($varStockBien_E,$varStockBien_EP,$varStockBien_E2) = calculateMontant($dateCreation,$dateChoisis,$varStockBien_E,$varStockBien_EP,$varStockBien_E2,'7132'); break;
		case '7134' : list($varStockServ_E,$varStockServ_EP,$varStockServ_E2) = calculateMontant($dateCreation,$dateChoisis,$varStockServ_E,$varStockServ_EP,$varStockServ_E2,'7134'); break;
		case '718' : list($autreProd_E,$autreProd_EP,$autreProd_E2) = calculateMontant($dateCreation,$dateChoisis,$autreProd_E,$autreProd_EP,$autreProd_E2,'718'); break;
		case '7181' : list($jetoPre_E,$jetoPre_EP,$jetoPre_E2) = calculateMontant($dateCreation,$dateChoisis,$jetoPre_E,$jetoPre_EP,$jetoPre_E2,'7181'); break;
		case '719' : list($repriseExpl_E,$repriseExpl_EP,$repriseExpl_E2) = calculateMontant($dateCreation,$dateChoisis,$repriseExpl_E,$repriseExpl_EP,$repriseExpl_E2,'719'); break;
		case '7197' : list($transCharg_E,$transCharg_EP,$transCharg_E2) = calculateMontant($dateCreation,$dateChoisis,$transCharg_E,$transCharg_EP,$transCharg_E2,'7197'); break;
		case '738' : list($interetAutre_E,$interetAutre_EP,$interetAutre_E2) = calculateMontant($dateCreation,$dateChoisis,$interetAutre_E,$interetAutre_EP,$interetAutre_E2,'738'); break;
		case '7381' : list($interetProd_E,$interetProd_EP,$interetProd_E2) = calculateMontant($dateCreation,$dateChoisis,$interetProd_E,$interetProd_EP,$interetProd_E2,'7381'); break;
		case '7383' : list($revenuCrean_E,$revenuCrean_EP,$revenuCrean_E2) = calculateMontant($dateCreation,$dateChoisis,$revenuCrean_E,$revenuCrean_EP,$revenuCrean_E2,'7383'); break;
		case '7385' : list($produitNet_E,$produitNet_EP,$produitNet_E2) = calculateMontant($dateCreation,$dateChoisis,$produitNet_E,$produitNet_EP,$produitNet_E2,'7385'); break;

        default:$default=$montant;break;

    }
}

// Calcule Totale Achats de marchandises
$achatMarch_E=$varStock_E-$total1_E;
$achatMarch_EP=$varStock_EP-$total1_EP;
$achatMarch_E2=$varStock_E2-$total1_E2;

// Achats de matières premières
$achatMatPre_E=$achatMatPre1_E+$achatMatPre2_E+$achatMatPre3_E+$achatMatPre4_E;
$achatMatPre_EP=$achatMatPre1_EP+$achatMatPre2_EP+$achatMatPre3_EP+$achatMatPre4_EP;
$achatMatPre_E2=$achatMatPre1_E2+$achatMatPre2_E2+$achatMatPre3_E2+$achatMatPre4_E2;

// Calcule Achats de matières et fournitures consommables et d'emballages
$achatMatFourn_E=$achatMatFourn1_E=$achatMatFourn2_E=$achatMatFourn3_E=$achatMatFourn4_E=$achatMatFourn5_E=$achatMatFourn6_E;
$achatMatFourn_EP=$achatMatFourn1_EP=$achatMatFourn2_EP=$achatMatFourn3_EP=$achatMatFourn4_EP=$achatMatFourn5_EP=$achatMatFourn6_EP;
$achatMatFourn_E2=$achatMatFourn1_E2=$achatMatFourn2_E2=$achatMatFourn3_E2=$achatMatFourn4_E2=$achatMatFourn5_E2=$achatMatFourn6_E2;

// Calcule Variation des stocks de matières, fournitures et emballages
$varStockMatFourn_E=$varStockMatFourn1_E+$varStockMatFourn2_E+$varStockMatFourn3_E;
$varStockMatFourn_EP=$varStockMatFourn1_EP+$varStockMatFourn2_EP+$varStockMatFourn3_EP;
$varStockMatFourn_E2=$varStockMatFourn1_E2+$varStockMatFourn2_E2+$varStockMatFourn3_E2;

// Calcule Achats non stockés de matières et de fournitures
$achatNonStockMat_E=$achatNonStockMat1_E+$achatNonStockMat2_E+$achatNonStockMat3_E;
$achatNonStockMat_EP=$achatNonStockMat1_EP+$achatNonStockMat2_EP+$achatNonStockMat3_EP;
$achatNonStockMat_E2=$achatNonStockMat1_E2+$achatNonStockMat2_E2+$achatNonStockMat3_E2;

// Calcule Achats de travaux, études et prestation de services
$achatTravEtud_E=$achatTravEtud1_E+$achatTravEtud2_E+$achatTravEtud3_E;
$achatTravEtud_EP=$achatTravEtud1_EP+$achatTravEtud2_EP+$achatTravEtud3_EP;
$achatTravEtud_E2=$achatTravEtud1_E2+$achatTravEtud2_E2+$achatTravEtud3_E2;

// Calcule Total 2
$total2_E=$achatMatPre_E+$varStockMat_E+$achatMatFourn_E+$varStockMatFourn_E+$achatNonStockMat_E+$achatTravEtud_E;
$total2_EP=$achatMatPre_EP+$varStockMat_EP+$achatMatFourn_EP+$varStockMatFourn_EP+$achatNonStockMat_EP+$achatTravEtud_EP;
$total2_E2=$achatMatPre_E2+$varStockMat_E2+$achatMatFourn_E2+$varStockMatFourn_E2+$achatNonStockMat_E2+$achatTravEtud_E2; 

// Calcule Autres charges externes
$autreCharg_E=$autreCharg1_E+$autreCharg2_E;
$autreCharg_EP=$autreCharg1_EP+$autreCharg2_EP;
$autreCharg_E2=$autreCharg1_E2+$autreCharg2_E2;

// Locations et charges locatives
$locatCharg_E=$locatCharg1_E+$locatCharg2_E+$locatCharg3_E;
$locatCharg_EP=$locatCharg1_EP+$locatCharg2_EP+$locatCharg3_EP;
$locatCharg_E2=$locatCharg1_E2+$locatCharg2_E2+$locatCharg3_E2;

// Calcule Redevances de crédit-bail
$redCred_E=$redCred1_E+$redCred2_E+$redCred3_E;
$redCred_EP=$redCred1_EP+$redCred2_EP+$redCred3_EP;
$redCred_E2=$redCred1_E2+$redCred2_E2+$redCred3_E2;

// Calcule Entretient et réparations
$entreRepa_E=$entreRepa1_E+$entreRepa2_E+$entreRepa3_E;
$entreRepa_EP=$entreRepa1_EP+$entreRepa2_EP+$entreRepa3_EP;
$entreRepa_E2=$entreRepa1_E2+$entreRepa2_E2+$entreRepa3_E2;

// Calcule Primes d'assurances
$primeAssur_E=$primeAssur1_E+$primeAssur2_E+$primeAssur3_E;
$primeAssur_EP=$primeAssur1_EP+$primeAssur2_EP+$primeAssur3_EP;
$primeAssur_E2=$primeAssur1_E2+$primeAssur2_E2+$primeAssur3_E2;

// Calcule Rémunérations du personnel extérieur à l'entreprise
$remunePers_E=$remunePers1_E+$remunePers2_E;
$remunePers_EP=$remunePers1_EP+$remunePers2_EP;
$remunePers_E2=$remunePers1_E2+$remunePers2_E2;

// Calcule Rémunérations d'intermédiaires et honoraires
$remuneInter_E=$remuneInter1_E+$remuneInter2_E+$remuneInter3_E;
$remuneInter_EP=$remuneInter1_EP+$remuneInter2_EP+$remuneInter3_EP;
$remuneInter_E2=$remuneInter1_E2+$remuneInter2_E2+$remuneInter3_E2;

// Calcule Redevances pour brevets, marque, droits ...
$redevBrevet_E=$redevBrevet1_E+$redevBrevet2_E+$redevBrevet3_E;
$redevBrevet_EP=$redevBrevet1_EP+$redevBrevet2_EP+$redevBrevet3_EP;
$redevBrevet_E2=$redevBrevet1_E2+$redevBrevet2_E2+$redevBrevet3_E2;

// Calcule Transports
$trans_E=$trans1_E+$trans2_E+$trans3_E;
$trans_EP=$trans1_EP+$trans2_EP+$trans3_EP;
$trans_E2=$trans1_E2+$trans2_E2+$trans3_E2;

// Calcule Déplacements, missions et réceptions
$deplacMiss_E=$deplacMiss1_E+$deplacMiss2_E;
$deplacMiss_EP=$deplacMiss1_EP+$deplacMiss2_EP;
$deplacMiss_E2=$deplacMiss1_E2+$deplacMiss2_E2;

// Calcule Total 3
$total3_E=$autreCharg1_E+$autreCharg2_E;
$total3_EP=$autreCharg1_EP+$autreCharg2_EP;
$total3_E2=$autreCharg1_E2+$autreCharg2_E2;

// Calcule Reste du poste des autres charges externes
$restPoste_E=$total3_E-($locatCharg_E+$redCred_E+$entreRepa_E+$primeAssur_E+$remunePers_E+$remuneInter_E+$redevBrevet_E+$trans_E+$deplacMiss_E);
$restPoste_EP=$total3_EP-($locatCharg_EP+$redCred_EP+$entreRepa_EP+$primeAssur_EP+$remunePers_EP+$remuneInter_EP+$redevBrevet_EP+$trans_EP+$deplacMiss_EP);
$restPoste_E2=$total3_E2-($locatCharg_E2+$redCred_E2+$entreRepa_E2+$primeAssur_E2+$remunePers_E2+$remuneInter_E2+$redevBrevet_E2+$trans_E2+$deplacMiss_E2);

// Calcule Total 4
$total4_E=$chagePers_E;
$total4_EP=$chagePers_EP;
$total4_E2=$chagePers_E2;

// Calcule Reste du poste des charges de personnel
$restPosteCharg_E=$total4_E-($remunePerso_E+$chageSocial_E);
$restPosteCharg_EP=$total4_EP-($remunePerso_EP+$chageSocial_EP);
$restPosteCharg_E2=$total4_E2-($remunePerso_E2+$chageSocial_E2);

// Calcule Total 5
$total5_E=$autreChargeExp_E;
$total5_EP=$autreChargeExp_EP;
$total5_E2=$autreChargeExp_E2;

// Calcule Reste du poste des autres charges d'exploitation
$restPosteChargExp_E=$total5_E-($jetonPres_E+$perteCre_E);
$restPosteChargExp_EP=$total5_EP-($jetonPres_EP+$perteCre_EP);
$restPosteChargExp_E2=$total5_E2-($jetonPres_E2+$perteCre_E2);

// Calcule Total 6
$tatal6_E=$autreChargFin_E;
$tatal6_EP=$autreChargFin_EP;
$tatal6_E2=$autreChargFin_E2;

// Reste du poste des autres charges financières
$restPosteFin_E=+$tatal6_E-$chargeNet_E;
$restPosteFin_EP=+$tatal6_EP-$chargeNet_EP;
$restPosteFin_E2=+$tatal6_E2-$chargeNet_E2;

// Calcule Total 7
$total7_E=$autreChargN_E;
$total7_EP=$autreChargN_EP;
$total7_E2=$autreChargN_E2;

// Calcule Reste du poste des autres charges non courantes
$restePosteNonC_E=$total7_E-($penalMarch_E+$rappelImpo_E+$penalAmand_E+$creanDeven_E);
$restePosteNonC_EP=$total7_EP-($penalMarch_EP+$rappelImpo_EP+$penalAmand_EP+$creanDeven_EP);
$restePosteNonC_E2=$total7_E2-($penalMarch_E2+$rappelImpo_E2+$penalAmand_E2+$creanDeven_E2);

// Calcule Total 8
$total8_E=-$venteMarch_E;
$total8_EP=-$venteMarch_EP;
$total8_E2=-$venteMarch_E2;

// Calcule Reste du poste des ventes de marchandises
$restePosteMarch_E=+$total8_E-($venteMarchMar_E+$venteMarchEtrg_E);
$restePosteMarch_EP=+$total8_EP-($venteMarchMar_EP+$venteMarchEtrg_EP);
$restePosteMarch_E2=+$total8_E2-($venteMarchMar_E2+$venteMarchEtrg_E2);

// Calcule Ventes de biens au Maroc
$venteBienMar_E=-$venteBienMar1_E-$venteBienMar2_E;
$venteBienMar_EP=-$venteBienMar1_EP-$venteBienMar2_EP;
$venteBienMar_E2=-$venteBienMar1_E2-$venteBienMar2_E2;

//Calcule Ventes de biens à l'étranger
$venteBienEtrg_E=-$venteBienEtrg1_E-$venteBienEtrg2_E;
$venteBienEtrg_EP=-$venteBienEtrg1_EP-$venteBienEtrg2_EP;
$venteBienEtrg_E2=-$venteBienEtrg1_E2-$venteBienEtrg2_E2;

// Calcule Ventes des services au Maroc
$venteServMar_E=-$venteServMar1_E-$venteServMar2_E;
$venteServMar_EP=-$venteServMar1_EP-$venteServMar2_EP;
$venteServMar_E2=-$venteServMar1_E2-$venteServMar2_E2;

// Calcule Ventes des services à l'étranger
$venteServEtrg_E=-$venteServEtrg1_EP-$venteServEtrg2_E2;
$venteServEtrg_EP=-$venteServEtrg1_EP-$venteServEtrg2_E2;
$venteServEtrg_E2=-$venteServEtrg1_EP-$venteServEtrg2_E2;

// Calcule Total 9
$total9_E=-$venteBienServ_E;
$total9_EP=-$venteBienServ_EP;
$total9_E2=-$venteBienServ_E2;

// Calcule Reste du poste des ventes et services produits
$restPosteVente_E=+$total9_E-($venteBienMar_E+$venteServMar_E+$venteServEtrg_E+$redevBrevet_E);
$restPosteVente_EP=+$total9_EP-($venteBienMar_EP+$venteServMar_EP+$venteServEtrg_EP+$redevBrevet_EP);
$restPosteVente_E2=+$total9_E2-($venteBienMar_E2+$venteServMar_E2+$venteServEtrg_E2+$redevBrevet_E2);

// Calcule Total 10
$total10_E=$varStockProdC_E+$varStockBien_E+$varStockServ_E;
$total10_EP=$varStockProdC_EP+$varStockBien_EP+$varStockServ_EP;
$total10_E2=$varStockProdC_E2+$varStockBien_E2+$varStockServ_E2;

// Calcule Total 11
$total11_E=-$autreProd_E;
$total11_EP=-$autreProd_EP;
$total11_E2=-$autreProd_E2;

// Calcule Reste du poste (produits divers)
$restePoste_E=+$total11_E-$jetoPre_E;
$restePoste_EP=+$total11_EP-$jetoPre_EP;
$restePoste_E2=+$total11_E2-$jetoPre_E2;

// Calcule Total 12
$total12_E=-$repriseExpl_E;
$total12_EP=-$repriseExpl_EP;
$total12_E2=-$repriseExpl_E2;

// Reprises
$reprise_E=+$total12_E-$transCharg_E;
$reprise_EP=+$total12_EP-$transCharg_EP;
$reprise_E2=+$total12_E2-$transCharg_E2;

// Calcule Total 13
$total13_E=-$interetAutre_E;
$total13_EP=-$interetAutre_EP;
$total13_E2=-$interetAutre_E2;

// Calcule Reste du poste intérêts et autres produits financiers
$restePosteIntert_E=+$total13_E-($interetProd_E+$revenuCrean_E+$produitNet_E);
$restePosteIntert_EP=+$total13_EP-($interetProd_EP+$revenuCrean_EP+$produitNet_EP);
$restePosteIntert_E2=+$total13_E2-($interetProd_E2+$revenuCrean_E2+$produitNet_E2);





?>