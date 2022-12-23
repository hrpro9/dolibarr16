<?php
$cnssSalariale = 0;
$cnssPatronale = 0;
$amoSalariale = 0;
$amoPatronale = 0;



// Get action
$action = GETPOST('action');

// GET tout les rubriques
$sql = "SELECT * FROM llx_Paie_EtatRubs WHERE id=1";
$res = $db->query($sql);

if (((object)$res)->num_rows > 0) {
    $row = ((object)$res)->fetch_assoc();
    $cnssSalariale = (int)$row["cnssSalariale"];
    $cnssPatronale = (int)$row["cnssPatronale"];
    $amoSalariale = (int)$row["amoSalariale"];
    $amoPatronale = (int)$row["amoPatronale"];
    $indemReprCode = (int)$row["indemRepr"];
    $indemTransCode = (int)$row["indemTrans"];
    $taxeProCode = (int)$row["taxePro"];
}

if ($action == "saveRubs") {
    // Get values
    $indemReprCode = (int)GETPOST("indemRepr", 'int');
    $indemTransCode = (int)GETPOST("indemTrans", 'int');
    $taxeProCode = (int)GETPOST("taxePro", 'int');

    //Create table for rubs of etats
    $sql = "CREATE TABLE IF NOT EXISTS llx_Paie_EtatRubs(id INT PRIMARY KEY, cnssSalariale float, cnssPatronale float, amoSalariale float,
    amoPatronale float, indemRepr float, indemTrans float, taxePro float);";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    //Inset data to etats rubs table
    $sql = "REPLACE INTO llx_Paie_EtatRubs(id, amoSalariale, amoPatronale, cnssSalariale, cnssPatronale, indemRepr, indemTrans, taxePro)
    VALUES(1, $amoSalariale, $amoPatronale, $cnssSalariale, $cnssPatronale, $indemReprCode, $indemTransCode, $taxeProCode);";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);
}



$french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');

$result = $db->query($sql0);
if (!$result) {
    dol_print_error($db);
    exit;
}

$num = $db->num_rows($result);

$data = array();
$i = 0;
while ($i < $num) {
    $workingdaysTot = 0; //
    $irNetTot = 0; //
    $netImposableTot = 0; //
    $brutGlobalTot = 0;
    $brutImposableTot = 0; //
    $indemTransTot = 0; //
    $indemReprTot = 0; //
    $taxeProTot = 0; //
    $salaireBrutTot = 0; //
    $cnssTot = 0; //
    $amoTot = 0;
    $indemTotal = 0;
    $user = array();

    $Taux = 0;
    $congeDays = 0;

    $obj = $db->fetch_object($result);
    $f = 1;

    for ($j = 1; $j <= 12; $j++) {
        $prev_month = $j;

        $workingdaysdeclaré = 0;
        $salaireMonsuel = 0;
        $primeDancien = 0;
        $representation = 0;
        $soldeConge = 0;
        $salaireBrut = 0;
        $pasEnBruts = array();
        $cotisations = array();
        $enBruts = array();
        $netImposable = 0;
        $chargeFamille = 0;
        $irNet  = 0;
        $prev_arrondi = 0;
        $arrondi  = 0;
        $totalNet = 0;
        $brutImposable = 0;
        $brutGlobal = 0;
        $indemRepr = 0;
        $indemTrans = 0;
        $taxePro = 0;


        $userstatic->cin = $obj->options_cin; //
        $userstatic->id = $obj->rowid;
        $userstatic->admin = $obj->admin;
        $userstatic->ref = $obj->label;
        $userstatic->login = $obj->login;
        $userstatic->statut = $obj->statut;
        $userstatic->email = $obj->email;
        $userstatic->gender = $obj->gender;
        $userstatic->socid = $obj->fk_soc;
        $userstatic->firstname = $obj->firstname;
        $userstatic->lastname = $obj->lastname;
        $userstatic->employee = $obj->employee;
        $userstatic->photo = $obj->photo;

        $object->fetch($obj->rowid); //

        $sql1 = "SELECT fk_user FROM llx_payment_salary WHERE fk_user=" . $object->id . " AND year(datep)=" . $prev_year . " AND month(datep)=" . $prev_month;
        $res1 = $db->query($sql1);
        if ($res1->num_rows == 0) {
            //continue;
        }

        //Get Parameters from database
        // $sql = "SELECT * FROM llx_Paie_bdpParameters";
        // $res = $db->query($sql);
        // $params = ((object)($res))->fetch_assoc();

        $cnss = "";
        //Get user salaire informations from database
        $sql = "SELECT cnss from llx_Paie_UserInfo WHERE userid=" . $object->id;
        $res = $db->query($sql);
        if (((object)$res)->num_rows > 0) {
            $cnss = ((object)$res)->fetch_assoc()["cnss"];
        }

        $sql = "SELECT * FROM  llx_Paie_MonthDeclaration m, llx_Paie_MonthDeclarationRubs r WHERE r.userid=m.userid AND r.month=m.month AND r.year = m.year AND m.userid=$object->id AND m.month=$prev_month AND m.year = $prev_year";
        $res = $db->query($sql);
        if (((object)$res)->num_rows > 0) {
            $row = $res->fetch_assoc();

            $workingdaysdeclaré = (int)$row["workingDays"];
            $netImposable = (float)$row["netImposable"];
            $brutImposable = (float)$row["salaireBrut"];
            $irNet = abs((float)$row["ir"]);
            $totalNet = (float)$row["salaireNet"];

            // $situation = $row["situationFamiliale"];
            $type = $row["type"];
            $role = $row["post"];
            $joursFerie = (int)$row["joursferie"];
            $bases["salaire de base"] = $row["salaireDeBase"];
            $bases["salaire mensuel"] = $row["salaireMensuel"];
            $salaireHoraire = $row["salaireHoraire"];
            // $enfants = $bases["enfants"];
            $rubs = $row["rubs"];

            foreach (explode(";", $rubs) as $r) {
                $rub = explode(":", $r);
                $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=" . $rub[0];
                $res = $db->query($sql);
                if ($rub[1] == "brutGlobal") {
                    $brutGlobal = $rub[2];
                }
                if ($rub[1] == "arrondiPrecdent") {
                    $prev_arrondi = $rub[2];
                }
                if ($rub[1] == "arrondiEnCours") {
                    $arrondi = $rub[2];
                }
                if ($rub[1] == "chargeFamille") {
                    $chargeFamille = $rub[2];
                }

                if ($rub[0] == $indemTransCode) {
                    $indemTrans = ($rub[2] > 500) ? 500 : $rub[2];
                }

                if ($rub[0] == $indemReprCode) {
                    $indemRepr = $rub[2];
                }

                if ($rub[0] == $taxeProCode) {
                    $taxePro = abs($rub[2]);
                }
            }
        }

        // GET les rubriques CNSS et AMO
        $sql = "SELECT * FROM llx_Paie_EtatRubs WHERE id=1";
        $res = $db->query($sql);
        if (((object)$res)->num_rows > 0) {
            $row = ((object)$res)->fetch_assoc();
            $cnssSalariale = $row["cnssSalariale"];
            $amoSalariale = $row["amoSalariale"];
        }

        $sql1 = "SELECT rubs FROM llx_Paie_MonthDeclarationRubs WHERE userid=$object->id and month= $j AND year = $prev_year";
        $res1 = $db->query($sql1);
        if (((object)$res1)->num_rows > 0) {
            $row1 = ((object)$res1)->fetch_assoc();
            $rubs = $row1["rubs"];
            foreach (explode(";", $rubs) as $r) {
                $rub = explode(":", $r);
                $user['userid'] = $object->id;
                if ($rub[0] == $cnssSalariale) {
                    $cnssTot += abs($rub[2]);
                } else if ($rub[0] == $amoSalariale) {
                    $amoTot += abs($rub[2]);
                }
            }
        }

        $brutGlobalTot += $brutGlobal; //
        $brutImposableTot += $brutImposable; //
        $indemTransTot += $indemTrans; //
        $indemReprTot += $indemRepr; //

        $taxeProTot += $taxePro; //
        $netImposableTot += $netImposable;
        $irNetTot += $irNet;
        $workingdaysTot += $workingdaysdeclaré;
        // $workingdaysdeclarés[$j] = $workingdaysdeclaré;
        // $netImposables[$j] = $netImposable;
        // $irNets[$j] = $irNetTot * -1;
        // $salaireMonsuels[$j] = $bases["salaire mensuel"];
        // $primeDanciens[$j] = $primeDancien;
        // $soldeConges[$j] = $soldeConge;
        // $allEnBrut[$j] = $enBruts;

        // $primeCommercials[$j] = $primeCommercial;
        // $allCotisations[$j] = $cotisations;

        // $chargeFamilles[$j] = $chargeFamille;
        // $allPasEnBrut[$j] = $pasEnBruts;
        // $prev_arrondis[$j] = $prev_arrondi;
        // $arrondis[$j] = $arrondi;
        // $totalNets[$j] = $totalNet;
        // print_r($allEnBrut[$j]['331'].'//');
    }


    // Get Address
    $sql = "SELECT address FROM llx_user WHERE rowid=" . $object->id;
    $res = $db->query($sql);
    $address = ((object)($res))->fetch_assoc()["address"];

    // Calcule amo + cnss
    $amo_cnss = $cnssTot + $amoTot;

    // Calcule transport + representation
    $indemTotal = $indemReprTot + $indemTransTot;

    // Get params
    $sql = "SELECT * FROM llx_Paie_bdpParameters";
    $res = $db->query($sql);
    $params = ((object)($res))->fetch_assoc();

    // Get user extra informations from database
    $sql = "SELECT situation, enfants, idpointage FROM " . MAIN_DB_PREFIX . $object->table_element . "_extrafields WHERE fk_object=" . $object->id;
    $res = $db->query($sql);
    $extrafields = ((object)($res))->fetch_assoc();
    // Get enfants
    $situation = ($extrafields["situation"] == '1') ? "MARIE" : (($extrafields["situation"] == '2') ? "CELEBATAIRE" : "DIVORCE");
    $enfants = $extrafields["enfants"] > $params["maxChildrens"] ? $params["maxChildrens"] : (int)$extrafields["enfants"];
    $chargeFamilleTaux = (($extrafields["situation"] == 1) && $object->gender == "man") ? 1 : 0;
    $chargeFamilleTaux += $enfants;

    // $sql = "SELECT sum(workingDays) as workingDays, sum(netImposable) as netImposable, sum(salaireBrut) as salaireBrut, sum(ir) as ir FROM llx_Paie_MonthDeclaration WHERE userid=$object->id AND year=$prev_year";
    // $res = $db->query($sql);
    // if ($res) {
    //     $row = $res->fetch_assoc();
    //     $TotWorkingDays = (int)$row["workingDays"];
    //     $TotNetImposable = (float)$row["netImposable"];
    //     // $comulsalaireBrut = (float)$row["salaireBrut"];
    //     $TotIR = abs((float)$row["ir"]);
    // }

    // Stor data
    $data[] = [
        'lastname' => $userstatic->lastname, 'firstname' => $userstatic->firstname, 'cin' => $userstatic->cin, 'cnss' => $cnss, 'address' => $address,
        'indemTotal' => price($indemTotal), 'brutGlobalTot' => price($brutGlobalTot), 'brutImposableTot' => price($brutGlobalTot - $indemTotal), 'taxeProTot' => price($taxeProTot),
        'amo_cnss' => price($amo_cnss), 'enfants' => $chargeFamilleTaux, 'TotNetImposable' => price($netImposableTot), 'TotIR' => price($irNetTot), 'TotWorkingdays' => $workingdaysTot
    ];

    // $data[] = ['lastname'=> $userstatic->lastname,'firstname'=> $userstatic->firstname,'cin'=> $userstatic->cin,'cnss'=>$cnss,'address'=>$address,'brutGlobalTot'=>price($brutGlobalTot),
    // 'brutImposableTot'=>price($brutImposableTot),'amo_cnss'=>price($amo_cnss),'enfants'=>$enfants,'netImposableTot'=>price($netImposableTot),
    // 'irNetTot'=>price($irNetTot),'workingdaysTot'=>$workingdaysTot];

    // print 'ID: '.$object->id.' Wokindays: '.$comulWorkingDays.' NetImposableTot: '.$comulnetImposable. ' SalaireBrutTot: ' .$comulsalaireBrut.' IRTotale: ' .$comulIR.'<br>'; 
    $i++;
}
