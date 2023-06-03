<?php
// Fetch the spaceship data from the server using the architecture in json file
// Path: ESIREMPIRE\api\boundary\APIinterface\APIvaisseau.php

require_once('../../controller/vaisseaux.php');

$controller_instance = new Vaisseau();
$api_vaisseau = new APIvaisseau($controller_instance);
$api_vaisseau->handleRequest();

/**
 * Class APIvaisseau
 * This class is the API for the vaisseau page.
 * It handles the POST and GET requests.
 */
class APIvaisseau
{
    private $controller;
    /**
     * APIvaisseau constructor.
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
    private function handlePost()
    {
        
        $nbrChasseur = $_POST['nombre-vaisseau-chasseur'];
        $nbrCroiseur = $_POST['nombre-vaisseau-croiseur'];
        $nbrTransporteur = $_POST['nombre-vaisseau-transporteur'];
        $nbrColonisateur = $_POST['nombre-vaisseau-colonisateur'];

        header('../../../front/attaque.php');
    }
    /**
     * This function handles the POST request.
     * It checks if the request is valid and calls the appropriate function.
     * If the request is not valid, it sends a 400 response.
     *
     * @return void
     */
    private function handleGet()
    {
        if (isset($_GET['id_Vaisseaux']) && isset($_GET['id_Univers'])) {
            $vaisseauID = $this->controller->getVaisseauID($_GET['id_Univers']);
            $this->sendResponse(200, 'OK', json_encode($vaisseauID));
        } else if (isset($_GET['default_vaisseaux']) && isset($_GET['id_Planet'])) {
            $defaultVaisseaux = $this->controller->getDefaultVaisseaux($_GET['id_Planet']);
            $this->sendResponse(200, 'OK', json_encode($defaultVaisseaux));
        }

    }
    /**
     * This function sends a response to the client.
     * It sets the status code and the status text.
     * If a body is provided, it sets the content type to JSON and sends the body.
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