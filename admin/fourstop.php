<?php
include("stop.php");

if (isset($_GET['flight_id'])) {
    $id = $_GET['flight_id'];
    echo $id;
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Form for onestop table</title>
    <style>
         body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            margin-top: 91px;
            margin-left:20px;
            height: 494px;
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* max-width: 600px; */
            width: 94%;
            box-sizing: border-box;
        }

        h2, h3 {
            color: #0b3958;
        }

        .one {
            display: flex;
            width: 250px;
            flex-direction: column;
            margin-bottom: 20px;
        }
        .two{
            display: flex;
            flex-direction: column;
            margin-bottom: -20px;
            width: 250px;
            margin-top: -249px;
            margin-left: 258px;
        }

        .three{
            display: flex;
            flex-direction: column;
            margin-bottom: 9px;
            width: 250px;
            margin-top: -239px;
            margin-left: 528px;
        }
        .four{
            display: flex;
            flex-direction: column;
            margin-bottom: 9px;
            width: 250px;
            margin-top: -239px;
            margin-left: 800px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        select, input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"], .view_but {
            background-color: #0b3958;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        input[type="submit"]:hover, .view_but:hover {
            background-color: #2980b9;
        }
    </style>


</head>

<body>

    <form action="#" method="post">
        <h2>Three Stop Details</h2>
        <div class="one">
        <h3>Enter details of stop one</h3>
        <label for="layover_duration">Layover Duration (Hours):</label>
        <select name="layover_duration" required>
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
        </div>
        
        <div class="two">
        <h3>Enter details of stop two</h3>
        <label for="layover_duration">Layover Duration (Hours):</label>
        <select name="layover_duration2" required>
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

        <label for="departure_location">Layover Stop:</label>
        <select name="departure_location2" id="departure_location2" required>
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
        </div>


        <div class="three">
        <h3>Enter details of stop three</h3>
        <label for="layover_duration">Layover Duration (Hours):</label>
        <select name="layover_duration3" required>
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

        Layover Stop:
        <select name="departure_location3" id="departure_location3" required>
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
        </div>


        <div class="four">
        <h3>Enter details of stop four</h3>
        <label for="layover_duration">Layover Duration (Hours):</label>
        <select name="layover_duration4" required>
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

        Layover Stop:
        <select name="departure_location4" id="departure_location4" required>
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
        </div>


        <input type="submit" value="Add"><br><br>
        <a href="twostop_view.php" class="view_but">view details</a>

    </form>



</body>

</html>
