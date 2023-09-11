<?php
    $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/CapitalSocial/CapitalSocial_fichier_' . $annee_du . '.php';
    if (file_exists($filename)) {
        include $filename;
        
        $ValeursTableau = $dom->createElement('ValeursTableau');
        $groupeValeursTableau->appendChild($ValeursTableau);
        $tableau = $dom->createElement('tableau');
        $ValeursTableau->appendChild($tableau);
        $id = $dom->createElement('id','41');
        $tableau->appendChild($id);

        $n=0;
        for($i=1;$i<=16;$i++)
        {
            $groupeValeurs = $dom->createElement('groupeValeurs');
            $ValeursTableau->appendChild($groupeValeurs);
            $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs');
            $ValeursTableau->appendChild($extraFieldvaleurs);

            CodeEdiValeurCelluleLigne('2094', (${'CapitalSocia' . $n++}), $i);
            CodeEdiValeurCelluleLigne('17887', (${'CapitalSocia' . $n++}), $i);
            CodeEdiValeurCelluleLigne('13536', (${'CapitalSocia' . $n++}), $i);
            CodeEdiValeurCelluleLigne('13537', (${'CapitalSocia' . $n++}), $i);
            CodeEdiValeurCelluleLigne('14560', (${'CapitalSocia' . $n++}), $i);
            CodeEdiValeurCelluleLigne('2095', (${'CapitalSocia' . $n++}), $i);
            CodeEdiValeurCelluleLigne('2096', (${'CapitalSocia' . $n++}), $i);
            CodeEdiValeurCelluleLigne('2097', (${'CapitalSocia' . $n++}), $i);
            CodeEdiValeurCelluleLigne('2098', (${'CapitalSocia' . $n++}), $i);
            CodeextraFieldvaleurs('2099',(${'CapitalSocia' . $n++}));
            CodeextraFieldvaleurs('2100',(${'CapitalSocia' . $n++}));        
            CodeextraFieldvaleurs('2101',(${'CapitalSocia' . $n++}));
        }


        $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs');
        $ValeursTableau->appendChild($extraFieldvaleurs);
        CodeextraFieldvaleurs('18','18');
      



    

    }
    // } else {
    //     echo "Error: The file $filename does not exist.";
    // }



    // $n=0;
    // $y=1;
    // for($i=1;$i<=16;$i++)
    // {
    //     $x=2094;
    //     for($j=1;$j<=9;$j++)
    //     {
    //         $valeur=${'CapitalSocia' . $n} ;

    //         switch ($j) { 
    //             case 2:
    //                 CodeEdiValeurCelluleLigne('17887', $valeur, $y);
    //                 break;
    //             case 3:
    //                 CodeEdiValeurCelluleLigne('13536', $valeur, $y);
    //                 break;
    //             case 4:
    //                 CodeEdiValeurCelluleLigne('13537', $valeur, $y);
    //                 break;
    //             case 5:
    //                 CodeEdiValeurCelluleLigne('14560', $valeur, $y);
    //                 break;
    //             default:
    //                 CodeEdiValeurCelluleLigne($x, $valeur, $y);
    //                 $x++;
    //         }
    //         $n++;
    //     }
    //     $y++;
    // }
?>
  


