<?php
  // Load Dolibarr environment
  require_once '../../../main.inc.php';
  require_once '../../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
  require_once '../functionDeclarationLaisse.php';

 

  // 'E' : Exercice  / 'EP' : Exercice Precedent  / 'E2' :  Exercice n-2 

  $dateChoisis=0;
  $venteMarch_E=$venteMarch_EP=$venteMarch_E2=0; //Ventes de marchandises
  $achatReMarch_E=$achatReMarch_EP=$achatReMarch_E2=0;// Achats revendus de marchandises
  $marchB_E=$marchB_EP=$marchB_E2=0;// MARGES BRUTES SUR VENTES EN L'ETAT	
  $ProdExe_E=$ProdExe_EP=$ProdExe_E2=0;// PRODUCTION DE L'EXERCICE (3+4+5)
  $venteServ_E=$venteServ_EP=$venteServ_E2=0;// Ventes de biens et services produits
  $varStock_E=$varStock_EP=$varStock_E2=0;// Variation de stocks de produits
  $immobiProd_E=$immobiProd_EP=$immobiProd_E2=0;// Immobilisations produites par l'entreprise pour elle même
  $achatCons_E=$achatCons_EP=$achatCons_E2=0;// Achats consommés de matières et fournitures
  $autreCharge_E=$autreCharge_EP=$autreCharge_E2=0;// Autres charges externes	
  $subExp_E=$subExp_EP=$subExp_E2=0;// Subventions d'exploitation
  $impotTaxe_E=$impotTaxe_EP=$impotTaxe_E2=0;// Impôts et taxes
  $chargePers_E=$chargePers_EP=$chargePers_E2=0;// Charges de personnel
  $autresProd_E=$autresProd_EP=$autresProd_E2=0;// Autres produits d'exploitation	
  $autresCharg_E=$autresCharg_EP=$autresCharg_E2=0;// Autres charges d'exploitation	
  $reprisesExpl_E=$reprisesExpl_EP=$reprisesExpl_E2=0;// Reprises d'exploitation: transfert de charges	
  $dotationExpl_E=$dotationExpl_EP=$dotationExpl_E2=0;// Dotations d'exploitation	
  $resultatFin1_E=$resultatFin1_EP=$resultatFin1_E2=$resultatFin2_E=$resultatFin2_EP=$resultatFin2_E2=0;// RESULTAT FINANCIER
  $resultatNonCrt1_E=$resultatNonCrt1_EP=$resultatNonCrt1_E2=$resultatNonCrt2_E=$resultatNonCrt2_EP=$resultatNonCrt2_E2=0;// RESULTAT NON COURANT ( + ou - )
  $impotRest_E=$impotRest_EP=$impotRest_E2=0;// Impôts sur les resultats
  $dotationExpl2_E=$dotationExpl2_EP=$dotationExpl2_E2=0;// Dotations d'exploitation
  $dotationfin1_E=$dotationfin1_EP=$dotationfin1_E2=$dotationfin2_E=$dotationfin2_EP=$dotationfin2_E2=$dotationfin3_E=$dotationfin3_EP=$dotationfin3_E2=0;// Dotations financières
  $dotationNonCour1_E=$dotationNonCour1_EP=$dotationNonCour1_E2=$dotationNonCour2_E=$dotationNonCour2_EP=$dotationNonCour2_E2=0;// Dotations non courantes
  $reprisesExpl1_E=$reprisesExpl1_EP=$reprisesExpl1_E2=$reprisesExpl2_E=$reprisesExpl2_EP=$reprisesExpl2_E2=$reprisesExpl3_E=$reprisesExpl3_EP=$reprisesExpl3_E2=0;// Reprises d'exploitation
  $repriseFin1_E=$repriseFin1_EP=$repriseFin1_E2=$repriseFin2_E=$repriseFin2_EP=$repriseFin2_E2=$repriseFin3_E=$repriseFin3_EP=$repriseFin3_E2=$repriseFin4_E=$repriseFin3_EP=$repriseFin3_E2=0;// Reprises financières
  $repriseNonCour1_E=$repriseNonCour1_EP=$repriseNonCour1_E2=$repriseNonCour2_E=$repriseNonCour2_EP=$repriseNonCour2_E2=$repriseNonCour3_E=$repriseNonCour3_EP=$repriseNonCour3_E2=$repriseNonCour4_E=$repriseNonCour4_EP=$repriseNonCour4_E2=$repriseNonCour5_E=$repriseNonCour5_EP=$repriseNonCour5_E2=0;// Reprises non courantes
  $prodImmb_E=$prodImmb_EP=$prodImmb_E2=0; // Produits des cession des immobilisations
  $valNetImmb_E=$valNetImmb_EP=$valNetImmb_E2=0;// Valeurs nettes des immobilisations cédées

  


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
          case '711' : list($venteMarch_E,$venteMarch_EP,$venteMarch_E2) = calculateMontant($dateCreation,$dateChoisis,$venteMarch_E,$venteMarch_EP,$venteMarch_E2,'711'); break;
          case '611' : list($achatReMarch_E,$achatReMarch_EP,$achatReMarch_E2) = calculateMontant($dateCreation,$dateChoisis,$achatReMarch_E,$achatReMarch_EP,$achatReMarch_E2,'611'); break;
          case '712' : list($venteServ_E,$venteServ_EP,$venteServ_E2) = calculateMontant($dateCreation,$dateChoisis,$venteServ_E,$venteServ_EP,$venteServ_E2,'712'); break;
          case '713' : list($varStock_E,$varStock_EP,$varStock_E2) = calculateMontant($dateCreation,$dateChoisis,$varStock_E,$varStock_EP,$varStock_E2,'713'); break;
          case '714' : list($immobiProd_E,$immobiProd_EP,$immobiProd_E2) = calculateMontant($dateCreation,$dateChoisis,$immobiProd_E,$immobiProd_EP,$immobiProd_E2,'714'); break;
          case '612' : list($achatCons_E,$achatCons_EP,$achatCons_E2) = calculateMontant($dateCreation,$dateChoisis,$achatCons_E,$achatCons_EP,$achatCons_E2,'612'); break;
          case '613' : list($autreCharge_E,$autreCharge_EP,$autreCharge_E2) = calculateMontant($dateCreation,$dateChoisis,$autreCharge_E,$autreCharge_EP,$autreCharge_E2,'613'); break;
          case '716' : list($subExp_E,$subExp_EP,$subExp_E2) = calculateMontant($dateCreation,$dateChoisis,$subExp_E,$subExp_EP,$subExp_E2,'716'); break;
          case '616' : list($impotTaxe_E,$impotTaxe_EP,$impotTaxe_E2) = calculateMontant($dateCreation,$dateChoisis,$impotTaxe_E,$impotTaxe_EP,$impotTaxe_E2,'616'); break;
          case '617' : list($chargePers_E,$chargePers_EP,$chargePers_E2) = calculateMontant($dateCreation,$dateChoisis,$chargePers_E,$chargePers_EP,$chargePers_E2,'617'); break;
          case '718' : list($autresProd_E,$autresProd_EP,$autresProd_E2) = calculateMontant($dateCreation,$dateChoisis,$autresProd_E,$autresProd_EP,$autresProd_E2,'718'); break;
          case '618' : list($autresCharg_E,$autresCharg_EP,$autresCharg_E2) = calculateMontant($dateCreation,$dateChoisis,$autresCharg_E,$autresCharg_EP,$autresCharg_E2,'618'); break;
          case '719' : list($reprisesExpl_E,$reprisesExpl_EP,$reprisesExpl_E2) = calculateMontant($dateCreation,$dateChoisis,$reprisesExpl_E,$reprisesExpl_EP,$reprisesExpl_E2,'719'); break;
          case '619' : list($dotationExpl_E,$dotationExpl_EP,$dotationExpl_E2) = calculateMontant($dateCreation,$dateChoisis,$dotationExpl_E,$dotationExpl_EP,$dotationExpl_E2,'619'); break;
          case '73' : list($resultatFin1_E,$resultatFin1_EP,$resultatFin1_E2) = calculateMontant($dateCreation,$dateChoisis,$resultatFin1_E,$resultatFin1_EP,$resultatFin1_E2,'73'); break;
          case '63' : list($resultatFin2_E,$resultatFin2_EP,$resultatFin2_E2) = calculateMontant($dateCreation,$dateChoisis,$resultatFin2_E,$resultatFin2_EP,$resultatFin2_E2,'63'); break;
          case '75' : list($resultatNonCrt1_E,$resultatNonCrt1_EP,$resultatNonCrt1_E2) = calculateMontant($dateCreation,$dateChoisis,$resultatNonCrt1_E,$resultatNonCrt1_EP,$resultatNonCrt1_E2,'75'); break;
          case '65' : list($resultatNonCrt2_E,$resultatNonCrt2_EP,$resultatNonCrt2_E2) = calculateMontant($dateCreation,$dateChoisis,$resultatNonCrt2_E,$resultatNonCrt2_EP,$resultatNonCrt2_E2,'65'); break;
          case '67' : list($impotRest_E,$impotRest_EP,$impotRest_E2) = calculateMontant($dateCreation,$dateChoisis,$impotRest_E,$impotRest_EP,$impotRest_E2,'67'); break;
          case '6196' : list($dotationExpl2_E,$dotationExpl2_EP,$dotationExpl2_E2) = calculateMontant($dateCreation,$dateChoisis,$dotationExpl2_E,$dotationExpl2_EP,$dotationExpl2_E2,'6196'); break;
          case '639' : list($dotationfin1_E,$dotationfin1_EP,$dotationfin1_E2) = calculateMontant($dateCreation,$dateChoisis,$dotationfin1_E,$dotationfin1_EP,$dotationfin1_E2,'639'); break;
          case '6396' : list($dotationfin2_E,$dotationfin2_EP,$dotationfin2_E2) = calculateMontant($dateCreation,$dateChoisis,$dotationfin2_E,$dotationfin2_EP,$dotationfin2_E2,'6396'); break;
          case '6393' : list($dotationfin3_E,$dotationfin3_EP,$dotationfin3_E2) = calculateMontant($dateCreation,$dateChoisis,$dotationfin3_E,$dotationfin3_EP,$dotationfin3_E2,'6393'); break;
          case '659' : list($dotationNonCour1_E,$dotationNonCour1_EP,$dotationNonCour1_E2) = calculateMontant($dateCreation,$dateChoisis,$dotationNonCour1_E,$dotationNonCour1_EP,$dotationNonCour1_E2,'659'); break;
          case '65963' : list($dotationNonCour2_E,$dotationNonCour2_EP,$dotationNonCour2_E2) = calculateMontant($dateCreation,$dateChoisis,$dotationNonCour2_E,$dotationNonCour2_EP,$dotationNonCour2_E2,'65963'); break;
          case '7196' : list($reprisesExpl1_E,$reprisesExpl1_EP,$reprisesExpl1_E2) = calculateMontant($dateCreation,$dateChoisis,$reprisesExpl1_E,$reprisesExpl1_EP,$reprisesExpl1_E2,'7196'); break;
          case '7197' : list($reprisesExpl2_E,$reprisesExpl2_EP,$reprisesExpl2_E2) = calculateMontant($dateCreation,$dateChoisis,$reprisesExpl2_E,$reprisesExpl2_EP,$reprisesExpl2_E2,'7197'); break;
          case '7198' : list($reprisesExpl3_E,$reprisesExpl3_EP,$reprisesExpl3_E2) = calculateMontant($dateCreation,$dateChoisis,$reprisesExpl3_E,$reprisesExpl3_EP,$reprisesExpl3_E2,'7198'); break;
          case '739' : list($repriseFin1_E,$repriseFin1_EP,$repriseFin1_E2) = calculateMontant($dateCreation,$dateChoisis,$repriseFin1_E,$repriseFin1_EP,$repriseFin1_E2,'739'); break;
          case '7396' : list($repriseFin2_E,$repriseFin2_EP,$repriseFin2_E2) = calculateMontant($dateCreation,$dateChoisis,$repriseFin2_E,$repriseFin2_EP,$repriseFin2_E2,'7396'); break;
          case '7397' : list($repriseFin3_E,$repriseFin3_EP,$repriseFin3_E2) = calculateMontant($dateCreation,$dateChoisis,$repriseFin3_E,$repriseFin3_EP,$repriseFin3_E2,'7397'); break;
          case '7393' : list($repriseFin4_E,$repriseFin4_EP,$repriseFin4_E2) = calculateMontant($dateCreation,$dateChoisis,$repriseFin4_E,$repriseFin4_EP,$repriseFin4_E2,'7393'); break;
          case '759' : list($repriseNonCour1_E,$repriseNonCour1_EP,$repriseNonCour1_E2) = calculateMontant($dateCreation,$dateChoisis,$repriseNonCour1_E,$repriseNonCour1_EP,$repriseNonCour1_E2,'759'); break;
          case '75963' : list($repriseNonCour2_E,$repriseNonCour2_EP,$repriseNonCour2_E2) = calculateMontant($dateCreation,$dateChoisis,$repriseNonCour2_E,$repriseNonCour2_EP,$repriseNonCour2_E2,'75963'); break;
          case '7597' : list($repriseNonCour3_E,$repriseNonCour3_EP,$repriseNonCour3_E2) = calculateMontant($dateCreation,$dateChoisis,$repriseNonCour3_E,$repriseNonCour3_EP,$repriseNonCour3_E2,'7597'); break;
          case '7598' : list($repriseNonCour4_E,$repriseNonCour4_EP,$repriseNonCour4_E2) = calculateMontant($dateCreation,$dateChoisis,$repriseNonCour4_E,$repriseNonCour4_EP,$repriseNonCour4_E2,'7598'); break;
          case '7595' : list($repriseNonCour5_E,$repriseNonCour5_EP,$repriseNonCour5_E2) = calculateMontant($dateCreation,$dateChoisis,$repriseNonCour5_E,$repriseNonCour5_EP,$repriseNonCour5_E2,'7595'); break;
          case '751' : list($prodImmb_E,$prodImmb_EP,$prodImmb_E2) = calculateMontant($dateCreation,$dateChoisis,$prodImmb_E,$prodImmb_EP,$prodImmb_E2,'751'); break;
          case '651' : list($valNetImmb_E,$valNetImmb_EP,$valNetImmb_E2) = calculateMontant($dateCreation,$dateChoisis,$valNetImmb_E,$valNetImmb_EP,$valNetImmb_E2,'651'); break;

          default:$default=$montant;break;

      }
  }

  // Calcule Total MARGES BRUTES SUR VENTES EN L'ETAT	 Exercice/Exercice pre/Exercice n-2
  $marchB_E=$venteMarch_E-$achatReMarch_E;
  $marchB_EP=$venteMarch_EP-$achatReMarch_EP;
  $marchB_E2=$venteMarch_E2-$achatReMarch_E2;

  // Calcule PRODUCTION DE L'EXERCICE (3+4+5)
  $prodExe_E=$venteServ_E+$varStock_E+$immobiProd_E;
  $prodExe_EP=$venteServ_EP+$varStock_EP+$immobiProd_EP;
  $prodExe_E2=$venteServ_E2+$varStock_E2+$immobiProd_E2;

  // Calcule CONSOMMATION DE L'EXERCICE (6+7)
  $ConsExe_E=$achatCons_E+$autreCharge_E;
  $ConsExe_EP=$achatCons_EP+$autreCharge_EP;
  $ConsExe_E2=$achatCons_E2+$autreCharge_E2;

  // Calcule Total VALEUR AJOUTEE ( I+II+III )	
  $valAjout_E=$marchB_E+$prodExe_E+$ConsExe_E;
  $valAjout_EP=$marchB_EP+$prodExe_EP+$ConsExe_EP;
  $valAjout_E2=$marchB_E2+$prodExe_E2+$ConsExe_E2;

  // Calcule Total EXCEDENT BRUT D'EXPLOITATION ( E.B.E )
  $ExcedentB_E=$valAjout_E+$subExp_E+$impotTaxe_E+$chargePers_E;
  $ExcedentB_EP=$valAjout_EP+$subExp_EP+$impotTaxe_EP+$chargePers_EP;
  $ExcedentB_E2=$valAjout_E2+$subExp_E2+$impotTaxe_E2+$chargePers_E2;

  // Calcule Total RESULTAT D'EXPLOITATION ( + ou - )
  $resultatExpl_E=$autresProd_E+$autresCharg_E+$reprisesExpl_E+$dotationExpl_E=0;
  $resultatExpl_EP=$autresProd_EP+$autresCharg_EP+$reprisesExpl_EP+$dotationExpl_EP=0;
  $resultatExpl_E2=$autresProd_E2+$autresCharg_E2+$reprisesExpl_E2+$dotationExpl_E2=0;

  // Calcule RESULTAT FINANCIER
  $resultatFin_E=-$resultatFin1_E-$resultatFin2_E;
  $resultatFin_EP=-$resultatFin1_EP-$resultatFin2_EP;
  $resultatFin_E2=-$resultatFin1_E2-$resultatFin2_E2;

  // Calcule Totale RESULTAT COURANT ( + ou - )
  $resultatCrt_E=$resultatExpl_E+$resultatFin_E;
  $resultatCrt_EP=$resultatExpl_EP+$resultatFin_EP;
  $resultatCrt_E2=$resultatExpl_E2+$resultatFin_E2;

  // Calcule RESULTAT NON COURANT ( + ou - )
  $resultatNonCrt_E=-$resultatNonCrt1_E-$resultatNonCrt2_E;
  $resultatNonCrt_EP=-$resultatNonCrt1_EP-$resultatNonCrt2_EP;
  $resultatNonCrt_E2=-$resultatNonCrt1_E2-$resultatNonCrt2_E2;

  // Calcule Totale RESULTAT NET DE L'EXERCICE ( + ou - )
  $resultatNetExe_E=$resultatCrt_E+$resultatNonCrt_E+$impotRest_E=0;
  $resultatNetExe_EP=$resultatCrt_EP+$resultatNonCrt_EP+$impotRest_EP=0;
  $resultatNetExe_E2=$resultatCrt_E2+$resultatNonCrt_E2+$impotRest_E2=0;

  // Calcule - Benefice (+)
  $benefice_E=($resultatNetExe_E>0)?$resultatNetExe_E:0;
  $benefice_EP=($resultatNetExe_EP>0)?$resultatNetExe_EP:0;
  $benefice_E2=($resultatNetExe_E2>0)?$resultatNetExe_E2:0;

  // Calcule - Perte (-)
  $perte_E=($resultatNetExe_E<0)?$resultatNetExe_E:0;
  $perte_EP=($resultatNetExe_EP<0)?$resultatNetExe_EP:0;
  $perte_E2=($resultatNetExe_E2<0)?$resultatNetExe_E2:0;

  // Calcule Dotations d'exploitation
  $datatExpl_E=$dotationExpl_E-$dotationExpl2_E;
  $datatExpl_EP=$dotationExpl_EP-$dotationExpl2_EP;
  $datatExpl_E2=$dotationExpl_E-$dotationExpl2_E2;

  // Calcule Dotations financières
  $dotationfin_E=$dotationfin1_E-$dotationfin2_E-$dotationfin3_E;
  $dotationfin_EP=$dotationfin1_EP-$dotationfin2_EP-$dotationfin3_EP;
  $dotationfin_E2=$dotationfin1_E2-$dotationfin2_E2-$dotationfin3_E2;

  // Calcule Dotations non courantes
  $dotationNonCour_E=$dotationNonCour1_E-$dotationNonCour2_E;
  $dotationNonCour_EP=$dotationNonCour1_EP-$dotationNonCour2_EP;
  $dotationNonCour_E2=$dotationNonCour1_E2-$dotationNonCour2_E2;

  // Calcule 	Reprises d'exploitation
  $reprExpl_E=-$reprisesExpl_E+$reprisesExpl1_E+$reprisesExpl2_E+$reprisesExpl3_E;
  $reprExpl_EP=-$reprisesExpl_EP+$reprisesExpl1_EP+$reprisesExpl2_EP+$reprisesExpl3_EP;
  $reprExpl_E2=-$reprisesExpl_E2+$reprisesExpl1_E2+$reprisesExpl2_E2+$reprisesExpl3_E2;

  // Calcule Reprises financières
  $repriseFin_E=-$repriseFin1_E+$repriseFin2_E+$repriseFin3_E+$repriseFin4_E;
  $repriseFin_EP=-$repriseFin1_EP+$repriseFin2_EP+$repriseFin3_EP+$repriseFin4_E;
  $repriseFin_E2=-$repriseFin1_E2+$repriseFin2_E2+$repriseFin3_E2+$repriseFin4_E;

  // Calcule Reprises non courantes
  $repNonCour_E=-$repriseNonCour1_E+$repriseNonCour2_E+$repriseNonCour3_E+$repriseNonCour4_E+$repriseNonCour5_E;
  $repNonCour_EP=-$repriseNonCour1_EP+$repriseNonCour2_EP+$repriseNonCour3_EP+$repriseNonCour4_EP+$repriseNonCour5_EP;
  $repNonCour_E2=-$repriseNonCour1_E2+$repriseNonCour2_E2+$repriseNonCour3_E2+$repriseNonCour4_E2+$repriseNonCour5_E2;

  // Calcule CAPACITE D'AUTOFINANCEMENT  ( C.A.F )
  $CAF_E=$benefice_E-$perte_E+$datatExpl_E+$dotationfin_E+$dotationNonCour_E-$reprExpl_E-$repriseFin_E-$repNonCour_E-$prodImmb_E+$valNetImmb_E;
  $CAF_EP=$benefice_EP-$perte_EP+$datatExpl_EP+$dotationfin_EP+$dotationNonCour_EP-$reprExpl_EP-$repriseFin_EP-$repNonCour_EP-$prodImmb_EP+$valNetImmb_EP;
  $CAF_E2=$benefice_E2-$perte_E2+$datatExpl_E2+$dotationfin_E2+$dotationNonCour_E2-$reprExpl_E2-$repriseFin_E2-$repNonCour_E2-$prodImmb_E2+$valNetImmb_E2;

  // Calcule AUTOFINANCEMENT
  $autofin_E=$CAF_E-0;
  $autofin_EP=$CAF_EP-0;
  $autofin_E2=$CAF_E2-0;


   
  $data = "<?php ";


  $data .= '$venteMarch_E = ' . $venteMarch_E . ";\n";
  $data .= '$venteMarch_EP = ' . $venteMarch_EP . ";\n";
  $data .= '$venteMarch_E2 = ' . $venteMarch_E2 . ";\n";
  $data .= '$achatReMarch_E = ' . $achatReMarch_E . ";\n";
  $data .= '$achatReMarch_EP = ' . $achatReMarch_EP . ";\n";
  $data .= '$achatReMarch_E2 = ' . $achatReMarch_E2 . ";\n";
  $data .= '$marchB_E = ' . $marchB_E . ";\n";
  $data .= '$marchB_EP = ' . $marchB_EP . ";\n";
  $data .= '$marchB_E2 = ' . $marchB_E2 . ";\n";
  $data .= '$prodExe_E = ' . $prodExe_E . ";\n";
  $data .= '$prodExe_EP = ' . $prodExe_EP . ";\n";
  $data .= '$prodExe_E2 = ' . $prodExe_E2 . ";\n";
  $data .= '$venteServ_E = ' . $venteServ_E . ";\n";
  $data .= '$prodExe_EP = ' . $venteServ_EP . ";\n";
  $data .= '$prodExe_E2 = ' . $venteServ_E2 . ";\n";
  $data .= '$varStock_E = ' . $varStock_E . ";\n";
  $data .= '$varStock_EP = ' . $varStock_EP . ";\n";
  $data .= '$varStock_E2 = ' . $varStock_E2 . ";\n";
  $data .= '$immobiProd_E = ' . $immobiProd_E . ";\n";
  $data .= '$immobiProd_EP = ' . $immobiProd_EP . ";\n";
  $data .= '$immobiProd_E2 = ' . $immobiProd_E2 . ";\n";
  $data .= '$ConsExe_E = ' . $ConsExe_E . ";\n";
  $data .= '$ConsExe_EP = ' . $ConsExe_EP . ";\n";
  $data .= '$ConsExe_E2 = ' . $ConsExe_E2 . ";\n";
  $data .= '$achatCons_E = ' . $achatCons_E . ";\n";
  $data .= '$achatCons_EP = ' . $achatCons_EP . ";\n";
  $data .= '$achatCons_E2 = ' . $achatCons_E2 . ";\n";
  $data .= '$autreCharge_E = ' . $autreCharge_E . ";\n";
  $data .= '$autreCharge_EP = ' . $autreCharge_EP . ";\n";
  $data .= '$autreCharge_E2 = ' . $autreCharge_E2 . ";\n";
  $data .= '$valAjout_E = ' . $valAjout_E . ";\n";
  $data .= '$valAjout_EP = ' . $valAjout_EP . ";\n";
  $data .= '$valAjout_E2 = ' . $valAjout_E2 . ";\n";
  $data .= '$subExp_E = ' . $subExp_E . ";\n";
  $data .= '$subExp_EP = ' . $subExp_EP . ";\n";
  $data .= '$subExp_E2 = ' . $subExp_E2 . ";\n";
  $data .= '$impotTaxe_E = ' . $impotTaxe_E . ";\n";
  $data .= '$impotTaxe_EP = ' . $impotTaxe_EP . ";\n";
  $data .= '$impotTaxe_E2 = ' . $impotTaxe_E2 . ";\n";
  $data .= '$chargePers_E = ' . $chargePers_E . ";\n";
  $data .= '$chargePers_EP = ' . $chargePers_EP . ";\n";
  $data .= '$chargePers_E2 = ' . $chargePers_E2 . ";\n";
  $data .= '$ExcedentB_E = ' . $ExcedentB_E . ";\n";
  $data .= '$ExcedentB_EP = ' . $ExcedentB_EP . ";\n";
  $data .= '$ExcedentB_E2 = ' . $ExcedentB_E2 . ";\n";
  $data .= '$autresProd_E = ' . $autresProd_E . ";\n";
  $data .= '$autresProd_EP = ' . $autresProd_EP . ";\n";
  $data .= '$autresProd_E2 = ' . $autresProd_E2 . ";\n";
  $data .= '$autresCharg_E = ' . $autresCharg_E . ";\n";
  $data .= '$autresCharg_EP = ' . $autresCharg_EP . ";\n";
  $data .= '$autresCharg_E2 = ' . $autresCharg_E2 . ";\n";
  $data .= '$reprisesExpl_E = ' . $reprisesExpl_E . ";\n";
  $data .= '$reprisesExpl_EP = ' . $reprisesExpl_EP . ";\n";
  $data .= '$reprisesExpl_E2 = ' . $reprisesExpl_E2 . ";\n";
  $data .= '$dotationExpl_E = ' . $dotationExpl_E . ";\n";
  $data .= '$dotationExpl_EP = ' . $dotationExpl_EP . ";\n";
  $data .= '$dotationExpl_E2 = ' . $dotationExpl_E2 . ";\n";
  $data .= '$resultatExpl_E = ' . $resultatExpl_E . ";\n";
  $data .= '$resultatExpl_EP = ' . $resultatExpl_EP . ";\n";
  $data .= '$resultatExpl_E2 = ' . $resultatExpl_E2 . ";\n";
  $data .= '$resultatFin_E = ' . $resultatFin_E . ";\n";
  $data .= '$resultatFin_EP = ' . $resultatFin_EP . ";\n";
  $data .= '$resultatFin_E2 = ' . $resultatFin_E2 . ";\n";
  $data .= '$resultatCrt_E = ' . $resultatCrt_E . ";\n";
  $data .= '$resultatCrt_EP = ' . $resultatCrt_EP . ";\n";
  $data .= '$resultatCrt_E2 = ' . $resultatCrt_E2 . ";\n";
  $data .= '$resultatCrt_E = ' . $resultatNonCrt_E . ";\n";
  $data .= '$resultatCrt_EP = ' . $resultatNonCrt_EP . ";\n";
  $data .= '$resultatCrt_E2 = ' . $resultatNonCrt_E2 . ";\n";
  $data .= '$impotRest_E = ' . $impotRest_E . ";\n";
  $data .= '$impotRest_EP = ' . $impotRest_EP . ";\n";
  $data .= '$impotRest_E2 = ' . $impotRest_E2 . ";\n";
  $data .= '$resultatNetExe_E = ' . $resultatNetExe_E . ";\n";
  $data .= '$resultatNetExe_EP = ' . $resultatNetExe_EP . ";\n";
  $data .= '$resultatNetExe_E2 = ' . $resultatNetExe_E2 . ";\n";
  $data .= '$benefice_E = ' . $benefice_E . ";\n";
  $data .= '$benefice_EP = ' . $benefice_EP . ";\n";
  $data .= '$resultatNetExe_E2 = ' . $benefice_E2 . ";\n";
  $data .= '$perte_E = ' . $perte_E . ";\n";
  $data .= '$perte_EP = ' . $perte_EP . ";\n";
  $data .= '$perte_E2 = ' . $perte_E2 . ";\n";
  $data .= '$datatExpl_E = ' . $datatExpl_E . ";\n";
  $data .= '$datatExpl_EP = ' . $datatExpl_EP . ";\n";
  $data .= '$datatExpl_E2 = ' . $datatExpl_E2 . ";\n";
  $data .= '$dotationfin_E = ' . $dotationfin_E . ";\n";
  $data .= '$dotationfin_E = ' . $dotationfin_E . ";\n";
  $data .= '$dotationfin_E2 = ' . $dotationfin_E2 . ";\n";
  $data .= '$dotationNonCour_E = ' . $dotationNonCour_E . ";\n";
  $data .= '$dotationNonCour_EP = ' . $dotationNonCour_EP . ";\n";
  $data .= '$dotationNonCour_E2 = ' . $dotationNonCour_E2 . ";\n";
  $data .= '$reprExpl_E = ' . $reprExpl_E . ";\n";
  $data .= '$reprExpl_EP = ' . $reprExpl_EP . ";\n";
  $data .= '$reprExpl_E2 = ' . $reprExpl_E2 . ";\n";
  $data .= '$repriseFin_E = ' . $repriseFin_E . ";\n";
  $data .= '$repriseFin_EP = ' . $repriseFin_EP . ";\n";
  $data .= '$repriseFin_E2 = ' . $repriseFin_E2 . ";\n";
  $data .= '$repNonCour_E = ' . $repNonCour_E . ";\n";
  $data .= '$repNonCour_EP = ' . $repNonCour_EP . ";\n";
  $data .= '$repNonCour_E2 = ' . $repNonCour_E2 . ";\n";
  $data .= '$prodImmb_E = ' . $prodImmb_E . ";\n";
  $data .= '$prodImmb_EP = ' . $prodImmb_EP . ";\n";
  $data .= '$prodImmb_E2 = ' . $prodImmb_E2 . ";\n";
  $data .= '$valNetImmb_E = ' . $valNetImmb_E . ";\n";
  $data .= '$valNetImmb_EP = ' . $valNetImmb_EP . ";\n";
  $data .= '$valNetImmb_E2 = ' . $valNetImmb_E2 . ";\n";
  $data .= '$CAF_E = ' . $CAF_E . ";\n";
  $data .= '$CAF_EP = ' . $CAF_EP . ";\n";
  $data .= '$CAF_E2 = ' . $CAF_E2 . ";\n";
  $data .= '$autofin_E = ' . $autofin_E . ";\n";
  $data .= '$autofin_EP = ' . $autofin_EP . ";\n";
  $data .= '$autofin_E2 = ' . $autofin_E2 . ";\n";
 






$data .= "?>";
 // Now, the variable $year will contain the year value "2023"
 $nomFichier = 'ESG_fichier_'. $dateChoisis.'.php';
 // Écrire les données dans le nouveau fichier
 file_put_contents($nomFichier, $data);



?>