<?php

// Load Dolibarr environment
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
require_once '../functionDeclarationLaisse.php';



  // Stock Final : MBSF= Montant brut	|| PPDSF = Provision pour dépréciation	||  MNSF = Montant net
  // Stock Initial : MBSI= Montant brut	|| PPDSI = Provision pour dépréciation	||  MNSI = Montant net
  // VDSEV = Variation de stock en Valeur

  $BM_MBSF=$BM_PPDSF=$BM_MNSF=$BM_MBSI=$BM_PPDSI=$BM_MNSI=$BM_VDSEV=0;//Biens meubles
  $BEPDALEEL_MBSF= $BEPDALEEL_PPDSF= $BEPDALEEL_MNSF= $BEPDALEEL_MBSI= $BEPDALEEL_PPDSI= $BEPDALEEL_MNSI= $BEPDALEEL_VDSEV=0;//- Biens et produits destinés à la revente en l'état 
  $MP_MBSF=$MP_PPDSF=$MP_MNSF=$MP_MBSI=$MP_PPDSI=$MP_MNSI=$MP_VDSEV=0;//Matières premières
  $MC_MBSF=$MC_PPDSF=$MC_MNSF=$MC_MBSI=$MC_PPDSI=$MC_MNSI=$MC_VDSEV=0;//Matières consommables
  $MC_MBSF1=$MC_PPDSF1=$MC_MNSF1=$MC_MBSI1=$MC_PPDSI1=$MC_MNSI1=$MC_VDSEV1=0;
  $MC_MBSF2=$MC_PPDSF2=$MC_MNSF2=$MC_MBSI2=$MC_PPDSI2=$MC_MNSI2=$MC_VDSEV2=0;
  $MC_MBSF3=$MC_PPDSF3=$MC_MNSF3=$MC_MBSI3=$MC_PPDSI3=$MC_MNSI3=$MC_VDSEV3=0;
  $BEMPDAADPEDT_MBSF= $BEMPDAADPEDT_PPDSF= $BEMPDAADPEDT_MNSF= $BEMPDAADPEDT_MBSI= $BEMPDAADPEDT_PPDSI= $BEMPDAADPEDT_MNSI= $BEMPDAADPEDT_VDSEV=0;//- Biens et Mat. premières destinés aux activités de prod. et de transf.
  $R_MBSF= $R_PPDSF= $R_MNSF= $R_MBSI= $R_PPDSI= $R_MNSI= $R_VDSEV=0; // récupérables
  $V_MBSF=$V_PPDSF=$V_MNSF=$V_MBSI=$V_PPDSI=$V_MNSI=$V_VDSEV=0;//vendus
  $V_MBSF1=$V_MBSF2=$V_MBSI1=$V_MBSI2=0;
  $P_MBSF=$P_PPDSF=$P_MNSF=$P_MBSI=$P_PPDSI=$P_MNSI=$P_VDSEV=0;//perdus
  $E_MBSF=$E_PPDSF=$E_MNSF=$E_MBSI=$E_PPDSI=$E_MNSI=$E_VDSEV=0;//Emballage
  $TSA_MBSF=$TSA_PPDSF=$TSA_MNSF=$TSA_MBSI=$TSA_PPDSI=$TSA_MNSI=$TSA_VDSEV=0;//Total stocks approvisionnement
  $PEC_MBSF= $PEC_PPDSF= $PEC_MNSF= $PEC_MBSI= $PEC_PPDSI= $PEC_MNSI= $PEC_VDSEV=0;//- Produits en cours
  $PEC_MBSF1=$PEC_MBSF2=$PEC_MBSF3=$PEC_MBSF4= $PEC_MBSI1=$PEC_MBSI2=$PEC_MBSI3=$PEC_MBSI4=0;
  $PEC_PPDSF1= $PEC_PPDSF2= $PEC_PPDSF3= $PEC_PPDSF4= $PEC_PPDSI1=$PEC_PPDSI2=$PEC_PPDSI3=$PEC_PPDSI4=0;
  $EEC_MBSF=$EEC_PPDSF=$EEC_MNSF=$EEC_MBSI=$EEC_PPDSI=$EEC_MNSI=$EEC_VDSEV=0;//Etudes en cours
  $TEC_MBSF=$TEC_PPDSF=$TEC_MNSF=$TEC_MBSI=$TEC_PPDSI=$TEC_MNSI=$TEC_VDSEV=0;//Travaux en cours
  $SEC_MBSF= $SEC_PPDSF= $SEC_MNSF= $SEC_MBSI= $SEC_PPDSI= $SEC_MNSI= $SEC_VDSEV=0;//Services en cours
  $SEC_MBSF1=$SEC_MBSF2= $SEC_MBSI1=$SEC_MBSI2=0;
  $TSDE_MBSF=$TSDE_PPDSF=$TSDE_MNSF=$TSDE_MBSI=$TSDE_PPDSI=$TSDE_MNSI=$TSDE_VDSEV=0;//Total Stocks des encours
  $PF_MBSF=$PF_PPDSF=$PF_MNSF=$PF_MBSI=$PF_PPDSI=$PF_MNSI=$PF_VDSEV=0;//Produits finis
  $TSPEBF_MBSF=$TSPEBF_PPDSF=$TSPEBF_MNSF=$TSPEBF_MBSI=$TSPEBF_PPDSI=$TSPEBF_MNSI=$TSPEBF_VDSEV=0;//Total Stocks Produits et Biens Finis
  $D_MBSF=$D_PPDSF=$D_MNSF=$D_MBSI=$D_PPDSI=$D_MNSI=$D_VDSEV=0;//Déchets
  $RE_MBSF=$RE_PPDSF=$RE_MNSF=$RE_MBSI=$RE_PPDSI=$RE_MNSI=$RE_VDSEV=0;//Rebuts
  $MDR_MBSF=$MDR_PPDSF=$MDR_MNSF=$MDR_MBSI=$MDR_PPDSI=$MDR_MNSI=$MDR_VDSEV=0;//Matières de récupération
  $TSPR_MBSF=$TSPR_PPDSF=$TSPR_MNSF=$TSPR_MBSI=$TSPR_PPDSI=$TSPR_MNSI=$TSPR_VDSEV=0;//Total Stocks Produits résiduels
  $TGL_MBSF=$TGL_PPDSF=$TGL_MNSF=$TGL_MBSI=$TGL_PPDSI=$TGL_MNSI=$TGL_VDSEV=0;//TOTAL GENERAL (Ligne 10+15+18+22)
  
  

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

      case "311":list($BM_MBSF, $BM_MBSI)=calculateMontant($dateCreation, $dateChoisis, $BM_MBSF,$BM_MBSI, 0,'311');break;
      case "3911":list($BM_PPDSF, $BM_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $BM_PPDSF,$BM_PPDSI, 0,'3911');break;
      case "3121":list($MP_MBSF, $MP_MBSI)=calculateMontant($dateCreation, $dateChoisis, $MP_MBSF,$MP_MBSI, 0,'3121');break;
      case "3911":list($MP_PPDSF, $MP_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $MP_PPDSF,$MP_PPDSI, 0,'3911');break;
      case "3911":list($MP_PPDSF, $MP_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $MP_PPDSF,$MP_PPDSI, 0,'3911');break;
      case "3122":list($MC_MBSF1, $MC_MBSI1)=calculateMontant($dateCreation, $dateChoisis, $MC_MBSF1,$MC_MBSI1, 0,'3122');break;
      case "3126":list($MC_MBSF2, $MC_MBSI2)=calculateMontant($dateCreation, $dateChoisis, $MC_MBSF2,$MC_MBSI2, 0,'3126');break;
      case "3128":list($MC_MBSF3, $MC_MBSI3)=calculateMontant($dateCreation, $dateChoisis, $MC_MBSF3,$MC_MBSI3, 0,'3128');break;
      case "39122":list($MC_PPDSF1, $MC_PPDSI1)=calculateMontant($dateCreation, $dateChoisis, $MC_PPDSF1,$MC_PPDSI1, 0,'39122');break;
      case "39126":list($MC_PPDSF2, $MC_PPDSI2)=calculateMontant($dateCreation, $dateChoisis, $MC_PPDSF2,$MC_PPDSI2, 0,'39126');break;
      case "39128":list($MC_PPDSF3, $MC_PPDSI3)=calculateMontant($dateCreation, $dateChoisis, $MC_PPDSF3,$MC_PPDSI3, 0,'39128');break;
      case "31232":list($R_MBSF, $R_MBSI)=calculateMontant($dateCreation, $dateChoisis, $R_MBSF,$R_MBSI, 0,'31232');break;
      case "391232":list($R_PPDSF, $R_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $R_PPDSF,$R_PPDSI, 0,'391232');break;
      case "31233":list($V_MBSF1, $V_MBSI1)=calculateMontant($dateCreation, $dateChoisis, $V_MBSF1,$V_MBSI1, 0,'31233');break;
      case "3173":list($V_MBSF2, $V_MBSI2)=calculateMontant($dateCreation, $dateChoisis, $V_MBSF2,$V_MBSI2, 0,'3173');break;
      case "39126":list($V_PPDSF, $V_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $V_PPDSF,$V_PPDSI, 0,'39126');break;
      case "31231":list($P_MBSF, $P_MBSI)=calculateMontant($dateCreation, $dateChoisis, $P_MBSF,$P_MBSI, 0,'31231');break;
      case "391231":list($P_PPDSF, $P_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $P_PPDSF,$P_PPDSI, 0,'391231');break;
      case "3131":list($PEC_MBSF1, $PEC_MBSI1)=calculateMontant($dateCreation, $dateChoisis, $PEC_MBSF1,$PEC_MBSI1, 0,'3131');break;
      case "3138":list($PEC_MBSF2, $PEC_MBSI2)=calculateMontant($dateCreation, $dateChoisis, $PEC_MBSF2,$PEC_MBSI2, 0,'3138');break;
      case "3141":list($PEC_MBSF3, $PEC_MBSI3)=calculateMontant($dateCreation, $dateChoisis, $PEC_MBSF3,$PEC_MBSI3, 0,'3141');break;
      case "3148":list($PEC_MBSF4, $PEC_MBSI4)=calculateMontant($dateCreation, $dateChoisis, $PEC_MBSF4,$PEC_MBSI4, 0,'3148');break;
      case "39131":list($PEC_PPDSF1, $PEC_PPDSI1)=calculateMontant($dateCreation, $dateChoisis, $PEC_PPDSF1,$PEC_PPDSI1, 0,'39131');break;
      case "39138":list($PEC_PPDSF2, $PEC_PPDSI2)=calculateMontant($dateCreation, $dateChoisis, $PEC_PPDSF2,$PEC_PPDSI2, 0,'39138');break;
      case "39141":list($PEC_PPDSF3, $PEC_PPDSI3)=calculateMontant($dateCreation, $dateChoisis, $PEC_PPDSF3,$PEC_PPDSI3, 0,'39141');break;
      case "39148":list($PEC_PPDSF4, $PEC_PPDSI4)=calculateMontant($dateCreation, $dateChoisis, $PEC_PPDSF4,$PEC_PPDSI4, 0,'39148');break;
      case "31342":list($EEC_MBSF, $EEC_MBSI)=calculateMontant($dateCreation, $dateChoisis, $EEC_MBSF,$EEC_MBSI, 0,'31342');break;
      case "391342":list($EEC_PPDSF, $EEC_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $EEC_PPDSF,$EEC_PPDSI, 0,'391342');break;
      case "31341":list($TEC_MBSF, $TEC_MBSI)=calculateMontant($dateCreation, $dateChoisis, $TEC_MBSF,$TEC_MBSI, 0,'31341');break;
      case "391341":list($TEC_PPDSF, $TEC_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $TEC_PPDSF,$TEC_PPDSI, 0,'391341');break;
      case "3134":list($SEC_MBSF1, $SEC_MBSI1)=calculateMontant($dateCreation, $dateChoisis, $SEC_MBSF1,$SEC_MBSI1, 0,'3134');break;
      case "31343":list($SEC_MBSF2, $SEC_MBSI2)=calculateMontant($dateCreation, $dateChoisis, $SEC_MBSF2,$SEC_MBSI2, 0,'31343');break;
      case "391343":list($SEC_PPDSF, $SEC_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $SEC_PPDSF,$SEC_PPDSI, 0,'391343');break;
      case "315":list($PF_MBSF, $PF_MBSI)=calculateMontant($dateCreation, $dateChoisis, $PF_MBSF,$PF_MBSI, 0,'315');break;
      case "3915":list($PF_PPDSF, $PF_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $PF_PPDSF,$PF_PPDSI, 0,'3915');break;
      case "31451":list($D_MBSF, $D_MBSI)=calculateMontant($dateCreation, $dateChoisis, $D_MBSF,$D_MBSI, 0,'31451');break;
      case "391451":list($D_PPDSF, $D_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $D_PPDSF,$D_PPDSI, 0,'391451');break;
      case "31452":list($RE_MBSF, $RE_MBSI)=calculateMontant($dateCreation, $dateChoisis, $RE_MBSF,$RE_MBSI, 0,'31452');break;
      case "391452":list($RE_PPDSF, $RE_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $RE_PPDSF,$RE_PPDSI, 0,'391452');break;
      case "31453":list($MDR_MBSF, $MDR_MBSI)=calculateMontant($dateCreation, $dateChoisis, $MDR_MBSF,$MDR_MBSI, 0,'31453');break;
      case "391453":list($MDR_PPDSF, $MDR_PPDSI)=calculateMontant($dateCreation, $dateChoisis, $MDR_PPDSF,$MDR_PPDSI, 0,'391453');break;
      
    }

    $BM_MNSF=$BM_MBSF-$BM_PPDSF;
    $BM_MNSI=$BM_MBSI-$BM_PPDSI;
    $BM_VDSEV= $BM_MNSI- $BM_MNSF;
    $BEPDALEEL_MBSF=  $BM_MBSF;
    $BEPDALEEL_PPDSF=$BM_PPDSF;
    $BEPDALEEL_MNSF= $BM_MNSF;
    $BEPDALEEL_MBSI= $BM_MBSI;
    $BEPDALEEL_PPDSI= $BM_PPDSI;
    $BEPDALEEL_MNSI=$BM_MNSI;
    $BEPDALEEL_VDSEV=$BM_VDSEV;
    $MP_MNSF= $MP_MBSF-$MP_PPDSF;
    $MP_MNSI=$MP_MBSI-$MP_PPDSI;
    $MP_VDSEV=$MP_MNSI-$MP_MNSF;
    $MC_MBSF = $MC_MBSF1 + $MC_MBSF2 + $MC_MBSF3;
    $MC_MBSI = $MC_MBSI1 + $MC_MBSI2 + $MC_MBSI3;
    $MC_PPDSF=(-$MC_PPDSF1-$MC_PPDSF2-$MC_PPDSF3);
    $MC_PPDSI=(-$MC_PPDSI1-$MC_PPDSI2-$MC_PPDSI3);
    $MC_MNSF=$MC_MBSF-$MC_PPDSF;
    $MC_MNSI=$MC_MBSI-$MC_PPDSI;
    $MC_VDSEV=$MC_MNSI-$MC_MNSF;
    $BEMPDAADPEDT_MBSF=$MP_MBSF+$MC_MBSF;
    $BEMPDAADPEDT_PPDSF=$MP_PPDSF+$MC_PPDSF;
    $BEMPDAADPEDT_MNSF=$MP_MNSF+$MC_MNSF;
    $BEMPDAADPEDT_MBSI=$MP_MBSI+$MC_MBSI;
    $BEMPDAADPEDT_PPDSI=$MP_PPDSI+$MC_PPDSI;
    $BEMPDAADPEDT_MNSI=$MP_MNSI+$MC_MNSI;
    $BEMPDAADPEDT_VDSEV=$MP_VDSEV+$MC_VDSEV;
    $R_MNSF=$R_MBSF - $R_PPDSF;
    $R_MNSI=$R_MBSI - $R_PPDSI;
    $R_VDSEV= $R_MNSI-$R_MNSF; 
    $V_MBSF=$V_MBSF1+$V_MBSF2;
    $V_MBSI=$V_MBSI1+$V_MBSI2;
    $V_MNSF=$V_MBSF-$V_PPDSF;
    $V_MNSI=$V_MBSI-$V_PPDSI;
    $V_VDSEV=$V_MNSI-$V_MNSF;
    $P_MNSF=$P_MBSF-$P_PPDSF;
    $P_MNSI=$P_MBSI-$P_PPDSI;
    $P_VDSEV= $P_MNSI-$P_MNSF;
    $E_MBSF=$R_MBSF+$V_MBSF+$P_MBSF;
    $E_PPDSF=$R_PPDSF+$V_PPDSF+$P_PPDSF;
    $E_MNSF=$R_MNSF+$V_MNSF+$P_MNSF;
    $E_MBSI=$R_MBSI+$V_MBSI+$P_MBSI;
    $E_PPDSI=$R_PPDSI+$V_PPDSI+$P_PPDSI;
    $E_MNSI=$R_MNSI+$V_MNSI+$P_MNSI;
    $E_VDSEV=$R_VDSEV+$V_VDSEV+$P_VDSEV;
    $TSA_MBSF=$R_MBSF+$V_MBSF+ $P_MBSF+ $BM_MBSF+ $MP_MBSF+$MC_MBSF;
    $TSA_PPDSF=$R_PPDSF+$V_PPDSF+$P_PPDSF+$BM_PPDSF+$MP_PPDSF+$MC_PPDSF;
    $TSA_MNSF=$R_MNSF+ $V_MNSF+ $P_MNSF+$BM_MNSF+$MP_MNSF+$MC_MNSF;
    $TSA_MBSI=$R_MBSI+ $V_MBSI+$P_MBSI+$BM_MBSI+$MP_MBSI+$MC_MBSI;
    $TSA_PPDSI=$R_PPDSI+$V_PPDSI+$P_PPDSI+$BM_PPDSI+$MP_PPDSI+$MC_PPDSI;
    $TSA_MNSI=$R_MNSI+ $V_MNSI+$P_MNSI+$BM_MNSI+$MP_MNSI+$MC_MNSI;
    $TSA_VDSEV=$R_VDSEV+$V_VDSEV+$P_VDSEV+$BM_VDSEV+$MP_VDSEV+$MC_VDSEV;
    $PEC_MBSF=$PEC_MBSF1+$PEC_MBSF2+$PEC_MBSF3+$PEC_MBSF4;
    $PEC_MBSI= $PEC_MBSI1+$PEC_MBSI2+$PEC_MBSI3+$PEC_MBSI4;
    $PEC_PPDSF=(-$PEC_PPDSF1-$PEC_PPDSF2- $PEC_PPDSF3- $PEC_PPDSF4);
    $PEC_PPDSI=(-$PEC_PPDSI1-$PEC_PPDSI2-$PEC_PPDSI3-$PEC_PPDSI4);
    $PEC_MNSF= $PEC_MBSF- $PEC_PPDSF;
    $PEC_MNSI=$PEC_MBSI- $PEC_PPDSI;
    $PEC_VDSEV= $PEC_MNSI-$PEC_MNSF;
    $EEC_MNSF=$EEC_MBSF-$EEC_PPDSF;
    $EEC_MNSI=$EEC_MBSI-$EEC_PPDSI;
    $EEC_VDSEV=$EEC_MNSI-$EEC_MNSF;
    $TEC_MNSF= $TEC_MBSF-$TEC_PPDSF;
    $TEC_MNSI= $TEC_MBSI-$TEC_PPDSI;
    $TEC_VDSEV=$TEC_MNSI- $TEC_MNSF;  
    $SEC_MBSF=$SEC_MBSF1-$SEC_MBSF2;
    $SEC_MBSI=$SEC_MBSI1-$SEC_MBSI2;
    $SEC_MNSF=$SEC_MBSF- $SEC_PPDSF;
    $SEC_MNSI= $SEC_MBSI-$SEC_PPDSI;
    $SEC_VDSEV=$SEC_MNSI-$SEC_MNSF;
    $TSDE_MBSF=$EEC_MBSF+ $TEC_MBSF+$SEC_MBSF;
    $TSDE_PPDSF=$EEC_PPDSF+$TEC_PPDSF+$SEC_PPDSF;
    $TSDE_MNSF=$EEC_MNSF+$TEC_MNSF+ $SEC_MNSF;
    $TSDE_MBSI=$EEC_MBSI+$TEC_MBSI+$SEC_MBSI;
    $TSDE_PPDSI=$EEC_PPDSI+$TEC_PPDSI+$SEC_PPDSI;
    $TSDE_MNSI=$EEC_MNSI+$TEC_MNSI+$SEC_MNSI;
    $TSDE_VDSEV=$EEC_VDSEV+$TEC_VDSEV+ $SEC_VDSEV;
    $PF_MNSF= $PF_MBSF-$PF_PPDSF;
    $PF_MNSI= $PF_MBSI-$PF_PPDSI;
    $PF_VDSEV=$PF_MNSI-$PF_MNSF;
    $TSPEBF_MBSF= $PF_MBSF;
    $TSPEBF_PPDSF=$PF_PPDSF;
    $TSPEBF_MNSF=$PF_MNSF;
    $TSPEBF_MBSI=$PF_MBSI;
    $TSPEBF_PPDSI=$PF_PPDSI;
    $TSPEBF_MNSI=$PF_MNSI;
    $TSPEBF_VDSEV=$PF_VDSEV;
    $D_MNSF= $D_MBSF-$D_PPDSF;
    $D_MNSI=$D_MBSI-$D_PPDSI;
    $D_VDSEV=$D_MNSI-$D_MNSF;
    $RE_MNSF= $RE_MBSF-$RE_PPDSF;
    $RE_MNSI= $RE_MBSI-$RE_PPDSI;
    $RE_VDSEV=$RE_MNSI-$RE_MNSF;
    $MDR_MNSF= $MDR_MBSF-$MDR_PPDSF;
    $MDR_MNSI=$MDR_MBSI-$MDR_PPDSI;
    $MDR_VDSEV=$MDR_MNSI-$MDR_MNSF;
    $TSPR_MBSF=$D_MBSF+$RE_MBSF+$MDR_MBSF;
    $TSPR_PPDSF=$D_PPDSF+$RE_PPDSF+$MDR_PPDSF;
    $TSPR_MNSF=$D_MNSF+$RE_MNSF+$MDR_MNSF;
    $TSPR_MBSI=$D_MBSI+$RE_MBSI+$MDR_MBSI;
    $TSPR_PPDSI=$D_PPDSI+$RE_PPDSI+$MDR_PPDSI;
    $TSPR_MNSI=$D_MNSI+$RE_MNSI+$MDR_MNSI;
    $TSPR_VDSEV=$D_VDSEV+$RE_VDSEV+$MDR_VDSEV;
    $TGL_MBSF=$TSA_MBSF+$TSDE_MBSF+ $TSPEBF_MBSF+$TSPR_MBSF;
    $TGL_PPDSF=$TSA_PPDSF+$TSDE_PPDSF+$TSPEBF_PPDSF+$TSPR_PPDSF;
    $TGL_MNSF=$TSA_MNSF+$TSDE_MNSF+$TSPEBF_MNSF+$TSPR_MNSF;
    $TGL_MBSI=$TSA_MBSI+$TSDE_MBSI+$TSPEBF_MBSI+$TSPR_MBSI;
    $TGL_PPDSI=$TSA_PPDSI+$TSDE_PPDSI+$TSPEBF_PPDSI+$TSPR_PPDSI;
    $TGL_MNSI=$TSA_MNSI+$TSDE_MNSI+$TSPEBF_MNSI+$TSPR_MNSI;
    $TGL_VDSEV=$TSA_VDSEV+$TSDE_VDSEV+$TSPEBF_VDSEV+$TSPR_VDSEV;
      

  
  }
  if(isset($_POST['chargement']))
  {
    $data = "<?php ";
    $data .= '$BM_MBSF = ' . $BM_MBSF . ";\n";
    $data .= '$BM_MBSI = ' . $BM_MBSI . ";\n";
    $data .= '$BM_PPDSF = ' . ($BM_PPDSF*-1) . ";\n";
    $data .= '$BM_PPDSI = ' . ($BM_PPDSI*-1) . ";\n";
    $data .= '$BM_MNSF = ' . ($BM_MNSF) . ";\n";
    $data .= '$BM_MNSI = ' . ($BM_MNSI) . ";\n";
    $data .= '$BM_VDSEV = ' . $BM_VDSEV . ";\n";
    $data .= '$BEPDALEEL_MBSF = ' . ($BEPDALEEL_MBSF) . ";\n";
    $data .= '$BEPDALEEL_PPDSF = ' . ($BEPDALEEL_PPDSF) . ";\n";
    $data .= '$BEPDALEEL_MNSF = ' . $BEPDALEEL_MNSF . ";\n";
    $data .= '$BEPDALEEL_MBSI = ' . ($BEPDALEEL_MBSI) . ";\n";
    $data .= '$BEPDALEEL_PPDSI = ' . ($BEPDALEEL_PPDSI) . ";\n";
    $data .= '$BEPDALEEL_MNSI = ' . $BEPDALEEL_MNSI . ";\n";
    $data .= '$BEPDALEEL_VDSEV = ' . ($BEPDALEEL_VDSEV) . ";\n";
    $data .= '$MP_MBSF = ' . ($MP_MBSF) . ";\n";
    $data .= '$MP_MBSI = ' . ($MP_MBSI) . ";\n";
    $data .= '$MP_PPDSF = ' . ($MP_PPDSF*-1) . ";\n";
    $data .= '$MP_PPDSI = ' . ($MP_PPDSI*-1) . ";\n";
    $data .= '$MP_MNSF = ' . ($MP_MNSF) . ";\n";
    $data .= '$MP_MNSI = ' . $MP_MNSI . ";\n";
    $data .= '$MP_VDSEV = ' . ($MP_VDSEV) . ";\n";
    $data .= '$MC_MBSF = ' . ($MC_MBSF) . ";\n";
    $data .= '$MC_MBSI = ' . ($MC_MBSI) . ";\n";
    $data .= '$MC_PPDSF = ' . ($MC_PPDSF) . ";\n";
    $data .= '$MC_PPDSI = ' . ($MC_PPDSI) . ";\n";
    $data .= '$MC_MNSF = ' . ($MC_MNSF) . ";\n";
    $data .= '$MC_MNSI = ' . $MC_MNSI . ";\n";
    $data .= '$MC_VDSEV = ' . ($MC_VDSEV) . ";\n";
    $data .= '$BEMPDAADPEDT_MBSF = ' . ($BEMPDAADPEDT_MBSF) . ";\n";
    $data .= '$BEMPDAADPEDT_PPDSF = ' . ($BEMPDAADPEDT_PPDSF) . ";\n";
    $data .= '$BEMPDAADPEDT_MNSF = ' . ($BEMPDAADPEDT_MNSF) . ";\n";
    $data .= '$BEMPDAADPEDT_MBSI = ' . ($BEMPDAADPEDT_MBSI) . ";\n";
    $data .= '$BEMPDAADPEDT_PPDSI = ' . ($BEMPDAADPEDT_PPDSI) . ";\n";
    $data .= '$BEMPDAADPEDT_MNSI = ' . $BEMPDAADPEDT_MNSI . ";\n";
    $data .= '$BEMPDAADPEDT_VDSEV = ' . ($BEMPDAADPEDT_VDSEV) . ";\n";
    $data .= '$R_MBSF = ' . ($R_MBSF) . ";\n";
    $data .= '$R_MBSI = ' . ($R_MBSI) . ";\n";
    $data .= '$R_PPDSI = ' . ($R_PPDSI*-1) . ";\n";
    $data .= '$R_PPDSF = ' . ($R_PPDSF*-1) . ";\n";
    $data .= '$R_MNSF = ' . ($R_MNSF) . ";\n";
    $data .= '$R_MNSI = ' . $R_MNSI . ";\n";
    $data .= '$R_VDSEV = ' . ($R_VDSEV) . ";\n";
    $data .= '$V_MBSF = ' . ($V_MBSF) . ";\n";
    $data .= '$V_MBSI = ' . ($V_MBSI) . ";\n";
    $data .= '$V_PPDSF = ' . ($V_PPDSF) . ";\n";
    $data .= '$V_PPDSI = ' . ($V_PPDSI) . ";\n";
    $data .= '$V_MNSF = ' . ($V_MNSF) . ";\n";
    $data .= '$V_MNSI = ' . $V_MNSI . ";\n";
    $data .= '$V_VDSEV = ' . ($V_VDSEV) . ";\n";
    $data .= '$P_MBSF = ' . ($P_MBSF) . ";\n";
    $data .= '$P_MBSI = ' . ($P_MBSI) . ";\n";
    $data .= '$P_PPDSF = ' . ($P_PPDSF*-1) . ";\n";
    $data .= '$P_PPDSI = ' . ($P_PPDSI*-1) . ";\n";
    $data .= '$P_MNSF = ' . ($P_MNSF) . ";\n";
    $data .= '$P_MNSI = ' . $P_MNSI . ";\n";
    $data .= '$P_VDSEV = ' . ($P_VDSEV) . ";\n";
    $data .= '$E_MBSF = ' . ($E_MBSF) . ";\n";
    $data .= '$E_PPDSF = ' . ($E_PPDSF) . ";\n";
    $data .= '$E_MNSF = ' . ($E_MNSF) . ";\n";
    $data .= '$E_MBSI = ' . ($E_MBSI) . ";\n";
    $data .= '$E_PPDSI = ' . ($E_PPDSI) . ";\n";
    $data .= '$E_MNSI = ' . $E_MNSI . ";\n";
    $data .= '$E_VDSEV = ' . ($E_VDSEV) . ";\n";
    $data .= '$TSA_MBSF = ' . ($TSA_MBSF) . ";\n";
    $data .= '$TSA_PPDSF = ' . ($TSA_PPDSF) . ";\n";
    $data .= '$TSA_MNSF = ' . ($TSA_MNSF) . ";\n";
    $data .= '$TSA_MBSI = ' . ($TSA_MBSI) . ";\n";
    $data .= '$TSA_PPDSI = ' . ($TSA_PPDSI) . ";\n";
    $data .= '$TSA_MNSI = ' . $TSA_MNSI . ";\n";
    $data .= '$TSA_VDSEV = ' . ($TSA_VDSEV) . ";\n";
    $data .= '$PEC_MBSF = ' . ($PEC_MBSF) . ";\n";
    $data .= '$PEC_MBSI = ' . ($PEC_MBSI) . ";\n";
    $data .= '$PEC_PPDSF = ' . ($PEC_PPDSF) . ";\n";
    $data .= '$PEC_PPDSI = ' . ($PEC_PPDSI) . ";\n";
    $data .= '$PEC_MNSF = ' . ($PEC_MNSF) . ";\n";
    $data .= '$PEC_MNSI = ' . $PEC_MNSI . ";\n";
    $data .= '$PEC_VDSEV = ' . ($PEC_VDSEV) . ";\n";
    $data .= '$EEC_MBSF = ' . ($EEC_MBSF) . ";\n";
    $data .= '$EEC_MBSI = ' . ($EEC_MBSI) . ";\n";
    $data .= '$EEC_PPDSF = ' . ($EEC_PPDSF*-1) . ";\n";
    $data .= '$EEC_PPDSI = ' . ($EEC_PPDSI*-1) . ";\n";
    $data .= '$EEC_MNSF = ' . ($EEC_MNSF) . ";\n";
    $data .= '$EEC_MNSI = ' . $EEC_MNSI . ";\n";
    $data .= '$EEC_VDSEV = ' . ($EEC_VDSEV) . ";\n";
    $data .= '$TEC_MBSF = ' . ($TEC_MBSF) . ";\n";
    $data .= '$TEC_MBSI = ' . ($TEC_MBSI) . ";\n";
    $data .= '$TEC_PPDSF = ' . ($TEC_PPDSF*-1) . ";\n";
    $data .= '$TEC_PPDSI = ' . ($TEC_PPDSI*-1) . ";\n";
    $data .= '$TEC_MNSF = ' . ($TEC_MNSF) . ";\n";
    $data .= '$TEC_MNSI = ' . $TEC_MNSI . ";\n";
    $data .= '$TEC_VDSEV = ' . ($TEC_VDSEV) . ";\n";
    $data .= '$SEC_MBSF = ' . ($SEC_MBSF) . ";\n";
    $data .= '$SEC_MBSI = ' . ($SEC_MBSI) . ";\n";
    $data .= '$SEC_PPDSF = ' . ($SEC_PPDSF*-1) . ";\n";
    $data .= '$SEC_PPDSI = ' . ($SEC_PPDSI*-1) . ";\n";
    $data .= '$SEC_MNSF = ' . ($SEC_MNSF) . ";\n";
    $data .= '$SEC_MNSI = ' . $SEC_MNSI . ";\n";
    $data .= '$SEC_VDSEV = ' . ($SEC_VDSEV) . ";\n";
    $data .= '$TSDE_MBSF = ' . ($TSDE_MBSF) . ";\n";
    $data .= '$TSDE_PPDSF = ' . ($TSDE_PPDSF) . ";\n";
    $data .= '$TSDE_MNSF = ' . ($TSDE_MNSF) . ";\n";
    $data .= '$TSDE_MBSI = ' . ($TSDE_MBSI) . ";\n";
    $data .= '$TSDE_PPDSI = ' . ($TSDE_PPDSI) . ";\n";
    $data .= '$TSDE_MNSI = ' . $TSDE_MNSI . ";\n";
    $data .= '$TSDE_VDSEV = ' . ($TSDE_VDSEV) . ";\n";
    $data .= '$PF_MBSF = ' . ($PF_MBSF) . ";\n";
    $data .= '$PF_MBSI = ' . ($PF_MBSI) . ";\n";
    $data .= '$PF_PPDSF = ' . ($PF_PPDSF*-1) . ";\n";
    $data .= '$PF_PPDSI = ' . ($PF_PPDSI*-1) . ";\n";
    $data .= '$PF_MNSF = ' . ($PF_MNSF) . ";\n";
    $data .= '$PF_MNSI = ' . $PF_MNSI . ";\n";
    $data .= '$PF_VDSEV = ' . ($PF_VDSEV) . ";\n";
    $data .= '$TSPEBF_MBSF = ' . ($TSPEBF_MBSF) . ";\n";
    $data .= '$TSPEBF_PPDSF = ' . ($TSPEBF_PPDSF) . ";\n";
    $data .= '$TSPEBF_MNSF = ' . ($TSPEBF_MNSF) . ";\n";
    $data .= '$TSPEBF_MBSI = ' . ($TSPEBF_MBSI) . ";\n";
    $data .= '$TSPEBF_PPDSI = ' . ($TSPEBF_PPDSI) . ";\n";
    $data .= '$TSPEBF_MNSI = ' . $TSPEBF_MNSI . ";\n";
    $data .= '$TSPEBF_VDSEV = ' . ($TSPEBF_VDSEV) . ";\n";
    $data .= '$D_MBSF = ' . ($D_MBSF) . ";\n";
    $data .= '$D_MBSI = ' . ($D_MBSI) . ";\n";
    $data .= '$D_PPDSF = ' . ($D_PPDSF*-1) . ";\n";
    $data .= '$D_PPDSI = ' . ($D_PPDSI*-1) . ";\n";
    $data .= '$D_MNSF = ' . ($D_MNSF) . ";\n";
    $data .= '$D_MNSI = ' . $D_MNSI . ";\n";
    $data .= '$D_VDSEV = ' . ($D_VDSEV) . ";\n";
    $data .= '$RE_MBSF = ' . ($RE_MBSF) . ";\n";
    $data .= '$RE_MBSI = ' . ($RE_MBSI) . ";\n";
    $data .= '$RE_PPDSF = ' . ($RE_PPDSF*-1) . ";\n";
    $data .= '$RE_PPDSI = ' . ($RE_PPDSI*-1) . ";\n";
    $data .= '$RE_MNSF = ' . ($RE_MNSF) . ";\n";
    $data .= '$RE_MNSI = ' . $RE_MNSI . ";\n";
    $data .= '$RE_VDSEV = ' . ($RE_VDSEV) . ";\n";
    $data .= '$MDR_MBSF = ' . ($MDR_MBSF) . ";\n";
    $data .= '$MDR_MBSI = ' . ($MDR_MBSI) . ";\n";
    $data .= '$MDR_PPDSF = ' . ($MDR_PPDSF*-1) . ";\n";
    $data .= '$MDR_PPDSI = ' . ($MDR_PPDSI*-1) . ";\n";
    $data .= '$MDR_MNSF = ' . ($MDR_MNSF) . ";\n";
    $data .= '$MDR_MNSI = ' . $MDR_MNSI . ";\n";
    $data .= '$MDR_VDSEV = ' . ($MDR_VDSEV) . ";\n";
    $data .= '$TSPR_MBSF = ' . ($TSPR_MBSF) . ";\n";
    $data .= '$TSPR_PPDSF = ' . ($TSPR_PPDSF) . ";\n";
    $data .= '$TSPR_MNSF = ' . ($TSPR_MNSF) . ";\n";
    $data .= '$TSPR_MBSI = ' . ($TSPR_MBSI) . ";\n";
    $data .= '$TSPR_PPDSI = ' . ($TSPR_PPDSI) . ";\n";
    $data .= '$TSPR_MNSI = ' . $TSPR_MNSI . ";\n";
    $data .= '$TSPR_VDSEV = ' . ($TSPR_VDSEV) . ";\n";
    $data .= '$TGL_MBSF = ' . ($TGL_MBSF) . ";\n";
    $data .= '$TGL_PPDSF = ' . ($TGL_PPDSF) . ";\n";
    $data .= '$TGL_MNSF = ' . ($TGL_MNSF) . ";\n";
    $data .= '$TGL_MBSI = ' . ($TGL_MBSI) . ";\n";
    $data .= '$TGL_PPDSI = ' . ($TGL_PPDSI) . ";\n";
    $data .= '$TGL_MNSI = ' . $TGL_MNSI . ";\n";
    $data .= '$TGL_VDSEV = ' . ($TGL_VDSEV) . ";\n";



    $data .= "?>";
    // Now, the variable $year will contain the year value "2023"
    $nomFichier = 'Etatdetaillesetock_fichier_'. $dateChoisis.'.php';
    // Écrire les données dans le nouveau fichier
    file_put_contents($nomFichier, $data);

  }


        


?>