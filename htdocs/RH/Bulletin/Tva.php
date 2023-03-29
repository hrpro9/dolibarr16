<?php
  // Load Dolibarr environment
  require '../../main.inc.php';
  require_once '../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
 

  if(isset($_POST['fichiertva']))
  { 
    $regime_value=$_POST['regime'];
    $periode_value=$_POST['periode'];

    $nomfiche="Tva.xml";
    header('Content-Disposition: attachment; filename='.$nomfiche);
    header('Content-Type: text/xml'); 
    // Create a new DOM document
    $dom=new DOMDocument(); 
    $dom->formatOutput=true;  
    // Create a DeclarationReleveDeduction element
    $DeclarationReleveDeduction = $dom->createElement('DeclarationReleveDeduction');
    $dom->appendChild($DeclarationReleveDeduction);

    // identifiantFiscal
    $identifiantFiscal = $dom->createElement('identifiantFiscal','?');
    $DeclarationReleveDeduction->appendChild($identifiantFiscal);   
    // annee
    $annee_now= date('Y'); 
    $annee = $dom->createElement('annee',$annee_now);
    $DeclarationReleveDeduction->appendChild($annee);   
    // periode
    if($regime_value==3 || $regime_value==4)
    {
        $periode_value= date('m'); 
    }
    $periode = $dom->createElement('periode',$periode_value);
    $DeclarationReleveDeduction->appendChild($periode);   
    // regime
    $regime = $dom->createElement('regime',$regime_value);  
    $DeclarationReleveDeduction->appendChild($regime);
    // releveDeductions
    $releveDeductions = $dom->createElement('releveDeductions');
    $DeclarationReleveDeduction->appendChild($releveDeductions);
    $ordPlus=0;   
    // $param='';
    $sql="SELECT *  FROM llx_facture_fourn";
    $rest_rd=$db->query($sql);
    // $param = ((object)($rest_ef))->fetch_assoc();
    foreach($rest_rd as $rdTva)
    { 
        $ordPlus+=1;
        // rd
        $rd = $dom->createElement('rd');
        $releveDeductions->appendChild($rd);
        // ord
        $ord = $dom->createElement('ord',$ordPlus);
        $rd->appendChild($ord);
        // num
        $num = $dom->createElement('num',$rdTva['ref']);
        $rd->appendChild($num);
        // des
        $des = $dom->createElement('des',$rdTva['libelle']);
        $rd->appendChild($des);
        // mht 
        $mht = $dom->createElement('mht', number_format($rdTva['total_ht'],2));
        $rd->appendChild($mht);
        // tva
        $tva = $dom->createElement('tva',number_format($rdTva['total_tva'],2));
        $rd->appendChild($tva);
        // ttc
        $ttc = $dom->createElement('ttc',number_format($rdTva['total_ttc'],2));
        $rd->appendChild($ttc);
        // refF
        $refF = $dom->createElement('refF');
        $rd->appendChild($refF);	
        $sql_reff="SELECT *  FROM llx_societe WHERE rowid=" . $rdTva['fk_soc'] . " ";
        $rest_reff=$db->query($sql_reff);
        $param_reff = ((object)($rest_reff))->fetch_assoc();
        // if
        $if = $dom->createElement('if',$param_reff['code_fournisseur']);
        $refF->appendChild($if);
        // nom
        $nom = $dom->createElement('nom',$param_reff['nom']);
        $refF->appendChild($nom);
        // ice
        $ice = $dom->createElement('ice',$param_reff['idprof5']);
        $refF->appendChild($ice);
        // tx
        $txt_tv=($rdTva['total_tva']/$rdTva['total_ht'])*100;
        $tx = $dom->createElement('tx',number_format($txt_tv,2));
        $rd->appendChild($tx);
        // prorata
        $prorata = $dom->createElement('prorata','?');
        $rd->appendChild($prorata);
        // llx_paiement
        $param_p='';
        $sql_p="SELECT *  FROM llx_paiement WHERE fk_user_creat=" . $rdTva['fk_user_author'] . " ";
        $rest_p=$db->query($sql_p);
        $param_p = ((object)($rest_p))->fetch_assoc();
        // mp
        // llx_c_paiement
        $sql="SELECT *  FROM llx_c_paiement ";
        $rest_cp=$db->query($sql);
        // $param = ((object)($rest))->fetch_assoc();
       foreach( $rest_cp as $cp)
        {
                foreach($rest_p as $p)
                {
                    if($p['fk_paiement'] == $cp['id'])
                    {
                        $mp = $dom->createElement('mp');
                        $rd->appendChild($mp);
                        // id_mp
                        switch ($cp['libelle']) {
                            case 'Cash':$mp_id=1;break;
                            case 'Cheque':$mp_id=2;break;
                            case 'Debit order':$mp_id=3;break;
                            case 'Transfer':$mp_id=4;break;
                            case 'Traite':$mp_id=5;break;
                            default:$mp_id=7;
                        }
                        $id = $dom->createElement('id',$mp_id);
                        $mp->appendChild($id);
                    }
                }  
        } 
        // dpai
        $datetime = new DateTime($param_p['datep']);
        $date = $datetime->format('Y-m-d');
        $dpai = $dom->createElement('dpai',$date);
        $rd->appendChild($dpai);
        // dpai
        $dfac = $dom->createElement('dfac',$rdTva['datef']);
        $rd->appendChild($dfac);
    }
    // Output the XML file without XML declaration
    echo $dom->saveXML($dom->documentElement);
   }
    else
    {     
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <link rel="stylesheet" href="style.css">       
        </head>
        <body >
          <center>
                <div class="col-lg-4 m-auto" style="width:100% ;height: 100%;">
                    <form method="post"  enctype="multipart/form-data" >
                    <ul class="form-style-1" style="text-align: center;">
                        <h4 style="text-align: center;" class="field-divided">Fichier EDI TVA !!!</h4>
                        <li>
                        <label>Régime & Période de la déclaration TVA <span class="required">* </label>
                            <select onchange="getCities(this.value)" name="regime" required>
                                <option value="">Choose a Régime</option>
                                <option value="1">Mensuel</option>
                                <option value="2">Trimestriel</option>
                                <option value="3">Déclaration TVA</option>
                                <option value="4">Cessation TVA</option>
                            </select>
                            <select name="periode" id="periode" disabled required>
                                <option value="">Choose a Période</option>
                            </select>
                        </li>
                        <li style="margin-top: 18px;">
                            <input type="submit" name="fichiertva" value="Télécharge" />
                        </li>      
                    </ul>
                    </form>  
                </div> 
         </center>
            <script>
                function getCities(declaration){
                    let citiesDropDown = document.querySelector("#periode");
                    
                    if(declaration.trim() === ""){
                        citiesDropDown.disabled = true;
                        citiesDropDown.selectedIndex = 0;
                        return false;
                    } 
                    // AJAX request with fetch() 
                    fetch("periode_declaration.json")
                    .then(function(response){
                        return response.json();
                    })
                    .then(function(data){
                        let periode = data[declaration];
                        let out = "";
                        out += `<option value=""></otion>`;   
                        for(let period of periode){
                            if(period==00)
                            {
                                out += `<option value="${period}">mois en cours</option>`;
                                break;
                            }
                            else{
                                out += `<option value="${period}">${period}</otion>`;   
                            }    
                        }
                        citiesDropDown.innerHTML = out;
                        citiesDropDown.disabled = false;
                    });
                }
            </script>
        </body>
        </html>
        <?php
    }
?>    
