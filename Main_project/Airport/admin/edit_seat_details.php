<?php
include "../config/dbcon.php";

// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $flightId = $_POST['flight_id'];
    $noEconomy = $_POST['no_economy'];
    $noPremium = $_POST['no_premium'];
    $noBusiness = $_POST['no_business'];
    $noFirst = $_POST['no_first'];

    // Fetch Airbus capacity
    $airbusCapacityQuery = "SELECT airbus.passenger_capacity
                            FROM flight
                            JOIN airbus ON flight.airbus_id = airbus.airbus_id
                            WHERE flight.flight_id = '$flightId'";
    $airbusCapacityResult = mysqli_query($con, $airbusCapacityQuery);
    $airbusCapacity = mysqli_fetch_assoc($airbusCapacityResult)['passenger_capacity'];

    // Calculate total seats
    $totalSeats = $noEconomy + $noPremium + $noBusiness + $noFirst;

    // Check if the total seats exceed the Airbus capacity
    if ($totalSeats > $airbusCapacity) {
        // Store the error message in a session variable
        $_SESSION['error_message'] = 'Error: Total seats exceed Airbus capacity. Please check your input.';
        header("Location: seat_view.php?flight_id=$flightId"); // Redirect back to the edit form
        exit();
    }

    // Update seat details in the database
    $updateSeatDetailsQuery = "UPDATE seat 
                              SET total_seat = '$totalSeats',
                                  no_economy = '$noEconomy',
                                  no_premium = '$noPremium',
                                  no_business = '$noBusiness',
                                  no_first = '$noFirst'
                              WHERE flight_id = '$flightId'";

    if (mysqli_query($con, $updateSeatDetailsQuery)) {
        // Successfully updated seat details
        header("Location: seat_view.php"); // Redirect to the main page or wherever you want to go after the update
        exit();
    } else {
        // Error in updating seat details
        $_SESSION['error_message'] = 'Error updating seat details: ' . mysqli_error($con);
        header("Location: seat_view.php?flight_id=$flightId"); // Redirect back to the edit form
        exit();
    }
}

// Close the database connection
mysqli_close($con);
?>
