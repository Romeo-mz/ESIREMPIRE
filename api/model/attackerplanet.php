<?php

class AttackerPlanet {

    private $idAttackerPlanet;
    private $idAttackerPlayer;
    private $fleetAttacker;

    public function __construct($idAttackerPlanet, $idAttackerPlayer, $fleetAttacker)
    {
        $this->idAttackerPlanet = $idAttackerPlanet;
        $this->idAttackerPlayer = $idAttackerPlayer;
        $this->fleetAttacker = $fleetAttacker;
    }

    public function getIdPlanet() { return $this->idAttackerPlanet; }
    public function getIdPlayer() { return $this->idAttackerPlayer; }

    public function getFleet_Attacker() { return $this->fleetAttacker; }

    public function getAttackPoints()
    {
        return $this->fleetAttacker->getAttackPoints();
    }

    public function getDefensePoints()
    {
        return $this->fleetAttacker->getDefensePoints();
    }

}