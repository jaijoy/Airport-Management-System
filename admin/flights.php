
<?php
include("includes/base.php");
include "../config/dbcon.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo $id;
    
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Flight Form</title>
    <link rel="stylesheet" type="text/css" href="css/flights.css">
</head>

<body>


    <div id="formModal" class="modal">
        <div class="modal-content">
            <span onclick="closeFormModal()" style="float: right; cursor: pointer;">&times;</span>
            <div class="container">
            <form action="#" method="post">
                    

                        <div class="form-group">
                            <label for="airbus_name">Airbus Name:</label>
                            <select name="airbus_name" id="airbus_name">
                                <?php

                                if (isset($_GET['id'])) {
                                    
                                    $airline_id = $_GET['airline_id'];
                                    $airbus_query = "SELECT airbus_id, airbus_name FROM airbus WHERE airline_id = '$id'";
                                    $airbus_result = mysqli_query($con, $airbus_query);
                                    if (mysqli_num_rows($airbus_result) > 0) {
                                        $output = '';
                                        while ($row = mysqli_fetch_array($airbus_result)) {
                                            $output .= "<option value='" . $row['airbus_id'] . "'>" . $row['airbus_name'] . "</option>";
                                        }
                                        echo $output;
                                    } else {
                                        echo "No airbus found for this airline.";
                                    }
                                } else {
                                    echo "Airline ID not set.";
                                }
                    
                                
                                
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="flight_name">Flight Name:</label>
                            <input type="text" id="flight_names" name="Flight_name">
                        </div>

                        <div class="form-group">
                            <label for="departure_location">Departure Location:</label>
                            <select name="departure_location" id="departure_location">
                                <?php
                                $airport_query = "SELECT * FROM airport";
                                $airport_result = mysqli_query($con, $airport_query);
                                while ($row = mysqli_fetch_array($airport_result)) {
                                    echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_location'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="arrival_location">Arrival Location:</label>
                            <select name="arrival_location" id="arrival_location">
                                <?php
                                mysqli_data_seek($airport_result, 0);
                                while ($row = mysqli_fetch_array($airport_result)) {
                                    echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_location'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="stop">Stop:</label>
                            <select name="stop" id="stop">
                                <option value="one_stop">One Stop</option>
                                <option value="one_stop">Two Stop</option>
                                <option value="one_stop">Three Stop</option>
                                <option value="one_stop">Four Stop</option>
                                <option value="non_stop">Non Stop</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="flight_service">Flight Service Type:</label>
                            <select name="flight_service" id="flight_service">
                                <option value="International">International</option>
                                <option value="Cargo">Cargo</option>
                                <option value="Domestic">Domestic</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="text" id="price" name="price">
                        </div>

                
                        <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

    <?php


include "../config/dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flight_name = $_POST['Flight_name']; // Corrected to match the name attribute in the HTML form
    $airline_id = $_POST['airline'];
    $airbus_id = $_POST['airbus_name'];
    $departure_location = $_POST['departure_location'];
    $arrival_location = $_POST['arrival_location'];
    $stop = $_POST['stop'];
    $flight_service = $_POST['flight_service'];
    $price = $_POST['price'];

    $insert_query = "INSERT INTO flight (flight_name, f_airline_name, f_airbus_name, f_departure, f_arrival, airline_id, airport_id, airbus_id, stop, flight_service, price) VALUES ('$flight_name', (SELECT airline_name FROM airline WHERE airline_id = $airline_id), (SELECT airbus_name FROM airbus WHERE airbus_id = $airbus_id), (SELECT airport_location FROM airport WHERE airport_id = $departure_location), (SELECT airport_location FROM airport WHERE airport_id = $arrival_location), $airline_id, $departure_location, $airbus_id, '$stop', '$flight_service', $price)";

    if (mysqli_query($con, $insert_query)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
    }
}




$select_query = "SELECT * FROM flight";
$result = mysqli_query($con, $select_query);

$serial_no = 1; // Initialize the serial number

?>

    <h2>Flight Details</h2>

    <table>
        <tr>
            <th>SI No</th>
            <th>Flight Name</th>
            <th>Airline Name</th>
            <th>Airbus Name</th>
            <th>Departure Location</th>
            <th>Arrival Location</th>
            <th>Stop</th>
            <th>Flight Service</th>
            <th>Price</th>
            <th>Edit</th> 
            <th>Enable/Disable</th>
        </tr>
        <?php while ($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $serial_no; ?></td>
                <td><?php echo $row['flight_name']; ?></td>
                <td><?php echo $row['f_airline_name']; ?></td>
                <td><?php echo $row['f_airbus_name']; ?></td>
                <td><?php echo $row['f_departure']; ?></td>
                <td><?php echo $row['f_arrival']; ?></td>
                <td><?php echo $row['stop']; ?></td>
                <td><?php echo $row['flight_service']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><a href="edit_flight.php?flight_id=<?php echo $row['flight_id']; ?>">Edit</a></td>
                <td><button>Enable/Disable</button></td>
            </tr>
            <?php $serial_no++; // Increment the serial number in each iteration ?>
        <?php } ?>
    </table>

    
    <button onclick="openFormModal()">Add Flight</button>
    

    <script>
        function openFormModal() {
            document.getElementById("formModal").style.display = "block";
        }

        function closeFormModal() {
            document.getElementById("formModal").style.display = "none";
        }

        // Update the link to include the flight_id without refreshing the page
        function editFlight(flightId) {
            // Assuming you have an edit_flight.php page for editing flights
            window.location.href = "edit_flight.php?flight_id=" + flightId;
        }
    </script>

</body>

</html>


































