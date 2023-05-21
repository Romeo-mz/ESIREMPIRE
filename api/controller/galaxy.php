<?php

require_once('../../boundary/DBinterface/DBgalaxy.php');


class Galaxy
{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBgalaxy();
    }

    public function getGalaxiesList($id_Univers)
    {
        return $this->dbInterface->getGalaxiesList($id_Univers);
    }

    public function getSystemsList($id_Galaxy)
    {
        return $this->dbInterface->getSystemsList($id_Galaxy);
    }

    public function getPlanets($id_SolarSystem)
    {
        return $this->dbInterface->getPlanets($id_SolarSystem);
    }

}