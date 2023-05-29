<?php

require_once('SessionInterface.php');
interface SessionInterface{
    public function startSession(): bool;

    public function getSessionVar(string $varName);

    public function setSessionVar(string $varName, $value);

    public function unsetSessionVar(string $varName);

    public function destroySession(): bool;

    public function storeJoueur($username, $id, $univers);
}