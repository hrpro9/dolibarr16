<?php
    // Load Dolibarr environment
    require '../../main.inc.php';
    require_once '../../vendor/autoload.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
    session_start();
    llxHeader("", "");

    if(isset($_REQUEST['success'])){
        echo '
        <style>
            /* Styles for the alert */
            .alertCheckbox {
                display: none; /* Hide the checkbox */
            }
            .alert {
                display: none;
                padding: 10px;
                margin-top: 10px;
                background-color: #4CAF50; /* Green background color */
                color: white;
                border-radius: 5px;
            }
            .alertCheckbox:checked + .alert {
                display: block; /* Show the alert when the checkbox is checked */
            }
            .alertClose {
                float: right;
                cursor: pointer;
            }
        </style>
        <label>
            <input type="checkbox" class="alertCheckbox" autocomplete="off" checked />
            <div class="alert success">
                <span class="alertClose" onclick="this.parentElement.style.display=\'none\'">X</span>
                <span class="alertText">Generate payment delay file successful. Total: ' . $_SESSION['totalAllAmount'] . '<br class="clear"/></span>
            </div>
        </label>';
    }
?>
    <!doctype html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="style.css">       
    </head>
    <body >
        <center>
            <div class="col-lg-4 m-auto" >
                <form method="post" action="GenereteDelaisPaiment.php"  enctype="multipart/form-data" >
                <ul class="form-style-1" style="text-align: center;">
                    <label style="text-align: center;" class="field-divided">Fichier EDI Delais Paiement !!!</label>
                    <li>
                    <label>Trimestre & Période  <span class="required">* </label>
                        <select onchange="getCities(this.value)" name="trimestre" required>
                            <option value="">Choose a periode</option>
                            <option value="Trimestriellement">Trimestriellement</option>
                            <option value="Annuellement">Annuellement</option>
                        </select>
                        <select name="periode" id="periode" disabled required>
                            <option value="">Choose a trimestre</option>
                        </select>
                    </li>
                    <li>
                    <label>activite <span class="required">* </label>
                        <select name="activite" required>
                            <option value="">Choose a activite</option>
                            <option value="1">Activité normale</option>
                            <option value="2">Entreprise en cours de procédure</option>
                        </select>
                    </li>
                  
                    <li style="margin-top: 18px;">
                        <input type="submit" name="fichierDelaisPaiement" value="suivant" />
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
                    var currentDate = new Date();
                    var currentYear = currentDate.getFullYear();
                    var previousYear = currentYear - 1;
                    var periodValue=true;
                    
                    for(let period of periode){
                        if(period=="Annuelle")
                        {
                            out += `<option value="${period}">l'année N-1 ( ${previousYear} )</option>`;
                            break;
                        }
                        else{
                                if(periodValue)
                                {
                                    out += `<option value=""></otion>`;
                                    periodValue=false;   
                                }
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


    
