<?php

require_once 'vendor/ezyang/htmlpurifier/library/HTMLPurifier.auto.php';

class Sanitize{

    public static function sanitizeHTML($dirtyHTML){
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $cleanHTML = $purifier->purify($dirtyHTML);
        return $cleanHTML;
    }
}

?>