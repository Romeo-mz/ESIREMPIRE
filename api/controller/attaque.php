<?php

require_once('../../boundary/DBinterface/DBattaque.php');
require_once('../../model/ship.php');
require_once('../../model/fleet.php');
require_once('../../model/defenderplanet.php');
require_once('../../model/attackerplanet.php');

class Attaque{
    private $dbInterface;

    // private $fleet_Attacker;
    // private $fleet_Defender;

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
        return new Fleet($ships);

        // var_dump($this->fleet_Attacker);
    }

    private function createDefenderFleet($id_Defender_Player, $id_Defender_Planet)
    {
        $shipsPoint = $this->dbInterface->getShipsPoint();
        $fleet_Defender_Composition = $this->dbInterface->getFleet($id_Defender_Player, $id_Defender_Planet);

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
        return new Fleet($ships);

        // var_dump($this->fleet_Defender);

    }

    private function createFleets($fleet_Attacker_Composition, $id_Defender_Player, $id_Defender_Planet) 
    {
        $attackerFleet =  $this->createAttackerFleet($fleet_Attacker_Composition);
        $defenderFleet = $this->createDefenderFleet($id_Defender_Player, $id_Defender_Planet);

        return array($attackerFleet, $defenderFleet);
    }

    private function createDefenderPlanet($id_Defender_Player, $id_Defender_Planet, $fleet_Defender)
    {

        $infra = $this->dbInterface->getInfrastructuresPoints($id_Defender_Planet);

        $defensePoints = 0;
        $attackPoints = 0;

        foreach($infra as $infrastructure){
            $defensePoints += $infrastructure['defense_point_defense'];
            $attackPoints += $infrastructure['defense_point_attaque'];
        }

        return new DefenderPlanet($id_Defender_Planet, $id_Defender_Player, $fleet_Defender, $defensePoints, $attackPoints);
    }

    public function attack($id_Attacker_Player, $id_Defender_Player, $id_Attacker_Planet, $id_Defender_Planet, $fleet_Attacker_Composition)
    {
       $fleets = $this->createFleets($fleet_Attacker_Composition, $id_Defender_Player, $id_Defender_Planet);
       $attackerPlanet = new AttackerPlanet($id_Attacker_Planet, $id_Attacker_Player, $fleets[0]);
       $defenderPlanet = $this->createDefenderPlanet($id_Defender_Player, $id_Defender_Planet, $fleets[1]);


        // Start attack
        $combatReport = $this->startAttack($attackerPlanet, $defenderPlanet);

        // // Return combat report
        // return $combatReport;

    }

    private function startAttack($attackerPlanet, $defenderPlanet) {
        // Calculate attack and defense points
        $attackerAttackPoints = $attackerPlanet->getAttackPoints();
        $attackerDefensePoints = $attackerPlanet->getDefensePoints();
        
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

        var_dump($damage);
        
        // Apply damage and update game state
        $rewards = $this->applyDamage($result, $damage, $attackerPlanet, $defenderPlanet);
        
        // // Generate combat report
        // $combatReport = $this->generateCombatReport($result, $damage, $rewards, $attackerPlanet, $defenderPlanet);
        
        // Return combat report
        // return $combatReport;
    }

    private function determineVictory($attackerAttackPoints, $attackerDefensePoints, $defenderAttackPoints, $defenderDefensePoints) {
        if ($defenderAttackPoints > $attackerDefensePoints) {
            return 'defenseur';
        } elseif ($attackerAttackPoints > $defenderDefensePoints) {
            return 'attaquant';
        } else {
            return 'egalite';
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

    private function applyDamage($result, $damage, $attackerPlanet, $defenderPlanet) {
        // Apply damage to defense systems and ships
        $this->applyDefenseSystemDamage($damage['attackRatio']);
        // $this->applyShipDamage($damage['defenseRatio']);

        // // Calculate rewards and update game state based on the result
        // if ($result === 'defenseur') {
        //     $rewards = $attackerPlanet->getDestroyedShipResources();
        //     $defenderPlanet->addResources($rewards);
        // } elseif ($result === 'attaquant') {
        //     $rewards = $this->handleAttackerVictory($attackerPlanet, $defenderPlanet);
        // } else {
        //     // In case of a draw, no rewards
        //     $rewards = [];
        // }

        // // Save changes to attacker fleet and defender planet
        // $attackerPlanet->save();
        // $defenderPlanet->save();

        // return $rewards;
    }

    private function applyDefenseSystemDamage($attackRatio) {
        
        if ($attackRatio > 1) {
            // Defense systems are destroyed
            $this->dbInterface->destroyAllDefenseSystems();
        } else {
            // Defense systems are damaged
            // foreach ($this->defenseSystems as $defenseSystem) {
            //     $defenseSystem->applyDamage($attackRatio);
            // }
        }

    }

    private function handleAttackerVictory($attackerPlanet, $defenderPlanet) {
        if ($attackerPlanet->hasColonizationShip()) {
            // Colonize planet
            $defenderPlanet->colonize($attackerPlanet->getOwner());
            return [];
        } elseif ($attackerPlanet->hasTransportShips()) {
            // Loot resources
            $lootCapacity = $attackerPlanet->getTransportCapacity();
            $lootedResources = $defenderPlanet->lootResources($lootCapacity);
            $attackerPlanet->getOwner()->addResources($lootedResources);
            return $lootedResources;
        } else {
            return [];
        }
    }

    private function generateCombatReport($result, $damage, $rewards, $attackerPlanet, $defenderPlanet) {
        $report = [
            'date' => date('Y-m-d H:i:s'),
            'result' => $result,
            'ships' => [
                'attacker' => $attackerPlanet->getShips(),
                'defender' => $defenderPlanet->getOrbitingShips(),
            ],
            'defenseSystems' => $defenderPlanet->getDefenseSystems(),
            'damage' => $damage,
            'rewards' => $rewards,
        ];

        // Save combat report for both attacker anddefender
        $attackerPlanet->getOwner()->addCombatReport($report);
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