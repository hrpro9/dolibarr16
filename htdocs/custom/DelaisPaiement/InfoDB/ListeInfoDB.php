<?php
  // Load Dolibarr environment
  require_once '../../../main.inc.php';
  require_once '../../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
 

   $action = GETPOST('action');
   if ($action != 'generate')
    llxHeader("", "");

  
    if(isset($_POST['chargement']))
    {
        $typeInfo=$_POST['typeInfo']??"affiche";
        $filename = DOL_DOCUMENT_ROOT . '/custom/DelaisPaiement/InfoDB/config/configDB.php';
        if (file_exists($filename)) {
            include $filename;
            $textInfo=($typeInfo=="modifier")?"Modifier":"";
            echo '<label>
                <div class="alert success">
                <span class="alertClose"></span>
                <span class="alertText">'.$textInfo.' Les informations DB<br class="clear"/></span>
                </div>
            </label>';
        }else{
           // Handle the case where the file was not added
           echo '<label>
            <div class="alert error">
            <span class="alertClose"></span>
            <span class="alertText">Échec Aucun informations<br class="clear"/></span>
            </div>
           </label>';
        }
    } else if(isset($_POST['SaveModifier']))
    {
        $typeERP=(!empty($_POST['typeErp']))?$_POST['typeErp']:$_POST['typeErpCheck'];
        $nameDB=$_POST['nameDB'];
        $IPAdress=$_POST['IPAdress'];
        $login=$_POST['login'];
        $password=$_POST['password'];

       // Database configuration constants
       $data = "<?php\n\n";
       $data .= "// Database configuration constants\n";
       $data .= "define('ERP_TYPE', '" . $typeERP . "');\n";
       $data .= "define('DB_NAME', '" . $nameDB . "');\n";
       $data .= "define('DB_IP', '" . $IPAdress . "');\n";
       $data .= "define('DB_LOGIN', '" . $login . "');\n";
       $data .= "define('DB_PASSWORD', '" . $password . "');\n\n";
       $data .= "?>";

        $nomFichier="config/configDB.php";
        file_put_contents($nomFichier, $data);
        $checkFile = DOL_DOCUMENT_ROOT . '/custom/DelaisPaiement/InfoDB/'.$nomFichier;
        if (file_exists($checkFile)) {  
            include $checkFile;
            // Écrire les données dans le nouveau fichier
            $typeInfo="affiche";
            echo '<label>
                <div class="alert success">
                <span class="alertClose"></span>
                <span class="alertText"> Les informations DB <br class="clear"/></span>
                </div>
            </label>';
        }
    }else{
        $filename = DOL_DOCUMENT_ROOT . '/custom/DelaisPaiement/InfoDB/config/configDB.php';
        if (file_exists($filename)) {
            include $filename;
            $typeInfo="affiche";
            echo '<label>
                <div class="alert success">
                <span class="alertClose"></span>
                <span class="alertText">Les informations DB <br class="clear"/></span>
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

       <form action="<?php $_SERVER['PHP_SELF']  ?>"  method="post"  enctype="multipart/form-data">
            <div class="table">
                <div class="table-header">
                    <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">type Erp</a></div>
                    <div class="header__item"><a id="name" class="filter__link" href="#">Name DB</a></div>
                    <div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">IP Adress</a></div>
                    <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">Login</a></div>
                    <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">Password</a></div>
                </div>
                <div class="table-content">
                    <?php
                        if($typeInfo=="affiche")
                        {
                            echo '
                                <div class="table-row">
                                    <div class="table-data">'.ERP_TYPE.'</div>
                                    <div class="table-data">'.DB_NAME.'</div>
                                    <div class="table-data">'.DB_IP.'</div>
                                    <div class="table-data">'.DB_LOGIN.'</div>
                                    <div class="table-data">'.DB_PASSWORD.'</div>
                                </div> 
                            ';
                        }else if($typeInfo=="modifier"){
                            echo '<div class="table-row">
                                <div class="table-data">
                                    <select name="typeErp"  id="typeErp">
                                        <option value="">Type Erp</option> 
                                        <option value="Erp1">Erp 1 </option>
                                        <option value="Erp2">Erp 2</option>
                                        <option value="Erp3">Erp 3</option>
                                    </select>
                                  
                                </div>
                                <input type="hidden" name="typeErpCheck" value="'.ERP_TYPE.'" style="width: 130px;"/>
                                <div class="table-data"><input type="text" name="nameDB" value="'.DB_NAME.'" style="width: 130px;"/></div>
                                <div class="table-data"><input type="text" name="IPAdress" value="'.DB_IP.'" style="width: 130px;"/></div>
                                <div class="table-data"><input type="text" name="login" value="'.DB_LOGIN.'" style="width: 130px;"/></div>
                                <div class="table-data"><input type="text" name="password" value="'.DB_PASSWORD.'" style="width: 130px;"/></div>
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