<?php

    $params = '';
    $salaireParams = '';
    $param='';
    $ir ='';
    $cnss_check=0;
    $mutuelle_patronale=0;
    //Get Parameters from database
    $sql = "SELECT * FROM llx_Paie_bdpParameters";
    $res = $db->query($sql);
    $params = ((object)($res))->fetch_assoc();
    //Get les rubriques cotisations
    $sql = "SELECT * FROM llx_Paie_Rub WHERE cotisation=1";
    $res = $db->query($sql);
    $param = ((object)($res))->fetch_assoc();
    //Get data From calcul_salaire_base
    $sn=$_POST['sn'];
   
    $les_indeminités=$_POST['les_indeminités'];                   
    $cf=$_POST['cf']; 
    $date=$_POST['date']; 
    $mutuelle_check=$_POST['mutuelle'] ?? 0;
    $cimr_check=$_POST['cimr'] ?? 0;

    $scolarite_input=intval($_POST['scolarite_input'] ?? 0);
    $aid_adha_input=intval($_POST['aid_adha_input'] ?? 0);
    $panier_input=intval($_POST['panier_input'] ?? 0);
    $transport_input=intval($_POST['transport_input'] ?? 0);
    $stage_input=intval($_POST['stage_input'] ?? 0);
    $responsabilite_input=intval($_POST['responsabilite_input'] ?? 0);
    $preavis_input=intval($_POST['preavis_input'] ?? 0);
    $rendement_input=intval($_POST['rendement_input'] ?? 0);
    $representation_input=intval($_POST['representation_input'] ?? 0);
    $fonction_input=intval($_POST['fonction_input'] ?? 0);
    $indemnite_transport_input=intval($_POST['indemnite_transport_input'] ?? 0);
    
    $primes=$scolarite_input+$aid_adha_input+$panier_input+$transport_input+$stage_input+$responsabilite_input+$preavis_input+
    $rendement_input+$representation_input+$fonction_input+$indemnite_transport_input;
    

    //test salaire de base 
    $sb=2500; 
    //test salaire net 
    $sn_test=2331.5;
    if($sn_test == $sn )
    {
        echo "----> salaire de base : ".$sb ."<br>";
    }
    else{
        do
        {
            $v_test=$sn-$sn_test;
            // salaire de base test
            $sb= round($sb + $v_test, 2);
            // salaire_brut_imposable
            $sbi=($sb+$primes)-$les_indeminités; 
            // cnss
                $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=700";
                $res = $db->query($sql);
                $param_cnss = ((object)($res))->fetch_assoc();
                $tauxcnss=$param_cnss["percentage"]/100;
                $maxcnss=$param_cnss["plafond"]/$tauxcnss;
                $cnss=$sbi<$maxcnss?$sbi*$tauxcnss:$maxcnss*$tauxcnss;
            //  cimr
            if($cimr_check==3)
            {
                $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=710";
                $res = $db->query($sql);
                $param_cimr = ((object)($res))->fetch_assoc();
                $tauxcimr=$param_cimr["percentage"]/100;
                $cimr=$sbi*$tauxcimr;
             }else  if($cimr_check==6){
                $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=712";
                $res = $db->query($sql);
                $param_cimr = ((object)($res))->fetch_assoc();
                $tauxcimr=$param_cimr["percentage"]/100;
                $cimr=$sbi*$tauxcimr;
             }else{
                $cimr=0;
             }
            // amo
            $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=702";
            $res = $db->query($sql);
            $param_amo = ((object)($res))->fetch_assoc();
            $tauxamo=$param_amo["percentage"]/100;
            $amo=$sbi*$tauxamo;
            // COTISATION MUTUELLE
            if($mutuelle_check==1)
            {
                $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=706";
                $res = $db->query($sql);
                $param_mutuelle = ((object)($res))->fetch_assoc();
                $tauxmutuelle=$param_mutuelle["percentage"]/100;
                $mutuelle=$sbi*$tauxmutuelle;
            }else{
                $mutuelle=0;
            }
            // fraie_professionnels
            $param["percentage"] = $sbi <= 6500 ?0.35 : 0.25;
            $fp=$sbi* $param["percentage"];
            $maxfp=2916.67;
            $fraie_professionnels=$fp<$maxfp?$fp:$maxfp;
            // salaire_net_imposable
            $sni=$sbi - ($cnss+$amo+$cimr+$mutuelle+$fraie_professionnels);
            //ir_brut
            $sql = "SELECT percentIR, deduction FROM llx_Paie_IRParameters WHERE (" . $sni . ">=irmin and " . $sni . "<=irmax) OR (" . $sni . ">=irmin and irmax = '+')";
            $res = $db->query($sql);
            $ir = ((object)($res))->fetch_assoc();
            $ir_taux =$ir['percentIR']/ 100;
            $ir_b =($sni*$ir_taux)-$ir['deduction'];
            //ir_n
            $ir_n=$cf>$params["maxChildrens"]?$ir_b-($params["maxChildrens"]*$params["primDenfan"]):$ir_b-($cf*$params["primDenfan"]); 
            // salaire net test 
            $sn_test=round($sbi-$cnss-$amo-$cimr-$mutuelle-$ir_n, 2);
        }while($sn_test != $sn); 
    }
    /*--------------------------------> charges patronale <--------------------------------*/
    $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=702";
    $res = $db->query($sql);
    $param_amo = ((object)($res))->fetch_assoc();
    $tauxamo=$param_amo["percentage"]/100;
    // cnss patronale
    $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=701";
    $res = $db->query($sql);
    $param_cp = ((object)($res))->fetch_assoc();
    $tauxcp=$param_cp["percentage"]/100;
    $maxcp=$param_cp["plafond"]/ $tauxcp;
    $cnss_patronale=$sbi<$maxcp?$sbi*$tauxcp:$maxcp*$tauxcp;
    //allocaton_familale
    $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=705";
    $res = $db->query($sql);
    $param_af = ((object)($res))->fetch_assoc();
    $allocaton_familale=$sbi* $param_af["percentage"]/100;
    //participation_amo
    $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=703";
    $res = $db->query($sql);
    $param_pamo = ((object)($res))->fetch_assoc();
    $tauxpamo=($param_pamo["percentage"]/100)-$tauxamo;
    $participation_amo=$sbi*$tauxpamo;  
    //amo_patronale
    $amo_patronale=$sbi*$tauxamo;
    //MUTUELLE patronale
    $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=706";
    $res = $db->query($sql);
    $param_mutuelle = ((object)($res))->fetch_assoc();
    $tauxmutuelle=$param_mutuelle["percentage"]/100;
    $mutuelle_patronale=$sbi*$tauxmutuelle;
   //cimr patronale
    if($cimr_check==3)
    {
        $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=711";
        $res = $db->query($sql);
        $param_cimrpatronale = ((object)($res))->fetch_assoc();
        $tauxcimrpatronale=$param_cimrpatronale["percentage"]/100;
        $cimr_patronale=$sbi*$tauxcimrpatronale;
     }else  if($cimr_check==6){
        $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=713";
        $res = $db->query($sql);
        $param_cimrpatronale = ((object)($res))->fetch_assoc();
        $tauxcimrpatronale=$param_cimrpatronale["percentage"]/100;
        $cimr_patronale=$sbi*$tauxcimrpatronale;
     }



    

      //open file
      $fileNameWrite =  DOL_DOCUMENT_ROOT . '/RH/Bulletin/files/SalaireBase.txt';
      file_put_contents($fileNameWrite, '');
      $myfilee = fopen("$fileNameWrite", "a+") or die("Unable to open file!");
      $txtf = "--> DATE DE RECRUTEMENT : ".$date ."\n";  
      $txtf .= " Indemnités : ".$les_indeminités ."\n";
      $txtf .= " Primes : ".$primes ."\n";
      $txtf .= " Charge de famille : ".$cf ."\n";
      $txtf .= " Salaire brut imposable : ".round($sbi,2) ."\n";
      $txtf .= " CNSS : ".round($cnss,2) ."\n";
      $txtf .= " CNSS Patronale  : ".round($cnss_patronale,2) ."\n";
      $txtf .= " AMO : ".round($amo,2) ."\n";
      $txtf .= " Participation AMO : ".round($participation_amo,2) ."\n";
      $txtf .= " AMO Patronale : ".round($amo_patronale,2) ."\n";
      if($mutuelle_check==1)
      { 
        $txtf .= " Mutuelle : " . round($mutuelle, 2) ."\n";
        $txtf .= " Mutuelle Patronale : " . round($mutuelle_patronale, 2) ."\n";
      }
      if($cimr_check==3 || $cimr_check==6)
      {
        $txtf .= " CIMR : ".  round($cimr, 2) ."\n";
        $txtf .= " CIMR Patronale : " . round($cimr_patronale, 2) ."\n";
      }
      $txtf .= " Frais Professionnels : ".round($fraie_professionnels,2) ."\n";
      $txtf .= " Salaire net imposable : ".round($sni,2) ."\n";
      $txtf .= " IR brut : ".round($ir_b,2) ."\n";
      $txtf .= " IR net : ".round($ir_n,2) ."\n";
      $txtf .= " Salaire  net : " . $sn ."\n";
      $txtf .= "----> Salaire de base : " . $sb ."\n";
      fwrite($myfilee, $txtf);
      fclose($myfilee);
      
     /* //Dowloand file Ds
      ob_clean();
      $DsFile = 'SalaireBase.TXT';
      header('Content-Type: application/txt');
      header('Content-Disposition: attachment; filename=' . "$DsFile");

      flush();
      readfile($fileNameWrite);
      exit();*/

?>
