<?php
include("stop.php");

if (isset($_GET['flight_id'])) {
    $id = $_GET['flight_id'];
    echo $id;
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Form for onestop table</title>
    <style>
         body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            height: 494px;
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* max-width: 600px; */
            width: 94%;
            box-sizing: border-box;
        }

        h2, h3 {
            color: #0b3958;
        }

        .one {
            display: flex;
            width: 250px;
            flex-direction: column;
            margin-bottom: 20px;
        }
        .two{
            display: flex;
            flex-direction: column;
            margin-bottom: -20px;
            width: 250px;
            margin-top: -249px;
            margin-left: 258px;
        }

        .three{
            display: flex;
            flex-direction: column;
            margin-bottom: 9px;
            width: 250px;
            margin-top: -239px;
            margin-left: 528px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        select, input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"], .view_but {
            background-color: #0b3958;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        input[type="submit"]:hover, .view_but:hover {
            background-color: #2980b9;
        }
    </style>


</head>

<body>

    <form action="#" method="post" onsubmit="return validateLocations()">
        <h2>Three Stop Details</h2>
        <div id="edit_error_message" style="color: red;"></div>

        <div class="one">
        <h3>Enter details of stop one</h3>
        <label for="layover_duration">Layover Duration (Hours):</label>
        <select name="layover_duration" required>
            <option></option>
            <option value="0.5">0.5 </option>
            <option value="1">1 </option>
            <option value="1.5">1.5</option>
            <option value="2">2</option>
            <option value="2.5">2.5</option>
            <option value="3">3</option>
            <option value="3.5">3.5</option>
            <option value="4">4</option>
            <option value="4.5">4.5</option>
            <option value="5">5</option>
            <option value="5.5">5.5</option>
            <option value="6">6</option>
            <option value="6.5">6.5</option>
            <option value="7">7</option>
            <option value="7.5">7.5</option>
            <option value="8">8</option>
            <option value="8.5">8.5</option>
            <option value="9">9</option>
            <option value="9.5">9.5</option>
            <option value="10">10</option>
            <option value="10.5">10.5</option>
            <option value="11">11</option>
            <option value="11.5">11.5</option>
            <option value="12.5">12</option>

        </select>
        
        Layover Stop:
        <select name="departure_location" id="departure_location" required>
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
        </div>
        
        <div class="two">
        <h3>Enter details of stop two</h3>
        <label for="layover_duration">Layover Duration (Hours):</label>
        <select name="layover_duration2" required>
            <option></option>
            <option value="0.5">0.5 </option>
            <option value="1">1 </option>
            <option value="1.5">1.5</option>
            <option value="2">2</option>
            <option value="2.5">2.5</option>
            <option value="3">3</option>
            <option value="3.5">3.5</option>
            <option value="4">4</option>
            <option value="4.5">4.5</option>
            <option value="5">5</option>
            <option value="5.5">5.5</option>
            <option value="6">6</option>
            <option value="6.5">6.5</option>
            <option value="7">7</option>
            <option value="7.5">7.5</option>
            <option value="8">8</option>
            <option value="8.5">8.5</option>
            <option value="9">9</option>
            <option value="9.5">9.5</option>
            <option value="10">10</option>
            <option value="10.5">10.5</option>
            <option value="11">11</option>
            <option value="11.5">11.5</option>
            <option value="12.5">12</option>

        </select>

        <label for="departure_location">Layover Stop:</label>
        <select name="departure_location2" id="departure_location2" required>
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
        </div>


        <div class="three">
        <h3>Enter details of stop three</h3>
        <label for="layover_duration">Layover Duration (Hours):</label>
        <select name="layover_duration3" required>
            <option></option>
            <option value="0.5">0.5 </option>
            <option value="1">1 </option>
            <option value="1.5">1.5</option>
            <option value="2">2</option>
            <option value="2.5">2.5</option>
            <option value="3">3</option>
            <option value="3.5">3.5</option>
            <option value="4">4</option>
            <option value="4.5">4.5</option>
            <option value="5">5</option>
            <option value="5.5">5.5</option>
            <option value="6">6</option>
            <option value="6.5">6.5</option>
            <option value="7">7</option>
            <option value="7.5">7.5</option>
            <option value="8">8</option>
            <option value="8.5">8.5</option>
            <option value="9">9</option>
            <option value="9.5">9.5</option>
            <option value="10">10</option>
            <option value="10.5">10.5</option>
            <option value="11">11</option>
            <option value="11.5">11.5</option>
            <option value="12.5">12</option>

        </select>

        Layover Stop:
        <select name="departure_location3" id="departure_location3" required>
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
        </div>
        <input type="submit" value="Add"><br><br>
        <a href="twostop_view.php" class="view_but">view details</a>

    </form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("departure_location").addEventListener("change", validateLocations);
    document.getElementById("departure_location2").addEventListener("change", validateLocations);
    document.getElementById("departure_location3").addEventListener("change", validateLocations);

});

function validateLocations() {
    var departureLocation = document.getElementById("departure_location").value;
    var departureLocation2 = document.getElementById("departure_location2").value;
    var departureLocation3 = document.getElementById("departure_location3").value;

    var errorMessage = document.getElementById("edit_error_message");

    if (departureLocation === departureLocation2) {
        errorMessage.textContent = "Stop one and Stop two locations cannot be the same. Please choose different locations.";
    }else if (departureLocation === departureLocation3) {
        errorMessage.textContent = "Stop one and Stop three locations cannot be the same. Please choose different locations.";
    }else if(departureLocation2==departureLocation3){
        errorMessage.textContent = "Stop two and Stop three locations cannot be the same. Please choose different locations.";
    }
     else  {
        errorMessage.textContent = "";
    }
}

</script>

</body>

</html>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $layover_duration = $_POST['layover_duration'];
    $departure_location = $_POST['departure_location'];
    $layover_duration2 = $_POST['layover_duration2'];
    $departure_location2 = $_POST['departure_location2'];
    $layover_duration3 = $_POST['layover_duration3'];
    $departure_location3 = $_POST['departure_location3'];

    // Assuming you have the flight_id available, either through a GET parameter or another method
    $flight_id = $_GET['flight_id']; // Adjust this according to your actual method of obtaining the flight_id

    // Check if the flight name already exists in the 'twostop' table
    $check_query = "SELECT COUNT(*) FROM threestop WHERE flight_id = '$flight_id'";
    $result = mysqli_query($con, $check_query);
    $row = mysqli_fetch_array($result);

    if ($row[0] > 0) {
        echo "Error: Flight name already exists";
    } else {
        // Insert data into the 'twostop' table
        $insert_query = "INSERT INTO threestop (flight_id, f_duration, f_stop, s_duration, s_stop,t_duration, t_stop) 
                         VALUES ('$flight_id', '$layover_duration', '$departure_location', '$layover_duration2', '$departure_location2', '$layover_duration3', '$departure_location3')";

        if (mysqli_query($con, $insert_query)) {
            echo "Records inserted successfully.";
        } else {
            echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
        }
    }
}

// Close the database connection
mysqli_close($con);
?>