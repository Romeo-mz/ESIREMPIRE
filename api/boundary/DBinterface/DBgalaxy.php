<?php

require_once 'DBinterface.php';

//Compte Interface API
// define('DB_LOGIN', "api_admin");
// define('DB_PWD', "!1vAOK/CSd6H6WeO");
define('DB_LOGIN', "root");
define('DB_PWD', "");

/**
 * DBgalaxy class
 * @package api\boundary\DBinterface
 */

class DBgalaxy extends DBinterface {
    /**
     * DBgalaxy constructor.
     */
    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }
    /**
     * renamePlanet
     * function that rename a planet
     * @param int $idPlanet
     * @param string $newName
     * @return void
     * 
     */
    public function renamePlanet($idPlanet, $newName)
    {
        $this->executeQuery('UPDATE planete SET nom = ? WHERE id = ?', [$newName, $idPlanet]);
    }
    /**
     * getPlanetName
     * function that return the name of a planet
     * @param int $idPlanet
     * @return string
     */
    public function getPlanetName($idPlanet)
    {
        return $this->fetchValue('SELECT nom FROM planete WHERE id = ?', [$idPlanet]);
    }
    /**
     * getGalaxiesList
     * function that return the list of galaxies
     * @param int $idUnivers
     * @return array
     */
    public function getGalaxiesList($idUnivers)
    {
        return $this->fetchAllRows('SELECT id, nom FROM galaxie WHERE id_univers = ? ORDER BY nom', [$idUnivers]);
    }
    /**
     * getSystemsList
     * function that return the list of solar systems
     * @param int $idGalaxy
     * @return array
     */
    public function getSystemsList($idGalaxy)
    {
        return $this->fetchAllRows('SELECT id, nom FROM systemesolaire WHERE id_Galaxie = ? ORDER BY nom', [$idGalaxy]);
    }
    /**
     * getPlanets
     * function that return the list of planets
     * @param int $idSolarSystem
     * @return array
     */
    public function getPlanets($idSolarSystem)
    {
        return $this->fetchAllRows('SELECT p.id, p.nom, p.position, j.pseudo FROM planete p LEFT JOIN joueur j ON p.id_Joueur = j.id WHERE id_Systeme_Solaire = ? ORDER BY p.position', [$idSolarSystem]);
    }
    /**
     * getLowestGalaxies
     * function that return the galaxy with the lowest id
     * @param int $idUnivers
     * @return int
     */
    public function getLowestGalaxies($idUnivers)
    {
        return $this->fetchValue('SELECT MIN(id) FROM galaxie WHERE id_Univers = ?', [$idUnivers]);
    }
    /**
     * getLowestSystems
     * function that return the solar system with the lowest id
     * @param int $idGalaxy
     * @return int
     */
    public function getLowestSystems($idGalaxy)
    {
        return $this->fetchValue('SELECT MIN(id) FROM systemesolaire WHERE id_Galaxie = ?', [$idGalaxy]);
    }

}

