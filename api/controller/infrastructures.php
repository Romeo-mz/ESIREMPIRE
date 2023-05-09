<?php

require_once('../../boundary/DBinterface/DBinfrastructures.php');

class Infrastructures
{
    private $dbInterface;

    public function __construct()
    {
        $this->dbInterface = new DBinfrastructures();
    }
    
    public function getInfrastructures($id_Planet)
    {
        $result = $this->dbInterface->getInfrastructuresByPlanetId($id_Planet);

        // Check each infrastructure if it is not in $result, if not add it to the $result
        $infrastructures = $this->dbInterface->getInfrastructures();
        foreach ($infrastructures as $infrastructure) {
            $found = false;
            foreach ($result as $res) {
                if ($res['id_Infrastructure'] == $infrastructure['id_Infrastructure']) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $infrastructure['level'] = 0;
                $result[] = $infrastructure;
            }
        }

    }

}