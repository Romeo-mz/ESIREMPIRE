<?php

class AttackerPlanet {

    private $id_Attacker_Planet;
    private $id_Attacker_Player;
    private $fleet_Attacker;

    public function __construct($id_Attacker_Planet, $id_Attacker_Player, $fleet_Attacker)
    {
        $this->id_Attacker_Planet = $id_Attacker_Planet;
        $this->id_Attacker_Player = $id_Attacker_Player;
        $this->fleet_Attacker = $fleet_Attacker;
    }

    public function getFleet_Attacker() { return $this->fleet_Attacker; }

    public function getAttackPoints()
    {
        return $this->fleet_Attacker->getAttackPoints();
    }

    public function getDefensePoints()
    {
        return $this->fleet_Attacker->getDefensePoints();
    }

}