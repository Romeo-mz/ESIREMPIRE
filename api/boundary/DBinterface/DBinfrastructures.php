<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "api_infrastructures");
define('DB_PWD', "kqV3qbr/AX)r9VI1");

class DBgalaxy extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }



}

