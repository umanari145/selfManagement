<?php
require_once("../config.php");
require_once( CLASS_FILENAME );

$objSetPostCode = new setPostCode();
$objSetPostCode->main();

class setPostCode
{
    public $objDb        = NULL;
    public $objFormParam = NULL;

    public function __construct()
    {
        $this->objDb        = new PDODatabase( DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_TYPE); 
        $this->objFormParam = new formParam();

    }

    public function main()
    {
        $this->initParam();
        $this->getPostCode();

    }

    public function getPostCode()
    {
        $zip1=$this->objFormParam->getValue('zip1');
        $zip2=$this->objFormParam->getValue('zip2');
        $zipArr = $this->objDb->select('mtb_zip', 'state,city,town','zipcode = ? ', array( $zip1.$zip2) );
       echo ( $zipArr !=='' && $zipArr !== false && $zipArr !== array() ) ?$zipArr[0]['state'].$zipArr[0]['city'].$zipArr[0]['town']:false;
    }

    public function initParam()
    {
        $this->objFormParam->addParam('郵便番号1','zip1');
        $this->objFormParam->addParam('郵便番号2','zip2');
        $this->objFormParam->setParam( $_POST );
    }

}

?>
