<?php


    // Load Dolibarr environment
    require '../../../main.inc.php';
    require_once '../../../vendor/autoload.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
    llxHeader("", "");

    if(isset($_POST['register'])){
        $typeERP=$_POST['typeErp'];
        $nameDB=$_POST['nameDB'];
        $IPAdress=$_POST['IPAdress'];
        $login=$_POST['login'];
        $password=$_POST['password'];

       

        $configFilePath = 'config/configDB.php';
        
        // Check if the config file already exists
        if (!file_exists($configFilePath)) {
            // Database configuration constants
            $data = "<?php\n\n";
            $data .= "// Database configuration constants\n";
            $data .= "define('ERP_TYPE', '" . $typeERP . "');\n";
            $data .= "define('DB_NAME', '" . $nameDB . "');\n";
            $data .= "define('DB_IP', '" . $IPAdress . "');\n";
            $data .= "define('DB_LOGIN', '" . $login . "');\n";
            $data .= "define('DB_PASSWORD', '" . $password . "');\n\n";
            $data .= "?>";
        
            // Write the data to the new file
            file_put_contents($configFilePath, $data);
        
            echo '<label>
                <input type="checkbox" class="alertCheckbox" autocomplete="off" />
                <div class="alert success">
                    <span class="alertClose">X</span>
                    <span class="alertText">Les informations ont été ajoutées avec succès<br class="clear"/></span>
                </div>
            </label>';
        }
        

        else{
            $pageList = DOL_URL_ROOT.'\custom\DelaisPaiement\InfoDB\ListeInfoDB.php';
            // Handle the case where the file was not added
            echo '<label>
                <input type="checkbox" class="alertCheckbox" autocomplete="off" />
                <div class="alert error">
                <span class="alertClose">X</span>
                <span class="alertText">Échec de l\'ajout des informations car elles existent déjà . Pour les modifier, veuillez vous rendre sur la page de liste <a href="'.$pageList.'">click ici</a><br class="clear"/></span>
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
    <form class="form-detail" action="<?php $_SERVER['PHP_SELF']  ?>"  method="post" >
        <input type="hidden" name="token" value="<?php newToken() ?> ">
        <div class="form-left">
        <h2>Infomation database </h2>


        <div class="form-row ">
            <select name="typeErp" required id="typeErp">
                <option value="">Type Erp</option>
                <option value="Erp1">Erp 1 </option>
                <option value="Erp2">Erp 2</option>
                <option value="Erp3">Erp 3</option>
            </select>
        </div>

        <div class="form-group">
            <div class="form-row form-row-1">
             <input type="text" name="nameDB" id="nameDB" class="input-text" placeholder="Name DB" required>
            </div>
            <div class="form-row form-row-2">
             <input type="text" name="IPAdress" class="adresse" id="IPAdress" placeholder="IP Adress" required>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row form-row-1">
             <input type="text" name="login" id="login" class="input-text" placeholder="Login" required>
            </div>
            <div class="form-row form-row-2">
             <input type="text" name="password" class="adresse" id="password" placeholder="Password" required>
            </div>
        </div>
        <center>
            <button type="submit" name="register" 
                style="margin-top: 18px;background: rgb(38,60,92);padding: 8px 15px 8px 15px;border: none;color: #fff;">Register</button><br> <br>
        </center>
        

        </div>

       
    </form>
    </div>
    </div>
</body>
</html>