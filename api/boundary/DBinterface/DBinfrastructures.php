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
        LEFT JOIN typeinfraressource tr ON r.id_Type_Ressource = tr.id
        LEFT JOIN ressourcedefaut rdf ON tr.id = rdf.id_Type_Ressource
        LEFT JOIN defense d ON i.id = d.id_Infrastructure
        LEFT JOIN typedefense td ON d.id_Type_Defense = td.id
        LEFT JOIN defensedefaut ddf ON td.id = ddf.id_Type_Defense
        WHERE i.id_Planete = ?;', [$id_Planet]);
    }

    public function getDefaultDefense()
    {
        return $this->fetchAllRows('
        SELECT
            td.type,
            ddf.cout_metal AS defense_cout_metal,
            ddf.cout_deuterium AS defense_cout_deuterium,
            ddf.cout_energie AS defense_cout_energie,
            ddf.temps_construction AS defense_temps_construction,
            ddf.point_attaque AS defense_point_attaque,
            ddf.point_defense AS defense_point_defense
        FROM
            defensedefaut ddf
        LEFT JOIN typedefense td ON ddf.id_Type_Defense = td.id;');
    }        

    public function getDefaultInstallation()
    {
        return $this->fetchAllRows('
        SELECT
            ti.type,
            idf.cout_metal AS installation_cout_metal,
            idf.cout_energie AS installation_cout_energie,
            idf.temps_construction AS installation_temps_construction
        FROM
            installationdefaut idf
        LEFT JOIN typeinstallation ti ON idf.id_Type_Installation = ti.id;');
    }

    public function getDefaultRessource()
    {
        return $this->fetchAllRows('
        SELECT
            tr.type,
            rdf.cout_metal AS ressource_cout_metal,
            rdf.cout_deuterium AS ressource_cout_deuterium,
            rdf.cout_energie AS ressource_cout_energie,
            rdf.temps_construction AS ressource_temps_construction,
            rdf.production_metal AS ressource_production_metal,
            rdf.production_energie AS ressource_production_energie,
            rdf.production_deuterium AS ressource_production_deuterium
        FROM
            ressourcedefaut rdf
        LEFT JOIN typeinfraressource tr ON rdf.id_Type_Ressource = tr.id;');
    }

    public function getLastInsertId()
    {
        return $this->fetchValue('SELECT id FROM infrastructure ORDER BY id DESC LIMIT 1;');
    }

    public function buildInfrastructure($id_Planet, $type)
    {
        $this->executeQuery('
        INSERT INTO infrastructure (id_Planete) VALUES (?);', [$id_Planet]);
        $id_Infrastructure = $this->getLastInsertId();

        switch ($type) {
            case 'Chantier spatial':
                $this->executeQuery('
                INSERT INTO installation (id_Infrastructure, id_Type_Installation) VALUES (?, 2);', [$id_Infrastructure]);
                break;
            case 'Laboratoire':
                $this->executeQuery('
                INSERT INTO installation (id_Infrastructure, id_Type_Installation) VALUES (?, 1);', [$id_Infrastructure]);
                break;
            case 'Usine de nanites':
                $this->executeQuery('
                INSERT INTO installation (id_Infrastructure, id_Type_Installation) VALUES (?, 3);', [$id_Infrastructure]);
                break;
            case 'Mine de metal':
                $this->executeQuery('
                INSERT INTO infraressource (id_Infrastructure, id_Type_Ressource) VALUES (?, 1);', [$id_Infrastructure]);
                break;
            case 'Synthetiseur de deuterium':
                $this->executeQuery('
                INSERT INTO infraressource (id_Infrastructure, id_Type_Ressource) VALUES (?, 2);', [$id_Infrastructure]);
                break;
            case 'Centrale solaire':
                $this->executeQuery('
                INSERT INTO infraressource (id_Infrastructure, id_Type_Ressource) VALUES (?, 3);', [$id_Infrastructure]);
                break;
            case 'Centrale a fusion':
                $this->executeQuery('
                INSERT INTO infraressource (id_Infrastructure, id_Type_Ressource) VALUES (?, 4);', [$id_Infrastructure]);
                break;
            case 'Artillerie laser':
                $this->executeQuery('
                INSERT INTO defense (id_Infrastructure, id_Type_Defense) VALUES (?, 1);', [$id_Infrastructure]);
                break;
            case 'Canon a ions':
                $this->executeQuery('
                INSERT INTO defense (id_Infrastructure, id_Type_Defense) VALUES (?, 2);', [$id_Infrastructure]);
                break;
            case 'Bouclier':
                $this->executeQuery('
                INSERT INTO defense (id_Infrastructure, id_Type_Defense) VALUES (?, 3);', [$id_Infrastructure]);
                break;
        }

        return $id_Infrastructure;
    }

    public function upgradeInfrastructure($id_Planet, $id_Infrastructure) 
    {
        return $this->executeQuery('UPDATE infrastructure SET niveau = niveau + 1 WHERE id = ?;', [$id_Infrastructure]);
    }

}

