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
        // $this->request();
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
        $username = $_POST['username'];
        $password = $_POST['password'];
        $univers = $_POST['univers'];

        if(!isset($username) || !isset($password) || !isset($univers))
        {
            http_response_code(400);
            echo "Bad request";
            return;
        }
        
        $result = $this->controller->login($username, $password);
        
        if($result == 0)
        {
            http_response_code(200);
            echo "Login successful";
        }
        else if($result == 1)
        {
            http_response_code(401);
            echo "Wrong password";
        }
        else if($result == 2)
        {
            http_response_code(401);
            echo "Wrong username";
        }
        else if($result == 3)
        {
            http_response_code(401);
            echo "Wrong univers";
        }
    }
}



?>