<?php
  // Load Dolibarr environment
  require_once '../../../main.inc.php';
  require_once '../../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';

  $action = GETPOST('action');
  if ($action != 'generate')
    llxHeader("", "");

  if(isset($_POST['fichierir']))
  { 

    $Exercicedu=$_POST['Exercicedu'];
    $Exerciceau=$_POST['Exerciceau'];
    //date du
    $datetime = new DateTime($Exercicedu);
    $annee_du = $datetime->format('Y');
    $mois_du = $datetime->format('m');
    $jour_du = $datetime->format('d');
    //date Au
    $datetime = new DateTime($Exerciceau);
    $annee_au = $datetime->format('Y');
    $mois_au = $datetime->format('m');
    $jour_au = $datetime->format('d');
    //nom fiche xml
    $nomfiche="Liasse".$annee_au.".xml";
    header('Content-Disposition: attachment; filename='.$nomfiche);
    header('Content-Type: text/xml'); 
    // Create a new DOM document
    $dom=new DOMDocument('1.0', 'UTF-8'); 
    $dom->formatOutput=true;  
    $Liasse = $dom->createElement('Liasse');
    $dom->appendChild($Liasse);
    $modele = $dom->createElement('modele');
    $Liasse->appendChild($modele);
    $id = $dom->createElement('id','7');
    $modele->appendChild($id);
    $resultatFiscal = $dom->createElement('resultatFiscal');
    $Liasse->appendChild($resultatFiscal);
    $identifiantFiscal = $dom->createElement('identifiantFiscal','123');
    $resultatFiscal->appendChild($identifiantFiscal);
    $exerciceFiscalDu = $dom->createElement('exerciceFiscalDu', $annee_du.'-'.$mois_du.'-'.$jour_du);
    $resultatFiscal->appendChild($exerciceFiscalDu);
    $exerciceFiscalAu = $dom->createElement('exerciceFiscalAu', $annee_au.'-'.$mois_au.'-'.$jour_au);
    $resultatFiscal->appendChild($exerciceFiscalAu);

    $groupeValeursTableau = $dom->createElement('groupeValeursTableau');
    $Liasse->appendChild($groupeValeursTableau);
    function CodeEdiValeurCellule($cellulecodeEdi,$cellulevaleur){
        global $groupeValeurs,$dom;
        $ValeurCellule = $dom->createElement('ValeurCellule');
        $groupeValeurs->appendChild($ValeurCellule);
        $cellule = $dom->createElement('cellule'); 
        $ValeurCellule->appendChild($cellule);
        $codeEdi = $dom->createElement('codeEdi',$cellulecodeEdi);
        $cellule->appendChild($codeEdi);
        $valeur = $dom->createElement('valeur',$cellulevaleur);                                                                       
        $ValeurCellule->appendChild($valeur);
    }
    function CodeEdiValeurCelluleLigne($cellulecodeEdi,$cellulevaleur,$numeroLignevaleur){
        global $groupeValeurs,$dom;
        $ValeurCellule = $dom->createElement('ValeurCellule');
        $groupeValeurs->appendChild($ValeurCellule);
        $cellule = $dom->createElement('cellule'); 
        $ValeurCellule->appendChild($cellule);
        $codeEdi = $dom->createElement('codeEdi',$cellulecodeEdi);
        $cellule->appendChild($codeEdi);
        $valeur = $dom->createElement('valeur',$cellulevaleur);                                                                       
        $ValeurCellule->appendChild($valeur);
        $numeroLigne = $dom->createElement('numeroLigne',$numeroLignevaleur);                                                                       
        $ValeurCellule->appendChild($numeroLigne);
    }
    function CodeextraFieldvaleurs($codeextraField,$valeurcodeextraField){
        global $extraFieldvaleurs,$dom;
       
        $ExtraFieldValeur = $dom->createElement('ExtraFieldValeur');
        $extraFieldvaleurs->appendChild($ExtraFieldValeur);
        $extraField = $dom->createElement('extraField');
        $ExtraFieldValeur->appendChild($extraField);
        $code = $dom->createElement('code',$codeextraField);
        $extraField->appendChild($code);
        $valeur = $dom->createElement('valeur',$valeurcodeextraField);
        $ExtraFieldValeur->appendChild($valeur);
    }
    // ---------------------------------------------- T01 PASSIF -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T01Passif.php';
    // ---------------------------------------------- T02 ACTIF -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T02Actif.php'; 
    // ---------------------------------------------- T06 Hors taxes -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T06HorsTaxes.php'; 
    // ---------------------------------------------- T07 Passage Resultat Comptable -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T07PassageResultat.php'; 
    // ---------------------------------------------- T11 IMMOBILISATION FINANCIERES -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T11ImmobilisationFinancieres.php'; 
    // ---------------------------------------------- T32 ESG -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T32ESG.php'; 
    // ---------------------------------------------- T34 CPC -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T34CPC.php'; 
    // ---------------------------------------------- T23 Tableau des biens en credit-bail -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T23biensCreditBail.php';
    // ---------------------------------------------- T24 AMORTISSEMENTS -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T24Amortissements.php';  
    // ---------------------------------------------- T37 PROVISIONS -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T37Provisions.php';
    // ---------------------------------------------- T38 Tableau des plus ou moins values sur cessions ou retraits d'immobilisations -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T38RetratsDimmobilisation.php';
    // ---------------------------------------------- T39 Tableau des titres de participation -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T39TitresParticipation.php';
    // ---------------------------------------------- T40 DETAIL TAXE SUR LA VALEUR AJOUTEE -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T40DETAILTAXE.php'; 
    // ---------------------------------------------- T41 Etat de repartition du capital social -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T41CapitalSocial.php';
    // ---------------------------------------------- T05 TABLEAU D'affectation des resultats intervenue au cours de l'exercice  -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T05EtatAffectation.php';
    // ---------------------------------------------- T12 Etat des dotations aux amortissements relatifs au immobilisations  -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T12DotationImobilisation.php';
    // ---------------------------------------------- T26 Etat Des Plus Values constatees en cas de fusions -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T26ConstateesFusions.php'; 
    // ---------------------------------------------- T27 Tableau des interets des emprunts contractes... -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T27EtatDesInterets.php';
    // ---------------------------------------------- T28 Tableau des location et baux autres que le credit bail -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T28AutrescreditBail.php';
    // ---------------------------------------------- T36 Etat DETAIL DES STOCKS -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T36EtatDETAILSTOCKS.php';  
    // ---------------------------------------------- T200 TABLEAU DES OPERATIONS EN DEVISES COMPTABILISEES PENDANT L'EXCERCICE -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T200OperationDevises.php';
    // ---------------------------------------------- T201 Etat des changements de methods -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T201EtatChangements.php';
    // ---------------------------------------------- T202 ETAT Des DEROGATIONS -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T202ETATdEROGATIONS.php';
    // ---------------------------------------------- T203 FINANCEMENT DE L'EXERCICE -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T203FINANCEMENTlEXERCICE.php';  
    // ---------------------------------------------- T220 Principales Methodes -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T220PrincipalesMethodes.php';  
    // ---------------------------------------------- T240 etat pour le calcul de l'impot sur les societes entreprises encouragees -------------------------------------
    include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DeclarationLiasse/T240EtatLimpot.php';

    


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
                            <input type="hidden" name="action" value="generate">
                            <ul class="form-style-1" style="text-align: center;">
                                <label style="text-align: center;" class="field-divided">Declaration Liasse !</label>
                                <li>
                                <label>Exercice Du  <span class="required">* </label>
                                <input type="date" name="Exercicedu" class="field-divided" placeholder="YYYY-MM-DD" required />
                                </li>
                                <li>
                                <label>Exercice Au  <span class="required">* </label>
                                <input type="date" name="Exerciceau" class="field-divided" placeholder="YYYY-MM-DD" required />
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

