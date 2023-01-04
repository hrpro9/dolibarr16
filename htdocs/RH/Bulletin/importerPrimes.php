<?php

require_once '../../vendor/autoload.php';
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'../user/class/user.class.php';



use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Write; 
use PhpOffice\PhpSpreadsheet\Spreadsheet;



$action = GETPOST('action', 'alpha');
$fileError = false;
$userInfos = ['Matricule', 'ID', 'Identifiant', 'Prenom', 'Nom'];
$importable = array();
$sql = "select rub, designation from llx_Paie_Rub WHERE importable = 1";
$res = $db->query($sql);
if ($res->num_rows) {
    while ($row = $res->fetch_assoc()) {
        array_push($importable, [$row['rub'], $row['designation']]);
    }
}



if ($action == 'exporter') {
    $rubs = GETPOST('rubs', 'array');

    $users = array();
    $spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
    
    $sql = "SELECT ef.matricule, u.rowid, u.login, u.firstname, u.lastname FROM `llx_user` as u LEFT JOIN llx_user_extrafields as ef ON u.rowid = ef.fk_object where u.employee = 1";
    $res = $db->query($sql);
    if ($res->num_rows) {
        while ($row = $res->fetch_assoc()) {
            array_push($users, [$row['matricule'], $row['rowid'], $row['login'], $row['firstname'], $row['lastname']]);
        }
    }
    $header = array_merge($userInfos, $rubs);


    for ($i = 0, $l = count($header); $i < $l; $i++) {
        $sheet->setCellValueByColumnAndRow($i + 1, 1, $header[$i]);
    }

    $j=2;
    for ($i = 0, $l = count($users); $i < $l; $i++) {
        for ($index = 0, $k = count($users[$i]); $index < $k; $index++) {
            $sheet->setCellValueByColumnAndRow($index + 1, $j, $users[$i][$index]);
        }
        $j++;
	}


    $fileName = "Employees.xlsx";
    $writer = new Write($spreadsheet);
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
	$writer->save('php://output');
	exit();

}
if ($action == 'import') {
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
        $rubValues = array();
        if (!empty($sheetData)) {
            for ($i=1; $i<count($sheetData); $i++) {
                $id = $sheetData[$i][1];
                $avance  = 0;
                for ($j= count($userInfos); $j < count(($sheetData[$i])); $j++) { 
                    $avance  = $sheetData[$i][$j] != '' ? $sheetData[$i][$j] : 0;
                    array_push($rubValues, [$id, $sheetData[0][$j], $avance]);
                }
            }
            $sql = "REPLACE INTO llx_Paie_UserParameters (userid, rub, amount) values ";
            foreach ($rubValues as $value) {
                $sql .= "($value[0], $value[1], '$value[2]'),";
            }
            $sql = substr($sql, 0, -1);
            $res = $db->query($sql);
            if($res === TRUE){
            }
        }else{
            $fileError = "le fichier empty";
        }
    }else{
        $fileError = "le fichier non autorisé. Uniquement .csv, .xls ou .xlsx";
    }
    $db->close();
    header('Location: /RH/Bulletin/importerPrimes.php');
}

$text = "Attacher Les Primes";

llxHeader("", "$text");

print_barre_liste($text, $page, $_SERVER["PHP_SELF"], $param, $sortfield, $sortorder, '', $num, $nbtotalofrecords, 'setup', 0, $morehtmlright.' '.$newcardbutton, '', $limit, 0, 0, 1);


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
        #file-upload-form p button, .exporter{
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


// exporter
print "
    <form enctype='multipart/form-data'  method='post' action='" . $_SERVER['PHP_SELF'] ."'>
        <input type='hidden' name='action' value='exporter'>
        <input type='hidden' name='token' value='".newToken()."'>";
        foreach ($importable as $rub) {
           print "
           <label>$rub[0] : $rub[1]</label>
           <input type='checkbox' name='rubs[]' value='$rub[0]'><br>";
        }
            
    print "</select>
        <p><button class='exporter' type='submit'>Exporter</button></p>";
    print '</form>';



print "
    <form enctype='multipart/form-data' id='file-upload-form' class='uploader' method='post' action='" . $_SERVER['PHP_SELF'] ."'>
        <input type='hidden' name='action' value='import'>
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

$employees = array();
$sql = "SELECT ef.matricule, u.firstname, u.lastname, u.rowid FROM `llx_user` as u LEFT JOIN llx_user_extrafields as ef ON u.rowid = ef.fk_object where u.employee=1";
$res = $db->query($sql);
if ($res->num_rows) {
    while ($row = $res->fetch_assoc()) {
        array_push($employees, [$row['rowid'], $row['matricule'], $row['firstname'] .' '.$row['lastname']]);
    }
}
print '<table border="1" style="border-collapse: collapse;"><thead><tr style="background-color: #dfdfdf;font-weight: 600;font-size: 12px;"><td>Matricule</td><td>Nom Complet</td>';
foreach ($importable as $rub) {
    print "<td>$rub[1]</td>";
}
print "</tr></thead><tbody>";
foreach ($employees as $employee) {
    print "<tr><td>$employee[1]</td><td>$employee[2]</td>";
    foreach ($importable as $rub) {
        $sql = "SELECT amount from llx_Paie_UserParameters WHERE userid=" . $employee[0] . " AND rub=" . $rub[0];
        $res1 = $db->query($sql);
        $amount=0;
        if ($res1->num_rows > 0) {
            $amount = $res1->fetch_assoc()["amount"];
        }
        print "<td>$amount</td>";
    }
}
print "</thead></table>";





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
    <style>
        td{
            text-align: center;
        }
    </style>
    
';



?>