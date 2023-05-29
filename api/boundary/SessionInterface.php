<?php

require_once('PHPSession.php');
class PHPSession implements SessionInterface
{
    public function startSession(): bool
    {
        return session_start();
    }

    public function getSessionVar(string $varName)
    {
        return $_SESSION[$varName] ?? null;
    }

    public function setSessionVar(string $varName, $value)
    {
        $_SESSION[$varName] = $value;
    }

    public function unsetSessionVar(string $varName)
    {
        unset($_SESSION[$varName]);
    }

    public function destroySession(): bool
    {
        return session_destroy();
    }

    public function storeJoueur($username, $id, $univers)
    {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;
        $_SESSION['univers'] = $univers;
    
    }
    public function getSessionId(): string
    {
        return session_id();
    }
}

?>