<?php

require_once('../../controller/administration.php');

$controller_instance = new Administration();
$api_admin = new APIadmin($controller_instance);
$api_admin->handleRequest();

/**
 * Class APIadmin
 * This class is the API for the admin page.
 * It handles the POST and GET requests.
 */
class APIadmin
{
    private $controller;
    /**
     * APIadmin constructor.
     * @param $controller
     */
    public function __construct($controller)
    {
        $this->controller = $controller;
    }
    /**
     * This function handles the request.
     * It checks the request method and calls the appropriate function.
     * If the request method is not supported, it sends a 405 response.
     * 
     * @return void
     */
    public function handleRequest()
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
    /**
     * This function handles the POST request.
     * It checks if the request is valid and calls the appropriate function.
     * If the request is not valid, it sends a 400 response.
     * 
     * @return void
     */
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
    /**
     * This function handles the GET request.
     * It checks if the request is valid and calls the appropriate function.
     * If the request is not valid, it sends a 400 response.
     * 
     * @return void
     */
    private function handleGet()
    {
        if (isset($_GET['universes'])) {
            $universes = $this->controller->getUniverses();
            $this->sendResponse(200, 'OK', json_encode($universes));
        } else {
            $this->sendResponse(400, 'Bad Request');
        }
    }
    /**
     * This function sends the response to the client.
     * 
     * @param int $statusCode
     * @param string $statusText
     * @param string $body
     * @return void
     */
    private function sendResponse($statusCode, $statusText, $body = null)
    {
        header("HTTP/1.1 {$statusCode} {$statusText}");

        if ($body != null) {
            header("Content-Type: application/json");
            echo $body;
        }
        else if ($statusCode >= 200 && $statusCode < 300) {
            echo "<script>window.location.href = '../../../front/admin.php?success=1&message=" . urlencode($statusText) . "';</script>";
        } else {
            echo "<script>window.location.href = '../../../front/admin.php?success=0&message=" . urlencode($statusText) . "';</script>";
        }
        exit;
    }

}

?>