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
              <form method="post" enctype="multipart/form-data"  class="shadow-lg p-3 mb-5 bg-body rounded mt-5">
                <h4 class="text-center text-primary">Teledeclaration !!!</h4>
                <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Ficher preetabli  </label><br>
                <input type="file" name="fichename" class="form-control" >
                </div><br>  
                <button type="submit" name="submit" class="btn btn-primary">Read fiche</button><br> 
              </form>

              <?php
                if(isset($_POST['submit']))
                {
                    $filename = $_FILES["fichename"]["name"];
                    $tempname = $_FILES["fichename"]["tmp_name"];  
                    $folder = "htdocs/RH/Bulletin/files/".$filename;   
                    if (move_uploaded_file($tempname, $folder)){
                        $msg = "Image uploaded successfully";
                    }else{
                        $msg = "Failed to upload image";
                    }

                    $file=fopen("$folder","r") or die("Unable to open file!");
                    $r=fread($file,filesize("$folder"));
                    fclose($file);
                    echo $r;
                }
              ?>







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
                      <td>
                        <select name="cars" id="cars">
                        <option value="sr"></option>
                          <option value="sr">sr</option>
                          <option value="sr">sr</option>
                          <option value="sr">sr</option>
                          <option value="sr">sr</option>
                        </select>
                      </td>
                    </tr>
                    <?php
                    }
                  ?>
                  </table>
               </div><br>
             
            </div> 
</center>
           

  </body>
</html>