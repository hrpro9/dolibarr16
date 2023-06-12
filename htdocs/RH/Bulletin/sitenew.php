          echo '<br>';
          echo '<div class="succes">';
          echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
          echo' <center>La quantite retournee est Modiifer</center>';
          echo '</div>';


          echo '<div class="alert">';
          echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
          echo' <center><strong>Attention!</strong> La quantite retournee et superieur de la quantite du stock</center>';
          echo '</div>';


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
