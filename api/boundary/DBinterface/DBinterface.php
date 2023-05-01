<?php

//paramètres de la base de données
define('SERVER', "localhost");
define('DB_PORT', "3307");
define('DB_NAME', "esirempire_db");
define('DB_LOGIN', "api_admin");
define('DB_PWD', "apiadmin1234");

class DBinterface {

    private $db;

    public function __construct(){
        try{
            $this->db = new PDO('mysql:host=' . SERVER . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8', DB_LOGIN, DB_PWD);
        } catch(PDOException $e){
            echo 'Error while connexion : ' . $e->getMessage();
        }
    }

    public function getLastUniverseId($query){
        $result = $this->db->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['MAX(id)'];
    }

    public function createUniverse($query){
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute(); 
        return $result;
    }

}