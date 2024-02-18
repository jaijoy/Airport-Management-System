<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Details</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container2 {
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
            border: none;
            border-radius: 10px;
        }

        .card:hover {
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 0.5rem;
        }

        .card-text {
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .modal-content {
            background-color: #fff;
        }

        .modal-header {
            background-color: #007bff;
            color: #fff;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
    <?php
        include("includes/header.php");
    ?>
</head>
<body>
<div class="container">

<?php
include 'includes/header2.php';
?>
<main>
    <div class="container2">


    <?php
// Check for error message in the session
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo $_SESSION['error_message'];
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';

    // Clear the error message from the session
    unset($_SESSION['error_message']);
}
?>


        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            include "../config/dbcon.php";

            function getSeatDetails($con, $flightId)
            {
                $seatDetailsQuery = "SELECT * FROM seat WHERE flight_id = '$flightId'";
                $seatDetailsResult = mysqli_query($con, $seatDetailsQuery);

                if ($seatDetailsResult) {
                    return mysqli_fetch_assoc($seatDetailsResult);
                } else {
                    return false;
                }
            }

            function getTotalSeats($con, $flightId)
            {
                $seatDetails = getSeatDetails($con, $flightId);
                if ($seatDetails) {
                    return $seatDetails['total_seat'];
                } else {
                    return 0;
                }
            }

            // Fetch flight details
            $flightDetailsQuery = "SELECT flight.flight_id, flight.flight_name, flight.airline_id, flight.airbus_id, airline.airline_name, airbus.airbus_name, airbus.passenger_capacity
                                  FROM flight
                                  JOIN airline ON flight.airline_id = airline.airline_id
                                  JOIN airbus ON flight.airbus_id = airbus.airbus_id";
            $flightDetailsResult = mysqli_query($con, $flightDetailsQuery);

            if ($flightDetailsResult) {
                while ($row = mysqli_fetch_assoc($flightDetailsResult)) {
                    $flightId = $row['flight_id'];
                    $flightName = $row['flight_name'];
                    $airlineName = $row['airline_name'];
                    $airbusName = $row['airbus_name'];
                    $passengerCapacity = $row['passenger_capacity'];
                    $totalSeats = getTotalSeats($con, $flightId);
            ?>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $flightName; ?></h5>
                        <p class="card-text">Airline: <?php echo $airlineName; ?></p>
                        <p class="card-text">Airbus: <?php echo $airbusName; ?></p>
                        <p class="card-text">Airbus Capacity: <?php echo $passengerCapacity; ?></p>
                        <p class="card-text">Total Seats: <?php echo $totalSeats; ?></p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seatDetailsModal<?php echo $flightId; ?>">
                            Seat Details
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editSeatDetailsModal<?php echo $flightId; ?>">
                            Edit
                        </button>
                    </div>
                </div>

                <!-- Modal for Seat Details -->
                <div class="modal fade" id="seatDetailsModal<?php echo $flightId; ?>" tabindex="-1" aria-labelledby="seatDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="seatDetailsModalLabel">Seat Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                    $seatDetails = getSeatDetails($con, $flightId);
                                    if ($seatDetails) {
                                ?>
                                <p>Economy Seats: <?php echo $seatDetails['no_economy']; ?></p>
                                <p>Premium Economy Seats: <?php echo $seatDetails['no_premium']; ?></p>
                                <p>Business Seats: <?php echo $seatDetails['no_business']; ?></p>
                                <p>First Class Seats: <?php echo $seatDetails['no_first']; ?></p>
                                <?php
                                    } else {
                                        echo "Seat details not available.";
                                    }
                                ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Edit Seat Details -->
                <div class="modal fade" id="editSeatDetailsModal<?php echo $flightId; ?>" tabindex="-1" aria-labelledby="editSeatDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSeatDetailsModalLabel">Edit Seat Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form for editing seat details -->
                                <form action="edit_seat_details.php" method="post">
                                    <input type="hidden" name="flight_id" value="<?php echo $flightId; ?>">
                                    <div class="mb-3">
                                        <label for="no_economy" class="form-label">Economy Seats</label>
                                        <input type="text" class="form-control" id="no_economy" name="no_economy" value="<?php echo $seatDetails['no_economy']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_premium" class="form-label">Premium Economy Seats</label>
                                        <input type="text" class="form-control" id="no_premium" name="no_premium" value="<?php echo $seatDetails['no_premium']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_business" class="form-label">Business Seats</label>
                                        <input type="text" class="form-control" id="no_business" name="no_business" value="<?php echo $seatDetails['no_business']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_first" class="form-label">First Class Seats</label>
                                        <input type="text" class="form-control" id="no_first" name="no_first" value="<?php echo $seatDetails['no_first']; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</main>
</div>
</body>
</html>
