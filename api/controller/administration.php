<?php

require_once('../../boundary/APIinterface/APIadmin.php');
require_once('../../boundary/DBinterface/DBadmin.php');

$controller = new Administration(new DBadmin(), new APIadmin());

class Administration
{
    private $dbInterface;
    private $apiInterface;

    public function __construct(DBadmin $dbInterface, APIadmin $apiInterface)
    {
        $this->dbInterface = $dbInterface;
        $this->apiInterface = $apiInterface;
    }

    public function getUniverses() 
    {
        return $this->dbInterface->getUniverses();
    }

    public function getLastUniverseId() 
    {
        return $this->dbInterface->getLastUniverseId();
    }

    private function getLast5GalaxiesId() 
    {
        return $this->dbInterface->getLast5GalaxiesId();
    }

    public function getLast50SolarSystemsId() 
    {
        return $this->dbInterface->getLast50SolarSystemsId();
    }

    public function createUniverse($universe_name) 
    {
        return $this->dbInterface->createUniverse($universe_name);
    }

    public function createGalaxies() 
    {
        $universeId = $this->getLastUniverseId();
        for ($i = 1; $i <= 5; $i++) {
            $name = "G" . $i;
            $result = $this->dbInterface->createGalaxy($name, $universeId);
        }
        return $result;
    }

    
    public function createSolarSystems() 
    {
        foreach ($this->getLast5GalaxiesId() as $GalaxyId) {
            for ($i = 1; $i <= 10; $i++) {
                $name = "SS" . $i;
                $result = $this->dbInterface->createSolarSystem($name, $GalaxyId['id']);
            }
        }
        return $result;
    }

    public function createPlanets()
    {
        $solarSystemIds = $this->getLast50SolarSystemsId();
        $result = array();

        foreach ($solarSystemIds as $solarSystem) {
            $nbPlanets = rand(4, 10);
            $positions = range(1, 10);
            shuffle($positions);
            $tailleValues = array(130, 120, 110, 100, 90);
            $tailleKeys = array(5, 4, 3, 2, 1);
            $tailleMap = array_combine($tailleKeys, $tailleValues);

            for ($i = 0; $i < $nbPlanets; $i++) {
                
                $name = "P" . $positions[$i];
                $position = $positions[$i];
                $taille = $tailleMap[$positions[$i]];
                $id_Bonus_Ressources = $positions[$i];
                $id_Systeme_Solaire = $solarSystem['id'];

                $result[] = $this->dbInterface->createPlanet($name, $position, $taille, $id_Bonus_Ressources, $id_Systeme_Solaire);
            }
        }

        return $result;
    }

}