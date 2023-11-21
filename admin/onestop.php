<?php
include("stop.php");

if (isset($_GET['flight_id'])) {
    $id = $_GET['flight_id'];
    //echo $id;

    
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Form for onestop table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        form {
            max-width: 400px;
            
            margin: 90px auto;
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color:  #0b3958;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color:  #2980b9;
        }
        
    </style>
</head>
<body>

<form action="#" method="post">
            <h2>One Stop Details</h2>
    
   
    Layover Duration(Hours): 
    <select name="layover_duration"  required>
                                <option></option>
                                <option value="0.5">0.5 </option>
                                <option value="1">1 </option>
                                <option value="1.5">1.5</option>
                                <option value="2">2</option>
                                <option value="2.5">2.5</option>
                                <option value="3">3</option>
                                <option value="3.5">3.5</option>
                                <option value="4">4</option>
                                <option value="4.5">4.5</option>
                                <option value="5">5</option>
                                <option value="5.5">5.5</option>
                                <option value="6">6</option>
                                <option value="6.5">6.5</option>
                                <option value="7">7</option>
                                <option value="7.5">7.5</option>
                                <option value="8">8</option>
                                <option value="8.5">8.5</option>
                                <option value="9">9</option>
                                <option value="9.5">9.5</option>
                                <option value="10">10</option>
                                <option value="10.5">10.5</option>
                                <option value="11">11</option>
                                <option value="11.5">11.5</option>
                                <option value="12.5">12</option>
                                
                            </select>
                            <br><br>
    Layover Stop: 
    <select name="departure_location" id="departure_location" required>
        <option></option>
    <?php
     if(isset($_GET['flight_id'])){

         $airport_query = "SELECT `airport_id`, `airport_name`, `airport_location`, `status` FROM `airport` WHERE `status` = 1 AND `airport_location` NOT IN (SELECT `f_arrival` FROM `flight` WHERE `f_arrival` IS NOT NULL and flight_id = '$id') AND `airport_location` NOT IN (SELECT `f_departure` FROM `flight` WHERE `f_departure` IS NOT NULL and flight_id = '$id')";
        $airport_result = mysqli_query($con, $airport_query);

        while ($row = mysqli_fetch_array($airport_result)) {
             echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
        }
     }
    ?>
</select>

    <input type="submit"  value="Add">
    <a href="onestop_view.php" class="view_but" >view details</a>

</form>


<script>
    
</script>
</body>
</html>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $flight_id = mysqli_real_escape_string($con, $_GET['flight_id']);
    $layover_duration = mysqli_real_escape_string($con, $_POST['layover_duration']);
    $layover_stop = mysqli_real_escape_string($con, $_POST['departure_location']); // Assuming the form field name is 'departure_location'

    // Check if there is already an entry for the given flight_id
    $existing_entry_query = "SELECT * FROM onestop WHERE flight_id = '$flight_id'";
    $existing_entry_result = mysqli_query($con, $existing_entry_query);

    if (mysqli_num_rows($existing_entry_result) > 0) {
        // An entry already exists for the given flight_id
        echo '<script>alert("ERROR: Entry already exists for the given flight_id.");</script>';
    } else {
        // If no entry exists, attempt the insert query execution
        $sql = "INSERT INTO onestop (flight_id, layover_duration, layover_stop) VALUES ('$flight_id', '$layover_duration', '$layover_stop')";

        if (mysqli_query($con, $sql)) {
            echo '<meta http-equiv="refresh" content="0">';
            echo "Records added successfully.";
        } else {
            echo '<script>alert("ERROR: Could not able to execute $sql. ' . mysqli_error($con) . '");</script>';
        }
    }
}
?>




