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

<body>

  <div class="container ">
    <center>
      <div class="grid">
        <!-- salaire net!!!!! -->
        <div class="col-lg-4 ">
          <form method="post" class="shadow-lg p-3 mb-5 bg-body rounded mt-5">
            <ul class="form-style-1">
              <label style="text-align: center;" class="field-divided">Calcul de la nouvelle prime !</label>
              <li>
                <label>Liste des employés <span class="required">*</span></label>
                <select name="employe" required>
                  <option value="">Choisissez un employé</option>
                  <?php
                  $sql = "SELECT *  FROM llx_user where employee=1 ORDER BY lastname ASC";
                  $rest = $db->query($sql);
                  foreach ($rest as $user) {
                    echo '<option value=' . $user["rowid"] . '>' . $user["lastname"] . " " . $user["firstname"] . '</option>';
                  }
                  ?>
                </select>
              </li>
              <li style="margin-top: 26px;">
                <label> Nouvelle prime <span class="required">*</span></label>
                <input type="number" min="0" step="any" name="newprimes" class="field-divided" placeholder=" nouvelle prime" required />
              </li>
              <li style="margin-top: 18px;">
                <input type="submit" name="new_prime" value="Calcul" />
              </li>
            </ul>
          </form>
        </div>
        <!-- salaire de net!!!!! -->

        <?php
        if (isset($_POST['new_prime'])) { ?>
          <div class="">
            <!-- Les donnés  ancien ------------>
            <div class="col-lg-4 " style="margin-top: 10px;"> <?php
              require "code_calcul_new_prime.php";
             ?>

              <div class="alert2" role="alert">
                <label style="text-align: center;display:block;font-weight: bold;font-size: 20px;" class="field-divided"> -->LES DONNÉES ANCIENNES </label>
                <?php
                echo " Salaire de base : " . $sb . "<br>";
                echo " Indemnités : " . $les_indeminités0 . "<br>";
                echo " Primes : " . $primes . "<br>";
                echo " Charge de famille : " . $cf . "<br>";
                echo " Salaire net   : " . $salairenet . "<br>";
                echo " Jours travaillés annuel   : " . $comulWorkingDays . "<br>";
                echo " Prime de Rendement  : " . $prime_rendement . "<br>";

                ?>
              </div>
              <!-- Les donnés  nouveau ------------>
              <div class="alert3">
                <label style="text-align: center;display:block;font-weight: bold;font-size: 20px;" class="field-divided"> -->LES DONNÉES NOUVELLES</label>
                <?php
                require "code_calcul_new_prime.php";
                echo " Salaire brut imposable : " . round($sbi, 2) . "<br>";
                echo " CNSS : " . round($cnss, 2) . "<br>";
                echo " CNSS Patronale : " . round($cnss_patronale, 2) . "<br>";
                echo " AMO : " . round($amo, 2) . "<br>";
                echo " Participation AMO : " . round($participation_amo, 2) . "<br>";
                echo " AMO Patronale : " . round($amo_patronale, 2) . "<br>";
                echo " Allocation Familiale : " . round($allocaton_familale, 2) . "<br>";
                if ($mutule_active == 1) {
                  echo " Mutuelle : " . round($mutuelle, 2) . "<br>";
                  echo " Mutuelle Patronale : " . round($mutuelle_patronale, 2) . "<br>";
                }
                if ($cimr_active == 1) {
                  echo " CIMR : " .  round($cimr, 2)  . "<br>";
                  echo " CIMR Patronale : " . round($cimr_patronale, 2) . "<br>";
                }
                echo " Frais Professionnels : " . round($fraie_professionnels, 2) . "<br>";
                echo " Salaire net imposable : " . round($sni, 2) . "<br>";
                echo " IR brut : " . round($ir_b, 2) . "<br>";
                echo " IR net : " . round($ir_n, 2) . "<br>";
                echo " Salaire net + nouvelle prime  : " . $sn . "<br>";
                echo "--> Nouvelle prime brut : " . round($new_prime, 2) . "<br>";
                ?>
              </div>

            </div>


          <?php
          //open file



        }
          ?>
          </div>
      </div>
  </div>
  </center>
  </div>


</body>

</html>