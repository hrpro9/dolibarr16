<?php
require_once DOL_DOCUMENT_ROOT.'/RH/Bulletin/TestClass/Shape.class.php';
class Circle extends Shape{
    private $raduis;

    public function __construct($r)
    {
        $this->raduis=$r;
    }

    public function claculateArea()
    {
        return 'circle : '.round((pi()*$this->raduis*$this->raduis),2);
    }

    public function toString(){
        echo '<br/> test raduis : '.$this->raduis;
    }
}