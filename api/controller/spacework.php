<?php

require_once('../../boundary/DBinterface/DBspacework.php');

class Spacework
{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBspacework();
    }
    
    public function getSpaceworkID($id_Planet)
    {
        return $this->dbInterface->getSpaceworkID($id_Planet);
    }

    public function getDefaultShips()
    {
        return $this->dbInterface->getDefaultShips();
    }

    public function getQuantityRessourcePlayer($id_Player, $id_Universe)
    {
        return $this->dbInterface->getQuantityRessourcePlayer($id_Player, $id_Universe);
    }

    public function getNbShips($id_Spacework)
    {
        return $this->dbInterface->getNbShips($id_Spacework);
    }

    public function getTechnologies($id_Planet)
    {
        return $this->dbInterface->getTechnologies($id_Planet);
    }

    public function addShip($id_Spacework, $type)
    {
        $this->dbInterface->addShip($id_Spacework, $type);
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