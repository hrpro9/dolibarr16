<?php

// Load Dolibarr environmend
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';

if (!$user->admin) {
    accessforbidden('you are not an administrator');
}

llxHeader("", "Paramétrage Bulletin de Paie");
$text = "Paramétrage";
print_barre_liste($text, $page, $_SERVER["PHP_SELF"], $param, $sortfield, $sortorder, "", $num, $nbtotalofrecords, 'setup', 0, $morehtmlright . ' ' . $newcardbutton, '', 0, 0, 1);


$action = GETPOST('action', 'alpha');


$rubriques = array(
    array("Salaire mensuel", "salaireMensuel"),
    array("Salaire horaire", "salaireHoraire"),
    array("PRIME D\'ANCIENNETE", "primeDancien"),
    array("CONGE PAYE", "congePaye"),
    array("SALAIRE NET IMPOSABLE	", "netImposable"),
    array("CHARGE DE FAMILLE", "chargefamille"),
    array("IR", "ir"),
    array("Prime commercial", "primeCommercial"),
    array("Frait de Transport", "fraitTransport"),
    array("Les jours férie", "joursferie"),
);

if ($action == 'delete') {
    $rub = (int)GETPOST("rub", "int");
    $sql = "DELETE FROM llx_Paie_Rub WHERE rub=$rub";
    $res = $db->query($sql);
    if (!$res)
        print "ERROR : $sql";
}
if ($action == 'editRub') {
    $rub = GETPOST("rub", 'int');
    $newRub = GETPOST("rubrique", 'int');
    $designation = GETPOST("designation", 'alpha');
    $codeComptable = GETPOST("codeComptable", 'int');
    $cotisation = (GETPOST("cotisation", 'alpha') == "oui") ? "1" : "0";
    $calcule = (GETPOST("calcule", 'alpha') == "oui") ? "1" : "0";
    $base = $db->escape(GETPOST("base", 'alpha'));
    $percentage = (float)GETPOST("percentage", 'float');
    $maxFree = (float)GETPOST("maxFree", 'float');
    $imposable = (GETPOST("imposable", 'alpha') == "oui") ? "1" : "0";
    $partiel = (GETPOST("partiel", 'alpha') == "oui") ? "1" : "0";
    $plafonne = (GETPOST("plafonne", 'alpha') == "oui") ? "1" : "0";
    $plafond = (float)GETPOST("plafond", 'float');
    $enBrut = (GETPOST("enBrutGlobal", 'alpha') == "oui") ? "1" : "0";
    $enJours = (GETPOST("enJours", 'alpha') == "oui") ? "1" : "0";
    $avecConge = (GETPOST("avecConge", 'alpha') == "1") ? "1" : "0";
    $auFiche = (GETPOST("auFiche", 'alpha') == "oui") ? "1" : "0";
    $surBulletin = (GETPOST("surBulletin", 'alpha') == "oui") ? "1" : "0";
    $enNetImposable = (GETPOST("enNetImposable", 'alpha') == "oui") ? "1" : "0";
    $reset = (GETPOST("reset", 'alpha') == "oui") ? "1" : "0";
    $importable = (GETPOST("importable", 'alpha') == "oui") ? "1" : "0";
    $sql = "UPDATE llx_Paie_Rub SET cotisation='$cotisation', calcule='$calcule', base='$base', percentage='$percentage', enNetImposable='$enNetImposable', surBulletin=$surBulletin, plafonne='$plafonne', plafond='$plafond', auFiche='$auFiche', enBrut='$enBrut', enJours='$enJours', avecConge='$avecConge', imposable='$imposable', partiel='$partiel', maxFree='$maxFree', designation='$designation', codeComptable='$codeComptable', reset='$reset', importable='$importable', rub='$newRub' where rub = $rub";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);
}
if ($action == 'addRub') {
    // $sql = "CREATE TABLE IF NOT EXISTS llx_Paie_Rub(rub INT PRIMARY KEY, designation VARCHAR(50), codeComptable INT, cotisation BOOLEAN, calcule BOOLEAN, base varchar(50), percentage float,
    //             imposable BOOLEAN, partiel BOOLEAN, maxFree float, plafonne BOOLEAN, plafond float, enBrut BOOLEAN, enJours BOOLEAN, avecConge BOOLEAN, auFiche BOOLEAN, surBulletin BOOLEAN, 
    //             enNetImposable BOOLEAN);";
    // $res = $db->query($sql);
    // if ($res);
    // else print("<br>fail ERR: " . $sql);
    $rubrique = GETPOST("rubrique", 'int');
    $designation = GETPOST("designation", 'alpha');
    $codeComptable = GETPOST("codeComptable", 'int');
    $cotisation = (GETPOST("cotisation", 'alpha') == "oui") ? "1" : "0";
    $calcule = (GETPOST("calcule", 'alpha') == "oui") ? "1" : "0";
    $base = $db->escape(GETPOST("base", 'alpha'));
    $percentage = (float)GETPOST("percentage", 'float');
    $maxFree = (float)GETPOST("maxFree", 'float');
    $imposable = (GETPOST("imposable", 'alpha') == "oui") ? "1" : "0";
    $partiel = (GETPOST("partiel", 'alpha') == "oui") ? "1" : "0";
    $plafonne = (GETPOST("plafonne", 'alpha') == "oui") ? "1" : "0";
    $plafond = (float)GETPOST("plafond", 'float');
    $enBrut = (GETPOST("enBrutGlobal", 'alpha') == "oui") ? "1" : "0";
    $enJours = (GETPOST("enJours", 'alpha') == "oui") ? "1" : "0";
    $avecConge = (GETPOST("avecConge", 'alpha') == "1") ? "1" : "0";
    $auFiche = (GETPOST("auFiche", 'alpha') == "oui") ? "1" : "0";
    $surBulletin = (GETPOST("surBulletin", 'alpha') == "oui") ? "1" : "0";
    $enNetImposable = (GETPOST("enNetImposable", 'alpha') == "oui") ? "1" : "0";
    $reset = (GETPOST("reset", 'alpha') == "oui") ? "1" : "0";
    $importable = (GETPOST("importable", 'alpha') == "oui") ? "1" : "0";
    $sql = "INSERT INTO llx_Paie_Rub (rub, cotisation, calcule, base, percentage, enNetImposable, surBulletin, plafonne, plafond, enBrut, enJours, avecConge, imposable, partiel, maxFree, designation, codeComptable, auFiche, reset, importable) VALUES ('$rubrique', '$cotisation', '$calcule', '$base', '$percentage', '$enNetImposable', '$surBulletin', '$plafonne', '$plafond', '$enBrut', '$enJours', '$avecConge', '$imposable', '$partiel', '$maxFree', '$designation', '$codeComptable', '$auFiche', '$reset', '$importable');";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);
}

if ($action == 'save') {

    $sql = "CREATE TABLE IF NOT EXISTS llx_Paie_bdpParameters(id int PRIMARY KEY, maxChildrens int, primDenfan float, smigHoraire float, hoursMonsuele int, workingDays float);";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    $sql = "CREATE TABLE IF NOT EXISTS llx_Paie_IRParameters(id int PRIMARY KEY, irmin float, irmax varchar(10), percentIR float, deduction float);";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    $sql = "CREATE TABLE IF NOT EXISTS llx_Paie_PrimDancienParameters(id int PRIMARY KEY, de float, a varchar(10), percentPrimDancien float);";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    $sql = "CREATE TABLE IF NOT EXISTS llx_Paie_HourSupp(rub INT PRiMARY KEY, designation VARCHAR(50), codeComptable int, percentHourSupp float);";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    $sql = "CREATE TABLE IF NOT EXISTS llx_Paie_Rubriques(rub INT PRiMARY KEY, designation VARCHAR(50), name VARCHAR(50) UNIQUE, codeComptable int);";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    $cnss = (float)GETPOST("cnss", 'float');
    $amo = (float)GETPOST("amo", 'float');
    $fp = (float)GETPOST("fp", 'float');
    $maxCNSS = (float)GETPOST("maxCNSS", 'float');
    $maxFraitPro = (float)GETPOST("maxFraitPro", 'float');
    $maxFreeTransport = (float)GETPOST("maxFreeTransport", 'float');
    $maxChildrens = (int)GETPOST("maxChildrens", 'int');
    $primDenfan = (int)GETPOST("primDenfan", 'int');
    $smigHoraire = (float)GETPOST("smigHoraire", 'float');
    $hoursMonsuele = (int)GETPOST("hoursMonsuele", 'int');
    $workingDays = (float)GETPOST("workingDays", 'float');
    $patronaleCnss = (float)GETPOST("patronaleCnss", 'float');
    $patronaleAmo = (float)GETPOST("patronaleAmo", 'float');
    $TaxFormationPro = (float)GETPOST("TaxFormationPro", 'float');
    $prestationFamilial = (float)GETPOST("prestationFamilial", 'float');



    // Get data of IRs
    $sql = "DELETE FROM llx_Paie_IRParameters";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);
    $lenghtIR = (int)GETPOST("lenghtIR", 'int');
    for ($i = 1; $i <= $lenghtIR; $i++) {
        $min = (float)GETPOST("min_" . ($i), 'float');
        $max = GETPOST("max_" . ($i), 'alphanum');

        if (!is_numeric($max)) // to prevent sql injection
            $max = "+";

        $percentIR = (float)GETPOST("percentIR_" . ($i), 'float');
        $deduction = (float)GETPOST("deduction_" . ($i), 'float');

        $sql = "REPLACE INTO llx_Paie_IRParameters(id, irmin, irmax, percentIR, deduction) VALUES($i, " . $min . ", '" . $max . "', " . $percentIR . ", " . $deduction . ");";
        $res = $db->query($sql);
        if ($res);
        else print("<br>fail ERR: " . $sql);
    }

    // Get data of prime d'ancien
    $sql = "DELETE FROM llx_Paie_PrimDancienParameters";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    $lenghtPrimdancien = (int)GETPOST("lenghtPrimdancien", 'int');
    for ($i = 1; $i <= $lenghtPrimdancien; $i++) {
        $de = (float)GETPOST("de_" . $i, 'float');
        $a = GETPOST("a_" . $i, 'alphanum');

        if (!is_numeric($a)) // to prevent sql injection
            $a = "+";

        $percentPrimDancien = (float)GETPOST("percentPrimDancien_" . ($i), 'float');

        $sql = "REPLACE INTO llx_Paie_PrimDancienParameters(id, de, a, percentPrimDancien) VALUES($i, " . $de . ", '" . $a . "', " . $percentPrimDancien . ");";
        $res = $db->query($sql);
        if ($res);
        else print("<br>fail ERR: " . $sql);
    }

    // Get data of Les Hour supp
    $sql = "DELETE FROM llx_Paie_HourSupp";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    $lenghtHourSupp = (int)GETPOST("lenghtHourSupp", 'int');
    for ($i = 1; $i <= $lenghtHourSupp; $i++) {
        $rub = (int)GETPOST("rubHourSupp_" . $i, 'int');
        $designation = GETPOST("designationHourSupp_" . $i, 'alphanum');
        $codeComptable = (int)GETPOST("codeComptableHourSupp_" . ($i), 'int');
        $percentHourSupp = (float)GETPOST("percentHourSupp_" . ($i), 'float');

        $sql = "REPLACE INTO llx_Paie_HourSupp(rub, designation, codeComptable, percentHourSupp) VALUES($rub , '" . $designation . "', $codeComptable, " . $percentHourSupp . ");";
        $res = $db->query($sql);
        if ($res);
        else print("<br>fail ERR: " . $sql);
    }

    //Insert parameters
    $sql = "REPLACE INTO llx_Paie_bdpParameters(id, cnss, patronaleCnss, amo, patronaleAmo, fp, TaxFormationPro, prestationFamilial, maxCNSS, maxFraitPro, maxFreeTransport, maxChildrens, primDenfan, smigHoraire, hoursMonsuele, workingDays) 
                    VALUES(1, $cnss, $patronaleCnss, $amo, $patronaleAmo, $fp, $TaxFormationPro, $prestationFamilial, $maxCNSS, $maxFraitPro, $maxFreeTransport, $maxChildrens, $primDenfan, $smigHoraire, $hoursMonsuele, $workingDays);";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    //Insert rubriques
    foreach ($rubriques as $r) {
        $rub = (int)GETPOST($r[1] . "rub", 'int');
        $codeComptable = (int)GETPOST($r[1] . "codeComptable", 'int');

        $sql = "REPLACE INTO llx_Paie_Rubriques(rub, designation, name, codeComptable) VALUES($rub, '" . $r[0] . "', '" . $r[1] . "', $codeComptable);";
        $res = $db->query($sql);
        if ($res);
        else print("<br>fail ERR: " . $sql);
    }
}

$sql = "SELECT * FROM llx_Paie_bdpParameters";
$res = $db->query($sql);
$row = array();
if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
}

print 
    "<style>
        /* page rh parametrage */
        #listeParametres{
            margin-left: 30px;
            border: 1px solid #e0e0e0;
        }

        #listeParametres .parametre{
            padding: 7px 8px;
        }
        #listeParametres .row-parametre{
            display: flex;
            justify-content: space-between;
            padding: 7px 8px;
            align-items: center;
        }
        #listeParametres .parametre:not(:last-child){
            border-bottom: 1px solid #e0e0e0;
        }
        #listeParametres .table-parametres .parametre-nom h1{
            font-size: 15px;
            margin: 0 0 5px 0;
        }
        #listeParametres .table-parametres .parametre-valeurs {
            border: 1px solid #e0e0e0;
        }
        #listeParametres .table-parametres .parametre-valeurs > .table-row:first-child{
            background: var(--colorbacktitle1);
            height: 30px;
            
        }
        #listeParametres .table-parametres .parametre-valeurs .table-row{
            display: grid;
            align-items: center;
            padding: 7px 8px;
        }
        #listeParametres .table-parametres .parametre-valeurs .table-row:hover,
        #listeParametres > .row-parametre:hover{
            background: var(--colorbacklinepairhover) !important;
        }
        #listeParametres > .table-parametres.tree-column .parametre-valeurs .table-row{
            grid-template-columns: 1fr 1fr 1fr;
        }
        #listeParametres > .table-parametres.four-column .parametre-valeurs .table-row{
            grid-template-columns: 1fr 1fr 1fr 100px;
        }
        #listeParametres > .table-parametres.five-column .parametre-valeurs .table-row{
            grid-template-columns: 1fr 1fr 1fr 1fr 100px;
        }
        #listeParametres > .table-parametres.fourteen-column .parametre-valeurs .table-row{
            grid-template-columns: 100px repeat(12, 1fr);
        }
        #listeParametres > .table-parametres.five-column:last-child .parametre-valeurs .table-row{
            grid-template-columns: 100px 1fr 1fr 1fr 100px ;
        }
        #listeParametres .table-parametres .parametre-valeurs .table-row:not(:last-child){
            border-bottom: 1px solid #e0e0e0;
        }
        #listeParametres .butActionEdit{
            text-decoration: none;
            text-transform: uppercase;
            font-weight: bold;
            padding: 7px 10px;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            color: #fff;
            border: 1px solid transparent;
            background-color: #ac88b5;
            margin: 0;
        }

        #addRubModal,
        #editModal{
            width: 700px;
            z-index: 156454;
            background: #e7e7e7;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: rgb(14 30 37 / 12%) 0px 2px 4px 0px, rgb(14 30 37 / 32%) 0px 2px 16px 0px;
            border-radius: 6px;
            display: none;
            grid-template-rows: 52px auto 60px;
            padding: 15px;
        }
        #addRubModal .modal-body,
        #editModal .modal-body{
            border-bottom: 1px solid #fff;
            border-top: 1px solid #fff;
        }
        #addRubModal .modal-footer,
        #editModal .modal-footer{
            align-items: center;
            justify-content: right;
            display: flex;
            gap: 24px;
        }
        #addRubModal button,
        #editModal button{
        border-radius: 8px;
        border-style: none;
        box-sizing: border-box;
        color: #FFFFFF;
        cursor: pointer;
        display: inline-block;
        font-size: 14px;
        font-weight: 500;
        height: 40px;
        line-height: 20px;
        list-style: none;
        margin: 0;
        outline: none;
        padding: 10px 16px;
        position: relative;
        text-align: center;
        text-decoration: none;
        transition: color 100ms;
        vertical-align: baseline;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        }
        #addRubModal .modal-header button,
        #editModal .modal-header button{
            border-radius: 5px;
            height: initial;
            line-height: initial;
            padding: 6px 8px;
        }

        #addRubModal button:hover,
        #addRubModal button:focus,
        #editModal button:hover,
        #editModal button:focus{
        opacity: .8;
        }
        #addRubModal .modal-header,
        #editModal .modal-header{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #addRubModal .modal-body,
        #editModal .modal-body{
            display: grid;
            grid-template-columns: 1fr 1fr;
            padding: 15px 4px;
            gap: 30px;
        }
        #addRubModal .modal-body .form-control,
        #editModal .modal-body .form-control{
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 8px 0px;
        }
        #addRubModal .modal-body .form-control input[type='text'],
        #editModal .modal-body .form-control input[type='text']{
            width: 180px;
        }
        #addRubModal .modal-body .form-control select,
        #editModal .modal-body .form-control select{
            width: 188px;
        }
        #addRubModal .modal-footer button:first-child,
        #editModal .modal-footer button:first-child{
            background-color: #6e9755;
        }
        #addRubModal .modal-header button,
        #addRubModal .modal-footer button:last-child,
        #editModal .modal-header button,
        #editModal .modal-footer button:last-child{
            background-color: #975555;
        }

        #overflow{
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: #2e2e2ebd;
            overflow: unset;
        }
        .form-group{
            padding: 6px 0;
            border-bottom: 1px solid #fff;
        }
        #addRubModal label,
        #editModal label{
            font-size: 14px;
            color: #5e5e5e;
        }
        #addRubModal label.titre,
        #editModal label.titre{
            font-size: 16px;
            color: #000;
            font-weight: bold;
        }

        #deleteRubConfirmation{
            padding: 18px;
            border-radius: 8px;
            height: 120px;
            background-color: #e7e7e7;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            flex-direction: column;
            justify-content: space-between;
        }
        #deleteRubConfirmation button{
            border: 0;
            border-radius: 0.25em;
            background: initial;
            color: #fff;
            font-size: 16px;
            padding: 9px;
            cursor: pointer;
        }
        #deleteRubConfirmation button.confirm{
            background-color: #548734;
        }
        #deleteRubConfirmation button.cancel{
            background-color: #dc3741;
        }
        #deleteRubConfirmation .confirmation-footer{
            display: flex;
            justify-content: space-evenly;
        }

        #listeParametres .btnDelete{
            color: #fff;
            padding: 4px 6px;
            cursor: pointer;
            background-color: transparent;
            border: none;
            font-size: 16px;
        }
        #listeParametres .btnDelete i{
            color: #bd686d !important;
        }
        #listeParametres .btnEdit{
            color: #53b360;
            padding: 4px 6px;
            cursor: pointer;
            background-color: transparent;
            border: none;
            font-size: 16px;
        }
        #listeParametres .btnEdit i{
            color: #ab6db7;
        }
    </style>";
print '
<div id="overflow">
</div>
<form id="frmparams" action="' . $_SERVER["PHP_SELF"] . '" method="post">
<input type="hidden" name="token" value="'.newToken().'">
<input type="hidden" name="action" value="save">
<div id="listeParametres">
    <div class="parametre row-parametre">
        <div class="parametre-nom"><label for="hoursMonsuele">LES HOURS DE TRAVAIL PAR MOIS<label></div>
        <div><input type="text" name="hoursMonsuele" id="hoursMonsuele" value="' . $row['hoursMonsuele'] . '"></div>
    </div>
    <div class="parametre row-parametre">
        <div class="parametre-nom"><label for="hoursMonsuele">LES JOURS DE TRAVAIL PAR MOIS<label></label></div>
        <div><input type="text" name="workingDays" id="workingDays" value="' . $row['workingDays'] . '"></div>
    </div>
    <div class="parametre row-parametre">
        <div class="parametre-nom"><label for="smigHoraire">SMIG Horaire (DH)<label></div>
        <div><input type="text" name="smigHoraire" id="smigHoraire" value="' . $row['smigHoraire'] . '"></div>
    </div>
    <div class="parametre row-parametre">
        <div class="parametre-nom"><label for="primDenfan">DEDUCTION (DH)<label></div>
        <div><input type="text" name="primDenfan" id="primDenfan" value="' . $row['primDenfan'] . '"></div>
    </div>
    <div class="parametre row-parametre">
        <div class="parametre-nom"><label for="maxChildrens">MAX ENFANTS (DH)</label></div>
        <div><input type="text" name="maxChildrens" id="maxChildrens" value="' . $row['maxChildrens'] . '"></div>
    </div>
    <div class="parametre table-parametres five-column" id="tableIR">
        <div class="parametre-nom">
            <div class="row-parametre">
                <h1>IR</h1>
                <div>
                    <button id="btnaddIR" type="button" class="button">
                        <span class="fa fa-plus-circle valignmiddle btnTitle-icon"></span>
                        <span class="valignmiddle text-plus-circle btnTitle-label hideonsmartphone">Ajouter IR</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="parametre-valeurs" id="tbadyIR">
            <div class="table-row">
                <div>MIN (DH)</div>
                <div>MAX (DH)</div>
                <div>Porcentage</div>
                <div>Deduction</div>
            </div>';
$sql = "SELECT * FROM llx_Paie_IRParameters";
$res = $db->query($sql);
if ($res->num_rows) {
    while ($row = $res->fetch_assoc()) {
        print '
            <div class="table-row">
            <div><input type="text" name="min_' . $row['id'] . '" value="' . $row['irmin'] . '"></div>
            <div><input type="text" name="max_' . $row['id'] . '" value="' . $row['irmax'] . '"></div>
            <div><input type="text" name="percentIR_' . $row['id'] . '" value="' . $row['percentIR'] . '"></div>
            <div><input type="text" name="deduction_' . $row['id'] . '" value="' . $row['deduction'] . '"></div>
            <div><button type="button" class="btnDelete deleteButton"><i class="fas fa-trash"></i></button></div>
        </div>';
    }
}
print '</div>
</div>
<div class="parametre table-parametres four-column" id="tablePrimDancien">
    <div class="parametre-nom">
        <div class="row-parametre">
            <h1>PRIME D\'ANCIENNETE</h1>
            <div>
            <button id="btnaddPrimDancien" type="button" class="button">
                <span class="fa fa-plus-circle valignmiddle btnTitle-icon"></span>
                <span class="valignmiddle text-plus-circle btnTitle-label hideonsmartphone">Ajouter Tranche</span>
            </button>
            </div>
        </div>
    </div>
    <div class="parametre-valeurs" id="tbadyPrimDancien">
        <div class="table-row">
            <div>de</div>
            <div>à</div>
            <div>Porcentage</div>
        </div>';
$sql = "SELECT * FROM llx_Paie_PrimDancienParameters";
$res = $db->query($sql);
if ($res->num_rows) {
    while ($row = $res->fetch_assoc()) {
        print '
            <div class="table-row">
            <div><input type="text" name="de_' . $row['id'] . '" value="' . $row['de'] . '"></div>
            <div><input type="text" name="a_' . $row['id'] . '" value="' . $row['a'] . '"></div>
            <div><input type="text" name="percentPrimDancien_' . $row['id'] . '" value="' . $row['percentPrimDancien'] . '"></div>
            <div><button type="button" class="btnDelete deleteButton"><i class="fas fa-trash"></i></button></div>
        </div>';
    }
}
print '</div>
</div>
<div class="parametre table-parametres five-column" id="tableHourSupp">
    <div class="parametre-nom">
        <div class="row-parametre">
            <h1>Les Houres supplémentaires</h1>
            <div>
            <button id="btnaddHourSupp" type="button" class="button">
            <span class="fa fa-plus-circle valignmiddle btnTitle-icon"></span>
            <span class="valignmiddle text-plus-circle btnTitle-label hideonsmartphone">Ajouter</span>
        </button>
            </div>
        </div>
    </div>
    <div class="parametre-valeurs" id="tbadyHourSupp">
        <div class="table-row">
            <div>Rub</div>
            <div>Désignation</div>
            <div>Code Comptable</div>
            <div>Porcentage</div>
        </div>';

$sql = "SELECT * FROM llx_Paie_HourSupp";
$res = $db->query($sql);
if ($res->num_rows) {
    $i = 1;
    while ($row = $res->fetch_assoc()) {
        print '
        <div class="table-row">
            <div><input type="number" name="rubHourSupp_' . $i . '" value="' . $row['rub'] . '"></div>
            <div><input type="text" name="designationHourSupp_' . $i . '" value="' . $row['designation'] . '"></div>
            <div><input type="number" name="codeComptableHourSupp_' . $i . '" value="' . $row['codeComptable'] . '"></div>
            <div><input type="text" name="percentHourSupp_' . $i . '" value="' . $row['percentHourSupp'] . '"></div>
            <div><button type="button" class="btnDelete deleteButton"><i class="fas fa-trash"></i></button></div>
        </div>';
        $i++;
    }
}

print '</div>
</div>
<div class="parametre table-parametres tree-column">
    <div class="parametre-nom">
        <div class="row-parametre">
            <h1>Les Rubrique</h1>
        </div>
    </div>
    <div class="parametre-valeurs">
        <div class="table-row">
            <div>Désignation</div>
            <div>Code Rubrique</div>
            <div>Code Comptable</div>
        </div>';

foreach ($rubriques as $r) {
    $row = "";
    $sql = "SELECT * FROM llx_Paie_Rubriques WHERE name='$r[1]'";
    $res = $db->query($sql);
    if ($res->num_rows) {
        $row = $res->fetch_assoc();
    }

    print '<div class="table-row">
    <div><label for="' . $r[1] . '">' . $r[0] . '</label></div>
    <div><input type="number" name="' . $r[1] . 'rub" id="' . $r[1] . 'rub" value="' . $row['rub'] . '"></div>
    <div><input type="number" name="' . $r[1] . 'codeComptable" value="' . $row['codeComptable'] . '"></div>
</div>';
}

print '
</div>
<div style="text-align:right;margin-top: 18px;"><input style="background: #20a53d;" type="submit" class="button" style="margin-left: 45%;" value="Enregistrer"></div>
</div> 

<div class="parametre table-parametres five-column" style="margin-top: 15px;border-top: 1px solid #e0e0e0;">
<button style="margin: 9px 0;" id="btnaddRub" type="button" class="button">  
    <span class="fa fa-plus-circle valignmiddle btnTitle-icon"></span>
    <span class="valignmiddle text-plus-circle btnTitle-label hideonsmartphone">Ajouter Rub</span>
</button>
<div class="parametre-valeurs" id="tbadyRub">
    <div class="table-row">
        <div></div>
        <div>Rubrique</div>
        <div>Désignation</div>
        <div style="text-align: center;">Code Comptable</div>
    </div>';

$sql = "SELECT * FROM llx_Paie_Rub";
$res = $db->query($sql);
if ($res->num_rows) {
    for ($i = 1; $i <= $res->num_rows; $i++) {
        $row = $res->fetch_assoc();

        print '
            <div class="table-row">
                <div><button type="button"style="margin:0;" class="deleteButton btnDelete" value="delete" onclick="deleteRub(\''.$row["designation"].'\',\''.$row["rub"].'\')"><i class="fas fa-trash"></i></buttton></div>
                <div><label>'. $row["rub"] .'</label></div>
                <div><label>'. $row["designation"] .'</label></div>
                <div style="text-align: center;"><label>'. $row["codeComptable"] .'</label></div>
                <div style="text-align:center;"><button type="button" class="editButton btnEdit" value="Modifier" onclick="editRub('.$row["rub"].',\''.$row["designation"].'\',\''.$row["codeComptable"].'\',\''.$row["cotisation"].'\',\''.$row["calcule"].'\', \''.$row["base"].'\''.', \''.$row["percentage"].'\',\''. $row["enNetImposable"].'\',\''.$row["surBulletin"].'\',\''.$row["plafonne"].'\',\''.$row["plafond"].'\',\''.$row["auFiche"].'\',\''.$row["enBrut"].'\',\''.$row["enJours"].'\',\''.$row["avecConge"].'\',\''.$row["imposable"].'\',\''.$row["partiel"].'\',\''.$row["maxFree"].'\',\''.$row["reset"].'\',\''.$row["importable"].'\')"><i class="fas fa-edit"></i></button></div>
            </div>';
    }
}
// <div style="text-align:center;"><input type="button" class="butActionEdit" value="Modifier" onclick="editRub('.$row["rub"].',\''.$row["designation"].'\',\''.$row["codeComptable"].'\',\''.$row["cotisation"].'\',\''.$row["calcule"].'\', \''.$row["base"].'\''.', \''.$row["percentage"].'\',\''. $row["enNetImposable"].'\',\''.$row["surBulletin"].'\',\''.$row["plafonne"].'\',\''.$row["plafond"].'\',\''.$row["auFiche"].'\',\''.$row["enBrut"].'\',\''.$row["enJours"].'\',\''.$row["avecConge"].'\',\''.$row["imposable"].'\',\''.$row["partiel"].'\',\''.$row["maxFree"].'\')"/></div>
// <div style="width:100px;"><input type="button"style="margin:0;" class="butActionDelete btnDelete" value="delete" onclick="deleteRub(\''.$row["designation"].'\',\''.$row["rub"].'\')"/></div>



print '
            </div>
        </div>
    </div>
    </div>
</form>
<form id="frmDelete" action="' . $_SERVER["PHP_SELF"] . '" method="post">
    <input type="hidden" name="token" value="'.newToken().'">
    <input type="hidden" name="action" value="delete">
</form>




<form id="frmEditRub" action="' . $_SERVER["PHP_SELF"] . '" method="post">
<input type="hidden" name="token" value="'.newToken().'">
<input type="hidden" name="action" value="editRub">
<input type="hidden" name="rub" id="editedRubId">
<div id="editModal">
    <div class="modal-header">
        <h3>Modifier Rubrique</h3>
        <button class="closeModal">X</button>
    </div>
    <div class="modal-body">
        <div>
            <div class="form-group">
                <div class="form-control">
                    <label for="rubrique" class="titre">Rubrique</label>
                    <input type="text" name="rubrique" id="rubrique">
                </div>                
            </div>
            <div class="form-group">
                <div class="form-control">
                    <label for="codeComptable" class="titre">Code Comptable</label>
                    <input type="text" name="codeComptable" id="codeComptable">
                </div>                
            </div>
            <div class="form-group">
                <div class="form-control">
                    <div>
                        <label for="checkCotisation" class="titre">Cotisation</label>
                        <input type="checkbox" name="cotisation" value="oui" id="checkCotisation" onclick="changeCotisation()">
                    </div>
                    <div>
                        <label for="checkCalculable" class="titre">Calculable</label>
                        <input type="checkbox" name="calcule" value="oui" id="checkCalculable" onclick="changeCalculable()">
                    </div>
                </div>
                
                
                <div id="baseData" style="display:none;">
                    <div class="form-control">
                        <label>Base</label>
                        <select id="base" name="base"><option value="salaire de base">Salaire de base</option><option value="salaire mensuel">Salaire mensuel</option><option value="salaire brut imposable">Salaire  brut imposable</option></select>
                    </div>
                    <div class="form-control">
                        <label for="calculablePercentage">Percentage</label>
                        <input type="text" name="percentage" id="percentage"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-control">
                    <label for="enJours" class="titre">Calculer en jours travaillés</label>
                    <input type="checkbox" name="enJours" value="oui" id="enJours" onclick="changeCalcJourTravail()">
                </div>
                <div id="calJourTravailData" style="display:none;">
                    <div class="form-control">
                        <label for="avecConge">Avec Congé</label>
                        <input type="radio" name="avecConge" value="1" id="avecConge" />
                        <label for="sansConge">Sans Congé</label>
                        <input type="radio" name="avecConge" value="0" id="sansConge" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-control">
                    <label for="enBrut" class="titre">Ajouter Au Brut Global</label>
                    <input type="checkbox" name="enBrutGlobal" id="enBrut" value="oui">
                </div>
            </div>
            <div class="form-group">
                <div class="form-control">
                    <label for="auFich" class="titre">Ajouter au fiche employé</label>
                    <input type="checkbox" name="auFiche" id="auFich" value="oui">
                </div>
            </div>  
            <div class="form-group">
                <div class="form-control">
                    <label for="importable" class="titre">importable</label>
                    <input type="checkbox" name="importable" id="importable" value="oui">
                </div>
            </div>
        </div>
        <div>
            <div class="form-group">
                <div class="form-control">
                    <label for="designation" class="titre">Désignation</label>
                    <input type="text" name="designation" id="designation">
                </div>                
            </div>
            <div class="form-group">
                <div class="form-control">
                    <label for="checkImposable" class="titre">Imposable</label>
                    <input type="checkbox" name="imposable" value="oui" id="checkImposable" onclick="changeImposable()">
                </div>
                <div id="imposableData" style="display:none;">
                    <div class="form-control">
                        <label for="checkPartiel">Imposable Partiellement</label>
                        <input type="checkbox" name="partiel" value="oui" id="checkPartiel" onclick="changePartiel()">
                    </div>
                    <div id="partielData" style="display:none;">
                        <div class="form-control">
                            <label for="maxFree">Plafond de non Imposable</label>
                            <input type="text" name="maxFree" id="maxFree" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">

                <div class="form-control">
                    <label for="checkPlafonne" class="titre">Plafonné</label>
                    <input type="checkbox" name="plafonne" value="oui" id="checkPlafonne" onclick="changePlafonne()">
                </div>
                <div id="plafonneData" style="display:none;">
                    <div class="form-control">
                        <label for="plafonne">Le Plafond</label>
                        <input type="text" name="plafond" id="plafond"/>
                    </div>
                </div>
            </div>
            <div class="form-group">

                <div class="form-control">
                    <label for="surBulletin" class="titre">Afficher sur le bulletin</label>
                    <input type="checkbox" name="surBulletin" id="surBulletin" value="oui">
                </div>
            </div>
            <div class="form-group">
                <div class="form-control">
                    <label for="enNetImposable" class="titre">En Net Imposable</label>
                    <input type="checkbox" name="enNetImposable" id="enNetImposable" value="oui">
                </div>
            </div>
            <div class="form-group">
                <div class="form-control">
                    <label for="reset" class="titre">Remis à 0</label>
                    <input type="checkbox" name="reset" id="reset" value="oui">
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button>Save Changes</button>
        <button class="closeModal">Cancel</button>
    </div>
</div>
</form>
<form id="frmAddRub" action="' . $_SERVER["PHP_SELF"] . '" method="post">
    <input type="hidden" name="token" value="'.newToken().'">
    <div id="addRubModal">
        <input type="hidden" name="action" value="addRub">
        <div class="modal-header">
            <h3>Ajouter Rubrique</h3>
            <button class="closeModal">X</button>
        </div>
        <div class="modal-body">
            <div>
                <div class="form-group">
                    <div class="form-control">
                        <label for="rubriqueAdded" class="titre">Rubrique</label>
                        <input type="text" name="rubrique" id="rubriqueAdded">
                    </div>                
                </div>
                <div class="form-group">
                    <div class="form-control">
                        <label for="codeComptableAdded" class="titre">Code Comptable</label>
                        <input type="text" name="codeComptable" id="codeComptableAdded">
                    </div>                
                </div>
                <div class="form-group">
                    <div class="form-control">
                        <div>
                            <label for="checkCotisationAdded" class="titre">Cotisation</label>
                            <input type="checkbox" name="cotisation" value="oui" id="checkCotisationAdded" onclick="changeCotisationAdded()">
                        </div>
                        <div>
                            <label for="checkCalculableAdded" class="titre">Calculable</label>
                            <input type="checkbox" name="calcule" value="oui" id="checkCalculableAdded" onclick="changeCalculableAdded()">
                        </div>
                    </div>
                    
                    
                    <div id="baseDataAdded" style="display:none;">
                        <div class="form-control">
                            <label>Base</label>
                            <select id="base" name="base"><option value="salaire de base">Salaire de base</option><option value="salaire mensuel">Salaire mensuel</option><option value="salaire brut imposable">Salaire  brut imposable</option></select>
                        </div>
                        <div class="form-control">
                            <label for="calculablePercentageAdded">Percentage</label>
                            <input type="text" name="percentage" id="calculablePercentageAdded"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-control">
                        <label for="enJoursAdded" class="titre">Calculer en jours travaillés</label>
                        <input type="checkbox" name="enJours" value="oui" id="enJoursAdded" onclick="changeCalcJourTravailAdded ()">
                    </div>
                    <div id="calJourTravailDataAdded" style="display:none;">
                        <div class="form-control">
                            <label for="avecCongeAdded">Avec Congé</label>
                            <input type="radio" name="avecConge" value="1" id="avecCongeAdded" />
                            <label for="sansCongeAdded">Sans Congé</label>
                            <input type="radio" name="avecConge" value="0" id="sansCongeAdded" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-control">
                        <label for="enBrutAdded" class="titre">Ajouter Au Brut Global</label>
                        <input type="checkbox" name="enBrutGlobal" id="enBrutAdded" value="oui">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-control">
                        <label for="auFichAdded" class="titre">Ajouter au fiche employé</label>
                        <input type="checkbox" name="auFiche" id="auFichAdded" value="oui">
                    </div>
                </div>  
                <div class="form-group">
                    <div class="form-control">
                        <label for="importableAdded" class="titre">importable</label>
                        <input type="checkbox" name="importable" id="importableAdded" value="oui">
                    </div>
                </div>
            </div>
            <div>
                <div class="form-group">
                    <div class="form-control">
                        <label for="designationAdded" class="titre">Désignation</label>
                        <input type="text" name="designation" id="designationAdded">
                    </div>                
                </div>
                <div class="form-group">
                    <div class="form-control">
                        <label for="checkImposableAdded" class="titre">Imposable</label>
                        <input type="checkbox" name="imposable" value="oui" id="checkImposableAdded" onclick="changeImposableAdded()">
                    </div>
                    <div id="imposableDataAdded" style="display:none;">
                        <div class="form-control">
                            <label for="checkPartielAdded">Imposable Partiellement</label>
                            <input type="checkbox" name="partiel" value="oui" id="checkPartielAdded" onclick="changePartielAdded()">
                        </div>
                        <div id="partielDataAdded" style="display:none;">
                            <div class="form-control">
                                <label for="maxFreeAdded">Plafond de non Imposable</label>
                                <input type="text" name="maxFree" id="maxFreeAdded" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-control">
                        <label for="checkPlafonneAdded" class="titre">Plafonné</label>
                        <input type="checkbox" name="plafonne" value="oui" id="checkPlafonneAdded" onclick="changePlafonneadded()">
                    </div>
                    <div id="plafonneDataAdded" style="display:none;">
                        <div class="form-control">
                            <label for="plafondAdded">Le Plafond</label>
                            <input type="text" name="plafond" id="plafondAdded"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">

                    <div class="form-control">
                        <label for="surBulletinAdded" class="titre">Afficher sur le bulletin</label>
                        <input type="checkbox" name="surBulletin" id="surBulletinAdded" value="oui">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-control">
                        <label for="enNetImposableAdded" class="titre">En Net Imposable</label>
                        <input type="checkbox" name="enNetImposable" id="enNetImposableAdded" value="oui">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-control">
                        <label for="resetAdded" class="titre">Remis à 0</label>
                        <input type="checkbox" name="reset" id="resetAdded" value="oui">
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button>Ajouter</button>
            <button class="closeModal">Cancel</button>
        </div>
    </div>
</form>
<div id="deleteRubConfirmation">
    <input type="hidden" id="deletedRubId"/>
    <div class="confirmation-title">
        <h2>Voulez-vous supprimer cette rubrique</h2>
    </div>
    <div class="confirmation-footer">
        <button class="confirm">Supprimer</button>
        <button class="cancel">Cancel</button>
    </div>
</div>';

?>
<script>
    function deleteRub(designation, deleteRub) {
        $('html, body').css({
            overflow: 'hidden',
        });
        $("#overflow").css("display", "block");
        $("#deleteRubConfirmation").css("display", "flex");
        $("#deleteRubConfirmation .confirmation-title").html("<h2 style='font-size: 18px;'>Voulez-vous supprimer la rubrique '" + designation + "'</h2>");
        $("#deletedRubId").val(deleteRub);
    }
    // cancel supprission
    $("#deleteRubConfirmation").on('click', ".cancel", function() {
        $("#deleteRubConfirmation").css("display", "none");
        $("#overflow").css("display", "none");
        $('html, body').css({
            overflow: 'auto',
        });
    });

    // confirm supprission
    $("#deleteRubConfirmation").on('click', ".confirm", function() {
        let deleteRub = $("#deletedRubId").val();
        $("#frmDelete").append('<input type="hidden" name="rub" value="' + deleteRub + '" />');
        $("#frmDelete").submit();
    });

    function editRub(id,designation, codeComptable, cotisation, calcule, base, percentage, enNetImposable, surBulletin, plafonne, plafond, auFich, enBrut, enJours, avecConge, imposable, partiel, maxFree, reset, importable) {
        $("#editModal").css("display", "grid");
        $("#overflow").css("display", "block");
        $('html, body').css({
            overflow: 'hidden',
        });
        $("#editedRubId").val(id);
        $("#rubrique").val(id);
        $("#designation").val(designation);
        $("#codeComptable").val(codeComptable);
        if(cotisation == 1){
            $('#baseData').css('display', "block");
            $("#checkCotisation").prop('checked', true);
            $('#checkCalculable').prop('disabled', true);
            $('#checkImposable').prop('disabled', true);
        }else{
            $("#checkCotisation").prop('checked', false);
            $('#checkCalculable').prop('disabled', false);
            $('#checkImposable').prop('disabled', false);
        }
        if(calcule == 1){
            $('#baseData').css('display', "block");
            $("#checkCalculable").prop('checked', true);
            $('#checkCotisation').prop('disabled', true);
        }else{
            $("#checkCalculable").prop('checked', false);
            if(cotisation != 1){
                $('#baseData').css('display', "none");
            }
        }
        $("#percentage").val(percentage);
        $("#base").val(base);
        if(enNetImposable == 1){
            $("#enNetImposable").prop('checked', true);
        }else{
            $("#enNetImposable").prop('checked', false);
        }
        if(reset == 1){
            $("#reset").prop('checked', true);
        }else{
            $("#reset").prop('checked', false);
        }
        if(importable == 1){
            $("#importable").prop('checked', true);
        }else{
            $("#importable").prop('checked', false);
        }
        if(surBulletin == 1){
            $("#surBulletin").prop('checked', true);
        }else{
            $("#surBulletin").prop('checked', false);
        }
        if(plafonne == 1){
            $("#checkPlafonne").prop('checked', true);
            $("#plafonneData").css('display', "block");
            $("#plafond").val(plafond);
        }else{
            $("#plafond").val('');
            $("#checkPlafonne").prop('checked', false);
            $("#plafonneData").css('display', "none");
        }
        if(auFich == 1){
            $("#auFich").prop('checked', true);
        }else{
            $("#auFich").prop('checked', false);
        }
        if(enBrut == 1){
            $("#enBrut").prop('checked', true);
        }else{
            $("#enBrut").prop('checked', false);
        }
        if(enJours == 1){
            $("#enJours").prop('checked', true);
            $('#calJourTravailData').css('display', "block");
            if(avecConge == 1){
                $("#avecConge").prop('checked', true);
            }else{
                $("#sansConge").prop('checked', true);
            }
        }else{
            $("#enJours").prop('checked', false);
            $('#calJourTravailData').css('display', "none");
        }
        if(imposable == 1){
            $("#checkImposable").prop('checked', true);
            $('#imposableData').css('display', "block");
            if(partiel == 1){
                $("#checkPartiel").prop('checked', true);
                $('#partielData').css('display', "block");
                $("#maxFree").val(maxFree);
            }else{
                $("#checkPartiel").prop('checked', false);
                $('#partielData').css('display', "none");
                $("#maxFree").val('');
            }
        }else{
            $("#checkImposable").prop('checked', false);
            $("#checkPartiel").prop('checked', false);
            $('#imposableData').css('display', "none");
        }
    };


    //COTISATION CHECKED Edit
    function changeCotisation() {
        if ($('#checkCotisation').is(':checked')) {
            $('#checkImposable').prop('checked', false);
            $('#imposableData').css('display', "none");
            $('#checkImposable').prop('disabled', true);
            $('#checkCalculable').prop('disabled', true);
            $('#checkCalculable').prop('checked', false);
            $('#baseData').css('display', "block");
        } else {
            $('#checkCalculable').prop('disabled', false);
            $('#checkImposable').prop('disabled', false);
            $('#baseData').css('display', "none");
        }
    }

    //COTISATION CHECKED Add
    function changeCotisationAdded() {
        if ($('#checkCotisationAdded').is(':checked')) {
            $('#checkCalculableAdded').prop('disabled', true);
            $('#checkCalculableAdded').prop('checked', false);
            $('#baseDataAdded').css('display', "block");
            $('#checkImposableAdded').prop('disabled', true);
            $('#checkImposableAdded').prop('checked', false);
            $('#imposableDataAdded').css('display', "none");

        } else {
            $('#checkCalculableAdded').prop('disabled', false);
            $('#checkImposableAdded').prop('disabled', false);
            $('#baseDataAdded').css('display', "none");
        }
    }

    //calculale Edit
    function changeCalculable() {
        if ($('#checkCalculable').is(':checked')) {
            $('#checkCotisation').prop('disabled', true);
            $('#baseData').css('display', "block");
        } else {
            $('#checkCotisation').prop('disabled', false);
            $('#baseData').css('display', "none");
        }
    }
    //calculale Add
    function changeCalculableAdded() {
        if ($('#checkCalculableAdded').is(':checked')) {
            $('#checkCotisationAdded').prop('disabled', true);
            $('#baseDataAdded').css('display', "block");
        } else {
            $('#checkCotisationAdded').prop('disabled', false);
            $('#baseDataAdded').css('display', "none");
        }
    }
    //Imposable add
    function changeImposableAdded() {
        if ($('#checkImposableAdded').is(':checked')) {
            $('#imposableDataAdded').css('display', "block");
        } else {
            $('#imposableDataAdded').css('display', "none");
        }
    }
    //Imposable edit
    function changeImposable() {
        if ($('#checkImposable').is(':checked')) {
            $('#imposableData').css('display', "block");
        } else {
            $('#imposableData').css('display', "none");
        }
    }
    //partiel edit
    function changePartiel() {
        if ($('#checkPartiel').is(':checked')) {
            $('#partielData').css('display', "block");
        } else {
            $('#partielData').css('display', "none");
        }
    }
    //partiel add
    function changePartielAdded() {
        if ($('#checkPartielAdded').is(':checked')) {
            $('#partielDataAdded').css('display', "block");
        } else {
            $('#partielDataAdded').css('display', "none");
        }
    }
    //plafond edit
    function changePlafonne() {
        if ($('#checkPlafonne').is(':checked')) {
            $('#plafonneData').css('display', "block");
        } else {
            $('#plafonneData').css('display', "none");
        }
    }
    //plafond add
    function changePlafonneadded() {
        if ($('#checkPlafonneAdded').is(':checked')) {
            $('#plafonneDataAdded').css('display', "block");
        } else {
            $('#plafonneDataAdded').css('display', "none");
        }
    }
    //calculer jours de travail edit
    function changeCalcJourTravail() {
        if ($('#enJours').is(':checked')) {
            $('#calJourTravailData').css('display', "block");
        } else {
            $('#calJourTravailData').css('display', "none");
        }
    }
    //calculer jours de travail add
    function changeCalcJourTravailAdded() {
        if ($('#enJoursAdded').is(':checked')) {
            $('#calJourTravailDataAdded').css('display', "block");
        } else {
            $('#calJourTravailDataAdded').css('display', "none");
        }
    }

    $(document).ready(function() {
        //modal
        $("#editModal").on('click', ".closeModal", function(event) {
            event.preventDefault();
            $("#editModal").css("display", "none");
            $("#overflow").css("display", "none");
            $('html, body').css({
                overflow: 'auto',
            });
        });

        // Les Rubrique
        let r = $("#tbadyRub .table-row").length -1;
        $("#frmparams").append('<input id="lenghtRub" type="hidden" name="lenghtRub" value="' + r + '">');
        
        $("#btnaddRub").click(function() {
            $("#addRubModal").css("display", "grid");
            $("#overflow").css("display", "block");
            $('html, body').css({
                overflow: 'hidden',
            });
        });
        $("#addRubModal").on('click', ".closeModal", function(event) {
            event.preventDefault();
            $("#addRubModal").css("display", "none");
            $("#overflow").css("display", "none");
            $('html, body').css({
                overflow: 'auto',
            });
        });


        
        // IR
        let i = $("#tbadyIR .table-row").length -1;
        $("#frmparams").append('<input id="lenghtIR" type="hidden" name="lenghtIR" value="' + i + '">')

        $("#btnaddIR").click(function() {
            i++;
            $("#tbadyIR").append('<div class="table-row"><div><input type="text" name="min_' + i + '" value=""></div><div><input type="text" name="max_' + i +
                '" value=""></div><div><input type="text" name="percentIR_' + i + '" value=""></div><div><input type="text" name="deduction_' + i + '" value=""></div><div><button type="button" class="btnDelete deleteButton"><i class="fas fa-trash"></i></button></div></div>');
            $("#lenghtIR").val(i);
        });

        $("#tableIR").on('click', ".btnDelete", function() {
            $(this).closest('.table-row').remove();
            i--;
            $("#lenghtIR").val(i);
        });

        //Prime D'ancien
        let p = $("#tbadyPrimDancien .table-row").length -1;
        $("#frmparams").append('<input id="lenghtPrimdancien" type="hidden" name="lenghtPrimdancien" value="' + p + '">')

        $("#btnaddPrimDancien").click(function() {
            p++;
            $("#tbadyPrimDancien").append('<div class="table-row"><div><input type="text" name="de_' + p + '" value=""></div><div><input type="text" name="a_' + p + '" value=""></div><div><input type="text" name="percentPrimDancien_' + p + '" value=""></div><div><button type="button" class="btnDelete deleteButton"><i class="fas fa-trash"></i></button></div></div></div>');
            $("#lenghtPrimdancien").val(p);
        });

        $("#tablePrimDancien").on('click', ".btnDelete", function() {
            $(this).closest('.table-row').remove();
            p--;
            $("#lenghtPrimdancien").val(p);
        });

        //Les hour supp
        let h = $("#tbadyHourSupp .table-row").length -1;
        $("#frmparams").append('<input id="lenghtHourSupp" type="hidden" name="lenghtHourSupp" value="' + (h) + '">')

        $("#btnaddHourSupp").click(function() {
            h++;
            $("#tbadyHourSupp").append('<div class="table-row"><div><input type="number" name="rubHourSupp_' + (h) + '" value=""></div><div><input type="text" name="designationHourSupp_' + h + '" value=""></div><div><input type="number" name="codeComptableHourSupp_' + h + '" value=""></div><div><input type="text" name="percentHourSupp_' + h + '" value=""></div><div><button type="button" class="btnDelete deleteButton"><i class="fas fa-trash"></i></button></div></div></div>');
            $("#lenghtHourSupp").val(h);
        });

        $("#tableHourSupp").on('click', ".btnDelete", function() {
            $(this).closest('.table-row').remove();
            h--;
            $("#lenghtHourSupp").val(h);
        });
    });
</script>
<?php
$db->free($result);

// End of page
llxFooter();
$db->close();

?>


