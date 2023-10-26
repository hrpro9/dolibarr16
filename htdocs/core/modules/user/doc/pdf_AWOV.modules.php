
<?php


require_once DOL_DOCUMENT_ROOT . '/core/modules/user/modules_user.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/company.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/pdf.lib.php';

require_once DOL_DOCUMENT_ROOT . '/societe/class/companybankaccount.class.php';
require_once DOL_DOCUMENT_ROOT . '/user/class/userbankaccount.class.php'; 




class pdf_AWOV extends ModelePDFUser
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
		$this->name = "OrderDeVirementGlobal";
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
	public function write_file($object, $outputlangs = "", $srctemplatepath = "", $hidedetails = 0, $hidedesc = 0, $hideref = 0, $moreparams)
	{
		// phpcs:enable
		global $object, $user, $langs, $conf, $mysoc, $hookmanager, $nblines, $action, $prev_month, $prev_year, $periode, $year, $db, $amoSalariale, $amoPatronale;
		error_log("work?");

		if (!is_object($outputlangs)) $outputlangs = $langs;
		// For backward compatibility with FPDF, force output charset to ISO, because FPDF expect text to be encoded in ISO
		if (!empty($conf->global->MAIN_USE_FPDF)) $outputlangs->charset_output = 'ISO-8859-1';

		// Load translation files required by the page
		$outputlangs->loadLangs(array("main", "dict", "companies", "bills", "products"));

		if (true) {
			$name = sprintf("%02d", $prev_month) . "-$prev_year";

			// Definition of $dir and $file
			if ($object->specimen) {
				//$dir = $conf->fournisseur->facture->dir_output;
				//$file = $dir . "/SPECIMEN.pdf";
			} else {
				$objectref = dol_sanitizeFileName($object->ref);
				$objectrefsupplier = isset($object->ref_supplier) ? dol_sanitizeFileName($object->ref_supplier) : '';

				$id=GETPOST('id_doc');
				$dir = DOL_DATA_ROOT . '/AWOV/'.$id.'/';
				

			


				

				$file = $dir . "AWOV.pdf";

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

				if (class_exists('TCPDF')) {
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

				$pdf->SetTitle($outputlangs->convToOutputCharset('AWOV'));
				$pdf->SetSubject($outputlangs->transnoentities(""));
				$pdf->SetCreator("Dolibarr " . DOL_VERSION);
				$pdf->SetAuthor($outputlangs->convToOutputCharset($user->getFullName($outputlangs)));
				if (!empty($conf->global->MAIN_DISABLE_PDF_COMPRESSION)) $pdf->SetCompression(false);

				$pdf->SetMargins($this->marge_gauche, $this->marge_haute, $this->marge_droite); // Left, Top, Right

				// New page
				// New page
				$pdf->AddPage('');
				$x = 0; // Position horizontale de image
				$y = 0; // Position verticale de image
				$w = 210; // Largeur de image
				$h = 300; 
				$type = 'JPEG';	
				$fileimage = DOL_DOCUMENT_ROOT . '/fourn/facture/images/AWOV.jpg';
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


	



				
				

				




									

				


				
				// Replace with your actual table HTML

				$pdf->SetFont('', '', $default_font_size);
				$pdf->SetY($pdf->GetY() + 6);
				$pdf->SetX($this->posxdesc + 6);
				// $pdf->writeHTML($table);

				// Pagefoot
				// $this->_pagefoot($pdf, $object, $outputlangs);
				// if (method_exists($pdf, 'AliasNbPages')) $pdf->AliasNbPages();

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
		global $langs, $conf, $mysoc, $prev_month, $prev_year;


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

		// $logo = $conf->mycompany->dir_output . '/logos/' . $mysoc->logo;
		// if ($mysoc->logo) {
		// 	if (is_readable($logo)) {
		// 		$height = pdf_getHeightForLogo($logo);
		// 		$pdf->Image($logo, $this->marge_gauche, $posy, 70, 0);	// width=0 (auto)
		// 	} else {
		// 		$pdf->SetTextColor(200, 0, 0);
		// 		$pdf->SetFont('', 'B', $default_font_size - 2);
		// 		$pdf->MultiCell(100, 3, $outputlangs->transnoentities("ErrorLogoFileNotFound", $logo), 0, 'L');
		// 		$pdf->MultiCell(100, 3, $outputlangs->transnoentities("ErrorGoToModuleSetup"), 0, 'L');
		// 	}
		// } else {
		// 	$text = $this->emetteur->name;
		// 	$pdf->MultiCell(100, 4, $outputlangs->convToOutputCharset($text), 0, 'L');
		// }

		// $pdf->SetFont('', 'B', $default_font_size + 3);
		// $pdf->MultiCell(200, 2, " ", 0, "C");
		// $pdf->SetFont('', '', $default_font_size + 3);
		// $pdf->MultiCell(200, 30, $periode, 0, "C");

		// $pdf->SetXY($posx, $posy);
		// $pdf->SetTextColor(0, 0, 60);
		// $posy += 1;


		// set style for barcode
		$style = array(
			'border' => 2,
			'vpadding' => 'auto',
			'hpadding' => 'auto',
			'fgcolor' => array(0, 0, 0),
			'bgcolor' => false, //array(255,255,255)
			'module_width' => 1, // width of a single module in points
			'module_height' => 1 // height of a single module in points
		);


		// $info = "Nom: " . $object->firstname . " " . $object->lastname . ". Periode: " . $periode . ". Salaire Net: " . price($totalNet, 0);

		// // // QRCODE,L : QR-CODE Low error correction
		// $pdf->write2DBarcode($info, 'QRCODE,L', 160, 6, 30, 30, $style, 'N');

		$w='';

		
		$Adresse='';
		$Nom='';
		$zip_societe='';
		$Pays='';
		global $db;

		$sql = "SELECT * FROM llx_const";
		$res_const = $db->query($sql);

		
		foreach($res_const as $item)
		{
			if($item['name']=='MAIN_INFO_SOCIETE_ADDRESS')
			{
				$Adresse= $item['value'];
				
				
			}
			else if($item['name']=='MAIN_INFO_SOCIETE_NOM')
			{
				$Nom= $item['value'];
				
			}
			else if($item['name']=='MAIN_INFO_SOCIETE_COUNTRY')
			{
				$Pays= $item['value'];

				$parts = explode(':', $Pays);

				if (count($parts) >= 3) {
					$Pays = $parts[2];
				} 
			}
			else if($item['name']=='MAIN_INFO_SOCIETE_ZIP')
			{
				$SOCIETE_ZIP= $item['value'];
			}
			
		}

        $id=GETPOST('id_doc');
		$sql = "SELECT * FROM llx_facture_fourn WHERE rowid='" . $id . "'";
		$res_facture_fourn = $db->query($sql);

		if ($res_facture_fourn) {
			$param = $res_facture_fourn->fetch_assoc();
			$total_ttc = $param['multicurrency_total_ttc'];
			$multicurrency_code = $param['multicurrency_code'];
			$formatter = new NumberFormatter("fr", NumberFormatter::SPELLOUT);
			$inWords = $formatter->format($total_ttc);

			$fk_soc = $param['fk_soc'];
			$ref_supplier = $param['ref_supplier'];		
		} 

		$sql = "SELECT * FROM llx_societe WHERE rowid='" . $fk_soc . "'";
		$res_societe = $db->query($sql);
		if ($res_societe) {
			$param_societe = $res_societe->fetch_assoc();
			$nom_societe = $param_societe['nom'];
			$zip_societe = $param_societe['zip'];
			$nom_address = $param_societe['address'];
			$fk_pays = $param_societe['fk_pays'];
		}

		$iban_prefix='';
		$bank_societe_rib='';
		$Swift='';
		$label_c_country='';
		$sql = "SELECT * FROM llx_societe_rib WHERE fk_soc='" . $fk_soc . "'";
		$res_societe_rib = $db->query($sql);
		if ($res_societe_rib && $res_societe_rib->num_rows > 0) {
			$param_societe_rib = $res_societe_rib->fetch_assoc();
			$iban_prefix = $param_societe_rib['iban_prefix'];
			$bank_societe_rib = $param_societe_rib['bank'];
			$Swift = $param_societe_rib['bic'];
			
		}

		$sql = "SELECT * FROM llx_c_country WHERE rowid='" . $fk_pays . "'";
		$res_c_country = $db->query($sql);
		if ($res_c_country && $res_c_country->num_rows > 0) {
			$param_c_country = $res_c_country->fetch_assoc();
			$label_c_country = $param_c_country['label'];
		}










		$sql = "SELECT * FROM llx_bank_account ";
		$res_bank_account  = $db->query($sql);
		if ($res_bank_account) {
			$param_bank_account = $res_bank_account->fetch_assoc();
			$Nbank_account = $param_bank_account['number'];
		}




        // --------- Adresse Sociate
		$posx += -74;
		$posy += 47;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($Adresse),'', 'L');
		// --------- Nom Sociate
		$posx += 18;
		$posy += -12;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($Nom),'', 'L');
        // --------- Pays Sociate   
		$posx += 78;
		$posy += 12;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($Pays),'', 'L');

		// --------- Devise de transfert   
		$posx += -80;
		$posy += 13.5;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($multicurrency_code),'', 'L');
		// --------- Montant en Devise (en chiffres)
		$posx += 19;
		$posy += 4;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, number_format($total_ttc, 2, '.', ''),'', 'L');
		// --------- Montant en Devise (en littres)
		$posx += -2;
		$posy +=4;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($inWords),'', 'L');

		// --------- BENEFICIARE nom
		$posx += -14;
		$posy +=33;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($nom_societe),'', 'L');
		// --------- BENEFICIARE n°
		$posx += -3;
		$posy +=4;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($iban_prefix),'', 'L');
		// --------- BENEFICIARE nom banque
		$posx += -1;
		$posy +=4;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($bank_societe_rib),'', 'L');
		// --------- BENEFICIARE code swift
		$posx += -8;
		$posy +=4;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($Swift),'', 'L');

		// --------- BENEFICIARE adresse
		$posx += 15;
		$posy +=4.5;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($nom_address),'', 'L');

		// --------- objet economique de paiment et nature 
		// reglement facture n° 
		$posx += 2;
		$posy +=13.5;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($ref_supplier),'', 'L');

		// --------- SOCIETE_ZIP  
		$posx += 119;
		$posy += -84.5;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($SOCIETE_ZIP),'', 'L');

		// --------- N° account  
		$posx += -137;
		$posy += -8.3;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
			// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($Nbank_account),'', 'L');


		$option=GETPOST('option');
		$option2=GETPOST('option2');
		

		$donnneurOrdre='';
		$Beneficiaire='';
		$donnneurOrdre2='';
		$Beneficiaire2='';
		$VerserClient='';
		$RegleeClient='';


		if($option=="donnneurOrdre")
		{
			$donnneurOrdre="x";
		}else if($option=="Beneficiaire"){
			$Beneficiaire="x";
		}

		// ----------------- A la charge du  : -----------------
        // donnneurOrdre
		$posx += -151;
		$posy += 131;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($donnneurOrdre),'', 'L');
		// Beneficiaire
		$posx += 0;
		$posy += 4.1;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($Beneficiaire),'', 'L');

		// ----------------- RETENUE A LA SOURCE  : -----------------

        if($option2=="donnneurOrdre2")
		{
			$donnneurOrdre2="x";
		}else if($option2=="Beneficiaire2"){
			$Beneficiaire2="x";
		}else if($option2=="VerserClient"){
			$VerserClient="x";
		}else if($option2=="RegleeClient"){
			$RegleeClient="x";
		}

		// donnneurOrdre 2
		$posx +=41.7;
		$posy += -1.4;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
			// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($donnneurOrdre2),'', 'L');
		// Beneficiaire 2
		$posx +=33;
		$posy += 0;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($Beneficiaire2),'', 'L');
		// VerserClient
		$posx += -33.1;
		$posy += 3.3;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($VerserClient),'', 'L');
		// RegleeClient
		$posx += 0;
		$posy += 3.3;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($RegleeClient),'', 'L');

		$NCommercial=GETPOST('NCommercial');
		$PMarchandise=GETPOST('PMarchandise');
       // NCommercial
		$posx += -78.2;  
		$posy += 12.5;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($NCommercial),'', 'L');
		// PMarchandise
		$posx += -1;    
		$posy +=3.9;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($PMarchandise),'', 'L');

		// zip_societe
		$posx +=114;
		$posy +=  -77.5;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($zip_societe),'', 'L');

		// label_c_country
		$posx +=165;
		$posy +=  0;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFontSize(9); // Set the font size to 9
		// $pdf->Ln(2);
		$pdf->MultiCell($w, 3, ucfirst($label_c_country),'', 'L');



		
		
		  

		// //Dat e
		// $posy += 2;
		// $pdf->SetXY($posx, 40);
		// $pdf->SetTextColor(0, 0, 60);
		// $pdf->MultiCell(100, 1, "Date.... ", '', 'R');

		// $posy += 1;
		// $pdf->SetTextColor(0, 0, 60);

		// $top_shift = 0;
		// Show list of linked objects
		$current_y = $pdf->getY();
		$posy = pdf_writeLinkedObjects($pdf, $object, $outputlangs, $posx, $posy, 100, 3, 'R', $default_font_size);
		if ($current_y < $pdf->getY()) {
			$top_shift = $pdf->getY() - $current_y;
		}

		$ltrdirection=0;
		if ($showaddress) {
			// Sender properties
			$carac_emetteur = '';
			// Add internal contact of proposal if defined
			$arrayidcontact = $object->getIdContact('internal', 'SALESREPFOLL');
			if (count($arrayidcontact) > 0) {
				$object->fetch_user($arrayidcontact[0]);
				$labelbeforecontactname = ($outputlangs->transnoentities("FromContactName") != 'FromContactName' ? $outputlangs->transnoentities("FromContactName") : $outputlangs->transnoentities("Name"));
				$carac_emetteur .= ($carac_emetteur ? "\n" : '').$labelbeforecontactname." ".$outputlangs->convToOutputCharset($object->user->getFullName($outputlangs))."\n";
			}

			$carac_emetteur .= pdf_build_address($outputlangs, $this->emetteur, $object->thirdparty, '', 0, 'source', $object);

			// ---Émetteur---

			// // Show sender
			// $posy = 48 + $top_shift;
			// $posx = $this->marge_gauche;
			// if (!empty($conf->global->MAIN_INVERT_SENDER_RECIPIENT)) {
			// 	$posx = $this->page_largeur - $this->marge_droite - 80;
			// }
			// $hautcadre = 40;

			// // Show sender frame
			// if (empty($conf->global->MAIN_PDF_NO_SENDER_FRAME)) {
			// 	$pdf->SetTextColor(0, 0, 0);
			// 	$pdf->SetFont('', '', $default_font_size - 2);
			// 	$pdf->SetXY($posx, $posy - 5);
			// 	$pdf->MultiCell(80, 5, $outputlangs->transnoentities("BillFrom"), 0, $ltrdirection);
			// 	$pdf->SetXY($posx, $posy);
			// 	$pdf->SetFillColor(230, 230, 230);
			// 	$pdf->MultiCell(82, $hautcadre, "", 0, 'R', 1);
			// 	$pdf->SetTextColor(0, 0, 60);
			// }

			// // Show sender name
			// if (empty($conf->global->MAIN_PDF_HIDE_SENDER_NAME)) {
			// 	$pdf->SetXY($posx + 2, $posy + 3);
			// 	$pdf->SetFont('', 'B', $default_font_size);
			// 	$pdf->MultiCell(80, 4, $outputlangs->convToOutputCharset($this->emetteur->name), 0, $ltrdirection);
			// 	$posy = $pdf->getY();
			// }

			// // Show sender information
			// $pdf->SetXY($posx + 2, $posy);
			// $pdf->SetFont('', '', $default_font_size - 1);
			// $pdf->MultiCell(80, 4, $carac_emetteur, 0, 'L');


			// If CUSTOMER contact defined, we use it
			$usecontact = false;
			$arrayidcontact = $object->getIdContact('external', 'CUSTOMER');
			if (count($arrayidcontact) > 0) {
				$usecontact = true;
				$result = $object->fetch_contact($arrayidcontact[0]);
			}

			// Recipient name
			if ($usecontact && ($object->contact->socid != $object->thirdparty->id && (!isset($conf->global->MAIN_USE_COMPANY_NAME_OF_CONTACT) || !empty($conf->global->MAIN_USE_COMPANY_NAME_OF_CONTACT)))) {
				$thirdparty = $object->contact;
			} else {
				$thirdparty = $object->thirdparty;
			}

			$carac_client_name = pdfBuildThirdpartyName($thirdparty, $outputlangs);

			$mode =  'target';
			$carac_client = pdf_build_address($outputlangs, $this->emetteur, $object->thirdparty, ($usecontact ? $object->contact : ''), $usecontact, $mode, $object);

			// Show recipient       
			$widthrecbox = !empty($conf->global->MAIN_PDF_USE_ISO_LOCATION) ? 92 : 100;
			if ($this->page_largeur < 210) {
				$widthrecbox = 84; // To work with US executive format
			}
		}
		$pdf->SetTextColor(0, 0, 0);

	
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
	// protected function _pagefoot(&$pdf, $object, $outputlangs, $hidefreetext = 0)
	// {
	// 	global $conf, $object;
	// 	$showdetails = $conf->global->MAIN_GENERATE_DOCUMENTS_SHOW_FOOT_DETAILS;
	// 	return pdf_pagefoot($pdf, $outputlangs, '', $this->emetteur, $this->marge_basse, $this->marge_gauche, $this->page_hauteur, $object, $showdetails, $hidefreetext);
	// }
}

			