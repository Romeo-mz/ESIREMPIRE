<?php

require_once('../../controller/administration.php');

class APIadmin
{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
        $this->request();
    }

    private function request()
    {

        // récuperer verbe
        $request_method = $_SERVER['REQUEST_METHOD'];

        // Traitement verbe
        switch ($request_method) {
            case 'POST':

                if($_POST['universe_name'] != "")
                    $universe_name = $_POST['universe_name'];
                else
                    echo "blank";

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