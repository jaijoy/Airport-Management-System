<?php
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Journey</title>
  <style>
    /* Styles for the table */
    table {
      border-collapse: collapse;
      width: 60%;
      margin-left: 20%;
      margin-bottom: 20px;
      border-radius: 5px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
    }
    th {
      background-color: #f2f2f2;
      font-weight: bold;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    /* Styles for the card-like section */
    .card-section {
      background-color: #f2f2f2;
      border-radius: 5px;
      padding: 10px;
      width: 60%;
      margin-left: 20%;
      padding-left:120px ;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-section h2 {
      margin-bottom: 5px;
    }
    .arrow {
      display: inline-block;
      width: 0;
      height: 0;
      border-top: 10px solid transparent;
      border-bottom: 10px solid transparent;
      border-right: 15px solid black;
      margin: 0 10px;
    }
  </style>
</head>
<body>
  <br><br><br><br><br><br><br><br>

  <?php
  include "../config/dbcon.php";
  // Check if the email and booking ID are set in the URL parameters
  if (isset($_GET['book_reference_id']) ) {
    
    
$mail =$_SESSION['auth_user']['email'];


    $b_ref_id  = $_GET['book_reference_id'];
    $_SESSION['book_reference_id'] = $b_ref_id;

    $sql = "SELECT bo.total_human, bo.book_reference_id, pd.full_name AS passenger_name, bo.email,
    pd.gender, pd.date_of_birth, pd.nationality, pd.email as individual_email ,pd.passport_id, pd.occupation,
    pd.contact_number, pd.emergency_contact_number, p.depa_date, p.payment_date,p.payment_id,p.checkin_status,
    f.flight_name,f.f_departure,f.f_arrival, al.airline_name AS airline_name, a.airbus_name AS airbus_name, 
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
    WHERE p.payment = 1 
    AND bo.book_reference_id = '$b_ref_id'
    AND p.checkin_status = '0'";


    $result = $con->query($sql);

    if ($result->num_rows > 0) {
      // Fetch departure and arrival data
      $row = $result->fetch_assoc();
      $departure_name = $row["departure_airport"];
      $departure_location = $row["departure_location"];
      $arrival_name = $row["arrival_airport"];
      $arrival_location = $row["arrival_location"];
      $departure_date = $row["depa_date"];
      $departure_time = $row["departure_time"];
      $arrival_time = $row["arrival_time"];
      $book_reference_id=$row["book_reference_id"];
      $payment_id=$row["payment_id"];
      $_SESSION['payment_id']=$payment_id;
      $_SESSION['book_reference_id'] = $book_reference_id;

      // // Debugging output
      echo "Departure DateTime: $departure_date $departure_time<br>";
      $departure_timestamp = strtotime("$departure_date $departure_time");  // Convert departure date and time to timestamp
      echo "Departure Timestamp: $departure_timestamp<br>";
      $current_time = time();  // Current system time in seconds
      echo "Current Time: $current_time<br>";

      $checkin_start_timestamp = $departure_timestamp - (60 * 60 * 4);  // 4 hours before departure
      echo "Check-in Start Timestamp: $checkin_start_timestamp<br>";

      $checkin_end_timestamp = $departure_timestamp - (60 * 60);  // 1 hour before departure
      echo "Check-in End Timestamp: $checkin_end_timestamp<br>";

      if ($current_time >= $checkin_start_timestamp && $current_time < $checkin_end_timestamp) {
        // Check-in available
        $checkin_link = "#"; // Set your check-in link here
        $checkin_message = "Online check-in is available. Check-in will close in " . round(($checkin_end_timestamp - $current_time) / (60 * 60)) . " hours.";
      } else {
        // Check-in not available
        $checkin_link = "#"; // Set your check-in link here
        $checkin_message = "Online check-in is not available at the moment.";
      }

      echo "Check-in Message: $checkin_message<br>";

      // Rest of your HTML and PHP code here
      ?>
      <div class="card-section">
        <h2 style="display: inline-block; margin-right: 10px;">Your Journey</h2>
        <p style="display: inline-block;"><?php echo $departure_date ?></p>
        <p><?php echo $departure_name; ?>, <?php echo $departure_location ." |". $departure_time. "-------->" ; ?>    <?php echo $arrival_name; ?>, <?php echo $arrival_location." |".$arrival_time; ?> </p>
        <p>Flight: <?php echo $row["flight_name"]; ?> | Airline: <?php echo $row["airline_name"]; ?> | Airbus: <?php echo $row["airbus_name"]; ?></p>
        <!-- <p><?php //echo $checkin_message; ?></p> -->
        <div style="text-align: center;">
           <a href="interface_two.php" class="btn btn-primary">Start Check-in</a>
        </div>
      </div>

      <table>
        <tr>
          <th>Passenger Name</th>
          <th>Passport ID</th>
          <th>Nationality</th>
          <th>Gender</th>
          <th>Email</th>
          <th>Phone Number</th>
        </tr>
        <?php
        // Output passenger details in table rows
        echo "<tr>";
        echo "<td>".$row["passenger_name"]."</td>";
        echo "<td>".$row["passport_id"]."</td>";
        echo "<td>".$row["nationality"]."</td>";
        echo "<td>".$row["gender"]."</td>";
        echo "<td>".$row["individual_email"]."</td>";
        echo "<td>".$row["contact_number"]."</td>";
        echo "</tr>";

        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>".$row["passenger_name"]."</td>";
          echo "<td>".$row["passport_id"]."</td>";
          echo "<td>".$row["nationality"]."</td>";
          echo "<td>".$row["gender"]."</td>";
          echo "<td>".$row["individual_email"]."</td>";
          echo "<td>".$row["contact_number"]."</td>";
          echo "</tr>";
        }
        ?>

      </table>
      <?php
    } else {
      echo '<script>alert("Error! Please Try Again");</script>';
    }
  }
  $con->close();
  ?>

</body>
</html>
