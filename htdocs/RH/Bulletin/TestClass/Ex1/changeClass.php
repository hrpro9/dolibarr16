<?php
require_once '../../../main.inc.php';
require_once '../../../vendor/autoload.php';
require_once DOL_DOCUMENT_ROOT.'/RH/Bulletin/TestClass/MyCustomClass.class.php';
require_once DOL_DOCUMENT_ROOT.'/RH/Bulletin/TestClass/ChildClass.class.php';
require_once DOL_DOCUMENT_ROOT.'/RH/Bulletin/TestClass/EmpCread.class.php';
llxHeader("", "");

if(isset($_POST['genere']))
{
    $one=$_POST['one'];
    $two=$_POST['two'];
    $three=$_POST['three'];
    // $mycustom = new MyCustomClass($db,$one,$two);
    // // $mycustom->doSomething( $one,$two);
    // $mycustom->one=$one;
    // $mycustom->two=$two;
    // $mycustom->readCode();
    $childCustom=new ChildClass();
    $childCustom->three=$three;
    
    $childCustom->readCodechild($one,$two,$three);
    $empCrea=new EmpCread();

    $empCread = new EmpCread();

    $empCread->readinterfaceClass();

}else{
    echo'
    <form action="" style="border:1px bold;" method="POST">
        <input type="text" name="one" id="">
        <input type="text" name="two" id="">
        <input type="text" name="three" id="">
        <input type="submit" name="genere" value="genere">
    </form>';
}




