<?php

require_once('PHPSession.php');
/**
 * Class SessionController
 * This class is the controller for the session.
 * It handles the session variables.
 */
class PHPSession implements SessionInterface
{   
    /**
     * This function starts the session.
     * 
     * @return bool
     */
    public function startSession(): bool
    {
        return session_start();
    }

    /**
     * This function gets the session variable.
     * 
     * @param string $varName
     * @return mixed
     */
    public function getSessionVar(string $varName)
    {
        return $_SESSION[$varName] ?? null;
    }
    /**
     * This function sets the session variable.
     * 
     * @param string $varName
     * @param mixed $value
     * @return void
     */
    public function setSessionVar(string $varName, $value)
    {
        $_SESSION[$varName] = $value;
    }
    /**
     * This function unsets the session variable.
     * 
     * @param string $varName
     * @return void
     */
    public function unsetSessionVar(string $varName)
    {
        unset($_SESSION[$varName]);
    }
    /**
     * This function destroys the session.
     * 
     * @return bool
     */
    public function destroySession(): bool
    {
        return session_destroy();
    }
    /**
     * This function checks if the session is started.
     * 
     * @return bool
     */
    public function storeJoueur($username, $id, $univers)
    {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;
        $_SESSION['univers'] = $univers;
    
    }
    /**
     * This function gets the session id.
     * 
     * @return string
     */
    public function getSessionId(): string
    {
        return session_id();
    }
}

?>