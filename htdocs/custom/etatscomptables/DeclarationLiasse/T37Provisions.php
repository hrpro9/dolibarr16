<?php
 $filename =   DOL_DOCUMENT_ROOT . '/custom/etatscomptables/Provision/Provision_fichier_'.$annee_du.'.php';
  if (file_exists($filename)) {
    include $filename;
  
  $ValeursTableau = $dom->createElement('ValeursTableau');
  $groupeValeursTableau->appendChild($ValeursTableau);
  $tableau = $dom->createElement('tableau');
  $ValeursTableau->appendChild($tableau);
  $id = $dom->createElement('id','37');
  $tableau->appendChild($id);
  $groupeValeurs = $dom->createElement('groupeValeurs');
  $ValeursTableau->appendChild($groupeValeurs);
  CodeEdiValeurCellule('1748',$PPDDLI_MDE);
  CodeEdiValeurCellule('1749',$PPDDLI_DED);
  CodeEdiValeurCellule('1750',$PPDDLI_FD);
  CodeEdiValeurCellule('1751',$PPDDLI_NCD);
  CodeEdiValeurCellule('1752',$PPDDLI_DER);
  CodeEdiValeurCellule('1753',$PPDDLI_FR);
  CodeEdiValeurCellule('1754',$PPDDLI_NCR);
  CodeEdiValeurCellule('1755',$PPDDLI_MFX);
  CodeEdiValeurCellule('1784',$PR_MDE);
  CodeEdiValeurCellule('1785','0');
  CodeEdiValeurCellule('1786','0');
  CodeEdiValeurCellule('1787',$PR_NCD);
  CodeEdiValeurCellule('1788','0');
  CodeEdiValeurCellule('1789','0');
  CodeEdiValeurCellule('1790',$PR_NCR);
  CodeEdiValeurCellule('1791',$PR_MFX);
  CodeEdiValeurCellule('1827',$PDPREC_MDE);
  CodeEdiValeurCellule('1828',$PDPREC_DED);
  CodeEdiValeurCellule('1829',$PDPREC_FD);
  CodeEdiValeurCellule('1830',$PDPREC_NCD);
  CodeEdiValeurCellule('1831',$PDPREC_DER);
  CodeEdiValeurCellule('1832',$PDPREC_FR);
  CodeEdiValeurCellule('1833',$PDPREC_NCR);
  CodeEdiValeurCellule('1834',$PDPREC_MFX);
  CodeEdiValeurCellule('1844',$ST_MDE);
  CodeEdiValeurCellule('1845',$ST_DED);
  CodeEdiValeurCellule('1846',$ST_FD);
  CodeEdiValeurCellule('1847',$ST_NCD);
  CodeEdiValeurCellule('1848',$ST_DER);
  CodeEdiValeurCellule('1849',$ST_FR);
  CodeEdiValeurCellule('1850',$ST_NCR);
  CodeEdiValeurCellule('1851',$ST_MFX);
  CodeEdiValeurCellule('1877',$PPDDLC_MDE);
  CodeEdiValeurCellule('1878',$PPDDLC_DED);
  CodeEdiValeurCellule('1879',$PPDDLC_FD);
  CodeEdiValeurCellule('1880',$PPDDLC_NCD);
  CodeEdiValeurCellule('1881',$PPDDLC_DER);
  CodeEdiValeurCellule('1882',$PPDDLC_FR);
  CodeEdiValeurCellule('1883',$PPDDLC_NCR);
  CodeEdiValeurCellule('1884',$PPDDLC_MFX);
  CodeEdiValeurCellule('1894',$APPREC_MDE);
  CodeEdiValeurCellule('1895',$APPREC_DED);
  CodeEdiValeurCellule('1896',$APPREC_FD);
  CodeEdiValeurCellule('1897',$APPREC_NCD);
  CodeEdiValeurCellule('1898',$APPREC_DER);
  CodeEdiValeurCellule('1899',$APPREC_FR);
  CodeEdiValeurCellule('1900',$TEVDP_MFX);
  CodeEdiValeurCellule('1901',$APPREC_MFX);
  CodeEdiValeurCellule('1903',$PPDDCDT_MDE);
  CodeEdiValeurCellule('1904','0');
  CodeEdiValeurCellule('1905',$PPDDCDT_FD);
  CodeEdiValeurCellule('1906','0');
  CodeEdiValeurCellule('1907','0');
  CodeEdiValeurCellule('1908',$PPDDCDT_FR);
  CodeEdiValeurCellule('1909','0');
  CodeEdiValeurCellule('1910',$PPDDCDT_MFX);
  CodeEdiValeurCellule('1912',$STB_MDE);
  CodeEdiValeurCellule('1913',$STB_DED);
  CodeEdiValeurCellule('1914',$STB_FD);
  CodeEdiValeurCellule('1915',$STB_NCD);
  CodeEdiValeurCellule('1916',$STB_DER);
  CodeEdiValeurCellule('1917',$STB_FR);
  CodeEdiValeurCellule('1918',$STB_NCR);
  CodeEdiValeurCellule('1919',$STB_MFX);
  CodeEdiValeurCellule('1921',$TAB_MDE);
  CodeEdiValeurCellule('1922',$TAB_DED);
  CodeEdiValeurCellule('1923',$TAB_FD);
  CodeEdiValeurCellule('1924',$TAB_NCD);
  CodeEdiValeurCellule('1925',$TAB_DER);
  CodeEdiValeurCellule('1926',$TAB_FR);
  CodeEdiValeurCellule('1927',$TAB_NCR);
  CodeEdiValeurCellule('1928',$TAB_MFX);
  
  $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs');
  $ValeursTableau->appendChild($extraFieldvaleurs);
  CodeextraFieldvaleurs('71','71');

}

?>
  