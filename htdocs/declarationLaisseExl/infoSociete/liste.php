<?php
  // Load Dolibarr environment
  require_once '../../../../main.inc.php';
  require_once '../../../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
 

   $action = GETPOST('action');
   if ($action != 'generate')
    llxHeader("", "");

  
    if(isset($_POST['chargement']) )
    {
        $typeInfo=$_POST['typeInfo']??"affiche";


        $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/declarationLaisseExl/infoSociete/InfomationSociete.php';
        if (file_exists($filename)) {
            include $filename;
            $textInfo=($typeInfo=="modifier")?"Modifier":"";
            echo '<label>
                <div class="alert success">
                <span class="alertClose"></span>
                <span class="alertText">'.$textInfo.' Les informations Societe<br class="clear"/></span>
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
        $data .= "?>";
        $nomFichier = 'InfomationSociete.php';
        file_put_contents($nomFichier, $data);
        $checkFile= DOL_DOCUMENT_ROOT.'/custom/etatscomptables/declarationLaisseExl/infoSociete/'.$nomFichier;
        if (file_exists($checkFile)) {  
            include $checkFile;
            // Écrire les données dans le nouveau fichier
            $typeInfo="affiche";
            echo '<label>
                <div class="alert success">
                <span class="alertClose"></span>
                <span class="alertText"> Les informations Socite <br class="clear"/></span>
                </div>
            </label>';
        }
        
    }else{
        $filename = DOL_DOCUMENT_ROOT . '/custom/etatscomptables/declarationLaisseExl/infoSociete/InfomationSociete.php';
        if (file_exists($filename)) {
            include $filename;
            $typeInfo="affiche";
            echo '<label>
                <div class="alert success">
                <span class="alertClose"></span>
                <span class="alertText">Les informations Societe <br class="clear"/></span>
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
            <!-- <h1 style="color: #666;font-size: 25px;text-align:center;margin:20px 0px">Infomation Société</h1> -->
            <div class="table">
                <div class="table-header">
                    <div class="header__item"><a id="name" class="filter__link" href="#">Nom Société</a></div>
                    <div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">IF</a></div>
                    <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">ICE</a></div>
                    <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">RC</a></div>
                    <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">CNSS</a></div>
                    <div class="header__item"><a id="name" class="filter__link" href="#">TP</a></div>
                    <div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">Téléphone</a></div>
                    <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">Fax</a></div>
                    <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">Email</a></div>
                    <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">Ville</a></div>
                    <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">Adresse</a></div>
                    <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">Date début Activité</a></div>
                    
                </div>
                <div class="table-content">
                    <?php
                    if($typeInfo=="affiche")
                    {
                        echo '
                            <div class="table-row">
                                <div class="table-data">'.$nom_societe.'</div>
                                <div class="table-data">'.$ifSoc.'</div>
                                <div class="table-data">'.$ice.'</div>
                                <div class="table-data">'.$rc.'</div>
                                <div class="table-data">'.$cnss.'</div>
                                <div class="table-data">'.$tp.'</div>
                                <div class="table-data">'.$telephone.'</div>
                                <div class="table-data">'.$fax .'</div>
                                <div class="table-data">'.$email.'</div>
                                <div class="table-data">'.$ville.'</div>
                                <div class="table-data">'.$adresse.'</div>
                                <div class="table-data">'.$dateActivite.'</div>
                            </div> 
                        ';
                    }else if($typeInfo=="modifier"){
                        echo '<div class="table-row">
                            <div class="table-data"><input type="text" name="nom_societe" value="'.$nom_societe.'" style="width: 90px;" /></div>
                            <div class="table-data"><input type="text" name="ifSoc" value="'.$ifSoc.'" style="width: 90px;"/></div>
                            <div class="table-data"><input type="text" name="ice" value="'.$ice.'" style="width: 90px;"/></div>
                            <div class="table-data"><input type="text" name="rc" value="'.$rc.'" style="width: 90px;"/></div>
                            <div class="table-data"><input type="text" name="cnss" value="'.$cnss.'" style="width: 90px;"/></div>
                            <div class="table-data"><input type="text" name="tp" value="'.$tp.'" style="width: 90px;"/></div>
                            <div class="table-data"><input type="text" name="telephone" value="'.$telephone.'" style="width: 90px;"/></div>
                            <div class="table-data"><input type="text" name="fax" value="'.$fax.'" style="width: 90px;"/></div>
                            <div class="table-data"><input type="text" name="email" value="'.$email.'" style="width: 90px;"/></div>
                            <div class="table-data"><input type="text" name="ville" value="'.$ville.'" style="width: 90px;"/></div>
                            <div class="table-data"><input type="text" name="adresse" value="'.$adresse.'" style="width: 90px;"/></div>
                            <div class="table-data"><input type="text" name="dateActivite" value="'.$dateActivite.'" style="width: 90px;"/></div>
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