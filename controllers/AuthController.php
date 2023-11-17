<?php

ini_set('log_errors', 'On');
ini_set('error_log', 'C:\\xampp\\php\\logs\\php_error_log');

session_start();

require_once('services/DBManager.php');
require_once('models/UserModel.php');
require_once('services/Email.php');

/**
 * AuthController controls user authentication.
 */
class AuthController{
    public static function generateSecureToken(){
        // Try getting a cryptographically secure token
        try{
            $token = openssl_random_pseudo_bytes(16, $crypto_strong);

            if ($token === false || !$crypto_strong) {
                echo "Unable to generate a secure token";
            } else {
                return bin2hex($token);
            }
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    // TODO: need to revamp role based access. Hit DB and check for role often.
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
        $user = new UserModel(NULL, $userName, $password, NULL);
        $userAuthed = DBManager::authUser($user);
        $userID = $user->getUserID();
        if($userAuthed->getIsEmailValidated()){
            $userAuthed->setRole(4);
        }

        if($userAuthed->getAuth()){
            $_SESSION['USER_ID'] = $userAuthed->getUserID();
            $_SESSION['USER_NAME'] = $userAuthed->getUserName();
            $_SESSION['USER_ROLE'] = $userAuthed->getRole();
        }
    }

    public static function processUserRegistration(){
        // TODO: add php validation in the future
        $userName = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $user = new UserModel(NULL, $userName, $password, NULL);
        $token = self::generateSecureToken();

        $user->setEmail($email);

        switch(DBManager::insertNewUser($user)){
            case 0:
                $expiry = time() + 3600; // 1 hour from now
                $cookieName = $user->getUserName() . "_email_token";

                // deployment cookie
                // setcookie($cookieName, $token, [
                //     'expires' => $expiry,
                //     'path' => '/',
                //     'domain' => 'arkchess.ca',
                //     'secure' => true,
                //     'httponly' => true,
                //     'samesite' => 'Strict'
                // ]);

                setcookie($cookieName, $token, [
                    'expires' => $expiry,
                    'path' => '/',
                ]);
                
                
                $userAuthed = DBManager::authUser($user);
        
                if($userAuthed->getAuth()){
                    $_SESSION['USER_ID'] = $userAuthed->getUserID();
                    $_SESSION['USER_NAME'] = $userAuthed->getUserName();
                    $_SESSION['USER_ROLE'] = $userAuthed->getRole();
                }

                Email::validationEmail($userAuthed->getEmail(), $token);
                break;
            case -100:
                echo "User already exists";
                break;
            case -200:
                echo "Failed to insert";
                break;
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