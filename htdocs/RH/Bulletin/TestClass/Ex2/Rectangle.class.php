<?php
require_once DOL_DOCUMENT_ROOT.'/RH/Bulletin/TestClass/Shape.class.php';
class Rectangle extends Shape{
    private $width;
    private $height;

    public function __construct($w,$h)
    {
        $this->width=$w;
        $this->height=$h;
    }

    public function claculateArea()
    {
        return '<br/>Rectangle : '.($this->width*$this->height);
    }

    public function toString()
    {
        echo '<br/>width is : '.$this->width . ' and height is : '.$this->height;
    }
}