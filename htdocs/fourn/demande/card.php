<?php
/* Copyright (C) 2004-2006 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2015 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005      Eric	Seigne          <eric.seigne@ryxeo.com>
 * Copyright (C) 2005-2016 Regis Houssin        <regis.houssin@inodbox.com>
 * Copyright (C) 2010-2015 Juanjo Menent        <jmenent@2byte.es>
 * Copyright (C) 2011-2018 Philippe Grand       <philippe.grand@atoo-net.com>
 * Copyright (C) 2012-2016 Marcos García        <marcosgdf@gmail.com>
 * Copyright (C) 2013      Florian Henry        <florian.henry@open-concept.pro>
 * Copyright (C) 2014      Ion Agorria          <ion@agorria.com>
 * Copyright (C) 2018-2019 Frédéric France         <frederic.france@netlogic.fr>
 * Copyright (C) 2022      Gauthier VERDOL     <gauthier.verdol@atm-consulting.fr>
 * Copyright (C) 2022      Charlene Benke        <charlene@patas-monkey.com>
 *
 * This	program	is free	software; you can redistribute it and/or modify
 * it under	the	terms of the GNU General Public	License	as published by
 * the Free	Software Foundation; either	version	2 of the License, or
 * (at your	option)	any	later version.
 *
 * This	program	is distributed in the hope that	it will	be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A	PARTICULAR PURPOSE.	 See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 * or see https://www.gnu.org/
 */

/**
 *	\file		htdocs/fourn/commande/card.php
 *	\ingroup	supplier, order
 *	\brief		Card supplier order
 */

require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formorder.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/modules/supplier_order/modules_commandefournisseur.php';
require_once DOL_DOCUMENT_ROOT . '/fourn/class/fournisseur.commande.class.php';
require_once DOL_DOCUMENT_ROOT . '/fourn/class/fournisseur.product.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/fourn.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/files.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/doleditor.class.php';
require_once DOL_DOCUMENT_ROOT . '/fourn/class/fournisseur.class.php';


$nature_demande = [
	"1" => "Négoce",
	"2" => "Production",
	"3" => "Consommable",
	"4" => "Travaux & Entretien"
];
$units = array();


if (!empty($conf->supplier_proposal->enabled)) {
	require_once DOL_DOCUMENT_ROOT . '/supplier_proposal/class/supplier_proposal.class.php';
}
if (!empty($conf->product->enabled)) {
	require_once DOL_DOCUMENT_ROOT . '/product/class/product.class.php';
}
if (!empty($conf->project->enabled)) {
	require_once DOL_DOCUMENT_ROOT . '/projet/class/project.class.php';
	require_once DOL_DOCUMENT_ROOT . '/core/class/html.formprojet.class.php';
}
require_once NUSOAP_PATH . '/nusoap.php'; // Include SOAP

if (!empty($conf->variants->enabled)) {
	require_once DOL_DOCUMENT_ROOT . '/variants/class/ProductCombination.class.php';
}
$langs->loadLangs(array('admin', 'orders', 'sendings', 'companies', 'bills', 'propal', 'receptions', 'supplier_proposal', 'deliveries', 'products', 'stocks', 'productbatch'));

$id = GETPOST('id', 'int');
$socid = GETPOST('socid', 'int');
$ref = GETPOST('ref', 'alpha');
$action 		= GETPOST('action', 'alpha');
$lineAction 		= GETPOST('lineAction', 'alpha');
$confirm		= GETPOST('confirm', 'alpha');
$contextpage = GETPOST('contextpage', 'aZ') ? GETPOST('contextpage', 'aZ') : 'purchaseordercard'; // To manage different context of search

$backtopage = GETPOST('backtopage', 'alpha');
$backtopageforcancel = GETPOST('backtopageforcancel', 'alpha');

$projectid = GETPOST('projectid', 'int');
$cancel         = GETPOST('cancel', 'alpha');
$lineid         = GETPOST('lineid', 'int');
$origin = GETPOST('origin', 'alpha');
$originid = (GETPOST('originid', 'int') ? GETPOST('originid', 'int') : GETPOST('origin_id', 'int')); // For backward compatibility
$rank = (GETPOST('rank', 'int') > 0) ? GETPOST('rank', 'int') : -1;

//PDF
$hidedetails = (GETPOST('hidedetails', 'int') ? GETPOST('hidedetails', 'int') : (!empty($conf->global->MAIN_GENERATE_DOCUMENTS_HIDE_DETAILS) ? 1 : 0));
$hidedesc = (GETPOST('hidedesc', 'int') ? GETPOST('hidedesc', 'int') : (!empty($conf->global->MAIN_GENERATE_DOCUMENTS_HIDE_DESC) ? 1 : 0));
$hideref = (GETPOST('hideref', 'int') ? GETPOST('hideref', 'int') : (!empty($conf->global->MAIN_GENERATE_DOCUMENTS_HIDE_REF) ? 1 : 0));

$datelivraison = dol_mktime(GETPOST('livhour', 'int'), GETPOST('livmin', 'int'), GETPOST('livsec', 'int'), GETPOST('livmonth', 'int'), GETPOST('livday', 'int'), GETPOST('livyear', 'int'));



// Initialize technical object to manage hooks of page. Note that conf->hooks_modules contains array of hook context
$hookmanager->initHooks(array('ordersuppliercard', 'globalcard'));


$object;
$demendeAchat = array();

$lieudelivraison = [];
$sql = "select id, adresse from llx_lieu_livraison where deleted = 0";
$res = $db->query($sql);
if ($res->num_rows) {
	while ($row = $res->fetch_assoc()) {
		array_push($lieudelivraison, [$row['id'], $row['adresse']]);
	}
}


if ($id) {
	$sql = "select da.lieuLivraison, da.motifRejet, lv.adresse as adresseLivraison, date(date_valid) as date_valid, reopened, date(date_reouvrir) as date_reouvrir, date(date_approuve) as date_approuve, date(dateRejte) as dateRejte, da.fk_soc, da.ref_supplier, s.nom, c.libelle, cp.libelle_facture, da.id, da.statut, da.deleted, da.note_public, da.note_private, da.ref, da.statut, da.fk_user_author,fk_user_valid, fk_user_valid, fk_user_approuve, fk_user_rejeter,date(da.date_creation) as date_demande, date(da.date_livraison) as date_livraison, date(da.date_valid) as date_valid, da.multicurrency_code, da.fk_cond_reglement, da.fk_mode_reglement, nature_demande, fk_user_reouvrir, motif_reouvrir,";
	$sql .= " p.rowid as project_id, p.ref as project_ref, p.title as project_title,";
	$sql .= " u.firstname, u.lastname, u.login, u.email as user_email, u.statut as user_status from ";
	$sql .= MAIN_DB_PREFIX . "demande_achat as da";
	$sql .= " LEFT JOIN " . MAIN_DB_PREFIX . "user as u ON da.fk_user_author = u.rowid";
	$sql .= " LEFT JOIN " . MAIN_DB_PREFIX . "projet as p ON p.rowid = da.fk_projet";
	$sql .= " LEFT JOIN " . MAIN_DB_PREFIX . "societe as s ON da.fk_soc = s.rowid";
	$sql .= " LEFT JOIN " . MAIN_DB_PREFIX . "c_payment_term as cp ON cp.rowid = da.fk_cond_reglement";
	$sql .= " LEFT JOIN " . MAIN_DB_PREFIX . "c_paiement AS c on c.id = da.fk_mode_reglement";
	$sql .= ' LEFT JOIN ' . MAIN_DB_PREFIX . 'lieu_livraison as lv ON da.lieuLivraison = lv.id';
	$sql .= " where da.id = $id";


	$res = $db->query($sql);
	if ($res->num_rows) {
		$row = $res->fetch_assoc();
		foreach ($row as $key => $value) {
			$demendeAchat[$key] = $value;
		}
	} else {
		header("Location: /fourn/demande/list.php?mainmenu=commercial&idmenu=21895");
	}
	$object = (object) $demendeAchat;
	if ($object->statut == 0) {
		$badge = '<div class="statusref"><span class="badge  badge-status0 badge-status" title="Brouillon (à valider)">Brouillon (à valider)</span></div>';
	} else if ($object->statut == 1) {
		$badge = '<div class="statusref"><span class="badge  badge-status4 badge-status" title="Validé">Validé</span></div>';
	} else if ($object->statut == 2) {
		$badge = '<div class="statusref"><span class="badge  badge-status5 badge-status" title="Approuvé">Approuvé</span></div>';
	} else if ($object->statut == 3) {
		$badge = '<div class="statusref"><span class="badge  badge-status8 badge-status" title="Refusé">Refusé</span></div>';
	}
	if ($object->deleted == 1) {
		header("Location: /fourn/demande/list.php?mainmenu=commercial&idmenu=21895");
	}
	$sql = "select firstname, lastname from llx_user where rowid = $object->fk_user_author limit 1";
	$res = $db->query($sql);
	if ($res) {
		$row = $res->fetch_assoc();
		$created_by = $row['lastname'] . " " . $row['firstname'];
	}
	$validated_by = null;
	if ($object->statut == 1 || $object->statut == 2) {
		$sql = "select firstname, lastname from llx_user where rowid = $object->fk_user_valid limit 1";
		$res = $db->query($sql);
		if ($res) {
			$row = $res->fetch_assoc();
			$validated_by = $row['lastname'] . " " . $row['firstname'];
		}
	}
	$approved_by = null;
	if ($object->statut == 2) {
		$sql = "select firstname, lastname from llx_user where rowid = $object->fk_user_approuve limit 1";
		$res = $db->query($sql);
		if ($res) {
			$row = $res->fetch_assoc();
			$approved_by = $row['lastname'] . " " . $row['firstname'];
		}
	}
	$rejet_by = null;
	if ($object->statut == 3) {
		$sql = "select firstname, lastname from llx_user where rowid = $object->fk_user_rejeter limit 1";
		$res = $db->query($sql);
		if ($res) {
			$row = $res->fetch_assoc();
			$rejet_by = $row['lastname'] . " " . $row['firstname'];
		}
	}
	$reopened_by = null;
	if ($object->reopened) {
		$sql = "select firstname, lastname from llx_user where rowid = $object->fk_user_reouvrir limit 1";
		$res = $db->query($sql);
		if ($res) {
			$row = $res->fetch_assoc();
			$reopened_by = $row['lastname'] . " " . $row['firstname'];
		}
	}
	$sql = "select rowid, sortorder llx_c_units";
	$res = $db->query($sql);
	if ($res) {
		$units = $res->fetch_assoc();
	}
}

// if ($user->socid) {
// 	$socid = $user->socid;
// }

// Load object
// if ($id > 0 || !empty($ref)) {
// 	$ret = $object->fetch($id, $ref);
// 	if ($ret < 0) {
// 		dol_print_error($db, $object->error);
// 	}
// 	$ret = $object->fetch_thirdparty();
// 	if ($ret < 0) {
// 		dol_print_error($db, $object->error);
// 	}
// } elseif (!empty($socid) && $socid > 0) {
// 	$fourn = new Fournisseur($db);
// 	$ret = $fourn->fetch($socid);
// 	if ($ret < 0) {
// 		dol_print_error($db, $object->error);
// 	}
// 	$object->socid = $fourn->id;
// 	$ret = $object->fetch_thirdparty();
// 	if ($ret < 0) {
// 		dol_print_error($db, $object->error);
// 	}
// }

// Security check


// Project permission

$error = 0;
$form = new	Form($db);
$formfile = new FormFile($db);
$formorder = new FormOrder($db);
// $commande = new CommandeFournisseur($db);
if (!empty($conf->project->enabled)) {
	$formproject = new FormProjets($db);
}

/*
 * Actions
 */

$parameters = array('socid' => $socid);
$reshook = $hookmanager->executeHooks('doActions', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks
if ($reshook < 0) {
	setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');
}

if (empty($reshook)) {
	$backurlforlist = DOL_URL_ROOT . '/fourn/demande/list.php';

	if (empty($backtopage) || ($cancel && empty($id))) {
		if (empty($backtopage) || ($cancel && strpos($backtopage, '__ID__'))) {
			if (empty($id) && (($action != 'add' && $action != 'create') || $cancel)) {
				$backtopage = $backurlforlist;
			} else {
				$backtopage = DOL_URL_ROOT . '/fourn/demande/card.php?action=view&id=' . ((!empty($id) && $id > 0) ? $id : '__ID__');
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
	// Add Line
	if ($lineAction == 'add') {
		$action = 'view';
		$errorMsg = null;
		$product_id 	= GETPOST('product_id', 'int')  == '' ? "NULL" : GETPOST('product_id', 'int');
		$desc 	= GETPOST('desc', 'text') == '' ? "NULL" : "'" . GETPOST('desc', 'text') . "'";
		$qty 	= GETPOST('qty', 'int') < 1 ? "NULL" : GETPOST('qty', 'int');
		$prix 	= GETPOST('prix', 'int') > 0 ?  GETPOST('prix', 'int') : 0;

		if ($product_id == 'NULL') {
			$errorMsg = "Le champ 'produit' est obligatoire";
		}
		if ($qty == "NULL" && $errorMsg == null) {
			$errorMsg = "Le champ 'quantité' est obligatoire";
		}
		if ($errorMsg != null) {
			setEventMessages($errorMsg, array(), 'errors');
		} else {
			$sql = "INSERT INTO `llx_demande_achat_lines` (`fk_demande`, `fk_product`, `quantity`, `description`, `prix`) VALUES ($id, $product_id , $qty, $desc, $prix);";
			$result = $db->query($sql);
			if ($result) {
				setEventMessages('Produit ajouté avec succès', array(), 'mesgs');
			}
		}
	} else if ($lineAction == 'update') {
		$action = 'view';
		$errorMsg = null;
		$edit_line_id 	= GETPOST('edit_line_id', 'int')  == '' ? "NULL" : GETPOST('edit_line_id', 'int');
		$product_id 	= GETPOST('edit_product_id', 'int')  == '' ? "NULL" : GETPOST('edit_product_id', 'int');
		$desc 	= GETPOST('edit_desc', 'text') == '' ? "NULL" : "'" . GETPOST('edit_desc', 'text') . "'";
		$qty 	= GETPOST('edit_qty', 'int') < 1 ? "NULL" : GETPOST('edit_qty', 'int');
		$prix 	= GETPOST('edit_price', 'int') < 1 ? "NULL" : GETPOST('edit_price', 'int');
		if ($product_id == 'NULL') {
			if ($desc == 'NULL') {
				$errorMsg = "Le champ 'description' est obligatoire";
			}
		}
		if ($qty == "NULL" && $errorMsg == null) {
			$errorMsg = "Le champ 'quantité' est obligatoire";
		}
		if ($errorMsg != null) {
			setEventMessages($errorMsg, array(), 'errors');
			header("Location: /fourn/demande/card.php?id=$id&action=view&lineid=$edit_line_id&editLine=1&edit_desc=" . GETPOST('edit_desc', 'text') . "&edit_qty=" . GETPOST('edit_qty', 'int'));
		} else {
			$sql = "UPDATE `llx_demande_achat_lines` SET `quantity` = $qty, `description` = $desc, `prix` = $prix WHERE `llx_demande_achat_lines`.`id` = $edit_line_id;";
			$result = $db->query($sql);
			if ($result) {
				setEventMessages('Produit modifié avec succès', array(), 'mesgs');
			}
		}
	} else if ($lineAction == 'delete') {
		$action = 'view';
		$deleted_line_id 	= GETPOST('deleted_line_id', 'int')  == '' ? "NULL" : GETPOST('deleted_line_id', 'int');

		$sql = "DELETE FROM `llx_demande_achat_lines` WHERE `id` = $deleted_line_id;";
		$result = $db->query($sql);
		if ($result) {
			setEventMessages('Ligne produit supprimée avec succès', array(), 'mesgs');
		} else {
			setEventMessages("Ligne produit n'est pas supprimée", array(), 'errors');
		}
	}

	// Confirmation de la validation
	if ($action == 'validate') {
		$action = 'view';


		print('user');
		print($user->id);
		if ($object->fk_soc > 0) {
			$sql = "update `llx_demande_achat` set statut = 1 , date_valid = now(), fk_user_valid = $user->id  where id=$id;";
			$result = $db->query($sql);
			if ($result) {

				$db->commit();

				header("Location: " . $_SERVER['PHP_SELF'] . "?action=view&id=" . $id);
			} else {
				$db->rollback();
				setEventMessages($db->error, $db->errors, 'errors');
			}
			header("Location: " . $_SERVER['PHP_SELF'] . "?action=view&id=" . $id);
		} else {
			setEventMessages('Ajouter un tier pour valider la demande', array(), 'errors');
		}
	}
	// Confirmation de approuver
	if ($action == 'approuver') {
		$action = 'view';


		if ($object->fk_soc > 0) {
			$sql = "update `llx_demande_achat` set statut = 2 , date_approuve = now(), fk_user_approuve = $user->id  where id=$id;";
			$result = $db->query($sql);
			if ($result) {

				// 	// Creation commande	
				$sql = "INSERT INTO " . MAIN_DB_PREFIX . "commande_fournisseur (";
				$sql .= "ref";
				$sql .= ", fk_soc";
				$sql .= ", ref_supplier";
				$sql .= ", note_private";
				$sql .= ", note_public";
				$sql .= ", fk_projet";
				$sql .= ", date_livraison";
				$sql .= ", fk_mode_reglement";
				$sql .= ", fk_cond_reglement";
				$sql .= ", fk_multicurrency";
				$sql .= ", multicurrency_code";
				$sql .= ", date_creation";
				// $sql .= ", date_valid";
				$sql .= ", fk_user_author";
				$sql .= ", fk_statut";
				$sql .= ", source";
				$sql .= ", lieuLivraison";
				$sql .= ") ";
				$sql .= " VALUES (";
				$sql .= "'(PROV)'";
				$sql .= ", " . $object->fk_soc;
				$sql .= ", '" . $object->ref_supplier . "'";
				$sql .= ", '" . $object->note_private . "'";
				$sql .= ", '" . $object->note_public . "'";
				$sql .= ", " . ((int) $object->project_id);
				$sql .= ", '" . $object->date_livraison . "'";
				$sql .= ", '" . $object->fk_mode_reglement . "'";
				$sql .= ", '" . $object->fk_cond_reglement . "'";
				$sql .= ", '" . (int) $object->fk_multicurrency . "'";
				$sql .= ", '$object->multicurrency_code'";
				$sql .= ",' $object->date_demande'";
				// $sql .= ",now()";
				$sql .= ", $user->id";
				$sql .= ", '0'";
				$sql .= ", '0'";
				$sql .= ", ".(int)$object->lieuLivraison;

				$sql .= ")";
				print $sql;
				$result = $db->query($sql);
				if ($result) {
					$db->commit();

					// get last id
					$sql1 = "SELECT rowid FROM llx_commande_fournisseur ORDER BY rowid DESC LIMIT 1";
					$res = $db->query($sql1);
					$result = $res->fetch_assoc();
					$id_commande = $result['rowid'];

					$sql= "UPDATE ".MAIN_DB_PREFIX."commande_fournisseur";
					$sql .= " SET ref='(PROV".$id_commande.")'";
					$sql .= " WHERE rowid=".$id_commande;
					$result = $db->query($sql);
					$db->commit();
					print $sql;



					$sql = "SELECT quantity, fk_product, quantity, prix, description FROM `llx_demande_achat_lines` where fk_demande =$id ";
					$resql = $db->query($sql);
					$num_row = $db->num_rows($resql);
					if ($num_row > 0) {
						while ($line = $resql->fetch_object()) {
							$sql = "INSERT INTO `llx_commande_fournisseurdet` (`fk_commande`, `fk_product`, `qty`, `subprice`, `description`, `fk_multicurrency`, `multicurrency_code`) VALUES ($id_commande, $line->fk_product , $line->quantity, $line->prix, '$line->description', 1, 'MAD');";
							print $sql;
							$db->query($sql);
						}
					}
					$db->commit();

					$sql = "INSERT INTO " . MAIN_DB_PREFIX . "commande_fournisseur_extrafields (";
		            $sql .= "tms,";
		            $sql .= "fk_object,";
		            $sql .= "type_comm_fr";
		            $sql .= ") ";
		            $sql .= " VALUES (";
		            $sql .= " NOW() ";
		            $sql .= ", $object->id_commande" ;
		            $sql .= ", " . $object->nature_demande .")";
					print $sql;

					$result = $db->query($sql);
					$db->commit();

				} else {
					$db->rollback();
					setEventMessages($db->error, $db->errors, 'errors');
				}

				// header("Location: " . $_SERVER['PHP_SELF'] . "?action=view&id=" . $id);
			} else {
				$db->rollback();
				setEventMessages($db->error, $db->errors, 'errors');
			}
		} else {
			setEventMessages('Valider demande pour la transformer en commande', array(), 'errors');
		}
	}
	if ($action == 'refuser') {
		$action = 'view';
		$motif = GETPOST('motif', 'alpha') ?  $db->escape(GETPOST('motif', 'alpha')) : null;
		if ($motif == null) {
			setEventMessages('Motif est obligatoire', array(), 'errors');
			header("Location: " . $_SERVER['PHP_SELF'] . "?action=view&id=" . $id);
		} else {

			$sql = "update `llx_demande_achat` set statut = 3, dateRejte = now(), fk_user_rejeter = $user->id, motifRejet = '$motif'  where id=$id;";
			$result = $db->query($sql);
			if ($result) {
				$db->commit();
				setEventMessages('Demande refuser avec succès', array(), 'mesgs');
				header("Location: " . $_SERVER['PHP_SELF'] . "?action=view&id=" . $id);
			} else {
				$db->rollback();
				setEventMessages("demande n'est pas refuser", array(), 'errors');
			}
		}
	}
	if ($action == 'reouvrir') {
		$action = 'view';
		$motif = GETPOST('motif', 'alpha') ?  $db->escape(GETPOST('motif', 'alpha')) : null;
		if ($motif == null) {
			setEventMessages('Motif est obligatoire', array(), 'errors');
			header("Location: " . $_SERVER['PHP_SELF'] . "?action=view&id=" . $id);
		} else {
			$sql = "update `llx_demande_achat` set statut = 0, date_reouvrir = now(), reopened = 1, fk_user_reouvrir = $user->id, motif_reouvrir = '$motif' where id=$id;";
			print $sql;
			$result = $db->query($sql);
			if ($result) {
				$db->commit();
				setEventMessages('Demande reouvri avec succès', array(), 'mesgs');
				header("Location: " . $_SERVER['PHP_SELF'] . "?action=view&id=" . $id);
			} else {
				$db->rollback();
				setEventMessages("demande n'est pas reouvri", array(), 'errors');
				header("Location: " . $_SERVER['PHP_SELF'] . "?action=view&id=" . $id);
			}
		}
	}
	// Confirmation de la delete
	if ($action == 'delete') {
		$sql = "update `llx_demande_achat` set deleted = 1  where id=$id;";
		$result = $db->query($sql);
		if ($result) {
			$db->commit();
			header("Location: /fourn/demande/list.php?mainmenu=commercial&idmenu=21895");
		} else {
			$db->rollback();
			setEventMessages($db->error, $db->errors, 'errors');
		}
	}





	/*
	 * Create an order
	 */
	if ($action == 'add') {
		$error = 0;

		if (!$error) {
			$db->begin();

			// Creation demande

			$socid = GETPOST('socid', 'int') == '' ? "NULL" : GETPOST('socid', 'int');
			$cond_reglement_id 	= GETPOST('cond_reglement_id', 'int') == '' ? "NULL" : GETPOST('cond_reglement_id', 'int');
			$mode_reglement_id 	= GETPOST('mode_reglement_id', 'int') == '' ? "NULL" : GETPOST('mode_reglement_id', 'int');
			$note_private 		= GETPOST('note_private', 'restricthtml') == '' ? "NULL" : "'" . $db->escape(GETPOST('note_private', 'restricthtml')) . "'";
			$note_public   		= GETPOST('note_public', 'restricthtml') == '' ? "NULL" : "'" . $db->escape(GETPOST('note_public', 'restricthtml')) . "'";
			$date_livraison 	= GETPOST('liv', 'date') == '' ? "NULL" : "'" . GETPOST('liv', 'date') . "'"; // deprecated
			$natureDemande      = GETPOST('natureDemande', 'alpha');
			$multicurrency_code = GETPOST('multicurrency_code', 'alpha') == '' ? "NULL" : "'" . GETPOST('multicurrency_code', 'alpha') . "'";
			$ref_fourn 			= GETPOST('ref_fourn', 'alpha') == '' ? "NULL" : "'" . GETPOST('ref_fourn', 'alpha') . "'";
			$fk_project       	= GETPOST('projectid', 'int') == '' ? "NULL" : GETPOST('projectid', 'int');
			$lieuLivraison       	= GETPOST('lieuLivraison', 'int') == '' ? "NULL" : GETPOST('lieuLivraison', 'int');
			if ($multicurrency_code == 'NULL') {
				$fk_multicurrency = 'NULL';
			} else {
				$fk_multicurrency = MultiCurrency::getIdFromCode($db, $multicurrency_code);
			}


			// If creation from another object of another module (Example: origin=propal, originid=1)
			$sql = "INSERT INTO `llx_demande_achat` (`ref`, `ref_supplier`,`fk_soc`, `fk_projet`, `fk_user_author`, `note_private`, `note_public`,`date_livraison`, `fk_cond_reglement`, `fk_mode_reglement`, `fk_multicurrency`, `multicurrency_code`, `nature_demande`, `lieuLivraison`) VALUES('ProvDemAchat', $ref_fourn, $socid, $fk_project, $user->id, $note_private, $note_public, $date_livraison, $cond_reglement_id, $mode_reglement_id, $fk_multicurrency, $multicurrency_code, '$natureDemande', $lieuLivraison);";
			$result = $db->query($sql);
			if ($result) {
				$sql2 = "select LAST_INSERT_ID() as id from llx_demande_achat";
				$result2 = $db->query($sql2);
				$id = $db->fetch_object($resql)->id;
				$sql3 .= "update llx_demande_achat SET ref='ProvDemAchat" . $id . "' WHERE id=" . ((int) $id);
				$db->query($sql3);

				$db->commit();
				header("Location: " . $_SERVER['PHP_SELF'] . "?action=view&id=" . $id);
			} else {
				$db->rollback();
				$action = 'create';
				setEventMessages($db->error, $db->errors, 'errors');
			}
		}
	} else if ($action == 'update') {
		$error = 0;

		if (!$error) {
			$db->begin();

			// update demande
			$socid = GETPOST('socid', 'int') == '' ? "NULL" : GETPOST('socid', 'int');
			$cond_reglement_id  = GETPOST('cond_reglement_id', 'int') == '' ? "NULL" : GETPOST('cond_reglement_id', 'int');
			$mode_reglement_id	= GETPOST('mode_reglement_id', 'int') == '' ? "NULL" : GETPOST('mode_reglement_id', 'int');
			$note_private 		= GETPOST('note_private', 'restricthtml') == '' ? "NULL" : "'" . $db->escape(GETPOST('note_private', 'restricthtml')) . "'";
			$note_public   		= GETPOST('note_public', 'restricthtml') == '' ? "NULL" : "'" . $db->escape(GETPOST('note_public', 'restricthtml')) . "'";
			$date_livraison 	= GETPOST('liv', 'date') == '' ? "NULL" : "'" . GETPOST('liv', 'date') . "'"; // deprecated
			$multicurrency_code = GETPOST('multicurrency_code', 'alpha') == '' ? "NULL" : "'" . GETPOST('multicurrency_code', 'alpha') . "'";
			$fk_project       	= GETPOST('projectid', 'int') == '' ? "NULL" : GETPOST('projectid', 'int');
			$ref_fourn 			= GETPOST('ref_fourn', 'alpha') == '' ? "NULL" : "'" . GETPOST('ref_fourn', 'alpha') . "'";
			$natureDemande      = GETPOST('natureDemande', 'alpha');
			$lieuLivraison       	= GETPOST('lieuLivraison', 'int') == '' ? "NULL" : "'" . GETPOST('lieuLivraison', 'int') . "'";


			if ($multicurrency_code == 'NULL') {
				$fk_multicurrency = 'NULL';
			} else {
				$fk_multicurrency = MultiCurrency::getIdFromCode($db, $multicurrency_code);
			}


			// If creation from another object of another module (Example: origin=propal, originid=1)
			$sql = "update `llx_demande_achat` set `fk_soc` = $socid,`ref_supplier` = $ref_fourn, `fk_projet` = $fk_project, `fk_user_author` = $user->id, `note_private` = $note_private, `note_public` = $note_public,`date_livraison` = $date_livraison, `fk_cond_reglement` = $cond_reglement_id, `fk_mode_reglement` = $mode_reglement_id, `fk_multicurrency` = $fk_multicurrency, `multicurrency_code`=$multicurrency_code, `nature_demande`='$natureDemande', `lieuLivraison`=$lieuLivraison where id=$id;";
			$result = $db->query($sql);
			if ($result) {
				$db->commit();
				$action = 'view';
				header("Location: " . $_SERVER['PHP_SELF'] . "?action=view&id=" . $id);
			} else {
				$db->rollback();
				$action = 'edit';
				setEventMessages($db->error, $db->errors, 'errors');
			}
		}
	}
}


/*
 * View
 */



$title = $langs->trans('SupplierOrder') . " - " . $langs->trans('Card');
$help_url = 'EN:Module_Suppliers_Orders|FR:CommandeFournisseur|ES:Módulo_Pedidos_a_proveedores';
llxHeader('', $title, $help_url);

$now = dol_now();

if ($action == 'create') {
	print load_fiche_titre("Nouvelle demande d'Achat", '', 'supplier_order');

	dol_htmloutput_events();

	$currency_code = $conf->currency;


	$cond_reglement_id  = '';
	$mode_reglement_id  = '';
	$soc = new Fournisseur($db);
	if ($socid > 0) {
		$soc->fetch($socid);
		$cond_reglement_id  = $soc->cond_reglement_supplier_id;
		$mode_reglement_id  = $soc->mode_reglement_supplier_id;
	}




	print '<form name="add" action="' . $_SERVER["PHP_SELF"] . '" method="post">';
	print '<input type="hidden" name="token" value="' . newToken() . '">';
	print '<input type="hidden" name="action" value="add">';
	if ($backtopage) {
		print '<input type="hidden" name="backtopage" value="' . $backtopage . '">';
	}
	if ($backtopageforcancel) {
		print '<input type="hidden" name="backtopageforcancel" value="' . $backtopageforcancel . '">';
	}

	if (!empty($currency_tx)) {
		print '<input type="hidden" name="originmulticurrency_tx" value="' . $currency_tx . '">';
	}

	print dol_get_fiche_head('');

	print '<table class="border centpercent">';

	// Ref
	print '<tr><td class="titlefieldcreate">' . $langs->trans('Ref') . '</td><td>' . $langs->trans('Draft') . '</td></tr>';

	// Third party
	print '<tr><td>' . $langs->trans('Supplier') . '</td>';
	print '<td>';
	print img_picto('', 'company') . $form->select_company(GETPOSTISSET('socid') ? GETPOST('socid', 'int') : '', 'socid', 's.fournisseur=1', 'SelectThirdParty', 0, 0, null, 0, 'minwidth300');
	print ' <a href="' . DOL_URL_ROOT . '/societe/card.php?action=create&client=0&fournisseur=1&backtopage=' . urlencode($_SERVER["PHP_SELF"] . '?action=create') . '"><span class="fa fa-plus-circle valignmiddle paddingleft" title="' . $langs->trans("AddThirdParty") . '"></span></a>';
	print '</td></tr>';
	print '<script>
		$(document).ready(function() {
			$("#socid").change(function() {
				var socid = $(this).val();
				var prjid = $("#projectid").val();
				// reload page
				window.location.href = "' . $_SERVER["PHP_SELF"] . '?action=create&socid="+socid+"&projectid="+prjid
			});
		});
		</script>';

	// ref supplier
	print '<tr><td>';
	print "Réf. fournisseur";
	print '</td>';
	print "<td><input  name='ref_fourn' type='text' value='" . (GETPOSTISSET('ref_fourn') ? GETPOST('ref_fourn', 'alpha') :  '') . "'/></td></tr>";

	// Nature Demande
	print "<tr>
			<td>Nature de la demande</td>
			<td><select name='natureDemande'>";
	foreach ($nature_demande as $key => $nature) {
		print "<option value='$key'>$nature</option>";
	}
	print "</select></td></tr>";


	// Payment term
	print '<tr><td class="nowrap">' . $langs->trans('PaymentConditionsShort') . '</td><td>';
	$form->select_conditions_paiements(GETPOSTISSET('cond_reglement_id') ? GETPOST('cond_reglement_id', 'int') : $cond_reglement_id, 'cond_reglement_id');
	print '</td></tr>';

	// Payment mode
	print '<tr><td>' . $langs->trans('PaymentMode') . '</td><td>';
	$form->select_types_paiements(GETPOSTISSET('mode_reglement_id') ? GETPOST('mode_reglement_id', 'int') : $mode_reglement_id, 'mode_reglement_id');
	print '</td></tr>';

	// Planned delivery date
	print '<tr><td>';
	print $langs->trans('DateDeliveryPlanned');
	print '</td>';
	print "<td><input  name='liv' type='date' value='" . (GETPOSTISSET('liv') ? GETPOST('liv', 'date') :  '') . "'/></td></tr>";


	// Project
	if (!empty($conf->project->enabled)) {
		$formproject = new FormProjets($db);

		$langs->load('projects');
		print '<tr><td>' . $langs->trans('Project') . '</td><td>';
		print img_picto('', 'project') . $formproject->select_projects((empty($conf->global->PROJECT_CAN_ALWAYS_LINK_TO_ALL_SUPPLIERS) ? $societe->id : -1), GETPOSTISSET('projectid') ? GETPOST('projectid', 'int') : '', 'projectid', 0, 0, 1, 1, 0, 0, 0, '', 1, 0, 'maxwidth500');
		print ' &nbsp; <a href="' . DOL_URL_ROOT . '/projet/card.php?action=create&status=1' . (!empty($societe->id) ? '&socid=' . $societe->id : "") . '&backtopage=' . urlencode($_SERVER["PHP_SELF"] . '?action=create' . (!empty($societe->id) ? '&socid=' . $societe->id : "")) . '"><span class="fa fa-plus-circle valignmiddle" title="' . $langs->trans("AddProject") . '"></span></a>';
		print '</td></tr>';
	}


	// Multicurrency
	if (!empty($conf->multicurrency->enabled)) {
		print '<tr>';
		print '<td>' . $form->editfieldkey('Currency', 'multicurrency_code', '', $object, 0) . '</td>';
		print '<td class="maxwidthonsmartphone">';
		print $form->selectMultiCurrency(GETPOSTISSET('multicurrency_code') ? GETPOST('multicurrency_code', 'alpha') : '', 'multicurrency_code');
		print '</td></tr>';
	}

	print '<tr><td>' . $langs->trans('NotePublic') . '</td>';
	print '<td>';
	$doleditor = new DolEditor('note_public', GETPOSTISSET('note_public') ? GETPOST('note_public', 'restricthtml') : '', '', 80, 'dolibarr_notes', 'In', 0, false, empty($conf->global->FCKEDITOR_ENABLE_NOTE_PUBLIC) ? 0 : 1, ROWS_3, '90%');
	print $doleditor->Create(1);
	print '</td>';
	//print '<textarea name="note_public" wrap="soft" cols="60" rows="'.ROWS_5.'"></textarea>';
	print '</tr>';

	print '<tr><td>' . $langs->trans('NotePrivate') . '</td>';
	print '<td>';
	$doleditor = new DolEditor('note_private',  GETPOSTISSET('note_private') ? GETPOST('note_private', 'restricthtml') : '', '', 80, 'dolibarr_notes', 'In', 0, false, empty($conf->global->FCKEDITOR_ENABLE_NOTE_PRIVATE) ? 0 : 1, ROWS_3, '90%');
	print $doleditor->Create(1);
	print '</td>';
	//print '<td><textarea name="note_private" wrap="soft" cols="60" rows="'.ROWS_5.'"></textarea></td>';
	print '</tr>';

	// lieu de livraison
	print '<tr><td>Lieu de livraison</td><td>';
	print "<select name='lieuLivraison'>";
	foreach ($lieudelivraison as $key => $value) {
		print "<option value='$value[0]'>$value[1]</option>";
	}
	print "</select>";

	print '</td></tr>';


	// Bouton "Create Draft"
	print "</table>\n";

	print dol_get_fiche_end();

	print $form->buttonsSaveCancel("CreateDraft");

	print "</form>\n";
} else if ($action == 'edit') {
	print load_fiche_titre("Modifier demande d'Achat", '', 'supplier_order');

	dol_htmloutput_events();

	$currency_code = $conf->currency;

	$cond_reglement_id  = '';
	$mode_reglement_id  = '';
	$soc = new Fournisseur($db);
	if ($socid > 0) {
		$soc->fetch($socid);
		$cond_reglement_id  = $soc->cond_reglement_supplier_id;
		$mode_reglement_id  = $soc->mode_reglement_supplier_id;
	}


	print $badge;
	print '<form name="update" action="' . $_SERVER["PHP_SELF"] . '?id=' . $id . '" method="post">';
	print '<input type="hidden" name="token" value="' . newToken() . '">';
	print '<input type="hidden" name="action" value="update">';
	if ($backtopage) {
		print '<input type="hidden" name="backtopage" value="' . $backtopage . '">';
	}
	if ($backtopageforcancel) {
		print '<input type="hidden" name="backtopageforcancel" value="' . $backtopageforcancel . '">';
	}

	if (!empty($currency_tx)) {
		print '<input type="hidden" name="originmulticurrency_tx" value="' . $currency_tx . '">';
	}

	print dol_get_fiche_head('');

	print '<table class="border centpercent">';

	// Ref
	print '<tr><td class="titlefieldcreate">' . $langs->trans('Ref') . '</td><td>' . $object->ref . '</td></tr>';

	// Third party
	print '<tr><td>' . $langs->trans('Supplier') . '</td>';
	print '<td>';
	print img_picto('', 'company') . $form->select_company(GETPOSTISSET('socid') ? GETPOST('socid', 'int') : $object->fk_soc, 'socid', 's.fournisseur=1', 'SelectThirdParty', 0, 0, null, 0, 'minwidth300');
	print ' <a href="' . DOL_URL_ROOT . '/societe/card.php?action=create&client=0&fournisseur=1&backtopage=' . urlencode($_SERVER["PHP_SELF"] . '?action=create') . '"><span class="fa fa-plus-circle valignmiddle paddingleft" title="' . $langs->trans("AddThirdParty") . '"></span></a>';
	print '</td></tr>';
	print '<script>
		$(document).ready(function() {
			$("#socid").change(function() {
				var socid = $(this).val();
				var prjid = $("#projectid").val();
				// reload page
				window.location.href = "' . $_SERVER["PHP_SELF"] . '?id=' . $id . '&action=edit&socid="+socid+"&projectid="+prjid
			});
		});
	</script>';

	// Nature Demande
	print "<tr>
		<td>Nature de la demande</td>
		<td><select name='natureDemande'>";
	foreach ($nature_demande as $key => $nature) {
		print "<option value='$key' " . ($key == $object->nature_demande ? "selected" : "") . ">$nature</option>";
	}
	print "</select></td></tr>";

	// ref supplier
	print '<tr><td>';
	print "Réf. fournisseur";
	print '</td>';
	print "<td><input  name='ref_fourn' type='text' value='" . (GETPOSTISSET('ref_fourn') ? GETPOST('ref_fourn', 'alpha') :  $object->ref_supplier) . "'/></td></tr>";

	// Payment term
	print '<tr><td class="nowrap">' . $langs->trans('PaymentConditionsShort') . '</td><td>';
	$form->select_conditions_paiements(GETPOSTISSET('cond_reglement_id') ? GETPOST('cond_reglement_id', 'int') : ($cond_reglement_id == '' ? $object->fk_cond_reglement : $cond_reglement_id), 'cond_reglement_id');
	print '</td></tr>';

	// Payment mode
	print '<tr><td>' . $langs->trans('PaymentMode') . '</td><td>';
	$form->select_types_paiements(GETPOSTISSET('mode_reglement_id') ? GETPOST('mode_reglement_id', 'int') : ($mode_reglement_id == '' ? $object->fk_mode_reglement : $mode_reglement_id), 'mode_reglement_id');
	print '</td></tr>';

	// Planned delivery date
	print '<tr><td>';
	print $langs->trans('DateDeliveryPlanned');
	print '</td>';
	print "<td><input  name='liv' type='date' value='" . (GETPOSTISSET('liv', 'date') ? GETPOST('liv', 'date') :  $object->date_livraison) . "'/></td></tr>";


	// Project
	if (!empty($conf->project->enabled)) {
		$formproject = new FormProjets($db);

		$langs->load('projects');
		print '<tr><td>' . $langs->trans('Project') . '</td><td>';
		print img_picto('', 'project') . $formproject->select_projects((empty($conf->global->PROJECT_CAN_ALWAYS_LINK_TO_ALL_SUPPLIERS) ? $societe->id : -1), (GETPOSTISSET('projectid') ? GETPOST('projectid', 'int') :  $object->project_id), 'projectid', 0, 0, 1, 1, 0, 0, 0, '', 1, 0, 'maxwidth500');
		print ' &nbsp; <a href="' . DOL_URL_ROOT . '/projet/card.php?action=create&status=1' . (!empty($societe->id) ? '&socid=' . $societe->id : "") . '&backtopage=' . urlencode($_SERVER["PHP_SELF"] . '?action=create' . (!empty($societe->id) ? '&socid=' . $societe->id : "")) . '"><span class="fa fa-plus-circle valignmiddle" title="' . $langs->trans("AddProject") . '"></span></a>';
		print '</td></tr>';
	}


	// Multicurrency
	if (!empty($conf->multicurrency->enabled)) {
		print '<tr>';
		print '<td>' . $form->editfieldkey('Currency', 'multicurrency_code', '', $object, 0) . '</td>';
		print '<td class="maxwidthonsmartphone">';
		print $form->selectMultiCurrency((GETPOSTISSET('multicurrency_code') ? GETPOST('multicurrency_code', 'alpha') :  $object->multicurrency_code), 'multicurrency_code');
		print '</td></tr>';
	}

	print '<tr><td>' . $langs->trans('NotePublic') . '</td>';
	print '<td>';
	$doleditor = new DolEditor('note_public', GETPOSTISSET('note_public') ? GETPOST('note_public', 'restricthtml') : $object->note_public, '', 80, 'dolibarr_notes', 'In', 0, false, empty($conf->global->FCKEDITOR_ENABLE_NOTE_PUBLIC) ? 0 : 1, ROWS_3, '90%');
	print $doleditor->Create(1);
	print '</td>';
	//print '<textarea name="note_public" wrap="soft" cols="60" rows="'.ROWS_5.'"></textarea>';
	print '</tr>';

	print '<tr><td>' . $langs->trans('NotePrivate') . '</td>';
	print '<td>';
	$doleditor = new DolEditor('note_private', GETPOSTISSET('note_private') ? GETPOST('note_private', 'restricthtml') : $object->note_private, '', 80, 'dolibarr_notes', 'In', 0, false, empty($conf->global->FCKEDITOR_ENABLE_NOTE_PRIVATE) ? 0 : 1, ROWS_3, '90%');
	print $doleditor->Create(1);
	print '</td>';
	//print '<td><textarea name="note_private" wrap="soft" cols="60" rows="'.ROWS_5.'"></textarea></td>';
	print '</tr>';

	// lieu de livraison
	print '<tr><td>Lieu de livraison</td><td>';
	print "<select name='lieuLivraison'>";
	foreach ($lieudelivraison as $key => $value) {
		print "<option value='$value[0]'" . ($value[0] == $object->lieuLivraison ? "selected" : "") . ">$value[1]</option>";
	}
	print "</select>";

	print '</td></tr>';


	print "</table>\n";

	print dol_get_fiche_end();

	print $form->buttonsSaveCancel("Modify");

	print "</form>\n";
} else if ($action == 'view') {
	print load_fiche_titre("Consulter demande d'Achat", '', 'supplier_order');

	print $badge;

	print '<form id="viewForm" name="add" action="' . $_SERVER["PHP_SELF"] . '?id=' . $id . '" method="post">';
	print '<input type="hidden" name="token" value="' . newToken() . '">';
	// print '<input type="hidden" name="action" value="view">';
	if ($backtopage) {
		print '<input type="hidden" name="backtopage" value="' . $backtopage . '">';
	}
	if ($backtopageforcancel) {
		print '<input type="hidden" name="backtopageforcancel" value="' . $backtopageforcancel . '">';
	}

	if (!empty($currency_tx)) {
		print '<input type="hidden" name="originmulticurrency_tx" value="' . $currency_tx . '">';
	}

	print dol_get_fiche_head('');

	print '<table class="border centpercent displaying">';

	// Ref
	print '<tr><td class="titlefieldcreate">' . $langs->trans('Ref') . '</td><td>' . $object->ref . '</td></tr>';

	// Tier
	print '<tr><td class="titlefieldcreate">Tier</td><td>' . $object->nom . '</td></tr>';

	// ref supplier
	print "<tr><td>Réf. fournisseur</td><td>$object->ref_supplier</td></tr>";

	// Nature de la demande
	print "<tr><td>Nature de la demande</td><td>".$nature_demande[$object->nature_demande]."</td></tr>";

	// Payment term
	print '<tr><td class="nowrap">' . $langs->trans('PaymentConditionsShort') . '</td><td>';
	$form->form_conditions_reglement($_SERVER['PHP_SELF'] . '?socid=' . $object->id, $object->fk_cond_reglement, 'none', 0, '', 1);
	print '</td></tr>';

	// Payment mode
	print '<tr><td>' . $langs->trans('PaymentMode') . '</td><td>';
	$form->form_modes_reglement($_SERVER['PHP_SELF'] . '?socid=' . $object->id, $object->fk_mode_reglement, 'none');
	print '</td></tr>';

	// Planned delivery date
	print '<tr><td>';
	print $langs->trans('DateDeliveryPlanned');
	print '</td>';
	print "<td>$object->date_livraison</td></tr>";


	// Project
	if (!empty($conf->project->enabled)) {
		$formproject = new FormProjets($db);

		$langs->load('projects');
		print '<tr><td>' . $langs->trans('Project') . '</td><td>';
		print "$object->project_ref $object->project_title";
		print '</td></tr>';
	}


	// Multicurrency
	if (!empty($conf->multicurrency->enabled)) {
		print '<tr>';
		print '<td>Devise</td>';
		print '<td class="maxwidthonsmartphone">';
		print $object->multicurrency_code;
		print '</td></tr>';
	}

	print '<tr><td>' . $langs->trans('NotePublic') . '</td>';
	print '<td>' . nl2br($object->note_public) . '</td>';	//print '<textarea name="note_public" wrap="soft" cols="60" rows="'.ROWS_5.'"></textarea>';
	print '</tr>';

	print '<tr><td>' . $langs->trans('NotePrivate') . '</td>';
	print '<td>' . nl2br($object->note_private) . '</td>';
	print '</tr>';
	print '<tr><td>Lieu de livraison</td>';
	print "<td>" . ($object->adresseLivraison ? $object->adresseLivraison : "-") . "</td>";
	print '</tr>';

	print "<tr><td>Creation</td><td>Creé Le $object->date_demande par $created_by</td></tr>";
	if ($object->statut == 1 || $object->statut == 2)
		print "<tr><td>Validé</td><td>Le $object->date_valid par $validated_by</td></tr>";
	if ($object->statut == 2)
		print "<tr><td>Transformé en commande</td><td>Le $object->date_approuve par $approved_by</td></tr>";
	if ($object->statut == 3)
		print "<tr><td>Refusé</td><td>Le $object->dateRejte par $rejet_by <br>Motif : $object->motifRejet</td></tr>";
	if ($object->reopened == 1)
		print "<tr><td>Reouvri</td><td>Le $object->date_reouvrir par $reopened_by <br>Motif : $object->motif_reouvrir</td></tr>";


	// Bouton "Create Draft"
	print "</table>\n";


	print '<div class="div-table-responsive-no-min" style="margin-top:20px;">';
	print '<table id="tablelines" class="noborder noshadow centpercent">';

	// head
	print '<thead>
	<tr style="background: #e9eaed !important;font-weight: normal;color: #28283ce6;font-family: arial,tahoma,verdana,helvetica;" class="liste_titre nodrag nodrop"><td class="linecoldescription">Description</td><td class="linecolqty center">Qté</td><td class="linecolqty center">Prix</td><td class="linecoledit" style="width: 10px"></td><td class="linecoldelete" style="width: 10px"></td></tr>
	</thead>';

	// Body
	print '<tbody class="showLines">';
	$products = array();
	$sql = "SELECT p.rowid, p.ref, p.label FROM llx_product as p ORDER BY p.ref ASC";
	$resql = $db->query($sql);
	$num_row = $db->num_rows($resql);
	if ($num_row > 0) {
		$i = 0;
		while ($row = $resql->fetch_object()) {
			$products[$i] = $row;
			$i++;
		}
	}

	$sql = "SELECT p.rowid, p.ref, p.label, l.quantity, l.id, l.description, l.prix FROM `llx_demande_achat_lines` as l ";
	$sql .= " LEFT JOIN llx_product as p ON p.rowid = l.fk_product where l.fk_demande = $id";
	$resql = $db->query($sql);
	$num_row = $db->num_rows($resql);
	if ($num_row > 0) {
		while ($row = $resql->fetch_object()) {
			if (GETPOST('editLine', 'int') == 1 && GETPOST('lineid', 'int') == $row->id && $object->statut == 0) {
				print "
				<tr class='oddeven tredited'>
				<td class='linecoldesc minwidth250onall'>
				<input type='hidden' name='edit_line_id' value='$row->id'>
				<div id='line_$row->id'></div>
			
				<input type='hidden' name='lineid' value='$row->id'>			
				<a href='/product/card.php?id=$row->rowid' class='nowraponall classfortooltip'><span class='fas fa-cube paddingright classfortooltip' style=' color: #a69944;'></span>$row->ref</a> - $row->label
				<input type='hidden' name='edit_product_id' value='$row->rowid'>		<br><br>
				
				<textarea name='edit_desc' rows='3' style='margin-top: 5px; width: 98%' class='flat '>" . (GETPOSTISSET('edit_desc', 'text') ? GETPOST('edit_desc', 'text') : $row->description) . "</textarea>	</td>
			
				<td class='center'><input size='3' type='number' class='flat right' name='edit_qty' value='" . (GETPOSTISSET('edit_qty', 'int') ? GETPOST('edit_qty', 'int') : $row->quantity) . "'>	</td>
				
				<td class='center'><input size='3' type='number' class='flat right' name='edit_price' value='" . (GETPOSTISSET('edit_price', 'int') ? GETPOST('edit_price', 'int') : $row->prix) . "'>	</td>
				
				<td class='center valignmiddle' colspan='5'>	
				    <button type='button' class='button buttongen marginbottomonly button-save' onclick='updateLine()'>Enregistrer</button>
					<input type='submit' class='button buttongen marginbottomonly button-cancel' id='cancellinebutton' name='cancel' value='Annuler'>
				</td>
			</tr>
				";
			} else {

				if ($row->rowid == null) {
					$label = $row->description;
					$ref = '';
				} else {
					$label = $row->ref;
					$ref = $row->label;
				}
				print "
				<tr id='row-$row->id' class='drag drop oddeven' data-element='commande_fournisseurdet' data-id='$row->id' data-qty='$row->quantity'>
					<td class='linecoldescription minwidth300imp'><div id='line_$row->id'></div><a href='/product/card.php?id=$row->rowid' class='nowraponall classfortooltip'><span class='fas fa-cube paddingright classfortooltip' style=' color: #a69944;'></span>$ref</a> - $label</td>
					<td class='linecolqty nowrap center'>$row->quantity</td>
					<td class='linecolqty nowrap center'>$row->prix</td>";
				if ($object->statut == 0) {
					print " <td class='linecoledit center'><a class='editfielda reposition' href='/fourn/demande/card.php?id=$id&action=view&lineid=$row->id&editLine=1'><span class='fas fa-pencil-alt' style=' color: #444;' title='Modifier'></span></a></td>
						<td class='linecoldelete center'><a href='#'  onclick='showConfirmation(" . '"Êtes-vous sûr de vouloir effacer cette ligne produit ?", "Supprimer ligne",' . $row->id . ")'><span class='fas fa-trash pictodelete' style='' title='Supprimer'></span></a></td>";
				} else {
					print " <td class='linecoledit center'></td>
						<td class='linecoldelete center'></td>";
				}
				print "</tr>";
			}
		}
	}
	print '</tbody>';
	print '<tbody>';
	if ($object->statut == 0) {
		print "
	<tr class='pair nodrag nodrop nohoverpair liste_titre_create'>
	<td class='nobottom linecoldescription'>
	<select name='product_id' style='width: 300px;'>
		<option value=''></option>";
		$selected = ($errorMsg ? GETPOST('product_id', 'int') : null);
		foreach ($products as $product) {
			print "<option value='$product->rowid' " . ($product->rowid == $selected ? "selected" : "") . ">$product->ref $product->label</option>";
		}
		print "</select>
<br><textarea name='desc' rows='3' style='margin-top: 5px; width: 98%' class='flat '>" . ($errorMsg ? GETPOST('desc', 'text') : null) . "</textarea></td>
	
<td class='nobottom linecolqty center'>
	<input type='number' size='2' name='qty' class='flat right' value='" . ($errorMsg ? GETPOST('qty', 'int') : null) . "'>
</td>
<td class='nobottom linecolqty center'>
	<input type='number' size='2' name='prix' class='flat right' value='" . ($errorMsg ? GETPOST('prix', 'int') : 0) . "'>
</td>
<td class='nobottom linecoledit center valignmiddle' colspan='3'>
	<button type='button' class='button reposition' onclick='addLine()'>Ajouter</button>

</td>
</tr>
	";
	}

	print '</tbody>';
	print '</table>';
	print '</div>';


	print dol_get_fiche_end();

	if ($object->statut == 0) {
		print "<button type='button' class='butAction' onclick='editDemande()'>" . $langs->trans("Modify") . "</button>";
		print "<button type='button' class='butAction rejetBtn' onclick='showConfirmation(" . '"Veuillez vraiment refuse cette demande", "Refuser",' . null . ")'>Refuser</button>";
		if ($num_row > 0) {
			print "<button type='button' class='butAction validateBtn' onclick='showConfirmation(" . '"Veuillez vraiment valider cette demande", "Valider",' . null . ")'>Valider</button>";
		}
		print "<button type='button' class='butAction deleteBtn' onclick='showConfirmation(" . '"Veuillez vraiment supprimer cette demande", "Supprimer",' . null . ")'>Supprimer</button>";
	} else if ($object->statut == 1) {
		print "<button type='button' class='butAction validateBtn' onclick='showConfirmation(" . '"Veuillez vraiment tronsformer cette demande au commande", "Approuver",' . null . ")'>Transformer au commande</button>";
		print "<button type='button' class='butAction' onclick='showConfirmation(" . '"Veuillez vraiment reouvrir cette demande", "Reouvrir",' . null . ")'>Reouvrir / Retour</button>";
	}


	print "</form>\n";
}


print '<div id="overflow">';
print "
    <div id='confirmationModal'>
        <div class='confirmation-title'>
            <h2>Voulez-vous supprimer cette rubrique</h2>
        </div>
        <div id='confirmation-body'>
        </div>
        <div class='confirmation-footer'>
            <button type='button' class='confirm'>Supprimer</button>
            <button type='button' class='cancel'>Annuler</button>
        </div>
    </div>";


print "

	<style>
		.validateBtn{
			background : rgb(85 157 72 / 95%);
		}
		.deleteBtn{
			background: rgb(189 57 57 / 95%);
		}
		.rejetBtn{
			background: rgb(203 170 42 / 95%);
		}
		#overflow{
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			height: 100%;
			width: 100%;
			background-color: #2e2e2ebd;
			overflow: unset;
		}
		#confirmationModal{
			padding: 18px;
			border-radius: 8px;
			background-color: #e7e7e7;
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			display: none;
			flex-direction: column;
			justify-content: space-between;
		}
		#confirmation-body{
			margin: 18px auto;
		}
		#confirmation-body textarea{
			width: 332px;
			height: 60px;
		}
		#confirmationModal button{
			border: 0;
			border-radius: 0.25em;
			background: initial;
			color: #fff;
			font-size: 16px;
			padding: 9px;
			cursor: pointer;
		}
		#confirmationModal button.confirm{
			background-color: #548734;
		}
		#confirmationModal button.cancel{
			background-color: #dc3741;
		}
		#confirmationModal .confirmation-footer{
			display: flex;
			justify-content: space-evenly;
		}
		#viewForm .displaying tr:nth-child(odd) {
			background: #e9e9e9 !important;
		}
	</style>
";

// End of page
llxFooter();
$db->close();


?>
<script>
	function showConfirmation(message, confirm, id) {
		if (id > 0) {
			$("#viewForm").append('<input id="deleteLine" type="hidden" name="deleted_line_id" value="' + id + '" />');
		}
		if (confirm == "Reouvrir") {
			+$("#confirmation-body").append("<textarea id='motif_reouvrir'></textarea>");
		}
		if (confirm == "Refuser") {
			+$("#confirmation-body").append("<textarea id='motif_rejet'></textarea>");
		}

		$("html, body").css({
			overflow: "hidden",
		});
		$("#overflow").css("display", "block");
		$("#confirmationModal").css("display", "flex");
		$("#confirmationModal .confirmation-title").html("<h2>" + message + "</h2>");
		$("#confirmationModal .confirm").html(confirm);
	}

	function editDemande() {
		$("#viewForm").append('<input type="hidden" name="action" value="edit" />');
		$("#viewForm").submit();

	}

	function addLine() {
		$("#viewForm").append('<input type="hidden" name="lineAction" value="add" />');
		$("#viewForm").submit();

	}

	function updateLine() {
		$("#viewForm").append('<input type="hidden" name="lineAction" value="update" />');
		$("#viewForm").submit();

	}
	$("#confirmationModal").on('click', ".confirm", function(event) {
		if ($(this).text() == 'Valider') {
			$("#viewForm").append('<input type="hidden" name="action" value="validate" />');
		} else if ($(this).text() == 'Supprimer') {
			$("#viewForm").append('<input type="hidden" name="action" value="delete" />');
		} else if ($(this).text() == 'Supprimer ligne') {
			$("#viewForm").append('<input type="hidden" name="lineAction" value="delete" />');
		} else if ($(this).text() == 'Refuser') {
			let motif = $("#motif_rejet").val();
			$("#viewForm").append('<input type="hidden" name="motif" value="' + motif + '" />');
			$("#viewForm").append('<input type="hidden" name="action" value="refuser" />');
		} else if ($(this).text() == 'Approuver') {
			$("#viewForm").append('<input type="hidden" name="action" value="approuver" />');
		} else if ($(this).text() == 'Reouvrir') {
			let motif = $("#motif_reouvrir").val();
			$("#viewForm").append('<input type="hidden" name="motif" value="' + motif + '" />');
			$("#viewForm").append('<input type="hidden" name="action" value="reouvrir" />');
		}
		$("#viewForm").submit();
	});
	// cancel supprission
	$("#confirmationModal").on('click', ".cancel", function() {
		if ($("#confirmationModal .confirm").text() == 'Supprimer ligne') {
			$("#viewForm #deleteLine").remove();
		}
		$("#confirmationModal").css("display", "none");
		$("#overflow").css("display", "none");
		$('html, body').css({
			overflow: 'auto',
		});
	});
</script>