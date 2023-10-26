<?php
require_once '../../../../main.inc.php';
require_once '../../../../vendor/autoload.php';
llxHeader("", "");
require_once DOL_DOCUMENT_ROOT.'/RH/Bulletin/TestClass/ExBank/Bank.class.php';

$moneydeposit= new Bank(6000,448814588760);

echo'
<style>
    /* Style for the container div */
    .form-container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    /* Style for the select dropdown and label */
    .form-container p {
        margin: 10px 0;
    }

    .form-container label {
        display: inline-block;
        vertical-align: middle;
        margin-left: 10px;
    }

    /* Style for the submit button */
    .form-container input[type="submit"] {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Style for the select dropdown */
    .form-container select {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>';

if(isset($_POST['confirm1']))
{
    $takemony1=$_POST['takemony1'];
    echo '
    <center>
        <div class="form-container">
            <p><label for="action"> '. $moneydeposit->Take($takemony1) . ' </label> </p>       
        </div>
    </center>';
}

else if(isset($_POST['confirm2'])){
    $depositmony2=$_POST['depositmony2'];
    echo'
    <center>  
        <div class="form-container">
            <p>
                <label for="action"> money to  Deposit is : '.$depositmony2.' mony in account now : '. $moneydeposit->Deposit($depositmony2).' </label>
            </p>
           
        </div>
    </center>';
}

else if(isset($_POST['confirm']))
{
  $actionMay=$_POST['actionMay'];

  if($actionMay==="takeMoney")
  {
    echo'
    <center>  
        <div class="form-container">
            <form action="" method="POST">
                <p>
                    <label for="action">Enter number money to want take :</label>
                    <input type="text" name="takemony1" placeholder="0.00" />
                </p>
                <input type="submit" name="confirm1" value="Confirm" >
        
            </form>
        </div>
    </center>';
  }

  else if($actionMay==="depositMoney"){
    echo'
    <center>  
        <div class="form-container">
            <form action="" method="POST">
                <p>
                    <label for="action">Enter number money to want Deposit :</label>
                    <input type="text" name="depositmony2" placeholder="0.00"/>
                </p>
                <input type="submit" name="confirm2" value="Confirm"  >
               
            </form>
        </div>
    </center>';
  }

  else if($actionMay==="checkBalance"){

    echo'
    <center>  
        <div class="form-container">
            <p>
                <label for="action"> mony in account : '. $moneydeposit->KnowMoney().'dh </label>
            </p>
         
        </div>
    </center>';
  }

  
  else {
    echo'
    <center>  
        <div class="form-container">
            <p>
                <label for="action"> account number : '. $moneydeposit->KnowAccount().' </label>
            </p>
           
        </div>
    </center>';
  }

}

else{
    echo'
    <center>  
        <div class="form-container">
            <form action="" method="POST">
            <h1> Bank X</h1>
                <p>
                    <label for="action">Select an action:</label>
                    <select name="actionMay" id="action">
                        <option value="takeMoney">Take out money</option>
                        <option value="depositMoney">Deposit money</option>
                        <option value="checkBalance">Know your current balance</option>
                        <option value="KnowAccount">Know your account number</option>
                    </select>
                </p>

                <input type="submit" name="confirm" value="Confirm">
            </form>
        </div>
    </center>';
}

class Phone{
    public static  $name="redmi";
    public static $ram='6g';
    public static function Tostring()
    {
        return 'phone : '.self::$name.' and ram : '.self::$ram;
    }
}
echo Phone :: $name;    
echo Phone :: Tostring();
$f=new Phone();
echo $f->Tostring();

$margone=['margone1','margone2','margone3','margone4'];
$margtwo=['margtwo1','margtwo2','margtwo3','margtwo4'];
print_r(array_merge($margone,))







