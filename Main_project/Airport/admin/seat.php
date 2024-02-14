<?php
include "../config/dbcon.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
    .bodyy {
        background-color: #f8f9fa;
    }

    .container2 {
        margin-top: 50px;
    }

    .flight-card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .flight-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        background-color: #007bff !important;
        color: #ffffff !important;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>

     <?php
        include("includes/header.php");
    ?>
</head>
<body class="bodyy">

<div class="container">

        <?php
        include 'includes/header2.php';
        ?>
    <main>
        <div class="container2">
            <h2 class="mb-4">Add Seat</h2>
            
            <div class="row">
                <?php
                // Check connection
                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                $sql = "SELECT flight.flight_id, flight.flight_name, airline.airline_name, airbus.airbus_name, airbus.passenger_capacity
                        FROM flight
                        JOIN airline ON flight.airline_id = airline.airline_id
                        JOIN airbus ON flight.airbus_id = airbus.airbus_id";

                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-md-4">
                            <div class="card flight-card">
                                <div class="card-header">
                                    <h5 class="mb-0"><?php echo $row["flight_name"]; ?></h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"><strong>Airline:</strong> <?php echo $row["airline_name"]; ?></p>
                                    <p class="card-text"><strong>Airbus:</strong> <?php echo $row["airbus_name"]; ?></p>
                                    <p class="card-text"><strong>Seat Capacity:</strong> <?php echo $row["passenger_capacity"]; ?></p>
                                    <a href='add_seat.php?flight_id=<?php echo $row["flight_id"]; ?>' class='btn btn-primary btn-sm'>Add Seat</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No flights found</p>";
                }

                $con->close();
                ?>
            </div>
        </div>
    </main>
</div>

</body>
</html>
