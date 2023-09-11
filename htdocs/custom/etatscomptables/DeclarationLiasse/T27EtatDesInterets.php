<?php
   $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/EtatDesInterets/etatDesInterets_fichier_' . $annee_du . '.php';

    if (file_exists($filename)) {
        include $filename;
        
        $ValeursTableau = $dom->createElement('ValeursTableau');
        $groupeValeursTableau->appendChild($ValeursTableau);
        $tableau = $dom->createElement('tableau');
        $ValeursTableau->appendChild($tableau);
        $id = $dom->createElement('id','27');
        $tableau->appendChild($id);
        $groupeValeurs = $dom->createElement('groupeValeurs');
            $ValeursTableau->appendChild($groupeValeurs);

        $n=0;
        for($i=1;$i<=6;$i++)
        {
           

            CodeEdiValeurCelluleLigne('1208', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('14969', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1209', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1210', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('14968', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1211', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1212', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1213', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1214', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1215',(${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1216',(${'etatDesInterets' . $n++}), $i);       
            CodeEdiValeurCelluleLigne('1217',(${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1218',(${'etatDesInterets' . $n++}), $i);
            if($n==13){
                $n++;
            }
            CodeEdiValeurCelluleLigne('1219',(${'etatDesInterets' .$n++}), $i);
            CodeEdiValeurCelluleLigne('1220',(${'etatDesInterets' . $n++}), $i);
        }


        for($i=7;$i<=12;$i++)
        {
            CodeEdiValeurCelluleLigne('1221', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('14970', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1222', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1223', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('14971', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1214', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1225', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1226', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1227', (${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1228',(${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1229',(${'etatDesInterets' . $n++}), $i);       
            CodeEdiValeurCelluleLigne('1250',(${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1251',(${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1252',(${'etatDesInterets' . $n++}), $i);
            CodeEdiValeurCelluleLigne('1253',(${'etatDesInterets' . $n++}), $i);
        }

        CodeEdiValeurCellule('1497',' ');
        CodeEdiValeurCellule('1255',' ');
        CodeEdiValeurCellule('1256',' ');
        CodeEdiValeurCellule('1497',' ');
        CodeEdiValeurCellule('1257',$sum6);
        CodeEdiValeurCellule('1258',' ');
        CodeEdiValeurCellule('1259',' ');
        CodeEdiValeurCellule('1260',' ');
        CodeEdiValeurCellule('1261',$sum1);
        CodeEdiValeurCellule('1262',$sum2);
        CodeEdiValeurCellule('1263',$sum3);
        CodeEdiValeurCellule('1264',$sum4);
         CodeEdiValeurCellule('1265',$sum5);
        CodeEdiValeurCellule('1266',' ');




        $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs');
        $ValeursTableau->appendChild($extraFieldvaleurs);
        CodeextraFieldvaleurs('55','55');
      



    

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
  


