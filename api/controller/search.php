<?php

require_once('../../boundary/DBinterface/DBsearch.php');

class Search
{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBsearch();
    }
    
    public function getLaboratoireID($id_Planet)
    {
        return $this->dbInterface->getLaboratoireID($id_Planet);
    }
    
}