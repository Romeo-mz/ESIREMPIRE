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
        if (isset($_GET['id_Planet'])) 
        {
            $infrastructures = $this->controller->getInfrastructures($_GET['id_Planet']);
            $this->sendResponse(200, 'OK', json_encode($infrastructures));
        }
        else if(isset($_GET['default_defense']))
        {
            $default_infrastructures = $this->controller->getDefaultDefense();
            $this->sendResponse(200, 'OK', json_encode($default_infrastructures));
        }
        else if(isset($_GET['default_installation']))
        {
            $default_infrastructures = $this->controller->getDefaultInstallation();
            $this->sendResponse(200, 'OK', json_encode($default_infrastructures));
        }
        else if(isset($_GET['default_ressource']))
        {
            $default_infrastructures = $this->controller->getDefaultRessource();
            $this->sendResponse(200, 'OK', json_encode($default_infrastructures));
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
        else if (isset($data['id_Planet']) && isset($data['type'])) 
        {
            $id_New_Infrastructure = $this->controller->buildInfrastructure($data['id_Planet'], $data['type']);
            // create json response with id_New_Infrastructure
            $response = array('id_New_Infrastructure' => $id_New_Infrastructure);

            $this->sendResponse(200, 'OK', json_encode($response));
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