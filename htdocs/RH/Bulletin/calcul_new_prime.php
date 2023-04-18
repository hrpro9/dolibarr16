<?php
    // Load Dolibarr environment
    require_once '../../main.inc.php';
    require_once '../../vendor/autoload.php';
  llxHeader("", "");
?>

<!doctype html>
<html lang="en">
  <head>
  <link rel="stylesheet" href="calcul_Style.css">
  </head>
  <body >

    <div class="container " >
      <center>
        <div class="grid">
          <!-- salaire net!!!!! -->
            <div class="col-lg-4 " >
              <form method="post" class="shadow-lg p-3 mb-5 bg-body rounded mt-5">
                  <ul class="form-style-1" >
                    <label style="text-align: center;" class="field-divided">Calcul nouveau prime !!!</label>
                    <li>
                      <label>Liste de employe <span class="required">*</span></label>
                      <select  name="employe" required>
                          <option value="">Choose a employe</option>
                          <?php 
                            $sql="SELECT *  FROM llx_user";
                            $rest=$db->query($sql);
                            foreach($rest as $user)
                            {
                            echo '<option value=' .$user["rowid"].'>'. $user["lastname"] . " " . $user["firstname"] . '</option>';
                            }
                          ?>     
                      </select>
                    </li>
                    <li style="margin-top: 26px;">
                      <label> Nouveau primes <span class="required">*</span></label>
                      <input type="number" min="0" step="any" name="newprimes"  class="field-divided" placeholder=" nouveau primes" required />
                    </li>
                    <li style="margin-top: 18px;">
                      <input type="submit"  name="new_prime" value="Calcul" />
                    </li>        
                  </ul>
                </form>
            </div>     
            <!-- salaire de net!!!!! -->
         
                  <?php
                    if(isset($_POST['new_prime']))
                    {?>
                    <div class="">
                      <!-- Les donnés  ancien ------------>
                      
               

                    <!-- Les donnés  nouveau ------------>

                    <div class="col-lg-4 "  style="margin-top: 10px;"> <?php
                          require "code_calcul_new_prime.php";  
                          ?>
                         
                          <div class="alert1" role="alert" >
                          <label style="text-align: center;display:block;font-weight: bold;font-size: 22px;"  class="field-divided"> --> LES DONNES ANCIEN </label>
                        <?php
                            echo " Salaire de base : ". $sb."<br>";
                            echo " Les_indeminités : ".$les_indeminités ."<br>";
                            echo " Charge de famille : ".$cf ."<br>";
                            echo " Primes : ".$primes ."<br>";
                            echo " Salaire  net   : ".$salairenet ."<br>";
                          

                          ?> 
                          </div>
                          <div class="alert2" >
                          <label style="text-align: center;display:block;font-weight: bold;font-size: 22px;"  class="field-divided"> --> LES DONNES NOUVEAU   </label>
                          <?php
                          require "code_calcul_new_prime.php"; 
                          echo " salair brut imposable : ".round($sbi,2) ."<br>";
                          echo " CNSS : ".round($cnss,2) ."<br>";
                          echo " CNSS Patronale : ".round($cnss_patronale,2) ."<br>";
                          echo " AMO : ".round($amo,2) ."<br>";
                          echo " Participation AMO : ".round($participation_amo,2) ."<br>";
                          echo " AMO Patronale : ".round($amo_patronale,2) ."<br>";
                          echo " Allocaton Familale : ".round($allocaton_familale,2) ."<br>";
                          if($mutule_active==1)
                          {
                            echo " MUTUELLE : " . round($mutuelle, 2) . "<br>";  
                            echo " MUTUELLE Patronale : " . round($mutuelle_patronale, 2) . "<br>";  
                          }
                          if($cimr_active==1)
                          {
                          echo "  CIMR : ".  round($cimr, 2)  ."<br>"; 
                          echo " CIMR Patronale : " . round($cimr_patronale, 2) . "<br>";
                          }
                          echo " Fraie Professionnels : ".round($fraie_professionnels,2) ."<br>";
                          echo " Salair net imposable : ".round($sni,2) ."<br>";
                          echo " Ir brut : ".round($ir_b,2) ."<br>";
                          echo " Ir net : ".round($ir_n,2)."<br>" ;
                        
                          
                         

                          echo " Salaire  net + nouveau prime  : ".$sn ."<br>";   
                          echo "--> nouveau Prime : ".round($new_prime,2) ."<br>";
                          ?> 
                          </div>
                        
                    </div>
                    
                     
                       <?php
                    }
                  ?>
                </div>
            </div>
        </div>
      </center>
    </div>


  </body>
</html>
