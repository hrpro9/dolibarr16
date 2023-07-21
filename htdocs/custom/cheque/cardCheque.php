<?php 
require_once '../../main.inc.php';
require_once '../../vendor/autoload.php';
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

llxHeader("", "");

?>
<!DOCTYPE html>
<html>
  <head>

  </head>
  <body>
    <?php
      print load_fiche_titre($langs->trans("Paiement par Chèque"), '', 'cheque.png@cheque');
    ?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <center>
   <br>
   <?php
      echo '<input type="hidden" name="valeur" value="'.GETPOST('id').'"/>' ;
   ?>

    <input type="text" name="ville" placeholder ="Saisir une Ville" required style="margin-top: 18px;font-size:95%; background: #ededed; font-weight:bolder; padding: 8px 15px 8px 15px; border: block; ">
    <input type="submit" name="submit" value="Traitement du cheque" style="margin-top: 18px; background: #4B99AD; padding: 8px 15px 8px 15px; border: block; color: #fff;">
   </center> 
   
</form>
  <?php
  if ((isset($_POST['submit'])) ) {
   $ville= isset($_POST['ville'])? $_POST['ville'] : 0;
   $valeur= isset($_POST['valeur'])? $_POST['valeur'] : 0;
   
   $sqlPaie="SELECT amount,`rowid`,`fk_facture` FROM `llx_paiement_facture` WHERE `rowid`=$valeur";
   $restPaie=$db->query($sqlPaie);
   $paramPaie=$restPaie->fetch_assoc();
   $facturePaie=$paramPaie['fk_facture'];
   $amount=$paramPaie['amount'];

   
  $sqlSoc="SELECT `fk_soc` FROM `llx_facture` WHERE `rowid`=$facturePaie";
  $restSoc=$db->query($sqlSoc);
  $paramSoc=$restSoc->fetch_assoc();
  $societe=$paramSoc['fk_soc'];

  $sqlName="SELECT `nom` FROM `llx_societe` WHERE `rowid`=$societe";
  $restName=$db->query($sqlName);
  $paramName=$restName->fetch_assoc();
  $nom=$paramName['nom'];
   
  $sqlRib="SELECT `number`,	domiciliation,bank FROM llx_bank_account WHERE bank='Bank Of Africa'";
  $restRib=$db->query($sqlRib);
  $paramRib=$restRib->fetch_assoc();
  $rib=$paramRib['number'];
  $dom=$paramRib['domiciliation'];
  $bank=$paramRib['bank'];

  $id=$valeur;
  
  GenerateDocuments($amount,$nom,$ville,$rib,$dom,$bank,$id,$facturePaie);
  
  }
  
  ?>
  </body>
</html>


<?php

$object = new User($db);
// $id = (GETPOST('id', 'int') ? GETPOST('id', 'int') : GETPOST('orderid', 'int'));

 $id = (GETPOST('id', 'int'));


function GenerateDocuments($amount,$nom,$ville,$rib,$dom,$bank,$id,$facturePaie)
{
  print '<form id="frmgen" name="builddoc" method="post">';
  print '<input type="hidden" name="token" value="' . newToken() . '">';
  print '<input type="hidden" name="action" value="builddoc">';
  print '<input type="hidden" name="model" value="Cheque">';
  print '<input type="hidden" name="amount" value="'.$amount.'">';
  print '<input type="hidden" name="facturePaie" value="'.$facturePaie.'">';
  print '<input type="hidden" name="nom" value="'.$nom.'">';
  print '<input type="hidden" name="ville" value="'.$ville.'">';
  print '<input type="hidden" name="rib" value="'.$rib.'">';
  print '<input type="hidden" name="id" value="'.$id.'">';
  print '<input type="hidden" name="dom" value="'.$dom.'">';
  print '<input type="hidden" name="bank" value="'.$bank.'">';
  print '<div class="right"  style="margin-bottom: 100px; margin-right: 20%;">
  <input type="submit" id="btngen" class="button" name="save" value="génerer">';
  print '</form>'; 
}

function ShowDocuments($id)
{

  // $id = (GETPOST('id', 'int'));
  // echo $id;
  // exit;
  
   global $db, $object,$conf, $month, $prev_year, $societe, $showAll, $prev_month, $prev_year, $start;
   print '<div class="fichecenter"><divclass="fichehalfleft">';
   $formfile = new FormFile($db);
   $subdir = "reglement-".$id."/";


   $filedir = DOL_DATA_ROOT . '/facture/reglement/reglement-'.$id.'/';
   $urlsource = $_SERVER['PHP_SELF'] . '';
   $genallowed = 0;
   $delallowed = 1;
   $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

  if ($societe !== null && isset($societe->default_lang)) {
    print $formfile->showdocuments('Cheque', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
  } else {
      print $formfile->showdocuments('Cheque', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
  }
 //  print $formfile->showdocuments('Passif', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
}

// $id = (GETPOST('id', 'int'));

$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/facture/reglement/reglement-'.$id.'/';
$permissiontoadd = 1;
$donotredirect = 1;
include DOL_DOCUMENT_ROOT . '/core/actions_builddoc.inc.php';

// $ref=GETPOST('newProduit');

// if(!empty($ref))
// {
//   GenerateDocuments($produit,$newProduit,$qty,$qtyretn);
//   ShowDocuments();
// }

    
  ShowDocuments($id);

?>