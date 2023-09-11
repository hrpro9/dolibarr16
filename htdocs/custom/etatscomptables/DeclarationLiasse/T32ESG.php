<?php
 $filename =  DOL_DOCUMENT_ROOT . '/custom/etatscomptables/ESG/ESG_fichier_'.$annee_du.'.php';
  if (file_exists($filename)) {
    include $filename;
 
  $ValeursTableau = $dom->createElement('ValeursTableau');
  $groupeValeursTableau->appendChild($ValeursTableau);
  $tableau = $dom->createElement('tableau');
  $ValeursTableau->appendChild($tableau);
  $id = $dom->createElement('id','32');
  $tableau->appendChild($id);
  $groupeValeurs = $dom->createElement('groupeValeurs');
  $ValeursTableau->appendChild($groupeValeurs); 
  CodeEdiValeurCellule('1308',$venteMarch_E);
  CodeEdiValeurCellule('1333',$venteMarch_EP);
  CodeEdiValeurCellule('1309',$achatReMarch_E);
  CodeEdiValeurCellule('1334',$achatReMarch_EP);
  CodeEdiValeurCellule('1310',$marchB_E);
  CodeEdiValeurCellule('1335',$marchB_EP);
  CodeEdiValeurCellule('1311',$prodExe_E);
  CodeEdiValeurCellule('1336',$prodExe_EP);
  CodeEdiValeurCellule('1312',$venteServ_E);
  CodeEdiValeurCellule('1337',$venteServ_EP);
  CodeEdiValeurCellule('1313',$varStock_E);
  CodeEdiValeurCellule('1338',$varStock_EP);
  CodeEdiValeurCellule('1314',$immobiProd_E);
  CodeEdiValeurCellule('1339',$immobiProd_EP);
  CodeEdiValeurCellule('1315',$ConsExe_E);
  CodeEdiValeurCellule('1340',$ConsExe_EP);
  CodeEdiValeurCellule('1316',$achatCons_E);
  CodeEdiValeurCellule('1341',$achatCons_EP);
  CodeEdiValeurCellule('1317',$autreCharge_E);
  CodeEdiValeurCellule('1342',$autreCharge_EP);
  CodeEdiValeurCellule('1318',$valAjout_E);
  CodeEdiValeurCellule('1343',$valAjout_EP);
  CodeEdiValeurCellule('1319',$subExp_E);
  CodeEdiValeurCellule('1344',$subExp_EP);
  CodeEdiValeurCellule('1320',$impotTaxe_E);
  CodeEdiValeurCellule('1345',$impotTaxe_EP);
  CodeEdiValeurCellule('1321',$chargePers_E);
  CodeEdiValeurCellule('1346',$chargePers_EP);
  CodeEdiValeurCellule('4063',$ExcedentB_E);
  CodeEdiValeurCellule('4064',$ExcedentB_EP);
  CodeEdiValeurCellule('4066',$autresProd_E);
  CodeEdiValeurCellule('4067',$autresProd_EP);
  CodeEdiValeurCellule('1324',$autresCharg_E);
  CodeEdiValeurCellule('1349',$autresCharg_EP);
  CodeEdiValeurCellule('1325',$reprisesExpl_E);
  CodeEdiValeurCellule('1350',$reprisesExpl_EP);
  CodeEdiValeurCellule('1326',$dotationExpl_E);
  CodeEdiValeurCellule('1351',$dotationExpl_EP);
  CodeEdiValeurCellule('1327',$resultatExpl_E);
  CodeEdiValeurCellule('1352',$resultatExpl_EP);
  CodeEdiValeurCellule('1327',$resultatExpl_E);
  CodeEdiValeurCellule('1352',$resultatExpl_EP);
  CodeEdiValeurCellule('1328',$resultatFin_E);
  CodeEdiValeurCellule('1353',$resultatFin_EP);
  CodeEdiValeurCellule('1329',$resultatCrt_E);
  CodeEdiValeurCellule('1354',$resultatCrt_EP);
  CodeEdiValeurCellule('1330',$resultatNonCrt_E);
  CodeEdiValeurCellule('1355',$resultatNonCrt_EP);
  CodeEdiValeurCellule('1331',$impotRest_E);
  CodeEdiValeurCellule('1356',$impotRest_EP);
  CodeEdiValeurCellule('1332',$resultatNetExe_E);
  CodeEdiValeurCellule('1357',$resultatNetExe_EP);
  CodeEdiValeurCellule('1372',$resultatNetExe_E);
  CodeEdiValeurCellule('1386',$resultatNetExe_EP);
  CodeEdiValeurCellule('1373',$benefice_E);
  CodeEdiValeurCellule('1387',$benefice_EP);
  CodeEdiValeurCellule('1374',$perte_E);
  CodeEdiValeurCellule('1388',$perte_EP);
  CodeEdiValeurCellule('1375',$datatExpl_E);
  CodeEdiValeurCellule('1389',$datatExpl_EP);
  CodeEdiValeurCellule('1376',$dotationfin_E);
  CodeEdiValeurCellule('1390',$dotationfin_EP);
  CodeEdiValeurCellule('1377',$dotationNonCour_E);
  CodeEdiValeurCellule('1391',$dotationNonCour_EP);
  CodeEdiValeurCellule('1378',$reprExpl_E);
  CodeEdiValeurCellule('1392',$reprExpl_EP);
  CodeEdiValeurCellule('1379',$repriseFin_E);
  CodeEdiValeurCellule('1393',$repriseFin_EP);
  CodeEdiValeurCellule('1380',$repNonCour_E);
  CodeEdiValeurCellule('1394',$repNonCour_EP);
  CodeEdiValeurCellule('1381',$prodImmb_E);
  CodeEdiValeurCellule('1395',$prodImmb_EP);
  CodeEdiValeurCellule('1382',$valNetImmb_E);
  CodeEdiValeurCellule('1396',$valNetImmb_EP);
  CodeEdiValeurCellule('1383',$CAF_E);
  CodeEdiValeurCellule('1397',$CAF_EP);
  CodeEdiValeurCellule('1384','0');
  CodeEdiValeurCellule('1398','0');
  CodeEdiValeurCellule('1383',$autofin_E);
  CodeEdiValeurCellule('1397',$autofin_EP);



  $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
  $ValeursTableau->appendChild($extraFieldvaleurs);

  }
?>
  