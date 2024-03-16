<?php
session_start();
//include("includes/base.php");
$userEmail = $_SESSION['auth_user']['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flight Details</title>
  <style>
    .bodyy {
      font-family: Arial, sans-serif;
     
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f5f5f5;
    }

    .container {
      max-width: 800px;
      width: 100%;
      padding: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      background-color: #ffffff;
      border-radius: 10px;
    }

    .container_one {
      max-width: 800px;
      width: 95%;
      padding: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      background-color: #ffffff;
      border-radius: 10px;
      display: flex;
      justify-content: space-between; /* Align part 1 and part 2 */
      align-items: center;
    }
    .container_Two {
      max-width: 800px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      padding: 20px;

      width:95%;
      display: flex;
      justify-content: space-between; /* Align part 1, part 2, and part 3 */
      background-color: #ffffff;
      border-radius: 10px;
      overflow: hidden; /* Prevent content from overflowing */
    }
    .card {
      padding: 43px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
      /* text-align: center; Center the content */
    }

    .one {
      margin-bottom: 10px;
      text-align: center;
    }

    .card p {
      margin-bottom: 5px;
    }

    .flight-icon {
      font-size: 40px; /* Adjust the font size as needed */
      text-align: center;
    }

    .button-container {
      display: flex;
      justify-content: space-between;
    }

    .button {
      padding: 10px 20px;
      background-color: #007bff;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-decoration: none;

    }

    .button:hover {
      background-color: #0056b3;
    }
    .tressa{
      background-color: #f44336;
      color: #fff;
      padding: 10px;
      border-radius: 5px;
      text-align: center;
    }
  </style>
</head>
<body class="bodyy">
  <div class="container">
    <div class="card">
      <?php
        // Connect to your database (replace placeholders with actual database credentials)
        include '../config/dbcon.php';
        

        // Query to fetch flight details including departure time, arrival time, day of the week, and payment date
        $sql = "SELECT 
        flight.flight_name, 
        flight.f_airline_name, 
        flight.f_airbus_name, 
        departure_airport.airport_name AS departure_name, 
        departure_airport.airport_location AS departure_location, 
        arrival_airport.airport_name AS arrival_name, 
        arrival_airport.airport_location AS arrival_location,
        schedule.departure_time,
        schedule.arrival_time,
        schedule.day_of_week,
        payment.payment_date,
        payment.payment_id,
        cancel.request
    FROM payment
    JOIN book_one ON payment.book_id = book_one.book_id
    JOIN flight ON book_one.flight_id = flight.flight_id
    JOIN airport AS departure_airport ON flight.f_departure = departure_airport.airport_id
    JOIN airport AS arrival_airport ON flight.f_arrival = arrival_airport.airport_id
    JOIN schedule ON flight.flight_id = schedule.flight_id
    LEFT JOIN cancel ON payment.payment_id = cancel.payment_id
    WHERE payment.payment = 1 AND payment.email = '$userEmail'";

        $result = $con->query($sql);

        if ($result->num_rows > 0) {
          // Output data of each row
          while($row = $result->fetch_assoc()) {
            // Display flight name with flight icon
            echo "<div class=main>";
           
            echo "<h2 class=one>" . "✈️ ". $row["flight_name"] ."</h2><br>";
            echo "<div class=container_one>";
            echo "<div class=part1>";
            echo "<h3 style='color: grey;'>Airline: <span style='color: black;'>" . $row["f_airline_name"] . "</span></h3>";
            echo "<h3 style='color: grey;'>Airbus: <span style='color: black;'>" . $row["f_airbus_name"] . "</span></h3>";
            echo "</div>";

            echo "<div class=part2>";
            echo "<h3 style='color: grey;'>Payment Status: </h3>";
            echo "<h3 style='color: black;'>Completed</h3>";
            echo "</div>";
            echo "</div>";
          
            echo "<div class=container_Two>";
                echo "<div class=part1>";
                     echo "<h3 style='color: grey;'>Departure<br> <span style='color: black;'>".$row["departure_name"] ."<br>".($row["departure_location"]) . "</span></h3>";
                     echo "<h3 style='color: grey;'>Time: <span style='color: black;'>".$row["departure_time"]  . "</span></h3>";

                echo "</div>";
                echo "<div class=part2>";
                    echo "<h2 class=one>" . "✈️ " ."</h2>";

                echo "</div>";
                echo "<div class=part3>";
                    echo "<h3 style='color: grey;'>Arrival<br><span style='color: black;'>" .$row["arrival_name"] ."<br>". ($row["arrival_location"]) . "</span></h3>";
                    echo "<h3 style='color: grey;'>Time: <span style='color: black;'>".$row["arrival_time"]  . "</span></h3>";

                echo "</div>";
            echo "</div>";
            echo "<p>Booked on " . $row["payment_date"] . "</p><br>";

            if ($row["request"] == 1) {
              echo "<div class='button-container'>";
              echo "<h4 class=tressa>Cancellation Pending.</h4>";
              echo "</div>";
            }
            else if ($row["request"] == null) {
              echo "<div class='button-container'>";
              echo "<a href='cancel.php?payment_id=" . $row["payment_id"] . "' class='button'>Cancel Booking</a>";
              echo "</div>";

            }
            else 
            {
              echo "<div class='button-container'>";
              echo "<h4 class=tressa>Booking Cancelled.</h4>";
              echo "</div>";
            }
           
            

            echo "</div>";

          }
        } else {
          echo "No flight found.";
        }

        $con->close();
      ?>
    </div>
    
  </div>
  <script>
    // Disable back button
    history.pushState(null, null, window.location.href);
    window.addEventListener('popstate', function (event) {
        history.pushState(null, null, window.location.href);
    });
</script>
</body>
</html>
