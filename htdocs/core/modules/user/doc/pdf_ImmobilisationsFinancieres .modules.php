
<?php


require_once DOL_DOCUMENT_ROOT . '/core/modules/user/modules_user.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/company.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/pdf.lib.php';

require_once DOL_DOCUMENT_ROOT . '/societe/class/companybankaccount.class.php';
require_once DOL_DOCUMENT_ROOT . '/user/class/userbankaccount.class.php'; 


class pdf_ImmobilisationsFinancieres extends ModelePDFUser
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
				$dir = DOL_DATA_ROOT . '/billanLaisse/ImmobilisationsFinancieres/';
			
				$year=GETPOST('valeurdatechoise');
			
				$file = $dir . "/ImmobilisationsFinancieres".$year . ".pdf";
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

				$pdf->SetTitle($outputlangs->convToOutputCharset('PassageComptableFiscal'));
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

				$year=GETPOST('valeurdatechoise');

				include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/ImmobilisationsFinancieres/ImmobilisationsFinancieres_fichier_'.$year.'.php';

	

		

	

			

				$table =
				'
				<style >			
				.gridlines td { border:1px dotted black }
				.gridlines th { border:1px dotted black }
			</style>
		
			

			<table >

			
			<tr>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Nature</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Montant brut début exercice</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Augmentation Acquisition</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Augmentation Production par l Etps pour elle même	</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Augmentation Virement</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Diminution Cession</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Diminution Retrait</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Diminution Virement</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Montant brut fin exercice</font></b></td>
				<td align="center" valign=middle><font face="Arial Narrow"><br></font></td>
				<td align="center" valign=middle><font face="Arial Narrow"><br></font></td>
			</tr>
			<tr>
				<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="20" align="left" valign=bottom><b><font face="Calibri">IMMOBILISATION EN NON-VALEURS</font></b></td>
				<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IENV_MBDE.'</font></b></td>
				<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IENV_AA.'</font></b></td>
				<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IENV_APPLPEM.'</font></b></td>
				<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IENV_AV.'</font></b></td>
				<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IENV_DC.'</font></b></td>
				<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IENV_DR.'</font></b></td>
				<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IENV_DV.'</font></b></td>
				<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IENV_MBFE.'</font></b></td>
				<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
				<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
			</tr>
			<tr>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Frais préliminaires</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$FP_MBDE.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$FP_AA.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres1.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres2.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres3.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres4.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres5.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$FP_MBFE.'</font></td>
				<td align="center" valign=middle sdval="211" sdnum="1033;"><font face="Arial Narrow"></font></td>
				<td align="center" valign=middle sdval="71411" sdnum="1033;"><font face="Arial Narrow"></font></td>
			</tr>
			<tr>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Charges à répartir sur plusieurs exercices</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$CARSPE_MBDE.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$CARSPE_AA.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres6.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres7.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres8.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres9.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres10.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$CARSPE_MBFE.'</font></td>
				<td align="center" valign=middle sdval="212" sdnum="1033;"><font face="Arial Narrow"></font></td>
				<td align="center" valign=middle sdval="71412" sdnum="1033;"><font face="Arial Narrow"></font></td>
		
			</tr>
			<tr>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Primes de remboursement obligations</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$PDRO_MBDE.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$PDRO_AA.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres11.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres12.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres13.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres14.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres15.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$PDRO_MBFE.'</font></td>
				<td align="center" valign=middle sdval="213" sdnum="1033;"><font face="Arial Narrow"></font></td>
				<td align="center" valign=middle sdval="71413" sdnum="1033;"><font face="Arial Narrow"></font></td>
			</tr>
		
		
			
			<tr>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=bottom><b><font face="Calibri">IMMOBILISATIONS INCORPORELLES</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$II_MBDE.'</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$II_AA.'</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$II_APPLPEM.'</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$II_AV.'</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$II_DC.'</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$II_DR.'</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$II_DV.'</font></b></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$II_MBFE.'</font></b></td>
				<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
				<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		
			</tr>
			<tr>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Immobilisation en recherche et développement</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$IERED_MBDE.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$IERED_AA.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres16.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres17.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres18.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres19.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres20.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$IERED_MBFE.'</font></td>
				<td align="center" valign=middle sdval="221" sdnum="1033;"><font face="Arial Narrow"></font></td>
				<td align="center" valign=middle sdval="71421" sdnum="1033;"><font face="Arial Narrow"></font></td>
		
			</tr>
			<tr>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Brevets, marques, droits et valeurs similaires</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$BMDEVS_MBDE.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$BMDEVS_AA.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres21.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres22.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres23.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres24.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres25.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$BMDEVS_MBFE.'</font></td>
				<td align="center" valign=middle sdval="222" sdnum="1033;"><font face="Arial Narrow"></font></td>
				<td align="center" valign=middle sdval="71422" sdnum="1033;"><font face="Arial Narrow"></font></td>
		
			</tr>
			<tr>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Fonds commercial</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$FC_MBDE.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$FC_AA.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres26.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres27.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres28.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres29.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres30.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$FC_MBFE.'</font></td>
				<td align="center" valign=middle sdval="223" sdnum="1033;"><font face="Arial Narrow"></font></td>
				<td align="center" valign=middle sdval="71423" sdnum="1033;"><font face="Arial Narrow"></font></td>
		
			</tr>
			<tr>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Autres immobilisations incorporelles</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$AII_MBDE.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$AII_AA.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres31.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres32.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres33.'</font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres34.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres35.'<br></font></td>
				<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$AII_MBFE.'</font></td>
				<td align="center" valign=middle sdval="228" sdnum="1033;"><font face="Arial Narrow"></font></td>
				<td align="center" valign=middle sdval="71428" sdnum="1033;"><font face="Arial Narrow"></font></td>
		
			</tr>
			<tr>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=bottom><b><font face="Calibri">IMMOBILISATIONS CORPORELLES</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IC_MBDE.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IC_AA.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IC_APPLPEM.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IC_AV.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IC_DC.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IC_DR.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IC_DV.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">'.$IC_MBFE.'</font></b></td>
			<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
			<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	
		</tr>
		<tr>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Terrains</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$T_MBDE.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$T_AA.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres36.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres37.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres38.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres39.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres40.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$T_MBFE.'</font></td>
			<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="231" sdnum="1033;"></td>
			<td align="center" valign=middle sdval="71431" sdnum="1033;"><font face="Arial Narrow"></font></td>
	
		</tr>
		<tr>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Constructions</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$C_MBDE.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$C_AA.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres41.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres42.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres43.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres44.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres45.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$C_MBFE.'</font></td>
			<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="232" sdnum="1033;"></td>
			<td align="center" valign=middle sdval="71432" sdnum="1033;"><font face="Arial Narrow"></font></td>
	
		</tr>
		<tr>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Installations techniques, matériel et outillage</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$ITMEO_MBDE.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$ITMEO_AA.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres46.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres47.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres48.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres49.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres50.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$ITMEO_MBFE.'</font></td>
			<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="233" sdnum="1033;"></td>
			<td align="center" valign=middle sdval="71433" sdnum="1033;"><font face="Arial Narrow"></font></td>
	
		</tr>
		<tr>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Matériel de transport</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$MDT_MBDE.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$MDT_AA.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres51.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres52.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres53.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres54.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres55.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$MDT_MBFE.'</font></td>
			<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="234" sdnum="1033;"></td>
			<td align="center" valign=middle sdval="71434" sdnum="1033;"><font face="Arial Narrow"></font></td>
	
		</tr>
		<tr>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Mobilier, matériel de bureau et aménagement</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$MMDBEA_MBDE.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$MMDBEA_AA.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres56.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres57.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres58.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres59.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres60.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$MMDBEA_MBFE.'</font></td>
			<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="235" sdnum="1033;"></td>
			<td align="center" valign=middle sdval="71435" sdnum="1033;"><font face="Arial Narrow"></font></td>
	
		</tr>
		<tr>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Autres immobilisations corporelles</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$AIC_MBDE.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$AIC_AA.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres61.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres62.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres63.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres64.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres65.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$AIC_MBFE.'</font></td>
			<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="238" sdnum="1033;"></td>
			<td align="center" valign=middle sdval="71438" sdnum="1033;"><font face="Arial Narrow"></font></td>
	
		</tr>
		<tr>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Immobilisations corporelles en cours</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$ICEC_MBDE.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$ICEC_AA.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres66.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres67.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres68.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres69.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres70.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$ICEC_MBFE.'</font></td>
			<td style="border-left: 1px solid #000000" align="center" valign=middle sdval="239" sdnum="1033;"><font face="Arial"></font></td>
			<td align="center" valign=middle sdval="71439" sdnum="1033;"><font face="Arial Narrow"></font></td>
	
		</tr>
		<tr>
			<td style="border-left: 1px solid #000000" height="18" align="left" valign=bottom><font face="Calibri">- Matériel informatique</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$MI_MBDE.'</font></td>
			<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$MI_AA.'</font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres71.'</font></td>
			<td align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres72.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres73.'</font></td>
			<td align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres74.'<br></font></td>
			<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$immobilisationFinancieres75.'<br></font></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">'.$MI_MBFE.'</font></td>
			<td align="center" valign=middle sdval="2355" sdnum="1033;"><font face="Arial Narrow"></font></td>
			<td align="center" valign=middle sdval="714391" sdnum="1033;"><font face="Arial Narrow"></font></td>
	
		</tr>
		<tr>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="34" align="center" valign=middle><b><font face="Calibri" size=3>Total</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3>'.$T_MBDE.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3>'.$T_AA.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3>'.$T_APPLPEM.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3>'.$T_AV.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3>'.$T_DC.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3>'.$T_DR.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3>'.$T_DV.'</font></b></td>
			<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" size=3>'.$T_MBFE.'</font></b></td>
			<td align="left" valign=middle><font face="Arial Narrow" size=3><br></font></td>
			<td align="left" valign=middle><font face="Arial Narrow" size=3><br></font></td>
	
		</tr>
		
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

		$year = GETPOST('valeurdatechoise');

		$pdf->SetFont('', 'B', $default_font_size + 3);
		$pdf->MultiCell(200, 2, "TABLEAU DES IMMOBILISATIONS AUTRES QUE FINANCIERES ".$year, 0, "C");
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

			