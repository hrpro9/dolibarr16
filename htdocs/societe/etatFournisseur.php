<?php
/* Copyright (C) 2001-2007  Rodolphe Quiedeville    <rodolphe@quiedeville.org>
 * Copyright (C) 2003       Brian Fraval            <brian@fraval.org>
 * Copyright (C) 2004-2015  Laurent Destailleur     <eldy@users.sourceforge.net>
 * Copyright (C) 2005       Eric Seigne             <eric.seigne@ryxeo.com>
 * Copyright (C) 2005-2017  Regis Houssin           <regis.houssin@inodbox.com>
 * Copyright (C) 2008       Patrick Raguin          <patrick.raguin@auguria.net>
 * Copyright (C) 2010-2020  Juanjo Menent           <jmenent@2byte.es>
 * Copyright (C) 2011-2013  Alexandre Spangaro      <aspangaro@open-dsi.fr>
 * Copyright (C) 2015       Jean-François Ferry     <jfefe@aternatik.fr>
 * Copyright (C) 2015       Marcos García           <marcosgdf@gmail.com>
 * Copyright (C) 2015       Raphaël Doursenaud      <rdoursenaud@gpcsolutions.fr>
 * Copyright (C) 2018       Nicolas ZABOURI	        <info@inovea-conseil.com>
 * Copyright (C) 2018       Ferran Marcet		    <fmarcet@2byte.es.com>
 * Copyright (C) 2018       Frédéric France         <frederic.france@netlogic.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 *  \file       htdocs/societe/card.php
 *  \ingroup    societe
 *  \brief      Third party card page
 */

require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/societe/class/societe.class.php';
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



$action = GETPOST('action', 'alpha');
$fournisseur = GETPOST('fournisseur', 'alpha');
$product = GETPOST('product', 'alpha');


if ($action == "download")
{
    $infos = array('La date', 'Quantity', 'Prix');
    $header = array('Fournisseur :', explode(':', $fournisseur)[1], 'Produit :', explode(':', $product)[1]);
    $spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
    $fileName = 'produit livré.xlsx';
	for ($i = 0, $l = count($infos); $i < $l; $i++) {
		$sheet->setCellValueByColumnAndRow($i + 1, 2, $infos[$i]);
	}
	for ($i = 0, $l = count($header); $i < $l; $i++) {
		$sheet->setCellValueByColumnAndRow($i + 1, 1, $header[$i]);
	}

    $lines = array();
    $sql = "select cfd.qty, cfd.total_ttc, cf.date_commande from IG_commande_fournisseurdet as cfd INNER JOIN IG_commande_fournisseur as cf ON cf.rowid=cfd.fk_commande where cfd.fk_product =".explode(':', $product)[0]." and cfd.product_type = 0 and cfd.fk_commande in (SELECT rowid FROM `IG_commande_fournisseur` WHERE fk_soc = ".explode(':', $fournisseur)[0]." and fk_statut = 5)
    ";
    $resql = $db->query($sql);
    if ($resql)
    {
        $j = 3;
        while ($obj = $db->fetch_object($resql))
        {
            $sheet->setCellValueByColumnAndRow(1, $j, $obj->date_commande);
            $sheet->setCellValueByColumnAndRow(2, $j, $obj->qty);
            $sheet->setCellValueByColumnAndRow(3, $j, $obj->total_ttc . ' MAD');
            $j++;
        }
    }

    setlocale(LC_ALL, 'en_US');
	$writer = new Xlsx($spreadsheet);
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
	$writer->save('php://output');
	exit();

}



llxHeader('', 'Etat Fournisseurs');
print load_fiche_titre($langs->trans("Etat fournisseur"), '', 'building');
$fournisseurs = array();
$products = array();
$sql = "SELECT rowid, nom as name FROM ".MAIN_DB_PREFIX."societe as s WHERE fournisseur =1";
$resql = $db->query($sql);
if ($resql)
{
	while ($obj = $db->fetch_object($resql))
	{
		// Compute level text
		$fournisseurs[$obj->rowid] = $obj->name;
	}
}

$sql = 'SELECT DISTINCT rowid, ref';
$sql .= ' FROM '.MAIN_DB_PREFIX.'product where fk_product_type = 0';

$resql = $db->query($sql);
if ($resql)
{
	while ($obj = $db->fetch_object($resql))
	{
		// Compute level text
		$products[$obj->rowid] = $obj->ref;
	}
}

print '
    <form method="POST" action="'.$_SERVER["PHP_SELF"].'" name="formfilter" autocomplete="off">
        <input type="hidden" name="token" value="'.newToken().'">
        <input type="hidden" name="action" value="download">
        <div>
            <div class="frContainer">
                <label>Fournisseur : </label>
                <select name="fournisseur">';
                    print "<option value=''></option>";
                    foreach ($fournisseurs as $key => $value) {
                        print "<option value='$key:$value'>$value</option>";
                    }
print "         </select>";
print '
            </div>
            <div class="prdContainer">
                <label>Produit : </label>
                <select name="product">';
                print "<option value=''></option>";
                    foreach ($products as $key => $value) {
                        print "<option value='$key:$value'>$value</option>";
                    }

print "
                </select>
            </div>
        </div>
        <div class='btnContainer'>
            <button type='submit'>Telecharger</button>
        </div>";
print "
    <style>
        .frContainer, .prdContainer{
            display: flex;
            align-items: end;
        }
        .frContainer label, .prdContainer label{
            font-size: 18px;
            font-weight: 500;
            margin-right: 17px;
        }
        .btnContainer button{
            margin-top: 10px;
            font-family: roboto,arial,tahoma,verdana,helvetica;
            padding: 8px 15px;
            cursor: pointer;
            background-color: #56a928;
            background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
            background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
            border: none;
            border-radius: 3px;
            font-weight: bold;
            text-transform: uppercase;
            color: #444;
        }

    </style>";

// End of page
llxFooter();
$db->close();
