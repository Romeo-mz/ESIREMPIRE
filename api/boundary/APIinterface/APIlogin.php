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
            $id = $this->controller->getIdJoueur($username);
            $ressources = $this->controller->getRessourcesJoueur($id, $univers);

            $this->session_controller->storeJoueur($username, $id, $univers, $ressources);
            header('Location: ../../../front/galaxy.php');
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