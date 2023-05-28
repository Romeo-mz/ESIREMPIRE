<?php
require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "api_admin");
define('DB_PWD', "lDMH6chWNK3um6fF");

class DBlogin extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    public function getIdRessources($idCurrentUnivers, $idJoueur)
    {
        return $this->fetchAllRows("SELECT id_Ressource AS id FROM joueurunivers WHERE id_Univers = ? AND id_Joueur = ?", [$idCurrentUnivers, $idJoueur]);
    }

    public function getIdPlanets($idCurrentUnivers, $idJoueur)
    {
        return $this->fetchAllRows("
            SELECT planete.id
            FROM planete
            INNER JOIN systemesolaire ON planete.id_Systeme_Solaire = systemesolaire.id
            INNER JOIN galaxie ON systemesolaire.id_Galaxie = galaxie.id
            INNER JOIN univers ON galaxie.id_Univers = univers.id
            WHERE planete.id_Joueur = ?
            AND univers.id = ?;", [$idJoueur, $idCurrentUnivers]);
    }

    public function checkIfPlayerHavePlanet($idCurrentUnivers, $idJoueur)
    {
        // Check if player have at least one planet on this universe
        return $this->fetchValue("
            SELECT COUNT(*) AS nb
            FROM planete
            INNER JOIN systemesolaire ON planete.id_Systeme_Solaire = systemesolaire.id
            INNER JOIN galaxie ON systemesolaire.id_Galaxie = galaxie.id
            INNER JOIN univers ON galaxie.id_Univers = univers.id
            WHERE planete.id_Joueur = ?
            AND univers.id = ?;", [$idJoueur, $idCurrentUnivers]);
    }

    public function linkJoueurUnivers($idCurrentUnivers, $idJoueur, $idRessources)
    {
        for($i = 0; $i < 3; $i++)
        {
            $this->executeQuery("INSERT INTO joueurunivers (id_Univers, id_Joueur, id_Ressource) VALUES (?, ?, ?);", [$idCurrentUnivers, $idJoueur, $idRessources[$i]]);
        }
    }

    public function addRessourcesToPlayer($idCurrentUnivers, $idJoueur)
    {
        // Get the last id
        $last_id = $this->executeQuery("SELECT id FROM ressource ORDER BY id DESC LIMIT 1;");

        $this->executeQuery("INSERT INTO ressource (id, id_Type) VALUES ($last_id+1,  1);");
        $this->executeQuery("INSERT INTO ressource (id, id_Type) VALUES ($last_id+2,  2);");
        $this->executeQuery("INSERT INTO ressource (id, id_Type) VALUES ($last_id+3,  3);");

        return array($last_id+1, $last_id+2, $last_id+3);
    }

    public function addPlanetToPlayer($idCurrentUnivers, $idJoueur)
    {
        // Fetch a random planet's ID
        $planet_id = $this->fetchValue("
            SELECT planete.id FROM planete
            WHERE id_joueur IS NULL
            AND id_Systeme_Solaire IN
                (SELECT id FROM systemesolaire
                WHERE id_Galaxie IN
                    (SELECT id FROM galaxie
                    WHERE id_Univers = ?))
            ORDER BY RAND()
            LIMIT 1", [$idCurrentUnivers]);

        return $this->executeQuery("
            UPDATE planete SET id_joueur = ?
            WHERE id = ?", [$idJoueur, $planet_id]);
    }


    public function login($username, $password){
        return $this->fetchAllRows("SELECT * FROM joueur WHERE pseudo = ? AND mdp = ?", [$username, $password]);
    }

    public function isEmail($mail){
        $query = "SELECT * FROM joueur WHERE email = ?";
        return $this->fetchAllRows($query, [$mail]);
    }

    public function getIdJoueur($pseudo){
        $query = "SELECT id FROM joueur WHERE pseudo = ?";
        return $this->fetchValue($query, [$pseudo]);
    }

    public function getNumberJoueurUnivers($idUnivers){
        $query = "SELECT COUNT(*) FROM joueurunivers WHERE id_Univers = ?";
        return $this->fetchValue($query, [$idUnivers]);
    }

    public function getIdUnivers(){
        $query = "SELECT id FROM univers ORDER BY id ASC LIMIT 1";
        return $this->fetchValue($query);
    }

}