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
        else if(isset($_GET['ships']) && isset($_GET['id_Spacework']))
        {
            $technologies = $this->controller->getTechnologies($_GET['id_Spacework']);
            $this->sendResponse(200, 'OK', json_encode($technologies));
        }
        // else if(isset($_GET['techno_required']))
        // {
        //     $techno_required = $this->controller->getTechnoRequired();
        //     $this->sendResponse(200, 'OK', json_encode($techno_required));
        // }
        else 
        {
            $this->sendResponse(400, 'Bad Request');
        }
    }

    private function handlePost()
    {
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (isset($data['id_Labo']) && isset($data['id_Technologie'])) 
        {
            $this->controller->upgradeTechnologie($data['id_Technologie']);
            $this->sendResponse(200, 'OK');
        }
        else if (isset($data['id_Labo']) && isset($data['type'])) 
        {
            $id_New_Technologie = $this->controller->createTechnologie($data['id_Labo'], $data['type']);
            $this->sendResponse(200, 'OK', json_encode(array('id_New_Technologie' => $id_New_Technologie)));
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