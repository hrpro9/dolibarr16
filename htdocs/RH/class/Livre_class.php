<?php
$french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');

for ($j = $start; $j < $start + 6; $j++) {
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

    $sql1 = "SELECT fk_user FROM IG_payment_salary WHERE fk_user=" . $object->id . " AND year(datep)=" . $prev_year . " AND month(datep)=" . $prev_month;
    $res1 = $db->query($sql1);
    if ($res1->num_rows == 0) {
        continue;
    }
    // see if it's clotured
    $cloture = 0;
    $sql1 = "SELECT cloture FROM IG_Paie_MonthDeclaration WHERE userid=$object->id AND year=$prev_year AND month=$prev_month";
    $res1 = $db->query($sql1);
    if ($res1) {
        $row1 = $res1->fetch_assoc();
        $cloture = $row1["cloture"] > 0 ? $row1["cloture"] : 0;
    }
    if ($cloture == 0) {
        continue;
    }

    //Get Parameters from database
    $sql = "SELECT * FROM IG_Paie_bdpParameters";
    $res = $db->query($sql);
    $params = ((object)($res))->fetch_assoc();

    //Get user extra informations from database
    $sql = "SELECT situation, enfants, idpointage FROM " . MAIN_DB_PREFIX . $object->table_element . "_extrafields WHERE fk_object=" . $object->id;
    $res = $db->query($sql);
    $extrafields = ((object)($res))->fetch_assoc();

    $cnss = "";
    //Get user salaire informations from database
    $sql = "SELECT cnss from IG_Paie_UserInfo WHERE userid=" . $object->id;
    $res = $db->query($sql);
    if (((object)$res)->num_rows > 0) {
        $cnss = ((object)$res)->fetch_assoc()["cnss"];
    }

    $sql = "SELECT * FROM  IG_Paie_MonthDeclaration m, IG_Paie_MonthDeclarationRubs r 
                WHERE r.userid=m.userid AND r.month=m.month AND r.year = m.year 
                AND m.userid=$object->id AND m.month=$prev_month AND m.year = $prev_year";
    $res = $db->query($sql);
    if (((object)$res)->num_rows > 0) {
        $row = $res->fetch_assoc();

        $workingdaysdeclaré = (int)$row["workingDays"];
        $netImposable = (float)$row["netImposable"];
        $brutImposable = (float)$row["salaireBrut"];
        $irNet = (float)$row["ir"];
        $totalNet = (float)$row["salaireNet"];

        $situation = $row["situationFamiliale"];
        $type = $row["type"];
        $role = $row["post"];
        $joursFerie = (int)$row["joursferie"];
        $bases["salaire de base"] = $row["salaireDeBase"];
        $bases["salaire mensuel"] = $row["salaireMensuel"];
        $salaireHoraire = $row["salaireHoraire"];
        $enfants = $bases["enfants"];
        $rubs = $row["rubs"];

        foreach (explode(";", $rubs) as $r) {
            //print $rub."<br>";
            $rub = explode(":", $r);
            $sql = "SELECT * FROM IG_Paie_Rub WHERE rub=" . $rub[0];
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

            if ($res->num_rows == 0) {
                $sql = "SELECT * FROM IG_Paie_HourSupp WHERE rub=" . $rub[0];
                $res = $db->query($sql);
            }
            if ($res->num_rows == 0) {
                $sql = "SELECT * FROM IG_Paie_Rubriques WHERE rub=" . $rub[0];
                $res = $db->query($sql);
            }
            if ($res->num_rows > 0 && $rub[2] != 0) {
                $param = $res->fetch_assoc();

                if ($rub[1] == "enBrut") {
                    $apayer = $rub[2];
                    $enBrutsRubs[$rub[0]] = array("rub" => $rub[0], "designation" => $param["designation"]);
                    $enBruts[$rub[0]] = $apayer;
                } else if ($rub[1] == "cotisation") {
                    $aretenu = $rub[2];
                    $cotisationsRubs[$rub[0]] = array("rub" => $rub[0], "designation" => $param["designation"]);
                    $cotisations[$rub[0]] = $aretenu;
                } else if ($rub[1] == "pasEnBrut") {
                    $apayer = $rub[2];
                    $pasEnBrutRubs[$rub[0]] = array("rub" => $rub[0], "designation" => $param["designation"]);
                    $pasEnBruts[$rub[0]] = $apayer;
                }
            }
        }
    }

    $workingdaysdeclarés[$j] = $workingdaysdeclaré; //
    $salaireMonsuels[$j] = $bases["salaire mensuel"]; //
    $primeDanciens[$j] = $primeDancien;
    $soldeConges[$j] = $soldeConge;
    $allEnBrut[$j] = $enBruts;
    $primeCommercials[$j] = $primeCommercial;
    $salaireBruts[$j] = $brutGlobal;
    $allCotisations[$j] = $cotisations;

    $netImposables[$j] = $netImposable; //
    $chargeFamilles[$j] = $chargeFamille;
    $irNets[$j] = $irNet * -1; //
    $allPasEnBrut[$j] = $pasEnBruts;
    $prev_arrondis[$j] = $prev_arrondi;
    $arrondis[$j] = $arrondi;
    $totalNets[$j] = $totalNet;
}
