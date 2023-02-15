<?php
  // Load Dolibarr environment
  require '../../main.inc.php';
  require_once '../../vendor/autoload.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/class/html.formother.class.php';
  require_once DOL_DOCUMENT_ROOT . '/core/lib/date.lib.php';

  //get N°cnss
  $sql1 = "SELECT cnss FROM llx_Paie_UserInfo";
  $res = $db->query($sql1);

 
?>
<!doctype html>
<html lang="en">
  <head>
    <style>
      table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
      text-align:center;
    }
    </style>
  </head>
  <body >
<center>
            <div class="col-lg-4 m-auto">
              <form method="post"  class="shadow-lg p-3 mb-5 bg-body rounded mt-5">
                <h4 class="text-center text-primary">Teledeclaration !!!</h4>
                <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Ficher preetabli  </label><br>
                <input type="file" name="" class="form-control" >
                </div><br>
                <div class="mb-3">
               <table >
                  <tr >
                    <th >N*cnss</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th >cin</th>
                    <th>jour</th>
                    <th>salaire</th>
                    <th>stuation</th>
                  </tr>
                  <?php
                  foreach ($res  as $user) {
                    ?>
                    <tr>
                    <td><?= $user['cnss'] ?></td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                  </tr>
                  <?php
                  }
                 ?>
                </table>
                </div><br>
                <button type="submit" name="teledeclaration" class="btn btn-primary">Generer</button>
              </form>
            </div> 
</center>
           

  </body>
</html>