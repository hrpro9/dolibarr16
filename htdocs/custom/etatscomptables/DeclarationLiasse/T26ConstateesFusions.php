<?php
 
  $filename =  DOL_DOCUMENT_ROOT . '/custom/etatscomptables/Fusion/Fusion_fichier_'.$annee_du.'.php';
  if (file_exists($filename)) {
    include $filename;
  
  $ValeursTableau = $dom->createElement('ValeursTableau');
  $groupeValeursTableau->appendChild($ValeursTableau);
  $tableau = $dom->createElement('tableau');
  $ValeursTableau->appendChild($tableau);
  $id = $dom->createElement('id','26');
  $tableau->appendChild($id);
  $groupeValeurs = $dom->createElement('groupeValeurs');
  $ValeursTableau->appendChild($groupeValeurs);
  CodeEdiValeurCellule('1110',$fusion0);
  CodeEdiValeurCellule('1111',$fusion1);
  CodeEdiValeurCellule('1112',$fusion2);
  CodeEdiValeurCellule('1113',$fusion3);
  CodeEdiValeurCellule('1114',$fusion4);
  CodeEdiValeurCellule('1115',$fusion5);
  CodeEdiValeurCellule('1116',$fusion6);
  CodeEdiValeurCellule('1117',$fusion7);
  CodeEdiValeurCellule('1119',$fusion9);
  CodeEdiValeurCellule('1120',$fusion10);
  CodeEdiValeurCellule('1121',$fusion11);
  CodeEdiValeurCellule('1122',$fusion12);
  CodeEdiValeurCellule('1123',$fusion13);
  CodeEdiValeurCellule('1124',$fusion14);
  CodeEdiValeurCellule('1125',$fusion15);
  CodeEdiValeurCellule('1126',$fusion16);
  CodeEdiValeurCellule('1128',$fusion17);
  CodeEdiValeurCellule('1129',$fusion18);
  CodeEdiValeurCellule('1130',$fusion19);
  CodeEdiValeurCellule('1131',$fusion20);
  CodeEdiValeurCellule('1132',$fusion21);
  CodeEdiValeurCellule('1133',$fusion22);
  CodeEdiValeurCellule('1134',$fusion23);
  CodeEdiValeurCellule('1135',$fusion24);
  CodeEdiValeurCellule('1137',$fusion25);
  CodeEdiValeurCellule('1138',$fusion26);
  CodeEdiValeurCellule('1139',$fusion27);
  CodeEdiValeurCellule('1140',$fusion28);
  CodeEdiValeurCellule('1141',$fusion29);
  CodeEdiValeurCellule('1142',$fusion30);
  CodeEdiValeurCellule('1143',$fusion31);
  CodeEdiValeurCellule('1144',$fusion32);
  CodeEdiValeurCellule('1146',$fusion33);
  CodeEdiValeurCellule('1147',$fusion34);
  CodeEdiValeurCellule('1148',$fusion35);
  CodeEdiValeurCellule('1149',$fusion36);
  CodeEdiValeurCellule('1150',$fusion37);
  CodeEdiValeurCellule('1151',$fusion38);
  CodeEdiValeurCellule('1152',$fusion39);
  CodeEdiValeurCellule('1153',$fusion40);
  CodeEdiValeurCellule('1155',$fusion41);
  CodeEdiValeurCellule('1156',$fusion42);
  CodeEdiValeurCellule('1157',$fusion43);
  CodeEdiValeurCellule('1158',$fusion44);
  CodeEdiValeurCellule('1159',$fusion45);
  CodeEdiValeurCellule('1160',$fusion46);
  CodeEdiValeurCellule('1161',$fusion47);
  CodeEdiValeurCellule('1162',$fusion48);
  CodeEdiValeurCellule('1164',$fusion49);
  CodeEdiValeurCellule('1165',$fusion50);
  CodeEdiValeurCellule('1166',$fusion51);
  CodeEdiValeurCellule('1167',$fusion52);
  CodeEdiValeurCellule('1168',$fusion53);
  CodeEdiValeurCellule('1169',$fusion54);
  CodeEdiValeurCellule('1170',$fusion55);
  CodeEdiValeurCellule('1171',$fusion56);
  CodeEdiValeurCellule('1173',$fusion57);
  CodeEdiValeurCellule('1174',$fusion58);
  CodeEdiValeurCellule('1175',$fusion59);
  CodeEdiValeurCellule('1176',$fusion60);
  CodeEdiValeurCellule('1177',$fusion61);
  CodeEdiValeurCellule('1178',$fusion62);
  CodeEdiValeurCellule('1179',$fusion63);
  CodeEdiValeurCellule('1180',$fusion64);
  CodeEdiValeurCellule('1182',$fusion65);
  CodeEdiValeurCellule('1183',$fusion66);
  CodeEdiValeurCellule('1184',$fusion67);
  CodeEdiValeurCellule('1185',$fusion68);
  CodeEdiValeurCellule('1186',$fusion69);
  CodeEdiValeurCellule('1187',$fusion70);
  CodeEdiValeurCellule('1188',$fusion71);
  CodeEdiValeurCellule('1189',$fusion72);
  CodeEdiValeurCellule('1191',$fusion73);
  CodeEdiValeurCellule('1192',$fusion74);
  CodeEdiValeurCellule('1193',$fusion75);
  CodeEdiValeurCellule('1194',$fusion76);
  CodeEdiValeurCellule('1195',$fusion77);
  CodeEdiValeurCellule('1196',$fusion78);
  CodeEdiValeurCellule('1197',$fusion79);
  CodeEdiValeurCellule('1198',$fusion80);
  CodeEdiValeurCellule('1200',$sum1);
  CodeEdiValeurCellule('1201',$sum2);
  CodeEdiValeurCellule('1202',$sum3);
  CodeEdiValeurCellule('1203',$sum4);
  CodeEdiValeurCellule('1204',$sum5);
  CodeEdiValeurCellule('1205',$sum6);
  CodeEdiValeurCellule('1206',$sum7);
  CodeEdiValeurCellule('1207','');


  $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs');
  $ValeursTableau->appendChild($extraFieldvaleurs);
  CodeextraFieldvaleurs('54','54');

  }

?>
  