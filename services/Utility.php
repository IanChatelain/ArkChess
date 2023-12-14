<?php

class Utility{

    public static function setFlashMessage($key, $message){
        $_SESSION[$key] = $message;
    }
    
    public static function getFlashMessage($key){
        if (isset($_SESSION[$key])) {
            $message = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $message;
        }
        return null;
    }
}

?>
