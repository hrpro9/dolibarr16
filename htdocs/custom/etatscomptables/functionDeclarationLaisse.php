<?php

  function affichageAnnees()
  {
      $anneeDebut = date('Y');
      $anneeFin = 2015;
      for ($annee = $anneeDebut; $annee >= $anneeFin; $annee--) {  
        echo '<option value="' . $annee . '">' . $annee . '</option>';
      }
  }
  function readMontant($name)
  {
    $name=!empty($name)?$name:0;
    echo number_format($name,2);
  }
  function montantCalcul($code_compt,$date)
  {
    global $db; // Assurez-vous que la variable $db est accessible dans cette fonction 
    $sql = "SELECT SUM(montant) AS montant FROM llx_accounting_bookkeeping WHERE numero_compte LIKE '$code_compt%' AND year(doc_date)=$date";
    $rest = $db->query($sql);
    $row = ((object)($rest))->fetch_assoc();
    $mont = 0; // Initialisez la variable $mont pour éviter une erreur si aucune valeur n'est trouvée
    $mont = $row['montant'];
    return $mont;
  }
  if (!function_exists('calculateMontant'))
  {
    function calculateMontant($dateCreation, $dateChoisis, $variablex,$variablex1,$variablex2,$codecompt) 
    {
      $anneeDebut = (!empty($dateChoisis))?$dateChoisis:date('Y');
      $dateCreationN1=$anneeDebut - 1;
      $dateCreationN2=$anneeDebut - 2;
          
      $valeurn = ($dateCreation == $anneeDebut) ? montantCalcul($codecompt, $anneeDebut) : $variablex;
      $valeurn1 = ($dateCreation == $dateCreationN1) ? montantCalcul($codecompt, $dateCreationN1) : $variablex1;
      $valeurn2 = ($dateCreation == $dateCreationN2) ? montantCalcul($codecompt, $dateCreationN2) : $variablex2;
      return array($valeurn, $valeurn1, $valeurn2);
    }
  }


?>