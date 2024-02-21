<?php
// Clear session data and destroy the session
session_start();
if (isset($_SESSION['auth'])) {
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
    session_destroy();
}

// Redirect to the index page after logging out
header('Location: index.php');
exit(); // Terminate the script to prevent further execution

?>
