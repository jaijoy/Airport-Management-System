<?php
include("stop.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>three Stop Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        form {
            max-width: 400px;
            margin: 125px auto;
            background: #ffffff;
            padding: 39px;
            border-radius: 31px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        select {
            width: 70%;
            padding: 10px;
            margin: 5px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        

        button:hover {
            background-color: #2980b9;
        }

        button {
            background-color: #0b3958;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<form action="threestop.php" method="post">
    <h2>Three Stop Details</h2>
    Flight Name:
    <select name="flight_id" id="flight_id" required>
        <option></option>
        <?php
        $flight_query = "SELECT * FROM flight where `stop`='three stop' and `status`= 0";
        $flight_result = mysqli_query($con, $flight_query);
        while ($row = mysqli_fetch_array($flight_result)) {

            echo "<option value='" . $row['flight_id'] . "'>" . $row['flight_name'] . "</option>";
        }
        ?>
    </select>
    <button type="button" onclick="addStop()">Add Stop</button>
</form>

<script>
    function addStop() {
        var selectedFlightId = document.getElementById('flight_id').value;
        if (selectedFlightId !== '') {
            window.location.href = 'threestop.php?flight_id=' + selectedFlightId;
        } else {
            alert('Please select a flight before clicking Add Stop.');
        }
    }
</script>

</body>
</html>
