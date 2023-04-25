<?php
// Load Dolibarr environment
require "../../main.inc.php";
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
        <div class="col-lg-4 cell">
          <form method="post" class="shadow-lg p-3 mb-5 bg-body rounded mt-5">
            <ul class="form-style-1">
              <label style="text-align: center;" class="field-divided">Calcul Salaire de base !!!</label>
              <li>
                <label>Salaire Net <span class="required">*</label>
                <input type="number" min="0" step="any" name="sn" class="field-divided" placeholder="salaire net" required />
              </li>
              <li style="margin-top: 26px;">
                <label>Les Indeminités <span class="required">*</span></label>
                <input type="number" min="0" step="any" name="les_indeminités" class="field-divided" placeholder="les_indeminités" required />
              </li>
              <li style="margin-top: 26px;">
                <label>Charge de Famille <span class="required">*</span></label>
                <input type="number" min="0" step="any" name="cf" class="field-divided" placeholder="charge de famille" required />
              </li>
              <div style="margin-top: 26px;">
                <label>Primes <span class="required">*</span></label>
                <div class="gridcheckbox">
                  <table style="border: 0px !important;">
                    <tr style="border: 0px !important;">
                      <td style="border: 0px !important;">
                        <h4>Scolarite <span class="required"><input type="checkbox" name="prime_de_scolarite" value="1" onclick="toggleInput(this, 'scolarite-input')"></span></h4>
                        <input type="number" id="scolarite-input" name="scolarite_input" style="display: none;">
                      </td>
                      <td style="border: 0px !important;">
                        <h4>Aid Adha <span class="required"><input type="checkbox" name="prime_aid_adha" value="1" onclick="toggleInput(this, 'aid-adha-input')"></span></h4>
                        <input type="number" id="aid-adha-input" name="aid_adha_input" style="display: none;">
                      </td>
                    </tr>
                    <tr style="border: 0px !important;">
                      <td style="border: 0px !important;">
                        <h4>Panier <span class="required"><input type="checkbox" name="prime_panier" value="1" onclick="toggleInput(this, 'panier-input')"></span></h4>
                        <input type="number" id="panier-input" name="panier_input" style="display: none;">
                      </td>
                      <td style="border: 0px !important;">
                        <h4>Transport <span class="required"><input type="checkbox" name="prime_transport" value="1" onclick="toggleInput(this, 'transport-input')"></span></h4>
                        <input type="number" id="transport-input" name="transport_input" style="display: none;">
                      </td>
                    </tr>
                    <tr style="border: 0px !important;">
                      <td style="border: 0px !important;">
                        <h4>Stage <span class="required"><input type="checkbox" name="stage_transport" value="1" onclick="toggleInput(this, 'stage-input')"></span></h4>
                        <input type="number" id="stage-input" name="stage_input" style="display: none;">
                      </td>
                      <td style="border: 0px !important;">
                        <h4>Responsabilite <span class="required"><input type="checkbox" name="responsabilite_transport" value="1" onclick="toggleInput(this, 'responsabilite-input')"></span></h4>
                        <input type="number" id="responsabilite-input" name="responsabilite_input" style="display: none;">
                      </td>
                    </tr>
                    <tr style="border: 0px !important;">
                      <td style="border: 0px !important;">
                        <h4>Formation <span class="required"><input type="checkbox" name="formation_transport" value="1" onclick="toggleInput(this, 'formation-input')"></span></h4>
                        <input type="number" id="formation-input" name="formation_input" style="display: none;">
                      </td>
                      <td style="border: 0px !important;">
                        <h4>Preavis <span class="required"><input type="checkbox" name="preavis_transport" value="1" onclick="toggleInput(this, 'preavis-input')"></span></h4>
                        <input type="number" id="preavis-input" name="preavis_input" style="display: none;">
                      </td>
                    </tr>
                    <tr>
                      <td style="border: 0px !important;">
                        <h4>Rendement <span class="required"><input type="checkbox" name="rendement_transport" value="1" onclick="toggleInput(this, 'rendement-input')"></span></h4>
                        <input type="number" id="rendement-input" name="rendement_input" style="display: none;">
                      </td>
                      <td style="border: 0px !important;">
                        <h4>Representation <span class="required"><input type="checkbox" name="representation_transport" value="1" onclick="toggleInput(this, 'representation-input')"></span></h4>
                        <input type="number" id="representation-input" name="representation_input" style="display: none;">
                      </td>
                    </tr>
                    <tr>
                      <td style="border: 0px !important;">
                        <h4>Fonction <span class="required"><input type="checkbox" name="fonction_transport" value="1" onclick="toggleInput(this, 'fonction-input')"></span></h4>
                        <input type="number" id="fonction-input" name="fonction_input" style="display: none;">
                      </td>
                      <td style="border: 0px !important;">
                        <h4>Indemnite Transport <span class="required"><input type="checkbox" name="indemnite_transport_transport" value="1" onclick="toggleInput(this, 'indemnite_transport-input')"></span></h4>
                        <input type="number" id="indemnite_transport-input" name="indemnite_transport_input" style="display: none;">
                      </td>
                    </tr>
                  </table>
                </div>

              </div>
              <div style="margin-top: 26px;">
                <label>Cotisation <span class="required">*</span></label>
                <li style="display: inline-block;">
                  <h4>CIMR <span class="required"> <input type="checkbox" name="cimr" value="1"></span></h4>
                </li>
                <li style="display: inline-block;">
                  <h4>MUTULLE <span class="required"> <input type="checkbox" name="mutuelle" value="1"></h4>
                </li>
              </div>

              <li style="margin-top: 18px;">
                <input type="submit" name="salaire_base" value="Calcul" />
              </li>

            </ul>
          </form>
        </div>
        <div>
          <?php
          //  require "code_calcul_salaire_base copy.php";
          //   echo "----> ir brut : ".round($ir_b,2) ."<br>";
          //      echo $params["maxCNSS"] ;
          if (isset($_POST['salaire_base'])) {
            // require "code_calcul_salaire_base copy.php";
            require "./code_calcul_salaire_base.php";
          ?>
            <div class="col-lg-4 cell" style="margin-top: 10px;">
              <div class="alert1" role="alert">
                <!--   <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>-->
                <?php
                echo " Salaire  net : " . $sn . "<br>";
                echo " Les_indeminités : " . $les_indeminités . "<br>";
                echo " Charge de famille : " . $cf . "<br>";
                echo " Primes : " . $primes . "<br>";

                echo " Salair brut imposable : " . round($sbi, 2) . "<br>";
                if ($mutuelle_check == 1) {
                  echo " MUTELLE : " . round($mutuelle, 2) . "<br>";
                }
                echo " CNSS : " . round($cnss, 2) . "<br>";
                echo " AMO : " . round($amo, 2) . "<br>";
                if ($cimr_check == 1) {
                  echo " CIMR : " . round($cimr, 2) . "<br>";
                }
                echo " Fraie Professionnels : " . round($fraie_professionnels, 2) . "<br>";
                echo " Salair net imposable : " . round($sni, 2) . "<br>";
                echo " Ir brut : " . round($ir_b, 2) . "<br>";
                echo " Ir net : " . round($ir_n, 2) . "<br>";

                ?>
              </div>
              <div class="alert2">
                <?php
                echo "----> Salaire de base : " . $sb . "<br>";
                ?>
              </div>
              <div class="alert3" role="alert">
                <h3 style="text-align: center;" class="">charges patronale !</h3>
                <?php
                echo " CNSS Patronale : " . round($cnss_patronale, 2) . "<br>";
                echo " Allocaton Familale : " . round($allocaton_familale, 2) . "<br>";
                echo " Participation AMO : " . round($participation_amo, 2) . "<br>";
                echo " AMO Patronale : " . round($amo_patronale, 2) . "<br>";
                if ($cimr_check == 1) {
                  echo " Cimr Patronale : " . round($cimr_patronale, 2) . "<br>";
                }
                if ($mutuelle_check == 1) {
                  echo " Mutuelle Patronale : " . round($mutuelle_patronale, 2) . "<br>";
                }
                ?>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </center>

  </div>

  <script>
    function toggleInput(checkbox, inputId) {
      var input = document.getElementById(inputId);
      if (checkbox.checked) {
        input.style.display = "block";
      } else {
        input.style.display = "none";
      }
    }
  </script>


</body>

</html>