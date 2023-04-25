<?php

  require '../../main.inc.php';
  

  if(isset($_POST['code_barre']))
  {
     $code_barre=$_POST['code_barre'];
     $sql="INSERT INTO llx_product_code_barr VALUES ('$code_barre')"; 
     $res = $db->query($sql); 
  }

?>

<!doctype html>
<html lang="en">
  <head>
  <link rel="stylesheet" href="style.css">
  </head>
  <body >

    <div class="container ">
        <div class="row">
          <!-- salaire net!!!!! -->
            <div class="col-lg-4 ">
            <form method="post" class="shadow-lg p-3 mb-5 bg-body rounded mt-5">
                <ul class="form-style-1">
                  <h4 style="text-align: center;" class="field-divided"> !!!</h4>
                  <li>
                    <label>code barre <span class="required">*</span></label>
                    <input type="text" name="code_barre" value="7400" class="field-divided" placeholder="code barre" required/>
                  </li>
                  <li style="margin-top: 18px;">
                    <input type="submit"  name="code_barre" value="Save" />
                  </li>    
                </ul>
              </form>
            </div>     
            <!-- salaire de net!!!!! -->
            <div class="col-lg-4 "> 
               
            </div>
        </div>
    </div>


  </body>
</html>