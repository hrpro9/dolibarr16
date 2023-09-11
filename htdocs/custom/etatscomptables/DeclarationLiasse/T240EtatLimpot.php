<?php

  $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/EtatLimpot/Etatlimpot_fichier_' . $annee_du . '.php';

 
if (file_exists($filename)) {
    include $filename;
    
    $ValeursTableau = $dom->createElement('ValeursTableau');
    $groupeValeursTableau->appendChild($ValeursTableau);
    $tableau = $dom->createElement('tableau');
    $ValeursTableau->appendChild($tableau);
    $id = $dom->createElement('id','240');
    $tableau->appendChild($id);
    $groupeValeurs = $dom->createElement('groupeValeurs');
    $ValeursTableau->appendChild($groupeValeurs);
    CodeEdiValeurCellule('14347',$Etatlimpot0);
    CodeEdiValeurCellule('14349',$Etatlimpot1);
    CodeEdiValeurCellule('14990',$Etatlimpot2);
    CodeEdiValeurCellule('14353',$Etatlimpot3);
    CodeEdiValeurCellule('14990',$Etatlimpot4);
    CodeEdiValeurCellule('14353',$Etatlimpot5);
    CodeEdiValeurCellule('14990',$Etatlimpot6);
    CodeEdiValeurCellule('14353',$Etatlimpot7);
    CodeEdiValeurCellule('14990',$Etatlimpot8);
    CodeEdiValeurCellule('14353',$Etatlimpot9);
    CodeEdiValeurCellule('14990',$Etatlimpot10);
    CodeEdiValeurCellule('14353',$Etatlimpot11);
    CodeEdiValeurCellule('14990',$Etatlimpot12);
    CodeEdiValeurCellule('14353',$Etatlimpot13);
    CodeEdiValeurCellule('17929',$Etatlimpot14);
    CodeEdiValeurCellule('14992',$Etatlimpot15);
    CodeEdiValeurCellule('14994',$Etatlimpot16);
    CodeEdiValeurCellule('14996',$Etatlimpot17);
    CodeEdiValeurCellule('14355',$Etatlimpot18);
    CodeEdiValeurCellule('14356',$Etatlimpot19);
    CodeEdiValeurCellule('14355',$Etatlimpot20);
    CodeEdiValeurCellule('14356',$Etatlimpot21);
    CodeEdiValeurCellule('14355',$Etatlimpot22);
    CodeEdiValeurCellule('14356',$Etatlimpot23);
    CodeEdiValeurCellule('14355',$Etatlimpot24);
    CodeEdiValeurCellule('14356',$Etatlimpot25);
    CodeEdiValeurCellule('14355',$Etatlimpot26);
    CodeEdiValeurCellule('14356',$Etatlimpot27);
    CodeEdiValeurCellule('14380',$sum1);
    CodeEdiValeurCellule('14415',$Etatlimpot28);

    $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
    $ValeursTableau->appendChild($extraFieldvaleurs);
  


}
// } else {
//     echo "Error: The file $filename does not exist.";
// }


?>
  