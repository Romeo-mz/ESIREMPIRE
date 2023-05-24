<?php

require_once('../../boundary/DBinterface/DBvaisseau.php');

class Vaisseau
{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBvaisseau();
    }

    private function getSpaceworkID($id_Planet)
    {
        return $this->dbInterface->getSpaceworkID($id_Planet);
    }

    public function getDefaultVaisseaux($id_Planet)
    {
        $id_Spacework = $this->getSpaceworkID($id_Planet);
        return $this->dbInterface->getDefaultVaisseaux($id_Spacework);
    }

    public function updateFlotteAttaque($idFlotte, $idJoueur, $idRapport, $idVaisseaux )
    {
        return $this->dbInterface->updateFlotteAttaque($idFlotte, $idJoueur, $idRapport, $idVaisseaux );
    }

    
}