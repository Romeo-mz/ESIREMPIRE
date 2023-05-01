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

    public function getLastUniverseId() {
        $query = "SELECT MAX(id) FROM univers";
        $result = $this->DBinterface->getLastUniverseId($query);
        return $result; 
    }

    public function getLast5GalaxiesId() {
        // Get laste 5 galaxies id where id_Univers = this->getLastUniverseId()
        $query = "SELECT id FROM galaxie WHERE id_Univers = " . $this->getLastUniverseId() . " ORDER BY id DESC LIMIT 5";
        $result = $this->DBinterface->getLast5GalaxiesId($query);
        return $result;
    }

    public function createUniverse($universe_name) {
        $query = "INSERT INTO univers (nom) VALUES ('" . $universe_name . "')";
        $result = $this->DBinterface->createUniverse($query);
        return $result; 
    }

    // getLast50SolarSystemsId
    public function getLast50SolarSystemsId() {
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

    // Create 5 galaxies for the universe
    public function createGalaxies($UniverseId) {
        for ($i = 1; $i <= 5; $i++) {
            $query = "INSERT INTO galaxie (nom, id_Univers) VALUES ('G" . $i . "', " . $UniverseId . ")";
            $result = $this->DBinterface->createGalaxy($query);
        }
        return $result;
    }

    // Create 10 solar systems for each galaxy
    public function createSolarSystems($GalaxiesId) {
        foreach ($GalaxiesId as $GalaxyId) {
            $nbSolarSystems = rand(4, 10);
            for ($i = 1; $i <= $nbSolarSystems; $i++) {
                $query = "INSERT INTO systemesolaire (nom, id_Galaxie) VALUES ('SS" . $i . "', " . $GalaxyId['id'] . ")";
                $result = $this->DBinterface->createSolarSystem($query);
            }
        }
        return $result;
    }

    // Create randomly between 4 and 10 Planets for each Solar System
    public function createPlanets($SolarSystemsId) {
        foreach ($SolarSystemsId as $SolarSystemId) {
            $nbPlanets = rand(4, 10);
            for ($i = 1; $i <= $nbPlanets; $i++) {
                $query = "INSERT INTO planete (nom, id_Systeme_Solaire) VALUES ('P" . $i . "', " . $SolarSystemId['id'] . ")";
                $result = $this->DBinterface->createPlanet($query);
            }
        }
        return $result;
    }

}