<?php

/* Project utilized some Tutorial Republic source code to understand how to implment a login/registration system
Link: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('server', 'localhost');
define('username', 'root');
define('password', 'itsaulgoodman');
define('name', 'practice_database');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(server, username, password, name);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
