<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "root");
define('DB_PWD', "");

/**
 * Class DBadmin
 * @package api\boundary\DBinterface
 */
class DBadmin extends DBinterface {
    /**
     * DBadmin constructor.
     */
    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }
    /**
     * getUniverses
     * 
     * @return array
     */
    public function getUniverses()
    {
        return $this->fetchAllRows('SELECT * FROM univers');
    }
    /**
     * getLastUniverseId
     *
     * @return int
     */
    public function getLastUniverseId()
    {
        return $this->fetchValue('SELECT MAX(id) FROM univers');
    }
    /**
     * getLast5GalaxiesId
     * Function that return the last 5 galaxies id
     *
     * @param int $universeId
     * @return array
     */
    public function getLast5GalaxiesId($universeId)
    {
        return $this->fetchAllRows('SELECT id FROM galaxie WHERE id_Univers = ' . $universeId . ' ORDER BY id DESC LIMIT 5');
    }
    /**
     * getLast50SolarSystemsId
     * Function that return the last 50 solar systems id
     *
     * @param array $galaxiesId
     * @return array
     */
    public function getLast50SolarSystemsId($placeholders, $galaxiesId)
    {
        return $this->fetchAllRows("SELECT id FROM systemesolaire WHERE id_Galaxie IN ($placeholders) ORDER BY id DESC LIMIT 50", $galaxiesId);
    }
    /**
     * createUniverse
     * Function that create a new universe by inserting a new row in the univers table
     *
     * @param string $name
     * @return void
     */
    public function createUniverse($name)
    {
        return $this->executeQuery('INSERT INTO univers (nom) VALUES (?)', [$name]);
    }
    /**
     * createGalaxy
     * Function that create a new galaxy by inserting a new row in the galaxie table
     *
     * @param string $name
     * @param int $universe_id
     * @return void
     */
    public function createGalaxy($name, $universe_id)
    {
        return $this->executeQuery('INSERT INTO galaxie (nom, id_Univers) VALUES (?, ?)', [$name, $universe_id]);
    }
    /**
     * createSolarSystem
     * Function that create a new solar system by inserting a new row in the systemesolaire table
     *
     * @param string $name
     * @param int $galaxy_id
     * @return void
     */
    public function createSolarSystem($name, $galaxy_id)
    {
        return $this->executeQuery('INSERT INTO systemesolaire (nom, id_Galaxie) VALUES (?, ?)', [$name, $galaxy_id]);
    }
    /**
     * createPlanet
     * Function that create a new planet by inserting a new row in the planete table
     *
     * @param string $name
     * @param int $position
     * @param int $taille
     * @param int $id_Bonus_Ressources
     * @param int $id_Systeme_Solaire
     * @return void
     */
    public function createPlanet($name, $position, $taille, $id_Bonus_Ressources, $id_Systeme_Solaire)
    {
        return $this->executeQuery('INSERT INTO planete (id_Systeme_Solaire, taille, position, nom, id_Bonus_Ressources) VALUES (?, ?, ?, ?, ?)', [$id_Systeme_Solaire, $taille, $position, $name, $id_Bonus_Ressources]);
    }

}

