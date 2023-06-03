<?php

require_once 'DBinterface.php';

//Compte Interface API
define('DB_LOGIN', "root");
define('DB_PWD', "");

/**
 * DBinfrastructures class
 * @package api\boundary\DBinterface
 */
class DBinfrastructures extends DBinterface {
    /**
     * DBinfrastructures constructor.
     */
    public function __construct(){
        parent::__construct(DB_LOGIN, DB_PWD);
    }

    private function getIdUniverse($idPlanet)
    {
        return $this->fetchValue('
            SELECT u.id AS universe_id
            FROM univers u
            JOIN galaxie g ON g.id_Univers = u.id
            JOIN systemesolaire s ON s.id_Galaxie = g.id
            JOIN planete p ON p.id_Systeme_Solaire = s.id
            WHERE p.id = ?;', [$idPlanet]
        );
    }

    public function updateResourcesEvent($id_Planet, $idInfra)
    {
        $idUniverse = $this->getIdUniverse($id_Planet);
        // Get the id Player
        $idPlayer = $this->fetchValue('
            SELECT id_Joueur
            FROM planete
            WHERE id = ?;', [$id_Planet]
        );

        $idResources = $this->fetchAllRows('
            SELECT ju.id_Ressource AS resource_id,
                    tr.type AS resource_type
            FROM joueurunivers ju
            JOIN ressource r ON r.id = ju.id_Ressource
            LEFT JOIN typeressource tr ON r.id_Type = tr.id
            WHERE ju.id_Univers = 1
            AND ju.id_Joueur = ?;', [$idPlayer]
        );
        
        $productionRate = $this->fetchAllRows('
            SELECT 
                i.id AS id,
                i.niveau AS niveau,
                tr.type AS type,
                rdf.production_metal AS production_metal,
                rdf.production_energie AS production_energie,
                rdf.production_deuterium AS production_deuterium
            FROM 
                infrastructure i
            LEFT JOIN infraressource r ON i.id = r.id_Infrastructure
            LEFT JOIN typeinfraressource tr ON r.id_Type_Ressource = tr.id
            LEFT JOIN ressourcedefaut rdf ON tr.id = rdf.id_Type_Ressource
            WHERE i.id = ?;', [$idInfra]
        )[0];

        // Update events
        // Metal
        $this->executeQuery('
            CREATE OR REPLACE EVENT 
                resource_metal_event_'.$idUniverse.'_'.$idPlayer.'_'.$idResources[0]['resource_id'].' 
            ON SCHEDULE EVERY 1 MINUTE DO 
            UPDATE 
                ressource 
            SET 
                ressource.quantite = ressource.quantite + ? 
            WHERE 
                ressource.id = ?;
            ', [($productionRate['production_metal'] * 60 * (1.5 ** ($productionRate['niveau']))), $idResources[0]['resource_id']]
        );
        // Energie
        $this->executeQuery('
            CREATE OR REPLACE EVENT 
                resource_energie_event_'.$idUniverse.'_'.$idPlayer.'_'.$idResources[1]['resource_id'].' 
            ON SCHEDULE EVERY 1 MINUTE DO 
            UPDATE 
                ressource 
            SET 
                ressource.quantite = ressource.quantite + ? 
            WHERE 
                ressource.id = ?;
            ', [($productionRate['production_energie'] * 60 * (1.5 ** ($productionRate['niveau']))), $idResources[1]['resource_id']]
        );
        // Deuterium
        $this->executeQuery('
            CREATE OR REPLACE EVENT 
                resource_deuterium_event_'.$idUniverse.'_'.$idPlayer.'_'.$idResources[2]['resource_id'].' 
            ON SCHEDULE EVERY 1 MINUTE DO 
            UPDATE 
                ressource 
            SET 
                ressource.quantite = ressource.quantite + ? 
            WHERE 
                ressource.id = ?;
            ', [($productionRate['production_deuterium'] * 60 * (1.5 ** ($productionRate['niveau']))), $idResources[2]['resource_id']]
        );

    }

    /**
     * getBonusRessources
     * function that return the bonus ressources of a planet
     * @param int $id_Planet
     * @return array
     */
    public function getBonusRessources($id_Planet)
    {
        return $this->fetchAllRows("
        SELECT 
            energie, 
            deuterium, 
            metal
        FROM 
            bonusressources
        WHERE id IN (
            SELECT 
                id_Bonus_Ressources
            FROM 
                planete
            WHERE 
                id = ?
        );", [$id_Planet])[0];
    }
    /**
     * getInfrastructuresByPlanetId
     * function that return the infrastructures of a planet
     * @param int $id_Planet
     * @return array
     */
    public function getInfrastructuresByPlanetId($id_Planet) 
    {
        return $this->fetchAllRows('
        SELECT 
            i.id AS infrastructure_id,
            i.niveau AS infrastructure_niveau,
            ti.type AS installation_type,
            tr.type AS ressource_type,
            td.type AS defense_type,
            ins.id AS installation_id,
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
    /**
     * getDefaultDefense
     * function that return the defense caracteristics of a player
     * 
     * @return array
     */
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
    /**
     * getDefaultInstallation
     * function that return the installation caracteristics of a player
     * 
     * @return array
     */
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
    /**
     * getDefaultRessource
     * function that return the ressource caracteristics of an infrastructure
     * 
     * @return array
     */
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
    /**
     * getLastInsertId
     * function that return the last id of the table infrastructure
     * 
     * @return int
     */
  
    public function getLastInsertId()
    {
        return $this->fetchValue('SELECT id FROM infrastructure ORDER BY id DESC LIMIT 1;');
    }
    /**
     * buildInfrastructure
     * function that build an infrastructure
     * @param int $id_Planet
     * @param string $type
     * @param string $infraType
     * @return int
     */
    

    public function buildInfrastructure($id_Planet, $infraType, $type)
    {
        $idType = $this->fetchValue('SELECT id FROM typeinfrastructure WHERE type = ?;', [$infraType]);

        $this->executeQuery('
        INSERT INTO infrastructure (id_Planete, id_Type) VALUES (?, ?);', [$id_Planet, $idType]);
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
    /**
     * upgradeInfrastructure
     * function that upgrade an infrastructure
     * @param int $id_Planet
     * @param int $id_Infrastructure
     * @return void
     */
    public function upgradeInfrastructure($id_Planet, $id_Infrastructure) 
    {
        return $this->executeQuery('UPDATE infrastructure SET niveau = niveau + 1 WHERE id = ?;', [$id_Infrastructure]);
    }
    /**
     * getQuantityRessourcePlayer
     * function that return the quantity of ressources of a player
     * 
     * @param int $id_Player
     * @param int $id_Universe
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
     * updateQuantityRessource
     * function that update the quantity of ressources of a player
     * 
     * @param int $id_Ressource
     * @param int $quantite
     * @return void
     */
    public function updateQuantityRessource($id_Ressource, $quantite)
    {
        return $this->executeQuery('UPDATE ressource SET quantite = quantite - ? WHERE id = ?;', [$quantite, $id_Ressource]);
    }

    /**
     * getTechnoRequired
     * function that return the technologies required
     * 
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
    /**
     * getInfraTechnoRequired
     * function that return the infrastructures technologies required
     * 
     * @return array
     */
    public function getInfraTechnoRequired()
    {
        return $this->fetchAllRows('
            SELECT
                itn.niveau,
                tt.type AS Type_Technologie,
                ti.type AS Type_Installation,
                td.type AS Type_Defense,
                tr.type AS Type_Ressource
            FROM infratechnologienecessaire AS itn
            LEFT JOIN typetechnologie AS tt
                ON itn.id_Technologie = tt.id
            LEFT JOIN typeinstallation AS ti
                ON itn.id_Type_Installation = ti.id
            LEFT JOIN typedefense AS td
                ON itn.id_Type_Defense = td.id
            LEFT JOIN typeinfraressource AS tr
                ON itn.id_Type_Ressource = tr.id;');
    }
    /**
     * getTechnologies
     * function that return the technologies of a laboratory
     * 
     * @param int $id_Labo
     * @return array
     */
    public function getTechnologies($id_Labo)
    {
        return $this->fetchAllRows('
            SELECT
                technologie.id,
                technologie.niveau,
                typetechnologie.type AS type_technologie
            FROM
                technologie
            JOIN
                typetechnologie ON technologie.id_Type = typetechnologie.id
            WHERE
            technologie.id_Laboratoire = ?;', [$id_Labo]);
    }

}

