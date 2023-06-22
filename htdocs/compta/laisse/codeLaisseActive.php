<?php

// Load Dolibarr environment
require_once '../../main.inc.php';
require_once '../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
require_once 'functionDeclarationLaisse.php';


// 'B' : Brut  / 'AP' : Amort et prov  / 'net' : Net   / 'N1' : Année actuel-1  / 'N2' : Année actuel-2  / 'EP' : Exercice Precedent  / 'E2' :  Exercice n-2 

$dateChoisis=0;
$fraisP_B=$fraisP_AP=$fraisP1_N1=$fraisP1_N2=$fraisP2_N1=$fraisP2_N2=0; //Frais préliminaires 
$chargesR_B=$chargesR_AP=$chargesR1_N1=$chargesR1_N2=$chargesR2_N1=$chargesR2_N2=0; //Charges à repartir sur plusieurs exercices
$primesR_B=$primesR_AP=$primesR1_N1=$primesR1_N2=$primesR2_N1=$primesR2_N2=$primesR_EP=$primesR_E2=0; //Primes de remboursement des obligations
$immReche_B=$immReche_AP=$immReche_AP1=$immReche_AP2=$immReche_N1=$immReche_N2=$immReche_AP1_N1=$immReche_AP1_N2=$immReche_AP2_N1=$immReche_AP2_N2=0; //Immobilisations en recherche et développement	
$BMD_B=$BMD_N1=$BMD_N2=$BMD_AP1=$BMD_AP1_N1=$BMD_AP1_N2=$BMD_AP2=$BMD_AP2_N1=$BMD_AP2_N2=0; //Brevets, marques, droits et valeurs similaires
$fondsC_B=$fondsC_N1=$fondsC_N2=$fondsC_AP1=$fondsC_AP2=$fondsC_AP1_N1=$fondsC_AP1_N2=$fondsC_AP2_N1=$fondsC_AP2_N2=0; //Fonds commercial
$autresImmoInc_B=$autresImmoInc_N1=$autresImmoInc_N2=$autresImmoInc_AP1=$autresImmoInc_AP2=$autresImmoInc_AP1_N1=$autresImmoInc_AP1_N2=$autresImmoInc_AP2_N1=$autresImmoInc_AP2_N2=0; //Autres immobilisations incorporelles
$terrains_B=$terrains_AP1=$terrains_AP2=$terrains_N1=$terrains_N2=$terrains_AP1_N1=$terrains_AP1_N2=$terrains_AP2_N1=$terrains_AP2_N2=0; //terrains
$cons_B=$cons_AP1=$cons_AP2=$cons_N1=$cons_N2=$cons_AP1_N1=$cons_AP1_N2=$cons_AP2_N1=$cons_AP2_N2=0; //Constructions
$instalTechMat_B=$instalTechMat_AP1=$instalTechMat_AP2=$instalTechMat_N1=$instalTechMat_N2=$instalTechMat_AP1_N1=$instalTechMat_AP1_N2=$instalTechMat_AP2_N1=$instalTechMat_AP2_N2=0; //Installations techniques, matériel et outillage
$matTransp_B=$matTransp_AP1=$matTransp_AP2=$matTransp_N1=$matTransp_N2=$matTransp_AP1_N1=$matTransp_AP1_N2=$matTransp_AP2_N1=$matTransp_AP2_N2=0; //Matériel de transport_brut
$mobMatAmenag_B=$mobMatAmenag_AP1=$mobMatAmenag_AP2=$mobMatAmenag_N1=$mobMatAmenag_N2=$mobMatAmenag_AP1_N1=$mobMatAmenag_AP1_N2=$mobMatAmenag_AP2_N1=$mobMatAmenag_AP2_N2=0; //Mobiliers, matériel de bureau et aménagements divers
$autresImmoCor_B=$autresImmoCor_AP1=$autresImmoCor_AP2=$autresImmoCor_N1=$autresImmoCor_N2=$autresImmoCor_AP1_N1=$autresImmoCor_AP1_N2=$autresImmoCor_AP2_N1=$autresImmoCor_AP2_N2=0; //Autres immobilisations corporelles
$immCorEnCours_B=$immCorEnCours_AP1=$immCorEnCours_AP2=$immCorEnCours_N1=$immCorEnCours_N2=$immCorEnCours_AP1_N1=$immCorEnCours_AP1_N2=$immCorEnCours_AP2_N1=$immCorEnCours_AP2_N2=0; //Immobilisations corporelles en cours  
$pretsImm_B=$pretsImm_AP=$pretsImm1_N1=$pretsImm1_N2=$pretsImm2_N1=$pretsImm2_N2=0; //Prêts immobilisés
$autresCreFin_B=$autresCreFin_AP=$autresCreFin1_N1=$autresCreFin1_N2=$autresCreFin2_N1=$autresCreFin2_N2=0;//Autres créances financières
$titresP_B=$titresP_AP=$titresP1_N1=$titresP1_N2=$titresP2_N1=$titresP2_N2=0; //Titres de participation_brut
$autresTitrImm_B=$autresTitrImm_AP=$autresTitrImm1_N1=$autresTitrImm1_N2=$autresTitrImm2_N1=$autresTitrImm2_N2=0; //Autres titres immobilisés_brut
$dimCreImm_B=$dimCreImm1_N1=$dimCreImm1_N2=0; //Diminution des créances immobilisées
$augDetFinc_B=$augDetFinc1_N1=$augDetFinc1_N2=0;//Augmentation des dettes de financement
$march_B=$march_AP=$march1_N1=$march1_N2=$march2_N1=$march2_N2=0; //Marchandises
$matFournCon_B=$matFournCon_AP=$matFournCon1_N1=$matFournCon1_N2=$matFournCon2_N1=$matFournCon2_N2=0; //Matières et fournitures consommables
$prodC_B=$prodC_AP=$prodC1_N1=$prodC1_N2=$prodC2_N1=$prodC2_N2=0;; //Produits en cours
$prodIntrProd_B=$prodIntrProd_AP=$prodIntrProd1_N1=$prodIntrProd1_N2=$prodIntrProd2_N1=$prodIntrProd2_N2=0;; //Produits intermédiaires et produits residuels 
$prodFinis_B=$prodFinis_AP=$prodFinis1_N1=$prodFinis1_N2=$prodFinis2_N1=$prodFinis2_N2=0;; //Produits finis
$fournDAA_B=$fournDAA_AP=$fournDAA1_N1=$fournDAA1_N2=$fournDAA2_N1=$fournDAA2_N2=0; // Fournisseurs débiteurs, avances et acomptes
$clientCR_B=$clientCR_AP=$clientCR1_N1=$clientCR1_N2=$clientCR2_N1=$clientCR2_N2=0; //Clients et comptes rattachés
$persl_B=$persl_AP=$persl1_N1=$persl1_N2=$persl2_N1=$persl2_N2=0;; //Personnel
$etat_B=$etat_AP=$etat1_N1=$etat1_N2=$etat2_N1=$etat2_N2=0; //Etat
$comptAss_B=$comptAss_AP=$comptAss1_N1=$comptAss1_N2=$comptAss2_N1=$comptAss2_N2=0; //Comptes d'associés
$autresDebit_B=$autresDebit_AP=$autresDebit1_N1=$autresDebit1_N2=$autresDebit2_N1=$autresDebit2_N2=0;; //Autres débiteurs
$comptRegAct_B=$comptRegAct_AP=$comptRegAct1_N1=$comptRegAct1_N2=$comptRegAct2_N1=$comptRegAct2_N2=0; //Comptes de régularisation actif 
$titreValPlace_B=$titreValPlace_AP=$titreValPlace1_N1=$titreValPlace1_N2=$titreValPlace2_N1=$titreValPlace2_N2=0;//TITRES ET VALEURS DE PLACEMENT 
$ecratConverAct_B=$ecratConverAct1_N1=$ecratConverAct1_N2=0; //ECART DE CONVERSION - ACTIF ( i ) (Elém. Circul.)
$chqValEnc_B=$chqValEnc_AP=$chqValEnc1_N1=$chqValEnc1_N2=$chqValEnc2_N1=$chqValEnc2_N2=0; //Chèques et valeurs à encaisser
$banqTGCP_B=$banqTGCP_AP=$banqTGCP1_N1=$banqTGCP2_N1=$banqTGCP1_N2=$banqTGCP2_N2=0; //Banques, T.G & CP
$caissRegAv_B=$caissRegAv_AP=$caissRegAv1_N1=$caissRegAv2_N1=$caissRegAv1_N2=$caissRegAv2_N2=0; //Caisses, régies d'avances et accréditifs
$tresorAct_B=$tresorAct_AP=$tresorAct_net=0; //TRESORERIE - ACTIF

$immNonVal_B=$immNonVal_AP=$immNonVal_net=0; //IMMOBILISATION EN NON VALEUR ( a )
$immIncor_B=$immIncor_AP=$immIncor_net=0; //IMMOBILISATIONS INCORPORELLES ( b )
$immCor_B=$immCor_AP=$immCor_net=0; //IMMOBILISATIONS CORPORELLES ( c )
$inmmFin_B=$inmmFin_AP=$inmmFin_net=0; //IMMOBILISATIONS FINANCIERES ( d )
$ecratsConv_B=$ecratsConv_AP=$ecratsConv_net=0; //ECARTS DE CONVERSION - ACTIF ( e )
$total1_B=$total1_AP=$total1_net=$total1_EP=$total1_E2=0; //----------------------------- TOTAL  I 
$stocks_B=$stocks_AP=$stocks_net=0; //STOCKS ( f ) 
$creActifCircl_B=$creActifCircl_AP=$creActifCircl_net=0;//CREANCES DE L'ACTIF CIRCULANT ( g )
$total2_B=$total2_AP=$total2_net=$total2_EP=$total2_E2=0;//------------------------------- TOTAL  II   (  f + g + h + i )

  $dateChoisis=0;
  $dateChoisis=(isset($_POST['chargement']))?$_POST['date_select']:0;

   if(!isset($_POST['chargement']))
  {
    $dateChoisis=GETPOST('valeurdatechoise');
  }

   $sql ="SELECT * FROM llx_accounting_bookkeeping ";
   $result =$db->query($sql);

   foreach($result as $row){

    

    $datetime = new DateTime($row['doc_date']);
    $dateCreation = $datetime->format('Y');
    

    
      $numero_compte=$row['numero_compte'];
      $montant=$row['montant'];

      switch($numero_compte){
        /* ancien methode :
          case '211' : 
          if($dateCreation==$anneeDebut){$fraisP_B=montantCalcul('611',$anneeDebut);}
          if($dateCreation==$dateCreationN1){$fraisP1_N1=montantCalcul('611',$dateCreationN1);}
          if($dateCreation==$dateCreationN2){$fraisP2_N1=montantCalcul('211',$dateCreationN2);} break;*/
        case '211' : list($fraisP_B,$fraisP1_N1,$fraisP1_N2) = calculateMontant($dateCreation, $dateChoisis,$fraisP_B,$fraisP1_N1,$fraisP1_N2,'211'); break;
        case '2811': list($fraisP_AP,$fraisP2_N1,$fraisP2_N2) = calculateMontant($dateCreation, $dateChoisis,$fraisP_AP,$fraisP2_N1,$fraisP2_N2,'2811'); break;
        case '212' : list($chargesR_B,$chargesR1_N1,$chargesR1_N2) = calculateMontant($dateCreation, $dateChoisis,$chargesR_B,$chargesR1_N1,$chargesR1_N2,'212'); break;
        case '2812': list($chargesR_B,$chargesR2_N1,$chargesR2_N2) = calculateMontant($dateCreation, $dateChoisis,$chargesR_B,$chargesR2_N1,$chargesR2_N2,'2812'); break;
        // case '213' : list($primesR_B,$primesR1_N1,$primesR1_N2) = calculateMontant($dateCreation, $dateChoisis,$primesR_B,$primesR1_N1,$primesR1_N2,'213'); break;    
        case '611' : list($primesR_B,$primesR1_N1,$primesR1_N2) = calculateMontant($dateCreation, $dateChoisis,$primesR_B,$primesR1_N1,$primesR1_N2,'611'); break;            
        case '2813': list($primesR_AP,$primesR2_N1,$primesR2_N2) = calculateMontant($dateCreation, $dateChoisis,$primesR_AP,$primesR2_N1,$primesR2_N2,'2813'); break;
        case '221' : list($immReche_B,$immReche_N1,$immReche_N2) = calculateMontant($dateCreation, $dateChoisis,$immReche_B,$immReche_N1,$immReche_N2,'221'); break;
        case '2821': list($immReche_AP1,$immReche_AP1_N1,$immReche_AP1_N2) = calculateMontant($dateCreation, $dateChoisis,$immReche_AP1,$immReche_AP1_N1,$immReche_AP1_N2,'2821'); break;
        case '2921': list($immReche_AP2,$immReche_AP2_N1,$immReche_AP2_N2) = calculateMontant($dateCreation, $dateChoisis,$immReche_AP2,$immReche_AP2_N1,$immReche_AP2_N2,'2921'); break;        
        case '222':  list($BMD_B,$BMD_N1,$BMD_N2) = calculateMontant($dateCreation, $dateChoisis,$BMD_B,$BMD_N1,$BMD_N2,'222'); break;
        case '2822': list($BMD_AP1,$BMD_AP1_N1,$BMD_AP1_N2) = calculateMontant($dateCreation, $dateChoisis,$BMD_AP1,$BMD_AP1_N1,$BMD_AP1_N2,'2822'); break;
        case '2922': list($BMD_AP2,$BMD_AP2_N1,$BMD_AP2_N2) = calculateMontant($dateCreation, $dateChoisis,$BMD_AP2,$BMD_AP2_N1,$BMD_AP2_N2,'2922'); break;
        case '223':  list($fondsC_B,$fondsC_N1,$fondsC_N2) = calculateMontant($dateCreation, $dateChoisis,$fondsC_B,$fondsC_N1,$fondsC_N2,'223'); break;
        case '2823': list($fondsC_AP1,$fondsC_AP1_N1,$fondsC_AP1_N2) = calculateMontant($dateCreation, $dateChoisis,$fondsC_AP1,$fondsC_AP1_N1,$fondsC_AP1_N2,'2823'); break;
        case '2923': list($fondsC_AP2,$fondsC_AP2_N1,$fondsC_AP2_N2) = calculateMontant($dateCreation, $dateChoisis,$fondsC_AP2,$fondsC_AP2_N1,$fondsC_AP2_N2,'2923'); break;
        case '228':  list($autresImmoInc_B,$autresImmoInc_N1,$autresImmoInc_N2) = calculateMontant($dateCreation, $dateChoisis,$autresImmoInc_B,$autresImmoInc_N1,$autresImmoInc_N2,'223'); break;
        case '2828': list($autresImmoInc_AP1,$autresImmoInc_AP1_N1,$autresImmoInc_AP1_N2) = calculateMontant($dateCreation, $dateChoisis,$autresImmoInc_AP1,$autresImmoInc_AP1_N1,$autresImmoInc_AP1_N2,'2823'); break;
        case '2928': list($autresImmoInc_AP2,$autresImmoInc_AP2_N1,$autresImmoInc_AP2_N2) = calculateMontant($dateCreation, $dateChoisis,$autresImmoInc_AP2,$autresImmoInc_AP2_N1,$autresImmoInc_AP2_N2,'2923'); break;   
        case '231':  list($terrains_B,$terrains_N1,$terrains_N2) = calculateMontant($dateCreation, $dateChoisis,$terrains_B,$terrains_N1,$terrains_N2,'231'); break;
        case '2831': list($terrains_AP1,$terrains_AP1_N1,$terrains_AP1_N2) = calculateMontant($dateCreation, $dateChoisis,$terrains_AP1,$terrains_AP1_N1,$terrains_AP1_N2,'2831'); break;
        case '2931': list($terrains_AP2,$terrains_AP2_N1,$terrains_AP2_N2) = calculateMontant($dateCreation, $dateChoisis,$terrains_AP2,$terrains_AP2_N1,$terrains_AP2_N2,'2931'); break;
        case '232':  list($cons_B,$cons_N1,$cons_N2) = calculateMontant($dateCreation, $dateChoisis,$cons_B,$cons_N1,$cons_N2,'232'); break;
        case '2832': list($cons_AP1,$cons_AP1_N1,$cons_AP1_N2) = calculateMontant($dateCreation, $dateChoisis,$cons_AP1,$cons_AP1_N1,$cons_AP1_N2,'2832'); break;
        case '2932': list($cons_AP2,$cons_AP2_N1,$cons_AP2_N2) = calculateMontant($dateCreation, $dateChoisis,$cons_AP2,$cons_AP2_N1,$cons_AP2_N2,'2932'); break;
        case '233':  list($instalTechMat_B,$instalTechMat_N1,$instalTechMat_N2) = calculateMontant($dateCreation, $dateChoisis,$instalTechMat_B,$instalTechMat_N1,$instalTechMat_N2,'233'); break;
        case '2833': list($instalTechMat_AP1,$instalTechMat_AP1_N1,$instalTechMat_AP1_N2) = calculateMontant($dateCreation, $dateChoisis,$instalTechMat_AP1,$instalTechMat_AP1_N1,$instalTechMat_AP1_N2,'2833'); break;
        case '2933': list($instalTechMat_AP2,$instalTechMat_AP2_N1,$instalTechMat_AP2_N2) = calculateMontant($dateCreation, $dateChoisis,$instalTechMat_AP2,$instalTechMat_AP2_N1,$instalTechMat_AP2_N2,'2933'); break; 
        case '234':  list($matTransp_B,$matTransp_N1,$matTransp_N2) = calculateMontant($dateCreation, $dateChoisis,$matTransp_B,$matTransp_N1,$matTransp_N2,'234'); break;
        case '2834': list($matTransp_AP1,$matTransp_AP1_N1,$matTransp_AP1_N2) = calculateMontant($dateCreation, $dateChoisis,$matTransp_AP1,$matTransp_AP1_N1,$matTransp_AP1_N2,'2834'); break;
        case '2934': list($matTransp_AP2,$matTransp_AP2_N1,$matTransp_AP2_N2) = calculateMontant($dateCreation, $dateChoisis,$matTransp_AP2,$matTransp_AP2_N1,$matTransp_AP2_N2,'2934'); break;      
        case '235':  list($mobMatAmenag_B,$mobMatAmenag_N1,$mobMatAmenag_N2) = calculateMontant($dateCreation, $dateChoisis,$mobMatAmenag_B,$mobMatAmenag_N1,$mobMatAmenag_N2,'235'); break;
        case '2835': list($mobMatAmenag_AP1,$mobMatAmenag_AP1_N1,$mobMatAmenag_AP1_N2) = calculateMontant($dateCreation, $dateChoisis,$mobMatAmenag_AP1,$mobMatAmenag_AP1_N1,$mobMatAmenag_AP1_N2,'2835'); break;
        case '2935': list($mobMatAmenag_AP2,$mobMatAmenag_AP2_N1,$mobMatAmenag_AP2_N2) = calculateMontant($dateCreation, $dateChoisis,$mobMatAmenag_AP2,$mobMatAmenag_AP2_N1,$mobMatAmenag_AP2_N2,'2935'); break;
        case '238':  list($autresImmoCor_B,$autresImmoCor_N1,$autresImmoCor_N2) = calculateMontant($dateCreation, $dateChoisis,$autresImmoCor_B,$autresImmoCor_N1,$autresImmoCor_N2,'238'); break;
        case '2838': list($autresImmoCor_AP1,$autresImmoCor_AP1_N1,$autresImmoCor_AP1_N2) = calculateMontant($dateCreation, $dateChoisis,$autresImmoCor_AP1,$autresImmoCor_AP1_N1,$autresImmoCor_AP1_N2,'2838'); break;
        case '2938': list($autresImmoCor_AP2,$autresImmoCor_AP2_N1,$autresImmoCor_AP2_N2) = calculateMontant($dateCreation, $dateChoisis,$autresImmoCor_AP2,$autresImmoCor_AP2_N1,$autresImmoCor_AP2_N2,'2938'); break;
        case '239':  list($immCorEnCours_B,$immCorEnCours_N1,$immCorEnCours_N2) = calculateMontant($dateCreation, $dateChoisis,$immCorEnCours_B,$immCorEnCours_N1,$immCorEnCours_N2,'239'); break;
        case '2839': list($immCorEnCours_AP1,$immCorEnCours_AP1_N1,$immCorEnCours_AP1_N2) = calculateMontant($dateCreation, $dateChoisis,$immCorEnCours_AP1,$immCorEnCours_AP1_N1,$immCorEnCours_AP1_N2,'2839'); break;
        case '2939': list($immCorEnCours_AP2,$immCorEnCours_AP2_N1,$immCorEnCours_AP2_N2) = calculateMontant($dateCreation, $dateChoisis,$immCorEnCours_AP2,$immCorEnCours_AP2_N1,$immCorEnCours_AP2_N2,'2939'); break;
        case '241':  list($pretsImm_B,$pretsImm1_N1,$pretsImm1_N2) = calculateMontant($dateCreation, $dateChoisis,$pretsImm_B,$pretsImm1_N1,$pretsImm1_N2,'241'); break;
        case '2941': list($pretsImm_AP,$pretsImm2_N1,$pretsImm2_N2) = calculateMontant($dateCreation, $dateChoisis,$pretsImm_AP,$pretsImm2_N1,$pretsImm2_N2,'2941'); break;
        case '241':  list($autresCreFin_B,$autresCreFin1_N1,$autresCreFin1_N2) = calculateMontant($dateCreation, $dateChoisis,$autresCreFin_B,$autresCreFin1_N1,$autresCreFin1_N2,'241'); break;
        case '2948': list($autresCreFin_AP,$autresCreFin2_N1,$autresCreFin2_N2) = calculateMontant($dateCreation, $dateChoisis,$autresCreFin_AP,$autresCreFin2_N1,$autresCreFin2_N2,'2948'); break;
        case '251':  list($titresP_B,$titresP1_N1,$titresP1_N2) = calculateMontant($dateCreation, $dateChoisis,$titresP_B,$titresP1_N1,$titresP1_N2,'251'); break;
        case '2951': list($titresP_AP,$titresP2_N1,$titresP2_N2) = calculateMontant($dateCreation, $dateChoisis,$titresP_AP,$titresP2_N1,$titresP2_N2,'2951'); break;
        case '258':  list($autresTitrImm_B,$autresTitrImm1_N1,$autresTitrImm1_N2) = calculateMontant($dateCreation, $dateChoisis,$autresTitrImm_B,$autresTitrImm1_N1,$autresTitrImm1_N2,'258'); break;
        case '2958': list($autresTitrImm_AP,$autresTitrImm2_N1,$autresTitrImm2_N2) = calculateMontant($dateCreation, $dateChoisis,$autresTitrImm_AP,$autresTitrImm2_N1,$autresTitrImm2_N2,'2958'); break;
        case '271':  list($dimCreImm_B,$dimCreImm1_N1,$dimCreImm1_N2) = calculateMontant($dateCreation, $dateChoisis,$dimCreImm_B,$dimCreImm1_N1,$dimCreImm1_N2,'271'); break;
        case '272':  list($augDetFinc_B,$augDetFinc1_N1,$augDetFinc1_N2) = calculateMontant($dateCreation, $dateChoisis,$augDetFinc_B,$augDetFinc1_N1,$augDetFinc1_N2,'271');
        case '311':  list($march_B,$march1_N1,$march1_N2) = calculateMontant($dateCreation, $dateChoisis,$march_B,$march1_N1,$march1_N2,'311'); break;
        case '3911': list($march_AP,$march2_N1,$march2_N2) = calculateMontant($dateCreation, $dateChoisis,$march_AP,$march2_N1,$march2_N2,'3911'); break;
        case '312':  list($matFournCon_B,$matFournCon1_N1,$matFournCon1_N2) = calculateMontant($dateCreation, $dateChoisis,$matFournCon_B,$matFournCon1_N1,$matFournCon1_N2,'312'); break;
        case '3912': list($matFournCon_AP,$matFournCon2_N1,$matFournCon2_N2) = calculateMontant($dateCreation, $dateChoisis,$matFournCon_AP,$matFournCon2_N1,$matFournCon2_N2,'3912'); break;
        case '313':  list($prodC_B,$prodC1_N1,$prodC1_N2) = calculateMontant($dateCreation, $dateChoisis,$prodC_B,$prodC1_N1,$prodC1_N2,'313'); break;
        case '3913': list($prodC_AP,$prodC2_N1,$prodC2_N2) = calculateMontant($dateCreation, $dateChoisis,$prodC_AP,$prodC2_N1,$prodC2_N2,'3913'); break;
        case '314':  list($prodIntrProd_B,$prodIntrProd1_N1,$prodIntrProd1_N2) = calculateMontant($dateCreation, $dateChoisis,$prodIntrProd_B,$prodIntrProd1_N1,$prodIntrProd1_N2,'314'); break;
        case '3914': list($prodIntrProd_AP,$prodIntrProd2_N1,$prodIntrProd2_N2) = calculateMontant($dateCreation, $dateChoisis,$prodIntrProd_AP,$prodIntrProd2_N1,$prodIntrProd2_N2,'3914'); break;
        case '315':  list($prodFinis_B,$prodFinis1_N1,$prodFinis1_N2) = calculateMontant($dateCreation, $dateChoisis,$prodFinis_B,$prodFinis1_N1,$prodFinis1_N2,'315'); break;
        case '3915': list($prodFinis_AP,$prodFinis2_N1,$prodFinis2_N2) = calculateMontant($dateCreation, $dateChoisis,$prodFinis_AP,$prodFinis2_N1,$prodFinis2_N2,'3915'); break;
        case '341':  list($fournDAA_B,$fournDAA1_N1,$fournDAA1_N2) = calculateMontant($dateCreation, $dateChoisis,$fournDAA_B,$fournDAA1_N1,$fournDAA1_N2,'341'); break;
        case '3941': list($fournDAA_AP,$fournDAA2_N1,$fournDAA2_N2) = calculateMontant($dateCreation, $dateChoisis,$fournDAA_AP,$prodC2_N1,$fournDAA2_N2,'3941'); break;
        case '342':  list($clientCR_B,$clientCR1_N1,$clientCR1_N2) = calculateMontant($dateCreation, $dateChoisis,$clientCR_B,$clientCR1_N1,$clientCR1_N2,'313'); break;
        case '3942': list($clientCR_AP,$clientCR2_N1,$clientCR2_N2) = calculateMontant($dateCreation, $dateChoisis,$clientCR_AP,$clientCR2_N1,$clientCR2_N2,'3913'); break;
        case '343':  list($persl_B,$persl1_N1,$persl1_N2) = calculateMontant($dateCreation, $dateChoisis,$persl_B,$persl1_N1,$persl1_N2,'343'); break;
        case '3943': list($persl_AP,$persl2_N1,$persl2_N2) = calculateMontant($dateCreation, $dateChoisis,$persl_AP,$persl2_N1,$persl2_N2,'3943'); break;
        case '345':  list($etat_B,$etat1_N1,$etat1_N2) = calculateMontant($dateCreation, $dateChoisis,$etat_B,$etat1_N1,$etat1_N2,'345'); break;
        case '3945': list($etat_AP,$etat2_N1,$etat2_N2) = calculateMontant($dateCreation, $dateChoisis,$etat_AP,$etat2_N1,$etat2_N2,'3945'); break;
        case '346':  list($comptAss_B,$comptAss1_N1,$comptAss1_N2) = calculateMontant($dateCreation, $dateChoisis,$comptAss_B,$comptAss1_N1,$comptAss1_N2,'346'); break;
        case '3946': list($comptAss_AP,$comptAss2_N1,$comptAss2_N2) = calculateMontant($dateCreation, $dateChoisis,$comptAss_AP,$comptAss2_N1,$comptAss2_N2,'3946'); break;
        case '348':  list($autresDebit_B,$autresDebit_N1,$autresDebit1_N2) = calculateMontant($dateCreation, $dateChoisis,$autresDebit_B,$autresDebit1_N1,$autresDebit1_N2,'348'); break;
        case '3948': list($autresDebit_AP,$autresDebit_N1,$autresDebit2_N2) = calculateMontant($dateCreation, $dateChoisis,$autresDebit_AP,$autresDebit2_N1,$autresDebit2_N2,'3948'); break;
        case '349':  list($comptRegAct_B,$comptRegAct1_N1,$comptRegAct1_N2) = calculateMontant($dateCreation, $dateChoisis,$comptRegAct_B,$comptRegAct1_N1,$comptRegAct1_N2,'349'); break;
        case '3949': list($comptRegAct_AP,$comptRegAct2_N1,$comptRegAct2_N2) = calculateMontant($dateCreation, $dateChoisis,$comptRegAct_AP,$comptRegAct2_N1,$comptRegAct2_N2,'3949'); break;
        case '35':  list($titreValPlace_B,$titreValPlace1_N1,$titreValPlace1_N2) = calculateMontant($dateCreation, $dateChoisis,$titreValPlace_B,$titreValPlace1_N1,$titreValPlace1_N2,'35'); break;
        case '395': list($titreValPlace_AP,$titreValPlace2_N1,$titreValPlace2_N2) = calculateMontant($dateCreation, $dateChoisis,$titreValPlace_AP,$titreValPlace2_N1,$titreValPlace2_N2,'395'); break;
        case '37':  list($ecratConverAct_B,$ecratConverAct1_N1,$ecratConverAct1_N2) = calculateMontant($dateCreation, $dateChoisis,$ecratConverAct_B,$ecratConverAct1_N1,$ecratConverAct1_N2,'37'); break;
        case '511':  list($chqValEnc_B,$chqValEnc1_N1,$chqValEnc1_N2) = calculateMontant($dateCreation, $dateChoisis,$chqValEnc_B,$chqValEnc1_N1,$chqValEnc1_N2,'511'); break;
        case '5911': list($chqValEnc_AP,$chqValEnc2_N1,$chqValEnc2_N2) = calculateMontant($dateCreation, $dateChoisis,$chqValEnc_AP,$chqValEnc2_N1,$chqValEnc2_N2,'5911'); break;
        case '514':  list($banqTGCP_B,$banqTGCP1_N1,$banqTGCP1_N2) = calculateMontant($dateCreation, $dateChoisis,$banqTGCP_B,$banqTGCP1_N1,$banqTGCP1_N2,'514'); break;
        case '5914': list($banqTGCP_AP,$banqTGCP2_N1,$banqTGCP2_N2) = calculateMontant($dateCreation, $dateChoisis,$banqTGCP_AP,$banqTGCP2_N1,$banqTGCP2_N2,'5914'); break;
        case '516':  list($caissRegAv_B,$caissRegAv1_N1,$caissRegAv1_N2) = calculateMontant($dateCreation, $dateChoisis,$caissRegAv_B,$caissRegAv1_N1,$caissRegAv1_N2,'516'); break;
        case '5916': list($caissRegAv_AP,$caissRegAv2_N1,$caissRegAv2_N2) = calculateMontant($dateCreation, $dateChoisis,$caissRegAv_AP,$caissRegAv2_N1,$caissRegAv2_N2,'5916'); break;

        default:$default=$montant;break;

      }

      // Calcule Exercice Precedent et Exercice n-2 
      $fraisP_EP=$fraisP1_N1+$fraisP2_N1;
      $fraisP_E2=$fraisP1_N2+$fraisP2_N2;
      $chargesR_EP=$chargesR1_N1+$chargesR2_N1;
      $chargesR_E2=$chargesR1_N2+$chargesR2_N2;
      $primesR_EP=$primesR1_N1+$primesR1_N2;
      $primesR_E2=$primesR2_N1+$primesR2_N2;
      $immReche_EP=$immReche_N1+$immReche_AP1_N1+$immReche_AP2_N1;
      $immReche_E2=$immReche_N2+$immReche_AP1_N2+$immReche_AP2_N2;
      $BMD_EP=$BMD_N1+$BMD_AP1_N1+$BMD_AP2_N1;
      $BMD_E2=$BMD_N2+$BMD_AP1_N2+$BMD_AP2_N2;
      $fondsC_EP=$fondsC_N1+$fondsC_AP1_N1+$fondsC_AP2_N1;
      $fondsC_E2=$fondsC_N2+$fondsC_AP1_N2+$fondsC_AP2_N2;
      $autresImmoInc_EP=$autresImmoInc_N1+$autresImmoInc_AP1_N1+$autresImmoInc_AP2_N1;
      $autresImmoInc_E2=$autresImmoInc_N2+$autresImmoInc_AP1_N2+$autresImmoInc_AP2_N2;
      $terrains_EP=$terrains_N1+$terrains_AP1_N1+$terrains_AP2_N1;
      $terrains_E2=$terrains_N2+$terrains_AP1_N2+$terrains_AP2_N2;
      $cons_EP=$cons_N1+$cons_AP1_N1+$cons_AP2_N1;
      $cons_E2=$cons_N2+$cons_AP1_N2+$cons_AP2_N2;
      $instalTechMat_EP=$instalTechMat_N1+$instalTechMat_AP1_N1+$instalTechMat_AP2_N1;
      $instalTechMat_E2=$instalTechMat_N2+$instalTechMat_AP1_N2+$instalTechMat_AP2_N2;       
      $matTransp_EP=$matTransp_N1+$matTransp_AP1_N1+$matTransp_AP2_N1;
      $matTransp_E2=$matTransp_N2+$matTransp_AP1_N2+$matTransp_AP2_N2;
      $mobMatAmenag_EP=$mobMatAmenag_N1+$mobMatAmenag_AP1_N1+$mobMatAmenag_AP2_N1;
      $mobMatAmenag_E2=$mobMatAmenag_N2+$mobMatAmenag_AP1_N2+$mobMatAmenag_AP2_N2;
      $autresImmoCor_EP=$autresImmoCor_N1+$autresImmoCor_AP1_N1+$autresImmoCor_AP2_N1;
      $autresImmoCor_E2=$autresImmoCor_N2+$autresImmoCor_AP1_N2+$autresImmoCor_AP2_N2;
      $immCorEnCours_EP=$immCorEnCours_N1+$immCorEnCours_AP1_N1+$immCorEnCours_AP2_N1;
      $immCorEnCours_E2=$immCorEnCours_N2+$immCorEnCours_AP1_N2+$immCorEnCours_AP2_N2;
      $pretsImm_EP=$pretsImm1_N1+$pretsImm2_N1;
      $pretsImm_E2=$pretsImm1_N2+$pretsImm2_N2;
      $autresCreFin_EP=$autresCreFin1_N1+$autresCreFin2_N1;
      $autresCreFin_E2=$autresCreFin1_N2+$autresCreFin2_N2;
      $titresP_EP=$titresP1_N1+$titresP2_N1;
      $titresP_E2=$titresP1_N2+$titresP2_N2;
      $autresTitrImm_EP=$autresTitrImm1_N1+$autresTitrImm2_N1;
      $autresTitrImm_E2=$autresTitrImm1_N2+$autresTitrImm2_N2;
      $dimCreImm_EP=$dimCreImm1_N1;
      $dimCreImm_E2=$dimCreImm1_N2;
      $augDetFinc_EP=$augDetFinc1_N1;
      $augDetFinc_E2=$augDetFinc1_N2;
      $march_EP=$march1_N1+$march2_N1;
      $march_E2=$march1_N2+$march2_N2;
      $matFournCon_EP=$matFournCon1_N1+$matFournCon2_N1;
      $matFournCon_E2=$matFournCon1_N2+$matFournCon2_N2;
      $prodC_EP=$prodC1_N1+$prodC2_N1;
      $prodC_E2=$prodC1_N2+$prodC2_N2;
      $prodIntrProd_EP=$prodIntrProd1_N1+$prodIntrProd2_N1;
      $prodIntrProd_E2=$prodIntrProd1_N2+$prodIntrProd2_N2;
      $prodFinis_EP=$prodFinis1_N1+$prodFinis2_N1;
      $prodFinis_E2=$prodFinis1_N2+$prodFinis2_N2;
      $fournDAA_EP=$fournDAA1_N1+$fournDAA2_N1;
      $fournDAA_E2=$fournDAA1_N2+$fournDAA2_N2;
      $clientCR_EP=$clientCR1_N1+$clientCR2_N1;
      $clientCR_E2=$clientCR1_N2+$clientCR2_N2;
      $persl_EP=$persl1_N1+$persl2_N1;
      $persl_E2=$persl1_N2+$persl2_N2;
      $etat_EP=$etat1_N1+$etat2_N1;
      $etat_E2=$etat1_N2+$etat2_N2;
      $comptAss_EP=$comptAss1_N1+$comptAss2_N1;
      $comptAss_E2=$comptAss1_N2+$comptAss2_N2;
      $autresDebit_EP=$autresDebit1_N1+$autresDebit2_N1;
      $autresDebit_E2=$autresDebit1_N2+$autresDebit2_N2;
      $comptRegAct_EP=$comptRegAct1_N1+$comptRegAct2_N1;
      $comptRegAct_E2=$comptRegAct1_N2+$comptRegAct2_N2;
      $titreValPlace_EP=$titreValPlace1_N1+$titreValPlace2_N1;
      $titreValPlace_E2=$titreValPlace1_N2+$titreValPlace2_N2;
      $ecratConverAct_EP=$ecratConverAct1_N1;
      $ecratConverAct_E2=$ecratConverAct1_N2;
      $chqValEnc_EP=$chqValEnc1_N1+$chqValEnc2_N1;
      $chqValEnc_E2=$chqValEnc1_N2+$chqValEnc2_N2;
      $banqTGCP_EP=$banqTGCP1_N1+$banqTGCP2_N1;
      $banqTGCP_E2=$banqTGCP1_N2+$banqTGCP2_N2;
      $caissRegAv_EP=$caissRegAv1_N1+$caissRegAv2_N1;
      $caissRegAv_E2=$caissRegAv1_N2+$caissRegAv2_N2;
      

      

      // Calcule Amort et porv pour les elements qui ont deux numero de compte a calculer
      $immReche_AP=-$immReche_AP1-$immReche_AP2;       
      $BMD_AP=-$BMD_AP1-$BMD_AP2;    
      $fondsC_AP=-$fondsC_AP1-$fondsC_AP2;  
      $autresImmoInc_AP=-$autresImmoInc_AP1-$autresImmoInc_AP2;      
      $terrains_AP=-$terrains_AP1-$terrains_AP2;     
      $cons_AP=-$cons_AP1-$cons_AP2;      
      $instalTechMat_AP=-$instalTechMat_AP1-$instalTechMat_AP2;        
      $matTransp_AP=-$matTransp_AP1-$matTransp_AP2;       
      $mobMatAmenag_AP=-$mobMatAmenag_AP1-$mobMatAmenag_AP2;      
      $autresImmoCor_AP=-$autresImmoCor_AP1-$autresImmoCor_AP2; 
      $immCorEnCours_AP=-$immCorEnCours_AP1-$immCorEnCours_AP2;
      

      // Calcule Total IMMOBILISATION EN NON VALEUR brut/amort and prov/net/Exercice pre/Exercice n-2
      $immNonVal_B=$fraisP_B+$chargesR_B+$primesR_B;
      $immNonVal_AP=$fraisP_AP+$chargesR_AP+$primesR_AP;
      $immNonVal_net=($fraisP_B-($fraisP_AP*-1))+($chargesR_B-($chargesR_AP*-1))+($primesR_B-($primesR_AP*-1));
      $immNonVal_EP=$fraisP_EP+$chargesR_EP+$primesR_EP;
      $immNonVal_E2=$fraisP_E2+$chargesR_E2+$primesR_E2;

      // Calcule Total IMMOBILISATIONS INCORPORELLES brut/amort and prov/net/Exercice pre/Exercice n-2
      $immIncor_B=$immReche_B+$BMD_B+$fondsC_B+$autresImmoInc_B;
      $immIncor_AP=$immReche_AP+$BMD_AP+$fondsC_AP+$autresImmoInc_AP;
      $immIncor_net=($immReche_B-($immReche_AP*-1))+($BMD_B-($BMD_AP*-1))+($autresImmoInc_B-($autresImmoInc_AP*-1));
      $immIncor_EP=$immReche_EP+$BMD_EP+$autresImmoInc_EP;
      $immIncor_E2=$immReche_E2+$BMD_E2+$autresImmoInc_E2;
      
      // Calcule Total IMMOBILISATIONS_CORPORELLES brut/amort and prov/net/Exercice pre/Exercice n-2
      $immCor_B=$terrains_B+$cons_B+$instalTechMat_B+$matTransp_B+$mobMatAmenag_B+$autresImmoCor_B+$immCorEnCours_B;
      $immCor_AP=$terrains_AP+$cons_B+$instalTechMat_AP+$matTransp_AP+$mobMatAmenag_AP+$autresImmoCor_AP+$immCorEnCours_AP;
      $immCor_net=($terrains_B-($terrains_AP*-1))+($cons_B-($cons_AP*-1))+($instalTechMat_B-($instalTechMat_AP*-1))+($matTransp_B-($matTransp_AP*-1))+
      ($mobMatAmenag_B-($mobMatAmenag_AP*-1))+($autresImmoCor_B-($autresImmoCor_AP*-1))+($immCorEnCours_B-($immCorEnCours_AP*-1));
      $immCor_EP=$terrains_EP+$cons_EP+$instalTechMat_EP+$matTransp_EP+$mobMatAmenag_EP+$autresImmoCor_EP+$immCorEnCours_EP;
      $immCor_E2=$terrains_E2+$cons_E2+$instalTechMat_E2+$matTransp_E2+$mobMatAmenag_E2+$autresImmoCor_E2+$immCorEnCours_E2;

      // Calcule Total IMMOBILISATIONS FINANCIERES brut/amort and prov/net/Exercice pre/Exercice n-2
      $immFin_B=$pretsImm_B+$autresCreFin_B+$titresP_B+$autresTitrImm_B;
      $immFin_AP=$pretsImm_AP+$autresCreFin_AP+$titresP_AP+$autresTitrImm_AP;
      $immFin_net=($pretsImm_B-($pretsImm_AP*-1))+($autresCreFin_B-($autresCreFin_AP*-1))+($titresP_B-($titresP_AP*-1))+($autresTitrImm_B-($autresTitrImm_AP*-1));
      $immFin_EP=$pretsImm_EP+$autresCreFin_EP+$titresP_EP+$autresTitrImm_EP;
      $immFin_E2=$pretsImm_E2+$autresCreFin_E2+$titresP_E2+$autresTitrImm_E2;

      // Calcule Total ECARTS DE CONVERSION - ACTIF brut/amort and prov/net/Exercice pre/Exercice n-2
      $ecratsConv_B=$dimCreImm_B+$augDetFinc_B;
      $ecratsConv_net=($dimCreImm_B-0)+($augDetFinc_B-0);
      $ecratsConv_EP=$dimCreImm_EP+$augDetFinc_EP;
      $ecratsConv_E2=$dimCreImm_E2+$augDetFinc_E2;

      // TOTAL  I   ( a + b + c + d + e )
      $total1_B=$immNonVal_B+$immIncor_B+$immCor_B+$immFin_B+$ecratsConv_B;
      $total1_AP=$immNonVal_AP+$immIncor_AP+$immCor_AP+$immFin_AP;
      $taotal1_net=$immNonVal_net+$immIncor_net+$immCor_net+$immFin_net+$ecratsConv_net;
      $taotal1_EP=$immNonVal_EP+$immIncor_EP+$immCor_EP+$immFin_EP+$ecratsConv_EP;
      $taotal1_E2=$immNonVal_E2+$immIncor_E2+$immCor_E2+$immFin_E2+$ecratsConv_E2;

      // Calcule Total STOCKS brut/amort and prov/net/Exercice pre/Exercice n-2
      $stocks_B=$march_B+$matFournCon_B+$prodC_B+$prodIntrProd_B+$prodFinis_B;
      $stocks_AP=$march_AP+$matFournCon_AP+$prodC_AP+$prodIntrProd_AP+$prodFinis_AP;
      $stocks_net=($march_B-($march_AP*-1))+($matFournCon_B-($matFournCon_AP*-1))+($prodC_B-($prodC_AP*-1))+($prodIntrProd_B-($prodIntrProd_AP*-1))+($prodFinis_B-($prodFinis_AP*-1));
      $stocks_EP=$march_EP+$matFournCon_EP+$prodC_EP+$prodIntrProd_EP+$prodFinis_EP;
      $stocks_E2=$march_E2+$matFournCon_B+$prodC_B+$prodIntrProd_B+$prodFinis_B;

      // Calcule CREANCES DE L'ACTIF CIRCULANT brut/amort and prov/net/Exercice pre/Exercice n-2
      $creActifCircl_B=$persl_B+$etat_B+$comptAss_B+$autresDebit_B+$comptRegAct_B;
      $creActifCircl_AP=$persl_AP+$etat_AP+$comptAss_AP+$autresDebit_AP+$comptRegAct_AP;
      $creActifCircl_net=($persl_B-($persl_AP*-1))+($etat_B-($etat_AP*-1))+($comptAss_B-($comptAss_AP*-1))+($autresDebit_B-($autresDebit_AP*-1))+($comptRegAct_B-($comptRegAct_AP*-1));
      $creActifCircl_EP=$persl_EP+$etat_EP+$comptAss_EP+$autresDebit_EP+$comptRegAct_EP;
      $creActifCircl_E2=$persl_E2+$etat_E2+$comptAss_E2+$autresDebit_E2+$comptRegAct_E2;

      //Calcule TOTAL  II   (  f + g + h + i )
      $ecratConverAct_AP=($ecratConverAct_B-0);
      $total2_B=$stocks_B+$creActifCircl_B+$titreValPlace_B+$ecratConverAct_B;
      $total2_AP=$stocks_AP+$creActifCircl_AP+$titreValPlace_AP+$ecratConverAct_AP;
      $total2_net=$stocks_net+$creActifCircl_net+($titreValPlace_B-($titreValPlace_AP*-1))+$ecratConverAct_AP;
      $total2_EP=$stocks_EP+$creActifCircl_EP+$titreValPlace_EP+$ecratConverAct_EP;
      $total2_E2=$stocks_E2+$creActifCircl_E2+$titreValPlace_E2+$ecratConverAct_E2;
      
      // Calcule TRESORERIE - ACTIF
      $tresorAct_B=$chqValEnc_B+$banqTGCP_B+$caissRegAv_B;
      $tresorAct_AP=($chqValEnc_AP*-1)+($banqTGCP_AP*-1)+($caissRegAv_AP*-1);
      $tresorAct_net=($chqValEnc_B-($chqValEnc_AP*-1))+($banqTGCP_B-($banqTGCP_AP*-1))+($caissRegAv_B-($caissRegAv_AP*-1));
      $tresorAct_EP=$chqValEnc_EP+$banqTGCP_EP+$caissRegAv_EP;
      $tresorAct_E2=$chqValEnc_E2+$banqTGCP_E2+$caissRegAv_E2;

      //TOTAL  III
      $total3_B=$tresorAct_B;
      $total3_AP=$tresorAct_AP;
      $total3_net=$tresorAct_net;
      $total3_EP=$tresorAct_EP;
      $total3_E2=$tresorAct_E2;

      // TOTAL GENERAL  I+II+III
      $totalGen_B=$total1_B+$total2_B+$total3_B;
      $totalGen_AP=$total1_AP+$total2_AP+$total3_AP;
      $totalGen_net=$total1_net+$total2_net+$total3_net;
      $totalGen_EP=$total1_EP+$total2_EP+$total3_EP;
      $totalGen_E2=$total1_E2+$total2_E2+$total3_E2;
    
   }




?>