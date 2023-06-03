<?php

require_once('../../controller/spacework.php');

$controller_instance = new Spacework();
$api_spacework = new APIspacework($controller_instance);
$api_spacework->handleRequest();

/**
 * Class APIspacework
 * This class is the API for the spacework page.
 * It handles the POST and GET requests.
 */
class APIspacework
{
    private $controller;
    /**
     * APIspacework constructor.
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
    private function handleGet()
    {
        if (isset($_GET['id_Spacework']) && isset($_GET['id_Planet'])) 
        {
            $spaceworkID = $this->controller->getSpaceworkID($_GET['id_Planet']);
            $this->sendResponse(200, 'OK', json_encode(array('id_Spacework' => $spaceworkID)));
        }
        else if (isset($_GET['default_ships'])) 
        {
            $defaultShips = $this->controller->getDefaultShips();
            $this->sendResponse(200, 'OK', json_encode($defaultShips));
        }
        else if(isset($_GET['quantity_ressource_player']) && isset($_GET['id_Player']) && isset($_GET['id_Universe']))
        {
            $quantity_ressource_player = $this->controller->getQuantityRessourcePlayer($_GET['id_Player'], $_GET['id_Universe']);
            $this->sendResponse(200, 'OK', json_encode($quantity_ressource_player));
        }
        else if(isset($_GET['nbships']) && isset($_GET['id_Spacework']))
        {
            $ships = $this->controller->getNbShips($_GET['id_Spacework']);
            $this->sendResponse(200, 'OK', json_encode($ships));
        }
        
        else if(isset($_GET['technologiesPlayer']) && isset($_GET['id_Planet']))
        {
            $technologies = $this->controller->getTechnologies($_GET['id_Planet']);
            $this->sendResponse(200, 'OK', json_encode($technologies));
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
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (isset($data['id_Spacework']) && isset($data['type'])) 
        {
            $this->controller->addShip($data['id_Spacework'], $data['type'], $_SESSION['id_joueur']);
            $this->sendResponse(200, 'OK');
        }
        else if (isset($data['id_Ressource']) && isset($data['quantite']))
        {
            $this->controller->updateQuantityRessource($data['id_Ressource'], $data['quantite']);
            $this->sendResponse(200, 'OK');
        }
        else 
        {
            $this->sendResponse(400, 'Bad Request');
        }
    }
    /**
     * This function sends a response with the given status code and status text.
     * If a body is given, it is sent as a JSON object.
     *
     * @param $statusCode
     * @param $statusText
     * @param null $body
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