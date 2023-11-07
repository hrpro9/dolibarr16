<?php
  // Load Dolibarr environment
  require_once '../../main.inc.php';
  require_once '../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
  use PhpOffice\PhpSpreadsheet\IOFactory;

   $action = GETPOST('action');
   if ($action != 'generate')
    llxHeader("", "");

    echo DOL_DOCUMENT_ROOT;
    exit;

    $typeInfo='affiche';

  
    if(isset($_POST['date_select']))
    {
        $date_select=$_POST['date_select'];
        $typeInfo=$_POST['typeInfo']??"affiche";


        $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/declarationLaisseExl/infoBalance/infoBalance_'.$date_select.'.php';
        if (file_exists($filename)) {
            include $filename;
            $textInfo=($typeInfo=="modifier")?"Modifier":"";
            echo '<label>
                <div class="alert success">
                <span class="alertClose"></span>
                <span class="alertText">'.$textInfo.' Les informations cette année : '.$date_select.'<br class="clear"/></span>
                </div>
            </label>';
        }else{
           // Handle the case where the file was not added
           echo '<label>
            <div class="alert error">
            <span class="alertClose"></span>
            <span class="alertText">Échec Aucun cette année<br class="clear"/></span>
            </div>
           </label>';
        }
    } else if(isset($_POST['SaveModifier']))
    {
        $annee=$_POST['annee'];
        $typeAnnee=$_POST['typeAnnee'];
        $anneeDu=$_POST['anneeDu'];
        $anneeAu=$_POST['anneeAu'];
        $infobalanceN=$_POST['infobalanceN'];
        $infobalanceN1=$_POST['infobalanceN1'];
        $infobalanceN2=$_POST['infobalanceN2'];
        $balanceN=($_FILES['balanceN']['name'])?$_FILES['balanceN']['name']:$infobalanceN;
        $balanceN1=($_FILES['balanceN1']['name'])?$_FILES['balanceN1']['name']:$infobalanceN1;
        $balanceN2=($_FILES['balanceN2']['name'])?$_FILES['balanceN2']['name']:$infobalanceN2;
        
        $uploadDirectory = './uploads/';  // The directory where you want to upload the files
        $newFileExcel='./balance/';



        function GenerateExcel($annee,$balanceName){
            $uploadDirectory = './uploads/';  // The directory where you want to upload the files
            $newFileExcel='./balance/';
                // Handle file upload for $balanceN
            if (isset($_FILES[$balanceName]) && $_FILES[$balanceName]['error'] === UPLOAD_ERR_OK) {
                $tempName = $_FILES[$balanceName]['tmp_name'];
                $newFileName = $uploadDirectory . basename($_FILES[$balanceName]['name']);
                move_uploaded_file($tempName, $newFileName);
                //   echo 'File "balanceN" has been uploaded successfully.<br>';
                // Read the Excel file
                $excelFile = $newFileName ; // Replace with the correct path
                $spreadsheet = IOFactory::load($excelFile);
                $worksheet = $spreadsheet->getActiveSheet();
                $data = $worksheet->toArray();
                // Write the data to a PHP file
                $phpFileContent = '<?php' . PHP_EOL;
                $phpFileContent .= '$data'.$balanceName.' = ' . var_export($data, true) . ';' . PHP_EOL;
                $phpFileContent .= '?>';
                file_put_contents($newFileExcel.$balanceName.'-'.$annee.'.php', $phpFileContent);
            }
        }
        GenerateExcel($annee,'balanceN');
        GenerateExcel($annee,'balanceN1');
        GenerateExcel($annee,'balanceN2');
        $data = "<?php ";
        $data .= '$annee = "' . $annee. "\";\n";
        $data .= '$typeAnnee = "' . $typeAnnee. "\";\n";
        $data .= '$anneeDu = "' . $anneeDu. "\";\n";
        $data .= '$anneeAu = "' . $anneeAu. "\";\n";
        $data .= '$balanceN = "' . $balanceN. "\";\n";
        $data .= '$balanceN1 = "' . $balanceN1. "\";\n";
        $data .= '$balanceN2 = "' . $balanceN2. "\";\n";
        $data .= "?>";
        $nomFichier = 'infoBalance_'. $annee.'.php';
        file_put_contents($nomFichier, $data);
        $checkFile= DOL_DOCUMENT_ROOT.'/custom/etatscomptables/declarationLaisseExl/infoBalance/'.$nomFichier;
        if (file_exists($checkFile)) {  
            include $checkFile;
            // Écrire les données dans le nouveau fichier
            $typeInfo="affiche";
            echo '<label>
                <div class="alert success">
                <span class="alertClose"></span>
                <span class="alertText"> Les informations cette année : '.$annee.'<br class="clear"/></span>
                </div>
            </label>';
        }
        
    }else{
        $date_now= date('Y')-1;
        $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/declarationLaisseExl/infoBalance/infoBalance_'.$date_now.'.php';
        if (file_exists($filename)) {
            include $filename;
            $typeInfo="affiche";
            echo '<label>
                <div class="alert success">
                <span class="alertClose"></span>
                <span class="alertText">Les informations cette année : '.$date_now.'<br class="clear"/></span>
                </div>
            </label>';
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/styleTable.css">
</head>
<body>
    <!-- <p>Sort Table Rows by Clicking on the Table Headers - Ascending and Descending (jQuery)</p> -->
    <div class="container">
       <center>
            <form method="POST" >
                <select name="date_select" required>
                    <option value="">Choisis date</option>
                        <?php
                            for ($i = date('Y'); $i >= (date('Y') - 5); $i--) {
                                echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                        ?>
                </select>
                <select name="typeInfo" id="" required>
                    <option value="">choisir un action</option>
                    <option value="affiche">affiche</option>
                    <option value="modifier">Modifier</option>
                    <!-- <option value="delete">delete</option> -->
                </select>
                <button type="submit" name="chargement" 
                style="margin: 18px 0px;background: rgb(38,60,92);padding: 8px 15px 8px 15px;border: none;color: #fff;">Chargement</button><br>  
            </form>
       </center>

        <form action="<?php $_SERVER['PHP_SELF'] ?>"  method="post"  enctype="multipart/form-data">
            <h1 style="color: #666;font-size: 25px;text-align:center;margin:20px 0px">Période de la déclaration et Fiche Balance</h1>     
            <div class="table">
                <div class="table-header">
                    <div class="header__item"><a id="name" class="filter__link" href="#">Type d'exercice comptable</a></div>
                    <div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">annee</a></div>
                    <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">annee Du</a></div>
                    <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">annee Au</a></div>
                    <div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">balanceN</a></div>
                    <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">balanceN1</a></div>
                    <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">balanceN2</a></div>
                </div>
                <div class="table-content">
                    <?php
                        if($typeInfo=="affiche")
                        {
                            echo '
                                <div class="table-row">
                                    <div class="table-data">'.$typeAnnee.'</div>
                                    <div class="table-data">'.$annee.'</div>
                                    <div class="table-data">'.$anneeDu.'</div>
                                    <div class="table-data">'.$anneeAu.'</div>
                                    <div class="table-data"><a href="./uploads/'.$balanceN.'" download="'.$balanceN.'" style="color:blue;">'.$balanceN.'</a></div>
                                    <div class="table-data"><a href="./uploads/'.$balanceN1.'" download="'.$balanceN1.'" style="color:blue;">'.$balanceN1.'</a></div>
                                    <div class="table-data"><a href="./uploads/'.$balanceN2.'" download="'.$balanceN2.'" style="color:blue;">'.$balanceN2.'</a></div>
                                </div> 
                            ';
                        }else if($typeInfo=="modifier"){
                            echo '<div class="table-row">
                                <div class="table-data"><input type="text" name="typeAnnee" value="'.$typeAnnee.'" style="width: 90px;" /></div>
                                <div class="table-data"><input type="text" name="annee" value="'.$annee.'" style="width: 90px;"/></div>
                                <div class="table-data"><input type="text" name="anneeDu" value="'.$anneeDu.'" style="width: 90px;"/></div>
                                <div class="table-data"><input type="text" name="anneeAu" value="'.$anneeAu.'" style="width: 90px;"/></div>
                                <div class="table-data"><input type="file" name="balanceN"  style="width: 90px;"/></div>
                                <div class="table-data"><input type="file" name="balanceN1"  style="width: 90px;"/></div>
                                <div class="table-data"><input type="file" name="balanceN2"  style="width: 90px;"/></div>
                                <input type="hidden" name="infobalanceN" value="'.$balanceN.'" style="width: 90px;"/>
                               <input type="hidden" name="infobalanceN1" value="'.$balanceN1.'" style="width: 90px;"/>
                               <input type="hidden" name="infobalanceN2" value="'.$balanceN2.'" style="width: 90px;"/>
                            </div> ';
                        }
                    ?>
                </div>
            </div>
            <?php
                if($typeInfo=="modifier")
                {
                    echo '
                      <center>
                        <button type="submit" name="SaveModifier" 
                        style="margin-top: 18px;background: rgb(38,60,92);padding: 8px 15px 8px 15px;border: none;color: #fff;">Save</button><br>
                      </center>   
                    ';
                }
            ?>
        </form>
    </div>
</body>
</html>