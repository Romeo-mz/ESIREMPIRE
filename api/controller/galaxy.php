<?php

require_once('../../boundary/APIinterface/APIgalaxy.php');
require_once('../../boundary/DBinterface/DBgalaxy.php');

$controller = new Galaxy();

class Galaxy
{
    private $dbInterface;
    private $apiInterface;

    public function __construct()
    {
        $this->dbInterface = new DBgalaxy();
        $this->apiInterface = new APIgalaxy($this);
    }

    public function getGalaxies($id_Univers)
    {
        return $this->dbInterface->getGalaxies($id_Univers);
    }

    public function getSystems($id_Galaxy)
    {
        return $this->dbInterface->getSystems($id_Galaxy);
    }

    public function getPlanets($id_SolarSystem)
    {
        return $this->dbInterface->getPlanets($id_SolarSystem);
    }

}