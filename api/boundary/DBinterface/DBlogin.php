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