<?php

require_once('services/DBManager.php');
require_once('models/UserModel.php');
require_once('services/Email.php');

/**
 * AuthController controls user authentication.
 */
class AuthController{
    public static function generateSecureToken(){
        $token = openssl_random_pseudo_bytes(16, $crypto_strong);

        if ($token === false || !$crypto_strong) {
            echo "Unable to generate a secure token";
        } else {
            return bin2hex($token);
        }
    }

    public static function ensureAuthenticated(){
        if(!isset($_SESSION['USER_ID']) || empty($_SESSION['USER_ID'])){
            return false;
        }
        else{
            return true;
        }
    }

    public static function loginUser(){
        $userName = $_POST['username'];
        $password = $_POST['password'];

        // Returns user id or false if user not verified.
        $userId = DBManager::verifyUserLogin($userName, $password);

        if($userId){
            self::setSession($userId, $userName);
            return true;
        }
        else{
            return false;
        }
    }

    public static function setUserSession($userId, $userName){
        $_SESSION['USER_ID'] = $userId;
        $_SESSION['USER_NAME'] = $userName;
    }

    public static function registerUser(){
        $userName = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $token = self::generateSecureToken();

        if(!DBManager::doesUserExist($userName)){

            $userId = DBManager::insertNewUser($userName, $hashedPassword, $email, $token);

            if($userId){
                self::setSession($userId, $userName);
        
                Email::validationEmail($email, $token);

                self::loginUser();
            }
        }
    }

    public static function logoutUser() {
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