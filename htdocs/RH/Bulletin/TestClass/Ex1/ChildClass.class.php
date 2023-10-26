<?php
require_once DOL_DOCUMENT_ROOT.'/RH/Bulletin/TestClass/MyCustomClass.class.php';

class ChildClass extends MyCustomClass{

    public $three;
    public $db;

    public function __construct()
    {
        // parent::__construct($one, $two);
        // $this->three=$three;
    }

    public function readCodechild($one,$two,$three)
    {
        $this->readCode($one,$two);
        echo ' three value : '.$three;
    }


}