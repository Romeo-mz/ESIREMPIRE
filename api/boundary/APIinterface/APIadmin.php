<?php

require_once('../../controller/administration.php');

class APIadmin
{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
        $this->request();
    }

    private function request()
    {

        // récuperer verbe
        $request_method = $_SERVER['REQUEST_METHOD'];

        // Traitement verbe
        switch ($request_method) {
            case 'POST':

                if (isset($_POST['universe_name'])) {

                    if($_POST['universe_name'] != "")
                        $universe_name = $_POST['universe_name'];
                    else 
                        $universe_name = "Univers " .  $this->controller->getLastUniverseId() + 1;

                    // Create Universe
                    $UniverseResult = $this->controller->createUniverse($universe_name);

                    // Create 5 Galaxies for the Universe
                    $UniverseId = $this->controller->getLastUniverseId();
                    $GalaxiesResult = $this->controller->createGalaxies($UniverseId);

                    // Create 10 Solar Systems for each Galaxy
                    $GalaxiesId = $this->controller->getLast5GalaxiesId();
                    $SolarSystemsResult = $this->controller->createSolarSystems($GalaxiesId);

                    // Create randomly between 4 and 10 Planets for each Solar System
                    $SolarSystemsId = $this->controller->getLast50SolarSystemsId();
                    $PlanetsResult = $this->controller->createPlanets($SolarSystemsId);

                    if($UniverseResult && $GalaxiesResult && $SolarSystemsResult)
                        echo "Universe, Galaxies, Solar Systems and Planets created";
                    else
                        echo "Error while creating Universe, Galaxies, Solar Systems and Planets";

                } else
                    echo "bad request";

                break;

            case 'GET':

                //Then, call controller method

                break;
            
            default:
                echo "Bad URL";
                break;
            }
    }
}

?>