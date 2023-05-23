<?php

require_once('../../boundary/DBinterface/DBlogin.php');
require_once('../../boundary/DBinterface/DBregister.php');

class Authentifier
{
    private $DBinterfaceLogin;
    private $DBinterfaceRegister;
    public function __construct()
    {
        $this->DBinterfaceLogin = new DBlogin();
        $this->DBinterfaceRegister = new DBregister();
    }

    public function login($username, $password, $univers) {
        $hashedPassword = hash("SHA512", $password);
        $result = $this->DBinterfaceLogin->login($username, $hashedPassword);
    
        if (!$result) 
        {
            return 2; // code 2: Wrong username
        }
    
        if ($result[0]['mdp'] === $hashedPassword && $username === $result[0]['pseudo']) 
        {
            return 0;
        } else {
            return 1;
        }
    }

    public function register($username, $password, $mail){

        //Check if email is valid

        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return 3;
        }

        //Check if user already exists
        $user_exist = $this->DBinterfaceRegister->isUser($username);
        
        
        if ($user_exist) {
            return 4;
        }
        
        //Check if email already exists
        $email_exist = $this->DBinterfaceRegister->isEmail($mail);

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
        $password = hash("SHA512" ,$password);

        //Insert user in database
        $result = $this->DBinterfaceRegister->register($username, $password, $mail);

        if ($result) {
            return 0;
        }


    }
    public function getIdJoueur($pseudo){
        $result = $this->DBinterfaceLogin->getIdJoueur($pseudo);
        return $result;
    }


    public function getNumberJoueurUnivers($idUnivers){
        $result = $this->DBinterfaceLogin->getNumberJoueurUnivers($idUnivers);
        return $result;
    }
    
    public function registerUnivers($idJoueur, $idUnivers, $idRessource){
        $result = $this->DBinterfaceRegister->registerUnivers($idJoueur, $idUnivers, $idRessource);
        return $result;
    }

    public function getIdUnivers() {
        $result = $this->DBinterfaceLogin->getIdUnivers();
        
        return $result;
        
    }
    public function registerPlanet($id_joueur, $id_univers){
        return $this->DBinterfaceRegister->registerPlanet($id_joueur, $id_univers);
    }

    public function createRessource(){
        return $this->DBinterfaceRegister->createRessource();
    }
    
    public function getIdRessources(){
        return $this->DBinterfaceRegister->getIdRessources();
    }
}