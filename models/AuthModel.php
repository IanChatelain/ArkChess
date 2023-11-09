<?php

/**
 * AuthModel represents the authenticating data stored for a user.
 */
class AuthModel{
    private $userID;
    private $session;
    private $cookies;
    private $authorized;
    private $role;
    private $password;

    public function __construct(){
        $this->userID = $userID;
        $this->session = $session;
        $this->cookies = $cookies;
        $this->authorized = $authorized;
        $this->role = $role;
        $this->role = $role;
        $this->password = $password;
    }
    
    /**
     * Gets the user id of the user being authenticated.
     * 
     * @return int $this->userID A unique identifier of the user.
     */
    public function getUserID(){
        return $this->userID;
    }
}

?>