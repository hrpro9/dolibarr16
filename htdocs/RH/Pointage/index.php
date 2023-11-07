<?php

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
}

// If $page is not defined, or '' or -1
$offset = $limit * $page;
$pageprev = $page - 1;
$pagenext = $page + 1;
if (!$sortorder) $sortorder = "DESC";
if (!$sortfield) $sortfield = "cp.rowid";

llxHeader("", "Pointage");
$text = "POINTAGE";
print_barre_liste($text, $page, $_SERVER["PHP_SELF"], $param, $sortfield, $sortorder, "", $num, $nbtotalofrecords, 'object_calendar', 0, $morehtmlright . ' ' . $newcardbutton, '', 0, 0, 1);

show();



function show()
{
    global $db;
    $sql = "SELECT * from P_Valide where Cloturé=2";
    $res = $db->query($sql);

    echo '<script type="text/javascript"> 
            function showHideRow(row) { 
                console.log("#" + row);
                $("#" + row).toggle(); 
            } 
        </script> ';
    echo
        '<table id="tblpoitage" class="tagtable liste" style="text-align: center;">
            <tr class="liste_titre">
                <th class="wrapcolumntitle liste_titre">Date</th>
                <th class="wrapcolumntitle liste_titre">Id</th>
                <th class="wrapcolumntitle liste_titre">Name</th>
                <th class="wrapcolumntitle liste_titre">Entrer</th>
                <th class="wrapcolumntitle liste_titre">Sortie</th>
                <th class="wrapcolumntitle liste_titre">Entrer</th>
                <th class="wrapcolumntitle liste_titre">Sortie</th>
                <th class="wrapcolumntitle liste_titre">nombre d\'heures Pointé</th>
                <th class="wrapcolumntitle liste_titre">nombre d\'heures travaillé</th>
            </tr>';

    $data = array();
    if (((object)$res)->num_rows > 0) {
        while ($row = ((object)$res)->fetch_assoc()) {
            $sql = "SELECT e.id, e.userid, u.name, e.time FROM P_ENTRER e, P_USER u where u.userid=e.userid and e.id=" . $row['IdE'] . " ORDER BY time";
            $resE = $db->query($sql);
            $rowe = ((object)$resE)->fetch_assoc();
            $sql = "select * from P_SORTIE where id=" . $row['IdS'];
            $resS = $db->query($sql);
            $rows = ((object)$resS)->fetch_assoc();

            //Sum of working hours
            $sql = 'SELECT sum(task_duration) as duration FROM IG_projet_task_time t, IG_user u WHERE t.fk_user=u.rowid AND t.task_date=\'' . date("Y-m-d", strtotime($rowe['time'])) . '\' AND u.note='.$rowe["userid"];
            $rest = $db->query($sql);
            $duration = ((object)$rest)->fetch_assoc()['duration'];
            $ht = (int)((int)$duration / 3600);
            $mt = (int)(((int)$duration - $ht * 3600) / 60);
            $Timet = date('H:i', strtotime($ht . ":" . $mt));

            //tasks
            $sql='SELECT p.rowid as p_id, p.ref as p_ref, p.title as p_title, ta.ref as t_ref, ta.label as t_label, ta.rowid as ta_id, t.task_duration as duration FROM IG_projet_task_time t, IG_user u, IG_projet_task ta, IG_projet p 
            WHERE t.fk_user=u.rowid AND
            t.fk_task=ta.rowid AND p.rowid=ta.fk_projet
            AND t.task_date=\'' . date("Y-m-d", strtotime($rowe['time'])) . '\' AND u.note='.$rowe["userid"];
            $resp=$db->query($sql);

            $sql='SELECT DISTINCT p.rowid as p_id, p.ref as p_ref, p.title as p_title FROM IG_projet_task_time t, IG_user u, IG_projet_task ta, IG_projet p 
            WHERE t.fk_user=u.rowid AND
            t.fk_task=ta.rowid AND p.rowid=ta.fk_projet
            AND t.task_date=\'' . date("Y-m-d", strtotime($rowe['time'])) . '\' AND u.note='.$rowe["userid"];
            $resp=$db->query($sql);

            $projects=array();
            while($row=$resp->fetch_assoc()){
                $sql='SELECT ta.rowid, ta.ref as t_ref, ta.label as t_label, t.task_duration as duration FROM IG_projet_task_time t, IG_user u, IG_projet_task ta
                WHERE t.fk_user=u.rowid AND
                t.fk_task=ta.rowid AND ta.fk_projet='.$row["p_id"].'
                AND t.task_date=\'' . date("Y-m-d", strtotime($rowe['time'])) . '\' AND u.note='.$rowe["userid"];
                $respt=$db->query($sql);
                $tasks=$respt->fetch_all();
                // while($rowt=$respt->fetch_assoc()){
                //     $tasks=array(
                //         "ref"=>$rowt["t_ref"],
                //         "label"=>$rowt["t_label"],
                //         "duration"=>$rowt["duration"],
                //     );
                // }
                $projects[]=array(
                    "id"=>$row["p_id"],
                    "ref"=>$row["p_ref"],
                    "title"=>$row["p_title"],
                    "tasks"=>$tasks
                    );
            }

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
            if (count($data) > 0) {
                $exist = false;
                for ($i = 0; $i < count($data); $i++) {
                    $d = $data[$i];
                    if ($d["userid"] == $rowe["userid"] && $d["date"] == date("d/m/Y", $t1)) {
                        $exist = true;
                        $h = (int)explode(':', $d["hoursP"])[0] + $h;
                        $m = (int)explode(':', $d["hoursP"])[1] + $m;
                        if ($m > 59) {
                            $h += 1;
                            $m -= 60;
                        }
                        $data[$i] = array(
                            'userid' => $rowe["userid"],
                            'name' => $rowe["name"],
                            'date' => date("d/m/Y", $t1),
                            'tE1' => $d["tE1"],
                            'tS1' => $d["tS1"],
                            'tE2' => date("H:i:s", $t1),
                            'tS2' => date("H:i:s", $t2),
                            'hoursP' => date('H:i', strtotime($h . ":" . $m)),
                            'hoursT' => $Timet,
                            'projects'=>$projects
                        );
                    }
                }
                if (!$exist) {
                    $data[] = array(
                        'userid' => $rowe["userid"],
                        'name' => $rowe["name"],
                        'date' => date("d/m/Y", $t1),
                        'tE1' => date("H:i:s", $t1),
                        'tS1' => date("H:i:s", $t2),
                        'hoursP' => date('H:i', strtotime($h . ":" . $m)),
                        'hoursT' => $Timet,
                        'projects'=>$projects
                    );
                }
            } else {
                $data[] = array(
                    'userid' => $rowe["userid"],
                    'name' => $rowe["name"],
                    'date' => date("d/m/Y", $t1),
                    'tE1' => date("H:i:s", $t1),
                    'tS1' => date("H:i:s", $t2),
                    'hoursP' => date('H:i', strtotime($h . ":" . $m)),
                    'hoursT' => $Timet,
                    'projects'=>$projects
                );
            }
        }
    }
    usort($data, function ($a, $b) {
        return $a['date'] <=> $b['date'];
    });
    // print "cc<pre>";  
    // print_r($data);
    $i=0;
    foreach ($data as $d) {
        echo '<tr class="hoverRow" style="background-color:white" onclick="showHideRow(\'hidden_row' . $i . '\')">
            <td >' . $d["date"] . '</td>
            <td >' . $d["userid"] . '</td>
            <td >' . $d["name"] . '</td>
            <td >' . $d["tE1"] . '</td>
            <td >' . $d["tS1"] . '</td>
            <td >' . $d["tE2"] . '</td>
            <td >' . $d["tS2"] . '</td>
            <td >' . $d["hoursP"] . '</td>
            <td >' . $d["hoursT"] . '</td>
        </tr>';

        echo ' <tr id="hidden_row' . $i . '" style="display: none;">
            <td ></td>
            <td colspan=8>
                <table class="tagtable" align=center style="width:100%; border-collapse: collapse; text-align: center; " cellpadding=10>';

        foreach($d['projects'] as $p){
            echo '<tr  style="background-color: lightgray;">';
            echo '<td > <a href="/htdocs/projet/card.php?id='.$p["id"].'">'.$p["ref"].'</a></td>';
            echo '<td >'.$p["title"].'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td></td>';
            echo '<td>';
            echo '<table class="tagtable" align=center style="width:100%; border-collapse: collapse; text-align: center;" cellpadding=10>
                        <tr  style="background-color: lightgray;">
                            <th class="">ref</th>
                            <th class="">label</th>
                            <th class="">duration</th>
                        </tr>';
            foreach($p['tasks'] as $t){
                $ht = (int)((int)$t[3] / 3600);
                $mt = (int)(((int)$t[3] - $ht * 3600) / 60);
                $Timet = date('H:i', strtotime($ht . ":" . $mt));
                echo '<tr>';
                echo '<td> <a href="/htdocs/projet/tasks/task.php?id='.$t[0].'&withproject='.$p["id"].'">'.$t[1].'</a></td>';
                echo '<td>'.$t[2].'</td>';
                echo '<td>'.$Timet.'</td>';
                echo '</tr>';
            }

            echo '</tr>';

            echo '</table>
                </td>';
            echo '</tr>';
        }

        echo '</table>
            </td>
        </tr>';
        
        $i++;
    }
    print "</table>";

    print "<script>
        $('.hoverRow').hover(function() {
            $(this).css({'background-color':'green', 'cursor': 'pointer'});
        }, function() {
            $(this).css('background-color', 'white');
        });
    </script>";
}

function expand()
{
    $date = $_GET["date"];
    $name = $_GET["name"];

    print $date . " " . $name;
}

// End of page
llxFooter();
$db->close();

