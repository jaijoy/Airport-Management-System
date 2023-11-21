<?php
include("stop.php");

if (isset($_GET['flight_id'])) {
    $id = $_GET['flight_id'];
    echo $id;
}
?>

<html lang="en">
<head>
    <title>One Stop Details</title>
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

        table {
            width: 95%;
            border-collapse: collapse;
            margin: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }
        .add {
            background-color: #0b3958;
            width: 15%;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 75%;
        }
        .add:hover {
             background-color: #2980b9;
        }
    </style>
</head>
<body>
    <br><br>
<a href="onestop_flight.php" class="add" >  + Add One Stop Details</a>
<table border='1'>
    <tr>
        <th>Flight Name</th>
        <th>Layover Duration</th>
        <th>Layover Stop</th>
        <th>Edit</th>
        <th>Disabled/Enabled</th>
    </tr>
    <?php
    $details_query = "SELECT airport.airport_location,airport.airport_name, flight.flight_name, onestop.layover_duration, airport.airport_location AS layover_stop FROM onestop 
    INNER JOIN airport ON onestop.layover_stop = airport.airport_id 
    INNER JOIN flight ON onestop.flight_id = flight.flight_id";
    $details_result = mysqli_query($con, $details_query);
    while ($row = mysqli_fetch_array($details_result)) {
        echo "<tr>";
        echo "<td>" . $row['flight_name'] . "</td>";
        echo "<td>" . $row['layover_duration'] . "</td>";
        echo "<td>" . $row['airport_name'].$row['layover_stop'] . "</td>";
        echo "<td><button>Edit</button></td>";
        echo "<td><button>Disabled/Enabled</button></td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
