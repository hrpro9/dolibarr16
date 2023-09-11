<?php


// Load Dolibarr environment
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
require_once '../functionDeclarationLaisse.php';


// CDEx=Cumul début exercice 
// DDLEx=Dotation de l'exercice
// ASISo=Amortissements sur immobilisations sorties
// CDFEx=Cumul d'amortissement fin exercice
// CARSPE=Charges à répartir sur plusieurs exercices


//IMMOBILISATION EN NON-VALEURS
$IENV_CDEx=$IENV_DDLEx=$IENV_ASISo=$IENV_CDFEx=0;

//  Frais préliminaires 
$FP_CDEx=$FP_DDLEx=$FP_ASISo=$FP_CDFEx=0;
// Charges à répartir sur plusieurs exercices
$CARSPE_CDEx=$CARSPE_DDLEx=$CARSPE_ASISo=$CARSPE_CDFEx=0;
//Primes de remboursement obligations
$PDRO_CDEx=$PDRO_DDLEx=$PDRO_ASISo=$PDRO_CDFEx=0;

//IMMOBILISATIONS INCORPORELLES
$II_CDEx=$II_DDLEx=$II_ASISo=$II_CDFEx=0;
//Brevets, marques, droits et valeurs similaires
$BMDEVS_CDEx=$BMDEVS_DDLEx=$BMDEVS_ASISo=$BMDEVS_CDFEx=0;
//  Fonds commercial
$FC_CDEx=$FC_DDLEx=$FC_ASISo=$FC_CDFEx=0;
// Autres immobilisations incorporelles
$AII_CDEx=$AII_DDLEx=$AII_ASISo=$AII_CDFEx=0;
// IMMOBILISATIONS CORPORELLES
$IC_CDEx=$IC_DDLEx=$IC_ASISo=$IC_CDFEx=0;
// Terrains
$TER_CDEx=$TER_DDLEx=$TER_ASISo=$TER_CDFEx=0;
// Constructions
$CONS_CDEx=$CONS_DDLEx=$CONS_ASISo=$CONS_CDFEx=0;
// Installations techniques, matériel et outillage
$ITMEO_CDEx=$ITMEO_DDLEx=$ITMEO_ASISo=$ITMEO_CDFEx=0;
// Matériel  de transport
$MDT_CDEx=$MDT_DDLEx=$MDT_ASISo=$MDT_CDFEx=0;
//  Mobilier, matériel  de bureau et aménagement
$MMDBEA_CDEx=$MMDBEA_DDLEx=$MMDBEA_ASISo=$MMDBEA_CDFEx=0;
// Autres immobilisations corporelles
$AIC_CDEx=$AIC_DDLEx=$AIC_ASISo=$AIC_CDFEx=0;
// Immobilisations corporelles en cours
$ICEC_CDEx=$ICEC_DDLEx=$ICEC_ASISo=$ICEC_CDFEx=0;
//Total
$TOTAl_CDEx=$TOTAl_DDLEx=$TOTAl_ASISo=$TOTAl_CDFEx=0;







//Immobilisation en recherche et développement
$IERED_CDEx=$IERED_DDLEx=$IERED_ASISo=$IERED_CDFEx=0;





  $dateChoisis=0;
  $dateChoisis=(isset($_POST['chargement']))?$_POST['date_select']:0;

  if(!isset($_POST['chargement']))
  {
    $dateChoisis=GETPOST('valeurdatechoise');
  }

  if(isset($_POST['chargement']))
  {
    for ($i = 1; $i <= 14; $i++) {
      ${'amortismon' . $i} = $_POST['amortismon' . $i];
  }
  }

 

  

   $sql ="SELECT * FROM llx_accounting_bookkeeping";
   $result =$db->query($sql);

   foreach($result as $row){

    

    $datetime = new DateTime($row['doc_date']);
    $dateCreation = $datetime->format('Y');
    

    
      $numero_compte=$row['numero_compte'];
      $montant=$row['montant'];

    switch($numero_compte){
        case '2811' : list($FP_CDFEx,$FP_CDEx) = calculateMontant($dateCreation,$dateChoisis,$FP_CDFEx,$FP_CDEx,0,'2811'); break;
        case '2812' : list($CARSPE_CDFEx,$CARSPE_CDEx) = calculateMontant($dateCreation,$dateChoisis,$CARSPE_CDFEx,$CARSPE_CDEx,0,'2812'); break;
        case '2813' : list($PDRO_CDFEx,$PDRO_CDEx) = calculateMontant($dateCreation,$dateChoisis,$PDRO_CDFEx,$PDRO_CDEx,0,'2813'); break;

       
        case '2821' : list($IERED_CDFEx,$IERED_CDEx) = calculateMontant($dateCreation,$dateChoisis,$IERED_CDFEx,$IERED_CDEx,0,'2821'); break;
        case '2822' : list($BMDEVS_CDFEx,$BMDEVS_CDEx) = calculateMontant($dateCreation,$dateChoisis,$BMDEVS_CDFEx,$$BMDEVS_CDEx,0,'2822'); break;
        case '2823' : list($FC_CDFEx,$FC_CDEx) = calculateMontant($dateCreation,$dateChoisis,$FC_CDFEx,$FC_CDEx,0,'2823'); break;
        case '2828' : list($AII_CDFEx,$AII_CDEx) = calculateMontant($dateCreation,$dateChoisis,$AII_CDFEx,$AII_CDEx,0,'2828'); break;

       
        case '2831' : list($TER_CDFEx,$TER_CDEx) = calculateMontant($dateCreation,$dateChoisis,$$TER_CDFEx,$TER_CDEx,0,'2831'); break;
        case '2832' : list($CONS_CDFEx,$CONS_CDEx) = calculateMontant($dateCreation,$dateChoisis,$CONS_CDFEx,$CONS_CDEx,0,'2832'); break;
        case '2833' : list($ITMEO_CDFEx,$ITMEO_CDEx) = calculateMontant($dateCreation,$dateChoisis,$ITMEO_CDFEx,$ITMEO_CDEx,0,'2833'); break;
        case '2834' : list($MDT_CDFEx,$MDT_CDEx) = calculateMontant($dateCreation,$dateChoisis,$MDT_CDFEx,$MDT_CDEx,0,'2834'); break;
        case '2835' : list($MMDBEA_CDFEx,$MMDBEA_CDEx) = calculateMontant($dateCreation,$dateChoisis,$MMDBEA_CDFEx,$MMDBEA_CDEx,0,'2835'); break;
        case '2838' : list($AIC_CDFEx,$AIC_CDEx) = calculateMontant($dateCreation,$dateChoisis,$AIC_CDFEx,$AIC_CDEx,0,'2838'); break;
        case '2839' : list($ICEC_CDFEx,$ICEC_CDEx) = calculateMontant($dateCreation,$dateChoisis,$ICEC_CDFEx,$ICEC_CDEx,0,'2839'); break;

    }

    $IENV_CDEx=$FP_CDEx+$CARSPE_CDEx=$PDRO_CDEx;
    $FP_DDLEx=$FP_CDFEx-$FP_CDEx;
    $IENV_DDLEx=$FP_DDLEx+$CARSPE_DDLEx+$PDRO_DDLEx;

    $II_CDEx=$IERED_CDEx+$BMDEVS_CDEx+$FC_CDEx+$AII_CDEx;
    $II_DDLEx=$IERED_DDLEx+$BMDEVS_DDLEx+$FC_DDLEx+$AII_DDLEx;
    $II_CDFEx=$IERED_CDFEx+$BMDEVS_CDFEx+$FC_CDFEx+$AII_CDFEx;

    $IC_CDEx=$TER_CDEx+$CONS_CDEx+$ITMEO_CDEx+$MDT_CDEx+$MMDBEA_CDEx+$AIC_CDEx+$ICEC_CDEx;
    $IC_CDFEx=$TER_CDFEx+$CONS_CDFEx+$ITMEO_CDFEx+$MDT_CDEx+$MMDBEA_CDFEx+$AIC_CDFEx+$ICEC_CDFEx;
    $IC_DDLEx=$TER_DDLEx+$CONS_DDLEx+$ITMEO_DDLEx+$MDT_DDLEx+$MMDBEA_DDLEx+$AIC_DDLEx+$ICEC_DDLEx;

    $TOTAl_CDEx=$IC_CDEx+$II_CDEx+$IENV_CDEx;
    $TOTAl_CDFEx=$IC_CDFEx+$II_CDFEx+$IENV_CDFEx;
    $TOTAl_DDLEx=$IC_DDLEx+$II_DDLEx+$IENV_DDLEx;
    

    $FP_DDLEx=($FP_CDFEx-$FP_CDEx);
    $CARSPE_DDLEx=($CARSPE_CDFEx-$CARSPE_CDEx);
    $PDRO_DDLEx=($PDRO_CDFEx-$PDRO_CDEx);

    $IERED_DDLEx=($IERED_CDFEx-$IERED_CDEx);
    $BMDEVS_DDLEx=($BMDEVS_CDFEx-$BMDEVS_CDEx);
    $FC_DDLEx=($FC_CDFEx-$FC_CDEx);
    $AII_DDLEx=($AII_CDFEx-$AII_CDEx);

    $TER_DDLEx=($TER_CDFEx-$TER_CDEx);
    $CONS_DDLEx=($CONS_CDFEx-$CONS_CDEx);
    $ITMEO_DDLEx=($ITMEO_CDFEx-$ITMEO_CDEx);
    $MDT_DDLEx=($MDT_CDFEx-$MDT_CDEx);
    $MMDBEA_DDLEx=($MMDBEA_CDFEx-$MMDBEA_CDEx);
    $AIC_DDLEx=($AIC_CDFEx-$AIC_CDEx);
    $ICEC_DDLEx=($ICEC_CDFEx-$ICEC_CDEx);

    $IENV_ASISo=(isset($amortismon1)?$amortismon1:0)+(isset($amortismon2)?$amortismon2:0)+(isset($amortismon3)?$amortismon3:0);
    $II_ASISo=(isset($amortismon4)?$amortismon4:0)+(isset($amortismon5)?$amortismon5:0)+(isset($amortismon6)?$amortismon6:0)+(isset($amortismon7)?$amortismon7:0);
    $IC_ASISo=(isset($amortismon8)?$amortismon8:0)+(isset($amortismon9)?$amortismon9:0)+(isset($amortismon10)?$amortismon10:0)+(isset($amortismon11)?$amortismon11:0)+(isset($amortismon12)?$amortismon12:0)
    +(isset($amortismon13)?$amortismon13:0)+(isset($amortismon14)?$amortismon14:0);

    $TOTAl_ASISo=$IENV_ASISo+$II_ASISo+$IC_ASISo;

}


if(isset($_POST['chargement']))
  {
  $data = "<?php ";
  $data .= '$IENV_CDEx = ' . $IENV_CDEx . ";\n";
  $data .= '$IENV_DDLEx = ' . $IENV_DDLEx . ";\n";
  $data .= '$II_CDFEx = ' . $II_CDFEx . ";\n";
  $data .= '$FP_CDEx = ' . (-$FP_CDEx) . ";\n";
  $data .= '$FP_DDLEx = ' . ($FP_DDLEx) . ";\n";
  $data .= '$FP_CDFEx = ' . (-$FP_CDFEx) . ";\n";
  $data .= '$CARSPE_DDLEx = ' .(-$CARSPE_DDLEx) . ";\n";
  $data .= '$CARSPE_ASISo = ' . $CARSPE_ASISo . ";\n";
  $data .= '$CARSPE_CDFEx = ' . (-$CARSPE_CDFEx) . ";\n";
  $data .= '$PDRO_DDLEx = ' . (-$PDRO_DDLEx) . ";\n";
  $data .= '$PDRO_ASISo = ' . (-$PDRO_ASISo) . ";\n";
  $data .= '$PDRO_CDFEx = ' . (-$PDRO_CDFEx) . ";\n";
  $data .= '$II_CDEx = ' . $II_CDEx . ";\n";
  $data .= '$II_DDLEx = ' . $II_DDLEx . ";\n";
  $data .= '$II_CDFEx = ' . $II_CDFEx . ";\n";
  $data .= '$IERED_CDEx = ' . (-$IERED_CDEx) . ";\n";
  $data .= '$IERED_DDLEx = ' . (-$IERED_DDLEx) . ";\n";
  $data .= '$IERED_CDFEx = ' . (-$IERED_CDFEx) . ";\n";
  $data .= '$BMDEVS_CDEx = ' . (-$BMDEVS_CDEx) . ";\n";
  $data .= '$BMDEVS_DDLEx = ' . (-$BMDEVS_DDLEx) . ";\n";
  $data .= '$BMDEVS_CDFEx = ' . (-$BMDEVS_CDFEx) . ";\n";
  $data .= '$FC_CDEx = ' . (-$FC_CDEx) . ";\n";
  $data .= '$FC_DDLEx = ' . ($FC_DDLEx) . ";\n";
  $data .= '$FC_CDFEx = ' . (-$FC_CDFEx) . ";\n";
  $data .= '$AII_CDEx = ' . (-$AII_CDEx) . ";\n";
  $data .= '$AII_DDLEx = ' . ($AII_DDLEx) . ";\n";
  $data .= '$AII_CDFEx = ' . (-$AII_CDFEx) . ";\n";
  $data .= '$IC_CDEx = ' . ($IC_CDEx) . ";\n";
  $data .= '$IC_DDLEx = ' . ($IC_DDLEx) . ";\n";
  $data .= '$IC_CDFEx = ' . ($IC_CDFEx) . ";\n";
  $data .= '$TER_CDEx = ' . (-$TER_CDEx) . ";\n";
  $data .= '$TER_DDLEx = ' . ($TER_DDLEx) . ";\n";
  $data .= '$TER_CDFEx = ' . (-$TER_CDFEx) . ";\n";
  $data .= '$CONS_CDEx = ' . (-$CONS_CDEx) . ";\n";
  $data .= '$CONS_DDLEx = ' . ($CONS_DDLEx) . ";\n";
  $data .= '$CONS_CDFEx = ' . (-$CONS_CDFEx) . ";\n";
  $data .= '$ITMEO_CDEx = ' . (-$ITMEO_CDEx) . ";\n";
  $data .= '$ITMEO_CDEx = ' . ($ITMEO_CDEx) . ";\n";
  $data .= '$ITMEO_CDFEx = ' . (-$ITMEO_CDFEx) . ";\n";
  $data .= '$MDT_CDEx = ' . (-$MDT_CDEx) . ";\n";
  $data .= '$MDT_DDLEx = ' . ($MDT_DDLEx) . ";\n";
  $data .= '$MDT_CDFEx = ' . (-$MDT_CDFEx) . ";\n";
  $data .= '$MMDBEA_CDEx = ' . (-$MMDBEA_CDEx) . ";\n";
  $data .= '$MMDBEA_DDLEx = ' . ($MMDBEA_DDLEx) . ";\n";
  $data .= '$MMDBEA_CDFEx = ' . (-$MMDBEA_CDFEx) . ";\n";
  $data .= '$AIC_CDEx = ' . (-$AIC_CDEx) . ";\n";
  $data .= '$AIC_DDLEx = ' . ($AIC_DDLEx) . ";\n";
  $data .= '$AIC_CDFEx = ' . (-$AIC_CDFEx) . ";\n";
  $data .= '$ICEC_CDEx = ' . (-$ICEC_CDEx) . ";\n";
  $data .= '$ICEC_DDLEx = ' . ($ICEC_DDLEx) . ";\n";
  $data .= '$ICEC_CDFEx = ' . (-$ICEC_CDFEx) . ";\n";
  $data .= '$TOTAl_CDEx = ' . (-$TOTAl_CDEx) . ";\n";
  $data .= '$TOTAl_DDLEx = ' . (-$TOTAl_DDLEx) . ";\n";
  $data .= '$TOTAl_CDFEx = ' . (-$TOTAl_CDFEx) . ";\n";

  
    for ($i = 1; $i <= 14; $i++) {
      ${'amortismon' . $i} = $_POST['amortismon' . $i];

      $data .= '$amortismon' . $i . ' = ' . ${'amortismon' . $i} . ";\n";  
    }
  


  $data .= '$IENV_ASISo = ' . ($IENV_ASISo) . ";\n";
  $data .= '$II_ASISo = ' . ($II_ASISo) . ";\n";
  $data .= '$IC_ASISo = ' . ($IC_ASISo) . ";\n";
  $data .= '$TOTAl_ASISo = ' . ($TOTAl_ASISo) . ";\n";
  $data .= "?>";
  // Now, the variable $year will contain the year value "2023"
  $nomFichier = 'Amortisement_fichier_'. $dateChoisis.'.php';
  // Écrire les données dans le nouveau fichier
  file_put_contents($nomFichier, $data);

  }


?>