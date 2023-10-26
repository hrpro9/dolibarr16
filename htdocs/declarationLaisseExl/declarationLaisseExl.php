<?php
  // Load Dolibarr environment
  require_once '../../../main.inc.php';
  require_once '../../../vendor/autoload.php';
  use PhpOffice\PhpSpreadsheet\IOFactory;
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';

   $action = GETPOST('action');
   if ($action != 'generate')
    llxHeader("", "");
  
  if(isset($_POST['register']))
  {
        $nom_societe=$_POST['nom_societe'];
        $ifSoc=$_POST['ifSoc'];
        $ice=$_POST['ice'];
        $rc=$_POST['rc'];
        $cnss=$_POST['cnss'];
        $tp=$_POST['tp'];
        $telephone=$_POST['telephone'];
        $fax=$_POST['fax'];
        $email=$_POST['email'];
        $adresse=$_POST['adresse'];
        $ville=$_POST['ville'];
        $dateActivite=$_POST['dateActivite'];
        $annee=$_POST['annee'];
        $typeAnnee=$_POST['typeAnnee'];
        $anneeDu=$_POST['anneeDu'];
        $anneeAu=$_POST['anneeAu'];

        $nomFichier = 'infoSociete/InfomationSociete_'. $annee.'.php';
        $checkFile= DOL_DOCUMENT_ROOT.'/custom/etatscomptables/declarationLaisseExl/'.$nomFichier;
        if (!file_exists($checkFile)) {
            $uploadDirectory = './uploads/';  // The directory where you want to upload the files
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
                file_put_contents('balanceN-'.$annee.'.php', $phpFileContent);
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
                file_put_contents('balanceN1-'.$annee.'.php', $phpFileContent);
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
                file_put_contents('balanceN2-'.$annee.'.php', $phpFileContent);
            }
            $data = "<?php ";
            $data .= '$nom_societe = "' . $nom_societe. "\";\n";
            $data .= '$ifSoc = "' . $ifSoc. "\";\n";
            $data .= '$ice = "' . $ice. "\";\n";
            $data .= '$rc = "' . $rc. "\";\n";
            $data .= '$cnss = "' . $cnss. "\";\n";
            $data .= '$tp = "' . $tp. "\";\n";
            $data .= '$telephone = "' . $telephone. "\";\n";
            $data .= '$fax = "' . $fax. "\";\n";
            $data .= '$email = "' . $email. "\";\n";
            $data .= '$adresse = "' . $adresse. "\";\n";
            $data .= '$ville = "' . $ville. "\";\n";
            $data .= '$dateActivite = "' . $dateActivite. "\";\n";
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
        $pageList = DOL_URL_ROOT.'\custom\etatscomptables\declarationLaisseExl\tableInfo.php';
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
<!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" type="text/css" href="css/montserrat-font.css">
<link rel="stylesheet" type="text/css" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css"> -->
<link rel="stylesheet" href="css/style.css"/>
<meta name="robots" content="noindex, follow">
<script nonce="82697c45-52d6-48ba-bd29-849c9953d491">(function(w,d){!function(du,dv,dw,dx){du[dw]=du[dw]||{};du[dw].executed=[];du.zaraz={deferred:[],listeners:[]};du.zaraz.q=[];du.zaraz._f=function(dy){return async function(){var dz=Array.prototype.slice.call(arguments);du.zaraz.q.push({m:dy,a:dz})}};for(const dA of["track","set","debug"])du.zaraz[dA]=du.zaraz._f(dA);du.zaraz.init=()=>{var dB=dv.getElementsByTagName(dx)[0],dC=dv.createElement(dx),dD=dv.getElementsByTagName("title")[0];dD&&(du[dw].t=dv.getElementsByTagName("title")[0].text);du[dw].x=Math.random();du[dw].w=du.screen.width;du[dw].h=du.screen.height;du[dw].j=du.innerHeight;du[dw].e=du.innerWidth;du[dw].l=du.location.href;du[dw].r=dv.referrer;du[dw].k=du.screen.colorDepth;du[dw].n=dv.characterSet;du[dw].o=(new Date).getTimezoneOffset();if(du.dataLayer)for(const dH of Object.entries(Object.entries(dataLayer).reduce(((dI,dJ)=>({...dI[1],...dJ[1]})),{})))zaraz.set(dH[0],dH[1],{scope:"page"});du[dw].q=[];for(;du.zaraz.q.length;){const dK=du.zaraz.q.shift();du[dw].q.push(dK)}dC.defer=!0;for(const dL of[localStorage,sessionStorage])Object.keys(dL||{}).filter((dN=>dN.startsWith("_zaraz_"))).forEach((dM=>{try{du[dw]["z_"+dM.slice(7)]=JSON.parse(dL.getItem(dM))}catch{du[dw]["z_"+dM.slice(7)]=dL.getItem(dM)}}));dC.referrerPolicy="origin";dC.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(du[dw])));dB.parentNode.insertBefore(dC,dB)};["complete","interactive"].includes(dv.readyState)?zaraz.init():du.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script></head>
<body >
    <div class="page-content">
    <div class="form-v10-content">
    <form class="form-detail" action="<?php $_SERVER['PHP_SELF']  ?>"  method="post"  enctype="multipart/form-data">
        <input type="hidden" name="token" value="<?php newToken() ?> ">
        <div class="form-left">
        <h2>Infomation Société </h2>
        <div class="form-row">
        <input type="text" name="nom_societe" id="nom_societe" class="input-text" placeholder="Nom Société" required>
       
        <span class="select-btn">
        <i class="zmdi zmdi-chevron-down"></i>
        </span>
        </div>
        <div class="form-group">
            <div class="form-row form-row-1">
              <input type="text" name="ifSoc" id="ifSoc" class="input-text" placeholder="IF" required>
            </div>
            <div class="form-row form-row-2">
              <input type="text" name="ice" id="ice" class="input-text" placeholder="ICE" required>
            </div>
            <div class="form-row form-row-2">
              <input type="text" name="rc" id="rc" class="input-text" placeholder="RC" required>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row form-row-1">
              <input type="text" name="cnss" id="cnss" class="input-text" placeholder="CNSS" required>
            </div>
            <div class="form-row form-row-2">
              <input type="text" name="tp" id="tp" class="input-text" placeholder="TP" required>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row form-row-1">
             <input type="text" name="telephone" id="telephone" class="input-text" placeholder="Téléphone" required>
            </div>
            <div class="form-row form-row-2">
             <input type="text" name="fax" id="fax" class="input-text" placeholder="Fax" required>
            </div>
        </div>
        <div class="form-row">
         <input type="email" name="email" class="adresse" id="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <div class="form-row form-row-1">
            <input type="text" name="ville" id="ville" class="input-text" placeholder="Ville" required>
            </div>
            <div class="form-row form-row-2">
            <input type="text" name="adresse" class="adresse" id="company" placeholder="Adresse" required>
            </div>
        </div>
        <div class="form-row">
        <p style="color: #666;font-size: 16px;"> Date début Activité</p>
         <input type="date" name="dateActivite" id="dateActivite" class="input-text" placeholder="Date début Activité" required>
        </div>
        
        </div>
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

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"81b2d9d7fb801a7f","version":"2023.10.0","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
</body>
</html>