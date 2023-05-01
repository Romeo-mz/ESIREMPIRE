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

                    $result = $this->controller->createUniverse($universe_name);

                    if($result)
                        echo "Universe created";
                    else
                        echo "Error while creating universe";

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