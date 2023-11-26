<?php
include "../config/dbcon.php";
include("includes/base.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
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
            .view{
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
    <div id="formModal" class="modal">
        <div class="modal-content">
            <span onclick="closeFormModal()" style="float: right; cursor: pointer;">&times;</span>
            <div class="container">
            <form action="#" method="post" onsubmit="return validateLocations()">
                    

                        <div class="form-group">
                            <h1>Add Flight Deatails</h1><br><br>
                            <label for="airbus_name">Airbus Name:</label>
                            <select name="airbus_name" id="airbus_name" required>
                                <?php

                                if (isset($_GET['id'])) {
                                    
                                    $airline_id = $_GET['airline_id'];
                                    $airbus_query = "SELECT airbus_id, airbus_name FROM airbus WHERE airline_id = '$id' and `status`=0";
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
                            <input type="text" id="flight_names" name="Flight_name" required>
                            <div id="flight_name_error" style="color: red;"></div>
                        </div>

                        <div class="form-group">
                            <label for="departure_location">Departure Location:</label>
                            <select name="departure_location" id="departure_location" required>
                                <option></option>
                                <?php
                                $airport_query = "SELECT * FROM airport where `status`=1";
                                $airport_result = mysqli_query($con, $airport_query);
                                while ($row = mysqli_fetch_array($airport_result)) {
                                    echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="arrival_location">Arrival Location:</label>
                            <select name="arrival_location" id="arrival_location" required>
                                <option></option>
                                <?php
                                mysqli_data_seek($airport_result, 0);
                                while ($row = mysqli_fetch_array($airport_result)) {
                                    echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name']. $row['airport_location'] . "</option>";
                                }
                                ?>
                            </select>
                            <div id="error_message" style="color: red;"></div>
                        </div>

                        <div class="form-group">
                            <label for="stop">Stop:</label>
                            <select name="stop" id="stop" required>
                                <option></option>
                                <option value="one stop">One Stop</option>
                                <option value="two stop">Two Stop</option>
                                <option value="three stop">Three Stop</option>
                                <option value="four stop">Four Stop</option>
                                <option value="non stop">Non Stop</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="flight_service">Flight Service Type:</label>
                            <select name="flight_service" id="flight_service" required>
                                <option></option>
                                <option value="International">International</option>
                                <option value="Cargo">Cargo</option>
                                <option value="Domestic">Domestic</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price">Price (INR):</label>
                            <input type="text" id="price" name="price" required>
                            <div id="price_error" style="color: red;"></div>

                        </div>

                
                        <input type="submit" value="ADD">
                        <a href="flights.php" class="view">VIEW DETAILS</a>

                </form>
            </div>
        </div>
    </div>

    </body>
    <script>

document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("departure_location").addEventListener("change", validateLocations);
        document.getElementById("arrival_location").addEventListener("change", validateLocations);
    });

    function validateLocations() {
        var departureLocation = document.getElementById("departure_location").value;
        var arrivalLocation = document.getElementById("arrival_location").value;
        var errorMessage = document.getElementById("error_message");

        if (departureLocation === arrivalLocation) {
            errorMessage.textContent = "Departure and arrival locations cannot be the same. Please choose different locations.";
        } else {
            errorMessage.textContent = "";
        }
    }



    
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("price").addEventListener("input", validatePrice);
    });

    function validatePrice() {
        var priceInput = document.getElementById("price").value;
        var errorMessage = document.getElementById("price_error");

        var pricePattern = /^\d+$/;
        if (!pricePattern.test(priceInput)) {
            errorMessage.textContent = "Price must contain number.";
        } else if (priceInput < 5000 || priceInput > 20000) {
            errorMessage.textContent = "Price must be between 5000 and 20000.";
        } else {
            errorMessage.textContent = "";
        }
    }


    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("flight_names").addEventListener("input", validateFlightName);
    });

    function validateFlightName() {
        var flightNameInput = document.getElementById("flight_names").value;
        var errorMessage = document.getElementById("flight_name_error");

        var flightNamePattern = /^[a-zA-Z][a-zA-Z0-9\s]{2,}$/;
        if (!flightNamePattern.test(flightNameInput)) {
            errorMessage.textContent = "Flight name must start with an alphabet and can only contain numbers or alphabets.";
        } else {
            errorMessage.textContent = "";
        }
    }
</script>
   
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flight_name = $_POST['Flight_name'];
    $airline_id = $_GET['id'];
    $airbus_id = $_POST['airbus_name'];
    $departure_location = $_POST['departure_location'];
    $arrival_location = $_POST['arrival_location'];
    $stop = $_POST['stop'];
    $flight_service = $_POST['flight_service'];
    $price = $_POST['price'];

    // Fetching airport_id for departure and arrival locations
    $departure_airport_query = "SELECT airport_id FROM airport WHERE airport_id = $departure_location";
    $arrival_airport_query = "SELECT airport_id FROM airport WHERE airport_id = $arrival_location";

    $departure_airport_result = mysqli_query($con, $departure_airport_query);
    $arrival_airport_result = mysqli_query($con, $arrival_airport_query);

    $departure_airport_row = mysqli_fetch_assoc($departure_airport_result);
    $arrival_airport_row = mysqli_fetch_assoc($arrival_airport_result);

    $departure_airport_id = $departure_airport_row['airport_id'];
    $arrival_airport_id = $arrival_airport_row['airport_id'];

    // Check if a similar record already exists
    $check_query = "SELECT * FROM flight WHERE flight_name = '$flight_name' ";

    $check_result = mysqli_query($con, $check_query);

    if ($check_result === false) {
        echo "Error: " . mysqli_error($con);
    } else {
        // Check if a similar record already exists
        $num_rows = mysqli_num_rows($check_result);
    
        if ($num_rows > 0) {
            // Display error message in a popup box
            echo "<script>
                    alert('Record with similar values already exists');
                </script>";
        } else {
        // If no similar record exists, insert the new record
        $insert_query = "INSERT INTO flight (flight_name, f_airline_name, f_airbus_name, f_departure, f_arrival, airline_id, airbus_id, stop, flight_service, price) VALUES ('$flight_name', (SELECT airline_name FROM airline WHERE airline_id = $airline_id), (SELECT airbus_name FROM airbus WHERE airbus_id = $airbus_id), $departure_airport_id, $arrival_airport_id, $airline_id, $airbus_id, '$stop', '$flight_service', $price)";

        if (mysqli_query($con, $insert_query)) {
            // Display success message in a popup box
            echo "<script>
                    alert('New record created successfully');
                </script>";
        } else {
            // Display error message in a popup box
            echo "<script>
                    alert('Error: " . mysqli_error($con) . "');
                </script>";
      
          }
    }
}
}
?>

