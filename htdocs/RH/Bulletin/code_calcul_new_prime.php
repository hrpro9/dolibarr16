<?php

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

    $employe=$_POST['employe'];
    $newprimes=$_POST['newprimes'] ?? 0;
    $annee_now=date('Y');
    $moisnew=date('m');
    $mois_now=date('m')-1;
    $sn=0;$salairenet=0;$primes=0;$les_indeminités=0;$sbi=0;$cnss=0;$amo=0;$cimr=0;$mutuelle=0;$cimr_patronale=0;$mutule_active=0;$cimr_active=0;
    $fraie_professionnels=0;$sni=0;$ir_b=0;$cf=0;$ir_n=0;$sb=0;$new_prime=0;$mutuelle_patronale=0;$cnss_patronale=0;$allocaton_familale=0;
    $participation_amo=0; $amo_patronale=0;$les_indeminités0=0;$les_indeminités1=0;$les_indeminités_moins=0;

    $sql="SELECT *  FROM llx_Paie_MonthDeclaration ";
    $rest=$db->query($sql);
    //$param_paie_mdeclaration=((object)($rest_paie_mdeclaration))->fetch_assoc();
    $jourWork=0;
    foreach($rest as $paie_monthdeclaration)
    {

        if($paie_monthdeclaration['userid']==$employe && $paie_monthdeclaration['year']==$annee_now)
        {
            $jourWork+=$paie_monthdeclaration['workingDays'];
        }
       
        if($paie_monthdeclaration['userid']==$employe && $paie_monthdeclaration['year']==$annee_now && ($paie_monthdeclaration['month']==$mois_now || $paie_monthdeclaration['month']==$moisnew ) )
        {

            $salairenet=$paie_monthdeclaration['salaireNet'];
           
            $sn= $salairenet;
            $sn_newprime=$sn+ $newprimes;

           


            $sql="SELECT *  FROM llx_Paie_MonthDeclarationRubs WHERE userid=" . $paie_monthdeclaration['userid'] . " ";
            $rest=$db->query($sql);
          //  $param_sb=((object)($rest))->fetch_assoc();
            foreach($rest as $paie_monthdeclarationrubs)
            {
                if($paie_monthdeclarationrubs['month']==$paie_monthdeclaration['month'] &&  $paie_monthdeclarationrubs['year']==$paie_monthdeclaration['year'])
                {
                    $sb=$paie_monthdeclarationrubs['salaireDeBase'];
                    
                    if($paie_monthdeclarationrubs['situationFamiliale']=="MARIE")
                    {
                        $cf=$paie_monthdeclarationrubs['enfants']+1;
                    }else{
                        $cf=$paie_monthdeclarationrubs['enfants'];
                    }
                }

            }
                $sql="SELECT *  FROM llx_Paie_UserParameters WHERE userid=" . $paie_monthdeclaration['userid'] . " ";
                $rest_paie_userparameters=$db->query($sql);
                foreach($rest_paie_userparameters as $paie_userparameters)
                {
                    $sql="SELECT *  FROM llx_Paie_Rub WHERE cotisation=0";
                    $rest_paie_rub0=$db->query($sql);
                    $param_paie_rub0=((object)($rest_paie_rub0))->fetch_assoc();
                    foreach($rest_paie_rub0 as $paie_rub0)
                    {
                        if($paie_rub0['imposable']==1)
                        {
                            if($paie_rub0['rub']==$paie_userparameters['rub'])
                            {                         
                                $primes+=$paie_userparameters['amount']; 
                            }
                        }else{
                            if($paie_rub0['rub']==$paie_userparameters['rub'])
                            {
                             $les_indeminités0+=$paie_userparameters['amount'];
                            }
                        }
                    }

                    $sql="SELECT *  FROM llx_Paie_UserInfo WHERE userid=" . $paie_monthdeclaration['userid'] . " ";
                    $rest_paie_userInfo=$db->query($sql);
                    $param_paie_userInfo=((object)($rest_paie_userInfo))->fetch_assoc();

                    if(!empty($param_paie_userInfo['mutuelle']) && $param_paie_userInfo['mutuelle']!=0)
                    {
                        $mutule_active=1;
                    }
                    if(!empty($param_paie_userInfo['cimr']) && $param_paie_userInfo['cimr']!=0)
                    {
                        $cimr_active=1;
                    }

                    $sql="SELECT *  FROM  llx_user WHERE rowid=" . $paie_monthdeclaration['userid'] . " ";
                    $rest_user=$db->query($sql);
                    $param_user=((object)($rest_user))->fetch_assoc();
                    $dateemployment=$param_user['dateemployment'];
                    // Convert $dateemployment to a DateTime object
                    $date1 = new DateTime($dateemployment);
                    // Create a DateTime object for today's date
                    $date2 = new DateTime();
                    // Calculate the interval between the two dates
                    $interval = $date1->diff($date2);
                    // Get the number of years
                    $years = $interval->y;
                    $sql = "SELECT 	percentPrimDancien FROM llx_Paie_PrimDancienParameters WHERE (" . $years . ">=de and " . $years . "<=a) OR (" . $years . ">=de and a = '+')";
                    $res_paie_primDancienParameters = $db->query($sql);
                    $param__paie_primDancienParameters = ((object)($res_paie_primDancienParameters))->fetch_assoc();
                    $percentPrimDancien=$param__paie_primDancienParameters['percentPrimDancien']/100;
                    $prime_danciennete=$sb*$percentPrimDancien;
                }
         
            $primes+=$prime_danciennete;
            // salaire_brut_imposable
            $sbi=(($sb+$primes));

            if($sn == $sn_newprime )
            {
                echo "<br>";
            }
            else{
                do
                {
                    $v_test=$sn_newprime-$sn;
                    // salaire_brut_imposable
                    $sbi=$sbi+ $v_test; 
                    // new_prime
                    $new_prime= $sbi+$les_indeminités-$sb-$primes; 
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
                    // COTISATION MUTUELLE
                    if($mutule_active==1)
                    {
                        $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=706";
                        $res = $db->query($sql);
                        $param_mutuelle = ((object)($res))->fetch_assoc();
                        $tauxmutuelle=$param_mutuelle["percentage"]/100;
                        $mutuelle=$sbi*$tauxmutuelle;
                    }
                    else{
                        $mutuelle=0;
                    }
                    //  cimr
                    if($cimr_active==1)
                    {
                        $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=710";
                        $res = $db->query($sql);
                        $param_cimr = ((object)($res))->fetch_assoc();
                        $tauxcimr=$param_cimr["percentage"]/100;
                        $cimr=$sbi*$tauxcimr;
                    }else{
                        $cimr=0;
                    }
                    // fraie_professionnels
                    $param["percentage"] = $sbi <= 6500 ?0.35 : 0.25;
                    $fp=$sbi* $param["percentage"];
                    $maxfp=2916.67;
                    $fraie_professionnels=$fp<$maxfp?$fp:$maxfp;
                    // salaire_net_imposable
                    $sni=$sbi - ($cnss+$amo+$mutuelle+$cimr+$fraie_professionnels);
                    //ir_brut
                    $sql = "SELECT percentIR, deduction FROM llx_Paie_IRParameters WHERE (" . $sni . ">=irmin and " . $sni . "<=irmax) OR (" . $sni . ">=irmin and irmax = '+')";
                    $res = $db->query($sql);
                    $ir = ((object)($res))->fetch_assoc();
                    $ir_taux =$ir['percentIR']/ 100;
                    $ir_b =($sni*$ir_taux)-$ir['deduction'];
                    //ir_net
                    $ir_n=$cf>$params["maxChildrens"]?$ir_b-($params["maxChildrens"]*$params["primDenfan"]):$ir_b-($cf*$params["primDenfan"]);
                    // salaire net test
                    $sn=round(($sbi-$cnss-$amo-$cimr-$mutuelle-$ir_n)+$les_indeminités0, 2);
             }while($sn != $sn_newprime );
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
            $amo_patronale=$sbi* $param_amo["percentage"]/100;
            //MUTUELLE patronale
            $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=706";
            $res = $db->query($sql);
            $param_mutuelle = ((object)($res))->fetch_assoc();
            $tauxmutuelle=$param_mutuelle["percentage"]/100;
            $mutuelle_patronale=$sbi*$tauxmutuelle;
            //cimr patronale
            $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=711";
            $res = $db->query($sql);
            $param_cimrpatronale = ((object)($res))->fetch_assoc();
            $tauxcimrpatronale=$param_cimrpatronale["percentage"]/100;
            $cimr_patronale=$sbi*$tauxcimrpatronale;
            }  
        }
    }

    
  
   