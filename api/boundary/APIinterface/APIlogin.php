<?php
require_once(__DIR__.'\..\SessionInterface.php');
require_once('../../controller/SessionController.php');
require_once('../../controller/authentifier.php');

$session = new PHPSession();
$controller_instance = new Authentifier();
$session_controller = new SessionController($session);

$session_controller->startSession();

$api_login = new APIlogin($controller_instance, $session_controller);
$api_login->request();

class APIlogin
{
    private $controller;
    private $session_controller;

    public function __construct($controller, $session_controller)
    {
        $this->controller = $controller;
        $this->session_controller = $session_controller;
        $this->request();
    }

    public function request()
    {
        $request_method = $_SERVER['REQUEST_METHOD'];
        
        switch ($request_method) {
            case 'POST':
                //echo("POST");
                $this->postRequest();
                break;

            case 'GET':
                http_response_code(405);
                echo "Method not allowed";
                break;
            
            default:
                echo "Bad URL";
                break;
            }
    }

    private function postRequest()
    {
        $data = json_decode(file_get_contents("php://input"));

        $username = $data->username;
        $password = $data->password;
        $univers = $data->universe;

        if(!isset($username) || !isset($password) || !isset($univers))
        {
            http_response_code(400);
            echo "Bad request";
            return;
        }
        
        $result = $this->controller->login($username, $password, $univers);
        
        if($result['success'])
        {
            $this->sendResponse(200, 'OK', json_encode($result));
        }
        else
        {
            $this->sendResponse(401, 'Error while authentification', json_encode($result));
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