<?php

require_once('../../controller/galaxy.php');

$controller_instance = new Galaxy();
$api_galaxy = new APIgalaxy($controller_instance);
$api_galaxy->handleRequest();
/**
 * Class APIgalaxy
 * This class is the API for the admin page.
 * It handles the POST and GET requests.
 */
class APIgalaxy
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
            case 'GET':
                $this->handleGet();
                break;
            default:
                $this->handlePost();
                break;
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
    /**
     * This function handles the POST request.
     * It checks if the request is valid and calls the appropriate function.
     * If the request is not valid, it sends a 400 response.
     * 
     * @return void
     */
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
    /**
     * This function sends a response with the given status code and status text.
     * If a body is given, it is also sent.
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
        
        exit;
    }

}

?>