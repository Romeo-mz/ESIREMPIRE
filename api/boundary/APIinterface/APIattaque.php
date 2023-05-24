<?php

require_once('../../controller/attaque.php');

$controller_instance = new Attaque();
$api_attaque = new APIattaque($controller_instance);
$api_attaque->handleRequest();

class APIattaque
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

    public function handleGet(){
        $flotte = $_GET['flotte'];
        echo($flotte);
    }
    public function handlePost(){
        
    }
    public function sendResponse($statusCode, $statusText, $body = null){
        header("HTTP/1.1 {$statusCode} {$statusText}");

        if($body != null){
            header("Content-Type: application/json");
            echo $body;
        }
    }

    
}

?>