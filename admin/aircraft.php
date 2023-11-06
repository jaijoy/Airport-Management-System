<?php
include("includes/base.php");
include "../config/dbcon.php";
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/aircraft.css">
    <style>
        /* CSS for the pop-up box */
    </style>
</head>


<?php

// Your PHP code here
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['sub'])){


    $airline_id = $_POST['airline_name'];
    $airbus_name = $_POST['airbus_name'];
    $passenger_capacity = $_POST['passenger_capacity'];

    // Insert data into the airbus table
    $insert_query = "INSERT INTO airbus (airline_id, airbus_name, passenger_capacity) VALUES ('$airline_id', '$airbus_name', '$passenger_capacity')";

    if (mysqli_query($con, $insert_query)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
    }
}
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit_airbus_id'])) {
        $airbus_id = $_POST['edit_airbus_id'];
        $airline_id = isset($_POST['airline_name_edit']) ? $_POST['airline_name_edit'] : '';
        $airbus_name = isset($_POST['edit_airbus_name']) ? $_POST['edit_airbus_name'] : '';
        $passenger_capacity = isset($_POST['edit_passenger_capacity']) ? $_POST['edit_passenger_capacity'] : '';

        // Update data in the airbus table
        if (!empty($airline_id) && !empty($airbus_name) && !empty($passenger_capacity)) {
            $update_query = "UPDATE airbus SET airline_id='$airline_id', airbus_name='$airbus_name', passenger_capacity='$passenger_capacity' WHERE airbus_id='$airbus_id'";
            if (mysqli_query($con, $update_query)) {
                echo "Record updated successfully";
            } else {
                echo "Error: " . $update_query . "<br>" . mysqli_error($con);
            }
        } else {
            echo "Please fill all the fields.";
        }
    }
}


?>


<body>

<h2 class="heading">Aircraft Details</h2>

<div class="popup" id="popup">
    <form action="#" method="post">
        <label for="airline_name">Airline Name:</label><br>
        <select name="airline_name" id="airline_name">
      
            <?php
            
            
            $query = "SELECT airline_id, airline_name FROM airline";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['airline_id'] . "'>" . $row['airline_name'] . "</option>";
            }
            ?>
    
        </select><br><br>
        <label for="airbus_name">Airbus Name:</label><br>
        <input type="text" name="airbus_name" id="airbus_name"><br><br>
        <label for="passenger_capacity">Passenger Capacity:</label><br>
        <input type="text" name="passenger_capacity" id="passenger_capacity"><br><br>
        <input type="submit"name="sub" value="Submit">
    </form>
    <button class="closeBtn" onclick="togglePopup()">Close</button>
</div>

<div class="popup" id="popupEdit" style="display: none;">
    <form action="#" method="post">
        <h1>Edit Airbus Details</h1>
        <label for="airline_name_edit">Airline Name:</label><br>
        <select name="airline_name_edit" id="airline_name_edit">
            <?php
                $query = "SELECT airline_id, airline_name FROM airline";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['airline_id'] . "'>" . $row['airline_name'] . "</option>";
                }
            ?>
        </select><br><br>
        <label for="edit_airbus_name">Airbus Name:</label><br>
        <input type="text" name="edit_airbus_name" id="edit_airbus_name" value="<?php echo isset($_POST['airbus_name']) ? $_POST['airbus_name'] : ''; ?>"><br><br>
        <label for="edit_passenger_capacity">Passenger Capacity:</label><br>
        <input type="text" name="edit_passenger_capacity" id="edit_passenger_capacity" value="<?php echo isset($_POST['passenger_capacity']) ? $_POST['passenger_capacity'] : ''; ?>"><br><br>
        <input type="hidden" name="edit_airbus_id" id="edit_airbus_id" value="">
        <input type="submit" class="update" value="Update">
    </form>
    <button class="closeBtn" onclick="document.getElementById('popupEdit').style.display = 'none'">Close</button>
</div>

<?php
// Your PHP code for querying and displaying the table

$select_query = "SELECT airbus.airbus_id, airline.airline_name, airbus.airbus_name, airbus.passenger_capacity, airbus.status FROM airbus JOIN airline ON airbus.airline_id = airline.airline_id";
$result = mysqli_query($con, $select_query);

if (mysqli_num_rows($result) > 0) {
    echo "<table>
    <tr>
    <th>Si. No.</th>
    <th>Airline Name</th>
    <th>Airbus Name</th>
    <th>Passenger Capacity</th>
    <th>Edit</th>
    <th>Enable/Disable</th>
    </tr>";

    $serial_no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $serial_no . "</td>";
        echo "<td>" . $row['airline_name'] . "</td>";
        echo "<td>" . $row['airbus_name'] . "</td>";
        echo "<td>" . $row['passenger_capacity'] . "</td>";
        echo "<td>";
        if (isset($row["status"]) && $row["status"] == 1) { ?>
            <button onclick='editRow(<?php echo $row["airbus_id"]; ?>, "<?php echo $row["airline_name"]; ?>", "<?php echo $row["passenger_capacity"]; ?>")' class='edit-button'>Edit</button>
        <?php } else { ?>
            <button class='edit-button-disabled' disabled>Edit</button>
        <?php } ?>
        </td>
        <td>
            <?php if (isset($row["status"]) && $row["status"] == 1) { ?>
                <button onclick='changeStatus(<?php echo $row["airbus_id"]; ?>, 0, event)' class='status-button status-button-enabled'>Enabled</button>
            <?php } else { ?>
                <button onclick='changeStatus(<?php echo $row["airbus_id"]; ?>, 1, event)' class='status-button status-button-disabled'>Disabled</button>
            <?php } ?>
<?php
        echo "</td>";

        echo "</tr>";
        $serial_no++;
    }
    echo "</table>";
} else {
    echo "0 results";
}

mysqli_close($con);
?>



<br><br>
<button onclick="togglePopup()">Add Airbus</button>

<?php
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Add error logging to debug
    error_log("ID: " . $id . ", Status: " . $status);

    $update_status_sql = "UPDATE airbus SET status=$status WHERE airbus_id=$id";

    // Add error logging to debug
    error_log("Update status SQL: " . $update_status_sql);

    if (mysqli_query($con, $update_status_sql)) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . mysqli_error($con);
    }
}
?>

<script>
    function editRow(airbus_id, airline_name, airbus_name, passenger_capacity) {
        var popup = document.getElementById("popupEdit");
        document.getElementById("airline_name_edit").value = airline_name;
        document.getElementById("edit_airbus_name").value = airbus_name;
        document.getElementById("edit_passenger_capacity").value = passenger_capacity;
        document.getElementById("edit_airbus_id").value = airbus_id;
        popup.style.display = "block";
    }

    function togglePopup() {
        var popup = document.getElementById("popup");
        if (popup.style.display === "none") {
            popup.style.display = "block";
        } else {
            popup.style.display = "none";
        }
    }

    function changeStatus(id, status, event) {
        event.preventDefault(); // Prevent the form submission
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    location.reload(); // Reload the page to reflect the updated status
                } else {
                    console.error("Request status: " + this.status);
                    console.error("Request response: " + this.responseText);
                }
            }
        };
        xhttp.open("GET", 'aircraft.php?id=' + id + '&status=' + status, true);
        xhttp.send();
    }
</script>

    



</body>
</html>
