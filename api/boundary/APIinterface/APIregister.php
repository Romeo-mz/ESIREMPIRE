<?php
require_once '../../controller/authentifier.php';
require_once '../../controller/SessionController.php';
require_once(__DIR__.'\..\SessionInterface.php');

$session = new PHPSession();

$controller_instance = new Authentifier();
$session_controller = new SessionController($session);

$session_controller->startSession();

$api_register = new APIregister($controller_instance, $session_controller);
$api_register->request();

/**
 * Class APIregister
 * This class is the API for the register page.
 * It handles the POST and GET requests.
 */
class APIregister{
    private $controller;
    private $session_controller;
    public function __construct($controller, $session_controller){
        $this->controller = $controller;
        $this->session_controller = $session_controller;
    }
    /**
     * This function handles the request.
     * It checks the request method and calls the appropriate function.
     * If the request method is not supported, it sends a 405 response.
     * 
     * @return void
     */
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
    /**
     * This function handles the POST request.
     * It checks if the request is valid and calls the appropriate function.
     * If the request is not valid, it sends a 400 response.
     * 
     * @return void
     */
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
            header('Location: ../../../front/login.php');
            
        }
        else if($result == 1){
            http_response_code(401);
            echo "Password Invalid / Password too short";
            header('Location: ../../../front/register.php');
        }
        else if($result == 2){
            http_response_code(401);
            echo "Username Ivalid / Username too short";
            header('Location: ../../../front/register.php');
        }
        else if($result == 3){
            http_response_code(401);
            echo "Email Invalid";
            header('Location: ../../../front/register.php');
        }
        else if($result == 4){
            http_response_code(401);
            echo "Username already exists";
            header('Location: ../../../front/register.php');
        }
        else if($result == 5){
            http_response_code(401);
            echo "Email already exists";
            header('Location: ../../../front/register.php');
        }
        else{
            http_response_code(500);
            echo "Internal server error";
            header('Location: ../../../front/register.php');
        }
    }
    /**
     * This function sends a response to the client.
     * 
     * @param int $code
     * @param string $status
     * @param string $message
     * @return int
     */
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
    /**
     * This function sends a response to the client.
     * 
     * @param int $code
     * @param string $status
     * @param string $message
     * @return void
     */
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
    /**
     * This function sends a response to the client.
     * 
     * @param int $code
     * @param string $status
     * @param string $message
     * @return void
     */
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
    /**
     * This function return all the Universes .
     * 
     * @param int $code
     * @param string $status
     * @param string $message
     * @return mixed
     */
    public function getAllUnivers(){
        $allunivers = $this->controller->getAllUnivers();
        return $allunivers;
    }
    /**
     * This function return the next Univers .
     * 
     * @param int $code
     * @param string $status
     * @param string $message
     * @return void
     */
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
    /**
     * This function add a joueur to an univers .
     * 
     * @return void
     */
    public function addJoueurToUnivers(){
        if(http_response_code() != 200){
            return;
        }
    
        $id_univers = $this->getIdUnivers();
        $id_joueur = $this->getIdJoueur($_POST['username']);
        $number_joueur = $this->getNumberJoueurUnivers($id_univers);
        
        $create_ressource = $this->controller->createRessource();
        print_r($number_joueur);
        if($number_joueur < 50 && $id_joueur != null){
            $id_ressources = $this->controller->getIdRessources();

            foreach ($id_ressources as $id_ressource) {
                
                $univers_joueur = $this->controller->registerUnivers($id_joueur, $id_univers, $id_ressource['id']);
                      
                }
            $this->addEmptyPlanet($id_joueur);
    }
        else {
            
            http_response_code(401);
            echo "Univers " + $id_univers +" is full";
            $id_univers = $this->nextUnivers();
        }

        
    }

   /**
     * This function add a planet to a joueur .
     * 
     * @param int $id_joueur
     * @return void
     */
    public function addEmptyPlanet($id_joueur){
        if(http_response_code() != 200){
            return;
        }
        $id_univers = $this->getIdUnivers();
        $this->controller->registerPlanet($id_joueur, $id_univers);
    }
}

    

