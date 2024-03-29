<?php
require_once('../SessionInterface.php');
class SessionController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function startSession(): bool
    {
        return $this->session->startSession();
    }

    public function getSessionVar(string $varName)
    {
        return $this->session->getSessionVar($varName);
    }

    public function setSessionVar(string $varName, $value)
    {
        $this->session->setSessionVar($varName, $value);
    }

    public function unsetSessionVar(string $varName)
    {
        $this->session->unsetSessionVar($varName);
    }

    public function destroySession(): bool
    {
        return $this->session->destroySession();
    }

    public function storeJoueur($username, $id, $univers){
        return $this->session->storeJoueur($username, $id, $univers);
    }
}