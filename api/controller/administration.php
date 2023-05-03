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
        return $this->DBinterface->getUniverses();
    }

    public function getLastUniverseId() 
    {
        return $this->DBinterface->getLastUniverseId();
    }

    private function getLast5GalaxiesId() 
    {
        return $this->DBinterface->getLast5GalaxiesId();
    }

    public function getLast50SolarSystemsId() 
    {
        return $this->DBinterface->getLast50SolarSystemsId();
    }

    public function createUniverse($universe_name) {
        $query = "INSERT INTO univers (nom) VALUES ('" . $universe_name . "')";
        $result = $this->DBinterface->createUniverse($query);
        return $result; 
    }

    public function createGalaxies() {
        for ($i = 1; $i <= 5; $i++) {
            $query = "INSERT INTO galaxie (nom, id_Univers) VALUES ('G" . $i . "', " . $this->getLastUniverseId() . ")";
            $result = $this->DBinterface->createGalaxy($query);
        }
        return $result;
    }

    // Create 10 solar systems for each galaxy
    public function createSolarSystems() {
        foreach ($this->getLast5GalaxiesId() as $GalaxyId) {
            for ($i = 1; $i <= 10; $i++) {
                $query = "INSERT INTO systemesolaire (nom, id_Galaxie) VALUES ('SS" . $i . "', " . $GalaxyId['id'] . ")";
                $result = $this->DBinterface->createSolarSystem($query);
            }
        }
        return $result;
    }

    // Create randomly between 4 and 10 Planets for each Solar System
    public function createPlanets() {
        foreach ($this->getLast50SolarSystemsId() as $SolarSystemId) {

            $nbPlanets = rand(4, 10);
            $positions = array();

            for ($i = 0; $i < $nbPlanets; $i++) {
                $random = rand(1, 10);
                while (in_array($random, $positions)) {
                    $random = rand(1, 10);
                }
                array_push($positions, $random);
            }

            for ($i = 1; $i <= $nbPlanets; $i++) {
                $id_Bonus_Ressources = $positions[$i - 1];

                if ($positions[$i - 1] == 1 || $positions[$i - 1] == 10) {
                    $taille = 90;
                } else if ($positions[$i - 1] == 2 || $positions[$i - 1] == 9) {
                    $taille = 100;
                } else if ($positions[$i - 1] == 3 || $positions[$i - 1] == 8) {
                    $taille = 110;
                } else if ($positions[$i - 1] == 4 || $positions[$i - 1] == 7) {
                    $taille = 120;
                } else if ($positions[$i - 1] == 5 || $positions[$i - 1] == 6) {
                    $taille = 130;
                }

                $query = "INSERT INTO planete (nom, position, taille, id_Bonus_Ressources, id_Systeme_Solaire) VALUES ('P" . $positions[$i - 1] . "', " . $positions[$i - 1] . ", " . $taille . ", " . $id_Bonus_Ressources . "," . $SolarSystemId['id'] . ")";
                $result = $this->DBinterface->createPlanet($query);
            }
        }
        return $result;
    }

}