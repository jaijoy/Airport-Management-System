<?php
include "../config/dbcon.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Schedule Form</title>
    <style>
        body {
            background-color: #f8f9fa;
            margin-top: 3px;
        }

        .container2 {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            width: 492px;
    margin-left: 356px;
        }

        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php
include("includes/header.php");
?>

<div class="container">
    <?php
    include 'includes/header2.php';
    ?>

    <main>
    <div class="container2">
        <h2>Schedule Form</h2>
        <form action="#" method="post" >

            <div class="form-group">
                <label for="day_of_week">Day of Week:</label>
                <select class="form-control" id="day_of_week" name="day_of_week" required>
                    <option value="">Select Day</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
                <small id="day_of_week_error" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label for="departure_time">Departure Time:</label>
                <input type="time" class="form-control" id="departure_time" name="departure_time" required>
                <small id="departure_time_error" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label for="arrival_time">Arrival Time:</label>
                <input type="time" class="form-control" id="arrival_time" name="arrival_time" required>
                <small id="arrival_time_error" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label for="gate_departure">Departure Gate:</label>
                <input type="text" class="form-control" id="gate_departure" name="gate_departure" required>
                <small id="gate_departure_error" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label for="gate_arrival">Arrival Gate:</label>
                <input type="text" class="form-control" id="gate_arrival" name="gate_arrival" required>
                <small id="gate_arrival_error" class="text-danger"></small>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>
    </main>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>


<?php
include "../config/dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $flight_id = mysqli_real_escape_string($con, $_GET['flight_id']);
    $day_of_week = $_POST['day_of_week'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $gate_departure = $_POST['gate_departure'];
    $gate_arrival = $_POST['gate_arrival'];

    // SQL insert statement
    $sql = "INSERT INTO Schedule (flight_id, day_of_week, departure_time, arrival_time, gate_departure, gate_arrival)
            VALUES ('$flight_id', '$day_of_week', '$departure_time', '$arrival_time', '$gate_departure', '$gate_arrival')";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
}
?>
