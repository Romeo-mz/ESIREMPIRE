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

    public function getIdUnivers(){
        $query = "SELECT id_Univers FROM joueurunivers WHERE nbJoueur > 0";
        $result = $this->DBinterface->getIdUniversNonVide($query);
        return $result;
    }
    public function registerUnivers($query, $idJoueur){
        $query = "INSERT INTO joueurunivers (idJoueur, idUnivers) VALUES (:idJoueur, :idUnivers)";
        $result = $this->DBinterface->registerUnivers($query, $idJoueur);
    }

}