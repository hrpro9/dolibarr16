<?php

// Load Dolibarr environment
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
require_once '../functionDeclarationLaisse.php';


  // MBDE : Montant brut début exercice 
  // Augmentation (AA : Acquisition // APPLPEM : Production par l'Etps pour elle même // AV : Virement	)
  // Diminution ( DC : Cession // DR :	Retrait // DV :	Virement)
  // MBFE : Montant brut fin exercice



 $FP_MBDE=$FP_AA=$FP_APPLPEM=$FP_AV=$FP_DC=$FP_DR=$FP_DV=$FP_MBFE=0;//- Frais préliminaires
 $CARSPE_MBDE=$CARSPE_AA=$CARSPE_APPLPEM=$CARSPE_AV=$CARSPE_DC=$CARSPE_DR=$CARSPE_DV=$CARSPE_MBFE=0;//- Charges à répartir sur plusieurs exercices
 $PDRO_MBDE=$PDRO_AA=$PDRO_APPLPEM=$PDRO_AV=$PDRO_DC=$PDRO_DR=$PDRO_DV=$PDRO_MBFE=0;//- Primes de remboursement obligations
 $IENV_MBDE=$IENV_AA=$IENV_APPLPEM=$IENV_AV=$IENV_DC=$IENV_DR=$IENV_DV=$IENV_MBFE=0;//IMMOBILISATION EN NON-VALEURS

 $II_MBDE=$II_AA=$II_APPLPEM=$II_AV=$II_DC=$II_DR=$II_DV=$II_MBFE=0;//IMMOBILISATIONS INCORPORELLES
 $IERED_MBDE=$IERED_AA=$IERED_APPLPEM=$IERED_AV=$IERED_DC=$IERED_DR=$IERED_DV=$IERED_MBFE=0;//- Immobilisation en recherche et développement
 $BMDEVS_MBDE=$BMDEVS_AA=$BMDEVS_APPLPEM=$BMDEVS_AV=$BMDEVS_DC=$BMDEVS_DR=$BMDEVS_DV=$BMDEVS_MBFE=0;//- Brevets, marques, droits et valeurs similaires
 $FC_MBDE=$FC_AA=$FC_APPLPEM=$FC_AV=$FC_DC=$FC_DR=$FC_DV=$FC_MBFE=0;//Fonds commercial
 $AII_MBDE=$AII_AA=$AII_APPLPEM=$AII_AV=$AII_DC=$AII_DR=$AII_DV=$AII_MBFE=0;//Autres immobilisations incorporelles

 $IC_MBDE=$IC_AA=$IC_APPLPEM=$IC_AV=$IC_DC=$IC_DR=$IC_DV=$IC_MBFE=0;//IMMOBILISATIONS CORPORELLES
 $T_MBDE=$T_AA=$T_APPLPEM=$T_AV=$T_DC=$T_DR=$T_DV=$T_MBFE=0;//- Terrains
 $C_MBDE= $C_AA= $C_APPLPEM= $C_AV= $C_DC= $C_DR= $C_DV= $C_MBFE=0;//- Constructions
 $ITMEO_MBDE= $ITMEO_AA= $ITMEO_APPLPEM= $ITMEO_AV= $ITMEO_DC= $ITMEO_DR= $ITMEO_DV= $ITMEO_MBFE=0;//- Installations techniques, matériel et outillage
 $MDT_MBDE=$MDT_AA=$MDT_APPLPEM=$MDT_AV=$MDT_DC=$MDT_DR=$MDT_DV=$MDT_MBFE=0;//Matériel de transport
 $MMDBEA_MBDE=$MMDBEA_AA=$MMDBEA_APPLPEM=$MMDBEA_AV=$MMDBEA_DC=$MMDBEA_DR=$MMDBEA_DV=$MMDBEA_MBFE=0;//- Mobilier, matériel de bureau et aménagement
 $MMDBEA_MBDE1=$MMDBEA_MBDE2=0;
 $MMDBEA_MBFE1=$MMDBEA_MBFE2=0;
 $AIC_MBDE=$AIC_AA=$AIC_APPLPEM=$AIC_AV=$AIC_DC=$AIC_DR=$AIC_DV=$AIC_MBFE=0;/// Autres immobilisations corporelles
 $ICEC_MBDE=$ICEC_AA=$ICEC_APPLPEM=$ICEC_AV=$ICEC_DC=$ICEC_DR=$ICEC_DV=$ICEC_MBFE=0;// Immobilisations corporelles en cours
 $MI_MBDE=$MI_AA=$MI_APPLPEM=$MI_AV=$MI_DC=$MI_DR=$MI_DV=$MI_MBFE=0;//Matériel informatique
 $T_MBDE=$T_AA=$T_APPLPEM=$T_AV=$T_DC=$T_DR=$T_DV=$T_MBFE=0;//Total




//  function checkValue($value)
//  {
//   $value=(isset($value))?$value:0;
//   return $value;
//  }



  $dateChoisis=0;
  $dateChoisis=(isset($_POST['chargement']))?$_POST['date_select']:0;
  if(!isset($_POST['chargement']))
  {
    $dateChoisis=GETPOST('valeurdatechoise');
  }

  if(isset($_POST['chargement']))
  {
      for ($i = 1; $i <= 75; $i++) {
        ${'immobilisationFinancieres' . $i} = $_POST['immobilisationFinancieres' . $i];
    }

    $IENV_APPLPEM=$immobilisationFinancieres1+$immobilisationFinancieres6+$immobilisationFinancieres11;
    $IENV_AV=$immobilisationFinancieres2+$immobilisationFinancieres7+$immobilisationFinancieres12;
    $IENV_DC=$immobilisationFinancieres3+$immobilisationFinancieres8+$immobilisationFinancieres13;
    $IENV_DR=$immobilisationFinancieres4+$immobilisationFinancieres9+$immobilisationFinancieres14;
    $IENV_DV=$immobilisationFinancieres5+$immobilisationFinancieres10+$immobilisationFinancieres15;

   
    $II_APPLPEM=$immobilisationFinancieres16+$immobilisationFinancieres21+$immobilisationFinancieres26+$immobilisationFinancieres31;
    $II_AV=$immobilisationFinancieres17+$immobilisationFinancieres22+$immobilisationFinancieres27+$immobilisationFinancieres32;
    $II_DC=$immobilisationFinancieres18+$immobilisationFinancieres23+$immobilisationFinancieres28+$immobilisationFinancieres33;
    $II_DR=$immobilisationFinancieres19+$immobilisationFinancieres24+$immobilisationFinancieres29+$immobilisationFinancieres34;
    $II_DV=$immobilisationFinancieres20+$immobilisationFinancieres25+$immobilisationFinancieres30+$immobilisationFinancieres35;


    $IC_APPLPEM=$immobilisationFinancieres36+$immobilisationFinancieres41+$immobilisationFinancieres46+$immobilisationFinancieres51+$immobilisationFinancieres56+$immobilisationFinancieres61+$immobilisationFinancieres66+$immobilisationFinancieres71;
    $IC_AV=$immobilisationFinancieres37+$immobilisationFinancieres42+$immobilisationFinancieres47+$immobilisationFinancieres52+$immobilisationFinancieres57+$immobilisationFinancieres62+$immobilisationFinancieres67+$immobilisationFinancieres72;
    $IC_DC=$immobilisationFinancieres38+$immobilisationFinancieres43+$immobilisationFinancieres48+$immobilisationFinancieres53+$immobilisationFinancieres58+$immobilisationFinancieres63+$immobilisationFinancieres68+$immobilisationFinancieres73;
    $IC_DR=$immobilisationFinancieres39+$immobilisationFinancieres44+$immobilisationFinancieres49+$immobilisationFinancieres54+$immobilisationFinancieres59+$immobilisationFinancieres64+$immobilisationFinancieres69+$immobilisationFinancieres74;
    $IC_DV=$immobilisationFinancieres40+$immobilisationFinancieres45+$immobilisationFinancieres50+$immobilisationFinancieres55+$immobilisationFinancieres60+$immobilisationFinancieres65+$immobilisationFinancieres70+$immobilisationFinancieres75;
   
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
      case "211":list($FP_MBFE,$FP_MBDE)=calculateMontant($dateCreation, $dateChoisis, $FP_MBFE,$FP_MBDE, '0','211');break;
      case "212":list($CARSPE_MBFE,$CARSPE_MBDE)=calculateMontant($dateCreation, $dateChoisis, $CARSPE_MBFE,$CARSPE_MBDE, '0','212');break;
      case "213":list($PDRO_MBFE,$PDRO_MBDE)=calculateMontant($dateCreation, $dateChoisis, $PDRO_MBFE,$PDRO_MBDE, '0','213');break;
      case "221":list($IERED_MBFE,$IERED_MBDE)=calculateMontant($dateCreation, $dateChoisis, $IERED_MBFE,$IERED_MBDE, '0','221');break;
      case "222":list($BMDEVS_MBFE,$BMDEVS_MBDE)=calculateMontant($dateCreation, $dateChoisis, $BMDEVS_MBFE,$BMDEVS_MBDE, '0','222');break;
      case "223":list($FC_MBFE,$FC_MBDE)=calculateMontant($dateCreation, $dateChoisis, $FC_MBFE,$FC_MBDE, '0','223');break;
      case "228":list($AII_MBFE,$AII_MBDE)=calculateMontant($dateCreation, $dateChoisis, $AII_MBFE,$AII_MBDE, '0','228');break;
      case "231":list($T_MBFE,$T_MBDE)=calculateMontant($dateCreation, $dateChoisis, $T_MBFE,$T_MBDE, '0','231');break;
      case "232":list($C_MBFE,$C_MBDE)=calculateMontant($dateCreation, $dateChoisis, $C_MBFE,$C_MBDE, '0','232');break;
      case "233":list($ITMEO_MBFE,$ITMEO_MBDE)=calculateMontant($dateCreation, $dateChoisis, $ITMEO_MBFE,$ITMEO_MBDE, '0','233');break;
      case "234":list($MDT_MBFE,$MDT_MBDE)=calculateMontant($dateCreation, $dateChoisis, $MDT_MBFE,$MDT_MBDE, '0','234');break;
      case "235":list($MMDBEA_MBFE1,$MMDBEA_MBDE1)=calculateMontant($dateCreation, $dateChoisis, $MMDBEA_MBFE1,$MMDBEA_MBDE1, '0','235');break;
      case "2355":list($MMDBEA_MBFE2,$MMDBEA_MBDE2)=calculateMontant($dateCreation, $dateChoisis, $MMDBEA_MBFE2,$MMDBEA_MBDE2, '0','2355');break;
      case "238":list($AIC_MBFE,$AIC_MBDE)=calculateMontant($dateCreation, $dateChoisis, $AIC_MBFE,$AIC_MBDE, '0','238');break;
      case "239":list($ICEC_MBFE,$ICEC_MBDE)=calculateMontant($dateCreation, $dateChoisis, $ICEC_MBFE,$ICEC_MBDE, '0','239');break;
      case "2355":list($MI_MBFE,$MI_MBDE)=calculateMontant($dateCreation, $dateChoisis, $MI_MBFE,$MI_MBDE, '0','2355');break;


    }

    // $FP_AA=$FP_MBFE-$FP_MBDE;
    $FP_AA=$FP_MBFE-$FP_MBDE-isset($immobilisationFinancieres1)-isset($immobilisationFinancieres2)+isset($immobilisationFinancieres3)+isset($immobilisationFinancieres4)+isset($immobilisationFinancieres5);
    // $CARSPE_AA=$CARSPE_MBFE-$CARSPE_MBDE;
    $CARSPE_AA=$CARSPE_MBFE-$CARSPE_MBDE-isset($immobilisationFinancieres6)-isset($immobilisationFinancieres7)+isset($immobilisationFinancieres8)+isset($immobilisationFinancieres9)+isset($immobilisationFinancieres10);
    // $PDRO_AA=$PDRO_MBFE-$PDRO_MBDE;
    $PDRO_AA=$PDRO_MBFE-$PDRO_MBDE-isset($immobilisationFinancieres11)-isset($immobilisationFinancieres12)+isset($immobilisationFinancieres13)+isset($immobilisationFinancieres14)+isset($immobilisationFinancieres15);
    $IENV_MBDE=$FP_MBDE+$CARSPE_MBDE+$PDRO_MBDE;
    $IENV_AA=$FP_AA+$CARSPE_AA+$PDRO_AA;
    $IENV_MBFE=$FP_MBFE+$CARSPE_MBFE+$PDRO_MBFE;
    // $IERED_AA=$IERED_MBFE-$IERED_MBDE-$IERED_APPLPEM+$IERED_DC;
    $IERED_AA=$IERED_MBFE-$IERED_MBDE-isset($immobilisationFinancieres16)-isset($immobilisationFinancieres17)+isset($immobilisationFinancieres18)+isset($immobilisationFinancieres19)+isset($immobilisationFinancieres20);
    // $BMDEVS_AA=$BMDEVS_MBFE-$BMDEVS_MBDE-$BMDEVS_APPLPEM+$BMDEVS_DC;
    $BMDEVS_AA=$BMDEVS_MBFE-$BMDEVS_MBDE-isset($immobilisationFinancieres21)-isset($immobilisationFinancieres22)+isset($immobilisationFinancieres23)+isset($immobilisationFinancieres24)+isset($immobilisationFinancieres25);
    // $FC_AA=$FC_MBFE-$FC_MBDE-$FC_APPLPEM+$FC_DC;
    $FC_AA=$FC_MBFE-$FC_MBDE-isset($immobilisationFinancieres26)-isset($immobilisationFinancieres27)+isset($immobilisationFinancieres28)+isset($immobilisationFinancieres29)+isset($immobilisationFinancieres30);
    // $AII_AA=$AII_MBFE-$AII_MBDE-$AII_APPLPEM+$AII_DC;
    $AII_AA=$AII_MBFE-$AII_MBDE-isset($immobilisationFinancieres31)-isset($immobilisationFinancieres32)+isset($immobilisationFinancieres33)+isset($immobilisationFinancieres34)+isset($immobilisationFinancieres35);
    $II_MBDE=$IERED_MBDE+$BMDEVS_MBDE+$FC_MBDE+$AII_MBDE;
    $II_AA=$IERED_AA+$BMDEVS_AA+$FC_AA+$AII_AA;
    $II_MBFE=$IERED_MBFE+$BMDEVS_MBFE+$FC_MBFE+$AII_MBFE;
    // $T_AA=$T_MBFE-$T_MBDE-$T_APPLPEM+$T_DC;
    $T_AA=$T_MBFE-$T_MBDE-isset($immobilisationFinancieres36)-isset($immobilisationFinancieres37)+isset($immobilisationFinancieres38)+isset($immobilisationFinancieres39)+isset($immobilisationFinancieres40);
    // $C_AA=$C_MBFE-$C_MBDE-$C_APPLPEM+ $C_DC;
    $C_AA=$C_MBFE-$C_MBDE-isset($immobilisationFinancieres41)-isset($immobilisationFinancieres42)+isset($immobilisationFinancieres43)+isset($immobilisationFinancieres44)+isset($immobilisationFinancieres45);
    // $ITMEO_AA=$ITMEO_MBFE-$ITMEO_MBDE-$ITMEO_APPLPEM+$ITMEO_DC;
    $ITMEO_AA=$ITMEO_MBFE-$ITMEO_MBDE-isset($immobilisationFinancieres46)-isset($immobilisationFinancieres47)+isset($immobilisationFinancieres48)+isset($immobilisationFinancieres49)+isset($immobilisationFinancieres50);
    $MMDBEA_MBDE= $MMDBEA_MBDE1-$MMDBEA_MBDE2;
    $MMDBEA_MBFE=$MMDBEA_MBFE1-$MMDBEA_MBFE2;
    // $MDT_AA=$MDT_MBFE-$MDT_MBDE-$MDT_APPLPEM+$MDT_DC;
    $MDT_AA=$MDT_MBFE-$MDT_MBDE-isset($immobilisationFinancieres51)-isset($immobilisationFinancieres52)+isset($immobilisationFinancieres53)+isset($immobilisationFinancieres54)+isset($immobilisationFinancieres55);
    // $MMDBEA_AA=$MMDBEA_MBFE-$MMDBEA_MBDE-$MMDBEA_APPLPEM+$MMDBEA_DC;
    $MMDBEA_AA=$MMDBEA_MBFE-$MMDBEA_MBDE-isset($immobilisationFinancieres56)-isset($immobilisationFinancieres57)+isset($immobilisationFinancieres58)+isset($immobilisationFinancieres59)+isset($immobilisationFinancieres60);
    // $AIC_AA=$AIC_MBFE-$AIC_MBDE-$AIC_APPLPEM+$AIC_DC;
    $AIC_AA=$AIC_MBFE-$AIC_MBDE-isset($immobilisationFinancieres61)-isset($immobilisationFinancieres62)+isset($immobilisationFinancieres63)+isset($immobilisationFinancieres64)+isset($immobilisationFinancieres65);
    // $ICEC_AA=$ICEC_MBFE-$ICEC_MBDE-$ICEC_APPLPEM+$ICEC_MBFE;
    $ICEC_AA=$ICEC_MBFE-$ICEC_MBDE-isset($immobilisationFinancieres66)-isset($immobilisationFinancieres67)+isset($immobilisationFinancieres68)+isset($immobilisationFinancieres69)+isset($immobilisationFinancieres70);
    // $MI_AA=$MI_MBFE-$MI_MBDE-$MI_APPLPEM+$MI_DC;
    $MI_AA=$MI_MBFE-$MI_MBDE-isset($immobilisationFinancieres71)-isset($immobilisationFinancieres72)+isset($immobilisationFinancieres73)+isset($immobilisationFinancieres74)+isset($immobilisationFinancieres75);
    $IC_MBDE= $T_MBDE+$C_MBDE+$ITMEO_MBDE+$MDT_MBDE+$MMDBEA_MBDE+$AIC_MBDE+ $ICEC_MBDE+$MI_MBDE;
    $IC_AA=$T_AA+$C_AA+$ITMEO_AA+$MDT_AA+$MMDBEA_AA+$AIC_AA+$ICEC_AA+$MI_AA;
    $IC_MBFE=$T_MBFE+$C_MBFE+$ITMEO_MBFE+$MDT_MBFE+$MMDBEA_MBFE+$AIC_MBFE+$ICEC_MBFE+$MI_MBFE;

    $T_MBDE=$IENV_MBDE+$AII_MBDE+$IC_MBDE;
    $T_AA=$IENV_AA+$AII_AA+$IC_AA;
    $T_MBFE=$IENV_MBFE+$AII_MBFE+$IC_MBFE;

    $T_APPLPEM= $IENV_APPLPEM+$II_APPLPEM+ $IC_APPLPEM;
    $T_AV=$IENV_AV+$II_AV+ $IC_AV;
    $T_DC= $IENV_DC+$II_DC+ $IC_DC;
    $T_DR= $IENV_DR+$II_DR+ $IC_DR;
    $T_DV= $IENV_DV+ $II_DV+$IC_DV;
  }
  if(isset($_POST['chargement']))
  {
    $data = "<?php ";
    $data .= '$FP_MBDE = ' . $FP_MBDE . ";\n";
    $data .= '$FP_MBFE = ' . $FP_MBFE . ";\n";
    $data .= '$FP_AA = ' . $FP_AA . ";\n";
    $data .= '$CARSPE_MBDE = ' . $CARSPE_MBDE . ";\n";
    $data .= '$CARSPE_MBFE = ' . $CARSPE_MBFE . ";\n";
    $data .= '$CARSPE_AA = ' . $CARSPE_AA . ";\n";
    $data .= '$PDRO_MBDE = ' . $PDRO_MBDE . ";\n";
    $data .= '$PDRO_MBFE = ' . $PDRO_MBFE . ";\n";
    $data .= '$PDRO_AA = ' . $PDRO_AA . ";\n";
    $data .= '$IENV_MBDE = ' . $IENV_MBDE . ";\n";
    $data .= '$IENV_AA = ' . $IENV_AA . ";\n";
    $data .= '$IENV_MBFE = ' . $IENV_MBFE . ";\n";
    $data .= '$IERED_MBFE = ' . $IERED_MBFE . ";\n";
    $data .= '$IERED_MBDE = ' . $IERED_MBDE . ";\n";
    $data .= '$IERED_AA = ' . $IERED_AA . ";\n";
    $data .= '$BMDEVS_MBFE = ' . $BMDEVS_MBFE . ";\n";
    $data .= '$BMDEVS_MBDE = ' . $BMDEVS_MBDE . ";\n";
    $data .= '$BMDEVS_AA = ' . $BMDEVS_AA . ";\n";
    $data .= '$FC_MBFE = ' . $FC_MBFE . ";\n";
    $data .= '$FC_MBDE = ' . $FC_MBDE . ";\n";
    $data .= '$FC_AA = ' . $FC_AA . ";\n";
    $data .= '$AII_MBFE = ' . $AII_MBFE . ";\n";
    $data .= '$AII_MBDE = ' . $AII_MBDE . ";\n";
    $data .= '$AII_AA = ' . $AII_AA . ";\n";
    $data .= '$II_MBDE = ' . $II_MBDE . ";\n";
    $data .= '$II_AA = ' . $II_AA . ";\n";
    $data .= '$II_MBFE = ' . $II_MBFE . ";\n";
    $data .= '$T_MBFE = ' . $T_MBFE . ";\n";
    $data .= '$T_MBDE = ' . $T_MBDE . ";\n";
    $data .= '$T_AA = ' . $T_AA . ";\n";
    $data .= '$C_MBFE = ' . $C_MBFE . ";\n";
    $data .= '$C_MBDE = ' . $C_MBDE . ";\n";
    $data .= '$C_AA = ' . $C_AA . ";\n";
    $data .= '$ITMEO_MBDE = ' . $ITMEO_MBDE . ";\n";
    $data .= '$ITMEO_MBFE = ' . $ITMEO_MBFE . ";\n";
    $data .= '$ITMEO_AA = ' . $ITMEO_AA . ";\n";
    $data .= '$MDT_MBDE = ' . $MDT_MBDE . ";\n";
    $data .= '$MDT_MBFE = ' . $MDT_MBFE . ";\n";
    $data .= '$MDT_AA = ' . $MDT_AA . ";\n";
    $data .= '$MMDBEA_MBFE = ' . $MMDBEA_MBFE . ";\n";
    $data .= '$MMDBEA_MBDE = ' . $MMDBEA_MBDE . ";\n";
    $data .= '$MMDBEA_AA = ' . $MMDBEA_AA . ";\n";
    $data .= '$AIC_MBFE = ' . $AIC_MBFE . ";\n";
    $data .= '$AIC_MBDE = ' . $AIC_MBDE . ";\n";
    $data .= '$AIC_AA = ' . $AIC_AA . ";\n";
    $data .= '$ICEC_MBFE = ' . $ICEC_MBFE . ";\n";
    $data .= '$ICEC_MBDE = ' . $ICEC_MBDE . ";\n";
    $data .= '$ICEC_AA = ' . $ICEC_AA . ";\n";
    $data .= '$MI_MBFE = ' . $MI_MBFE . ";\n";
    $data .= '$MI_MBDE = ' . $MI_MBDE . ";\n";
    $data .= '$MI_AA = ' . $MI_AA . ";\n";
    $data .= '$IC_MBDE = ' . $IC_MBDE . ";\n";
    $data .= '$IC_AA = ' . $IC_AA . ";\n";
    $data .= '$IC_MBFE = ' . $IC_MBFE . ";\n";

    $data .= '$T_MBDE = ' . $T_MBDE . ";\n";
    $data .= '$T_AA = ' . $T_AA . ";\n";
    $data .= '$T_MBFE = ' . $T_MBFE   . ";\n";

    for ($i = 1; $i <= 75; $i++) {
      ${'immobilisationFinancieres' . $i} = $_POST['immobilisationFinancieres' . $i];
        $data .= '$immobilisationFinancieres' . $i . ' = ' . ${'immobilisationFinancieres' . $i} . ";\n";  
    }

    $data .= '$IENV_APPLPEM = ' . $IENV_APPLPEM . ";\n";
    $data .= '$IENV_AV = ' . $IENV_AV . ";\n";
    $data .= '$IENV_DC = ' . $IENV_DC   . ";\n";
    $data .= '$IENV_DR = ' . $IENV_DR . ";\n";
    $data .= '$IENV_DV = ' . $IENV_DV . ";\n";
    $data .= '$II_APPLPEM = ' . $II_APPLPEM . ";\n";
    $data .= '$II_AV = ' . $II_AV . ";\n";
    $data .= '$II_DC = ' . $II_DC   . ";\n";
    $data .= '$II_DR = ' . $II_DR . ";\n";
    $data .= '$II_DV = ' . $II_DV . ";\n";
    $data .= '$IC_APPLPEM = ' . $IC_APPLPEM . ";\n";
    $data .= '$IC_AV = ' . $IC_AV . ";\n";
    $data .= '$IC_DC = ' . $IC_DC   . ";\n";
    $data .= '$IC_DR = ' . $IC_DR . ";\n";
    $data .= '$IC_DV = ' . $IC_DV . ";\n";

    $data .= '$T_APPLPEM = ' . $T_APPLPEM . ";\n";
    $data .= '$T_AV = ' . $T_AV . ";\n";
    $data .= '$T_DC = ' . $T_DC   . ";\n";
    $data .= '$T_DR = ' . $T_DR . ";\n";
    $data .= '$T_DV = ' . $T_DV . ";\n";

    $data .= "?>";
    // Now, the variable $year will contain the year value "2023"
    $nomFichier = 'ImmobilisationsFinancieres_fichier_'. $dateChoisis.'.php';
    // Écrire les données dans le nouveau fichier
    file_put_contents($nomFichier, $data);

  }


        


?>