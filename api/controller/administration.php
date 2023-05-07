<?php

require_once('../../boundary/DBinterface/DBadmin.php');

class Administration
{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBadmin();
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
        $universeId = $this->getLastUniverseId();
        return $this->dbInterface->getLast5GalaxiesId($universeId);
    }

    public function getLast50SolarSystemsId() 
    {
        $galaxiesId = $this->getLast5GalaxiesId();
        $placeholders = rtrim(str_repeat('?, ', count($galaxiesId)), ', ');
        return $this->dbInterface->getLast50SolarSystemsId($placeholders, array_column($galaxiesId, 'id'));
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
                if (!isset($positions[$i])) {
                    continue;
                }
                
                $name = "P" . $positions[$i];
                $position = $positions[$i];
                $taille = isset($tailleMap[$positions[$i]]) ? $tailleMap[$positions[$i]] : 0;
                $id_Bonus_Ressources = $positions[$i];
                $id_Systeme_Solaire = $solarSystem['id'];

                $result = $this->dbInterface->createPlanet($name, $position, $taille, $id_Bonus_Ressources, $id_Systeme_Solaire);
            }
        }

        return $result;
    }

}