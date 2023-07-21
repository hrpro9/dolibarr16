<?php


$content = '

<?php
require_once DOL_DOCUMENT_ROOT . \'/core/modules/user/modules_user.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/company.lib.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/functions2.lib.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/pdf.lib.php\';

require_once DOL_DOCUMENT_ROOT . \'/societe/class/companybankaccount.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/user/class/userbankaccount.class.php\'; 


require_once DOL_DOCUMENT_ROOT . \'/core/class/html.formfile.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/class/html.formorder.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/class/html.formmargin.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/modules/commande/modules_commande.php\';
require_once DOL_DOCUMENT_ROOT . \'/commande/class/commande.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/comm/action/class/actioncomm.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/order.lib.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/functions2.lib.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/class/extrafields.class.php\';


/**
 *	Class to generate the supplier invoices PDF with the template canelle
 */
class pdf_Cheque extends ModelePDFUser
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
	public $version = \'dolibarr\';

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
		$this->name = "OrderDeVirementGlobal";
		$this->description = $langs->trans(\'SuppliersInvoiceModel\');

		
		// Dimension page
		$this->type = \'pdf\';
		$this->page_largeur = 175; // Largeur en millimètres pour le format Cheque
		$this->page_hauteur = 88; // Hauteur en millimètres pour le format Cheque
		$this->format = array($this->page_largeur, $this->page_hauteur);
		$this->marge_gauche = 10;
		$this->marge_droite = 10;
		$this->marge_haute = 10;
		$this->marge_basse = 10;

		$this->option_logo = 1; // Affiche logo
		$this->option_tva = 1; // Gere option tva FACTURE_TVAOPTION
		$this->option_modereg = 1; // Affiche mode reglement
		$this->option_condreg = 1; // Affiche conditions reglement
		$this->option_codeproduitservice = 1; // Affiche code produit-service
		$this->option_multilang = 1; // Dispo en plusieurs langues

		// Define column position
		$this->posxdesc = $this->marge_gauche + 1;
		$this->posxtva = 30;
		$this->posxup = 50;
		$this->posxqty = 70;
		$this->posxunit = 90;
		$this->posxdiscount = 110;
		$this->postotalht = 130;

		if (isset($conf->global) && isset($conf->global->PRODUCT_USE_UNITS) && $conf->global->PRODUCT_USE_UNITS) {
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

	
	public function write_file($object, $outputlangs = \'\', $srctemplatepath = \'\', $hidedetails = 0, $hidedesc = 0, $hideref = 0, $moreparams)
	{
		// phpcs:enable
		global $object, $user, $langs, $conf, $mysoc, $hookmanager, $nblines, $action, $prev_month, $prev_year, $periode, $year, $db, $amoSalariale, $amoPatronale;
		error_log("work?");

		if (!is_object($outputlangs)) $outputlangs = $langs;
		// For backward compatibility with FPDF, force output charset to ISO, because FPDF expect text to be encoded in ISO
		if (!empty($conf->global->MAIN_USE_FPDF)) $outputlangs->charset_output = \'ISO-8859-1\';

		// Load translation files required by the page
		$outputlangs->loadLangs(array("main", "dict", "companies", "bills", "products"));

		if (true) {
			// $name = sprintf("%02d", $prev_month) . "-$prev_year";
		

			// Definition of $dir and $file
			if ($object->specimen) {
				$dir = $conf->fournisseur->facture->dir_output;
				$file = $dir . "/SPECIMEN.pdf";
			} else {    
				$objectref = dol_sanitizeFileName($object->ref);
				$objectrefsupplier = isset($object->ref_supplier) ? dol_sanitizeFileName($object->ref_supplier) : \'\';
			
			
				
				// $dir = DOL_DATA_ROOT . \'/commande/dispatch/\';
				$id = (GETPOST(\'id\'));
				$facturePaie = GETPOST(\'facturePaie\');
				
				 $dir = DOL_DATA_ROOT . \'/facture/reglement/reglement-\'.$id.\'/\';
				
				 $n="R" .$id."-"."F".$facturePaie."-".date("ymd");
				 $file = $dir .$n.".pdf";

				// $file = $dir . "/Passif.pdf";
				if (!empty($conf->global->SUPPLIER_REF_IN_NAME)) $file = $dir . "/" . $objectref . ($objectrefsupplier ? "_" . $objectrefsupplier : "") . ".pdf";
			}

			if (!file_exists($dir)) {
				if (dol_mkdir($dir) < 0) {
					$this->error = $langs->transnoentities("ErrorCanNotCreateDir", $dir);
					return 0;
				}
			}

			

			if (file_exists($dir)) {

				// Create pdf instance
				$pdf = pdf_getInstance($this->format);
				$default_font_size = pdf_getPDFFontSize($outputlangs); // Must be after pdf_getInstance
				$pdf->SetAutoPageBreak(1, 0);

				$heightforfooter = $this->marge_basse + 8; // Height reserved to output the footer (value include bottom margin)
				if ($conf->global->MAIN_GENERATE_DOCUMENTS_SHOW_FOOT_DETAILS > 0) $heightforfooter += 6;

				if (class_exists(\'TCPDF\')) {
					$pdf->setPrintHeader(false);
					$pdf->setPrintFooter(false);
				}

			


				$pdf->SetFont(pdf_getPDFFont($outputlangs));

				if (!is_object($object->thirdparty)) $object->fetch_thirdparty();
				if (!is_object($object->thirdparty)) $object->thirdparty = $mysoc; // If fetch_thirdparty fails, object has no socid (specimen)
				$this->emetteur = $object->thirdparty;
				if (!$this->emetteur->country_code) $this->emetteur->country_code = substr($langs->defaultlang, -2); // By default, if was not defined



			

				

				$pdf->Open();
				$pagenb = 0;
				$pdf->SetDrawColor(128, 128, 128);

				$pdf->SetTitle($outputlangs->convToOutputCharset(\'Cheque\'));
				$pdf->SetSubject($outputlangs->transnoentities("EtatAMO"));
				$pdf->SetCreator("Dolibarr " . DOL_VERSION);
				$pdf->SetAuthor($outputlangs->convToOutputCharset($user->getFullName($outputlangs)));
				if (!empty($conf->global->MAIN_DISABLE_PDF_COMPRESSION)) $pdf->SetCompression(false);

				$pdf->SetMargins($this->marge_gauche, $this->marge_haute, $this->marge_droite); // Left, Top, Right
				// New page
				$pdf->AddPage(\'L\');
				$x = 0; // Position horizontale de l\'image
				$y = 0; // Position verticale de l\'image
				$w = 570; // Largeur de l\'image
				$h = 252; 
				$type = \'JPEG\';	
				$fileimage = DOL_DATA_ROOT . \'/images/cheque.jpg\';
				$pdf->Image($fileimage, $x , $y , $w , $h, $type );

				if (!empty($tplidx)) $pdf->useTemplate($tplidx);
				$pagenb++;
				$totalNet = 0;
				$top = $this->_pagehead($pdf, $object, 1, $outputlangs, $totalNet, $periode);
				$pdf->SetY($pdf->GetY() + 10);
				$pdf->SetTextColor(0, 0, 0);

				


				$tab_top = 90;
				$tab_top_newpage = (empty($conf->global->MAIN_PDF_DONOTREPEAT_HEAD) ? 42 : 10);
		
				// body

			

				
				
				// \'
				 // Replace with your actual table HTML
				
				$pdf->SetFont(\'\', \'\', $default_font_size);
				$pdf->SetY($pdf->GetY() + 6);
				$pdf->SetX($this->posxdesc + 6);
				// $pdf->writeHTML($table);

				// Pagefoot
				$this->_pagefoot($pdf, $object, $outputlangs);
				if (method_exists($pdf, \'AliasNbPages\')) $pdf->AliasNbPages();

				$pdf->Close();



				$pdf->Output($file, \'F\');

				// Add pdfgeneration hook
				$hookmanager->initHooks(array(\'pdfgeneration\'));
				$parameters = array(\'file\' => $file, \'object\' => $object, \'outputlangs\' => $outputlangs);
				global $action;
				$reshook = $hookmanager->executeHooks(\'afterPDFCreation\', $parameters, $this, $action); // Note that $action and $object may have been modified by some hooks
				if ($reshook < 0) {
					$this->error = $hookmanager->error;
					$this->errors = $hookmanager->errors;
				}

				if (!empty($conf->global->MAIN_UMASK))
					@chmod($file, octdec($conf->global->MAIN_UMASK));

				$this->result = array(\'fullpath\' => $file);

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
	protected function _pagehead(&$pdf, $object, $showaddress, $outputlangs, $totalNet, $periode)
	{
		global $langs, $conf, $mysoc, $prev_month, $prev_year,$db;


		// Load translation files required by the page
		$outputlangs->loadLangs(array("main", "orders", "companies", "bills"));

		$default_font_size = pdf_getPDFFontSize($outputlangs);

		// Do not add the BACKGROUND as this is for suppliers
		//pdf_pagehead($pdf,$outputlangs,$this->page_hauteur);

		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFont(\'\', \'B\', $default_font_size + 3);

		$posy = $this->marge_haute;
		$posx = $this->page_largeur - $this->marge_droite - 100;

		$pdf->SetXY($this->marge_gauche, $posy);


		// set style for barcode
			$style = array(
				\'border\' => 2,
				\'vpadding\' => \'auto\',
				\'hpadding\' => \'auto\',
				\'fgcolor\' => array(0, 0, 0),
				\'bgcolor\' => false, //array(255,255,255)
				\'module_width\' => 1, // width of a single module in points
				\'module_height\' => 1 // height of a single module in points
			);
			$w = 100;

		// $info = "Nom: " . $object->firstname . " " . $object->lastname . ". Periode: " . $periode . ". Salaire Net: " . price($totalNet, 0);

		// // // QRCODE,L : QR-CODE Low error correction
		// $pdf->write2DBarcode($info, \'QRCODE,L\', 160, 6, 30, 30, $style, \'N\');


		//price
		$amount = GETPOST(\'amount\');
		$amount = floatval(str_replace(\',\', \'.\', $amount)); // Convertir la valeur en nombre flottant

		$posx += -5;
		$posy += -3;

		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(11);

		$pdf->MultiCell($w, \'\',  \'#\'.number_format($amount, 2, \',\', \' \').\'#\', \'\', \'R\');

		// Fonction pour convertir un nombre en mots
		function numberToWords($number) {
			$numberFormatter = new NumberFormatter(\'fr\', NumberFormatter::SPELLOUT);
			return $numberFormatter->format($number);
		}

		$numberInWords = numberToWords(floor($amount)); // Utiliser la partie entière du montant
		$decimalPart = $amount - floor($amount); // Utiliser la partie décimale du montant

		$numberInWords = mb_convert_case($numberInWords, MB_CASE_TITLE, \'UTF-8\'); // Mettre la première lettre en majuscule

		// Remplacer les chiffres par des lettres spécifiques en français
		$numberInWords = str_replace(
			array(\'Vingt-Dix\', \'Vingt-Un\'),
			array(\'Vingt et Dix\', \'Vingt et Un\'),
			$numberInWords
		);

		if ($decimalPart > 0) {
			$numberInWords .= \' Dinars et \';

			// Utiliser les premiers deux chiffres après la virgule
			$decimalPart = floor($decimalPart * 100);

			$decimalNumberInWords = numberToWords($decimalPart);
			$decimalNumberInWords = mb_convert_case($decimalNumberInWords, MB_CASE_TITLE, \'UTF-8\'); // Mettre la première lettre en majuscule
			$decimalNumberInWords = str_replace(\'Un\', \'Un Centime\', $decimalNumberInWords);
			$decimalNumberInWords = str_replace(\'Deux\', \'Deux Centimes\', $decimalNumberInWords);

			$numberInWords .= $decimalNumberInWords;
		}

		$pdf->SetFont(\'\', \'B\', $default_font_size);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY($this->marge_gauche + 5, $posy + 10);
		$pdf->MultiCell(170, 7, $numberInWords, 0, \'L\', 1);

		$pdf->SetFillColor(192, 192, 192);
		$pdf->SetTextColor(0, 0, 0);

		// // // display logo
		$this->show_logo($pdf, $outputlangs);

		return $posy + 30;
	}

	protected function _pagefoot(&$pdf, $object, $outputlangs)
	{
		global $conf, $user, $db;

		$pdf->SetFont(\'\', \'\', 7);

		$pdf->SetY($this->page_hauteur - $this->marge_basse + 4);

		$pdf->SetXY($this->marge_gauche, $this->page_hauteur - $this->marge_basse);
		$pdf->SetFont(\'\', \'B\', 7);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(0, 6, $object->getRef(), 0, 1, \'C\');

		$pdf->SetFont(\'\', \'\', 5);
		$pdf->SetXY($this->marge_gauche, $this->page_hauteur - $this->marge_basse + 8);
		$pdf->MultiCell(0, 3, $outputlangs->convToOutputCharset($object->libelle), 0, \'C\');

		$w = $this->page_largeur - ($this->marge_droite + $this->marge_gauche);
		$pdf->SetFont(\'\', \'\', 7);
		$pdf->SetXY($this->marge_gauche, $this->page_hauteur - $this->marge_basse + 14);
		$pdf->MultiCell($w, 3, dol_print_date($db->jdate($object->datec), \'day\', $user), 0, \'C\');
		$pdf->SetXY($this->marge_gauche, $this->page_hauteur - $this->marge_basse + 18);
		$pdf->MultiCell($w, 3, $outputlangs->convToOutputCharset($object->getUserAuthor($db)), 0, \'C\');
		$pdf->SetXY($this->marge_gauche, $this->page_hauteur - $this->marge_basse + 22);
		$pdf->MultiCell($w, 3, dol_print_date($db->jdate($object->datem), \'day\', $user), 0, \'C\');
		$pdf->SetXY($this->marge_gauche, $this->page_hauteur - $this->marge_basse + 26);
		$pdf->MultiCell($w, 3, $outputlangs->convToOutputCharset($object->getUserModif($db)), 0, \'C\');

		if (is_array($this->emetteur->array_options) && !empty($this->emetteur->array_options[\'options_signature\']) && is_file(DOL_DATA_ROOT . \'/socpeople/\' . $this->emetteur->id . \'/\' . $this->emetteur->array_options[\'options_signature\'])) {
			$pdf->Image(DOL_DATA_ROOT . \'/socpeople/\' . $this->emetteur->id . \'/\' . $this->emetteur->array_options[\'options_signature\'], $this->page_largeur - $this->marge_droite - 25, $this->page_hauteur - $this->marge_basse - 15, 20, 0, \'\', \'http://\' . $_SERVER[\'HTTP_HOST\'] . DOL_MAIN_FILE_ROOT . \'/comm/socpeople/\' . $this->emetteur->id . \'/\' . $this->emetteur->array_options[\'options_signature\']);
		}
	}

	protected function show_logo(&$pdf, $outputlangs)
	{
		global $conf, $user, $db, $mysoc, $dol_print;
		$pdf->SetXY($this->marge_gauche + 5, $this->marge_haute + 5);
		$height = $this->posxdesc - $this->posxpicture + 5;
		if ($height < 20) {
			// Show with height=20
			$height = 20;
			$width = $height * 1.618;
		} else {
			$width = $height * 1.618;
		}
		if ($this->option_logo) {
			$logo = null;
			$logo = dol_syslogo($mysoc->id, 0, 0, $dol_print);
			if ($logo !== false) {
				if (!empty($logo)) {
					$type = substr(strtolower(pathinfo($logo, PATHINFO_EXTENSION)), 0, 3);
					$type = $type === \'jp\' ? \'jpg\' : $type;
					$pdf->Image($logo, $this->marge_gauche + 5, $this->marge_haute + 5, $width, $height, $type);
				}
			}
		}
	}
}
			';


?>