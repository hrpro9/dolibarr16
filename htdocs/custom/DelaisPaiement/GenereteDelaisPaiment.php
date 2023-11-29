<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    // Load Dolibarr environment
    require '../../main.inc.php';
    require_once '../../vendor/autoload.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
    session_start();
    $action = GETPOST('action');
    if ($action != 'generate')
    llxHeader("", "");
    if(isset($_POST['fichierDelaisPaiement']) || isset($_POST['genereDelaisPaiement']))
    { 
        $totalAllAmount=0;
        $trimestre_value=$_POST['trimestre'];
        $periode_value=$_POST['periode'];
        $activite_value=$_POST['activite'];
        $dateAlFitr=$_POST['dateAlFitr'];
        $dateAlAdha=$_POST['dateAlAdha'];
        $dateAlMawlid=$_POST['dateAlMawlid'];
        $annee_now=date('Y'); 

        // identification_fiscale soc
        $sql="SELECT * FROM llx_const ";
        $restConst=$db->query($sql);
        foreach($restConst as $rowConst) {if($rowConst['name']=='MAIN_INFO_PROFID5'){$ice=$rowConst['value'];}}
        function DateFacture($M_D_One,$M_D_Two,$priodecheck=false){
            $annee_now=($priodecheck)?date('Y')-1:date('Y');
            $dateOne=$annee_now.$M_D_One;
            $dateTwo=$annee_now.$M_D_Two;
            $sqlF="SELECT * FROM llx_facture_fourn WHERE datef BETWEEN '".  $dateOne."' AND '". $dateTwo."'";
            return $sqlF;
        }
        switch($periode_value)
        {
            case 'trimestre01':$sqlF =  DateFacture('-01-01','-03-31');$periode_Num=1;break;
            case 'trimestre02': $sqlF =  DateFacture('-03-01','-06-30');$periode_Num=2;break;
            case 'trimestre03': $sqlF =  DateFacture('-07-01','-09-30'); $periode_Num=3;break;
            case 'trimestre04': $sqlF =  DateFacture('-10-01','-12-31');$periode_Num=4; break;
            default :$sqlF =  DateFacture('-01-01','-12-31',true); $periode_Num=5; break;
        }
        $restfacture=$db->query($sqlF);
        if($restfacture != null && $restfacture->num_rows > 0)
        {
            $WriteV=true;
            foreach($restfacture as $rowF)
            {
                $natureMarchandiseValue='';
                $sumValueValid=0;
                $sumValueNonValid=0;
                $array=[];
                $dateEmission_Value=$rowF['datef'];
                $datePrevuePaiement_Value=$rowF['date_lim_reglement'];
                $montantFactureTtc_Value=$rowF['multicurrency_total_ttc'];
                if(empty($datePrevuePaiement_Value)){
                    $dateEmission_Value = $rowF['datef'];
                    $datetime = new DateTime($dateEmission_Value);
                    $datetime->add(new DateInterval('P60D'));
                    $datePrevuePaiementNull= $datetime->format('Y-m-d');  
                    $datePrevuePaiement_Value =$datePrevuePaiementNull;    
                }
                $countryCode = 'MA'; // Country code for Morocco
                $year=date('Y');
                $apiUrl = "https://date.nager.at/Api/v2/PublicHolidays/$year/$countryCode";
                $response = file_get_contents($apiUrl);
                $holidays = json_decode($response, true);
                if (!function_exists('datePrevuePaiement')) {
                    function datePrevuePaiement($datePrevuePaiement_Value, $intervalSpec)
                    {
                        $datetime = new DateTime($datePrevuePaiement_Value);
                        $datetime->add(new DateInterval($intervalSpec));
                        return $datetime->format('Y-m-d');
                    }
                }
                if ($holidays !== null) {
                    foreach ($holidays as $holiday) {
                        if ($datePrevuePaiement_Value == $holiday['date']) { $datePrevuePaiement_Value = datePrevuePaiement($datePrevuePaiement_Value, 'P1D');  }
                    }
                }
                switch ($datePrevuePaiement_Value) {
                    case $dateAlFitr:
                    case $dateAlAdha:
                        $datePrevuePaiement_Value = datePrevuePaiement($datePrevuePaiement_Value, 'P2D'); break;
                    case $dateAlMawlid:  $datePrevuePaiement_Value = datePrevuePaiement($datePrevuePaiement_Value, 'P1D'); break;
                }
                $sql = "SELECT p.*, pf.* FROM llx_paiementfourn_facturefourn pf JOIN llx_paiementfourn p ON pf.fk_paiementfourn = p.rowid WHERE pf.fk_facturefourn = '" . $rowF['rowid'] . "'";
                $res = $db->query($sql);
                foreach ($res as $row) {
                    if ($datePrevuePaiement_Value >= $row['datep']) {  $sumValueValid += $row['amount'];  }
                    else {  
                        $sumValueNonValid += $row['amount']; 
                        $array[] = $row['rowid'];
                    }
                }
                if($sumValueValid!= $montantFactureTtc_Value &&  $datePrevuePaiement_Value<date('Y-m-d')){
                    $arryFk[]=$rowF['ref'];
                    if(isset($_POST['genereDelaisPaiement']))
                    {  
                        $selectedFactures = $_POST["facture"];
                        $selectedTypeMarchandises = $_POST["typeMarchandise"];
                        foreach ($selectedFactures as $index => $facture) {
                            $typeMarchandise = $selectedTypeMarchandises[$index];
                            if($facture==$rowF['ref']){ $natureMarchandiseValue=$typeMarchandise;  }
                        }
                        if($WriteV){
                            $dom=new DOMDocument('1.0', 'UTF-8'); 
                            $dom->formatOutput=true;  
                            $dom->xmlStandalone = true;
                            $DeclarationDelaiPaiement = $dom->createElement('DeclarationDelaiPaiement');
                            $dom->appendChild($DeclarationDelaiPaiement);
                            $identifiantFiscal = $dom->createElement('identifiantFiscal',$ice);
                            $DeclarationDelaiPaiement->appendChild($identifiantFiscal);
                            $annee = $dom->createElement('annee',$annee_now);
                            $DeclarationDelaiPaiement->appendChild($annee);
                            $periode = $dom->createElement('periode',$periode_Num);
                            $DeclarationDelaiPaiement->appendChild($periode);
                            $activite = $dom->createElement('activite',$activite_value);
                            $DeclarationDelaiPaiement->appendChild($activite);
                            $ChiffreAffaire=$_POST['ChiffreAffaire'];
                            $chiffreAffaire = $dom->createElement('chiffreAffaire',$ChiffreAffaire);
                            $DeclarationDelaiPaiement->appendChild($chiffreAffaire);
                            $listeFacturesHorsDelai = $dom->createElement('listeFacturesHorsDelai');
                            $DeclarationDelaiPaiement->appendChild($listeFacturesHorsDelai);
                            $WriteV=false;
                        }
                        if(empty($array)){ $array[]=$row['rowid']; }
                            $sum_montantPayeHorsDelaiValue=0;
                            foreach ($array as $value) {
                                $sqlS = "SELECT * FROM llx_societe WHERE rowid ='". $rowF['fk_soc']."'";
                                $resultS = $db->query($sqlS);
                                if ($resultS->num_rows > 0) {
                                    $rowS = $resultS->fetch_assoc();
                                    $identifiantFiscal_Value=$rowS['ape'];
                                    $adresseSiegeSocial_Value=$rowS['address'];
                                    $numFacture=$rowF['ref'];    
                                    $montantFactureTtc_Value=$rowF['multicurrency_total_ttc'];
                                    $FactureHorsDelai = $dom->createElement('FactureHorsDelai');
                                    $listeFacturesHorsDelai->appendChild($FactureHorsDelai);
                                    $identifiantFiscal = $dom->createElement('identifiantFiscal',$identifiantFiscal_Value);
                                    $FactureHorsDelai->appendChild($identifiantFiscal);
                                    $adresseSiegeSocial = $dom->createElement('adresseSiegeSocial',$adresseSiegeSocial_Value);
                                    $FactureHorsDelai->appendChild($adresseSiegeSocial);
                                    $numFacture = $dom->createElement('numFacture',$numFacture);
                                    $FactureHorsDelai->appendChild($numFacture);
                                    $dateEmission = $dom->createElement('dateEmission',$dateEmission_Value);
                                    $FactureHorsDelai->appendChild($dateEmission);
                                    $natureMarchandise = $dom->createElement('natureMarchandise',$natureMarchandiseValue);
                                    $FactureHorsDelai->appendChild($natureMarchandise);
                                    $dateLivraisonMarchandise = $dom->createElement('dateLivraisonMarchandise',$dateEmission_Value);
                                    $FactureHorsDelai->appendChild($dateLivraisonMarchandise);
                                    $datepref=($rowF['date_lim_reglement'])?$rowF['date_lim_reglement']:$datePrevuePaiementNull;
                                    $datePrevuePaiement = $dom->createElement('datePrevuePaiement', $datepref);
                                    $FactureHorsDelai->appendChild($datePrevuePaiement);
                                    $montantFactureTtc = $dom->createElement('montantFactureTtc',round($montantFactureTtc_Value,2));
                                    $FactureHorsDelai->appendChild($montantFactureTtc);
                                    $sqlP2="SELECT * FROM llx_paiementfourn WHERE rowid='". $value."'";
                                    $resP2=$db->query($sqlP2); 
                                    $rowp2 = $resP2->fetch_assoc();
                                    $montantPayeHorsDelaiValue=$rowp2['amount'];
                                    $montantNonEncorePayeTestSum=$montantFactureTtc_Value-($sumValueValid+$sumValueNonValid);
                                    $sum_montantPayeHorsDelaiValue+=$montantPayeHorsDelaiValue;
                                    $montantNonEncorePayeValue=$montantFactureTtc_Value-($sumValueValid+$sum_montantPayeHorsDelaiValue);
                                    $montantNonEncorePaye = $dom->createElement('montantNonEncorePaye',round($montantNonEncorePayeValue,2));
                                    $FactureHorsDelai->appendChild($montantNonEncorePaye);
                                    $montantPayeHorsDelai = $dom->createElement('montantPayeHorsDelai',round($montantPayeHorsDelaiValue,2));
                                    $FactureHorsDelai->appendChild($montantPayeHorsDelai);
                                    $timestamp = strtotime($rowp2['datep']);
                                    $dateOnly = date('Y-m-d', $timestamp);
                                    $datePaiementHorsDelai = $dom->createElement('datePaiementHorsDelai',$dateOnly);
                                    $FactureHorsDelai->appendChild($datePaiementHorsDelai);
                                    switch($rowp2['fk_paiement']){
                                        case 4 : $modePaiementValue=1;break;
                                        case 7 : $modePaiementValue=2;break;
                                        case 2 : $modePaiementValue=4;break;
                                        case 106 : $modePaiementValue=5;break;
                                        default : $modePaiementValue=3;break;
                                    }
                                    $modePaiement = $dom->createElement('modePaiement',$modePaiementValue);
                                    $FactureHorsDelai->appendChild($modePaiement);
                                    $referencePaiement = $dom->createElement('referencePaiement',$rowp2['ref']);
                                    $FactureHorsDelai->appendChild($referencePaiement); 
                                    if (!function_exists('checkMonthYear')) {
                                        function checkMonthYear($dateTime1,$dateTime2,$montantPayeHorsDelaiValue ){
                                            $totalAmount=0;$monthNumberF=0;$amountFirstMonth=0;$amountOtherMonths=0;
                                            $monthsArray = [];
                                            while ($dateTime1->format('Ym') <= $dateTime2->format('Ym')) {
                                                $monthsArray[] = $dateTime1->format('m-Y');
                                                $dateTime1->modify('+1 month');
                                            }
                                            $uniqueMonths = array_unique($monthsArray);
                                            $numberOfMonths = count($uniqueMonths);
                                            $firstMonthPercentage = 3;
                                            $otherMonthsPercentage = 0.85;
                                            $amountFirstMonth = $montantPayeHorsDelaiValue * ($firstMonthPercentage / 100);
                                            $amountOtherMonths = $montantPayeHorsDelaiValue * ($otherMonthsPercentage / 100) * ($numberOfMonths - 1);
                                            $totalAmount = $amountFirstMonth + $amountOtherMonths; 
                                            return $totalAmount ;
                                        }  
                                    }
                                    if(!empty($rowp2['datep']) && $rowp2['datep']>$datePrevuePaiement_Value )
                                    {
                                        $dateTime2 = new DateTime($rowp2['datep']);
                                        $dateTime1 = DateTime::createFromFormat('Y-m-d',$datePrevuePaiement_Value);   
                                        $totalAllAmount+=checkMonthYear($dateTime1,$dateTime2,$montantPayeHorsDelaiValue );
                                    }
                                    if($montantNonEncorePayeTestSum!=0 && $checkFacture!=$rowF['rowid'] ){
                                        $checkFacture=$rowF['rowid'];
                                        $dateDay=date('Y-m-d');
                                        $dateTime1 = DateTime::createFromFormat('Y-m-d', $datePrevuePaiement_Value);
                                        $dateTime2 = DateTime::createFromFormat('Y-m-d', $dateDay);
                                        $totalAllAmount+=checkMonthYear($dateTime1,$dateTime2,$montantNonEncorePayeTestSum );
                                    }
                                }
                            }
                        }   
                    }else if($periode_Num!=5){ $errorF=true; }
                }     
                if (isset($_POST['genereDelaisPaiement'])) {       
                    $nomfiche = "DelaisPaiement" . $periode_value . $annee_now . ".xml";
                    $xmlContent = $dom->saveXML();
                    header('Content-Disposition: attachment; filename=' . $nomfiche);
                    header('Content-Type: text/xml');
                    echo $xmlContent;
                    // Save $totalAllAmount in the session
                    $_SESSION['totalAllAmount'] = $totalAllAmount;
                    $sql = "CREATE TABLE IF NOT EXISTS llx_DelaisPaiement (id INT AUTO_INCREMENT PRIMARY KEY, periode VARCHAR(255),totalAmount VARCHAR(255),dateDP VARCHAR(255) );";
                    $res = $db->query($sql);
                    if ($res);
                    $datnow = date('Y-m-d'); 
                    switch($periode_Num)
                    {
                        case 1:$periode_V="trimestre 1 ";break;
                        case 2:$periode_V="trimestre 2";break;
                        case 3:$periode_V="trimestre 3";break;
                        case 4:$periode_V="trimestre 4";break;
                        default :$periode_V="Annuelle"; break;
                    }
                    $checkAmoutexist=true;
                    $sqlCheckExistence = "SELECT * FROM llx_DelaisPaiement ";
                    $result = $db->query($sqlCheckExistence);
                    foreach ($result as $row) {
                        if ($row['totalAmount'] == $totalAllAmount && $row['dateDP'] == $datnow) {
                            $checkAmoutexist=false;
                        }
                    }
                    if($checkAmoutexist){
                        $sqlInsertData = "INSERT INTO llx_DelaisPaiement (periode, totalAmount, dateDP) VALUES ('$periode_V', '$totalAllAmount', '$datnow')";
                        $res = $db->query($sqlInsertData);
                    }
                } 
            }else{ $errorF=true; }
        if(isset($_POST['fichierDelaisPaiement']))
        {
            print '
                <!doctype html>
                <html lang="en">
                <head>
                    <link rel="stylesheet" href="style.css">       
                </head>
                <body >
                    <center>
                        <div class="col-lg-4 m-auto" style="width:100% ;height: 100%;">
                            <form method="post" action="GenereteDelaisPaiment.php"  enctype="multipart/form-data" >
                            <input type="hidden" name="action" value="generate">
                            <input type="hidden" name="trimestre" value="'.$trimestre_value.'">
                            <input type="hidden" name="periode" value="'.$periode_value.'">
                            <input type="hidden" name="activite" value="'.$activite_value.'">
                            <ul class="form-style-1" style="text-align: center;">
                                <label style="text-align: center;" class="field-divided">Fichier EDI Delais Paiement !!!</label>
                                ';
                                    foreach($arryFk as $rowF)
                                    {
                                        print '
                                            <li>
                                                <select  name="facture[]" required>
                                                    <option value="'. $rowF.'">'. $rowF.'</option>
                                                </select>
                                                <select name="typeMarchandise[]"  required>
                                                    <option value="">Type Marchandise</option>
                                                    <option value="Marchandise1">Marchandise 1</option>
                                                    <option value="Marchandise2">Marchandise 2</option>
                                                    <option value="Marchandise3">Marchandise 3</option>
                                                </select>
                                            </li>
                                        ';
                                    }
                                    if($errorF){
                                        $pageList = DOL_URL_ROOT.'\custom\DelaisPaiement\declarationDelaisPaiement.php';
                                        print'
                                            <span class="alertText">d\'aucune information  concernant le Délai de Paiement <a href="'.$pageList.'">click ici</a><br class="clear"/></span>
                                        ';
                                    }else{
                                        $pageList = DOL_URL_ROOT.'declarationDelaisPaiement.php';
                                        print '
                                        <li>
                                            <label>Chiffre Affaire <span class="required">* </label>
                                            <input type="text" name="ChiffreAffaire"  required/>
                                        </li>
                                        <div style="display:flex; justify-content: space-evenly;">
                                            <li>
                                            <label>Eid al-Fitr <span class="">* </label>
                                            <input type="date" name="dateAlFitr"  />
                                            </li>
                                            <li>
                                            <label>Eid al-Adha  <span class="">* </label>
                                            <input type="date" name="dateAlAdha"  />
                                            </li> 
                                            <li>
                                                <label>Eid al-Mawlid Annabawi  <span class="">* </label>
                                                <input type="date" name="dateAlMawlid"  />
                                            </li>
                                       </div>
                                        <li style="margin-top: 18px;">
                                            <input type="submit" name="genereDelaisPaiement" value="Télécharge" onclick="refreshPage()" />
                                        </li>
                                        <script>
                                            function refreshPage() {
                                                // Wait for a short time before refreshing the page
                                                setTimeout(function() {
                                                    // Get the totalAllAmount value from wherever it\'s stored
                                                    var totalAllAmount = "YOUR_TOTAL_ALL_AMOUNT_VALUE"; // Replace this with the actual value

                                                    // Construct the URL with the totalAllAmount parameter
                                                    var url = "' . $pageList . '?success=1";

                                                    // Redirect to the specified URL
                                                    window.location.href = url;
                                                }, 1000); // Adjust the delay in milliseconds as needed
                                            }
                                        </script>';
                                    }
                                print'      
                            </ul>
                            </form>  
                        </div> 
                    </center>
                </body>
                </html>
            ';
        }
    }



?>
 

