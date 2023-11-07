<?php
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);


// Load Dolibarr environment
require '../../main.inc.php';

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

llxHeader("", "Correction Pointage");
$text = "CORRECTION";
print_barre_liste($text, $page, $_SERVER["PHP_SELF"], $param, $sortfield, $sortorder, "", $num, $nbtotalofrecords, 'object_calendar', 0, $morehtmlright . ' ' . $newcardbutton, '', 0, 0, 1);

show();


if ($action) {
    Confirmer();
}

function show()
{
    global $db;
    $sql = "SELECT e.userid, u.name, e.time FROM P_ENTRER e, P_USER u where u.userid=e.userid  ORDER BY time";
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
                <th class="wrapcolumntitle liste_titre">Edit</th>
            </tr>';

    if (((object)$resE)->num_rows > 0) {
        while ($rowe = ((object)$resE)->fetch_assoc()) {
            $sql = "SELECT * FROM `P_SORTIE` where userid=" . $rowe['userid'] . " and DATE(time)='" . date("Y-m-d", strtotime($rowe['time'])) . "'";
            $resS = $db->query($sql);
            $sql = "select * from P_ENTRER where userid=" . $rowe['userid'] . " and DATE(time)='" . date("Y-m-d", strtotime($rowe['time'])) . "'";
            $rest = $db->query($sql);
            if (((object)$resS)->num_rows == ((object)$rest)->num_rows) {
                //print("<br>U:".$rowe['userid']." D:".date("Y-m-d", strtotime($rowe['time']))." E:((object)$rest)->num_rows ; S:((object)$resS)->num_rows");
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

                    echo '<tr>
                    <td >' . $rowe["userid"] . '</td>
                    <td >' . $rowe["name"] . '</td>
                    <td > ' . date("d/m/Y", $t1) . '</td>
                    <td > <input type="text" class="txtTime" name="txtE" value="' . date("H:i:s", $t1) . '" disabled></td>
                    <td > <input type="text" class="txtTime" name="txtS" value="' . date("H:i:s", $t2) . '" disabled></td>
                    <td >' . $h . ":" . $m . '</td>
                    <td > <input type="button" name="btnedit" class="button" value="EDIT" onclick="edit(this)"> </td>
                     <input type="hidden" name="date" value="' . date("d-m-Y", $t1) . '">
                    <input type="hidden" name="name" value="' . $rowe["name"] . '">
                    <input type="hidden" name="userid" value="' . $rowe["userid"] . '">
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

    if ($userid && $E && $date) {
        $time = date("Y-m-d H:i:s", strtotime($date . " " . $E));
        $sql = "SELECT * FROM P_ENTRER WHERE userid=$userid AND time='$time'";
        $res = $db->query($sql);
        if (((object)$res)->num_rows == 0) {
            $sql = "INSERT INTO P_ENTRER(userid, time) VALUES($userid, '$name', '$time');";
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

