<html>
    <head>
            

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



        </main>

    </div>
    </body>


</html>












<?php
include "../config/dbcon.php";

if (isset($_GET['flight_id'])) {
    $id = $_GET['flight_id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission

    // Get flight_id from the form data
    $flight_id = mysqli_real_escape_string($con, $_POST['flight_id']);

    // Get stop type from the form data
    $stop_type = mysqli_real_escape_string($con, $_POST['stopType']);

    // Initialize variables for stop names and durations with empty strings
    $one_stop_name = $one_stop_duration = $two_stop_name = $two_stop_duration = $three_stop_name = $three_stop_duration = $four_stop_name = $four_stop_duration = '';

    switch ($stop_type) {
        case 'one_stop':
            $one_stop_name = mysqli_real_escape_string($con, $_POST['one_stop_name']);
            $one_stop_duration = mysqli_real_escape_string($con, $_POST['one_layover_duration']);
            // Insert data into the stop table for one_stop
            $insert_query = "INSERT INTO stop (stop_type, one_stop_name, one_stop_layover_duration, flight_id)
                            VALUES ('$stop_type', '$one_stop_name', '$one_stop_duration', '$flight_id')";
            break;

        case 'two_stop':
            $one_stop_name = mysqli_real_escape_string($con, $_POST['one_stop_name']);
            $one_stop_duration = mysqli_real_escape_string($con, $_POST['one_layover_duration']);
            $two_stop_name = mysqli_real_escape_string($con, $_POST['two_stop_name']);
            $two_stop_duration = mysqli_real_escape_string($con, $_POST['two_layover_duration']);
            // Insert data into the stop table for two_stop
            $insert_query = "INSERT INTO stop (stop_type, one_stop_name, one_stop_layover_duration, 
                            two_stop_name, two_stop_layover_duration, flight_id)
                            VALUES ('$stop_type', '$one_stop_name', '$one_stop_duration', 
                                    '$two_stop_name', '$two_stop_duration', '$flight_id')";
            break;

        case 'three_stop':
            $one_stop_name = mysqli_real_escape_string($con, $_POST['one_stop_name']);
            $one_stop_duration = mysqli_real_escape_string($con, $_POST['one_layover_duration']);
            $two_stop_name = mysqli_real_escape_string($con, $_POST['two_stop_name']);
            $two_stop_duration = mysqli_real_escape_string($con, $_POST['two_layover_duration']);
            $three_stop_name = mysqli_real_escape_string($con, $_POST['three_stop_name']);
            $three_stop_duration = mysqli_real_escape_string($con, $_POST['three_layover_duration']);
            // Insert data into the stop table for three_stop
            $insert_query = "INSERT INTO stop (stop_type, one_stop_name, one_stop_layover_duration, 
                            two_stop_name, two_stop_layover_duration, 
                            three_stop_name, three_stop_layover_duration, flight_id)
                            VALUES ('$stop_type', '$one_stop_name', '$one_stop_duration', 
                                    '$two_stop_name', '$two_stop_duration', 
                                    '$three_stop_name', '$three_stop_duration', '$flight_id')";
            break;

        case 'four_stop':
            $one_stop_name = mysqli_real_escape_string($con, $_POST['one_stop_name']);
            $one_stop_duration = mysqli_real_escape_string($con, $_POST['one_layover_duration']);
            $two_stop_name = mysqli_real_escape_string($con, $_POST['two_stop_name']);
            $two_stop_duration = mysqli_real_escape_string($con, $_POST['two_layover_duration']);
            $three_stop_name = mysqli_real_escape_string($con, $_POST['three_stop_name']);
            $three_stop_duration = mysqli_real_escape_string($con, $_POST['three_layover_duration']);
            $four_stop_name = mysqli_real_escape_string($con, $_POST['four_stop_name']);
            $four_stop_duration = mysqli_real_escape_string($con, $_POST['four_layover_duration']);
            // Insert data into the stop table for four_stop
            $insert_query = "INSERT INTO stop (stop_type, one_stop_name, one_stop_layover_duration, 
                            two_stop_name, two_stop_layover_duration, 
                            three_stop_name, three_stop_layover_duration, 
                            four_stop_name, four_stop_layover_duration, flight_id)
                            VALUES ('$stop_type', '$one_stop_name', '$one_stop_duration', 
                                    '$two_stop_name', '$two_stop_duration', 
                                    '$three_stop_name', '$three_stop_duration', 
                                    '$four_stop_name', '$four_stop_duration', '$flight_id')";
            break;

        default:
            // Handle other cases or set a default query if needed
            break;
    }

    // Check if insert_query is set before proceeding
    if (isset($insert_query)) {
        // For debugging, echo the SQL query
        echo $insert_query;

        // Execute the insert query
        if (mysqli_query($con, $insert_query)) {
            echo "Stop data inserted successfully";
        } else {
            echo "Error inserting stop data: " . mysqli_error($con);
        }
    } else {
        echo "Error: Invalid stop type.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stop Form</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: auto;
        }

        label, select {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            text-align: left;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .stop-fields {
            display: none;
            margin-top: 10px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<br><br>
<div class="container mt-5">
    <form id="stopForm" method="post" action="stop.php">
        <!-- Add a hidden input field to store flight_id -->
        <input type="hidden" name="flight_id" value="<?php echo $id; ?>">

        <label for="stopType">Select Stop Type:</label>
        <select id="stopType" name="stopType" onchange="showFields(this.value)">
           <option ></option>
            <option value="non_stop">Non-Stop</option>
            <option value="one_stop">One Stop</option>
            <option value="two_stop">Two Stop</option>
            <option value="three_stop">Three Stop</option>
            <option value="four_stop">Four Stop</option>
        </select>

        <!-- One Stop Fields -->
        <div class="stop-fields" id="one_stop_fields">
            <label for="one_stop_name">Layover stop one:</label>

            <select name="one_stop_name" id="one_stop_name" required>
                <option></option>
                <?php
                if (isset($_GET['flight_id'])) {

                    $airport_query = "SELECT `airport_id`, `airport_name`, `airport_location`, `status` FROM `airport` WHERE `status` = 1 AND `airport_location` NOT IN (SELECT `f_arrival` FROM `flight` WHERE `f_arrival` IS NOT NULL and flight_id = '$id') AND `airport_location` NOT IN (SELECT `f_departure` FROM `flight` WHERE `f_departure` IS NOT NULL and flight_id = '$id')";
                    $airport_result = mysqli_query($con, $airport_query);

                    while ($row = mysqli_fetch_array($airport_result)) {
                        echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="one_layover_duration"> One stop Layover Duration (Hours):</label>
            <select name="one_layover_duration" required>
                <option></option>
                <option value="0.5">0.5 </option>
                <option value="1">1 </option>
                <!-- Add other options as needed -->
            </select>
        </div>

        <!-- Two Stop Fields -->
        <div class="stop-fields" id="two_stop_fields">

        <label for="one_stop_name">Layover stop one:</label>
        <select name="one_stop_name" id="one_stop_name" required>
            <option></option>
            <?php
            if (isset($_GET['flight_id'])) {

                $airport_query = "SELECT `airport_id`, `airport_name`, `airport_location`, `status` FROM `airport` WHERE `status` = 1 AND `airport_location` NOT IN (SELECT `f_arrival` FROM `flight` WHERE `f_arrival` IS NOT NULL and flight_id = '$id') AND `airport_location` NOT IN (SELECT `f_departure` FROM `flight` WHERE `f_departure` IS NOT NULL and flight_id = '$id')";
                $airport_result = mysqli_query($con, $airport_query);

                while ($row = mysqli_fetch_array($airport_result)) {
                    echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                }
            }
            ?>
        </select>
        <label for="one_layover_duration"> One stop Layover Duration (Hours):</label>
        <select name="one_layover_duration" required>
            <option></option>
            <option value="0.5">0.5 </option>
            <option value="1">1 </option>
            <!-- Add other options as needed -->
        </select>


            <label for="two_stop_name">Layover stop Two:</label>
            <select name="two_stop_name" id="two_stop_name" required>
                <option></option>
                <?php
                if (isset($_GET['flight_id'])) {

                    $airport_query = "SELECT `airport_id`, `airport_name`, `airport_location`, `status` FROM `airport` WHERE `status` = 1 AND `airport_location` NOT IN (SELECT `f_arrival` FROM `flight` WHERE `f_arrival` IS NOT NULL and flight_id = '$id') AND `airport_location` NOT IN (SELECT `f_departure` FROM `flight` WHERE `f_departure` IS NOT NULL and flight_id = '$id')";
                    $airport_result = mysqli_query($con, $airport_query);

                    while ($row = mysqli_fetch_array($airport_result)) {
                        echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="two_layover_duration">Two Layover Duration (Hours):</label>
            <select name="two_layover_duration" required>
                <option></option>
                <option value="0.5">0.5 </option>
                <option value="1">1 </option>
                <!-- Add other options as needed -->
            </select>
        </div>

        <!-- Three Stop Fields -->
        <div class="stop-fields" id="three_stop_fields">


        <label for="one_stop_name">Layover stop one:</label>
        <select name="one_stop_name" id="one_stop_name" required>
            <option></option>
            <?php
            if (isset($_GET['flight_id'])) {

                $airport_query = "SELECT `airport_id`, `airport_name`, `airport_location`, `status` FROM `airport` WHERE `status` = 1 AND `airport_location` NOT IN (SELECT `f_arrival` FROM `flight` WHERE `f_arrival` IS NOT NULL and flight_id = '$id') AND `airport_location` NOT IN (SELECT `f_departure` FROM `flight` WHERE `f_departure` IS NOT NULL and flight_id = '$id')";
                $airport_result = mysqli_query($con, $airport_query);

                while ($row = mysqli_fetch_array($airport_result)) {
                    echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                }
            }
            ?>
        </select>
        <label for="one_layover_duration"> One stop Layover Duration (Hours):</label>
        <select name="one_layover_duration" required>
            <option></option>
            <option value="0.5">0.5 </option>
            <option value="1">1 </option>
            <!-- Add other options as needed -->
        </select>


            <label for="two_stop_name">Layover stop Two:</label>
            <select name="two_stop_name" id="two_stop_name" required>
                <option></option>
                <?php
                if (isset($_GET['flight_id'])) {

                    $airport_query = "SELECT `airport_id`, `airport_name`, `airport_location`, `status` FROM `airport` WHERE `status` = 1 AND `airport_location` NOT IN (SELECT `f_arrival` FROM `flight` WHERE `f_arrival` IS NOT NULL and flight_id = '$id') AND `airport_location` NOT IN (SELECT `f_departure` FROM `flight` WHERE `f_departure` IS NOT NULL and flight_id = '$id')";
                    $airport_result = mysqli_query($con, $airport_query);

                    while ($row = mysqli_fetch_array($airport_result)) {
                        echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="two_layover_duration">Two Layover Duration (Hours):</label>
            <select name="two_layover_duration" required>
                <option></option>
                <option value="0.5">0.5 </option>
                <option value="1">1 </option>
                <!-- Add other options as needed -->
            </select>

            <label for="three_stop_name">Layover stop Three:</label>

            <select name="three_stop_name" id="three_stop_name" required>
                <option></option>
                <?php
                if (isset($_GET['flight_id'])) {

                    $airport_query = "SELECT `airport_id`, `airport_name`, `airport_location`, `status` FROM `airport` WHERE `status` = 1 AND `airport_location` NOT IN (SELECT `f_arrival` FROM `flight` WHERE `f_arrival` IS NOT NULL and flight_id = '$id') AND `airport_location` NOT IN (SELECT `f_departure` FROM `flight` WHERE `f_departure` IS NOT NULL and flight_id = '$id')";
                    $airport_result = mysqli_query($con, $airport_query);

                    while ($row = mysqli_fetch_array($airport_result)) {
                        echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="three_layover_duration"> Three stop Layover Duration (Hours):</label>
            <select name="three_layover_duration" required>
                <option></option>
                <option value="0.5">0.5 </option>
                <option value="1">1 </option>
                <!-- Add other options as needed -->
            </select>
        </div>

        <!-- Four Stop Fields -->
        <div class="stop-fields" id="four_stop_fields">

        <label for="one_stop_name">Layover stop one:</label>
        <select name="one_stop_name" id="one_stop_name" required>
            <option></option>
            <?php
            if (isset($_GET['flight_id'])) {

                $airport_query = "SELECT `airport_id`, `airport_name`, `airport_location`, `status` FROM `airport` WHERE `status` = 1 AND `airport_location` NOT IN (SELECT `f_arrival` FROM `flight` WHERE `f_arrival` IS NOT NULL and flight_id = '$id') AND `airport_location` NOT IN (SELECT `f_departure` FROM `flight` WHERE `f_departure` IS NOT NULL and flight_id = '$id')";
                $airport_result = mysqli_query($con, $airport_query);

                while ($row = mysqli_fetch_array($airport_result)) {
                    echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                }
            }
            ?>
        </select>
        <label for="one_layover_duration"> One stop Layover Duration (Hours):</label>
        <select name="one_layover_duration" required>
            <option></option>
            <option value="0.5">0.5 </option>
            <option value="1">1 </option>
            <!-- Add other options as needed -->
        </select>


            <label for="two_stop_name">Layover stop Two:</label>
            <select name="two_stop_name" id="two_stop_name" required>
                <option></option>
                <?php
                if (isset($_GET['flight_id'])) {

                    $airport_query = "SELECT `airport_id`, `airport_name`, `airport_location`, `status` FROM `airport` WHERE `status` = 1 AND `airport_location` NOT IN (SELECT `f_arrival` FROM `flight` WHERE `f_arrival` IS NOT NULL and flight_id = '$id') AND `airport_location` NOT IN (SELECT `f_departure` FROM `flight` WHERE `f_departure` IS NOT NULL and flight_id = '$id')";
                    $airport_result = mysqli_query($con, $airport_query);

                    while ($row = mysqli_fetch_array($airport_result)) {
                        echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="two_layover_duration">Two Layover Duration (Hours):</label>
            <select name="two_layover_duration" required>
                <option></option>
                <option value="0.5">0.5 </option>
                <option value="1">1 </option>
                <!-- Add other options as needed -->
            </select>

            <label for="three_stop_name">Layover stop Three:</label>

            <select name="three_stop_name" id="three_stop_name" required>
                <option></option>
                <?php
                if (isset($_GET['flight_id'])) {

                    $airport_query = "SELECT `airport_id`, `airport_name`, `airport_location`, `status` FROM `airport` WHERE `status` = 1 AND `airport_location` NOT IN (SELECT `f_arrival` FROM `flight` WHERE `f_arrival` IS NOT NULL and flight_id = '$id') AND `airport_location` NOT IN (SELECT `f_departure` FROM `flight` WHERE `f_departure` IS NOT NULL and flight_id = '$id')";
                    $airport_result = mysqli_query($con, $airport_query);

                    while ($row = mysqli_fetch_array($airport_result)) {
                        echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="three_layover_duration"> Three stop Layover Duration (Hours):</label>
            <select name="three_layover_duration" required>
                <option></option>
                <option value="0.5">0.5 </option>
                <option value="1">1 </option>
                <!-- Add other options as needed -->
            </select>

            <label for="four_stop_name">Layover stop four:</label>

            <select name="four_stop_name" id="four_stop_name" required>
                <option></option>
                <?php
                if (isset($_GET['flight_id'])) {

                    $airport_query = "SELECT `airport_id`, `airport_name`, `airport_location`, `status` FROM `airport` WHERE `status` = 1 AND `airport_location` NOT IN (SELECT `f_arrival` FROM `flight` WHERE `f_arrival` IS NOT NULL and flight_id = '$id') AND `airport_location` NOT IN (SELECT `f_departure` FROM `flight` WHERE `f_departure` IS NOT NULL and flight_id = '$id')";
                    $airport_result = mysqli_query($con, $airport_query);

                    while ($row = mysqli_fetch_array($airport_result)) {
                        echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="four_layover_duration">Four Stop Layover Duration (Hours):</label>
            <select name="four_layover_duration" required>
                <option></option>
                <option value="0.5">0.5 </option>
                <option value="1">1 </option>
                <!-- Add other options as needed -->
            </select>
        </div>

        <button type="submit" name="sub">Submit</button>
    </form>
</div>

<script>

    function showFields(stopType) {
        hideAllFields();

        // Show fields based on selected stop type
        document.getElementById(stopType + '_fields').style.display = 'block';

        // Hide all subsequent fields
        var types = ['one_stop', 'two_stop', 'three_stop', 'four_stop'];
        var found = false;

        for (var i = 0; i < types.length; i++) {
            if (found) {
                document.getElementById(types[i] + '_fields').style.display = 'none';
            } else if (types[i] === stopType) {
                found = true;
            }
        }
    }

    function hideAllFields() {
        var fields = document.getElementsByClassName('stop-fields');
        for (var i = 0; i < fields.length; i++) {
            fields[i].style.display = 'none';
        }
    }
</script>

</script>

</body>
</html>
