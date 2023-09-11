<?php

// Load Dolibarr environment
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
require_once '../functionDeclarationLaisse.php';


 $RAN=0;// - Report à nouveau
 $RNDL_N=$RNDL_N1=0;//- Résultat net de l'exercice N-1
 $RL=0;// Réserve légale
 $AR=0;//Autres réserves

 $TotalA=0;//TOTAL A 
 $TotalB=0;//TOTAL B






  $dateChoisis=0;
  $dateChoisis=(isset($_POST['chargement']))?$_POST['date_select']:0;
  if(!isset($_POST['chargement']))
  {
    $dateChoisis=GETPOST('valeurdatechoise');
  }

  if(isset($_POST['chargement']))
  {
      for ($i = 1; $i <= 12; $i++) {
        ${'etataffectation' . $i} = $_POST['etataffectation' . $i];
    }

    $TotalA=$etataffectation2+$etataffectation4+$etataffectation6+$etataffectation8+$etataffectation10+$etataffectation12;
    $TotalB=$etataffectation3+$etataffectation5+$etataffectation7+$etataffectation9+$etataffectation11;
  }



 

 
//   $dateChoisis=2022;
  
  // $sql="SELECT * FROM llx_accounting_bookkeeping";
  // $rest=$db->query($sql);
  // foreach( $rest as $row )
  // { 
  //   $datetime = new DateTime($row['doc_date']);
  //   $dateCreation = $datetime->format('Y');
  //   $numero_compte = $row['numero_compte'];
  //   $montant = $row['montant']; 
  //   switch ($numero_compte) {
  //     case "116":list($RAN)=calculateMontant($dateCreation, $dateChoisis, $RAN,'0', '0','116');break;
  //     case "119":list($RNDL_N,$RNDL_N1)=calculateMontant($dateCreation, $dateChoisis, $RNDL_N,$RNDL_N1, '0','119');break;
  //     case "114":list($RL)=calculateMontant($dateCreation, $dateChoisis, $RL,'0', '0','114');break;
  //     case "115":list($AR)=calculateMontant($dateCreation, $dateChoisis, $AR,'0', '0','115');break;


  //   }

    

   

  
  // }
  if(isset($_POST['chargement']))
  {
    $data = "<?php ";
  
    for ($i = 1; $i <= 12; $i++) {
      ${'etataffectation' . $i} = $_POST['etataffectation' . $i];

      if (is_string(${'etataffectation' . $i})) {
        // If the value is a string, add double quotes around it
        $data .= '$etataffectation' . $i . ' = "' . ${'etataffectation' . $i} . "\";\n";
      }
      else {
        $data .= '$etataffectation' . $i . ' = ' . ${'etataffectation' . $i} . ";\n";  
      }

     
    }

    

    $data .= '$TotalA = ' . $TotalA . ";\n";
    $data .= '$TotalB = ' . $TotalB . ";\n";



   

    $data .= "?>";
    // Now, the variable $year will contain the year value "2023"
    $nomFichier = 'EtatAffectation_fichier_'. $dateChoisis.'.php';
    // Écrire les données dans le nouveau fichier
    file_put_contents($nomFichier, $data);

  }


        


?>