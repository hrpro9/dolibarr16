<?php
 // Load Dolibarr environment
 require '../../main.inc.php';
 require_once '../../vendor/autoload.php';
 require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
 require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
 require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
 llxHeader("", ""); 

 

 function affichageAnnees(){
    $anneeDebut = date('Y')-1;
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
            width: 83px
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
        <center>

         
        <form method="POST" >

        <ul class="form-style-1" style="text-align: center;">
                        <li>
                        <label>Affichage  Objectif <span class="required">* </label>
                        <select name="annee_select" required>  <option value="" > Année choisi : </option> <?php affichageAnnees() ?> </select>
                        </li>
                        <li style="margin-top: 18px;">
                            <input type="submit" name="chargement" value="Chargement" />
                        </li>      
                    </ul>
        </form>

        </center>
       

        <?php
                if(isset($_POST['chargement']))
                {
                        $datechoisier=$_POST['annee_select'];
                        if(empty($datechoisier))
                        {
                            $datechoisier=0;
                        }

                    ?>
                      <h3>Affichage  objectif Annuel</h3>

                        <table id="customers" style="margin-top: 30px;">
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
                                    </tr>
                                    <tr>
                                        
                                        <?php
                                        //   echo '<td>'.$datechoisier.'</td>';
                                          $sql="SELECT * FROM llx_objectif_annuel WHERE annee= $datechoisier";
                                          $rest=$db->query($sql);
                                          $param_p = ((object)($rest))->fetch_assoc();
                                        

                                            print '
                                             <td>'.(isset($param_p["annee"])?$param_p["annee"]:'').'</td>
                                            <td>'.(isset($param_p["janvier"])?$param_p["janvier"]:'').'</td>
                                            <td>'.(isset($param_p["février"])?$param_p["février"]:'').'</td>
                                            <td>'.(isset($param_p["mars"])?$param_p["mars"]:'').'</td>
                                            <td>'.(isset($param_p["avril"])?$param_p["avril"]:'').'</td>
                                            <td>'.(isset($param_p["mai"])?$param_p["mai"]:'').'</td>
                                            <td>'.(isset($param_p["juin"])?$param_p["juin"]:'') .'</td>
                                            <td>'.(isset($param_p["juillet"])?$param_p["juillet"]:'') .'</td>
                                            <td>'. (isset( $param_p["août"])? $param_p["août"]:'').'</td>
                                            <td>'.(isset($param_p["septembre"])?$param_p["septembre"]:'') .'</td>
                                            <td>'.(isset($param_p["octobre"])? $param_p["octobre"]:'').'</td>
                                            <td>'.(isset($param_p["novembre"])?$param_p["novembre"]:'') .'</td>
                                            <td>'.(isset($param_p["décembre"])?$param_p["décembre"]:'') .'</td>
                                            <td>'.(isset($param_p["total"])?$param_p["total"]:'').'</td>
                                            ';
                                          
                                        ?>      
                                    </tr>
                            </table>



                            <h3>Affichage  objectif Commercial </h3>


                            <table id="customers" style="margin-top: 30px;">
                                    <tr>        
                                         <th>liste commercial</th>
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
                                    </tr>
                                    <tr>
                                        
                                        <?php
                                    
                                          $sql="SELECT * FROM llx_objectif_annuel_commercial WHERE annee= $datechoisier";
                                          $restt=$db->query($sql);
                                          foreach ($restt as  $value) {

                                            $sql = "SELECT rowid,lastname, firstname FROM llx_user WHERE rowid = " . $value['rowid'] . " ORDER BY lastname ASC";
                                            $userData = $db->query($sql)->fetch_assoc();
                                            
                                               $lastname = $userData['lastname'];
                                               $firstname = $userData['firstname'];
                                             

                                            print ' 
                                           <tr>
                                            <td>'.  $lastname.' '.$firstname.'</td>
                                            <td>'.$value["janvier"].'</td>
                                            <td>'.$value["février"].'</td>
                                            <td>'.$value["mars"].'</td>
                                            <td>'.$value["avril"].'</td>
                                            <td>'.$value["mai"].'</td>
                                            <td>'.$value["juin"].'</td>
                                            <td>'.$value["juillet"].'</td>
                                            <td>'.$value["août"].'</td>
                                            <td>'.$value["septembre"].'</td>
                                            <td>'.$value["octobre"].'</td>
                                            <td>'.$value["novembre"].'</td>
                                            <td>'.$value["décembre"].'</td>
                                            <td>'.$value["total"].'</td>
                                           </tr>

                                      
                                         
                                           
                                               ';
                                  
                                          }
                                        

                                           
                                        ?>      
                                    </tr>
                            </table>







                <?php
                                
                                }

                        ?>






        
        

        <?php
                if(isset($_POST['chargement']))
                {
                $datechoisier=$_POST['annee_select'];
                if(empty($datechoisier))
                {
                    $datechoisier=0;
                }

                ?>
                       
                <?php
                                
                                }

                        ?>

       
<!-- 
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
            <table id="customers" style="margin-top: 50px;">
                <tr>
                    <th>liste commercial</th>
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
                    <th>Décembre

                    </th>
                </tr>
                     <input type="hidden" name="annee" value="<?php if(empty($datechoisier )){echo $datechoisier=0;} else{echo $datechoisier;}  ?>">
                    <?php
                 
                 
                 $sql = "SELECT * FROM llx_usergroup_user WHERE fk_usergroup = 6";
                 $rest = $db->query($sql);

                 $i=0;
                 
                 foreach ($rest as $row) {
                     $sql = "SELECT rowid,lastname, firstname FROM llx_user WHERE rowid = " . $row['fk_user'] . " ORDER BY lastname ASC";
                     $userData = $db->query($sql)->fetch_assoc();
                     
                        $lastname = $userData['lastname'];
                        $firstname = $userData['firstname'];
                        $idrow = $userData['rowid'];
                        
   
                       //  <td><input type="number" min="0" step="any" name="janv[]" oninput="sumValues()" value=""></td>
                       //  <td><input type="number" min="0" step="any" name="fevr[]" oninput="sumValues()" value=""></td>
                       //  <td><input type="number" min="0" step="any" name="mars[]" oninput="sumValues()" value=""></td>
                       //  <td><input type="number" min="0" step="any" name="avril[]" oninput="sumValues()" value=""></td>
                       //  <td><input type="number" min="0" step="any" name="mai[]" oninput="sumValues()" value=""></td>
                       //  <td><input type="number" min="0" step="any" name="juin[]" oninput="sumValues()" value=""></td>
                       //  <td><input type="number" min="0" step="any" name="juillet[]" oninput="sumValues()" value=""></td>
                       //  <td><input type="number" min="0" step="any" name="août[]" oninput="sumValues()" value=""></td>
                       //  <td><input type="number" min="0" step="any" name="septembre[]" oninput="sumValues()" value=""></td>
                       //  <td><input type="number" min="0" step="any" name="octobre[]" oninput="sumValues()" value=""></td>
                       //  <td><input type="number" min="0" step="any" name="novembre[]" oninput="sumValues()" value=""></td>
                       //  <td><input type="number" min="0" step="any" name="décembre[]" oninput="sumValues()" value=""></td>
                       
                      
                    
                        echo '<tr>
                        <input type="hidden" name="idrow[]" value="' . $idrow . '">
                            <td>' . $lastname . ' ' . $firstname . '</td> 
                            <td><input  type="number" min="0" step="any" name="janv[]" id="janv[]" oninput="sumValues()" value=""></td>
                            <td><input  type="number" min="0" step="any" name="fevr[]" id="fevr" oninput="sumValues()" value=""></td>
                            <td><input  type="number" min="0" step="any" name="mars[]" id="mars" oninput="sumValues()" value=""></td>
                            <td><input  type="number" min="0" step="any" name="avril[]" id="avril" oninput="sumValues()" value=""></td>
                            <td><input  type="number" min="0" step="any" name="mai[]" id="mai" oninput="sumValues()" value=""></td>
                            <td><input  type="number" min="0" step="any" name="juin[]" id="juin" oninput="sumValues()" value=""></td>
                            <td><input  type="number" min="0" step="any" name="juillet[]" id="juillet" oninput="sumValues()" value=""></td>
                            <td><input  type="number" min="0" step="any" name="août[]" id="août" oninput="sumValues()" value=""></td>
                            <td><input  type="number" min="0" step="any" name="septembre[]" id="septembre" oninput="sumValues()" value=""></td>
                            <td><input  type="number" min="0" step="any" name="octobre[]" id="octobre" oninput="sumValues()" value=""></td>
                            <td><input  type="number" min="0" step="any" name="novembre[]" id="novembre" oninput="sumValues()" value=""></td>
                            <td><input  type="number" min="0" step="any" name="décembre[]" id="décembre" oninput="sumValues()" value=""></td>
                        
                        </tr>';
   
                   
                    
                     
                 }
                 ?>
                
                 </table>

                <input type="hidden" name="janvresult" id="janvresult" value="">
                <input type="hidden" name="fevrresult" id="fevrresult" value="">
                <input type="hidden" name="marsresult" id="marsresult" value="">
                <input type="hidden" name="avrilresult" id="avrilresult" value="">
                <input type="hidden" name="mairesult" id="mairesult" value="">
                <input type="hidden" name="juinresult" id="juinresult" value="">
                <input type="hidden" name="juilletresult" id="juilletresult" value="">
                <input type="hidden" name="aoutresult" id="aoutresult" value="">
                <input type="hidden" name="septembreresult" id="septembreresult" value="">
                <input type="hidden" name="octobreresult" id="octobreresult" value="">
                <input type="hidden" name="novembreresult" id="novembreresult" value="">
                <input type="hidden" name="decembreresult" id="decembreresult" value="">


                 <input type="submit" name="ajouter" value="Ajouter" style="margin-top: 18px;background: rgb(38,60,92);padding: 8px 15px 8px 15px;border: none;color: #fff;" />
                 </form>
                  -->
               

    <script>
                        function sumValues() {
                            var janvInputs = document.querySelectorAll('input[name^="janv[]"]');
                            var fevrInputs = document.querySelectorAll('input[name^="fevr[]"]');
                            var marsInputs = document.querySelectorAll('input[name^="mars[]"]');
                            var avrilInputs = document.querySelectorAll('input[name^="avril[]"]');
                            var maiInputs = document.querySelectorAll('input[name^="mai[]"]');
                            var juinInputs = document.querySelectorAll('input[name^="juin[]"]');
                            var juilletInputs = document.querySelectorAll('input[name^="juillet[]"]');
                            var aoutInputs = document.querySelectorAll('input[name^="aout[]"]');
                            var septembreInputs = document.querySelectorAll('input[name^="septembre[]"]');
                            var octobreInputs = document.querySelectorAll('input[name^="octobre[]"]');
                            var novembreInputs = document.querySelectorAll('input[name^="novembre[]"]');
                            var decembreInputs = document.querySelectorAll('input[name^="decembre[]"]');
                            
                            var janvSum = 0;
                            for (var i = 0; i < janvInputs.length; i++) {
                            janvSum += parseFloat(janvInputs[i].value) || 0;
                            }
                            
                            var fevrSum = 0;
                            for (var i = 0; i < fevrInputs.length; i++) {
                            fevrSum += parseFloat(fevrInputs[i].value) || 0;
                            }
                            
                            var marsSum = 0;
                            for (var i = 0; i < marsInputs.length; i++) {
                            marsSum += parseFloat(marsInputs[i].value) || 0;
                            }
                            
                            var avrilSum = 0;
                            for (var i = 0; i < avrilInputs.length; i++) {
                            avrilSum += parseFloat(avrilInputs[i].value) || 0;
                            }
                            
                            var maiSum = 0;
                            for (var i = 0; i < maiInputs.length; i++) {
                            maiSum += parseFloat(maiInputs[i].value) || 0;
                            }
                            
                            var juinSum = 0;
                            for (var i = 0; i < juinInputs.length; i++) {
                            juinSum += parseFloat(juinInputs[i].value) || 0;
                            }
                            
                            var juilletSum = 0;
                            for (var i = 0; i < juilletInputs.length; i++) {
                            juilletSum += parseFloat(juilletInputs[i].value) || 0;
                            }
                            
                            var aoutSum = 0;
                            for (var i = 0; i < aoutInputs.length; i++) {
                            aoutSum += parseFloat(aoutInputs[i].value) || 0;
                            }
                            
                            var septembreSum = 0;
                            for (var i = 0; i < septembreInputs.length; i++) {
                            septembreSum += parseFloat(septembreInputs[i].value) || 0;
                            }
                            
                            var octobreSum = 0;
                            for (var i = 0; i < octobreInputs.length; i++) {
                            octobreSum += parseFloat(octobreInputs[i].value) || 0;
                            }
                            
                            var novembreSum = 0;
                            for (var i = 0; i < novembreInputs.length; i++) {
                            novembreSum += parseFloat(novembreInputs[i].value) || 0;
                            }
                            
                            var decembreSum = 0;
                            for (var i = 0; i < decembreInputs.length; i++) {
                            decembreSum += parseFloat(decembreInputs[i].value) || 0;
                            }
                            
                            document.getElementById("janvresult").value = janvSum.toFixed(2);
                            document.getElementById("fevrresult").value = fevrSum.toFixed(2);
                            document.getElementById("marsresult").value = marsSum.toFixed(2);
                            document.getElementById("avrilresult").value = avrilSum.toFixed(2);
                            document.getElementById("mairesult").value = maiSum.toFixed(2);
                            document.getElementById("juinresult").value = juinSum.toFixed(2);
                            document.getElementById("juilletresult").value = juilletSum.toFixed(2);
                            document.getElementById("aoutresult").value = aoutSum.toFixed(2);
                            document.getElementById("septembreresult").value = septembreSum.toFixed(2);
                            document.getElementById("octobreresult").value = octobreSum.toFixed(2);
                            document.getElementById("novembreresult").value = novembreSum.toFixed(2);
                            document.getElementById("decembreresult").value = decembreSum.toFixed(2);
                            }
    </script>




        <?php

          if (isset($_POST['ajouter']))
          {

             
               
                // $janv = intval($_POST['janvresult']) ?? 0;
                // $fevr = intval($_POST['fevrresult']) ?? 0;
                // $mars = intval($_POST['marsresult']) ?? 0;
                // $avril = intval($_POST['avrilresult']) ?? 0;
                // $mai = intval($_POST['mairesult']) ?? 0;
                // $juin = intval($_POST['juinresult']) ?? 0;
                // $juillet = intval($_POST['juilletresult']) ?? 0;
                // $août = intval($_POST['aoutresult']) ?? 0;
                // $septembre = intval($_POST['septembreresult']) ?? 0;
                // $octobre = intval($_POST['octobreresult']) ?? 0;
                // $novembre = intval($_POST['novembreresult']) ?? 0;
                // $décembre = intval($_POST['decembreresult']) ?? 0;
                // $toalcom= $janv+$fevr+$mars+$avril+$mai+$juin+$juillet+$août+$septembre+$octobre+$novembre+$décembre;
                $i=0;
                $sql = "SELECT * FROM llx_usergroup_user WHERE fk_usergroup = 6";
                $rest = $db->query($sql);
              
                $janv=0;
             
                    
                 //   echo $_POST['janv[$key]'];
                 $annee = $_POST['annee'];
                 echo  $annee;

                 if($annee==0)
                 {
                    echo 'error';
                 }
                 else{
                    foreach ($rest as $t => $row) {
                  
                        $annee = $_POST['annee'];
                        $rowid=  $_POST['idrow'][$t];
                        $janv = intval($_POST['janv'][$t]) ?? 0;
                        $fevr = intval($_POST['fevr'][$t]) ?? 0;
                        $mars = intval($_POST['mars'][$t]) ?? 0;
                        $avril = intval($_POST['avril'][$t]) ?? 0;
                        $mai = intval($_POST['mai'][$t]) ?? 0;
                        $juin = intval($_POST['juin'][$t]) ?? 0;
                        $juillet = intval($_POST['juillet'][$t]) ?? 0;
                        $août = intval($_POST['août'][$t]) ?? 0;
                        $septembre = intval($_POST['septembre'][$t]) ?? 0;
                        $octobre = intval($_POST['octobre'][$t]) ?? 0;
                        $novembre = intval($_POST['novembre'][$t]) ?? 0;
                        $décembre = intval($_POST['décembre'][$t]) ?? 0;
                        $toal= $janv+$fevr+$mars+$avril+$mai+$juin+$juillet+$août+$septembre+$octobre+$novembre+$décembre;
                        $insertQuery = "INSERT INTO llx_objectif_annuel_commercial (rowid,janvier, février, mars, avril, mai, juin, juillet, août, septembre, octobre, novembre, décembre, total, annee) 
                        VALUES ('$rowid','$janv', '$fevr', '$mars', '$avril', '$mai', '$juin', '$juillet', '$août', '$septembre', '$octobre', '$novembre', '$décembre', '$toal', '$annee')";
                     $res = $db->query($insertQuery);
                    
                }
                 }
             
                 
                

                
               
           
}

                

            //     foreach ($_POST['idrow'] as $key => $rowid) {
            //         // Check if the array indices exist before accessing them
            //         echo $_POST['janv'];
            //         $janvt = intval($_POST['janv']) ?? 0;
            //         $fevrt = isset($fevrp[$key]) ? intval($fevrp[$key]) : 0;
            //         $marst = isset($mars[$key]) ? intval($mars[$key]) : 0;
            //         $avrilt = isset($avril[$key]) ? intval($avril[$key]) : 0;
            //         $mait = isset($mai[$key]) ? intval($mai[$key]) : 0;
            //         $juint = isset($juin[$key]) ? intval($juin[$key]) : 0;
            //         $juillett = isset($juillet[$key]) ? intval($juillet[$key]) : 0;
            //         $aoûtt = isset($août[$key]) ? intval($août[$key]) : 0;
            //         $septembret = isset($septembre[$key]) ? intval($septembre[$key]) : 0;
            //         $octobret = isset($octobre[$key]) ? intval($octobre[$key]) : 0;
            //         $novembret = isset($novembre[$key]) ? intval($novembre[$key]) : 0;
            //         $décembret = isset($décembre[$key]) ? intval($décembre[$key]) : 0;
                    
            //         // Calculate the total
            //         $toalcomt = $janvt + $fevrt + $marst + $avrilt + $mait + $juint + $juillett + $aoûtt + $septembret + $octobret + $novembret + $décembret;
   
            // }
            // $sql = "SELECT * FROM llx_objectif_annuel WHERE annee = $annee";
            // $result = $db->query($sql);
            // $param_p = $result->fetch_assoc();

           

            // if (
            //     $janv > $param_p['janvier'] ||
            //     $fevr > $param_p['février'] ||
            //     $mars > $param_p['mars'] ||
            //     $avril > $param_p['avril'] ||
            //     $mai > $param_p['mai'] ||
            //     $juin > $param_p['juin'] ||
            //     $juillet > $param_p['juillet'] ||
            //     $août > $param_p['août'] ||
            //     $septembre > $param_p['septembre'] ||
            //     $octobre > $param_p['octobre'] ||
            //     $novembre > $param_p['novembre'] ||
            //     $décembre > $param_p['décembre']
            // ) {
            //     echo 'error';
            // } else {
            //     // Insert the new record
                
            //     $insertQuery = "INSERT INTO llx_objectif_annuel_commercial (rowid, janvier, février, mars, avril, mai, juin, juillet, août, septembre, octobre, novembre, décembre, total, annee) 
            //                     VALUES ('$rowid', '$janvt', '$fevrt', '$marst', '$avrilt', '$mait', '$juint', '$juillett', '$aoûtt', '$septembret', '$octobret', '$novembret', '$décembret', '$toalcomt', '$annee')";
            //   echo $insertQuery;
            //   $res = $db->query($insertQuery);

            // }
        
          

        ?>

          
    </body>
    </html>