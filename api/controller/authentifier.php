<?php

require_once('../../boundary/DBinterface/DBinterface.php');

class Authentifier
{
    private $DBinterface;
    public function __construct()
    {
        $this->DBinterface = new DBinterface();
    }

    public function login($username, $password){

        $query = "SELECT * FROM joueur WHERE pseudo = :pseudo";
        
        $result = $this->DBinterface->login($query, $username);
        
        if(!$result){
            //echo "Error while preparing request";
            return 2; // code 2 : Wrong username
        }

        if($result['mdp'] == $password && $username == $result['pseudo']){
            $_SESSION['id'] = $result['id'];
            $_SESSION['username'] = $result['pseudo'];
            // $_SESSION['univers'] = $result['univers'];
            return 0;
        }
        else if($result){
            return 1;
        }
        else{
            return 2;
        }
    }

    public function register($username, $password, $mail){

        //Check if email is valid

        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return 3;
        }

        //Check if user already exists
        $query_user_exist = "SELECT * FROM joueur WHERE pseudo = :pseudo";
        $user_exist = $this->DBinterface->login($query_user_exist, $username);
        
        
        if ($user_exist) {
            return 4;
        }
        
        //Check if email already exists
        $query_email_exist = "SELECT * FROM joueur WHERE mail = :mail";
        $email_exist = $this->DBinterface->isEmail($query_email_exist, $mail);

        if ($email_exist) {
            return 5;
        }

        //Check if password is valid
        if (strlen($password) < 8) {
            return 1;
        }

        //Check if username is valid
        if (strlen($username) < 4) {
            return 2;
        }

        //Insert user in database
        $query = "INSERT INTO joueur (pseudo, email , mdp ) VALUES (:pseudo, :email, :mdp)";
        $result = $this->DBinterface->register($query, $username, $password, $mail);

        if ($result) {
            return 0;
        }


    }
    public function getIdJoueur($pseudo){
        $query = "SELECT id FROM joueur WHERE pseudo = :pseudo";
        $result = $this->DBinterface->getIdJoueur($query, $pseudo);
        return $result;
    }


    public function getNumberJoueurUnivers($idUnivers){
        $query = "SELECT COUNT(*) FROM joueurunivers WHERE id_Univers = :id_Univers";
        $result = $this->DBinterface->getNumberJoueurUnivers($query, $idUnivers);
        return $result;
    }
    
    public function registerUnivers($idJoueur, $idUnivers, $idRessource){
        $query = "INSERT INTO joueurunivers (id_Joueur, id_Univers, id_Ressource) VALUES (:idJoueur, :idUnivers, :idRessource)";
        $result = $this->DBinterface->registerUnivers($query, $idJoueur, $idUnivers, $idRessource);
        return $result;
    }

    public function getIdUnivers() {
        $result = $this->DBinterface->getIdUnivers();
        
        return $result;
        
    }
    
    public function getAllUnivers() {
        $query = "SELECT * FROM univers";
        $result = $this->DBinterface->getAllUnivers($query);
        
        return $result;
    }

    public function getIdTypeRessource($type){
        $query = "SELECT id FROM typeressource WHERE id_Type = :type AND quantite = 500";
        $result = $this->DBinterface->getDb()->prepare($query);
        $result->bindParam(':type', $type);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    
    public function registerRessource($id_joueur, $id_ressource, $quantite){

        $result = $this->DBinterface->registerQuantiteRessource($id_ressource, $quantite);
        print_r($this->getIdUnivers());
        $query2 = "INSERT INTO joueurunivers (id_joueur, id_univers, id_ressource) VALUES (:id_joueur, :id_univers, :id_ressource)";
        $params2 = array(':id_joueur' => $id_joueur, ':id_univers' => $this->getIdUnivers()[0]['id'], ':id_ressource' => $id_ressource);
        $this->DBinterface->getDb()->prepare($query2)->execute($params2);
    }

    public function lienRessourcesJoueur($id_joueur, $id_univers, $id_ressource) {
        $query = "UPDATE joueurunivers SET id_ressource = :id_ressource WHERE id_joueur = :id_joueur AND id_univers = :id_univers";
        $params = array(':id_joueur' => $id_joueur, ':id_univers' => $id_univers, ':id_ressource' => $id_ressource);
        $stmt = $this->DBinterface->getDb()->prepare($query);
        $result = $stmt->execute($params);
        return $result;
    }
    
}