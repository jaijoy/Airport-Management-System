<?php
session_start();
include "../config/dbcon.php";

if (isset($_POST["changePasswordBtn"])) {
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmNewPassword = $_POST["confirmNewPassword"];

    // Fetch the hashed password from the database
    $email = $_SESSION['auth_user']['email'];

    // Hash the current password for verification
    $op = password_hash($currentPassword, PASSWORD_DEFAULT);

    // Hash the new password for storage
    $np = password_hash($newPassword, PASSWORD_DEFAULT);

    // Check if the hashed current password matches the one in the database
    $sql = "SELECT pass1 FROM users WHERE `email`='$email'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $userdata = mysqli_fetch_assoc($result);
        $hashedPasswordFromDB = $userdata['pass1'];

        // Verify the current password
        if (password_verify($currentPassword, $hashedPasswordFromDB)) {
            // Update the password in the database with the hashed new password
            $sql_2 = "UPDATE users SET pass1='$np' WHERE `email`='$email'";
            mysqli_query($con, $sql_2);

            echo "Password updated successfully";
        } else {
            echo "Incorrect current password";
        }
    } else {
        echo "User not found or database error";
    }
}
?>
