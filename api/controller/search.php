<?php

require_once('../../boundary/DBinterface/DBsearch.php');

class Search
{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBsearch();
    }
    
    
}