<?php

/**
 * UserModel represents the data stored for a user.
 */
class UserModel{
    private $userID;
    private $userName;
    private $firstName;
    private $lastName;
    private $rating;
    private $email;
    private $role;
    private $password;
    private $auth;

    public function __construct($userID = NULL, $userName = '', $password = '', $role = NULL){
        $this->userID = $userID;
        $this->userName = $userName;
        // $this->rating = $rating;
        // $this->email = $email;
        // $this->role = $role;
        // $this->content = $content;
        $this->password = $password;
    }
    
    /**
     * Gets the user id.
     * 
     * @return int $this->userID A unique identifier of the user.
     */
    public function getUserID(){
        return $this->userID;
    }
    
    /**
     * Gets the user name.
     * 
     * @return int $this->userName The user name of the user.
     */
    public function getUserName(){
        return $this->userName;
    }

    /**
     * Gets the user email.
     * 
     * @return int $this->email The email of the user.
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * Gets whether the user is authenticated.
     * 
     * @return int $this->auth The email of the user.
     */
    public function getAuth(){
        return $this->auth;
    }

    public function setAuth($auth){
        $this->auth = $auth;
    }

    public function getPassword(){
        return $this->password;
    }
}

?>