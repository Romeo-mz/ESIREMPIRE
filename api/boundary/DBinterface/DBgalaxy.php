<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "root");
define('DB_PWD', "");

class DBgalaxy extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    public function renamePlanet($idPlanet, $newName)
    {
        $this->executeQuery('UPDATE planete SET nom = ? WHERE id = ?', [$newName, $idPlanet]);
    }

    public function getPlanetName($idPlanet)
    {
        return $this->fetchValue('SELECT nom FROM planete WHERE id = ?', [$idPlanet]);
    }

    public function getGalaxiesList($idUnivers)
    {
        return $this->fetchAllRows('SELECT id, nom FROM galaxie WHERE id_univers = ? ORDER BY nom', [$idUnivers]);
    }

    public function getSystemsList($idGalaxy)
    {
        return $this->fetchAllRows('SELECT id, nom FROM systemesolaire WHERE id_Galaxie = ? ORDER BY nom', [$idGalaxy]);
    }

    public function getPlanets($idSolarSystem)
    {
        return $this->fetchAllRows('SELECT p.id, p.nom, p.position, j.pseudo FROM planete p LEFT JOIN joueur j ON p.id_Joueur = j.id WHERE id_Systeme_Solaire = ? ORDER BY p.position', [$idSolarSystem]);
    }

    public function getLowestGalaxies($idUnivers)
    {
        return $this->fetchValue('SELECT MIN(id) FROM galaxie WHERE id_Univers = ?', [$idUnivers]);
    }

    public function getLowestSystems($idGalaxy)
    {
        return $this->fetchValue('SELECT MIN(id) FROM systemesolaire WHERE id_Galaxie = ?', [$idGalaxy]);
    }

}

