<?php

  $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/ImmobilisationsFinancieres/ImmobilisationsFinancieres_fichier_' . $annee_du . '.php';


if (file_exists($filename)) {
    include $filename;
    
    $ValeursTableau = $dom->createElement('ValeursTableau');
    $groupeValeursTableau->appendChild($ValeursTableau);
    $tableau = $dom->createElement('tableau');
    $ValeursTableau->appendChild($tableau);
    $id = $dom->createElement('id','11');
    $tableau->appendChild($id);
    $groupeValeurs = $dom->createElement('groupeValeurs');
    $ValeursTableau->appendChild($groupeValeurs);
    CodeEdiValeurCellule('10064',$IENV_MBDE);
    CodeEdiValeurCellule('10065',$IENV_AA);
    CodeEdiValeurCellule('10066',$IENV_APPLPEM);
    CodeEdiValeurCellule('10067',$IENV_AV);
    CodeEdiValeurCellule('10068',$IENV_DC);
    CodeEdiValeurCellule('10069',$IENV_DR);
    CodeEdiValeurCellule('10070',$IENV_DV);
    CodeEdiValeurCellule('10071',$IENV_MBFE);
    CodeEdiValeurCellule('966',$FP_MBDE);
    CodeEdiValeurCellule('980',$FP_AA);
    CodeEdiValeurCellule('994',$immobilisationFinancieres1);
    CodeEdiValeurCellule('1008',$immobilisationFinancieres2);
    CodeEdiValeurCellule('1022',$immobilisationFinancieres3);
    CodeEdiValeurCellule('1036',$immobilisationFinancieres4);
    CodeEdiValeurCellule('1050',$immobilisationFinancieres5);
    CodeEdiValeurCellule('1064',$FP_MBFE);
    CodeEdiValeurCellule('967',$CARSPE_MBDE);
    CodeEdiValeurCellule('981',$CARSPE_AA);
    CodeEdiValeurCellule('995',$immobilisationFinancieres6);
    CodeEdiValeurCellule('1009',$immobilisationFinancieres7);
    CodeEdiValeurCellule('1023',$immobilisationFinancieres8);
    CodeEdiValeurCellule('1037',$immobilisationFinancieres9);
    CodeEdiValeurCellule('1051',$immobilisationFinancieres10);
    CodeEdiValeurCellule('1065',$CARSPE_MBFE);
    CodeEdiValeurCellule('968',$PDRO_MBDE);
    CodeEdiValeurCellule('982',$PDRO_AA);
    CodeEdiValeurCellule('996',$immobilisationFinancieres11);
    CodeEdiValeurCellule('1010',$immobilisationFinancieres12);
    CodeEdiValeurCellule('1024',$immobilisationFinancieres13);
    CodeEdiValeurCellule('1038',$immobilisationFinancieres14);
    CodeEdiValeurCellule('1052',$immobilisationFinancieres15);
    CodeEdiValeurCellule('1066',$PDRO_MBFE);
    CodeEdiValeurCellule('10073',$II_MBDE);
    CodeEdiValeurCellule('10074',$II_AA);
    CodeEdiValeurCellule('10075',$II_APPLPEM);
    CodeEdiValeurCellule('10076',$II_AV);
    CodeEdiValeurCellule('10077',$II_DC);
    CodeEdiValeurCellule('10078',$II_DR);
    CodeEdiValeurCellule('10079',$II_DV);
    CodeEdiValeurCellule('10078',$PDRO_MBFE);
    CodeEdiValeurCellule('969',$IERED_MBDE);
    CodeEdiValeurCellule('983',$IERED_AA);
    CodeEdiValeurCellule('997',$immobilisationFinancieres16);
    CodeEdiValeurCellule('1011',$immobilisationFinancieres17);
    CodeEdiValeurCellule('1025',$immobilisationFinancieres18);
    CodeEdiValeurCellule('1039',$immobilisationFinancieres19);
    CodeEdiValeurCellule('1053',$immobilisationFinancieres20);
    CodeEdiValeurCellule('1067',$IERED_MBFE);
    CodeEdiValeurCellule('970',$BMDEVS_MBDE);
    CodeEdiValeurCellule('984',$BMDEVS_AA);
    CodeEdiValeurCellule('998',$immobilisationFinancieres21);
    CodeEdiValeurCellule('1012',$immobilisationFinancieres22);
    CodeEdiValeurCellule('1026',$immobilisationFinancieres23);
    CodeEdiValeurCellule('1040',$immobilisationFinancieres24);
    CodeEdiValeurCellule('1054',$immobilisationFinancieres25);
    CodeEdiValeurCellule('1068',$BMDEVS_MBFE);
    CodeEdiValeurCellule('971',$FC_MBDE);
    CodeEdiValeurCellule('985',$FC_AA);
    CodeEdiValeurCellule('999',$immobilisationFinancieres26);
    CodeEdiValeurCellule('1013',$immobilisationFinancieres27);
    CodeEdiValeurCellule('1027',$immobilisationFinancieres28);
    CodeEdiValeurCellule('1041',$immobilisationFinancieres29);
    CodeEdiValeurCellule('1055',$immobilisationFinancieres30);
    CodeEdiValeurCellule('1069',$FC_MBFE);
    CodeEdiValeurCellule('972',$AII_MBDE);
    CodeEdiValeurCellule('986',$AII_AA);
    CodeEdiValeurCellule('1000',$immobilisationFinancieres31);
    CodeEdiValeurCellule('1014',$immobilisationFinancieres32);
    CodeEdiValeurCellule('1028',$immobilisationFinancieres33);
    CodeEdiValeurCellule('1042',$immobilisationFinancieres34);
    CodeEdiValeurCellule('1056',$immobilisationFinancieres35);
    CodeEdiValeurCellule('1070',$AII_MBFE);
    CodeEdiValeurCellule('10082',$IC_MBDE);
    CodeEdiValeurCellule('10083',$IC_AA);
    CodeEdiValeurCellule('10084',$IC_APPLPEM);
    CodeEdiValeurCellule('10085',$IC_AV);
    CodeEdiValeurCellule('10086',$IC_DC);
    CodeEdiValeurCellule('10087',$IC_DR);
    CodeEdiValeurCellule('10088',$IC_DV);
    CodeEdiValeurCellule('10089',$IC_MBFE);
    CodeEdiValeurCellule('973',$T_MBDE);
    CodeEdiValeurCellule('987',$T_AA);
    CodeEdiValeurCellule('1001',$immobilisationFinancieres36);
    CodeEdiValeurCellule('1015',$immobilisationFinancieres37);
    CodeEdiValeurCellule('1029',$immobilisationFinancieres38);
    CodeEdiValeurCellule('1043',$immobilisationFinancieres39);
    CodeEdiValeurCellule('1057',$immobilisationFinancieres40);
    CodeEdiValeurCellule('1071',$T_MBFE);
    CodeEdiValeurCellule('974',$C_MBDE);
    CodeEdiValeurCellule('988',$C_AA);
    CodeEdiValeurCellule('1002',$immobilisationFinancieres41);
    CodeEdiValeurCellule('1016',$immobilisationFinancieres40);
    CodeEdiValeurCellule('1030',$immobilisationFinancieres43);
    CodeEdiValeurCellule('1044',$immobilisationFinancieres44);
    CodeEdiValeurCellule('1058',$immobilisationFinancieres45);
    CodeEdiValeurCellule('1072',$C_MBFE);
    CodeEdiValeurCellule('975',$ITMEO_MBDE);
    CodeEdiValeurCellule('989',$ITMEO_AA);
    CodeEdiValeurCellule('1003',$immobilisationFinancieres46);
    CodeEdiValeurCellule('1017',$immobilisationFinancieres47);
    CodeEdiValeurCellule('1031',$immobilisationFinancieres48);
    CodeEdiValeurCellule('1045',$immobilisationFinancieres49);
    CodeEdiValeurCellule('1059',$immobilisationFinancieres50);
    CodeEdiValeurCellule('1073',$ITMEO_MBFE);
    CodeEdiValeurCellule('976',$MDT_MBDE);
    CodeEdiValeurCellule('990',$MDT_AA);
    CodeEdiValeurCellule('1004',$immobilisationFinancieres51);
    CodeEdiValeurCellule('1018',$immobilisationFinancieres52);
    CodeEdiValeurCellule('1032',$immobilisationFinancieres53);
    CodeEdiValeurCellule('1046',$immobilisationFinancieres54);
    CodeEdiValeurCellule('1060',$immobilisationFinancieres55);
    CodeEdiValeurCellule('1074',$MDT_MBFE);
    CodeEdiValeurCellule('978',$MMDBEA_MBDE);
    CodeEdiValeurCellule('991',$MMDBEA_AA);
    CodeEdiValeurCellule('1006',$immobilisationFinancieres56);
    CodeEdiValeurCellule('1020',$immobilisationFinancieres57);
    CodeEdiValeurCellule('1034',$immobilisationFinancieres58);
    CodeEdiValeurCellule('1048',$immobilisationFinancieres59);
    CodeEdiValeurCellule('1062',$immobilisationFinancieres60);
    CodeEdiValeurCellule('1076',$MMDBEA_MBFE);
    CodeEdiValeurCellule('979',$AIC_MBDE);
    CodeEdiValeurCellule('992',$AIC_AA);
    CodeEdiValeurCellule('1007',$immobilisationFinancieres61);
    CodeEdiValeurCellule('1021',$immobilisationFinancieres62);
    CodeEdiValeurCellule('1035',$immobilisationFinancieres63);
    CodeEdiValeurCellule('1049',$immobilisationFinancieres64);
    CodeEdiValeurCellule('1063',$immobilisationFinancieres65);
    CodeEdiValeurCellule('1077',$AIC_MBFE);
    CodeEdiValeurCellule('977',$ICEC_MBDE);
    CodeEdiValeurCellule('991',$ICEC_AA);
    CodeEdiValeurCellule('1005',$immobilisationFinancieres66);
    CodeEdiValeurCellule('1019',$immobilisationFinancieres67);
    CodeEdiValeurCellule('1033',$immobilisationFinancieres68);
    CodeEdiValeurCellule('1047',$immobilisationFinancieres69);
    CodeEdiValeurCellule('1061',$immobilisationFinancieres70);
    CodeEdiValeurCellule('1075',$ICEC_MBFE);
    CodeEdiValeurCellule('12597',$MI_MBDE);
    CodeEdiValeurCellule('12598',$MI_AA);
    CodeEdiValeurCellule('12599',$immobilisationFinancieres71);
    CodeEdiValeurCellule('12600',$immobilisationFinancieres72);
    CodeEdiValeurCellule('12601',$immobilisationFinancieres73);
    CodeEdiValeurCellule('12602',$immobilisationFinancieres74);
    CodeEdiValeurCellule('12603',$immobilisationFinancieres75);
    CodeEdiValeurCellule('12604',$MI_MBFE);
    CodeEdiValeurCellule('14045',$T_MBDE);
    CodeEdiValeurCellule('14046',$T_AA);
    CodeEdiValeurCellule('14047',$T_APPLPEM);
    CodeEdiValeurCellule('14048',$T_AV);
    CodeEdiValeurCellule('14049',$T_DC);
    CodeEdiValeurCellule('14050',$T_DR);
    CodeEdiValeurCellule('14051',$T_DV);
    CodeEdiValeurCellule('14052',$T_MBFE);




   


    $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
    $ValeursTableau->appendChild($extraFieldvaleurs);
  
}
// } else {
//     echo "Error: The file $filename does not exist.";
// }


// CodeEdiValeurCelluleLigne('821', '1. Courantes',1);
?>