<?php
 // Load Dolibarr environment
 require '../../main.inc.php';
 require_once '../../vendor/autoload.php';
 require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
 require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
 require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';
 llxHeader("", ""); 

 if(isset($_POST['ajouter']))
 {
    $janv=$_POST['janv'];
    $fevr=$_POST['fevr'];
    $mars=$_POST['mars'];
    $avril=$_POST['avril'];
    $mai=$_POST['mai'];
    $juin=$_POST['juin'];
    $juillet=$_POST['juillet'];
    $aout=$_POST['aout'];
    $septembre=$_POST['septembre'];
    $octobre=$_POST['octobre'];
    $novembre=$_POST['novembre'];
    $decembre=$_POST['decembre'];
    $toal= $janv+$fevr+$mars+$avril+$mai+$juin+$juillet+$aout+$septembre+$octobre+$novembre+$decembre;

    $sql = "INSERT INTO llx_objectif_annuel (janvier, février, mars, avril, mai, juin, juillet, août, septembre, octobre,novembre,décembre) 
      VALUES ('$janv', '$fevr', '$mars',' $avril',' $mai', '$juin', '$juillet',' $aout', '$septembre', '$octobre','$novembre','$decembre')";
    $res = $db->query($sql);

 }





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 90%;
        }

        #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        #customers td,#customers input {
            width: 92px
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: rgb(38,60,92);
        color: white;
        }
    </style>
    </head>
    <body>
        <h1>Saisie objet commercial</h1>
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">

            <table id="customers">
                <tr>
                    <th>Janvier</th>
                    <th>Février</th>
                    <th>Mars</th>
                    <th>Avril</th>
                    <th>Mai</th>
                    <th>Juin</th>
                    <th>Juillet</th>
                    <th>Août</th>
                    <th>Septembre</th>
                    <th>Octobre</th>
                    <th>Novembre</th>
                    <th>Décembre</th>
                </tr>
                <tr>
                    <td><input type="number" min="0" step="any"  name="janv"></td>
                    <td><input type="number" min="0" step="any"  name="fevr"></td>
                    <td><input type="number" min="0" step="any"  name="mars"></td>
                    <td><input type="number" min="0" step="any"  name="avril"></td>
                    <td><input type="number" min="0" step="any"  name="mai"></td>
                    <td><input type="number" min="0" step="any"  name="juin"></td>
                    <td><input type="number" min="0" step="any"  name="juillet"></td>
                    <td><input type="number" min="0" step="any"  name="aout"></td>
                    <td><input type="number" min="0" step="any"  name="septembre"></td>
                    <td><input type="number" min="0" step="any"  name="octobre"></td>
                    <td><input type="number" min="0" step="any"  name="novembre"></td>
                    <td><input type="number" min="0" step="any"  name="decembre"></td>
                </tr>
            </table>
        <input type="submit" name="ajouter" value="Ajouter" style="margin-top: 18px;background: rgb(38,60,92);padding: 8px 15px 8px 15px;border: none;color: #fff;" />
        </form>
    </body>
    </html>