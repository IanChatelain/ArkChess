<?php

class Utility {

    // Sets session key and message.
    public static function setFlashMessage($key, $message) {
        $_SESSION[$key] = $message;
    }
    
    // Gets message from session key.
    public static function getFlashMessage($key) {
        if (isset($_SESSION[$key])) {
            $message = $_SESSION[$key];
            unset($_SESSION[$key]); // Clear the message from the session.
            return $message;
        }
        return null;
    }
}

?>
