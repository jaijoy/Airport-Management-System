<?php
    session_start();
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome CSS -->
    <title>Flight Details</title>
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }

        .flight-card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .flight-card h4 {
            color: #007bff;
            margin-bottom: 20px;
        }

        .flight-card p {
            margin-bottom: 10px;
        }

        .flight-icon {
            font-size: 24px;
            margin-right: 10px;
        }

        .btn-book-now {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-book-now:hover {
            background-color: #0056b3;
        }

        .seat-details {
            display: none;
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
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

        // Query to retrieve scheduled flights based on the given criteria
        $flight_query = "SELECT f.flight_id, f.flight_name, a.airline_name, ab.airbus_name, 
        dep_airport.airport_name AS departure_airport, 
        dep_airport.airport_location AS departure_location, 
        arr_airport.airport_name AS arrival_airport, 
        arr_airport.airport_location AS arrival_location, 
        s.departure_time, s.arrival_time, s.gate_departure, s.gate_arrival, 
        f.stop, f.price,
        st.total_seat, st.no_economy, st.no_premium, st.no_business, st.no_first
FROM flight f
JOIN schedule s ON f.flight_id = s.flight_id
JOIN seat st ON f.flight_id = st.flight_id
JOIN airline a ON f.airline_id = a.airline_id
JOIN airbus ab ON f.airbus_id = ab.airbus_id
JOIN airport dep_airport ON f.f_departure = dep_airport.airport_id
JOIN airport arr_airport ON f.f_arrival = arr_airport.airport_id
WHERE s.day_of_week = '$day_of_week'
AND f.f_departure = '$departure_location'
AND f.f_arrival = '$destination_location'
AND f.status = 1";


        $flight_result = mysqli_query($con, $flight_query);

        if (!$flight_result) {
            // If there is an error in the query, display an error message
            die('Error in SQL query: ' . mysqli_error($con));
        }

        // Display the results
        while ($row = mysqli_fetch_assoc($flight_result)) {
            // Display flight information in a card
            echo '<div class="flight-card card">';
            echo '<h4 class="card-title mb-4 text-center"><i class="fas fa-plane flight-icon"></i>' . $row['flight_name'] . '</h4>';
            echo '<p class="card-text "><strong>Airline Name:</strong> ' . $row['airline_name'] . '</p>';
            echo '<p class="card-text "><strong>Airbus Name:</strong> ' . $row['airbus_name'] . '</p>'.'<br>';
            
            // Left-hand side of the card
            echo '<div class="row">';
            echo '<div class="col-md-6">';
            echo '<p class="card-text"><strong>Departure Airport:</strong> ' . $row['departure_airport'] . ' - ' . $row['departure_location'] . '</p>';
            echo '<p class="card-text"><strong>Departure Time:</strong> ' . $row['departure_time'] . '</p>';
            echo '<p class="card-text"><strong>Gate Departure:</strong> ' . $row['gate_departure'] . '</p>';
            echo '</div>';

            // Right-hand side of the card
            echo '<div class="col-md-6">';
            echo '<p class="card-text"><strong>Arrival Airport:</strong> ' . $row['arrival_airport'] . ' - ' . $row['arrival_location'] . '</p>';
            echo '<p class="card-text"><strong>Arrival Time:</strong> ' . $row['arrival_time'] . '</p>';
            echo '<p class="card-text"><strong>Gate Arrival:</strong> ' . $row['gate_arrival'] . '</p>';
            echo '</div>';
            echo '</div>';

            // Middle of the card
            echo '<p class="card-text mt-3"><strong>Stop:</strong> ' . $row['stop'] . '</p>';
            echo '<p class="card-text"><strong>Price:</strong> $' . $row['price'] . '</p>';

            // Book Now button
            $flightId = $row['flight_id'];
            echo '<button class="btn btn-book-now mt-3" onclick="bookNow(' . $flightId . ')">Book Now</button>';
                        
            // Seat Details button
            echo '<button class="btn btn-secondary mt-3" onclick="toggleSeatDetails(' . $row['flight_id'] . ')">Seat Details</button>';
            
            // Seat Details container
            echo '<div class="seat-details" id="seatDetails_' . $row['flight_id'] . '">';
            echo '<p><strong>Total Seats:</strong> ' . $row['total_seat'] . '</p>';
            echo '<p><strong>Economy Class:</strong> ' . $row['no_economy'] . '</p>';
            echo '<p><strong>Premium Class:</strong> ' . $row['no_premium'] . '</p>';
            echo '<p><strong>Business Class:</strong> ' . $row['no_business'] . '</p>';
            echo '<p><strong>First Class:</strong> ' . $row['no_first'] . '</p>';
            echo '</div>';
            
            echo '</div>';
        }
    }

    echo '<script>
            function bookNow(flightId) {
                var seatDetails = document.getElementById("seatDetails_" + flightId);
                seatDetails.style.display = seatDetails.style.display === "none" ? "block" : "none";

                // Check if the user is logged in
                var isLoggedIn = ' . (isset($_SESSION['auth']) ? 'true' : 'false') . ';

                if (isLoggedIn) {
                    // If logged in, redirect to book1.php
                    window.location.href = "book1.php?flightId=" + flightId;
                } else {
                    // If not logged in, redirect to login.php
                    window.location.href = "login.php";
                }
            }
          </script>';
    ?>

    <script>
        function toggleSeatDetails(flightId) {
            var seatDetails = document.getElementById('seatDetails_' + flightId);
            seatDetails.style.display = seatDetails.style.display === 'none' ? 'block' : 'none';
        }
    </script>

</div>

</body>
</html>
