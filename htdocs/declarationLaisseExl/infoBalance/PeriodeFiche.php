<?php
  // Load Dolibarr environment
  require_once '../../../../main.inc.php';
  require_once '../../../../vendor/autoload.php';
  use PhpOffice\PhpSpreadsheet\IOFactory;
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';

   $action = GETPOST('action');
   if ($action != 'generate')
    llxHeader("", "");
  
  if(isset($_POST['register']))
  {
        $annee=$_POST['annee'];
        $typeAnnee=$_POST['typeAnnee'];
        $anneeDu=$_POST['anneeDu'];
        $anneeAu=$_POST['anneeAu'];

        $nomFichier = 'infoBalance_'. $annee.'.php';
        $checkFile= DOL_DOCUMENT_ROOT.'/custom/etatscomptables/declarationLaisseExl/infoBalance/'.$nomFichier;
        if (!file_exists($checkFile)) {
            $uploadDirectory = './uploads/';  // The directory where you want to upload the files
            $newFileExcel='./balance/';
            // Handle file upload for $balanceN
            if (isset($_FILES['balanceN']) && $_FILES['balanceN']['error'] === UPLOAD_ERR_OK) {
                $tempName = $_FILES['balanceN']['tmp_name'];
                $newFileName = $uploadDirectory . basename($_FILES['balanceN']['name']);
                move_uploaded_file($tempName, $newFileName);
                //   echo 'File "balanceN" has been uploaded successfully.<br>';
                // Read the Excel file
                $excelFile = $newFileName ; // Replace with the correct path
                $spreadsheet = IOFactory::load($excelFile);
                $worksheet = $spreadsheet->getActiveSheet();
                $data = $worksheet->toArray();
                // Write the data to a PHP file
                $phpFileContent = '<?php' . PHP_EOL;
                $phpFileContent .= '$data = ' . var_export($data, true) . ';' . PHP_EOL;
                $phpFileContent .= '?>';
                file_put_contents($newFileExcel.'balanceN-'.$annee.'.php', $phpFileContent);
            }
            // Handle file upload for $balanceN1
            if (isset($_FILES['balanceN1']) && $_FILES['balanceN1']['error'] === UPLOAD_ERR_OK) {
                $tempName = $_FILES['balanceN1']['tmp_name'];
                $newFileName = $uploadDirectory . basename($_FILES['balanceN1']['name']);
                move_uploaded_file($tempName, $newFileName);
                //  echo 'File "balanceN1" has been uploaded successfully.<br>';
                // Read the Excel file
                $excelFile = $newFileName ; // Replace with the correct path
                $spreadsheet = IOFactory::load($excelFile);
                $worksheet = $spreadsheet->getActiveSheet();
                $data = $worksheet->toArray();
                // Write the data to a PHP file
                $phpFileContent = '<?php' . PHP_EOL;
                $phpFileContent .= '$data = ' . var_export($data, true) . ';' . PHP_EOL;
                $phpFileContent .= '?>';
                file_put_contents($newFileExcel.'balanceN1-'.$annee.'.php', $phpFileContent);
            }
            // Handle file upload for $balanceN2 (if it exists and is not empty)
            if (!empty($_FILES['balanceN2']) && $_FILES['balanceN2']['error'] === UPLOAD_ERR_OK) {
                $tempName = $_FILES['balanceN2']['tmp_name'];
                $newFileName = $uploadDirectory . basename($_FILES['balanceN2']['name']);
                move_uploaded_file($tempName, $newFileName);
                //    echo 'File "balanceN2" has been uploaded successfully.<br>';
                // Read the Excel file
                $excelFile = $newFileName ; // Replace with the correct path
                $spreadsheet = IOFactory::load($excelFile);
                $worksheet = $spreadsheet->getActiveSheet();
                $data = $worksheet->toArray();
                // Write the data to a PHP file
                $phpFileContent = '<?php' . PHP_EOL;
                $phpFileContent .= '$data = ' . var_export($data, true) . ';' . PHP_EOL;
                $phpFileContent .= '?>';
                file_put_contents($newFileExcel.'balanceN2-'.$annee.'.php', $phpFileContent);
            }
            $data = "<?php ";
            $data .= '$annee = "' . $annee. "\";\n";
            $data .= '$typeAnnee = "' . $typeAnnee. "\";\n";
            $data .= '$anneeDu = "' . $anneeDu. "\";\n";
            $data .= '$anneeAu = "' . $anneeAu. "\";\n";
            $data .= '$balanceN = "' . $_FILES['balanceN']['name']. "\";\n";
            $data .= '$balanceN1 = "' . $_FILES['balanceN1']['name']. "\";\n";
            $data .= '$balanceN2 = "' . $_FILES['balanceN2']['name']. "\";\n";
            $data .= "?>";
            // Now, the variable $year will contain the year value "2023"
            // Écrire les données dans le nouveau fichier
            file_put_contents($nomFichier, $data);
            // The file was successfully added
            echo '<label>
                <input type="checkbox" class="alertCheckbox" autocomplete="off" />
                <div class="alert success">
                <span class="alertClose">X</span>
                <span class="alertText">Les informations ont été ajoutées avec succès<br class="clear"/></span>
                </div>
            </label>';
        } else {
         $pageList = DOL_URL_ROOT.'\custom\etatscomptables\declarationLaisseExl\infoBalance\Liste.php';
        // Handle the case where the file was not added
        echo '<label>
            <input type="checkbox" class="alertCheckbox" autocomplete="off" />
            <div class="alert error">
            <span class="alertClose">X</span>
            <span class="alertText">Échec de l\'ajout des informations car elles existent déjà pour cette année. Pour les modifier, veuillez vous rendre sur la page de liste <a href="'.$pageList.'">click ici</a><br class="clear"/></span>
            </div>
        </label>';
    }   
  }
?>
 
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/style.css"/>
<body >
    <div class="page-content">
    <div class="form-v10-content">
    <form class="form-detail" action="<?php $_SERVER['PHP_SELF']  ?>"  method="post"  enctype="multipart/form-data">
        <input type="hidden" name="token" value="<?php newToken() ?> ">
        <div class="form-right">
        <h2>Période de la déclaration et Fiche Balance</h2>
        <div class="form-group">
            <div class="form-row form-row-1">
                <select name="annee" required>
                    <?php
                    for ($i = date('Y'); $i >= (date('Y') - 5); $i--) {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-row form-row-2">
                <select name="typeAnnee" required id="typeAnneeSelect">
                    <option value="">Type d'exercice comptable</option>
                    <option value="position">Exercices à cheval</option>
                    <option value="director">Exercices 2</option>
                    <option value="Exercices3">Exercices 3</option>
                </select>
            </div>
        </div>
        <div id="dateFields" style="display: none;">
            <div class="form-group">
                <div class="form-row form-row-1">
                    <p style="color: #fff">Du</p>
                    <input type="text" name="anneeDu" id="anneeDu" class="input-text" required>
                </div>
                <div class="form-row form-row-2">
                    <p style="color: #fff">Au</p>
                    <input type="text" name="anneeAu" id="anneeAu" class="input-text" required>
                </div>
            </div>
        </div>
        <script>
            document.getElementById("typeAnneeSelect").addEventListener("change", function () {
                var typeAnnee = this.value;
                var annee = document.querySelector("select[name='annee']").value;
                var anneeDu, anneeAu,affiche;
                if (typeAnnee === "position") {
                    anneeDu = '01/01/' + annee;
                    anneeAu = '31/12/' + annee;    
                } else if (typeAnnee === "director") {
                    anneeDu = '01/04/' + annee;
                    anneeAu = '31/03/' + (parseInt(annee) + 1);
                }else if (typeAnnee === "Exercices3"){
                    affiche=1;
                }
                if (anneeDu && anneeAu ) {
                    document.getElementById("anneeDu").value = anneeDu;
                    document.getElementById("anneeAu").value = anneeAu;
                    document.getElementById("anneeDu").readOnly = true;
                     document.getElementById("anneeAu").readOnly = true;
                    document.getElementById("dateFields").style.display = "block";
                }else if(affiche){
                    anneeDu = '01/04/' + annee;
                    anneeAu = '31/03/' + (parseInt(annee) + 1);
                    document.getElementById("anneeDu").value = anneeDu;
                    document.getElementById("anneeAu").value = anneeAu;
                    document.getElementById("anneeDu").readOnly = false;
                     document.getElementById("anneeAu").readOnly = false;

                    document.getElementById("dateFields").style.display = "block";
                }
                else {
                    document.getElementById("dateFields").style.display = "none";
                }
            });
        </script>
        <div class="form-row">
            <p style='color:#fff'> Balance N</p>
            <input type="file" name="balanceN" class="adresse" id="balanceN" placeholder="balanceN" required>
        </div>
        <div class="form-row">
            <p style='color:#fff'> Balance N-1</p>
            <input type="file" name="balanceN1" class="adresse" id="balanceN1" placeholder="balanceN1" required>
        </div>
        <div class="form-row">
            <p style='color:#fff'> Balance N-2</p>
            <input type="file" name="balanceN2" class="adresse" id="balanceN2" placeholder="balanceN2" >
        </div>
        <div class="form-row-last">
           <input type="submit" name="register" class="register" value="Save">
        </div>
        </div>
    </form>
    </div>
    </div>

   
</body>
</html>