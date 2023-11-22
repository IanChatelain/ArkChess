<?php

require_once('services/DBManager.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

$allUsers = DBManager::getAllUsers();
$userNames = [];

foreach ($allUsers as $user) {
    $userNames[] = $user->getUserName(); // Appending each username to the array
}
$q = $_REQUEST["q"]; // The search query

$hint = [];

// Search for users
if ($q !== "") {
    $q = strtolower($q);
    $len = strlen($q);
    foreach ($userNames as $name) { // Iterate through $userNames array
        if (stristr($q, substr($name, 0, $len))) {
            $hint[] = $name; // Add matching username to hints array
        }
    }
}

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($hint);

?>