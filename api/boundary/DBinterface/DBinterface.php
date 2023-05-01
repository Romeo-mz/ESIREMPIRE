<?php

//paramètres de la base de données
define('SERVER', "localhost");
define('DB_PORT', "3306");
define('DB_NAME', "esirempire");
define('DB_LOGIN', "root");
define('DB_PWD', "");

class DBinterface {

    private $db;

    public function __construct(){
        try{
            $this->db = new PDO('mysql:host=' . SERVER . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8', DB_LOGIN, DB_PWD);
        } catch(PDOException $e){
            echo 'Error while connexion : ' . $e->getMessage();
        }
    }

    public function getDB(){
        return $this->db;
    }

}