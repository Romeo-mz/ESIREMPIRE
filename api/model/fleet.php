<?php

class Fleet {

    private $ships;

    public function __construct($ships) {
        $this->ships = $ships;
    }

    public function getShips() { return $this->ships; }

    public function countShips($type)
    {
        $count = 0;
        foreach ($this->ships as $ship) {
            if ($ship->getType() == $type) {
                $count++;
            }
        }
        return $count;
    }

    public function hasColonizationShip() {
        foreach ($this->ships as $ship) {
            if ($ship->getType() == 'colonization') {
                return true;
            }
        }
        return false;
    }

    public function hasTransportShips() {
        foreach ($this->ships as $ship) {
            if ($ship->getType() == 'transport') {
                return true;
            }
        }
        return false;
    }

    public function getAttackPoints() {
        $attackPoints = 0;
        foreach ($this->ships as $ship) {
            $attackPoints += $ship->getAttackPoints();
        }
        return $attackPoints;
    }

    public function getDefensePoints() {
        $defensePoints = 0;
        foreach ($this->ships as $ship) {
            $defensePoints += $ship->getDefensePoints();
        }
        return $defensePoints;
    }

}