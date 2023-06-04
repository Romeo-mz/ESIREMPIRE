<?php

require_once('DBinterface.php');

// define('DB_LOGIN', "api_vaisseau");
// define('DB_PWD', "HoEPox@4lnMYL5d)");
define('DB_LOGIN', "root");
define('DB_PWD', "");

/**
 * DBvaisseau class
 * @package api\boundary\DBinterface
 *
 */
class DBvaisseau extends DBinterface
{
    /**
     * DBvaisseau constructor.
     */
    public function __construct()
    {
        parent::__construct(DB_LOGIN, DB_PWD);
    }
    /**
     * function getDefaultVaisseaux
     * function that get the default ships
     * @param $id_Spacework
     * @return array
     */
    public function getDefaultVaisseaux($id_Spacework)
    {
        return $this->fetchAllRows('
            SELECT
                tv.type,
            COALESCE(sq.nb, 0) AS quantity
            FROM
                vaisseaudefaut vdf
            LEFT JOIN typevaisseaux tv ON vdf.id_Type = tv.id
            LEFT JOIN (
                SELECT
                    tv.id AS type_id,
                    COUNT(v.id) AS nb
                FROM
                    vaisseau v
                LEFT JOIN typevaisseaux tv ON v.id_Type = tv.id
                WHERE
                    v.id_Chantier_Spatial = ?
                GROUP BY
                    tv.id
            ) AS sq ON tv.id = sq.type_id;', [$id_Spacework]);
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
            WHERE ti.type = "Chantier spatial" AND inf.id_Planete = ?;',
            [$id_Planet]
        );
    }
    /**
     * function updateFlotteAttaque
     * function that update the attack fleet
     * @param $idFlotte
     * @param $idJoueur
     * @param $idRapport
     * @param $idVaisseaux
     * @return array
     */
    public function updateFlotteAttaque($idFlotte, $idJoueur, $idRapport, $idVaisseaux )
    {
        // Mettez à jour la table flotte_attaque avec les ID des vaisseaux correspondants
        return $this->executeQuery('
            INSERT INTO flotte_attaque (id, id_Joueur, id_Rapport_Combat, id_Vaisseaux_Combattants)
            VALUES (?, ?, ?, ?);',
            [$idFlotte, $idJoueur, $idRapport, $idVaisseaux]
        );
        
    }



}