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

        $user = $this->DBinterface->getDB()->prepare("SELECT * FROM user WHERE username = :username AND univers = :univers");

        //Association des paramètres
        $user->bindParam(':username', $username);
        $user->bindParam(':univers', $univers);

        $user->execute();
        
        if(!$user){
            echo "Error while preparing request";
            return false;
        }

        

        $result = $user->fetch(PDO::FETCH_ASSOC);

        if($result && password_verify($password, $result['password'])){
            $_SESSION['username'] = $username;
            $_SESSION['univers'] = $univers;
            $_SESSION['id'] = $result['id'];
            return 0;
        }
        else if($result){
            return 1;
        }
        else{
            return 2;
        }
    }
}