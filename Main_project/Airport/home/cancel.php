<?php
session_start();
include "../config/dbcon.php"; // Include your database connection file

$payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : null;
$_SESSION['paymentt_id'] = $payment_id;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_booking'])) {
    // Get user email from session
    $userEmail = $_SESSION['auth_user']['email'];

    // Insert into the cancel table
    $insertQuery = "INSERT INTO cancel (request, payment_id) SELECT 1, payment_id FROM payment WHERE email = '$userEmail' and payment_id = '$payment_id'";
    
    if (mysqli_query($con, $insertQuery)) {
        echo '<script>alert("Cancellation is pending...It will take some time"); window.location.href = "book_details.php";</script>';
    } else {
        echo "Error submitting cancel request: " . mysqli_error($con);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking</title>
</head>
<body>
    <h1>Cancel Booking</h1>
    <p>Credit the amount to the card/bank account used at the time of booking. (Cancellation fee will be charged)</p>
    <form method="POST">
        <button type="submit" name="cancel_booking">Cancel Booking</button>
    </form>
</body>
</html>
