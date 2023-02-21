<?php

    // Load Dolibarr environment
    require '../../main.inc.php';
    require_once '../../vendor/autoload.php';
    // require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
    // require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
    // require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
    // require_once DOL_DOCUMENT_ROOT . '/categories/class/categorie.class.php';
    $params = '';
    $salaireParams = '';
    $param='';
    $ir ='';
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
    $primes=$_POST['primes'];
    $les_indeminités=$_POST['les_indeminités'];                   
    $cf=$_POST['cf']; 
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
            // amo
            $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=702";
            $res = $db->query($sql);
            $param_amo = ((object)($res))->fetch_assoc();
            $tauxamo=$param_amo["percentage"]/100;
            $amo=$sbi*$tauxamo;
            // fraie_professionnels
            $param["percentage"] = $sbi <= 6500 ?0.35 : 0.25;
            $fp=$sbi* $param["percentage"];
            $maxfp=2916.67;
            $fraie_professionnels=$fp<$maxfp?$fp:$maxfp;
            // salaire_net_imposable
            $sni=$sbi - ($cnss+$amo+$fraie_professionnels);
            //ir_brut
            $sql = "SELECT percentIR, deduction FROM llx_Paie_IRParameters WHERE (" . $sni . ">=irmin and " . $sni . "<=irmax) OR (" . $sni . ">=irmin and irmax = '+')";
            $res = $db->query($sql);
            $ir = ((object)($res))->fetch_assoc();
            $ir_taux =$ir['percentIR']/ 100;
            $ir_b =($sni*$ir_taux)-$ir['deduction'];
            //ir_n
            $ir_n=$cf>$params["maxChildrens"]?$ir_b-($params["maxChildrens"]*$params["primDenfan"]):$ir_b-($cf*$params["primDenfan"]); 
            // salaire net test 
            $sn_test=round($sbi-$cnss-$amo-$ir_n, 2);
        }while($sn_test != $sn); 
    }
    /*--------------------------------> charges patronale <--------------------------------*/
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
?>