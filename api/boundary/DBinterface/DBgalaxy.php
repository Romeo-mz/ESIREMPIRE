<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "root");
define('DB_PWD', "");

class DBgalaxy extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    public function getGalaxies($idUnivers)
    {
        return $this->fetchAllRows('SELECT id, nom FROM galaxie WHERE id_univers = ? ORDER BY nom', [$idUnivers]);
    }

    public function getSystems($idGalaxy)
    {
        return $this->fetchAllRows('SELECT id, nom FROM systemesolaire WHERE id_Galaxie = ? ORDER BY nom', [$idGalaxy]);
    }

    public function getPlanets($idSolarSystem)
    {
        // get id, name and position and pseudo of player of planets
        return $this->fetchAllRows('SELECT p.id, p.nom, p.position, j.pseudo FROM planete p LEFT JOIN joueur j ON p.id_Joueur = j.id WHERE id_Systeme_Solaire = ? ORDER BY p.position', [$idSolarSystem]);
    }

}

