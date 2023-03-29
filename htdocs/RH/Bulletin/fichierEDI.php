<?php
  // Load Dolibarr environment
  require '../../main.inc.php';
  require_once '../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
      
 
  if(isset($_POST['fichieredi']))
  { 
      $nomfiche="ficherEDI.xml";
      header('Content-Disposition: attachment; filename='.$nomfiche);
      header('Content-Type: text/xml');
  
      //open file 
      // Create a new DOM document
      $dom=new DOMDocument('1.0', 'UTF-8');
      $dom->formatOutput=true;
      // Create a Liasse element
      $Liasse = $dom->createElement('Liasse');
      $dom->appendChild($Liasse);
      // model
      $model = $dom->createElement('model');
      $Liasse->appendChild($model);
      // id
      $dg1 = $dom->createElement('id','1');
      $model->appendChild($dg1);
      // resultatFiscal
      $resultatFiscal = $dom->createElement('resultatFiscal');
      $Liasse->appendChild($resultatFiscal);
      // resultatFiscal
      $identifiantfiscal = $dom->createElement('identifiantfiscal','123');
      $resultatFiscal->appendChild($identifiantfiscal);    
      // exerciceFiscalDu
      $exerciceFiscalDu = $dom->createElement('exerciceFiscalDu','2010-01-01');
      $resultatFiscal->appendChild($exerciceFiscalDu);
      // exerciceFiscalAu
      $exerciceFiscalAu = $dom->createElement('exerciceFiscalAu','2010-01-01');
      $resultatFiscal->appendChild($exerciceFiscalAu);  
      // Set the headers for the download
  
  
      // Output the XML file
      echo $dom->saveXML();
  }
  else
  {
      // HTML code goes here
  ?>
  <!doctype html>
  <html lang="en">
    <head>
      <link rel="stylesheet" href="style.css">
    </head>
    <body >
      <center>
        <div class="col-lg-4 m-auto">
          <form method="post"  enctype="multipart/form-data" >
          <ul class="form-style-1" style="text-align: center;">
              <h4 style="text-align: center;" class="field-divided">Fichier EDI !!!</h4>
              <li style="margin-top: 18px;">
              <input type="submit" name="fichieredi" value="Télécharge" />
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