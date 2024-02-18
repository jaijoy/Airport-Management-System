


<?php
include "../config/dbcon.php";

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
            background-color: #0b3958;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .alert {
            display: none;
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

        <form action="#" method="post">
            <!-- Bootstrap Success Message with Blurred Background -->
            <div class="alert alert-success mt-3 alert-dismissible fade show" id="successMessage" role="alert" style=" color: green; border: 1px solid #4CAF50; border-radius: 1px; backdrop-filter: blur(5px);">
                <strong>Success!</strong> Record added successfully.
                
            </div>
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
                if (isset($_GET['flight_id'])) {
                    $airport_query = "SELECT `airport_id`, `airport_name`, `airport_location`, `status` FROM `airport` WHERE `status` = 1 AND `airport_location` NOT IN (SELECT `f_arrival` FROM `flight` WHERE `f_arrival` IS NOT NULL and flight_id = '$id') AND `airport_location` NOT IN (SELECT `f_departure` FROM `flight` WHERE `f_departure` IS NOT NULL and flight_id = '$id')";
                    $airport_result = mysqli_query($con, $airport_query);

                    while ($row = mysqli_fetch_array($airport_result)) {
                        echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                    }
                }
                ?>
            </select>

            <input type="submit" value="Add">
            <a href="onestop_view.php" class="view_but">View Details</a>

        </form>


        <script>
            // Display success message on successful record addition
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['layover_duration']) && isset($_POST['departure_location'])) {
                echo 'document.getElementById("successMessage").style.display = "block";';
            }
            ?>

            // Function to close success message
            function closeSuccessMessage() {
                document.getElementById("successMessage").style.display = "none";
            }
        </script>

    </main>
</div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../config/dbcon.php";

    // Escape user inputs for security
    $flight_id = mysqli_real_escape_string($con, $_GET['flight_id']);
    $layover_duration = mysqli_real_escape_string($con, $_POST['layover_duration']);
    $departure_location = mysqli_real_escape_string($con, $_POST['departure_location']);

    // Check if there is already an entry for the given flight_id
    $existing_entry_query = "SELECT * FROM stop WHERE flight_id = '$flight_id'";
    $existing_entry_result = mysqli_query($con, $existing_entry_query);

    if (mysqli_num_rows($existing_entry_result) > 0) {
        // An entry already exists for the given flight_id
        echo '<script>alert("ERROR: Entry already exists for the given flight_id.");</script>';
    } else {
        // If no entry exists, attempt the insert query execution
        $sql = "INSERT INTO `stop` (flight_id, one_stop_name, one_stop_layover_duration) VALUES ('$flight_id', '$departure_location', '$layover_duration')";

        if (mysqli_query($con, $sql)) {
            // Record added successfully
        } else {
            echo '<script>alert("ERROR: Could not able to execute $sql. ' . mysqli_error($con) . '");</script>';
        }
    }

    // Close the database connection
    mysqli_close($con);
}
?>



