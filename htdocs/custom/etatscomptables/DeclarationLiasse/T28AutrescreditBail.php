<?php
    $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/AutrescreditBail/autrecreditBail_fichier_' . $annee_du . '.php';

    
    if (file_exists($filename)) {
        include $filename;
        
        $ValeursTableau = $dom->createElement('ValeursTableau');
        $groupeValeursTableau->appendChild($ValeursTableau);
        $tableau = $dom->createElement('tableau');
        $ValeursTableau->appendChild($tableau);
        $id = $dom->createElement('id','28');
        $tableau->appendChild($id);
        $groupeValeurs = $dom->createElement('groupeValeurs');
            $ValeursTableau->appendChild($groupeValeurs);

        $n=0;
        for($i=1;$i<=19;$i++)
        {

            CodeEdiValeurCelluleLigne('1267', (${'autrecreditBail' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1268', (${'autrecreditBail' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1269', (${'autrecreditBail' . $n++}), $i);
            CodeEdiValeurCelluleLigne('14964', (${'autrecreditBail' . $n++}), $i);
            CodeEdiValeurCelluleLigne('14965', (${'autrecreditBail' . $n++}), $i);
            CodeEdiValeurCelluleLigne('14040', (${'autrecreditBail' . $n++}), $i);
            CodeEdiValeurCelluleLigne('14041', (${'autrecreditBail' . $n++}), $i);
            CodeEdiValeurCelluleLigne('17919', (${'autrecreditBail' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1270', (${'autrecreditBail' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1271',(${'autrecreditBail' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1272',(${'autrecreditBail' . $n++}), $i);       
            CodeEdiValeurCelluleLigne('1273',(${'autrecreditBail' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1274',(${'autrecreditBail' . $n++}), $i);
        }

        CodeEdiValeurCellule('1276',' ');
        CodeEdiValeurCellule('1277',' ');
        CodeEdiValeurCellule('14966',' ');
        CodeEdiValeurCellule('14967',' ');
        CodeEdiValeurCellule('14042',' ');
        CodeEdiValeurCellule('14043',' ');
        CodeEdiValeurCellule('17920',' ');
        CodeEdiValeurCellule('1278',' ');
        CodeEdiValeurCellule('1279',$sum1);
        CodeEdiValeurCellule('1280',$sum2);
        CodeEdiValeurCellule('1281',' ');
        CodeEdiValeurCellule('1282',' ');




        $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
        $ValeursTableau->appendChild($extraFieldvaleurs);
        
      



    

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
  


