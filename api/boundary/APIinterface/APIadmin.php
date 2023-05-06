<?php

require_once('../../controller/administration.php');

$controller_instance = new Administration();
$api_admin = new APIadmin($controller_instance);
$api_admin->handleRequest();

class APIadmin
{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
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
        if (!isset($_POST['universe_name'])) {
            $this->sendResponse(400, 'Bad Request');
            return;
        }

        $universeName = $_POST['universe_name'] ?: "Univers " . ($this->controller->getLastUniverseId() + 1);

        $universeResult = $this->controller->createUniverse($universeName);
        $galaxiesResult = $this->controller->createGalaxies();
        $solarSystemsResult = $this->controller->createSolarSystems();
        $planetsResult = $this->controller->createPlanets();

        if ($universeResult && $galaxiesResult && $solarSystemsResult && $planetsResult) {
            $this->sendResponse(201, 'Universe Created');
        } else {
            $this->sendResponse(500, 'Internal Server Error');
        }
    }

    private function handleGet()
    {
        if (isset($_GET['universes'])) {
            $universes = $this->controller->getUniverses();
            $this->sendResponse(200, 'OK', json_encode($universes));
        } else {
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
        else if ($statusCode >= 200 && $statusCode < 300) {
            echo "<script>window.location.href = 'http://localhost:5550/ESIREMPIRE/front/admin.php?success=1&message=" . urlencode($statusText) . "';</script>";
        } else {
            echo "<script>window.location.href = 'http://localhost:5550/ESIREMPIRE/front/admin.php?success=0&message=" . urlencode($statusText) . "';</script>";
        }
        exit;
    }

}

?>