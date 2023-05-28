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

    
    

    public function handlePost()
    {

    }
    public function sendResponse($statusCode, $statusText, $body = null)
    {
        header("HTTP/1.1 {$statusCode} {$statusText}");

        if ($body != null) {
            header("Content-Type: application/json");
            echo $body;
        }
    }


}
