<?php

require_once('services/DBManager.php');
require_once('models/UserModel.php');

/**
 * AuthController controls user authentication.
 */
class AuthController{
    public static function ensureAuthenticated(){
        session_start();
        if(!isset($_SESSION['USER_ID']) || empty($_SESSION['USER_ID'])){
            header('Location: login.php');
            exit();
        }
    }
}

?>