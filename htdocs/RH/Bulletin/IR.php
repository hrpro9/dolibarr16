<?php
  // Load Dolibarr environment
  require '../../main.inc.php';
  require_once '../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';

  

  if(isset($_POST['fichierir']))
  { 
    $param_ncnss='';
    

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
    // Create a identifiantFiscal element
    $identifiantFiscal = $dom->createElement('identifiantFiscal',' ');
    $TraitementEtSalaire->appendChild($identifiantFiscal);
    // Create a nom element
    $nom_element=' ';
    $nom = $dom->createElement('nom',$nom_element);
    $TraitementEtSalaire->appendChild($nom);
    // Create a prenom element
    $prenom_element=' ';
    $prenom = $dom->createElement('prenom',$prenom_element);
    $TraitementEtSalaire->appendChild($prenom);
    // Create a raisonSociale element
    $raisonSociale = $dom->createElement('raisonSociale',' ');
    $TraitementEtSalaire->appendChild($raisonSociale);
    // Create a exerciceFiscalDu element
    $exerciceFiscalDu = $dom->createElement('exerciceFiscalDu',' ');
    $TraitementEtSalaire->appendChild($exerciceFiscalDu);
    // Create a exerciceFiscalAu element
    $exerciceFiscalAu = $dom->createElement('exerciceFiscalAu',' ');
    $TraitementEtSalaire->appendChild($exerciceFiscalAu);
    // Create a exerciceFiscalAu element
    $annee_now= date('Y');
    $annee = $dom->createElement('annee',$annee_now);
    $TraitementEtSalaire->appendChild($annee);
    // -------     -> info societe  <-    -------
    // Create a commune element
    $commune = $dom->createElement('commune');
    $TraitementEtSalaire->appendChild($commune);
    // Create a code element
    $code = $dom->createElement('code',' ');
    $commune->appendChild($code);
    // Create a code element
    $adresse = $dom->createElement('adresse',' ');
    $TraitementEtSalaire->appendChild($adresse);
    // Create a numeroCIN element
    $numeroCIN = $dom->createElement('numeroCIN',' ');
    $TraitementEtSalaire->appendChild($numeroCIN);
    // Create a numeroCNSS element
    $numeroCNSS = $dom->createElement('numeroCNSS',' ');
    $TraitementEtSalaire->appendChild($numeroCNSS);
    // Create a numeroCE element
    $numeroCE = $dom->createElement('numeroCE',' ');
    $TraitementEtSalaire->appendChild($numeroCE);
    // Create a numeroRC element
    $numeroRC = $dom->createElement('numeroRC',' ');
    $TraitementEtSalaire->appendChild($numeroRC);
    // Create a identifiantTP element
    $identifiantTP = $dom->createElement('identifiantTP',' ');
    $TraitementEtSalaire->appendChild($identifiantTP);
    // Create a numeroFax element
    $numeroFax = $dom->createElement('numeroFax',' ');
    $TraitementEtSalaire->appendChild($numeroFax);
    // Create a numeroTelephone element
    $numeroTelephone = $dom->createElement('numeroTelephone',' ');
    $TraitementEtSalaire->appendChild($numeroTelephone);
    // Create a email element
    $email = $dom->createElement('email',' ');
    $TraitementEtSalaire->appendChild($email);
    // Create a effectifTotal element
    $effectifTotal = $dom->createElement('effectifTotal',' ');
    $TraitementEtSalaire->appendChild($effectifTotal);
    // Create a nbrPersoPermanent element
    $nbrPersoPermanent = $dom->createElement('nbrPersoPermanent',' ');
    $TraitementEtSalaire->appendChild($nbrPersoPermanent);
    // Create a nbrPersoOccasionnel element
    $nbrPersoOccasionnel = $dom->createElement('nbrPersoOccasionnel',' ');
    $TraitementEtSalaire->appendChild($nbrPersoOccasionnel);
    // Create a nbrStagiaires element
    $nbrStagiaires = $dom->createElement('nbrStagiaires',' ');
    $TraitementEtSalaire->appendChild($nbrStagiaires);
    // Create a totalMtRevenuBrutImposablePP element
    $totalMtRevenuBrutImposablePP = $dom->createElement('totalMtRevenuBrutImposablePP',' ');
    $TraitementEtSalaire->appendChild($totalMtRevenuBrutImposablePP);
    // Create a totalMtRevenuNetImposablePP element
    $totalMtRevenuNetImposablePP = $dom->createElement('totalMtRevenuNetImposablePP',' ');
    $TraitementEtSalaire->appendChild($totalMtRevenuNetImposablePP);
    // Create a totalMtTotalDeductionPP element
    $totalMtTotalDeductionPP = $dom->createElement('totalMtTotalDeductionPP',' ');
    $TraitementEtSalaire->appendChild($totalMtTotalDeductionPP);
    // Create a totalMtBrutSommesPO element
    $totalMtBrutSommesPO = $dom->createElement('totalMtBrutSommesPO',' ');
    $TraitementEtSalaire->appendChild($totalMtBrutSommesPO);
    // Create a totalIrPrelevePO element
    $totalIrPrelevePO = $dom->createElement('totalIrPrelevePO',' ');
    $TraitementEtSalaire->appendChild($totalIrPrelevePO);
    // Create a totalMtBrutTraitSalaireSTG element
    $totalMtBrutTraitSalaireSTG = $dom->createElement('totalMtBrutTraitSalaireSTG',' ');
    $TraitementEtSalaire->appendChild($totalMtBrutTraitSalaireSTG);
    // Create a totalMtBrutIndemnitesSTG element
    $totalMtBrutIndemnitesSTG = $dom->createElement('totalMtBrutIndemnitesSTG',' ');
    $TraitementEtSalaire->appendChild($totalMtBrutIndemnitesSTG);
    // Create a totalMtRetenuesSTG element
    $totalMtRetenuesSTG = $dom->createElement('totalMtRetenuesSTG',' ');
    $TraitementEtSalaire->appendChild($totalMtRetenuesSTG);
    // Create a totalMtRevenuNetImpSTG element
    $totalMtRevenuNetImpSTG = $dom->createElement('totalMtRevenuNetImpSTG',' ');
    $TraitementEtSalaire->appendChild($totalMtRevenuNetImpSTG);
    // Create a totalSommePayeRTS element
    $totalSommePayeRTS = $dom->createElement('totalSommePayeRTS',' ');
    $TraitementEtSalaire->appendChild($totalSommePayeRTS);
    // Create a totalmtAnuuelRevenuSalarial element
    $totalmtAnuuelRevenuSalarial = $dom->createElement('totalmtAnuuelRevenuSalarial',' ');
    $TraitementEtSalaire->appendChild($totalmtAnuuelRevenuSalarial);
    // Create a totalmtAbondement element
    $totalmtAbondement = $dom->createElement('totalmtAbondement',' ');
    $TraitementEtSalaire->appendChild($totalmtAbondement);
    // Create a montantPermanent element
    $montantPermanent = $dom->createElement('montantPermanent',' ');
    $TraitementEtSalaire->appendChild($montantPermanent);
    // Create a montantOccasionnel element
    $montantOccasionnel = $dom->createElement('montantOccasionnel',' ');
    $TraitementEtSalaire->appendChild($montantOccasionnel);
    // Create a montantStagiaire element
    $montantStagiaire = $dom->createElement('montantStagiaire',' ');
    $TraitementEtSalaire->appendChild($montantStagiaire);
   
    $param_ncin='';
    $sql="SELECT *  FROM llx_user ";
    $rest=$db->query($sql);
    $param = ((object)($rest))->fetch_assoc();
    foreach($rest as $permanentPersonnel)
    {
        $sql="SELECT *  FROM llx_user_extrafields WHERE rowid=" . $permanentPersonnel['rowid'] . "  ";
        $rest=$db->query($sql);
        $param_ncin=((object)($rest))->fetch_assoc();

        if($param_ncin['stype'] == 1 || empty($param_ncin['stype']))
       {

           // Create a listPersonnelPermanent element
            if(empty($listPersonnelPermanent))
            {
                // -------     -> list Personnel Permanent  <-    -------
                $listPersonnelPermanent = $dom->createElement('listPersonnelPermanent');
                $TraitementEtSalaire->appendChild($listPersonnelPermanent);
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
        
            $param_ncin['cin']=(!empty($param_ncin['cin']))?$param_ncin['cin']:' ';
            $numCNI = $dom->createElement('numCNI',$param_ncin['cin']);
            $PersonnelPermanent->appendChild($numCNI);
            // Create a numCE element
            $numCE = $dom->createElement('numCE',' ');
            $PersonnelPermanent->appendChild($numCE);
            // Create a numPPR element
            $numPPR = $dom->createElement('numPPR',' ');
            $PersonnelPermanent->appendChild($numPPR);
            // Create a numCNSS element
            $sql_ncnss="SELECT *  FROM llx_Paie_UserInfo WHERE userid=" . $permanentPersonnel['rowid'] . " ";
            $rest_ncnss=$db->query($sql_ncnss);
            $param_ncnss=((object)($rest_ncnss))->fetch_assoc();
            $param_ncnss['cnss']=(!empty($param_ncnss['cnss']))?$param_ncnss['cnss']:' ';
            $numCNSS = $dom->createElement('numCNSS',$param_ncnss['cnss']);
            $PersonnelPermanent->appendChild($numCNSS);
            // Create a ifu element
            $ifu = $dom->createElement('ifu',' ');
            $PersonnelPermanent->appendChild($ifu);
            // Create a salaireBaseAnnuel element
            $sql_salairebrut="SELECT *  FROM llx_Paie_MonthDeclaration WHERE userid=" . $permanentPersonnel['rowid'] . " ";
            $rest_salairebrut=$db->query($sql_salairebrut);
            $param_salairebrut=((object)($rest_salairebrut))->fetch_assoc();
            $param_salairebrut['salaireBrut']=(!empty($param_salairebrut['salaireBrut']))?$param_salairebrut['salaireBrut']*12:' ';
            $salaireBaseAnnuel = $dom->createElement('salaireBaseAnnuel',$param_salairebrut['salaireBrut']);
            $PersonnelPermanent->appendChild($salaireBaseAnnuel);
            // Create a mtBrutTraitementSalaire element
            $mtBrutTraitementSalaire = $dom->createElement('mtBrutTraitementSalaire',' ');
            $PersonnelPermanent->appendChild($mtBrutTraitementSalaire);
            // Create a periode element
            $periode = $dom->createElement('periode',' ');
            $PersonnelPermanent->appendChild($periode);
            // Create a mtExonere element
            $mtExonere = $dom->createElement('mtExonere',' ');
            $PersonnelPermanent->appendChild($mtExonere);
            // Create a mtEcheances element
            $mtEcheances = $dom->createElement('mtEcheances',' ');
            $PersonnelPermanent->appendChild($mtEcheances);
            // Create a nbrReductions element
            $nbrReductions = $dom->createElement('nbrReductions',' ');
            $PersonnelPermanent->appendChild($nbrReductions);
            // Create a mtIndemnite element
            $mtIndemnite = $dom->createElement('mtIndemnite',' ');
            $PersonnelPermanent->appendChild($mtIndemnite);
            // Create a mtAvantages element
            $mtAvantages = $dom->createElement('mtAvantages',' ');
            $PersonnelPermanent->appendChild($mtAvantages);
            // Create a mtRevenuBrutImposable element
            $mtRevenuBrutImposable = $dom->createElement('mtRevenuBrutImposable',' ');
            $PersonnelPermanent->appendChild($mtRevenuBrutImposable);
            // Create a mtFraisProfess element
            $mtFraisProfess = $dom->createElement('mtFraisProfess',' ');
            $PersonnelPermanent->appendChild($mtFraisProfess);
            // Create a mtCotisationAssur element
            $mtCotisationAssur = $dom->createElement('mtCotisationAssur',' ');
            $PersonnelPermanent->appendChild($mtCotisationAssur);
            // Create a mtAutresRetenues element
            $mtAutresRetenues = $dom->createElement('mtAutresRetenues',' ');
            $PersonnelPermanent->appendChild($mtAutresRetenues);
            // Create a mtRevenuNetImposable element
            $mtRevenuNetImposable = $dom->createElement('mtRevenuNetImposable',' ');
            $PersonnelPermanent->appendChild($mtRevenuNetImposable);
            // Create a mtTotalDeduction element
            $mtTotalDeduction = $dom->createElement('mtTotalDeduction',' ');
            $PersonnelPermanent->appendChild($mtTotalDeduction);
            // Create a irPreleve element
            $irPreleve = $dom->createElement('irPreleve',' ');
            $PersonnelPermanent->appendChild($irPreleve);
            // Create a casSportif element
            $casSportif = $dom->createElement('casSportif',' ');
            $PersonnelPermanent->appendChild($casSportif);
            // Create a numMatricule element
            $numMatricule = $dom->createElement('numMatricule',' ');
            $PersonnelPermanent->appendChild($numMatricule);
            // Create a datePermis element
            $datePermis = $dom->createElement('datePermis',' ');
            $PersonnelPermanent->appendChild($datePermis);
            // Create a dateAutorisation element
            $dateAutorisation = $dom->createElement('dateAutorisation',' ');
            $PersonnelPermanent->appendChild($dateAutorisation);
            // Create a refSituationFamiliale element
            $refSituationFamiliale = $dom->createElement('refSituationFamiliale');
            $PersonnelPermanent->appendChild($refSituationFamiliale);
            // Create a code Situation familiale element 
            switch($permanentPersonnel['civility'])
            {
                case 'MR':
                    $permanentPersonnel['civility'] = "M";
                    break;
                case 'CE':
                    $permanentPersonnel['civility'] = "C";
                    break;
                case 'VE':
                    $permanentPersonnel['civility'] = "V";
                    break;
                case 'DI':
                    $permanentPersonnel['civility'] = "D"; 
                    break;
                default:
                $permanentPersonnel['civility'] = " ";
            }
            $code = $dom->createElement('code',$permanentPersonnel['civility']);
            $refSituationFamiliale->appendChild($code);
            // Create a refTaux element
            $refTaux = $dom->createElement('refTaux');
            $PersonnelPermanent->appendChild($refTaux);
            // Create a Taux des frais professionnels element
            $code = $dom->createElement('code','');
            $refSituationFamiliale->appendChild($code);
            // Create a listElementsExonere element
            $listElementsExonere = $dom->createElement('listElementsExonere');
            $refSituationFamiliale->appendChild($listElementsExonere);
            // Create a ElementExonerePP element
            $ElementExonerePP = $dom->createElement('ElementExonerePP');
            $listElementsExonere->appendChild($ElementExonerePP);
            // Create a montantExonere element
            $montantExonere = $dom->createElement('montantExonere',' ');
            $listElementsExonere->appendChild($montantExonere);
            // Create a refNatureElementExonere element
            $refNatureElementExonere = $dom->createElement('refNatureElementExonere');
            $listElementsExonere->appendChild($refNatureElementExonere);
            // Create a code element
            $code = $dom->createElement('code',' ');
            $refNatureElementExonere->appendChild($code);
        }
        else  if($param_ncin['stype'] == 2){
            // -------     -> list Personnel Occasionnel  <-    -------
            if(empty($listPersonnelOccasionnel))
            {
                // Create a listPersonnelOccasionnel element
                $listPersonnelOccasionnel = $dom->createElement('listPersonnelOccasionnel');
                $TraitementEtSalaire->appendChild($listPersonnelOccasionnel);
            }
            // Create a PersonnelOccasionnel element
            $PersonnelOccasionnel = $dom->createElement('PersonnelOccasionnel');
            $listPersonnelOccasionnel->appendChild($PersonnelOccasionnel);
            // Create a nom element
            $nom = $dom->createElement('nom',$permanentPersonnel['lastname']);
            $PersonnelOccasionnel->appendChild($nom);
            // Create a prenom element
            $prenom = $dom->createElement('prenom',$permanentPersonnel['firstname']);
            $PersonnelOccasionnel->appendChild($prenom);
        }
        else if($param_ncin['stype'] == 3){
            // -------     -> list Stagiaires <-    -------
            if(empty($listStagiaires))
            {
                // Create a listStagiaires element
                $listStagiaires = $dom->createElement('listStagiaires');
                $TraitementEtSalaire->appendChild($listStagiaires);
            }
            // Create a Stagiaire element
            $Stagiaire = $dom->createElement('Stagiaire');
            $listStagiaires->appendChild($Stagiaire);
            // Create a nom element
            $nom = $dom->createElement('nom',$permanentPersonnel['lastname']);
            $Stagiaire->appendChild($nom);
            // Create a prenom element
            $prenom = $dom->createElement('prenom',$permanentPersonnel['firstname']);
            $Stagiaire->appendChild($prenom);
        }
        else if($param_ncin['stype'] == 4)
        {
            // -------     -> list Stagiaires <-    -------
            if(empty($listDoctorants))
            {
                // Create a listStagiaires element
                $listDoctorants = $dom->createElement('listDoctorants');
                $TraitementEtSalaire->appendChild($listDoctorants);
            }
            // Create a Stagiaire element
            $Doctorant = $dom->createElement('Doctorant');
            $listDoctorants->appendChild($Doctorant);
            // Create a nom element
            $nom = $dom->createElement('nom',$permanentPersonnel['lastname']);
            $Doctorant->appendChild($nom);
            // Create a prenom element
            $prenom = $dom->createElement('prenom',$permanentPersonnel['firstname']);
            $Doctorant->appendChild($prenom);
        }
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
                        <label style="text-align: center;" class="field-divided">Fichier EDI IR !!!</label>
                        <li>
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