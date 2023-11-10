<?php

session_start();

require_once('services/DBManager.php');
require_once('models/UserModel.php');

/**
 * AuthController controls user authentication.
 */
class AuthController{
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

        if($userAuthed->getAuth()){
            $_SESSION['USER_ID'] = $userAuthed->getUserID();
            $_SESSION['USER_NAME'] = $userAuthed->getUserName();
            $_SESSION['USER_ROLE'] = $userAuthed->getRole();
        }

        return $userAuthed;
    }

    public static function getUser(){
        if(!empty($_SESSION['USER_ID'])){
            $userId = $_SESSION['USER_ID'];

            return DBManager::getAuthUser($userId);
        }
    }

    public static function logoutUser() {
        // Unset all session variables
        $_SESSION = array();
    
        // If it's desired to kill the session, also delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    
        // Destroy the session
        session_destroy();
    
        // Redirect to the login page
        header('Location: login.php');
        exit();
    }

    public static function isAdmin($user){
        
    }
}

?>