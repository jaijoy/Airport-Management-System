<?php
include("includes/base.php");
include "../config/dbcon.php";
if (isset($_GET['flight_id'])) {
    $id = $_GET['flight_id'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departureTime = mysqli_real_escape_string($con, $_POST['departureTime']);
    $arrivalTime = mysqli_real_escape_string($con, $_POST['arrivalTime']);
    $flight_id = mysqli_real_escape_string($con, $id); // Assuming $id is the flight_id from the GET parameter

    $checkQuery = "SELECT * FROM schedule WHERE flight_id = '$flight_id'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Schedule already exists, perform appropriate action (display message, redirect, etc.)
        echo "Schedule already exists!";
    } 
    else {
    // Constructing the SQL query
        $insertQuery = "INSERT INTO schedule (flight_id, departure_time, arrival_time) 
                        VALUES ('$flight_id', '$departureTime', '$arrivalTime')";

        // Executing the query
        $result = mysqli_query($con, $insertQuery);

        if ($result) {
            echo "Insertion successful!";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Form</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            margin-left: 30%;
            margin-top: 15%;
            background-color: #fff;
            padding: 49px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
        
            margin: 10px 0;
            color: #333;
            font-size: 16px;
        }

        input[type="time"] {
            width: calc(100% - 20px);
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<form method="POST" action="#">
    <h1>Schedule Details</h1>

    <label for="departureLocation">Departure Location:</label>
    <?php
        $flight_query = "SELECT * FROM flight where `flight_id`='$id' and `status`= 0";
        $flight_result = mysqli_query($con, $flight_query);
        while ($row = mysqli_fetch_array($flight_result)) {
            echo $row['f_departure'];
        }
    ?>
    <br>

    <label for="arrivalLocation">Arrival Location:</label>
    <?php
        $flight_query = "SELECT * FROM flight where `flight_id`='$id' and `status`= 0";
        $flight_result = mysqli_query($con, $flight_query);
        while ($row = mysqli_fetch_array($flight_result)) {
            echo $row['f_arrival'];
        }
    ?>
    <br>

    <label for="departureTime">Departure Time:</label>
    <input type="time" id="departureTime" name="departureTime" required><br>

    <label for="arrivalTime">Arrival Time:</label>
    <input type="time" id="arrivalTime" name="arrivalTime" required><br>

    <button type="submit">Submit</button>
</form>

</body>
</html>


