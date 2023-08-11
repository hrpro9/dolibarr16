<?php
/* Copyright (C) 2001-2005 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2015 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2012 Regis Houssin        <regis.houssin@inodbox.com>
 * Copyright (C) 2015      Jean-François Ferry	<jfefe@aternatik.fr>
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
 */

/**
 *	\file       etatscomptables/etatscomptablesindex.php
 *	\ingroup    etatscomptables
 *	\brief      Home page of etatscomptables top menu
 */

// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
	$res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
}
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME']; $tmp2 = realpath(__FILE__); $i = strlen($tmp) - 1; $j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) {
	$i--; $j--;
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) {
	$res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
}
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) {
	$res = @include dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php";
}
// Try main.inc.php using relative path
if (!$res && file_exists("../main.inc.php")) {
	$res = @include "../main.inc.php";
}
if (!$res && file_exists("../../main.inc.php")) {
	$res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
	$res = @include "../../../main.inc.php";
}
if (!$res) {
	die("Include of main fails");
}

require_once DOL_DOCUMENT_ROOT.'/core/class/html.formfile.class.php';

// Load translation files required by the page
$langs->loadLangs(array("etatscomptables@etatscomptables"));

$action = GETPOST('action', 'aZ09');


// Security check
// if (! $user->rights->etatscomptables->myobject->read) {
// 	accessforbidden();
// }
$socid = GETPOST('socid', 'int');
if (isset($user->socid) && $user->socid > 0) {
	$action = '';
	$socid = $user->socid;
}

$max = 5;
$now = dol_now();


/*
 * Actions
 */

// None


/*
 * View
 */

$form = new Form($db);
$formfile = new FormFile($db);

llxHeader("", $langs->trans("EtatsComptablesArea"));

// print load_fiche_titre($langs->trans("EtatsComptablesArea"), '', 'etatscomptables.png@etatscomptables');

// print '<div class="fichecenter"><div class="fichethirdleft">';

$chemin_fichier = DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Passif.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/Passif/codepdfpassif.php';



$fichierLib = DOL_DOCUMENT_ROOT . '\core\lib\files.lib.php';
$contenuLib = file_get_contents($fichierLib);

$codeLib = '
// diclration passif  docs
elseif ($modulepart == \'Passif\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/billan_Passif/\' . $original_file;
}

// diclration passif  docs
elseif ($modulepart == \'Active\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/billan_Active/\' . $original_file;
}

//  Hors Taxes  docs
elseif ($modulepart == \'HorsTaxes\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	
	
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/HorsTaxes/\'. $original_file;

}

//  ESG  docs
elseif ($modulepart == \'Esg\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	
	
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/Esg/\'. $original_file;

}

//  Cpc  docs
elseif ($modulepart == \'Cpc\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	
	
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/Cpc/\'. $original_file;

}

//  CreditBail  docs
elseif ($modulepart == \'CreditBail\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	
	
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/CreditBail/\'. $original_file;

}
//  Retratsdimm  docs
elseif ($modulepart == \'Retratsdimm\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/Retratsdimm/\'. $original_file;

}
//  TitresParticipation  docs
elseif ($modulepart == \'TitresParticipation\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/TitresParticipation/\'. $original_file;

}

//  TitresParticipation  docs
elseif ($modulepart == \'CapitalSocial\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/CapitalSocial/\'. $original_file;

}

//  Amortisement  docs
elseif ($modulepart == \'Amortisement\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/Amortisement/\'. $original_file;

}
//  Provisions  docs
elseif ($modulepart == \'Provisions\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/Provisions/\'. $original_file;
}
//  Fusion  docs
elseif ($modulepart == \'Fusion\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/Fusion/\'. $original_file;
}
//  Autrecreditbail  docs
elseif ($modulepart == \'Autrecreditbail\') {
	if ($fuser->rights->salaries->read) {
		$accessallowed = 1;
	}
	$original_file = DOL_DATA_ROOT . \'/billanLaisse/Autrecreditbail/\'. $original_file;

}
//  Etatdesinterets  docs
elseif ($modulepart == \'Etatdesinterets\') {
if ($fuser->rights->salaries->read) {
	$accessallowed = 1;
}
$original_file = DOL_DATA_ROOT . \'/billanLaisse/Etatdesinterets/\'. $original_file;
}
//  OperationDevises  docs
elseif ($modulepart == \'OperationDevises\') {
if ($fuser->rights->salaries->read) {
	$accessallowed = 1;
}
$original_file = DOL_DATA_ROOT . \'/billanLaisse/OperationDevises/\'. $original_file;
}

//  Etatderogations  docs
elseif ($modulepart == \'Etatderogations\') {
if ($fuser->rights->salaries->read) {
	$accessallowed = 1;
}
$original_file = DOL_DATA_ROOT . \'/billanLaisse/Etatderogations/\'. $original_file;
}

//  Etatchangment  docs
elseif ($modulepart == \'Etatchangment\') {
if ($fuser->rights->salaries->read) {
	$accessallowed = 1;
}
$original_file = DOL_DATA_ROOT . \'/billanLaisse/Etatchangment/\'. $original_file;
}

//  Etatlimpot  docs
elseif ($modulepart == \'Etatlimpot\') {
if ($fuser->rights->salaries->read) {
	$accessallowed = 1;
}
$original_file = DOL_DATA_ROOT . \'/billanLaisse/Etatlimpot/\'. $original_file;
}

//  Principalesmethodes  docs
elseif ($modulepart == \'Principalesmethodes\') {
if ($fuser->rights->salaries->read) {
	$accessallowed = 1;
}
$original_file = DOL_DATA_ROOT . \'/billanLaisse/Principalesmethodes/\'. $original_file;
}

//  Etatdetaillesetock  docs
elseif ($modulepart == \'Etatdetaillesetock\') {
if ($fuser->rights->salaries->read) {
	$accessallowed = 1;
}
$original_file = DOL_DATA_ROOT . \'/billanLaisse/Etatdetaillesetock/\'. $original_file;
}

//  Detailtaxe  docs
elseif ($modulepart == \'Detailtaxe\') {
if ($fuser->rights->salaries->read) {
	$accessallowed = 1;
}
$original_file = DOL_DATA_ROOT . \'/billanLaisse/Detailtaxe/\'. $original_file;
}

// GENERIC Wrapping

';

if(!file_exists($chemin_fichier)){
$file = fopen($chemin_fichier, 'w');
fwrite($file, $content);
fclose($file);


$contenuLib = str_replace('// GENERIC Wrapping', $codeLib, $contenuLib);
// Écriture du code dans le fichier
file_put_contents($fichierLib, $contenuLib);


$chemin_fichierActive = DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Active.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/Actif/codepdfactif.php';

if(!file_exists($chemin_fichierActive)){
	$fileactive = fopen($chemin_fichierActive, 'w');
	fwrite($fileactive, $contentactive);
	fclose($fileactive);
}


$chemin_fichierhorttaxes = DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_HorsTaxes.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/HORTAXES/codepdfhorstaxes.php';

if(!file_exists($chemin_fichierhorttaxes)){
	$filehortaxes = fopen($chemin_fichierhorttaxes, 'w');
	fwrite($filehortaxes, $contenthortaxes);
	fclose($filehortaxes);
}



$chemin_fichierEsg = DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Esg.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/ESG/codepdfEsg.php';

if(!file_exists($chemin_fichierEsg)){
	$fileEsg = fopen($chemin_fichierEsg, 'w');
	fwrite($fileEsg, $contentEsg);
	fclose($fileEsg);
}

$chemin_fichierCpc = DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Cpc.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/Cpc/codepdfCpc.php';

if(!file_exists($chemin_fichierCpc)){
	$fileCpc = fopen($chemin_fichierCpc, 'w');
	fwrite($fileCpc, $contentCpc);
	fclose($fileCpc);
}

$chemin_fichierCreditbail = DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_CreditBail.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/CreditBail/codepdfactifCreditBail.php';

if(!file_exists($chemin_fichierCreditbail)){
	$fileCreditbail = fopen($chemin_fichierCreditbail, 'w');
	fwrite($fileCreditbail, $contentacreditbail);
	fclose($fileCreditbail);
}

$chemin_fichierRetratsdimm = DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Retratsdimm.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/Retratsdimm/codepdfRetratsdimm.php';

if(!file_exists($chemin_fichierRetratsdimm)){
	$fileRetratsdimm = fopen($chemin_fichierRetratsdimm, 'w');
	fwrite($fileRetratsdimm, $contentRetratsdimm);
	fclose($fileRetratsdimm);
}

$chemin_fichierTitresParticpation= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_TitresParticipation.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/TitresParticipation/codepdfTitresParticpation.php';

if(!file_exists($chemin_fichierTitresParticpation)){
	$fileTitresParticpation = fopen($chemin_fichierTitresParticpation, 'w');
	fwrite($fileTitresParticpation, $contentTitresParticpation);
	fclose($fileTitresParticpation);
}

$chemin_fichierCapitalSocial= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_CapitalSocial.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/CapitalSocial/codepdfCapitalSocial.php';

if(!file_exists($chemin_fichierCapitalSocial)){
	$fileCapitalSocial = fopen($chemin_fichierCapitalSocial, 'w'); 
	fwrite($fileCapitalSocial, $contentTitresParticpation);
	fclose($fileCapitalSocial);
}

$chemin_fichierAmortisement= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Amortisement.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/Amortissemen/codepdfAmortisement.php';

if(!file_exists($chemin_fichierAmortisement)){
	$fileAmortisement = fopen($chemin_fichierAmortisement, 'w'); 
	fwrite($fileAmortisement, $contentAmortisement);
	fclose($fileAmortisement);
}

$chemin_fichierProvisions= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Provisions.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/Provision/codepdfProfisions.php';

if(!file_exists($chemin_fichierProvisions)){
	$fileProvisions = fopen($chemin_fichierProvisions, 'w'); 
	fwrite($fileProvisions, $contentProvisions);
	fclose($fileProvisions);
}

$chemin_fichierFusion= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Fusion.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/Fusion/codepdfFusion.php';

if(!file_exists($chemin_fichierFusion)){
	$fileFusion = fopen($chemin_fichierFusion, 'w'); 
	fwrite($fileFusion, $contentFusion);
	fclose($fileFusion);
}

$chemin_fichierAutrecreditbail= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Autrecreditbail.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/AutrescreditBail/codepdfAutrecreditbail.php';

if(!file_exists($chemin_fichierAutrecreditbail)){
	$fileAutrecreditbail = fopen($chemin_fichierAutrecreditbail, 'w'); 
	fwrite($fileAutrecreditbail, $contentAutrecreditbail);
	fclose($fileAutrecreditbail);
}

$chemin_fichierEtatdesinterets= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Etatdesinterets.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/EtatDesInterets/codepdfEtatdesinterets.php';

if(!file_exists($chemin_fichierEtatdesinterets)){
	$fileEtatdesinterets = fopen($chemin_fichierEtatdesinterets, 'w'); 
	fwrite($fileEtatdesinterets, $contentEtatdesinterets);
	fclose($fileEtatdesinterets);
}

$chemin_fichierOperationDevises= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_OperationDevises.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/OperatinDevises/codepdfOperationDevises.php';

if(!file_exists($chemin_fichierOperationDevises)){
	$fileOperationDevises = fopen($chemin_fichierOperationDevises, 'w'); 
	fwrite($fileOperationDevises, $contentOperationDevises);
	fclose($fileOperationDevises);
}

$chemin_fichierEtatderogations= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Etatderogations.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/EtatDerogations/codepdfEtatderogations.php';

if(!file_exists($chemin_fichierEtatderogations)){
	$fileEtatderogations = fopen($chemin_fichierEtatderogations, 'w'); 
	fwrite($fileEtatderogations, $contentEtatderogations);
	fclose($fileEtatderogations);
}


$chemin_fichierEtatchangments= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Etatchangment.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/EtatChangements/codepdfEtatchangment.php';

if(!file_exists($chemin_fichierEtatchangments)){
	$fileEtatchangment = fopen($chemin_fichierEtatchangments, 'w'); 
	fwrite($fileEtatchangment, $contentEtatchangment);
	fclose($fileEtatchangment);
}

$chemin_fichierEtatlimpot= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Etatlimpot.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/EtatLimpot/codepdfEtatlimpot.php';

if(!file_exists($chemin_fichierEtatlimpot)){
	$fileEtatlimpot = fopen($chemin_fichierEtatlimpot, 'w'); 
	fwrite($fileEtatlimpot, $contentEtatlimpot);
	fclose($fileEtatlimpot);
}

$chemin_fichierPrincipalesMethodes= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Principalesmethodes.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/PrincipalesMethodes/codepdfPrincipalesmethodes.php';

if(!file_exists($chemin_fichierPrincipalesMethodes)){
	$filePrincipalesMethodes = fopen($chemin_fichierPrincipalesMethodes, 'w'); 
	fwrite($filePrincipalesMethodes, $contentPrincipalesmethodes);
	fclose($filePrincipalesMethodes);
}

$chemin_fichierEtatdetaillesetock= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Etatdetaillesetock.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/EtatDetailleStock/codepdfEtatdetaillesetock.php';

if(!file_exists($chemin_fichierEtatdetaillesetock)){
	$fileEtatdetaillesetock = fopen($chemin_fichierEtatdetaillesetock, 'w'); 
	fwrite($fileEtatdetaillesetock, $contentEtatdetaillesetock);
	fclose($fileEtatdetaillesetock);
}

$chemin_fichierDetailtaxe= DOL_DOCUMENT_ROOT .'/core/modules/user/doc/pdf_Detailtaxe.modules.php';
require_once DOL_DOCUMENT_ROOT.'/custom/etatscomptables/DetatlTaxe/codepdfDetailtaxe.php';

if(!file_exists($chemin_fichierDetailtaxe)){
	$fileDetailtaxe = fopen($chemin_fichierDetailtaxe, 'w'); 
	fwrite($fileDetailtaxe, $contentDetailtaxe);
	fclose($fileDetailtaxe);
}

}



// Écriture du code dans le fichier
file_put_contents($fichierLib, $contenuLib);

print load_fiche_titre($langs->trans("Etats Comptables"), '', 'hrm');

print '<div class="fichecenter"><div class="fichethirdleft">';

$urltoredirectPassif = DOL_URL_ROOT.'\custom\etatscomptables\Passif\declarationlaissepassif.php';
$urltoredirectActif = DOL_URL_ROOT.'\custom\etatscomptables\Actif\declarationlaisseactive.php';
$urltoredirectirHorsTaxes=DOL_URL_ROOT.'\custom\etatscomptable\HORTAXES\HORSTAXES.php';
$urltoredirectirCPC=DOL_URL_ROOT.'\custom\etatscomptables\Cpc\declarationCPC.php';
$urltoredirectirESG=DOL_URL_ROOT.'\custom\etatscomptables\ESG\declarationESG.php';
$urltoredirectircreditbail=DOL_URL_ROOT.'\custom\etatscomptables\CreditBail\declarationCreditBail.php';
$urltoredirectirRetratsdimm=DOL_URL_ROOT.'\custom\etatscomptables\Retratsdimm\declarationRetratsDimmobilistion.php';
$urltoreTitresParticipation=DOL_URL_ROOT.'\custom\etatscomptables\TitresParticipation\declarationTitresParticipation.php';
$urltoreCapitalSocial=DOL_URL_ROOT.'\custom\etatscomptables\CapitalSocial\declarationCapitalSocial.php';
$urltoreAmortissemen=DOL_URL_ROOT.'\custom\etatscomptables\Amortissemen\declarationamortismon.php';
$urltoreProvision=DOL_URL_ROOT.'\custom\etatscomptables\Provision\declarationProvision.php';
$urltoreFusion=DOL_URL_ROOT.'\custom\etatscomptables\Fusion\declarationFusion.php';
$urltoreAutrecreditbail=DOL_URL_ROOT.'\custom\etatscomptables\AutrescreditBail\declarationAutrescreditBail.php';
$urltoreEtatdesinterets=DOL_URL_ROOT.'\custom\etatscomptables\EtatDesInterets\declarationEtatDesInterets.php';
$urltoreOperationDevises=DOL_URL_ROOT.'\custom\etatscomptables\OperatinDevises\declarationOprerationDevises.php';
$urltoreEtatderogations=DOL_URL_ROOT.'\custom\etatscomptables\EtatDerogations\declarationEtatDerogations.php';
$urltoreEtatchangment=DOL_URL_ROOT.'\custom\etatscomptables\EtatChangements\declarationEtatChangement.php';
$urltoreEtatlimpot=DOL_URL_ROOT.'\custom\etatscomptables\EtatLimpot\declarationEtatLimpot.php';
$urltorePrincipalesMethodes=DOL_URL_ROOT.'\custom\etatscomptables\PrincipalesMethodes\declarationPrincipalesMethodes.php';
$urltoreEtatdetaillesetock=DOL_URL_ROOT.'\custom\etatscomptables\EtatDetailleStock\declaationEtatDetailleStock.php';
$urltoreDetailtaxe=DOL_URL_ROOT.'\custom\etatscomptables\DetatlTaxe\declarationDetatlTaxe.php';
// Bilan - Passif/Actif-Hors - Taxes-C.P.C-E.S.G
print '<div class="div-table-responsive-no-min">';
print '<table class="noborder nohover centpercent">';
print '<tr class="liste_titre"><th colspan="3"> </th></tr>';
print '<tr class="oddeven">';
print '<td>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoredirectPassif . '">
Bilan - Passif</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoredirectActif . '">
Bilan - Actif</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoredirectirHorsTaxes . '">
Hors - Taxes</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoredirectirCPC . '">
C.P.C</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoredirectirESG . '">
E.S.G</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoredirectircreditbail . '">
BIENS EN CREDIT BAIL</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoredirectirRetratsdimm . '">
RETRAITS D IMMOBILISATIONS</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreTitresParticipation . '">
TABLEAU DES TITRES DE PARTICIPATION</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreCapitalSocial . '">
ETAT DE REPARTITION DU CAPITAL SOCIAL</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreAmortissemen . '">
TABLEAU DES AMORTISSEMENTS</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreProvision . '">
TABLEAU DES PROVISIONS</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreFusion . '">
ETAT DES PLUS-VALUES CONSTATEES EN CAS DE FUSION</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreAutrecreditbail . '">
TABLEAU DES LOCATIONS ET BAUX AUTRES QUE LE CREDIT-BAIL</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreEtatdesinterets . '">
ETAT DES INTERETS DES EMPRUNTS CONTRACTES AUPRES DES ASSOCIES ET DES TIERS AUTRES QUE LES ORGANISMES DE BANQUE OU DE CREDIT</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreOperationDevises . '">
TABLEAU DES OPERATIONS EN DEVISES COMPTABILISEES PENDANT L EXERCICE</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreEtatderogations . '">
ETAT DES DEROGATIONS</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreEtatchangment . '">
ETAT DES CHANGEMENTS DE METHODES</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreEtatlimpot . '">
ETAT POUR LE CALCUL DE LIMPOT SUR LES SOCIETES -
ENTREPRISES ENCOURAGEES</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltorePrincipalesMethodes . '">
PRINCIPALES METHODES D EVALUATION SPECIFIQUES A L ENTREPRISE</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreEtatdetaillesetock . '">
ETAT DETAILLE DES STOCKS</a></span></div>';
print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoreDetailtaxe . '">
DETAIL DE LA TAXE SUR LA VALEUR AJOUTEE</a></span></div>';
print '<span class="opacitymedium"></span>';
print '</td>';
print '</tr>';
print '</table></div><br>';
print '</div><div class="fichetwothirdright">';
print '<div class="fichecenter"><div class="fichethirdleft">';



// // Bilan - Actif
// print '<div class="div-table-responsive-no-min">';
// print '<table class="noborder nohover centpercent">';
// print '<tr class="liste_titre"><th colspan="3">Bilan - Actif</th></tr>';
// print '<tr class="oddeven">';
// print '<td>';
// print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoredirectActif . '">
// Bilan - Actif</a></span></div>';
// print '<span class="opacitymedium"></span>';
// print '</td>';
// print '</tr>';
// print '</table></div><br>';
// print '</div><div class="fichetwothirdright">';
// print '<div class="fichecenter"><div class="fichethirdleft">';

// // Hors - Taxes
// print '<div class="div-table-responsive-no-min">';
// print '<table class="noborder nohover centpercent">';
// print '<tr class="liste_titre"><th colspan="3">Hors - Taxes</th></tr>';    
// print '<tr class="oddeven">';
// print '<td>';
// print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoredirectirHorsTaxes . '">
// Hors - Taxes</a></span></div>';
// print '<span class="opacitymedium"></span>';
// print '</td>';
// print '</tr>';
// print '</table></div><br>';
// print '</div><div class="fichetwothirdright">';

// // C.P.C
// print '<div class="div-table-responsive-no-min">';
// print '<table class="noborder nohover centpercent">';
// print '<tr class="liste_titre"><th colspan="3">C.P.C</th></tr>';
// print '<tr class="oddeven">';
// print '<td>';
// print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoredirectirCPC . '">
// C.P.C</a></span></div>';
// print '<span class="opacitymedium"></span>';
// print '</td>';
// print '</tr>';
// print '</table></div><br>';
// print '</div><div class="fichetwothirdright">';


// // E.S.G
// print '<div class="div-table-responsive-no-min">';
// print '<table class="noborder nohover centpercent">';
// print '<tr class="liste_titre"><th colspan="3">E.S.G</th></tr>';
// print '<tr class="oddeven">';
// print '<td>';
// print '<div class="valignmiddle div-balanceofleave"><span class="balanceofleave valignmiddle"><a href="' . $urltoredirectirESG . '">
// E.S.G</a></span></div>';
// print '<span class="opacitymedium"></span>';
// print '</td>';
// print '</tr>';
// print '</table></div><br>';
// print '</div><div class="fichetwothirdright">';


/* BEGIN MODULEBUILDER DRAFT MYOBJECT
// Draft MyObject
if (! empty($conf->etatscomptables->enabled) && $user->rights->etatscomptables->read)
{
	$langs->load("orders");

	$sql = "SELECT c.rowid, c.ref, c.ref_client, c.total_ht, c.tva as total_tva, c.total_ttc, s.rowid as socid, s.nom as name, s.client, s.canvas";
	$sql.= ", s.code_client";
	$sql.= " FROM ".MAIN_DB_PREFIX."commande as c";
	$sql.= ", ".MAIN_DB_PREFIX."societe as s";
	if (! $user->rights->societe->client->voir && ! $socid) $sql.= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
	$sql.= " WHERE c.fk_soc = s.rowid";
	$sql.= " AND c.fk_statut = 0";
	$sql.= " AND c.entity IN (".getEntity('commande').")";
	if (! $user->rights->societe->client->voir && ! $socid) $sql.= " AND s.rowid = sc.fk_soc AND sc.fk_user = ".((int) $user->id);
	if ($socid)	$sql.= " AND c.fk_soc = ".((int) $socid);

	$resql = $db->query($sql);
	if ($resql)
	{
		$total = 0;
		$num = $db->num_rows($resql);

		print '<table class="noborder centpercent">';
		print '<tr class="liste_titre">';
		print '<th colspan="3">'.$langs->trans("DraftMyObjects").($num?'<span class="badge marginleftonlyshort">'.$num.'</span>':'').'</th></tr>';

		$var = true;
		if ($num > 0)
		{
			$i = 0;
			while ($i < $num)
			{

				$obj = $db->fetch_object($resql);
				print '<tr class="oddeven"><td class="nowrap">';

				$myobjectstatic->id=$obj->rowid;
				$myobjectstatic->ref=$obj->ref;
				$myobjectstatic->ref_client=$obj->ref_client;
				$myobjectstatic->total_ht = $obj->total_ht;
				$myobjectstatic->total_tva = $obj->total_tva;
				$myobjectstatic->total_ttc = $obj->total_ttc;

				print $myobjectstatic->getNomUrl(1);
				print '</td>';
				print '<td class="nowrap">';
				print '</td>';
				print '<td class="right" class="nowrap">'.price($obj->total_ttc).'</td></tr>';
				$i++;
				$total += $obj->total_ttc;
			}
			if ($total>0)
			{

				print '<tr class="liste_total"><td>'.$langs->trans("Total").'</td><td colspan="2" class="right">'.price($total)."</td></tr>";
			}
		}
		else
		{

			print '<tr class="oddeven"><td colspan="3" class="opacitymedium">'.$langs->trans("NoOrder").'</td></tr>';
		}
		print "</table><br>";

		$db->free($resql);
	}
	else
	{
		dol_print_error($db);
	}
}
END MODULEBUILDER DRAFT MYOBJECT */


print '</div><div class="fichetwothirdright">';


$NBMAX = $conf->global->MAIN_SIZE_SHORTLIST_LIMIT;
$max = $conf->global->MAIN_SIZE_SHORTLIST_LIMIT;

/* BEGIN MODULEBUILDER LASTMODIFIED MYOBJECT
// Last modified myobject
if (! empty($conf->etatscomptables->enabled) && $user->rights->etatscomptables->read)
{
	$sql = "SELECT s.rowid, s.ref, s.label, s.date_creation, s.tms";
	$sql.= " FROM ".MAIN_DB_PREFIX."etatscomptables_myobject as s";
	//if (! $user->rights->societe->client->voir && ! $socid) $sql.= ", ".MAIN_DB_PREFIX."societe_commerciaux as sc";
	$sql.= " WHERE s.entity IN (".getEntity($myobjectstatic->element).")";
	//if (! $user->rights->societe->client->voir && ! $socid) $sql.= " AND s.rowid = sc.fk_soc AND sc.fk_user = ".((int) $user->id);
	//if ($socid)	$sql.= " AND s.rowid = $socid";
	$sql .= " ORDER BY s.tms DESC";
	$sql .= $db->plimit($max, 0);

	$resql = $db->query($sql);
	if ($resql)
	{
		$num = $db->num_rows($resql);
		$i = 0;

		print '<table class="noborder centpercent">';
		print '<tr class="liste_titre">';
		print '<th colspan="2">';
		print $langs->trans("BoxTitleLatestModifiedMyObjects", $max);
		print '</th>';
		print '<th class="right">'.$langs->trans("DateModificationShort").'</th>';
		print '</tr>';
		if ($num)
		{
			while ($i < $num)
			{
				$objp = $db->fetch_object($resql);

				$myobjectstatic->id=$objp->rowid;
				$myobjectstatic->ref=$objp->ref;
				$myobjectstatic->label=$objp->label;
				$myobjectstatic->status = $objp->status;

				print '<tr class="oddeven">';
				print '<td class="nowrap">'.$myobjectstatic->getNomUrl(1).'</td>';
				print '<td class="right nowrap">';
				print "</td>";
				print '<td class="right nowrap">'.dol_print_date($db->jdate($objp->tms), 'day')."</td>";
				print '</tr>';
				$i++;
			}

			$db->free($resql);
		} else {
			print '<tr class="oddeven"><td colspan="3" class="opacitymedium">'.$langs->trans("None").'</td></tr>';
		}
		print "</table><br>";
	}
}
*/

print '</div></div>';

// End of page
llxFooter();
$db->close();
