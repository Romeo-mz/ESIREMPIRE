<?php
require_once 'DBinterface.php';

//Compte Interface API
// define('DB_LOGIN', "api_admin");
// define('DB_PWD', "lDMH6chWNK3um6fF");

class DBlogin extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    public function login($username, $password){
        $query = "SELECT * FROM joueur WHERE pseudo = ? AND mdp = ?";
        return $this->fetchAllRows($query, [$username, $password]);
    }

    public function isEmail($mail){
        $query = "SELECT * FROM joueur WHERE mail = ?";
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
        return $this->fetchAllRows($query);
    }

}