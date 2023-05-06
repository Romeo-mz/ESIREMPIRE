<?php
require_once '../../controller/authentifier.php';
class APIregister{
    private $controller;

    public function __construct($controller){
        $this->controller = $controller;
        $this->addJoueurToUnivers();
    }

    public function request(){
        $request = $_SERVER['REQUEST_METHOD'];

        if($request == 'POST'){
            $this->postRequest();
        }
        else{
            http_response_code(405);
            echo "Method not allowed";
        }
    }

    public function postRequest(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $mail = $_POST['email'];

        if(!isset($username) || !isset($password) || !isset($mail)){
            http_response_code(400);
            echo "Bad request";
            return;
        }

        $result = $this->controller->register($username, $password, $mail);

        if($result == 0){
            http_response_code(200);
            echo "Register successful";
        }
        else if($result == 1){
            http_response_code(401);
            echo "Password Invalid / Password too short";
        }
        else if($result == 2){
            http_response_code(401);
            echo "Username Ivalid / Username too short";
        }
        else if($result == 3){
            http_response_code(401);
            echo "Email Invalid";
        }
        else if($result == 4){
            http_response_code(401);
            echo "Username already exists";
        }
        else if($result == 5){
            http_response_code(401);
            echo "Email already exists";
        }
        else{
            http_response_code(500);
            echo "Internal server error";
        }
    }
    public function addJoueurToUnivers(){
        if(http_response_code() != 200){
            return;
        }
    
        $id_univers = $this->controller->getIdUnivers();
        $id_joueur = $this->controller->getIdJoueur($_POST['username']);
        $number_joueur = $this->controller->getNumberJoueurUnivers($id_univers[0]['id']);
        

        if($number_joueur['COUNT(*)'] < 50 && $id_joueur['id'] != null){
            $univers_joueur = $this->controller->registerUnivers($id_joueur['id'], $id_univers[0]['id']);            
        } else {
            http_response_code(401);
            echo "Univers is full";
        }
    }
    
}

$controller_instance = new Authentifier();
$api_register = new APIregister($controller_instance);
$api_register->request();