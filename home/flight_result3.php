



<?php
include "../config/dbcon.php";
?>

<?php
include("includes/base.php");
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Details</title>
    <!-- Add these lines to include jQuery and jQuery UI -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container-fluid {
            padding: 30px;
        }

        .airline-filter,
        .stop-filter,
        .price-filter,
        .search-form {
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .filter-heading {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .form-check {
            margin-bottom: 10px;
        }

        .flight-table {
            margin-top: 30px;
        }
        .selected-airlines {
        font-weight: bold;
    }
        /* Add your custom styles here */
        /* .hero-section {
            background: url(images/back1.jpg) center/cover no-repeat;
            color: #fff;
            font-weight: bold;
            color: #fff;
            text-align: center;
            padding: 150px 20px;
            
        } */
        .search-form {
            max-width: 600px;
            margin: 0 auto;
            
        }
    </style>
</head>

<body><br><br><br><br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Search Bar -->
                <div class="search-form">
                    <form class="form-inline mb-4">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search" id="searchInput">
                        <button class="btn btn-primary my-2 my-sm-0" type="button" onclick="searchFlights()">Search</button>
                    </form>
                </div><br>

                <!-- Price Filter -->
                <div class="price-filter">
                <h5 class="filter-heading">Sort by price</h5>

                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="priceSort" id="lowToHigh" value="asc" onchange="sortFlightsByPrice()" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="lowToHigh">Low to High</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="priceSort" id="highToLow" value="desc" onchange="sortFlightsByPrice()" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'desc') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="highToLow">High to Low</label>
                    </div>
                </div>

                <!-- Airline Filter -->
                <div class="airline-filter">
                <h5 class="filter-heading">Airline Filter</h5>
                <?php
                $airlineQuery = "SELECT DISTINCT flight.airline_id, airline.airline_name 
                                FROM flight
                                JOIN airline ON flight.airline_id = airline.airline_id
                                WHERE flight.`status` = '1'
                                ORDER BY airline.airline_name ASC";

                $airlineResult = mysqli_query($con, $airlineQuery);

                if (!$airlineResult) {
                    die("Error in SQL query: " . mysqli_error($con));
                }

                while ($airlineRow = mysqli_fetch_assoc($airlineResult)) {
                    echo '<div class="form-check mb-2">';
                    echo '<input type="checkbox" class="form-check-input airline-checkbox" id="airline_' . $airlineRow['airline_id'] . '" value="' . $airlineRow['airline_name'] . '" onclick="filterByAirline()">';
                    echo '<label class="form-check-label" for="airline_' . $airlineRow['airline_id'] . '">' . $airlineRow['airline_name'] . '</label>';
                    echo '</div>';
                }
                ?>
            </div>


                <!-- Stop Filter -->
                <div class="stop-filter">
                    <h5 class="filter-heading">Stop Details Filter</h5>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input stop-checkbox" id="oneStop" value="one stop" onclick="filterByStop()">
                        <label class="form-check-label" for="oneStop">One Stop</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input stop-checkbox" id="twoStop" value="two stop" onclick="filterByStop()">
                        <label class="form-check-label" for="twoStop">Two Stops</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input stop-checkbox" id="threeStop" value="three stop" onclick="filterByStop()">
                        <label class="form-check-label" for="threeStop">Three Stops</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input stop-checkbox" id="fourStop" value="four stop" onclick="filterByStop()">
                        <label class="form-check-label" for="threeStop">Three Stops</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input stop-checkbox" id="nonStop" value="non stop" onclick="filterByStop()">
                        <label class="form-check-label" for="threeStop">Three Stops</label>
                    </div>

                    <!-- Add more checkboxes for additional stop details -->
                </div>
            </div>

            <!-- Price Filter -->























            


            <div class="col-md-9">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Flight Search</h5>
            <form action="#" method="get">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="departure_location">Departure Location:</label>
                        <select class="form-control custom-select" name="departure_location" id="departure_location" required>
                            <option value="" disabled selected>Select Departure Location</option>
                            <?php
                            $airport_query = "SELECT * FROM airport WHERE `status`=1";
                            $airport_result = mysqli_query($con, $airport_query);
                            while ($row = mysqli_fetch_array($airport_result)) {
                                echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="destination_location">Destination City:</label>
                        <select class="form-control custom-select" name="destination_location" id="destination_location" required>
                            <option value="" disabled selected>Select Destination City</option>
                            <?php
                            $airport_query ="SELECT * FROM airport WHERE `status`=1";
                            $airport_result = mysqli_query($con, $airport_query);
                            while ($row = mysqli_fetch_array($airport_result)) {
                                echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="departureDate">Departure Date:</label>
                        <input type="date" class="form-control" id="departureDate" required>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label></label>
                        <button type="submit" class="btn btn-primary btn-block">Search Flights</button>
                    </div>
                </div>
            </form>
        </div>
    </div>































            
                

                <!-- Flight Details Table -->
                <div class="flight-table">
                    <h2 class="mb-4">Flight Details</h2>
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
                    


                    $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'asc'; // Default to ascending order if not specified

// Get the selected departure and destination locations from the form
$departureLocation = isset($_GET['departure_location']) ? mysqli_real_escape_string($con, $_GET['departure_location']) : '';
$destinationLocation = isset($_GET['destination_location']) ? mysqli_real_escape_string($con, $_GET['destination_location']) : '';

// Construct the base query
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
            destination_airport.airport_location AS destination_airport_location,
            airline.airline_name AS airline_name,
            airbus.airbus_name AS airbus_name  -- Include the airbus_name column
            FROM flight
            INNER JOIN schedule ON flight.flight_id = schedule.flight_id
            INNER JOIN seat ON flight.flight_id = seat.flight_id
            LEFT JOIN onestop ON flight.flight_id = onestop.flight_id
            LEFT JOIN twostop ON flight.flight_id = twostop.flight_id
            LEFT JOIN threestop ON flight.flight_id = threestop.flight_id
            JOIN airport AS departure_airport ON flight.f_departure = departure_airport.airport_id
            JOIN airport AS destination_airport ON flight.f_arrival = destination_airport.airport_id
            JOIN airline ON flight.airline_id = airline.airline_id
            JOIN airbus ON flight.airbus_id = airbus.airbus_id  -- Join with the airbus table
            WHERE flight.status = '1'";

// Add conditions for filtering based on user input
if (!empty($departureLocation) && !empty($destinationLocation)) {
    $query .= " AND departure_airport.airport_id = '$departureLocation' AND destination_airport.airport_id = '$destinationLocation'";
}

// Add the sorting part of the query
$query .= " ORDER BY flight.price $sortOrder, flight.flight_id ASC";





                
                    $result = mysqli_query($con, $query);
                
                    if (!$result) {
                        die("Error in SQL query: " . mysqli_error($con));
                    }
                
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>{$row['flight_name']}</td>";
                                echo "<td>{$row['airline_name']}</td>";
                                echo "<td>{$row['airbus_name']}</td>";
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
                        
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        searchFlights();
    });

    function searchFlights() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementsByTagName("table")[0];
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            // Skip the first row (header row)
            td = tr[i].getElementsByTagName("td");
            var found = false;
            for (var j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break; // Break if the search term is found in any column
                    }
                }
            }
            tr[i].style.display = found ? "" : "none";
        }
    }

    function filterByAirline() {
    var selectedAirlines = [];
    var checkboxes = document.getElementsByClassName('airline-checkbox');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            selectedAirlines.push(checkboxes[i].value);
        }
    }

    var table, tr, airline, i;
    table = document.getElementsByTagName("table")[0];
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        airline = tr[i].getElementsByTagName("td")[1].textContent || tr[i].getElementsByTagName("td")[1].innerText;

        if (selectedAirlines.length === 0 || selectedAirlines.includes(airline)) {
            tr[i].style.display = "";  // Show the row
            tr[i].classList.add('selected-airlines');
        } else {
            tr[i].style.display = "none";  // Hide the row
            tr[i].classList.remove('selected-airlines');
        }
    }
}





    function filterByStop() {
        var selectedStops = [];
        var checkboxes = document.getElementsByClassName('stop-checkbox');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selectedStops.push(checkboxes[i].value);
            }
        }

        var table, tr, stops, i;
        table = document.getElementsByTagName("table")[0];
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            stops = tr[i].getElementsByTagName("td")[7].textContent || tr[i].getElementsByTagName("td")[7].innerText;

            if (selectedStops.length === 0 || selectedStops.includes(stops)) {
                tr[i].style.display = "";  // Show the row
            } else {
                tr[i].style.display = "none";  // Hide the row
            }
        }
    }

    function sortFlightsByPrice() {
    var selectedSort = document.querySelector('input[name="priceSort"]:checked');
    if (selectedSort) {
        window.location.href = "flight_result3.php?sort=" + selectedSort.value;
    }
}




</script>
</body>
</html>
