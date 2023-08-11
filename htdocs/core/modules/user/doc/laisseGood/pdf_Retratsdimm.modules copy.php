
<?php


require_once DOL_DOCUMENT_ROOT . '/core/modules/user/modules_user.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/company.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/pdf.lib.php';

require_once DOL_DOCUMENT_ROOT . '/societe/class/companybankaccount.class.php';
require_once DOL_DOCUMENT_ROOT . '/user/class/userbankaccount.class.php'; 


class pdf_Retratsdimm extends ModelePDFUser
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
				$dir = DOL_DATA_ROOT . '/billanLaisse/Retratsdimm/';
			
				$year=GETPOST('year');
			
				$file = $dir . "/Retratsdimm".$year . ".pdf";
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

				$pdf->SetTitle($outputlangs->convToOutputCharset('CreditBail'));
				$pdf->SetSubject($outputlangs->transnoentities(""));
				$pdf->SetCreator("Dolibarr " . DOL_VERSION);
				$pdf->SetAuthor($outputlangs->convToOutputCharset($user->getFullName($outputlangs)));
				if (!empty($conf->global->MAIN_DISABLE_PDF_COMPRESSION)) $pdf->SetCompression(false);

				$pdf->SetMargins($this->marge_gauche, $this->marge_haute, $this->marge_droite); // Left, Top, Right

				// New page
				$pdf->AddPage();
			//	if (!empty($tplidx)) $pdf->useTemplate($tplidx);
				$pagenb++;
				$totalNet = 0;
				$top = $this->_pagehead($pdf, $object, 1, $outputlangs, $totalNet, $periode);
				$pdf->SetY($pdf->GetY() + 10);
				$pdf->SetTextColor(0, 0, 0);

				$tab_top = 90;
				$tab_top_newpage = (empty($conf->global->MAIN_PDF_DONOTREPEAT_HEAD) ? 42 : 10);
		
				// body


				$year=GETPOST('year');
				include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/RetratsDimmobilisation_fichier_'.$year.'.php';

				$table =
				'
				<style >			
				.gridlines td { border:1px dotted black }
				.gridlines th { border:1px dotted black }
			   </style>		
			<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">
				<col class="col0">
				<col class="col1">
				<col class="col2">
				<col class="col3">
				<col class="col4">
				<col class="col5">
				<col class="col6">
				<col class="col7">
				<col class="col8">
				<col class="col9">
				<col class="col10">
        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style3" colspan="8">TABLEAU DES PLUS OU MOINS VALUES SUR CESSIONS OU RETRAITS D\'\IMMOBILISATIONS</td>

          </tr>
          <tr class="row1">
            <td class="column0 style5 f"></td>
            <td class="column1 style6 null"></td>
            <td class="column2 style7 null"></td>
            <td class="column3 style8 s"></td>
            <td class="column4 style9 f"></td>
            <td class="column5 style7 null"></td>
            <td class="column6 style7 null"></td>
            <td class="column7 style10 f"></td>

          </tr>
          <tr class="row2">
            <td class="column0 style12 s">Date de cession ou de retrait</td>
            <td class="column1 style12 s">Compte principal</td>
            <td class="column2 style12 s">Montant brut</td>
            <td class="column3 style12 s">Amortissements cumulés</td>
            <td class="column4 style13 s">Valeur nette d\'\'.number_format(amortissement</td>
            <td class="column5 style12 s">Produit de cession</td>
            <td class="column6 style12 s">Plus values</td>
            <td class="column7 style12 s">Moins values</td>

          </tr>
          <tr class="row3">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation0,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation1,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation2,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation3,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation4,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation5,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues1,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues1,2).' </td>

          </tr>
          <tr class="row4">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation6,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation7,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation8,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation9,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation10,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation11,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues2,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues2,2).' </td>

          </tr>
          <tr class="row5">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation12,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation13,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation14,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation15,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation16,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation17,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues3,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues3,2).' </td>

          </tr>
          <tr class="row6">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation18,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation19,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation20,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation21,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation22,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation23,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues4,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues4,2).' </td>

          </tr>
          <tr class="row7">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation24,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation25,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation26,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation27,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation28,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation29,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues5,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues5,2).' </td>

          </tr>
          <tr class="row8">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation30,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation31,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation32,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation33,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation34,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation35,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues6,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues6,2).' </td>
          </tr>
          <tr class="row9">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation36,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation37,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation38,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation39,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation40,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation41,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues7,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues7,2).' </td>
          </tr>
          <tr class="row10">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation42,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation43,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation44,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation45,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation46,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation47,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues8,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues8,2).' </td>
          </tr>
          <tr class="row11">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation48,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation49,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation5,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation51,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation52,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation53,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues9,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues9,2).' </td>
          </tr>
          <tr class="row12">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation54,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation55,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation56,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation57,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation58,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation59,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues10,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues10,2).' </td>
          </tr>
          <tr class="row13">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation60,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation61,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation62,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation63,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation64,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation65,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues11,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues11,2).' </td>
          </tr>
          <tr class="row14">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation66,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation67,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation68,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation69,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation70,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation71,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues12,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues12,2).' </td>
          </tr>
          <tr class="row15">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation72,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation73,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation74,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation75,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation76,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation77,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues13,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues13,2).' </td>
          </tr>
          <tr class="row16">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation78,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation79,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation80,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation81,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation82,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation83,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues14,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues14,2).' </td>
          </tr>
          <tr class="row17">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation84,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation85,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation86,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation87,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation88,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation89,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues15,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues15,2).' </td>
          </tr>
          <tr class="row18">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation90,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation91,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation92,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation93,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation94,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation95,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues16,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues16,2).' </td>
          </tr>
          <tr class="row19">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation96,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation97,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation98,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation99,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation100,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation101,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues17,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues17,2).' </td>
          </tr>
          <tr class="row20">
            <td class="column0 style15 null">'.number_format( $RDimmobilisation102,2).'</td>
            <td class="column1 style16 null">'.number_format( $RDimmobilisation103,2).'</td>
            <td class="column2 style17 null">'.number_format( $RDimmobilisation104,2).'</td>
            <td class="column3 style17 null">'.number_format( $RDimmobilisation105,2).'</td>
            <td class="column4 style17 null">'.number_format( $RDimmobilisation106,2).'</td>
            <td class="column5 style17 null">'.number_format( $RDimmobilisation107,2).'</td>
            <td class="column6 style18 f">'.number_format( $PlusValues18,2).'</td>
            <td class="column7 style18 f">'.number_format( $MoinsValues18,2).' </td>
          </tr>
          <tr class="row21">
            <td class="column0 style19 null"></td>
            <td class="column1 style20 s">Total</td>
            <td class="column2 style21 f">'.number_format( $sum1,2).'</td>
            <td class="column3 style21 f">'.number_format( $sum2,2).'</td>
            <td class="column4 style21 f">'.number_format( $sum3,2).'</td>
            <td class="column5 style21 f">'.number_format( $sum4,2).'</td>
            <td class="column6 style21 f">'.number_format( $sum5,2).'</td>
            <td class="column7 style21 f">'.number_format( $sum6,2).'</td>
          </tr>
  
 
        </tbody>
    </table>
			

				'
				; // Replace with your actual table HTML

				$pdf->SetFont('', '', $default_font_size);
				$pdf->SetY($pdf->GetY() + 6);
				$pdf->SetX($this->posxdesc + 6);
				$pdf->writeHTML($table);

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

		$year = GETPOST('year');

		$pdf->SetFont('', 'B', $default_font_size + 3);
		$pdf->MultiCell(200, 2, "TABLEAU DES PLUS OU MOINS VALUES SUR CESSIONS OU RETRAITS D'IMMOBILISATIONS".$year, 0, "C");
		$pdf->SetFont('', '', $default_font_size + 3);
		$pdf->MultiCell(200, 30, $periode, 0, "C");

		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$posy += 1;


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

		//Date
		$posy += 2;
		$pdf->SetXY($posx, 40);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->MultiCell(100, 1, "Date.... " . date("d/m/Y"), '', 'R');

		$posy += 1;
		$pdf->SetTextColor(0, 0, 60);

		$top_shift = 0;
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

			// Show sender
			$posy = 48 + $top_shift;
			$posx = $this->marge_gauche;
			if (!empty($conf->global->MAIN_INVERT_SENDER_RECIPIENT)) {
				$posx = $this->page_largeur - $this->marge_droite - 80;
			}
			$hautcadre = 40;

			// Show sender frame
			if (empty($conf->global->MAIN_PDF_NO_SENDER_FRAME)) {
				$pdf->SetTextColor(0, 0, 0);
				$pdf->SetFont('', '', $default_font_size - 2);
				$pdf->SetXY($posx, $posy - 5);
				$pdf->MultiCell(80, 5, $outputlangs->transnoentities("BillFrom"), 0, $ltrdirection);
				$pdf->SetXY($posx, $posy);
				$pdf->SetFillColor(230, 230, 230);
				$pdf->MultiCell(82, $hautcadre, "", 0, 'R', 1);
				$pdf->SetTextColor(0, 0, 60);
			}

			// Show sender name
			if (empty($conf->global->MAIN_PDF_HIDE_SENDER_NAME)) {
				$pdf->SetXY($posx + 2, $posy + 3);
				$pdf->SetFont('', 'B', $default_font_size);
				$pdf->MultiCell(80, 4, $outputlangs->convToOutputCharset($this->emetteur->name), 0, $ltrdirection);
				$posy = $pdf->getY();
			}

			// Show sender information
			$pdf->SetXY($posx + 2, $posy);
			$pdf->SetFont('', '', $default_font_size - 1);
			$pdf->MultiCell(80, 4, $carac_emetteur, 0, 'L');


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
		global $conf, $object;
		$showdetails = $conf->global->MAIN_GENERATE_DOCUMENTS_SHOW_FOOT_DETAILS;
		return pdf_pagefoot($pdf, $outputlangs, '', $this->emetteur, $this->marge_basse, $this->marge_gauche, $this->page_hauteur, $object, $showdetails, $hidefreetext);
	}
}

			