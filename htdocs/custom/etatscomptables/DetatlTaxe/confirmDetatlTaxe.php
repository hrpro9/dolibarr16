
<?php
    // Load Dolibarr environment
    require_once '../../../main.inc.php';
    require_once '../../../vendor/autoload.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
    require_once '../functionDeclarationLaisse.php';

    llxHeader("", "");

    $returnpage=GETPOST('model');
    if($returnpage=="Detailtaxe")
    { 
        $url = DOL_URL_ROOT . '/custom/etatscomptables/DetatlTaxe/declarationDetatlTaxe.php';
        echo"<script>window.location.href='$url';</script>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $check=$_POST['check']??'';
        if( $check == 'true')
        {
            // Retrieve the form data
            for ($i = 0; $i <= 48; $i++) {
                ${'detatTaxe' . $i} = $_POST['detatTaxe' . $i];
            }
            $Solde1=$detatTaxe0-$detatTaxe1-$detatTaxe2-$detatTaxe3;
            $Solde2=$detatTaxe4-$detatTaxe5-$detatTaxe6-$detatTaxe7;
            $Solde3=$detatTaxe8-$detatTaxe9-$detatTaxe10-$detatTaxe11;
            $Solde4=$detatTaxe12-$detatTaxe13-$detatTaxe14-$detatTaxe15;
            $Solde5=$detatTaxe16-$detatTaxe17-$detatTaxe18-$detatTaxe19;
            $Solde6=$detatTaxe20-$detatTaxe21-$detatTaxe22-$detatTaxe23;
            $Solde7=$detatTaxe24-$detatTaxe25-$detatTaxe26-$detatTaxe27;
            $Solde8=$detatTaxe28-$detatTaxe29-$detatTaxe30-$detatTaxe31;
            $Solde9=$detatTaxe32-$detatTaxe33-$detatTaxe34-$detatTaxe35;
            $Solde10=intval($detatTaxe36) - intval($detatTaxe37) - intval($detatTaxe38) - intval($detatTaxe39);
            $Solde11=intval($detatTaxe40) - intval($detatTaxe41) - intval($detatTaxe42) - intval($detatTaxe43);
            $Solde12=intval($detatTaxe44) - intval($detatTaxe45) - intval($detatTaxe46) - intval($detatTaxe47) ;
            $sum1=$detatTaxe0+$detatTaxe4+ $detatTaxe8+$detatTaxe12+$detatTaxe16+$detatTaxe20+$detatTaxe24+$detatTaxe28+$detatTaxe32+$detatTaxe36+$detatTaxe40+$detatTaxe44;
            $sum2=$detatTaxe1+$detatTaxe5+$detatTaxe9+$detatTaxe13+$detatTaxe17+$detatTaxe21+$detatTaxe25+$detatTaxe29+$detatTaxe33+$detatTaxe37+$detatTaxe41+$detatTaxe45;
            $sum3=$detatTaxe2+$detatTaxe6+$detatTaxe10+$detatTaxe14+$detatTaxe18+$detatTaxe22+$detatTaxe26+$detatTaxe30+$detatTaxe34+$detatTaxe38+$detatTaxe42+$detatTaxe46;
            $sum4=$detatTaxe3+$detatTaxe7+$detatTaxe11+$detatTaxe15+$detatTaxe19+$detatTaxe23+$detatTaxe27+$detatTaxe31+$detatTaxe35+$detatTaxe39+$detatTaxe43+$detatTaxe47;
            $sum5=$Solde1+$Solde2 +$Solde3+ $Solde4+ $Solde5+$Solde6+ $Solde7+ $Solde8+$Solde9+$Solde10+$Solde11+ $Solde12;

            $detatTaxeValeur1=$_POST['detatTaxeValeur1'];
            $detatTaxeValeur2=$_POST['detatTaxeValeur2'];
            $detatTaxeValeur3=$_POST['detatTaxeValeur3'];
            $detatTaxeValeur4=$_POST['detatTaxeValeur4'];

            
             // ... continue for other $Solde variables

            $data = "<?php ";

            for ($i = 0; $i <= 48; $i++) {
              ${'detatTaxe' . $i} = $_POST['detatTaxe' . $i];
                if(${'detatTaxe' . $i}==$detatTaxe48)
                {
        
                    $selectedDate = new DateTime($detatTaxe48);
                    $year = $selectedDate->format('Y');
                    $data .= '$detatTaxe' . $i . ' = ' . $year . ";\n";   
        
                }
              else {
                  $data .= '$detatTaxe' . $i . ' = ' . ${'detatTaxe' . $i} . ";\n";  
              }
              
            }

            $data .= '$Solde1 = ' . $Solde1 . ";\n";
            $data .= '$Solde2 = ' . $Solde2 . ";\n";
            $data .= '$Solde3 = ' . $Solde3 . ";\n";
            $data .= '$Solde4 = ' . $Solde4 . ";\n";
            $data .= '$Solde5 = ' . $Solde5 . ";\n";
            $data .= '$Solde6 = ' . $Solde6 . ";\n";
            $data .= '$Solde7 = ' . $Solde7 . ";\n";
            $data .= '$Solde8 = ' . $Solde8 . ";\n";
            $data .= '$Solde9 = ' . $Solde9 . ";\n";
            $data .= '$Solde10 = ' . $Solde10 . ";\n";
            $data .= '$Solde11 = ' . $Solde11 . ";\n";
            $data .= '$Solde12 = ' . $Solde12 . ";\n";
            $data .= '$sum1 = ' . $sum1 . ";\n";
            $data .= '$sum2 = ' . $sum2 . ";\n";
            $data .= '$sum3 = ' . $sum3 . ";\n";
            $data .= '$sum4 = ' . $sum4 . ";\n";
            $data .= '$sum5 = ' . $sum5 . ";\n";

            $data .= '$detatTaxeValeur1 = ' . $detatTaxeValeur1 . ";\n";
            $data .= '$detatTaxeValeur2 = ' . $detatTaxeValeur2 . ";\n";
            $data .= '$detatTaxeValeur3 = ' . $detatTaxeValeur3 . ";\n";
            $data .= '$detatTaxeValeur4 = ' . $detatTaxeValeur4 . ";\n";

            

      
            $selectedDate = new DateTime($detatTaxe48);
            $year = $selectedDate->format('Y'); // Extract the year value
            			
            // SADDL : Solde au début de l'exercice
            // OCDL : Opérations comptables de l'exercice
            // DTDL :  Déclarations TVA de l'exercice
            // SFDE : Solde fin d'exercice	

            $TF_SADDL=$TF_OCDL=$TF_DTDL=$TF_SFDE=0;//A. T.V.A. Facturée
            $TR_SADDL=$TR_OCDL=$TR_DTDL=$TR_SFDE=0;//B. T.V.A. Récuperable
            $SC_SADDL= $SC_OCDL= $SC_DTDL= $SC_SFDE=0;//sur charges
            $SIM_SADDL=$SIM_OCDL=$SIM_DTDL=$SIM_SFDE=0;//sur immobilisations
            $TDOCDT_SADDL=$TDOCDT_OCDL=$TDOCDT_DTDL=$TDOCDT_SFDE=0;//C. T.V.A. dûe ou crédit de T.V.A = (A - B)

           
            
            
            $dateChoisis= $year ;
            
            if(!isset($_POST['chargement']))
            {
                $dateChoisis=GETPOST('valeurdatechoise');
            }
            //   $dateChoisis=2022;
            
            $sql="SELECT * FROM llx_accounting_bookkeeping";
            $rest=$db->query($sql);
            foreach( $rest as $row )
            { 
                $datetime = new DateTime($row['doc_date']);
                $dateCreation = $datetime->format('Y');
                $numero_compte = $row['numero_compte'];
                $montant = $row['montant']; 
                switch ($numero_compte) {

                 case "4455":list($TF_SFDE, $TF_SADDL)=calculateMontant($dateCreation, $dateChoisis, $TF_SFDE,$TF_SADDL, 0,'4455');break;
                 case "3455":list($TR_SFDE, $TR_SADDL)=calculateMontant($dateCreation, $dateChoisis, $TR_SFDE,$TR_SADDL, 0,'3455');break;
                 case "34552":list($SC_SFDE, $SC_SADDL)=calculateMontant($dateCreation, $dateChoisis, $SC_SFDE,$SC_SADDL, 0,'34552');break;
                 case "34551":list($SIM_SFDE, $SIM_SADDL)=calculateMontant($dateCreation, $dateChoisis, $SIM_SFDE,$SIM_SADDL, 0,'34551');break;
                
                }

                $SC_OCDL=$SC_SFDE-$SC_SADDL;
                $SIM_OCDL=$SIM_SFDE- $SIM_SADDL;
                $TR_OCDL=$SC_OCDL+$SIM_OCDL;
                $TDOCDT_SADDL= $TF_SADDL-$TR_SADDL;
                $TDOCDT_OCDL=$TF_OCDL-$TR_OCDL;
                $TDOCDT_DTDL=$TF_DTDL-$TR_DTDL;
                $TDOCDT_SFDE=$TF_SFDE-$TR_SFDE;

               
            }

            $data .= '$TF_SFDE = ' . (-$TF_SFDE) . ";\n";
            $data .= '$TF_SADDL = ' . (-$TF_SADDL) . ";\n";
            $data .= '$TR_SADDL = ' . $TR_SADDL . ";\n";
            $data .= '$TR_SFDE = ' . $TR_SFDE . ";\n";
             $data .= '$TR_OCDL = ' . $TR_OCDL . ";\n";
            $data .= '$SC_SFDE = ' . $SC_SFDE . ";\n";
            $data .= '$SC_SADDL = ' . $SC_SADDL . ";\n";
            $data .= '$SC_OCDL = ' . $SC_OCDL . ";\n";
            $data .= '$SIM_SADDL = ' . $SIM_SADDL . ";\n";
            $data .= '$SIM_SFDE = ' . $SIM_SFDE . ";\n";
            $data .= '$SIM_OCDL = ' . $SIM_OCDL . ";\n";
            $data .= '$TDOCDT_SADDL = ' . $TDOCDT_SADDL . ";\n";
            $data .= '$TDOCDT_OCDL = ' . $TDOCDT_OCDL . ";\n";
            $data .= '$TDOCDT_DTDL = ' . $TDOCDT_DTDL . ";\n";
            $data .= '$TDOCDT_SFDE = ' . $TDOCDT_SFDE . ";\n";
            
           

            $data .= "?>";

            // Now, the variable $year will contain the year value "2023"
            $nomFichier = 'detatTaxe_fichier_'. $year.'.php';
            // Écrire les données dans le nouveau fichier
            file_put_contents($nomFichier, $data);

           
        
        }
    }

  $object = new User($db);
  $id=$user->id;
  
  
  function GenerateDocuments($year)
  {
    global $day, $month, $year, $start, $prev_year;
    print '<form id="frmgen" name="builddoc" method="post">';
    print '<input type="hidden" name="token" value="' . newToken() . '">';
    print '<input type="hidden" name="action" value="builddoc">';
    print '<input type="hidden" name="model" value="Detailtaxe">';
    print '<input type="hidden" name="year" value="'.$year.'">';
    print '<div class="right"  style="margin-bottom: 100px; margin-right: 20%;">
    <input type="submit" id="btngen" class="button" name="save" value="génerer">';
    print '</form>';
  }
  function ShowDocuments()
  {
    global $db, $object, $conf, $month, $prev_year, $societe, $showAll, $prev_month, $prev_year, $start;
    print '<div class="fichecenter"><divclass="fichehalfleft">';
    $formfile = new FormFile($db);
    $subdir ='';
    $filedir = DOL_DATA_ROOT . '/billanLaisse/Detailtaxe/';
    $urlsource = $_SERVER['PHP_SELF'] . '';
    $genallowed = 0;
    $delallowed = 1;
    $modelpdf = (!empty($object->modelpdf) ? $object->modelpdf : (empty($conf->global->RH_ADDON_PDF) ? '' : $conf->global->RH_ADDON_PDF));
  
    if ($societe !== null && isset($societe->default_lang)) {
      print $formfile->showdocuments('Detailtaxe', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0, '', '', '', $societe->default_lang);
    } else {
        print $formfile->showdocuments('Detailtaxe', $subdir, $filedir, $urlsource, $genallowed, $delallowed, $modelpdf, 1, 0, 0, 40, 0);
    }
  
  }
  // Actions to build doc
  $action = GETPOST('action', 'aZ09');
  $upload_dir = DOL_DATA_ROOT . '/billanLaisse/Detailtaxe/';
  $permissiontoadd = 1;
  $donotredirect = 1;
  
  include DOL_DOCUMENT_ROOT . '/core/actions_builddoc.inc.php';
  

?>

<!DOCTYPE html>

<html>
<head>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title></title>
	<meta name="generator" content="LibreOffice 7.4.2.3 (Linux)"/>
	<meta name="author" content="Microsoft Office User"/>
	<meta name="created" content="2023-08-09T15:38:35"/>
	<meta name="changedby" content="Microsoft Office User"/>
	<meta name="changed" content="2023-08-09T15:38:56"/>
	<meta name="AppVersion" content="16.0300"/>
	
</head>

<body>
<center>
<form method="POST" action="declarationDetatlTaxe.php">
    <?php
    // Loop to create the hidden input fields
    for ($i = 0; $i <= 48; $i++) {
        $detatTaxe = ${'detatTaxe' . $i};
      echo '<input type="hidden" name="detatTaxe' . $i . '" value="' . $detatTaxe . '" />';
    }
    ?>     
    <div>
        <p style="display: inline; margin-top: 10px; font-size: 16px; color: black;">Confirmer :</p>
        <label for="oui">Oui</label>
        <input type="radio" name="sitec" id="oui" value="oui" required>
        <label for="non">Non</label>                    
        <input type="radio" name="sitec" id="non" value="non" required>

        <!-- Code block for "non" option -->
        <div id="nonBlock" style="display: none;">
            <button type="submit" name="chargement" style="margin-top: 18px; background: #4B99AD; padding: 8px 15px; border: none; color: #fff;">Modifier</button><br>
        </div>
    </div>
</form>

<!-- Code block for "oui" option -->
<div id="ouiBlock" style="display: none;">
    <!-- PHP code -->
    <center>
        <?php GenerateDocuments($year); ?>
    </center>
</div>

<script>
    // Function to toggle the display of ouiBlock and nonBlock based on the selected radio button
    function toggleDisplay() {
        var ouiBlock = document.getElementById('ouiBlock');
        var nonBlock = document.getElementById('nonBlock');
        var ouiRadio = document.getElementById('oui');

        if (ouiRadio.checked) {
            ouiBlock.style.display = 'block';
            nonBlock.style.display = 'none';
        } else {
            ouiBlock.style.display = 'none';
            nonBlock.style.display = 'block';
        }
    }

    // Attach the toggleDisplay function to the click event of the radio buttons
    document.getElementById('oui').addEventListener('click', toggleDisplay);
    document.getElementById('non').addEventListener('click', toggleDisplay);
</script>
<table align="center" cellspacing="0" border="0">
	<colgroup width="280"></colgroup>
	<colgroup span="5" width="124"></colgroup>
	<tr>
		<td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=5 height="26" align="center" valign=bottom><b><font face="Calibri" size=4>DETAIL DE LA TAXE SUR LA VALEUR AJOUTEE</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td height="31" align="left" valign=middle><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=middle><font face="Calibri"><br></font></td>
		<td align="left" valign=middle><b><font face="Calibri"><br></font></b></td>
		<td align="left" valign=middle><b><font face="Calibri"><br></font></b></td>
		<td align="right" valign=middle><b><font face="Calibri"></font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 height="73" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Nature</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Solde au début de l'exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Opérations comptables de l'exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Déclarations TVA de l'exercice</font></b></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#D9D9D9"><b><font face="Calibri">Solde fin d'exercice</font></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font face="Calibri">1</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdval="2" sdnum="1033;"><b><i><font face="Calibri">2</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9" sdval="3" sdnum="1033;"><b><i><font face="Calibri">3</font></i></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom bgcolor="#D9D9D9"><b><i><font face="Calibri">(1 + 2 - 3 = 4)</font></i></b></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="33" align="left" valign=middle><b><font face="Calibri">A. T.V.A. Facturée</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($TF_SADDL*-1);?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($detatTaxeValeur1);?><br></font></b></td>
		<td align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($detatTaxeValeur2);?><br></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php echo( $TF_SFDE *-1);?></font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow" color="#FFFFFF">GrasGauche</font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="33" align="left" valign=middle><b><font face="Calibri">B. T.V.A. Récuperable</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($TR_SADDL);?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($TR_OCDL);?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php readMontant($TR_SFDE);?></font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow" color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="33" align="left" valign=middle><font face="Calibri">- sur charges</font></td> 
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($SC_SADDL);?></font></td>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($SC_OCDL);?></font></td>
		<td align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($detatTaxeValeur3);?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($SC_SFDE);?></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="33" align="left" valign=middle><font face="Calibri">- sur immobilisations</font></td> 
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($SIM_SADDL);?></font></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($SIM_OCDL);?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($detatTaxeValeur4);?><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><font face="Calibri"><?php readMontant($SIM_SFDE);?></font></td>
		<td align="left" valign=middle><font face="Arial Narrow" color="#FFFFFF"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="33" align="left" valign=middle><b><font face="Calibri">C. T.V.A. dûe ou crédit de T.V.A = (A - B)</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php echo ($TDOCDT_SADDL);?></font></b></td> 
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php echo ($TDOCDT_OCDL);?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri">0.00</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdval="0" sdnum="1033;0;#,##0.00"><b><font face="Calibri"><?php echo ($TDOCDT_SFDE);?></font></b></td>
		<td align="left" valign=middle><font face="Arial Narrow" color="#FFFFFF">GrasGauche</font></td>
	</tr>
	<tr>
		<td height="17" align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td height="17" align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
		<td align="left" valign=bottom><font face="Arial Narrow"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 height="25" align="center" valign=bottom bgcolor="#FBE5D6"><b><i><font face="Calibri" size=4>TVA - Déclarations de l'exercice<br>(Ce tableau ne fait pas partie de la liasse. Il est destiné à vous aider à remplir ce tableau)</font></i></b></td>
		</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="113" align="center" valign=middle bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>Mois</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>TVA Facturée</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>TVA Récupérable sur charges</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>TVA Récupérable sur immobilisations</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>Crédit M-1</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>Solde (pour Vérification)</font></i></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Janvier</font></i></b></td>
        <?php
                for ($i = 0; $i <= 3; $i++) {
                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3>'.${'detatTaxe' . $i}.'</td>' . "\n";
                }
            ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3><?php echo $Solde1;?></font></i></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Février</font></i></b></td>
        <?php
                for ($i = 4; $i <= 7; $i++) {
                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3>'.${'detatTaxe' . $i}.'</td>' . "\n";
                }
            ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3><?php echo $Solde2;?></font></i></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Mars</font></i></b></td>
        <?php
                for ($i = 8; $i <= 11; $i++) {
                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3>'.${'detatTaxe' . $i}.'</td>' . "\n";
                }
            ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3><?php echo $Solde3;?></font></i></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Avril</font></i></b></td>
        <?php
                for ($i = 12; $i <= 15; $i++) {
                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3>'.${'detatTaxe' . $i}.'</td>' . "\n";
                }
            ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3><?php echo $Solde4;?></font></i></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Mai</font></i></b></td>
        <?php
                for ($i = 16; $i <= 19; $i++) {
                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3>'.${'detatTaxe' . $i}.'</td>' . "\n";
                }
            ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3><?php echo $Solde5;?></font></i></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Juin</font></i></b></td>
        <?php
                for ($i = 20; $i <= 23; $i++) {
                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3>'.${'detatTaxe' . $i}.'</td>' . "\n";
                }
            ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3><?php echo $Solde6;?></font></i></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Juillet</font></i></b></td>
        <?php
                for ($i = 24; $i <= 27; $i++) {
                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3>'.${'detatTaxe' . $i}.'</td>' . "\n";
                }
            ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3><?php echo $Solde7;?></font></i></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Août</font></i></b></td>
        <?php
                for ($i = 28; $i <= 31; $i++) {
                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3>'.${'detatTaxe' . $i}.'</td>' . "\n";
                }
            ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3><?php echo $Solde8;?></font></i></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Septembre</font></i></b></td>
        <?php
                for ($i = 32; $i <= 35; $i++) {
                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3>'.${'detatTaxe' . $i}.'</td>' . "\n";
                }
            ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3><?php echo $Solde9;?></font></i></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Octobre</font></i></b></td>
        <?php
                for ($i = 36; $i <= 39; $i++) {
                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3>'.${'detatTaxe' . $i}.'</td>' . "\n";
                }
            ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3><?php echo $Solde10;?></font></i></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Novembre</font></i></b></td>
        <?php
                for ($i = 40; $i <= 43; $i++) {
                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3>'.${'detatTaxe' . $i}.'</td>' . "\n";
                }
            ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3><?php echo $Solde11;?></font></i></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=bottom><b><i><font face="Calibri" size=3>Décembre</font></i></b></td>
        <?php
                for ($i = 44; $i <= 47; $i++) {
                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom bgcolor="#DAE3F3" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3>'.${'detatTaxe' . $i}.'</td>' . "\n";
                }
            ?>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;#,##0.00"><i><font face="Calibri" size=3><?php echo $Solde12;?></font></i></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="22" align="center" valign=top bgcolor="#FBE5D6"><b><i><font face="Calibri" size=3>Totaux</font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#FBE5D6" sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri" size=3><?php echo $sum1;?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#FBE5D6" sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri" size=3><?php echo $sum2;?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#FBE5D6" sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri" size=3><?php echo $sum3;?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#FBE5D6" sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri" size=3><?php echo $sum4;?></font></i></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom bgcolor="#FBE5D6" sdval="0" sdnum="1033;0;#,##0.00"><b><i><font face="Calibri" size=3><?php echo $sum5;?></font></i></b></td>
	</tr>
</table>

<!-- ************************************************************************** -->
</body>

</html>
