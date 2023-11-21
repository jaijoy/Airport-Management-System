<?php
include "../config/dbcon.php";
include("includes/base.php");
?>
<html>
   <head>
        <style>
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
    <br>
    <h2><center>Seat Details</center></h2><br><br>

     <a href="seat_flight.php" class="add" >  + Add One Stop Details</a><br><br>



<table border="1">
    <tr>
        <th>SI Number</th>
        <th>Flight Name</th>
        <th>Total Seats</th>
        <th>Economy Seats</th>
        <th>Premium Economy Seats</th>
        <th>Business Seats</th>
        <th>First Class Seats</th>
        <th>Edit</th>
        <th>Enable/Disable</th>
    </tr>

 <?php
        
        // Retrieve data from the database with flight name
        $selectQuery = "SELECT s.*, f.flight_name FROM seat s
                        JOIN flight f ON s.flight_id = f.flight_id";

        $result = mysqli_query($con, $selectQuery);

    $siNumber = 1; // Initialize the serial number counter

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$siNumber}</td>";
        echo "<td>{$row['flight_name']}</td>";
        echo "<td>{$row['total_seat']}</td>";
        echo "<td>{$row['no_economy']}</td>";
        echo "<td>{$row['no_premium']}</td>";
        echo "<td>{$row['no_business']}</td>";
        echo "<td>{$row['no_first']}</td>";
        echo "<td><button>Edit</button></td>";
        echo "<td><button>Disabled/Enabled</button></td>";
        echo "</tr>";

        $siNumber++; // Increment the serial number counter for the next row
    }
    ?>
</table>
</body>
</html>