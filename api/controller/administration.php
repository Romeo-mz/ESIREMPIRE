<?php

require_once('../../boundary/DBinterface/DBadmin.php');

define('GALAXIES_PER_UNIVER', 5);
define('SOLAR_SYSTEMS_PER_GALAXY', 10);
/**
 * Class Administration
 * This class is the controller for the administration page.
 * It handles the administration of the game.
 */
class Administration
{
    private $dbInterface;
    /**
     * Administration constructor.
     */
    public function __construct()
    {
        $this->dbInterface = new DBadmin();
    }
    /**
     * This function gets the universes from the database.
     * 
     * @return array the result of the database operation
     */
    public function getUniverses() 
    {
        return $this->dbInterface->getUniverses();
    }
    /**
     * This function gets the last Universe Id from the database.
     * 
     * @return array the result of the database operation
     */
    public function getLastUniverseId() 
    {
        return $this->dbInterface->getLastUniverseId();
    }
    /**
     * This function gets the last 5 galaxies Id from the database.
     * 
     * @return array the result of the database operation
     */
    private function getLast5GalaxiesId() 
    {
        $universeId = $this->getLastUniverseId();
        return $this->dbInterface->getLast5GalaxiesId($universeId);
    }
    /**
     * This function gets the last 50 solar systems Id from the database.
     * 
     * @return array the result of the database operation
     */
    public function getLast50SolarSystemsId() 
    {
        $galaxiesId = $this->getLast5GalaxiesId();
        $placeholders = rtrim(str_repeat('?, ', count($galaxiesId)), ', ');
        return $this->dbInterface->getLast50SolarSystemsId($placeholders, array_column($galaxiesId, 'id'));
    }
    /**
     * This function creates a universe in the database.
     * 
     * @param string $universe_name
     * @return array the result of the database operation
     */
    public function createUniverse($universe_name) 
    {
        return $this->dbInterface->createUniverse($universe_name);
    }
    /**
     * This function creates a galaxy in the database.
     * 
     * @param string $galaxy_name
     * @param int $universe_id
     * @return array the result of the database operation
     */
    public function createGalaxies() 
    {
        $universeId = $this->getLastUniverseId();
        for ($i = 1; $i <= GALAXIES_PER_UNIVER; $i++) {
            $name = "G" . $i;
            $result = $this->dbInterface->createGalaxy($name, $universeId);
        }
        return $result;
    }

    /**
     * Creates a batch of planets in the last 50 solar systems in the database.
     *
     * @throws Some_Exception_Class when there is an error creating a planet.
     * @return array the result of creating the planets.
     */
    public function createSolarSystems() 
    {
        foreach ($this->getLast5GalaxiesId() as $GalaxyId) {
            for ($i = 1; $i <= SOLAR_SYSTEMS_PER_GALAXY; $i++) {
                $name = "SS" . $i;
                $result = $this->dbInterface->createSolarSystem($name, $GalaxyId['id']);
            }
        }
        return $result;
    }

    /**
     * Creates a set of planets and stores them in the database.
     *
     * @return array the result of the database operation
     */
    public function createPlanets()
    {
        $solarSystemIds = $this->getLast50SolarSystemsId();
        $result = array();

        foreach ($solarSystemIds as $solarSystem) {
            $nbPlanets = rand(4, 10);
            $positions = range(1, 10);
            shuffle($positions);
            $tailleValues = array(90, 100, 110, 120, 130, 130, 120, 110, 100, 90);
            $tailleKeys = array(10, 9, 8, 7, 6, 5, 4, 3, 2, 1);
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