<?php

require_once('../../boundary/APIinterface/APIlogin.php');
require_once('../../boundary/DBinterface/DBinterface.php');

$controller = new Authentifier();

class Authentifier
{
    public function __construct()
    {
        $this->DBinterface = new DBinterface();
        $this->APIlogin = new APIlogin($this);
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

        //Check if fields are empty

        if (empty($username) || empty($password) || empty($email)) {
            return array('success' => false, 'message' => 'Veuillez remplir tous les champs.');
        }

        //Check if email is valid

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return array('success' => false, 'message' => 'Adresse e-mail invalide.');
        }

        //Check if user already exists
        $user_query = $this->DBinterface->query("SELECT * FROM joueur WHERE pseudo = :pseudo", array('pseudo' => $username));
        
        $existing_user = $user_query->fetch();
    }
}