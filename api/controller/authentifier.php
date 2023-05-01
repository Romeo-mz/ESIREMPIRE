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

    public function login($username, $password, $univers){
        
        $user = $this->DBinterface->getDB()->prepare("SELECT * FROM joueur WHERE pseudo = 'test'");

        //Association des paramètres
        // $user->bindParam(':pseudo', $username);
        // $user->bindParam(':univers', $univers);

        $user->execute();
        $result = $user->fetch(PDO::FETCH_ASSOC);
        
        return $result;
        
        // if(!$user){
        //     echo "Error while preparing request";
        //     return false;
        // }

        // if($result && password_verify($password, $result['password'])){
        //     $_SESSION['username'] = $username;
        //     $_SESSION['univers'] = $univers;
        //     $_SESSION['id'] = $result['id'];
        //     return 0;
        // }
        // else if($result){
        //     return 1;
        // }
        // else{
        //     return 2;
        // }
    }
}