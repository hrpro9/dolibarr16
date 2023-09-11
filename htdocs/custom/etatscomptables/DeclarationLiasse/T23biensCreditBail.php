<?php

  $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/CreditBail/CreditBail_fichier_' . $annee_du . '.php';

if (file_exists($filename)) {
    include $filename;
    
    $ValeursTableau = $dom->createElement('ValeursTableau');
    $groupeValeursTableau->appendChild($ValeursTableau);
    $tableau = $dom->createElement('tableau');
    $ValeursTableau->appendChild($tableau);
    $id = $dom->createElement('id','23');
    $tableau->appendChild($id);
    $groupeValeurs = $dom->createElement('groupeValeurs');
    $ValeursTableau->appendChild($groupeValeurs);
 
    $n=0;
    $y=1;
    for($i=0;$i<=17;$i++)
    {
        $x=1098;
        for($j=1;$j<=11;$j++)
        {
            $valeur=${'Valeurajouter' . $n} ;
            CodeEdiValeurCelluleLigne($x,$valeur,$y);
            $x++;
            $n++;
        }
        $y++;

    }

    $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs');
    $ValeursTableau->appendChild($extraFieldvaleurs);
    CodeextraFieldvaleurs('53','53');

   

    


}
// } else {
//     echo "Error: The file $filename does not exist.";
// }


?>
  


