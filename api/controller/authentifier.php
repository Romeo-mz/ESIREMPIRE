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
            $session = [
                'success' => false,
                'message' => 'Username incorrect'
            ];
            return $session;
        }
        if ($result[0]['mdp'] === $hashedPassword && $username === $result[0]['pseudo']) 
        {
            $number = $this->DBinterfaceLogin->checkIfPlayerHavePlanet($univers, $result[0]['id']);

            if ($number == 0) {
                $this->DBinterfaceLogin->addPlanetToPlayer($univers, $result[0]['id']);
                $resourcesId = $this->DBinterfaceLogin->addRessourcesToPlayer($univers, $result[0]['id']);
                $this->DBinterfaceLogin->linkJoueurUnivers($univers, $result[0]['id'], $resourcesId);
            }

            $idRessources = $this->DBinterfaceLogin->getIdRessources($univers, $result[0]['id']);
            $idPlanets = $this->DBinterfaceLogin->getIdPlanets($univers, $result[0]['id']);

            $session = [
                'success' => true,
                'id_Player' => $result[0]['id'],
                'pseudo' => $result[0]['pseudo'],
                'id_Univers' => $univers,
                'id_Ressources' => $idRessources,
                'id_Planetes' => $idPlanets,
            ];

            return $session;

        } else {
            $session = [
                'success' => false,
                'message' => 'Password incorrect'
            ];

            return $session;
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