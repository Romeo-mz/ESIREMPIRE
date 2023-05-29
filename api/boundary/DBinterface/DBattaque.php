<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "root");
define('DB_PWD', "");

class DBattaque extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    public function getInfrastructuresPoints($id_Defender_Planet)
    {
        return $this->fetchAllRows('
            SELECT  
                i.id AS infrastructure_id,
                i.niveau AS infrastructure_niveau,
                td.type AS defense_type,
                ddf.point_attaque AS defense_point_attaque,
                ddf.point_defense AS defense_point_defense
            FROM 
                infrastructure i
            LEFT JOIN defense d ON i.id = d.id_Infrastructure
            LEFT JOIN typedefense td ON d.id_Type_Defense = td.id
            LEFT JOIN defensedefaut ddf ON td.id = ddf.id_Type_Defense
            WHERE i.id_Planete = ? AND td.type IS NOT NULL;', [$id_Defender_Planet]);
    }

    public function getFleet($idDefenderPlayer, $idDefenderPlanet)
    {
        $id_Spacework =  $this->fetchValue('
            SELECT ins.id
            FROM installation AS ins
            JOIN typeinstallation AS ti ON ins.id_Type_Installation = ti.id
            JOIN infrastructure AS inf ON ins.id_Infrastructure = inf.id
            WHERE ti.type = "Chantier spatial" AND inf.id_Planete = ?;',
            [$idDefenderPlanet]
        );

        if($id_Spacework === false){
            return null;
        }

        $ships =  $this->fetchAllRows('
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

        return $ships;

    }

    public function getShipsPoint()
    {
        return $this->fetchAllRows('
            SELECT
                tv.type,
                vdf.point_attaque,
                vdf.point_defense,
                vdf.capacite_fret
            FROM
                vaisseaudefaut vdf
            LEFT JOIN typevaisseaux tv ON vdf.id_Type = tv.id;
        ');
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
    
        $query = "SELECT p.id as id, j.pseudo as pseudo, g.nom as nom_galaxie, ss.nom as nom_systeme_solaire, p.nom as nom_planete, p.id as id_planete, p.id_Joueur as id_defender
              FROM planete p
              JOIN joueur j ON p.id_Joueur = j.id
              JOIN systemesolaire ss ON p.id_Systeme_Solaire = ss.id
              JOIN galaxie g ON ss.id_Galaxie = g.id
              WHERE p.id_Joueur = ? AND p.id_Systeme_Solaire IN ($inQuery)";
        $params = array_merge([$id_Ennemis], $id_Systeme_Solaire);
        $dataEnnemis = $this->fetchAllRows($query, $params);
    
        return $dataEnnemis;
    }
    
    public function getPseudo($id_Planet, $id_Univers){
        $query = "SELECT joueur.pseudo
        FROM joueur
        INNER JOIN joueurunivers ON joueur.id = joueurunivers.id_Joueur
        INNER JOIN planete ON joueur.id = planete.id_Joueur
        WHERE joueurunivers.id_univers = ?
        AND planete.id = ?
        ";
        $pseudo = $this->fetchAllRows($query, [$id_Planet, $id_Univers]);
        return $pseudo;
    }

}