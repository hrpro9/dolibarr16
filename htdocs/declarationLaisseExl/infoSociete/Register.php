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

        $nomFichier = 'InfomationSociete.php';
        $checkFile= DOL_DOCUMENT_ROOT.'/custom/etatscomptables/declarationLaisseExl/infoSociete/'.$nomFichier;
        if (!file_exists($checkFile)) {
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
        $pageList = DOL_URL_ROOT.'\custom\etatscomptables\declarationLaisseExl\infoSociete\liste.php';
        // Handle the case where the file was not added
        echo '<label>
            <input type="checkbox" class="alertCheckbox" autocomplete="off" />
            <div class="alert error">
            <span class="alertClose">X</span>
            <span class="alertText">Échec de l\'ajout des informations car elles existent déjà . Pour les modifier, veuillez vous rendre sur la page de liste Société <a href="'.$pageList.'">click ici</a><br class="clear"/></span>
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