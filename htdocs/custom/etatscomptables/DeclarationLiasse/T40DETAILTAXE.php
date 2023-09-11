<?php

 
  $filename =   DOL_DOCUMENT_ROOT . '/custom/etatscomptables/DetatlTaxe/detatTaxe_fichier_'.$annee_du.'.php';
  if (file_exists($filename)) {
    include $filename;
 
  $ValeursTableau = $dom->createElement('ValeursTableau');
  $groupeValeursTableau->appendChild($ValeursTableau);
  $tableau = $dom->createElement('tableau');
  $ValeursTableau->appendChild($tableau);
  $id = $dom->createElement('id','40');
  $tableau->appendChild($id);
  $groupeValeurs = $dom->createElement('groupeValeurs');
  $ValeursTableau->appendChild($groupeValeurs);
  CodeEdiValeurCellule('2065',$TF_SADDL);
  CodeEdiValeurCellule('2066',$detatTaxeValeur1);
  CodeEdiValeurCellule('2067',$detatTaxeValeur2);
  CodeEdiValeurCellule('2068',$TF_SFDE);
  CodeEdiValeurCellule('2070',$TR_SADDL);
  CodeEdiValeurCellule('2071',$TR_OCDL);
  CodeEdiValeurCellule('2072','0');
  CodeEdiValeurCellule('2073',$TR_SFDE);
  CodeEdiValeurCellule('2075',$SC_SADDL);
  CodeEdiValeurCellule('2076',$SC_OCDL);
  CodeEdiValeurCellule('2077',$detatTaxeValeur3);
  CodeEdiValeurCellule('2078',$SC_SFDE);
  CodeEdiValeurCellule('2080',$SIM_SADDL);
  CodeEdiValeurCellule('2081',$SIM_OCDL);
  CodeEdiValeurCellule('2082',$detatTaxeValeur4);
  CodeEdiValeurCellule('2083',$SIM_SFDE);
  CodeEdiValeurCellule('2085',$TDOCDT_SADDL);
  CodeEdiValeurCellule('2086',$TDOCDT_OCDL);
  CodeEdiValeurCellule('2087','0');
  CodeEdiValeurCellule('2088',$TDOCDT_SFDE);


  
  $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
  $ValeursTableau->appendChild($extraFieldvaleurs);
  
  }


?>
  