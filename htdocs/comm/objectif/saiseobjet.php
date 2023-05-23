<?php
 // Load Dolibarr environment
 require '../../main.inc.php';
 require_once '../../vendor/autoload.php';
 require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
 require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
 require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
 llxHeader("", ""); 

 if(isset($_POST['ajouter']))
 {
    $annee_select=$_POST['annee_select'];
    $a=0;
    
  
    $janv=$_POST['janv'];
    $fevr=$_POST['fevr'];
    $mars=$_POST['mars'];
    $avril=$_POST['avril'];
    $mai=$_POST['mai'];
    $juin=$_POST['juin'];
    $juillet=$_POST['juillet'];
    $aout=$_POST['aout'];
    $septembre=$_POST['septembre'];
    $octobre=$_POST['octobre'];
    $novembre=$_POST['novembre'];
    $decembre=$_POST['decembre'];
    $toal= $janv+$fevr+$mars+$avril+$mai+$juin+$juillet+$aout+$septembre+$octobre+$novembre+$decembre;

    // Assuming you have a database connection established

    // Check if record with the same year exists
    $yearExistsQuery = "SELECT annee FROM llx_objectif_annuel WHERE annee = '$annee_select'";
    $result = $db->query($yearExistsQuery);  
    if (mysqli_num_rows($result) > 0) {
        // Year already exists, handle the error or take appropriate action
        print '
        <div class="alert" style="background-color: #f8d7da;border: 1px solid #f5c6cb;padding: 10px; color: #721c24;width:180px;">cette mois exist deja.</div>
            ';
    } else {
    // Insert the new record
    $insertQuery = "INSERT INTO llx_objectif_annuel (janvier, février, mars, avril, mai, juin, juillet, août, septembre, octobre, novembre, décembre, total, annee) 
                    VALUES ('$janv', '$fevr', '$mars', '$avril', '$mai', '$juin', '$juillet', '$aout', '$septembre', '$octobre', '$novembre', '$decembre', '$toal', '$annee_select')";
     $res = $db->query($insertQuery);
    }



   


 }

  function affichageAnnees(){
    $anneeDebut = date('Y');
    $anneeFin =date('Y')+1;

    for ($annee = $anneeDebut; $annee <= $anneeFin; $annee++) {  
      echo '<option value="' . $annee . '"> Année chargé :  ' . $annee . '</option>';
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


    <h1>Saisie objet Annuel</h1>
    <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
    <select name="annee_select"><?php affichageAnnees()?></select>
    <table id="customers">
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
          
            <td><input type="text" min="0" step="any" name="janv" id="janv" oninput="sumValues()" value="0"></td>
            <td><input type="text" min="0" step="any" name="fevr" id="fevr" oninput="sumValues()" value="0"></td>
            <td><input type="text" min="0" step="any" name="mars" id="mars" oninput="sumValues()" value="0"></td>
            <td><input type="text" min="0" step="any" name="avril" id="avril" oninput="sumValues()" value="0"></td>
            <td><input type="text" min="0" step="any" name="mai" id="mai" oninput="sumValues()"></td>
            <td><input type="text" min="0" step="any" name="juin" id="juin" oninput="sumValues()"></td>
            <td><input type="text" min="0" step="any" name="juillet" id="juillet" oninput="sumValues()"></td>
            <td><input type="text" min="0" step="any" name="aout" id="aout" oninput="sumValues()"></td>
            <td><input type="text" min="0" step="any" name="septembre" id="septembre" oninput="sumValues()"></td>
            <td><input type="text" min="0" step="any" name="octobre" id="octobre" oninput="sumValues()"></td>
            <td><input type="text" min="0" step="any" name="novembre" id="novembre" oninput="sumValues()"></td>
            <td><input type="text" min="0" step="any" name="decembre" id="decembre" oninput="sumValues()"></td>
           
        </tr>
    </table>
    <p id="result"></p>
    <input type="submit" name="ajouter" value="Ajouter" style="background: rgb(38,60,92);padding: 8px 15px 8px 15px;border: none;color: #fff;" />
   
   
   
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
        var aout = parseFloat(document.getElementById("aout").value) ?? 0;
        var septembre = parseFloat(document.getElementById("septembre").value) ?? 0;
        var octobre = parseFloat(document.getElementById("octobre").value) ?? 0;
        var novembre = parseFloat(document.getElementById("novembre").value) ?? 0;
        var decembre = parseFloat(document.getElementById("decembre").value) ?? 0;
        var sum = janv + fevr + mars + avril + mai + juin + juillet + aout + septembre + octobre + novembre + decembre;
       document.getElementById("result").textContent = "Total mois : " + sum ;
    }
 
</script>






<form action="<?php $_SERVER["PHP_SELF"]?>" method="post" style="margin-top: 50px;" >
<h2>List objet Annuel</h2>
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
                                   <input type="submit" name="update" value="Update" style="background: #04AA6D;padding: 8px 15px 8px 15px;border: none;color: #fff;" />
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
  
   
   
  
</form>






</body>
</html>