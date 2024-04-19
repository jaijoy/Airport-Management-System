<?php
// Start the session
session_start();

include("includes/base.php");
include "../config/dbcon.php";

$mail =$_SESSION['auth_user']['email'];

// Check if the email is set in the session
if (!isset($_SESSION['auth_user']['email'])) {
    // Retrieve the email from the session
    header("Location: login.php"); // Redirect to your login page
    exit();
}
// Initialize variables to track previously displayed book_reference_id
$prevBookRefId = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Journey Details</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      margin-top: 150px;
    }
    .card {
      border: 1px solid rgba(0, 0, 0, 0.125);
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px; /* Added margin for spacing between cards */
    }
    .card-header {
      background-color: #007bff;
      color: #fff;
      border-radius: 10px 10px 0 0;
    }
    .card-body {
      padding: 20px;
    }
    .form-group {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title text-center mb-0">Your Journey </h5>
        </div>
        <div class="card-body">
        <form action="interface_one.php" method="GET">
    <div class="form-group">
        <center><label for="email"></label><?php echo $mail; ?></center>
    </div>
    <?php
  date_default_timezone_set('Asia/Kolkata');


   // Calculate the time 4 hours before the departure time
   // Calculate the current time
$currentDateTime = date('Y-m-d H:i:s');

// Calculate the time 4 hours before the departure time
$fourHoursBeforeDeparture = date('Y-m-d H:i:s', strtotime('-4 hours'));

// Calculate the time of the next 4 hours from the current time
$fourHoursAfterCurrent = date('Y-m-d H:i:s', strtotime('+4 hours'));

// SQL query with the condition to check for future departure dates and times within 4 hours
$sql = "SELECT bo.total_human, bo.book_reference_id, pd.full_name AS passenger_name, bo.email,
            pd.gender, pd.date_of_birth, pd.nationality, pd.email as individual_email ,pd.passport_id, pd.occupation,
            pd.contact_number, pd.emergency_contact_number, p.depa_date, p.payment_date,
            f.flight_name, al.airline_name AS airline_name, a.airbus_name AS airbus_name, 
            dep.airport_name AS departure_airport, dep.airport_location AS departure_location,
            arr.airport_name AS arrival_airport, arr.airport_location AS arrival_location,
            s.departure_time, s.arrival_time, s.gate_departure, s.gate_arrival 
            FROM payment p 
            JOIN book_one bo ON p.book_id = bo.book_id 
            JOIN passenger_details pd ON pd.book_id = bo.book_id 
            JOIN flight f ON bo.flight_id = f.flight_id 
            JOIN airbus a ON f.airbus_id = a.airbus_id 
            JOIN airline al ON f.airline_id = al.airline_id
            JOIN airport dep ON f.f_departure = dep.airport_id 
            JOIN airport arr ON f.f_arrival = arr.airport_id
            JOIN schedule s ON f.flight_id = s.flight_id 
            WHERE p.payment = '1' AND p.checkin_status = '0'
            AND CONCAT(p.depa_date, ' ', s.departure_time) > '$currentDateTime'";
           

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Check if the current book_reference_id is different from the previous one
            if ($row["book_reference_id"] !== $prevBookRefId) {
                // Display details in a card
                echo "<div class='card'>";
                echo "<div class='card-body'>";
                echo "<p>Departure Date: " . $row["depa_date"] ." ".$row["departure_time"]. "</p>";
                echo "<p>Departure Airport: " . $row["departure_airport"] . "</p>";
                echo "<p>Arrival Airport: " . $row["arrival_airport"] . "</p>";
                echo "</div>";

                // Pass the book_reference_id through the URL as a query parameter
                echo "<div class='text-center'>";
                echo "<a href='interface_one.php?book_reference_id=" . $row["book_reference_id"] . "' class='btn btn-primary'>Check IN</a>";
                echo "</div>";

                echo "</div>";
            }
            // Update prevBookRefId with the current book_reference_id
            $prevBookRefId = $row["book_reference_id"];
        }
      } else {
        echo "No upcoming journeys within 4 hours from now.";
    }

    $con->close();
    ?>
</form>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery
