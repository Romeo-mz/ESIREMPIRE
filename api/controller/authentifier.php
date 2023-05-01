<?php

require_once('../../boundary/APIinterface/APIinterface.php');

class Authentifier
{
    public function __construct()
    {
        $this->interfaceBDD = new InterfaceBDD();
        $this->APIlogin = new APIlogin($this);
    }

}