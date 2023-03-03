 <!doctype html>
<html lang="en">
  <head>  
     <link rel="stylesheet" href="style.css">
  </head> 
  <body > 

    <div class="container ">
        <div class="row">
            <div class="col-lg-4 ">
              <form method="post" class="shadow-lg p-3 mb-5 bg-body rounded mt-5">
                <ul class="form-style-1">
                  <h4 style="text-align: center;" class="field-divided">Calcul Salaire de base !!!</h4>
                  <li>
                    <label>salaire net <span class="required">*</label>
                    <input type="number" step="any" name="sn"   class="field-divided" placeholder="salaire de base" required/>
                    
                  </li>
                  <li style="margin-top: 26px;">
                    <label>primes <span class="required">*</span></label>
                    <input type="number" step="any" name="primes"class="field-divided" placeholder="primes" required />
                  </li>
                  <li style="margin-top: 26px;"> 
                    <label>les_indeminités <span class="required">*</span></label>
                    <input type="number" step="any" name="les_indeminités" class="field-divided" placeholder="les_indeminités" required />
                  </li>
                  <li style="margin-top: 26px;">
                    <label>charge de famille <span class="required">*</span></label>
                    <input type="number" step="any" name="cf"  class="field-divided" placeholder="charge de famille" required/>
                  </li>
                  <li style="margin-top: 18px;">
                    <input type="submit"  name="salaire_base" value="Calcul" />
                  </li>        
                </ul>
              </form>
            </div>    
            <div class="">
             <?php
           //  require "code_calcul_salaire_base copy.php";
          //   echo "----> ir brut : ".round($ir_b,2) ."<br>";
            //      echo $params["maxCNSS"] ;
                  if(isset($_POST['salaire_base']))
                  {
                   // require "code_calcul_salaire_base copy.php";
                   require "code_calcul_salaire_base.php";
                    ?>
                    <div class="alert1" role="alert" style="margin-left: 50%; width: 20%;margin-top: -2%;">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?php
                      echo "----> salaire  net : ".$sn ."<br>";
                      echo "----> primes : ".$primes ."<br>";
                      echo "----> les_indeminités : ".$les_indeminités ."<br>";
                      echo "----> salair brut imposable : ".round($sbi,2) ."<br>";
                      echo "----> cnss : ".round($cnss,2) ."<br>";
                      echo "----> amo : ".round($amo,2) ."<br>";
                      echo "----> fraie_professionnels : ".round($fraie_professionnels,2) ."<br>";
                      echo "----> salair net imposable : ".round($sni,2) ."<br>";
                      echo "----> ir brut : ".round($ir_b,2) ."<br>";
                      echo "----> charge de famille : ".$cf ."<br>";
                      echo "----> ir net : ".round($ir_n,2)."<br>" ;
                    ?> 
                    </div>
                    <div class="alert2" style="margin-left: 50%; width: 20%;">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?php
                    echo "----> salaire de base : ". $sb;
                    ?> 
                    </div> 
                    <div class="alert3" role="alert" style="margin-left: 50%; width: 20%;">  
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <h3  style="text-align: center;" class="">charges patronale !</h3>
                    <?php
                      echo "----> cnss patronale : ".round($cnss_patronale,2) ."<br>";
                      echo "----> allocaton familale : ".round($allocaton_familale,2) ."<br>";
                      echo "----> participation amo : ".round($participation_amo,2) ."<br>";
                      echo "----> amo patronale : ".round($amo_patronale,2) ."<br>";
                    ?> 
                    </div>  <?php
                  }    
              ?>
            </div>
        </div>
    </div>



  </body>
</html> 