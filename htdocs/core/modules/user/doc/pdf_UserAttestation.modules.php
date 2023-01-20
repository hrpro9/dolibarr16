<?php
/* Copyright (C) 2010-2011  Juanjo Menent        <jmenent@2byte.es>
 * Copyright (C) 2010-2014  Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2015       Marcos García        <marcosgdf@gmail.com>
 * Copyright (C) 2018       Frédéric France      <frederic.france@netlogic.fr>
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
 * or see https://www.gnu.org/
 */

/**
 *	\file       htdocs/core/modules/supplier_invoice/doc/pdf_canelle.modules.php
 *	\ingroup    fournisseur
 *	\brief      Class file to generate the supplier invoices with the canelle model
 */

use Stripe\BankAccount;

require_once DOL_DOCUMENT_ROOT . '/core/modules/user/modules_user.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/company.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/pdf.lib.php';

require_once DOL_DOCUMENT_ROOT . '/societe/class/companybankaccount.class.php';
require_once DOL_DOCUMENT_ROOT . '/user/class/userbankaccount.class.php';


/**
 *	Class to generate the supplier invoices PDF with the template canelle
 */
class pdf_UserAttestation extends ModelePDFUser
{
	/**
	 * @var DoliDb Database handler
	 */
	public $db;

	/**
	 * @var string model name
	 */
	public $name;

	/**
	 * @var string model description (short text)
	 */
	public $description;

	/**
	 * @var int 	Save the name of generated file as the main doc when generating a doc with this template
	 */
	public $update_main_doc_field;

	/**
	 * @var string document type
	 */
	public $type;

	/**
	 * @var array Minimum version of PHP required by module.
	 * e.g.: PHP ≥ 5.5 = array(5, 5)
	 */
	public $phpmin = array(5, 5);

	/**
	 * Dolibarr version of the loaded document
	 * @var string
	 */
	public $version = 'dolibarr';

	/**
	 * @var int page_largeur
	 */
	public $page_largeur;

	/**
	 * @var int page_hauteur
	 */
	public $page_hauteur;

	/**
	 * @var array format
	 */
	public $format;

	/**
	 * @var int marge_gauche
	 */
	public $marge_gauche;

	/**
	 * @var int marge_droite
	 */
	public $marge_droite;

	/**
	 * @var int marge_haute
	 */
	public $marge_haute;

	/**
	 * @var int marge_basse
	 */
	public $marge_basse;

	/**
	 * Issuer
	 * @var Societe object that emits
	 */
	public $emetteur;


	/**
	 *	Constructor
	 *
	 *  @param	DoliDB		$db     	Database handler
	 */
	public function __construct($db)
	{
		global $conf, $langs, $mysoc;

		// Translations
		$langs->loadLangs(array("main", "bills"));

		$this->db = $db;
		$this->name = "Bulletin de Paie";
		$this->description = $langs->trans('SuppliersInvoiceModel');

		// Dimension page
		$this->type = 'pdf';
		$formatarray = pdf_getFormat();
		$this->page_largeur = $formatarray['width'];
		$this->page_hauteur = $formatarray['height'];
		$this->format = array($this->page_largeur, $this->page_hauteur);
		$this->marge_gauche = isset($conf->global->MAIN_PDF_MARGIN_LEFT) ? $conf->global->MAIN_PDF_MARGIN_LEFT : 10;
		$this->marge_droite = isset($conf->global->MAIN_PDF_MARGIN_RIGHT) ? $conf->global->MAIN_PDF_MARGIN_RIGHT : 10;
		$this->marge_haute = isset($conf->global->MAIN_PDF_MARGIN_TOP) ? $conf->global->MAIN_PDF_MARGIN_TOP : 10;
		$this->marge_basse = isset($conf->global->MAIN_PDF_MARGIN_BOTTOM) ? $conf->global->MAIN_PDF_MARGIN_BOTTOM : 10;

		$this->option_logo = 1; // Affiche logo
		$this->option_tva = 1; // Gere option tva FACTURE_TVAOPTION
		$this->option_modereg = 1; // Affiche mode reglement
		$this->option_condreg = 1; // Affiche conditions reglement
		$this->option_codeproduitservice = 1; // Affiche code produit-service
		$this->option_multilang = 1; // Dispo en plusieurs langues

		// Define column position
		$this->posxdesc = $this->marge_gauche + 1;
		$this->posxtva = 112;
		$this->posxup = 126;
		$this->posxqty = 145;
		$this->posxunit = 162;
		$this->posxdiscount = 162;
		$this->postotalht = 174;

		if ($conf->global->PRODUCT_USE_UNITS) {
			$this->posxtva = 99;
			$this->posxup = 114;
			$this->posxqty = 130;
			$this->posxunit = 147;
		}
		//if (! empty($conf->global->MAIN_GENERATE_DOCUMENTS_WITHOUT_VAT)) $this->posxtva=$this->posxup;
		$this->posxpicture = $this->posxtva - (empty($conf->global->MAIN_DOCUMENTS_WITH_PICTURE_WIDTH) ? 20 : $conf->global->MAIN_DOCUMENTS_WITH_PICTURE_WIDTH); // width of images
		if ($this->page_largeur < 210) // To work with US executive format
		{
			$this->posxpicture -= 20;
			$this->posxtva -= 20;
			$this->posxup -= 20;
			$this->posxqty -= 20;
			$this->posxunit -= 20;
			$this->posxdiscount -= 20;
			$this->postotalht -= 20;
		}

		$this->tva = array();
		$this->localtax1 = array();
		$this->localtax2 = array();
		$this->atleastoneratenotnull = 0;
		$this->atleastonediscount = 0;
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Function to build pdf onto disk
	 *
	 *  @param		FactureFournisseur	$object				Object to generate
	 *  @param		Translate			$outputlangs		Lang output object
	 *  @param		string				$srctemplatepath	Full path of source filename for generator using a template file
	 *  @param		int					$hidedetails		Do not show line details
	 *  @param		int					$hidedesc			Do not show desc
	 *  @param		int					$hideref			Do not show ref
	 *  @return		int										1=OK, 0=KO
	 */
	public function write_file($object, $outputlangs = '', $srctemplatepath = '', $hidedetails = 0, $hidedesc = 0, $hideref = 0)
	{
		// phpcs:enable
		global $db, $prev_month, $prev_year, $user, $langs, $conf, $mysoc, $hookmanager, $nblines, $cloture;

		error_log("work?");
		// Get source company
		$currency = !empty($currency) ? $currency : $conf->currency;
		if (!is_object($object->thirdparty)) $object->fetch_thirdparty();
		if (!is_object($object->thirdparty)) $object->thirdparty = $mysoc; // If fetch_thirdparty fails, object has no socid (specimen)
		$this->emetteur = $object->thirdparty;
		if (!$this->emetteur->country_code) $this->emetteur->country_code = substr($langs->defaultlang, -2); // By default, if was not defined

		if (!is_object($outputlangs)) $outputlangs = $langs;
		// For backward compatibility with FPDF, force output charset to ISO, because FPDF expect text to be encoded in ISO
		if (!empty($conf->global->MAIN_USE_FPDF)) $outputlangs->charset_output = 'ISO-8859-1';

		// Load translation files required by the page
		$outputlangs->loadLangs(array("main", "dict", "companies", "bills", "products"));


		if (1) {
			$object->fetch_thirdparty();

			//create table for saving attestations info
			$sql = "CREATE TABLE IF NOT EXISTS  " . MAIN_DB_PREFIX . "UserAttestation(`numero` int(4) AUTO_INCREMENT primary key, `matricule` varchar(20), `user` int, `date` datetime, `idUserCrée` int)";
			$res = $db->query($sql);
			if (!$res) {
				print "ERROR : can't create table llx_UserAttestation.";
				exit;
			}

			// Definition of $dir and $file
			if ($object->specimen) {
				$dir = $conf->user->dir_output;
				$file = $dir . "/SPECIMEN.pdf";
			} else {
				$objectref = dol_sanitizeFileName($object->ref);
				$objectrefsupplier = dol_sanitizeFileName($object->ref_supplier);
				$dir = $conf->user->dir_output;

				$file = $dir . "/" . $object->login . "_Attestation.pdf";
				if (!empty($conf->global->SUPPLIER_REF_IN_NAME)) $file = $dir . "/" . $objectref . ($objectrefsupplier ? "_" . $objectrefsupplier : "") . ".pdf";
			}

			if (!file_exists($dir)) {
				if (dol_mkdir($dir) < 0) {
					$this->error = $langs->transnoentities("ErrorCanNotCreateDir", $dir);
					return 0;
				}
			}

			if (file_exists($dir)) {
				// Add pdfgeneration hook
				if (!is_object($hookmanager)) {
					include_once DOL_DOCUMENT_ROOT . '/core/class/hookmanager.class.php';
					$hookmanager = new HookManager($this->db);
				}
				$hookmanager->initHooks(array('pdfgeneration'));
				$parameters = array('file' => $file, 'object' => $object, 'outputlangs' => $outputlangs);
				global $action;
				$reshook = $hookmanager->executeHooks('beforePDFCreation', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks

				// Create pdf instance
				$pdf = pdf_getInstance($this->format);
				$default_font_size = pdf_getPDFFontSize($outputlangs); // Must be after pdf_getInstance
				$pdf->SetAutoPageBreak(1, 0);

				$heightforinfotot = 50 + (4 * $nbpayments); // Height reserved to output the info and total part and payment part
				$heightforfreetext = (isset($conf->global->MAIN_PDF_FREETEXT_HEIGHT) ? $conf->global->MAIN_PDF_FREETEXT_HEIGHT : 5); // Height reserved to output the free text on last page
				$heightforfooter = $this->marge_basse + 8; // Height reserved to output the footer (value include bottom margin)
				if ($conf->global->MAIN_GENERATE_DOCUMENTS_SHOW_FOOT_DETAILS > 0) $heightforfooter += 6;

				if (class_exists('TCPDF')) {
					$pdf->setPrintHeader(false);
					$pdf->setPrintFooter(false);
				}
				$pdf->SetFont(pdf_getPDFFont($outputlangs));
				// Set path to the background PDF File
				if (!empty($conf->global->MAIN_ADD_PDF_BACKGROUND)) {
					$pagecount = $pdf->setSourceFile($conf->mycompany->multidir_output[$object->entity] . '/' . $conf->global->MAIN_ADD_PDF_BACKGROUND);
					$tplidx = $pdf->importPage(1);
				}

				$pdf->Open();
				$pagenb = 0;
				$pdf->SetDrawColor(128, 128, 128);

				$pdf->SetTitle($outputlangs->convToOutputCharset($object->ref));
				$pdf->SetSubject($outputlangs->transnoentities("PdfInvoiceTitle"));
				$pdf->SetCreator("Dolibarr " . DOL_VERSION);
				$pdf->SetAuthor($outputlangs->convToOutputCharset($user->getFullName($outputlangs)));
				$pdf->SetKeyWords($outputlangs->convToOutputCharset($object->ref) . " " . $outputlangs->transnoentities("PdfInvoiceTitle") . " " . $outputlangs->convToOutputCharset($object->thirdparty->name));
				if (!empty($conf->global->MAIN_DISABLE_PDF_COMPRESSION)) $pdf->SetCompression(false);

				$pdf->SetMargins($this->marge_gauche, $this->marge_haute, $this->marge_droite); // Left, Top, Right

				// Set $this->atleastonediscount if you have at least one discount
				for ($i = 0; $i < $nblines; $i++) {
					if ($object->lines[$i]->remise_percent) {
						$this->atleastonediscount++;
					}
				}
				if (empty($this->atleastonediscount)) {
					$delta = ($this->postotalht - $this->posxdiscount);
					$this->posxpicture += $delta;
					$this->posxtva += $delta;
					$this->posxup += $delta;
					$this->posxqty += $delta;
					$this->posxunit += $delta;
					$this->posxdiscount += $delta;
					// post of fields after are not modified, stay at same position
				}

				//Get All Info
				$sql = "SELECT status, cin, matricule, rolec FROM llx_user_extrafields WHERE fk_object = $object->id";
				$res = $db->query($sql);
				if ($res->num_rows > 0) {
					$extra = $res->fetch_assoc();
					$stat = (($extra["status"] == '2') ? "STAGE" : ($extra["status"] == '4')) ? "STAGE" : "TRAVAIL";
					$stats = (($extra["status"] == '2') ? "STAGE" : ($extra["status"] == '4')) ? "Stage non rémunéré" : "TRAVAIL";
				}

				$sql = "SELECT param FROM llx_extrafields WHERE name = 'rolec'";
				$res = $db->query($sql);
				if ($res->num_rows > 0) {
					$options = $res->fetch_assoc()['param'];
					$poste = unserialize($options)['options'][$extra["rolec"]];
				}

				$sql = "SELECT cnss from llx_Paie_UserInfo WHERE userid=$object->id";
				$res = $db->query($sql);
				if ($res->num_rows > 0) {
					$cnss = $res->fetch_assoc()['cnss'];
				}

				$sql = "INSERT INTO llx_UserAttestation(`matricule`, `user`, `date`, `idUserCrée`) VALUES('" . $extra["matricule"] . "', $object->id, '" . date("Y-m-d h:i") . "', $user->id)";
				$res = $db->query($sql);
				if (!$res) {
					print "ERROR : can't insert info to llx_UserAttestation.";
					print $sql;
					exit;
				}

				$sql = "SELECT numero from llx_UserAttestation ORDER BY numero DESC LIMIT 1;";
				$res = $db->query($sql);
				if ($res->num_rows > 0) {
					$numero = $res->fetch_assoc()['numero'];
				}
				//

				// New page
				$pdf->AddPage();
				if (!empty($tplidx)) $pdf->useTemplate($tplidx);
				$pagenb++;
				$top_shift = $this->_pagehead($pdf, $object, 1, $outputlangs, $totalNet, $periode, $numero);
				$tab_top = 90 + $top_shift;

				$pdf->SetY($pdf->GetY() + 15);
				$pdf->SetX(10);
				$pdf->SetTextColor(0, 0, 0);
				$pdf->SetFont('', 'b', 25);
				$pdf->MultiCell(0, 3, ''); // Set interline to 3
				$pdf->SetTextColor(0, 0, 0);
				// $tab_top = 90 + $top_shift;
				// $tab_top_newpage = (empty($conf->global->MAIN_PDF_DONOTREPEAT_HEAD) ? 42 + $top_shift : 10);

				// body

				if ($object->dateemploymentend > 0 && $object->dateemploymentend < strtotime(date("Y-m-d"))) {
					$title = "CERTIFICATE";
					$dateFin = " à <b>" . date("d/m/Y", $object->dateemploymentend) . "</b>";
				} else {
					$title = "ATTESTATION";
					$dateFin = "à ce jour";
				}

				$pdf->MultiCell(200, 1, $title . " DE " . $stat, 0, "C");
				$pdf->SetFont('', '', $default_font_size + 3);

				$pdf->SetFont('', '', $default_font_size - 1);

				$pdf->SetX($curX + 20);
				$pdf->SetFont('', '', $default_font_size + 5);

				$french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');

				$dateFin = ($object->dateemploymentend > 0 && $object->dateemploymentend < strtotime(date("Y-m-d"))) ? " à <b>" . date("d/m/Y", $object->dateemploymentend) . "</b>" : "à ce jour";

				$pdf->writeHTMLCell(
					180,
					30,
					$this->posxdesc + 3,
					$pdf->GetY() + 15,
					'<p style="font-family: Georgia, serif; padding-right: 150px; line-height: 200%;">
					&nbsp; &nbsp; &nbsp; Nous soussignée, société <b>I-Gouvernancia</b> par la présente que ' . (($object->gender == "man") ? "Mr " : "Mme ") . '<b>' . $object->lastname . " " . $object->firstname . '</b> sous le matricule <b>'
						. $extra["matricule"] . '</b> <span style="text-decoration: underline;">' . (($object->gender == "man") ? "né" : "neé") . ' ' . date("d/m/Y", $object->birth) . '</span>, de nationalité marocaine, titulaire de CIN ' . $extra["cin"] . ', '
						. (($cnss) ? "Affilé" . (($object->gender == "man") ? "" : "e") . " à la CNSS dont le <b>N° $cnss</b>, " : "") . 'Attestons qu\'' . (($object->gender == "man") ? "il" : "elle") . ' a effectué un ' . $stats . ' <b>&lt;&lt;Poste de ' . $poste . '&gt;&gt;</b> à partir de <b>'
						. date("d/m/Y", $object->dateemployment) . '</b> ' . $dateFin . '.</p>
					<br/><br/>'
						. '<p style="font-family: Georgia, serif; line-height: 1.6;">Cette Attestation est délivrée pour servir et valoir ce que de droit.</p>'
						. '<p style="font-family: Georgia, serif; text-align:right; line-height: 1.6;">Fait à Casablanca, le <b>' . date("d") . " " . $french_months[(int)date("m") - 1] . " " . date("Y") . '</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p><br/>'
						. '<p style="font-family: Georgia, serif; text-align:right; line-height: 1.6;"><b>DIRECTEUR Géneral :</b><br/> 
							Tahir Choaib &nbsp; &nbsp; &nbsp;</p>'
				);


				//CODE QR
				// set style for CODEQR
				$style = array(
					'border' => 1,
					'vpadding' => 'auto',
					'hpadding' => 'auto',
					'fgcolor' => array(0, 0, 0),
					'bgcolor' => false, //array(255,255,255)
					'module_width' => 1, // width of a single module in points
					'module_height' => 1 // height of a single module in points
				);

				$info = "Cree par: " . $user->firstname . " " . $user->lastname . ". date: " . date("d/m/Y") . ". Matricule: " . $extra["matricule"] . ". Nom et prenom: " . $object->lastname . " " . $object->firstname;

				// QRCODE,L : QR-CODE Low error correction
				$pdf->write2DBarcode($info, 'QRCODE,L', 150, $pdf->GetY() + 140, 40, 40, $style, 'N');




				// Pagefoot
				$this->_pagefoot($pdf, $object, $outputlangs);
				if (method_exists($pdf, 'AliasNbPages')) $pdf->AliasNbPages();

				$pdf->Close();

				$pdf->Output($file, 'F');

				// Add pdfgeneration hook
				$hookmanager->initHooks(array('pdfgeneration'));
				$parameters = array('file' => $file, 'object' => $object, 'outputlangs' => $outputlangs);
				global $action;
				$reshook = $hookmanager->executeHooks('afterPDFCreation', $parameters, $this, $action); // Note that $action and $object may have been modified by some hooks
				if ($reshook < 0) {
					$this->error = $hookmanager->error;
					$this->errors = $hookmanager->errors;
				}

				if (!empty($conf->global->MAIN_UMASK))
					@chmod($file, octdec($conf->global->MAIN_UMASK));

				$this->result = array('fullpath' => $file);

				//Cloturé le moi
				$sql = "UPDATE llx_Paie_MonthDeclaration SET cloture=1 WHERE userid=$object->id AND year=$prev_year AND month=$prev_month;";
				$res = $db->query($sql);
				if ($res);
				else print("<br>fail ERR: " . $sql);

				return 1; // No error
			} else {
				$this->error = $langs->transnoentities("ErrorCanNotCreateDir", $dir);
				return 0;
			}
		} else {
			$this->error = $langs->transnoentities("ErrorConstantNotDefined", "SUPPLIER_OUTPUTDIR");
			return 0;
		}
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.PublicUnderscore
	/**
	 *  Show top header of page.
	 *
	 *  @param  PDF                 $pdf            Object PDF
	 *  @param  FactureFournisseur  $object         Object to show
	 *  @param  int                 $showaddress    0=no, 1=yes
	 *  @param  Translate           $outputlangs    Object lang for output
	 *  @return void
	 */
	protected function _pagehead(&$pdf, $object, $showaddress, $outputlangs, $totalNet, $periode, $numero)
	{
		global $langs, $conf, $mysoc, $prev_month, $prev_year, $db;

		//get date
		$dateg = $_SESSION['dateg'];
		//set date of salary
		$date = date("M Y", strtotime(date("d") . '-' . $dateg));

		// Load translation files required by the page
		$outputlangs->loadLangs(array("main", "orders", "companies", "bills"));

		$default_font_size = pdf_getPDFFontSize($outputlangs);

		// Do not add the BACKGROUND as this is for suppliers
		//pdf_pagehead($pdf,$outputlangs,$this->page_hauteur);

		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFont('', 'B', $default_font_size + 3);

		$posy = $this->marge_haute;
		$posx = $this->page_largeur - $this->marge_droite - 100;

		$pdf->SetXY($this->marge_gauche, $posy);

		// Logo
		$logo = $conf->mycompany->dir_output . '/logos/' . $mysoc->logo;
		if ($mysoc->logo) {
			if (is_readable($logo)) {
				$height = pdf_getHeightForLogo($logo);
				$pdf->Image($logo, $this->marge_gauche, $posy, 70, 0);	// width=0 (auto)
			} else {
				$pdf->SetTextColor(200, 0, 0);
				$pdf->SetFont('', 'B', $default_font_size - 2);
				$pdf->MultiCell(100, 3, $outputlangs->transnoentities("ErrorLogoFileNotFound", $logo), 0, 'L');
				$pdf->MultiCell(100, 3, $outputlangs->transnoentities("ErrorGoToModuleSetup"), 0, 'L');
			}
		} else {
			$text = $this->emetteur->name;
			$pdf->MultiCell(100, 4, $outputlangs->convToOutputCharset($text), 0, 'L');
		}

		$posy += 10;

		$pdf->SetFont('', 'B', $default_font_size + 3);


		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$posy += 1;

		//set Number of attestation 
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->MultiCell(100, 4, "IG/ATTS/" . sprintf("%'.03d", $numero), '', 'R');

		$posy += 1;
		$pdf->SetTextColor(0, 0, 60);

		$top_shift = 0;
		// Show list of linked objects
		$current_y = $pdf->getY();
		$posy = pdf_writeLinkedObjects($pdf, $object, $outputlangs, $posx, $posy, 100, 3, 'R', $default_font_size);
		if ($current_y < $pdf->getY()) {
			$top_shift = $pdf->getY() - $current_y;
		}

		return $top_shift;
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.PublicUnderscore
	/**
	 *  Show footer of page. Need this->emetteur object
	 *
	 *  @param  PDF                 $pdf                PDF
	 *  @param  FactureFournisseur  $object             Object to show
	 *  @param  Translate           $outputlangs        Object lang for output
	 *  @param  int                 $hidefreetext       1=Hide free text
	 *  @return int                                     Return height of bottom margin including footer text
	 */
	protected function _pagefoot(&$pdf, $object, $outputlangs, $hidefreetext = 0)
	{
		global $conf;
		$showdetails = $conf->global->MAIN_GENERATE_DOCUMENTS_SHOW_FOOT_DETAILS;
		return pdf_pagefoot($pdf, $outputlangs, 'SUPPLIER_INVOICE_FREE_TEXT', $this->emetteur, $this->marge_basse, $this->marge_gauche, $this->page_hauteur, $object, $showdetails, $hidefreetext);
	}
}
