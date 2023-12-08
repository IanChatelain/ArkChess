<?php

/**
 * UserModel represents the data stored for a user.
 */
class UserModel{
    private $userID;
    private $userName;
    private $firstName;
    private $lastName;
    private $email;
    private $rating;
    private $role;


    public function __construct($userID = NULL, $userName = null, $firstName = null, $lastName = null, 
                                $email = null, $rating = 1200, $role = 4){
        $this->userID = $userID;
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->rating = $rating;
        $this->role = $role;
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

    public function setRating($rating){
        $this->rating = $rating;
    }
    
    public function setRole($role){
        $this->role = $role;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRole(){
        return $this->role;
    }

    public function getRating(){
        return $this->rating;
    }

    public function setIsEmailValidated($isEmailValidated){
        $this->isEmailValidated = $isEmailValidated;
    }

    public function getIsEmailValidated(){
        return $this->isEmailValidated;
    }
}

?>