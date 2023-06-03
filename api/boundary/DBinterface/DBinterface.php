<?php

define('SERVER', "localhost");
define('DB_PORT', "3307");
define('DB_NAME', "esirempire_db");

/**
 * Class DBinterface
 * @package api\boundary\DBinterface
 */
abstract class DBinterface {

    protected $db;
    /**
     * DBinterface constructor.
     * @param $db_login
     * @param $db_pwd
     */
    public function __construct($db_login, $db_pwd){
        try{
            $this->db = new PDO('mysql:host=' . SERVER . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8', $db_login, $db_pwd);
        } catch(PDOException $e){
            echo 'Error while connexion : ' . $e->getMessage();
        }
    }
    /**
     * @param $query
     * @param array $params
     * @return mixed
     */
    protected function fetchAllRows($query, array $params = [])
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * @param $query
     * @param array $params
     * @return mixed
     */
    protected function fetchValue($query, array $params = [])
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
    /**
     * @param $query
     * @param array $params
     * @return mixed
     */
    protected function executeQuery($query, array $params = [])
    {
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }
    
}

?>