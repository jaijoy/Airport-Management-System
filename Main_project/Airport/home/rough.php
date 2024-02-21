<?php
include "../config/dbcon.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve user inputs
    $departure_location = $_GET['departure_location'];
    $destination_location = $_GET['destination_location'];
    $departure_date = $_GET['departureDate'];

    // Get the day of the week from the selected date
    $day_of_week = date('l', strtotime($departure_date));

    // Debugging: Display selected inputs and day of the week
    echo "Departure Location: $departure_location <br>";
    echo "Destination Location: $destination_location <br>";
    echo "Departure Date: $departure_date <br>";
    echo "Day of the Week: $day_of_week <br>";

    // Query to retrieve scheduled flights based on the given criteria
    $flight_query = "SELECT f.* FROM flight f
                 JOIN schedule s ON f.flight_id = s.flight_id
                 WHERE s.day_of_week = '$day_of_week'
                 AND f.f_departure = '$departure_location'
                 AND f.f_arrival = '$destination_location'
                 AND f.status = 1";


    // Debugging: Display the generated SQL query
    echo "SQL Query: $flight_query <br>";

    $flight_result = mysqli_query($con, $flight_query);

    // Display the results
    while ($row = mysqli_fetch_array($flight_result)) {
        // Display flight information here
        echo "Flight ID: " . $row['flight_id'] . "<br>";
        echo "Flight Name: " . $row['flight_name'] . "<br>";
        // Add other flight details as needed
        echo "<hr>";
    }
}
?>
