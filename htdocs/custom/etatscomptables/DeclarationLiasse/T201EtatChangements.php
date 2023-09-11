<?php
    $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/EtatChangements/EtatChangment_fichier_' . $annee_du . '.php';
    if (file_exists($filename)) {
        include $filename;
        
        $ValeursTableau = $dom->createElement('ValeursTableau');
        $groupeValeursTableau->appendChild($ValeursTableau);
        $tableau = $dom->createElement('tableau');
        $ValeursTableau->appendChild($tableau);
        $id = $dom->createElement('id','201');
        $tableau->appendChild($id);
        $groupeValeurs = $dom->createElement('groupeValeurs');
        $ValeursTableau->appendChild($groupeValeurs);
        $n=0;
        for($i=1;$i<=8;$i++)
        {
            if($i==1)
            {
                CodeEdiValeurCelluleLigne('14088', 'I. Changements affectant les méthodes d\'évaluation', $i);
                CodeEdiValeurCelluleLigne('14089', (${'EtatChangment' . $n++}), $i);
                CodeEdiValeurCelluleLigne('14090', (${'EtatChangment' . $n++}), $i);
            }
            else{
                CodeEdiValeurCelluleLigne('14088', (${'EtatChangment' . $n++}), $i);
                CodeEdiValeurCelluleLigne('14089', (${'EtatChangment' . $n++}), $i);
                CodeEdiValeurCelluleLigne('14090', (${'EtatChangment' . $n++}), $i);
            }
        }
        for($i=9;$i<=16;$i++)
        {
            if($i==9)
            {
                CodeEdiValeurCelluleLigne('14091', 'II. Changements affectant les régles de présentation', $i);
                CodeEdiValeurCelluleLigne('14092', (${'EtatChangment' . $n++}), $i);
                CodeEdiValeurCelluleLigne('14093', (${'EtatChangment' . $n++}), $i);
            }else{
                CodeEdiValeurCelluleLigne('14091', (${'EtatChangment' . $n++}), $i);
                CodeEdiValeurCelluleLigne('14092', (${'EtatChangment' . $n++}), $i);
                CodeEdiValeurCelluleLigne('14093', (${'EtatChangment' . $n++}), $i);
            }
        }

       


        $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
        $ValeursTableau->appendChild($extraFieldvaleurs);



    }
    // } else {
    //     echo "Error: The file $filename does not exist.";
    // }
?>