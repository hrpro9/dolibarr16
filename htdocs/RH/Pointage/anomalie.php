<?php
ini_set('display_errors', '1');
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

if ($action == 'Confirmer') {
    Confirmer();
}

llxHeader("", "Anomalie Pointage");

$text = "ANNOMALIE";
print_barre_liste($text, $page, $_SERVER["PHP_SELF"], $param, $sortfield, $sortorder, "", $num, $nbtotalofrecords, 'object_calendar', 0, $morehtmlright . ' ' . $newcardbutton, '', 0, 0, 1);


$mydate = getdate(date("U"));
$day = ($_GET['reday'] != '') ? $_GET['reday'] : $mydate['mday'];
$month = ($_GET['remonth'] != '') ? $_GET['remonth'] : $mydate['mon'];
$year = ($_GET['reyear'] != '') ? $_GET['reyear'] : $mydate['year'];

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



filter();

show($day, $month, $year);



//filter by date
function filter()
{
    global $form, $day, $month, $year, $prev_year, $prev_month, $prev_day, $next_year, $next_month, $next_day, $param, $langs;

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

// $date = "23-12-2020";
// $S = "12:55:00";

// $time = date("Y-m-d H:i:s", strtotime($date . " " . $S));
// $userid=4;

// $sql = "SELECT * FROM P_SORTIE WHERE userid=$userid AND time='$time'";
// if (((object)$res)->num_rows == 0) {
//     $sql = "INSERT INTO P_SORTIE(userid, time) VALUES($userid, '$time');";
//     $db->query($sql);
// }



function show($day, $month, $year)
{
    global $db;
    $sql = "SELECT `note` FROM IG_user";
    $users = $db->query($sql);

    // $sql = "SELECT * from P_ENTRER WHERE DATE(time)='$year-$month-$day'";
    // $resE = $db->query($sql);

    // $sql = "SELECT * from P_SORTIE WHERE DATE(time)='$year-$month-$day'";
    // $resS = $db->query($sql);

    echo
        '<table id="tblpoitage" class="tagtable liste">
            <tr class="liste_titre">
                <th class="wrapcolumntitle liste_titre">Id</th>
                <th class="wrapcolumntitle liste_titre">Name</th>
                <th class="wrapcolumntitle liste_titre">Date</th>
                <th class="wrapcolumntitle liste_titre">Entrer</th>
                <th class="wrapcolumntitle liste_titre">Sortie</th>
                <th class="wrapcolumntitle liste_titre">nombre d\'heures</th>
                <th class="wrapcolumntitle liste_titre">Edit</th>
    </tr>';

    if (((object)$users)->num_rows > 0) {
        while ($row = ((object)$users)->fetch_assoc()) {
            $sql = "SELECT u.userid, e.time, u.name from P_ENTRER e, P_USER u WHERE e.userid=u.userid AND DATE(e.time)='$year-$month-$day' and u.userid=" . $row['note'];
            $resE = $db->query($sql);

            $sql = "SELECT u.userid, s.time, u.name from P_SORTIE s, P_USER u WHERE s.userid=u.userid AND DATE(s.time)='$year-$month-$day' and u.userid=" . $row['note'];
            $resS = $db->query($sql);

            if (((object)$resE)->num_rows > 0 && ((object)$resS)->num_rows == 0) {
                while ($rowe = ((object)$resE)->fetch_assoc()) {
                    $t1 = strtotime($rowe['time']);
                    $t2 = '00:00:00';

                    echo '<tr>
                            <td >' . $rowe["userid"] . '</td>
                            <td >' . $rowe["name"] . '</td>
                            <td > ' . date("d/m/Y", $t1) . '</td>
                            <td > <input type="text" class="txtTime" name="txtE" value="' . date("H:i:s", $t1) . '" disabled></td>
                            <td > <input type="text" class="txtTime" name="txtS" value="' . $t2 . '" disabled></td>
                            <td > INCONNUE </td>
                            <td > <input type="button" name="btnedit" class="button" value="EDIT" onclick="edit(this)"> </td>
                             <input type="hidden" name="date" value="' . date("d-m-Y", $t1) . '">
                            <input type="hidden" name="userid" value="' . $rowe["userid"] . '">
                        </tr>';
                }
            } else if (((object)$resE)->num_rows == 0 && ((object)$resS)->num_rows > 0) {
                while ($rows = ((object)$resS)->fetch_assoc()) {
                    $t2 = strtotime($rows['time']);
                    $t1 = '00:00:00';

                    echo '<tr>
                            <td >' . $rows["userid"] . '</td>
                            <td >' . $rows["name"] . '</td>
                            <td > ' . date("d/m/Y", $t2) . '</td>
                            <td > <input type="text" class="txtTime" name="txtE" value="' . $t1 . '" disabled></td>
                            <td > <input type="text" class="txtTime" name="txtS" value="' . date("H:i:s", $t2) . '" disabled></td>
                            <td > INCONNUE </td>
                            <td > <input type="button" name="btnedit" class="button" value="EDIT" onclick="edit(this)"> </td>
                             <input type="hidden" name="date" value="' . date("d-m-Y", $t2) . '">
                            <input type="hidden" name="userid" value="' . $rows["userid"] . '">
                        </tr>';
                }
            } else if (((object)$resE)->num_rows == 0 && ((object)$resS)->num_rows == 0) {
                $sql = "SELECT * from P_USER where userid=" . $row['note'];
                $res = $db->query($sql);

                if (((object)$res)->num_rows > 0) {
                    $t2 = '00:00:00';
                    $t1 = '00:00:00';

                    $user = ((object)$res)->fetch_assoc();

                    echo '<tr>
                                <td >' . $user["userid"] . '</td>
                                <td >' . $user["name"] . '</td>
                                <td >' . $day . '/' . $month . '/' . $year . '</td>
                                <td > <input type="text" class="txtTime" name="txtE" value="' . $t1 . '" disabled></td>
                                <td > <input type="text" class="txtTime" name="txtS" value="' . $t2 . '" disabled></td>
                                <td > INCONNUE </td>
                                <td > <input type="button" name="btnedit" class="button" value="EDIT" onclick="edit(this)"> </td>
                                 <input type="hidden" name="date" value="' . $day . '-' . $month . '-' . $year . '">
                                <input type="hidden" name="userid" value="' . $user["userid"] . '">
                    </tr>';
                    echo '<tr>
                                <td >' . $user["userid"] . '</td>
                                <td >' . $user["name"] . '</td>
                                <td > ' . $day . '/' . $month . '/' . $year . '</td>
                                <td > <input type="text" class="txtTime" name="txtE" value="' . $t1 . '" disabled></td>
                                <td > <input type="text" class="txtTime" name="txtS" value="' . $t2 . '" disabled></td>
                                <td > INCONNUE </td>
                                <td > <input type="button" name="btnedit" class="button" value="EDIT" onclick="edit(this)"> </td>
                                 <input type="hidden" name="date" value="' . $day . '-' . $month . '-' . $year . '">
                                <input type="hidden" name="userid" value="' . $user["userid"] . '">
                    </tr>';
                }
            }
        }
    }





    print "</table>";
    print '<form id="frmvalide" name="validate" action="' . $_SERVER["PHP_SELF"] . '" method="post">
        <input type="hidden" name="token" value="' . newToken() . '">
        <input type="hidden" id="action" name="action" value="Confirmer">
        <input type="hidden" id="timeE" name="timeE" value="">
        <input type="hidden" id="date" name="date" value="">
        <input type="hidden" id="userid" name="userid" value="">
        <input type="hidden" id="timeS" name="timeS" value="">';

    print '<div class="center"><input type="button" id="btnConfirmer" class="button" name="save" value="Confirmer">';

    print '</form>';

    print "<script>

            $(function () {
                edit = function (btn) {
                    var txtE =$(btn).closest('tr').find('.txtTime');
                    txtE.prop('disabled', false);
                };
            });

            $('#btnConfirmer').click(function(){
                var tmp=0;
	            $('.txtTime:enabled[name=txtE]').each(function () {
                    tmp+=1;
                    var E = $(this).closest('tr').find('input[name=txtE]').val();
                    var S = $(this).closest('tr').find('input[name=txtS]').val();
                    var date = $(this).closest('tr').find('input[name=date]').val();
                    var userid = $(this).closest('tr').find('input[name=userid]').val();
                    console.log(userid+' '+name+' '+E+' '+S+' '+date);
                    $('#action').val('Confirmer');
                    $('#timeE').val(E);
                    $('#timeS').val(S);
                    $('#date').val(date);
                    $('#userid').val(userid);
	            	$.ajax({
	            		url: '" . $_SERVER["PHP_SELF"] . "',
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
    </script>";
}

function Confirmer()
{
    global $db;

    $E = $_POST["timeE"];
    $S = $_POST["timeS"];
    $date = $_POST["date"];
    $userid = $_POST["userid"];

    if ($E == "00:00:00" || $S == "00:00:00") return;

    if ($userid  && $E && $date) {
        $time = date("Y-m-d H:i:s", strtotime($date . " " . $E));
        $sql = "SELECT * FROM P_ENTRER WHERE userid=$userid AND time='$time'";
        $res = $db->query($sql);
        if (((object)$res)->num_rows == 0) {
            $sql = "INSERT INTO P_ENTRER(userid, time) VALUES($userid, '$time');";
            $db->query($sql);
        }
    }

    if ($userid && $S && $date) {
        $time = date("Y-m-d H:i:s", strtotime($date . " " . $S));
        $sql = "SELECT * FROM P_SORTIE WHERE userid=$userid AND time='$time'";
        $res = $db->query($sql);
        if (((object)$res)->num_rows == 0) {
            $sql = "INSERT INTO P_SORTIE(userid, time) VALUES($userid, '$time');";
            $db->query($sql);
        }
    }
}



// End of page
llxFooter();
$db->close();

