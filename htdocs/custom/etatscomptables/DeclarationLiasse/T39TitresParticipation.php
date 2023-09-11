<?php
    $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/TitresParticipation/TitresParticipation_fichier_' . $annee_du . '.php';
    if (file_exists($filename)) {
        include $filename;
        
        $ValeursTableau = $dom->createElement('ValeursTableau');
        $groupeValeursTableau->appendChild($ValeursTableau);
        $tableau = $dom->createElement('tableau');
        $ValeursTableau->appendChild($tableau);
        $id = $dom->createElement('id','39');
        $tableau->appendChild($id);
        $groupeValeurs = $dom->createElement('groupeValeurs');
        $ValeursTableau->appendChild($groupeValeurs);
        $n=0;
        $y=1;
        for($i=1;$i<=14;$i++)
        {
            $x=2044;
            for($j=1;$j<=11;$j++)
            {
                if($j==2){
                    $valeur=${'Participation' . $n} ;
                    CodeEdiValeurCelluleLigne('14065',$valeur,$y);
                }else{
                    $valeur=${'Participation' . $n} ;
                    CodeEdiValeurCelluleLigne($x,$valeur,$y);
                    $x++;
                }
            
                $n++;
            }
            $y++;
        }

        CodeEdiValeurCellule('2056',$sum1);
        CodeEdiValeurCellule('2057',$sum1);
        CodeEdiValeurCellule('2058',$sum2);
        CodeEdiValeurCellule('2059',$sum3);
        CodeEdiValeurCellule('2060',$sum1);
        CodeEdiValeurCellule('2061',$sum4);
        CodeEdiValeurCellule('2062',$sum5);
        CodeEdiValeurCellule('2063',$sum6);


        $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
        $ValeursTableau->appendChild($extraFieldvaleurs);



    }
    // } else {
    //     echo "Error: The file $filename does not exist.";
    // }
?>
  


