<?php
// Load Dolibarr environment
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
require_once '../functionDeclarationLaisse.php';


$dateChoisis=(isset($_POST['chargement']))?$_POST['date_select']:0;


if($dateChoisis!=0)
{
	include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/Passif/Passif_fichier_'.$dateChoisis.'.php';
	include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/Actif/Active_fichier_'.$dateChoisis.'.php';
}


	// E : Exercice
	// EP : Exercice précédent
	// VE : Variations a-b	Emplois
	// VR :  Variations a-b	Ressources

	// Financement Permanent
	$FP_E=$FP_EP=$FP_VE=$FP_VR=0;
    $FP_E= (isset($totalABCDE))?($totalABCDE*-1*-1):0;
	$FP_EP= (isset($totalABCDEN1))?($totalABCDEN1*-1*-1):0;
	//Moins actif immobilisé
	$MAI_E=$MAI_EP=$MAI_VE=$MAI_VR=0;
	$MAI_E=(isset($total1_net))?($total1_net):0;
	$MAI_EP=(isset($total1_EP))?($total1_EP):0;
	//Fonds de roulement fonctionnel (1-2) (A)
	$FDRF_E=$FDRF_EP=$FDRF_VE=$FDRF_VR=0;
	$FDRF_E=$FP_E-$MAI_E ;
	$FDRF_EP=$FP_EP-$MAI_EP;
	// Actif circulant
	$AC_E=$AC_EP=$AC_VE=$AC_VR=0;
	$AC_E=(isset($total2_net))?($total2_net):0;
	$AC_EP=(isset($total2_EP))?($total2_EP):0;
	// 	Moins passif circulant
	$MPC_E=$MPC_EP=$MPC_VE=$MPC_VR=0;
	$MPC_E=(isset($totalFGH))?($totalFGH*-1*-1):0;
	$MPC_EP=(isset($totalFGHN1))?($totalFGHN1*-1*-1):0;
	// Besoin de financement global (4-5) (B)
	$BDFG_E=$BDFG_EP=$BDFG_VE=$BDFG_VR=0;
	$BDFG_E=$AC_E-$MPC_E;
	$BDFG_EP=$AC_EP-$MPC_EP;
	//TRESORERIE NETTE (Actif-Passif) = A-B
	$TN_E=$TN_EP=$TN_VE=$TN_VR=0;
	$TN_E=$FDRF_E-$BDFG_E;
	$TN_EP=$FDRF_EP-$BDFG_EP;
    // EE : Exercice Emplois
	// ER : Exercice Ressources
	// EPE : Exercice précédent Emplois
	// EPR : Exercice précédent Ressources
	//Capacité d'autofinancement
	$CDA_ER=$CDA_EPR=0;
	$CDA_ER=(isset($CAF_E))?($CAF_E):0;;
	$CDA_EPR=(isset($CAF_EP))?($CAF_EP):0;
	//Autofinancement (A)
	$AU_ER=$AU_EPR=0;	
	//Cessions d'immobilisations incorporelles
	$CDII_ER=$CDII_EPR=0;
	// Cessions d'immobilisations corporelles
	$CDIC_ER=$CDIC_EPR=0;
	//Cessions d'immobilisations financières
	$CDIF_ER=$CDIF_EPR=0;
	//Cessions et reductions d'immobilisations (B)
	$CERDI_ER=$CERDI_EPR=0;
	//  Augmentation du capital , apports
	$ADCA_ER=$ADCA_EPR=0;
	$ADCA_ER1=$ADCA_ER2=$ADCA_ER3=0;
	$ADCA_ER4=$ADCA_ER5=$ADCA_ER6=0;
	//Subventions d'investissement
	$SDI_ER=$SDI_EPR=0;
	$SDI_ER1=$SDI_ER2=$SDI_ER3=0;
	//Augmentation des capitaux propres et assimiles (C)
	$ADCPEA_ER=$ADCPEA_EPR=0;
	//TOTAL I - RESSOURCES STABLES (A+B+C+D)
	$TRS_ER=$TRS_EPR=0;
	//Acquisitions d'immobilisations incorporelles
	$ADII_EE=$ADII_EPE=0;


	


	





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
			case "7512":list($CDII_ER, $CDII_EPR)=calculateMontant($dateCreation, $dateChoisis, $CDII_ER, $CDII_EPR,0,'7512');break;
			case "7513":list($CDIC_ER, $CDIC_EPR)=calculateMontant($dateCreation, $dateChoisis, $CDIC_ER, $CDIC_EPR,0,'7513');break;
			case "7514":list($CDIF_ER, $CDIF_EPR)=calculateMontant($dateCreation, $dateChoisis, $CDIF_ER, $CDIF_EPR,0,'7514');break;
			case "111":list($ADCA_ER1, $ADCA_ER2,$ADCA_ER3)=calculateMontant($dateCreation, $dateChoisis, $ADCA_ER1, $ADCA_ER2,$ADCA_ER3,'111');break;
			case "112":list($ADCA_ER4, $ADCA_ER5,$ADCA_ER6)=calculateMontant($dateCreation, $dateChoisis, $ADCA_ER4, $ADCA_ER5,$ADCA_ER6,'112');break;
			case "131":list($SDI_ER1, $SDI_ER2,$SDI_ER3)=calculateMontant($dateCreation, $dateChoisis, $SDI_ER1, $SDI_ER2,$SDI_ER3,'131');break;
		
		}
		$FP_VE=($FP_E>$FP_EP)?0:$FP_EP-$FP_E;
		$FP_VR=($FP_E>$FP_EP)?$FP_E-$FP_EP:0;
		$AU_ER=$CDA_ER;
	    $AU_EPR=$CDA_EPR;
		$TN_VE=($TN_E>$TN_EP)?$TN_E-$TN_EP:0;
		$TN_VR=($TN_E>$TN_EP)?0:$TN_EP-$TN_E;
		$ADCA_ER=$ADCA_ER1-$ADCA_ER2+$ADCA_ER4-$ADCA_ER5;
		$ADCA_EPR=$ADCA_ER2-$ADCA_ER3+$ADCA_ER5-$ADCA_ER6;
		$CERDI_ER=$CDII_ER+$CDIC_ER+$CDIF_ER;
    	$CERDI_EPR=$CDII_EPR+$CDIC_EPR+$CDIF_EPR;
		$MAI_VE=($MAI_E>$MAI_E)?$MAI_E-$MAI_E:0;
		$MAI_VR=($MAI_E>$MAI_E)?0:$MAI_E-$MAI_E;
		$FDRF_VE=($FDRF_E>$FDRF_EP)?0:$FDRF_EP-$FDRF_E;
		$FDRF_VR=($FDRF_E>$FDRF_EP)?$FDRF_E-$FDRF_EP:0;
		$AC_VE=($AC_E>$AC_EP)?$AC_E-$AC_EP:0;
		$AC_VR=($AC_E>$AC_EP)?0:$AC_EP-$AC_E;
		$MPC_VE=($MPC_E>$MPC_EP)?0:$MPC_EP-$MPC_E;
		$MPC_VR=($MPC_E>$MPC_EP)?$MPC_E-$MPC_EP:0;
		$BDFG_VE=($BDFG_E>$BDFG_EP)?$BDFG_E-$BDFG_EP:0;
		$BDFG_VR=($BDFG_E>$BDFG_EP)?0:$BDFG_EP-$BDFG_E;
		$SDI_ER=$SDI_ER1-$SDI_ER2;
	    $SDI_EPR=$SDI_ER2-$SDI_ER3;
		$ADCPEA_ER=$ADCA_ER+$SDI_ER;
		$ADCPEA_EPR=$ADCA_EPR+$SDI_EPR;
		$TRS_ER=$AU_ER+$CERDI_ER+$ADCPEA_ER;
	    $TRS_EPR=$AU_EPR+$CERDI_EPR+$ADCPEA_EPR;
	}

  if(isset($_POST['chargement']))
  {
    $data = "<?php ";
    $data .= '$FP_E = ' . $FP_E . ";\n";
	$data .= '$FP_EP = ' . $FP_EP . ";\n";
	$data .= '$FP_VE = ' . $FP_VE . ";\n";
	$data .= '$FP_VR = ' . $FP_VR . ";\n";
	$data .= '$MAI_E = ' . $MAI_E . ";\n";
	$data .= '$MAI_EP = ' . $MAI_EP . ";\n";
	$data .= '$MAI_VE = ' . $MAI_VE . ";\n";
	$data .= '$MAI_VR = ' . $MAI_VR . ";\n";
	$data .= '$FDRF_E = ' . $FDRF_E . ";\n";
	$data .= '$FDRF_EP = ' . $FDRF_EP . ";\n";
	$data .= '$FDRF_VE = ' . $FDRF_VE . ";\n";
	$data .= '$FDRF_VR = ' . $FDRF_VR . ";\n";
	$data .= '$AC_E = ' . $AC_E . ";\n";
	$data .= '$AC_EP = ' . $AC_EP . ";\n";
	$data .= '$AC_VE = ' . $AC_VE . ";\n";
	$data .= '$AC_VR = ' . $AC_VR . ";\n";
	$data .= '$MPC_E = ' . $MPC_E . ";\n";
	$data .= '$MPC_EP = ' . $MPC_EP . ";\n";
	$data .= '$MPC_VE = ' . $MPC_VE . ";\n";
	$data .= '$MPC_VR = ' . $MPC_VR . ";\n";
	$data .= '$BDFG_E = ' . $BDFG_E . ";\n";
	$data .= '$BDFG_EP = ' . $BDFG_EP . ";\n";
	$data .= '$BDFG_VE = ' . $BDFG_VE . ";\n";
	$data .= '$BDFG_VR = ' . $BDFG_VR . ";\n";
	$data .= '$TN_E = ' . $TN_E . ";\n";
	$data .= '$TN_EP = ' . $TN_EP . ";\n";
	$data .= '$TN_VE = ' . $TN_VE . ";\n";
	$data .= '$TN_VR = ' . $TN_VR . ";\n";
	$data .= '$CDA_ER = ' . $CDA_ER . ";\n";
	$data .= '$CDA_EPR = ' . $CDA_EPR . ";\n";
	$data .= '$AU_ER = ' . $AU_ER . ";\n";
	$data .= '$AU_EPR = ' . $AU_EPR . ";\n";
	$data .= '$CDII_ER = ' . $CDII_ER . ";\n";
	$data .= '$CDII_EPR = ' . ($CDII_EPR*-1) . ";\n";
	$data .= '$CDIC_ER = ' . $CDIC_ER . ";\n";
	$data .= '$CDIC_EPR = ' . ($CDIC_EPR*-1 ). ";\n";
	$data .= '$CDIF_ER = ' . $CDIF_ER . ";\n";
	$data .= '$CDIF_EPR = ' . ($CDIF_EPR*-1) . ";\n";
	$data .= '$CERDI_ER = ' . $CERDI_ER . ";\n";
	$data .= '$CERDI_EPR = ' . $CERDI_EPR . ";\n";
	$data .= '$ADCA_ER = ' . $ADCA_ER . ";\n";
	$data .= '$ADCA_EPR = ' . $ADCA_EPR . ";\n";
	$data .= '$SDI_ER = ' . $SDI_ER . ";\n";
	$data .= '$SDI_EPR = ' . $SDI_EPR . ";\n";
	$data .= '$ADCPEA_ER = ' . $ADCPEA_ER . ";\n";
	$data .= '$ADCPEA_EPR = ' . $ADCPEA_EPR . ";\n";
	$data .= '$TRS_ER = ' . $TRS_ER . ";\n";
	$data .= '$TRS_EPR = ' . $TRS_EPR . ";\n";



    $data .= "?>";
    // Now, the variable $year will contain the year value "2023"
    $nomFichier = 'FinancementEx_fichier_'. $dateChoisis.'.php';
    // Écrire les données dans le nouveau fichier
    file_put_contents($nomFichier, $data);

  }


        


?>