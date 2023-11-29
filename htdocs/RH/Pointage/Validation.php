<?php
// ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);


// Load Dolibarr environment
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';

if (!$user->rights->user->user->lire && !$user->admin) {
    accessforbidden();
}

// Load variable for pagination
$limit = GETPOST('limit', 'int') ? GETPOST('limit', 'int') : $conf->liste_limit;
$sortfield = GETPOST('sortfield', 'alpha');
$sortorder = GETPOST('sortorder', 'alpha');
$action = GETPOST('action', 'aZ09');

$page = GETPOSTISSET('pageplusone') ? (GETPOST('pageplusone') - 1) : GETPOST("page", 'int');

if (empty($page) || $page == -1) {
    $page = 0;
}     // If $page is not defined, or '' or -1
$offset = $limit * $page;
$pageprev = $page - 1;
$pagenext = $page + 1;
if (!$sortorder) $sortorder = "DESC";
if (!$sortfield) $sortfield = "cp.rowid";


llxHeader("", "Validation Pointage");
$text = "VALIDATION";
print_barre_liste($text, $page, $_SERVER["PHP_SELF"], $param, $sortfield, $sortorder, "", $num, $nbtotalofrecords, 'object_calendar', 0, $morehtmlright . ' ' . $newcardbutton, '', 0, 0, 1);


$mydate = getdate(date("U"));
$day = (GETPOST('reday') != '') ? GETPOST('reday') : $mydate['mday'];
$month = (GETPOST('remonth') != '') ? GETPOST('remonth') : $mydate['mon'];
$year = (GETPOST('reyear') != '') ? GETPOST('reyear') : $mydate['year'];


$now = dol_now();
$daytoparse = $now;
if ($year && $month && $day) $daytoparse = dol_mktime(0, 0, 0, $month, $day, $year);

$prev = dol_getdate($daytoparse - (24 * 3600));
$prev_year  = $prev['year'];
$prev_month = $prev['mon'];
$prev_day   = $prev['mday'];

$next = dol_getdate($daytoparse + (24 * 3600));
$next_year  = $next['year'];
$next_month = $next['mon'];
$next_day   = $next['mday'];

set_exception_handler('exception_handler');

filter();
getUsers();
getInData();
getOutData();
show($day, $month, $year);

if ($action) {
    if ($action == 'delete') {
        $sql = "DELETE FROM P_Valide WHERE Cloturé = 1;";
        $res = $db->query($sql);
    }
    if ($action == 'validate') {
        validate();
    }
    if ($action == 'cloturervalide') {
        cloturéValide();
    }
    if ($action == 'cloturerNotvalide') {
        cloturéNotValide();
    }
}

//filter by date
function filter()
{
    global $form, $dateinvoice, $day, $month, $year, $prev_year, $prev_month, $prev_day, $next_year, $next_month, $next_day, $param, $langs;

    print '<div class="right">';
    print '<form id="frmfilter" name="filter" action="' . $_SERVER["PHP_SELF"] . '" method="GET">';
    print '<input type="hidden" name=action value="filter">';

    // Show navigation bar
    $nav = '<a class="inline-block valignmiddle" href="?reyear=' . $prev_year . "&amp;remonth=" . $prev_month . "&amp;reday=" . $prev_day . $param . '">' . img_previous($langs->trans("Previous")) . "</a>\n";
    $nav .= dol_print_date(dol_mktime(0, 0, 0, $month, $day, $year), "%A") . ' ';
    $nav .= " <span id=\"month_name\">" . dol_print_date(dol_mktime(0, 0, 0, $month, $day, $year), "day") . " </span>\n";
    $nav .= '<a class="inline-block valignmiddle" href="?reyear=' . $next_year . "&amp;remonth=" . $next_month . "&amp;reday=" . $next_day . $param . '">' . img_next($langs->trans("Next")) . "</a>\n";
    //$nav .= " &nbsp; (<a href=\"?year=".$nowyear."&amp;month=".$nowmonth."&amp;day=".$nowday.$param."\">".$langs->trans("Today")."</a>)";
    $nav .= ' ' . $form->selectDate(-1, '', 0, 0, 2, "addtime", 1, 1) . ' ';
    //$nav .= ' <input type="submit" name="submitdateselect" class="button valignmiddle" value="'.$langs->trans("Refresh").'">';
    $nav .= ' <button type="submit" name="button_search_x" value="x" class="bordertransp"><span class="fa fa-search"></span></button>';

    print $nav;

    //print '<input type="submit" class="button" value="Filtrer">';
    print '</div>';
    print '</form>';
}

function getUsers()
{
    global $db, $object;

    $serverName = "10.20.30.106";
    $connectionOptions = array(
        "database" => "zkaccess",
        "uid" => "zk",
        "pwd" => "Rayane@25031971+Roma"
    );
    // Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if (!$conn) {
        die(formatErrors(sqlsrv_errors()));
    } else {
        echo "Connected successfully!";
    }
    
    echo 'test';
   
    

    // Select Query
    $tsql = "SELECT userid, name FROM userinfo";

    // Executes the query
    $stmt = sqlsrv_query($conn, $tsql);

    // Error handling
    if ($stmt === false) {
        die(formatErrors(sqlsrv_errors()));
    }

       


    $sql = "CREATE TABLE IF NOT EXISTS P_USER(userid int(10) PRIMARY KEY, name nvarchar(100));";
    $res = $db->query($sql);
    if (!$res) print("<br>fail ERR: " . $sql);


    while ($user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

        $sql = "SELECT * FROM P_USER WHERE userid=" . $user['userid'];
        $res = $db->query($sql);

        if ($res->num_rows == 0) {
            $sql = "SELECT idpointage FROM " . MAIN_DB_PREFIX . "user_extrafields WHERE idpointage=" . $user['userid'];
            $res = $db->query($sql);

            if ($res->num_rows > 0) {
                $sql = "INSERT INTO P_USER (userid, name)
                    values(" . $user['userid'] . ",'" . $user['name'] . "')";
                $res = $db->query($sql);
            }
            if (!$res) print("<br>fail ERR: " . $sql);
        }
    }
}

function getInData()
{
    global $db;

    $serverName = "192.168.1.245";
    $connectionOptions = array(
        "database" => "zkaccess",
        "uid" => "zk",
        "pwd" => "Rayane@25031971+Roma"
    );

    // Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn === false) {
        die(formatErrors(sqlsrv_errors()));
    }

    // get logs from database (sn is serial of  the in-door)
    $tsql = "SELECT userid, checktime FROM CHECKINOUT WHERE sn='BRE3194560363'";

    // Executes the querys
    $stmt = sqlsrv_query($conn, $tsql);



    $sql = "SELECT userid, name from P_USER";
    $result = $db->query($sql);


    //print_r $result1->fetchAll();
    $checks = array();

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $checks[] = $row;
    }
    //print_r ($checks);
    $data = array();
    if (((object)$result)->num_rows > 0) {
        while ($user = ((object)$result)->fetch_assoc()) {
            foreach ($checks as $check) {
                if ($user['userid'] == $check['userid']) {
                    $data[] = array('id' => $user['userid'], 'time' => $check['checktime']);
                }
            }
        }
    }



    $checks = "";

    usort($data, function ($a, $b) {
        return $a['time'] <=> $b['time'];
    });

    //$sql = "DROP TABLE IF EXISTS P_ENTRER;";
    //$res = $db->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS P_ENTRER(id int(10) PRIMARY KEY AUTO_INCREMENT, userid int not null, time datetime, 
                FOREIGN KEY (userid) REFERENCES P_USER(userid))";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    if (count($data) > 0) {
        for ($i = 0; $i < count($data) - 1; $i++) {
            if ($data[$i]['id'] == $data[$i + 1]['id']) {
                $t1 = date_format($data[$i]['time'], "d/m/y h");
                $t2 = date_format($data[$i + 1]['time'], "d/m/y h");
                if ($t1 == $t2) {
                    continue;
                }
            }

            $sql = "SELECT * FROM P_ENTRER WHERE userid=" . $data[$i]['id'] . " and time='" . date_format($data[$i]['time'], "Y-m-d H:i:s") . "'";
            $res = $db->query($sql);
            if (((object)$res)->num_rows == 0) {
                $sql = "INSERT INTO P_ENTRER (userid, time)
            values(" . $data[$i]['id'] . ", '" . date_format($data[$i]['time'], "Y-m-d H:i:s") . "');";
                $res = $db->query($sql);
                if ($res);
                else print("<br>fail ERR $i: " . $sql);
            }
        }

        $sql = "SELECT * FROM P_ENTRER WHERE userid=" . $data[count($data) - 1]['id'] . " and time='" . date_format($data[count($data) - 1]['time'], "Y-m-d H:i:s") . "'";
        $res = $db->query($sql);
        if (((object)$res)->num_rows == 0) {
            $sql = "INSERT INTO P_ENTRER (userid, time)
            values(" . $data[count($data) - 1]['id'] . ", '" . date_format($data[count($data) - 1]['time'], "Y-m-d H:i:s") . "');";
            $res = $db->query($sql);
            if ($res);
            else print("<br>fail ERR last: " . $sql);
        }
        $data = "";
    }
}


function getOutData()
{
    global $db;

    $serverName = "192.168.1.245";
    $connectionOptions = array(
        "database" => "zkatt",
        "uid" => "zk",
        "pwd" => "Rayane@25031971+Roma"
    );

    // Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn === false) {
        die(formatErrors(sqlsrv_errors()));
    }

    // Select Query
    $tsql = "SELECT userid, checktime FROM CHECKINOUT";
    // $tsql = "SELECT u.Badgenumber, c.checktime FROM CHECKINOUT as c, USERINFO as u WHERE u.userid=c.userid AND u.Badgenumber= ORDER BY c.checktime";

    // Executes the query
    $stmt = sqlsrv_query($conn, $tsql);


    $checks = array();

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $checks[] = $row;
    }

    $sql = "SELECT userid, Badgenumber from USERINFO";
    $stmt = sqlsrv_query($conn, $sql);

    $users = array();
    while ($user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $sql = "SELECT u.userid, u.name from P_USER u where u.userid=" . $user['Badgenumber'];
        $resu = $db->query($sql);
        if (((object)$resu)->num_rows > 0) {
            $users[] = $user;
        }
    }

    //print_r ($checks);
    $data = array();
    foreach ($users as $user) {
        foreach ($checks as $check) {
            if ($user['userid'] == $check['userid']) {
                $data[] = array('id' => $user['Badgenumber'], 'time' => $check['checktime']);
            }
        }
    }
    $checks = "";

    usort($data, function ($a, $b) {
        return $a['time'] <=> $b['time'];
    });

    // $sql = "DROP TABLE IF EXISTS P_SORTIE;";
    // $res = $db->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS P_SORTIE(id int(10) PRIMARY KEY AUTO_INCREMENT, userid int not null, time datetime, 
                FOREIGN KEY (userid) REFERENCES P_USER(userid))";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    if (count($data) > 0) {
        $sql = "SELECT * FROM P_SORTIE WHERE userid=" . $data[0]['id'] . " and time='" . date_format($data[0]['time'], "Y-m-d H:i:s") . "'";
        $res = $db->query($sql);

        if (((object)$res)->num_rows == 0) {
            $sql = "INSERT INTO P_SORTIE (userid, time)
            values(" . $data[0]['id'] . ", '" . date_format($data[0]['time'], "Y-m-d H:i:s") . "');";
            $res = $db->query($sql);
            if ($res);
            else print("<br>fail ERR 0: " . $sql);
        }

        for ($i = 1; $i < count($data); $i++) {
            if ($data[$i]['id'] == $data[$i - 1]['id']) {
                $t1 = date_format($data[$i]['time'], "d/m/y H");
                $t2 = date_format($data[$i - 1]['time'], "d/m/y H");
                if ($t1 == $t2) {
                    continue;
                }
            }

            $sql = "SELECT * FROM P_SORTIE WHERE userid=" . $data[$i]['id'] . " and time='" . date_format($data[$i]['time'], "Y-m-d H:i:s")  . "'";
            $res = $db->query($sql);
            $sql = "SELECT `rowid` FROM IG_user g, P_USER u where u.userid=" . $data[$i]['id'];
            $users = $db->query($sql);
            if (((object)$res)->num_rows == 0) {
                $sql = "INSERT INTO P_SORTIE (userid, time)
            values(" . $data[$i]['id'] . ", '" . date_format($data[$i]['time'], "Y-m-d H:i:s") . "');";
                $res = $db->query($sql);
                if ($res);
                else print("<br>fail ERR $i: " . $sql);
            }
        }
    }
    $data = "";
}


function show($day, $month, $year)
{
    global $db;
    $sql = "SELECT e.id, e.userid, u.name, e.time FROM P_ENTRER e, P_USER u where u.userid=e.userid AND DATE(e.time)='" . $year . "-" . $month . "-" . $day . "' ORDER BY e.time";
    $resE = $db->query($sql);

    echo
        '<table id="tblpoitage" class="tagtable liste">
            <tr class="liste_titre">
                <th class="wrapcolumntitle liste_titre">Id</th>
                <th class="wrapcolumntitle liste_titre">Name</th>
                <th class="wrapcolumntitle liste_titre">Date</th>
                <th class="wrapcolumntitle liste_titre">Entrer</th>
                <th class="wrapcolumntitle liste_titre">Sortie</th>
                <th class="wrapcolumntitle liste_titre">nombre d\'heures</th>
                <th class="wrapcolumntitle liste_titre">Validé</th>
            </tr>';

    if (((object)$resE)->num_rows > 0) {
        while ($rowe = ((object)$resE)->fetch_assoc()) {
            $sql = "SELECT * FROM `P_SORTIE` where userid=" . $rowe['userid'] . " and DATE(time)='" . date("Y-m-d", strtotime($rowe['time'])) . "'";
            $resS = $db->query($sql);
            $sql = "select * from P_ENTRER where userid=" . $rowe['userid'] . " and DATE(time)='" . date("Y-m-d", strtotime($rowe['time'])) . "'";
            $rest = $db->query($sql);
            if (((object)$resS)->num_rows != ((object)$rest)->num_rows) {
                //print("<br>U:".$rowe['userid']." D:".date("Y-m-d", strtotime($rowe['time']))." E:$rest->num_rows ; S:((object)$resS)->num_rows");
                continue;
            }

            if (((object)$resS)->num_rows > 0) {
                while ($rows = ((object)$resS)->fetch_assoc()) {
                    $t1 = strtotime($rowe['time']);
                    $t2 = strtotime($rows['time']);
                    $h1 = (int)date("H", $t1);
                    $h2 = (int)date("H", $t2);
                    $m1 = (int)date("i", $t1);
                    $m2 = (int)date("i", $t2);
                    $h = $h2 - $h1;
                    $m = $m2 - $m1;
                    //if($h<0) continue;
                    if ($m < 0) {
                        $h -= 1;
                        $m = 60 + $m;
                    }
                    $sql = "SELECT * FROM P_Valide WHERE IdE=" . $rowe['id'] . " and IdS=" . $rows['id'];
                    $res = $db->query($sql);

                    //check validation
                    $valide = "";
                    if (((object)$res)->num_rows > 0) {
                        $cloturé = ((object)$res)->fetch_assoc()['Cloturé'];
                        if ($cloturé == '2') {
                            continue;
                        } else if ($cloturé == '1') {
                            $valide = "checked";
                        } else {
                            $valide = "disabled";
                        }
                    }

                    echo '<tr>
                    <td >' . $rowe["userid"] . '</td>
                    <td >' . $rowe["name"] . '</td>
                    <td >' . date("d/m/Y", $t1) . '</td>
                    <td >' . date("H:i:s", $t1) . '</td>
                    <td >' . date("H:i:s", $t2) . '</td>
                    <td >' . $h . ":" . $m . '</td>
                    <td > <input type="checkbox" name="checkpiont" ' . $valide . '></td>
                     <input type="hidden" name="ide" value="' . $rowe["id"] . '"> 
                     <input type="hidden" name="ids" value="' . $rows["id"] . '"> 
                </tr>';
                }
            }
        }
    }
    print "</table>";
    print '<form id="frmvalide" name="validate" action="' . $_SERVER["PHP_SELF"] . '" method="post">
        <input type="hidden" name="token" value="' . newToken() . '">
        <input type="hidden" id="action" name="action">
        <input type="hidden" id="ide" name="IdE" value="">
        <input type="hidden" id="ids" name="IdS" value="">';

    print '<div class="center"><input type="button" id="btnValide" class="button" name="validé" value="Valider">';
    print '<input type="button" id="btnCloturé" class="button" name="cloturé" value="Cloturer" style="margin-left:40px;"></div>';

    print '</form>';

    print "<script>
            $('#btnValide').click(function(){
                var tmp=0;
                $('#action').val('delete');
                $.ajax({
                    url: '" . $_SERVER["PHP_SELF"] . "?action=delete',
                    type: 'post',
                    data:$('#frmvalide').serialize(),
                    success:function(){	
                    }
                });
	            $('#tblpoitage input[name=checkpiont]:checked').each(function () {
                    tmp+=1;
                    var ide = $(this).closest('tr').find('input[name=ide]').val();
                    var ids = $(this).closest('tr').find('input[name=ids]').val();
                    $('#action').val('validate');
                    $('#ide').val(ide);
                    $('#ids').val(ids);
                    // $('#frmvalide').submit();
	            	$.ajax({
	            		url: '" . $_SERVER["PHP_SELF"] . "?action=validate',
	            		type: 'post',
	            		data:$('#frmvalide').serialize(),
	            		success:function(){	
                        }
	            	});
	            });
                if(tmp>0){
                    alert('Please Wait for '+tmp/2+' seconds'); 
                }
                setTimeout(
                    function() 
                    {
                        location.reload(true);
                    }, tmp*500);
            });
            
            $('#btnCloturé').click(function(){
                var tmp=0;
                $('#action').val('delete');
                $.ajax({
                    url: '" . $_SERVER["PHP_SELF"] . "?action=delete',
                    type: 'post',
                    data:$('#frmvalide').serialize(),
                    success:function(){	
                    }
                });
                $('#tblpoitage input[name=checkpiont]').each(function () {
                    tmp+=1;
                    if($(this).prop('checked') == true){
                        var ide = $(this).closest('tr').find('input[name=ide]').val();
                        var ids = $(this).closest('tr').find('input[name=ids]').val();
                        $('#action').val('cloturervalide');
                        $('#ide').val(ide);
                        $('#ids').val(ids);
	            	    $.ajax({
	            	    	url: '" . $_SERVER["PHP_SELF"] . "',
	            	    	type: 'post',
	            	    	data:$('#frmvalide').serialize(),
	            	    	success:function(){	
                            }
	            	    });
                    }
                    else if($(this).prop('checked') == false){
                        var ide = $(this).closest('tr').find('input[name=ide]').val();
                        var ids = $(this).closest('tr').find('input[name=ids]').val();
                        $('#action').val('cloturerNotvalide');
                        $('#ide').val(ide);
                        $('#ids').val(ids);
	            	    $.ajax({
	            	    	url: '" . $_SERVER["PHP_SELF"] . "',
	            	    	type: 'post',
	            	    	data:$('#frmvalide').serialize(),
	            	    	success:function(){	
                            }
	            	    });
                    }        
                    
                });
                if(tmp>0){
                    alert('Please Wait for '+tmp/4+' seconds'); 
                }
                setTimeout(
                    function() 
                    {
                        location.reload(true);
                    }, tmp*250);
            });
        </script>";

    // print "<script>
    // 	$(document).ready(function(){
    // 		$('#re').val('".$day."/".$month."/".$year."');	
    // 	});
    // </script>";
}

function validate()
{
    global $db;

    //create table P_valide * * * cloturé 1:default, 2:validate, 0:eliminate
    $sql = "CREATE TABLE IF NOT EXISTS P_Valide(IdE int not null, IdS int not null, Cloturé int,
                primary key (IdE, IdS), FOREIGN KEY (IdE) REFERENCES P_ENTRER(id), FOREIGN KEY (IdS) REFERENCES P_SORTIE(id));";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    $ide = $_POST["IdE"];
    $ids = $_POST["IdS"];
    if ($ids && $ide) {
        $sql = "INSERT INTO P_Valide(IdE, IdS, Cloturé) VALUES($ide, $ids, 1);";
        $res = $db->query($sql);
        if (!$res) {
            print "ERR: $sql";
        }
    }
}

function cloturéValide()
{
    global $db;

    $sql = "CREATE TABLE IF NOT EXISTS P_Valide(IdE int not null, IdS int not null, Cloturé int,
                primary key (IdE, IdS), FOREIGN KEY (IdE) REFERENCES P_ENTRER(id), FOREIGN KEY (IdS) REFERENCES P_SORTIE(id));";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    $ide = $_POST["IdE"];
    $ids = $_POST["IdS"];
    if ($ids && $ide) {
        $sql = "INSERT INTO P_Valide(IdE, IdS, Cloturé) VALUES($ide, $ids, 2);";
        $res = $db->query($sql);
        if (!$res) {
            print "ERR: $sql";
        }
    }
}

function cloturéNotValide()
{
    global $db;

    $sql = "CREATE TABLE IF NOT EXISTS P_Valide(IdE int not null, IdS int not null, Cloturé int,
                primary key (IdE, IdS), FOREIGN KEY (IdE) REFERENCES P_ENTRER(id), FOREIGN KEY (IdS) REFERENCES P_SORTIE(id));";
    $res = $db->query($sql);
    if ($res);
    else print("<br>fail ERR: " . $sql);

    $ide = $_POST["IdE"];
    $ids = $_POST["IdS"];
    if ($ids && $ide) {
        $sql = "INSERT INTO P_Valide(IdE, IdS, Cloturé) VALUES($ide, $ids, 0);";
        $res = $db->query($sql);
        if (!$res) {
            print "ERR: $sql";
        }
    }
}

function formatErrors($errors)
{
    // Display errors
    echo "<h1>SQL Error:</h1>";
    echo "Error information: <br/>";
    foreach ($errors as $error) {
        echo "SQLSTATE: " . $error['SQLSTATE'] . "<br/>";
        echo "Code: " . $error['code'] . "<br/>";
        echo "Message: " . $error['message'] . "<br/>";
    }
}

function exception_handler($exception)
{
    echo "<h1>Failure</h1>";
    echo "Uncaught exception: ", $exception->getMessage();
}



// End of page
llxFooter();
$db->close();

