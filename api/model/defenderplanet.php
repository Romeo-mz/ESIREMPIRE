<?php

class DefenderPlanet {

    private $fleet_Defender;
    private $infraDefensePoints;
    private $infraAttackPoints;

    public function __construct($fleet_Defender, $infraDefensePoints, $infraAttackPoints)
    {
        $this->fleet_Defender = $fleet_Defender;
        $this->infraDefensePoints = $infraDefensePoints;
        $this->infraAttackPoints = $infraAttackPoints;
    }

    public function getFleet_Defender() { return $this->fleet_Defender; }
    public function getInfraDefensePoints() { return $this->infraDefensePoints; }
    public function getInfraAttackPoints() { return $this->infraAttackPoints; }

    public function getAttackPoints()
    {
        $attacksPoints = $this->infraAttackPoints;

        foreach ($this->fleet_Defender->getShips() as $ship) {
            $attacksPoints += $ship->getAttackPoints();
        }

        return $attacksPoints;
    }

    public function getDefensePoints()
    {
        $defensesPoints = $this->infraDefensePoints;

        foreach ($this->fleet_Defender->getShips() as $ship) {
            $defensesPoints += $ship->getDefensePoints();
        }

        return $defensesPoints;
    }

}