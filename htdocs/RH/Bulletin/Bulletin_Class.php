<?php
global $year, $month;

// les jours ferie
$joursFerie = 0;
$sql = "SELECT c.code as country_code, a.day, a.month, a.year, a.active FROM " . MAIN_DB_PREFIX . "c_hrm_public_holiday as a LEFT JOIN " . MAIN_DB_PREFIX . "c_country as c ON a.fk_country=c.rowid AND c.active=1 WHERE c.code='MA' AND a.month=$month";
$res = $db->query($sql);
while ($row = $res->fetch_assoc()) {
    if ($row['active'])
        $joursFerie++;
}

//Get Parameters from database
$sql = "SELECT * FROM llx_Paie_bdpParameters";
$res = $db->query($sql);
$params = ((object)($res))->fetch_assoc();

//Get user extra informations from database
$sql = "SELECT situation, enfants, idpointage FROM " . MAIN_DB_PREFIX . $object->table_element . "_extrafields WHERE fk_object=" . $object->id;
$res = $db->query($sql);
$extrafields = ((object)($res))->fetch_assoc();

//Get user salaire informations from database
$sql = "SELECT * from llx_Paie_UserInfo WHERE userid=" . $object->id;
$res = $db->query($sql);
if ($res->num_rows > 0) {
    $salaireParams = $res->fetch_assoc();
}

// see if it's clotured
$cloture = 0;
$sql1 = "SELECT cloture FROM llx_Paie_MonthDeclaration WHERE userid=$id AND year=$year AND month=$month";
$res1 = $db->query($sql1);
if ($res1) {
    $row1 = $res1->fetch_assoc();
    $cloture = $row1["cloture"] > 0 ? $row1["cloture"] : 0;
}
if ($cloture > 0) {
    return;
}
//peroide
$periode = '01/' . sprintf("%02d", $month) . '-' . date("t", strtotime($month . '/01/' . $year)) . '/' . sprintf("%02d", $month);
if ($cloture == 0) {

    //Rubs for declaration
    $rubs = "";

    //Get working time on this month
    $Hours = 0;
    // $sql = "SELECT e.time as ts, s.time as te FROM P_Valide v, P_ENTRER e, P_SORTIE s WHERE v.Cloturé=2 and e.id=v.IdE and s.id=v.IdS and e.userid=" . $extrafields["idpointage"] . " and MONTH(e.time)=MONTH('" . $year . "-" . $month . "-01')";
    // $res = $db->query($sql);

    // if (((object)$res)->num_rows > 0) {
    //     while ($row = ((object)$res)->fetch_assoc()) {
    //         $t1 = strtotime($row['ts']);
    //         $t2 = strtotime($row['te']);
    //         $h1 = (int)date("H", $t1);
    //         $h2 = (int)date("H", $t2);
    //         $m1 = (int)date("i", $t1);
    //         $m2 = (int)date("i", $t2);
    //         $h = $h2 - $h1;
    //         $m = $m2 - $m1;
    //         $Hours += $h + $m / 60;
    //     }
    // }
    // $Hours = round($Hours, 0);

    $situation = ($extrafields["situation"] == '1') ? "MARIE" : (($extrafields["situation"] == '2') ? "CELEBATAIRE" : "DIVORCE");
    $enfants = $extrafields["enfants"] > $params["maxChildrens"] ? $params["maxChildrens"] : (int)$extrafields["enfants"];

    $chargeFamilleTaux = (($extrafields["situation"] == 1) && $object->gender == "man") ? 1 : 0;
    $chargeFamilleTaux += $enfants;
    $chargeFamille = $chargeFamilleTaux * $params["primDenfan"];
    $rubs .= getRebrique("chargefamille") . ":chargeFamille:$chargeFamille" . ";";
    $type = $salaireParams["type"];

    //Get congé
    $sql = "SELECT date_debut, date_fin, halfday FROM llx_holiday WHERE fk_user=" . $object->id . " AND statut=3 AND ((Month(date_debut)=" . $month . " AND Year(date_debut)=" . $year . ")
        OR (Month(date_fin)=" . $month . " AND Year(date_fin)=" . $year . "))";
    $res = $db->query($sql);

    if ($res->num_rows > 0) {
        $row = ((object)($res))->fetch_assoc();
        //$congeDays = date("d", strtotime($fin) - strtotime($debut));
        $congeDays = num_open_day(strtotime($row["date_debut"]), strtotime($row["date_fin"]), 0, 1, $row["halfday"]);
    }

    $workingHours = 0;
    if ($type == 'mensuel') //Mensuel
    {
        $smig = $params["smigHoraire"] * $workingdaysdeclaré * ($params["hoursMonsuele"] / $params["workingDays"]);
        $object->salary = $object->salary < $smig ? $smig : $object->salary;

        $bases["salaire de base"] = (float)$object->salary;
        ////////////////////
        $dt = date("Y-m-d", $object->dateemployment);
        $dateemployment = explode('-', $dt)[2] . '-' . explode('-', $dt)[1] . '-' . explode('-', $dt)[0];
        $diff = date_diff(date_create($dateemployment), date_create("$year-$month-1"));
        $workingYears = $diff->format("%a") / 365;

        $Taux = $Hours / ($params["hoursMonsuele"] / $params["workingDays"]);
        $Taux = 26;
        $sql = "SELECT workingDays, joursferie FROM llx_Paie_MonthDeclaration WHERE userid=$object->id AND month=$month AND year = $year";
        $res = $db->query($sql);
        if (((object)$res)->num_rows > 0) {
            $row = ((object)$res)->fetch_assoc();
            $Taux = (float)$row["workingDays"];
            // $joursFerie = (int)$row["joursferie"];
        }

        if ($Taux > ($params["workingDays"] - $congeDays - $joursFerie)) {
            $Taux = $params["workingDays"] - $congeDays - $joursFerie;
        }

        //get working days
        $workingdays = $Taux;
        $workingdaysdeclaré = $workingdays + $congeDays;

        // calculate smig
        $bases["salaire mensuel"] = (float)(($object->salary / $params["workingDays"]) * $workingdays);
        // $bases["salaire mensuel"] = 884.69;

        $salaireHoraire = (float)($bases["salaire de base"] / $params["hoursMonsuele"]);

        $rubs .= getRebrique("salaireMensuel") . ":enBrut:" . $bases["salaire mensuel"] . ";";
    } else if ($type == 'horaire') //Journalier or Horaire
    {
        $object->thm = ($object->thm < $params["smigHoraire"]) ? $params["smigHoraire"] : $object->thm;
        $bases["salaire de base"] = (float)($object->thm * $params["hoursMonsuele"]);

        // //Get working time on all time
        // $yearHours = 0;
        // $sql = "SELECT e.time as ts, s.time as te FROM P_Valide v, P_ENTRER e, P_SORTIE s WHERE v.Cloturé=2 and e.id=v.IdE and s.id=v.IdS and e.userid=" . $extrafields["idpointage"];
        // $res = $db->query($sql);

        // if (((object)$res)->num_rows > 0) {
        //     while ($row = ((object)$res)->fetch_assoc()) {
        //         $t1 = strtotime($row['ts']);
        //         $t2 = strtotime($row['te']);
        //         $h1 = (int)date("H", $t1);
        //         $h2 = (int)date("H", $t2);
        //         $m1 = (int)date("i", $t1);
        //         $m2 = (int)date("i", $t2);
        //         $h = $h2 - $h1;
        //         $m = $m2 - $m1;
        //         $yearHours += $h + $m / 60;
        //     }
        // }

        // $yearHours = round($yearHours, 0);
        // $workingYears = $yearHours / ($params["hoursMonsuele"] * 12 + $conge);
        //$Taux = 40;
        //$salaireMonsuel = 16  * $Taux;

        $Taux = $Hours;
        $sql = "SELECT workingHours, joursferie FROM llx_Paie_MonthDeclaration WHERE userid=$object->id AND month=$month AND year = $year";
        $res = $db->query($sql);
        if (((object)$res)->num_rows > 0) {
            $row = ((object)$res)->fetch_assoc();
            $Taux = (int)$row["workingHours"];
            // $joursFerie = (int)$row["joursferie"];
        }
        if (($Taux + ($congeDays * ($params["hoursMonsuele"] / $params["workingDays"])) + ($joursFerie * ($params["hoursMonsuele"] / $params["workingDays"]))) > $params["hoursMonsuele"]) {
            $Taux = (int) ($params["hoursMonsuele"] - ($congeDays * ($params["hoursMonsuele"] / $params["workingDays"])) - ($joursFerie * ($params["hoursMonsuele"] / $params["workingDays"])));
        }
        $workingHours = $Taux;

        $yearHours = 1;
        $sql = "SELECT sum(workingHours) FROM llx_Paie_MonthDeclaration WHERE userid=$object->id";
        $res = $db->query($sql);
        if (((object)$res)->num_rows > 0) {
            $row = ((object)$res)->fetch_assoc();
            $yearHours = (int)$row["workingHours"];
        }
        $workingYears = (int)($yearHours / ($params["hoursMonsuele"] * 12 + $conge));

        //get working days
        $workingdays = $Taux  / ($params["hoursMonsuele"] / $params["workingDays"]);
        $workingdaysdeclaré = $workingdays + $congeDays + $joursFerie;
        if ($workingdaysdeclaré > ($params["workingDays"] - $congeDays - $joursFerie)) {
            $workingdaysdeclaré = $params["workingDays"] - $congeDays - $joursFerie;
        }
        $workingdaysdeclaré = round($workingdaysdeclaré);
        // calculate smig
        $bases["salaire mensuel"] = (float)($object->thm * $Taux);
        $salaireHoraire = $object->thm;

        $rubs .= getRebrique("salaireHoraire") . ":enBrut:" . $bases["salaire mensuel"] . ";";
    }

    //Get Prime D'ANCIENNETE from database by the workingYears
    $sql = "SELECT percentPrimDancien FROM llx_Paie_PrimDancienParameters WHERE (" . $workingYears . ">de and " . $workingYears . "<=a) OR (" . $workingYears . ">de and a = '+')";
    $res = $db->query($sql);
    if ($res->num_rows > 0) {
        $primeDancienPercentage = ((object)($res))->fetch_assoc()["percentPrimDancien"];
    }

    //CONGE
    $soldeConge = ($bases["salaire de base"] / $params["workingDays"]) * $congeDays;
    $soldeConge += $soldeConge * ($primeDancienPercentage / 100);
    $rubs .= getRebrique("congePaye") . ":enBrut:" . $soldeConge . ";";

    //Jours Férie
    $soldeferie = ($bases["salaire de base"] / $params["workingDays"]) * $joursFerie;
    $rubs .= getRebrique("joursferie") . ":enBrut:" . $soldeferie . ";";


    //Les hours supp
    $soldeHoursSup = 0;
    $hrs = array();
    $sql = "SELECT h.rub, h.designation, h.percentHourSupp, d.nhours FROM llx_Paie_HourSupp h, llx_Paie_HourSuppDeclaration d WHERE h.rub=d.rub AND d.userid=$object->id AND d.year=$year AND d.month=$month";
    $res = $db->query($sql);
    if ($res->num_rows > 0) {
        while ($hr = ((object)($res))->fetch_assoc()) {
            $rub = $hr["rub"];
            $designation = $hr["designation"];
            $percentage = $hr["percentHourSupp"] + 100;
            $nhours = $hr["nhours"];
            $apayer = $salaireHoraire * $nhours * $percentage / 100;

            $soldeHoursSup += $apayer;

            if ($apayer > 0) {
                $hrs[] = array("rub" => $rub, "designation" => $designation, "nombre" => $nhours, "base" => $salaireHoraire, "taux" => $percentage, "apayer" => $apayer, "aretenu" => "");
                $rubs .= "$rub:enBrut:$apayer" . ";";
            }
        }
    }

    //PRIME D'ANCIEN
    $bases['primeDancien'] = $bases["salaire mensuel"] + $soldeConge + $soldeferie + $soldeHoursSup;
    $primeDancien = $primeDancienPercentage * $bases['primeDancien'] / 100;
    $rubs .= getRebrique("primeDancien") . ":enBrut:" . $primeDancien . ";";

    //Les Bruts
    $brutGlobal = $bases["salaire mensuel"] + $primeDancien + $soldeConge + $soldeferie + $soldeHoursSup;
    $brutImposable = $brutGlobal;

    //print sizeof($hrs);

    $enBruts = array();
    $totalRetenu = 0;
    $retenueFromBrut = 0;


    //Get les rubriques en brut global
    $sql = "SELECT * FROM llx_Paie_Rub WHERE enBrut=1";
    $res = $db->query($sql);
    if ($res->num_rows > 0) {
        while ($param = ((object)($res))->fetch_assoc()) {
            $apayer = 0;
            $aretenu = 0;
            //if it's prime or indemnite add from fiche emploiyee
            if ($param["auFiche"]) {
                //get value of it
                $sql = "SELECT amount, checked FROM llx_Paie_UserParameters  WHERE rub=" . $param['rub'] . " AND userid=$object->id";
                $resFiche = $db->query($sql);
                if ($resFiche->num_rows > 0) {
                    $fiche = $resFiche->fetch_assoc();
                    //if it's calculable
                    if ($param["calcule"] == 1 && $fiche["checked"] == 1) {
                        $base = $bases[$param["base"]];
                        $Tauxr = $param["percentage"] . "%";
                        $apayer = (float)($base * $param["percentage"] / 100);
                        if ($param["plafonne"] == 1) {
                            $base = ($apayer > $param["plafond"]) ? $param["plafond"] / $param["percentage"] * 100 : $base;
                        }
                        $apayer = (float)($base * $param["percentage"] / 100);
                    } else {
                        $base = "";
                        $Tauxr = "";
                        if ($param["rub"] == 5) {
                            $aretenu = (float)$fiche["amount"];
                            $retenueFromBrut += $aretenu;
                        } else {
                            $apayer = (float)$fiche["amount"];
                        }
                    }
                    //if it's depend to working days
                    if ($param["enJours"] == 1) {
                        if ($param["avecConge"] == 1) {
                            $apayer *= $workingdaysdeclaré / $params["workingDays"];
                            $base = (float)$fiche["amount"];
                            $Tauxr = $workingdaysdeclaré;
                        } else {
                            $apayer *= $workingdays / $params["workingDays"];
                            $base = (float)$fiche["amount"];
                            $Tauxr = $workingdays;
                        }
                    }
                    if ($fiche["checked"] == 1 || $fiche["amount"] > 0) {
                        if ($param["rub"] == 5) {
                            $rubs .= $param["rub"] . ":enBrut:$aretenu" . ";";
                        } else {
                            $rubs .= $param["rub"] . ":enBrut:$apayer" . ";";
                        }
                        $enBruts[] = array("rub" => $param["rub"], "designation" => $param["designation"], "nombre" => "", "base" => $base, "taux" => $Tauxr, "apayer" => $apayer, "aretenu" => $aretenu, "surbulletin" => $param["surBulletin"]);
                    }
                }
            } else {
                //if it's calculable
                if ($param["calcule"] == 1) {
                    $base = $bases[$param["base"]];
                    $Tauxr = $param["percentage"] . "%";
                    //$apayer = (float)($base * $param["percentage"] / 100);
                    $apayer = $param["percentage"] / 100 * 5;
                    if ($param["plafonne"] == 1) {
                        $base = ($apayer > $param["plafond"]) ? $param["plafond"] / $param["percentage"] * 100 : $base;
                    }
                    //$base = 14.81;
                    $apayer = (float)($base / 191 * $param["percentage"] / 100 * 5);
                } else {
                    $apayer = (float)$fiche["amount"];
                }

                $enBruts[] = array("rub" => $param["rub"], "designation" => $param["designation"], "nombre" => "5", "base" => $base / 191, "taux" => $Tauxr, "apayer" => $apayer, "aretenu" => "", "surbulletin" => $param["surBulletin"]);
                $rubs .= $param["rub"] . ":enBrut:$apayer" . ";";
            }
            $brutGlobal += $apayer;
            if ($param["imposable"] == 1) {
                if ($param["partiel"] == 1) {
                    $brutImposable += ($apayer > $param["maxFree"]) ? $apayer - $param["maxFree"] : 0;
                } else {
                    $brutImposable += $apayer;
                }
            }
        }
    }

    $role = "";
    //Get role of user and set prime commmercial
    $sql = "SELECT rolec FROM " . MAIN_DB_PREFIX . "user_extrafields WHERE fk_object = $object->id";
    $res = $db->query($sql);
    if ($res)
        $rolec = $res->fetch_assoc()["rolec"];
    switch ($rolec) {
        case 1: {
                $role = "Commercial";
                $sql = "SELECT sum(total) as total FROM llx_facture WHERE fk_user_author=$object->id AND MONTH(date_closing)=$month AND YEAR(date_closing)=" . $year . " AND paye=1";
                $res = $db->query($sql);
                if ($res) {
                    $CA = (float)$res->fetch_assoc()['total'];
                }

                $sql = "SELECT percent FROM llx_Paie_Commerce_Prime WHERE userId=$object->id AND YEAR=$year AND ((min<=$CA AND max>=$CA) OR (min<=$CA AND max='+'))";
                $res = $db->query($sql);
                if ($res->num_rows > 0) {
                    $percent = (float)$res->fetch_assoc()['percent'];
                }

                $primeCommercial = $CA * $percent / 100;
                $brutImposable += $primeCommercial;
                $brutGlobal += $primeCommercial;
                break;
            }

        case 2:
            $role = "Technicien";
            break;
        case 3:
            $role = "Admin Résaux";
            break;
        case 4:
            $role = "Pentesteur";
            break;
        case 5:
            $role = "Administratif";
            break;
        default:
            $role = "";
    }


    $brutImposable -= $retenueFromBrut;
    $brutGlobal -= $retenueFromBrut;

    $bases["salaire brut imposable"] = $brutImposable;

    $netImposable = $brutImposable;

    $cotisations = array();
    $totalCotisations = 0;
    //Get les rubriques cotisations
    $sql = "SELECT * FROM llx_Paie_Rub WHERE cotisation=1";
    $res = $db->query($sql);
    if ($res->num_rows > 0) {
        while ($param = ((object)($res))->fetch_assoc()) {

            if ($param["auFiche"]  == 1) {
                $sql1 = "SELECT checked FROM llx_Paie_UserParameters WHERE rub=" . $param["rub"] . " AND userid=" . $object->id;
                $res1 = $db->query($sql1);
                $checked = ((object)($res1))->fetch_assoc()["checked"];
                if ($checked != 1)
                    continue;
            }
            //if it's calculable
            $base = $bases[$param["base"]];
            $Tauxr = $param["percentage"] . "%";

            $aretenu = (float)($base * $param["percentage"] / 100);
            if ($param["plafonne"] == 1) {
                $base = ($aretenu > $param["plafond"]) ? $param["plafond"] / $param["percentage"] * 100 : $base;
            }
            $aretenu = (float)($base * $param["percentage"] / 100);
            $totalCotisations += $aretenu;

            $cotisations[] = array("rub" => $param["rub"], "designation" => $param["designation"], "nombre" => $brutImposable, "base" => $base, "taux" => $Tauxr, "apayer" => "", "aretenu" => $aretenu, "surbulletin" => $param["surBulletin"]);
            $rubs .= $param["rub"] . ":cotisation:" . ($aretenu * -1) . ";";


            if ($param["surBulletin"]) {
                $totalRetenu += $aretenu;
            }

            if ($param["enNetImposable"]) {
                $netImposable -= $aretenu;
            }
        }
    }

    // Les cumule
    $sql = "SELECT sum(workingDays) as workingDays, sum(netImposable) as netImposable, sum(salaireBrut) as salaireBrut, sum(ir) as ir FROM llx_Paie_MonthDeclaration WHERE userid=$object->id AND year=$year AND month<$month";
    $res = $db->query($sql);
    if ($res) {
        $row = $res->fetch_assoc();
        $comulWorkingDays = (float)$row["workingDays"];
        $comulnetImposable = (float)$row["netImposable"];
        $comulsalaireBrut = (float)$row["salaireBrut"];
        $comulIR = (float)$row["ir"];
    }

    //Get IR from database by the netImposable
    $irbase = 0;
    if (($comulWorkingDays + $workingdaysdeclaré) != 0) {
        $irbase = (($comulnetImposable + $netImposable) * ($params["workingDays"] * 12)) / ($comulWorkingDays + $workingdaysdeclaré);
    }
    $irbase = ($irbase > 0) ? $irbase : 0;

    $sql = "SELECT percentIR, deduction FROM llx_Paie_IRParameters WHERE (" . $irbase . ">=irmin and " . $irbase . "<=irmax) OR (" . $irbase . ">=irmin and irmax = '+')";
    $res = $db->query($sql);
    $ir = ((object)($res))->fetch_assoc();

    $irBrut = $ir['percentIR'] * $irbase / 100 - $ir['deduction'];
    $irNet = ($irBrut > $chargeFamille) ? $irBrut - $chargeFamille * 12 : 0;

    $irNet = $irNet / ($params["workingDays"] * 12) * ($comulWorkingDays + $workingdaysdeclaré);
    $irNet = $irNet - $comulIR;

    $totalRetenu += $irNet + $avanceSurSalaire;
    $totalBrut = $brutGlobal;

    //Get les rubriques pas en brut global et non imposable
    $pasEnBruts = array();
    $aretenu = 0;
    $sql = "SELECT * FROM llx_Paie_Rub WHERE enBrut!=1 AND cotisation!=1 AND imposable!=1";
    $res = $db->query($sql);
    if ($res->num_rows > 0) {
        while ($param = ((object)($res))->fetch_assoc()) {
            $apayer = 0;
            //if it's prime or indemnite add from fiche emploiyee
            if ($param["auFiche"]) {
                //get value of it
                $sql = "SELECT amount, checked FROM llx_Paie_UserParameters  WHERE rub=" . $param['rub'] . " AND userid=$object->id";
                $resFiche = $db->query($sql);
                if ($resFiche->num_rows > 0) {
                    $fiche = $resFiche->fetch_assoc();
                    //if it's calculable
                    if ($param["calcule"] == 1 && $fiche["checked"] == 1) {
                        $base = $bases[$param["base"]];
                        $Tauxr = $param["percentage"] . "%";
                        $apayer = (float)($base * $param["percentage"] / 100);
                        if ($param["plafonne"] == 1) {
                            $base = ($apayer > $param["plafond"]) ? $param["plafond"] / $param["percentage"] * 100 : $base;
                        }
                        $apayer = (float)($base * $param["percentage"] / 100);
                    } else {
                        $base = "";
                        $Tauxr = "";
                        $apayer = (float)$fiche["amount"];
                    }
                    //if it's depend to working days
                    if ($param["enJours"] == 1) {
                        if ($param["avecConge"] == 1) {
                            $apayer *= $workingdaysdeclaré / $params["workingDays"];
                        } else {
                            $apayer *= $workingdays / $params["workingDays"];
                        }
                    }
                    if ($fiche["checked"] == 1 || $fiche["amount"] > 0) {
                        if ($param["rub"] == '902') {
                            $aretenu = $apayer;
                            $apayer = 0;
                            $rubs .= $param["rub"] . ":pasEnBrut:$aretenu" . ";";
                            $pasEnBruts[] = array("rub" => $param["rub"], "designation" => $param["designation"], "nombre" => "", "base" => $base, "taux" => $Tauxr, "apayer" => "", "aretenu" => $aretenu, "surbulletin" => $param["surBulletin"]);
                        } else {
                            $rubs .= $param["rub"] . ":pasEnBrut:$apayer" . ";";
                            $pasEnBruts[] = array("rub" => $param["rub"], "designation" => $param["designation"], "nombre" => "", "base" => $base, "taux" => $Tauxr, "apayer" => $apayer, "aretenu" => "", "surbulletin" => $param["surBulletin"]);
                        }
                    }
                }
            } else {
                //if it's calculable
                if ($param["calcule"] == 1) {
                    $base = $bases[$param["base"]];
                    $Tauxr = $param["percentage"] . "%";
                    $apayer = (float)($base * $param["percentage"] / 100);
                    if ($param["plafonne"] == 1) {
                        $base = ($apayer > $param["plafond"]) ? $param["plafond"] / $param["percentage"] * 100 : $base;
                    }
                    $apayer = (float)($base * $param["percentage"] / 100);
                    $pasEnBruts[] = array("rub" => $param["rub"], "designation" => $param["designation"], "nombre" => "", "base" => $base, "taux" => $Tauxr, "apayer" => $apayer, "aretenu" => "", "surbulletin" => $param["surBulletin"]);
                    $rubs .= $param["rub"] . ":pasEnBrut:$apayer" . ";";
                }
            }
            $totalBrut += $apayer;
            $totalRetenu += $aretenu;
        }
    }



    $totalNet = $totalBrut - $totalRetenu;

    //declare brut global
    $rubs .= " :brutGlobal:" . $brutGlobal . ";";


    //Inset data to month declaration table
    $sql = "REPLACE INTO llx_Paie_MonthDeclaration(userid, year, month, workingDays, workingHours, joursferie, netImposable, salaireBrut, salaireNet, ir, cloture ) VALUES($object->id, $year, $month, $workingdaysdeclaré, $workingHours, $joursFerie, $netImposable, $brutImposable, $totalNet, $irNet, $cloture);";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    $sql = "REPLACE INTO llx_Paie_MonthDeclarationRubs(userid, year, month, type, post, situationFamiliale, enfants, salaireDeBase, salaireMensuel, salaireHoraire, rubs) VALUES($object->id, $year, $month, '$type', '$object->job', '$situation', $enfants, " . $bases["salaire de base"] . ", " . $bases["salaire mensuel"] . ", $salaireHoraire, '$rubs');";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);
} else {
    $sql = "SELECT * FROM llx_Paie_MonthDeclaration m, llx_Paie_MonthDeclarationRubs r WHERE r.userid=m.userid AND r.month=m.month AND r.year = m.year AND m.userid=$object->id AND m.month=$month AND m.year = $year";
    $res = $db->query($sql);
    if (((object)$res)->num_rows > 0) {
        $row = $res->fetch_assoc();
        $situation = $row["situationFamiliale"];
        $type = $row["type"];
        $role = $row["post"];
        $joursFerie = (int)$row["joursferie"];
        $bases["salaire de base"] = $row["salaireDeBase"];
        $bases["salaire mensuel"] = $row["salaireMensuel"];
        $brutGlobal = $bases["salaire mensuel"];
        $rubs = $row["rubs"];

        $enBruts[] = array();
        $i = 0;

        foreach (explode(";", $rubs) as $r) {
            //print $rub."<br>";
            $rub = explode(":", $r);
            $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=" . $rub[0];
            $res = $db->query($sql);
            if ($res->num_rows == 0) {
                $sql = "SELECT * FROM llx_Paie_HourSupp WHERE rub=" . $rub[0];
                $res = $db->query($sql);
            }
            if ($res->num_rows == 0) {
                $sql = "SELECT * FROM llx_Paie_Rubriques WHERE rub=" . $rub[0];
                $res = $db->query($sql);
            }
            if ($res->num_rows > 0 && $rub[2] > 0) {
                $param = $res->fetch_assoc();

                if ($rub[1] == "enBrut") {
                    $brutGlobal += $rub[2];
                    $apayer = $rub[2];
                    $enBruts[] = array("rub" => $param["rub"], "designation" => strtoupper($param["designation"]), "nombre" => "", "base" => $base, "taux" => $Tauxr, "apayer" => $apayer, "aretenu" => "", "surbulletin" => $param["surBulletin"]);
                }
            }
        }
    }
}



//Les compte comptable
function getRebrique($name)
{
    global $db;
    $sql = "SELECT rub FROM llx_Paie_Rubriques WHERE name = '$name'";
    $res = $db->query($sql);
    if ($res) {
        $row = ((object)$res)->fetch_assoc();
    } else
        print("<br>fail ERR: " . $sql);

    return $row["rub"];
}
