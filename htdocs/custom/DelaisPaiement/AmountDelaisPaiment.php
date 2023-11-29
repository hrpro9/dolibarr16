<?php
    // Load Dolibarr environment
    require '../../main.inc.php';
    require_once '../../vendor/autoload.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
    require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';


    llxHeader("", "");


    if(isset($_POST['chargement']))
    {
        $date_select=$_POST['date_select'];
        $sql="SELECT * FROM llx_DelaisPaiement WHERE dateDP = $date_select";
        $res=$db->query($sql);
    }else{
        $sql="SELECT * FROM llx_DelaisPaiement";
        $res=$db->query($sql);
    }
    


?>

<head>
    <link rel="stylesheet" href="./css/styleTable.css">
</head>

<body>
    <!-- <p>Sort Table Rows by Clicking on the Table Headers - Ascending and Descending (jQuery)</p> -->
    <div class="container">
       <center>
            <form method="POST" >
                <select name="date_select" required>
                    <option value="">Choisis date</option>
                        <?php
                           $anneedebut=2021;
                            for ($i = date('Y'); $i >= $anneedebut; $i--) {
                                echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            
                        ?>
                </select>
                <button type="submit" name="chargement" 
                style="margin: 18px 0px;background: rgb(38,60,92);padding: 8px 15px 8px 15px;border: none;color: #fff;">Chargement</button><br>  
           
       </center>

     
            <h1 style="color: #666;font-size: 25px;text-align:center;margin:20px 0px">List Delais Paiement !!!</h1>     
            <div class="table">
                <div class="table-header">
                    <div class="header__item"><a id="name" class="filter__link" href="#">#</a></div>
                    <div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">Periode</a></div>
                    <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">Total Amount</a></div>
                    <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">Date DP</a></div>
                </div>
                <div class="table-content">
                    <?php
                    foreach( $res as $row )
                    {
                        echo '
                            <div class="table-row">
                                <div class="table-data">'.$row['id'].'</div>
                                <div class="table-data">'.$row['periode'].'</div>
                                <div class="table-data">'.$row['totalAmount'].'</div>
                                <div class="table-data">'.$row['dateDP'].'</div>
                            </div> 
                        '; 
                    }
                       
                    ?>
                </div>
            </div>
        </form>
    </div>
</body>
    