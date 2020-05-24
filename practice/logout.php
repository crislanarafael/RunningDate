<?php

/* Project utilized some Tutorial Republic source code to understand how to implment a login/registration system
Link: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */
// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login.php");
exit;
?>
