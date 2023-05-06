<?php

//paramètres de la base de données
define('SERVER', "localhost");
define('DB_PORT', "3307");
define('DB_NAME', "esirempire_db");
define('DB_LOGIN', "root");
define('DB_PWD', "");

class DBinterface {

    private $db;

    public function __construct(){
        try{
            $this->db = new PDO('mysql:host=' . SERVER . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8', DB_LOGIN, DB_PWD);
        } catch(PDOException $e){
            echo 'Error while connexion : ' . $e->getMessage();
        }
    }

    // public function getDB(){
    //     return $this->db;
    // }

    public function login($query, $username){
        $user = $this->db->prepare($query);
        $user->bindParam(':pseudo', $username);
        $user->execute();
        $result = $user->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function isEmail($query, $mail){
        $user = $this->db->prepare($query);
        $user->bindParam(':mail', $mail);
        $user->execute();
        $result = $user->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function register($query, $username, $password, $mail ){
        $user = $this->db->prepare($query);
        $user->bindParam(':pseudo', $username);
        $user->bindParam(':mdp', $password);
        $user->bindParam(':email', $mail);
        $user->execute();
        $result = $user->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getIdJoueur($query, $username){
        $user = $this->db->prepare($query);
        $user->bindParam(':pseudo', $username);
        $user->execute();
        $result = $user->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function registerUnivers($query, $idJoueur, $idUnivers){
        $user = $this->db->prepare($query);
        $user->bindParam(':idJoueur', $idJoueur);
        $user->bindParam(':idUnivers', $idUnivers);
        
        // var_dump($user);
        $user->execute();
        $result = $user->rowCount();
        if ($user->errorCode() !== '00000') {
            $errorInfo = $user->errorInfo();
            echo 'Erreur lors de l\'exécution de la requête : '.$errorInfo[2];
        }
        return $result;
    }

    public function getNumberJoueurUnivers($query, $idUnivers){
        $user = $this->db->prepare($query);
        $user->execute([':id_Univers' => $idUnivers]);
        $result = $user->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getIdUnivers($query) {
        $user = $this->db->prepare($query);
        $user->execute();
        $result = $user->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
}

?>