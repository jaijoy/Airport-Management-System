<?php

include("includes/base.php");
include "../config/dbcon.php";

// Check if flight_id is set and fetch existing flight details
if (isset($_GET['flight_id'])) {
    $flightId = $_GET['flight_id'];

    // Fetch existing flight details
    $editFlightQuery = "SELECT * FROM flight WHERE flight_id = $flightId";
    $editFlightResult = mysqli_query($con, $editFlightQuery);

    if ($editFlightResult && mysqli_num_rows($editFlightResult) > 0) {
        $flightData = mysqli_fetch_assoc($editFlightResult);
    } else {
        echo "Flight not found.";
        exit();
    }
} else {
    echo "Flight ID not set.";
    exit();
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data here if needed

    // Sanitize the data before updating the database to prevent SQL injection
    $flightId = mysqli_real_escape_string($con, $_POST['flight_id']);
    $airbusId = mysqli_real_escape_string($con, $_POST['edit_airbus_name']);
    $flightName = mysqli_real_escape_string($con, $_POST['edit_flight_name']);
    $departureLocation = mysqli_real_escape_string($con, $_POST['edit_departure_location']);
    $arrivalLocation = mysqli_real_escape_string($con, $_POST['edit_arrival_location']);
    //$stop = mysqli_real_escape_string($con, $_POST['edit_stop']);
    $flightService = mysqli_real_escape_string($con, $_POST['edit_flight_service']);
    $price = mysqli_real_escape_string($con, $_POST['edit_price']);

    // Update the flight details in the database
    $checkQuery = "SELECT * FROM flight WHERE
      
        flight_name = '$flightName' AND
        
        flight_id != '$flightId'";

    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "Flight details with similar values already exist.";
    } else {
        // Update the flight details in the database
        $updateFlightQuery = "UPDATE flight SET
            airline_id = (SELECT airline_id FROM airbus WHERE airbus_id = '$airbusId'),
            airbus_id = '$airbusId',
            flight_name = '$flightName',
            f_departure = (SELECT airport_location FROM airport WHERE airport_id = '$departureLocation'),
            f_arrival = (SELECT airport_location FROM airport WHERE airport_id = '$arrivalLocation'),
            flight_service = '$flightService',
            price = '$price'
            WHERE flight_id = '$flightId'";

        $updateFlightResult = mysqli_query($con, $updateFlightQuery);

        if ($updateFlightResult) {
            echo "Flight details updated successfully.";
            // Redirect to the flights.php page or any other page as needed
        } else {
            echo "Error updating flight details: " . mysqli_error($con);
        }
    }
}

?>

<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 600px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select,
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .view {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px
        }
    </style>
</head>

<body>

    <div id="editFormModal" class="modal">
        <div class="modal-content">
            <span onclick="closeEditFormModal()" style="float: right; cursor: pointer;">&times;</span>
            <div class="container">
                <form action="#" method="post" onsubmit="return validateLocations()">

                    <!-- Existing flight data to be edited -->
                    <input type="hidden" name="flight_id" value="<?php echo $flightData['flight_id']; ?>">

                    <div class="form-group">
                        <h1>Edit Flight Details</h1><br><br>
                        <label for="edit_airbus_name">Airbus Name:</label>
                        <select name="edit_airbus_name" id="edit_airbus_name" required>
                            <?php
                            // Fetch and display the available airbuses for editing
                            $airlineId = $flightData['airline_id'];
                            $airbus_query = "SELECT airbus_id, airbus_name FROM airbus WHERE airline_id = '$airlineId' and `status`=0";
                            $airbus_result = mysqli_query($con, $airbus_query);

                            if ($airbus_result && mysqli_num_rows($airbus_result) > 0) {
                                $output = '';
                                while ($row = mysqli_fetch_array($airbus_result)) {
                                    $selected = ($row['airbus_id'] == $flightData['airbus_id']) ? 'selected' : '';
                                    $output .= "<option value='" . $row['airbus_id'] . "' $selected>" . $row['airbus_name'] . "</option>";
                                }
                                echo $output;
                            } else {
                                echo "No airbus found for this airline.";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_flight_name">Flight Name:</label>
                        <input type="text" id="edit_flight_name" name="edit_flight_name" value="<?php echo $flightData['flight_name']; ?>" required>
                        <div id="edit_flight_name_error" style="color: red;"></div>
                    </div>

                    <div class="form-group">
                        <label for="edit_departure_location">Departure Location:</label>
                        <select name="edit_departure_location" id="edit_departure_location" required>
                            <option value="<?php echo $flightData['f_departure']; ?>" selected><?php echo $flightData['f_departure']; ?></option>

                            <?php
                            // Fetch and display the available departure locations for editing
                            $airport_query = "SELECT * FROM airport where `status`=1";
                            $airport_result = mysqli_query($con, $airport_query);

                            while ($row = mysqli_fetch_array($airport_result)) {
                                $selected = ($row['airport_id'] == $flightData['f_departure']) ? 'selected' : '';
                                echo "<option value='" . $row['airport_id'] . "' $selected>" . $row['airport_location'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="edit_arrival_location">Arrival Location:</label>
                        <select name="edit_arrival_location" id="edit_arrival_location" required>
                        <option value="<?php echo $flightData['f_arrival']; ?>" selected><?php echo $flightData['f_arrival']; ?></option>

                            <?php
                            // Fetch and display the available arrival locations for editing
                            mysqli_data_seek($airport_result, 0);

                            while ($row = mysqli_fetch_array($airport_result)) {
                                $selected = ($row['airport_id'] == $flightData['arrival_location']) ? 'selected' : '';
                                echo "<option value='" . $row['airport_id'] . "' $selected>" . $row['airport_location'] . "</option>";
                            }
                            ?>
                        </select>
                        <div id="edit_error_message" style="color: red;"></div>
                    </div>

<!--
                    <div class="form-group">
                        <label for="edit_stop">Stop:</label>
                        <select name="edit_stop" id="edit_stop" required>-->
                            <?php
                           //  $stopOptions = array("one stop", "two stop", "three stop", "four stop", "non stop");
                           // foreach ($stopOptions as $option) {
                           // $selected = ($option == $flightData['stop']) ? 'selected' : '';
                           //  echo "<option value='$option' $selected>" . $option . "</option>";
                           // }
                            ?>
                        <!--</select>
                    </div> -->

                    <div class="form-group">
                        <label for="edit_flight_service">Flight Service Type:</label>
                        <select name="edit_flight_service" id="edit_flight_service" required>
                            <?php
                            // Fetch and display the selected flight service type for editing
                            $serviceOptions = array("International", "Cargo", "Domestic");
                            foreach ($serviceOptions as $option) {
                                $selected = ($option == $flightData['flight_service']) ? 'selected' : '';
                                echo "<option value='$option' $selected>" . $option . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_price">Price (INR):</label>
                        <input type="text" id="edit_price" name="edit_price" value="<?php echo $flightData['price']; ?>" required>
                        <div id="edit_price_error" style="color: red;"></div>
                    </div>

                    <input type="submit" value="UPDATE">
                    <a href="flights.php" class="view">VIEW DETAILS</a>

                </form>
            </div>
        </div>
    </div>

    <script>
        // Add your JavaScript code here
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("edit_departure_location").addEventListener("change", validateLocations);
            document.getElementById("edit_arrival_location").addEventListener("change", validateLocations);
            document.getElementById("edit_flight_name").addEventListener("input", validateFlightName);


        });

        function validateLocations() {
            var departureLocation = document.getElementById("edit_departure_location").value;
            var arrivalLocation = document.getElementById("edit_arrival_location").value;
            var errorMessage = document.getElementById("edit_error_message");

            if (departureLocation === arrivalLocation) {
                errorMessage.textContent = "Departure and arrival locations cannot be the same. Please choose different locations.";
            } else {
                errorMessage.textContent = "";
            }
        }

        
    function validateFlightName() {
        var flightNameInput = document.getElementById("edit_flight_name").value;
        var errorMessage = document.getElementById("edit_flight_name_error");

        var flightNamePattern = /^[a-zA-Z][a-zA-Z0-9\s]{2,}$/;
        if (!flightNamePattern.test(flightNameInput)) {
            errorMessage.textContent = "Flight name must start with an alphabet and can only contain numbers or alphabets.";
        } else {
            errorMessage.textContent = "";
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("edit_price").addEventListener("input", validatePrice);
});

function validatePrice() {
    var priceInput = document.getElementById("edit_price").value;
    var errorMessage = document.getElementById("edit_price_error"); // Corrected typo here

    var pricePattern = /^\d+$/;
    if (!pricePattern.test(priceInput)) {
        errorMessage.textContent = "Price must contain numbers only.";
    } else if (priceInput < 5000 || priceInput > 20000) {
        errorMessage.textContent = "Price must be between 5000 and 20000.";
    } else {
        errorMessage.textContent = "";
    }
}

    </script>
</body>

</html>