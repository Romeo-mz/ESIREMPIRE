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
                $this->handlePost();
                break;
        }
    }

    private function handleGet()
    {
        if (isset($_GET['planets']) && isset($_GET['id_Universe']) && isset($_GET['id_Galaxy']) && isset($_GET['id_SolarSystem'])) 
        {
            $response = $this->controller->getPlanets($_GET['id_Universe'], $_GET['id_Galaxy'], $_GET['id_SolarSystem']);
            $this->sendResponse(200, 'OK', json_encode($response));
        }
        if (isset($_GET['get_planet_name']) && isset($_GET['id_planet'])) 
        {
            $response = $this->controller->getPlanetName($_GET['id_planet']);
            $this->sendResponse(200, 'OK', json_encode($response));
        }
        else 
        {
            $this->sendResponse(400, 'Bad Request');
        }
    }

    private function handlePost()
    {
        // decode json post data
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['id_Planet']) && isset($data['new_planet_name'])) 
        {
            $this->controller->renamePlanet($data['id_Planet'], $data['new_planet_name']);
            $this->sendResponse(200, 'OK');
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