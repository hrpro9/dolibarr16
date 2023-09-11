<?php

  $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/Retratsdimm/RetratsDimmobilisation_fichier_' . $annee_du . '.php';

if (file_exists($filename)) {
    include $filename;
    
    $ValeursTableau = $dom->createElement('ValeursTableau');
    $groupeValeursTableau->appendChild($ValeursTableau);
    $tableau = $dom->createElement('tableau');
    $ValeursTableau->appendChild($tableau);
    $id = $dom->createElement('id','38');
    $tableau->appendChild($id);
    $groupeValeurs = $dom->createElement('groupeValeurs');
    $ValeursTableau->appendChild($groupeValeurs);
 
    $n=0;
    $y=1;
    for($i=1;$i<=18;$i++)
    {
        $x=1929;
        for($j=1;$j<=6;$j++)
        {
            $valeur=${'RDimmobilisation' . $n} ;
            CodeEdiValeurCelluleLigne($x,$valeur,$y);
            $x++;
            $n++;
        }
        $valeurP=${'PlusValues' . $i} ;
        CodeEdiValeurCelluleLigne($x,$valeurP,$y);
        $x++;
        $valeurM=${'MoinsValues' . $i} ;
        CodeEdiValeurCelluleLigne($x,$valeurM,$y);
        $y++;
    }

    CodeEdiValeurCellule('2037',' ');
    $s=2038;
    for($j=1;$j<=6;$j++)
    {
        $valeursum=${'sum' . $j} ;
        CodeEdiValeurCellule($s,$valeursum,);
        $s++;
     
    }

 

    $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs');
    $ValeursTableau->appendChild($extraFieldvaleurs);

    CodeextraFieldvaleurs('72','72');


}
// } else {
//     echo "Error: The file $filename does not exist.";
// }


?>
  


