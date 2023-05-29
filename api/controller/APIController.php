<?php
require_once '../api/boundary/APIinterface/APIinterface.php';
require_once '../api/boundary/DBinterface/DBinterface.php';

class APIController implements APIinterface {
    private $db;

    public function __construct(DBinterface $db) {
        $this->db = $db;
    }

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