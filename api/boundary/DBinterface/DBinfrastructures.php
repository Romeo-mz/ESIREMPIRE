<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "api_infrastructures");
define('DB_PWD', "kqV3qbr/AX)r9VI1");

class DBinfrastructures extends DBinterface {

    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    public function getInfrastructuresByPlanetId($id_Planet) 
    {
        return $this->fetchAllRows('
            SELECT 
                i.id, 
                i.niveau, 
                i.nom, 
                i.id_Planete, 
                inst.id as id_Installation, 
                ti.type as typeinstallation, 
                cs.id as id_Chantier_Spatial, 
                cs.nom as nom_Chantier_Spatial, 
                lab.id as id_Laboratoire, lab.nom as nom_Laboratoire, 
                r.id as id_Ressource, tr.type as typeressource, r.nom as nom_Ressource,
                d.id as id_Defense, td.type as typedefense, d.nom as nom_Defense
            FROM 
                infrastructure i
            LEFT JOIN 
                installation inst ON i.id = inst.id_Infrastructure
            LEFT JOIN 
                typeinstallation ti ON inst.id_Type = ti.id
            LEFT JOIN 
                chantierspatial cs ON inst.id = cs.id_Installation
            LEFT JOIN 
                laboratoire lab ON inst.id = lab.id_Installation
            LEFT JOIN 
                infraressource r ON i.id = r.id_Infrastructure
            LEFT JOIN 
                typeinfraressource tr ON r.id_Type = tr.id
            LEFT JOIN 
                defense d ON i.id = d.id_Infrastructure
            LEFT JOIN 
                typedefense td ON d.id_Type = td.id
            WHERE 
                i.id_Planete = ?', [$id_Planet]);
    }
        

}

