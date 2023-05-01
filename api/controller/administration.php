<?php

require_once('../../boundary/APIinterface/APIadmin.php');
require_once('../../boundary/DBinterface/DBinterface.php');

$controller = new Authentifier();

class Authentifier
{
    public function __construct()
    {
        $this->DBinterface = new DBinterface();
        $this->APIadmin = new APIadmin($this);
    }

    public function getLastUniverseId() {
        $query = "SELECT MAX(id) FROM univers";
        $result = $this->DBinterface->getLastUniverseId($query);
        return $result; 
    }

    public function createUniverse($universe_name) {
        $query = "INSERT INTO univers (nom) VALUES ('" . $universe_name . "')";
        $result = $this->DBinterface->createUniverse($query);
        return $result; 
    }

}