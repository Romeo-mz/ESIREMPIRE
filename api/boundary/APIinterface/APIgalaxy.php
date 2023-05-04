<?php

require_once('../../controller/galaxy.php');

class APIgalaxy
{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
        $this->handleRequest();
    }

    private function handleRequest()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        switch ($requestMethod) {
            case 'POST':
                $this->handlePost();
                break;
            case 'GET':
                $this->handleGet();
                break;
            default:
                $this->sendResponse(405, 'Method Not Allowed');
                break;
        }
    }

    private function handlePost()
    {
        // if (!isset($_POST['id_Univers']) || !isset($_POST['galaxyName']) || !isset($_POST['solarSystemName'])) {
        //     $this->sendResponse(400, 'Bad Request');
        //     return;
        // }

        // $id_Univers = $_POST['id_Univers'];
        // $galaxyName = $_POST['galaxyName'];
        // $solarSystemName = $_POST['solarSystemName'];

        // $getGalaxiesResult = $this->controller->getGalaxies($id_Univers, $galaxyName, $solarSystemName);

        // if ($universeResult && $galaxiesResult && $solarSystemsResult && $planetsResult) {
        //     $this->sendResponse(201, 'Universe Created');
        // } else {
        //     $this->sendResponse(500, 'Internal Server Error');
        // }
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
        // if ($statusCode >= 200 && $statusCode < 300) {
        //     echo "<script>window.location.href = 'http://localhost:5550/ESIREMPIRE/front/admin.php?success=1&message=" . urlencode($statusText) . "';</script>";
        // } else {
        //     echo "<script>window.location.href = 'http://localhost:5550/ESIREMPIRE/front/admin.php?success=0&message=" . urlencode($statusText) . "';</script>";
        // }
        exit;
    }

}

?>