<?php

require_once('../../controller/attaque.php');

// $data = json_decode(file_get_contents('php://input'), true);

// var_dump($data);

// var_dump($data['id_Attacker_Player']);
// var_dump($data['id_Defender_Player']);
// var_dump($data['id_Attacker_Planet']);
// var_dump($data['id_Defender_Planet']);
// var_dump($data['fleet_Attacker']);

$controller_instance = new Attaque();
$api_attaque = new APIattaque($controller_instance);
$api_attaque->handleRequest();
/**
 * Class APIattaque
 * This class is the API for the admin page.
 * It handles the POST and GET requests.
 */
class APIattaque
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

            case 'POST':
                $this->handlePost();
                break;
            default:
                $this->sendResponse(405, 'Method Not Allowed');
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
    public function handleGet()
    {
        if (isset($_GET['default_ennemis']) && isset($_GET['id_Joueur']) && isset($_GET['id_Univers'])) {
            $listeEnnemis = $this->controller->getListeEnnemis($_GET['id_Joueur'], $_GET['id_Univers']);
            $this->sendResponse(200, 'OK', json_encode($listeEnnemis));
            exit; // Add this line to stop execution after sending the response
        } 
        else if (isset($_GET['dataEnnemis']) && isset($_GET['liste_Ennemis']) && isset($_GET['id_Univers'])) {
            $dataEnnemis = $this->controller->getDataEnnemis($_GET['liste_Ennemis'], $_GET['id_Univers']);
            $this->sendResponse(200, 'OK', json_encode($dataEnnemis));
            exit;
        } else {
            $this->sendResponse(400, 'Bad Request', 'Missing parameter');
        }
    }

    /**
     * This function handles the POST request.
     * It checks if the request is valid and calls the appropriate function.
     * If the request is not valid, it sends a 400 response.
     * 
     * @return void
     */
    public function handlePost()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Start attack
        if (isset($data['id_Attacker_Player']) && isset($data['id_Defender_Player']) && isset($data['id_Attacker_Planet']) && isset($data['id_Defender_Planet']) && isset($data['fleet_Attacker'])) 
        {
            $this->controller->attack($data['id_Attacker_Player'], $data['id_Defender_Player'], $data['id_Attacker_Planet'], $data['id_Defender_Planet'], $data['fleet_Attacker']);
            $this->sendResponse(200, 'OK');
        }
    }
    /**
     * This function sends a response with the given status code and status text.
     * If a body is given, it is sent as a JSON string.
     * 
     * @param int $statusCode
     * @param string $statusText
     * @param string|null $body
     * @return void
     */
    public function sendResponse($statusCode, $statusText, $body = null)
    {
        header("HTTP/1.1 {$statusCode} {$statusText}");

        if ($body != null) {
            header("Content-Type: application/json");
            echo $body;
        }
    }


}
