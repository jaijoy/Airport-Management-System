<?php
include "../config/dbcon.php";
include("includes/base.php");

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .form-popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            width: 300px;
            border: 1px solid #888;
            border-radius: 5px;
        }

        button {
            background-color: #1c4fa9;
            /* Blue shade */
            color: white;
            padding: 12px 15px;
            margin-left: 69%;
            margin-top: 40px;
            margin-right: 10%;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #305f9e;
            /* Hover color in different blue shade */
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 130px;
            background-color: white;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th{
            padding: 10px;
            text-align: left; 
        }
        td {
            padding: 1px;
            text-align: left;
        }

        th {
            background-color: #4d90e6;
            /* Blue shade */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #d9edf7;
            /* Light blue shade */
        }

        tr:hover {
            background-color: #bcdff1;
            /* Hover color in a different light blue shade */
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .status-button {
            padding: 10px 15px;
            margin: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .status-button-enabled {
            background-color: #4d90e6;
            /* Blue shade */
            color: white;
        }

        .status-button-disabled {
            background-color: #ff6666;
            /* Light red shade */
            color: white;
        }

        .edit-button {
            background-color: #007acc;
            /* Blue shade */
            color: white;
            padding: 10px 15px;
            margin: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
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

        input[type="text"]#searchInput {
            width: 30%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button#searchButton {
            background-color: #1c4fa9;
            /* Blue shade */
            color: white;
            padding: 10px 15px;
            margin: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button#searchButton:hover {
            background-color: #305f9e;
            /* Hover color in different blue shade */
        }
        .error-message{
            color:red;
        }
    </style>

</head>

<body>
    <h1>Airport Deatails</h1>

    <div style="display: flex;">
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for airport name or location...">
        <button id="searchButton" onclick="searchTable()">
            <i class="fas fa-search"></i>
        </button>
    </div>

    <button onclick="openForm()"> +Add Airport</button>

    <div id="airportForm" class="form-popup">
        <div class="form-container">
            <form action="airport.php" method="post" onsubmit="return submitAddForm()">
                Airport Name:<br>
                <input type="text" id="airport_name" name="airport_name" oninput="validateAirportName()" required>
                <span id="airport_name_error" class="error-message"></span><br><br>

                <br><br>
                Airport Location:<br>
                <input type="text" name="airport_location" id="airport_location" oninput="validateAirportLocation()" required>
                <span id="airport_location_error" class="error-message"></span><br><br>
                <br><br>
                <!-- Terminal <br>
                <input type="checkbox" name="airport_type[]" value="domestic"> Domestic<br>
                <input type="checkbox" name="airport_type[]" value="international"> International<br>
                <input type="checkbox" name="airport_type[]" value="cargo"> Cargo<br>
                <br><br> -->
                <button type="submit">Submit</button>
                <button type="button" onclick="closeForm()">Close</button>
            </form>
        </div>
    </div>

    <script>
        function validateAirportName() {
            var airportNameInput = document.getElementById('airport_name');
            var airportNameError = document.getElementById('airport_name_error');
            var airportNameRegex =  /^[a-zA-Z\s]{3,}$/;


            if (!airportNameRegex.test(airportNameInput.value)) {
                airportNameError.textContent = "Airport Name must start with at least three alphabets";
                return false;
            } else {
                airportNameError.textContent = "";
                return true;
            }
        }

        function validateAirportLocation() {
        var airportLocationInput = document.getElementById('airport_location');
        var airportLocationError = document.getElementById('airport_location_error');
        var airportLocationRegex = /^[a-zA-Z\s]{3,}$/;

        if (!airportLocationRegex.test(airportLocationInput.value)) {
            airportLocationError.textContent = "Airport location must consist of at least three alphabets and spaces, without numbers";
            return false;
        } else {
            airportLocationError.textContent = "";
            return true;
        }
}


        function submitAddForm() {
            return validateAirportName() && validateAirportLocation();
        }
    </script>



    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['airport_name']) && isset($_POST['airport_location'])) {
            $airport_name = $_POST['airport_name'];
            $airport_location = $_POST['airport_location'];

            // Check if the airport with the same name and location already exists
            $check_query = "SELECT * FROM airport WHERE airport_name='$airport_name' OR airport_location='$airport_location'";
            $check_result = mysqli_query($con, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                echo "Error: Airport with the same name and location already exists.";
            } else {
                if (!empty($_POST['airport_type'])) {
                    $airport_types = $_POST['airport_type'];
                    $types_string = implode(", ", $airport_types);
                    $sql = "INSERT INTO airport (airport_name, airport_location, terminal) VALUES ('$airport_name', '$airport_location', '$types_string')";

                    if (mysqli_query($con, $sql)) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($con);
                    }
                } else {
                    $sql = "INSERT INTO airport (airport_name, airport_location) VALUES ('$airport_name', '$airport_location')";

                    if (mysqli_query($con, $sql)) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($con);
                    }
                }
            }

        }
        elseif (isset($_POST['edit_id']) && isset($_POST['edit_name']) && isset($_POST['edit_location'])) {
            $edit_id = $_POST['edit_id'];
            $edit_name = $_POST['edit_name'];
            $edit_location = $_POST['edit_location'];

            // Check if the edited values are different from the existing values in the database
            $check_query = "SELECT * FROM airport WHERE (airport_name='$edit_name' OR airport_location='$edit_location') AND airport_id <> '$edit_id'";
            $check_result = mysqli_query($con, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                echo "Error: The edited values conflict with existing values in the database.";
            } else {
                $update_sql = "UPDATE airport SET airport_name='$edit_name', airport_location='$edit_location' WHERE airport_id=$edit_id";

                if (mysqli_query($con, $update_sql)) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . mysqli_error($con);
                }
            }
        }
    }

    $sql = "SELECT * FROM airport";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>SI NO</th><th>Airport Name</th><th>Airport Location</th><th>Edit</th><th>Status</th></tr>";
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $counter . "</td>";
            echo "<td>" . $row["airport_name"] . "</td>";
            echo "<td>" . $row["airport_location"] . "</td>";
            echo "<td>";
            if (isset($row["status"]) && $row["status"] == 1) { ?>
                <button onclick='openEditForm(<?php echo $row["airport_id"]; ?>, "<?php echo $row["airport_name"]; ?>", "<?php echo $row["airport_location"]; ?>", "<?php echo $row["terminal"]; ?>")' class='edit-button'>Edit</button>
            <?php } else { ?>
                <button class='edit-button-disabled' disabled>Edit</button>
            <?php } ?>
            </td>
            <td>
                <?php if (isset($row["status"]) && $row["status"] == 1) { ?>
                    <button onclick='changeStatus(<?php echo $row["airport_id"]; ?>, 0, event)' class='status-button status-button-enabled'>Enabled</button>
                <?php } else { ?>
                    <button onclick='changeStatus(<?php echo $row["airport_id"]; ?>, 1, event)' class='status-button status-button-disabled'>Disabled</button>
                <?php } ?>
            </td>

            </tr>
    <?php $counter++;
        }
        echo "</table>";
    } else {
        echo "<p>No results</p>";
    }
    ?>


    <?php
    if (isset($_GET['id']) && isset($_GET['status'])) {
        $id = $_GET['id'];
        $status = $_GET['status'];
        $update_status_sql = "UPDATE airport SET status=$status WHERE airport_id=$id";

        if (mysqli_query($con, $update_status_sql)) {
            echo "Status updated successfully";
        } else {
            echo "Error updating status: " . mysqli_error($con);
        }
    }

    mysqli_close($con);
    ?>

    <div id="editForm" class="form-popup">
        <div class="form-container">
            <form action="airport.php" method="post" onsubmit="return submitEditForm()">
                <input type="hidden" id="edit_id" name="edit_id" value="">
                Airport Name:<br>
                <input type="text" id="edit_name" name="edit_name" oninput="validateEditAirportName()"required><br>
                <span id="edit_name_error" class="error-message"></span><br><br>
                <br><br>
                Airport Location:<br>
                <input type="text" id="edit_location" name="edit_location" oninput="validateEditAirportLocation()" required><br>
                <span id="edit_location_error" class="error-message"></span><br><br>
                <br><br>
                <!-- Terminal:<br>
                <input type="checkbox" id="edit_terminal" name="edit_terminal[]" value="domestic"> Domestic<br>
                <input type="checkbox" id="edit_terminal" name="edit_terminal[]" value="international"> International<br>
                <input type="checkbox" id="edit_terminal" name="edit_terminal[]" value="cargo"> Cargo<br>
                <br><br> -->
                <button type="submit">Update</button>
                <button type="button" onclick="closeEditForm()">Close</button>
            </form>
        </div>
    </div>




<script>
    function validateEditAirportName() {
    var airportEditNameInput = document.getElementById('edit_name');
    var airportNameError = document.getElementById('edit_name_error');
    var airportNameRegex = /^[a-zA-Z\s]{3,}$/;

    if (!airportNameRegex.test(airportEditNameInput.value)) {
        airportNameError.textContent = "Airport Name must start alphabets";
        return false;
    } else {
        airportNameError.textContent = "";
        return true;
            }
        }

        function validateEditAirportLocation() {
            var airportLocationInput = document.getElementById('edit_location');
            var airportLocationError = document.getElementById('edit_location_error');
            var airportLocationRegex = /^[a-zA-Z\s]{3,}$/;

            if (!airportLocationRegex.test(airportLocationInput.value)) {
                airportLocationError.textContent = "Airport location must consist of alphabets.";
                return false;
            } else {
                airportLocationError.textContent = "";
                return true;
            }
        }

        function submitEditForm() {
            return validateEditAirportName() && validateEditAirportLocation();
        }


        function submitAddForm() {
            return validateAirportName() && validateAirportLocation();
        }
        function openForm() {
            document.getElementById("airportForm").style.display = "flex";
        }

        function closeForm() {
            document.getElementById("airportForm").style.display = "none";
        }

        function openEditForm(id, name, location, terminal) {
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_name").value = name;
            document.getElementById("edit_location").value = location;
            var terminals = terminal.split(', ');
            var editTerminals = document.querySelectorAll('input[name^="edit_terminal"]');
            for (var i = 0; i < editTerminals.length; i++) {
                if (terminals.includes(editTerminals[i].value)) {
                    editTerminals[i].checked = true;
                } else {
                    editTerminals[i].checked = false;
                }
            }
            document.getElementById("editForm").style.display = "flex";
        }

        function changeStatus(id, status, event) {
            event.preventDefault(); // Prevent the form submission
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload(); // Reload the page to reflect the updated status
                }
            };
            xhttp.open("GET", 'airport.php?id=' + id + '&status=' + status, true);
            xhttp.send();
        }

        function closeEditForm() {
            document.getElementById("editForm").style.display = "none";
        }

        function searchTable() {
            var input, filter, table, tr, td1, td2, i, txtValue1, txtValue2;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.querySelector('table');
            tr = table.getElementsByTagName('tr');

            for (i = 0; i < tr.length; i++) {
                td1 = tr[i].getElementsByTagName('td')[1];
                td2 = tr[i].getElementsByTagName('td')[2];
                if (td1 || td2) {
                    txtValue1 = td1.textContent || td1.innerText;
                    txtValue2 = td2.textContent || td2.innerText;
                    if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1) {
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