<?php
    // Load Dolibarr environment
    require_once '../../main.inc.php';
    require_once '../../vendor/autoload.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
    require_once 'functionDeclarationLaisse.php';

    // PaLex = Propres à l'exercice / CLExPr = Concernant les exercices précédents / ToEx = Totaux de l'exercice / ExPre = Exercice précédent / ExN2 = Exercice N-2
    $prExPaLex=$prExCLExPr=$prExToEx=$prExExPre=$prExExN2=0; //PRODUITS D'EXPLOITATION
    $veMarchPaLex=$veMarchCLExPr=$veMarchToEx=$veMarchExPre=$veMarchExN2=0; //ventes de marchandises
    $venBSPPaLex=$venBSPCLExPr=$venBSPToEx=$venBSPExPre=$venBSPExN2=0;// Ventes de biens et services produits
    $chAffPaLex=$chAffCLExPr=$chAffToEx=$chAffExPre=$chAffExN2=0;//Chiffres d'affaires	
    $varSyProPaLex=$varSyProCLExPr=$varSyProToEx=$varSyProExPre=$varSyProExN2=0; // Variation de stock de produits
    $imPrLePaLex=$imPrLeCLExPr=$imPrLeToEx=$imPrLeExPre=$imPrLeExN2=0;//Immobilisations produites pour l'Ese p/elle même
    $subEXPaLex=$subEXCLExPr=$subEXToEx=$subEXExPre=$subEXExN2=0;//Subvention d'exploitation
    $auPrExPaLex=$auPrExCLExPr=$auPrExToEx=$auPrExExPre=$auPrExExN2=0;//Autres produits d'exploitation
    $reExTchPaLex=$reExTchCLExPr=$reExTchToEx=$reExTchExPre=$reExTchExN2=0;//Reprises d'exploitation; transfert de charges
    $totalIPaLex=$totalICLExPr=$totalIToEx=$totalIExPre=$totalIExN2=0;//TOTAL I
    $achReMPaLex=$achReMCLExPr=$achReMToEx=$achReMExPre=$achReMExN2=0;//Achats revendus de marchandises
    $achCMDPaLex=$achCMDCLExPr=$achCMDToEx=$achCMDExPre=$achCMDExN2=0;//Achat consommes de matières et de fournitures

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
            case '7118' : list($veMarchCLExPr) = calculateMontant($dateCreation, $dateChoisis,$veMarchCLExPr,0,0,'7118'); break;            
            case '711' : list($veMarchToEx,$veMarchExPre,$veMarchExN2) = calculateMontant($dateCreation, $dateChoisis,$veMarchToEx,$veMarchExPre,$veMarchExN2,'711'); break;     
            case '7128' : list($venBSPCLExPr) = calculateMontant($dateCreation, $dateChoisis,$venBSPCLExPr,0,0,'7128'); break;   
            case '712' : list($venBSPToEx,$venBSPExPre,$venBSPExN2) = calculateMontant($dateCreation, $dateChoisis,$venBSPToEx,$venBSPExPre,$venBSPExN2,'712'); break; 
            case '7138' : list($varSyProCLExPr) = calculateMontant($dateCreation, $dateChoisis,$varSyProCLExPr,0,0,'7138'); break;   
            case '713' : list($varSyProToEx,$varSyProExPre,$varSyProExN2) = calculateMontant($dateCreation, $dateChoisis,$varSyProToEx,$varSyProExPre,$varSyProExN2,'713'); break; 
            case '7148' : list($imPrLeCLExPr) = calculateMontant($dateCreation, $dateChoisis,$imPrLeCLExPr,0,0,'7148'); break;   
            case '714' : list($imPrLeToEx,$imPrLeExPre,$imPrLeExN2) = calculateMontant($dateCreation, $dateChoisis,$imPrLeToEx,$imPrLeExPre,$imPrLeExN2,'714'); break;
            case '7168' : list($subEXCLExPr) = calculateMontant($dateCreation, $dateChoisis,$subEXCLExPr,0,0,'7168'); break;   
            case '716' : list($subEXToEx,$subEXExPre,$subEXExN2) = calculateMontant($dateCreation, $dateChoisis,$subEXToEx,$subEXExPre,$subEXExN2,'716'); break;
            case '7188' : list($auPrExCLExPr) = calculateMontant($dateCreation, $dateChoisis,$auPrExCLExPr,0,0,'7188'); break;   
            case '718' : list($auPrExToEx,$auPrExExPre,$auPrExExN2) = calculateMontant($dateCreation, $dateChoisis,$auPrExToEx,$auPrExExPre,$auPrExExN2,'718'); break;
            case '7198' : list($reExTchCLExPr) = calculateMontant($dateCreation, $dateChoisis,$reExTchCLExPr,0,0,'7198'); break;   
            case '719' : list($reExTchToEx,$reExTchExPre,$reExTchExN2) = calculateMontant($dateCreation, $dateChoisis,$reExTchToEx,$reExTchExPre,$reExTchExN2,'719'); break;
            case '6118' : list($achReMCLExPr) = calculateMontant($dateCreation, $dateChoisis,$achReMCLExPr,0,0,'6118'); break;   
            case '611' : list($achReMToEx,$achReMExPre,$achReMExN2) = calculateMontant($dateCreation, $dateChoisis,$achReMToEx,$achReMExPre,$achReMExN2,'611'); break;
            case '6128' : list($achReMCLExPr) = calculateMontant($dateCreation, $dateChoisis,$achReMCLExPr,0,0,'6128'); break;   
            case '612' : list($achReMToEx,$achReMExPre,$achReMExN2) = calculateMontant($dateCreation, $dateChoisis,$achReMToEx,$achReMExPre,$achReMExN2,'612'); break;
                 
            default:$default=$montant;break;
        }

        //ventes de marchandises  Propres à l'exercice
        $veMarchPaLex=$veMarchToEx+$veMarchCLExPr;
        // Ventes de biens et services produits Propres à l'exercice
        $venBSPPaLex=$venBSPToEx+$venBSPCLExPr;
        // Chiffres d'affaires  Propres à l'exercice
        $chAffPaLex=$veMarchPaLex+$venBSPPaLex;
        $chAffCLExPr=$veMarchCLExPr+$venBSPCLExPr;
        $chAffToEx=$veMarchToEx+$venBSPToEx;
        $chAffExPre=$veMarchExPre+$venBSPExPre;
        $chAffExN2=$veMarchExN2+$venBSPExN2;
        // Variation de stock de produits  Propres à l'exercice
        $varSyProPaLex=$varSyProToEx+$varSyProCLExPr;
        //Immobilisations produites pour l'Ese p/elle même  Propres à l'exercice
        $imPrLePaLex=$imPrLeCLExPr+$imPrLeToEx;
        //Subvention d'exploitation  Propres à l'exercice
        $subEXPaLex=$subEXCLExPr+$subEXToEx;
        // Autres produits d'exploitation  Propres à l'exercice
        $auPrExPaLex=$auPrExCLExPr+$auPrExToEx;
        // Reprises d'exploitation; transfert de charges Propres à l'exercice
        $reExTchPaLex=$reExTchCLExPr+$reExTchToEx;
        //PRODUITS D'EXPLOITATION
        $prExPaLex= $chAffPaLex+$varSyProPaLex+$imPrLePaLex+$subEXPaLex+ $auPrExPaLex+ $reExTchPaLex;
        $reExTchCLExPr=$chAffCLExPr+$varSyProCLExPr+$imPrLeCLExPr+$subEXCLExPr+$auPrExCLExPr+$reExTchCLExPr;
        $reExTchToEx=$chAffToEx+$varSyProToEx+$imPrLeToEx+$subEXToEx+$auPrExToEx+$reExTchToEx;
        $reExTchExPre= $chAffExPre+$varSyProExPre+$imPrLeExPre+$subEXExPre+$auPrExExPre;
        $reExTchExN2= $chAffExN2+$varSyProExN2+$imPrLeExN2+$subEXExN2+$auPrExExN2;
        //TOTAL I
        $totalIPaLex=$chAffPaLex+$varSyProPaLex+$imPrLePaLex+$subEXPaLex+ $auPrExPaLex+ $reExTchPaLex;
        $totalICLExPr=$chAffCLExPr+$varSyProCLExPr+$imPrLeCLExPr+$subEXCLExPr+$auPrExCLExPr+$reExTchCLExPr;
        $totalIToEx=$chAffToEx+$varSyProToEx+$imPrLeToEx+$subEXToEx+$auPrExToEx+$reExTchToEx;
        $totalIExPre=$chAffExPre+$varSyProExPre+$imPrLeExPre+$subEXExPre+$auPrExExPre;
        $totalIExN2=$chAffExN2+$varSyProExN2+$imPrLeExN2+$subEXExN2+$auPrExExN2;
        //Achats revendus de marchandises
        $achReMPaLex=$achReMCLExPr+$achReMToEx;
    }




?>