<?php

require_once DOL_DOCUMENT_ROOT.'/RH/Bulletin/TestClass/ExBank/MoneyAbstract.class.php';

class Bank extends MoneyAbstract{
    private $money;
    private $account;

    public function __construct($m,$a)
    {
        $this->money=$m;
        $this->account=$a;
    }


    public function Deposit($d){
        $this->money+=$d;
        return  $this->money;
    }

    public function  Take($t){
        return 
        ($this->money> $t)?'money to take is:'.$t.'<br>money in account  : '.$this->money-=$t
        :
        'money i want take is:'.$t.'<br>its impossible because in account there just : '.$this->money;
    }


    public function KnowMoney(){
        return $this->money;
    }
    public function KnowAccount(){
        return $this->account;
    }

}