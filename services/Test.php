<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$bytes = openssl_random_pseudo_bytes(10, $crypto_strong);
if ($bytes === false || !$crypto_strong) {
    echo "Unable to generate a secure token";
} else {
    echo bin2hex($bytes);
}

?>
