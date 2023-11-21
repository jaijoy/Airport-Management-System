<?php
session_start();
include("includes/base.php");
include "../config/dbcon.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aircraft Details</title>
    <style>
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9;
            background-color: #ffffff;
            max-width: 500px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .error-message {
            color: red;
        }
        .add{
            width: 25%;
            text-align: center;
            margin-left: 70%;
            padding: 12px 20px;
            background-color: #590066;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .status-button {
            padding: 10px 15px;
            margin: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .status-button-enabled {
            background-color: rgb(66, 55, 107);
            color: white;
        }

        .status-button-disabled {
            background-color: #f44336;
            color: white;
        }
        .edit-button-disabled {
            background-color: #cccccc;
            color: #666666;
            padding: 10px 15px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: not-allowed;

        }

        /* CSS for the heading */
        .heading {
            text-align: center;
            margin: 20px 0;
            font-family: Arial, sans-serif;
            color: #333;
        }
        /* CSS for the form and buttons */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 4px;
            background-color: #754caf;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }
        button.closeBtn {
            background-color: #f44336;
        }
        button.closeBtn:hover {
            background-color: #d32f2f;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        
    </style>
</head>

<body><br><br>
<h2 class="heading">Aircraft Details</h2>
    <button class="add" id="addAirbusButton">Add Airbus</button>
    <div class="popup" id="popup">
        <form action="#" method="post" onsubmit="return submitForm()">
            <label for="airline_name">Airline Name:</label><br>
            <select name="airline_name" id="airline_name" required>
                <?php
                $query = "SELECT airline_id, airline_name FROM airline where `status`=1";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['airline_id'] . "'>" . $row['airline_name'] . "</option>";
                }
                ?>
            </select><br><br>
            <label for="airbus_name">Airbus Name:</label><br>
            <input type="text" name="airbus_name" id="airbus_name" oninput="validateAirbusName()" required><br>
            <span id="airbus_name_error" class="error-message"></span><br><br>

            <label for="passenger_capacity">Passenger Capacity:</label><br>
            <input type="text" name="passenger_capacity" id="passenger_capacity" oninput="validatePassengerCapacity()" required><br>
            <span id="passenger_capacity_error" class="error-message"></span><br><br>
            
            <input type="submit" name="sub" value="Submit">
        </form>
    </div>
        <script>
            function validateAirbusName() {
                var airbusNameInput = document.getElementById('airbus_name');
                var airbusNameError = document.getElementById('airbus_name_error');
                var airbusNameRegex = /^[a-zA-Z][a-zA-Z0-9\s]{2,}$/;

                if (!airbusNameRegex.test(airbusNameInput.value)) {
                    airbusNameError.textContent = "Airbus Name must start with atleast three alphabets";
                    return false;
                } else {
                    airbusNameError.textContent = "";
                    return true;
                }
            }

            function validatePassengerCapacity() {
                var passengerCapacityInput = document.getElementById('passenger_capacity');
                var passengerCapacityError = document.getElementById('passenger_capacity_error');
                var passengerCapacity = parseInt(passengerCapacityInput.value);

                if (isNaN(passengerCapacity) || passengerCapacity < 5 || passengerCapacity > 800) {
                    passengerCapacityError.textContent = "Please enter a valid number between 5 and 800.";
                    return false;
                } else {
                    passengerCapacityError.textContent = "";
                    return true;
                }
            }

            function submitForm() {
                return validateAirbusName() && validatePassengerCapacity();
            }
        </script>


<div class="popup" id="editPopup">
    <form action="#" method="post" onsubmit="return submitEditForm()">
        <input type="hidden" name="edit_airbus_id" id="edit_airbus_id" value="">

        <label for="edit_airline_name">Airline Name:</label><br>
        <select name="edit_airline_name" id="edit_airline_name" required>
        <?php
        $query = "SELECT airline_id, airline_name FROM airline where `status`=1";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['airline_id'] . "'>" . $row['airline_name'] . "</option>";
        }
    ?>
        </select><br><br>
        <label for="edit_airbus_name">Airbus Name:</label><br>
        <input type="text" name="edit_airbus_name" id="edit_airbus_name" oninput="validateEditAirbusName()"required><br>
        <span id="edit_airbus_name_error" class="error-message"></span><br><br>

        <label for="edit_passenger_capacity">Passenger Capacity:</label><br>
        <input type="text" name="edit_passenger_capacity" id="edit_passenger_capacity" oninput="validateEditPassengerCapacity()"required><br>
        <span id="edit_passenger_capacity_error" class="error-message"></span><br><br>

        <input type="submit" name="edit_sub" value="Submit">
    </form>
</div>

<script>
    function validateEditAirbusName() {
        var airbusNameInput = document.getElementById('edit_airbus_name');
        var airbusNameError = document.getElementById('edit_airbus_name_error');
        var airbusNameRegex = /^[a-zA-Z][a-zA-Z0-9\s]{2,}$/;

        if (!airbusNameRegex.test(airbusNameInput.value)) {
            airbusNameError.textContent = "Airbus Name must start with atleast three alphabets";
            return false;
        } else {
            airbusNameError.textContent = "";
            return true;
        }
    }

    function validateEditPassengerCapacity() {
        var passengerCapacityInput = document.getElementById('edit_passenger_capacity');
        var passengerCapacityError = document.getElementById('edit_passenger_capacity_error');
        var passengerCapacity = parseInt(passengerCapacityInput.value);

        if (isNaN(passengerCapacity) || passengerCapacity < 5 || passengerCapacity > 800) {
            passengerCapacityError.textContent = "Please enter a valid number between 5 and 800.";
            return false;
        } else {
            passengerCapacityError.textContent = "";
            return true;
        }
    }

    function submitEditForm() {
        return validateEditAirbusName() && validateEditPassengerCapacity();
    }
</script>



    <!-- ... Your HTML and CSS code ... -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Wait for the DOM to be fully loaded before executing the script

            function togglePopup(popupId) {
                var popup = document.getElementById(popupId);
                popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
            }

            function editRow(airbusId, airlineName, airbusName, passengerCapacity) {
                document.getElementById('edit_airbus_id').value = airbusId;
                document.getElementById('edit_airline_name').value = airlineName;
                document.getElementById('edit_airbus_name').value = airbusName;
                document.getElementById('edit_passenger_capacity').value = passengerCapacity;
                togglePopup('editPopup');
            }

            // Attach the click event handler to the button
            document.getElementById("addAirbusButton").addEventListener("click", function(event) {
                event.preventDefault(); // Prevent the default behavior of the button
                togglePopup('popup');
            });

            document.querySelectorAll(".edit-button").forEach(function(button) {
                button.addEventListener("click", function(event) {
                    event.preventDefault(); // Prevent the default behavior of the button
                    var airbusId = this.getAttribute("data-airbus-id");
                    var airlineName = this.getAttribute("data-airline-name");
                    var airbusName = this.getAttribute("data-airbus-name");
                    var passengerCapacity = this.getAttribute("data-passenger-capacity");
                    editRow(airbusId, airlineName, airbusName, passengerCapacity);
                });
            });
        });
    </script>


    <?php

    // Your PHP code here
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['sub'])) {
            $airline_id = $_POST['airline_name'];
            $airbus_name = $_POST['airbus_name'];
            $passenger_capacity = $_POST['passenger_capacity'];

            // Check if the combination of values already exists
            $check_query = "SELECT * FROM airbus WHERE airline_id = '$airline_id' AND airbus_name = '$airbus_name' AND passenger_capacity = '$passenger_capacity'";
            $result = mysqli_query($con, $check_query);

            if (mysqli_num_rows($result) > 0) {
                // Record already exists
                echo "Error: Record already exists.";
            } else {
                // Insert data into the airbus table
                $insert_query = "INSERT INTO airbus (airline_id, airbus_name, passenger_capacity) VALUES ('$airline_id', '$airbus_name', '$passenger_capacity')";

                if (mysqli_query($con, $insert_query)) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
                }
            }
        }



        if (isset($_POST['edit_sub'])) {
            // Code for updating an existing record
            $edit_airbus_id = $_POST['edit_airbus_id'];
            
            $edit_airline_id = $_POST['edit_airline_name'];
            $edit_airbus_name = $_POST['edit_airbus_name'];
            $edit_passenger_capacity = $_POST['edit_passenger_capacity'];

            // Check if the new values already exist in other records
            $check_query = "SELECT * FROM airbus WHERE airline_id = '$edit_airline_id' AND airbus_name = '$edit_airbus_name'  AND airbus_id != '$edit_airbus_id'";
            $result = mysqli_query($con, $check_query);

            if (mysqli_num_rows($result) > 0) {
                // New values already exist in other records
                echo "Error: New values already exist in other records.";
            } else {
                // Update the record in the airbus table
                $update_query = "UPDATE airbus SET airline_id = '$edit_airline_id', airbus_name = '$edit_airbus_name', passenger_capacity = '$edit_passenger_capacity' WHERE airbus_id = '$edit_airbus_id'";

                if (mysqli_query($con, $update_query)) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . mysqli_error($con);
                }
            }
        }



        if (isset($_POST['enable_disable']) && isset($_POST['form_submitted'])) {
            $airbusId = $_POST['enable_disable'];

            // Toggle the status in the database
            $updateStatusQuery = "UPDATE airbus SET status = (1 - status) WHERE airbus_id = $airbusId";

            if (mysqli_query($con, $updateStatusQuery)) {
                echo "Status updated successfully";
            } else {
                echo "Error updating status: " . mysqli_error($con);
            }
            unset($_SESSION['form_submitted']);
        }
    }
    ?>
            
        

<?php
    $select_query = "SELECT airbus.airbus_id,airline.airline_name,airline.status,airbus.airbus_name,airbus.passenger_capacity,airbus.status FROM airbus JOIN airline ON airbus.airline_id = airline.airline_id WHERE airline.status = 1";

    $result = mysqli_query($con, $select_query);

    if (mysqli_num_rows($result) > 0) {
        echo "<form method='post'>";
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
            echo "<td><button class='edit-button' data-airbus-id='" . $row['airbus_id'] . "' data-airline-name='" . $row['airline_name'] . "' data-airbus-name='" . $row['airbus_name'] . "' data-passenger-capacity='" . $row['passenger_capacity'] . "'>Edit</button></td>";
            echo "<td>
            <form method='post'>
                <input type='hidden' name='form_submitted' value='1'>
                <button type='submit' name='enable_disable' value='" . $row['airbus_id'] . "'>" . ($row['status'] == 1 ? 'Disable' : 'Enable') . "</button>
            </form>
        </td>";
            echo "</tr>";
            $serial_no++;
        }

        echo "</table>";
        echo "</form>";
    }

    mysqli_close($con);
?>
</body>

</html>