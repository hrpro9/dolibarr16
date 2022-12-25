<?php



$i = 0;
$result = $db->query($sql0);
if ($result) {
    $nbtotalofrecords = $db->num_rows($result);
}

$result = $db->query($sql0);
if (!$result) {
    dol_print_error($db);
    exit;
}

$num = $db->num_rows($result);

if ($num == 1 && !empty($conf->global->MAIN_SEARCH_DIRECT_OPEN_IF_ONLY_ONE) && $sall) {
    $obj = $db->fetch_object($resql);
    $id = $obj->rowid;
    header("Location: " . DOL_URL_ROOT . '/user/card.php?id=' . $id);
    exit;
}

$salaireMonsuelTot = 0;
$salaireHoraireTot = 0;
$primeDancienTot = 0;
$soldeCongeTot = 0;
$brutGlobalTot = 0;
$enBruts = array();
$cotisations = array();
$pasEnBruts = array();
$workingdaysdeclaréTot = 0;
$netImposableTot = 0;
$chargeFamilleTot = 0;
$irNetTot  = 0;
$prev_arrondiTot = 0;
$arrondiTot  = 0;
$totalNetTot = 0;

while ($i < $num) {
    $Taux = 0;
    $workingdaysdeclaré = 0;
    $congeDays = 0;

    $obj = $db->fetch_object($result);
    //$sql2="SELECT ex.name FROM " . MAIN_DB_PREFIX . "extrafields as ex LEFT JOIN " . MAIN_DB_PREFIX . "user_extrafields as eu on ex.rowid=eu.fk"

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

    $object->fetch($obj->rowid);

    $sql1 = "SELECT fk_user FROM " . MAIN_DB_PREFIX . "payment_salary WHERE fk_user=" . $obj->rowid . " AND year(datep)=" . $prev_year . " AND month(datep)=" . $prev_month;
    $res1 = $db->query($sql1);
    if ($res1->num_rows == 0) {
        $i++;
        continue;
    }

    // see if it's clotured
    $cloture = 0;
    $sql1 = "SELECT cloture FROM " . MAIN_DB_PREFIX . "Paie_MonthDeclaration WHERE userid=$obj->rowid AND year=$prev_year AND month=$prev_month";
    $res1 = $db->query($sql1);
    if ($res1) {
        $row1 = $res1->fetch_assoc();
        $cloture = $row1["cloture"] > 0 ? $row1["cloture"] : 0;
    }
    if ($cloture == 0) {
        $i++;
        continue;
    }

    /*************************************** ******************************************
     * ********************************** 
     * Get salary informations of all emploiyes
     */

    //Get Parameters from database
    $sql = "SELECT * FROM " . MAIN_DB_PREFIX . "Paie_bdpParameters";
    $res = $db->query($sql);
    $params = ((object)($res))->fetch_assoc();

    //Get user extra informations from database
    $sql = "SELECT situation, enfants, idpointage FROM " . MAIN_DB_PREFIX . $object->table_element . "_extrafields WHERE fk_object=" . $object->id;
    $res = $db->query($sql);
    if ($res->num_rows > 0)
        $extrafields = ((object)($res))->fetch_assoc();

    $sql = "SELECT * FROM " . MAIN_DB_PREFIX . "Paie_MonthDeclaration m, " . MAIN_DB_PREFIX . "Paie_MonthDeclarationRubs r WHERE r.userid=m.userid AND r.month=m.month AND r.year = m.year AND m.userid=$object->id AND m.month=$prev_month AND m.year = $prev_year";
    $res = $db->query($sql);
    if (((object)$res)->num_rows > 0) {
        $row = $res->fetch_assoc();

        $workingdaysdeclaré = (int)$row["workingDays"];
        $workingdaysdeclaréTot += $workingdaysdeclaré;
        $netImposable = (float)$row["netImposable"];
        $netImposableTot += $netImposable;
        $brutImposable = (float)$row["salaireBrut"];
        $irNet = (float)$row["ir"];
        $irNetTot += $irNet;
        $totalNet = (float)$row["salaireNet"];
        $totalNetTot += $totalNet;

        $situation = $row["situationFamiliale"];
        $type = $row["type"];
        $role = $row["post"];
        $joursFerie = (int)$row["joursferie"];
        $bases["salaire de base"] = $row["salaireDeBase"];
        $bases["salaire mensuel"] = $row["salaireMensuel"];
        $salaireMonsuelTot += $bases["salaire mensuel"];
        $salaireHoraire = $row["salaireHoraire"];
        $salaireHoraireTot += $salaireHoraire;

        $rubs = $row["rubs"];

        foreach (explode(";", $rubs) as $r) {
            //print $rub."<br>";
            $rub = explode(":", $r);
            $sql = "SELECT * FROM " . MAIN_DB_PREFIX . "Paie_Rub WHERE rub=" . $rub[0];
            $res = $db->query($sql);
            if ($rub[1] == "brutGlobal") {
                $brutGlobal = $rub[2];
                $brutGlobalTot += $brutGlobal;
            }
            if ($rub[1] == "arrondiPrecdent") {
                $prev_arrondi = $rub[2];
                $prev_arrondiTot += $prev_arrondi;
            }
            if ($rub[1] == "arrondiEnCours") {
                $arrondi = $rub[2];
                $arrondiTot += $arrondi;
            }
            if ($rub[1] == "chargeFamille") {
                $chargeFamille = $rub[2];
                $chargeFamilleTot += $chargeFamille;
            }
            if ($res->num_rows == 0) {
                $sql = "SELECT * FROM " . MAIN_DB_PREFIX . "Paie_HourSupp WHERE rub=" . $rub[0];
                $res = $db->query($sql);
            }
            if ($res->num_rows == 0) {
                $sql = "SELECT * FROM " . MAIN_DB_PREFIX . "Paie_Rubriques WHERE rub=" . $rub[0];
                $res = $db->query($sql);
            }
            if ($res->num_rows > 0 && $rub[2] != 0) {
                $param = $res->fetch_assoc();

                if ($rub[1] == "enBrut") {
                    $apayer = $rub[2];
                    $enBrutsRubs[$rub[0]] = array("rub" => $rub[0], "designation" => $param["designation"]);
                    $enBruts[$rub[0]] += $apayer;
                } else if ($rub[1] == "cotisation") {
                    $aretenu = $rub[2];
                    $cotisationsRubs[$rub[0]] = array("rub" => $rub[0], "designation" => $param["designation"]);
                    $cotisations[$rub[0]] += $aretenu;
                } else if ($rub[1] == "pasEnBrut") {
                    $apayer = $rub[2];
                    $pasEnBrutRubs[$rub[0]] = array("rub" => $rub[0], "designation" => $param["designation"]);
                    $pasEnBruts[$rub[0]] += $apayer;
                }
            }
        }
    }

    $i++;
}

asort($enBrutsRubs);
asort($pasEnBrutRubs);
asort($cotisationsRubs);
