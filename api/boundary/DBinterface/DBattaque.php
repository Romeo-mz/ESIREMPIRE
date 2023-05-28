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

    public function getIdGalaxie($id_Univers){
        $result = "SELECT id FROM galaxie WHERE id_Univers = ?";
        $result = $this->fetchAllRows($result, [$id_Univers]);
    
        $id_Galaxie = array_column($result, 'id');
    
        return $id_Galaxie;
    }
    
    public function getIdSystemeSolaire($id_Galaxie){
        $inQuery = implode(',', array_fill(0, count($id_Galaxie), '?'));
    
        $result = "SELECT id FROM systemesolaire WHERE id_Galaxie IN ($inQuery)";
        $result_query = $this->fetchAllRows($result, $id_Galaxie);
    
        $id_Systeme_Solaire = array_column($result_query, 'id');
    
        return $id_Systeme_Solaire;
    }
    
    public function getDataEnnemis($id_Ennemis, $id_Univers) {
        $id_Galaxie = $this->getIdGalaxie($id_Univers);
        $id_Systeme_Solaire = $this->getIdSystemeSolaire($id_Galaxie);
        
        $inQuery = implode(',', array_fill(0, count($id_Systeme_Solaire), '?'));
    
        $query = "SELECT id, nom, id_Systeme_Solaire FROM planete WHERE id_Joueur = ? AND id_Systeme_Solaire IN ($inQuery)";
        $params = array_merge([$id_Ennemis], $id_Systeme_Solaire);
        $dataEnnemis = $this->fetchAllRows($query, $params);
    
        return $dataEnnemis;
    }
    
}