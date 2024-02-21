<?php
// update_total_economy_price.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the AJAX request
    $numEconomySeats = isset($_POST['numEconomySeats']) ? intval($_POST['numEconomySeats']) : 0;
    $economyPrice = isset($_POST['economyPrice']) ? floatval($_POST['economyPrice']) : 0;

    // Calculate total economy price
    $totalEconomyPrice = $numEconomySeats * $economyPrice;

    // Send the calculated total economy price back to the client
    echo $totalEconomyPrice;
} else {
    // Handle invalid request method (if needed)
    echo "Invalid request method.";
}
?>
