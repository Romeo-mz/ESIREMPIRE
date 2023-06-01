<?php

require_once('SessionInterface.php');

/**
 * Class PHPSession
 * This class is the implementation of the SessionInterface.
 * It handles the session variables.
 */
interface SessionInterface{
    /**
     * This function starts the session.
     * 
     * @return bool
     */
    public function startSession(): bool;

    /**
     * This function gets the session variable.
     * 
     * @param string $varName
     * @return mixed
     */
    public function getSessionVar(string $varName);

    /**
     * This function sets the session variable.
     * 
     * @param string $varName
     * @param mixed $value
     * @return void
     */
    public function setSessionVar(string $varName, $value);

    /**
     * This function unsets the session variable.
     * 
     * @param string $varName
     * @return void
     */
    public function unsetSessionVar(string $varName);

    /**
     * This function destroys the session.
     * 
     * @return bool
     */
    public function destroySession(): bool;

    /**
     * This function checks if the session is started.
     * 
     * @return bool
     */
    public function storeJoueur($username, $id, $univers);
}