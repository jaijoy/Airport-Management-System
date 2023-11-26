<?php
include "../config/dbcon.php";
?>

<?php
include("includes/base.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- seacrch chyumbol varanehh -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4"><br><br>
    <h2>Flight Details</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
            <tr>
                <th>Flight Name</th>
                <th>Airline Name</th>
                <th>Airbus Name</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Stop</th>
                <th>Price (INR)</th>
                <th>Seat</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Collect form data
    if(isset($_GET["departure_location"]))
    {
        $from = mysqli_real_escape_string($con, $_GET['departure_location']);
    }
    if(isset($_GET["destination_location"])){
        $to = mysqli_real_escape_string($con, $_GET['destination_location']);
    }

    
    $query = "SELECT flight.*, 
    schedule.departure_time, 
    schedule.arrival_time, 
    seat.no_economy, 
    seat.no_premium, 
    seat.no_business, 
    seat.no_first, 
    onestop.layover_duration, 
    onestop.layover_stop, 
    twostop.f_duration, 
    twostop.f_stop, 
    twostop.s_duration, 
    twostop.s_stop, 
    threestop.f_duration as t_f_duration, 
    threestop.f_stop as t_f_stop, 
    threestop.s_duration as t_s_duration, 
    threestop.s_stop as t_s_stop, 
    threestop.t_duration, 
    threestop.t_stop,
    departure_airport.airport_name AS departure_airport_name,
    departure_airport.airport_location AS departure_airport_location,
    destination_airport.airport_name AS destination_airport_name,
    destination_airport.airport_location AS destination_airport_location
    FROM flight
    INNER JOIN schedule ON flight.flight_id = schedule.flight_id
    INNER JOIN seat ON flight.flight_id = seat.flight_id
    LEFT JOIN onestop ON flight.flight_id = onestop.flight_id
    LEFT JOIN twostop ON flight.flight_id = twostop.flight_id
    LEFT JOIN threestop ON flight.flight_id = threestop.flight_id
    JOIN airport AS departure_airport ON flight.f_departure = departure_airport.airport_id
    JOIN airport AS destination_airport ON flight.f_arrival = destination_airport.airport_id
    WHERE flight.f_departure = '$from' AND flight.f_arrival = '$to'";

    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Error in SQL query: " . mysqli_error($con));
    }

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['flight_name']}</td>";
                echo "<td>{$row['f_airline_name']}</td>";
                echo "<td>{$row['f_airbus_name']}</td>";
                echo "<td>{$row['departure_airport_name']} ({$row['departure_airport_location']})</td>";
                echo "<td>{$row['destination_airport_name']} ({$row['destination_airport_location']})</td>";
                echo "<td>{$row['departure_time']}</td>";
                echo "<td>{$row['arrival_time']}</td>";
                echo "<td>{$row['stop']}</td>";
                echo "<td>{$row['price']}</td>";
                echo "<td>
                    <a href='#' class='btn btn-primary' data-toggle='modal' data-target='#seatDetailsModal{$row['flight_id']}'>Seat Details</a>";
                
                if (!empty($row['layover_duration'])) {
                    // Show Layover Details if layover is present
                    echo "<a href='#' class='btn btn-info' data-toggle='modal' data-target='#layoverDetailsModal{$row['flight_id']}'>stop one Details</a>";
                }

                

                if (!empty($row['s_duration'])) {
                    // Show Second Stop Details if the second stop is present
                    echo "<a href='#' class='btn btn-info' data-toggle='modal' data-target='#secondStopDetailsModal{$row['flight_id']}'>Second Stop Details</a>";
                }

                if (!empty($row['t_f_duration'])) {
                    // Show Third Stop Details if the third stop is present
                    echo "<a href='#' class='btn btn-info' data-toggle='modal' data-target='#thirdStopDetailsModal{$row['flight_id']}'>Third Stop Details</a>";
                }
                
                echo "</td>";

                // Modal for Seat Details
                 echo "<div class='modal fade' id='seatDetailsModal{$row['flight_id']}' tabindex='-1' role='dialog' aria-labelledby='seatDetailsModalLabel' aria-hidden='true'>
                 <div class='modal-dialog' role='document'>
                     <div class='modal-content'>
                         <div class='modal-header'>
                             <h5 class='modal-title' id='seatDetailsModalLabel'>Seat Details</h5>
                             <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                 <span aria-hidden='true'>&times;</span>
                             </button>
                         </div>
                         <div class='modal-body'>
                             <p>Economy Seats: {$row['no_economy']}</p>
                             <p>Premium Seats: {$row['no_premium']}</p>
                             <p>Business Seats: {$row['no_business']}</p>
                             <p>First Class Seats: {$row['no_first']}</p>
                         </div>
                         <div class='modal-footer'>
                             <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                         </div>
                     </div>
                 </div>
             </div>";

                 // Modal for First Stop Details
                echo "<div class='modal fade' id='layoverDetailsModal{$row['flight_id']}' tabindex='-1' role='dialog' aria-labelledby='layoverDetailsModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='layoverDetailsModalLabel'>stop one Details</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <p>Layover Duration: {$row['layover_duration']}</p>
                            <p>Layover Stop: {$row['layover_stop']}</p>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </div>
                </div>
            </div>";

               
                

                // Modal for Second Stop Details
                echo "<div class='modal fade' id='secondStopDetailsModal{$row['flight_id']}' tabindex='-1' role='dialog' aria-labelledby='secondStopDetailsModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='secondStopDetailsModalLabel'>Two Stop Details</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                        <p>First Stop Duration: {$row['f_duration']}</p>
                        <p>First Stop: {$row['f_stop']}</p>
                        <p>Second Stop Duration: {$row['s_duration']}</p>
                        <p>Second Stop: {$row['s_stop']}</p>
                           
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </div>
                </div>
            </div>";

                // Modal for Third Stop Details
                echo "<div class='modal fade' id='thirdStopDetailsModal{$row['flight_id']}' tabindex='-1' role='dialog' aria-labelledby='thirdStopDetailsModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='thirdStopDetailsModalLabel'>Three Stop Details</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                        <p>First Stop Duration: {$row['t_f_duration']}</p>
                        <p>First Stop: {$row['t_f_stop']}</p>
                        <p>Second Stop Duration: {$row['t_s_duration']}</p>
                        <p>Second Stop: {$row['t_s_stop']}</p>
                        <p>Third Stop Duration: {$row['t_duration']}</p>
                        <p>Third Stop: {$row['t_stop']}</p>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        </div>
                    </div>
                </div>
            </div>";

                echo "<td><a href='book.php?flight_id={$row['flight_id']}' class='btn btn-primary'>Book Now</a></td>";

                echo "</tr>";
            }
        }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
