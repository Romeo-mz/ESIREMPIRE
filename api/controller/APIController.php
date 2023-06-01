<?php
require_once '../api/boundary/APIinterface/APIinterface.php';
require_once '../api/boundary/DBinterface/DBinterface.php';
/**
 * Class APIController
 * This class is the controller for the API.
 * It handles the API requests.
 */
class APIController implements APIinterface {
    private $db;
    /**
     * APIController constructor.
     * @param $db
     */
    public function __construct(DBinterface $db) {
        $this->db = $db;
    }
    /**
     * This function test if a user is in the database.
     * 
     * @return true if the user is in the database, false otherwise
     */
    public function login($username, $password) {
        // Vérifier si l'utilisateur existe dans la base de données
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}