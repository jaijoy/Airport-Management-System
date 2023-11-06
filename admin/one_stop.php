<?php
include("includes/base.php");
include "../config/dbcon.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form for onestop table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<form action="#" method="post">
            <label for="airline">Airline:</label>
                <select name="airline" id="airline">
                     <?php
                         $airline_query = "SELECT * FROM airline";
                         $airline_result = mysqli_query($con, $airline_query);
                        while ($row = mysqli_fetch_array($airline_result)) {
                            echo "<option value='" . $row['airline_id'] . "'>" . $row['airline_name'] . "</option>";
                         }
                        ?>
                    </select>
    Flight Name: 
    <select name="flight_id" id="flight_id">
    <?php
        $flight_query = "SELECT * FROM flight";
        $flight_result = mysqli_query($con, $flight_query);
        while ($row = mysqli_fetch_array($flight_result)) {
            echo "<option value='" . $row['flight_id'] . "'>" . $row['flight_name'] . "</option>";
        }
    ?>
</select><br><br>
   
    Layover Duration: <input type="text" name="layover_duration"><br><br>
    Layover Stop: 
                            <select name="departure_location" id="departure_location">
                                <?php
                                $airport_query = "SELECT * FROM airport";
                                $airport_result = mysqli_query($con, $airport_query);
                                while ($row = mysqli_fetch_array($airport_result)) {
                                    echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_location'] . "</option>";
                                }
                                ?>
                            </select>
    <input type="submit" value="Submit">
</form>
<table border='1'>
    <tr>
        <th>Airport Name</th>
        <th>Flight Name</th>
        <th>Layover Duration</th>
        <th>Layover Stop</th>
        <th>Edit</th>
        <th>Disabled/Enabled</th>
    </tr>
    <?php
    $details_query = "SELECT airport.airport_name, flight.flight_name, onestop.layover_duration, onestop.layover_stop FROM onestop 
    INNER JOIN airport ON onestop.layover_stop = airport.airport_id 
    INNER JOIN flight ON onestop.flight_id = flight.flight_id";
    $details_result = mysqli_query($con, $details_query);
    while ($row = mysqli_fetch_array($details_result)) {
        echo "<tr>";
        echo "<td>" . $row['airport_name'] . "</td>";
        echo "<td>" . $row['flight_name'] . "</td>";
        echo "<td>" . $row['layover_duration'] . "</td>";
        echo "<td>" . $row['layover_stop'] . "</td>";
        echo "<td><button>Edit</button></td>";
        echo "<td><button>Disabled/Enabled</button></td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $airport_id = mysqli_real_escape_string($con, $_POST['departure_location']);
    $airline_id = mysqli_real_escape_string($con, $_POST['airline']);
    $flight_id = mysqli_real_escape_string($con, $_POST['flight_id']);
    echo $flight_id;
    echo $airline_id;
    $layover_duration = mysqli_real_escape_string($con, $_POST['layover_duration']);
    $layover_stop = mysqli_real_escape_string($con, $_POST['departure_location']);

    // Attempt insert query execution
    $sql = "INSERT INTO onestop (airport_id, flight_id, airline_id, layover_duration, layover_stop) VALUES ('$airport_id', '$flight_id', '$airline_id', '$layover_duration', '$layover_stop')";
   
    if (mysqli_query($con, $sql)) {
        echo '<meta http-equiv="refresh" content="0">';
        echo "Records added successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
}

// Close connection
mysqli_close($con);

?>
