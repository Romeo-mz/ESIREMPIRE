<?php

class Ship {

    private $type;
    private $attackPoints;
    private $defensePoints;
    private $capacity;

    public function __construct($type, $attackPoints, $defensePoints, $capacity) {
        $this->type = $type;
        $this->attackPoints = $attackPoints;
        $this->defensePoints = $defensePoints;
        $this->capacity = $capacity;
    }

    public function getType() { return $this->type; }
    public function getAttackPoints() { return $this->attackPoints; }
    public function getDefensePoints() { return $this->defensePoints; }
    public function getCapacity() { return $this->capacity; }

    public function setType($type) { $this->type = $type; }
    public function setAttackPoints($attackPoints) { $this->attackPoints = $attackPoints; }
    public function setDefensePoints($defensePoints) { $this->defensePoints = $defensePoints; }
    public function setCapacity($capacity) { $this->capacity = $capacity; }
}