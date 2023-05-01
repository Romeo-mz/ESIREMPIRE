<?php

require_once('../../controller/authentifier.php');


class APIlogin
{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
        //$this->request();
    }

    private function request()
    {

        // récuperer verbe
        $request_method = $_SERVER['REQUEST_METHOD'];

        // Traitement verbe
        switch ($request_method) {
            case 'POST':

                $data = json_decode(file_get_contents("php://input"),true);

                //Then, call controller method

                break;

            case 'GET':

                //Then, call controller method

                break;
            
            default:
                echo "Bad URL";
                break;
            }
    }
}

?>