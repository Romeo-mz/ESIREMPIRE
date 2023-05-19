<?php

require_once('../../controller/spacework.php');

$controller_instance = new Spacework();
$api_spacework = new APIspacework($controller_instance);
$api_spacework->handleRequest();

class APIspacework
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
            case 'POST':
                $this->handlePost();
                break;
            default:
                $this->sendResponse(405, 'Method Not Allowed');
                break;
        }
    }

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

    private function handlePost()
    {
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (isset($data['id_Spacework']) && isset($data['type'])) 
        {
            $this->controller->addShip($data['id_Spacework'], $data['type']);
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