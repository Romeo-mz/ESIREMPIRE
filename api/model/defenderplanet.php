<?php

class DefenderPlanet {

    private $idDefenderPlanet;
    private $idDefenderPlayer;
    private $fleetDefender;
    private $infraDefensePoints;
    private $infraAttackPoints;

    public function __construct($idDefenderPlanet, $idDefenderPlayer, $fleetDefender, $infraDefensePoints, $infraAttackPoints)
    {
        $this->idDefenderPlanet = $idDefenderPlanet;
        $this->idDefenderPlayer = $idDefenderPlayer;
        $this->fleetDefender = $fleetDefender;
        $this->infraDefensePoints = $infraDefensePoints;
        $this->infraAttackPoints = $infraAttackPoints;
    }

    public function getIdPlanet() { return $this->idDefenderPlanet; }
    public function getFleetDefender() { return $this->fleetDefender; }
    public function getInfraDefensePoints() { return $this->infraDefensePoints; }
    public function getInfraAttackPoints() { return $this->infraAttackPoints; }

    public function getAttackPoints()
    {
        $attacksPoints = $this->infraAttackPoints;

        foreach ($this->fleetDefender->getShips() as $ship) {
            $attacksPoints += $ship->getAttackPoints();
        }

        return $attacksPoints;
    }

    public function getDefensePoints()
    {
        $defensesPoints = $this->infraDefensePoints;

        foreach ($this->fleetDefender->getShips() as $ship) {
            $defensesPoints += $ship->getDefensePoints();
        }

        return $defensesPoints;
    }

}