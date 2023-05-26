<?php
 // Load Dolibarr environment

use Stripe\Terminal\Location;

 require '../../main.inc.php';
 require_once '../../vendor/autoload.php';
 require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
 require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
 require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
 llxHeader("", ""); 

 if(isset($_POST['ajouter']))
 {
    $annee = $_POST['annee'] ;
    $janv = intval($_POST['janv']) ?? 0;
    $fevr = intval($_POST['fevr']) ?? 0;
    $mars = intval($_POST['mars']) ?? 0;
    $avril = intval($_POST['avril']) ?? 0;
    $mai = intval($_POST['mai']) ?? 0;
    $juin = intval($_POST['juin']) ?? 0;
    $juillet = intval($_POST['juillet']) ?? 0;
    $août = intval($_POST['août']) ?? 0;
    $septembre = intval($_POST['septembre']) ?? 0;
    $octobre = intval($_POST['octobre']) ?? 0;
    $novembre = intval($_POST['novembre']) ?? 0;
    $décembre = intval($_POST['décembre']) ?? 0;
    $toal= $janv+$fevr+$mars+$avril+$mai+$juin+$juillet+$août+$septembre+$octobre+$novembre+$décembre;
    // Assuming you have a database connection established
    // Check if record with the same year exists
    if(isset($_GET['id'])){
        $id=$_POST['id'];
        $pdo_sql = "UPDATE llx_objectif_annuel SET janvier='$janv', février='$fevr', mars='$mars', avril='$avril',
                    mai='$mai', juin='$juin', juillet='$juillet', août='$août', septembre='$septembre', octobre='$octobre',
                    novembre='$novembre', décembre='$décembre', total='$toal', annee= '$annee' WHERE id=$id";
         $result = $db->query($pdo_sql);
        // // Check if the update was successful
        if ($result) {
            $redirectUrl = DOL_URL_ROOT.'/comm/objectif/saiseobjet.php?idmenu=21951&leftmenu=';
            echo "<script>window.location.href = '$redirectUrl';</script>";
           exit;
        }  
    }
    else{
        $annee_select=$_POST['annee_select'];
        $yearExistsQuery = "SELECT annee FROM llx_objectif_annuel WHERE annee = '$annee_select'";
        $result = $db->query($yearExistsQuery);  
        if (mysqli_num_rows($result) > 0) {
            // Year already exists, handle the error or take appropriate action
            print '
            <div class="alert" style="background-color: #f8d7da;border: 1px solid #f5c6cb;padding: 10px; color: #721c24;width:180px;">cette annee exist deja.</div>
                ';
        } else {
        // Insert the new record
        $insertQuery = "INSERT INTO llx_objectif_annuel (janvier, février, mars, avril, mai, juin, juillet, août, septembre, octobre, novembre, décembre, total, annee) 
                        VALUES ('$janv', '$fevr', '$mars', '$avril', '$mai', '$juin', '$juillet', '$août', '$septembre', '$octobre', '$novembre', '$décembre', '$toal', '$annee_select')";
         $res = $db->query($insertQuery);
        }
    }
 }
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $pdo_sql = "SELECT * FROM llx_objectif_annuel WHERE id=$id";
        $result = $db->query($pdo_sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $annee = $row['annee'];
            $janv = $row['janvier'];
            $fevr = $row['février'];
            $mars = $row['mars'];
            $avril=$row['avril'];
            $mai=$row['mai'];
            $juin=$row['juin'];
            $juillet=$row['juillet'];
            $août=$row['août'];
            $septembre=$row['septembre'];
            $octobre=$row['octobre'];
            $novembre=$row['novembre'];
            $décembre=$row['décembre'];
        }
    }
  function affichageAnnees(){
    $anneeDebut = date('Y');
    $anneeFin =date('Y')+1;
    for ($annee = $anneeDebut; $annee <= $anneeFin; $annee++) {  
      echo '<option value="' . $annee . '"> ' . $annee . '</option>';
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 90%;
        }

        #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        #customers td,#customers input {
            width: 92px
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: rgb(38,60,92);
        color: white;
        }
    </style>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Saisie objectif Annuel</h1>
    <form  method="post" >
    <?php
        if (isset($_GET['id'])) { echo '<input type="text"  readonly oninput="sumValues()" value="' . (isset($annee) ? 'annee modifier : '.$annee : '') . '">';  }
        else{ ?><select name="annee_select" required>  <option value="" > Année choisi : </option> <?php affichageAnnees() ?> </select><?php }
    ?>
    <table id="customers" >
        <tr>        
            <th>Janvier</th>
            <th>Février</th>
            <th>Mars</th>
            <th>Avril</th>
            <th>Mai</th>
            <th>Juin</th>
            <th>Juillet</th>
            <th>Août</th>
            <th>Septembre</th>
            <th>Octobre</th>
            <th>Novembre</th>
            <th>Décembre</th>
        </tr>
        <tr>
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <input type="hidden" name="annee" value="<?php echo isset($annee) ? $annee : ''; ?>">
            <?php
            if (isset($_GET['id'])) 
            {
                if (01>=date('m') || $annee>date('Y') ){echo '<td><input  type="number" min="0" step="any" name="janv" id="janv"  oninput="sumValues()" value="' . (isset($janv) ? $janv : '') . '"></td>'; }
                else{echo '<td><input type="number" min="0" step="any" name="janv" id="janv" readonly oninput="sumValues()" value="' . (isset($janv) ? $janv : '') . '"></td>'; }
                if (02>=date('m') || $annee>date('Y') ){ echo '<td><input type="number" min="0" step="any" name="fevr" id="fevr" oninput="sumValues()" value="' . (isset($fevr) ? $fevr : '') . '"></td>';  }
                else{  echo '<td><input type="number" min="0" step="any" name="fevr" id="fevr" readonly oninput="sumValues()" value="' . (isset($fevr) ? $fevr : '') . '"></td>'; }
                if (03>=date('m') || $annee>date('Y') ){ echo '<td><input type="number" min="0" step="any" name="mars" id="mars" oninput="sumValues()" value="' . (isset($mars) ? $mars : '') . '"></td>';  }
                else{  echo '<td><input type="number" min="0" step="any" name="mars" id="mars" readonly oninput="sumValues()" value="' . (isset($mars) ? $mars : '') . '"></td>'; }
                if (04>=date('m') || $annee>date('Y') ){ echo '<td><input type="number" min="0" step="any" name="avril" id="avril" oninput="sumValues()" value="' . (isset($avril) ? $avril : '') . '"></td>';}
                else{ echo '<td><input type="number" min="0" step="any" name="avril" id="avril" readonly oninput="sumValues()" value="' . (isset($avril) ? $avril : '') . '"></td>';}
                if (05>=date('m') || $annee>date('Y') ){ echo '<td><input type="number" min="0" step="any" name="mai" id="mai" oninput="sumValues()" value="' . (isset($mai) ? $mai : '') . '"></td>';}
                else{ echo '<td><input type="number" min="0" step="any" name="mai" id="mai" readonly oninput="sumValues()" value="' . (isset($mai) ? $mai : '') . '"></td>';}
                if (06>=date('m') || $annee>date('Y') ){ echo '<td><input type="number" min="0" step="any" name="juin" id="juin" oninput="sumValues()" value="' . (isset($juin) ? $juin : '') . '"></td>';}
                else{ echo '<td><input type="number" min="0" step="any" name="juin" id="juin" readonly oninput="sumValues()" value="' . (isset($juin) ? $juin : '') . '"></td>';}
                if (07>=date('m') || $annee>date('Y') ){ echo '<td><input type="number" min="0" step="any" name="juillet" id="juillet" oninput="sumValues()" value="' . (isset($juillet) ? $juillet : '') . '"></td>';}
                else{ echo '<td><input type="number" min="0" step="any" name="juillet" id="juillet" readonly oninput="sumValues()" value="' . (isset($juillet) ? $juillet : '') . '"></td>';}
                if (date('m') <= 8 || $annee > date('Y')) { echo '<td><input type="number" min="0" step="any" name="août" id="août" oninput="sumValues()" value="' . (isset($août) ? $août : '') . '"></td>'; }
                else { echo '<td><input type="number" min="0" step="any" name="août" id="août" readonly oninput="sumValues()" value="' . (isset($août) ? $août : '') . '"></td>';}
                if (date('m') <= 9 || $annee > date('Y')) { echo '<td><input type="number" min="0" step="any" name="septembre" id="septembre" oninput="sumValues()" value="' . (isset($septembre) ? $septembre : '') . '"></td>';} 
                else { echo '<td><input type="number" min="0" step="any" name="septembre" id="septembre" readonly oninput="sumValues()" value="' . (isset($septembre) ? $septembre : '') . '"></td>';  }
                if (date('m') <= 10 || $annee > date('Y')) {   echo '<td><input type="number" min="0" step="any" name="octobre" id="octobre" oninput="sumValues()" value="' . (isset($octobre) ? $octobre : '') . '"></td>';   }
                else { echo '<td><input type="number" min="0" step="any" name="octobre" id="octobre" readonly oninput="sumValues()" value="' . (isset($octobre) ? $octobre : '') . '"></td>';   }
                if (date('m') <= 11 || $annee > date('Y')) { echo '<td><input type="number" min="0" step="any" name="novembre" id="novembre" oninput="sumValues()" value="' . (isset($novembre) ? $novembre : '') . '"></td>';   } 
                else {  echo '<td><input type="number" min="0" step="any" name="novembre" id="novembre" readonly oninput="sumValues()" value="' . (isset($novembre) ? $novembre : '') . '"></td>';      }
                if (date('m') <= 12 || $annee > date('Y')) {  echo '<td><input type="number" min="0" step="any" name="décembre" id="décembre" oninput="sumValues()" value="' . (isset($décembre) ? $décembre : '') . '"></td>'; } 
                else {  echo '<td><input type="number" min="0" step="any" name="décembre" id="décembre" readonly oninput="sumValues()" value="' . (isset($décembre) ? $décembre : '') . '"></td>';  }
            }else{
                echo '<td><input  type="number" min="0" step="any" name="janv" id="janv" oninput="sumValues()" value="' . (isset($janv) ? $janv : '') . '"></td>'; 
                echo '<td><input  type="number" min="0" step="any" name="fevr" id="fevr" oninput="sumValues()" value="' . (isset($fevr) ? $fevr : '') . '"></td>'; 
                echo '<td><input  type="number" min="0" step="any" name="mars" id="mars" oninput="sumValues()" value="' . (isset($mars) ? $mars : '') . '"></td>'; 
                echo '<td><input  type="number" min="0" step="any" name="avril" id="avril" oninput="sumValues()" value="' . (isset($avril) ? $avril : '') . '"></td>';
                echo '<td><input  type="number" min="0" step="any" name="mai" id="mai" oninput="sumValues()" value="' . (isset($mai) ? $mai : '') . '"></td>'; 
                echo '<td><input  type="number" min="0" step="any" name="juin" id="juin" oninput="sumValues()" value="' . (isset($juin) ? $juin : '') . '"></td>'; 
                echo '<td><input  type="number" min="0" step="any" name="juillet" id="juillet" oninput="sumValues()" value="' . (isset($juillet) ? $juillet : '') . '"></td>'; 
                echo '<td><input  type="number" min="0" step="any" name="août" id="août" oninput="sumValues()" value="' . (isset($août) ? $août : '') . '"></td>'; 
                echo '<td><input  type="number" min="0" step="any" name="septembre" id="septembre" oninput="sumValues()" value="' . (isset($septembre) ? $septembre : '') . '"></td>'; 
                echo '<td><input  type="number" min="0" step="any" name="octobre" id="octobre" oninput="sumValues()" value="' . (isset($octobre) ? $octobre : '') . '"></td>'; 
                echo '<td><input  type="number" min="0" step="any" name="novembre" id="novembre" oninput="sumValues()" value="' . (isset($novembre) ? $novembre : '') . '"></td>';
                echo '<td><input  type="number" min="0" step="any" name="décembre" id="décembre" oninput="sumValues()" value="' . (isset($décembre) ? $décembre : '') . '"></td>';
            }
           ?>
        </tr>
    </table>
    <p id="result"></p>
    <button type="submit" name="ajouter"  style="background: rgb(38,60,92);padding: 8px 15px 8px 15px;border: none;color: #fff;" >
    <?php
    if (isset($_GET['id'])) {   echo 'modifier'; }else{echo "ajouter";}
    ?>
    </button>
</form>
<script>
    function sumValues() {
        var janv = parseFloat(document.getElementById("janv").value) ?? 0;
        var fevr = parseFloat(document.getElementById("fevr").value) ?? 0;
        var mars = parseFloat(document.getElementById("mars").value) ?? 0;
        var avril = parseFloat(document.getElementById("avril").value) ?? 0;
        var mai = parseFloat(document.getElementById("mai").value) ?? 0;
        var juin = parseFloat(document.getElementById("juin").value) ?? 0;
        var juillet = parseFloat(document.getElementById("juillet").value) ?? 0;
        var aout = parseFloat(document.getElementById("août").value) ?? 0;
        var septembre = parseFloat(document.getElementById("septembre").value) ?? 0;
        var octobre = parseFloat(document.getElementById("octobre").value) ?? 0;
        var novembre = parseFloat(document.getElementById("novembre").value) ?? 0;
        var decembre = parseFloat(document.getElementById("décembre").value) ?? 0;
        var sum = janv + fevr + mars + avril + mai + juin + juillet + aout + septembre + octobre + novembre + decembre;
       document.getElementById("result").textContent = "Total mois : " + sum ;
    }
</script>
<h2>Liste objectif Annuel</h2>
    <table id="customers" >
        <tr>        
        <th>annee</th>
            <th>Janvier</th>
            <th>Février</th>
            <th>Mars</th>
            <th>Avril</th>
            <th>Mai</th>
            <th>Juin</th>
            <th>Juillet</th>
            <th>Août</th>
            <th>Septembre</th>
            <th>Octobre</th>
            <th>Novembre</th>
            <th>Décembre</th>
            <th>total</th>
            <th>action</th>
        </tr>
        <?php
         $anneenow = date('Y');
         $sql = "SELECT *  FROM llx_objectif_annuel WHERE annee>=$anneenow  ";
         $rest = $db->query($sql);
     
         foreach ($rest as $row) {
        
          $id=$row['id'];
         ?>
             <tr>
                 <th scope="row"> 
               
                  <?= $row['annee'] ?>
                 </th>
                
                 <td>
                 <?= $row['janvier'] ?>
                
                 </td>
                 <td>
                 <?= $row['février'] ?>
                 </td>
                 <td>
                 <?= $row['mars'] ?>
                 </td>
                 <td>
                 <?= $row['avril'];  ?>
                 </td>
                 <td>
                 <?= $row['mai'] ?>
                 </td>
                 <td>
                 <?= $row['juin'] ?>
                 </td>
                 <td>
                 <?= $row['juillet'] ?>
                 </td>
                 <td>
                 <?= $row['août'] ?>
                 </td>
                 <td>
                 <?= $row['septembre'] ?>
                 </td>
                 <td>
                 <?= $row['octobre'] ?>
                 </td>
                 <td>
                 <?= $row['novembre'] ?>
                 </td>
                 <td>
                 <?= $row['décembre'] ?>
                 </td>
                 <td>
                 <?= $row['total'] ?>
                 </td>
                 <td>
                  <a href="saiseobjet.php?id=<?=$id?>"  > <input type="button"  value="modifier" style="background: #04AA6D;padding: 8px 15px 8px 15px;border: none;color: #fff;" /></a>
                 </td>
             </tr>
         <?php
         }
         ?>

        </tr> 
      <?php
         $anneenow = date('Y')-1;
         $sql = "SELECT *  FROM llx_objectif_annuel WHERE annee<=$anneenow ";
         $rest = $db->query($sql);
         
         foreach ($rest as $row) {
         ?>
             <tr>
                 <th scope="row">
                     <?= $row['annee'] ?>
                 </th>
                 <td>
                     <?= $row['janvier'] ?>
                 </td>
                 <td>
                     <?= $row['février'] ?>
                 </td>
                 <td>
                     <?= $row['mars'] ?>
                 </td>
                 <td>
                     <?= $row['avril'];  ?>
                 </td>
                 <td>
                 <?= $row['mai'] ?>
                 </td>
                 <td>
                 <?= $row['juin'] ?>
                 </td>
                 <td>
                 <?= $row['juillet'] ?>
                 </td>
                 <td>
                 <?= $row['août'] ?>
                 </td>
                 <td>
                 <?= $row['septembre'] ?>
                 </td>
                 <td>
                 <?= $row['octobre'] ?>
                 </td>
                 <td>
                 <?= $row['novembre'] ?>
                 </td>
                 <td>
                 <?= $row['décembre'] ?>
                 </td>
                 <td>
                 <?= $row['total'] ?>
                 </td>
               
             </tr>
         <?php
         }
         ?>  
    </table>
    </table>
  
   
   
  







</body>
</html>