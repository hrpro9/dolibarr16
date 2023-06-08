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
 </head>
    <body>
        <h1>Saisie objet commercial</h1>
        
        <form method="POST" >
        <select name="annee_select" required>  <option value="" > Année choisi : </option> <?php affichageAnnees() ?> </select>
            <button type="submit" name="chargement" style="margin-top: 18px;background: #4B99AD;padding: 8px 15px 8px 15px;border: none;color: #fff;">Chargement</button><br>  
        </form>

        <?php
                if(isset($_POST['chargement']))
                {
                $datechoisier=$_POST['annee_select'];
                if(empty($datechoisier))
                {
                    $datechoisier=0;
                }

                ?>
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
                <?php
                                
                                }

                        ?>

       

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
                        
   
                
                       
                       $ExistsQuery = "SELECT * FROM llx_objectif_annuel_commercial WHERE annee =$datechoisier AND rowid= $idrow";
                       $resultQuery = $db->query($ExistsQuery);  
                       $param_pr = ((object)($resultQuery))->fetch_assoc();
                       
                        echo '<tr>
                        <input type="hidden" name="idrow[]" value="' . $idrow . '">
                            <td>' . $lastname . ' ' . $firstname . '</td> 

                    


















                            
                            <td><input '.( $t=(01>=date('m') || $datechoisier>date('Y')-2) ? '' :  'readonly').'  type="number"  min="0" step="any" name="janv[]" id="janv[]" oninput="sumValues()" value="'.(isset($param_pr['janvier']) ? $param_pr['janvier'] : '').'"></td>
                            <td><input '.( $t=(02>=date('m') || $datechoisier>date('Y')-2) ? '' :  'readonly').'  type="number" min="0" step="any" name="fevr[]" id="fevr[]" oninput="sumValues()" value="' . (isset($param_pr['février']) ? $param_pr['février'] : '') . '"></td>
                            <td><input '.( $t=(03>=date('m') || $datechoisier>date('Y')-2) ? '' :  'readonly').'  type="number" min="0" step="any" name="mars[]" id="mars[]" oninput="sumValues()" value="' . (isset($param_pr['mars']) ? $param_pr['mars'] : '') . '"></td>
                            <td><input '.( $t=(04>=date('m') || $datechoisier>date('Y')-2) ? '' :  'readonly').'  type="number" min="0" step="any" name="avril[]" id="avril[]" oninput="sumValues()" value="' . (isset($param_pr['avril']) ? $param_pr['avril'] : '') . '"></td>
                            <td><input '.( $t=(05>=date('m') || $datechoisier>date('Y')-2) ? '' :  'readonly').'  type="number" min="0" step="any" name="mai[]" id="mai[]" oninput="sumValues()" value="' . (isset($param_pr['mai']) ? $param_pr['mai'] : '') . '"></td>
                            <td><input '.( $t=(06>=date('m') || $datechoisier>date('Y')-2) ? '' :  'readonly').'  type="number" min="0" step="any" name="juin[]" id="juin[]" oninput="sumValues()" value="' . (isset($param_pr['juin']) ? $param_pr['juin'] : '') . '"></td>
                            <td><input '.( $t=(07>=date('m') || $datechoisier>date('Y')-2) ? '' :  'readonly').'  type="number" min="0" step="any" name="juillet[]" id="juillet[]" oninput="sumValues()" value="' . (isset($param_pr['juillet']) ? $param_pr['juillet'] : '') . '"></td>
                            <td><input '.( $t=(8>=date('m') || $datechoisier>date('Y')-2) ? '' :  'readonly').'  type="number" min="0" step="any" name="août[]" id="août[]" oninput="sumValues()" value="' . (isset($param_pr['août']) ? $param_pr['août'] : '') . '"></td>
                            <td><input '.( $t=(9>=date('m') || $datechoisier>date('Y')-2) ? '' :  'readonly').'  type="number" min="0" step="any" name="septembre[]" id="septembre[]" oninput="sumValues()" value="' . (isset($param_pr['septembre']) ? $param_pr['septembre'] : '') . '"></td>
                            <td><input '.( $t=(10>=date('m') || $datechoisier>date('Y')-2) ? '' :  'readonly').'  type="number" min="0" step="any" name="octobre[]" id="octobre[]" oninput="sumValues()" value="' . (isset($param_pr['octobre']) ? $param_pr['octobre'] : '') . '"></td>
                            <td><input '.( $t=(11>=date('m') || $datechoisier>date('Y')-2) ? '' :  'readonly').'  type="number" min="0" step="any" name="novembre[]" id="novembre[]" oninput="sumValues()" value="' . (isset($param_pr['novembre']) ? $param_pr['novembre'] : '') . '"></td>
                            <td><input '.( $t=(12>=date('m') || $datechoisier>date('Y')-2) ? '' :  'readonly').'  type="number" min="0" step="any" name="décembre[]" id="décembre[]" oninput="sumValues()" value="' . (isset($param_pr['décembre']) ? $param_pr['décembre'] : '') . '"></td>
                        
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
    
               $annee = $_POST['annee'];
                $janvsum = intval($_POST['janvresult']) ?? 0;
                $fevrsum = intval($_POST['fevrresult']) ?? 0;
                $marssum = intval($_POST['marsresult']) ?? 0;
                $avrilsum = intval($_POST['avrilresult']) ?? 0;
                $maisum = intval($_POST['mairesult']) ?? 0;
                $juinsum = intval($_POST['juinresult']) ?? 0;
                $juilletsum = intval($_POST['juilletresult']) ?? 0;
                $aoûtsum = intval($_POST['aoutresult']) ?? 0;
                $septembresum = intval($_POST['septembreresult']) ?? 0;
                $octobresum = intval($_POST['octobreresult']) ?? 0;
                $novembresum = intval($_POST['novembreresult']) ?? 0;
                $décembresum = intval($_POST['decembreresult']) ?? 0;

                $sql = "SELECT * FROM llx_objectif_annuel WHERE annee = $annee";
                $result = $db->query($sql);
                $param_p = $result->fetch_assoc();

                $afficheerror='';
                if($annee==0)
                {
                  print ' <div class="alert" style="background-color: #f8d7da;border: 1px solid #f5c6cb;padding: 10px; color: #721c24;width:180px;margin-top:10px;">annee non selection.</div>';
                }else if (
                        
                        $janvsum > $param_p['janvier'] ||
                        $fevrsum > $param_p['février'] ||
                        $marssum > $param_p['mars'] ||
                        $avrilsum > $param_p['avril'] ||
                        $maisum > $param_p['mai'] ||
                        $juinsum > $param_p['juin'] ||
                        $juilletsum > $param_p['juillet'] ||
                        $aoûtsum > $param_p['août'] ||
                        $septembresum > $param_p['septembre'] ||
                        $octobresum > $param_p['octobre'] ||
                        $novembresum > $param_p['novembre'] ||
                        $décembresum > $param_p['décembre']
                    ) {

                        if( $janvsum > $param_p['janvier'] )
                        {
                            $afficheerror =" le total du mois de janvier n'est pas égal à objet annuel  de janvier  <br>";
                        }

                        if( $fevrsum > $param_p['février'] )
                        {
                            $afficheerror .= " le total du mois de février n'est pas égal à objet annuel  de février  <br>";
                        }

                        if( $marssum > $param_p['mars'] )
                        {
                            $afficheerror .= " le total du mois de mars n'est pas égal à objet annuel  de mars  <br>";
                        }

                        if( $avrilsum > $param_p['avril'] )
                        {
                            $afficheerror .= " le total du mois de avril n'est pas égal à objet annuel  de avril  <br>";
                        }

                        if( $maisum > $param_p['mai'] )
                        {
                            $afficheerror .= " le total du mois de mai n'est pas égal à objet annuel  de mai  <br>";
                        }

                        if( $juinsum > $param_p['juin'] )
                        {
                            $afficheerror .= " le total du mois de juin n'est pas égal à objet annuel  de juin  <br>";
                        }

                        if( $juilletsum > $param_p['juillet'] )
                        {
                            $afficheerror .= " le total du mois de juillet n'est pas égal à objet annuel  de juillet  <br>";
                        }

                        if( $aoûtsum > $param_p['août'] )
                        {
                            $afficheerror .= " le total du mois de août n'est pas égal à objet annuel  de août  <br>";
                        }

                        if( $septembresum > $param_p['septembre'] )
                        {
                            $afficheerror .= " le total du mois de septembre n'est pas égal à objet annuel  de septembre  <br>";
                        }

                        if( $octobresum > $param_p['octobre'] )
                        {
                            $afficheerror .= " le total du mois de octobre n'est pas égal à objet annuel  de octobre  <br>";
                        }

                        if( $novembresum > $param_p['novembre'] )
                        {
                            $afficheerror .= " le total du mois de novembre n'est pas égal à objet annuel  de novembre  <br>";
                        }

                        if( $décembresum > $param_p['décembre'] )
                        {
                            $afficheerror .= " le total du mois de décembre n'est pas égal à objet annuel  de décembre  <br>";
                        }

                      



                        echo ' <div class="alert" style="background-color: #f8d7da;border: 1px solid #f5c6cb;padding: 10px; color: #721c24;width:500px;margin-top:10px;">'.  $afficheerror .' </div> <br>';;
                       

                      




                    } else {


                   











          
                $i=0;
                $sql = "SELECT * FROM llx_usergroup_user WHERE fk_usergroup = 6";
                $rest = $db->query($sql);
              
                $janv=0;
                $updatedonne=0;
             
                    
            
               

             

               
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


                      
                        

                            $pdo_sql = "UPDATE llx_objectif_annuel_commercial SET rowid='$rowid',janvier='$janv', février='$fevr', mars='$mars', avril='$avril',
                            mai='$mai', juin='$juin', juillet='$juillet', août='$août', septembre='$septembre', octobre='$octobre',
                            novembre='$novembre', décembre='$décembre', total='$toal', annee= '$annee' WHERE rowid=$rowid AND  annee= $annee ";
                            $result = $db->query($pdo_sql);

                            $updatedonne=1;


                    }

                    if( $updatedonne==1)
                    {
                        $annee = $_POST['annee'];

                        print '
                        <div class="alert" style="background-color: #f8d7da;border: 1px solid #f5c6cb;padding: 10px; color: #721c24;width:310px;margin-top:15px;"> Modifier l objectif commercial de l année : '.$annee.'   </div>
                            ';
                    }
             
                }

                

                
               
           
}

        
          

        ?>

          
    </body>
    </html>