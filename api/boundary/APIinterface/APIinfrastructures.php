<?php

require_once('../../controller/infrastructures.php');

$controller_instance = new Infrastructures();
$api_infrastructures = new APIinfrastructures($controller_instance);
$api_infrastructures->handleRequest();

class APIinfrastructures
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
        if (isset($_GET['id_SolarSystem'])) 
        {
            $planets = $this->controller->getPlanets($_GET['id_SolarSystem']);
            $this->sendResponse(200, 'OK', json_encode($planets));
        }
        else if (isset($_GET['id_Galaxy'])) 
        {
            $sys_sols = $this->controller->getSystems($_GET['id_Galaxy']);
            $this->sendResponse(200, 'OK', json_encode($sys_sols));
        }
        else if (isset($_GET['id_Univers'])) 
        {
            $galaxies = $this->controller->getGalaxies($_GET['id_Univers']);
            $this->sendResponse(200, 'OK', json_encode($galaxies));
        } else 
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