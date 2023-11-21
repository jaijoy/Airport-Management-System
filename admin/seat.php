<?php
include "../config/dbcon.php";
include("includes/base.php");

if (isset($_GET['flight_id'])) {
    $id = $_GET['flight_id'];
    //echo $id;

    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Form Fields</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            margin: 250px;
            margin-top: 5%;
            margin-left: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-size: 16px;
            font-weight: bold;
        }

        input[type="checkbox"] {
            margin-right: 8px;
            transform: scale(1.5); /* Increase the size of the checkboxes */
        }

        div {
            margin-bottom: 16px;
        }

        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<form method="POST" action="#">


       
            <label for="total">Total number of seats:</label>
            <input type="number" id="total" name="total">
        

        <label for="economyCheckbox">Economy Class:</label>
        <input type="checkbox" id="economyCheckbox" onchange="toggleField('economyCheckbox', 'economyField')">
        <div id="economyField" style="display: none;">
            <label for="numberOfEconomy">Number of Economy:</label>
            <input type="number" id="numberOfEconomy" name="numberOfEconomy_economy">
        </div>

        <label for="preEconomyCheckbox">Premium Economy Class:</label>
        <input type="checkbox" id="preEconomyCheckbox" onchange="toggleField('preEconomyCheckbox', 'preEconomyField')">
        <div id="preEconomyField" style="display: none;">
            <label for="numberOfPreEconomy">Number of Premium Economy:</label>
            <input type="number" id="numberOfPreEconomy" name="numberOfEconomy_pre">
        </div>

        <label for="businessCheckbox">Business Class:</label>
        <input type="checkbox" id="businessCheckbox" onchange="toggleField('businessCheckbox', 'businessField')">
        <div id="businessField" style="display: none;">
            <label for="numberOfBusiness">Number of Business:</label>
            <input type="number" id="numberOfBusiness" name="numberOfBusiness">
        </div>

        <label for="firstCheckbox">First Class:</label>
        <input type="checkbox" id="firstCheckbox" onchange="toggleField('firstCheckbox', 'firstField')">
        <div id="firstField" style="display: none;">
            <label for="numberOfFirst">Number of First Class:</label>
            <input type="number" id="numberOfFirst" name="numberOfFirst">
        </div>
        <br><br>
        <button type="submit">Submit</button>
    </form>

    <script>
        function toggleField(checkboxId, fieldId) {
            var checkbox = document.getElementById(checkboxId);
            var field = document.getElementById(fieldId);

            field.style.display = checkbox.checked ? "block" : "none";
        }
    </script>

</body>
</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total = mysqli_real_escape_string($con, $_POST['total']);
    $numberOfEconomy = mysqli_real_escape_string($con, $_POST['numberOfEconomy_economy']);
    $numberOfPreEconomy = mysqli_real_escape_string($con, $_POST['numberOfEconomy_pre']);
    $numberOfBusiness = mysqli_real_escape_string($con, $_POST['numberOfBusiness']);
    $numberOfFirst = mysqli_real_escape_string($con, $_POST['numberOfFirst']);
    $flight_id = mysqli_real_escape_string($con, $_GET['flight_id']);

    $checkQuery = "SELECT * FROM seat WHERE flight_id = '$flight_id'";
    $checkResult = mysqli_query($con, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        // Record already exists, perform update or take appropriate action
        echo "Record already exists!";
    } 
    else {
    // Constructing the SQL query
            $insertQuery = "INSERT INTO seat (total_seat, no_economy, no_premium, no_business, no_first, flight_id) VALUES ('$total', '$numberOfEconomy', '$numberOfPreEconomy', '$numberOfBusiness', '$numberOfFirst', '$flight_id')";

            // Executing the query
            $result = mysqli_query($con, $insertQuery);
            
            if ($result) {
                echo "Insertion successful!";
            } else {
                echo "Error: " . mysqli_error($con);
            }
    }
}
?>
