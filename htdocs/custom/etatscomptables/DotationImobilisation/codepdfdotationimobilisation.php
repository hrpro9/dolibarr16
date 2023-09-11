<?php


$contentdotationimobilisation = '
<?php


require_once DOL_DOCUMENT_ROOT . \'/core/modules/user/modules_user.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/company.lib.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/functions2.lib.php\';
require_once DOL_DOCUMENT_ROOT . \'/core/lib/pdf.lib.php\';

require_once DOL_DOCUMENT_ROOT . \'/societe/class/companybankaccount.class.php\';
require_once DOL_DOCUMENT_ROOT . \'/user/class/userbankaccount.class.php\'; 


class pdf_Dotationimobilisation extends ModelePDFUser
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
				$dir = DOL_DATA_ROOT . \'/billanLaisse/Dotationimobilisation/\';
			
				$year=GETPOST(\'year\');
			
				$file = $dir . "/Dotationimobilisation".$year . ".pdf";
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

				$pdf->SetTitle($outputlangs->convToOutputCharset(\'Dotation imobilisationL\'));
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

				$year=GETPOST(\'year\');

				include DOL_DOCUMENT_ROOT . \'/custom/etatscomptables/DotationImobilisation/Dotationimobilisation_fichier_\'.$year.\'.php\';

				

				$table =
				\'
				<style >			
				.gridlines td { border:1px dotted black }
				.gridlines th { border:1px dotted black }
			</style>
									
		
			<table border="1">
        <tbody>
          <tr class="row0">
            <td class="column0 style1  style3" colspan="10">ETAT DE DOTATIONS AUX AMORTISSEMENTS RELATIFS AUX IMMOBILISATIONS</td>
          </tr>
          <tr class="row7">
            <td class="column0 style28 s">Total</td>
            <td class="column1 style29 null"></td>
            <td class="column2 style30 f">\'.  $sum1 .\'</td>
            <td class="column3 style31 null"></td>
            <td class="column4 style30 f">\'. $sum2 .\'</td>
            <td class="column5 style32 null"></td>
            <td class="column6 style33 null"></td>
            <td class="column7 style30 f">\'. $sum3 .\'</td>
            <td class="column8 style30 f">\'. $sum4 .\'</td>
            <td class="column9 style34 null"></td>

          </tr>
          <tr class="row8">
            <td class="column0 style39 s style41" >Immobilisations concernées</td>
            <td class="column1 style39 s style41" >Date d entrée (1)</td>
            <td class="column2 style39 s style41">Prix d acquisition (2)</td>
            <td class="column3 style39 s style41" >Valeur comptable après réévaluation</td>
            <td class="column4 style39 s style41" >Amortissements antérieurs (3)</td>
            <td class="column5 style39 s style41" >Taux en %</td>
            <td class="column6 style39 s style41" >Durée en années (4)</td>
            <td class="column7 style39 s style41" >Amortissements de l exercice</td>
            <td class="column8 style39 s style41" >Cumul amortissements (col. 4 + col. 7)</td>
            <td class="column9 style39 s style41" >Observations (5)</td>
          </tr>
          \';
		
			$table .= \'<tr class="row190">
			<td class="column0 style46 null">Frais de constitution</td>\';

			for ($i = 0; $i <= 6; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
			}

			$table .= \'<td class="column8 style50 f">\' . $cumul1 . \'</td>
			<td class="column9 style48 null">\' . $dotationimobilisation7 . \'</td>
			</tr>\';

			$table .= \'<tr class="row190">
			<td class="column0 style46 null">Frais prealables au demarrage</td>\';

			for ($i = 8; $i <= 14; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
			}

			$table .= \'<td class="column8 style50 f">\' . $cumul2 . \'</td>
			<td class="column9 style48 null">\' . $dotationimobilisation15 . \'</td>
			</tr>\';

			$table .= \'<tr class="row190">
			<td class="column0 style46 null">Frais d\'augmentation du capital</td>\';

			for ($i = 16; $i <= 22; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
			}

			$table .= \'<td class="column8 style50 f">\' . $cumul3 . \'</td>
			<td class="column9 style48 null">\' . $dotationimobilisation23 . \'</td>
			</tr>\';

          $table .= \'<tr class="row190">
            <td class="column0 style46 null">Frais operations de fusions, scissions</td>\';

			for ($i = 24; $i <= 30; $i++) {
				$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
			}

			$table .= \'<td class="column8 style50 f">\' . $cumul4 . \'</td>
						<td class="column9 style48 null">\' . $dotationimobilisation31 . \'</td>
					</tr>\';

			$table .= \'<tr class="row190">
						<td class="column0 style46 null">Frais de prospection</td>\';

			for ($i = 32; $i <= 38; $i++) {
				$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
			}

			$table .= \'<td class="column8 style50 f">\' . $cumul5 . \'</td>
						<td class="column9 style48 null">\' . $dotationimobilisation39 . \'</td>
					</tr>\';

			$table .= \'<tr class="row190">
						<td class="column0 style46 null">Frais de publicite</td>\';

			for ($i = 40; $i <= 46; $i++) {
				$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
			}

			$table .= \'<td class="column8 style50 f">\' . $cumul6 . \'</td>
						<td class="column9 style48 null">\' . $dotationimobilisation47 . \'</td>
					</tr>\';

					$table .= \'<tr class="row190">
					<td class="column0 style46 null">Autres frais preliminaires</td>\';
		
		for ($i = 48; $i <= 54; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}
		
		$table .= \'<td class="column8 style50 f">\' . $cumul7 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation55 . \'</td>
				  </tr>\';
		
		$table .= \'<tr class="row190">
					<td class="column0 style46 null">Frais d\'acquisition des immobilisations</td>\';
		
		for ($i = 56; $i <= 62; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}
		
		$table .= \'<td class="column8 style50 f">\' . $cumul8 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation63 . \'</td>
				  </tr>\';
		
		$table .= \'<tr class="row190">
					<td class="column0 style46 null">Frais d\'emission des emprunts</td>\';
		
		for ($i = 64; $i <= 70; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}
		
		$table .= \'<td class="column8 style50 f">\' . $cumul9 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation71 . \'</td>
				  </tr>\';
		
		$table .= \'<tr class="row190">
					<td class="column0 style46 null">Autres charges à repartir</td>\';
		
		for ($i = 72; $i <= 78; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}
		
		$table .= \'<td class="column8 style50 f">\' . $cumul10 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation79 . \'</td>
				  </tr>\';
		
				  $table .= \'<tr class="row190">
				  <td class="column0 style46 null">Primes de remboursement des obligations</td>\';
	  
	  for ($i = 80; $i <= 86; $i++) {
		  $table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
	  }
	  
	  $table .= \'<td class="column8 style50 f">\' . $cumul11 . \'</td>
				  <td class="column9 style48 null">\' . $dotationimobilisation87 . \'</td>
				</tr>\';
	  
	  $table .= \'<tr class="row190">
				  <td class="column0 style46 null">Immob en recherche et developpement</td>\';
	  
	  for ($i = 88; $i <= 94; $i++) {
		  $table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
	  }
	  
	  $table .= \'<td class="column8 style50 f">\' . $cumul12 . \'</td>
				  <td class="column9 style48 null">\' . $dotationimobilisation95 . \'</td>
				</tr>\';
	  
	  $table .= \'<tr class="row190">
				  <td class="column0 style46 null">Terrains nus</td>\';
	  
	  for ($i = 96; $i <= 102; $i++) {
		  $table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
	  }
	  
	  $table .= \'<td class="column8 style50 f">\' . $cumul13 . \'</td>
				  <td class="column9 style48 null">\' . $dotationimobilisation103 . \'</td>
				</tr>\';
	  
	  $table .= \'<tr class="row190">
				  <td class="column0 style46 null">Terrains amenages</td>\';
	  
	  for ($i = 104; $i <= 110; $i++) {
		  $table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
	  }
	  
	  $table .= \'<td class="column8 style50 f">\' . $cumul14 . \'</td>
				  <td class="column9 style48 null">\' . $dotationimobilisation111 . \'</td>
				</tr>\';
	  
	  $table .= \'<tr class="row190">
				  <td class="column0 style46 null">Terrains batis</td>\';
	  
	  for ($i = 112; $i <= 118; $i++) {
		  $table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
	  }
	  
	  $table .= \'<td class="column8 style50 f">\' . $cumul15 . \'</td>
				  <td class="column9 style48 null">\' . $dotationimobilisation119 . \'</td>
				</tr>\';
	$table .= \'<tr class="row190">
	<td class="column0 style46 null">Agencements et amenagements de terrains</td>\';

		for ($i = 120; $i <= 126; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}

		$table .= \'<td class="column8 style50 f">\' . $cumul16 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation127 . \'</td>
				</tr>\';

		$table .= \'<tr class="row190">
					<td class="column0 style46 null">Batiments</td>\';

		for ($i = 128; $i <= 134; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}

		$table .= \'<td class="column8 style50 f">\' . $cumul17 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation135 . \'</td>
				</tr>\';

		$table .= \'<tr class="row190">
					<td class="column0 style46 null">Constructions sur terrains d\'autrui</td>\';

		for ($i = 136; $i <= 142; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}

		$table .= \'<td class="column8 style50 f">\' . $cumul18 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation143 . \'</td>
				</tr>\';

				$table .= \'<tr class="row190">
				<td class="column0 style46 null">Ouvrages d\'infrastructure</td>\';
	
		for ($i = 144; $i <= 150; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}
		
		$table .= \'<td class="column8 style50 f">\' . $cumul19 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation151 . \'</td>
				</tr>\';
		
		$table .= \'<tr class="row190">
					<td class="column0 style46 null">Agencements et amenag des constructions</td>\';
		
		for ($i = 152; $i <= 158; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}
		
		$table .= \'<td class="column8 style50 f">\' . $cumul20 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation159 . \'</td>
				</tr>\';
		
		$table .= \'<tr class="row190">
					<td class="column0 style46 null">Autres constructions</td>\';
		
		for ($i = 160; $i <= 166; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}
		
		$table .= \'<td class="column8 style50 f">\' . $cumul21 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation167 . \'</td>
				</tr>\';
		
		$table .= \'<tr class="row190">
					<td class="column0 style46 null">Installations techniques</td>\';
		
		for ($i = 168; $i <= 174; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}
		
		$table .= \'<td class="column8 style50 f">\' . $cumul22 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation175 . \'</td>
			  </tr>\';
	
			  $table .= \'<tr class="row190">
			  <td class="column0 style46 null">Materiel et outillage</td>\';
  
		for ($i = 176; $i <= 182; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}
		
		$table .= \'<td class="column8 style50 f">\' . $cumul23 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation183 . \'</td>
					</tr>\';
		
		$table .= \'<tr class="row190">
					<td class="column0 style46 null">Emballages recuperables identifiables</td>\';
		
		for ($i = 184; $i <= 190; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}
		
		$table .= \'<td class="column8 style50 f">\' . $cumul24 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation191 . \'</td>
					</tr>\';
		
		$table .= \'<tr class="row190">
					<td class="column0 style46 null">Autres instal techniques, mat. et outillage</td>\';
		
		for ($i = 192; $i <= 198; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}
		
		$table .= \'<td class="column8 style50 f">\' . $cumul25 . \'</td>
					<td class="column9 style48 null">\' . $dotationimobilisation199 . \'</td>
					</tr>\';
		
		$table .= \'<tr class="row190">
					<td class="column0 style46 null">Materiel de transport</td>\';
		
		for ($i = 200; $i <= 206; $i++) {
			$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
		}
		
		$table .= \'<td class="column8 style50 f">\' . $cumul26 . \'</td>
			  <td class="column9 style48 null">\' . $dotationimobilisation207 . \'</td>
			</tr>\';
  
			$table .= \'<tr class="row190">
            <td class="column0 style46 null">Mobilier de bureau</td>\';

			for ($i = 208; $i <= 214; $i++) {
				$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
			}

			$table .= \'<td class="column8 style50 f">\' . $cumul27 . \'</td>
						<td class="column9 style48 null">\' . $dotationimobilisation215 . \'</td>
					</tr>\';

			$table .= \'<tr class="row190">
						<td class="column0 style46 null">Materiel de bureau</td>\';

			for ($i = 216; $i <= 222; $i++) {
				$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
			}

			$table .= \'<td class="column8 style50 f">\' . $cumul28 . \'</td>
						<td class="column9 style48 null">\' . $dotationimobilisation223 . \'</td>
					</tr>\';

			$table .= \'<tr class="row190">
						<td class="column0 style46 null">Materiel informatique</td>\';

			for ($i = 224; $i <= 230; $i++) {
				$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
			}

			$table .= \'<td class="column8 style50 f">\' . $cumul29 . \'</td>
						<td class="column9 style48 null">\' . $dotationimobilisation231 . \'</td>
					</tr>\';

			$table .= \'<tr class="row190">
						<td class="column0 style46 null">Agencements installations et aménagements divers</td>\';

			for ($i = 232; $i <= 238; $i++) {
				$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
			}

			$table .= \'<td class="column8 style50 f">\' . $cumul30 . \'</td>
						<td class="column9 style48 null">\' . $dotationimobilisation239 . \'</td>
					</tr>\';

			$table .= \'<tr class="row190">
						<td class="column0 style46 null">Autres immobilisations corporelles</td>\';

			for ($i = 240; $i <= 246; $i++) {
				$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n";
			}

			$table .= \'<td class="column8 style50 f">\' . $cumul31 . \'</td>
						<td class="column9 style48 null">\' . $dotationimobilisation247 . \'</td>
					</tr>
        </tbody>
    </table>\'; // Replace with your actual table HTML

				$pdf->SetFont(\'\', \'\', $default_font_size);
				$pdf->SetY($pdf->GetY() + 6);
				$pdf->SetX($this->posxdesc + 6);
				$pdf->writeHTML($table);

				// Pagefoot
				$this->_pagefoot($pdf, $object, $outputlangs);
				if (method_exists($pdf, \'AliasNbPages\')) $pdf->AliasNbPages();


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

				$year=GETPOST(\'year\');

				include DOL_DOCUMENT_ROOT . \'/custom/etatscomptables/DotationImobilisation\Dotationimobilisation_fichier_\'.$year.\'.php\';

				$table =
			\'
			<style >			
				.gridlines td { border:1px dotted black }
				.gridlines th { border:1px dotted black }
			</style>
			
			<table border="1">
        <tbody>
          <tr class="row0">
            <td class="column0 style1  style3" colspan="8">ETAT DE DOTATIONS AUX AMORTISSEMENTS RELATIFS AUX IMMOBILISATIONS</td>
          </tr>
		<tr class="row8">
		<td class="column1 style39 s style41" >Compte Actif</td>
		<td class="column2 style39 s style41">Compte Amort</td>
		<td class="column3 style39 s style41" >Compte Charge</td>
		<td class="column0 style39 s style41" >Immobilisations </td>
		<td class="column1 style39 s style41" >Total Immob</td>
		<td class="column2 style39 s style41">Total Amort Anterieur</td>
		<td class="column3 style39 s style41" >Total Amort exercice</td>
		<td class="column4 style39 s style41" >Total Cumul amort</td>
        </tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">21110000</td>
		<td class="column0 style46 null">28111000</td>
		<td class="column0 style46 null">61911000</td>
		<td class="column0 style46 null">Frais de constitution</td>\';
		for ($i = 249; $i <= 252; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">21120000</td>
		<td class="column0 style46 null">28112000</td>
		<td class="column0 style46 null">61911000</td>
		<td class="column0 style46 null">Frais prealables au demarrage</td>
		\';
		for ($i = 253; $i <= 256; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">21130000</td>
		<td class="column0 style46 null">28113000</td>
		<td class="column0 style46 null">61911000</td>
		  <td class="column0 style46 null">Frais d augmentation du capital</td>
		\';
		for ($i = 257; $i <= 260; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">21140000</td>
		<td class="column0 style46 null">28114000</td>
		<td class="column0 style46 null">61911000</td>
		  <td class="column0 style46 null">Frais operations de fusions, scissions</td>
		\';
		for ($i = 261; $i <= 264; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">21160000</td>
		<td class="column0 style46 null">28116000</td>
		<td class="column0 style46 null">61911000</td>
		  <td class="column0 style46 null">Frais de prospection</td>
		\';
		for ($i = 265; $i <= 268; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">21170000</td>
		<td class="column0 style46 null">28117000</td>
		<td class="column0 style46 null">61911000</td>
		  <td class="column0 style46 null">Frais de publicite</td>
		\';
		for ($i = 269; $i <= 272; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">21180000</td>
		<td class="column0 style46 null">28118000</td>
		<td class="column0 style46 null">61911000</td>
		<td class="column0 style46 null">Autres frais preliminaires</td>
		\';
		for ($i = 273; $i <= 276; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">21210000</td>
		<td class="column0 style46 null">28121000</td>
		<td class="column0 style46 null">61912000</td>
		  <td class="column0 style46 null">Frais d acquisition des immobilisations</td>
		\';
		for ($i = 277; $i <= 280; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">21250000</td>
		<td class="column0 style46 null">28125000</td>
		<td class="column0 style46 null">61912000</td>
		  <td class="column0 style46 null">Frais d emission des emprunts</td>
		\';
		for ($i = 281; $i <= 284; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		 <td class="column0 style46 null">21280000</td>
          <td class="column0 style46 null">28128000</td>
          <td class="column0 style46 null">61912000</td>
            <td class="column0 style46 null">Autres charges à repartir</td>
		\';
		for ($i = 285; $i <= 288; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">21300000</td>
		<td class="column0 style46 null">28130000</td>
		<td class="column0 style46 null">63910000</td>
		  <td class="column0 style46 null">Primes de remboursement des obligations</td>
		\';
		for ($i = 289; $i <= 292; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">22100000</td>
		<td class="column0 style46 null">28210000</td>
		<td class="column0 style46 null">61921000</td>
		  <td class="column0 style46 null">Immob en recherche et developpement</td>
		\';
		for ($i = 293; $i <= 296; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23110000</td>
		<td class="column0 style46 null">28311000</td>
		<td class="column0 style46 null">61931000</td>
		  <td class="column0 style46 null">Terrains nus</td>
		\';
		for ($i = 297; $i <=300; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} .\'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23120000</td>
		<td class="column0 style46 null">28312000</td>
		<td class="column0 style46 null">61931000</td>
		<td class="column0 style46 null">Terrains amenages</td>
		\';
		for ($i = 301; $i <=304; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23130000</td>
		<td class="column0 style46 null">28313000</td>
		<td class="column0 style46 null">61931000</td>
		<td class="column0 style46 null">Terrains batis</td>
		\';
		for ($i = 305; $i <=308; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23160000</td>
		<td class="column0 style46 null">28316000</td>
		<td class="column0 style46 null">61932000</td>
		<td class="column0 style46 null">Agencements et amenagements de terrains</td>
		\';
		for ($i = 309; $i <=312; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
        $table .= \'<tr class="row190">
		<td class="column0 style46 null">23210000</td>
		<td class="column0 style46 null">28321000</td>
		<td class="column0 style46 null">61932000</td>
		  <td class="column0 style46 null">Batiments</td>
		\';
		for ($i = 313; $i <=316; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23230000</td>
		<td class="column0 style46 null">28323000</td>
		<td class="column0 style46 null">61932000</td>
		<td class="column0 style46 null">Constructions sur terrains d autrui</td>
		\';
		for ($i = 317; $i <=320; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23250000</td>
		<td class="column0 style46 null">28325000</td>
		<td class="column0 style46 null">61932000</td>
		  <td class="column0 style46 null">Ouvrages d infrastructure</td>
		\';
		for ($i = 321; $i <=324; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23270000</td>
		<td class="column0 style46 null">28327000</td>
		<td class="column0 style46 null">61932000</td>
		  <td class="column0 style46 null">Agencements et amenag des constructions</td>
		\';
		for ($i = 325; $i <=328; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		  <td class="column0 style46 null">23280000</td>
          <td class="column0 style46 null">28328000</td>
          <td class="column0 style46 null">61932000</td>
            <td class="column0 style46 null">Autres constructions</td>
		\';
		for ($i = 329; $i <=332; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23310000</td>
		<td class="column0 style46 null">28331000</td>
		<td class="column0 style46 null">61933000</td>
		  <td class="column0 style46 null">Installations techniques</td>
		\';
		for ($i = 333; $i <=336; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23320000</td>
		<td class="column0 style46 null">28332000</td>
		<td class="column0 style46 null">61933000</td>
		<td class="column0 style46 null">Materiel et outillage</td>
		\';
		for ($i = 337; $i <=340; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23330000</td>
		<td class="column0 style46 null">28333000</td>
		<td class="column0 style46 null">61933000</td>
		  <td class="column0 style46 null">Emballages recuperables identifiables</td>
		\';
		for ($i = 341; $i <=344; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23380000</td>
		<td class="column0 style46 null">28338000</td>
		<td class="column0 style46 null">61933000</td>
		  <td class="column0 style46 null">Autres instal techniques, mat. et outillage</td>
		\';
		for ($i = 345; $i <=348; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23400000</td>
		<td class="column0 style46 null">28340000</td>
		<td class="column0 style46 null">61934000</td>
		  <td class="column0 style46 null">Materiel de transport </td>
		\';
		for ($i = 349; $i <=352; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23510000</td>
		<td class="column0 style46 null">28351000</td>
		<td class="column0 style46 null">61935000</td>
		<td class="column0 style46 null">Mobilier de bureau </td>
		\';
		for ($i = 353; $i <=356; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23520000</td>
		<td class="column0 style46 null">28352000</td>
		<td class="column0 style46 null">61935000</td>
		  <td class="column0 style46 null">Materiel de bureau</td>
		\';
		for ($i = 357; $i <=360; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23550000</td>
		<td class="column0 style46 null">28355000</td>
		<td class="column0 style46 null">61935000</td>
		<td class="column0 style46 null">Materiel informatique</td>
		\';
		for ($i = 361; $i <=364; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';
		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23560000</td>
		<td class="column0 style46 null">28358000</td>
		<td class="column0 style46 null">61935000</td>
		  <td class="column0 style46 null">Agencements installations et aménagements divers</td>
		\';
		for ($i = 365; $i <=368; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';

		$table .= \'<tr class="row190">
		<td class="column0 style46 null">23800000</td>
		<td class="column0 style46 null">28380000</td>
		<td class="column0 style46 null">61938000</td>
		  <td class="column0 style46 null">Autres immobilisations corporelles</td>
		\';
		for ($i = 369; $i <=372; $i++) {    
		$table .= \'<td class="column0 style46 null">\' . ${\'dotationimobilisation\' . $i} . \'</td>\' . "\n"; 
		} 
		$table .= \'</tr>\';



		$table .= \' 
		<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="21" align="left" valign=middle><b><font size=2><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=middle><b><font size=2><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle><b>TOTAL</b></td>
		<td class="column0 style46 null">\'. $sumTotalImmob .\'</td>
		<td class="column0 style46 null">\'. $sumTotalAmortAnterieur .\'</td>
		<td class="column0 style46 null">\'. $sumTotalAmortexercice .\'</td>
		<td class="column0 style46 null">\'. $sumTotalCumulamort .\'</td>
	  </tr>
	  <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="21" align="left" valign=middle><b><font size=2><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=middle><b><font size=2><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle><b>TOTAL TABLEAU 16</b></td>
		<td class="column0 style46 null">\'. $sum1 .\'</td>
		<td class="column0 style46 null">\'. $sum2 .\'</td>
		<td class="column0 style46 null">\'. $sum4 .\'</td>
		<td class="column0 style46 null">\'. $sum4 .\'</td>
	  </tr> 
	   <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="21" align="left" valign=middle><b><font size=2><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=middle><b><font size=2><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle><b>TOTAL TABLEAUX 4 ET 8</b></td>
		<td class="column0 style46 null">\'. $TotalTab1 .\'</td>
		<td class="column0 style46 null">\'. $TotalTab2 .\'</td>
		<td class="column0 style46 null">\'. $TotalTab3 .\'</td>
		<td class="column0 style46 null">\'. $TotalTab4 .\'</td>
	  </tr> 
	   <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="21" align="left" valign=middle><b><font size=2><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=middle><b><font size=2><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="left" valign=middle><b><font size=2><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle><b>\'.$NomTotal.\'</b></td>
		<td class="column0 style46 null">\'. $RESULTATeXACTfAUT1 .\'</td>
		<td class="column0 style46 null">\'. $RESULTATeXACTfAUT2 .\'</td>
		<td class="column0 style46 null">\'. $RESULTATeXACTfAUT3 .\'</td>
		<td class="column0 style46 null">\'. $RESULTATeXACTfAUT4 .\'</td>
	  </tr> 

	  \';


				 

	$table .= \'    </tbody>
    </table>\';
            // Replace with your actual table HTML

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

		$year = GETPOST(\'year\');

		$pdf->SetFont(\'\', \'B\', $default_font_size + 3);
		$pdf->MultiCell(200, 2, "ETAT DE DOTATIONS AUX AMORTISSEMENTS RELATIFS AUX IMMOBILISATIONS ".$year, 0, "C");
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