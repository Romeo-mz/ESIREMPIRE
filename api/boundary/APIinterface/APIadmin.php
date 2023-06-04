<?php

require_once('../../controller/administration.php');

$controller_instance = new Administration();
$api_admin = new APIadmin($controller_instance);
$api_admin->handleRequest();

/**
 * Class APIadmin
 * This class is the API for the admin page.
 * It handles the POST and GET requests.
 */
class APIadmin
{
    private $controller;
    /**
     * APIadmin constructor.
     * @param $controller
     */
    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @brief Gère la requête entrante.
     * @details Vérifie la méthode de la requête et appelle la fonction appropriée.
     * Si la méthode de la requête n'est pas prise en charge, elle envoie une réponse 405.
     * @return void
     */
    public function handleRequest()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        switch ($requestMethod) {
            case 'POST':
                $this->handlePost();
                break;
            case 'GET':
                $this->handleGet();
                break;
            default:
                $this->sendResponse(405, 'Method Not Allowed');
                break;
        }
    }

    /**
     * @brief Gère la requête POST.
     * @details Vérifie si la requête est valide et appelle la fonction appropriée.
     * Si la requête n'est pas valide, elle envoie une réponse 400.
     * @note Fetch à réaliser: POST /api/boundary/apiinterface/apiadmin.php
     * @note JSON envoyé: { "universe_name": "nom de l'univers" }
     * @return void
     */
    private function handlePost()
    {
        if (!isset($_POST['universe_name'])) {
            $this->sendResponse(400, 'Bad Request');
            return;
        }

        $universeName = $_POST['universe_name'] ?: "Univers " . ($this->controller->getLastUniverseId() + 1);

        $universeResult = $this->controller->createUniverse($universeName);
        $galaxiesResult = $this->controller->createGalaxies();
        $solarSystemsResult = $this->controller->createSolarSystems();
        $planetsResult = $this->controller->createPlanets();

        if ($universeResult && $galaxiesResult && $solarSystemsResult && $planetsResult) {
            $this->sendResponse(201, 'Universe Created');
        } else {
            $this->sendResponse(500, 'Internal Server Error');
        }
    }

    /**
     * @brief Gère la requête GET.
     * @details Vérifie si la requête est valide et appelle la fonction appropriée.
     * Si la requête n'est pas valide, elle envoie une réponse 400.
     * @note Fetch à réaliser: GET /api/boundary/apiinterface/apiadmin.php?universes
     * @note JSON renvoyé: Un tableau JSON contenant les informations sur les univers.
     * @return void
     */
    private function handleGet()
    {
        if (isset($_GET['universes'])) {
            $universes = $this->controller->getUniverses();
            $this->sendResponse(200, 'OK', json_encode($universes));
        } else {
            $this->sendResponse(400, 'Bad Request');
        }
    }
    /**
     * @brief Envoie la réponse au client.
     * @param int $statusCode - Le code de statut HTTP.
     * @param string $statusText - Le texte du statut HTTP.
     * @param string|null $body - Le corps de la réponse, s'il y en a un.
     * @return void
     */
    private function sendResponse($statusCode, $statusText, $body = null)
    {
        header("HTTP/1.1 {$statusCode} {$statusText}");

        if ($body != null) {
            header("Content-Type: application/json");
            echo $body;
        }
        else if ($statusCode >= 200 && $statusCode < 300) {
            echo "<script>window.location.href = '../../../front/admin.php?success=1&message=" . urlencode($statusText) . "';</script>";
        } else {
            echo "<script>window.location.href = '../../../front/admin.php?success=0&message=" . urlencode($statusText) . "';</script>";
        }
        exit;
    }

}

?>