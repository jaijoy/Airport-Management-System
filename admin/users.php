<?php
include "../config/dbcon.php";
include("includes/base.php");
 $query = "SELECT * FROM users WHERE `verify_status` = 1 AND `role` = 0";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users Table</title>
    <style>
        table {
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Users Table</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
           
        </tr>
        <?php
        // Iterate through the fetched results and display them in the table
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
          
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
