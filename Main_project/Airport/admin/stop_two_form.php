



<?php
include "../config/dbcon.php";

if (isset($_GET['flight_id'])) {
    $id = $_GET['flight_id'];
    // echo $id; 
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Form for twostop table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            
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
        .view_but{
            width: 100%;
            background-color:  #0b3958;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
    </style>
    
</head>
<?php
        include("includes/header.php");
        ?>
<body>
<div class="container">

<?php
include 'includes/header2.php';
?>

<main>
<form action="#" method="post" onsubmit="return validateLocations()">
    <h2>Two Stop Details</h2>
   
    <h3>Enter details of stop one</h3>
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

    <h3>Enter details of stop two</h3>
    Layover Duration(Hours): 
    <select name="layover_duration2"  required>
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
    <select name="departure_location2" id="departure_location2" required>
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
    <div id="edit_error_message" style="color: red;"></div>

    <input type="submit"  value="Add"><br><br>
    <a href="twostop_view.php" class="view_but" >view details</a>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("departure_location").addEventListener("change", validateLocations);
    document.getElementById("departure_location2").addEventListener("change", validateLocations);
});

function validateLocations() {
    var departureLocation = document.getElementById("departure_location").value;
    var arrivalLocation = document.getElementById("departure_location2").value;
    var errorMessage = document.getElementById("edit_error_message");

    if (departureLocation === arrivalLocation) {
        errorMessage.textContent = "Stop one and Stop two locations cannot be the same. Please choose different locations.";
    } else {
        errorMessage.textContent = "";
    }
}
</script>

</main>
</div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $layover_duration = $_POST['layover_duration'];
    $departure_location = $_POST['departure_location'];
    $layover_duration2 = $_POST['layover_duration2'];
    $departure_location2 = $_POST['departure_location2'];

    // Assuming you have the flight_id available, either through a GET parameter or another method
    $flight_id = $_GET['flight_id']; // Adjust this according to your actual method of obtaining the flight_id

    // Check if the flight name already exists in the 'twostop' table
    $check_query = "SELECT COUNT(*) FROM `stop` WHERE flight_id = '$flight_id'";
    $result = mysqli_query($con, $check_query);
    $row = mysqli_fetch_array($result);

    if ($row[0] > 0) {
        echo "Error: Flight name already exists";
    } else {
        // Insert data into the 'twostop' table
        $insert_query = "INSERT INTO `stop` (flight_id, one_stop_name, one_stop_layover_duration, two_stop_name, two_stop_layover_duration) 
                         VALUES ('$flight_id', '$departure_location', '$layover_duration', '$departure_location2', '$layover_duration2')";

        if (mysqli_query($con, $insert_query)) {
            echo "Records inserted successfully.";
        } else {
            echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
        }
    }
}

// Close the database connection
mysqli_close($con);
?>
