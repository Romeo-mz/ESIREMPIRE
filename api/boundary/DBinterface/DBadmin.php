<?php

require_once 'Interface.php';

//Compte Interface API
define('DB_LOGIN', "api_admin");
define('DB_PWD', "apiadmin1234");

class DBadmin extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    public function getUniverses()
    {
        return $this->fetchAllRows('SELECT * FROM universes');
    }

    public function getLastUniverseId()
    {
        return $this->fetchValue('SELECT MAX(id) FROM universes');
    }

    public function getLast5GalaxiesId()
    {
        return $this->fetchAllRows('SELECT * FROM galaxies ORDER BY id DESC LIMIT 5');
    }

    public function getLast50SolarSystemsId()
    {
        return $this->fetchAllRows('SELECT * FROM solar_systems ORDER BY id DESC LIMIT 50');
    }

    public function createUniverse($name)
    {
        return $this->executeQuery('INSERT INTO universes (name) VALUES (?)', [$name]);
    }

    public function createGalaxy($name, $universe_id)
    {
        return $this->executeQuery('INSERT INTO galaxies (name, universe_id) VALUES (?, ?)', [$name, $universe_id]);
    }

    public function createSolarSystem($name, $galaxy_id)
    {
        return $this->executeQuery('INSERT INTO solar_systems (name, galaxy_id) VALUES (?, ?)', [$name, $galaxy_id]);
    }

    public function createPlanet($name, $solar_system_id)
    {
        return $this->executeQuery('INSERT INTO planets (name, solar_system_id) VALUES (?, ?)', [$name, $solar_system_id]);
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