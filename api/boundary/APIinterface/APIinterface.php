<?php
/**
 * Class APIinterface
 * This class is the API for the login page.
 * It handles the POST and GET requests.
 */
interface APIinterface {
    public function login($username, $password);
}