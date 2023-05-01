<?php
require_once (realpath(dirname(__FILE__) . '../controller/APIController.php'));

// Connexion à la base de données
$db = new mysqli('localhost', 'romeo', 'admin1234', 'ESIREMPIRE');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Création d'une instance du contrôleur API
$apiController = new APIController($db);

// Vérification des informations de connexion
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $apiController->login($username, $password);

    if ($result) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false));
    }
}

// Déconnexion de la base de données
$db->close();