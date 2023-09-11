<?php


// Load Dolibarr environment
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
require_once '../functionDeclarationLaisse.php';


// MDE=Montant début exercice
// Dotations : DED : d'exploitation \\ FD: financières \\ NCD : non courantes
// Reprises : DER : d'exploitation \\ FR: financières \\ NCR : non courantes
// MFX=Montant fin exercice

$PPDDLI_MDE=$PPDDLI_DED=$PPDDLI_FD=$PPDDLI_NCD=$PPDDLI_DER=$PPDDLI_FR=$PPDDLI_NCR=$PPDDLI_MFX=0; //Provisions pour dépréciation de l'actif immobilisé
$PR_MDE=$PR_NCD=$PR_NCR=$PR_MFX=0;// Provisions réglementées
$PDPREC_MDE=$PDPREC_DED=$PDPREC_FD=$PDPREC_NCD=$PDPREC_DER=$PDPREC_FR=$PDPREC_NCR=$PDPREC_MFX=0;//Provisions durables pour risques et charges

$ST_MDE=$ST_DED=$ST_FD=$ST_NCD=$ST_DER=$ST_FR=$ST_NCR=$ST_MFX=0;//Sous-Total (A)

$PPDDLC_MDE=$PPDDLC_DED=$PPDDLC_FD=$PPDDLC_NCD=$PPDDLC_DER=$PPDDLC_FR=$PPDDLC_NCR=$PPDDLC_MFX=0;//Provisions pour dépréciation de l'actif circulant
$S_MDE=$S_DED=$S_NCD=$S_DER=$S_NCR=$S_MFX=0;//- Stocks
$C_MDE=$C_DED=$C_NCD=$C_DER=$C_NCR=$C_MFX=0;//Créances
$TEVDP_MDE=$TEVDP_FD=$TEVDP_FR=$TEVDP_MFX=0;//- Titres et valeurs de placement
$APPREC_MDE=$APPREC_DED=$APPREC_FD=$APPREC_NCD=$APPREC_DER=$APPREC_FR=$APPREC_NCR=$APPREC_MFX=0;//Autres Provisions pour risques et charges
$PPDDCDT_MDE=$PPDDCDT_FD=$PPDDCDT_FR=$PPDDCDT_MFX=0;//Provisions pour dépréciation des comptes de trésorerie

$STB_MDE=$STB_DED=$STB_FD=$STB_NCD=$STB_DER=$STB_FR=$STB_NCR=$STB_MFX=0;//Sous-Total (B)

$TAB_MDE=$TAB_DED=$TAB_FD=$TAB_NCD=$TAB_DER=$TAB_FR=$TAB_NCR=$TAB_MFX=0;//Total (A + B)



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
        case '29' : list($PPDDLI_MFX,$PPDDLI_MDE) = calculateMontant($dateCreation,$dateChoisis,$PPDDLI_MFX,$PPDDLI_MDE,0,'29'); break;
        case '6194' : list($PPDDLI_DED) = calculateMontant($dateCreation,$dateChoisis,$PPDDLI_DED,0,0,'6194'); break;
        case '63944' : list($PPDDLI_FD) = calculateMontant($dateCreation,$dateChoisis,$PPDDLI_FD,0,0,'63944'); break;
        case '65962' : list($PPDDLI_NCD) = calculateMontant($dateCreation,$dateChoisis,$PPDDLI_NCD,0,0,'65962'); break;
        case '7194' : list($PPDDLI_DER) = calculateMontant($dateCreation,$dateChoisis,$PPDDLI_DER,0,0,'7194'); break;
        case '7392' : list($PPDDLI_FR) = calculateMontant($dateCreation,$dateChoisis,$PPDDLI_FR,0,0,'7392'); break;
        case '75962' : list($PPDDLI_NCR) = calculateMontant($dateCreation,$dateChoisis,$PPDDLI_NCR,0,0,'75962'); break;
        case '135' : list($PR_MFX,$PR_MDE) = calculateMontant($dateCreation,$dateChoisis,$PR_MFX,$PR_MDE,0,'135'); break;
        case '6594' : list($PR_NCD) = calculateMontant($dateCreation,$dateChoisis,$PR_NCD,0,0,'6594'); break;
        case '7594' : list($PR_NCR) = calculateMontant($dateCreation,$dateChoisis,$PR_NCR,0,0,'7594'); break;
        case '15' : list($PDPREC_MFX,$PDPREC_MDE) = calculateMontant($dateCreation,$dateChoisis,$PDPREC_MFX,$PDPREC_MDE,0,'15'); break;
        case '61955' : list($PDPREC_DED) = calculateMontant($dateCreation,$dateChoisis,$PDPREC_DED,0,0,'61955'); break;
        case '63935' : list($PDPREC_FD) = calculateMontant($dateCreation,$dateChoisis,$PDPREC_FD,0,0,'63935'); break;
        case '65955' : list($PDPREC_NCD) = calculateMontant($dateCreation,$dateChoisis,$PDPREC_NCD,0,0,'65955'); break;
        case '71955' : list($PDPREC_DER) = calculateMontant($dateCreation,$dateChoisis,$PDPREC_DER,0,0,'71955'); break;
        case '73935' : list($PDPREC_FR) = calculateMontant($dateCreation,$dateChoisis,$PDPREC_FR,0,0,'73935'); break;
        case '75955' : list($PDPREC_NCR) = calculateMontant($dateCreation,$dateChoisis,$PDPREC_NCR,0,0,'75955'); break;
        case '39' : list($PPDDLC_MFX,$PPDDLC_MDE) = calculateMontant($dateCreation,$dateChoisis,$PPDDLC_MFX,$PPDDLC_MDE,0,'39'); break;
        case '6196' : list($PPDDLC_DED) = calculateMontant($dateCreation,$dateChoisis,$PPDDLC_DED,0,0,'6196'); break;
        case '6394' : list($PPDDLC_FD) = calculateMontant($dateCreation,$dateChoisis,$PPDDLC_FD,0,0,'6394'); break;
        case '65963' : list($PPDDLC_NCD) = calculateMontant($dateCreation,$dateChoisis,$PPDDLC_NCD,0,0,'65963'); break;
        case '7196' : list($PPDDLC_DER) = calculateMontant($dateCreation,$dateChoisis,$PPDDLC_DER,0,0,'7196'); break;
        case '7394' : list($PPDDLC_FR) = calculateMontant($dateCreation,$dateChoisis,$PPDDLC_FR,0,0,'7394'); break;
        case '75963' : list($PPDDLC_NCR) = calculateMontant($dateCreation,$dateChoisis,$PPDDLC_NCR,0,0,'75963'); break;
        case '391' : list($S_MFX,$S_MDE) = calculateMontant($dateCreation,$dateChoisis,$S_MFX,$S_MDE,0,'391'); break;
        case '61961' : list($S_DED) = calculateMontant($dateCreation,$dateChoisis,$S_DED,0,0,'61961'); break;
        case '659631' : list($S_NCD) = calculateMontant($dateCreation,$dateChoisis,$S_NCD,0,0,'659631'); break;
        case '71961' : list($S_DER) = calculateMontant($dateCreation,$dateChoisis,$S_DER,0,0,'71961'); break;
        case '7394' : list($S_NCR) = calculateMontant($dateCreation,$dateChoisis,$S_NCR,0,0,'7394'); break;
        case '394' : list($C_MFX,$C_MDE) = calculateMontant($dateCreation,$dateChoisis,$C_MFX,$C_MDE,0,'394'); break;
        case '61964' : list($C_DED) = calculateMontant($dateCreation,$dateChoisis,$C_DED,0,0,'61964'); break;
        case '659634' : list($C_NCD) = calculateMontant($dateCreation,$dateChoisis,$C_NCD,0,0,'659634'); break;
        case '71964' : list($C_DER) = calculateMontant($dateCreation,$dateChoisis,$C_DER,0,0,'71964'); break;
        case '759634' : list($C_NCR) = calculateMontant($dateCreation,$dateChoisis,$C_NCR,0,0,'759634'); break;
        case '395' : list($TEVDP_MFX,$TEVDP_MDE) = calculateMontant($dateCreation,$dateChoisis,$TEVDP_MFX,$TEVDP_MDE,0,'395'); break;
        case '6394' : list($TEVDP_FD) = calculateMontant($dateCreation,$dateChoisis,$TEVDP_FD,0,0,'6394'); break;
        case '7394' : list($TEVDP_FR) = calculateMontant($dateCreation,$dateChoisis,$TEVDP_FR,0,0,'7394'); break;
        case '45' : list($APPREC_MFX,$APPREC_MDE) = calculateMontant($dateCreation,$dateChoisis,$APPREC_MFX,$APPREC_MDE,0,'45'); break;
        case '6195' : list($APPREC_DED) = calculateMontant($dateCreation,$dateChoisis,$APPREC_DED,0,0,'6195'); break;
        case '6393' : list($APPREC_FD) = calculateMontant($dateCreation,$dateChoisis,$APPREC_FD,0,0,'6393'); break;
        case '6595' : list($APPREC_NCD) = calculateMontant($dateCreation,$dateChoisis,$APPREC_NCD,0,0,'6595'); break;
        case '7195' : list($APPREC_DER) = calculateMontant($dateCreation,$dateChoisis,$APPREC_DER,0,0,'7195'); break;
        case '7393' : list($APPREC_FR) = calculateMontant($dateCreation,$dateChoisis,$APPREC_FR,0,0,'7393'); break;
        case '7595' : list($APPREC_NCR) = calculateMontant($dateCreation,$dateChoisis,$APPREC_NCR,0,0,'7595'); break;

        case '59' : list($PPDDCDT_MFX,$PPDDCDT_MDE) = calculateMontant($dateCreation,$dateChoisis,$PPDDCDT_MFX,$PPDDCDT_MDE,0,'59'); break;
        case '6396' : list($PPDDCDT_FD) = calculateMontant($dateCreation,$dateChoisis,$PPDDCDT_FD,0,0,'6396'); break;
        case '7396' : list($PPDDCDT_FR) = calculateMontant($dateCreation,$dateChoisis,$PPDDCDT_FR,0,0,'7396'); break;
    }
    //Sous-Total (A)
    $ST_MDE=$PPDDLI_MDE+$PR_MDE+$PDPREC_MDE;
    $ST_DED=$PPDDLI_DED+$PDPREC_DED;
    $ST_FD=$PPDDLI_FD+$PDPREC_FD;
    $ST_NCD=$PPDDLI_NCD+$PR_NCD+$PDPREC_NCD;
    $ST_DER=$PPDDLI_DER+$PDPREC_DER;
    $ST_FR=$PPDDLI_FR+$PDPREC_FR;
    $ST_NCR=$PPDDLI_NCR+$PR_NCR+$PDPREC_NCR;
    $ST_MFX=$PPDDLI_MFX+$PR_MFX+$PDPREC_MFX;
    //Sous-Total (b)
    $STB_MDE=$S_MDE+$C_MDE+$TEVDP_MDE+$APPREC_MDE+$PPDDCDT_MDE;
    $STB_DED=$S_DED+$C_DED+$APPREC_DED;
    $STB_FD=$TEVDP_FD+$APPREC_FD+$PPDDCDT_FD;
    $STB_NCD=$S_NCD+$C_NCD+$APPREC_NCD;
    $STB_DER=$S_DER+$C_DER+$APPREC_DER;
    $STB_FR=$TEVDP_FR+$APPREC_FR+$PPDDCDT_FR;
    $STB_NCR=$S_NCR+$C_NCR+$APPREC_NCR;
    $STB_MFX=$S_MFX+$C_MFX+$TEVDP_MFX+$APPREC_MFX+$PPDDCDT_MFX;
    //total a+b
    $TAB_MDE=$ST_MDE+$STB_MDE;
    $TAB_DED=$ST_DED+$STB_DED;
    $TAB_FD=$ST_FD+$STB_FD;
    $TAB_NCD=$ST_NCD+$STB_NCD;
    $TAB_DER=$ST_DER+$STB_DER;
    $TAB_NCR=$ST_FR+$STB_FR;
    $TAB_FR=$ST_NCR+$STB_NCR;
    $TAB_MFX=$ST_MFX+$STB_MFX;
}

  if(isset($_POST['chargement']))
  {

  $data = "<?php ";
  $data .= '$PPDDLI_MDE = ' . $PPDDLI_MDE . ";\n";
  $data .= '$PPDDLI_MFX = ' . $PPDDLI_MFX . ";\n";
  $data .= '$PPDDLI_DED = ' . $PPDDLI_DED . ";\n";
  $data .= '$PPDDLI_FD = ' . $PPDDLI_FD . ";\n";
  $data .= '$PPDDLI_NCD = ' . $PPDDLI_NCD . ";\n";
  $data .= '$PPDDLI_DER = ' . $PPDDLI_DER . ";\n";
  $data .= '$PPDDLI_FR = ' .$PPDDLI_FR. ";\n";
  $data .= '$PPDDLI_NCR = ' . $PPDDLI_NCR . ";\n";
  $data .= '$PR_NCD = ' . $PR_NCD . ";\n";
  $data .= '$PR_MFX = ' . $PR_MFX. ";\n";
  $data .= '$PR_MDE = ' . $PR_MDE . ";\n";
  $data .= '$PR_NCR = ' . $PR_NCR . ";\n";
  $data .= '$PDPREC_MFX = ' . $PDPREC_MFX . ";\n";
  $data .= '$PDPREC_MDE = ' . $PDPREC_MDE . ";\n";
  $data .= '$PDPREC_DED = ' . $PDPREC_DED . ";\n";
  $data .= '$PDPREC_FD = ' . $PDPREC_FD . ";\n";
  $data .= '$PDPREC_NCD = ' . $PDPREC_NCD . ";\n";
  $data .= '$PDPREC_DER = ' . $PDPREC_DER. ";\n";
  $data .= '$PDPREC_FR = ' . $PDPREC_FR . ";\n";
  $data .= '$PDPREC_NCR = ' . $PDPREC_NCR . ";\n";
  $data .= '$PPDDLC_MDE = ' . $PPDDLC_MDE . ";\n";
  $data .= '$PPDDLC_MFX = ' . $PPDDLC_MFX . ";\n";
  $data .= '$PPDDLC_DED = ' . $PPDDLC_DED . ";\n";
  $data .= '$PPDDLC_FD = ' . $PPDDLC_FD . ";\n";
  $data .= '$PPDDLC_NCD = ' . $PPDDLC_NCD . ";\n";
  $data .= '$PPDDLC_DER = ' . $PPDDLC_DER. ";\n";
  $data .= '$PPDDLC_FR = ' . $PPDDLC_FR . ";\n";
  $data .= '$PPDDLC_NCR = ' . $PPDDLC_NCR . ";\n";
  $data .= '$S_MDE = ' . $S_MDE . ";\n";
  $data .= '$S_MFX = ' . $S_MFX . ";\n";
  $data .= '$S_DED = ' . $S_DED . ";\n";
  $data .= '$S_NCD = ' . $S_NCD . ";\n";
  $data .= '$S_DER = ' . $S_DER . ";\n";
  $data .= '$S_NCR = ' . $S_NCR. ";\n";
  $data .= '$C_MDE = ' . $C_MDE . ";\n";
  $data .= '$C_MFX = ' . $C_MFX . ";\n";
  $data .= '$C_DED = ' . $C_DED . ";\n";
  $data .= '$C_NCD = ' . $C_NCD . ";\n";
  $data .= '$C_DER = ' . $C_DER . ";\n";
  $data .= '$C_NCR = ' . $C_NCR. ";\n";
  $data .= '$TEVDP_MDE = ' . $TEVDP_MDE . ";\n";
  $data .= '$TEVDP_MFX = ' . $TEVDP_MFX . ";\n";
  $data .= '$TEVDP_FD = ' . $TEVDP_FD . ";\n";
  $data .= '$TEVDP_FR = ' . $TEVDP_FR. ";\n";
  $data .= '$APPREC_MDE = ' . $APPREC_MDE . ";\n";
  $data .= '$APPREC_MFX = ' . $APPREC_MFX . ";\n";
  $data .= '$APPREC_DED = ' . $APPREC_DED . ";\n";
  $data .= '$APPREC_FD = ' . $APPREC_FD . ";\n";
  $data .= '$APPREC_NCD = ' . $APPREC_NCD . ";\n";
  $data .= '$APPREC_DER = ' . $APPREC_DER. ";\n";
  $data .= '$APPREC_FR = ' . $APPREC_FR . ";\n";
  $data .= '$APPREC_NCR = ' . $APPREC_NCR . ";\n";
  $data .= '$PPDDCDT_MDE = ' . $PPDDCDT_MDE . ";\n";
  $data .= '$PPDDCDT_MFX = ' . $PPDDCDT_MFX . ";\n";
  $data .= '$PPDDCDT_FD = ' . $PPDDCDT_FD . ";\n";
  $data .= '$PPDDCDT_FR = ' . $PPDDCDT_FR. ";\n";
  $data .= '$ST_MDE = ' . $ST_MDE . ";\n";
  $data .= '$ST_DED = ' . $ST_DED. ";\n";
  $data .= '$ST_FD = ' . $ST_FD . ";\n";
  $data .= '$ST_NCD = ' . $ST_NCD . ";\n";
  $data .= '$ST_DER = ' . $ST_DER . ";\n";
  $data .= '$ST_FR = ' . $ST_FR . ";\n";
  $data .= '$ST_NCR = ' . $ST_NCR . ";\n";
  $data .= '$ST_MFX = ' . $ST_MFX. ";\n";
  $data .= '$STB_MDE = ' . $STB_MDE . ";\n";
  $data .= '$STB_DED = ' . $STB_DED. ";\n";
  $data .= '$STB_FD = ' . $STB_FD . ";\n";
  $data .= '$STB_NCD = ' . $STB_NCD . ";\n";
  $data .= '$STB_DER = ' . $STB_DER . ";\n";
  $data .= '$STB_FR = ' . $STB_FR . ";\n";
  $data .= '$STB_NCR = ' . $STB_NCR . ";\n";
  $data .= '$STB_MFX = ' . $STB_MFX. ";\n";
  $data .= '$TAB_MDE = ' . $TAB_MDE . ";\n";
  $data .= '$TAB_DED = ' . $TAB_DED. ";\n";
  $data .= '$TAB_FD = ' . $TAB_FD . ";\n";
  $data .= '$TAB_NCD = ' . $TAB_NCD . ";\n";
  $data .= '$TAB_DER = ' . $TAB_DER . ";\n";
  $data .= '$TAB_FR = ' . $TAB_FR . ";\n";
  $data .= '$TAB_NCR = ' . $TAB_NCR . ";\n";
  $data .= '$TAB_MFX = ' . $TAB_MFX. ";\n";
 
  $data .= "?>";
  // Now, the variable $year will contain the year value "2023"
  $nomFichier = 'Provision_fichier_'. $dateChoisis.'.php';
  // Écrire les données dans le nouveau fichier
  file_put_contents($nomFichier, $data);

  }
?>