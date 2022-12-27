<?php

require_once '../../vendor/autoload.php';
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'../user/class/user.class.php';


llxHeader("", "Atacher list des utilisateurs");

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


$sites = ['agadir', 'ain sebaa', 'bourgone', 'ennassim', 'jnane bernoussi','marrakech', 'oulfa', 'rangement', 'siège', 'temara', 'val fleurie'];
$categories = ['ouvrier', 'ouvrier qualifié', 'cadre', 'employe'];
$banks = [
    '001' => 'BAM',
    '002' => 'AB',
    '005' => 'UMB',
    '007' => 'AWB',
    '009' => 'SBC',
    '011' => 'BMCE',
    '013' => 'BMCI',
    '019' => 'WB',
    '021' => 'CDM',
    '022' => 'SGMB',
    '023' => 'ABN',
    '025' => 'BMAO',
    '026' => 'UNIB',
    '028' => 'CITI',
    '031' => 'SMDC',
    '032' => 'BEX',
    '054' => 'CDG',
    '101' => 'BPA',
    '105' => 'BPH',
    '109' => 'BPBM',
    '117' => 'BPE',
    '127' => 'BPF',
    '133' => 'BPG',
    '140' => 'BPKH',
    '143' => 'BPL',
    '145' => 'BPM',
    '148' => 'BPMK',
    '149' => 'PBRI',
    '150' => 'BPN',
    '155' => 'BPOU',
    '157' => 'BPO',
    '159' => 'BPS',
    '164' => 'BPTA',
    '169' => 'BPTZ',
    '172' => 'BPTE',
    '175' => 'BPTI',
    '178' => 'BPCA',
    '181' => 'BPR',
    '190' => 'BCP',
    '195' => 'BPCE',
    '197' => 'BPCS',
    '205' => 'BNDE',
    '210' => 'CDG',
    '225' => 'CNCA',
    '230' => 'CIH',
    '310' => 'TGR',
    '350' => 'CCP'
];
$rowsLog = [];
$action = GETPOST('action', 'alpha');
$fileError = false;

print '
    <style>
        /* add file users */
        #file-upload-form {
            margin: 0 auto;
            max-width: 950px;
            width: 90%;
        }
        #file-upload-form label {
            padding: 2rem 1.5rem;
            background: #fff;
            border-radius: 7px;
            border: 3px solid #eee;
            text-align: center;
            display: grid;
        }
        #file-upload-form label:hover {
            border-color: #454cad;
        }
        #file-upload-form label.hover {
            border: 3px solid #454cad;
            box-shadow: inset 0 0 0 6px #eee;
        }
        #file-upload-form label.hover #start i.fa {
            transform: scale(0.8);
            opacity: 0.3;
        }
        /* #file-upload-form #start {
            float: left;
            clear: both;
            width: 100%;
        } */
        #file-upload-form #start.hidden {
            display: none;
        }
        #file-upload-form #start i.fa {
            font-size: 50px;
            margin-bottom: 1rem;
            transition: all 0.2s ease-in-out;
        }
        #file-upload-form #start i.fa {
            font-size: 50px;
            margin-bottom: 1rem;
            transition: all 0.2s ease-in-out;
        }
        
        #file-upload-form div {
            margin: 0 0 0.5rem 0;
            color: #5f6982;
        }
        #file-upload-form input[type="file"] {
            display: none;
        }
        #file-upload-form .btn {
            display: inline-block;
            margin: 0.5rem 0.5rem 1rem 0.5rem;
            clear: both;
            font-family: inherit;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            text-transform: initial;
            border: none;
            border-radius: 0.2rem;
            outline: none;
            padding: 0 1rem;
            height: 36px;
            line-height: 36px;
            color: #fff;
            transition: all 0.2s ease-in-out;
            box-sizing: border-box;
            background: #454cad;
            border-color: #454cad;
            cursor: pointer;
        }
        #file-upload-form p button{
            border: none;
            background: green;
            padding: 10px 12px;
            font-size: 16px;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
        }
        
        #fileNotAllowed{
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            width: 500px;
            height: 350px;
            border-radius: 5px;
            align-items: center;
            display: grid;
            justify-content: center;
            grid-template-rows: 1fr 1fr 1fr 40px;
            padding: 20px;
        }
        #fileNotAllowed .header{
            justify-self: center;
            font-size: 70px;
            color: red;
        }
        #fileNotAllowed .title{
            padding: 0.8em 1em 0;
            color: inherit;
            font-size: 1.875em;
            font-weight: 600;
            text-align: center;
            text-transform: none;
            word-wrap: break-word;
        }
        #fileNotAllowed .dismiss{
            justify-self: center;
        }
        #fileNotAllowed .message{
            justify-content: center;
            margin: 1em 1.6em 0.3em;
            padding: 0;
            overflow: auto;
            color: inherit;
            font-size: 1.125em;
            font-weight: normal;
            line-height: normal;
            text-align: center;
            word-wrap: break-word;
            word-break: break-word;
            align-self: start;
        }
        #fileNotAllowed .dismiss button{
            border: 0;
            border-radius: 0.25em;
            background: initial;
            background-color: #7066e0;
            color: #fff;
            font-size: 1em;
            margin: 0.3125em;
            padding: 0.625em 1.1em;
            transition: box-shadow .1s;
            box-shadow: 0 0 0 3px rgb(0 0 0 / 0%);
            font-weight: 500;
            cursor: pointer;
        }
        
        #logUpload div{
            font-size: 15px;
            font-weight: bold;
        }
        #logUpload .rejectedRow{
            color: #ff6d6d;
        }
        #logUpload .addedRow{
            color: #62c362;
        }
        #logUpload .existeRow{
            color: #ddbe29;
        }
    
    </style>
';

if ($action == 'addList') {
    $errorFormat = false;
    $arr_file = explode('.', $_FILES['file']['name']);
    $extension = end($arr_file);
    if($extension == 'csv') {
        $reader = new Csv();
    } else if($extension == 'xls') {
        $reader = new Xls();
    }else if ($extension == 'xlsx'){
        $reader = new Xlsx();
    }else{
        $errorFormat = true;
    }
    if (! $errorFormat){
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        if (!empty($sheetData)) {
            $nbUsersAdded = 0;
            $notAdded = [];
            for ($i=1; $i<count($sheetData); $i++) { //skipping first row
                $correctInformations = true;
                $errorMsg = null;
                $matricule = $sheetData[$i][0];
                $nom = strtolower($sheetData[$i][1]);
                $prenom = strtolower($sheetData[$i][2]);
                $login = substr($prenom, 0, 1)[0] . $nom;
                $currentDate = getdate(date("U"));
                $DNaissance = date("Y-m-d", strtotime($sheetData[$i][3]));

                $datetime1 = date_create(explode('-', $DNaissance)[2].'-'.explode('-', $DNaissance)[1].'-'. explode('-', $DNaissance)[0]);
                $datetime2 = date_create($currentDate['year'].'-'.$currentDate['mon'].'-'.$currentDate['mday']);
                $age =  date_diff($datetime1, $datetime2)->format('%y');
                if($age < 18){
                    $errorMsg = "La personne n'a pas 18 ans";
                    $correctInformations = false;
                }
                $DEmbauche =  date("Y-m-d", strtotime($sheetData[$i][4]));
                $cin = $sheetData[$i][5];
                if ($cin != ''){
                    $qry = "SELECT * FROM llx_user_extrafields WHERE cin = '".$cin."'";
                    $result = $db->query($qry);
                    if ( $result->num_rows > 0) {
                        $errorMsg = "Utilisateur avec cin : $cin deja existe";
                        $correctInformations = false;
                    }
                }
                $cnss = $sheetData[$i][6];
                if ($cnss != ''){
                    $qry = "SELECT * FROM llx_Paie_UserInfo WHERE cnss = '".$cnss."'";
                    $result = $db->query($qry);
                    if ( $result->num_rows > 0) {
                        $errorMsg = "Utilisateur avec cnss : $cnss deja existe";
                        $correctInformations = false;
                    }
                }
                $mutuelle = $sheetData[$i][7];
                if ($mutuelle != ''){
                    $qry = "SELECT * FROM llx_Paie_UserInfo WHERE mutuelle = '".$mutuelle."'";
                    $result = $db->query($qry);
                    if ( $result->num_rows > 0) {
                        $errorMsg = "Utilisateur avec mutuelle : $mutuelle deja existe";
                        $correctInformations = false;
                    }
                }
                $sexeStr = trim($sheetData[$i][8]);
                if (strcasecmp($sexeStr, 'm') == 0){
                    $sexe = 'man';
                }elseif(strcasecmp($sexeStr, 'f') == 0){
                    $sexe = 'woman';
                }else{
                    $errorMsg = "Sexe n'est pas valide";
                    $correctInformations = false;
                }
                $sfStr = $sheetData[$i][9];
                if (strcasecmp($sfStr, 'M') == 0){
                    $sf = 1;
                }elseif(strcasecmp($sfStr, 'c') == 0){
                    $sf = 2;
                }else{
                    $errorMsg = "Situation familiale n'est pas valide";
                    $correctInformations = false;
                }
                $ne=$sheetData[$i][10];
                $fonction = $sheetData[$i][12];
                $categorieStr = trim(mb_strtolower($sheetData[$i][13]));
                if (empty($categorieStr)){
                    $categorie = '';
                }elseif (in_array($categorieStr, $categories)){
                    $categorie = array_search($categorieStr, $categories, true) + 1;
                }else{
                    $correctInformations = false;
                    $errorMsg = "Catégorie n'est pas valide";
                }
                $siteStr = trim(mb_strtolower($sheetData[$i][14]));
                if (in_array($siteStr, $sites)){
                    $site = array_search($siteStr, $sites) + 1;
                }else{
                    $correctInformations = false;
                    $errorMsg = "Site n'est pas valide";
                }
                $ribStr = trim($sheetData[$i][15]);
                if (strlen($ribStr) == 24){
                    $codeBank = substr($ribStr, 0, 3);
                    $codeGuichet = substr($ribStr, 3, 3);
                    $bankName = $banks[$codeBank];
                    $cleRib = substr($ribStr, -2, 2);
                }else{
                    $correctInformations = false;
                    $errorMsg = "RIB n'est pas valide";
                }
                $adresse = $sheetData[$i][16];
                $cimr = $sheetData[$i][17];
                if ($cimr != ''){
                    $qry = "SELECT * FROM llx_Paie_UserInfo WHERE cimr = '".$cimr."'";
                    $result = $db->query($qry);
                    if ( $result->num_rows > 0) {
                        $errorMsg = "Utilisateur avec cimr : $cimr deja existe";
                        $correctInformations = false;
                    }
                }
                $salary = !empty($sheetData[$i][18]) ? str_replace(',', '.', $sheetData[$i][18]) : 0;
                $db->begin();
                if($correctInformations){
                    $qry = "SELECT * FROM llx_user WHERE login = '".$login."'";
                    $result = $db->query($qry);
                    if ( $result->num_rows > 0) {
                        array_push($rowsLog, [0, $i+1, "Utilisateur $prenom $nom deja existe"]);
                        $db->rollback();
                    }else{
                        $sql="INSERT INTO llx_user(lastname, firstname, login, admin, gender, employee, address, dateemployment, birth, job, salary) 
                        VALUES('$nom', '$prenom', '$login', 0, '$sexe', 1, '$adresse', '$DEmbauche', '$DNaissance', '$fonction', $salary)";

                        $res = $db->query($sql);
                        if($res === true){
                            $db->commit();
                            // get last id
                            $sql1="SELECT rowid FROM llx_user ORDER BY rowid DESC LIMIT 1";
                            $res = $db->query($sql1);
                            $result = $res->fetch_assoc();
                            $id = $result['rowid'];   

                            // create cnss
                            $sql2="INSERT INTO llx_Paie_UserInfo(userid, cnss, mutuelle, type, cimr) 
                            VALUES($id, '$cnss', '$mutuelle', 'mensuel', '$cimr')";
                            $res = $db->query($sql2);
                            if($res === TRUE){
                                //create extra fields
                                $sql3="INSERT INTO llx_user_extrafields(fk_object, status, situation, enfants, matricule, cin, categorie, site) 
                                VALUES($id, 1, $sf, $ne, '$matricule', '$cin', '$categorie', '$site')";
                                $res = $db->query($sql3);
                                if($res === TRUE){
                                    $nbUsersAdded += 1;
                                    $sql4="INSERT INTO llx_user_rib(fk_user, bank, code_banque, code_guichet, number, cle_rib) 
                                            VALUES($id, '$bankName', '$codeBank', '$codeGuichet', '$ribStr', '$cleRib')";
                                    $res = $db->query($sql4);
                                    if($res === TRUE){
                                        array_push($rowsLog, [1, $i+1, 'Utilisateur '.$prenom.' '.$nom.' Ajouté avec success']);
                                        $db->commit();
                                    }else{
                                        $db->rollback();
                                        $errorMsg = "RIB error";
                                    }
                                }else{

                                    $db->rollback();
                                    $errorMsg = "(matricule, cin, ou categorie) error";
                                }
                            }else{
                                $db->rollback();
                                $errorMsg = "(cnss ou mutuelle) error";
                            }                    
                        }else{
                            $db->rollback();
                            $errorMsg = "(nom, prenom, sexe, adresse, Date Embauche, Date Naissance ou fonction) error";
                        } 
                    }
                }
                if ($errorMsg){
                    array_push($rowsLog, [-1, $i+1, $errorMsg]);
                }
            }
        }else{
            $fileError = "le fichier empty";
        }
    }else{
        $fileError = "le fichier non autorisé. Uniquement .csv, .xls ou .xlsx";
    }
    $db->close();
    $nbrowsAdded = count(array_filter($rowsLog, function($row) { return $row[0] === 1;}));
    $nbrowsRejected = count(array_filter($rowsLog, function($row) {return $row[0] === 0;}));
}
if ($fileError){
    print '
        <div id="overflow" style="display:block">
        </div>
        <div id="fileNotAllowed">
            <div class="header">
            <i class="far fa-times-circle"></i>
            </div>
            <div class="title">Oops</div>
            <div class="message">'.$fileError.'</div>
            <div class="dismiss"><button>Ok</button></div>
        </div>
    ';
}

print "
    <form enctype='multipart/form-data' id='file-upload-form' class='uploader' method='post' action='" . $_SERVER['PHP_SELF'] ."'>
        <input type='hidden' name='action' value='addList'>
        <input type='hidden' name='token' value='".newToken()."'>
        <input id='file-upload' type='file' name='file' accept='application/vnd.ms-excel, text/csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' />
        <label for='file-upload' id='file-drag'>
            <div id='start'>
                <i class='fa fa-download' aria-hidden='true'></i>
                <div>Select a file</div>
                <span id='file-upload-btn' class='btn btn-primary'>Select a file</span>
            </div>
            <div class='fileName' style='display:none;'>file name</div>
        </label>
        <p><button type='submit'>Enregistrer</button></p>";
if (count($rowsLog) > 0){
    print'
    <div id="logUpload">
        <h2>Vous avez ajouter '.$nbrowsAdded.' utilisateurs, et '.$nbrowsRejected.' sont rejteés</h2>
        <div>';
        foreach ($rowsLog as $row) {
            if ($row[0] == -1){
                print "<div class='rejectedRow'>$row[1] : $row[2]</div>";
            }elseif ($row[0] == 1){
                print "<div class='addedRow'>$row[1] : $row[2]</div>";
            }else{
                print "<div class='existeRow'>$row[1] : $row[2]</div>";
            }
        }
    print'
        </div>
    </div>
    </form>';

}
print '
    <script>
        $("#fileNotAllowed .dismiss").click(function(){
            $("#overflow").css("display", "none");
            $("#fileNotAllowed").css("display", "none");
        });
        $("#file-upload").change(function(event){
            $(".fileName").html(event.target.files[0].name);
            $(".fileName").css("display", "block");
        });
    </script>
';


?>