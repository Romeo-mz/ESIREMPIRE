<?php

require_once('../../controller/galaxy.php');

$controller_instance = new Galaxy();
$api_galaxy = new APIgalaxy($controller_instance);
$api_galaxy->handleRequest();

class APIgalaxy
{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function handleRequest()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        switch ($requestMethod) {
            case 'GET':
                $this->handleGet();
                break;
            default:
                $this->sendResponse(405, 'Method Not Allowed');
                break;
        }
    }

    private function handleGet()
    {
        // if (isset($_GET['id_SolarSystem'])) 
        // {
        //     $planets = $this->controller->getPlanets($_GET['id_SolarSystem']);
        //     $this->sendResponse(200, 'OK', json_encode($planets));
        // }
        // else if (isset($_GET['id_Galaxy'])) 
        // {
        //     $sys_sols = $this->controller->getSystems($_GET['id_Galaxy']);
        //     $this->sendResponse(200, 'OK', json_encode($sys_sols));
        // }
        // else if (isset($_GET['id_Univers'])) 
        // {
        //     $galaxies = $this->controller->getGalaxies($_GET['id_Univers']);
        //     $this->sendResponse(200, 'OK', json_encode($galaxies));
        // }
         if (isset($_GET['id_Univers']) && isset($_GET['id_Galaxy']) && isset($_GET['id_SolarSystem'])) 
        {
            $galaxies = $this->controller->getGalaxiesList($_GET['id_Univers']);
            $sys_sols = $this->controller->getSystemsList($_GET['id_Galaxy']);
            $planets = $this->controller->getPlanets($_GET['id_SolarSystem']);

            $response = array(
                'galaxies' => $galaxies,
                'sys_sols' => $sys_sols,
                'planets' => $planets
            );

            $this->sendResponse(200, 'OK', json_encode($response));
        }
        else 
        {
            $this->sendResponse(400, 'Bad Request');
        }
    }

    private function sendResponse($statusCode, $statusText, $body = null)
    {
        header("HTTP/1.1 {$statusCode} {$statusText}");

        if ($body != null) {
            header("Content-Type: application/json");
            echo $body;
        }
        
        exit;
    }

}

?>