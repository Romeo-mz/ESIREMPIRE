<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "api_galaxy");
define('DB_PWD', "@]UXDXmAc796NQdf");

class DBgalaxy extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
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

}

