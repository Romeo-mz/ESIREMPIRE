<?php

require_once('../../boundary/DBinterface/DBvaisseau.php');

class Vaisseau{
    private $dbInterface;

    public function __construct(){
        $this->dbInterface = new DBvaisseau();
    }

    public function getVaisseauID($id_Planet){
        return $this->dbInterface->getVaisseauID($id_Planet);
    }

    public function getFlotte($id_Vaisseau){
        return $this->dbInterface->getFlotte($id_Vaisseau);
    }

    public function isFlotte($id_Vaisseau){
        return $this->dbInterface->isFlotte($id_Vaisseau);
    }

    public function addFlotte($id_Vaisseau, $id_Player){
        $this->dbInterface->addFlotte($id_Vaisseau, $id_Player);
    }

    public function removeFlotte($id_Vaisseau){
        $this->dbInterface->removeFlotte($id_Vaisseau);
    }

    public function getNbVaisseaux($id_Vaisseau){
        return $this->dbInterface->getNbVaisseaux($id_Vaisseau);
    }

    public function getNbVaisseauxFlotte($id_joueur){
        return $this->dbInterface->getNbVaisseauxFlotte($id_joueur);
    }
}