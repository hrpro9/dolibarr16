
<?php


require_once DOL_DOCUMENT_ROOT . '/core/modules/user/modules_user.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/company.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/pdf.lib.php';

require_once DOL_DOCUMENT_ROOT . '/societe/class/companybankaccount.class.php';
require_once DOL_DOCUMENT_ROOT . '/user/class/userbankaccount.class.php'; 


class pdf_Active extends ModelePDFUser
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
				$dir = DOL_DATA_ROOT . '/billanLaisse/billan_Active/';

				$year=GETPOST('valeurdatechoise');
			
				
			
				$file = $dir . "/Billan Actif".$year . ".pdf";
			
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

				$pdf->SetTitle($outputlangs->convToOutputCharset('Bilan Active'));
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

				include DOL_DOCUMENT_ROOT . '/custom/etatscomptables/Actif/codeLaisseActive.php';

				$table =
				'
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
					padding-top:0px;
					padding-bottom: 0px;
					text-align: center;
					background-color: #04AA6D;
					color: white;
					}
				</style>
						
				<table style="font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;margin-bottom:50px;">

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding:0px;">
				<th  style="padding-top: 0px;padding-bottom: 0px;text-align: center;background-color:rgb(38,60,92);color:white;">&nbsp;</th>
				<th  style="padding-top: 0px;padding-bottom: 0px;text-align: center;background-color:rgb(38,60,92);color:white;">Brut</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align: center;background-color:rgb(38,60,92);color:white;">Amort &amp; Prov</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align: center;background-color:rgb(38,60,92);color:white;">Net</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align: center;background-color: rgb(38,60,92);color:white;">Exercice Précédent</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align: center;background-color: rgb(38,60,92);color:white;">Exercice N-2</th>
				</tr>
				
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">IMMOBILISATION EN NON VALEUR ( a )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immNonVal_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immNonVal_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immNonVal_net,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immNonVal_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immNonVal_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">Frais préliminaires</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($fraisP_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($fraisP_AP*-1),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($fraisP_B-($fraisP_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($fraisP_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($fraisP_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Charges à repartir sur plusieurs exercices</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($chargesR_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($chargesR_AP*-1),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($chargesR_B-($chargesR_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($chargesR_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($chargesR_E2,2).'</td>
				</tr>
			

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Primes de remboursement des obligations</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($primesR_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($primesR_AP*-1),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($primesR_B-($primesR_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($primesR_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($primesR_E2,2).'</td>
				</tr>
			
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">IMMOBILISATIONS INCORPORELLES ( b )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immIncor_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($immIncor_AP*-1),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immIncor_net,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immIncor_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immIncor_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Immobilisations en recherche et développement</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immReche_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immReche_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($immReche_B-$immReche_AP),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immReche_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immReche_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Brevets, marques, droits et valeurs similaires</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($BMD_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($BMD_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($BMD_B-$BMD_AP),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($BMD_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($BMD_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Fonds commercial</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($fondsC_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($fondsC_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($fondsC_B-$fondsC_AP),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($fondsC_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($fondsC_E2,2).'</td>
				</tr>

				
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Autres immobilisations incorporelles</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresImmoInc_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresImmoInc_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($autresImmoInc_B-$autresImmoInc_AP),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresImmoInc_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresImmoInc_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">IMMOBILISATIONS CORPORELLES ( c )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immCor_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immCor_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immCor_net,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immCor_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immCor_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Terrains</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($terrains_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($terrains_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($terrains_B-$terrains_AP),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($terrains_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($terrains_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Constructions</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($cons_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($cons_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($cons_B-$cons_AP),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($cons_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($cons_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Installations techniques, matériel et outillage</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($instalTechMat_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($instalTechMat_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($instalTechMat_B-$instalTechMat_AP),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($instalTechMat_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($instalTechMat_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Matériel de transport</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($matTransp_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($matTransp_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($matTransp_B-$matTransp_AP),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($matTransp_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($matTransp_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Mobiliers, matériel de bureau et aménagements divers</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($mobMatAmenag_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($mobMatAmenag_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($mobMatAmenag_B-$mobMatAmenag_AP),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($mobMatAmenag_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($mobMatAmenag_E2,2).'</td>
				</tr>';


				$table .='	<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color:rgb(38,60,92);color:white;">&nbsp;</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color:rgb(38,60,92);color:white;">Brut</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color:rgb(38,60,92);color:white;">Amort &amp; Prov</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color:rgb(38,60,92);color:white;">Net</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice Précédent</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice N-2</th>
				</tr>
			

                <tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Autres immobilisations corporelles</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresImmoCor_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresImmoCor_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($autresImmoCor_B-$autresImmoCor_AP),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresImmoCor_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresImmoCor_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Immobilisations corporelles en cours</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immCorEnCours_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immCorEnCours_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($immCorEnCours_B-$immCorEnCours_AP),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immCorEnCours_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immCorEnCours_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">IMMOBILISATIONS FINANCIERES ( d )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immFin_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immFin_AP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immFin_net,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immFin_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($immFin_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Prêts immobilisés</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($pretsImm_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($pretsImm_AP*-1),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($pretsImm_B-($pretsImm_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($pretsImm_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($pretsImm_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Autres créances financières</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresCreFin_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($autresCreFin_AP*-1),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($autresCreFin_B-($autresCreFin_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresCreFin_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresCreFin_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Titres de participation</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($titresP_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($titresP_AP*-1),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($titresP_B-($titresP_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($titresP_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($titresP_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Autres titres immobilisés</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresTitrImm_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($autresTitrImm_AP*-1),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($autresTitrImm_B-($autresTitrImm_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresTitrImm_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresTitrImm_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">ECARTS DE CONVERSION - ACTIF ( e )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($ecratsConv_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"> </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($ecratsConv_net,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($ecratsConv_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($ecratsConv_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Diminution des créances immobilisées</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($dimCreImm_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"> </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($dimCreImm_B-0),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($dimCreImm_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($dimCreImm_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Augmentation des dettes de financement</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($augDetFinc_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"> </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($augDetFinc_B-0),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($augDetFinc_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($augDetFinc_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">TOTAL  I   ( a + b + c + d + e )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total1_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total1_AP,2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total1_net,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total1_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total1_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">STOCKS ( f )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($stocks_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($stocks_AP,2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($stocks_net,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($stocks_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($stocks_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Marchandises</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($march_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($march_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($march_B-($march_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($march_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($march_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Matières et fournitures consommables</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($matFournCon_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($matFournCon_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($matFournCon_B-($matFournCon_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($matFournCon_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($matFournCon_E2,2).'</td>
				</tr>

				
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Produits en cours</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($prodC_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($prodC_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($prodC_B-($prodC_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($prodC_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($prodC_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Produits intermédiaires et produits residuels</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($prodIntrProd_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($prodIntrProd_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($prodIntrProd_B-($prodIntrProd_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($prodIntrProd_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($prodIntrProd_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Produits finis</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($prodFinis_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($prodFinis_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($prodFinis_B-($prodFinis_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($prodFinis_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($prodFinis_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">CREANCES DE L ACTIF CIRCULANT ( g )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($creActifCircl_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($creActifCircl_AP,2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($creActifCircl_net,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($creActifCircl_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($creActifCircl_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Fournisseurs débiteurs, avances et acomptes</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($fournDAA_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($fournDAA_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($fournDAA_B-($fournDAA_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($fournDAA_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($fournDAA_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Clients et comptes rattachés</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($clientCR_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($clientCR_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($clientCR_B-($clientCR_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($clientCR_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($clientCR_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Personnel</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($persl_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($persl_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($persl_B-($persl_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($persl_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($persl_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Etat</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($etat_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($etat_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($etat_B-($etat_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($etat_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($etat_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Comptes d associés</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($comptAss_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($comptAss_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($comptAss_B-($comptAss_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($comptAss_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($comptAss_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Autres débiteurs</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresDebit_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresDebit_AP,2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($autresDebit_B-($autresDebit_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresDebit_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($autresDebit_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Comptes de régularisation actif</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($comptRegAct_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($comptRegAct_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($comptRegAct_B-($comptRegAct_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($comptRegAct_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($comptRegAct_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">TITRES ET VALEURS DE PLACEMENT ( h )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($titreValPlace_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($titreValPlace_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($titreValPlace_B-($titreValPlace_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($titreValPlace_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($titreValPlace_E2,2).'</td>
				</tr>';



				$table .='	<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color:rgb(38,60,92);color:white;">&nbsp;</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color:rgb(38,60,92);color:white;">Brut</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color:rgb(38,60,92);color:white;">Amort &amp; Prov</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color:rgb(38,60,92);color:white;">Net</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice Précédent</th>
				<th  style="padding-top: 12px;padding-bottom: 12px;text-align:center;background-color: rgb(38,60,92);color:white;">Exercice N-2</th>
				</tr>
			

                <tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">ECART DE CONVERSION - ACTIF ( i )<span style="color:#000000; font-family:"Calibri"; font-size:11pt"> (Elém. Circul.)</span></td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($ecratConverAct_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;"> </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($ecratConverAct_B-0),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($ecratConverAct_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($ecratConverAct_E2,2).'</td>
				</tr>
				
				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">TOTAL  II   (  f + g + h + i )</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total2_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total2_AP,2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total2_net,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total2_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total2_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">TRESORERIE - ACTIF</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($tresorAct_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($tresorAct_AP,2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($tresorAct_net,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($tresorAct_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($tresorAct_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Chèques et valeurs à encaisser</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($chqValEnc_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($chqValEnc_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($chqValEnc_B-($chqValEnc_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($chqValEnc_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($chqValEnc_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Banques, T.G &amp; CP</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($banqTGCP_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($banqTGCP_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($banqTGCP_B-($banqTGCP_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($banqTGCP_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($banqTGCP_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">Caisses, régies d avances et accréditifs</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($caissRegAv_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($caissRegAv_AP*-1),2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format(($caissRegAv_B-($caissRegAv_AP*-1)),2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($caissRegAv_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($caissRegAv_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">TOTAL  III</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total3_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total3_AP,2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total3_net,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total3_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($total3_E2,2).'</td>
				</tr>

				<tr style="background-color: #f2f2f2;border: 1px solid #ddd;padding: 8px;">
				<td style="border: 1px solid #ddd;padding: 8px;">TOTAL GENERAL  I+II+III</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($totalGen_B,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($totalGen_AP,2).' </td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($totalGen_net,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($totalGen_EP,2).'</td>
				<td style="border: 1px solid #ddd;padding: 8px;text-align:center;">'.number_format($totalGen_E2,2).'</td>
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

		$pdf->SetFont('', 'B', $default_font_size + 3);
		$pdf->MultiCell(200, 2, "Billan Actif", 0, "C");
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

			