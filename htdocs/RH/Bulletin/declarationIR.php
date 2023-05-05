<?php
  // Load Dolibarr environment
  require '../../main.inc.php';
  require_once '../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';

  if(isset($_POST['fichierir']))
  { 
    $nom_value=$_POST['nom'];
    $prenom_value=$_POST['prenom'];
    $ncin_value=$_POST['ncin'];
    $du_date=$_POST['du'];
    $au_date=$_POST['au'];
    //date du
    $datetime = new DateTime($du_date);
    $annee_du = $datetime->format('Y');
    $mois_du = $datetime->format('m');
    $jour_du = $datetime->format('d');
    //date Au
    $datetime = new DateTime($au_date);
    $annee_au = $datetime->format('Y');
    $mois_au = $datetime->format('m');
    $jour_au = $datetime->format('d');
    $annee_now=$datetime->format('Y');
    $NbrPersoPermanent=0;$NbrPersoOccasionnel=0;$NbrStagiaires=0;$TtMtRevenuBrutImposablePP=0;$TtMtRevenuNetImposablePP=0; $TtIrPrelevePO=0;
    $TtMtBrutSommesPO=0;$TtMtIrPrelevePP=0; $TtMtBrutTraitSalaireS=0; $TtMtRevenuNetImpSTG=0; $BrutImposablePP_mois=0; $RevenuNetImposablePP_mois=0;
    $IrPrelevePP_mois=0;$TtmtAnuuelRevenuSalarial=0;$mtExonere=0;$nbrReductions='';$refSituationFamiliale_code='';$mtBrutTraitementSalaire=0;
    $indemnitesSTG=0;$indemnitesDO=0;$totalMtRetenuesSTG=0; $totalMtBrutIndemnitesSTG=0;
    //nom fiche xml
    $nomfiche="IR".date('Y').".xml";
    header('Content-Disposition: attachment; filename='.$nomfiche);
    header('Content-Type: text/xml'); 
    // Create a new DOM document
    $dom=new DOMDocument('1.0', 'UTF-8'); 
    $dom->formatOutput=true;  
    // Create a DeclarationPension element and set the xsi namespace
    $DeclarationPension = $dom->createElement('DeclarationPension');
    $DeclarationPension->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
    $dom->appendChild($DeclarationPension);
    // Create a TraitementEtSalaire element
    $TraitementEtSalaire = $dom->createElement('TraitementEtSalaire');
    $dom->appendChild($TraitementEtSalaire);
    function roundVar($nom) // y= " numbre de position "
    {
        $nom = ($nom != 0)? round(floatval($nom), 2) : '';
        return $nom;
    }
    // list employee
    $sql="SELECT *  FROM llx_user WHERE employee = 1 ";
    $rest=$db->query($sql);
    foreach($rest as $permanentPersonnel)
    {
        //-----------------------------------------------------------
        $SBaseAnnuel=0;
        $mtExonere=0;
        $periodeAnnuel=0;
        $SBrutAnnuel=0;
        $param_user_extrafields='';
        $sql="SELECT *  FROM llx_user_extrafields WHERE fk_object=" . $permanentPersonnel['rowid'] . "  ";
        $rest=$db->query($sql);
        $param_user_extrafields=((object)($rest))->fetch_assoc();
        //-----------------------------------------------------------
        $param_MonthDeclarationRubs='';
        $sql_MonthDeclarationRubs="SELECT *  FROM llx_Paie_MonthDeclarationRubs WHERE userid=" . $permanentPersonnel['rowid'] . " ";
        $rest_MonthDeclarationRubs=$db->query($sql_MonthDeclarationRubs);
        $param_MonthDeclarationRubs=((object)($rest_MonthDeclarationRubs))->fetch_assoc();
        //-----------------------------------------------------------
        $sql = "SELECT *  FROM llx_Paie_UserParameters WHERE userid=" . $permanentPersonnel['rowid'] . " ";
        $rest_paie_userparameters = $db->query($sql);
        foreach ($rest_paie_userparameters as $paie_userparameters) {
            $sql = "SELECT *  FROM llx_Paie_Rub WHERE cotisation=0 AND imposable=0";
            $rest_paie_rub0 = $db->query($sql);
            // $param_paie_rub0 = ((object)($rest_paie_rub0))->fetch_assoc();
            foreach ($rest_paie_rub0 as $paie_rub0) {
                    
                if ($paie_rub0['rub'] == $paie_userparameters['rub']) {
                 $mtExonere += $paie_userparameters['amount'];
                }
            }
        }

      //  $sql = "SELECT *  FROM llx_Paie_MonthDeclarationRubs WHERE userid=" . $permanentPersonnel['rowid'] . " ";
       // $rest_paie_monthdeclarationRubs = $db->query($sql);
       // $param_paie_monthdeclarationRubs=((object)($rest_paie_monthdeclarationRubs))->fetch_assoc(); 

        $sql = "SELECT  rubs FROM llx_Paie_MonthDeclarationRubs WHERE userid=" . $permanentPersonnel['rowid'] . "
        AND ((year > $annee_du OR (year = $annee_du AND month >= $mois_du))
        AND (year < $annee_au OR (year = $annee_au AND month <= $mois_au)))";
        $rest_paie_monthdeclarationRubs = $db->query($sql);

        $fraisProfessionnels=0;
        $cotisationCNSS=0;
        $cotisationCIMR=0;
        $cotisationMutulle=0;
        $cotisationAMO=0;
        while ($row = $db->fetch_array($rest_paie_monthdeclarationRubs)) {
            $rubs_data = $row['rubs'];
            $rubs_array = explode(";", $rubs_data);

            foreach ($rubs_array as $rubs_element) {
                $rubs_element_array = explode(":", $rubs_element);
                $rubs_code = $rubs_element_array[0];
                if (count($rubs_element_array) >= 3) {
                    $rubs_designation = $rubs_element_array[1];
                    $rubs_value = abs($rubs_element_array[2]); 
                    if ($rubs_code == "714") {
                        $fraisProfessionnels+= $rubs_value;
                    }
                    if ($rubs_code == "700") {
                        $cotisationCNSS+= $rubs_value;
                    }
                    if ($rubs_code == "710" || $rubs_code == "712" ) {
                        $cotisationCIMR+= $rubs_value;
                    }
                    if ($rubs_code == "702") {
                        $cotisationAMO+= $rubs_value;
                    }
                    if ($rubs_code == "706") {
                        $cotisationMutulle+= $rubs_value;
                    }
                }
            }            
        }

      





        // -----------------------> ETAT CONCERNAT PERSONNEL EXONERE <-----------------------
      //l  $sql_personnelexonere="SELECT   sum(salaireBrut) as salaireBrut , sum(ir) as ir , sum(netImposable) as netImposable, sum(workingDays) as workingDays , sum(joursferie) as joursferie , sum(joursconge) as joursconge  FROM llx_Paie_MonthDeclaration   WHERE userid=" . $permanentPersonnel['rowid'] . " AND (	(year>=$annee_du AND month>=$mois_du) BETWEEN (year<=$annee_au AND month<=$mois_au) ) ";
        $sql_personnelexonere="
        SELECT sum(salaireBrut) as salaireBrut, 
        sum(ir) as ir, 
        sum(netImposable) as netImposable, 
        sum(workingDays) as workingDays, 
        sum(joursferie) as joursferie, 
        sum(joursconge) as joursconge 
            FROM llx_Paie_MonthDeclaration 
        WHERE userid=" . $permanentPersonnel['rowid'] . " 
        AND ((year > $annee_du OR (year = $annee_du AND month >= $mois_du)) 
            AND (year < $annee_au OR (year = $annee_au AND month <= $mois_au))) ";

        
        $rest_personnelexonere=$db->query($sql_personnelexonere);
        $param_personnelexonere=((object)($rest_personnelexonere))->fetch_assoc(); 
        if($param_personnelexonere['ir']==0)
        {
            $mtBrutTraitementSalaire = (float)$param_personnelexonere['salaireBrut'];
            $mtRetenuesOperees = (float)$param_personnelexonere['ir'];
            $mtRevenuNetImposable= (float)$param_personnelexonere['netImposable'];
            $periode = (float)$param_personnelexonere['workingDays'] + (float)$param_personnelexonere['joursconge'] + (float)$param_personnelexonere['joursferie'];
            $listPersonnelExonere = $dom->createElement('listPersonnelExonere');
            // Create a PersonnelExonere element
            $PersonnelExonere = $dom->createElement('PersonnelExonere');
            $listPersonnelExonere->appendChild($PersonnelExonere);
            // Create a nom element
            $nom = $dom->createElement('fraisProfessionnels',$fraisProfessionnels);
            $PersonnelExonere->appendChild($nom);
            // Create a nom element
            $nom = $dom->createElement('cotisationCNSS',$cotisationCNSS);
            $PersonnelExonere->appendChild($nom);
            // Create a nom element
            $nom = $dom->createElement('cotisationAMO',$cotisationAMO);
            $PersonnelExonere->appendChild($nom);
             // Create a nom element
             $nom = $dom->createElement('cotisationMutulle',$cotisationMutulle);
             $PersonnelExonere->appendChild($nom);
            // Create a nom element
            $nom = $dom->createElement('nom',$permanentPersonnel['lastname']);
            $PersonnelExonere->appendChild($nom);
            // Create a prenom element
            $prenom = $dom->createElement('prenom',$permanentPersonnel['firstname']);
            $PersonnelExonere->appendChild($prenom);
            // Create a adressePersonnelle element
            $adressePersonnelle = $dom->createElement('adressePersonnelle',$permanentPersonnel['address']);
            $PersonnelExonere->appendChild($adressePersonnelle);
            // Create a numCNI element
            $cni_value=(!empty($param_user_extrafields['cin']))?$param_user_extrafields['cin']:'';
            $numCNI = $dom->createElement('numCNI',trim($cni_value));
            $PersonnelExonere->appendChild($numCNI);
            // Create a numCE element
            $numCE = $dom->createElement('numCE','');//null
            $PersonnelExonere->appendChild($numCE);
            // Create a numCNSS element
            $sql_Paie_UserInfo="SELECT *  FROM llx_Paie_UserInfo WHERE userid=" . $permanentPersonnel['rowid'] . " ";
            $rest_Paie_UserInfo=$db->query($sql_Paie_UserInfo);
            $param_Paie_UserInfo=((object)($rest_Paie_UserInfo))->fetch_assoc();
            $ncnss_value=(!empty($param_Paie_UserInfo['cnss']))?$param_Paie_UserInfo['cnss']:'';
            $numCNSS = $dom->createElement('numCNSS',$ncnss_value);
            $PersonnelExonere->appendChild($numCNSS);
            // Create a ifu element
            $ifu = $dom->createElement('ifu','');//null
            $PersonnelExonere->appendChild($ifu);
            // Create a dateRecrutement element
            $dateRecrutement = $dom->createElement('dateRecrutement',$permanentPersonnel['dateemployment']);
            $PersonnelExonere->appendChild($dateRecrutement);
            // Create a mtBrutTraitementSalaire element
            $mtBrutTraitementSalaire = $dom->createElement('mtBrutTraitementSalaire',roundVar($mtBrutTraitementSalaire));
            $PersonnelExonere->appendChild($mtBrutTraitementSalaire);
            // Create a mtIndemniteAgentNature element
            $mtIndemniteAgentNature = $dom->createElement('mtIndemniteArgentNature','');
            $PersonnelExonere->appendChild($mtIndemniteAgentNature);
            // Create a mtIndemniteFraisPro element
            $mtIndemniteFraisPro = $dom->createElement('mtIndemniteFraisPro','');
            $PersonnelExonere->appendChild($mtIndemniteFraisPro);
            // Create a mtRevenuBrutImposable element
            $mtRevenuBrutImposable = $dom->createElement('mtRevenuBrutImposable','');
            $PersonnelExonere->appendChild($mtRevenuBrutImposable);
            // Create a mtRetenuesOperees element
            $mtRetenuesOperees = $dom->createElement('mtRetenuesOperees',roundVar($mtRetenuesOperees));
            $PersonnelExonere->appendChild($mtRetenuesOperees);
            // Create a mtRevenuNetImposable element
            $mtRevenuNetImposable = $dom->createElement('mtRevenuNetImposable',roundVar($mtRevenuNetImposable));
            $PersonnelExonere->appendChild($mtRevenuNetImposable);
            // Create a periode element
            $periode = $dom->createElement('periode',$periode);
            $PersonnelExonere->appendChild($periode);
        }
        // ----------------------->  <-----------------------
        $sql_salaire="SELECT   sum(salaireBrut) as salaireBrut  , sum(ir) as ir,sum(salaireNet) as salaireNet , sum(netImposable) as netImposable, sum(workingDays) as workingDays , sum(joursferie) as joursferie , sum(joursconge) as joursconge  FROM llx_Paie_MonthDeclaration   WHERE userid=" . $permanentPersonnel['rowid'] . " AND month<=12 ";
        $rest_salaire=$db->query($sql_salaire); 
        // -----------------------> ETAT CONCERNAT LE PERSONNEL PERMANENT <-----------------------
        if($param_user_extrafields['stype'] == 1 || empty($param_user_extrafields['stype']))
        {
            $NbrPersoPermanent++;
            $mtCotisationAssur= $cotisationCNSS+ $cotisationAMO+$cotisationMutulle;
            if ($rest_salaire) {
                $row = $rest_salaire->fetch_assoc();
                $TtMtRevenuBrutImposablePP += (float)$row["salaireBrut"] ;
                $TtMtRevenuNetImposablePP += (float)$row["netImposable"];
                $TtMtIrPrelevePP += (float)$row["ir"];
                $mtBrutTraitementSalaire= (float)$row["salaireBrut"] ;
                $periode=(float)$row["workingDays"]+(float)$row["joursconge"]+(float)$row["joursferie"];
            }
            //-----------------------------------------------------------
            $sql="SELECT sum(salaireDeBase) as salaireDeBase FROM llx_Paie_MonthDeclarationRubs WHERE userid=" . $permanentPersonnel['rowid'] . "  ";
            $rest_monthdeclarationRubs=$db->query($sql);     
            if ($rest_monthdeclarationRubs) {
                $row = $rest_monthdeclarationRubs->fetch_assoc();
                $salaireBaseAnnuel = (float)$row["salaireDeBase"];
            }    
            //-----------------------------------------------------------
            $sql = "SELECT * FROM llx_Paie_MonthDeclarationRubs where userid=" . $permanentPersonnel['rowid'] . " AND year=$annee_au AND month=$mois_au ";
            $rest_monthdeclarationRubs = $db->query($sql);
            $param_monthdeclarationRubs = $rest_monthdeclarationRubs->fetch_assoc();

            if ($param_monthdeclarationRubs && isset($param_monthdeclarationRubs['situationFamiliale'])) {
                switch ($param_monthdeclarationRubs['situationFamiliale']) {
                    case "DIVORCE":
                        $refSituationFamiliale_code = "D";
                        break;
                    case "MARIE":
                        $refSituationFamiliale_code = "M";
                        break;
                    case "CELIBATAIRE":
                        $refSituationFamiliale_code = "C";
                        break;
                    default:
                        $refSituationFamiliale_code = "V";
                        break;
                }
            } else {
                // handle the case where $param_monthdeclarationRubs is null or undefined
            }
            $nbrenfants = 0; // default value
            if(isset($param_monthdeclarationRubs) && $param_monthdeclarationRubs['enfants']){
                $nbrenfants = $param_monthdeclarationRubs['enfants'];
            } else {
                // handle the case where $param_monthdeclarationRubs is null or the 'enfants' key is not set
            }
            $nbrReductions = ($refSituationFamiliale_code == "M") ? $nbrenfants+1 : (($nbrenfants == 0) ? '' : $nbrenfants);
            
            if(empty($listPersonnelPermanent))
            {
                $listPersonnelPermanent = $dom->createElement('listPersonnelPermanent');    
            }
            // Create a PersonnelPermanent element
            $PersonnelPermanent = $dom->createElement('PersonnelPermanent');
            $listPersonnelPermanent->appendChild($PersonnelPermanent);
            // Create a nom element
            $nom = $dom->createElement('nom',$permanentPersonnel['lastname']);
            $PersonnelPermanent->appendChild($nom);
            // Create a prenom element
            $prenom = $dom->createElement('prenom',$permanentPersonnel['firstname']);
            $PersonnelPermanent->appendChild($prenom);
            // Create a adressePersonnelle element
            $adressePersonnelle = $dom->createElement('adressePersonnelle',$permanentPersonnel['address']);
            $PersonnelPermanent->appendChild($adressePersonnelle);
            // Create a numCNI element
            $cni_value=(!empty($param_user_extrafields['cin']))?$param_user_extrafields['cin']:'';
            $numCNI = $dom->createElement('numCNI',trim($cni_value));
            $PersonnelPermanent->appendChild($numCNI);
            // Create a numCE element
            $numCE = $dom->createElement('numCE','');//null
            $PersonnelPermanent->appendChild($numCE);
            // Create a numPPR element
            $numPPR = $dom->createElement('numPPR','');
            $PersonnelPermanent->appendChild($numPPR);
            // Create a numCNSS element
            $sql_Paie_UserInfo="SELECT *  FROM llx_Paie_UserInfo WHERE userid=" . $permanentPersonnel['rowid'] . " ";
            $rest_Paie_UserInfo=$db->query($sql_Paie_UserInfo);
            $param_Paie_UserInfo=((object)($rest_Paie_UserInfo))->fetch_assoc();
            $ncnss_value=(!empty($param_Paie_UserInfo['cnss']))?$param_Paie_UserInfo['cnss']:' ';
            $numCNSS = $dom->createElement('numCNSS',$ncnss_value);
            $PersonnelPermanent->appendChild($numCNSS);
            // Create a ifu element
            $ifu = $dom->createElement('ifu','');
            $PersonnelPermanent->appendChild($ifu);
            // Create a salaireBaseAnnuel element
            $salaireBaseAnnuel = $dom->createElement('salaireBaseAnnuel',roundVar($salaireBaseAnnuel));
            $PersonnelPermanent->appendChild($salaireBaseAnnuel);
            // Create a mtBrutTraitementSalaire element
            $mtBrutTraitementSalaire = $dom->createElement('mtBrutTraitementSalaire',roundVar($mtBrutTraitementSalaire));
            $PersonnelPermanent->appendChild($mtBrutTraitementSalaire);
            // Create a periode element
            $periode = $dom->createElement('periode',roundVar($periode));
            $PersonnelPermanent->appendChild($periode);
            // Create a mtExonere element
            $mtExonere = $dom->createElement('mtExonere',roundVar($mtExonere));
            $PersonnelPermanent->appendChild($mtExonere);
            // Create a mtEcheances element
            $mtEcheances = $dom->createElement('mtEcheances','');
            $PersonnelPermanent->appendChild($mtEcheances);
            // Create a nbrReductions element
            $nbrReductions = $dom->createElement('nbrReductions',roundVar($nbrReductions));
            $PersonnelPermanent->appendChild($nbrReductions); 
            // Create a mtIndemnite element
            $mtIndemnite = $dom->createElement('mtIndemnite','');
            $PersonnelPermanent->appendChild($mtIndemnite);
            // Create a mtAvantages element
            $mtAvantages = $dom->createElement('mtAvantages','');
            $PersonnelPermanent->appendChild($mtAvantages);
            // Create a mtRevenuBrutImposable element
            $mtRevenuBrutImposable = $dom->createElement('mtRevenuBrutImposable','');
            $PersonnelPermanent->appendChild($mtRevenuBrutImposable);
            // Create a mtFraisProfess element
            $mtFraisProfess = $dom->createElement('mtFraisProfess',roundVar($fraisProfessionnels));
            $PersonnelPermanent->appendChild($mtFraisProfess);   
            // Create a mtCotisationAssur element
            $mtCotisationAssur = $dom->createElement('mtCotisationAssur',roundVar($mtCotisationAssur));
            $PersonnelPermanent->appendChild($mtCotisationAssur); 
            // Create a mtAutresRetenues element
            $mtAutresRetenues = $dom->createElement('mtAutresRetenues','');// vide 
            $PersonnelPermanent->appendChild($mtAutresRetenues);         
            // Create a mtRevenuNetImposable element
            $mtRevenuNetImposable = $dom->createElement('mtRevenuNetImposable','');
            $PersonnelPermanent->appendChild($mtRevenuNetImposable); 
            // Create a mtTotalDeduction element
            $mtTotalDeduction = $dom->createElement('mtTotalDeduction','');
            $PersonnelPermanent->appendChild($mtTotalDeduction);
            // Create a irPreleve element
            $irPreleve = $dom->createElement('irPreleve','');
            $PersonnelPermanent->appendChild($irPreleve);
            // Create a casSportif element
            $casSportif = $dom->createElement('casSportif','');
            $PersonnelPermanent->appendChild($casSportif);
            // Create a numMatricule element
            $numMatricule = $dom->createElement('numMatricule','');
            $PersonnelPermanent->appendChild($numMatricule);
            // Create a datePermis element
            $datePermis = $dom->createElement('datePermis',''); //vide 
            $PersonnelPermanent->appendChild($datePermis);
            // Create a dateAutorisation element
            $dateAutorisation = $dom->createElement('dateAutorisation',''); //vide 
            $PersonnelPermanent->appendChild($dateAutorisation);
            // Create a refSituationFamiliale element
            $refSituationFamiliale = $dom->createElement('refSituationFamiliale');
            $PersonnelPermanent->appendChild($refSituationFamiliale);
            // Create a code element
            $code = $dom->createElement('code',$refSituationFamiliale_code);
            $refSituationFamiliale->appendChild($code);
            // Create a refTaux element
            $refTaux = $dom->createElement('refTaux');
            $PersonnelPermanent->appendChild($refTaux);
            // Create a code element
            $code = $dom->createElement('code','');
            $refTaux->appendChild($code);
            // Create a listElementsExonere element
            $listElementsExonere = $dom->createElement('listElementsExonere','');
            $PersonnelPermanent->appendChild($listElementsExonere);
            // Create a ElementExonerePP element
            $ElementExonerePP = $dom->createElement('ElementExonerePP','');
            $listElementsExonere->appendChild($ElementExonerePP);
            // Create a ElementExonerePP element
            $ElementExonerePP = $dom->createElement('ElementExonerePP','');
            $listElementsExonere->appendChild($ElementExonerePP);
            // Create a montantExonere element
            $montantExonere = $dom->createElement('montantExonere','');
            $ElementExonerePP->appendChild($montantExonere);
            // Create a refNatureElementExonere element
            $refNatureElementExonere = $dom->createElement('refNatureElementExonere');
            $ElementExonerePP->appendChild($refNatureElementExonere);
            // Create a code element
            $code = $dom->createElement('code','');
            $refNatureElementExonere->appendChild($code);
        }
        // -----------------------> ETAT CONCERNAT LES REMUNERATIONS OCCASIONNELLES <-----------------------
         elseif ($param_user_extrafields['stype'] == 2 )
        {
            $NbrPersoOccasionnel++;
            if ($rest_salaire) {
                $row = $rest_salaire->fetch_assoc();
                $TtMtBrutSommesPO += (float)$row["salaireBrut"] ;
                $TtIrPrelevePO += (float)$row["ir"];
                $irPreleve=(float)$row["ir"];
                $mtBrutSommes=(float)$row["salaireBrut"] ;
            }
            if(empty($listPersonnelOccasionnel))
            {
                $listPersonnelOccasionnel = $dom->createElement('listPersonnelOccasionnel');    
            }
            // Create a PersonnelPermanent element
            $PersonnelOccasionnel = $dom->createElement('PersonnelOccasionnel');
            $listPersonnelOccasionnel->appendChild($PersonnelOccasionnel);
            // Create a nom element
            $nom = $dom->createElement('nom',$permanentPersonnel['lastname']);
            $PersonnelOccasionnel->appendChild($nom);
            // Create a prenom element
            $prenom = $dom->createElement('prenom',$permanentPersonnel['firstname']);
            $PersonnelOccasionnel->appendChild($prenom);
            // Create a adressePersonnelle element
            $adressePersonnelle = $dom->createElement('adressePersonnelle',$permanentPersonnel['address']);
            $PersonnelOccasionnel->appendChild($adressePersonnelle);
            // Create a numCNI element
            $cni_value=(!empty($param_user_extrafields['cin']))?$param_user_extrafields['cin']:'';
            $numCNI = $dom->createElement('numCNI',trim($cni_value));
            $PersonnelOccasionnel->appendChild($numCNI);
            // Create a numCE element
            $numCE = $dom->createElement('numCE','');//null
            $PersonnelOccasionnel->appendChild($numCE);
            // Create a ifu element
            $ifu = $dom->createElement('ifu','');//null
            $PersonnelOccasionnel->appendChild($ifu);
            // Create a mtBrutSommes element
            $mtBrutSommes = $dom->createElement('mtBrutSommes',roundVar($mtBrutSommes));
            $PersonnelOccasionnel->appendChild($mtBrutSommes);
            // Create a irPreleve element
            $irPreleve = $dom->createElement('irPreleve',roundVar($irPreleve));
            $PersonnelOccasionnel->appendChild($irPreleve);
            // Create a profession element
            $profession = $dom->createElement('profession',$permanentPersonnel['job']);
            $PersonnelOccasionnel->appendChild($profession);


        }
        // -----------------------> LIST DES STAGIAIRES <-----------------------
        elseif  ($param_user_extrafields['stype'] == 3 ) 
        {
            $NbrStagiaires++;
            if ($rest_salaire) {
                $row = $rest_salaire->fetch_assoc();
                $TtMtBrutTraitSalaireS += (float)$row["salaireBrut"] ;
                $TtMtRevenuNetImpSTG += (float)$row["netImposable"];
                $totalMtRetenuesSTG += (float)$row["ir"];
                $mtBrutTraitementSalaire = (float)$row["salaireBrut"];
                $mtRetenues=(float)$row["ir"];
                $mtRevenuNetImposable=(float)$row["netImposable"];
                $periode=(float)$row["workingDays"]+(float)$row["joursconge"]+(float)$row["joursferie"];
            }
            $sql = "SELECT *  FROM llx_Paie_UserParameters WHERE userid=" . $permanentPersonnel['rowid'] . " ";
            $rest_paie_userparameters = $db->query($sql);
            foreach ($rest_paie_userparameters as $paie_userparameters) {
                $sql = "SELECT *  FROM llx_Paie_Rub WHERE cotisation=0";
                $rest_paie_rub0 = $db->query($sql);
                foreach ($rest_paie_rub0 as $paie_rub0) {
                    if ($paie_rub0['rub'] == $paie_userparameters['rub']) {
                        $indemnitesSTG += $paie_userparameters['amount'];
                    }
                }
            }

            $totalMtBrutIndemnitesSTG+=$indemnitesSTG;



            if(empty($listStagiaires))
            {
                $listStagiaires = $dom->createElement('listStagiaires');    
            }
            // Create a Stagaiaire element
            $Stagaiaire = $dom->createElement('Stagaiaire');
            $listStagiaires->appendChild($Stagaiaire);
            // Create a nom element
            $nom = $dom->createElement('nom',$permanentPersonnel['lastname']);
            $Stagaiaire->appendChild($nom);
            // Create a prenom element
            $prenom = $dom->createElement('prenom',$permanentPersonnel['firstname']);
            $Stagaiaire->appendChild($prenom);
            // Create a adressePersonnelle element
            $adressePersonnelle = $dom->createElement('adressePersonnelle',$permanentPersonnel['address']);
            $Stagaiaire->appendChild($adressePersonnelle);
            // Create a numCNI element
            $cni_value=(!empty($param_user_extrafields['cin']))?$param_user_extrafields['cin']:'';
            $numCNI = $dom->createElement('numCNI',trim($cni_value));
            $Stagaiaire->appendChild($numCNI);
            // Create a numCE element
            $numCE = $dom->createElement('numCE','');//null
            $Stagaiaire->appendChild($numCE);
            // Create a numCNSS element
            $sql_Paie_UserInfo="SELECT *  FROM llx_Paie_UserInfo WHERE userid=" . $permanentPersonnel['rowid'] . " ";
            $rest_Paie_UserInfo=$db->query($sql_Paie_UserInfo);
            $param_Paie_UserInfo=((object)($rest_Paie_UserInfo))->fetch_assoc();
            $ncnss_value=(!empty($param_Paie_UserInfo['cnss']))?$param_Paie_UserInfo['cnss']:' ';
            $numCNSS = $dom->createElement('numCNSS',$ncnss_value);
            $Stagaiaire->appendChild($numCNSS);
            // Create a ifu element
            $ifu = $dom->createElement('ifu','');
            $Stagaiaire->appendChild($ifu);
            // Create a mtBrutTraitementSalaire element
            $mtBrutTraitementSalaire = $dom->createElement('mtBrutTraitementSalaire',roundVar($mtBrutTraitementSalaire));
            $Stagaiaire->appendChild($mtBrutTraitementSalaire);
            // Create a mtBrutIndemnites element
            $mtBrutIndemnites = $dom->createElement('mtBrutIndemnites',roundVar($indemnitesSTG));
            $Stagaiaire->appendChild($mtBrutIndemnites);
            // Create a mtRetenues element
            $mtRetenues = $dom->createElement('mtRetenues',roundVar($mtRetenues));
            $Stagaiaire->appendChild($mtRetenues);
            // Create a mtRevenuNetImposable element
            $mtRevenuNetImposable = $dom->createElement('mtRevenuNetImposable',roundVar($mtRevenuNetImposable) );
            $Stagaiaire->appendChild($mtRevenuNetImposable);
            // Create a periode element
            $periode = $dom->createElement('periode',$periode);
            $Stagaiaire->appendChild($periode);
        }   
          // -----------------------> LIST DES DOCTORANTS <-----------------------
          elseif  ($param_user_extrafields['stype'] == 4 ) 
          {
                $sql = "SELECT *  FROM llx_Paie_UserParameters WHERE userid=" . $permanentPersonnel['rowid'] . " ";
                $rest_paie_userparameters = $db->query($sql);
              foreach ($rest_paie_userparameters as $paie_userparameters) {
                $sql = "SELECT *  FROM llx_Paie_Rub WHERE cotisation=0";
                $rest_paie_rub0 = $db->query($sql);
                foreach ($rest_paie_rub0 as $paie_rub0) {
                    if ($paie_rub0['rub'] == $paie_userparameters['rub']) {
                        $indemnitesDO += $paie_userparameters['amount'];
                    }
                    }
              }
              if(empty($listDoctorants))
              {
                  $listDoctorants = $dom->createElement('listDoctorants');    
              }
              // Create a Stagaiaire element
              $Doctorant = $dom->createElement('Doctorant');
              $listDoctorants->appendChild($Doctorant);
              // Create a nom element
              $nom = $dom->createElement('nom',$permanentPersonnel['lastname']);
              $Doctorant->appendChild($nom);
              // Create a prenom element
              $prenom = $dom->createElement('prenom',$permanentPersonnel['firstname']);
              $Doctorant->appendChild($prenom);
              // Create a adressePersonnelle element
              $adressePersonnelle = $dom->createElement('adressePersonnelle',$permanentPersonnel['address']);
              $Doctorant->appendChild($adressePersonnelle);
              // Create a numCNI element
              $cni_value=(!empty($param_user_extrafields['cin']))?$param_user_extrafields['cin']:'';
              $numCNI = $dom->createElement('numCNI',trim($cni_value));
              $Doctorant->appendChild($numCNI);
              // Create a numCE element
              $numCE = $dom->createElement('numCE','');//null
              $Doctorant->appendChild($numCE);
              // Create a mtBrutIndemnites element
              $mtBrutIndemnites = $dom->createElement('mtBrutIndemnites',roundVar($indemnitesDO));
              $Doctorant->appendChild($mtBrutIndemnites);
          }   
    }
    // -----------------------> IDENTIFICATION DU CONTERIBUABLE <-----------------------
    // Create a identifiantFiscal element
    $identifiantFiscal = $dom->createElement('identifiantFiscal',' ');
    $TraitementEtSalaire->appendChild($identifiantFiscal);
    // Create a nom element
    $nom = $dom->createElement('nom',$nom_value);
    $TraitementEtSalaire->appendChild($nom);
    // Create a prenom element
    $prenom = $dom->createElement('prenom',$prenom_value);
    $TraitementEtSalaire->appendChild($prenom);
    // Create a raisonSociale element
    $raisonSociale = $dom->createElement('raisonSociale','?');
    $TraitementEtSalaire->appendChild($raisonSociale);
    // Create a exerciceFiscalDu element
    $exerciceFiscalDu = $dom->createElement('exerciceFiscalDu',$du_date);
    $TraitementEtSalaire->appendChild($exerciceFiscalDu);
    // Create a exerciceFiscalAu element
    $exerciceFiscalAu = $dom->createElement('exerciceFiscalAu',$au_date);
    $TraitementEtSalaire->appendChild($exerciceFiscalAu);
    // Create a exerciceFiscalAu element
    $annee = $dom->createElement('annee',$annee_now);
    $TraitementEtSalaire->appendChild($annee);
    // -------     -> info societe  <-    -------
    // Create a commune element
    $commune = $dom->createElement('commune');
    $TraitementEtSalaire->appendChild($commune);
    // Create a ville element
    $code = $dom->createElement('code','?');
    $commune->appendChild($code);
    // Create a adresse du siege social element
    $adresse = $dom->createElement('adresse','?');
    $TraitementEtSalaire->appendChild($adresse);
     // Create a numeroCIN element
    $numeroCIN = $dom->createElement('numeroCIN',$ncin_value);
    $TraitementEtSalaire->appendChild($numeroCIN);   
    // Create a numeroCNSS element
    $numeroCNSS = $dom->createElement('numeroCNSS','?');
    $TraitementEtSalaire->appendChild($numeroCNSS);
    // Create a numeroCarte de séjour element
    $numeroCE = $dom->createElement('numeroCE','?');//null
    $TraitementEtSalaire->appendChild($numeroCE);
    // Create a numeroRC element
    $numeroRC = $dom->createElement('numeroRC','?');
    $TraitementEtSalaire->appendChild($numeroRC);
    // Create a numeroFax element
    $numeroFax = $dom->createElement('numeroFax','?');
    $TraitementEtSalaire->appendChild($numeroFax);
    // Create a numeroTelephone element
    $numeroTelephone = $dom->createElement('numeroTelephone','?');
    $TraitementEtSalaire->appendChild($numeroTelephone);
    // Create a identifiantTP element
    $identifiantTP = $dom->createElement('identifiantTP','?');
    $TraitementEtSalaire->appendChild($identifiantTP);
    // Create a email element
    $email = $dom->createElement('email','?');
    $TraitementEtSalaire->appendChild($email);
    // Create a effectifTotal element
    $nbr_POS=$NbrPersoPermanent+$NbrPersoOccasionnel+$NbrStagiaires;
    $effectifTotal = $dom->createElement('effectifTotal',roundVar($nbr_POS));
    $TraitementEtSalaire->appendChild($effectifTotal);
    // Create a nbrPersoPermanent element
    $nbrPersoPermanent = $dom->createElement('nbrPersoPermanent',roundVar($NbrPersoPermanent));
    $TraitementEtSalaire->appendChild($nbrPersoPermanent);
    // Create a nbrPersoOccasionnel element
    $nbrPersoOccasionnel = $dom->createElement('nbrPersoOccasionnel',roundVar($NbrPersoOccasionnel));
    $TraitementEtSalaire->appendChild($nbrPersoOccasionnel);
    // Create a nbrStagiaires element
    $nbrStagiaires = $dom->createElement('nbrStagiaires',roundVar($NbrStagiaires));
    $TraitementEtSalaire->appendChild($nbrStagiaires);
    // Create a totalMtRevenuBrutImposablePP element  
    $totalMtRevenuBrutImposablePP = $dom->createElement('totalMtRevenuBrutImposablePP',roundVar($TtMtRevenuBrutImposablePP));
    $TraitementEtSalaire->appendChild($totalMtRevenuBrutImposablePP);
    // Create a totalMtRevenuNetImposablePP element
    $totalMtRevenuNetImposablePP = $dom->createElement('totalMtRevenuNetImposablePP',roundVar($TtMtRevenuNetImposablePP));
    $TraitementEtSalaire->appendChild($totalMtRevenuNetImposablePP);
    // Create a totalMtTotalDeductionPP element
    $totalMtTotalDeductionPP = $dom->createElement('totalMtTotalDeductionPP','?');
    $TraitementEtSalaire->appendChild($totalMtTotalDeductionPP);
    // Create a totalMtIrPrelevePP element
    $totalMtIrPrelevePP = $dom->createElement('totalMtIrPrelevePP',roundVar($TtMtIrPrelevePP));
    $TraitementEtSalaire->appendChild($totalMtIrPrelevePP);
    // Create a totalMtBrutSommesPO element
    $totalMtBrutSommesPO = $dom->createElement('totalMtBrutSommesPO',roundVar($TtMtBrutSommesPO));
    $TraitementEtSalaire->appendChild($totalMtBrutSommesPO);
    // Create a totalIrPrelevePO element
    $totalIrPrelevePO = $dom->createElement('totalIrPrelevePO',roundVar($TtIrPrelevePO));
    $TraitementEtSalaire->appendChild($totalIrPrelevePO);
    // Create a totalMtBrutTraitSalaireSTG element
    $totalMtBrutTraitSalaireSTG = $dom->createElement('totalMtBrutTraitSalaireSTG',roundVar($TtMtBrutTraitSalaireS));
    $TraitementEtSalaire->appendChild($totalMtBrutTraitSalaireSTG);
    // Create a totalMtBrutIndemnitesSTG element
    $totalMtBrutIndemnitesSTG = $dom->createElement('totalMtBrutIndemnitesSTG',roundVar($totalMtBrutIndemnitesSTG));
    $TraitementEtSalaire->appendChild($totalMtBrutIndemnitesSTG);
    // Create a totalMtRetenuesSTG element
    $totalMtRetenuesSTG = $dom->createElement('totalMtRetenuesSTG',roundVar($totalMtRetenuesSTG));
    $TraitementEtSalaire->appendChild($totalMtRetenuesSTG);
    // Create a totalMtRevenuNetImpSTG element
    $totalMtRevenuNetImpSTG = $dom->createElement('totalMtRevenuNetImpSTG',roundVar($TtMtRevenuNetImpSTG));
    $TraitementEtSalaire->appendChild($totalMtRevenuNetImpSTG);
    // Create a totalSommePayeRTS element
    $totalSommePayeRTS = $dom->createElement('totalSommePayeRTS','');//null
    $TraitementEtSalaire->appendChild($totalSommePayeRTS);
    // Create a totalmtAnuuelRevenuSalarial element
    $TtmtAnuuelRevenuSalarial = $TtMtRevenuNetImpSTG+$TtMtRevenuNetImposablePP;
    $totalmtAnuuelRevenuSalarial = $dom->createElement('totalmtAnuuelRevenuSalarial',roundVar($TtmtAnuuelRevenuSalarial));
    $TraitementEtSalaire->appendChild($totalmtAnuuelRevenuSalarial);
    // Create a totalmtAbondement element
    $totalmtAbondement = $dom->createElement('totalmtAbondement','');//null
    $TraitementEtSalaire->appendChild($totalmtAbondement);
    // Create a montantPermanent element
    $montantPermanent = $dom->createElement('montantPermanent','');//null
    $TraitementEtSalaire->appendChild($montantPermanent);
    // Create a montantOccasionnel element
    $montantOccasionnel = $dom->createElement('montantOccasionnel','');//null
    $TraitementEtSalaire->appendChild($montantOccasionnel);
    // Create a montantStagiaire element
    $montantStagiaire = $dom->createElement('montantStagiaire','');//null
    $TraitementEtSalaire->appendChild($montantStagiaire);
    //----------------> ETAT CONCERNANT LE PERSONNEL PERMANENT <-----------------
    if(!empty($listPersonnelPermanent))
    {
        $TraitementEtSalaire->appendChild($listPersonnelPermanent);
    }
    //----------------> ETAT CONCERNANT LE PERSONNEL PERMANENT <-----------------
    if(!empty($listPersonnelExonere))
    {
        $TraitementEtSalaire->appendChild($listPersonnelExonere);
    }
    // -----------------------> ETAT CONCERNAT LES REMUNERATIONS OCCASIONNELLES <-----------------------
    if(!empty($listPersonnelOccasionnel))
    {
        $TraitementEtSalaire->appendChild($listPersonnelOccasionnel);
    }
    // -----------------------> LIST DES STAGIAIRES <-----------------------
    if(!empty($listStagiaires))
    {
        $TraitementEtSalaire->appendChild($listStagiaires);
    }
    // -----------------------> LIST DES Doctorants <-----------------------
    if(!empty($listDoctorants))
    {
        $TraitementEtSalaire->appendChild($listDoctorants);
    }
   







   
    

   
  

    // Output the XML file
    echo $dom->saveXML();
   }
    else
    {     
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <link rel="stylesheet" href="style.css">       
        </head>
        <body >
            <center>
                <div class="col-lg-4 m-auto" style="width:100% ;height: 100%;">
                    <form method="post"  enctype="multipart/form-data" >
                    <ul class="form-style-1" style="text-align: center;">
                        <label style="text-align: center;" class="field-divided">Declaration IR !</label>
                        <li>
                         <label>Nom <span class="required">* </label>
                         <input type="text" name="nom" class="field-divided" placeholder="nom" required />
                        </li>
                        <li>
                         <label>Prenom <span class="required">* </label>
                         <input type="text" name="prenom" class="field-divided" placeholder="prenom" required />
                        </li>
                        <li>
                         <label>N°Cin <span class="required">* </label>
                         <input type="text" name="ncin" class="field-divided" placeholder="ncin" required />
                        </li>
                        <li>
                         <label>Du  <span class="required">* </label>
                         <input type="date" name="du" class="field-divided" placeholder="YYYY-MM-DD" required />
                        </li>
                        <li>
                         <label>Au <span class="required">* </label>
                         <input type="date" name="au" class="field-divided" placeholder="YYYY-MM-DD"  required />
                        </li>
                        <li style="margin-top: 18px;">
                            <input type="submit" name="fichierir" value="Télécharge" />
                        </li>      
                    </ul>
                    </form>  
                </div> 
            </center>
        </body>
        </html>
        <?php
    }

?>











