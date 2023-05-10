<?php

require_once('../../boundary/DBinterface/DBinfrastructures.php');

class Infrastructures
{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBinfrastructures();
    }
    
    public function getInfrastructures($id_Planet)
    {
        return $this->dbInterface->getInfrastructuresByPlanetId($id_Planet);
    }

    public function getDefaultDefense()
    {
        return $this->dbInterface->getDefaultDefense();
    }

    public function getDefaultInstallation()
    {
        return $this->dbInterface->getDefaultInstallation();
    }

    public function getDefaultRessource()
    {
        return $this->dbInterface->getDefaultRessource();
    }

}