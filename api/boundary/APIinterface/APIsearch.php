<?php

require_once('../../controller/search.php');

$controller_instance = new Search();
$api_search = new APIsearch($controller_instance);
$api_search->handleRequest();

class APIsearch
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
        if (isset($_GET['id_Labo']) && isset($_GET['id_Planet'])) 
        {
            $laboID = $this->controller->getLaboratoireID($_GET['id_Planet']);
            $this->sendResponse(200, 'OK', json_encode(array('id_Labo' => $laboID)));
        }
        else if (isset($_GET['default_technologies'])) 
        {
            $defaultTechno = $this->controller->getDefaultTechnologie();
            $this->sendResponse(200, 'OK', json_encode($defaultTechno));
        }
        else if(isset($_GET['quantity_ressource_player']) && isset($_GET['id_Player']) && isset($_GET['id_Universe']))
        {
            $quantity_ressource_player = $this->controller->getQuantityRessourcePlayer($_GET['id_Player'], $_GET['id_Universe']);
            $this->sendResponse(200, 'OK', json_encode($quantity_ressource_player));
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
        
        if (isset($data['id_Planet']) && isset($data['id_Infrastructure'])) 
        {
            $this->controller->upgradeInfrastructure($data['id_Planet'], $data['id_Infrastructure']);
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