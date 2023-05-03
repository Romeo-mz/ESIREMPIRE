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
}