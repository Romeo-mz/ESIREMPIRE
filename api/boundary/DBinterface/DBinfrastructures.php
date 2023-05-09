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
            i.id AS infrastructure_id,
            i.niveau AS infrastructure_niveau,
            ti.type AS installation_type,
            tr.type AS ressource_type,
            td.type AS defense_type,
            idf.cout_metal AS installation_cout_metal,
            idf.cout_energie AS installation_cout_energie,
            idf.temps_construction AS installation_temps_construction,
            rdf.cout_metal AS ressource_cout_metal,
            rdf.cout_deuterium AS ressource_cout_deuterium,
            rdf.cout_energie AS ressource_cout_energie,
            rdf.temps_construction AS ressource_temps_construction,
            rdf.production_metal AS ressource_production_metal,
            rdf.production_energie AS ressource_production_energie,
            rdf.production_deuterium AS ressource_production_deuterium,
            ddf.cout_metal AS defense_cout_metal,
            ddf.cout_deuterium AS defense_cout_deuterium,
            ddf.cout_energie AS defense_cout_energie,
            ddf.temps_construction AS defense_temps_construction,
            ddf.point_attaque AS defense_point_attaque,
            ddf.point_defense AS defense_point_defense
        FROM 
            infrastructure i
        LEFT JOIN installation ins ON i.id = ins.id_Infrastructure
        LEFT JOIN typeinstallation ti ON ins.id_Type_Installation = ti.id
        LEFT JOIN installationdefaut idf ON ti.id = idf.id_Type_Installation
        LEFT JOIN infraressource r ON i.id = r.id_Infrastructure
        LEFT JOIN typeressource tr ON r.id_Type_Ressource = tr.id
        LEFT JOIN ressourcedefaut rdf ON tr.id = rdf.id_Type_Ressource
        LEFT JOIN defense d ON i.id = d.id_Infrastructure
        LEFT JOIN typedefense td ON d.id_Type_Defense = td.id
        LEFT JOIN defensedefaut ddf ON td.id = ddf.id_Type_Defense
        WHERE i.id_Planete = ?;', [$id_Planet]);
    }
        

}

