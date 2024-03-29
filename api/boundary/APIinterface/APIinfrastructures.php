<?php

require_once('../../controller/infrastructures.php');

$controller_instance = new Infrastructures();
$api_infrastructures = new APIinfrastructures($controller_instance);
$api_infrastructures->handleRequest();
/**
 * Class APIinfrastructures
 * This class is the API for the admin page.
 * It handles the POST and GET requests.
 */
class APIinfrastructures
{
    private $controller;
    /**
     * APIinfrastructures constructor.
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
        if(isset($_GET['bonus_ressources']) && isset($_GET['id_Planet']))
        {
            $bonusRessources = $this->controller->getBonusRessources($_GET['id_Planet']);
            $this->sendResponse(200, 'OK', json_encode($bonusRessources));
        }
        else if (isset($_GET['id_Planet'])) 
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
        else if(isset($_GET['quantity_ressource_player']) && isset($_GET['id_Player']) && isset($_GET['id_Universe']))
        {
            $quantity_ressource_player = $this->controller->getQuantityRessourcePlayer($_GET['id_Player'], $_GET['id_Universe']);
            $this->sendResponse(200, 'OK', json_encode($quantity_ressource_player));
        }
        else if(isset($_GET['techno_required']))
        {
            $techno_required = $this->controller->getTechnoRequired();
            $this->sendResponse(200, 'OK', json_encode($techno_required));
        }
        else if(isset($_GET['infra_techno_required']))
        {
            $infra_techno_required = $this->controller->getInfraTechnoRequired();
            $this->sendResponse(200, 'OK', json_encode($infra_techno_required));
        }
        else if(isset($_GET['technologies']) && isset($_GET['id_Labo']))
        {
            $technologies = $this->controller->getTechnologies($_GET['id_Labo']);
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
        // decode json post data
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['id_Planet']) && isset($data['id_Infrastructure'])) 
        {
            $this->controller->upgradeInfrastructure($data['id_Planet'], $data['id_Infrastructure']);
            $this->sendResponse(200, 'OK');
        }
        else if (isset($data['id_Planet']) && isset($data['infraType']) && isset($data['type'])) 
        {
            $id_New_Infrastructure = $this->controller->buildInfrastructure($data['id_Planet'], $data['infraType'], $data['type']);
            $response = array('id_New_Infrastructure' => $id_New_Infrastructure);

            $this->sendResponse(200, 'OK', json_encode($response));
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
     * If a body is given, it is added to the response.
     * 
     * @param $statusCode
     * @param $statusText
     * @param null $body
     * @return void
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