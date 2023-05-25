<?php

require_once('../../controller/attaque.php');

$controller_instance = new Attaque();
$api_attaque = new APIattaque($controller_instance);
$api_attaque->handleRequest();

class APIattaque
{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;

    }

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

    public function handleGet()
    {
        if (isset($_GET['flotte'])) {
            $flotteData = $_GET['flotte'];
            $flotte = json_decode(urldecode($flotteData), true);
            $flotteHtml = '<div id="flotte-container">';
            $flotteHtml .= '<h2>Flotte</h2>';
            foreach ($flotte as $vaisseau) {
                $flotteHtml .= '<p>Type: ' . $vaisseau['type'] . ', Quantity: ' . $vaisseau['quantity'] . '</p>';
            }
            $flotteHtml .= '</div>';

            // Afficher la flotte sur la page
            echo $flotteHtml;
        } else {
            // Gérer le cas où le paramètre 'flotte' est manquant
            $this->sendResponse(400, 'Bad Request', 'Missing flotte parameter');
        }
    }

    public function handlePost()
    {

    }
    public function sendResponse($statusCode, $statusText, $body = null)
    {
        header("HTTP/1.1 {$statusCode} {$statusText}");

        if ($body != null) {
            header("Content-Type: application/json");
            echo $body;
        }
    }


}

?>