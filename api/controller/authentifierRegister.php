<?php

require_once('../../boundary/APIinterface/APIregister.php');
require_once('../../boundary/DBinterface/DBinterface.php');

$controller = new Authentifier();

class Authentifier
{
    public function __construct()
    {
        $this->DBinterface = new DBinterface();
        $this->APIregister = new APIregister($this);
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
            echo "Username already exists";
            return 4;
        }        
    }
}