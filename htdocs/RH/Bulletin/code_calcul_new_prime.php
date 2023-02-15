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
    //Get Parameters from database
    $sql = "SELECT * FROM llx_Paie_bdpParameters";
    $res = $db->query($sql);
    $params = ((object)($res))->fetch_assoc();
    //Get les rubriques cotisations
    $sql = "SELECT * FROM llx_Paie_Rub WHERE cotisation=1";
    $res = $db->query($sql);
    $param = ((object)($res))->fetch_assoc();

    $sn=$_POST['sn'];
    $sb=$_POST['sb'];
    $conge=$_POST['conge'];
    $primes=$_POST['primes'];
    $les_indeminités=$_POST['les_indeminités'];                   
    $cf=$_POST['cf'];
    // salaire_brut_imposable
    $sbi=($sb+$primes+$conge)-$les_indeminités;  
    // cnss
    //  $cnss=$sbi<6000?$sbi*0.0448:6000*0.0448;
    $cnss=$sbi<$params["maxCNSS"]?$sbi*$params["cnss"]:$params["maxCNSS"]*$params["cnss"];
    // amo
    //  $amo=$sbi*0.0226; 
    $amo=$sbi*$params["amo"]; 
    // fraie_professionnels
     /*  $fraie_professionnels=$sbi>6500?$sbi*0.25:$sbi*0.35; 
    if($fraie_professionnels>2916.67)
    {
        $fraie_professionnels=2916.67;
    }*/
    $param["percentage"] = $sbi <= 6500 ?0.35 : 0.25;
    $fp=$sbi* $param["percentage"];
    $fraie_professionnels=$fp<2916.67?$fp:2916.67;
    // salaire_net_imposable
    $sni=$sbi - ($cnss+$amo+$fraie_professionnels);
    //ir_brut
    $ir='';
    $sql = "SELECT percentIR, deduction FROM llx_Paie_IRParameters WHERE (" . $sni . ">=irmin and " . $sni . "<=irmax) OR (" . $sni . ">=irmin and irmax = '+')";
    $res = $db->query($sql);
    $ir = ((object)($res))->fetch_assoc();
    $ir_b = $ir['percentIR'] * $sni / 100 - $ir['deduction'];
    //ir_net
    $ir_n=$cf>$params["maxChildrens"]?$ir_b-($params["maxChildrens"]*$params["primDenfan"]):$ir_b-($cf*$params["primDenfan"]);
    // salaire net test
    $sn_test=$sbi-$cnss-$amo-$ir_n;
    if($sn_test == $sn )
    {
        echo "----> prime : ".$primes ."<br>";
    }
    else{
        do
        {
            $v_test=$sn-$sn_test;
            // salaire_brut_imposable
            $sbi=$sbi+ $v_test; 
            // new_prime
            $new_prime= $sbi+$les_indeminités-$sb-$primes-$conge; 
            // cnss
            $cnss=$sbi<$params["maxCNSS"]?$sbi*$params["cnss"]:$params["maxCNSS"]*$params["cnss"];
            // amo
            $amo=$sbi*$params["amo"];
            // fraie_professionnels
            $param["percentage"] = $sbi <= 6500 ?0.35 : 0.25;
            $fp=$sbi* $param["percentage"];
            $fraie_professionnels=$fp<2916.67?$fp:2916.67;
            // salaire_net_imposable 
            $sni=$sbi - ($cnss+$amo+$fraie_professionnels); 
            //ir_brut
            $ir='';
            $sql = "SELECT percentIR, deduction FROM llx_Paie_IRParameters WHERE (" . $sni . ">=irmin and " . $sni . "<=irmax) OR (" . $sni . ">=irmin and irmax = '+')";
            $res = $db->query($sql);
            $ir = ((object)($res))->fetch_assoc();
            $ir_b = $ir['percentIR'] * $sni / 100 - $ir['deduction'];
            //ir_net
            $ir_n=$cf>$params["maxChildrens"]?$ir_b-($params["maxChildrens"]*$params["primDenfan"]):$ir_b-($cf*$params["primDenfan"]); 
            // salaire net test
            $sn_test=round($sbi-$cnss-$amo-$ir_n, 2);
        }while($sn_test != $sn);
    }
    /*--------------------------------> charges patronale <--------------------------------*/
    // cnss patronale
    //$cnss_patronale=$sbi<6000?$sbi*0.0898:6000*0.0898;
    $cnss_patronale=$sbi<$params["maxCNSS"]?$sbi* $params["patronaleCnss"]:$params["maxCNSS"]*$params["patronaleCnss"];
    //allocaton_familale
    $allocaton_familale=$sbi*0.0640; 
    //participation_amo
    $participation_amo=$sbi*0.0185;  
    //amo_patronale
   // $amo_patronale=$sbi*0.0226;
    $amo_patronale=$sbi*$params["patronaleAmo"]; 








?>