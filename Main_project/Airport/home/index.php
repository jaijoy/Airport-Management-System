<?php
    session_start();
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Flight Booking</title>
    <style>
        /* Custom Styles */
        .bdy {
            padding-top: 56px; /* Adjusted for fixed navbar height */
        }
        .hero-section {
            background: url(images/back1.jpg) center/cover no-repeat;
            color: #fff;
            font-weight: bold;
            color: #fff;
            text-align: center;
            padding: 150px 20px;
            
        }
        .search-form {
            max-width: 600px;
            margin: 0 auto;
            
        }
        .featured-flights {
            margin: 40px 0;
        }
        .flight-card {
            transition: transform 0.3s ease-in-out;
        }
        .flight-card:hover {
            transform: scale(1.05);
        }

        .display-4{
            font-weight: bold;
        }
        .lead{
            font-weight: bold;
        }
    </style>
</head>
<body class="bdy">
<?php
include("includes/base.php");
?>

<?php
include "../config/dbcon.php";
?>
 

<div class="hero-section">
        <div class="container">
        
            <h1 class="display-4">Find Your Next Adventure</h1>
            <p class="lead">Book your flights with ease and convenience.</p>
            <form action="flight_result2.php" method="get"  onsubmit="return validateForm()">
                <div class="form-row align-items-center">


                    <div class="col-md-4 mb-3">
                        <label for="departure_location">Departure Location:</label>
                        <select class="form-control" name="departure_location" id="departure_location" >
                        <option selected disabled>Select Departure Location</option>
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
                        <select class="form-control" name="destination_location" id="destination_location" >
                        <option selected disabled>Select Destination Location</option>
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
    <input type="date" class="form-control" id="departureDate" name="departureDate" >
</div>

                    <div class="col-md-2 mb-3">
                        <label></label>
                        <button type="submit" class="btn btn-primary btn-block">Search Flights</button>
                    </div>
                </div>
            </form>
        </div>
    </div>





<?php
include("includes/featured.php");
?>
<?php
include("includes/foot.php");
?>

 <!-- Bootstrap Scripts -->
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
    <script>
    function validateForm() {
        var departureLocation = document.getElementById('departure_location').value;
        var destinationLocation = document.getElementById('destination_location').value;
        var departureDate = document.getElementById('departureDate').value;

        if (departureLocation === "" && destinationLocation === "" && departureDate === "") {
            alert("Please select at least one of Departure Location, Destination Location, or Departure Date.");
            return false;
        }

        return true;
    }
</script>
</body>
</html>