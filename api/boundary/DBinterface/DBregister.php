<?php

require_once 'DBinterface.php';

//Compte Interface API
// define('DB_LOGIN', "root");
// define('DB_PWD', "");

class DBregister extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    public function register($username, $password, $mail ){
        return $this->fetchAllRows('INSERT INTO joueur (pseudo, mdp, email) VALUES (?, ?, ?)', [$username, $password, $mail]);
    }

    public function isUser($username){
        return $this->fetchAllRows('SELECT * FROM joueur WHERE pseudo = ?', [$username]);
    }

    public function isEmail($mail){
        return $this->fetchAllRows('SELECT * FROM joueur WHERE email = ?', [$mail]);
    }

    public function registerJoueur($username, $password, $mail){
        return $this->executeQuery('INSERT INTO joueur (pseudo, mdp, email) VALUES (?, ?, ?)', [$username, $password, $mail]);
    }

    public function registerUnivers($idJoueur, $idUnivers, $idRessource ){
        return $this->executeQuery('INSERT INTO joueurunivers (id_Joueur, id_Univers, id_Ressource) VALUES (?, ?, ?)', [$idJoueur, $idUnivers, $idRessource]);
    }

    public function registerPlanet($id_joueur, $id_univers){
        $query = "UPDATE planete SET id_joueur = ? 
                  WHERE id_joueur IS NULL 
                  AND id_Systeme_Solaire IN 
                      (SELECT id FROM systemesolaire 
                       WHERE id_Galaxie IN 
                           (SELECT id FROM galaxie 
                            WHERE id_Univers = ?))
                  LIMIT 1";
        return $this->executeQuery($query, [$id_joueur, $id_univers]);
    }

    public function createRessource(){
        $typeRessources = array(1, 2, 3);

        foreach ($typeRessources as $typeRessource) {
            $query = "INSERT INTO ressource (id_Type, quantite) VALUES (?, ?)";
            $this->executeQuery($query, [$typeRessource, 500]);
        }
    }

    public function getIdRessources(){
        $query = "SELECT id FROM ressource WHERE id_type IN (1,2,3) ORDER BY id ASC"    ;
        return $this->fetchAllRows($query);
    }
}