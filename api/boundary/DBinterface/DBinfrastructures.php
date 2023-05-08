<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "api_infrastructures");
define('DB_PWD', "kqV3qbr/AX)r9VI1");

class DBinfrastructures extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    public function getInfrastructures($id_Planet)
    {
        return $this->fetchAllRows('SELECT id, nom, niveau FROM infrastructure WHERE id_Planete = ? ORDER BY nom', [$id_Planet]);
    }

}

