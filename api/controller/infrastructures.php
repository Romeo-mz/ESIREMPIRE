<?php

require_once('../../boundary/DBinterface/DBinfrastructures.php');

class Infrastructures
{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBinfrastructures();
    }

    public function getBonusRessources($id_Planet)
    {
        return $this->dbInterface->getBonusRessources($id_Planet);
    }
    
    public function getInfrastructures($id_Planet)
    {
        return $this->dbInterface->getInfrastructuresByPlanetId($id_Planet);
    }

    public function getDefaultDefense()
    {
        return $this->dbInterface->getDefaultDefense();
    }

    public function getDefaultInstallation()
    {
        return $this->dbInterface->getDefaultInstallation();
    }

    public function getDefaultRessource()
    {
        return $this->dbInterface->getDefaultRessource();
    }

    public function buildInfrastructure($id_Planet, $type)
    {
        return $this->dbInterface->buildInfrastructure($id_Planet, $type);
    }

    public function upgradeInfrastructure($id_Planet, $id_Infrastructure)
    {
        $this->dbInterface->upgradeInfrastructure($id_Planet, $id_Infrastructure);
    }

    public function getQuantityRessourcePlayer($id_Player, $id_Universe)
    {
        return $this->dbInterface->getQuantityRessourcePlayer($id_Player, $id_Universe);
    }

    public function updateQuantityRessource($id_Ressource, $quantite)
    {
        $this->dbInterface->updateQuantityRessource($id_Ressource, $quantite);
    }

    public function getTechnoRequired()
    {
        return $this->dbInterface->getTechnoRequired();
    }

    public function getInfraTechnoRequired()
    {
        return $this->dbInterface->getInfraTechnoRequired();
    }

    public function getTechnologies($id_Labo)
    {
        return $this->dbInterface->getTechnologies($id_Labo);
    }

}