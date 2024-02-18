<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight List</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .bodyy {
            background-color: #f8f9fa;
        }

        .container2 {
            max-width: 800px;
            margin: auto; /* Center the container */
        }

        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        p {
            margin-bottom: 10px;
        }

        .btn-add-details {
            display: block;
            margin-top: 10px;
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
            <?php
            include "../config/dbcon.php";

            // Retrieve flights with one_stop
            $query = "SELECT f.flight_id, f.flight_name, al.airline_name, a.airbus_name
                    FROM flight f
                    JOIN airline al ON f.airline_id = al.airline_id
                    JOIN airbus a ON f.airbus_id = a.airbus_id
                    WHERE f.stop = 'one stop';";

            $result = mysqli_query($con, $query);

            if ($result) {
                ?>
                <div class="container2">
                    <h2 class="mb-4">Flights with One Stop</h2>
                    <div class="row">
                        <?php
                        $count = 0;
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="col-md-4">
                                <div class="card mx-auto">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['flight_name']; ?></h5>
                                        <p class="card-text">Airline: <?php echo $row['airline_name']; ?></p>
                                        <p class="card-text">Airbus: <?php echo $row['airbus_name']; ?></p>
                                        <!-- Pass flight_id as a query parameter -->
                                        <a href="stop_one_form.php?flight_id=<?php echo $row['flight_id']; ?>" class="btn btn-primary btn-add-details">Add One Stop Details</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $count++;
                            if ($count % 3 == 0) {
                                // Start a new row after every 3 cards
                                echo '</div><div class="row">';
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php
            } else {
                echo "Error: " . mysqli_error($con);
            }

            mysqli_close($con);
            ?>

            <!-- Include Bootstrap JS and Popper.js -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </main>
    </div>
</body>
</html>
