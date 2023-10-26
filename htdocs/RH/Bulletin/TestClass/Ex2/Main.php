<?php

require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT.'/RH/Bulletin/TestClass/Circle.class.php';
require_once DOL_DOCUMENT_ROOT.'/RH/Bulletin/TestClass/Rectangle.class.php';
llxHeader("", "");

if(isset($_POST['calcul']))
{
    $raduis=$_POST['raduis'];
    $width=$_POST['width'];
    $height=$_POST['height'];

    $circle = new Circle($raduis);
    echo $circle->claculateArea();
    $circle->toString();

    echo '<br/>-----------------';

    $rectangle = new Rectangle($width,$height);
    echo $rectangle->claculateArea();
    $rectangle->toString();

}else{
    echo '
    <style>
    /* CSS style for the form *

    /* CSS style for form inputs (optional) */
    input[type="text"] {
        border: 1px solid #ccc; /* Add your desired border style here */
        padding: 5px; /* Add padding for spacing */
    }
   </style>
   <center>
    <form method="POST">
    <h6>raduis</h6>
    <input type="text" name="raduis" id="">
    <br>
    <h6>width</h6>
    <input type="text" name="width" id="">
    <br>
    <h6>height</h6>
    <input type="text" name="height" id="">
    <br>
    <input type="submit" name="calcul" value="calcul">
    </form>
    </center>
    ';
}

