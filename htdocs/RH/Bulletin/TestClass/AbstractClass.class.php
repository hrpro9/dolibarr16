<?php

abstract class AbstractClass {
    public $value1;
    public $value2;

    public function afficheValue() { 
        echo '<br /> value 1 : ' . $this->value1 . ' value 2 : ' . $this->value2 ;
    }
}
