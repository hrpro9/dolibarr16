<?php
class MyCustomClass{
    public $db;
    public $one;
    public $two;
    /**
	 *  Constructor
	 *
	 *  @param	DoliDB		$db		Database handler
	 */
    public function __construct() {
    }


    public function readCode($one,$two)
    {
        echo '-one value : '.$one .'-two value : '.$two;
    }




}