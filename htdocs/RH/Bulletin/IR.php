<?php
  // Load Dolibarr environment
  require '../../main.inc.php';
  require_once '../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';

  

  if(isset($_POST['fichierir']))
  { 

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
    $identifiantFiscal = $dom->createElement('identifiantFiscal','?');
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
    $raisonSociale = $dom->createElement('raisonSociale','?');
    $TraitementEtSalaire->appendChild($raisonSociale);
    // Create a exerciceFiscalDu element
    $exerciceFiscalDu = $dom->createElement('exerciceFiscalDu','?');
    $TraitementEtSalaire->appendChild($exerciceFiscalDu);
    // Create a exerciceFiscalAu element
    $exerciceFiscalAu = $dom->createElement('exerciceFiscalAu','?');
    $TraitementEtSalaire->appendChild($exerciceFiscalAu);
    // Create a exerciceFiscalAu element
    $annee_now= date('Y');
    $annee = $dom->createElement('annee',$annee_now);
    $TraitementEtSalaire->appendChild($annee);
    // Create a commune element
    $commune = $dom->createElement('commune');
    $TraitementEtSalaire->appendChild($commune);
    // Create a code element
    $code = $dom->createElement('code','?');
    $commune->appendChild($code);
    // Create a code element
    $adresse = $dom->createElement('adresse','?');
    $TraitementEtSalaire->appendChild($adresse);
    // Create a numeroCIN element
    $numeroCIN = $dom->createElement('numeroCIN','?');
    $TraitementEtSalaire->appendChild($numeroCIN);
    // Create a numeroCNSS element
    $numeroCNSS = $dom->createElement('numeroCNSS','?');
    $TraitementEtSalaire->appendChild($numeroCNSS);
    // Create a numeroCE element
    $numeroCE = $dom->createElement('numeroCE','?');
    $TraitementEtSalaire->appendChild($numeroCE);


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