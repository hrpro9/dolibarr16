<?php


$contentFinancementEx = '
<?php


require_once DOL_DOCUMENT_ROOT . \'/core/modules/user/modules_user.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/company.lib.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/functions2.lib.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/pdf.lib.php\';

require_once DOL_DOCUMENT_ROOT . \'/societe/class/companybankaccount.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/user/class/userbankaccount.class.php\'; 


class pdf_FinancementEx extends ModelePDFUser
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
		$formatarray = pdf_getFormat();
		$this->page_largeur = $formatarray[\'width\'];
		$this->page_hauteur = $formatarray[\'height\'];
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
		if (!empty($conf->global->MAIN_USE_FPDF)) $outputlangs->charset_output = \'ISO-8859-1\';

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
				$objectrefsupplier = isset($object->ref_supplier) ? dol_sanitizeFileName($object->ref_supplier) : \'\';
				$dir = DOL_DATA_ROOT . \'/billanLaisse/FinancementEx/\';
			
				$year=GETPOST(\'valeurdatechoise\');
			
				$file = $dir . "/FinancementEx".$year . ".pdf";
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

				$pdf->SetTitle($outputlangs->convToOutputCharset(\'CreditBail\'));
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

				$year=GETPOST(\'valeurdatechoise\');

				include DOL_DOCUMENT_ROOT . \'/custom/etatscomptables/FinancementEx/FinancementEx_fichier_\'.$year.\'.php\';

	

			

				$table =
				\'
				<style >			
				.gridlines td { border:1px dotted black }
				.gridlines th { border:1px dotted black }
			</style>
		
			<table >




	<tr>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=middle bgcolor="#D9D9D9"><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" rowspan=3 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>Masses</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>Exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=top bgcolor="#D9D9D9"><b><font size=2>Exercice précédent</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=bottom bgcolor="#D9D9D9"><b><font size=2>Variations a-b Emplois</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=bottom bgcolor="#D9D9D9"><b><font size=2>Variations a-b Ressources</font></b></td>
		<td align="left" valign=bottom><b><font face="Arial" size=2><br></font></b></td>
	</tr>

<tr>
	<td height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom><b><font size=2>I-SYNTHESE DES MASSES DU BILAN</font></b></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="right" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="1" sdnum="1033;"><font size=2>1</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>  Financement Permanent</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$FP_E.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$FP_EP.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$FP_VE.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$FP_VR.\'</font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>

</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="2" sdnum="1033;"><font size=2>2</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>  Moins actif immobilisé</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$MAI_E.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$MAI_EP.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$MAI_VE.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$MAI_VR.\'</font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="3" sdnum="1033;"><font size=2>3</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>  = Fonds de roulement fonctionnel (1-2) (A)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$FDRF_E.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$FDRF_EP.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$FDRF_VE.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$FDRF_VR.\'</font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="4" sdnum="1033;"><font size=2>4</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>  Actif circulant</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$AC_E.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$AC_EP.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$AC_VE.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$AC_VR.\'</font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="5" sdnum="1033;"><font size=2>5</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>  Moins passif circulant</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$MPC_E.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$MPC_EP.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$MPC_VE.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$MPC_VR.\'</font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>	
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="6" sdnum="1033;"><font size=2>6</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>  = Besoin de financement global (4-5) (B)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$BDFG_E.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$BDFG_EP.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$BDFG_VE.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$BDFG_VR.\'</font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="7" sdnum="1033;"><font size=2>7</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>  TRESORERIE NETTE (Actif-Passif) = A-B</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$BDFG_E.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$BDFG_E.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$BDFG_E.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$BDFG_E.\'</font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td align="left" valign=bottom><font size=2><br></font></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom><b><font size=2>II- EMPLOIS ET RESSOURCES</font></b></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="right" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
	<tr>
	<td style="border-top: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=middle bgcolor="#D9D9D9"><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" rowspan=3 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2></font></b></td>
	<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9"><b><font size=2>Exercice précédent Emplois</font></b></td>
	<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=top bgcolor="#D9D9D9"><b><font size=2>Exercice précédent Ressources</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=bottom bgcolor="#D9D9D9"><b><font size=2>Exercice précédent Emplois</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=bottom bgcolor="#D9D9D9"><b><font size=2>Exercice précédent Ressources</font></b></td>
	<td align="left" valign=bottom><b><font face="Arial" size=2><br></font></b></td>
</tr>

<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>I- RESSOURCES STABLES DE L EXERCICE (FLUX)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Autofinancement (A)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$AU_ER.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$AU_EPR.\'</font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Capacité d autofinancement</font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$CDA_ER.\'</font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$CDA_EPR.\'</font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>- Distributions de bénéfices</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Cessions et reductions d immobilisations (B)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$CERDI_ER.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$CERDI_EPR.\'</font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Cessions d immobilisations incorporelles</font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$CDII_ER.\'</font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.($CDII_EPR*-1).\'</font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Cessions d immobilisations corporelles</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$CDIC_ER.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.($CDIC_EPR*-1).\'</font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Cessions d immobilisations financières</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$CDIF_ER.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.($CDIF_EPR*-1).\'</font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Récupérations sur créances immobilisées</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Augmentation des capitaux propres et assimiles (C)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$ADCPEA_ER.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$ADCPEA_EPR.\'</font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Augmentation du capital , apports</font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$ADCA_ER.\'</font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$ADCA_EPR.\'</font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Subventions d investissement</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$SDI_ER.\'</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>\'.$SDI_EPR.\'</font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Augmentation des dettes de financement (D) (1)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom><b><font size=2>TOTAL I - RESSOURCES STABLES (A+B+C+D)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$TRS_ER.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$TRS_EPR.\'</font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td height="6" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom><b><font size=2>II- EMPLOIS STABLES DE L EXERCICE (FLUX)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Acquisitions et augmentations d immobilisations (E)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Acquisitions d immobilisations incorporelles</font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
	<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Acquisitions d immobilisation corporelles</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Acquisitions d immobilisation financières</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><font size=2>+ Augmentation des créances immobilisées</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font size=2>0.00</font></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Remboursement des capitaux propres (F)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Remboursements des dettes de financement (G)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>Emplois en non valeurs (H)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$EENV_EE.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>0.00</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>TOTAL II - EMPLOIS STABLES (E+F+G+H)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$$TOTALIIEMPLOISSTABLES_EE.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2>\'.$$TOTALIIEMPLOISSTABLES_ER.\'<br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$$TOTALIIEMPLOISSTABLES_EPE.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2>\'.$$TOTALIIEMPLOISSTABLES_EPR.\'<br></font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td height="7" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font size=2><br></font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>III- VARIATION DU BESOIN DE FINANCEMENT GLOBAL (B.F.G)</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$VDBDFG_EE.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$VDBDFG_ER.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$VDBDFG_EPE.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$VDBDFG_EPR.\'</font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>IV- VARIATION DE LA TRESORERIE</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$VDLT_EE.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$VDLT_ER.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$VDLT_EPE.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$VDLT_EPR.\'</font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>
<tr>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=bottom><b><font size=2><br></font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font size=2>TOTAL GENERAL</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$TOTALGENERAL_EE.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$TOTALGENERAL_ER.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$TOTALGENERAL_EPE.\'</font></b></td>
	<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font size=2>\'.$TOTALGENERAL_EPR.\'</font></b></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
	<td align="left" valign=bottom><font face="Arial" size=2><br></font></td>
</tr>

</table>
\'

				; // Replace with your actual table HTML

				$pdf->SetFont(\'\', \'\', $default_font_size);
				$pdf->SetY($pdf->GetY() + 6);
				$pdf->SetX($this->posxdesc + 6);
				$pdf->writeHTML($table);

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
		global $langs, $conf, $mysoc, $prev_month, $prev_year;


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

		// Logo

		$logo = $conf->mycompany->dir_output . \'/logos/\' . $mysoc->logo;
		if ($mysoc->logo) {
			if (is_readable($logo)) {
				$height = pdf_getHeightForLogo($logo);
				$pdf->Image($logo, $this->marge_gauche, $posy, 70, 0);	// width=0 (auto)
			} else {
				$pdf->SetTextColor(200, 0, 0);
				$pdf->SetFont(\'\', \'B\', $default_font_size - 2);
				$pdf->MultiCell(100, 3, $outputlangs->transnoentities("ErrorLogoFileNotFound", $logo), 0, \'L\');
				$pdf->MultiCell(100, 3, $outputlangs->transnoentities("ErrorGoToModuleSetup"), 0, \'L\');
			}
		} else {
			$text = $this->emetteur->name;
			$pdf->MultiCell(100, 4, $outputlangs->convToOutputCharset($text), 0, \'L\');
		}

		$year = GETPOST(\'valeurdatechoise\');

		$pdf->SetFont(\'\', \'B\', $default_font_size + 3);
		$pdf->MultiCell(200, 2, "TABLEAU DE FINANCEMENT DE L EXERCICE ".$year, 0, "C");
		$pdf->SetFont(\'\', \'\', $default_font_size + 3);
		$pdf->MultiCell(200, 30, $periode, 0, "C");

		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$posy += 1;


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


		// $info = "Nom: " . $object->firstname . " " . $object->lastname . ". Periode: " . $periode . ". Salaire Net: " . price($totalNet, 0);

		// // // QRCODE,L : QR-CODE Low error correction
		// $pdf->write2DBarcode($info, \'QRCODE,L\', 160, 6, 30, 30, $style, \'N\');

		//Date
		$posy += 2;
		$pdf->SetXY($posx, 40);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->MultiCell(100, 1, "Date.... " . date("d/m/Y"), \'\', \'R\');

		$posy += 1;
		$pdf->SetTextColor(0, 0, 60);

		$top_shift = 0;
		// Show list of linked objects
		$current_y = $pdf->getY();
		$posy = pdf_writeLinkedObjects($pdf, $object, $outputlangs, $posx, $posy, 100, 3, \'R\', $default_font_size);
		if ($current_y < $pdf->getY()) {
			$top_shift = $pdf->getY() - $current_y;
		}

		$ltrdirection=0;
		if ($showaddress) {
			// Sender properties
			$carac_emetteur = \'\';
			// Add internal contact of proposal if defined
			$arrayidcontact = $object->getIdContact(\'internal\', \'SALESREPFOLL\');
			if (count($arrayidcontact) > 0) {
				$object->fetch_user($arrayidcontact[0]);
				$labelbeforecontactname = ($outputlangs->transnoentities("FromContactName") != \'FromContactName\' ? $outputlangs->transnoentities("FromContactName") : $outputlangs->transnoentities("Name"));
				$carac_emetteur .= ($carac_emetteur ? "\n" : \'\').$labelbeforecontactname." ".$outputlangs->convToOutputCharset($object->user->getFullName($outputlangs))."\n";
			}

			$carac_emetteur .= pdf_build_address($outputlangs, $this->emetteur, $object->thirdparty, \'\', 0, \'source\', $object);

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
				$pdf->SetFont(\'\', \'\', $default_font_size - 2);
				$pdf->SetXY($posx, $posy - 5);
				$pdf->MultiCell(80, 5, $outputlangs->transnoentities("BillFrom"), 0, $ltrdirection);
				$pdf->SetXY($posx, $posy);
				$pdf->SetFillColor(230, 230, 230);
				$pdf->MultiCell(82, $hautcadre, "", 0, \'R\', 1);
				$pdf->SetTextColor(0, 0, 60);
			}

			// Show sender name
			if (empty($conf->global->MAIN_PDF_HIDE_SENDER_NAME)) {
				$pdf->SetXY($posx + 2, $posy + 3);
				$pdf->SetFont(\'\', \'B\', $default_font_size);
				$pdf->MultiCell(80, 4, $outputlangs->convToOutputCharset($this->emetteur->name), 0, $ltrdirection);
				$posy = $pdf->getY();
			}

			// Show sender information
			$pdf->SetXY($posx + 2, $posy);
			$pdf->SetFont(\'\', \'\', $default_font_size - 1);
			$pdf->MultiCell(80, 4, $carac_emetteur, 0, \'L\');


			// If CUSTOMER contact defined, we use it
			$usecontact = false;
			$arrayidcontact = $object->getIdContact(\'external\', \'CUSTOMER\');
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

			$mode =  \'target\';
			$carac_client = pdf_build_address($outputlangs, $this->emetteur, $object->thirdparty, ($usecontact ? $object->contact : \'\'), $usecontact, $mode, $object);

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
		return pdf_pagefoot($pdf, $outputlangs, \'\', $this->emetteur, $this->marge_basse, $this->marge_gauche, $this->page_hauteur, $object, $showdetails, $hidefreetext);
	}
}

			';



?>