<?php

require_once 'DBinterface.php';

class Test extends DBinterface {

    public function __construct(){
        parent::__construct();
    }

    public function getTest(){
        $sql = "SELECT * FROM joueur";
        $query = $this->getDB()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}

$test = new Test();

echo json_encode($test->getTest());

?>
