<?php
// Load Dolibarr environment
require '../../main.inc.php';
require_once '../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';

$action = GETPOST('action');
if ($action != 'generate')
    llxHeader("", "");

?>

<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <center>
        <div class="col-lg-4 m-auto">
            <form method="post">
                <input type="hidden" name="action" value="generate">
                <ul class="form-style-1" style="text-align: center;">
                    <h4 style="text-align: center;" class="field-divided">Declaration CIMR !</h4>
                    <li>
                        <label>N°d'adhérent <span class="required">* </label>
                        <input type="text" name="n_adherent" class="field-divided" placeholder="N°d'adhérent" required />
                    </li>
                    <li>
                        <label>Trimestre & Année de cotisation <span class="required">* </label>
                        <select name="trimestriel" required>
                            <option value="">Choose a Trimestriel</option>
                            <option value="1">Trimestre 1 </option>
                            <option value="2">Trimestre 2</option>
                            <option value="3">Trimestre 3</option>
                            <option value="4">Trimestre 4</option>
                        </select>
                        <input type="reset" name="annee" value="<?php echo date('Y') ?>">
                    </li>
                    <li style="margin-top: 18px;">
                        <input type="submit" name="telecharge_cimr" value="Télécharge" />
                    </li>
                </ul>
            </form>
            <?php
            if (isset($_POST['telecharge_cimr'])) {

                $txtf = '';
                $n_adherent = 0;
                $trimestre = $_POST['trimestriel'];
                $annee = date('Y');
                $n_adherent = $_POST['n_adherent'];
                //open file
                $fileNameWrite =  DOL_DOCUMENT_ROOT . '/RH/Bulletin/files/Cimr.txt';
                file_put_contents($fileNameWrite, '');
                $myfilee = fopen("$fileNameWrite", "a+") or die("Unable to open file!");


                function NombrePositionsAlphabetique($nom, $y) // y= " numbre de position "
                {
                    $nom =trim($nom);
                    if (strlen($nom) <= $y) {
                        $x = $y - strlen($nom);
                        for ($i = 1; $i <= $x; $i++) {
                            $y = $nom . " ";
                            $nom = $y;
                        }
                    }
                    return $nom;
                }
                function NombrePositionsNumerique($nom, $y) // y= " numbre de position "
                {
                    if (strlen($nom) <= $y) {
                        $x = $y - strlen($nom);
                        for ($i = 1; $i <= $x; $i++) {
                            $y = "0" . $nom;
                            $nom = $y;
                        }
                    }else{             
                        $nom = substr($nom, 0, $y);
                    }
                    return $nom;
                }

                $sql = "SELECT * FROM llx_user where employee=1";
                $rest = $db->query($sql);
                foreach ($rest as $user) {
                    $salairebrut = 0;
                    if(!empty( $txtf))
                    {
                        $txtf=0;
                    }
                    $sql = "SELECT *  FROM llx_Paie_UserInfo WHERE userid=" . $user['rowid'] . "  ";
                    $rest_paie_userInfo = $db->query($sql);
                    $param_paie_userInfo = ((object)($rest_paie_userInfo))->fetch_assoc();
                    //----------------------------------------------------------------------------------
                    $sql = "SELECT *  FROM llx_user_extrafields WHERE fk_object=" . $user['rowid'] . "  ";
                    $rest_user_extrafields = $db->query($sql);
                    $param_puser_extrafields = ((object)($rest_user_extrafields))->fetch_assoc();
                    //----------------------------------------------------------------------------------
                    $sql = "SELECT *  FROM llx_Paie_MonthDeclarationRubs WHERE userid=" . $user['rowid'] . "  ";
                    $rest_paie_mdeclarationRubs = $db->query($sql);
                    $param_paie_mdeclarationRubs = ((object)($rest_paie_mdeclarationRubs))->fetch_assoc();
                    //----------------------------------------------------------------------------------
                    $sql = "SELECT *  FROM llx_Paie_MonthDeclaration WHERE userid=" . $user['rowid'] . " ";
                    $rest_paie_mdeclaration = $db->query($sql);
                
                    $sql = "SELECT * FROM llx_Paie_UserParameters WHERE userid = " . $user['rowid'] . " AND (rub = 710 AND checked = 1 OR rub = 712 AND checked = 1)";
                    $rest_paie_userparameters=$db->query($sql);
                    $param_paie_userparameters = ((object)($rest_paie_userparameters))->fetch_assoc();
                    $tcimr=( $param_paie_userparameters['rub']==710 )?'0300':'0600';

                        if(!empty($param_paie_userInfo['cimr']) && $param_paie_userInfo['cimr']!=0)
                        {

                           
                            foreach ($rest_paie_mdeclaration as $mdeclaration) {
                                if ($mdeclaration["year"] == $annee ) {
        
                                    $l_situation = (!empty($param_puser_extrafields['l_situation'])) ? $param_puser_extrafields['l_situation'] : "0";
                                    $enregistrement_value = ($l_situation == 1 || $l_situation == 2  || $l_situation == 6 || $l_situation == 7) ? 7 : 2;
                                    $code_enregistrement = NombrePositionsNumerique($enregistrement_value, 1);
                                    $numero_dadherent = NombrePositionsNumerique($n_adherent, 6);
                                    $numero_categorie = NombrePositionsNumerique('01', 2);
                                    $matriculeCimr = NombrePositionsNumerique($param_paie_userInfo['cimr'], 9);
                                  //  $tauxcimr = (!empty($param_puser_extrafields['tauxcimr'])) ? $param_puser_extrafields['tauxcimr'] : "0"; //---------------------------> taux cimr  ????????????????????
                                    $tauxCotisation = NombrePositionsNumerique($tcimr, 4);
                                    $nom = NombrePositionsAlphabetique($user['lastname'], 25);
                                    $prenom = NombrePositionsAlphabetique($user['firstname'], 25);
                                    $numeroInterieurSociete = NombrePositionsNumerique($param_puser_extrafields['matricule'], 6); 
                                    $sex_value = ($user['gender'] == "man") ? "M" : "F";
                                    $sex = NombrePositionsAlphabetique($sex_value, 1);
                                    $nationalite = NombrePositionsAlphabetique(!empty($param_puser_extrafields['nationalite']) ? $param_puser_extrafields['nationalite'] : 'M', 1);
                                    $dateAff = !empty($param_puser_extrafields['date_daffiliation']) ? date("jmY", strtotime($param_puser_extrafields['date_daffiliation'])) : '';
                                    $date_daffiliation = NombrePositionsNumerique($dateAff, 8);
                                    $datetime_naissance = new DateTime($user['birth']);
                                    $jour_naissance = $datetime_naissance->format('d');
                                    $mois_naissance = $datetime_naissance->format('m');
                                    $annee_naissance = $datetime_naissance->format('Y');
                                    $date_naissance_value = $jour_naissance . $mois_naissance . $annee_naissance;
                                    $date_naissance = NombrePositionsNumerique($date_naissance_value, 8);
                                    switch ($param_paie_mdeclarationRubs['situationFamiliale']) {
                                        case "DIVORCE":
                                            $stf = "D";
                                            break;
                                        case "MARIE":
                                            $stf = "M";
                                            break;
                                        case "CELIBATAIRE":
                                            $stf = "C";
                                            break;
                                        default:
                                            $stf = "V";
                                            break;
                                    }
                                    $stuationFamille = NombrePositionsAlphabetique($stf, 1);
                                    $nombreEnfants = NombrePositionsNumerique($param_paie_mdeclarationRubs['enfants'], 1);
        
                                    $dateemploymentend = $user['dateemploymentend'];
                                    if (empty($dateemploymentend)) {
                                        $dateSortie = NombrePositionsAlphabetique("", 8);
                                    } else {
                                        $datetime_sortie = new DateTime($dateemploymentend);
                                        $jour_sortie = $datetime_sortie->format('d');
                                        $mois_sortie = $datetime_sortie->format('m');
                                        $annee_sortie = $datetime_sortie->format('Y');
                                        $date_sortie = $jour_sortie . $mois_sortie . $annee_sortie;
                                        $dateSortie = NombrePositionsAlphabetique($date_sortie, 8);
                                    }
        
                                    $numCnie =NombrePositionsAlphabetique($param_puser_extrafields['cin'], 10);                
                                    $numCnss = NombrePositionsNumerique($param_paie_userInfo['cnss'], 10);
                                    $user_mobile = $user['user_mobile'];
                                    //GSM
                                    if (strlen($user_mobile) == 10) {
                                        $user_mobile = str_replace($user_mobile[0], "212", $user_mobile);
                                    }
                                    $numGSM = NombrePositionsNumerique($user_mobile, 14);
                                    $adresseEmail = NombrePositionsAlphabetique($user['email'], 35);
        
        
                                    $monthD = $mdeclaration["month"]; // month declaration
        
                                    switch ($trimestre) {
                                        case 1:
                                            if ($monthD == 1 || $monthD == 2 || $monthD == 3) {
                                                $salairebrut += round($mdeclaration["salaireBrut"], 2) * 100;
                                                $salaireSoumisContributions = NombrePositionsNumerique($salairebrut, 10);
                                                $txtf = $code_enregistrement . $numero_dadherent . $numero_categorie . $matriculeCimr . $tauxCotisation .
                                                $nom . $prenom .  $numeroInterieurSociete . $sex . $nationalite . $date_daffiliation . $date_naissance . $stuationFamille . $nombreEnfants .
                                                $salaireSoumisContributions . $dateSortie .  $numCnie  . $numCnss . $numGSM . $adresseEmail . $trimestre . $annee . "\n";
                                            }
                                            break;
                                        case 2:
                                            if ($monthD == 4 || $monthD == 5 || $monthD == 6) {
                                                $salairebrut += round($mdeclaration["salaireBrut"], 2) * 100;
                                                $salaireSoumisContributions = NombrePositionsNumerique($salairebrut, 10);
                                                $txtf = $code_enregistrement . $numero_dadherent . $numero_categorie . $matriculeCimr . $tauxCotisation .
                                                    $nom . $prenom .  $numeroInterieurSociete . $sex . $nationalite . $date_daffiliation . $date_naissance . $stuationFamille . $nombreEnfants .
                                                    $salaireSoumisContributions . $dateSortie .  $numCnie . $numCnss . $numGSM . $adresseEmail . $trimestre . $annee  . "\n";
                                            }
                                            break;
                                        case 3:
                                            if ($monthD == 7 || $monthD == 8 || $monthD == 9) {
                                                $salairebrut += round($mdeclaration["salaireBrut"], 2) * 100;
                                                $salaireSoumisContributions = NombrePositionsNumerique($salairebrut, 10);
                                                $txtf = $code_enregistrement . $numero_dadherent . $numero_categorie . $matriculeCimr . $tauxCotisation .
                                                    $nom . $prenom .  $numeroInterieurSociete  . $sex . $nationalite . $date_daffiliation . $date_naissance . $stuationFamille . $nombreEnfants .
                                                    $salaireSoumisContributions . $dateSortie .  $numCnie . $numCnss . $numGSM . $adresseEmail . $trimestre . $annee  . "\n";
                                            }
                                            break;
                                        case 4:
                                            if ($monthD == 10 || $monthD == 11 || $monthD == 12) {
                                                $salairebrut += round($mdeclaration["salaireBrut"], 2) * 100;
                                                $salaireSoumisContributions = NombrePositionsNumerique($salairebrut, 10);
                                                $txtf = $code_enregistrement . $numero_dadherent . $numero_categorie . $matriculeCimr . $tauxCotisation .
                                                    $nom . $prenom .  $numeroInterieurSociete . $sex . $nationalite . $date_daffiliation . $date_naissance . $stuationFamille . $nombreEnfants .
                                                    $salaireSoumisContributions . $dateSortie .  $numCnie . $numCnss . $numGSM . $adresseEmail . $trimestre . $annee  . "\n";
                                            }
                                            break;
                                        default:
                                            $txtf = "il n'y a pas d'trimestre\n";
                                            break;
                                    }
                                }
                            }
                        }
                    if($txtf != 0)
                    {
                        fwrite($myfilee, $txtf);
                    }  
                }


                fclose($myfilee);
                //Dowloand file Ds
                ob_clean();
                $DsFile = 'cimr' . $annee . $trimestre . '.TXT';
                header('Content-Type: application/txt');
                header('Content-Disposition: attachment; filename=' . "$DsFile");

                flush();
                readfile($fileNameWrite);
                exit();
            }
            ?>
        </div>
    </center>
</body>

</html>