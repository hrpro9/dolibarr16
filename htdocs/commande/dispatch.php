<?php
/* Copyright (C) 2003-2006	Rodolphe Quiedeville	<rodolphe@quiedeville.org>
 * Copyright (C) 2004-2015	Laurent Destailleur		<eldy@users.sourceforge.net>
 * Copyright (C) 2005		Marc Barilley / Ocebo	<marc@ocebo.com>
 * Copyright (C) 2005-2015	Regis Houssin			<regis.houssin@inodbox.com>
 * Copyright (C) 2006		Andre Cianfarani		<acianfa@free.fr>
 * Copyright (C) 2010-2013	Juanjo Menent			<jmenent@2byte.es>
 * Copyright (C) 2011-2019	Philippe Grand			<philippe.grand@atoo-net.com>
 * Copyright (C) 2012-2013	Christophe Battarel		<christophe.battarel@altairis.fr>
 * Copyright (C) 2012-2016	Marcos García			<marcosgdf@gmail.com>
 * Copyright (C) 2012       Cedric Salvador      	<csalvador@gpcsolutions.fr>
 * Copyright (C) 2013		Florian Henry			<florian.henry@open-concept.pro>
 * Copyright (C) 2014       Ferran Marcet			<fmarcet@2byte.es>
 * Copyright (C) 2015       Jean-François Ferry		<jfefe@aternatik.fr>
 * Copyright (C) 2018-2021  Frédéric France         <frederic.france@netlogic.fr>
 * Copyright (C) 2022	    Gauthier VERDOL     <gauthier.verdol@atm-consulting.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file 	htdocs/commande/card.php
 * \ingroup commande
 * \brief 	Page to show customer order
 */

require_once '../main.inc.php';


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
if (!empty($conf->propal->enabled)) {
    require_once DOL_DOCUMENT_ROOT . '/comm/propal/class/propal.class.php';
}
if (!empty($conf->project->enabled)) {
    require_once DOL_DOCUMENT_ROOT . '/projet/class/project.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formprojet.class.php';
}

require_once DOL_DOCUMENT_ROOT . '/core/class/doleditor.class.php';

if (!empty($conf->variants->enabled)) {
    require_once DOL_DOCUMENT_ROOT . '/variants/class/ProductCombination.class.php';
}

// Load translation files required by the page
$langs->loadLangs(array('orders', 'sendings', 'companies', 'bills', 'propal', 'deliveries', 'products', 'other'));
if (!empty($conf->incoterm->enabled)) {
    $langs->load('incoterm');
}
if (!empty($conf->margin->enabled)) {
    $langs->load('margins');
}
if (!empty($conf->productbatch->enabled)) {
    $langs->load("productbatch");
}

$id = (GETPOST('id', 'int') ? GETPOST('id', 'int') : GETPOST('orderid', 'int'));
$ref = GETPOST('ref', 'alpha');

$socid = GETPOST('socid', 'int');
$action = GETPOST('action', 'aZ09');
$cancel = GETPOST('cancel', 'alpha');
$confirm = GETPOST('confirm', 'alpha');
$lineid = GETPOST('lineid', 'int');
$contactid = GETPOST('contactid', 'int');
$projectid = GETPOST('projectid', 'int');
$origin = GETPOST('origin', 'alpha');
$originid = (GETPOST('originid', 'int') ? GETPOST('originid', 'int') : GETPOST('origin_id', 'int')); // For backward compatibility
$rank = (GETPOST('rank', 'int') > 0) ? GETPOST('rank', 'int') : -1;

// PDF
$hidedetails = (GETPOST('hidedetails', 'int') ? GETPOST('hidedetails', 'int') : (!empty($conf->global->MAIN_GENERATE_DOCUMENTS_HIDE_DETAILS) ? 1 : 0));
$hidedesc = (GETPOST('hidedesc', 'int') ? GETPOST('hidedesc', 'int') : (!empty($conf->global->MAIN_GENERATE_DOCUMENTS_HIDE_DESC) ? 1 : 0));
$hideref = (GETPOST('hideref', 'int') ? GETPOST('hideref', 'int') : (!empty($conf->global->MAIN_GENERATE_DOCUMENTS_HIDE_REF) ? 1 : 0));







// Security check
if (!empty($user->socid)) {
    $socid = $user->socid;
}



// Initialize technical object to manage hooks of page. Note that conf->hooks_modules contains array of hook context
$hookmanager->initHooks(array('ordercard', 'globalcard'));

$result = restrictedArea($user, 'commande', $id);

$object = new Commande($db);

$extrafields = new ExtraFields($db);

// fetch optionals attributes and labels
$extrafields->fetch_name_optionals_label($object->table_element);

// Load object
include DOL_DOCUMENT_ROOT . '/core/actions_fetchobject.inc.php'; // Must be include, not include_once

$usercanread = $user->hasRight("commande", "lire");
$usercancreate = $user->hasRight("commande", "creer");
$usercandelete = $user->hasRight("commande", "supprimer");
// Advanced permissions
$usercanclose = ((empty($conf->global->MAIN_USE_ADVANCED_PERMS) && !empty($user->rights->commande->creer)) || (!empty($conf->global->MAIN_USE_ADVANCED_PERMS) && !empty($user->rights->commande->order_advance->close)));
$usercanvalidate = ((empty($conf->global->MAIN_USE_ADVANCED_PERMS) && $usercancreate) || (!empty($conf->global->MAIN_USE_ADVANCED_PERMS) && !empty($user->rights->commande->order_advance->validate)));
$usercancancel = ((empty($conf->global->MAIN_USE_ADVANCED_PERMS) && $usercancreate) || (!empty($conf->global->MAIN_USE_ADVANCED_PERMS) && !empty($user->rights->commande->order_advance->annuler)));
$usercansend = (empty($conf->global->MAIN_USE_ADVANCED_PERMS) || $user->rights->commande->order_advance->send);

$usercancreatepurchaseorder = ($user->hasRight("fournisseur", "commande", "creer") || $user->hasRight("supplier_order", "creer"));

$permissionnote = $usercancreate; // Used by the include of actions_setnotes.inc.php
$permissiondellink = $usercancreate; // Used by the include of actions_dellink.inc.php
$permissiontoadd = $usercancreate; // Used by the include of actions_addupdatedelete.inc.php and actions_lineupdown.inc.php

$error = 0;

$date_delivery = dol_mktime(GETPOST('liv_hour', 'int'), GETPOST('liv_min', 'int'), 0, GETPOST('liv_month', 'int'), GETPOST('liv_day', 'int'), GETPOST('liv_year', 'int'));






/*
 * Actions
 */

$parameters = array('socid' => $socid);
// Note that $action and $object may be modified by some hooks
$reshook = $hookmanager->executeHooks('doActions', $parameters, $object, $action);
if ($reshook < 0) {
    setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');
}

if (empty($reshook)) {
    $backurlforlist = DOL_URL_ROOT . '/commande/list.php';

    if (empty($backtopage) || ($cancel && empty($id))) {
        if (empty($backtopage) || ($cancel && strpos($backtopage, '__ID__'))) {
            if (empty($id) && (($action != 'add' && $action != 'create') || $cancel)) {
                $backtopage = $backurlforlist;
            } else {
                $backtopage = DOL_URL_ROOT . '/commande/card.php?id=' . ((!empty($id) && $id > 0) ? $id : '__ID__');
            }
        }
    }

    if ($cancel) {
        if (!empty($backtopageforcancel)) {
            header("Location: " . $backtopageforcancel);
            exit;
        } elseif (!empty($backtopage)) {
            header("Location: " . $backtopage);
            exit;
        }
        $action = '';
    }

    // include DOL_DOCUMENT_ROOT . '/core/actions_setnotes.inc.php'; // Must be include, not include_once

    // include DOL_DOCUMENT_ROOT . '/core/actions_dellink.inc.php'; // Must be include, not include_once

    // include DOL_DOCUMENT_ROOT . '/core/actions_lineupdown.inc.php'; // Must be include, not include_once

}

/*
 *	View
 */

$title = $langs->trans('Order') . " - " . $langs->trans('Card');
$help_url = 'EN:Customers_Orders|FR:Commandes_Clients|ES:Pedidos de clientes|DE:Modul_Kundenaufträge';
llxHeader('', $title, $help_url);

$form = new Form($db);
$formfile = new FormFile($db);
$formorder = new FormOrder($db);
$formmargin = new FormMargin($db);
if (!empty($conf->project->enabled)) {
    $formproject = new FormProjets($db);
}


// Mode view
$now = dol_now();

if ($object->id > 0) {

    // $orders = array();
    // $sql = "SELECT p.ref, det.total_ttc, det.qty, det.total_tva, det.price, s.reel, en.ref as entrepot, ed.qty as expedite  FROM llx_expedition as e";
    // $sql .= ' right JOIN '.MAIN_DB_PREFIX.'expeditiondet as ed ON (e.rowid = ed.fk_expedition)';
    // $sql .= ' right JOIN '.MAIN_DB_PREFIX.'commandedet as det ON (det.rowid = ed.fk_origin_line)';
    // $sql .= ' right JOIN '.MAIN_DB_PREFIX.'product as p ON (p.rowid = det.fk_product)';
    // $sql .= ' right JOIN '.MAIN_DB_PREFIX.'product_stock as s  ON (s.fk_product = det.fk_product)';
    // $sql .= ' right JOIN '.MAIN_DB_PREFIX.'entrepot as en  ON (en.rowid = s.fk_entrepot)';
    // $sql .= " WHERE det.fk_commande = '$object->id'";
    // $total_ttc = 0;
    // $total_tva= 0;    $res = $db->query($sql);
    // if ($res->num_rows) {
    //     while ($row = $res->fetch_assoc()) {
    //         $total_ttc += $row['total_ttc'];
    //         $total_tva += $row['total_tva'];
    //         array_push($orders, [$row['ref'], $row['price'], $row['qty'], $row['total_tva'], $row['total_ttc'], $row['reel'], $row['expedite'], $row['entrepot']]);
    //     }
    // }

    

   

    $orders = array();
    $sql = "SELECT p.ref, det.tva_tx, det.qty, det.price, en.ref as entrepot FROM llx_commandedet as det";
    $sql .= ' LEFT JOIN '.MAIN_DB_PREFIX.'product as p ON (p.rowid = det.fk_product)';
    $sql .= ' LEFT JOIN '.MAIN_DB_PREFIX.'product_stock as s  ON (s.fk_product = det.fk_product)';
    $sql .= ' LEFT JOIN '.MAIN_DB_PREFIX.'entrepot as en  ON (en.rowid = s.fk_entrepot)';
    $sql .= " WHERE det.fk_commande = '$object->id' and p.fk_product_type=0 ";
    $res = $db->query($sql);
    if ($res->num_rows) {
        while ($row = $res->fetch_assoc()) {
            array_push($orders, [$row['ref'], $row['price'], $row['qty'],  $row['tva_tx'], $row['entrepot']]);
           
        }
    }


    


    $product_static = new Product($db);

    $soc = new Societe($db);
    $soc->fetch($object->socid);

    $author = new User($db);
    $author->fetch($object->user_author_id);

    $object->fetch_thirdparty();
    $res = $object->fetch_optionals();

    $head = commande_prepare_head($object);
    print dol_get_fiche_head($head, 'dispatch', $langs->trans("CustomerOrder"), -1, 'order');

    // Order card

    $linkback = '<a href="' . DOL_URL_ROOT . '/commande/list.php?restore_lastsearch_values=1' . (!empty($socid) ? '&socid=' . $socid : '') . '">' . $langs->trans("BackToList") . '</a>';

    $morehtmlref = '<div class="refidno">';
    // Ref customer
    $morehtmlref .= $form->editfieldkey("RefCustomer", 'ref_client', $object->ref_client, $object, $usercancreate, 'string', '', 0, 1);
    $morehtmlref .= $form->editfieldval("RefCustomer", 'ref_client', $object->ref_client, $object, $usercancreate, 'string', '', null, null, '', 1);
    // Thirdparty
    $morehtmlref .= '<br>' . $langs->trans('ThirdParty') . ' : ' . $soc->getNomUrl(1, 'customer');
    if (empty($conf->global->MAIN_DISABLE_OTHER_LINK) && $object->thirdparty->id > 0) {
        $morehtmlref .= ' (<a href="' . DOL_URL_ROOT . '/commande/list.php?socid=' . $object->thirdparty->id . '&search_societe=' . urlencode($object->thirdparty->name) . '">' . $langs->trans("OtherOrders") . '</a>)';
    }


    dol_banner_tab($object, 'ref', $linkback, 1, 'ref', 'ref', $morehtmlref);
    
    $totalPrice = 0;
    $entrepots = [];
   
    
    foreach ($orders as $key => $value) {
        array_push($entrepots, $value[$key]);
    }
    foreach ($orders as $key => $order) {
        $entrepot[$order[4]][] = $order;
    }

    $i = [];

    foreach ($entrepot as $key => $values) {
        if (!in_array($key, $i)) {
            
            echo '<div class="fichecenter">';
            echo '<div class="underbanner clearboth"></div>';
            echo '<div class="fichecenter">';
            echo '<table class="border allwidth">';
            echo "<h2>Entrepôt: $key</h2>";
            echo "<tr>
                    <th>Product</th>
                    <th>Quantite</th>
                    <th>Quantity à Livré</th>
                    <th>prix TTC</th>
                    <th>TVA</th>
                    <th>Total TTC</th>
                </tr>";
        }

        foreach ($values as $value) {
            $quantiteLivrer = intval($value[2] < $value[3] ? $value[2] : $value[3]);
            $price = $quantiteLivrer * $value[1];

            echo '<tr>';
            echo '<td>' . $value[0] . '</td>';
            echo '<td>' . $value[2] . '</td>';
            echo '<td>' . $quantiteLivrer . '</td>';
            echo '<td>' . $value[1] . '</td>';
            echo '<td>' . intval($value[3]) . '%</td>';
            echo '<td>' . $price . '</td>';
            echo '</tr>';

            $totalPrice += $price;
        }

        $i[] = $key;
    }
    echo '</table>';





    // foreach ($orders as $key => $order) {
    //     $entrepot[$order[$key]] = $order;
    // }

    
    // $i=[];
    
    // foreach ($entrepot as $key => $value) {
    //     $quantiteLivrer = intval($value[2] < $value[3] ? $value[2] : $value[3]);
    //     $price = $quantiteLivrer * $value[1];


        

    //     if(!in_array($value[4], $i))
    //     {
    //         print'<div class="fichecenter">';
    //         print '<div class="underbanner clearboth"></div>';
    //         print '<div class="fichecenter">';
        
    //         print '<table class="border allwidth">';
    //         print "<h2>Entrepôt : ".$value[4]."</h2>";
    //         print "<tr>
    //                     <th>product</th>
    //                     <th>Quantite</th>
    //                     <th>Quantity à Livré</th>
    //                     <th>prix TTC</th>
    //                     <th>TVA</th>
    //                     <th>Total TTC</th>
    //                 </tr>";


    //     }
      
        
            
    //         print '<tr>';
    //         print '<td>'.$value[0]. '</td>';
    //         print '<td>'.$value[2]. '</td>';
    //         print '<td>'. $quantiteLivrer .'</td>';
    //         print '<td>'. $value[1] .'</td>';
    //         print '<td>'.intval($value[3]). '%</td>';
    //         print '<td>'. $price . '</td>';
    //         print '</tr>';
       
       
    //     $totalPrice = $totalPrice + $price;

       

    //     $i[]=$value[4];

    // }   
    // print '</table>';

    
    print "
    <div class='details'>
        <h4>Total produits : ".count($orders)."  </h4>
        <h4>Total TTC : ". $totalPrice."  </h4>

    </div>";
    
    print '<div>';

  
    

  

    print dol_get_fiche_end();
}
print "
	<style>
    .details{
        margin-top: 30px;
    }
    .details h3{
        font-size: 18px;
        color: #70768d;
    }
    table{
        margin-top: 25px;
    }
	tr{
		text-align: center;
	}
	tr:nth-of-type(even) {
		background: #eeeeee;
	}
	tr:nth-of-type(odd) {
		background: #f7f7f7;
	}
	  
	th {
		background-color: #708090;
		color: white;
		font-weight: bold;
		padding: 0.5em 0.375em;
		text-align: center;
		border: 1px solid #aaa;
	}
	td{
		border-right: 1px solid #d5cccc7d;
		border-bottom: none;
		padding-top: 0;
		padding-top: 0px !important;
		border-bottom: none !important;
		height: auto;
	}
</style>";


$object = new User($db);

$id = (GETPOST('id', 'int') ? GETPOST('id', 'int') : GETPOST('orderid', 'int'));

$sql="SELECT * FROM llx_commande WHERE rowid=$id";
$rest=$db->query($sql);
if($rest)
{
    $param=$rest->fetch_assoc();
    $importref=$param['ref'];
}else{
    $importref='';
}







function GenerateDocuments($importref)
{
    global $day, $month, $year, $start, $prev_year;
    print '<form id="frmgen" name="builddoc" method="post">';
    print '<input type="hidden" name="token" value="' . newToken() . '">';
    print '<input type="hidden" name="action" value="builddoc">';
    print '<input type="hidden" name="model" value="Dispatche">';
    print '<input type="hidden" name="importref" value="'.$importref.'">';
    print '<div class="right"  style="margin-bottom: 100px; margin-right: 20%;">
    <input type="submit" id="btngen" class="button" name="save" value="génerer">';
    print '</form>';
}
   


 function ShowDocuments($importref)
 {
    
    global $db, $object,$conf, $month, $prev_year, $societe, $showAll, $prev_month, $prev_year, $start;
    print '<div class="fichecenter"><divclass="fichehalfleft">';
    $formfile = new FormFile($db);
   
    $subdir = $importref."/";

    $filedir = DOL_DATA_ROOT . '/commande/dispatch/'.$importref.'/';
    $urlsource = $_SERVER['PHP_SELF'] . '';
    $genallowed = 0;
    $delallowed = 1;
    $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

   if ($societe !== null && isset($societe->default_lang)) {
     print $formfile->showdocuments('Dispatche', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
   } else {
       print $formfile->showdocuments('Dispatche', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
   }
  //  print $formfile->showdocuments('Passif', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
 }


 

$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/commande/dispatch/'.$importref.'/';
$permissiontoadd = 1;
$donotredirect = 1;

include DOL_DOCUMENT_ROOT . '/core/actions_builddoc.inc.php';


GenerateDocuments($importref);
ShowDocuments($importref);



// End of page
llxFooter();
$db->close();
