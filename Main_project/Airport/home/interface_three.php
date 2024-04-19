<?php
// Assuming you have already connected to your database
// Start the session
session_start();

include("includes/base.php");
include "../config/dbcon.php";

// Check if the email is set in the session
if (!isset($_SESSION['auth_user']['email'])) {
    // Retrieve the email from the session
    header("Location: login.php"); // Redirect to your login page
    exit();
}

// Include QR Code library
require_once('phpqrcode/qrlib.php');

$book_reference_id = $_SESSION['book_reference_id'];
// echo $b_ref_id;

// Execute your SQL query to fetch the boarding pass data
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
    WHERE p.payment = 1 AND bo.book_reference_id = '$book_reference_id'";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Output the boarding pass HTML for each passenger
    while ($row = $result->fetch_assoc()) {
        $passenger_name = $row["passenger_name"];
        $flight_name = $row["flight_name"];
        $airline_name = $row["airline_name"];
        $airbus_name = $row["airbus_name"];
        $departure_date = date("Y-m-d", strtotime($row["depa_date"]));
        $seat_number = "10A"; // Example seat number
        $departure_airport = $row["departure_airport"];
        $arrival_airport = $row["arrival_airport"];
        $departure_time = strtotime($row["departure_time"]); // Convert to Unix timestamp
        $boarding_time = date("h:i A", strtotime('-1 hour', $departure_time)); // Calculate boarding time
        $arrival_time = $row["arrival_time"];
        $gate_departure = $row["gate_departure"];
        $gate_arrival = $row["gate_arrival"];

        
        // Generate QR code
        $qrCodeText = "FLYEASY <br> Passenger: $passenger_name \n Flight: $flight_name | Airline: $airline_name | Airbus: $airbus_name\nDeparture: $departure_airport\nDestination: $arrival_airport\nBoarding Time: $boarding_time\nDeparture Time: " . date("h:i A", $departure_time) . "\nArrival Time: $arrival_time\nGate Departure: $gate_departure
        \nGate Arrival: $gate_arrival";
        $qrCodePath = 'phpqrcode/qrcode/' . $passenger_name . '_boarding_pass.png';
        QRcode::png($qrCodeText, $qrCodePath);

        // Output the boarding pass HTML for each passenger
        echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Boarding Pass</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .boarding-pass {
      width: 400px;
      margin: 20px auto;
      padding: 20px;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      position: relative;
    }
    .pass-header {
      text-align: center;
      margin-bottom: 20px;
    }
    .pass-header h1 {
      font-size: 24px;
      margin: 0;
      color: #333;
    }
    .pass-info {
      margin-bottom: 20px;
      color: #555;
    }
    .pass-info p {
      margin: 5px 0;
    }
    .pass-barcode {
      text-align: center;
      margin-top: 20px;
    }
    .pass-barcode img {
      width: 200px;
      height: auto;
      display: block;
      margin: 0 auto;
    }
    .pass-footer {
      text-align: center;
      margin-top: 20px;
      color: #888;
    }
    .pass-info,
    .pass-footer {
      background-color: #f0f0f0;
      padding: 10px;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="boarding-pass">
    <div class="pass-header">
      <h1>FLYEASY</h1>
    </div>
    <div class="pass-info">
      <p><strong>Passenger: ' . $passenger_name . '</strong></p>
      <p>Departure Date: ' . $departure_date . '</p>
      <p>Flight: ' . $flight_name . ' | Airline: ' . $airline_name . ' | Airbus: ' . $airbus_name . '</p>
      <p>Departure: ' . $departure_airport . '</p>
      <p>Destination: ' . $arrival_airport . '</p>
      <p>Boarding Time: ' . $boarding_time . '</p>
      <p>Departure Time: ' . date("h:i A", $departure_time) . '</p>
      <p>Arrival Time: ' . $arrival_time . '</p>
      <p>Gate Departure: ' . $gate_departure . '</p>
      <p>Gate Arrival: ' . $gate_arrival . '</p>
    </div>
    <div class="pass-barcode">
      <img src="' . $qrCodePath . '" alt="Boarding Pass QR Code">
    </div>
    <div class="pass-footer">
      Have a pleasant flight!
    </div>

    

  </div>
 

</body>
</html>';
    }
} else {
    echo "No boarding pass data found.";
}

$con->close();
?>
