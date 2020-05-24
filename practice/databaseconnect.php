<?php

/* Alternative php script to access database with exception handling */
require_once 'pdoconfig.php';

try {
    $link = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "Connected to $dbname at $host successfully.";
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

?>
