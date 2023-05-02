<?php
require_once '../../controller/authentifier.php';

class APIregister{
    private $controller;

    public function __construct($controller){
        $this->controller = $controller;
        echo("okayy");
        $this->request();
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
            echo "Wrong password";
        }
        else if($result == 2){
            http_response_code(401);
            echo "Wrong username";
        }
        else{
            http_response_code(500);
            echo "Error while registering";
        }
    }
}