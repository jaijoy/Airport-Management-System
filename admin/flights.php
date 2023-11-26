
<?php
session_start();
include("includes/base.php");
include "../config/dbcon.php";

?>
<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <head>
    <style>

            .bodyy{font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .edit-link, button {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .edit-link:hover, button:hover {
            background-color: #2980b9;
        }

        .enable-btn {
            background-color: #4CAF50 !important;
            color: white !important;
        }

        .disable-btn {
            background-color: #e74c3c !important;
            color: white !important;
        }

        @media screen and (max-width: 600px) {
            table {
                width: 100%;
            }

            th, td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }

            th {
                position: relative;
            }

            th:before {
                content: "";
                height: 20px;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background-color: #4CAF50;
            }
        }
    </style>
    </head>
    <body class="bodyy">


<?php

    if (isset($_POST['enable_disable']) && isset($_POST['form_submitted'])) {
        $airlineId = $_POST['enable_disable'];

        // Toggle the status in the database
        $updateStatusQuery = "UPDATE flight SET status = (1 - status) WHERE flight_id = $airlineId";

        if (mysqli_query($con, $updateStatusQuery)) {
            echo "Status updated successfully";
        } else {
            echo "Error updating status: " . mysqli_error($con);
        }
        unset($_SESSION['form_submitted']);
    
        
    }

?>

 


<?php
// Your database connection and other code...

$select_query = "SELECT
    flight.flight_id,
    flight.flight_name,
    airline.airline_name AS f_airline_name,
    airbus.airbus_name AS f_airbus_name,
    departure_airport.airport_name AS departure_airport_name,
    departure_airport.airport_location AS departure_airport_location,
    destination_airport.airport_name AS destination_airport_name,
    destination_airport.airport_location AS destination_airport_location,
    flight.stop,
    flight.flight_service,
    flight.price,
    flight.status
FROM
    flight
JOIN
    airline ON flight.airline_id = airline.airline_id
JOIN
    airbus ON flight.airbus_id = airbus.airbus_id
JOIN
    airport AS departure_airport ON flight.f_departure = departure_airport.airport_id
JOIN
    airport AS destination_airport ON flight.f_arrival = destination_airport.airport_id
WHERE
    airline.status = 1 AND
    airbus.status = 0 AND
    departure_airport.status = 1 AND
    destination_airport.status = 1";




$result = mysqli_query($con, $select_query);

$serial_no = 1; // Initialize the serial number

// Check if the query was successful
if ($result) {
    // Check if there are rows in the result
    if (mysqli_num_rows($result) > 0) {
        ?>
        <h2>Flight Details</h2>

        <div style="display: flex;">
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for flight name or location...">
        <button id="searchButton" onclick="searchTable()">
            <i class="fas fa-search"></i>
        </button>
         </div>

        <table border="1">
            <tr>
                <th>SI No</th>
                <th>Airline Name</th>
                <th>Airbus Name</th>
                <th>Flight Name</th>
                <th>Departure Location</th>
                <th>Arrival Location</th>
                <th>Stop</th>
                <th>Flight Service</th>
                <th>Price</th>
                <th>Edit</th>
                <th>Enable/Disable</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $serial_no; ?></td>
                    <td><?php echo $row['f_airline_name']; ?></td>
                    <td><?php echo $row['f_airbus_name']; ?></td>
                    <td><?php echo $row['flight_name']; ?></td>

                    <td><?php echo $row['departure_airport_name'].$row['departure_airport_location']; ?></td>
    
    <td><?php echo $row['destination_airport_name'].$row['destination_airport_location']; ?></td>
                    
                    <td><?php echo $row['stop']; ?></td>
                    <td><?php echo $row['flight_service']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><a href="flight_edit.php?flight_id=<?php echo $row['flight_id']; ?>"class="edit-link">Edit</a></td>
                    <td>
                    <form method='post'>
                            <input type='hidden' name='form_submitted' value='1'>
                            <button type='submit' name='enable_disable' value='<?php echo $row['flight_id']; ?>'
                                class="<?php echo ($row['status'] == 1 ? 'enable-btn' : 'disable-btn'); ?>">
                                <?php echo ($row['status'] == 1 ? 'Disable' : 'Enable'); ?>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php $serial_no++; // Increment the serial number in each iteration ?>
            <?php } ?>
        </table>
        <?php
    } else {
        echo "No records found.";
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Handle the case where the query failed
    echo "Error executing the query: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>



<script>
      // JavaScript function to perform search
function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.querySelector("table");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        // Change the indices based on your table structure
        var tdAirbus = tr[i].getElementsByTagName("td")[2];
        var tdFlight = tr[i].getElementsByTagName("td")[3];
        var tdPrice = tr[i].getElementsByTagName("td")[8];
        var tdStop = tr[i].getElementsByTagName("td")[6];
        var tdAirline = tr[i].getElementsByTagName("td")[1];

        if (tdAirbus || tdFlight || tdPrice || tdStop || tdAirline) {
            var txtValueAirbus = tdAirbus.textContent || tdAirbus.innerText;
            var txtValueFlight = tdFlight.textContent || tdFlight.innerText;
            var txtValuePrice = tdPrice.textContent || tdPrice.innerText;
            var txtValueStop = tdStop.textContent || tdStop.innerText;
            var txtValueAirline = tdAirline.textContent || tdAirline.innerText;

            // Check if any of the criteria match
            if (
                txtValueAirbus.toUpperCase().indexOf(filter) > -1 ||
                txtValueFlight.toUpperCase().indexOf(filter) > -1 ||
                txtValuePrice.toUpperCase().indexOf(filter) > -1 ||
                txtValueStop.toUpperCase().indexOf(filter) > -1 ||
                txtValueAirline.toUpperCase().indexOf(filter) > -1
            ) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

</script>

</body>
</html>






















