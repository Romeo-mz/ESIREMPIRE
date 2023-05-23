<?php

require_once('../../boundary/DBinterface/DBvaisseau.php');

class Vaisseau{
    private $dbInterface;

    public function __construct(){
        $this->dbInterface = new DBvaisseau();
    }

    private function getSpaceworkID($id_Planet){
        return $this->dbInterface->getSpaceworkID($id_Planet);
    }

    public function getDefaultVaisseaux($id_Planet){
        $id_Spacework = $this->getSpaceworkID($id_Planet);
        return $this->dbInterface->getDefaultVaisseaux($id_Spacework);
    }



    // public function getAllVaisseauID($id_joueur, $id_univers){
    //     return $this->dbInterface->getAllVaisseauID($id_joueur, $id_univers);
    // }


    // public function getFlotte($id_Vaisseau){
    //     return $this->dbInterface->getFlotte($id_Vaisseau);
    // }

    // public function isFlotte($id_Vaisseau){
    //     return $this->dbInterface->isFlotte($id_Vaisseau);
    // }

    // public function addFlotte($id_Vaisseau, $id_Player){
    //     $this->dbInterface->addFlotte($id_Vaisseau, $id_Player);
    // }

    // public function removeFlotte($id_Vaisseau){
    //     $this->dbInterface->removeFlotte($id_Vaisseau);
    // }

    // public function getNbVaisseaux($id_Vaisseau){
    //     return $this->dbInterface->getNbVaisseaux($id_Vaisseau);
    // }

    // public function getNbVaisseauxFlotte($id_joueur){
    //     return $this->dbInterface->getNbVaisseauxFlotte($id_joueur);
    // }

    

}