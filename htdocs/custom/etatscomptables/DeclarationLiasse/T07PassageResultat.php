<?php

  $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/PassageComptableFiscal/PassageComptableFiscal_fichier_' . $annee_du . '.php';


if (file_exists($filename)) {
    include $filename;
    
    $ValeursTableau = $dom->createElement('ValeursTableau');
    $groupeValeursTableau->appendChild($ValeursTableau);
    $tableau = $dom->createElement('tableau');
    $ValeursTableau->appendChild($tableau);
    $id = $dom->createElement('id','7');
    $tableau->appendChild($id);
    $groupeValeurs = $dom->createElement('groupeValeurs');
    $ValeursTableau->appendChild($groupeValeurs);
    CodeEdiValeurCellule('817',$BN_MP);
    CodeEdiValeurCellule('819','0');
    CodeEdiValeurCellule('818','0');
    CodeEdiValeurCellule('820',$PN_MM);
    CodeEdiValeurCellule('18009',$IIRF_MP);
    CodeEdiValeurCellule('18010','0');
    CodeEdiValeurCelluleLigne('821', '1. Courantes',1);
    CodeEdiValeurCelluleLigne('822', $C1_MP,1);
    CodeEdiValeurCelluleLigne('823', '0',1);
    CodeEdiValeurCelluleLigne('821', 'RRR obtenus des exercice anterieurs',2);
    CodeEdiValeurCelluleLigne('822', $RODEA_MP,2);
    CodeEdiValeurCelluleLigne('823', '0',2);
    CodeEdiValeurCelluleLigne('821', 'Autres charges des exercice anterieurs',3);
    CodeEdiValeurCelluleLigne('822', $ACDEA_MP,3);
    CodeEdiValeurCelluleLigne('823', '0',3);
    CodeEdiValeurCelluleLigne('821', 'Impots et taxes des exercices anterieurs',4);
    CodeEdiValeurCelluleLigne('822', $IETDEA_MP,4);
    CodeEdiValeurCelluleLigne('823', '0',4);
    CodeEdiValeurCelluleLigne('821', 'Charges de personnel exercices anterieurs',5);
    CodeEdiValeurCelluleLigne('822', $CDPEA_MP,5);
    CodeEdiValeurCelluleLigne('823', '0',5);
    CodeEdiValeurCelluleLigne('821', 'Dotation d\'exploitation exercices anterieurs',6);
    CodeEdiValeurCelluleLigne('822', $DDEA_MP,6);
    CodeEdiValeurCelluleLigne('823', '0',6);
    CodeEdiValeurCelluleLigne('821', 'Charges d\'interet des exercices anterieurs',7);
    CodeEdiValeurCelluleLigne('822', $CDDEA_MP,7);
    CodeEdiValeurCelluleLigne('823', '0',7);
    CodeEdiValeurCelluleLigne('821', 'Pertes de changes exercice anterieurs',8);
    CodeEdiValeurCelluleLigne('822', $PDCEA_MP,8);
    CodeEdiValeurCelluleLigne('823', '0',8);
    CodeEdiValeurCelluleLigne('821', 'Autres charges financieres exercice anterieurs',9);
    CodeEdiValeurCelluleLigne('822', $ACFEA_MP,9);
    CodeEdiValeurCelluleLigne('823', '0',9);
    CodeEdiValeurCelluleLigne('821', 'Achats revendus de marchandises des exercices anterieurs',11);
    CodeEdiValeurCelluleLigne('822', $ARDMDEA_MP,11);
    CodeEdiValeurCelluleLigne('823', '0',11);
    CodeEdiValeurCelluleLigne('821', 'Achats de matieres et de fournitures des exercices anterieurs',12);
    CodeEdiValeurCelluleLigne('822', $ADMEDFDEA_MP,12);
    CodeEdiValeurCelluleLigne('823', '0',12);
    CodeEdiValeurCelluleLigne('821', 'Cadeaux non deductibles',13);
    CodeEdiValeurCelluleLigne('822', $CND_MP,13);
    CodeEdiValeurCelluleLigne('823', '0',13);
    CodeEdiValeurCelluleLigne('821', 'Dons non deductible',14);
    CodeEdiValeurCelluleLigne('822', $DND_MP,14);
    CodeEdiValeurCelluleLigne('823', '0',14);
    CodeEdiValeurCelluleLigne('824', '1. Non courantes',1);
    CodeEdiValeurCelluleLigne('825', $NC2_MP,1);
    CodeEdiValeurCelluleLigne('826', '0',1);
    CodeEdiValeurCelluleLigne('824', 'Cotisation Minimale',2);
    CodeEdiValeurCelluleLigne('825', $CM_MP,2);
    CodeEdiValeurCelluleLigne('826', '0',2);
    CodeEdiValeurCelluleLigne('824', 'Impot sur le resultat',3);
    CodeEdiValeurCelluleLigne('825', $ISLR_MP,3);
    CodeEdiValeurCelluleLigne('826', '0',3);
    CodeEdiValeurCelluleLigne('824', 'Creances devenues irrecouvrables',4);
    CodeEdiValeurCelluleLigne('825', $CDI_MP,4);
    CodeEdiValeurCelluleLigne('826', '0',4);
    CodeEdiValeurCelluleLigne('824', 'Subventions accordees exercice anterieurs',5);
    CodeEdiValeurCelluleLigne('825', $SAEA_MP,5);
    CodeEdiValeurCelluleLigne('826', '0',5);
    CodeEdiValeurCelluleLigne('824', 'Penalites et amandes fiscales',6);
    CodeEdiValeurCelluleLigne('825', $PEAF_MP,6);
    CodeEdiValeurCelluleLigne('826', '0',6);
    CodeEdiValeurCelluleLigne('824', 'Autres charges non courant des exercices ant',7);
    CodeEdiValeurCelluleLigne('825', $ACNCDEA_MP,7);
    CodeEdiValeurCelluleLigne('826', '0',7);
    CodeEdiValeurCelluleLigne('824', 'Dotations non courantes exercices anterieurs',8);
    CodeEdiValeurCelluleLigne('825', $DNCEA_MP,8);
    CodeEdiValeurCelluleLigne('826', '0',8);
    CodeEdiValeurCelluleLigne('824', 'Dotations non courantes exercices anterieurs',9);
    CodeEdiValeurCelluleLigne('825', $DNCEA_MP,9);
    CodeEdiValeurCelluleLigne('826', '0',9);
    CodeEdiValeurCelluleLigne('824', 'Contribution sociale de solidarité sur les bénéfices (C.S.S)',10);
    CodeEdiValeurCelluleLigne('825', $DNCEA_MP,10);
    CodeEdiValeurCelluleLigne('826', '0',10);
    CodeEdiValeurCellule('18012','0');
    CodeEdiValeurCellule('18013',$IIIDF_MM);
    CodeEdiValeurCelluleLigne('827', '1. Courantes',1);
    CodeEdiValeurCelluleLigne('828', '0',1);
    CodeEdiValeurCelluleLigne('830', $CIII_MM,1);
    CodeEdiValeurCelluleLigne('827', 'Dividendes et produits de participation',2);
    CodeEdiValeurCelluleLigne('828', '0',2);
    CodeEdiValeurCelluleLigne('830', $DEPDP_MM,2);
    CodeEdiValeurCelluleLigne('827', 'Ind.retard (Loi 32-10) compt.non encaissées',3);
    CodeEdiValeurCelluleLigne('828', '0',3);
    CodeEdiValeurCelluleLigne('830', $IRCNE_MM,3);
    CodeEdiValeurCelluleLigne('827', 'Ind.retard (Loi 32-10) compt.non payées en N',4);
    CodeEdiValeurCelluleLigne('828', '0',4);
    CodeEdiValeurCelluleLigne('830', $IRCNPEN_MM,4);
    CodeEdiValeurCelluleLigne('829', '2.  Non courantes',1);
    CodeEdiValeurCelluleLigne('831', '0',1);
    CodeEdiValeurCelluleLigne('7830', $NCIII_MM,1);
    CodeEdiValeurCelluleLigne('829',$PassageCom1,2);
    CodeEdiValeurCelluleLigne('831', '0',2);
    CodeEdiValeurCelluleLigne('7830', $PassageCom3,2);
    CodeEdiValeurCelluleLigne('829',$PassageCom4,3);
    CodeEdiValeurCelluleLigne('831', '0',3);
    CodeEdiValeurCelluleLigne('7830', $PassageCom6,3);
    CodeEdiValeurCelluleLigne('829',$PassageCom7,4);
    CodeEdiValeurCelluleLigne('831', '0',4);
    CodeEdiValeurCelluleLigne('7830', $PassageCom9,4);
    CodeEdiValeurCellule('833',$Total_MP);
    CodeEdiValeurCellule('834',$Total_MM);
    CodeEdiValeurCellule('837',$BBSI_MM);
    CodeEdiValeurCellule('839','0');
    CodeEdiValeurCellule('838','0');
    CodeEdiValeurCellule('840',$DBFSI_MM);
    CodeEdiValeurCellule('845',$PassageCom10);
    CodeEdiValeurCellule('849','0');
    CodeEdiValeurCellule('846',$PassageCom11);
    CodeEdiValeurCellule('850','0');
    CodeEdiValeurCellule('847',$PassageCom12);
    CodeEdiValeurCellule('851','0');
    CodeEdiValeurCellule('848',$PassageCom13);
    CodeEdiValeurCellule('852','0');
    CodeEdiValeurCellule('6872','0');
    CodeEdiValeurCellule('6874',$BNFAC_MM);
    CodeEdiValeurCellule('6873','0');
    CodeEdiValeurCellule('6875',$VRDIC_MM);
    CodeEdiValeurCellule('854','0');
    CodeEdiValeurCellule('855',$PassageCom15);
    CodeEdiValeurCellule('860','0');
    CodeEdiValeurCellule('864',$PassageCom16);
    CodeEdiValeurCellule('861','0');
    CodeEdiValeurCellule('865',$PassageCom17);
    CodeEdiValeurCellule('862','0');
    CodeEdiValeurCellule('866',$PassageCom18);
    CodeEdiValeurCellule('863','0');
    CodeEdiValeurCellule('867',$PassageCom19);


    $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
    $ValeursTableau->appendChild($extraFieldvaleurs);
  
}
// } else {
//     echo "Error: The file $filename does not exist.";
// }


?>