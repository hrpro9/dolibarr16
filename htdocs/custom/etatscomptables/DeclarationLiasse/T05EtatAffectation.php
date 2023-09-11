<?php
    $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/EtatAffectation/EtatAffectation_fichier_' . $annee_du . '.php';

  
    if (file_exists($filename)) {
        include $filename;
        
        $ValeursTableau = $dom->createElement('ValeursTableau');
        $groupeValeursTableau->appendChild($ValeursTableau);
        $tableau = $dom->createElement('tableau');
        $ValeursTableau->appendChild($tableau);
        $id = $dom->createElement('id','5');
        $tableau->appendChild($id);
        $groupeValeurs = $dom->createElement('groupeValeurs');
        $ValeursTableau->appendChild($groupeValeurs);


        CodeEdiValeurCellule('471',$etataffectation3);
        CodeEdiValeurCellule('473',$etataffectation5);
        CodeEdiValeurCellule('475',$etataffectation7);
        CodeEdiValeurCellule('477',$etataffectation9);
        CodeEdiValeurCellule('479',$etataffectation11);
        CodeEdiValeurCellule('481',$TotalA);
        CodeEdiValeurCellule('483',$etataffectation2);
        CodeEdiValeurCellule('485',$etataffectation4);
        CodeEdiValeurCellule('487',$etataffectation6);
        CodeEdiValeurCellule('489',$etataffectation8);
        CodeEdiValeurCellule('491',$etataffectation10);
        CodeEdiValeurCellule('493',$etataffectation12);
        CodeEdiValeurCellule('495',$TotalB);


        $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
        $ValeursTableau->appendChild($extraFieldvaleurs);



    }
    // } else {
    //     echo "Error: The file $filename does not exist.";
    // }
?>
  
