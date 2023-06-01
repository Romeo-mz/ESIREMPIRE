<?php

require_once('../../controller/search.php');

$controller_instance = new Search();
$api_search = new APIsearch($controller_instance);
$api_search->handleRequest();

/**
 * Class APIsearch
 * This class is the API for the search page.
 * It handles the POST and GET requests.
 */
class APIsearch
{
    private $controller;
    /**
     * APIsearch constructor.
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
        else if(isset($_GET['technologies']) && isset($_GET['id_Labo']))
        {
            $technologies = $this->controller->getTechnologies($_GET['id_Labo']);
            $this->sendResponse(200, 'OK', json_encode($technologies));
        }
        else if(isset($_GET['techno_required']))
        {
            $techno_required = $this->controller->getTechnoRequired();
            $this->sendResponse(200, 'OK', json_encode($techno_required));
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