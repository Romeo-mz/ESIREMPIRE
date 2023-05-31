<?php

require_once 'DBinterface.php';

//Compte Interface API
// define('DB_LOGIN', "root");
// define('DB_PWD', "");

/**
 * DBregister class
 * @package api\boundary\DBinterface
 *
 */
class DBregister extends DBinterface {
    /**
     * DBregister constructor.
     */
    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }
    /**
     * function register
     * function that register a new user
     * @param $username
     * @param $password
     * @param $mail
     * @return array
     */
    public function register($username, $password, $mail ){
        return $this->fetchAllRows('INSERT INTO joueur (pseudo, mdp, email) VALUES (?, ?, ?)', [$username, $password, $mail]);
    }
    /**
     * function isUser
     * function that check if the user exist
     * @param $username
     * @return array
     */
    public function isUser($username){
        return $this->fetchAllRows('SELECT * FROM joueur WHERE pseudo = ?', [$username]);
    }
    /**
     * function isEmail
     * function that check if the email exist
     * @param $mail
     * @return array
     */
    public function isEmail($mail){
        return $this->fetchAllRows('SELECT * FROM joueur WHERE email = ?', [$mail]);
    }
    /**
     * function registerJoueur
     * function that register a new user
     * @param $username
     * @param $password
     * @param $mail
     * @return array
     */
    public function registerJoueur($username, $password, $mail){
        return $this->executeQuery('INSERT INTO joueur (pseudo, mdp, email) VALUES (?, ?, ?)', [$username, $password, $mail]);
    }
    /**
     * function registerUnivers
     * function that register a new user
     * @param $idJoueur
     * @param $idUnivers
     * @param $idRessource
     * @return array
     */
    public function registerUnivers($idJoueur, $idUnivers, $idRessource ){
        return $this->executeQuery('INSERT INTO joueurunivers (id_Joueur, id_Univers, id_Ressource) VALUES (?, ?, ?)', [$idJoueur, $idUnivers, $idRessource]);
    }
    /**
     * function registerPlanet
     * function that add a planet to a user
     * 
     * @param $id_joueur
     * @param $id_univers
     * 
     * @return array
     */
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
    /**
     * function createRessource
     * function that create ressources for a new user
     * 
     * @return array
     */
    public function createRessource(){
        $typeRessources = array(1, 2, 3);

        foreach ($typeRessources as $typeRessource) {
            $query = "INSERT INTO ressource (id_Type, quantite) VALUES (?, ?)";
            $this->executeQuery($query, [$typeRessource, 500]);
        }
    }
    /**
     * function getIdRessources
     * function that get the id of the ressources
     * 
     * @return array
     */
    public function getIdRessources(){
        $query = "SELECT id FROM ressource WHERE id_type IN (1,2,3) ORDER BY id ASC"    ;
        return $this->fetchAllRows($query);
    }
}