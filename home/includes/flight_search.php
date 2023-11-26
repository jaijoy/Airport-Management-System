<?php
include "../config/dbcon.php";
?>
 
 <!-- Hero Section with Search Form -->
 <head>
    <style>
        .display-4{
            font-weight: bold;
        }
        .lead{
            font-weight: bold;
        }
    </style>
 </head>
 <div class="hero-section">
        <div class="container">
        
            <h1 class="display-4">Find Your Next Adventure</h1>
            <p class="lead">Book your flights with ease and convenience.</p>
            <form action="flight_result2.php" method="post">
                <div class="form-row align-items-center">


                    <div class="col-md-4 mb-3">
                        <label for="departure_location">Departure Location:</label>
                        <select class="form-control" name="departure_location" id="departure_location" required>
                            <option></option>
                            <?php
                            $airport_query = "SELECT * FROM airport where `status`=1";
                            $airport_result = mysqli_query($con, $airport_query);
                            while ($row = mysqli_fetch_array($airport_result)) {
                                echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="destinationCity">Destination City</label>
                        <select class="form-control" name="destination_location" id="destination_location" required>
                            <option></option>
                            <?php
                            $airport_query ="SELECT * FROM airport where `status`=1";
                            $airport_result = mysqli_query($con, $airport_query);
                            while ($row = mysqli_fetch_array($airport_result)) {
                                echo "<option value='" . $row['airport_id'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>


                    <div class="col-md-2 mb-3">
                        <label for="departureDate">Departure Date</label>
                        <input type="date" class="form-control" id="departureDate" required>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
