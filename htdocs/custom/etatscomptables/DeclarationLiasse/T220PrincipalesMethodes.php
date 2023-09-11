<?php
  $filename =  DOL_DOCUMENT_ROOT . '/custom/etatscomptables/PrincipalesMethodes/PrincipalesMethodes_fichier_'.$annee_du.'.php';
  if (file_exists($filename)) {
    include $filename;
  $ValeursTableau = $dom->createElement('ValeursTableau');
  $groupeValeursTableau->appendChild($ValeursTableau);
  $tableau = $dom->createElement('tableau');
  $ValeursTableau->appendChild($tableau);
  $id = $dom->createElement('id','220');
  $tableau->appendChild($id);
  $groupeValeurs = $dom->createElement('groupeValeurs');
  $ValeursTableau->appendChild($groupeValeurs);
  CodeEdiValeurCellule('14342',$PrincipalesMethodes0);
  CodeEdiValeurCellule('14343',$PrincipalesMethodes1);
  CodeEdiValeurCellule('14344',$PrincipalesMethodes2);
  CodeEdiValeurCellule('14345',$PrincipalesMethodes3);
  CodeEdiValeurCellule('14301',$PrincipalesMethodes4);
  CodeEdiValeurCellule('14303',$PrincipalesMethodes5);
  CodeEdiValeurCellule('14305',$PrincipalesMethodes6);
  CodeEdiValeurCellule('14307',$PrincipalesMethodes7);
  CodeEdiValeurCellule('14309',$PrincipalesMethodes8);
  CodeEdiValeurCellule('14311',$PrincipalesMethodes9);
  CodeEdiValeurCellule('14313',$PrincipalesMethodes10);
  CodeEdiValeurCellule('14315',$PrincipalesMethodes11);
  CodeEdiValeurCellule('14317',$PrincipalesMethodes12);
  CodeEdiValeurCellule('14319',$PrincipalesMethodes13);
  CodeEdiValeurCellule('14321',$PrincipalesMethodes14);
  CodeEdiValeurCellule('14323',$PrincipalesMethodes15);
  CodeEdiValeurCellule('14325',$PrincipalesMethodes16);
  CodeEdiValeurCellule('14327',$PrincipalesMethodes17);
  CodeEdiValeurCellule('14329',$PrincipalesMethodes18);
  CodeEdiValeurCellule('14331',$PrincipalesMethodes19);
  CodeEdiValeurCellule('14333',$PrincipalesMethodes20);
  CodeEdiValeurCellule('14335',$PrincipalesMethodes21);
  CodeEdiValeurCellule('14337',$PrincipalesMethodes22);
  $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
  $ValeursTableau->appendChild($extraFieldvaleurs);

}
?>
  