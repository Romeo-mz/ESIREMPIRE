<?php

require_once('../../boundary/APIinterface/APIadmin.php');
require_once('../../boundary/DBinterface/DBinterface.php');

$controller = new Authentifier();

class Authentifier
{
    public function __construct()
    {
        $this->DBinterface = new DBinterface();
        $this->APIadmin = new APIadmin($this);
    }

}