<?php

require_once('DBinterface.php');

define('DB_LOGIN', "root");
define('DB_PWD', "");
class DBvaisseau extends DBinterface {
    
    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    
}