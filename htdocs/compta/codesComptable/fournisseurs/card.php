<?php


require '../../../main.inc.php';

$action = (GETPOST('action', 'alpha') ? GETPOST('action', 'alpha') : 'view');
$id = GETPOST('id', 'int');


// actions
if($action == "update"){
	if(!GETPOSTISSET("cancel")){
		$code_compta_fournisseur = GETPOST('code_compta_fournisseur', 'alpha');
		$sql = "update `llx_societe` set code_compta_fournisseur = '$code_compta_fournisseur' where rowid = $id;";
		$result = $db->query($sql);
		if ($result) {
			$db->commit();
			header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $id);
		} else {
			$action = "edit";
			$db->rollback();
		}
	}else{
		header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $id);
	}
}




$backPage = false;
if($id){
	$societe = array();
	$sql = "select rowid, code_compta_fournisseur, nom, name_alias, client, fournisseur from llx_societe where rowid = $id";
	$res = $db->query($sql);
	if ($res->num_rows) {
		$societe = $res->fetch_assoc();
	}else{
		$backPage = true;
	}
}else{
	$backPage = true;
}
if($backPage || $societe['fournisseur'] == 0){
	header("Location: /compta/codesComptable/fournisseurs/list.php?type=f");
}


llxHeader('', "Codes comptable fournisseur", "");

print "<h3 class='title'>Fournisseur : ".$societe['nom']." (". $societe['name_alias'] .")</h3>";

print '<div class="underbanner clearboth"></div>';

print '<form action="' . $_SERVER["PHP_SELF"] . '?id=' . $id .'method="POST">
<input type="hidden" name="token" value="' . newToken() . '">
<input type="hidden" name="action" value="' . (($action != 'edit') ? 'edit' : 'update') . '">
<input type="hidden" name="id" value="' . $id . '">';

print '<div class="fichehalfleft">';


print '<table class="border centpercent tableforfield">';
// print "<h4>Modifier code comptable du client</h4>";
print '<tr>';
print '<td>Code comptable fournisseur<td>';
if($action == "edit"){
    print "<input name='code_compta_fournisseur' type='text' value='".$societe['code_compta_fournisseur']."'/>";
}else{
	print '<td>'.$societe['code_compta_fournisseur'].'</td>';
}
print '</tr>';

print '</table>';


print '</div>';
print "<div style='clear: both;margin-top: 50px;'>";
if($action == "edit"){
	print "<button type='submit' class='butAction'>Enregistrer</button>";
	print "<button name='cancel' type='submit' class='butAction'>Annuler</button>";
}else{
	print "<button type='submit' class='butAction'>Modifier</button>";
}
print '</div>
</form>';


print "
	<style>
		.title{
			color: var(--colortexttitlenotab);
		}
	</style>";
