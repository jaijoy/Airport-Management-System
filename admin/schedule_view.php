<?php
include("includes/base.php");
include "../config/dbcon.php";
?>

<html>
<head>
    <style>
        .add {
            align-items: center;
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

<h2><center>Schedule Details</center></h2><br>
<a href="schedule_flight.php" class="add" >+ Add Schedule</a><br><br>

<table border="1">
    <tr>
        <th>SI No.</th>
        <th>Flight Name</th>
        <th>Departure Location</th>
        <th>Arrival Location</th>
        <th>Departure Time</th>
        <th>Arrival Time</th>
        <th>Edit</th>
        <th>Enable/Disable</th>
    </tr>

    <?php
    $scheduleQuery = "SELECT s.*, f.flight_name, f.f_departure, f.f_arrival 
    FROM schedule s JOIN flight f ON s.flight_id = f.flight_id where f.status='0'";

    $scheduleResult = mysqli_query($con, $scheduleQuery);
    $siNumber = 1;

    while ($scheduleRow = mysqli_fetch_assoc($scheduleResult)) {
        echo "<tr>";
        echo "<td>{$siNumber}</td>";
        echo "<td>{$scheduleRow['flight_name']}</td>";
        echo "<td>{$scheduleRow['f_departure']}</td>";
        echo "<td>{$scheduleRow['f_arrival']}</td>";
        echo "<td>{$scheduleRow['departure_time']}</td>";
        echo "<td>{$scheduleRow['arrival_time']}</td>";
        echo "<td><button>Edit</button></td>";
        echo "<td><button>Disabled/Enabled</button></td>";
        echo "</tr>";
        $siNumber++;
    }
    ?>
</table>

</body>
</html>
