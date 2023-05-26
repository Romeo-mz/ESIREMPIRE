<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "root");
define('DB_PWD', "");

class DBattaque extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    
    public function getListeEnnemis($id_Joueur, $id_Univers){
        $listeEnnemis = "SELECT DISTINCT id_Joueur FROM joueurunivers WHERE id_Joueur != ? AND id_Univers = ?";
        $listeEnnemis = $this->fetchAllRows($listeEnnemis, [$id_Joueur, $id_Univers]);
        return $listeEnnemis;
    }



}