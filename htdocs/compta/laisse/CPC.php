<?php

require_once 'codeLaisseCPC.php';

$object = new User($db);
$id=$user->id;

function GenerateDocuments($dateChoisist)
{
 global $day, $month, $year, $start, $prev_year;
 print '<form id="frmgen" name="builddoc" method="post">';
 print '<input type="hidden" name="token" value="' . newToken() . '">';
 print '<input type="hidden" name="action" value="builddoc">';
 print '<input type="hidden" name="model" value="Cpc">';
 print '<input type="hidden" name="valeurdatechoise" value="'.$dateChoisist.'">';
 print '<div class="right"  style="margin-bottom: 100px; margin-right: 20%;">
 <input type="submit" id="btngen" class="button" name="save" value="génerer">';
 print '</form>';
}

llxHeader("", "");




?>


<!DOCTYPE html>

<html>
<head>
</head>

<body>
<center>


<form method="POST" >
	<select name="date_select"><?php affichageAnnees()?></select>
	<button type="submit" name="chargement" 
	style="margin-top: 18px;background: #4B99AD;padding: 8px 15px 8px 15px;border: none;color: #fff;">Chargement</button><br>  
</form>
<br>
    <?php
    $date=(!empty($dateChoisis))?$dateChoisis:date('Y');
    echo'<input type="text" style="text-align:center;font-weight:bold;" value="Année chargé : '.$date.'"disabled/>';
    ?>
<br><br> 



<table align="center" cellspacing="0" border="0">
	<colgroup span="2" width="28"></colgroup>
	<colgroup width="250"></colgroup>
	<colgroup span="4" width="124"></colgroup>
	<colgroup width="84"></colgroup>
	<colgroup width="123"></colgroup>
	<tr>
		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=7 height="26" align="center" valign=bottom sdnum="1033;0;H:MM"><b><font face="Calibri" size=4>COMPTE DE PRODUITS ET CHARGES ( HORS TAXES )</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td height="24" align="left" valign=bottom><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=bottom><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=bottom><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><font face="Calibri"><br></font></td>
		<td align="left" valign=bottom><font face="Calibri"><br></font></td>
		<td align="right" valign=bottom><b><font face="Calibri"></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Opérations</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Totaux de l'exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Exercice précédent</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Exercice N-2</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="60" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Eléments</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Propres à l'exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri">Concernant les exercices précédents</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="18" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D9D9D9" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;0"><b><i><font face="Calibri">1</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;0"><b><i><font face="Calibri">2</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;0"><b><i><font face="Calibri">3 = 1 + 2</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;0"><b><i><font face="Calibri">4</font></i></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdnum="1033;0;0"><b><i><font face="Calibri">4</font></i></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=20 height="360" align="center" valign=middle><b><font face="Calibri">EXPLOITATION</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">I - PRODUITS D'EXPLOITATION</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($prExPaLex)?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($reExTchCLExPr)?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($reExTchToEx)?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($reExTchExPre)?></font></i></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($reExTchExN2)?></font></i></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Ventes de marchandises</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($veMarchPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($veMarchCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($veMarchToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($veMarchExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($veMarchExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Ventes de biens et services produits</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venBSPPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venBSPCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venBSPToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venBSPExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($venBSPExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdnum="1033;0;#,##0.00"><i><font face="Calibri">Chiffres d'affaires</font></i></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($chAffPaLex)?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($chAffCLExPr)?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($chAffToEx)?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($chAffExPre)?></font></i></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri"><?php readMontant($chAffExN2)?></font></i></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Variation de stock de produits</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($varSyProPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($varSyProCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($varSyProToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($varSyProExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($varSyProExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Immobilisations produites pour l'Ese p/elle même</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imPrLePaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imPrLeCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imPrLeToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imPrLeExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($imPrLeExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Subvention d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subEXPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subEXCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subEXToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subEXExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($subEXExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Autres produits d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrExPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrExCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrExToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrExExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($auPrExExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Reprises d'exploitation; transfert de charges</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reExTchPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reExTchCLExPr)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reExTchToEx)?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reExTchExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($reExTchExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">TOTAL  I</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIPaLex)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalICLExPr)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIToEx)?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIExPre)?></font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($totalIExN2)?></font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">II - CHARGES D'EXPLOITATION</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Achats revendus de marchandises</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMCLExPr)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMToEx)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMExPre)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMExN2)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Achat consommes de matières et de fournitures</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMPaLex)?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMPaLex)?></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($achReMPaLex)?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Autres charges externes</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Impôts et taxes</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Charges de personnel</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Autres charges d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Dotations d'exploitation</font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">TOTAL  II</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">III - RESULTAT D'EXPLOITATION  ( I - II )</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=13 height="234" align="center" valign=middle><b><font face="Calibri">FINANCIER</font></b></td>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">IV - PRODUITS FINANCIERS</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Produits des titres de partic. et autres titres immo.</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Gains de change</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Intérêts et autres produits financiers</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Reprises financières; transfert de charges</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">TOTAL  IV</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">V - CHARGES FINANCIERES</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Charges d'intérêts</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Pertes de changes</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Autres charges financières</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom><font face="Calibri">Dotations financières</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">TOTAL  V</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">VI - RESULTAT FINANCIER ( IV - V )</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">VII - RESULTAT COURANT ( III - V I)</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">VII - RESULTAT COURANT ( Report )</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=14 height="252" align="center" valign=middle><b><font face="Calibri">NON COURANT</font></b></td>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">VIII - PRODUITS NON COURANTS</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Produits des cessions d'immobilisations</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Subventions d'équilibre</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Reprises sur subventions d'investissement</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Autres produits non courants</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Reprises non courantes; transferts de charges</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">TOTAL  VIII</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">IX - CHARGES NON COURANTES</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri" color="#FFFFFF">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Valeurs nettes d'amortis. des immos cédées</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Subventions accordées</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Autres charges non courantes</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri">Dotations non courantes aux amortiss. et prov.</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri">TOTAL  IX</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">X - RESULTAT NON COURANT ( VIII- IV )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">XI - RESULTAT AVANT IMPOTS ( VII+ X )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">XII - IMPOTS SUR LES RESULTATS </font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">#NAME?</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">XIII - RESULTAT NET ( XI - XII )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td height="18" align="left" valign=bottom><font face="Calibri" color="#C0C0C0"><br></font></td>
		<td align="left" valign=bottom><b><font face="Calibri" color="#C0C0C0"><br></font></b></td>
		<td align="left" valign=bottom><font face="Calibri" color="#C0C0C0"><br></font></td>
		<td align="left" valign=bottom><font face="Calibri" color="#C0C0C0"><br></font></td>
		<td align="left" valign=bottom><font face="Calibri" color="#C0C0C0"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri" color="#C0C0C0"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri" color="#C0C0C0"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri" color="#C0C0C0"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">XIV - TOTAL DES PRODUITS ( I + IV + VIII )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">XV - TOTAL DES CHARGES ( II + V + IX + XII )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=bottom sdnum="1033;0;#,##0.00"><font face="Calibri"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;#,##0.00"><b><font face="Calibri"><br></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;#,##0"><b><font face="Calibri">XVI - RESULTAT NET ( XIV - XV )</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#808080" sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri">0.00</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">#NAME?</font></b></td>
	</tr>
	
</table>

</center>
<!-- ************************************************************************** -->
</body>

</html>
