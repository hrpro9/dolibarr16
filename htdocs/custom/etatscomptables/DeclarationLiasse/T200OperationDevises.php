<?php

  $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/OperatinDevises/Operationdevises_fichier_' . $annee_du . '.php';

if (file_exists($filename)) {
    include $filename;
    
    $ValeursTableau = $dom->createElement('ValeursTableau');
    $groupeValeursTableau->appendChild($ValeursTableau);
    $tableau = $dom->createElement('tableau');
    $ValeursTableau->appendChild($tableau);
    $id = $dom->createElement('id','200');
    $tableau->appendChild($id);
    $groupeValeurs = $dom->createElement('groupeValeurs');
    $ValeursTableau->appendChild($groupeValeurs);
    CodeEdiValeurCellule('14068',$Operationdevises0);
    CodeEdiValeurCellule('14069',$Operationdevises1);
    CodeEdiValeurCellule('14071',$Operationdevises2);
    CodeEdiValeurCellule('14072',$Operationdevises3);
    CodeEdiValeurCellule('14074',$Operationdevises4);
    CodeEdiValeurCellule('14075',$Operationdevises5);
    CodeEdiValeurCellule('14077',$Operationdevises6);
    CodeEdiValeurCellule('14078',$Operationdevises7);
    CodeEdiValeurCellule('14080',$Operationdevises8);
    CodeEdiValeurCellule('14081',$Operationdevises9);
    CodeEdiValeurCellule('14083',$Operationdevises10);
    CodeEdiValeurCellule('14084',$Operationdevises11);
    CodeEdiValeurCellule('14086',$sum1);
    CodeEdiValeurCellule('14087','0');
    CodeEdiValeurCellule('16394','0');
    CodeEdiValeurCellule('16395',$sum2);
    CodeEdiValeurCellule('16397',$sum3);
    CodeEdiValeurCellule('16398',$sum4);
    CodeEdiValeurCellule('16400',$sum5);
    CodeEdiValeurCellule('16401',$sum6);

    $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
    $ValeursTableau->appendChild($extraFieldvaleurs);
  
}
// } else {
//     echo "Error: The file $filename does not exist.";
// }


?>
  