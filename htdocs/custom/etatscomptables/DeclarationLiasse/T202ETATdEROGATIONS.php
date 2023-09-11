<?php

  $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/EtatDerogations/Etatderogations_fichier_' . $annee_du . '.php';

if (file_exists($filename)) {
    include $filename;
    
    $ValeursTableau = $dom->createElement('ValeursTableau');
    $groupeValeursTableau->appendChild($ValeursTableau);
    $tableau = $dom->createElement('tableau');
    $ValeursTableau->appendChild($tableau);
    $id = $dom->createElement('id','202');
    $tableau->appendChild($id);
    $groupeValeurs = $dom->createElement('groupeValeurs');
    $ValeursTableau->appendChild($groupeValeurs);
    CodeEdiValeurCellule('14098',$Etatderogations0);
    CodeEdiValeurCellule('14099',$Etatderogations1);
    CodeEdiValeurCellule('14101',$Etatderogations2);
    CodeEdiValeurCellule('14102',$Etatderogations3);
    CodeEdiValeurCellule('14104',$Etatderogations4);
    CodeEdiValeurCellule('14105',$Etatderogations5);

    $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
    $ValeursTableau->appendChild($extraFieldvaleurs);
  
}
// } else {
//     echo "Error: The file $filename does not exist.";
// }


?>
  