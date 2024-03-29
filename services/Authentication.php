<?php

require_once('services/DBManager.php');
require_once('models/UserModel.php');
require_once('services/Email.php');

/**
 * Authentication controls user authentication.
 */
class Authentication{
    public static function generateSecureToken(){
        $token = openssl_random_pseudo_bytes(16, $crypto_strong);

        if ($token === false || !$crypto_strong) {
            echo "Unable to generate a secure token";
        } else {
            return bin2hex($token);
        }
    }

    public static function isLoggedIn(){
        if(!isset($_SESSION['USER_ID']) || empty($_SESSION['USER_ID'])){
            return false;
        }
        else{
            return true;
        }
    }

    public static function loginUser($userName, $password){
        // Returns user id or false if user not verified.
        $userId = DBManager::verifyUserLogin($userName, $password);
        $userRole = DBManager::getUserData($userId, UserField::Role);

        if($userId){
            self::setUserSession($userId, $userName, $userRole);
            return true;
        }
        else{
            return false;
        }
    }

    public static function isAuthorized(){
        return isset($_SESSION['ROLE_ID']) && $_SESSION['ROLE_ID'] == 1;
    }

    public static function setUserSession($userId, $userName, $role){
        $_SESSION['USER_ID'] = $userId;
        $_SESSION['USER_NAME'] = $userName;
        $_SESSION['ROLE_ID'] = $role;
    }

    public static function addUser(){
        $userName = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $token = self::generateSecureToken();

        if(!DBManager::doesUserExist($userName)){

            $userId = DBManager::insertNewUser($userName, $hashedPassword, $email);

            if($userId){
                return true;
            }
        }
    }

    public static function registerUser(){
        $userName = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // $token = self::generateSecureToken(); // Not implemented yet.

        if(!DBManager::doesUserExist($userName)){

            $userId = DBManager::insertNewUser($userName, $hashedPassword, $email);

            if($userId){
                //Email::validationEmail($email, $token);

                self::loginUser($userName, $password);
            }
        }
    }

    public static function logoutUser(){
        $_SESSION = array();
    
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    
        session_destroy();
    }
}

?>