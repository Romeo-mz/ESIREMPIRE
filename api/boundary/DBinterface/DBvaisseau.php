<?php

require_once('DBinterface.php');

class DBvaisseau extends DBinterface {
    
    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

          
}