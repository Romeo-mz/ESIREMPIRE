<?php

require_once('../../boundary/DBinterface/DBsearch.php');

class Search
{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBsearch();
    }
    
    public function getLaboratoireID($id_Planet)
    {
        return $this->dbInterface->getLaboratoireID($id_Planet);
    }

    public function getDefaultTechnologie()
    {
        return $this->dbInterface->getDefaultTechnologie();
    }

    public function getQuantityRessourcePlayer($id_Player, $id_Universe)
    {
        return $this->dbInterface->getQuantityRessourcePlayer($id_Player, $id_Universe);
    }

    public function getTechnologies($id_Labo)
    {
        return $this->dbInterface->getTechnologies($id_Labo);
    }

    public function upgradeTechnologie($id_Technologie)
    {
        $this->dbInterface->upgradeTechnologie($id_Technologie);
    }

    public function createTechnologie($id_Labo, $type)
    {
        return $this->dbInterface->createTechnologie($id_Labo, $type);
    }

    public function updateQuantityRessource($id_Ressource, $quantite)
    {
        $this->dbInterface->updateQuantityRessource($id_Ressource, $quantite);
    }

    public function getTechnoRequired()
    {
        return $this->dbInterface->getTechnoRequired();
    }
    
}