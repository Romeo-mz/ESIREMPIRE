<?php

require_once('../../boundary/DBinterface/DBattaque.php');
require_once('../../model/ship.php');
require_once('../../model/fleet.php');
require_once('../../model/defenderplanet.php');
require_once('../../model/attackerplanet.php');

/**
 * Class Attaque
 * This class is the controller for the attack page.
 * It handles the attack of the game.
 */
class Attaque{
    private $dbInterface;

    // private $fleet_Attacker;
    // private $fleet_Defender;
    /**
     * Attaque constructor.
     */
    public function __construct()
    {
        $this->dbInterface = new DBattaque();
    }
    /**
     * this create a fleet with the ships
     * 
     * @return array the result of the database operation
     */
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
    }
    /**
     * this create a defender fleet with the ships
     * @param int $id_Defender_Player
     * @param int $id_Defender_Planet
     * @return array the result of the database operation
     */
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
    }
    /**
     * this function create a fleet for the attacker and the defender
     * 
     * @param array $fleet_Attacker_Composition
     * @param int $id_Defender_Player
     * @param int $id_Defender_Planet
     * 
     * @return array the result of the database operation
     */
    private function createFleets($fleet_Attacker_Composition, $id_Defender_Player, $id_Defender_Planet) 
    {
        $attackerFleet =  $this->createAttackerFleet($fleet_Attacker_Composition);
        $defenderFleet = $this->createDefenderFleet($id_Defender_Player, $id_Defender_Planet);

        return array($attackerFleet, $defenderFleet);
    }
    /**
     * this function create a defender planet
     * 
     * @param int $id_Defender_Player
     * @param int $id_Defender_Planet
     * @param array $fleet_Defender
     * 
     * @return array the result of the database operation
     */
     
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
    /**
     * This function setup the attack
     * 
     * @param int $id_Attacker_Player
     * @param int $id_Defender_Player
     * @param int $id_Attacker_Planet
     * @param int $id_Defender_Planet
     * @param array $fleet_Attacker_Composition
     * 
     * @return array the result of the database operation
     */
    public function attack($id_Attacker_Player, $id_Defender_Player, $id_Attacker_Planet, $id_Defender_Planet, $fleet_Attacker_Composition)
    {
       $fleets = $this->createFleets($fleet_Attacker_Composition, $id_Defender_Player, $id_Defender_Planet);
       $attackerPlanet = new AttackerPlanet($id_Attacker_Planet, $id_Attacker_Player, $fleets[0]);
       $defenderPlanet = $this->createDefenderPlanet($id_Defender_Player, $id_Defender_Planet, $fleets[1]);

        // Start attack
        $combatReport = $this->startAttack($attackerPlanet, $defenderPlanet);

        // Add combat report to DB

    }
    /**
     * This function start the attack
     * 
     * @param int $id_Attacker_Player
     * @param int $id_Defender_Player
     * @param int $id_Attacker_Planet
     * @param int $id_Defender_Planet
     * @param array $fleet_Attacker_Composition
     * 
     * @return array the result of the database operation
     */
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
    /**
     * This function determine the victory
     * 
     * @param int $attackerAttackPoints
     * @param int $attackerDefensePoints
     * @param int $defenderAttackPoints
     * @param int $defenderDefensePoints
     * 
     * @return array the result of the database operation
     */
    private function determineVictory($attackerAttackPoints, $attackerDefensePoints, $defenderAttackPoints, $defenderDefensePoints) {
        if ($defenderAttackPoints > $attackerDefensePoints) {
            return 'defenseur';
        } elseif ($attackerAttackPoints > $defenderDefensePoints) {
            return 'attaquant';
        } else {
            return 'egalite';
        }
    }
    /**
     * This function calculate the damage
     * 
     * @param int $attackerAttackPoints
     * @param int $attackerDefensePoints
     * @param int $defenderAttackPoints
     * @param int $defenderDefensePoints
     * 
     * @return array the result of the database operation
     */
    private function calculateDamage($attackerAttackPoints, $attackerDefensePoints, $defenderAttackPoints, $defenderDefensePoints) {
        $attackRatio = $attackerAttackPoints / $defenderDefensePoints;
        $defenseRatio = $defenderAttackPoints / $attackerDefensePoints;

        return [
            'attackRatio' => $attackRatio,
            'defenseRatio' => $defenseRatio,
        ];
    }
    /**
     * This function apply the damage
     * 
     * @param int $result
     * @param int $damage
     * @param object $attackerPlanet
     * @param object $defenderPlanet
     * 
     * @return array the result of the database operation
     */
    private function applyDamage($result, $damage, $attackerPlanet, $defenderPlanet) {
        // Apply damage to defense systems and ships
        $this->applyDefenseSystemDamage($damage['attackRatio'], $defenderPlanet->getIdPlanet());
        $this->applyShipDamage($damage['defenseRatio'], $attackerPlanet->getIdPlanet());

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

    private function applyShipDamage($defenseRatio, $idAttackerPlanet) {
        if ($defenseRatio > 1) {
            // All ships are destroyed
            $this->dbInterface->destroyAllShips($idAttackerPlanet);
        } else {
            // Destroy randomly ships
            var_dump("randomly destroy ships");
            // $ships = $this->dbInterface->getShips($idAttackerPlanet);
            // $shipsCount = count($ships);
            // $shipsToDestroy = max(1, min($shipsCount, round($shipsCount * $defenseRatio)));

            // $shipsToDestroyKeys = array_rand($ships, $shipsToDestroy);
            // if (!is_array($shipsToDestroyKeys)) {
            //     $shipsToDestroyKeys = [$shipsToDestroyKeys];
            // }

            // foreach ($shipsToDestroyKeys as $key) {
            //     $this->dbInterface->destroyShip($ships[$key]['ship_id']);
            // }
        }
    }

    private function applyDefenseSystemDamage($attackRatio, $idDefenderPlanet) {
        
        if ($attackRatio > 1) {
            // Defense systems are all destroyed
            $this->dbInterface->destroyAllDefenseSystems($idDefenderPlanet);
        } else {
            // Destroy randomly defense systems
            $defenseSystems = $this->dbInterface->getDefenseSystems($idDefenderPlanet);
            $defenseSystemsCount = count($defenseSystems);
            $defenseSystemsToDestroy = max(1, min($defenseSystemsCount, round($defenseSystemsCount * $attackRatio)));

            $defenseSystemsToDestroyKeys = array_rand($defenseSystems, $defenseSystemsToDestroy);
            if (!is_array($defenseSystemsToDestroyKeys)) {
                $defenseSystemsToDestroyKeys = [$defenseSystemsToDestroyKeys];
            }

            foreach ($defenseSystemsToDestroyKeys as $key) {
                $this->dbInterface->destroyDefenseSystem($defenseSystems[$key]['infrastructure_id']);
}
        }

    }
    /**
     * This function handle the attacker victory
     * 
     * @param object $attackerPlanet
     * @param object $defenderPlanet
     * 
     * @return array the result of the database operation
     */

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
    /**
     * This function generate the combat report
     * 
     * @param int $result
     * @param int $damage
     * @param object $attackerPlanet
     * @param object $defenderPlanet
     * 
     * @return array the result of the database operation
     */
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