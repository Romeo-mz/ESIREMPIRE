<?php

require_once('../../boundary/DBinterface/DBgalaxy.php');


class Galaxy
{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBgalaxy();
    }

    public function getPlanetName($id_planet)
    {
        return $this->dbInterface->getPlanetName($id_planet);
    }

    public function renamePlanet($idPlanet, $newName)
    {
        $this->dbInterface->renamePlanet($idPlanet, $newName);
    }

    public function getGalaxiesList($id_Univers)
    {
        return $this->dbInterface->getGalaxiesList($id_Univers);
    }

    public function getSystemsList($id_Galaxy)
    {
        return $this->dbInterface->getSystemsList($id_Galaxy);
    }

    public function getPlanets($id_Univers, $id_Galaxy, $id_SolarSystem)
    {

        if ($id_Galaxy == 0) // get the lowest id where id_Univers = $id_Univers
            $id_Galaxy = $this->dbInterface->getLowestGalaxies($id_Univers);
        if ($id_SolarSystem == 0) // get the lowest id where id_Galaxy = $id_Galaxy
            $id_SolarSystem = $this->dbInterface->getLowestSystems($id_Galaxy);

        $galaxies = $this->dbInterface->getGalaxiesList($id_Univers);
        $sys_sols = $this->dbInterface->getSystemsList($id_Galaxy);
        $planets = $this->dbInterface->getPlanets($id_SolarSystem);

        $response = array(
            'galaxies' => $galaxies,
            'sys_sols' => $sys_sols,
            'planets' => $planets
        );

        return $response;
    }

}