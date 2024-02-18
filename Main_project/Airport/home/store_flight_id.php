<?php
session_start();

// Check if the flightId parameter is provided
if (isset($_POST['flightId'])) {
    // Get and sanitize the flightId
    $flightId = htmlspecialchars($_POST['flightId']);

    // Store the flightId in the session
    $_SESSION['flightId'] = $flightId;

    // Send a JSON response indicating success
    echo json_encode(['success' => true]);
} else {
    // Send a JSON response indicating failure if flightId is not provided
    echo json_encode(['success' => false, 'message' => 'Flight ID not provided']);
}
?>
