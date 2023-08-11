<?php


$contenthortaxes = '
<?php


require_once DOL_DOCUMENT_ROOT . \'/core/modules/user/modules_user.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/company.lib.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/functions2.lib.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/pdf.lib.php\';

require_once DOL_DOCUMENT_ROOT . \'/societe/class/companybankaccount.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/user/class/userbankaccount.class.php\'; 


class pdf_HorsTaxes extends ModelePDFUser
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
				$dir = DOL_DATA_ROOT . \'/billanLaisse/HorsTaxes/\';
			
				$file = $dir . "/Hors Taxes.pdf";
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

				$pdf->SetTitle($outputlangs->convToOutputCharset(\'Hors Taxes\'));
				$pdf->SetSubject($outputlangs->transnoentities("EtatAMO"));
				$pdf->SetCreator("Dolibarr " . DOL_VERSION);
				$pdf->SetAuthor($outputlangs->convToOutputCharset($user->getFullName($outputlangs)));
				if (!empty($conf->global->MAIN_DISABLE_PDF_COMPRESSION)) $pdf->SetCompression(false);

				$pdf->SetMargins($this->marge_gauche, $this->marge_haute, $this->marge_droite); // Left, Top, Right

				// New page
				$pdf->AddPage();
				if (!empty($tplidx)) $pdf->useTemplate($tplidx);
				$pagenb++;
				$totalNet = 0;
				$top = $this->_pagehead($pdf, $object, 1, $outputlangs, $totalNet, $periode);
				$pdf->SetY($pdf->GetY() + 10);
				$pdf->SetTextColor(0, 0, 0);

				$tab_top = 90;
				$tab_top_newpage = (empty($conf->global->MAIN_PDF_DONOTREPEAT_HEAD) ? 42 : 10);
		
				// body



				include DOL_DOCUMENT_ROOT . \'/custom/etatscomptables/HORTAXES/codeLaisseHORSTAXES.php\';

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
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color:rgb(38,60,92);color:white;">Eléments</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color:rgb(38,60,92);color:white;">Propres à l exercice</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Concernant les exercices précédents</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Totaux de l exercice</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice Précédent</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice N-2</th>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">I - PRODUITS D EXPLOITATION</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($prExPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reExTchCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reExTchToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reExTchExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reExTchExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Ventes de marchandises</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($veMarchPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($veMarchCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($veMarchToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($veMarchExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($veMarchExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Ventes de biens et services produits</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venBSPPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venBSPCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venBSPToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venBSPExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($venBSPExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Chiffres d affaires</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chAffPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chAffCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chAffToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chAffExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chAffExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Variation de stock de produits</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varSyProPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varSyProCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varSyProToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varSyProExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($varSyProExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Immobilisations produites pour l Ese p/elle même</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($imPrLePaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($imPrLeCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($imPrLeToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($imPrLeExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($imPrLeExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Subvention d exploitation</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($subEXPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($subEXCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($subEXToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($subEXExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($subEXExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Autres produits d exploitation</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auPrExPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auPrExCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auPrExToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auPrExExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auPrExExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Reprises d exploitation; transfert de charges</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reExTchPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reExTchCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reExTchToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reExTchExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reExTchExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">TOTAL I</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalICLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIExN2,2).\'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">II - CHARGES D EXPLOITATION</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Achats revendus de marchandises</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achReMPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achReMCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achReMToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achReMExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achReMExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Achat consommes de matières et de fournitures</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achCMDPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achCMDCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achCMDToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achCMDExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($achCMDExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Autres charges externes</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autChExPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autChExCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autChExToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autChExExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($autChExExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Impôts et taxes</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($imetPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($imetCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($imetToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($imetExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($imetExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Charges de personnel</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chPrPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chPrCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chPrToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chPrExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chPrExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Autres charges d exploitation</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auChExPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auChExCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auChExToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auChExExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auChExExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Dotations d exploitation</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($dExPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($dExCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($dExToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($dExExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($dExExN2,2).\'</td>
				</tr>


                <tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">   
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color:rgb(38,60,92);color:white;">Eléments</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color:rgb(38,60,92);color:white;">Propres à l exercice</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Concernant les exercices précédents</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Totaux de l exercice</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice Précédent</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice N-2</th>
				</tr>



				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">TOTAL  II</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIIPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIICLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIIToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIIExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIIExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">III - RESULTAT D EXPLOITATION  ( I - II )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reExI_IIToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reExI_IIExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reExI_IIExN2,2).\'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">IV - PRODUITS FINANCIERS</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Produits des titres de partic. et autres titres immo.</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($prTPPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($prTPCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($prTPToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($prTPExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($prTPExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Gains de changes</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($gaChPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($gaChCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($gaChToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($gaChExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($gaChExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Intérêts et autres produits financiers</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($inAPFPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($inAPFCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($inAPFToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($inAPFExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($inAPFExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Reprises financières; transfert de charges</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reFTChPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reFTChCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reFTChToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reFTChExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reFTChExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">TOTAL  IV</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIVPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIVCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIVToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIVExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIVExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">V - CHARGES FINANCIERES</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Charges d intérêts</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chiPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chiCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chiToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chiExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($chiExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Pertes de changes</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($peChPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($peChCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($peChToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($peChExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($peChExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Autres charges financières</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auChFPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auChFCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auChFToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auChFExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auChFExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Dotations financières</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($doFPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($doFCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($doFToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($doFExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($doFExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">TOTAL  V</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalVPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalVCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalVToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalVExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalVExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">VI - RESULTAT FINANCIER ( IV - V )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reFToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reFExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reFExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">VII - RESULTAT COURANT ( III - V I)</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reCoToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reCoExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reCoExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">VII - RESULTAT COURANT ( Report )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reTCToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reTCExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reTCExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">VIII - PRODUITS NON COURANTS</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Produits des cessions d immobilisations</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($proDCIPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($proDCICLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($proDCIToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($proDCIExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($proDCIExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Subventions d équilibre</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($subDEPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($subDECLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($subDEToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($subDEExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($subDEExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Reprises sur subventions d investissement</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reSDPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reSDCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reSDToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reSDExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reSDExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Autres produits non courants</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auPrCPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auPrCCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auPrCToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auPrCExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auPrCExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Reprises non courantes; transferts de charges</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reCTCPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reCTCCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reCTCToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reCTCExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($reCTCExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">TOTAL  VIII</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalVIIIPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalVIIICLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalVIIIToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalVIIIExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalVIIIExN2,2).\'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">   
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color:rgb(38,60,92);color:white;">Eléments</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color:rgb(38,60,92);color:white;">Propres à l exercice</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Concernant les exercices précédents</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Totaux de l exercice</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice Précédent</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice N-2</th>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">IX - CHARGES NON COURANTES</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">&nbsp;</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Valeurs nettes d amortis. des immos cédées</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($vaNAICPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($vaNAICCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($vaNAICToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($vaNAICExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($vaNAICExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Subventions accordées</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($suAcPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($suAcCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($suAcToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($suAcExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($suAcExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Autres charges non courantes</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auCNCPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auCNCCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auCNCToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auCNCExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($auCNCExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Dotations non courantes aux amortiss. et prov.</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($daCAPPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($daCAPCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($daCAPToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($daCAPExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($daCAPExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">TOTAL  IX</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIXPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIXCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIXToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIXExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($totalIXExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">X - RESULTAT NON COURANT ( VIII- IV )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($XReNCToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($XReNCExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($XReNCExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">XI - RESULTAT AVANT IMPOTS ( VII+ X )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xiResulAIToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xiResulAIExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xiResulAIExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">XII - IMPOTS SUR LES RESULTATS</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xiiIMSLRPaLex,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xiiIMSLRCLExPr,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xiiIMSLRToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xiiIMSLRExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xiiIMSLRExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">XIII - RESULTAT NET ( XI - XII )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xiiReNToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xiiReNExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xiiReNExN2,2).\'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">XIV - TOTAL DES PRODUITS ( I + IV + VIII )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xivToDPrToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xivToDPrExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xivToDPrExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">XV - TOTAL DES CHARGES ( II + V + IX + XII )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xvToDCHToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xvToDCHExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xvToDCHExN2,2).\'</td>
				</tr>
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">XVI - RESULTAT NET ( XIV - XV )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format(0,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xviReNToEx,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xviReNExPre,2).\'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">\'.number_format($xviReNExN2,2).\'</td>
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
		$pdf->MultiCell(200, 2, "Hors Taxes", 0, "C");
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