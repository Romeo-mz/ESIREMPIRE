<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "api_search");
define('DB_PWD', "4]vhuhrWWSzDF_OG");
/**
 * DBsearch class
 * @package api\boundary\DBinterface
 *
 */
class DBsearch extends DBinterface {
    /**
     * DBsearch constructor.
     */
    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }
    /**
     * function getLaboratoireID
     * function that get the id of the laboratory
     * @param $id_Planet
     * @return array
     */
    public function getLaboratoireID($id_Planet)
    {
        return $this->fetchValue('
            SELECT ins.id
            FROM installation AS ins
            JOIN typeinstallation AS ti ON ins.id_Type_Installation = ti.id
            JOIN infrastructure AS inf ON ins.id_Infrastructure = inf.id
            WHERE ti.type = "Laboratoire" AND inf.id_Planete = ?;', [$id_Planet]
        );
    }
    /**
     * function getDefaultTechnologie
     * function that get the default technology
     * @return array
     * 
     */
    public function getDefaultTechnologie()
    {
        return $this->fetchAllRows('
            SELECT
                tt.type,
                tdf.cout_metal,
                tdf.cout_deuterium,
                tdf.temps_recherche
            FROM
                technologiedefaut tdf
            LEFT JOIN typetechnologie tt ON tdf.id_Type_Technologie = tt.id;
        ');
    }
    /**
     * function getQuantityRessourcePlayer
     * function that get the quantity of the resource of the player
     * @param $id_Player
     * @param $id_Universe
     * @return array
     */
    public function getQuantityRessourcePlayer($id_Player, $id_Universe)
    {
        return $this->fetchAllRows('
            SELECT
                ju.id_Ressource,
                tr.type,
                r.quantite
            FROM
                joueurunivers ju
            LEFT JOIN ressource r ON r.id = ju.id_Ressource
            LEFT JOIN typeressource tr ON tr.id = r.id_Type
            WHERE
                ju.id_Joueur = ? AND
                ju.id_Univers = ?;', [$id_Player, $id_Universe]);
    }
    /**
     * function getTechnologies
     * function that get the technologies of a Laboratory
     * @param $id_Labo
     */
    public function getTechnologies($id_Labo)
    {
        return $this->fetchAllRows('
            SELECT
                technologie.id,
                technologie.niveau,
                tt.type AS type_technologie,
                td.cout_metal,
                td.cout_deuterium,
                td.temps_recherche
            FROM
                technologie
            JOIN
                typetechnologie tt ON technologie.id_Type = tt.id
            LEFT JOIN 
                technologiedefaut td ON tt.id = td.id_Type_Technologie
            WHERE
                technologie.id_Laboratoire = ?;', [$id_Labo]);
    }
    /**
     * function upgradeTechnologie
     * function that upgrade the technology
     * @param $id_Technologie
     * @return array
     */
    public function upgradeTechnologie($id_Technologie) 
    {
        return $this->executeQuery('UPDATE technologie SET niveau = niveau + 1 WHERE id = ?;', [$id_Technologie]);
    }
    /**
     * function createTechnologie
     * function that create a technology
     * @param $id_Labo
     * @param $type
     * @return array
     */
    public function createTechnologie($id_Labo, $type)
    {
        switch ($type) {
            case 'ENERGIE':
                $this->executeQuery('
                INSERT INTO technologie (id_Laboratoire, id_Type) VALUES (?, 1);', [$id_Labo]);
                $id_Technologie = $this->fetchValue('SELECT id FROM technologie WHERE id_Laboratoire = ? AND id_Type = 1;', [$id_Labo]);
                break;
            case 'LASER':
                $this->executeQuery('
                INSERT INTO technologie (id_Laboratoire, id_Type) VALUES (?, 2);', [$id_Labo]);
                $id_Technologie = $this->fetchValue('SELECT id FROM technologie WHERE id_Laboratoire = ? AND id_Type = 2;', [$id_Labo]);
                break;
            case 'IONS':
                $this->executeQuery('
                INSERT INTO technologie (id_Laboratoire, id_Type) VALUES (?, 3);', [$id_Labo]);
                $id_Technologie = $this->fetchValue('SELECT id FROM technologie WHERE id_Laboratoire = ? AND id_Type = 3;', [$id_Labo]);
                break;
            case 'IA':
                $this->executeQuery('
                INSERT INTO technologie (id_Laboratoire, id_Type) VALUES (?, 4);', [$id_Labo]);
                $id_Technologie = $this->fetchValue('SELECT id FROM technologie WHERE id_Laboratoire = ? AND id_Type = 4;', [$id_Labo]);
                break;
            case 'ARMEMENT':
                $this->executeQuery('
                INSERT INTO technologie (id_Laboratoire, id_Type) VALUES (?, 5);', [$id_Labo]);
                $id_Technologie = $this->fetchValue('SELECT id FROM technologie WHERE id_Laboratoire = ? AND id_Type = 5;', [$id_Labo]);
                break;
            case 'BOUCLIER':
                $this->executeQuery('
                INSERT INTO technologie (id_Laboratoire, id_Type) VALUES (?, 6);', [$id_Labo]);
                $id_Technologie = $this->fetchValue('SELECT id FROM technologie WHERE id_Laboratoire = ? AND id_Type = 6;', [$id_Labo]);
                break;
        }

        

        return $id_Technologie;
    }
    /**
     * function updateQuantityRessource
     * function that update the quantity of the resource
     * @param $id_Ressource
     * @param $quantite
     * @return array
     */
    public function updateQuantityRessource($id_Ressource, $quantite)
    {
        return $this->executeQuery('UPDATE ressource SET quantite = quantite - ? WHERE id = ?;', [$quantite, $id_Ressource]);
    }
    /**
     * function getTechnoRequired
     * function that get the technology required
     * @return array
     */
    public function getTechnoRequired()
    {
        return $this->fetchAllRows('
            SELECT
                tt1.type AS technologie,
                tt2.type AS technologie_necessaire,
                tn.niveau AS technologie_necessaire_niveau
            FROM
                technotechnologienecessaire AS tn
            JOIN
                typetechnologie AS tt1
            ON
                tn.id_Technologie = tt1.id
            JOIN
                typetechnologie AS tt2
            ON
                tn.id_Technologie_Necessaire = tt2.id;');
    }

    

}

