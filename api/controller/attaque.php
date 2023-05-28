<?php

require_once('../../boundary/DBinterface/DBattaque.php');

class Attaque{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBattaque();
    }

    public function getListeEnnemis($id_Joueur, $id_Univers){
        $listeEnnemis = $this->dbInterface->getListeEnnemis($id_Joueur, $id_Univers);
        return $listeEnnemis;
    }

    public function getDataEnnemis($listeEnnemis, $id_Univers){
        $dataEnnemis = $this->dbInterface->getDataEnnemis($listeEnnemis, $id_Univers);
        return $dataEnnemis;
    }
}
?>