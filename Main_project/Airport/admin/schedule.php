<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            /* margin: 0;
            padding: 0; */
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 20px;
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            margin: 0;
            color: #666;
        }

        .stop-details {
            display: none;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ccc;
        }

        .show-stop-details {
            margin-top: 15px;
        }

        .add-schedule-btn {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            text-align: center;
        }
    </style>
    <title>Flight Details</title>
</head>
<?php
        include("includes/header.php");
        ?>
<body>


    <div class="container">
    

<?php
include 'includes/header2.php';
?>

<main>

        <div class="row">
            <?php
                include "../config/dbcon.php";

                // Fetch flight details from the database
                $query = "SELECT flight.flight_id, flight_name, airline_name, airbus_name, 
                          departure.airport_name as departure_name, departure.airport_location as departure_location, 
                          arrival.airport_name as arrival_name, arrival.airport_location as arrival_location, 
                          stop, stop.stop_id, stop_type, 
                          stop.one_stop_name, oneStop.airport_name as one_stop_airport_name, oneStop.airport_location as one_stop_airport_location,
                          stop.two_stop_name, twoStop.airport_name as two_stop_airport_name, twoStop.airport_location as two_stop_airport_location,
                          stop.three_stop_name, threeStop.airport_name as three_stop_airport_name, threeStop.airport_location as three_stop_airport_location,
                          stop.four_stop_name, fourStop.airport_name as four_stop_airport_name, fourStop.airport_location as four_stop_airport_location,
                          stop.one_stop_layover_duration, stop.two_stop_layover_duration, stop.three_stop_layover_duration, stop.four_stop_layover_duration
                          FROM flight 
                          INNER JOIN airline ON flight.airline_id = airline.airline_id
                          INNER JOIN airbus ON flight.airbus_id = airbus.airbus_id
                          INNER JOIN airport as departure ON flight.f_departure = departure.airport_id
                          INNER JOIN airport as arrival ON flight.f_arrival = arrival.airport_id
                          LEFT JOIN stop ON flight.flight_id = stop.flight_id
                          LEFT JOIN airport as oneStop ON stop.one_stop_name = oneStop.airport_id
                          LEFT JOIN airport as twoStop ON stop.two_stop_name = twoStop.airport_id
                          LEFT JOIN airport as threeStop ON stop.three_stop_name = threeStop.airport_id
                          LEFT JOIN airport as fourStop ON stop.four_stop_name = fourStop.airport_id";

                $result = mysqli_query($con, $query);

                // Display flight details in cards with buttons
                while ($row = mysqli_fetch_assoc($result)) {
                    $flightId = $row['flight_id'];
                    echo '<div class="col-md-6">';
                    echo '<div class="card">';
                    echo '<h2>' . $row['flight_name'] . '</h2>';
                    echo '<p><strong>Airline:</strong> ' . $row['airline_name'] . '</p>';
                    echo '<p><strong>Airbus:</strong> ' . $row['airbus_name'] . '</p>';
                    echo '<p><strong>Departure:</strong> ' . $row['departure_name'] . ' (' . $row['departure_location'] . ')</p>';
                    echo '<p><strong>Arrival:</strong> ' . $row['arrival_name'] . ' (' . $row['arrival_location'] . ')</p>';
                    echo '<p><strong>Stops:</strong> ' . $row['stop'] . '</p>';

                    // Button to show stop details
                    echo '<button class="show-stop-details btn btn-primary" data-flight-id="' . $flightId . '">Show Stop Details</button>';

                    // Container for stop details
                    echo '<div class="stop-details" id="stop-details-' . $flightId . '">';
                    echo '<p><strong>One Stop Name:</strong> ' . $row['one_stop_airport_name'] . ' (' . $row['one_stop_airport_location'] . ')</p>';
                    echo '<p><strong>One Stop Layover Duration(Hour):</strong> ' . $row['one_stop_layover_duration'] . '</p>';
                    echo '<p><strong>Two Stop Name:</strong> ' . $row['two_stop_airport_name'] . ' (' . $row['two_stop_airport_location'] . ')</p>';
                    echo '<p><strong>Two Stop Layover Duration(Hour):</strong> ' . $row['two_stop_layover_duration'] . '</p>';
                    echo '<p><strong>Three Stop Name:</strong> ' . $row['three_stop_airport_name'] . ' (' . $row['three_stop_airport_location'] . ')</p>';
                    echo '<p><strong>Three Stop Layover Duration(Hour):</strong> ' . $row['three_stop_layover_duration'] . '</p>';
                    echo '<p><strong>Four Stop Name:</strong> ' . $row['four_stop_airport_name'] . ' (' . $row['four_stop_airport_location'] . ')</p>';
                    echo '<p><strong>Four Stop Layover Duration(Hour):</strong> ' . $row['four_stop_layover_duration'] . '</p>';
                    echo '</div>';

                    // View Details button
                    echo '<a href="schedule_form.php?flight_id=' . $flightId . '" class="btn btn-success add-schedule-btn">Add Schedule</a>';

                    echo '</div>';
                    echo '</div>';
                }
            ?>
        </div>
</main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // JavaScript to handle button click and toggle stop details visibility
        const showStopButtons = document.querySelectorAll('.show-stop-details');

        showStopButtons.forEach(button => {
            button.addEventListener('click', () => {
                const flightId = button.getAttribute('data-flight-id');
                const stopDetails = document.getElementById(`stop-details-${flightId}`);
                stopDetails.style.display = stopDetails.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>

</body>
</html>
