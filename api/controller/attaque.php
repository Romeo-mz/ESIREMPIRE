<?php

require_once('../../boundary/DBinterface/DBattaque.php');

class Attaque{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBattaque();
    }

    

}
?>