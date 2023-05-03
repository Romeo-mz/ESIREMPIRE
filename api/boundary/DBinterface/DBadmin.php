<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "api_admin");
define('DB_PWD', "apiadmin1234");

class DBadmin extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    public function getUniverses()
    {
        return $this->fetchAllRows('SELECT * FROM univers');
    }

    public function getLastUniverseId()
    {
        return $this->fetchValue('SELECT MAX(id) FROM univers');
    }

    public function getLast5GalaxiesId($universeId)
    {
        return $this->fetchAllRows('SELECT id FROM galaxie WHERE id_Univers = ' . $universeId . ' ORDER BY id DESC LIMIT 5');
    }

    public function getLast50SolarSystemsId($placeholders, $galaxiesId)
    {
        // return $this->fetchAllRows("SELECT id FROM systemesolaire WHERE id_Galaxie IN ($placeholders) ORDER BY id DESC LIMIT 50");
        return $this->fetchAllRows("SELECT id FROM systemesolaire WHERE id_Galaxie IN ($placeholders) ORDER BY id DESC LIMIT 50", $galaxiesId);
    }

    public function createUniverse($name)
    {
        return $this->executeQuery('INSERT INTO univers (nom) VALUES (?)', [$name]);
    }

    public function createGalaxy($name, $universe_id)
    {
        return $this->executeQuery('INSERT INTO galaxie (nom, id_Univers) VALUES (?, ?)', [$name, $universe_id]);
    }

    public function createSolarSystem($name, $galaxy_id)
    {
        return $this->executeQuery('INSERT INTO systemesolaire (nom, id_Galaxie) VALUES (?, ?)', [$name, $galaxy_id]);
    }

    public function createPlanet($name, $position, $taille, $id_Bonus_Ressources, $id_Systeme_Solaire)
    {
        return $this->executeQuery('INSERT INTO planete (id_Systeme_Solaire, taille, position, nom, id_Bonus_Ressources) VALUES (?, ?, ?, ?, ?)', [$id_Systeme_Solaire, $taille, $position, $name, $id_Bonus_Ressources]);
    }

    // public function getUniverses($query){
    //     $result = $this->db->query($query);
    //     $row = $result->fetchAll(PDO::FETCH_ASSOC);
    //     return $row;
    // }

    // public function getLastUniverseId($query){
    //     $result = $this->db->query($query);
    //     $row = $result->fetch(PDO::FETCH_ASSOC);
    //     return $row['MAX(id)'];
    // }

    // public function getLast5GalaxiesId($query){
    //     $result = $this->db->query($query);
    //     $row = $result->fetchAll(PDO::FETCH_ASSOC);
    //     return $row;
    // }

    // public function getLast50SolarSystemsId($query){
    //     $result = $this->db->query($query);
    //     $row = $result->fetchAll(PDO::FETCH_ASSOC);
    //     return $row;
    // }

    // public function createUniverse($query){
    //     $stmt = $this->db->prepare($query);
    //     $result = $stmt->execute(); 
    //     return $result;
    // }

    // public function createGalaxy($query){
    //     $stmt = $this->db->prepare($query);
    //     $result = $stmt->execute(); 
    //     return $result;
    // }

    // public function createSolarSystem($query){
    //     $stmt = $this->db->prepare($query);
    //     $result = $stmt->execute(); 
    //     return $result;
    // }

    // public function createPlanet($query){
    //     $stmt = $this->db->prepare($query);
    //     $result = $stmt->execute(); 
    //     return $result;
    // }

}

