<?php
require_once '../../controller/authentifier.php';

$controller_instance = new Authentifier();
$api_register = new APIregister($controller_instance);
$api_register->request();
class APIregister{
    private $controller;

    public function __construct($controller){
        $this->controller = $controller;
        
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
            $this->addJoueurToUnivers();
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
    
    public function getIdUnivers(){
        if(http_response_code() != 200){
            return;
        }

        $univers = $this->controller->getIdUnivers();

        if($univers == null){
            http_response_code(401);
            echo "Univers doesn't exist";
        }
        else{
            return $univers;
        }
    }

    public function getIdJoueur($username){
        if(http_response_code() != 200){
            return;
        }

        $id_joueur = $this->controller->getIdJoueur($username);

        if($id_joueur == null){
            http_response_code(401);
            echo "Joueur doesn't exist";
        }
        else{
            return $id_joueur;
        }
    }

    public function getNumberJoueurUnivers($id_univers){
        if(http_response_code() != 200){
            return;
        }

        $number_joueur = $this->controller->getNumberJoueurUnivers($id_univers);

        if($number_joueur == null){
            http_response_code(401);
            echo "Aucun joueur dans cet univers";
        }
        else{
            return $number_joueur;
        }
    }

    public function getAllUnivers(){
        $allunivers = $this->controller->getAllUnivers();
        return $allunivers;
    }
    public function nextUnivers(){
        $univers = $this->getAllUnivers();
        foreach($univers as $u){
            $id_univers = $u['id'];
            $number_joueur = $this->getNumberJoueurUnivers($id_univers);
            if($number_joueur['COUNT(*)'] < 50){
                return $id_univers;
            }
        }
        return null; // Tous les univers ont atteint leur limite
    }
    
    public function addJoueurToUnivers(){
        if(http_response_code() != 200){
            return;
        }
    
        $id_univers = $this->getIdUnivers();
        $id_joueur = $this->getIdJoueur($_POST['username']);
        $number_joueur = $this->getNumberJoueurUnivers($id_univers);
        
        if($number_joueur < 50 && $id_joueur != null){
            $typeRessources = array('10', '11', '12');

            foreach ($typeRessources as $typeRessource) {
                
                $univers_joueur = $this->controller->registerUnivers($id_joueur, $id_univers, $typeRessource);
                      
                }
            $this->addEmptyPlanet($id_joueur);
    }
        else {
            
            http_response_code(401);
            echo "Univers " + $id_univers +" is full";
            $id_univers = $this->nextUnivers();
        }

        
    }

   
    public function addEmptyPlanet($id_joueur){
        if(http_response_code() != 200){
            return;
        }
        $id_univers = $this->getIdUnivers();
        $this->controller->registerPlanet($id_joueur, $id_univers);
    }
}

    

