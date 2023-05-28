<?php

require_once('../../boundary/DBinterface/DBattaque.php');
require_once('../../model/ship.php');
require_once('../../model/fleet.php');

class Attaque{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBattaque();
    }

    private function createAttackerFleet($fleet_Attacker_Composition)
    {
        $shipsPoint = $this->dbInterface->getShipsPoint();
        $ships = array();

        for ($i = 0; $i < count($fleet_Attacker_Composition); $i++) {
            $quantity = $fleet_Attacker_Composition[$i]['quantity'];
            $type = $fleet_Attacker_Composition[$i]['type'];
            $point_attaque = $shipsPoint[$i]['point_attaque'];
            $point_defense = $shipsPoint[$i]['point_defense'];
            $capacite_fret = $shipsPoint[$i]['capacite_fret'];

            for ($j = 0; $j < $quantity; $j++) {
                $ships[] = new Ship($type, $point_attaque, $point_defense, $capacite_fret);
            }
        }

        // Create a fleet with the ships
        $fleet = new Fleet($ships);

        var_dump($fleet);
    }

    private function createDefenderFleet($id_Defender_Player, $id_Defender_Planet)
    {
        $shipsPoint = $this->dbInterface->getShipsPoint();
        $fleet_Defender_Composition = $this->dbInterface->getFleet($id_Defender_Player, $id_Defender_Planet);

        // var_dump($shipsPoint);
        // var_dump($fleet_Defender_Composition);

        $ships = array();

        for ($i = 0; $i < count($fleet_Defender_Composition); $i++) {
            $quantity = $fleet_Defender_Composition[$i]['quantity'];
            $type = $fleet_Defender_Composition[$i]['type'];
            $point_attaque = $shipsPoint[$i]['point_attaque'];
            $point_defense = $shipsPoint[$i]['point_defense'];
            $capacite_fret = $shipsPoint[$i]['capacite_fret'];

            for ($j = 0; $j < $quantity; $j++) {
                $ships[] = new Ship($type, $point_attaque, $point_defense, $capacite_fret);
            }
        }

        // Create a fleet with the ships
        $fleet = new Fleet($ships);

    }

    private function createFleets($fleet_Attacker_Composition, $id_Defender_Player, $id_Defender_Planet) 
    {
        $this->createAttackerFleet($fleet_Attacker_Composition);
        $this->createDefenderFleet($id_Defender_Player, $id_Defender_Planet);
    }

    public function attack($id_Attacker_Player, $id_Defender_Player, $id_Attacker_Planet, $id_Defender_Planet, $fleet_Attacker_Composition)
    {
       $this->createFleets($fleet_Attacker_Composition, $id_Defender_Player, $id_Defender_Planet);

        // Get attacker fleet
        // $attackerFleet = $this->dbInterface->getFleet($id_Attacker_Player, $id_Attacker_Planet, $fleet_Attacker);

        // // Get defender planet
        // $defenderPlanet = $this->dbInterface->getPlanet($id_Defender_Player, $id_Defender_Planet);

        // // Start attack
        // $combatReport = $this->startAttack($attackerFleet, $defenderPlanet);

        // // Return combat report
        // return $combatReport;

    }

    private function startAttack($attackerFleet, $defenderPlanet) {
        // Calculate attack and defense points
        $attackerAttackPoints = $attackerFleet->getAttackPoints();
        $attackerDefensePoints = $attackerFleet->getDefensePoints();
        
        $defenderAttackPoints = $defenderPlanet->getAttackPoints();
        $defenderDefensePoints = $defenderPlanet->getDefensePoints();
        
        // Determine victory conditions
        $result = $this->determineVictory(
            $attackerAttackPoints, $attackerDefensePoints,
            $defenderAttackPoints, $defenderDefensePoints
        );
        
        // Calculate damage
        $damage = $this->calculateDamage(
            $attackerAttackPoints, $attackerDefensePoints,
            $defenderAttackPoints, $defenderDefensePoints
        );
        
        // Apply damage and update game state
        $rewards = $this->applyDamage($result, $damage, $attackerFleet, $defenderPlanet);
        
        // Generate combat report
        $combatReport = $this->generateCombatReport($result, $damage, $rewards, $attackerFleet, $defenderPlanet);
        
        // Return combat report
        return $combatReport;
    }

    private function determineVictory($attackerAttackPoints, $attackerDefensePoints, $defenderAttackPoints, $defenderDefensePoints) {
        if ($defenderAttackPoints > $attackerDefensePoints) {
            return 'defender';
        } elseif ($attackerAttackPoints > $defenderDefensePoints) {
            return 'attacker';
        } else {
            return 'draw';
        }
    }

    private function calculateDamage($attackerAttackPoints, $attackerDefensePoints, $defenderAttackPoints, $defenderDefensePoints) {
        $attackRatio = $attackerAttackPoints / $defenderDefensePoints;
        $defenseRatio = $defenderAttackPoints / $attackerDefensePoints;

        return [
            'attackRatio' => $attackRatio,
            'defenseRatio' => $defenseRatio,
        ];
    }

    private function applyDamage($result, $damage, $attackerFleet, $defenderPlanet) {
        // Apply damage to defense systems and ships
        $defenderPlanet->applyDefenseSystemDamage($damage['attackRatio']);
        $attackerFleet->applyShipDamage($damage['defenseRatio']);

        // Calculate rewards and update game state based on the result
        if ($result === 'defender') {
            $rewards = $attackerFleet->getDestroyedShipResources();
            $defenderPlanet->addResources($rewards);
        } elseif ($result === 'attacker') {
            $rewards = $this->handleAttackerVictory($attackerFleet, $defenderPlanet);
        } else {
            // In case of a draw, no rewards
            $rewards = [];
        }

        // Save changes to attacker fleet and defender planet
        $attackerFleet->save();
        $defenderPlanet->save();

        return $rewards;
    }

    private function handleAttackerVictory($attackerFleet, $defenderPlanet) {
        if ($attackerFleet->hasColonizationShip()) {
            // Colonize planet
            $defenderPlanet->colonize($attackerFleet->getOwner());
            return [];
        } elseif ($attackerFleet->hasTransportShips()) {
            // Loot resources
            $lootCapacity = $attackerFleet->getTransportCapacity();
            $lootedResources = $defenderPlanet->lootResources($lootCapacity);
            $attackerFleet->getOwner()->addResources($lootedResources);
            return $lootedResources;
        } else {
            return [];
        }
    }

    private function generateCombatReport($result, $damage, $rewards, $attackerFleet, $defenderPlanet) {
        $report = [
            'date' => date('Y-m-d H:i:s'),
            'result' => $result,
            'ships' => [
                'attacker' => $attackerFleet->getShips(),
                'defender' => $defenderPlanet->getOrbitingShips(),
            ],
            'defenseSystems' => $defenderPlanet->getDefenseSystems(),
            'damage' => $damage,
            'rewards' => $rewards,
        ];

        // Save combat report for both attacker anddefender
        $attackerFleet->getOwner()->addCombatReport($report);
        $defenderPlanet->getOwner()->addCombatReport($report);

        return $report;
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