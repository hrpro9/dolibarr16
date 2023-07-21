<?php


$contentCpc = '
<?php


require_once DOL_DOCUMENT_ROOT . \'/core/modules/user/modules_user.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/company.lib.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/functions2.lib.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/pdf.lib.php\';

require_once DOL_DOCUMENT_ROOT . \'/societe/class/companybankaccount.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/user/class/userbankaccount.class.php\'; 


class pdf_Cpc extends ModelePDFUser
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
				$dir = DOL_DATA_ROOT . \'/billanLaisse/Cpc/\';
			
				$file = $dir . "/Cpc" . ".pdf";
				
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

				$pdf->SetTitle($outputlangs->convToOutputCharset(\'ETAT DES SOLDES INTERMEDIAIRES DE GESTION (E.S.G)\'));
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



				include DOL_DOCUMENT_ROOT . \'/custom/etatscomptables/codeCPC.php\';

				$table =
				\'
				<style>
				#customers {
				font-family: Arial, Helvetica, sans-serif;
				border-collapse: collapse;
				width: 100%;
				}

				#customers td, #customers th {
				border: 1px solid #ddd;
				padding: 8px;
				}

				#customers tr:nth-child(even){background-color: #f2f2f2;}

				#customers tr:hover {background-color: #ddd;}

				#customers th {
				padding-top: 12px;
				padding-bottom: 12px;
				text-align: left;
				background-color: #04AA6D;
				color: white;
				}
			</style>
					
			<table style="font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;margin-bottom:50px;">
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<th  style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color:rgb(38,60,92);color:white;">Poste</th>
			<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color:rgb(38,60,92);color:white;">Exercice</th>
			<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice Précédent</th>
			<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice N-2</th>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">CHARGES D EXPLOITATION</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Achats revendus de marchandises</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatRevMarch_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatRevMarch_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatRevMarch_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Achats de marchandises</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatMarch_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatMarch_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatMarch_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Variation des stocks de marchandises</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStock_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStock_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStock_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total1_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total1_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total1_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Achats consommés de matières et fournitures</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatConsMat_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatConsMat_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatConsMat_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Achats de matières premières</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatMatPre_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatMatPre_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatMatPre_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Variation des stocks de matières premières</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockMat_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockMat_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockMat_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Achats de matières et fournitures consommables et d emballages</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatMatFourn_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatMatFourn_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatMatFourn_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Variation des stocks de matières, fournitures et emballages</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockMatFourn_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockMatFourn_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockMatFourn_E,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Achats non stockés de matières et de fournitures</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatNonStockMat_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatNonStockMat_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatNonStockMat_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Achats de travaux, études et prestation de services</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatTravEtud_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatTravEtud_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achatTravEtud_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total2_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total2_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total2_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Autres charges externes</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autreCharg_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autreCharg_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autreCharg_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Locations et charges locatives</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($locatCharg_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($locatCharg_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($locatCharg_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Redevances de crédit-bail</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($redCred_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($redCred_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($redCred2_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Entretient et réparations</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($entreRepa_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($entreRepa_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($entreRepa_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Primes d assurances</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($primeAssur_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($primeAssur_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($primeAssur_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Rémunérations du personnel extérieur à l entreprise</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($remunePers_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($remunePers_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($remunePers_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Rémunérations d intermédiaires et honoraires</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($remuneInter_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($remuneInter_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($remuneInter2_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Redevances pour brevets, marque, droits ...</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($redevBrevet_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($redevBrevet_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($redevBrevet2_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Transports</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($trans_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($trans_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($trans_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Déplacements, missions et réceptions</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($deplacMiss_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($deplacMiss_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($deplacMiss_E2,2).\'</td>
			</tr>

			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<th  style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color:rgb(38,60,92);color:white;">Poste </th>
			<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color:rgb(38,60,92);color:white;">Exercice</th>
			<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice Précédent</th>
			<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice N-2</th>
			</tr>
			
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Reste du poste des autres charges externes</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPoste_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPoste_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPoste_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total3_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total3_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total3_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Charges de personnel</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chagePers_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chagePers_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chagePers_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Rémunération du personnel</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($remunePerso_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($remunePerso_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($remunePerso_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Charges sociales</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chageSocial_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chageSocial_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chageSocial_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Reste du poste des charges de personnel</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPosteCharg_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPosteCharg_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPosteCharg_E2,2).\'</td>
			</tr>


			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total </td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total4_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total4_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total4_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Autres charges d exploitation</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autreChargeExp_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autreChargeExp_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autreChargeExp_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Jetons de présence </td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($jetonPres_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($jetonPres_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($jetonPres_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Pertes sur créances irrécouvrables </td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($perteCre_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($perteCre_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($perteCre_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Reste du poste des autres charges d exploitation</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPosteChargExp_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPosteChargExp_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPosteChargExp_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total5_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total5_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total5_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">CHARGES FINANCIERES</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Autres charges financières</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autreChargFin_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autreChargFin_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autreChargFin_E2,2).\'</td>
			</tr>


			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Charges nettes sur cessions de titres et valeurs de placement</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chargeNet_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chargeNet_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chargeNet_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Reste du poste des autres charges financières </td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPosteFin_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPosteFin_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPosteFin_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($tatal6_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($tatal6_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($tatal6_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">CHARGES NON COURANTES</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Autres charges non courantes</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autreChargN_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autreChargN_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autreChargN_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Pénalités sur marchés et débits</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($penalMarch_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($penalMarch_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($penalMarch_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Rappels d impôts (autres qu impôts sur les résultats)Autres charges financières</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($rappelImpo_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($rappelImpo_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($rappelImpo_E2,2).\'</td>
			</tr>


			
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Pénalités et amendes fiscales et pénales</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($penalAmand_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($penalAmand_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($penalAmand_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Créances devenues irrécouvrables</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($creanDeven_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($creanDeven_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($creanDeven_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Reste du poste des autres charges non courantes</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restePosteNonC_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restePosteNonC_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restePosteNonC_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total7_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total7_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total7_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">PRODUITS D EXPLOITATION</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Ventes de marchandises</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteMarch_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteMarch_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteMarch_E,2).\'</td>
			</tr>


			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Ventes de marchandises au Maroc </td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($venteMarchMar_E),2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($venteMarchMar_E),2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($venteMarchMar_E),2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Ventes de marchandises à l étranger</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteMarchEtrg_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteMarchEtrg_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteMarchEtrg_E,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Reste du poste des ventes de marchandises </td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restePosteMarch_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restePosteMarch_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restePosteMarch_E,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total </td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total8_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total8_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total8_E,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Ventes des biens et services produits</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($venteBienServ_E),2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($venteBienServ_E),2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($venteBienServ_E),2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Ventes de biens au Maroc</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteBienMar_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteBienMar_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteBienMar_E,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Ventes de biens à l étranger</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteBienEtrg_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteBienEtrg_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteBienEtrg_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Ventes des services au Maroc</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteServMar_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteServMar_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteServMar_E,2).\'</td>
			</tr>
                    
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<th  style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color:rgb(38,60,92);color:white;">Poste </th>
			<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color:rgb(38,60,92);color:white;">Exercice</th>
			<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice Précédent</th>
			<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice N-2</th>
			</tr>

			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Ventes des services à l étranger</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteServEtrg_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteServEtrg_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venteServEtrg_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Redevances pour brevets, marques, droits ... </td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($redevBrevet_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($redevBrevet_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($redevBrevet_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Reste du poste des ventes et services produits</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPosteVente_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPosteVente_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restPosteVente_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total9_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total9_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total9_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Variation des stocks de produits</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($varStockProd_E),2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($varStockProd_EP),2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($varStockProd_E2),2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Variation des stocks de produits de produits en cours</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockProdC_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockProdC_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockProdC_E,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Variation des stocks de biens produits</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockBien_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockBien_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockBien_E,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Variation des stocks de services en cours</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockServ_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockServ_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varStockServ_E,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total </td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total10_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total10_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total10_E,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Autres produits d exploitation</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($autreProd_E),2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($autreProd_EP),2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($autreProd_E2),2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Jetons de présence reçus</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($jetoPre_E),2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($jetoPre_EP),2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($jetoPre_E2),2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Reste du poste (produits divers)</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restePoste_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restePoste_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restePoste_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total11_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total11_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total11_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Reprises d exploitation, transferts de charges</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($repriseExpl_E),2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($repriseExpl_EP),2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(-($repriseExpl_E2),2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Reprises</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reprise_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reprise_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reprise_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Transferts de charges</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($transCharg_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($transCharg_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($transCharg_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total12_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total12_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total12_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">PRODUITS FINANCIERS</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"></td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">>Intérêts et autres produits financier</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($interetAutre_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($interetAutre_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($interetAutre_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Intérêt et produits assimilés</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($interetProd_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($interetProd_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($interetProd_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Revenus des créances rattachées à des participations</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($revenuCrean_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($revenuCrean_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($revenuCrean_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Produits nets sur cessions de titres et valeurs de placement</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($produitNet_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($produitNet_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($produitNet_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">- Reste du poste intérêts et autres produits financiers</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restePosteIntert_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restePosteIntert_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($restePosteIntert_E2,2).\'</td>
			</tr>
			<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
			<td style="border: 1px solid #ddd;padding: 8px;">Total</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total13_E,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total13_EP,2).\'</td>
			<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($total13_E2,2).\'</td>
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

		$pdf->SetFont(\'\', \'B\', $default_font_size + 3);
		$pdf->MultiCell(200, 2, "DETAIL DES POSTES DU C.P.C.", 0, "C");
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