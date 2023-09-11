<?php

// Load Dolibarr environment
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
require_once '../functionDeclarationLaisse.php';

 //   MP : Montant + // MM : Montant -

  $BN_MP= $BN_MM=0;//Bénéfice net
  $PN_MP=$PN_MM=0;// Perte nette

  $IIRF_MP=0;//II. REINTEGRATIONS FISCALES


  $RODEA_MP=$RODEA_MM=0;//- RRR obtenus des exercice anterieurs
  $RODEA_MP1=$RODEA_MP2=0;
  $ACDEA_MP=$ACDEA_MM=0;//- Autres charges des exercice anterieurs
  $ACDEA_MP1=$ACDEA_MP2=0;
  $IETDEA_MP=$IETDEA_MM=0;//- Impots et taxes des exercices anterieurs
  $CDPEA_MP=$CDPEA_MM=0;//- Charges de personnel exercices anterieurs
  $DDEA_MP= $DDEA_MM=0;//- Dotation d'exploitation exercices anterieurs
  $CDDEA_MP=$CDDEA_MM=0;// - Charges d'interet des exercices anterieurs
  $PDCEA_MP=$PDCEA_MM=0;// - Pertes de changes exercice anterieurs
  $ACFEA_MP=$ACFEA_MM=0;//- Autres charges financieres exercice anterieurs
  $ARDMDEA_MP=$ARDMDEA_MM=0;// - Achats revendus de marchandises des exercices anterieurs
  $ADMEDFDEA_MP=$ADMEDFDEA_MM=0;//- Achats de matieres et de fournitures des exercices anterieurs
  $CND_MP=$CND_MM=0;// - Cadeaux non deductibles
  $DND_MP=$DND_MM=0; // - Dons non deductible
  $C1_MP=$C1_MM=0; //1. Courantes

  $CM_MP=$CM_MM=0;// - Cotisation Minimale
  $ISLR_MP=$ISLR_MM=0; //- Impot sur le resultat
  $CDI_MP=$CDI_MM=0; //- Creances devenues irrecouvrables
  $SAEA_MP=$SAEA_MM=0;//- Subventions accordees exercice anterieurs
  $PEAF_MP=$PEAF_MM=0;// - Penalites et amandes fiscales
  $ACNCDEA_MP=$ACNCDEA_MM=0;// - Autres charges non courant des exercices ant
  $DNCEA_MP=$DNCEA_MM=0;// - Dotations non courantes exercices anterieurs
  $CSDSSLB_MP=$CSDSSLB_MM=0;// - Contribution sociale de solidarité sur les bénéfices (C.S.S)
  $NC2_MP=$NC2_MM=0;//2. Non courantes

  $DEPDP_MP= $DEPDP_MM=0;//- Dividendes et produits de participation
  $IRCNE_MP=$IRCNE_MM=0;//- Ind.retard (Loi 32-10) compt.non encaissées
  $IRCNPEN_MP=$IRCNPEN_MM=0;//- Ind.retard (Loi 32-10) compt.non payées en N
  $CIII_MP=$CIII_MM=0;//1. Courantes III
  $NCIII_MM=0;//2.  Non courantes III

  $Total_MP= $Total_MM=0;//Total 


  $BBSI_MP=$BBSI_MM=0;// Bénéfice brut si T1 &gt; T2 (A)
  $DBFSI_MP=$DBFSI_MM=0;//Déficit brut fiscal si T2 &gt; T1 (B)

  $VRDIC_MP= $VRDIC_MM=0;//V. REPORTS DEFICITAIRES IMPUTES  (C)  (1)

  $BNFAC_MP=$BNFAC_MM=0;//Bénéfice net fiscal  (A-C)

  $ODNF_MP=$ODNF_MM=0;//ou déficit net fiscal  (B)

  $VIICDDFRAR_MP=$VIICDDFRAR_MM=0;//VIII. CUMUL DES DEFICITS FISCAUX RESTANT A REPORTER

  $IIIDF_MP=$IIIDF_MM=0;//III. DEDUCTIONS FISCALES


  
  
  
 
 


  $dateChoisis=0;
  $dateChoisis=(isset($_POST['chargement']))?$_POST['date_select']:0;
  if(!isset($_POST['chargement']))
  {
    $dateChoisis=GETPOST('valeurdatechoise');
  }

  if($dateChoisis!=0)
  {
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/HORTAXES/Hortaxes_fichier_'.$dateChoisis.'.php';
  }

  if(isset($_POST['chargement']))
  {
    for ($i = 1; $i <= 19; $i++) {
      ${'PassageCom' . $i} = $_POST['PassageCom' . $i];
    }
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
      case "61298":list($RODEA_MP1)=calculateMontant($dateCreation, $dateChoisis, $RODEA_MP1,'0', '0','61298');break;
      case "6149":list($RODEA_MP2)=calculateMontant($dateCreation, $dateChoisis, $RODEA_MP2,'0', '0','6149');break;
      case "6148":list($ACDEA_MP1)=calculateMontant($dateCreation, $dateChoisis, $ACDEA_MP1,'0', '0','6148');break;
      case "6188":list($ACDEA_MP2)=calculateMontant($dateCreation, $dateChoisis, $ACDEA_MP2,'0', '0','6188');break;
      case "6168":list($IETDEA_MP)=calculateMontant($dateCreation, $dateChoisis, $IETDEA_MP,'0', '0','6168');break;
      case "6178":list($CDPEA_MP)=calculateMontant($dateCreation, $dateChoisis, $CDPEA_MP,'0', '0','6178');break;
      case "6198":list($DDEA_MP)=calculateMontant($dateCreation, $dateChoisis, $DDEA_MP,'0', '0','6198');break;
      case "6318":list($CDDEA_MP)=calculateMontant($dateCreation, $dateChoisis, $CDDEA_MP,'0', '0','6318');break;
      case "6338":list($PDCEA_MP)=calculateMontant($dateCreation, $dateChoisis, $PDCEA_MP,'0', '0','6338');break;
      case "6398":list($ACFEA_MP)=calculateMontant($dateCreation, $dateChoisis, $ACFEA_MP,'0', '0','6398');break;
      case "6118":list($ARDMDEA_MP)=calculateMontant($dateCreation, $dateChoisis, $ARDMDEA_MP,'0', '0','6118');break;
      case "6128":list($ADMEDFDEA_MP)=calculateMontant($dateCreation, $dateChoisis, $ADMEDFDEA_MP,'0', '0','6128');break;
      case "61447":list($CND_MP)=calculateMontant($dateCreation, $dateChoisis, $CND_MP,'0', '0','61447');break;
      case "61462":list($DND_MP)=calculateMontant($dateCreation, $dateChoisis, $DND_MP,'0', '0','61462');break;
      case "1191":list($BN_MP)=calculateMontant($dateCreation, $dateChoisis, $BN_MP,'0', '0','1191');break;
      case "1169":list($PN_MM)=calculateMontant($dateCreation, $dateChoisis, $PN_MM,'0', '0','1169');break;
      case "6701":list($ISLR_MP)=calculateMontant($dateCreation, $dateChoisis, $ISLR_MP,'0', '0','6701');break;
      case "6585":list($CDI_MP)=calculateMontant($dateCreation, $dateChoisis, $CDI_MP,'0', '0','6585');break;
      case "6568":list($SAEA_MP)=calculateMontant($dateCreation, $dateChoisis, $SAEA_MP,'0', '0','6568');break;
      case "6583":list($PEAF_MP)=calculateMontant($dateCreation, $dateChoisis, $PEAF_MP,'0', '0','6583');break;
      case "6588":list($ACNCDEA_MP)=calculateMontant($dateCreation, $dateChoisis, $ACNCDEA_MP,'0', '0','6588');break;
      case "6598":list($DNCEA_MP)=calculateMontant($dateCreation, $dateChoisis, $DNCEA_MP,'0', '0','6598');break;
      case "65864":list($CSDSSLB_MP)=calculateMontant($dateCreation, $dateChoisis, $CSDSSLB_MP,'0', '0','65864');break;
      case "732":list($DEPDP_MM)=calculateMontant($dateCreation, $dateChoisis, $DEPDP_MM,'0', '0','732');break;
      case "738111":list($IRCNE_MM)=calculateMontant($dateCreation, $dateChoisis, $IRCNE_MM,'0', '0','738111');break;
      case "631181":list($IRCNPEN_MM)=calculateMontant($dateCreation, $dateChoisis, $IRCNPEN_MM,'0', '0','631181');break;

      case "61461":list($CM_MP)=calculateMontant($dateCreation, $dateChoisis,$CM_MP,'0', '0','61461');break;


    }
    $RODEA_MP=$RODEA_MP1+$RODEA_MP2;
    $ACDEA_MP=$ACDEA_MP1+$ACDEA_MP2;
    $C1_MP=$RODEA_MP+$ACDEA_MP+$IETDEA_MP+ $CDPEA_MP+$DDEA_MP+$CDDEA_MP+$PDCEA_MP+$ACFEA_MP+$ARDMDEA_MP+$ADMEDFDEA_MP+$CND_MP+$DND_MP;
    $NC2_MP= $CM_MP+$ISLR_MP+$CDI_MP+$SAEA_MP+$PEAF_MP+$ACNCDEA_MP+$DNCEA_MP+$CSDSSLB_MP;
    $CIII_MM=$DEPDP_MP+ $IRCNE_MP+$IRCNPEN_MP;

    $IIRF_MP= $C1_MP+$NC2_MP;

    $NCIII_MM=isset($PassageCom3)+isset($PassageCom6)+isset($PassageCom9);

    $Total_MP=$BN_MP+$C1_MP+$NC2_MP;
    $Total_MM=$PN_MM+$CIII_MM+$NCIII_MM;

    $BBSI_MM=($Total_MP-$Total_MM>=0)?$Total_MP-$Total_MM:0;
  
    $DBFSI_MM=($Total_MP-$Total_MM<0)?$Total_MP-$Total_MM:0;

    
    $VRDIC_MM=isset($PassageCom10)+isset($PassageCom11)+isset($PassageCom12)+isset($PassageCom13)+isset($PassageCom14);
    $BNFAC_MM=$BBSI_MM-$BNFAC_MM;
    $ODNF_MM=$DBFSI_MM;
    $VIICDDFRAR_MM=isset($PassageCom16)+isset($PassageCom17)+isset($PassageCom18)+isset($PassageCom19);


    $BN_MP=( $xviReNToEx>0)? $xviReNToEx:0;
    $PN_MM=( $xviReNToEx<0)? -$xviReNToEx:0;

    $IIIDF_MM=$CIII_MM+$NCIII_MM;
  }
  if(isset($_POST['chargement']))
  {
    $data = "<?php ";
    $data .= '$BN_MP = ' . $BN_MP . ";\n";
    $data .= '$PN_MM = ' . $PN_MM . ";\n";
    $data .= '$IIRF_MP = ' . $IIRF_MP . ";\n";
    $data .= '$RODEA_MP = ' . $RODEA_MP . ";\n";
    $data .= '$ACDEA_MP = ' . $ACDEA_MP . ";\n";
    $data .= '$IETDEA_MP = ' . $IETDEA_MP . ";\n";
    $data .= '$CDPEA_MP = ' . $CDPEA_MP . ";\n";
    $data .= '$DDEA_MP = ' . $DDEA_MP . ";\n";
    $data .= '$CDDEA_MP = ' . $CDDEA_MP . ";\n";
    $data .= '$PDCEA_MP = ' . $PDCEA_MP . ";\n";
    $data .= '$ACFEA_MP = ' . $ACFEA_MP . ";\n";
    $data .= '$ARDMDEA_MP = ' . $ARDMDEA_MP . ";\n";
    $data .= '$ADMEDFDEA_MP = ' . $ADMEDFDEA_MP . ";\n";
    $data .= '$CND_MP = ' . $CND_MP . ";\n";
    $data .= '$DND_MP = ' . $DND_MP . ";\n";
    $data .= '$C1_MP = ' . $C1_MP . ";\n";
    $data .= '$ISLR_MP = ' . $ISLR_MP . ";\n";
    $data .= '$CDI_MP = ' . $CDI_MP . ";\n";
    $data .= '$SAEA_MP = ' . $SAEA_MP . ";\n";
    $data .= '$PEAF_MP = ' . $PEAF_MP . ";\n";
    $data .= '$ACNCDEA_MP = ' . $ACNCDEA_MP . ";\n";
    $data .= '$DNCEA_MP = ' . $DNCEA_MP . ";\n";
    $data .= '$CSDSSLB_MP = ' . $CSDSSLB_MP . ";\n";
    $data .= '$NC2_MP = ' . $NC2_MP . ";\n";
    $data .= '$DEPDP_MM = ' . $DEPDP_MM . ";\n";
    $data .= '$IRCNE_MM = ' . $IRCNE_MM . ";\n";
    $data .= '$IRCNPEN_MM = ' . $IRCNPEN_MM . ";\n";
    $data .= '$CIII_MM = ' . $CIII_MM . ";\n";
    $data .= '$NCIII_MM = ' . $NCIII_MM . ";\n";
    $data .= '$Total_MP = ' . $Total_MP . ";\n";
    $data .= '$Total_MM = ' . $Total_MM . ";\n";
    $data .= '$BBSI_MM = ' . $BBSI_MM . ";\n";
    $data .= '$DBFSI_MM = ' . $DBFSI_MM . ";\n";
    $data .= '$VRDIC_MM = ' . $VRDIC_MM . ";\n";
    $data .= '$BNFAC_MM = ' . $BNFAC_MM . ";\n";
    $data .= '$ODNF_MM = ' . $ODNF_MM . ";\n";
    $data .= '$VIICDDFRAR_MM = ' . $VIICDDFRAR_MM . ";\n";

    $data .= '$BN_MP = ' . $BN_MP . ";\n";
    $data .= '$PN_MM = ' . $PN_MM . ";\n";

    $data .= '$CM_MP = ' . $CM_MP . ";\n";
    $data .= '$IIIDF_MM = ' . $IIIDF_MM . ";\n";
    for ($i = 1; $i <= 19; $i++) {
      ${'PassageCom' . $i} = $_POST['PassageCom' . $i];

      if (is_string(${'PassageCom' . $i})) {
        // If the value is a string, add double quotes around it
        $data .= '$PassageCom' . $i . ' = "' . ${'PassageCom' . $i} . "\";\n";
      }
      else {
        $data .= '$PassageCom' . $i . ' = ' . ${'PassageCom' . $i} . ";\n";  
      }

     
    }
   

    $data .= "?>";
    // Now, the variable $year will contain the year value "2023"
    $nomFichier = 'PassageComptableFiscal_fichier_'. $dateChoisis.'.php';
    // Écrire les données dans le nouveau fichier
    file_put_contents($nomFichier, $data);

  }


        


?>