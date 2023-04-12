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
    $datetime = new DateTime($du_date);
    $annee_now = $datetime->format('Y');
    $NbrPersoPermanent=0;$NbrPersoOccasionnel=0;$NbrStagiaires=0;$TtMtRevenuBrutImposablePP=0;$TtMtRevenuNetImposablePP=0; $TtIrPrelevePO=0;$TtMtBrutSommesPO=0;$TtMtIrPrelevePP=0; $TtMtBrutTraitSalaireS=0; $TtMtRevenuNetImpSTG=0; $BrutImposablePP_mois=0; $RevenuNetImposablePP_mois=0; $IrPrelevePP_mois=0;$TtmtAnuuelRevenuSalarial=0;
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
    $sql="SELECT *  FROM llx_user";
    $rest=$db->query($sql);
    foreach($rest as $permanentPersonnel)
    {
        //-----------------------------------------------------------
        $SBaseAnnuel=0;
        $periodeAnnuel=0;
        $SBrutAnnuel=0;
        $param_user_extrafields='';
        $sql="SELECT *  FROM llx_user_extrafields WHERE rowid=" . $permanentPersonnel['rowid'] . "  ";
        $rest=$db->query($sql);
        $param_user_extrafields=((object)($rest))->fetch_assoc();
        //-----------------------------------------------------------
        $param_salaire='';
        $sql_salaire="SELECT *  FROM llx_Paie_MonthDeclaration WHERE userid=" . $permanentPersonnel['rowid'] . " ";
        $rest_salaire=$db->query($sql_salaire);
        $param_salaire=((object)($rest_salaire))->fetch_assoc();
        //-----------------------------------------------------------
        $param_MonthDeclarationRubs='';
        $sql_MonthDeclarationRubs="SELECT *  FROM llx_Paie_MonthDeclarationRubs WHERE userid=" . $permanentPersonnel['rowid'] . " ";
        $rest_MonthDeclarationRubs=$db->query($sql_MonthDeclarationRubs);
        $param_MonthDeclarationRubs=((object)($rest_MonthDeclarationRubs))->fetch_assoc();
        //-----------------------------------------------------------
        if(empty($param_user_extrafields['stype']))
        {
            $param_user_extrafields['stype']=0;
        }
        $salaireBrut_value=isset($param_salaire['salaireBrut'])?$param_salaire['salaireBrut']:0;
        $salaireNet_value=isset($param_salaire['salaireNet'])?$param_salaire['salaireNet']:0;
        $ir_value=isset($param_salaire['ir'])?$param_salaire['ir']:0;
        $netImposable_value=isset($param_salaire['netImposable'])?$param_salaire['netImposable']:0;
        //---------> PERSONNEL PERMANENT <---------------
        if($param_user_extrafields['stype'] == 1 || $param_user_extrafields['stype']==0)
        {
            $NbrPersoPermanent++;
            $param_salaire['month']=empty($param_salaire['month'])?$param_salaire['month']=0:$param_salaire['month'];
            switch($param_salaire['month'])
            {
                case 1: $BrutImposablePP_mois = $salaireBrut_value; $RevenuNetImposablePP_mois = $salaireNet_value; $IrPrelevePP_mois = $ir_value;break;
                case 2: $BrutImposablePP_mois = $salaireBrut_value; $RevenuNetImposablePP_mois = $salaireNet_value; $IrPrelevePP_mois = $ir_value;break;
                case 3: $BrutImposablePP_mois = $salaireBrut_value; $RevenuNetImposablePP_mois = $salaireNet_value; $IrPrelevePP_mois = $ir_value;break;
                case 4: $BrutImposablePP_mois = $salaireBrut_value; $RevenuNetImposablePP_mois = $salaireNet_value; $IrPrelevePP_mois = $ir_value;break;
                case 5: $BrutImposablePP_mois = $salaireBrut_value; $RevenuNetImposablePP_mois = $salaireNet_value; $IrPrelevePP_mois = $ir_value;break;
                case 6: $BrutImposablePP_mois = $salaireBrut_value; $RevenuNetImposablePP_mois = $salaireNet_value; $IrPrelevePP_mois = $ir_value;break;
                case 7: $BrutImposablePP_mois = $salaireBrut_value; $RevenuNetImposablePP_mois = $salaireNet_value; $IrPrelevePP_mois = $ir_value;break;
                case 8: $BrutImposablePP_mois = $salaireBrut_value; $RevenuNetImposablePP_mois = $salaireNet_value; $IrPrelevePP_mois = $ir_value;break;
                case 9: $BrutImposablePP_mois = $salaireBrut_value; $RevenuNetImposablePP_mois = $salaireNet_value; $IrPrelevePP_mois = $ir_value;break;
                case 10:$BrutImposablePP_mois = $salaireBrut_value; $RevenuNetImposablePP_mois = $salaireNet_value; $IrPrelevePP_mois = $ir_value;break;
                case 11:$BrutImposablePP_mois = $salaireBrut_value; $RevenuNetImposablePP_mois = $salaireNet_value; $IrPrelevePP_mois = $ir_value;break;
                default:$BrutImposablePP_mois = $salaireBrut_value; $RevenuNetImposablePP_mois = $salaireNet_value; $IrPrelevePP_mois = $ir_value;break;
            }
            $TtMtRevenuBrutImposablePP+=$BrutImposablePP_mois;
            $TtMtRevenuNetImposablePP+=$RevenuNetImposablePP_mois;
            $TtMtIrPrelevePP+= $IrPrelevePP_mois;
            // -------     -> list Personnel Permanent  <-    -------
            if(empty($listPersonnelPermanent))
            {
                // -------     -> list Personnel Permanent  <-    -------
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
            $cni_value=(!empty($param_user_extrafields['cin']))?$param_user_extrafields['cin']:' ';
            $numCNI = $dom->createElement('numCNI',$cni_value);
            $PersonnelPermanent->appendChild($numCNI);
            // Create a numCE element
            $numCE = $dom->createElement('numCE',' ');//null
            $PersonnelPermanent->appendChild($numCE);
            // Create a numPPR element
            $numPPR = $dom->createElement('numPPR',' ');
            $PersonnelPermanent->appendChild($numPPR);
            // Create a numCNSS element
            $sql_Paie_UserInfo="SELECT *  FROM llx_Paie_UserInfo WHERE userid=" . $permanentPersonnel['rowid'] . " ";
            $rest_Paie_UserInfo=$db->query($sql_Paie_UserInfo);
            $param_Paie_UserInfo=((object)($rest_Paie_UserInfo))->fetch_assoc();
            $ncnss_value=(!empty($param_Paie_UserInfo['cnss']))?$param_Paie_UserInfo['cnss']:' ';
            $numCNSS = $dom->createElement('numCNSS',$ncnss_value);
            $PersonnelPermanent->appendChild($numCNSS);
            // Create a ifu element
            $ifu = $dom->createElement('ifu',' ');
            //------------>
            foreach($rest_MonthDeclarationRubs as $mdr)
            {
                if($mdr['userid']==$permanentPersonnel['rowid'])
                {
                    $SBaseAnnuel+=$mdr['salaireDeBase'];
                }
            }
            // Create a salaireBaseAnnuel element
            $salaireBaseAnnuel = $dom->createElement('salaireBaseAnnuel',$SBaseAnnuel);
            $PersonnelPermanent->appendChild($salaireBaseAnnuel); 
            foreach($rest_salaire as $sb_pr)
            {
                if($sb_pr['userid']==$permanentPersonnel['rowid'])
                {
                    $SBrutAnnuel+=$sb_pr['salaireBrut'];
                    $periodeAnnuel+=$sb_pr['workingDays'];
                }
            }
            // Create a mtBrutTraitementSalaire element
            $mtBrutTraitementSalaire = $dom->createElement('mtBrutTraitementSalaire',$SBrutAnnuel);
            $PersonnelPermanent->appendChild($mtBrutTraitementSalaire);
            // Create a periode element
            $periode = $dom->createElement('periode',$periodeAnnuel);
            $PersonnelPermanent->appendChild($periode);
            // Create a mtExonere element
            $mtExonere = $dom->createElement('mtExonere',' ');
            $PersonnelPermanent->appendChild($mtExonere);
            // Create a mtEcheances element  
            $mtEcheances = $dom->createElement('mtEcheances',' ');
            $PersonnelPermanent->appendChild($mtEcheances);
            // Create a nbrReductions element
            $enfants=$param_MonthDeclarationRubs['enfants'];
            $nbrReductions_value= ($param_MonthDeclarationRubs['situationFamiliale']=="MARIE")? $enfants+1: $enfants;
            $nbrReductions = $dom->createElement('nbrReductions',$nbrReductions_value);
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
            
        }
        //-------------------> PERSONNEL OCCASIONNEL <-------------------
        else if($param_user_extrafields['stype']==2){
            $NbrPersoOccasionnel++;
            switch($param_salaire['month'])
            {
                case 1: $BrutImposablePO_mois = $salaireBrut_value; $IrPrelevePO_mois = $ir_value;break;
                case 2: $BrutImposablePO_mois = $salaireBrut_value; $IrPrelevePO_mois = $ir_value;break;
                case 3: $BrutImposablePO_mois = $salaireBrut_value; $IrPrelevePO_mois = $ir_value;break;
                case 4: $BrutImposablePO_mois = $salaireBrut_value; $IrPrelevePO_mois = $ir_value;break;
                case 5: $BrutImposablePO_mois = $salaireBrut_value; $IrPrelevePO_mois = $ir_value;break;
                case 6: $BrutImposablePO_mois = $salaireBrut_value; $IrPrelevePO_mois = $ir_value;break;
                case 7: $BrutImposablePO_mois = $salaireBrut_value; $IrPrelevePO_mois = $ir_value;break;
                case 8: $BrutImposablePO_mois = $salaireBrut_value; $IrPrelevePO_mois = $ir_value;break;
                case 9: $BrutImposablePO_mois = $salaireBrut_value; $IrPrelevePO_mois = $ir_value;break;
                case 10:$BrutImposablePO_mois = $salaireBrut_value; $IrPrelevePO_mois = $ir_value;break;
                case 11:$BrutImposablePO_mois = $salaireBrut_value; $IrPrelevePO_mois = $ir_value;break;
                default:$BrutImposablePO_mois = $salaireBrut_value; $IrPrelevePO_mois = $ir_value;break;
            }
            $TtMtBrutSommesPO+=$BrutImposablePO_mois;
            $TtMtRevenuNetImposablePP+=$IrPrelevePO_mois;
        }
        //---------------------> STAGIAIRES <-------------------------
        else if($param_user_extrafields['stype']==3){
            $NbrStagiaires++;
            switch($param_salaire['month'])
            {
                case 1: $BrutTraitSalaireSTG_mois = $salaireBrut_value; $MtRevenuNetImp_moisSTG = $netImposable_value;break;
                case 2: $BrutTraitSalaireSTG_mois = $salaireBrut_value; $MtRevenuNetImp_moisSTG = $netImposable_value;break;
                case 3: $BrutTraitSalaireSTG_mois = $salaireBrut_value; $MtRevenuNetImp_moisSTG = $netImposable_value;break;
                case 4: $BrutTraitSalaireSTG_mois = $salaireBrut_value; $MtRevenuNetImp_moisSTG = $netImposable_value;break;
                case 5: $BrutTraitSalaireSTG_mois = $salaireBrut_value; $MtRevenuNetImp_moisSTG = $netImposable_value;break;
                case 6: $BrutTraitSalaireSTG_mois = $salaireBrut_value; $MtRevenuNetImp_moisSTG = $netImposable_value;break;
                case 7: $BrutTraitSalaireSTG_mois = $salaireBrut_value; $MtRevenuNetImp_moisSTG = $netImposable_value;break;
                case 8: $BrutTraitSalaireSTG_mois = $salaireBrut_value; $MtRevenuNetImp_moisSTG = $netImposable_value;break;
                case 9: $BrutTraitSalaireSTG_mois = $salaireBrut_value; $MtRevenuNetImp_moisSTG = $netImposable_value;break;
                case 10:$BrutTraitSalaireSTG_mois = $salaireBrut_value; $MtRevenuNetImp_moisSTG = $netImposable_value;break;
                case 11:$BrutTraitSalaireSTG_mois = $salaireBrut_value; $MtRevenuNetImp_moisSTG = $netImposable_value;break;
                default:$BrutTraitSalaireSTG_mois = $salaireBrut_value; $MtRevenuNetImp_moisSTG = $netImposable_value;break;
            }
            $TtMtBrutTraitSalaireS+=$BrutTraitSalaireSTG_mois;
            $TtMtRevenuNetImpSTG+=$MtRevenuNetImp_moisSTG;
        }
    }
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
    $numeroCE = $dom->createElement('numeroCE','?');
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
    $effectifTotal = $dom->createElement('effectifTotal',($NbrPersoPermanent+$NbrPersoOccasionnel+$NbrStagiaires));
    $TraitementEtSalaire->appendChild($effectifTotal);
    // Create a nbrPersoPermanent element
    $nbrPersoPermanent = $dom->createElement('nbrPersoPermanent',$NbrPersoPermanent);
    $TraitementEtSalaire->appendChild($nbrPersoPermanent);
    // Create a nbrPersoOccasionnel element
    $nbrPersoOccasionnel = $dom->createElement('nbrPersoOccasionnel',$NbrPersoOccasionnel);
    $TraitementEtSalaire->appendChild($nbrPersoOccasionnel);
    // Create a nbrStagiaires element
    $nbrStagiaires = $dom->createElement('nbrStagiaires',$NbrStagiaires);
    $TraitementEtSalaire->appendChild($nbrStagiaires);
    // Create a totalMtRevenuBrutImposablePP element  
    $totalMtRevenuBrutImposablePP = $dom->createElement('totalMtRevenuBrutImposablePP',$TtMtRevenuBrutImposablePP);
    $TraitementEtSalaire->appendChild($totalMtRevenuBrutImposablePP);
    // Create a totalMtRevenuNetImposablePP element
    $totalMtRevenuNetImposablePP = $dom->createElement('totalMtRevenuNetImposablePP',$TtMtRevenuNetImposablePP);
    $TraitementEtSalaire->appendChild($totalMtRevenuNetImposablePP);
    // Create a totalMtTotalDeductionPP element
    $totalMtTotalDeductionPP = $dom->createElement('totalMtTotalDeductionPP','?');
    $TraitementEtSalaire->appendChild($totalMtTotalDeductionPP);
    // Create a totalMtIrPrelevePP element
    $totalMtIrPrelevePP = $dom->createElement('totalMtIrPrelevePP',$TtMtIrPrelevePP);
    $TraitementEtSalaire->appendChild($totalMtIrPrelevePP);
    // Create a totalMtBrutSommesPO element
    $totalMtBrutSommesPO = $dom->createElement('totalMtBrutSommesPO',$TtMtBrutSommesPO);
    $TraitementEtSalaire->appendChild($totalMtBrutSommesPO);
    // Create a totalIrPrelevePO element
    $totalIrPrelevePO = $dom->createElement('totalIrPrelevePO',$TtIrPrelevePO);
    $TraitementEtSalaire->appendChild($totalIrPrelevePO);
    // Create a totalMtBrutTraitSalaireSTG element
    $totalMtBrutTraitSalaireSTG = $dom->createElement('totalMtBrutTraitSalaireSTG',$TtMtBrutTraitSalaireS);
    $TraitementEtSalaire->appendChild($totalMtBrutTraitSalaireSTG);
    // Create a totalMtBrutIndemnitesSTG element
    $totalMtBrutIndemnitesSTG = $dom->createElement('totalMtBrutIndemnitesSTG','?');
    $TraitementEtSalaire->appendChild($totalMtBrutIndemnitesSTG);
    // Create a totalMtRetenuesSTG element
    $totalMtRetenuesSTG = $dom->createElement('totalMtRetenuesSTG','?');
    $TraitementEtSalaire->appendChild($totalMtRetenuesSTG);
    // Create a totalMtRevenuNetImpSTG element
    $totalMtRevenuNetImpSTG = $dom->createElement('totalMtRevenuNetImpSTG',$TtMtRevenuNetImpSTG);
    $TraitementEtSalaire->appendChild($totalMtRevenuNetImpSTG);
    // Create a totalSommePayeRTS element
    $totalSommePayeRTS = $dom->createElement('totalSommePayeRTS',' ');//null
    $TraitementEtSalaire->appendChild($totalSommePayeRTS);
    // Create a totalmtAnuuelRevenuSalarial element
    $TtmtAnuuelRevenuSalarial = $TtMtRevenuNetImpSTG+$TtMtRevenuNetImposablePP;
    $totalmtAnuuelRevenuSalarial = $dom->createElement('totalmtAnuuelRevenuSalarial',$TtmtAnuuelRevenuSalarial);
    $TraitementEtSalaire->appendChild($totalmtAnuuelRevenuSalarial);
    // Create a totalmtAbondement element
    $totalmtAbondement = $dom->createElement('totalmtAbondement',' ');//null
    $TraitementEtSalaire->appendChild($totalmtAbondement);
    // Create a montantPermanent element
    $montantPermanent = $dom->createElement('montantPermanent',' ');//null
    $TraitementEtSalaire->appendChild($montantPermanent);
    // Create a montantOccasionnel element
    $montantOccasionnel = $dom->createElement('montantOccasionnel',' ');//null
    $TraitementEtSalaire->appendChild($montantOccasionnel);
    // Create a montantStagiaire element
    $montantStagiaire = $dom->createElement('montantStagiaire',' ');//null
    $TraitementEtSalaire->appendChild($montantStagiaire);

    //----------------> ETAT CONCERNANT LE PERSONNEL PERMANENT <-----------------
    $TraitementEtSalaire->appendChild($listPersonnelPermanent);

   
  

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
                         <label>Du <span class="required">* </label>
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


    /*switch($param_ncin['stype'])
        {
            case 1:
                $NbrPersoPermanent++;
                $TtMtRevenuBrutImposablePP+=$param_salairebrut['salaireBrut'];
                $TtMtRevenuNetImposablePP+=$param_salairebrut['salaireNet'];
                $TtMtIrPrelevePP+=$param_salairebrut['ir'];
                break;
            case 2:
                $NbrPersoOccasionnel++;
                $TtMtBrutSommesPO+=$param_salairebrut['salaireBrut'];
                $TtMtRevenuNetImposablePP+=$param_salairebrut['ir'];
                break;
            case 3:
                $NbrStagiaires++;
                $TtMtBrutTraitSalaireS+=$param_salairebrut['salaireBrut'];
                $TtMtRevenuNetImpSTG+=$param_salairebrut['netImposable'];
                break;
            default:
                $NbrPersoPermanent++;
        }
    */










    /*
    foreach($rest as $permanentPersonnel)
    {
        $sql="SELECT *  FROM llx_user_extrafields WHERE rowid=" . $permanentPersonnel['rowid'] . "  ";
        $rest=$db->query($sql);
        $param_ncin=((object)($rest))->fetch_assoc();
        $pp=1;

        if($param_ncin['stype'] ==1 || empty($param_ncin['stype']))
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
           c
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
            $nom = $dom->createElement('nom',' ');
            $Doctorant->appendChild($nom);
            // Create a prenom element
            $prenom = $dom->createElement('prenom',' ');
            $Doctorant->appendChild($prenom);
        }
    }*/

?>











