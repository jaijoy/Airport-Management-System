<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page or any other desired page
header("Location: ../home/login.php"); // Replace "login.php" with your login page URL
exit();
?>