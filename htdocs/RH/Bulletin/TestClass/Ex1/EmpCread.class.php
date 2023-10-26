<?php
require_once DOL_DOCUMENT_ROOT.'/RH/Bulletin/TestClass/AbstractClass.class.php';
require_once DOL_DOCUMENT_ROOT.'/RH/Bulletin/TestClass/interfaceClass.class.php';

class EmpCread implements interfaceClass{

    public $a,$b,$c;
    public function readinterfaceClass(){
        echo '<br/> this page interface class ';
    }

}