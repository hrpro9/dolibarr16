<?php


require_once '../../main.inc.php';

llxHeader("", "");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="calcul_Style.css">

<style>
  .alert {
  padding: 20px;
  background-color: #d51000;
  color: white;
  border-radius: 8px;
}
.succes{

  padding: 20px;
  background-color: #40a52a;
  color: white;
  border-radius: 8px;
  

}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}

.site-form {
  width: 300px;
  margin: 10px;
  padding: 10px;
  background-color: #f5f5f5;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.form-message {
  margin-bottom: 10px;
  font-weight: bold;
}

label {
  display: block;
  margin-bottom: 5px;
}

select,
input[type="submit"] {
  padding: 5px;
  font-size: 14px;
  border-radius: 4px;
}

.submit-button {
  background-color: #4caf50;
  color: #fff;
  cursor: pointer;
}

.submit-button:hover {
  background-color: #45a049;
}

</style>

</head>
<body>

<!-- Add a button to show the input field -->
<!-- <button onclick="showInput()">Add Nouvel Site +</button> -->



<center>
<div class="col-lg-4 m-auto" style="width:100% ;height: 100%;">
<form method="post"  >
                    <input type="hidden" name="action" value="generate">
                    <ul class="form-style-1" style="text-align: center;">
                     
                       
                        <li>
                            <label> Nouveau Site <span class="required">*</span></label>
                            <input type="text" t name="new_city" required class="field-divided" placeholder=" Nouveau Site"  />
                            
                        </li>
                       
                        <li style="margin-top: 18px;">
                            <input type="submit"  value="Enregister" />
                        </li>      
                    </ul>
                    </form>  
                </div>       

                  
 </center>  
</body>
</html>



<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the serialized array from the database
  $sql = "SELECT rowid,param FROM `llx_extrafields` WHERE name='site'";
  $rest = $db->query($sql);
  $param = $rest->fetch_assoc();
  $x = $param['param'];

  // Unserialize the array
  $array = unserialize($x);

  // Check if the new city is set in the POST data
  if (isset($_POST['new_city'])) {
    $new_city = $_POST['new_city'];

    // Check if the new city already exists in the array
    if (in_array($new_city, $array['options'])) {

      echo '<div class="alert">';
      echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
      echo' <center><strong>Attention!</strong> Error: Ce site  ' . $new_city . ' existe déjà</center>';
      echo '</div>';
   
   
    } else {
      // Add the new city to the array
      $array['options'][] = $new_city;

      // Serialize the modified array
      $serialized_array = serialize($array);

      if ($serialized_array) {
        echo '
        <center>
        <form method="post" class="site-form">
        <p class="form-message">Le site à ajouter ----> '. $new_city .' </p>
        <label for="sitec">Confirmation :</label>
        <select name="sitec" id="sitec" required>
        <option value="oui">Oui</option>
        <option value="no">Non</option>
         </select>
          <input type="hidden" name="new_city" value="' . $new_city . '">
          <input type="submit" name="submit" value="Valider" class="submit-button">  
        </form>
        </center>';
      }

      if (isset($_POST['submit'])) {

        $sitec = $_POST['sitec'];
        if($sitec=="oui")
        {
          // Update the `param` column in the database
          $sql = "UPDATE `llx_extrafields` SET `param` = '$serialized_array' WHERE `rowid` = " . $param['rowid'];
          $rest = $db->query($sql);
          if ($rest) {
            // $urltoredirect = DOL_URL_ROOT.'/RH/Bulletin/nouvelSite.php?idmenu=21978&leftmenu=';
            // echo "<script>window.location.href = '$urltoredirect';</script>";
          echo '<br>';
          echo '<div class="succes">';
          echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
          echo' <center>Le site  ' . $new_city . ' a été ajouté</center>';
          echo '</div>';
          }
        }else{
          echo '<div class="alert">';
          echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
          echo' <center><strong>Attention!</strong>Le site ' . $new_city . ' a été annulé.</center>';
          echo '</div>';
        }
      
      }
    }
  } else {
    echo ' <div class="alert" style="background-color: #f8d7da;border: 1px solid #f5c6cb;padding: 10px; color: #721c24;width:500px;margin-top:10px;">Error: Veuillez fournir une nouvelle ville</div> <br>';
  }
}
?>



