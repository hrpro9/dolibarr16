<?php
  $filename =  DOL_DOCUMENT_ROOT . '/custom/etatscomptables/Actif/Active_fichier_'.$annee_du.'.php'; 
  if (file_exists($filename)) {
      include $filename;
  $ValeursTableau = $dom->createElement('ValeursTableau');
  $groupeValeursTableau->appendChild($ValeursTableau);
  $tableau = $dom->createElement('tableau');
  $ValeursTableau->appendChild($tableau);
  $id = $dom->createElement('id','2');
  $tableau->appendChild($id);
  $groupeValeurs = $dom->createElement('groupeValeurs');
  $ValeursTableau->appendChild($groupeValeurs);
  CodeEdiValeurCellule('497',$immNonVal_B);
  CodeEdiValeurCellule('498',$immNonVal_AP);
  CodeEdiValeurCellule('499',$immNonVal_net);
  CodeEdiValeurCellule('500',$immNonVal_EP);
  CodeEdiValeurCellule('238',$fraisP_B);
  CodeEdiValeurCellule('241',$fraisP_AP);
  CodeEdiValeurCellule('444',$fraisP_B_fraisP_AP);
  CodeEdiValeurCellule('247',$fraisP_EP);
  CodeEdiValeurCellule('239',$chargesR_B);
  CodeEdiValeurCellule('242',$chargesR_AP);
  CodeEdiValeurCellule('445',$chargesR_B_chargesR_AP );
  CodeEdiValeurCellule('248',$chargesR_EP);
  CodeEdiValeurCellule('240',$primesR_B);
  CodeEdiValeurCellule('243',$primesR_AP);
  CodeEdiValeurCellule('446',$primesR_B_primesR_AP);
  CodeEdiValeurCellule('249',$primesR_EP);
  CodeEdiValeurCellule('502',$immIncor_B);
  CodeEdiValeurCellule('503',$immIncor_AP);
  CodeEdiValeurCellule('504',$immIncor_net);
  CodeEdiValeurCellule('505',$immIncor_EP);
  CodeEdiValeurCellule('274',$immReche_B);
  CodeEdiValeurCellule('278',$immReche_AP);
  CodeEdiValeurCellule('282',$immReche_B_immReche_AP);
  CodeEdiValeurCellule('286',$immReche_EP);
  CodeEdiValeurCellule('275',$BMD_B);
  CodeEdiValeurCellule('279',$BMD_AP);
  CodeEdiValeurCellule('283',$BMD_B_BMD_AP);
  CodeEdiValeurCellule('287',$BMD_EP);
  CodeEdiValeurCellule('276',$fondsC_B);
  CodeEdiValeurCellule('280',$fondsC_AP);
  CodeEdiValeurCellule('284',$fondsC_B_fondsC_AP);
  CodeEdiValeurCellule('288',$fondsC_EP);
  CodeEdiValeurCellule('277',$autresImmoInc_B);
  CodeEdiValeurCellule('281',$autresImmoInc_AP);
  CodeEdiValeurCellule('285',$autresImmoInc_B_autresImmoInc_AP);
  CodeEdiValeurCellule('289',$autresImmoInc_EP);
  CodeEdiValeurCellule('507',$immCor_B);
  CodeEdiValeurCellule('508',$immCor_AP);
  CodeEdiValeurCellule('509',$immCor_net);
  CodeEdiValeurCellule('510',$immCor_EP);
  CodeEdiValeurCellule('207',$terrains_B);
  CodeEdiValeurCellule('214',$terrains_AP);
  CodeEdiValeurCellule('221',$terrains_B_terrains_AP);
  CodeEdiValeurCellule('228',$terrains_EP);
  CodeEdiValeurCellule('208',$cons_B);
  CodeEdiValeurCellule('215',$cons_AP);
  CodeEdiValeurCellule('222',$cons_B_cons_AP);
  CodeEdiValeurCellule('229',$cons_EP);
  CodeEdiValeurCellule('209',$instalTechMat_B);
  CodeEdiValeurCellule('216',$instalTechMat_AP);
  CodeEdiValeurCellule('223',$instalTechMat_B_instalTechMat_AP);
  CodeEdiValeurCellule('230',$instalTechMat_EP);
  CodeEdiValeurCellule('210',$matTransp_B);
  CodeEdiValeurCellule('217',$matTransp_AP);
  CodeEdiValeurCellule('224',$matTransp_B_matTransp_AP);
  CodeEdiValeurCellule('231',$matTransp_EP);
  CodeEdiValeurCellule('211',$mobMatAmenag_B);
  CodeEdiValeurCellule('218',$mobMatAmenag_AP);
  CodeEdiValeurCellule('225',$mobMatAmenag_B_BmobMatAmenag_AP);
  CodeEdiValeurCellule('232',$mobMatAmenag_EP);
  CodeEdiValeurCellule('212',$autresImmoCor_B);
  CodeEdiValeurCellule('219',$autresImmoCor_AP);
  CodeEdiValeurCellule('226',$autresImmoCor_B_autresImmoCor_AP);
  CodeEdiValeurCellule('233',$autresImmoCor_EP);
  CodeEdiValeurCellule('213',$immCorEnCours_B);
  CodeEdiValeurCellule('220',$immCorEnCours_AP);
  CodeEdiValeurCellule('227',$immCorEnCours_B_immCorEnCours_AP);
  CodeEdiValeurCellule('234',$immCorEnCours_EP);
  CodeEdiValeurCellule('512',$immFin_B);
  CodeEdiValeurCellule('513',$immFin_AP);
  CodeEdiValeurCellule('514',$immFin_net);
  CodeEdiValeurCellule('515',$immFin_EP);
  CodeEdiValeurCellule('254',$pretsImm_B);
  CodeEdiValeurCellule('258',$pretsImm_AP);
  CodeEdiValeurCellule('262',$pretsImm_B_pretsImm_AP);
  CodeEdiValeurCellule('266',$pretsImm_EP);
  CodeEdiValeurCellule('255',$autresCreFin_B);
  CodeEdiValeurCellule('259',$autresCreFin_AP);
  CodeEdiValeurCellule('263',$autresCreFin_B_autresCreFin_AP);
  CodeEdiValeurCellule('267',$autresCreFin_EP);
  CodeEdiValeurCellule('256',$titresP_B);
  CodeEdiValeurCellule('260',$titresP_AP);
  CodeEdiValeurCellule('264',$titresP_B_titresP_AP);
  CodeEdiValeurCellule('268',$titresP_EP);
  CodeEdiValeurCellule('257',$autresTitrImm_B);
  CodeEdiValeurCellule('261',$autresTitrImm_AP);
  CodeEdiValeurCellule('265',$autresTitrImm_autresTitrImm_AP);
  CodeEdiValeurCellule('269',$autresTitrImm_EP);
  CodeEdiValeurCellule('517',$ecratsConv_B);
  CodeEdiValeurCellule('518',$ecratsConv_net);
  CodeEdiValeurCellule('519',$ecratsConv_EP);
  CodeEdiValeurCellule('520',$ecratsConv_E2);
  CodeEdiValeurCellule('192',$dimCreImm_B);
  CodeEdiValeurCellule('194','0');
  CodeEdiValeurCellule('196',$dimCreImm_B);
  CodeEdiValeurCellule('198',$dimCreImm_EP);
  CodeEdiValeurCellule('193',$augDetFinc_B);
  CodeEdiValeurCellule('195','0');
  CodeEdiValeurCellule('197',$augDetFinc_B);
  CodeEdiValeurCellule('199',$augDetFinc_EP);
  CodeEdiValeurCellule('291',$total1_B);
  CodeEdiValeurCellule('292',$total1_AP);
  CodeEdiValeurCellule('293',$total1_net);
  CodeEdiValeurCellule('294',$total1_EP);
  CodeEdiValeurCellule('522',$stocks_B);
  CodeEdiValeurCellule('523',$stocks_AP);
  CodeEdiValeurCellule('524',$stocks_net);
  CodeEdiValeurCellule('525',$stocks_EP);
  CodeEdiValeurCellule('160',$march_B);
  CodeEdiValeurCellule('165',$march_AP);
  CodeEdiValeurCellule('170',$march_B_march_AP);
  CodeEdiValeurCellule('175',$march_EP);
  CodeEdiValeurCellule('161',$matFournCon_B);
  CodeEdiValeurCellule('166',$matFournCon_AP);
  CodeEdiValeurCellule('171',$matFournCon_B_matFournCon_AP);
  CodeEdiValeurCellule('176',$matFournCon_EP);
  CodeEdiValeurCellule('162',$prodC_B);
  CodeEdiValeurCellule('167',$prodC_AP);
  CodeEdiValeurCellule('172',$prodC_B_prodC_AP);
  CodeEdiValeurCellule('177',$prodC_EP);
  CodeEdiValeurCellule('163',$prodIntrProd_B);
  CodeEdiValeurCellule('168',$prodIntrProd_AP);
  CodeEdiValeurCellule('173',$prodIntrProd_B_prodIntrProd_AP);
  CodeEdiValeurCellule('178',$prodIntrProd_E2);
  CodeEdiValeurCellule('164',$prodFinis_B);
  CodeEdiValeurCellule('169',$prodFinis_AP);
  CodeEdiValeurCellule('174',$prodFinis_B_prodFinis_AP);
  CodeEdiValeurCellule('179',$prodFinis_EP);
  CodeEdiValeurCellule('527',$creActifCircl_B);
  CodeEdiValeurCellule('528',$creActifCircl_AP);
  CodeEdiValeurCellule('529',$creActifCircl_net);
  CodeEdiValeurCellule('530',$creActifCircl_EP);
  CodeEdiValeurCellule('122',$fournDAA_B);
  CodeEdiValeurCellule('129',$fournDAA_AP);
  CodeEdiValeurCellule('136',$fournDAA_B_fournDAA_AP);
  CodeEdiValeurCellule('143',$fournDAA_EP);
  CodeEdiValeurCellule('123',$clientCR_B);
  CodeEdiValeurCellule('130',$clientCR_AP);
  CodeEdiValeurCellule('137',$clientCR_B_clientCR_AP);
  CodeEdiValeurCellule('144',$clientCR_EP);
  CodeEdiValeurCellule('124',$persl_B);
  CodeEdiValeurCellule('131',$persl_AP);
  CodeEdiValeurCellule('138',$persl_B_persl_AP);
  CodeEdiValeurCellule('145',$persl_EP);
  CodeEdiValeurCellule('125',$etat_B);
  CodeEdiValeurCellule('132',$etat_AP);
  CodeEdiValeurCellule('139',$etat_B_etat_AP);
  CodeEdiValeurCellule('146',$etat_EP);
  CodeEdiValeurCellule('126',$comptAss_B);
  CodeEdiValeurCellule('133',$comptAss_AP);
  CodeEdiValeurCellule('140',$comptAss_B_comptAss_AP);
  CodeEdiValeurCellule('147',$comptAss_EP);
  CodeEdiValeurCellule('127',$autresDebit_B);
  CodeEdiValeurCellule('134',$autresDebit_AP);
  CodeEdiValeurCellule('141',$autresDebit_B_autresDebit_AP);
  CodeEdiValeurCellule('148',$autresDebit_EP);
  CodeEdiValeurCellule('128',$comptRegAct_B);
  CodeEdiValeurCellule('135',$comptRegAct_AP);
  CodeEdiValeurCellule('142',$comptRegAct_B_comptRegAct_AP);
  CodeEdiValeurCellule('149',$comptRegAct_EP);
  CodeEdiValeurCellule('181',$titreValPlace_B);
  CodeEdiValeurCellule('182',$titreValPlace_AP);
  CodeEdiValeurCellule('183',$titreValPlace_B_titreValPlace_AP);
  CodeEdiValeurCellule('184',$titreValPlace_EP);
  CodeEdiValeurCellule('151',$ecratConverAct_B);
  CodeEdiValeurCellule('152','0');
  CodeEdiValeurCellule('153',$ecratConverAct_B);
  CodeEdiValeurCellule('154',$ecratConverAct_EP);
  CodeEdiValeurCellule('296',$total2_B);
  CodeEdiValeurCellule('297',$total2_AP);
  CodeEdiValeurCellule('298',$total2_net);
  CodeEdiValeurCellule('299',$total2_EP);
  CodeEdiValeurCellule('532',$tresorAct_B);
  CodeEdiValeurCellule('533',$tresorAct_AP);
  CodeEdiValeurCellule('534',$tresorAct_net);
  CodeEdiValeurCellule('535',$tresorAct_EP);
  CodeEdiValeurCellule('303',$chqValEnc_B);
  CodeEdiValeurCellule('306',$chqValEnc_AP);
  CodeEdiValeurCellule('309',$chqValEnc_B_chqValEnc_AP);
  CodeEdiValeurCellule('312',$chqValEnc_EP);
  CodeEdiValeurCellule('304',$banqTGCP_B);
  CodeEdiValeurCellule('307',$banqTGCP_AP);
  CodeEdiValeurCellule('310',$banqTGCP_B_banqTGCP_AP);
  CodeEdiValeurCellule('313',$banqTGCP_EP);
  CodeEdiValeurCellule('305',$caissRegAv_B);
  CodeEdiValeurCellule('308',$caissRegAv_AP);
  CodeEdiValeurCellule('311',$caissRegAv_B_caissRegAv_AP);
  CodeEdiValeurCellule('314',$caissRegAv_EP);
  CodeEdiValeurCellule('316',$total3_B);
  CodeEdiValeurCellule('317',$total3_AP);
  CodeEdiValeurCellule('318',$total3_net);
  CodeEdiValeurCellule('319',$total3_EP);
  CodeEdiValeurCellule('186',$totalGen_B);
  CodeEdiValeurCellule('187',$totalGen_AP);
  CodeEdiValeurCellule('188',$totalGen_net);
  CodeEdiValeurCellule('189',$totalGen_EP);
  
  
  $extraFieldvaleurs = $dom->createElement('extraFieldvaleurs',' ');
  $ValeursTableau->appendChild($extraFieldvaleurs);
 
  }

?>
  