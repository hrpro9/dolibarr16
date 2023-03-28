<?php
  // Load Dolibarr environment
  require '../../main.inc.php';
  require_once '../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="style.css">
  </head>
  <body >
    <center>
      <div class="col-lg-4 m-auto">
        <form method="post"  enctype="multipart/form-data">
        <ul class="form-style-1" style="text-align: center;">
            <h4 style="text-align: center;" class="field-divided">Teledeclaration !!!</h4>
            <li>
            <label>Ficher Preetabli <span class="required">* </label>
            <input type="file"  name="fichename"   class="field-divided" placeholder="salaire de base" required/>
            </li>
            <li style="margin-top: 18px;">
            <input type="submit" name="read_file" value="Read file" />
          </li>      
           </ul>
        </form>      
        <?php
          if(isset($_POST['read_file']))
          {
            //DELETE data FROM table cnss temporary
            $sql1="DELETE FROM llx_cnss_temporary";
            $rest1=$db->query($sql1);
            //upload file 
            $filename = $_FILES["fichename"]["name"];
            $tempname = $_FILES["fichename"]["tmp_name"];  
            // "C:/xampp/htdocs/dolibarr16/htdocs/RH/Bulletin/files/".$filename;  
            $folder = DOL_DOCUMENT_ROOT.'/RH/Bulletin/files/'.$filename;
            if (move_uploaded_file($tempname, $folder)){
              $msg = "file uploaded successfully";
            }else{  
                $msg = "Failed to upload file";
            }
            //open file
            $file=fopen("$folder","r") or die("Unable to open file!");
            $all_lines = file($folder);
            $b00=$all_lines[0];
            $b00=str_replace("A","B",$b00);
            $b01=$all_lines[1];
            $b01=str_replace($b01[0],"B",$b01);
            //write new file b01 and b02
            // "C:/xampp/htdocs/dolibarr16/htdocs/RH/Bulletin/files/fileDs.txt";
         
            while(!feof($file))
            {
              $content=fgets($file);
              $carray=explode(".",$content);
              $a = fread( $file,"3");
              $n_num_affilie = fread( $file,"7");
              $annee = fread($file,"4");
              $mois = fread($file,"2");
              $date=$annee.$mois;
              $ncnss = fread($file,"9");
              $nom_prenom = fread( $file,"60");
              $n_enfants = fread( $file,"2");
              $n_af_a_payer= fread( $file,"6");
              $n_af_a_deduire=fread( $file,"6");
              //insert n°cnss in table cnss temporary
              $sql="INSERT INTO llx_cnss_temporary(n_cnss_temporary,date,n_num_affilie,nom_prenom,n_af_a_deduire,annee,mois) VALUES('$ncnss','$date','$n_num_affilie','$nom_prenom','$n_af_a_deduire','$annee','$mois')";
              $res = $db->query($sql);
            }
            fclose($file);
            $fileNameWrite=  DOL_DOCUMENT_ROOT.'/RH/Bulletin/files/fileDs.txt'; 
            file_put_contents($fileNameWrite, '');
            $myfilee = fopen("$fileNameWrite", "a+") or die("Unable to open file!");
            $txtf = $b00. $b01;
            fwrite($myfilee, $txtf);
            fclose($myfilee);
        ?>    
          <form method="post"  enctype="multipart/form-data"><br>  
          <table class="table" style="margin-top:15px; text-align: center;">
              <thead>
                <tr>
                <!--  <th scope="col">user id</th>-->
                <th scope="col">Num Affilie</th>
                  <th scope="col">L_période</th>
                  <th scope="col">N_Num_Assure</th>
                  <th scope="col">Nom Prenom</th>
                  <th scope="col">Enfants</th>
                  <th scope="col">AF_A_Payer</th>
                  <th scope="col">AF_A_Deduire</th>
                  <th scope="col">AF_A_Net_Payer</th>
                  <th scope="col">AF_A_Reverser</th>
                  <th scope="col">Jours_Declares</th>
                  <th scope="col">Salaire_Reel</th>
                  <th scope="col">Salaire_Plaf</th>
                  <th scope="col">Stuation</th>
                </tr>
              </thead>
              <tbody>
                <?php
                //comparison between n°cnss from llx_cnss_temporary and n cnss temporary
                $sql="SELECT *  FROM llx_Paie_UserInfo,llx_cnss_temporary WHERE cnss=n_cnss_temporary";
                $rest_cnss=$db->query($sql); 
              foreach($rest_cnss as $test)
              { 
                $param='';
                $sql="SELECT *  FROM llx_Paie_MonthDeclarationRubs WHERE userid=" . $test['userid'] . " ";
                $rest_ef=$db->query($sql);
                $param = ((object)($rest_ef))->fetch_assoc();
                ?>
                  <tr>
                    <th scope="row">
                      <?= $test['n_num_affilie'] ?>
                    </th>
                    <td>
                      <?= $test['date'] ?>
                    </td>
                    <td>
                      <?= $test['cnss'] ?>
                    </td>
                    <td>
                      <?= $test['nom_prenom'] ?>
                    </td>
                    <td>
                      <?php
                       echo $param['enfants'];
                      ?>
                    </td>
                    <td>
                      <?php
                        if($param['enfants']<=3)
                        {
                        echo $cf=$param['enfants']*300;
                        }
                        else if($param['enfants']>3 && $param['enfants']<6)
                        {
                          $a=$param['enfants']-3;
                          $b=3*300;
                          $c=$a*36;
                          echo $cf=$b+$c;
                        }
                      ?>
                    </td>
                    <td>
                      <?php
                        echo  $test['n_af_a_deduire'] ;
                       ?>
                    </td>
                    <td>
                      <?php
                        echo  $AF_A_Net_Payer= $cf -$test['n_af_a_deduire'] ;
                       ?>
                    </td>
                    <td>0</td>
                    <td>
                      <?php
                       $param='';
                       $sql="SELECT *  FROM llx_Paie_MonthDeclaration WHERE userid=" . $test['userid'] . " ";
                       $rest_cs=$db->query($sql);
                       $param = ((object)($rest_cs))->fetch_assoc();
                       echo $param['workingDays'];
                      ?>
                    </td>
                    <td>
                    <?php
                       echo $param['salaireBrut'];
                      ?>
                    </td>
                    <td>
                      <?php
                        $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=700";
                        $res = $db->query($sql);
                        $param_cnss = ((object)($res))->fetch_assoc();
                        $tauxcnss=$param_cnss["percentage"]/100;
                        $maxcnss=$param_cnss["plafond"]/$tauxcnss;
                      echo  $Salaire_Plaf=$param['salaireBrut']>$maxcnss?$maxcnss:$param['salaireBrut'];
                      ?>
                    </td>
                    <td>
                      <?php
                       //L_Situation
                        $param_st='';
                        $sql="SELECT *  FROM llx_user WHERE rowid=" . $test['userid'] . " ";
                        $rest_st=$db->query($sql);
                        $param_st = ((object)($rest_st))->fetch_assoc();
                        echo $param_st['l_situation'];
                      ?>
                    </td>
                  </tr>
                <?php
              }
                ?>
              </tbody>
          </table>              
            <input type="submit"   name="Generer" value="Génerer" style="margin-top: 18px;background: #4B99AD;padding: 8px 15px 8px 15px;border: none;color: #fff;"/>    
           <?php 
          }
        ?>
        <?php
         if(isset($_POST['Generer']))
         { 
            //open file 
            // "C:/xampp/htdocs/dolibarr16/htdocs/RH/Bulletin/files/fileDs.txt";
            $fileNameWrite= DOL_DOCUMENT_ROOT.'/RH/Bulletin/files/fileDs.txt';
            $myfile = fopen("$fileNameWrite", "a+") or die("Unable to open file!");
            //open file line 1 and lin é
            $all_lines = file($fileNameWrite);
            $b00=$all_lines[0];
            $b01=$all_lines[1];
            //write new file b01 and b02
            file_put_contents($fileNameWrite, '');
            $myfilee = fopen("$fileNameWrite", "a+") or die("Unable to open file!");
            $txtf = $b00. $b01;
            fwrite($myfilee, $txtf);
            fclose($myfilee);  
           //comparison between n°cnss from llx_cnss_temporary and  cnss from temporary
           $sql="SELECT *  FROM llx_Paie_UserInfo,llx_cnss_temporary  WHERE cnss=n_cnss_temporary ";
           $rest_cnss=$db->query($sql);
           $param = ((object)($rest_cnss))->fetch_assoc();
           // ----> b02 <----
           foreach($rest_cnss as $test)
           { 
            $param='';
            $sql="SELECT *  FROM llx_Paie_MonthDeclarationRubs WHERE userid=" . $test['userid'] . " ";
            $rest_ef=$db->query($sql);
            $param = ((object)($rest_ef))->fetch_assoc();
             //n_num_affilie
             $n_num_affilie= $test['n_num_affilie'];
             //l_periode
             $l_periode= $test['date'];  
             //n_num_assure
             $n_num_assure=$test['cnss'] ;
             //n_nb_salaries
             $n_nb_salaries++;
             //n_t_num_immatriculations
             $x_n_t_num_imm=$n_t_num_imm+$test['cnss'];
             $n_t_num_imm=$x_n_t_num_imm;
             //l_nom_prenom
             $l_nom_prenom=$test['nom_prenom'];
             //n_enfants
             $n_enfants=$param['enfants'];
             //n_t_enfants
             $x_n_t_enfants=$n_t_enfants+$param['enfants'];
             $n_t_enfants=$x_n_t_enfants;
             //AF_A_Payer
             if($param['enfants']<=3)
             {
              $AF_A_Payer=($param['enfants']*300)*100;
             }
             else if($param['enfants']>3 && $param['enfants']<6)
             {
               $a=$param['enfants']-3;
               $b=3*300;
               $c=$a*36;
               $AF_A_Payer=($b+$c)*100;
             }
             //n_t_af_payer
             $n_t_af_payer=$n_t_af_payer+$AF_A_Payer;
             $n_t_af_payer=$n_t_af_payer;
             //n_af_a_deduire
             $n_af_a_deduire= $test['n_af_a_deduire'] ;
             //n_t_af_a_deduire
             $n_t_af_a_deduire=$n_t_af_a_deduire+$n_af_a_deduire;
             $n_t_af_a_deduire=$n_t_af_a_deduire;
             //n_af_net_a_payer
             $n_af_net_a_payer= $AF_A_Payer-$n_af_a_deduire;
             //n_t_af_net_a_payer
             $n_t_af_net_a_payer=$n_t_af_net_a_payer+$n_af_net_a_payer;
             $n_t_af_net_a_payer=$n_t_af_net_a_payer;
             //n_af_a_reverser
             $n_af_a_reverser=0;
             //n_t_af_a_reverser
             $n_t_af_a_reverser=$n_t_af_a_reverser+$n_af_a_reverser;
             $n_t_af_a_reverser=$n_t_af_a_reverser;
             //n_jour_declares
             $param_dl='';
             $sql5="SELECT *  FROM llx_Paie_MonthDeclaration WHERE userid=" . $test['userid'] . " ";
             $rest_dl=$db->query($sql5);
             $param_dl = ((object)($rest_dl))->fetch_assoc();
             $n_jour_declares=$param_dl['workingDays'];
             //n_t_jour_declares
             $n_t_jour_declares=$n_t_jour_declares+$n_jour_declares;
             $n_t_jour_declares=$n_t_jour_declares;
             //n_salaire_reel
             $param_dl['salaireBrut']=$param_dl['salaireBrut']*100;
             $n_salaire_reel=$param_dl['salaireBrut'];
             //n_t_salaire_reel
             $n_t_salaire_reel=$n_t_salaire_reel+$n_salaire_reel;
             $n_t_salaire_reel=$n_t_salaire_reel;
             //Salaire_Plaf
             $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=700";
             $res = $db->query($sql);
             $param_cnss = ((object)($res))->fetch_assoc();
             $tauxcnss=$param_cnss["percentage"]/100;
             $maxcnss=($param_cnss["plafond"]/$tauxcnss)*100;
             $Salaire_Plaf=$param_dl['salaireBrut']>$maxcnss?$maxcnss:$param_dl['salaireBrut'];
             //n_t_Salaire_Plaf
             $n_t_Salaire_Plaf=$n_t_Salaire_Plaf+$Salaire_Plaf;
             $n_t_Salaire_Plaf=$n_t_Salaire_Plaf;
             //L_Situation
            $param_st='';
            $sql="SELECT *  FROM llx_user WHERE rowid=" . $test['userid'] . " ";
            $rest_st=$db->query($sql);
            $param_st = ((object)($rest_st))->fetch_assoc();
            if($param_st['l_situation']=="non_renseigne")
            {
              for($i=1;$i<2;$i++)
              {
                $param_st['l_situation']=' ';
                $y=" ".$param_st['l_situation'];
                $n_st=$y;
              }
            }
            else{
              $n_st=$param_st['l_situation'];
            }
            //le Rang de la situation
            switch ($n_st) {
              case "SO":$r_d_st=1;break;
              case "DE":$r_d_st=2;break;
              case "IT":$r_d_st=3;break;
              case "IL":$r_d_st=4;break;
              case "AT":$r_d_st=5;break;
              case "CS":$r_d_st=6;break;
              case "MS":$r_d_st=7;break;
              case "MP":$r_d_st=8;break;
              default:
              $r_d_st=0;
            }
             //S_Ctr
             $S_Ctr=$n_num_assure+$n_af_a_reverser+$n_jour_declares+$n_salaire_reel+$Salaire_Plaf+$r_d_st;
             //n_t_S_Ctr
             $n_t_S_Ctr=$n_t_S_Ctr+$S_Ctr;
             $n_t_S_Ctr=$n_t_S_Ctr;
             // n(2) n_enfants
             if(strlen($n_enfants)<=2)
             {
              $x=2-strlen($n_enfants);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $n_enfants;
                $n_enfants=$y;
              }
             }
             // n(6) AF_A_Payer
             if(strlen($AF_A_Payer)<=6)
             {
              $x=6-strlen($AF_A_Payer);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $AF_A_Payer;
                $AF_A_Payer=$y;
              }
             }
             // n(6) n_af_net_a_payer
             if(strlen($n_af_net_a_payer)<=6)
             {
              $x=6-strlen($n_af_net_a_payer);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $n_af_net_a_payer;
                $n_af_net_a_payer=$y;
              }
             }
             // n(6) n_af_a_reverser
             if(strlen( $n_af_a_reverser)<=6)
             {
              $x=6-strlen( $n_af_a_reverser);
              for($i=1;$i<=$x;$i++)
              {
                $y="0".  $n_af_a_reverser;
                $n_af_a_reverser=$y;
              }
             }
             // n(6) n_jour_declares
             if(strlen($n_jour_declares)<=6)
             {
              $x=6-strlen($n_jour_declares);
              for($i=1;$i<=$x;$i++)
              {
                $y="0".  $n_jour_declares;
                $n_jour_declares=$y;
              }
             }
             // n(13) n_salaire_reel
             if(strlen($n_salaire_reel)<=13)
             {
              $x=13-strlen($n_salaire_reel);
              for($i=1;$i<=$x;$i++)
              {
                $y="0".  $n_salaire_reel;
                $n_salaire_reel=$y;
              }
             }
             // n(9) Salaire_Plaf
             if(strlen($Salaire_Plaf)<=9)
             {
              $x=9-strlen($Salaire_Plaf);
              for($i=1;$i<=$x;$i++)
              {
                $y="0".  $Salaire_Plaf;
                $Salaire_Plaf=$y;
              }
             }
             // n(19) S_Ctr
             if(strlen($S_Ctr)<=19)
             {
              $x=19-strlen($S_Ctr);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $S_Ctr;
                $S_Ctr=$y;
              }
             }
             // an(6) espace b02
             $espace=' ';
              for($i=1;$i<=103;$i++)
              {
                $y=" ".$espace;
                $espace=$y;
              }
             //write file b02
             $b02 =
             "B02".$n_num_affilie.$l_periode.$n_num_assure.$l_nom_prenom.$n_enfants.$AF_A_Payer.$n_af_a_deduire.$n_af_net_a_payer.
             $n_af_a_reverser.$n_jour_declares.$n_salaire_reel.$Salaire_Plaf. $n_st.$S_Ctr.$espace."\n";
             fwrite($myfile,$b02);
            }
            // ----> b03 <----
              // n(6) n_nb_salaries
              if(strlen($n_nb_salaries)<=6)
              {
              $x=6-strlen($n_nb_salaries);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $n_nb_salaries;
                $n_nb_salaries=$y;
              }
              }
              // n(6) n_t_enfants
              if(strlen($n_t_enfants)<=6)
              {
              $x=6-strlen($n_t_enfants);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $n_t_enfants;
                $n_t_enfants=$y;
              }
              }
              // n(12) n_t_af_payer
              if(strlen($n_t_af_payer)<=12)
              {
              $x=12-strlen($n_t_af_payer);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $n_t_af_payer;
                $n_t_af_payer=$y;
              }
              }
              // n(12) n_t_af_a_deduire
              if(strlen($n_t_af_a_deduire)<=12)
              {
              $x=12-strlen($n_t_af_a_deduire);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $n_t_af_a_deduire;
                $n_t_af_a_deduire=$y;
              }
              }
              // n(12) n_t_af_net_a_payer
              if(strlen($n_t_af_net_a_payer)<=12)
              {
              $x=12-strlen($n_t_af_net_a_payer);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $n_t_af_net_a_payer;
                $n_t_af_net_a_payer=$y;
              }
              }
              // n(15) n_t_num_immatriculations
              if(strlen($x_n_t_num_imm)<=15)
              {
              $x=15-strlen($x_n_t_num_imm);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $x_n_t_num_imm;
                $x_n_t_num_imm=$y;
              }
              }
              // n(12) n_t_af_a_reverser
              if(strlen($n_t_af_a_reverser)<=12)
              {
              $x=12-strlen($n_t_af_a_reverser);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $n_t_af_a_reverser;
                $n_t_af_a_reverser=$y;
              }
              }
              // n(6) n_t_jour_declares
              if(strlen($n_t_jour_declares)<=6)
              {
              $x=6-strlen($n_t_jour_declares);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $n_t_jour_declares;
                $n_t_jour_declares=$y;
              }
              }
              // n(15) n_t_salaire_reel
              if(strlen($n_t_salaire_reel)<=15)
              {
              $x=15-strlen($n_t_salaire_reel);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $n_t_salaire_reel;
                $n_t_salaire_reel=$y;
              }
              }
              // n(13) n_t_Salaire_Plaf
              if(strlen($n_t_Salaire_Plaf)<=13)
              {
              $x=13-strlen($n_t_Salaire_Plaf);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $n_t_Salaire_Plaf;
                $n_t_Salaire_Plaf=$y;
              }
              }
              // n(19) n_t_S_Ctr
              if(strlen($n_t_S_Ctr)<=19)
              {
              $x=19-strlen($n_t_S_Ctr);
              for($i=1;$i<=$x;$i++)
              {
                $y="0". $n_t_S_Ctr;
                $n_t_S_Ctr=$y;
              }
              }
             // an(116) espace b03
             $espace=' ';
              for($i=1;$i<=116;$i++)
              {
                $y=" ".$espace;
                $espace=$y;
              }
            //write b03
            $b03 =
             "B03".$n_num_affilie.$l_periode.$n_nb_salaries.$n_t_enfants. $n_t_af_payer. $n_t_af_a_deduire.$n_t_af_net_a_payer.$x_n_t_num_imm.$n_t_af_a_reverser.
             $n_t_jour_declares.$n_t_salaire_reel.$n_t_Salaire_Plaf.$n_t_S_Ctr.$espace."\n";
             fwrite($myfile,$b03);
            // ----> b04 <----
            $param_cnss_t='';
            $n_t_Salaire_Plaf_en=0;
            $n_t_S_Ctr_en=0;
            $sql="SELECT *  FROM llx_cnss_temporary";
            $rest_cnss_t=$db->query($sql);
            $param_cnss = ((object)($rest_cnss_t))->fetch_assoc();
            //n_num_affilie
            $n_num_affilie=$param_cnss['n_num_affilie'];
            //l_periode
            $l_periode=$param_cnss['date']; 
            //date_cnss_t
            $date_cnss_t=$param_cnss['annee'].'-'.$param_cnss['mois'];
            $sql="SELECT *  FROM llx_Paie_UserInfo ";
            $rest_cnss=$db->query($sql);       
            foreach($rest_cnss as $info_cnss)
            {
              //cin
              $param_cin='';
              $sql="SELECT *  FROM llx_user_extrafields WHERE rowid=" .$info_cnss['userid'] . " ";
              $rest_cin=$db->query($sql);
              $param_cin = ((object)($rest_cin))->fetch_assoc();
             // $n_cin=;
              //n_num_assure declares entrants
              $n_num_assure=$info_cnss['cnss'] ;
              //n_jour_declares declares entrants
              $param_dl='';
              $sql5="SELECT *  FROM llx_Paie_MonthDeclaration WHERE userid=" .$info_cnss['userid'] . " ";
              $rest_dl=$db->query($sql5);
              $param_dl = ((object)($rest_dl))->fetch_assoc();
              $n_jour_declares=$param_dl['workingDays'];
              //n_salaire_reel  declares entrants
              $param_dl['salaireBrut']=$param_dl['salaireBrut']*100;
              $n_salaire_reel=$param_dl['salaireBrut'];
              //Salaire_Plaf  declares entrants
              $sql = "SELECT * FROM llx_Paie_Rub WHERE rub=700";
              $res = $db->query($sql);
              $param_cnss = ((object)($res))->fetch_assoc();
              $tauxcnss=$param_cnss["percentage"]/100;
              $maxcnss=($param_cnss["plafond"]/$tauxcnss)*100;
              $Salaire_Plaf=$param_dl['salaireBrut']>$maxcnss?$maxcnss:$param_dl['salaireBrut'];
              //S_Ctr  declares entrants
              $S_Ctr=$n_num_assure+$n_jour_declares+$n_salaire_reel+$Salaire_Plaf;
              //import data from user
              $param_date='';
              $sql="SELECT *  FROM llx_user WHERE rowid=" .$info_cnss['userid'] . " ";
              $rest_date=$db->query($sql);
              foreach($rest_date as $info_date)
              {
                  //lastname and firstname declares entrants
                  $l_nom=$info_date['lastname'];
                  $l_prenom=$info_date['firstname'];
                  //date declares entrants
                  $date_user=$info_date['dateemployment'];  
                  $one_date=strtotime($date_cnss_t);
                  $two_date=strtotime($date_user);
                  $day_num=$one_date-$two_date;
                  //days entrants
                  $day=floor($day_num/(60*60*24));
                  if($day>0 && $day<=30 )
                  {
                    //n_t_num_immatriculations  declares entrants
                    $x_n_t_num_imm_en=$n_t_num_imm_en+$n_num_assure;
                    $n_t_num_imm_en=$x_n_t_num_imm_en;
                    //n_t_jour_declares  declares entrants
                    $n_t_jour_declares_en=$n_t_jour_declares_en+$n_jour_declares;
                    $n_t_jour_declares_en=$n_t_jour_declares_en;
                    //n_t_salaire_reel declares entrants
                    $n_t_salaire_reel_en=$n_t_salaire_reel_en+$n_salaire_reel;
                    $n_t_salaire_reel_en=$n_t_salaire_reel_en;
                    //n_t_Salaire_Plaf declares entrants
                    $n_t_Salaire_Plaf_en=$n_t_Salaire_Plaf_en+$Salaire_Plaf;
                    $n_t_Salaire_Plaf_en=$n_t_Salaire_Plaf_en;
                    //n_t_S_Ctr declares entrants
                    $n_t_S_Ctr_en=$n_t_S_Ctr_en+$S_Ctr;
                    $n_t_S_Ctr_en=$n_t_S_Ctr_en;
                    // n_nbr_salaries declares entrants
                    $n_nbr_salaries_en++;
                    // n(9) n_num_assure
                    if(strlen($n_num_assure)<=9)
                    {
                    $x=9-strlen($n_num_assure);
                    for($i=1;$i<=$x;$i++)
                    {
                      $y="0".$n_num_assure;
                      $n_num_assure=$y;
                    }
                    }
                    // n(30) l_nom
                    if(strlen($l_nom)<=30)
                    {
                    $x=30-strlen($l_nom);
                    for($i=1;$i<=$x;$i++)
                    {
                      $y=$l_nom." ";
                      $l_nom=$y;
                    }
                    }
                    // n(30) l_prenom
                    if(strlen($l_prenom)<=30)
                    {
                    $x=30-strlen($l_prenom);
                    for($i=1;$i<=$x;$i++)
                    {
                      $y=$l_prenom." ";
                      $l_prenom=$y;
                    }
                    }
                    // n(8) cin
                    if(strlen($param_cin['cin'])<=8)
                    {
                    $x=8-strlen($param_cin['cin']);
                    for($i=1;$i<=$x;$i++)
                    {
                      $y=$param_cin['cin']." ";
                      $param_cin['cin']=$y;
                    }
                    }
                    // n(2) n_jour_declares
                    if(strlen($n_jour_declares)<=2)
                    {
                    $x=2-strlen($n_jour_declares);
                    for($i=1;$i<=$x;$i++)
                    {
                      $y="0".$n_jour_declares;
                      $n_jour_declares=$y;
                    }
                    }
                    // n(13) n_salaire_reel
                    if(strlen($n_salaire_reel)<=13)
                    {
                    $x=13-strlen($n_salaire_reel);
                    for($i=1;$i<=$x;$i++)
                    {
                      $y="0".$n_salaire_reel;
                      $n_salaire_reel=$y;
                    }
                    }
                    // n(9) Salaire_Plaf
                    if(strlen($Salaire_Plaf)<=9)
                    {
                    $x=9-strlen($Salaire_Plaf);
                    for($i=1;$i<=$x;$i++)
                    {
                      $y="0".$Salaire_Plaf;
                      $Salaire_Plaf=$y;
                    }
                    }
                    // n(19) S_Ctr
                    if(strlen($S_Ctr)<=19)
                    {
                    $x=19-strlen($S_Ctr);
                    for($i=1;$i<=$x;$i++)
                    {
                      $y="0".$S_Ctr;
                      $S_Ctr=$y;
                    }
                    }
                    // an(124) espace b04
                    $espace=' ';
                    for($i=1;$i<=123;$i++)
                    {
                     $y=" ".$espace;
                     $espace=$y;
                    }
                    //write b04 in file declares entrants
                    $b04 =
                    "B04".$n_num_affilie.$l_periode.$n_num_assure.$l_nom.$l_prenom.$param_cin['cin'].$n_jour_declares. $n_salaire_reel.$Salaire_Plaf.$S_Ctr.$espace."\n";
                    fwrite($myfile,$b04);   
                  } 
              }
            }

            // ----> b05 <----
            // n(6) n_nbr_salaries_en
            if(strlen($n_nbr_salaries_en)<=6)
            {
            $x=6-strlen($n_nbr_salaries_en);
            for($i=1;$i<=$x;$i++)
            {
              $y="0". $n_nbr_salaries_en;
              $n_nbr_salaries_en=$y;
            }
            }
            // n(15)n_t_num_imm_en
            if(strlen($n_t_num_imm_en)<=15)
            {
            $x=15-strlen($n_t_num_imm_en);
            for($i=1;$i<=$x;$i++)
            {
              $y="0". $n_t_num_imm_en;
              $n_t_num_imm_en=$y;
            }
            }
            // n(6)n_t_jour_declares_en
            if(strlen($n_t_jour_declares_en)<=6)
            {
            $x=6-strlen($n_t_jour_declares_en);
            for($i=1;$i<=$x;$i++)
            {
              $y="0". $n_t_jour_declares_en;
              $n_t_jour_declares_en=$y;
            }
            }
            // n(15)n_t_salaire_reel_en
            if(strlen($n_t_salaire_reel_en)<=15)
            {
            $x=15-strlen($n_t_salaire_reel_en);
            for($i=1;$i<=$x;$i++)
            {
              $y="0". $n_t_salaire_reel_en;
              $n_t_salaire_reel_en=$y;
            }
            }
            // n(13)n_t_Salaire_Plaf_en
            if(strlen($n_t_Salaire_Plaf_en)<=13)
            {
            $x=13-strlen($n_t_Salaire_Plaf_en);
            for($i=1;$i<=$x;$i++)
            {
              $y="0". $n_t_Salaire_Plaf_en;
              $n_t_Salaire_Plaf_en=$y;
            }
            }
            // n(19)n_t_S_Ctr_en
            if(strlen($n_t_S_Ctr_en)<=19)
            {
            $x=19-strlen($n_t_S_Ctr_en);
            for($i=1;$i<=$x;$i++)
            {
              $y="0". $n_t_S_Ctr_en;
              $n_t_S_Ctr_en=$y;
            }
            }
            // an(170) espace b06 and b05
            $espace=' ';
            for($i=1;$i<=169;$i++)
            {
              $y=" ".$espace;
              $espace=$y;
            }
            //write b05 in file  declares entrants
            $b05 =
                "B05".$n_num_affilie.$l_periode.$n_nbr_salaries_en.$n_t_num_imm_en.$n_t_jour_declares_en. $n_t_salaire_reel_en
                .$n_t_Salaire_Plaf_en.$n_t_S_Ctr_en.$espace."\n";
                fwrite($myfile,$b05);  
            // ----> b06 <----
             //n_nbr_salaries entrants + existants
             $n_nbr_salaries_en_ex=$n_nb_salaries+$n_nbr_salaries_en;
             //n_t_num_imm entrants + existants
             $n_t_num_imm_en_ex=$x_n_t_num_imm+$n_t_num_imm_en;
             //n_t_jours_declares entrants + existants
             $n_t_jour_declares_en_ex=$n_t_jour_declares_en+$n_t_jour_declares;
             //n_t_salaire_reel entrants + existants
             $n_t_salaire_reel_en_ex=$n_t_salaire_reel+$n_t_salaire_reel_en;
             //n_t_Salaire_Plaf entrants + existants
             $n_t_Salaire_Plaf_en_ex=$n_t_Salaire_Plaf+$n_t_Salaire_Plaf_en;
             //n_t_S_Ctr entrants + existants
             $n_t_S_Ctr_en_ex=$n_t_S_Ctr+$n_t_S_Ctr_en;
             // n(6) n_nbr_salaries_en_ex
             if(strlen($n_nbr_salaries_en_ex)<=6)
             {
             $x=6-strlen($n_nbr_salaries_en_ex);
             for($i=1;$i<=$x;$i++)
             {
               $y="0". $n_nbr_salaries_en_ex;
               $n_nbr_salaries_en_ex=$y;
             }
             }
             // n(15)n_t_num_imm_en_ex
             if(strlen($n_t_num_imm_en_ex)<=15)
             {
             $x=15-strlen($n_t_num_imm_en_ex);
             for($i=1;$i<=$x;$i++)
             {
               $y="0". $n_t_num_imm_en_ex;
               $n_t_num_imm_en_ex=$y;
             }
             }
             // n(6)n_t_jour_declares_en_ex
             if(strlen($n_t_jour_declares_en_ex)<=6)
             {
             $x=6-strlen($n_t_jour_declares_en_ex);
             for($i=1;$i<=$x;$i++)
             {
               $y="0". $n_t_jour_declares_en_ex;
               $n_t_jour_declares_en_ex=$y;
             }
             }
             // n(15)n_t_salaire_reel_en_ex
             if(strlen($n_t_salaire_reel_en_ex)<=15)
             {
             $x=15-strlen($n_t_salaire_reel_en_ex);
             for($i=1;$i<=$x;$i++)
             {
               $y="0". $n_t_salaire_reel_en_ex;
               $n_t_salaire_reel_en_ex=$y;
             }
             }
             // n(13)n_t_Salaire_Plaf_en_ex
             if(strlen($n_t_Salaire_Plaf_en_ex)<=13)
             {
             $x=13-strlen($n_t_Salaire_Plaf_en_ex);
             for($i=1;$i<=$x;$i++)
             {
               $y="0". $n_t_Salaire_Plaf_en_ex;
               $n_t_Salaire_Plaf_en_ex=$y;
             }
             }
             // n(19)n_t_S_Ctr
             if(strlen($n_t_S_Ctr_en_ex)<=19)
             {
             $x=19-strlen($n_t_S_Ctr_en_ex);
             for($i=1;$i<=$x;$i++)
             {
               $y="0". $n_t_S_Ctr_en_ex;
               $n_t_S_Ctr_en_ex=$y;
             }
             }
             //write b06 in file
             $b06 =
             "B06".$n_num_affilie.$l_periode.$n_nbr_salaries_en_ex.$n_t_num_imm_en_ex. $n_t_jour_declares_en_ex. $n_t_salaire_reel_en_ex. $n_t_Salaire_Plaf_en_ex
             .$n_t_S_Ctr_en_ex.$espace."\n";
             fwrite($myfile,$b06);
             //close file
             fclose($myfile);
             //Dowloand file Ds
             ob_clean();
             $sqlll="SELECT *  FROM llx_cnss_temporary";
             $rest_l=$db->query($sqlll);
             $param_l = ((object)($rest_l))->fetch_assoc();   
             $DsFile='DS_'.$param_l['n_num_affilie'].'_'.$param_l['date'].'.TXT';
             header('Content-Type: application/txt');
             header('Content-Disposition: attachment; filename='."$DsFile");
             flush();
             readfile($fileNameWrite);
             exit();
        }
      ?>
      </div> 
    </center>
  </body>
</html>