<?php
// database credentials
$dbHost = 'localhost';
$dbName = 'boulder';
$dbUser = 'root';
$dbPass = '';
try {
    // attempt to connect to the database
    $db = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName . ';charset=UTF8', $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // fetch results to an associative array
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING ); // show warnings, useful for debugging
} catch(Exception $e) {
    // if we get any errors, print them.
    echo $e->getMessage();
    exit;
}
?>