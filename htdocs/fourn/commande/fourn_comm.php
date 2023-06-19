<?php
require_once '../../main.inc.php';
require_once '../../vendor/autoload.php';






llxHeader("", "");

?>
<!DOCTYPE html>
<html>
<head>
<style>
#table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#table td, #table th {
  border: 1px solid #ddd;
  padding: 8px;
}


#table tr:hover {background-color: #ddd;}

#table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: rgb(38,60,92);
  color: white;
}

.alert {
  padding: 20px;
  background-color: #d51000;
  color: white;
  border-radius: 8px;
}
.succes{

  padding: 20px;
  background-color: #40a52a;
  color: white;
  border-radius: 8px;
  

}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}

</style>
</head>
<h1>Commande Fournisseur</h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <center>
   <br>
   <select name="select" style="margin-top: 18px;font-size:95%; background: #eeeeee; font-weight:bold; padding: 8px 15px 8px 15px; border: block;">
        <option>Sélectionnez un fournisseur</option>
        <?php
        $sql = 'SELECT rowid, nom, name_alias FROM llx_societe where fournisseur=1';
        $rest = $db->query($sql);
        
        foreach ($rest as $row) {
            echo '<option value="' . $row['rowid'] . '">' . strtoupper($row['nom']) . ' ' . strtoupper($row['name_alias']) . '</option>';
        }
     
        ?>
    </select>
    <input type="submit" name="submit" value="Afficher les commandes" style="margin-top: 18px; background: #4B99AD; padding: 8px 15px 8px 15px; border: block; color: #fff;">
   </center> 
     
</form>
<br>



    <?php

require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formorder.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formmargin.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/modules/commande/modules_commande.php';
require_once DOL_DOCUMENT_ROOT . '/commande/class/commande.class.php';
require_once DOL_DOCUMENT_ROOT . '/comm/action/class/actioncomm.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/order.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/extrafields.class.php';


    if (isset($_POST['submit'])) {
        $id = $_POST['select'];
      // Utilisez $_POST['select'] pour obtenir la valeur sélectionnée
        $sql = "SELECT rowid, ref, lieuLivraison  FROM llx_commande_fournisseur WHERE fk_soc = $id AND fk_statut = 5";
        $rest = $db->query($sql);
        print'<table id="table">
                <tr>
                <th>Commande</th>
                </tr>';
        foreach ($rest as $row) {
          
            echo '<tr>';
            echo '<td>';
            echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
            echo '<input type="hidden" name="commande" value="' . $row['ref'] . '">';
            echo '<input type="hidden" name="valeur" value="' . $id . '">';
            echo '<input type="hidden" name="valeurC" value="' . $row['rowid'] . '">';
            echo '<input type="hidden" name="entrepot" value="' . $row['lieuLivraison'] . '">';  
            echo '<input type="submit" name="commandeC" value="' . $row['ref'] . '" style="border: none";>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
            
        }
        echo '</table>';
    }

if (isset($_POST['commandeC'])) {
    $ref = $_POST['commande'];
    $valeur = $_POST['valeur'];
    $idC = $_POST['valeurC'];
    $entrepot = $_POST['entrepot'];
    
    $sql = "SELECT rowid, nom, name_alias FROM llx_societe WHERE rowid = $valeur";
    $rest = $db->query($sql);
    $param = $rest->fetch_assoc();

    $sql2 = "SELECT fk_commande, qty, fk_product,fk_entrepot ,cost_price FROM llx_commande_fournisseur_dispatch WHERE fk_commande = $idC";
    $restC = $db->query($sql2);

    
    // Utilisez $_POST['select'] pour obtenir la valeur sélectionnée
      $sql = "SELECT rowid, ref, lieuLivraison FROM llx_commande_fournisseur WHERE fk_soc = $valeur AND fk_statut = 5";
      $rest = $db->query($sql);
      print'<table id="table">
              <tr>
              <th>Commande</th>
              </tr>';
      foreach ($rest as $row) {
        
          echo '<tr>';
          echo '<td>';
          echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
          echo '<input type="hidden" name="commande" value="' . $row['ref'] . '">';
          echo '<input type="hidden" name="valeur" value="' . $valeur . '">';
          echo '<input type="hidden" name="valeurC" value="' . $row['rowid'] . '">';
          echo '<input type="hidden" name="entrepot" value="' . $row['lieuLivraison'] . '">';          
          echo '<input type="submit" name="commandeC" value="' . $row['ref'] . '"style="border: none";>';
          echo '</form>';
          echo '</td>';
          echo '</tr>';
          
      }
      echo '</table>';
  echo '<h2 style="color:#4B99AD;">Fournisseur : ' . $param['nom'] . ' | Commande : ' . $ref . '</h2>';

    echo '<table id="table">';
    echo '<tr>
            <th style="text-align:center;">Nom Produit</th>
            <th style="text-align:center;">Référence</th>
            <th style="text-align:center;">Quantité Commondée</th>
            <th style="text-align:center;">Quantité en Stock</th>
            <th style="text-align:center;">Entrepot</th>
            <th style="text-align:center;">Quantité retournée</th>
            <th style="text-align:center;">Action</th>
          </tr>';
    $x=0;
    foreach ($restC as $row) {
        
        $sql2 = "SELECT fk_commande, qty, fk_product,fk_entrepot ,cost_price FROM llx_commande_fournisseur_dispatch WHERE fk_commande = $idC";
        $restC = $db->query($sql2);
        $product = $row['fk_product'];
        $entrepot =$row['fk_entrepot'];
        
        $sql3 = "SELECT ref,label FROM llx_product WHERE rowid = $product";
        $rest = $db->query($sql3);
        $param3 = $rest->fetch_assoc();

        $sql5= "SELECT `reel`  FROM `llx_product_stock` WHERE `fk_product` =  $product and `fk_entrepot` = $entrepot";
        $restS=$db->query($sql5);
        $param4= $restS->fetch_assoc();

       $sqlEnt="SELECT `ref` FROM `llx_entrepot` WHERE rowid = $entrepot";
       $restEnt=$db->query($sqlEnt);
       $paramEnt= $restEnt->fetch_assoc();
        echo '<tr>
                <td style="text-align:center;">' . $param3['label'] . '</td>
                <td style="text-align:center;">' . $param3['ref'] . '</td>
                <td style="text-align:center;">' . $row['qty'] . '</td>
                <td style="text-align:center;">' . $param4['reel'] . '</td>
                <td style="text-align:center;">' . $paramEnt['ref'] . '</td>
                <form method="post" action="' . $_SERVER['PHP_SELF'] . '">
                <input type="hidden" name="qty" value="' . $row['qty'] . '"/>
                <input type="hidden" name="product" value="' . $row['fk_product'] . '"/>
                <input type="hidden" name="price" value="' . $row['cost_price'] . '"/>
                <input type="hidden" name="comm" value="' . $ref . '"/>
                <input type="hidden" name="valeur" value="' . $valeur . '"/>
                <input type="hidden" name="idCommande" value="' . $idC . '"/>
                <input type="hidden" name="entp" value="' . $row['fk_entrepot'] . '"/>
                <input type="hidden" name="label" value="' . $param3['label'] . '"/>
                <input type="hidden" name="entpName" value="' . $paramEnt['ref'] . '"/>
                <input type="hidden" name="nomF" value="' . $param['nom'] . '"/>
                <input type="hidden" name="ref" value="' . $param3['ref'] . '"/>
                  <td style="text-align:center;">
                  <input type="number" name="qtyretn" min="0" step="any" required style="margin-top: 18px;font-size:100%;width:100px; background: #f0f0f0;  padding: 8px 15px 8px 15px; border: block;"/>
                  </td> 
                  <td style="text-align:center;">
                  <input type="submit" name="valider" value="Valider" style="margin-top: 18px; background: rgb(38,60,92); padding: 8px 15px 8px 15px; border: none; color: #fff;"/>
                  </td> 
                                
            </form>     

              </tr>';
       }
    echo '</table>';
    
    
}

      if (isset($_POST['valider'])) {

          $idFournisseur=isset($_POST['valeur']) ? $_POST['valeur'] : 0;
          $qtyretn = isset($_POST['qtyretn']) ? $_POST['qtyretn'] : 0;
          $qty = isset($_POST['qty']) ? $_POST['qty'] : 0;
          $product = isset($_POST['product']) ? $_POST['product'] : 0;
          $entrepot = isset($_POST['entp']) ? $_POST['entp'] : 0;
          $price = isset($_POST['price']) ? $_POST['price'] : 0;
          $nomF = isset($_POST['nomF']) ? $_POST['nomF'] : 0;
          $nomCommande = isset($_POST['comm']) ? $_POST['comm'] : 0;
          $produit = isset($_POST['label']) ? $_POST['label'] : 0;
          $warehouse = isset($_POST['entp']) ? $_POST['entp'] : 0;
          $entrepotName = isset($_POST['entpName']) ? $_POST['entpName'] : 0;
          $commande = isset($_POST['idCommande']) ? $_POST['idCommande'] : 0;

          $ref=isset($_POST['ref']) ? $_POST['ref'] : 0;
          $newProduit = 'D-'.$ref;


          $sql7="SELECT `rowid` FROM `llx_product` WHERE `ref`='$newProduit'";
          

          $rest7=$db->query($sql7);
          $param7=$rest7->fetch_assoc();
          $productDef= $param7['rowid'];
         
            
            $sql4 = "SELECT rowid, nom FROM llx_societe WHERE rowid = $idFournisseur";
            $rest = $db->query($sql4);
            $param2 = $rest->fetch_assoc();
            $nomFournisseur=$param2['nom'];

        
            $paramDefc=0;
            $sqlDefc= "SELECT `reel`  FROM `llx_product_stock` WHERE `fk_product` =  $productDef";
            $restStock=$db->query($sqlDefc);
            if($restStock && $restStock->num_rows > 0){
              $paramDefc=$restStock->fetch_assoc();
            }
            
            $reelD=0;
            $sqlSum="SELECT SUM(`value`) as value FROM `llx_stock_retours` WHERE `fk_product`=$productDef";
            $restSum=$db->query($sqlSum);
            $paramSum=$restSum->fetch_assoc();
            $qtyStock= $paramSum['value'];
            if($restSum && $qtyStock+$qtyretn<$qty && $qtyretn>0){

                  
                  $date = dol_print_date(dol_now(), '%Y-%m-%d %H:%M');
                  $sql = "INSERT INTO `llx_stock_mouvement`(`tms`, `datem`, `fk_product`, `batch`, `eatby`, `sellby`, `fk_entrepot`, `value`, `price`, `type_mouvement`, `fk_user_author`, `label`, `inventorycode`, `fk_project`, `fk_origin`, `origintype`, `model_pdf`, `fk_projet`) VALUES('$date', '$date',$productDef, 0, 0, 0, $entrepot, $qtyretn, $price, 1, 0, 'Retour de Produit au fournisseur : $nomFournisseur + num de commande : $nomCommande , produit : $produit ', 0, 0, 0, 0, 0, 0)";
                  $rest = $db->query($sql);

                  
      
                  // requette suivi
                  $date = dol_print_date(dol_now(), '%Y-%m-%d %H:%M');
                  $sql = "INSERT INTO `llx_stock_retours`(`tms`, `datem`, `fk_product`, `batch`, `eatby`, `sellby`, `fk_entrepot`, `value`, `price`, `type_mouvement`, `fk_user_author`, `label`, `inventorycode`, `fk_project`, `fk_origin`, `origintype`, `model_pdf`, `fk_projet`,`id_commande`,`type_tier`,`type_retour`) VALUES('$date', '$date',$productDef, 0, 0, 0, $entrepot, $qtyretn, $price, 1, 0, 'Retour de Produit au fournisseur : $nomFournisseur + num de commande : $nomCommande , produit : $produit ', 0, 0, 0, 0, 0, 0,$commande,'C',null)";
                  $rest = $db->query($sql);
  
                  
                  
                  // $sql8="SELECT `fk_product`  FROM `llx_product_stock` WHERE `fk_product` =  $productDef";
                  // $rest8=$db->query($sql8);
                  
                 
                    $date = dol_print_date(dol_now(), '%Y-%m-%d %H:%M');
                    $reelD=$paramDefc['reel']-$qtyretn;
                    $sql = "UPDATE `llx_product_stock` SET `reel`=$reelD WHERE `fk_product`=$productDef and `fk_entrepot`=$warehouse";
                    $rest = $db->query($sql);

                  echo '<br>';
                  echo '<div class="succes">';
                  echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
                  echo' <center>La quantite retournee est Modiifer</center>';
                  echo '</div>';


                  $sqlRO="SELECT rowid FROM `llx_stock_retours` ORDER BY `rowid`DESC LIMIT 1";
                  $restRO=$db->query($sqlRO);
                  $paramRO=$restRO->fetch_assoc();

                  $idRO=$paramRO['rowid'];
                  if(strlen($idRO)<=4)
                  {
                  $x=4-strlen($idRO);
                  for($i=1;$i<=$x;$i++)
                  {
                    $y="0". $idRO;
                    $idRO=$y;
                  }
                  }
                  
      
                  GenerateDocuments($produit,$newProduit,$qty,$entrepotName,$qtyretn,$nomF,$nomCommande,$idRO);



           }else if($qtyretn==0){
            echo '<br>';
            echo '<div class="alert">';
            echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
            echo' <center><strong>Attention!</strong> Merci de saisir une valeur supérieur de " 0 " </center>';
            echo '</div>';
           }
            else{
            echo '<br>';
            echo '<div class="alert">';
            echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
            echo' <center><strong>Attention!</strong> La somme des quantités retournées ne pas depasser la quantite commandée</center>';
            echo '</div>';
            }
           
           
         
          }

      

          //-------- PDF

          

?>


<?php


$object = new User($db);
$id = (GETPOST('id', 'int') ? GETPOST('id', 'int') : GETPOST('orderid', 'int'));

function GenerateDocuments($produit,$newProduit,$qty,$entrepotName,$qtyretn,$nomF,$nomCommande,$idRO)
{
  print '<form id="frmgen" name="builddoc" method="post">';
  print '<input type="hidden" name="token" value="' . newToken() . '">';
  print '<input type="hidden" name="action" value="builddoc">';
  print '<input type="hidden" name="model" value="fournisseurco">';
  print '<input type="hidden" name="produit" value="'.$produit.'">';
  print '<input type="hidden" name="newProduit" value="'.$newProduit.'">';
  print '<input type="hidden" name="qty" value="'.$qty.'">';
  print '<input type="hidden" name="entrpName" value="'.$entrepotName.'">';
  print '<input type="hidden" name="qtyretn" value="'.$qtyretn.'">';
  print '<input type="hidden" name="nomF" value="'.$nomF.'">';
  print '<input type="hidden" name="idRO" value="'.$idRO.'">';
  print '<input type="hidden" name="nomCommande" value="'.$nomCommande.'">';
  print '<div class="right"  style="margin-bottom: 100px; margin-right: 20%;">
  <input type="submit" id="btngen" class="button" name="save" value="génerer">';
  print '</form>';
  
}

function ShowDocuments()
{
  
   global $db, $object,$conf, $month, $prev_year, $societe, $showAll, $prev_month, $prev_year, $start;
   print '<div class="fichecenter"><divclass="fichehalfleft">';
   $formfile = new FormFile($db);
   $subdir = "";

   $filedir = DOL_DATA_ROOT . '/fournisseurCo/';
   $urlsource = $_SERVER['PHP_SELF'] . '';
   $genallowed = 0;
   $delallowed = 1;
   $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

  if ($societe !== null && isset($societe->default_lang)) {
    print $formfile->showdocuments('fournisseurco', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
  } else {
      print $formfile->showdocuments('fournisseurco', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
  }
 //  print $formfile->showdocuments('Passif', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
}



$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/fournisseurCo/';
$permissiontoadd = 1;
$donotredirect = 1;
include DOL_DOCUMENT_ROOT . '/core/actions_builddoc.inc.php';

// $ref=GETPOST('newProduit');

// if(!empty($ref))
// {
//   GenerateDocuments($produit,$newProduit,$qty,$qtyretn);
//   ShowDocuments();
// }

    

  ShowDocuments();



?>


</body>
</html>

