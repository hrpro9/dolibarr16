<?php

// Load Dolibarr environment
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
require_once DOL_DOCUMENT_ROOT.'/categories/class/categorie.class.php';

if (!$user->rights->salaries->read) {
    accessforbidden("you don't have right for this page");
}


// Load translation files required by page
$langs->loadLangs(array('users', 'companies', 'hrm'));

$contextpage = GETPOST('contextpage', 'aZ') ? GETPOST('contextpage', 'aZ') : 'userlist'; // To manage different context of search

// Security check (for external users)
$socid = 0;
if ($user->socid > 0) {
    $socid = $user->socid;
}

// Load mode employee
$mode = GETPOST("mode", 'alpha');

// Load variable for pagination
$limit = GETPOST('limit', 'int') ? GETPOST('limit', 'int') : $conf->liste_limit;
$sortfield = GETPOST('sortfield', 'alpha');
$sortorder = GETPOST('sortorder', 'alpha');
$page = GETPOSTISSET('pageplusone') ? (GETPOST('pageplusone') - 1) : GETPOST("page", 'int');
if (empty($page) || $page == -1) {
    $page = 0;
}
$offset = $limit * $page;
$pageprev = $page - 1;
$pagenext = $page + 1;
if (!$sortfield) $sortfield = "u.login";
if (!$sortorder) $sortorder = "ASC";

// Define value to know what current user can do on users
$canadduser = (!empty($user->admin) || $user->rights->user->user->creer);

// Initialize technical object to manage hooks of page. Note that conf->hooks_modules contains array of hook context
$object = new User($db);
$hookmanager->initHooks(array('userlist'));
$extrafields = new ExtraFields($db);

// fetch optionals attributes and labels
$extrafields->fetch_name_optionals_label($object->table_element);
$search_array_options = $extrafields->getOptionalsFromPost($object->table_element, '', 'search_');

$userstatic = new User($db);
$companystatic = new Societe($db);
$form = new Form($db);

// List of fields to search into when doing a "search in all"
$fieldstosearchall = array(
    'u.login' => "Login",
    'u.lastname' => "Lastname",
    'u.firstname' => "Firstname",
    'u.accountancy_code' => "AccountancyCode",
    'u.email' => "EMail",
    'u.note' => "Note",
);
if (!empty($conf->api->enabled)) {
    $fieldstosearchall['u.api_key'] = "ApiKey";
}

// Definition of fields for list
$arrayfields = array(
    'u.login' => array('label' => $langs->trans("Login"), 'checked' => 1),
    'u.lastname' => array('label' => $langs->trans("Lastname"), 'checked' => 1),
    'u.firstname' => array('label' => $langs->trans("Firstname"), 'checked' => 1),
    'u.gender' => array('label' => $langs->trans("Gender"), 'checked' => 0),
    'u.accountancy_code' => array('label' => $langs->trans("AccountancyCode"), 'checked' => 0),
    'u.email' => array('label' => $langs->trans("EMail"), 'checked' => 1),
    'u.api_key' => array('label' => $langs->trans("ApiKey"), 'checked' => 0, "enabled" => ($conf->api->enabled && $user->admin)),
    'u.fk_soc' => array('label' => $langs->trans("Company"), 'checked' => 1),
    'u.entity' => array('label' => $langs->trans("Entity"), 'checked' => 1, 'enabled' => (!empty($conf->multicompany->enabled) && empty($conf->global->MULTICOMPANY_TRANSVERSE_MODE))),
    'u.fk_user' => array('label' => $langs->trans("HierarchicalResponsible"), 'checked' => 1),
    'u.datelastlogin' => array('label' => $langs->trans("LastConnexion"), 'checked' => 1, 'position' => 100),
    'u.datepreviouslogin' => array('label' => $langs->trans("PreviousConnexion"), 'checked' => 0, 'position' => 110),
    'u.datec' => array('label' => $langs->trans("DateCreation"), 'checked' => 0, 'position' => 500),
    'u.tms' => array('label' => $langs->trans("DateModificationShort"), 'checked' => 0, 'position' => 500),
    'u.statut' => array('label' => $langs->trans("Status"), 'checked' => 1, 'position' => 1000),
);

$object->fields = dol_sort_array($object->fields, 'position');
$arrayfields = dol_sort_array($arrayfields, 'position');

// Init search fields
$sall = trim((GETPOST('search_all', 'alphanohtml') != '') ? GETPOST('search_all', 'alphanohtml') : GETPOST('sall', 'alphanohtml'));
$search_user = GETPOST('search_user', 'alpha');
$search_login = GETPOST('search_login', 'alpha');
$search_lastname = GETPOST('search_lastname', 'alpha');
$search_firstname = GETPOST('search_firstname', 'alpha');
$search_gender = GETPOST('search_gender', 'alpha');
$search_employee = GETPOST('search_employee', 'alpha');
$search_accountancy_code = GETPOST('search_accountancy_code', 'alpha');
$search_email = GETPOST('search_email', 'alpha');
$search_api_key = GETPOST('search_api_key', 'alphanohtml');
$search_statut = GETPOST('search_statut', 'intcomma');
$search_thirdparty = GETPOST('search_thirdparty', 'alpha');
$search_supervisor = GETPOST('search_supervisor', 'intcomma');
$optioncss = GETPOST('optioncss', 'alpha');
$search_categ = GETPOST("search_categ", 'int');
$catid = GETPOST('catid', 'int');

// Default search
if ($search_statut == '') $search_statut = '1';
if ($mode == 'employee' && !GETPOSTISSET('search_employee')) $search_employee = 1;



/*
 * Actions
 */

if (GETPOST('cancel', 'alpha')) {
    $action = 'list';
    $massaction = '';
}
if (!GETPOST('confirmmassaction', 'alpha') && $massaction != 'presend' && $massaction != 'confirm_presend' && $massaction != 'confirm_createbills') {
    $massaction = '';
}

$parameters = array();
$reshook = $hookmanager->executeHooks('doActions', $parameters); // Note that $action and $object may have been modified by some hooks
if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');

if (empty($reshook)) {
    // Selection of new fields
    include DOL_DOCUMENT_ROOT . '/core/actions_changeselectedfields.inc.php';

    // Purge search criteria
    if (GETPOST('button_removefilter_x', 'alpha') || GETPOST('button_removefilter.x', 'alpha') || GETPOST('button_removefilter', 'alpha')) // All tests are required to be compatible with all browsers
    {
        $search_user = "";
        $search_login = "";
        $search_lastname = "";
        $search_firstname = "";
        $search_gender = "";
        $search_employee = "";
        $search_accountancy_code = "";
        $search_email = "";
        $search_statut = "";
        $search_thirdparty = "";
        $search_supervisor = "";
        $search_api_key = "";
        $search_datelastlogin = "";
        $search_datepreviouslogin = "";
        $search_date_creation = "";
        $search_date_update = "";
        $search_array_options = array();
        $search_categ = 0;
    }
}

//get date filter
$action = GETPOST('action');
$id = GETPOST('id', 'int');

$mydate = getdate(date("U"));
$day = (GETPOST('reday') != '') ? GETPOST('reday') : $mydate['mday'];
$prev_year = (GETPOST('reyear') != '') ? GETPOST('reyear') : $mydate['year'];
$showAll = GETPOST('showAll');

$start = GETPOST('start', 'int');

$month =  $start;
if (!$start) {
    $month = date("m");
    if ($month < 7) {
        $start = 7;
        $prev_year = $prev_year - 1;
    } else if ($month >= 7) {
        $start = 1;
    }
}
$prev_month = $start;


//Save date to use in generate module
$_SESSION['start'] = $start;

$next = dol_get_next_month($month, $prev_year);
$next_year  = $next['year'];
$next_month = $next['month'];
$next_day   = 1;


// Actions to build doc
$action = GETPOST('action', 'aZ09');
$upload_dir = DOL_DATA_ROOT . '/grh/LivreDePaie';
$permissiontoadd = 1;
$donotredirect = 1;
include DOL_DOCUMENT_ROOT . '/core/actions_builddoc.inc.php';

$_SESSION['start'] = null;


/*
 * View
 */

$htmlother = new FormOther($db);

$user2 = new User($db);

$buttonviewhierarchy = '<form action="' . DOL_URL_ROOT . '/user/hierarchy.php' . (($search_statut != '' && $search_statut >= 0) ? '?search_statut=' . $search_statut : '') . '" method="POST"><input type="submit" class="button" style="width:120px" name="viewcal" value="' . dol_escape_htmltag($langs->trans("HierarchicView")) . '"></form>';

$sql = "SELECT DISTINCT u.rowid, u.lastname, u.firstname, u.admin, u.fk_soc, u.login,  u.gender, u.photo, u.salary, u.dateemploymentend, u.dateemployment,";
$sql .= " u.statut";
//$sql .= " ex.name";

// Add fields from extrafields
if (!empty($extrafields->attributes[$object->table_element]['label'])) {
    foreach ($extrafields->attributes[$object->table_element]['label'] as $key => $val) $sql .= ($extrafields->attributes[$object->table_element]['type'][$key] != 'separate' ? ", ef." . $key . ' as options_' . $key : '');
}
// Add fields from hooks
$parameters = array();
$reshook = $hookmanager->executeHooks('printFieldListSelect', $parameters); // Note that $action and $object may have been modified by hook
$sql .= $hookmanager->resPrint;
$sql .= " FROM " . MAIN_DB_PREFIX . "user as u";
if (is_array($extrafields->attributes[$object->table_element]['label']) && count($extrafields->attributes[$object->table_element]['label'])) $sql .= " LEFT JOIN " . MAIN_DB_PREFIX . $object->table_element . "_extrafields as ef on (u.rowid = ef.fk_object)";
$sql .= " LEFT JOIN " . MAIN_DB_PREFIX . "user as u2 ON u.fk_user = u2.rowid";
if (!empty($search_categ) || !empty($catid)) $sql .= ' LEFT JOIN ' . MAIN_DB_PREFIX . "categorie_user as cu ON u.rowid = cu.fk_user"; // We'll need this table joined to the select in order to filter by categ
// Add fields from hooks
$parameters = array();
$reshook = $hookmanager->executeHooks('printUserListWhere', $parameters); // Note that $action and $object may have been modified by hook
if ($reshook > 0) {
    $sql .= $hookmanager->resPrint;
} else {
    $sql .= " WHERE u.entity IN (" . getEntity('user') . ") and u.employee =1";
}
if ($socid > 0) $sql .= " AND u.fk_soc = " . $socid;

//specifie the status (1=Employee)
$sql .= " AND ef.status  = '1'";

//if ($search_user != '')       $sql.=natural_search(array('u.login', 'u.lastname', 'u.firstname'), $search_user);
if ($search_supervisor > 0)   $sql .= " AND u.fk_user IN (" . $db->escape($search_supervisor) . ")";
if ($search_thirdparty != '') $sql .= natural_search(array('s.nom'), $search_thirdparty);
if ($search_login != '')      $sql .= natural_search("u.login", $search_login);
if ($search_lastname != '')   $sql .= natural_search("u.lastname", $search_lastname);
if ($search_firstname != '')  $sql .= natural_search("u.firstname", $search_firstname);
if ($search_gender != '' && $search_gender != '-1')     $sql .= " AND u.gender = '" . $search_gender . "'";
if (is_numeric($search_employee) && $search_employee >= 0) {
    $sql .= ' AND u.employee = ' . (int) $search_employee;
}
if ($search_accountancy_code != '')  $sql .= natural_search("u.accountancy_code", $search_accountancy_code);
if ($search_email != '')             $sql .= natural_search("u.email", $search_email);
if ($search_api_key != '')           $sql .= natural_search("u.api_key", $search_api_key);
if ($search_statut != '' && $search_statut >= 0) $sql .= " AND u.statut IN (" . $db->escape($search_statut) . ")";
if ($sall)                           $sql .= natural_search(array_keys($fieldstosearchall), $sall);
if ($catid > 0)     $sql .= " AND cu.fk_categorie = " . $catid;
if ($catid == -2)   $sql .= " AND cu.fk_categorie IS NULL";
if ($search_categ > 0)   $sql .= " AND cu.fk_categorie = " . $db->escape($search_categ);
if ($search_categ == -2) $sql .= " AND cu.fk_categorie IS NULL";

// Add where from hooks
$parameters = array();
$reshook = $hookmanager->executeHooks('printFieldListWhere', $parameters); // Note that $action and $object may have been modified by hook
$sql .= $hookmanager->resPrint;
$sql .= $db->order($sortfield, $sortorder);

$nbtotalofrecords = 0;
$result = $db->query($sql);
if ($result) {
    $nbtotalofrecords = $db->num_rows($result);
}

$sql .= $db->plimit($limit + 1, $offset);

$result = $db->query($sql);
if (!$result) {
    dol_print_error($db);
    exit;
}

$num = $db->num_rows($result);

if ($num == 1 && !empty($conf->global->MAIN_SEARCH_DIRECT_OPEN_IF_ONLY_ONE) && $sall) {
    $obj = $db->fetch_object($resql);
    $id = $obj->rowid;
    header("Location: " . DOL_URL_ROOT . '/user/card.php?id=' . $id);
    exit;
}

$param = '';
if (!empty($contextpage) && $contextpage != $_SERVER["PHP_SELF"]) $param .= '&amp;contextpage=' . urlencode($contextpage);
if ($limit > 0 && $limit != $conf->liste_limit) $param .= '&amp;limit=' . urlencode($limit);
if ($sall != '') $param .= '&amp;sall=' . urlencode($sall);
if ($search_user != '') $param .= "&amp;search_user=" . urlencode($search_user);
if ($search_login != '') $param .= "&amp;search_login=" . urlencode($search_login);
if ($search_lastname != '') $param .= "&amp;search_lastname=" . urlencode($search_lastname);
if ($search_firstname != '') $param .= "&amp;search_firstname=" . urlencode($search_firstname);
if ($search_gender != '') $param .= "&amp;search_gender=" . urlencode($search_gender);
if ($search_employee != '') $param .= "&amp;search_employee=" . urlencode($search_employee);
if ($search_accountancy_code != '') $param .= "&amp;search_accountancy_code=" . urlencode($search_accountancy_code);
if ($search_email != '') $param .= "&amp;search_email=" . urlencode($search_email);
if ($search_api_key != '') $param .= "&amp;search_api_key=" . urlencode($search_api_key);
if ($search_supervisor > 0) $param .= "&amp;search_supervisor=" . urlencode($search_supervisor);
if ($search_statut != '') $param .= "&amp;search_statut=" . urlencode($search_statut);
if ($optioncss != '') $param .= '&amp;optioncss=' . urlencode($optioncss);
if ($mode != '')      $param .= '&amp;mode=' . urlencode($mode);
if ($search_categ > 0) $param .= "&amp;search_categ=" . urlencode($search_categ);



llxHeader("", "Livre de Paie");
$text = "Livre de Paie";

//peroide
$periode = sprintf("%02d", $start) . '/' . $prev_year . ' - '  . sprintf("%02d", $start + 5) .  '/' . $prev_year;

//add filter by date
datefilter();

print '<form method="POST" id="searchFormList" action="' . $_SERVER["PHP_SELF"] . '">' . "\n";
if ($optioncss != '') print '<input type="hidden" name="optioncss" value="' . $optioncss . '">';
print '<input type="hidden" name="token" value="' . newToken() . '">';
print '<input type="hidden" name="formfilteraction" id="formfilteraction" value="list">';
print '<input type="hidden" name="sortfield" value="' . $sortfield . '">';
print '<input type="hidden" name="sortorder" value="' . $sortorder . '">';
print '<input type="hidden" name="mode" value="' . $mode . '">';
print '<input type="hidden" name="contextpage" value="' . $contextpage . '">';

$morehtmlright .= dolGetButtonTitle($langs->trans("HierarchicView"), '', 'fa fa-sitemap paddingleft', DOL_URL_ROOT . '/user/hierarchy.php' . (($search_statut != '' && $search_statut >= 0) ? '?search_statut=' . $search_statut : ''));

print_barre_liste($text, $page, $_SERVER["PHP_SELF"], $param, $sortfield, $sortorder, "", $num, $nbtotalofrecords, 'setup', 0, $morehtmlright . ' ' . $newcardbutton, '', 0, 0, 1);

if (!empty($catid)) {
    print "<div id='ways'>";
    $c = new Categorie($db);
    $ways = $c->print_all_ways(' &gt; ', 'user/list.php');
    print " &gt; " . $ways[0] . "<br>\n";
    print "</div><br>";
}

if ($sall) {
    foreach ($fieldstosearchall as $key => $val) $fieldstosearchall[$key] = $langs->trans($val);
    print '<div class="divsearchfieldfilter">' . $langs->trans("FilterOnInto", $sall) . join(', ', $fieldstosearchall) . '</div>';
}

$moreforfilter = '';

// Filter on categories
if (!empty($conf->categorie->enabled)) {
    $moreforfilter .= '<div class="divsearchfield">';
    $moreforfilter .= $langs->trans('Categories') . ': ';
    $moreforfilter .= $htmlother->select_categories(Categorie::TYPE_USER, $search_categ, 'search_categ', 1);
    $moreforfilter .= '</div>';
}

$parameters = array();
$reshook = $hookmanager->executeHooks('printFieldPreListTitle', $parameters); // Note that $action and $object may have been modified by hook
if (empty($reshook)) $moreforfilter .= $hookmanager->resPrint;
else $moreforfilter = $hookmanager->resPrint;

if ($moreforfilter) {
    print '<div class="liste_titre liste_titre_bydiv centpercent">';
    print $moreforfilter;
    print '</div>';
}

$varpage = empty($contextpage) ? $_SERVER["PHP_SELF"] : $contextpage;

$selectedfields = $form->multiSelectArrayWithCheckbox('selectedfields', $arrayfields, $varpage); // This also change content of $arrayfields


print '<div class="" style="padding-bottom: 50px;">';
print '<table id="tblUsers" class="tagtable liste' . ($moreforfilter ? " listwithfilterbefore" : "") . '">' . "\n";

// Search bar
print '<tr class="liste_titre_filter">';

print '<td class="liste_titre"><input type="text" name="Check" class="maxwidth50" value="&nbsp;"></td>';
if (!empty($arrayfields['u.login']['checked'])) {
    print '<td class="liste_titre"><input type="text" name="search_login" class="maxwidth50" value="' . $search_login . '"></td>';
}
if (!empty($arrayfields['u.lastname']['checked'])) {
    print '<td class="liste_titre"><input type="text" name="search_lastname" class="maxwidth50" value="' . $search_lastname . '"></td>';
}
if (!empty($arrayfields['u.firstname']['checked'])) {
    print '<td class="liste_titre"><input type="text" name="search_firstname" class="maxwidth50" value="' . $search_firstname . '"></td>';
}
if (!empty($arrayfields['u.gender']['checked'])) {
    print '<td class="liste_titre">';
    $arraygender = array('man' => $langs->trans("Genderman"), 'woman' => $langs->trans("Genderwoman"));
    print $form->selectarray('search_gender', $arraygender, $search_gender, 1);
    print '</td>';
}
if (!empty($arrayfields['u.employee']['checked'])) {
    print '<td class="liste_titre">';
    print $form->selectyesno('search_employee', $search_employee, 1, false, 1);
    print '</td>';
}
if (!empty($arrayfields['u.accountancy_code']['checked'])) {
    print '<td class="liste_titre"><input type="text" name="search_accountancy_code" class="maxwidth50" value="' . $search_accountancy_code . '"></td>';
}
if (!empty($arrayfields['u.email']['checked'])) {
    print '<td class="liste_titre"><input type="text" name="search_email" class="maxwidth75" value="' . $search_email . '"></td>';
}
if (!empty($arrayfields['u.api_key']['checked'])) {
    print '<td class="liste_titre"><input type="text" name="search_api_key" class="maxwidth50" value="' . $search_api_key . '"></td>';
}
if (!empty($arrayfields['u.fk_soc']['checked'])) {
    print '<td class="liste_titre"><input type="text" name="search_thirdparty" class="maxwidth75" value="' . $search_thirdparty . '"></td>';
}
if (!empty($arrayfields['u.entity']['checked'])) {
    print '<td class="liste_titre"></td>';
}
// Supervisor
if (!empty($arrayfields['u.fk_user']['checked'])) {
    print '<td class="liste_titre">';
    print $form->select_dolusers($search_supervisor, 'search_supervisor', 1, array(), 0, '', 0, 0, 0, 0, '', 0, '', 'maxwidth200');
    print '</td>';
}
if (!empty($arrayfields['u.datelastlogin']['checked'])) {
    print '<td class="liste_titre"></td>';
}
if (!empty($arrayfields['u.datepreviouslogin']['checked'])) {
    print '<td class="liste_titre"></td>';
}
// Extra fields
include DOL_DOCUMENT_ROOT . '/core/tpl/extrafields_list_search_input.tpl.php';
// Fields from hook
$parameters = array('arrayfields' => $arrayfields);
$reshook = $hookmanager->executeHooks('printFieldListOption', $parameters); // Note that $action and $object may have been modified by hook
print $hookmanager->resPrint;
if (!empty($arrayfields['u.datec']['checked'])) {
    // Date creation
    print '<td class="liste_titre">';
    print '</td>';
}
if (!empty($arrayfields['u.tms']['checked'])) {
    // Date modification
    print '<td class="liste_titre">';
    print '</td>';
}
if (!empty($arrayfields['u.statut']['checked'])) {
    // Status
    print '<td class="liste_titre center">';
    print $form->selectarray('search_statut', array('-1' => '', '0' => $langs->trans('Disabled'), '1' => $langs->trans('Enabled')), $search_statut);
    print '</td>';
}
// Action column
print '<td class="liste_titre maxwidthsearch">';
$searchpicto = $form->showFilterAndCheckAddButtons(0);
print $searchpicto;
print '</td>';

print "</tr>\n";


print '<tr class="liste_titre">';
print '<th class="wrapcolumntitle liste_titre" title="Nom">Select</th>';
if (!empty($arrayfields['u.login']['checked']))          print_liste_field_titre("Login", $_SERVER['PHP_SELF'], "u.login", $param, "", "", $sortfield, $sortorder);
if (!empty($arrayfields['u.lastname']['checked']))       print_liste_field_titre("Lastname", $_SERVER['PHP_SELF'], "u.lastname", $param, "", "", $sortfield, $sortorder);
if (!empty($arrayfields['u.firstname']['checked']))      print_liste_field_titre("FirstName", $_SERVER['PHP_SELF'], "u.firstname", $param, "", "", $sortfield, $sortorder);
if (!empty($arrayfields['u.gender']['checked']))         print_liste_field_titre("Gender", $_SERVER['PHP_SELF'], "u.gender", $param, "", "", $sortfield, $sortorder);
if (!empty($arrayfields['u.employee']['checked']))       print_liste_field_titre("Employee", $_SERVER['PHP_SELF'], "u.employee", $param, "", "", $sortfield, $sortorder);
if (!empty($arrayfields['u.accountancy_code']['checked'])) print_liste_field_titre("AccountancyCode", $_SERVER['PHP_SELF'], "u.accountancy_code", $param, "", "", $sortfield, $sortorder);
if (!empty($arrayfields['u.email']['checked']))          print_liste_field_titre("EMail", $_SERVER['PHP_SELF'], "u.email", $param, "", "", $sortfield, $sortorder);
if (!empty($arrayfields['u.api_key']['checked']))        print_liste_field_titre("ApiKey", $_SERVER['PHP_SELF'], "u.api_key", $param, "", "", $sortfield, $sortorder);
if (!empty($arrayfields['u.fk_soc']['checked']))         print_liste_field_titre("Company", $_SERVER['PHP_SELF'], "u.fk_soc", $param, "", "", $sortfield, $sortorder);
if (!empty($arrayfields['u.entity']['checked']))         print_liste_field_titre("Entity", $_SERVER['PHP_SELF'], "u.entity", $param, "", "", $sortfield, $sortorder);
if (!empty($arrayfields['u.fk_user']['checked']))        print_liste_field_titre("HierarchicalResponsible", $_SERVER['PHP_SELF'], "u.fk_user", $param, "", "", $sortfield, $sortorder);
if (!empty($arrayfields['u.datelastlogin']['checked']))  print_liste_field_titre("LastConnexion", $_SERVER['PHP_SELF'], "u.datelastlogin", $param, "", '', $sortfield, $sortorder, 'center ');
if (!empty($arrayfields['u.datepreviouslogin']['checked'])) print_liste_field_titre("PreviousConnexion", $_SERVER['PHP_SELF'], "u.datepreviouslogin", $param, "", '', $sortfield, $sortorder, 'center ');

// Hook fields
$parameters = array('arrayfields' => $arrayfields, 'param' => $param, 'sortfield' => $sortfield, 'sortorder' => $sortorder);
$reshook = $hookmanager->executeHooks('printFieldListTitle', $parameters); // Note that $action and $object may have been modified by hook
print $hookmanager->resPrint;
if (!empty($arrayfields['u.datec']['checked']))  print_liste_field_titre("DateCreationShort", $_SERVER["PHP_SELF"], "u.datec", "", $param, '', $sortfield, $sortorder, 'center nowrap ');
if (!empty($arrayfields['u.tms']['checked']))    print_liste_field_titre("DateModificationShort", $_SERVER["PHP_SELF"], "u.tms", "", $param, '', $sortfield, $sortorder, 'center nowrap ');
if (!empty($arrayfields['u.statut']['checked'])) print_liste_field_titre("Status", $_SERVER["PHP_SELF"], "u.statut", "", $param, '', $sortfield, $sortorder, 'center ');
print_liste_field_titre($selectedfields, $_SERVER["PHP_SELF"], "", '', '', '', $sortfield, $sortorder, 'center maxwidthsearch ');
print "</tr>\n";


$i = 0;
$totalarray = array();
while ($i < min($num, $limit)) {
    $obj = $db->fetch_object($result);

    if ((strtotime($obj->dateemploymentend) < strtotime(date("d") . '-' . $start . '-' . $prev_year) && $obj->dateemploymentend != '') || $obj->dateemployment == '' || (strtotime($obj->dateemployment) > strtotime(date("t", strtotime('01-' . ($start + 5) . '-' . $prev_year)) . '-' . ($start + 5) . '-' . $prev_year) && $obj->dateemployment != '')) {
        $i++;
        continue;
    }

    $userstatic->id = $obj->rowid;
    $userstatic->admin = $obj->admin;
    $userstatic->ref = $obj->label;
    $userstatic->login = $obj->login;
    $userstatic->statut = $obj->statut;
    $userstatic->email = $obj->email;
    $userstatic->gender = $obj->gender;
    $userstatic->socid = $obj->fk_soc;
    $userstatic->firstname = $obj->firstname;
    $userstatic->lastname = $obj->lastname;
    $userstatic->employee = $obj->employee;
    $userstatic->photo = $obj->photo;

    $li = '<a href="' . $_SERVER["PHP_SELF"] . '?id=' . $userstatic->id . '&action=show&start=' . $start . '&reyear=' . $prev_year . '">' . $userstatic->login . '</a>';

    print "<tr>";
    if (!empty($arrayfields['u.login']['checked'])) {
        print '<td class="nowraponall"> <input type="checkbox" name="checkUser"> </td>';
        print '<td class="nowraponall">';
        print $li;
        if (!empty($conf->multicompany->enabled) && $obj->admin && !$obj->entity) {
            print img_picto($langs->trans("SuperAdministrator"), 'redstar', 'class="valignmiddle paddingleft"');
        } elseif ($obj->admin) {
            print img_picto($langs->trans("Administrator"), 'star', 'class="valignmiddle paddingleft"');
        }
        print '</td>';
        if (!$i) $totalarray['nbfield']++;
    }
    if (!empty($arrayfields['u.lastname']['checked'])) {
        print '<td>' . $obj->lastname . '</td>';
        if (!$i) $totalarray['nbfield']++;
    }
    if (!empty($arrayfields['u.firstname']['checked'])) {
        print '<td>' . $obj->firstname . '</td>';
        if (!$i) $totalarray['nbfield']++;
    }
    if (!empty($arrayfields['u.gender']['checked'])) {
        print '<td>';
        if ($obj->gender) print $langs->trans("Gender" . $obj->gender);
        print '</td>';
        if (!$i) $totalarray['nbfield']++;
    }
    if (!empty($arrayfields['u.employee']['checked'])) {
        print '<td>' . yn($obj->employee) . '</td>';
        if (!$i) $totalarray['nbfield']++;
    }
    if (!empty($arrayfields['u.accountancy_code']['checked'])) {
        print '<td>' . $obj->accountancy_code . '</td>';
        if (!$i) $totalarray['nbfield']++;
    }
    if (!empty($arrayfields['u.email']['checked'])) {
        print '<td>' . $obj->email . '</td>';
        if (!$i) $totalarray['nbfield']++;
    }
    if (!empty($arrayfields['u.api_key']['checked'])) {
        print '<td>' . $obj->api_key . '</td>';
        if (!$i) $totalarray['nbfield']++;
    }
    if (!empty($arrayfields['u.fk_soc']['checked'])) {
        print "<td>";
        if ($obj->fk_soc) {
            $companystatic->id = $obj->fk_soc;
            $companystatic->name = $obj->name;
            $companystatic->canvas = $obj->canvas;
            print $companystatic->getNomUrl(1);
        } elseif ($obj->ldap_sid) {
            print $langs->trans("DomainUser");
        } else {
            print $langs->trans("InternalUser");
        }
        print '</td>';
        if (!$i) $totalarray['nbfield']++;
    }
    // Multicompany enabled
    if (!empty($conf->multicompany->enabled) && is_object($mc) && empty($conf->global->MULTICOMPANY_TRANSVERSE_MODE)) {
        if (!empty($arrayfields['u.entity']['checked'])) {
            print '<td>';
            if (!$obj->entity) {
                print $langs->trans("AllEntities");
            } else {
                $mc->getInfo($obj->entity);
                print $mc->label;
            }
            print '</td>';
            if (!$i) $totalarray['nbfield']++;
        }
    }
    // Supervisor
    if (!empty($arrayfields['u.fk_user']['checked'])) {
        // Resp
        print '<td class="nowrap">';
        if ($obj->login2) {
            $user2->id = $obj->id2;
            $user2->login = $obj->login2;
            $user2->lastname = $obj->lastname2;
            $user2->firstname = $obj->firstname2;
            $user2->gender = $obj->gender2;
            $user2->photo = $obj->photo2;
            $user2->admin = $obj->admin2;
            $user2->email = $obj->email2;
            $user2->socid = $obj->fk_soc2;
            $user2->statut = $obj->statut2;
            print $user2->getNomUrl(-1, '', 0, 0, 24, 0, '', '', 1);
            if (!empty($conf->multicompany->enabled) && $obj->admin2 && !$obj->entity2) {
                print img_picto($langs->trans("SuperAdministrator"), 'redstar', 'class="valignmiddle paddingleft"');
            } elseif ($obj->admin2) {
                print img_picto($langs->trans("Administrator"), 'star', 'class="valignmiddle paddingleft"');
            }
        }
        print '</td>';
        if (!$i) $totalarray['nbfield']++;
    }

    // Date last login
    if (!empty($arrayfields['u.datelastlogin']['checked'])) {
        print '<td class="nowrap center">' . dol_print_date($db->jdate($obj->datelastlogin), "dayhour") . '</td>';
        if (!$i) $totalarray['nbfield']++;
    }
    // Date previous login
    if (!empty($arrayfields['u.datepreviouslogin']['checked'])) {
        print '<td class="nowrap center">' . dol_print_date($db->jdate($obj->datepreviouslogin), "dayhour") . '</td>';
        if (!$i) $totalarray['nbfield']++;
    }

    // Fields from hook
    $parameters = array('arrayfields' => $arrayfields, 'obj' => $obj, 'i' => $i, 'totalarray' => &$totalarray);
    $reshook = $hookmanager->executeHooks('printFieldListValue', $parameters); // Note that $action and $object may have been modified by hook
    print $hookmanager->resPrint;
    // Date creation
    if (!empty($arrayfields['u.datec']['checked'])) {
        print '<td class="center">';
        print dol_print_date($db->jdate($obj->date_creation), 'dayhour', 'tzuser');
        print '</td>';
        if (!$i) $totalarray['nbfield']++;
    }
    // Date modification
    if (!empty($arrayfields['u.tms']['checked'])) {
        print '<td class="center">';
        print dol_print_date($db->jdate($obj->date_update), 'dayhour', 'tzuser');
        print '</td>';
        if (!$i) $totalarray['nbfield']++;
    }
    // Status
    if (!empty($arrayfields['u.statut']['checked'])) {
        $userstatic->statut = $obj->statut;
        print '<td class="center">' . $userstatic->getLibStatut(5) . '</td>';
        if (!$i) $totalarray['nbfield']++;
    }

    $sql = "SELECT fk_user, bank, number FROM llx_user_rib WHERE fk_user=" . $obj->rowid;
    $res = $db->query($sql);
    $data = ((object)($res))->fetch_assoc();

    print '<td> <input type="hidden" name="idCell" value="' . $obj->rowid . '"></td>';
    print '<td> <input type="hidden" name="salaryCell" value="' . $obj->salary . '"></td>';
    $bank = $data["bank"];
    $bank .= "  / RIB: ";
    $bank .= $data["number"];
    print '<td> <input type="hidden" name="bankCell" value="' . $bank . '"></td>';

    // Action column
    print '<td></td>';
    if (!$i) $totalarray['nbfield']++;

    print "</tr>\n";

    $i++;
}

$parameters = array('arrayfields' => $arrayfields, 'sql' => $sql);
$reshook = $hookmanager->executeHooks('printFieldListFooter', $parameters); // Note that $action and $object may have been modified by hook
print $hookmanager->resPrint;

print "</table>";
print '</div>';
print "</form>\n";

GenerateDocuments();

$action = GETPOST('action');
$id = GETPOST('id', 'int');

if ($id && $action == 'show') {
    ShowBulletin($id);
}

ShowDocuments();

function GenerateDocuments()
{
    global $day, $month, $year, $start, $prev_year;
    print '<form id="frmgen" name="generateDocs" method="post">';
    print '<input type="hidden" name="token" value="' . newToken() . '">';
    print '<input type="hidden" name="action" value="generateDocs">';
    print '<input type="hidden" name="model" value="LivreDePaie">';
    print '<input type="hidden" name="day" value="' . $day . '">';
    print '<input type="hidden" name="remonth" value="' . $month . '">';
    print '<input type="hidden" name="reyear" value="' . $prev_year . '">';
    print '<input type="hidden" name="start" value="' . $start . '">';
    print '<div class="right"  style="margin-bottom: 100px; margin-right: 20%;"><input type="button" id="btngen" class="button" name="save" value="génerer">';


    print "<script>
        $('#btngen').click(function(){
            var i=1;
            $('#tblUsers input[name=checkUser]:checked').each(function () {
                var id = $(this).closest('tr').find('input[name=idCell]').val();
                var salary = $(this).closest('tr').find('input[name=salaryCell]').val();
                var b = $(this).closest('tr').find('input[name=bankCell]').val();
                var nom = $(this).closest('tr').find('td:eq(2)').val();
                $('input[name=id]').remove();
                $('<input type=\"hidden\" name=\"id\" value=\"'+id+'\" >').appendTo('#frmgen');
                $.ajax({
                    url: '" . $_SERVER["PHP_SELF"] . "',
                    type: 'post',
                    data:$('#frmgen').serialize(),
                    success:function(){			
                    }
                });
            });
	        location.reload(true);
        });
    </script>";
    print '</form>';
}


function ShowDocuments()
{
    global $db, $object, $conf, $month, $prev_year, $societe, $showAll, $start;
    print '<div class="fichecenter"><div class="fichehalfleft">';
    $formfile = new FormFile($db);


    $subdir = get_exdir($object->id, 2, 0, 0, $object, 'RH');
    $filedir = DOL_DATA_ROOT . '/grh/LivreDePaie' . '/' . $subdir;

    $urlsource = $_SERVER['PHP_SELF'] . '';
    $genallowed = 0;
    $delallowed = 1;
    $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));

    if (!$showAll) {
        $name = ($start == 1) ? "01-$prev_year" : "02-$prev_year";
        $_SESSION["filterDoc"] = $name;
    }

    print $formfile->showdocuments('LivreDePaie', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, 'remonth=' . $month . '&amp;reyear=' . $prev_year, '', '', $societe->default_lang);
    $somethingshown = $formfile->numoffiles;

    $_SESSION["filterDoc"] = null;
    // Show links to link elements
    //$linktoelem = $form->showLinkToObjectBlock($object, null, array('RH'));
}


function ShowBulletin($id)
{

    global $db, $object, $prev_month, $prev_year, $start, $periode;
    $object->fetch($id);
    include("../class/Livre_class.php");

    $livre = '<style type="text/css">
    table.tableizer-table {
        font-size: 11px;
		margin:auto;
        border-bottom:1px solid #000;
        border-collapse: collapse;
    } 
    .tableizer-table td {
        padding: 4px;
        margin: 3px;
        border-left: 1px solid #000;
        border-right: 1px solid #000;
    }
    .tableizer-table th {
        background-color: #104E8B; 
        color: #FFF;
        font-weight: bold;
    }
    .row-bordered{
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
    }
    .row-content{
        background-color: rgb(214, 214, 214);
    }
    .importent-cell{
        background-color: rgb(122, 166, 202);
        font-weight: bold;
    }
    .white-cell{
        background-color: white;
        font-weight: bold;
    }
    </style>
        <table class="tableizer-table">
            <thead><tr class="tableizer-firstrow"><th colspan="9">LIVRE DE PAIE</th></tr></thead>
            <tbody>
            <tr class="importent-cell row-bordered"><td>&nbsp;</td><td>Nom</td><td class="white-cell" colspan=2>' . $object->lastname . ' ' . $object->firstname . '</td><td colspan=2>Date de naissance</td><td class="white-cell" colspan="3">' . date("d/m/Y", $object->birth) . '</td></tr>
            <tr class="importent-cell row-bordered"><td>&nbsp;</td><td>N° CNSS</td><td colspan=2 class="white-cell">' . $cnss . '</td><td colspan=2>Fonction</td><td class="white-cell" colspan="3">' . $role . '</td></tr>
            <tr class="importent-cell row-bordered"><td>&nbsp;</td><td>Periode</td><td class="white-cell" colspan=2>' . $periode . '</td><td colspan=2>adresse</td><td class="white-cell" colspan="3">' . $object->address . '</td></tr>
            <tr class="importent-cell row-bordered"><td>&nbsp;</td><td>Situation familiale</td><td class="white-cell" colspan=2>' . $situation . '</td><td colspan=2>nombre d\'enfants</td><td class="white-cell" colspan=3>' . $extrafields["enfants"] . '</td></tr>
             <tr class="importent-cell row-bordered"><td>Rub</td><td >Désignation</td><td>' . $french_months[$start - 1] . '</td><td>' . $french_months[$start - 1 + 1] . '</td><td>' . $french_months[$start - 1 + 2] . '</td><td>' . $french_months[$start - 1 + 3] . '</td><td>' . $french_months[$start - 1 + 4] . '</td><td>' . $french_months[$start - 1 + 5] . '</td><td>TOTAL</td></tr>
             <tr><td>&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td>&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td></tr>
             <tr class="row-content"><td></td><td >NOMBRE DES JOURS</td><td > ' . price($workingdaysdeclarés[$start]) . ' </td><td > ' . price($workingdaysdeclarés[$start + 1]) . ' </td><td > ' . price($workingdaysdeclarés[$start + 2]) . ' </td><td > ' . price($workingdaysdeclarés[$start + 3]) . ' </td><td > ' . price($workingdaysdeclarés[$start + 4]) . ' </td><td > ' . price($workingdaysdeclarés[$start + 5]) . ' </td><td > ' . price(array_sum((array)$workingdaysdeclarés)) . ' </td>
             </tr><tr><td>&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td></tr>';

    //  '<tr><td>&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td></tr>
    //  <tr class="row-content"><td>' . getRebrique("salaireMensuel") . '</td><td >SALAIRE MENSUEL</td><td > ' . price($salaireMonsuels[$start]) . ' </td><td > ' . price($salaireMonsuels[$start + 1]) . ' </td><td > ' . price($salaireMonsuels[$start + 2]) . ' </td><td > ' . price($salaireMonsuels[$start + 3]) . ' </td><td > ' . price($salaireMonsuels[$start + 4]) . ' </td><td > ' . price($salaireMonsuels[$start + 5]) . ' </td><td > ' . price(array_sum($salaireMonsuels)) . ' </td></tr>';

    // $livre .= ' <tr class="row-content"><td>' . getRebrique("primeDancien") . '</td><td >PRIME D\'ANCIENNETE</td><td >' . price($primeDanciens[$start]) . '</td><td > ' . price($primeDanciens[$start + 1]) . ' </td><td > ' . price($primeDanciens[$start + 2]) . ' </td><td > ' . price($primeDanciens[$start + 3]) . ' </td><td > ' . price($primeDanciens[$start + 4]) . ' </td><td > ' . price($primeDanciens[$start + 5]) . ' </td><td > ' . price(array_sum($primeDanciens)) . ' </td></tr> ';

    // $livre .= ' <tr class="row-content"><td>' . getRebrique("congePaye") . '</td><td >SOLDE CONGE PAYE</td><td >' . price($soldeConges[$start]) . '</td><td > ' . price($soldeConges[$start + 1]) . ' </td><td > ' . price($soldeConges[$start + 2]) . ' </td><td > ' . price($soldeConges[$start + 3]) . ' </td><td > ' . price($soldeConges[$start + 4]) . ' </td><td > ' . price($soldeConges[$start + 5]) . ' </td><td > ' . price(array_sum($soldeConges)) . ' </td></tr> ';

    //Get les rubriques en brut global
    foreach ((array)$enBrutsRubs as $rub) {
        $total = 0;
        for ($j = $start; $j < $start + 6; $j++) {
            $total += $allEnBrut[$j][$rub["rub"]];
        }
        $livre .= '<tr class="row-content"><td>' . $rub["rub"] . '</td><td >' . $rub["designation"] . '</td><td >' . price($allEnBrut[$start][$rub["rub"]]) . '</td><td > ' . price($allEnBrut[$start + 1][$rub["rub"]]) . ' </td><td > ' . price($allEnBrut[$start + 2][$rub["rub"]]) . ' </td><td > ' . price($allEnBrut[$start + 3][$rub["rub"]]) . ' </td><td > ' . price($allEnBrut[$start + 4][$rub["rub"]]) . ' </td><td > ' . price($allEnBrut[$start + 5][$rub["rub"]]) . ' </td><td > ' . price($total) . ' </td></tr>';
    }

    $livre .= '<tr><td>&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td></tr>
             <tr class="row-content"><td>&nbsp;</td><td >TOTAL BRUT</td><td > ' . price($salaireBruts[$start]) . ' </td><td > ' . price($salaireBruts[$start + 1]) . ' </td><td > ' . price($salaireBruts[$start + 2]) . ' </td><td > ' . price($salaireBruts[$start + 3]) . ' </td><td > ' . price($salaireBruts[$start + 4]) . ' </td><td > ' . price($salaireBruts[$start + 5]) . ' </td><td > ' . price(array_sum((array)$salaireBruts)) . ' </td></tr>
             <tr><td>&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td></tr>';

    //Get les rubriques cotisations
    foreach ((array)$cotisationsRubs as $rub) {
        $total = 0;
        for ($j = $start; $j < $start + 6; $j++) {
            $total += $allCotisations[$j][$rub["rub"]];
        }
        $livre .= '<tr class=""><td>' . $rub["rub"] . '</td><td >' . $rub["designation"] . '</td><td >' . price($allCotisations[$start][$rub["rub"]]) . '</td><td > ' . price($allCotisations[$start + 1][$rub["rub"]]) . ' </td><td > ' . price($allCotisations[$start + 2][$rub["rub"]]) . ' </td><td > ' . price($allCotisations[$start + 3][$rub["rub"]]) . ' </td><td > ' . price($allCotisations[$start + 4][$rub["rub"]]) . ' </td><td > ' . price($allCotisations[$start + 5][$rub["rub"]]) . ' </td><td > ' . price($total) . ' </td></tr>';
    }

    $livre .= '<tr><td>&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td></tr>
             <tr class="row-content"><td>' . getRebrique("netImposable") . '</td><td >SALAIRE NET IMPOSABLE</td><td > ' . price($netImposables[$start]) . ' </td><td > ' . price($netImposables[$start + 1]) . ' </td><td > ' . price($netImposables[$start + 2]) . ' </td><td > ' . price($netImposables[$start + 3]) . ' </td><td > ' . price($netImposables[$start + 4]) . ' </td><td > ' . price($netImposables[$start + 5]) . ' </td><td > ' . price(array_sum((array)$netImposables)) . ' </td></tr>
             <tr><td>&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td></tr>';

    $livre .= '<tr class="row-content"><td>' . getRebrique("chargefamille") . '</td><td >CHARGE DE FAMILLE</td><td >' . price($chargeFamilles[$start]) . '</td><td > ' . price($chargeFamilles[$start + 1]) . ' </td><td > ' . price($chargeFamilles[$start + 2]) . ' </td><td > ' . price($chargeFamilles[$start + 3]) . ' </td><td > ' . price($chargeFamilles[$start + 4]) . ' </td><td > ' . price($chargeFamilles[$start + 5]) . ' </td><td > ' . price(array_sum((array)$chargeFamilles)) . ' </td></tr>';

    $livre .= '<tr><td>&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td></tr>
        <tr class="row-content"><td>' . getRebrique("ir") . '</td><td >IR</td><td > ' . price($irNets[$start]) . ' </td><td > ' . price($irNets[$start + 1]) . ' </td><td > ' . price($irNets[$start + 2]) . ' </td><td > ' . price($irNets[$start + 3]) . ' </td><td > ' . price($irNets[$start + 4]) . ' </td><td > ' . price($irNets[$start + 5]) . ' </td><td > ' . price(array_sum((array)$irNets)) . ' </td></tr>';

    $livre .= '<tr><td>&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td></tr>';

    //Get rubriques pas en brut et pas imposable
    foreach ((array)$pasEnBrutRubs as $rub) {
        $total = 0;
        for ($j = $start; $j < $start + 6; $j++) {
            $total += $allPasEnBrut[$j][$rub["rub"]];
        }
        $livre .= '<tr class="row-content"><td>' . $rub["rub"] . '</td><td >' . $rub["designation"] . '</td><td >' . price($allPasEnBrut[$start][$rub["rub"]]) . '</td><td > ' . price($allPasEnBrut[$start + 1][$rub["rub"]]) . ' </td><td > ' . price($allPasEnBrut[$start + 2][$rub["rub"]]) . ' </td><td > ' . price($allPasEnBrut[$start + 3][$rub["rub"]]) . ' </td><td > ' . price($allPasEnBrut[$start + 4][$rub["rub"]]) . ' </td><td > ' . price($allPasEnBrut[$start + 5][$rub["rub"]]) . ' </td><td > ' . price($total) . ' </td></tr>';
    }



    $livre .= '<tr><td>&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td></tr>
             <tr><td>&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td></tr>
             <tr  class="importent-cell row-bordered" ><td>&nbsp;</td><td >Net a payer</td><td > ' . price($totalNets[$start]) . ' </td><td > ' . price($totalNets[$start + 1]) . ' </td><td > ' . price($totalNets[$start + 2]) . ' </td><td > ' . price($totalNets[$start + 3]) . ' </td><td > ' . price($totalNets[$start + 4]) . ' </td><td > ' . price($totalNets[$start + 5]) . ' </td><td > ' . price(array_sum((array)$totalNets)) . ' </td></tr>
             
             </tbody>
    </table>';

    print $livre;
}


//filter by date
function datefilter()
{
    global $form, $dateinvoice, $month, $year, $prev_year, $start, $prev_day, $next_year, $next_month, $next_day, $periode, $langs;
    print '<div class="center">';
    print '<form id="frmfilter" name="filter" action="' . $_SERVER["PHP_SELF"] . '" method="POST">';
    print '<input type="hidden" name="action" value="filter">';

    // Show navigation bar
    $next_yearClick = ($start == 7) ? $prev_year + 1 : $prev_year;
    $prev_yearClick = ($start == 1) ? $prev_year - 1 : $prev_year;
    $nav = '<a class="inline-block valignmiddle" href="?reyear=' . $prev_yearClick . "&start=" . abs($start - 8) . '">' . img_previous($langs->trans("Previous")) . "</a>\n";
    $nav .= " <span id=\"month_name\">" . $periode . " </span>\n";
    $nav .= '<a class="inline-block valignmiddle" href="?reyear=' . $next_yearClick . "&start=" . abs($start - 8) . '">' . img_next($langs->trans("Next")) . "</a>\n";
    //$nav.=" &nbsp; (<a href=\"?year=".$nowyear."&month=".$nowmonth."&day=".$nowday.$param."\">".$langs->trans("Today")."</a>)";
    //$nav.=' <input type="submit" name="submitdateselect" class="button" value="'.$langs->trans("Refresh").'">';
    $nav .= ' <button type="submit" name="button_search_x" value="x" class="bordertransp"><span class="fa fa-search"></span></button>';

    print $nav;

    //print '<input type="submit" class="button" value="Filtrer">';

    print '<br><input type="checkbox" id="showAll" name="showAll" value="1">';
    print '<label for="showAll">Show ALL</label>';
    print '</div>';
    print '</form>';
}

print "<script>
		$(document).ready(function(){
			$('#re').val('" . $month . "/" . $prev_year . "');	
		});
	</script>";


//Les compte comptable
function getRebrique($name)
{
    global $db;
    $sql = "SELECT rub FROM llx_Paie_Rubriques WHERE name = '$name'";
    $res = $db->query($sql);
    if ($res) {
        $row = ((object)$res)->fetch_assoc();
    } else
        print("<br>fail ERR: " . $sql);

    return $row["rub"];
}

$db->free($result);

// End of page
llxFooter();
$db->close();
