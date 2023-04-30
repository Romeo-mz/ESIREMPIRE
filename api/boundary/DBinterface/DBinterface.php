<?php

//paramètres de la base de données
define('SERVEURBDD', "localhost");
define('NOMBASE', "esirempire_db");
define('LOGINBDD', "_");
define('PASSWORDBDD', "");

class DBinterface {

    private $db;

    public function __construct(){
        try{
            $this->bdd = new PDO(
                "mysql:host=". SERVEURBDD .";dbname=". NOMBASE , LOGINBDD, PASSWORDBDD;
            );
        } catch(PDOException $e){
            echo 'Échec lors de la connexion : ' . $e->getMessage();
        }
    }

}