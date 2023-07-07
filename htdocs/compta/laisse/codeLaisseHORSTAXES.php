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
    //Autres charges externes
    $autChExCLExPr=$autChExCLExPr1=$autChExCLExPr2=0;
    $autChExToEx=$autChExToEx1=$autChExToEx2=0;
    $autChExExPre=$autChExExPre1=$autChExExPre2=0;
    $autChExExN2=$autChExExN21=$autChExExN22=0;
    $autChExPaLex=0;
    $imetPaLex=$imetCLExPr=$imetToEx=$imetExPre=$imetExN2=0;//Impôts et taxes
    $chPrPaLex=$chPrCLExPr=$chPrToEx=$chPrExPre=$chPrExN2=0;//Charges de personnel
    $auChExPaLex=$auChExCLExPr=$auChExToEx=$auChExExPre=$auChExExN2=0; //Autres charges d'exploitation
    $dExPaLex=$dExCLExPr=$dExToEx=$dExExPre=$dExExN2=0;//Dotations d'exploitation
    $totalIIPaLex=$totalIICLExPr=$totalIIToEx=$totalIIExPre=$totalIIExN2=0;//TOTAL  II
    $reExI_IIToEx=$reExI_IIExPre=$reExI_IIExN2=0;//III - RESULTAT D'EXPLOITATION  ( I - II )
    $prTPPaLex=$prTPCLExPr=$prTPToEx=$prTPExPre=$prTPExN2=0;//Produits des titres de partic. et autres titres immo
    $gaChPaLex=$gaChCLExPr=$gaChToEx=$gaChExPre=$gaChExN2=0;//Gains de change
    $inAPFPaLex=$inAPFCLExPr=$inAPFToEx=$inAPFExPre=$inAPFExN2=0; //Intérêts et autres produits financiers
    $reFTChPaLex=$reFTChCLExPr=$reFTChToEx=$reFTChExPre=$reFTChExN2=0; //Reprises financières; transfert de charges
    $totalIVPaLex=$totalIVCLExPr=$totalIVToEx=$totalIVExPre=$totalIVExN2=0; //TOTAL  IV
    $chiPaLex=$chiCLExPr=$chiToEx=$chiExPre=$chiExN2=0; //Charges d'intérêts
    $peChPaLex=$peChCLExPr=$peChToEx=$peChExPre=$peChExN2=0; //Pertes de changes
    $auChFPaLex=$auChFCLExPr=$auChFToEx=$auChFExPre=$auChFExN2=0;//Autres charges financières
    $doFPaLex= $doFCLExPr= $doFToEx= $doFExPre= $doFExN2=0;//Dotations financières
    $totalVPaLex=$totalVCLExPr=$totalVToEx=$totalVExPre=$totalVExN2=0;// TOTAL V
    $reFToEx= $reFExPre= $reFExN2=0;//RESULTAT FINANCIER ( IV - V )
    $reCoToEx=$reCoExPre=$reCoExN2=0;//RESULTAT COURANT ( III - V I)
    $reTCToEx=$reTCExPre=$reTCExN2=0;//RESULTAT COURANT ( Report )
    $proDCIPaLex=$proDCICLExPr=$proDCIToEx=$proDCIExPre=$proDCIExN2=0;//Produits des cessions d'immobilisations
    $subDEPaLex=$subDECLExPr=$subDEToEx=$subDEExPre=$subDEExN2=0;//Subventions d'équilibre
    $reSDPaLex=$reSDCLExPr=$reSDToEx=$reSDExPre=$reSDExN2=0;//Reprises sur subventions d'investissement
    $auPrCPaLex=$auPrCCLExPr=$auPrCToEx=$auPrCExPre=$auPrCExN2=0;//Autres produits non courants
    $reCTCPaLex=$reCTCCLExPr=$reCTCToEx=$reCTCExPre=$reCTCExN2=0;//Reprises non courantes; transferts de charges
    $totalVIIIPaLex=$totalVIIICLExPr=$totalVIIIToEx=$totalVIIIExPre=$totalVIIIExN2=0;//TOTAL  VIII
    $vaNAICPaLex=$vaNAICCLExPr=$vaNAICToEx=$vaNAICExPre=$vaNAICExN2=0; //Valeurs nettes d'amortis. des immos cédées
    $suAcPaLex=$suAcCLExPr=$suAcToEx=$suAcExPre=$suAcExN2=0; //Subventions accordées
    $auCNCPaLex=$auCNCCLExPr=$auCNCToEx=$auCNCExPre=$auCNCExN2=0; //Autres charges non courantes
    $daCAPPaLex=$daCAPCLExPr=$daCAPToEx=$daCAPExPre=$daCAPExN2=0; //Dotations non courantes aux amortiss. et prov.
    $totalIXPaLex=$totalIXCLExPr=$totalIXToEx=$totalIXExPre=$totalIXExN2=0;//TOTAL  IX
    $XReNCToEx=$XReNCExPre=$XReNCExN2=0;//X - RESULTAT NON COURANT ( VIII- IV )
    $xiResulAIToEx=$xiResulAIExPre=$xiResulAIExN2=0;//XI - RESULTAT AVANT IMPOTS ( VII+ X )
    $xiiIMSLRPaLex= $xiiIMSLRCLExPr= $xiiIMSLRToEx= $xiiIMSLRExPre= $xiiIMSLRExN2=0;//XII - IMPOTS SUR LES RESULTATS
    $xiiReNToEx=$xiiReNExPre=$xiiReNExN2=0;// XIII - RESULTAT NET ( XI - XII )
    $xivToDPrToEx=$xivToDPrExPre=$xivToDPrExN2=0;//XIV - TOTAL DES PRODUITS ( I + IV + VIII )
    $xvToDCHToEx=$xvToDCHExPre=$xvToDCHExN2=0;//XV - TOTAL DES CHARGES ( II + V + IX + XII )
    $xviReNToEx=$xviReNExPre=$xviReNExN2=0;//XVI - RESULTAT NET ( XIV - XV )

    
    

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
            case '6128' : list($achCMDCLExPr) = calculateMontant($dateCreation, $dateChoisis,$achCMDCLExPr,0,0,'6128'); break;   
            case '612' : list($achCMDToEx,$achCMDExPre,$achCMDExN2) = calculateMontant($dateCreation, $dateChoisis,$achCMDToEx,$achCMDExPre,$achCMDExN2,'612'); break;
            case '6138' : list($autChExCLExPr1) = calculateMontant($dateCreation, $dateChoisis,$autChExCLExPr1,0,0,'6138'); break;
            case '6148' : list($autChExCLExPr2) = calculateMontant($dateCreation, $dateChoisis,$autChExCLExPr2,0,0,'6148'); break;
            case '613' : list($autChExToEx1,$autChExExPre1,$autChExExN21) = calculateMontant($dateCreation, $dateChoisis,$autChExToEx1,$autChExExPre1,$autChExExN21,'613'); break;
            case '614' : list($autChExToEx2,$autChExExPre2,$autChExExN22) = calculateMontant($dateCreation, $dateChoisis,$autChExToEx2,$autChExExPre2,$autChExExN22,'614'); break;
            case '6168' : list($imetCLExPr) = calculateMontant($dateCreation, $dateChoisis,$imetCLExPr,0,0,'6168'); break;   
            case '616' : list($imetToEx,$imetExPre,$imetExN2) = calculateMontant($dateCreation, $dateChoisis,$imetToEx,$imetExPre,$imetExN2,'616'); break;
            case '6178' : list($chPrCLExPr) = calculateMontant($dateCreation, $dateChoisis,$chPrCLExPr,0,0,'6178'); break;   
            case '617' : list($chPrToEx,$chPrExPre,$chPrExN2) = calculateMontant($dateCreation, $dateChoisis,$chPrToEx,$imetExPre,$chPrExN2,'617'); break;
            case '6188' : list($auChExCLExPr) = calculateMontant($dateCreation, $dateChoisis,$auChExCLExPr,0,0,'6188'); break;   
            case '618' : list($auChExToEx,$auChExExPre,$auChExExN2) = calculateMontant($dateCreation, $dateChoisis,$auChExToEx,$auChExExPre,$auChExExN2,'618'); break;
            case '6198' : list($dExCLExPr) = calculateMontant($dateCreation, $dateChoisis,$dExCLExPr,0,0,'6198'); break;   
            case '619' : list($dExToEx,$dExExPre,$dExExN2) = calculateMontant($dateCreation, $dateChoisis,$dExToEx,$dExExPre,$dExExN2,'619'); break;
            case '7328' : list($prTPCLExPr) = calculateMontant($dateCreation, $dateChoisis,$prTPCLExPr,0,0,'7328'); break;   
            case '732' : list($prTPToEx,$prTPExPre,$prTPExN2) = calculateMontant($dateCreation, $dateChoisis,$prTPToEx,$prTPExPre,$prTPExN2,'732'); break;
            case '7338' : list($gaChCLExPr) = calculateMontant($dateCreation, $dateChoisis,$gaChCLExPr,0,0,'7338'); break;   
            case '733' : list($gaChToEx,$gaChExPre,$gaChExN2) = calculateMontant($dateCreation, $dateChoisis,$gaChToEx,$gaChExPre,$gaChExN2,'733'); break;
            case '7388' : list($inAPFCLExPr) = calculateMontant($dateCreation, $dateChoisis,$inAPFCLExPr,0,0,'7388'); break;   
            case '738' : list($inAPFToEx,$inAPFExPre,$inAPFExN2) = calculateMontant($dateCreation, $dateChoisis,$inAPFToEx,$inAPFExPre,$inAPFExN2,'738'); break;
            case '6318' : list($chiCLExPr) = calculateMontant($dateCreation, $dateChoisis,$chiCLExPr,0,0,'6318'); break;   
            case '631' : list($chiToEx,$chiExPre,$chiExN2) = calculateMontant($dateCreation, $dateChoisis,$chiToEx,$chiExPre,$chiExN2,'631'); break;
            case '6338' : list($peChCLExPr) = calculateMontant($dateCreation, $dateChoisis,$peChCLExPr,0,0,'6338'); break;   
            case '633' : list($peChToEx,$peChExPre,$peChExN2) = calculateMontant($dateCreation, $dateChoisis,$peChToEx,$peChExPre,$peChExN2,'633'); break;
            case '6388' : list($auChFCLExPr) = calculateMontant($dateCreation, $dateChoisis,$auChFCLExPr,0,0,'6388'); break;   
            case '638' : list($auChFToEx,$auChFExPre,$auChFExN2) = calculateMontant($dateCreation, $dateChoisis,$auChFToEx,$auChFExPre,$auChFExN2,'638'); break;
            case '6398' : list($doFCLExPr) = calculateMontant($dateCreation, $dateChoisis,$doFCLExPr,0,0,'6398'); break;   
            case '639' : list($doFToEx,$doFExPre,$doFExN2) = calculateMontant($dateCreation, $dateChoisis,$doFToEx,$doFExPre,$doFExN2,'639'); break;
            case '7518' : list($proDCICLExPr) = calculateMontant($dateCreation, $dateChoisis,$proDCICLExPr,0,0,'7518'); break;   
            case '751' : list($proDCIToEx,$proDCIExPre,$proDCIExN2) = calculateMontant($dateCreation, $dateChoisis,$proDCIToEx,$proDCIExPre,$proDCIExN2,'751'); break;
            case '7568' : list($subDECLExPr) = calculateMontant($dateCreation, $dateChoisis,$subDECLExPr,0,0,'7568'); break;   
            case '756' : list($subDEToEx,$subDEExPre,$subDEExN2) = calculateMontant($dateCreation, $dateChoisis,$subDEToEx,$subDEExPre,$subDEExN2,'756'); break;
            case '7578' : list($reSDCLExPr) = calculateMontant($dateCreation, $dateChoisis,$reSDCLExPr,0,0,'7578'); break;   
            case '757' : list($reSDToEx,$reSDExPre,$reSDExN2) = calculateMontant($dateCreation, $dateChoisis,$reSDToEx,$reSDExPre,$reSDExN2,'757'); break;
            case '7588' : list($auPrCCLExPr) = calculateMontant($dateCreation, $dateChoisis,$auPrCCLExPr,0,0,'7588'); break;   
            case '758' : list($auPrCToEx,$auPrCExPre,$auPrCExN2) = calculateMontant($dateCreation, $dateChoisis,$auPrCToEx,$auPrCExPre,$auPrCExN2,'758'); break;
            case '7598' : list($reCTCCLExPr) = calculateMontant($dateCreation, $dateChoisis,$reCTCCLExPr,0,0,'7598'); break;   
            case '759' : list($reCTCToEx,$reCTCExPre,$reCTCExN2) = calculateMontant($dateCreation, $dateChoisis,$reCTCToEx,$reCTCExPre,$reCTCExN2,'759'); break;
            case '6518' : list($vaNAICCLExPr) = calculateMontant($dateCreation, $dateChoisis,$vaNAICCLExPr,0,0,'6518'); break;   
            case '651' : list($vaNAICToEx,$vaNAICExPre,$vaNAICExN2) = calculateMontant($dateCreation, $dateChoisis,$vaNAICToEx,$vaNAICExPre,$vaNAICExN2,'651'); break;
            case '6568' : list($vaNAICCLExPr) = calculateMontant($dateCreation, $dateChoisis,$vaNAICCLExPr,0,0,'6568'); break;   
            case '656' : list($vaNAICToEx,$vaNAICExPre,$vaNAICExN2) = calculateMontant($dateCreation, $dateChoisis,$vaNAICToEx,$vaNAICExPre,$vaNAICExN2,'656'); break;
            case '6588' : list($auCNCCLExPr) = calculateMontant($dateCreation, $dateChoisis,$auCNCCLExPr,0,0,'6588'); break;   
            case '658' : list($auCNCToEx,$auCNCExPre,$auCNCExN2) = calculateMontant($dateCreation, $dateChoisis,$auCNCToEx,$auCNCExPre,$auCNCExN2,'658'); break;
            case '6598' : list($daCAPCLExPr) = calculateMontant($dateCreation, $dateChoisis,$daCAPCLExPr,0,0,'6598'); break;   
            case '659' : list($daCAPToEx,$daCAPExPre,$daCAPExN2) = calculateMontant($dateCreation, $dateChoisis,$daCAPToEx,$daCAPExPre,$daCAPExN2,'659'); break;
            case '6708' : list($xiiIMSLRCLExPr) = calculateMontant($dateCreation, $dateChoisis,$xiiIMSLRCLExPr,0,0,'6708'); break;   
            case '67' : list($xiiIMSLRToEx,$xiiIMSLRExPre,$xiiIMSLRExN2) = calculateMontant($dateCreation, $dateChoisis,$xiiIMSLRToEx,$xiiIMSLRExPre,$xiiIMSLRExN2,'67'); break;
            default:$default=$montant;break;
        }
        $veMarchPaLex=$veMarchToEx-$veMarchCLExPr; //ventes de marchandises  Propres à l'exercice        
        $venBSPPaLex=$venBSPToEx-$venBSPCLExPr;// Ventes de biens et services produits Propres à l'exercice
        // Chiffres d'affaires  Propres à l'exercice
        $chAffPaLex=$veMarchPaLex+$venBSPPaLex;
        $chAffCLExPr=$veMarchCLExPr+$venBSPCLExPr;
        $chAffToEx=$veMarchToEx+$venBSPToEx;
        $chAffExPre=$veMarchExPre+$venBSPExPre;
        $chAffExN2=$veMarchExN2+$venBSPExN2;        
        $varSyProPaLex=$varSyProToEx-$varSyProCLExPr;// Variation de stock de produits  Propres à l'exercice       
        $imPrLePaLex=$imPrLeToEx-$imPrLeCLExPr;//Immobilisations produites pour l'Ese p/elle même  Propres à l'exercice      
        $subEXPaLex=$subEXToEx-$subEXCLExPr; //Subvention d'exploitation  Propres à l'exercice       
        $auPrExPaLex=$auPrExToEx-$auPrExCLExPr; // Autres produits d'exploitation  Propres à l'exercice        
        $reExTchPaLex=$reExTchToEx-$reExTchCLExPr;// Reprises d'exploitation; transfert de charges Propres à l'exercice
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
        $achReMPaLex=$achReMToEx-$achReMCLExPr;  //Achats revendus de marchandises     
        $achCMDPaLex=$achCMDToEx-$achCMDCLExPr;  //Achat consommes de matières et de fournitures
        //Autres charges externes
        $autChExCLExPr=$autChExCLExPr1=$autChExCLExPr2;
        $autChExToEx=$autChExToEx1+$autChExToEx2;
        $autChExExPre=$autChExExPre1+$autChExExPre2;
        $autChExExN2=$autChExExN21=$autChExExN22;
        $autChExPaLex= $autChExToEx-$autChExCLExPr;       
        $imetPaLex=$imetToEx-$imetCLExPr;//Impôts et taxes      
        $chPrPaLex=$chPrToEx-$chPrCLExPr; //Charges de personnel       
        $auChExPaLex=$auChExToEx-$auChExCLExPr;//Autres charges d'exploitation
        $dExPaLex=$dExToEx-$dExCLExPr; //Dotations d'exploitation
        // total II
        $totalIIPaLex=$achReMPaLex+$achCMDPaLex+$autChExPaLex+$imetPaLex+$chPrPaLex+$auChExPaLex+$dExPaLex;
        $totalIICLExPr==$achReMCLExPr+$achCMDCLExPr+$autChExCLExPr+$imetCLExPr+$chPrCLExPr+$auChExCLExPr+$dExCLExPr;
        $totalIIToEx=$achReMToEx+$achCMDToEx+$autChExToEx+$imetToEx+$chPrToEx+$auChExToEx+=$dExToEx;
        $totalIIExPre=$achReMExPre+$achCMDExPre+ $autChExExPre+=$imetExPre+$chPrExPre+$auChExExPre+$dExExPre;
        $totalIIExN2=$achReMExN2+$achCMDExN2+$autChExExN2+$imetExN2+$chPrExN2+$auChExExN2+$dExExN2;
        // III - RESULTAT D'EXPLOITATION  ( I - II )
        $reExI_IIToEx=$totalIToEx-$totalIIToEx;
        $reExI_IIExPre=$totalIExPre+$totalIIExPre;
        $reExI_IIExN2=$totalIExN2+$totalIIExN2;
        $prTPPaLex=$prTPToEx-$prTPCLExPr; //Produits des titres de partic. et autres titres immo
        $gaChPaLex=$gaChToEx-$gaChCLExPr; //Gains de change
        $inAPFPaLex=$inAPFToEx+$inAPFCLExPr;//Intérêts et autres produits financiers
        $reFTChPaLex=$reFTChToEx+$reFTChCLExPr;//Reprises financières; transfert de charges
        // TOTAL  IV
        $totalIVPaLex=$prTPPaLex+$gaChPaLex+$inAPFPaLex+$reFTChPaLex;
        $totalIVCLExPr=$prTPCLExPr+$gaChCLExPr+$inAPFCLExPr+$reFTChCLExPr;
        $totalIVToEx=$prTPToEx+$gaChToEx+$inAPFToEx+$reFTChToEx;
        $totalIVExPre=$prTPExPre+$gaChExPre+$inAPFExPre+$reFTChExPre;
        $totalIVExN2=$prTPExN2+$gaChExN2+$inAPFExN2+$reFTChExN2;
        $chiPaLex=$chiToEx+$chiCLExPr;//Charges d'intérêts
        $peChPaLex=$peChToEx - $peChCLExPr; //Pertes de changes
        $auChFPaLex=$auChFToEx-$auChFCLExPr;//Autres charges financières
        $doFPaLex=  $doFToEx-$doFCLExPr;//Dotations financières
         // TOTAL V
        $totalVPaLex= $chiPaLex+ $peChPaLex+$auChFPaLex+ $doFPaLex;
        $totalVCLExPr=$chiCLExPr+$peChCLExPr+$auChFCLExPr+ $doFCLExPr;
        $totalVToEx=$chiToEx+$peChToEx+$auChFToEx+$doFToEx;
        $totalVExPre=$chiExPre+$peChExPre+$auChFExPre+ $doFExPre;
        $totalVExN2=$chiExN2+$peChExN2+$auChFExN2+$doFExN2;
        //RESULTAT FINANCIER ( IV - V )
        $reFToEx=$totalIVToEx-$totalVToEx;
        $reFExPre=$totalIVExPre-$totalVExPre;
        $totalVExN2=$totalIVExN2-$totalVExN2;
        //RESULTAT COURANT ( III - V I)
        $reCoToEx=$reExI_IIToEx+$prTPToEx+$gaChToEx+$inAPFToEx+$reFTChToEx+$totalIVToEx+$chiToEx+$peChToEx+$auChFToEx+ $doFToEx+$totalVToEx+$reFToEx;
        $reCoExPre=$reExI_IIExPre+$prTPExPre+$gaChExPre+$inAPFExPre+$reFTChExPre+$totalIVExPre+$chiExPre+$peChExPre+$auChFExPre+ $doFExPre+$totalVExPre+$reFExPre;
        $reCoExN2=$reExI_IIExN2+$prTPExN2+$gaChExN2+$inAPFExN2+$reFTChExN2+$totalIVExN2+$chiExN2+$peChExN2+$auChFExN2+ $doFExN2+$totalVExN2+$reFExN2;
        //RESULTAT COURANT ( Report )
        $reTCToEx=$reCoToEx;
        $reTCExPre=$reCoExPre;
        $reTCExN2=$reCoExN2;
        $proDCIPaLex=$proDCIToEx-$proDCICLExPr;//Produits des cessions d'immobilisations
        $subDEPaLex=$subDEToEx-$subDECLExPr;//Subventions d'équilibre
        $reSDPaLex=$reSDToEx-$reSDCLExPr;//Reprises sur subventions d'investissement
        $auPrCPaLex=$auPrCToEx-$auPrCCLExPr;//Autres produits non courants
        $reCTCPaLex=$reCTCToEx-$reCTCCLExPr;//Reprises non courantes; transferts de charges
        //TOTAL  VIII
        $totalVIIIPaLex=$proDCIPaLex+$subDEPaLex+$reSDPaLex+$auPrCPaLex+$reCTCPaLex;
        $totalVIIICLExPr=$proDCICLExPr+$subDECLExPr+$reSDCLExPr+$auPrCCLExPr+$reCTCCLExPr;
        $totalVIIIToEx=$proDCIToEx+$subDEToEx+$reSDToEx+$auPrCToEx+$reCTCToEx;
        $totalVIIIExPre=$proDCIExPre+$subDEExPre+$reSDExPre+$auPrCExPre+$reCTCExPre;
        $totalVIIIExN2=$proDCIExN2+$subDEExN2+$reSDExN2+$auPrCExN2+$reCTCExN2;
        $vaNAICPaLex=$vaNAICToEx-$vaNAICCLExPr; //Valeurs nettes d'amortis. des immos cédées
        $suAcPaLex=$suAcToEx-$suAcCLExPr;//Subventions accordées
        $auCNCPaLex=$auCNCToEx-$auCNCCLExPr;//Autres charges non courantes
        $daCAPPaLex=$daCAPToEx-$daCAPCLExPr; //Dotations non courantes aux amortiss. et prov.
        //TOTAL  IX
        $totalIXPaLex=$vaNAICPaLex+$suAcPaLex+$auCNCPaLex+$daCAPPaLex;
        $totalIXCLExPr=$vaNAICCLExPr+$suAcCLExPr+$auCNCCLExPr+$daCAPCLExPr;
        $totalIXToEx=$vaNAICToEx+$suAcToEx+$auCNCToEx+$daCAPToEx;
        $totalIXExPre=$vaNAICExPre+$suAcExPre+$auCNCExPre+$daCAPExPre;
        $totalIXExN2=$vaNAICExN2+$suAcExN2+$auCNCExN2+$daCAPExN2;
        //X - RESULTAT NON COURANT ( VIII- IV )
        $XReNCToEx=$totalVIIIToEx-$totalIXToEx;
        $XReNCExPre=$totalVIIIExPre-$totalIXExPre;
        $XReNCExN2=$totalVIIIExN2-$totalIXExN2;
        //XI - RESULTAT AVANT IMPOTS ( VII+ X )
        $xiResulAIToEx=$reTCToEx+$proDCIToEx+$subDEToEx+$reSDToEx+$auPrCToEx+$reCTCToEx+$totalVIIIToEx+$vaNAICToEx+$suAcToEx+$auCNCToEx+$daCAPToEx+$totalIXToEx+ $XReNCToEx;
        $xiResulAIExPre=$reTCExPre+$proDCIExPre+$subDEExPre+$reSDExPre+$auPrCExPre+$reCTCExPre+$totalVIIIExPre+$vaNAICExPre+$suAcExPre+$auCNCExPre+$daCAPExPre+$totalIXExPre+$XReNCExPre;
        $xiResulAIExN2=$reTCExN2+$proDCIExN2+$subDEExN2+$reSDExN2+$auPrCExN2+$reCTCExN2+$totalVIIIExN2+$vaNAICExN2+$suAcExN2+$auCNCExN2+$daCAPExN2+$totalIXExN2+$XReNCExN2;
        $xiiIMSLRPaLex= $xiiIMSLRToEx- $xiiIMSLRCLExPr;//XII - IMPOTS SUR LES RESULTATS
        // XIII - RESULTAT NET ( XI - XII )
        $xiiReNToEx=$xiResulAIToEx-$xiiIMSLRToEx;
        $xiiReNExPre=$xiResulAIExPre-$xiiIMSLRExPre;
        $xiiReNExN2=$xiResulAIExN2-$xiiIMSLRExN2;
        //XIV - TOTAL DES PRODUITS ( I + IV + VIII )
        $xivToDPrToEx=$totalIToEx+$totalIVToEx+$totalVIIIToEx;
        $xivToDPrExPre=$totalIExPre+$totalIVExPre+$totalVIIIExPre;
        $xivToDPrExN2=$totalIExN2+$totalIVExN2+$totalVIIIExN2;
        // XV - TOTAL DES CHARGES ( II + V + IX + XII )
        $xvToDCHToEx=$xiiIMSLRToEx+$totalIXToEx+$totalVToEx+$totalIIToEx;
        $xvToDCHExPre=$xiiIMSLRExPre+$totalIXExPre+$totalVExPre+$totalIIExPre;
        $xvToDCHExN2=$xiiIMSLRExN2+$totalIXExN2+$totalVExN2+$totalIIExN2;
        //XVI - RESULTAT NET ( XIV - XV )
        $xviReNToEx= $xivToDPrToEx- $xvToDCHToEx;
        $xviReNExPre=$xivToDPrExPre-$xvToDCHExPre;
        $xviReNExN2=$xivToDPrExN2-$xvToDCHExN2;
    }





?>