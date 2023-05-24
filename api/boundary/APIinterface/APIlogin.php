<?php

require_once('../../controller/authentifier.php');
$controller_instance = new Authentifier();
$api_login = new APIlogin($controller_instance);
$api_login->request();

class APIlogin
{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
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
        
        if($result == 0)
        {
            // http_response_code(200);
            
            $this->sendResponse(200, 'OK', json_encode($_SESSION['user']));
            // header('Location: http://esirempire/front/galaxy.html');
        }
        else if($result == 1)
        {
            http_response_code(401);
            // header('Location: http://esirempire/front/login.php?wrong_password');
        }
        else if($result == 2)
        {
            http_response_code(401);
            // header('Location: http://esirempire/front/login.php?wrong_username');
        }
        else if($result == 3)
        {
            http_response_code(401);
            // header('Location: http://esirempire/front/login.php?wrong_universe');
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