<?php
// Fetch the spaceship data from the server using the architecture in json file
// Path: ESIREMPIRE\api\boundary\APIinterface\APIvaisseau.php

require_once('../../controller/vaisseau.php');

$controller_instance = new Vaisseau();
$api_vaisseau = new APIvaisseau($controller_instance);
$api_vaisseau->handleRequest();

class APIvaisseau{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function handleRequest(){
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

    private function handleGet(){
        if (isset($_GET['id_Vaisseaux']) && isset($_GET['id_Univers'])){
            $vaisseauID = $this->controller->getVaisseauID($_GET['id_Univers']);
            $this->sendResponse(200, 'OK', json_encode(array('id_Vaisseaux' => $vaisseauID)));
        }
        
    }
}
