<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "root");
define('DB_PWD', "");

/**
 * DBspacework class
 * @package api\boundary\DBinterface
 *
 */
class DBspacework extends DBinterface {
    /**
     * DBspacework constructor.
     */
    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }
    /**
     * function getSpaceworkID
     * function that get the id of the spacework
     * @param $id_Planet
     * @return array
     */
    public function getSpaceworkID($id_Planet)
    {
        return $this->fetchValue('
            SELECT ins.id
            FROM installation AS ins
            JOIN typeinstallation AS ti ON ins.id_Type_Installation = ti.id
            JOIN infrastructure AS inf ON ins.id_Infrastructure = inf.id
            WHERE ti.type = "Chantier spatial" AND inf.id_Planete = ?;', [$id_Planet]
        );
    }
    /**
     * function getDefaultShips
     * function that get the default ships
     * @return array
     */
    public function getDefaultShips()
    {
        return $this->fetchAllRows('
            SELECT
                tv.type,
                vdf.cout_metal,
                vdf.cout_deuterium,
                vdf.temps_construction,
                vdf.point_attaque,
                vdf.point_defense,
                vdf.capacite_fret
            FROM
                vaisseaudefaut vdf
            LEFT JOIN typevaisseaux tv ON vdf.id_Type = tv.id;
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
     * function getNbShips
     * function that get the number of ships
     * @param $id_Spacework
     * @return array
     */
    public function getNbShips($id_Spacework)
    {
        // Get the number of ships for each type of ship
        return $this->fetchAllRows('
            SELECT
                tv.type,
                COUNT(v.id) AS nb
            FROM
                vaisseau v
            LEFT JOIN typevaisseaux tv ON v.id_Type = tv.id
            WHERE
                v.id_Chantier_Spatial = ?
            GROUP BY
                tv.type;', [$id_Spacework]);
    }
    /**
     * function getLaboratoireID
     * function that get the id of the laboratory
     * @param $id_Planet
     * @return array
     */
    private function getLaboratoireID($id_Planet)
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
     * function getTechnologies
     * function that get the technologies
     * @param $id_Planet
     * @return array
     */
    public function getTechnologies($id_Planet)
    {
        $idLabo = $this->getLaboratoireID($id_Planet);

        return $this->fetchAllRows('
            SELECT
                t.id,
                tt.type,
                t.niveau
            FROM
                technologie t
            LEFT JOIN typetechnologie tt ON t.id_Type = tt.id
            WHERE
                t.id_Laboratoire = ?;', [$idLabo]);
    }
    /**
     * function addShip
     * function that add a ship
     * @param $id_Spacework
     * @param $type
     * @return array
     */
    public function addShip($id_Spacework, $type)
    {
        switch ($type) {
            case 'CHASSEUR':
                $this->executeQuery('
                    INSERT INTO vaisseau (id_Chantier_Spatial, id_Type) VALUES (?, 1);', [$id_Spacework]);
                break;
            case 'CROISEUR':
                $this->executeQuery('
                    INSERT INTO vaisseau (id_Chantier_Spatial, id_Type) VALUES (?, 2);', [$id_Spacework]);
                break;
            case 'TRANSPORTEUR':
                $this->executeQuery('
                    INSERT INTO vaisseau (id_Chantier_Spatial, id_Type) VALUES (?, 3);', [$id_Spacework]);
                break;
            case 'COLONISATEUR':
                $this->executeQuery('
                    INSERT INTO vaisseau (id_Chantier_Spatial, id_Type) VALUES (?, 4);', [$id_Spacework]);
                break;
        }
    }
    /**
     * function addToDefense
     * function that add to defense
     * @param $id_joueur
     * @return array
     */
    public function addToDefense($id_joueur){
        $id_vaisseaux = $this->executeQuery('
            SELECT * FROM vaisseau ORDER BY vaisseau.id DESC LIMIT 1;');
        $this->executeQuery('
            INSERT INTO flottedefense (id_joueur, id_vaisseaux_combattants) VALUES (?, ?);', [$id_joueur, $id_vaisseaux]);
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
     * function that get the required technology
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

