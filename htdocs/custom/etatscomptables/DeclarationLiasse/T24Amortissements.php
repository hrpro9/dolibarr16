<?php
 $filename =  DOL_DOCUMENT_ROOT . '/custom/etatscomptables/Amortissemen/Amortisement_fichier_'.$annee_du.'.php';
  if (file_exists($filename)) {
    include $filename;
  
  $ValeursTableau = $dom->createElement('ValeursTableau');
  $groupeValeursTableau->appendChild($ValeursTableau);
  $tableau = $dom->createElement('tableau');
  $ValeursTableau->appendChild($tableau);
  $id = $dom->createElement('id','24');
  $tableau->appendChild($id);
  $groupeValeurs = $dom->createElement('groupeValeurs');
  $ValeursTableau->appendChild($groupeValeurs);
  CodeEdiValeurCellule('1231',$IENV_CDEx);
  CodeEdiValeurCellule('1232',$IENV_DDLEx);
  CodeEdiValeurCellule('1233',$IENV_ASISo);
  CodeEdiValeurCellule('1234',$II_CDFEx);
  CodeEdiValeurCellule('1236',$FP_CDEx);
  CodeEdiValeurCellule('1237',$FP_DDLEx);
  CodeEdiValeurCellule('1238',$amortismon1);
  CodeEdiValeurCellule('1239',$FP_CDFEx);
  CodeEdiValeurCellule('1241',$CARSPE_DDLEx);
  CodeEdiValeurCellule('1242',$CARSPE_ASISo);
  CodeEdiValeurCellule('1243',$amortismon2);
  CodeEdiValeurCellule('1244',$CARSPE_CDFEx);
  CodeEdiValeurCellule('1246',$PDRO_DDLEx);
  CodeEdiValeurCellule('1247',$PDRO_ASISo);
  CodeEdiValeurCellule('1248',$amortismon3);
  CodeEdiValeurCellule('1249',$PDRO_CDFEx);
  CodeEdiValeurCellule('1624',$II_CDEx);
  CodeEdiValeurCellule('1629',$II_DDLEx);
  CodeEdiValeurCellule('1650',$II_ASISo);
  CodeEdiValeurCellule('1679',$II_CDFEx);
  CodeEdiValeurCellule('1625',$IERED_CDEx);
  CodeEdiValeurCellule('1630',$IERED_DDLEx);
  CodeEdiValeurCellule('1651',$amortismon4);
  CodeEdiValeurCellule('1680',$IERED_CDFEx);
  CodeEdiValeurCellule('1626',$BMDEVS_CDEx);
  CodeEdiValeurCellule('1631',$BMDEVS_DDLEx);
  CodeEdiValeurCellule('1652',$amortismon5);
  CodeEdiValeurCellule('1681',$BMDEVS_CDFEx);
  CodeEdiValeurCellule('1627',$FC_CDEx);
  CodeEdiValeurCellule('1632',$FC_DDLEx);
  CodeEdiValeurCellule('1653',$amortismon6);
  CodeEdiValeurCellule('1682',$FC_CDFEx);
  CodeEdiValeurCellule('1628',$AII_CDEx);
  CodeEdiValeurCellule('1633',$AII_DDLEx);
  CodeEdiValeurCellule('1654',$amortismon7);
  CodeEdiValeurCellule('1683',$AII_CDFEx);
  CodeEdiValeurCellule('1700',$IC_CDEx);
  CodeEdiValeurCellule('1708',$IC_DDLEx);
  CodeEdiValeurCellule('1716',$IC_ASISo);
  CodeEdiValeurCellule('1724',$IC_CDFEx);
  CodeEdiValeurCellule('1701',$TER_CDEx);
  CodeEdiValeurCellule('1709',$TER_DDLEx);
  CodeEdiValeurCellule('1717',$amortismon8);
  CodeEdiValeurCellule('1725',$TER_CDFEx);
  CodeEdiValeurCellule('1702',$CONS_CDEx);
  CodeEdiValeurCellule('1710',$CONS_DDLEx);
  CodeEdiValeurCellule('1718',$amortismon9);
  CodeEdiValeurCellule('1726',$CONS_CDFEx);
  CodeEdiValeurCellule('1703',$ITMEO_CDEx);
  CodeEdiValeurCellule('1711',$ITMEO_CDEx);
  CodeEdiValeurCellule('1719',$amortismon10);
  CodeEdiValeurCellule('1727',$ITMEO_CDFEx);
  CodeEdiValeurCellule('1704',$MDT_CDEx);
  CodeEdiValeurCellule('1712',$MDT_DDLEx);
  CodeEdiValeurCellule('1720',$amortismon11);
  CodeEdiValeurCellule('1728',$MDT_CDFEx);
  CodeEdiValeurCellule('1705',$MMDBEA_CDEx);
  CodeEdiValeurCellule('1713',$MMDBEA_DDLEx);
  CodeEdiValeurCellule('1721',$amortismon12);
  CodeEdiValeurCellule('1729',$MMDBEA_CDFEx);
  CodeEdiValeurCellule('1706',$AIC_CDEx);
  CodeEdiValeurCellule('1714',$AIC_DDLEx);
  CodeEdiValeurCellule('1722',$amortismon13);
  CodeEdiValeurCellule('1730',$AIC_CDFEx);
  CodeEdiValeurCellule('1707',$ICEC_CDEx);
  CodeEdiValeurCellule('1715',$ICEC_DDLEx);
  CodeEdiValeurCellule('1723',$amortismon14);
  CodeEdiValeurCellule('1731',$ICEC_CDFEx);
  CodeEdiValeurCellule('14061',$TOTAl_CDEx);
  CodeEdiValeurCellule('14062',$TOTAl_DDLEx);
  CodeEdiValeurCellule('14063',$TOTAl_ASISo);
  CodeEdiValeurCellule('14064',$TOTAl_CDFEx);

  

  $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
  $ValeursTableau->appendChild($extraFieldvaleurs);

  


  }
?>
  