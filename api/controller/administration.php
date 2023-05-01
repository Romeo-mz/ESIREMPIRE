<?php

require_once('../../boundary/APIinterface/APIadmin.php');
require_once('../../boundary/DBinterface/DBinterface.php');

$controller = new Administration();

class Administration
{
    public function __construct()
    {
        $this->DBinterface = new DBinterface();
        $this->APIadmin = new APIadmin($this);
    }

    public function getUniverses() {
        $query = "SELECT * FROM univers";
        $result = $this->DBinterface->getUniverses($query);
        return $result;
    }

    public function getLastUniverseId() {
        $query = "SELECT MAX(id) FROM univers";
        $result = $this->DBinterface->getLastUniverseId($query);
        return $result; 
    }

    private function getLast5GalaxiesId() {
        // Get laste 5 galaxies id where id_Univers = this->getLastUniverseId()
        $query = "SELECT id FROM galaxie WHERE id_Univers = " . $this->getLastUniverseId() . " ORDER BY id DESC LIMIT 5";
        $result = $this->DBinterface->getLast5GalaxiesId($query);
        return $result;
    }

    private function getLast50SolarSystemsId() {
        // Get last 50 solar systems id where id_Galaxie = this->getLast5GalaxiesId()
        $query = "SELECT id FROM systemesolaire WHERE id_Galaxie IN (";
        $GalaxiesId = $this->getLast5GalaxiesId();
        foreach ($GalaxiesId as $GalaxyId) {
            $query .= $GalaxyId['id'] . ", ";
        }
        $query = substr($query, 0, -2);
        $query .= ") ORDER BY id DESC LIMIT 50";
        $result = $this->DBinterface->getLast50SolarSystemsId($query);
        return $result;
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