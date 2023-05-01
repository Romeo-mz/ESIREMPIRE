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
                    $GalaxiesResult = $this->controller->createGalaxies();

                    // Create 10 Solar Systems for each Galaxy
                    $SolarSystemsResult = $this->controller->createSolarSystems();

                    // Create randomly between 4 and 10 Planets for each Solar System
                    $PlanetsResult = $this->controller->createPlanets();

                    if($UniverseResult && $GalaxiesResult && $SolarSystemsResult && $PlanetsResult)
                        header("Location: ../../../front/admin.php?success=1");
                    else
                        header("Location: ../../../front/admin.php?success=0");

                } else
                    header("Location: ../../../front/admin.php?success=0");
                break;

            case 'GET':

                if(isset($_GET['universes']))
                    echo json_encode($this->controller->getUniverses());
                
                break;
            
            default:
                echo "Bad URL";
                break;
            }
    }
}

?>