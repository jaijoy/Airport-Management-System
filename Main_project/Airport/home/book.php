<?php
// Start the session
session_start();

// Check if the email is set in the session
if (!isset($_SESSION['auth_user']['email'])) {
    // Retrieve the email from the session
    header("Location: login.php"); // Redirect to your login page
    exit();
}
    $userEmail = $_SESSION['auth_user']['email'];


    if (isset($_GET['flightId'])) {
        $flight_Id = $_GET['flightId'];
        echo $flight_Id;
    } else {
        // Handle the case when 'flightId' is not set, e.g., redirect the user to an error page.
        echo "no fk";
    }
    


include "../config/dbcon.php";



// Process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['sub'])) {
    // Your existing logic here...
    $flight_Id = $_GET['flightId'];
    $numInfants =$_POST["numInfants"] ;
    $infantsNeedSeat = isset($_POST["infantsNeedSeat"]) ? $_POST["infantsNeedSeat"] : 0;
    $numInfantSeats = $_POST["numInfantSeats"] ;
    $numChildren = $_POST["numChildren"] ;
    $numAdults = $_POST["numAdults"] ;
    echo "numInfants: $numInfants, infantsNeedSeat: $infantsNeedSeat, numInfantSeats: $numInfantSeats, numChildren: $numChildren, numAdults: $numAdults";

    // Calculate total_human
    $totalHuman = (int)$numInfantSeats + (int)$numChildren + (int)$numAdults;

    // Insert data into the database
    $sql = "INSERT INTO book_one (numInfants, infantsNeedSeat, numInfantSeats, numChildren, numAdults, total_human, email, flight_id)
        VALUES ('$numInfants', '$infantsNeedSeat', '$numInfantSeats', '$numChildren', '$numAdults', '$totalHuman', '$userEmail', '$flight_Id')";

echo $sql;
    if ($con->query($sql) == TRUE) {
        echo "Booking successfully submitted!";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Form Design</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Optional: Add your custom styles here -->
    <style>
        /* Add your custom styles if needed */
        body {
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Flight Booking Form</h2>
        <form action="book1.php" method="post">
            <!-- Your existing form fields... -->

            <div class="form-group">
                <a href="#" data-toggle="modal" data-target="#infantDetailsModal">Infant Seat Details</a>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="infantDetailsModal" tabindex="-1" role="dialog"
                aria-labelledby="infantDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="infantDetailsModalLabel">Infant Seat Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>You can carry an infant under two years old on your lap and use a special seat belt extension. You can also book a separate seat for your child but they must be seated in a car seat approved for use on board during take-off and landing.</p>
                            <p>If you are traveling with two children under two years old, only one child can be carried on your lap and you’ll have to book a seat for the second infant. You’ll also need to have a car seat approved for use on board for the infant traveling in their own seat.</p>
                            <p>For children over two years old, you'll need to buy a child's fare and they'll have their own seat.</p>
                            <p>If you’re bringing your own child safety belt or seat, please check our guidelines on child restraint devices that you can use on board.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Your existing form fields... -->
            <div class="form-group">
                <label for="numInfants">Number of Infants (below 2 years):</label>
                <input type="number" class="form-control" id="numInfants" name="numInfants"  >
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="infantsNeedSeat" name="infantsNeedSeat">
                <label class="form-check-label" for="infantsNeedSeat">Infants Need a Seat</label>
            </div>

            <div class="form-group" id="infantSeatInput" style="display: none;">
                <label for="numInfantSeats">Number of Infant Seats:</label>
                <input type="number" class="form-control" id="numInfantSeats" name="numInfantSeats" >
            </div>

            <div class="form-group">
                <label for="numChildren">Number of Children (2 - 12 years):</label>
                <input type="number" class="form-control" id="numChildren" name="numChildren">
            </div>

            <div class="form-group">
                <label for="numAdults">Number of Adults (12 years and above):</label>
                <input type="number" class="form-control" id="numAdults" name="numAdults" >
            </div>

            <button type="submit" class="btn btn-primary btn-add-details" name="sub">submit</button>
    
            <a href="book2.php?flightId=<?php echo $flight_Id ?>" class="btn btn-primary btn-add-details">Next-></a>


        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        // Show/hide infant seat input based on checkbox
        document.getElementById("infantsNeedSeat").addEventListener("change", function () {
            var infantSeatInput = document.getElementById("infantSeatInput");
            infantSeatInput.style.display = this.checked ? "block" : "none";
        });
    </script>

</body>

</html>













<?php
session_start();
include("includes/base.php");
include "../config/dbcon.php";


$book_two_id = isset($_GET['book_two_id']) ? $_GET['book_two_id'] : '';


// Assuming the form data is sent as a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Book_Two_ID=$_POST['booktwoid'];
   // echo $Book_Two_ID;
   $checkDuplicateQuery = "SELECT COUNT(*) as count FROM seat_selection WHERE book_two_id = '$Book_Two_ID'";
   $resultDuplicate = $con->query($checkDuplicateQuery);

   if ($resultDuplicate && $resultDuplicate->num_rows > 0) {
       $row = $resultDuplicate->fetch_assoc();
       $duplicateCount = $row['count'];

       if ($duplicateCount > 0) {
        echo "<script>alert('Error: Record with book_two_id $Book_Two_ID already exists.');</script>";

       } 
       else{
                    $sqlFetchDetails = "SELECT bo.total_human, fl.flight_name, bo.passenger_total_seat, st.total_seat, st.no_economy, st.economy_price,
                                    st.no_premium, st.premium_price, st.no_business, st.business_price,
                                    st.no_first, st.first_price, fl.price as flight_price
                                FROM book_one bo
                                JOIN flight fl ON bo.flight_id = fl.flight_id
                                JOIN seat st ON bo.flight_id = st.flight_id
                                WHERE bo.book_id = '$Book_Two_ID'";

                //echo "Debug: SQL Query = $sqlFetchDetails<br>";
                    $result = $con->query($sqlFetchDetails);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $flight_price = $row['flight_price'];
                        $totalHuman = $row['total_human'];
                        $passenger_totalSeat = $row['passenger_total_seat'];
                        $flightName = $row['flight_name'];
                        $totalSeat = $row['total_seat'];
                        $noEconomy = $row['no_economy'];
                        $economyPrice = $row['economy_price'];
                        $noPremium = $row['no_premium'];
                        $premiumPrice = $row['premium_price'];
                        $noBusiness = $row['no_business'];
                        $businessPrice = $row['business_price'];
                        $noFirst = $row['no_first'];
                        $firstPrice = $row['first_price'];

                        
                        
                        $numEconomySeat = isset($_POST['economySeat']) ? (int)$_POST['economySeat'] : 0;
                        $numPremiumEconomySeat = isset($_POST['premiumEconomySeat']) ? (int)$_POST['premiumEconomySeat'] : 0;
                        $numBusinessClassSeat = isset($_POST['businessClassSeat']) ? (int)$_POST['businessClassSeat'] : 0;
                        $numFirstClassSeat = isset($_POST['firstClassSeat']) ? (int)$_POST['firstClassSeat'] : 0;
                        
                        // Calculate variables based on form data
                        // Calculate variables based on form data
                $total_human_flight_price = (float)$flight_price * (int)$totalHuman;
                $economy_seat_price = (float)$economyPrice * (int)$numEconomySeat;
                $premium_seat_price = (float)$premiumPrice * (int)$numPremiumEconomySeat;
                $business_seat_price = (float)$businessPrice * (int)$numBusinessClassSeat;
                $first_seat_price = (float)$firstPrice * (int)$numFirstClassSeat;

                $total_price = $total_human_flight_price + $economy_seat_price + $premium_seat_price + $business_seat_price + $first_seat_price;

                        // Construct the INSERT query
                    // Construct the INSERT query with proper handling of checkbox values
                $insertQuery = "
                INSERT INTO seat_selection (
                    num_economy_seat,
                    num_premium_economy_seat,
                    num_business_class_seat,
                    num_first_class_seat,
                    total_price,
                    book_two_id
                ) VALUES (
                
                    $numEconomySeat,
                    $numPremiumEconomySeat,
                    $numBusinessClassSeat,
                    $numFirstClassSeat,
                    $total_price,
                    $Book_Two_ID
                );
                ";

                // Handle NULL values for checkboxes
                $insertQuery = str_replace('NULL,', '0,', $insertQuery);
                $insertQuery = str_replace(', NULL', ', 0', $insertQuery);

                // Execute the query
               
                if (mysqli_query($con, $insertQuery)) {
                    $lastInsertedId = mysqli_insert_id($con);
                    echo "New record created successfully with book_two_id: " . $lastInsertedId;
            
                    // Use JavaScript to redirect
                    echo "<script>";
                    echo "window.location.href = 'book4.php?book_three_id=" . $lastInsertedId . "';";
                    echo "</script>";
                    exit();

                } else {
                //echo "Error: " . $insertQuery . "<br>" . $con->error;
                }
            }
    }
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 600px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        .seat-input {
            display: none;
            margin-top: 10px;
        }

        input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
    <form action="book3.php" method="post">
    <input type="text" name="flight_price" value="<?php echo $flight_price; ?>" readonly>
<input type="text" name="totalHuman" value="<?php echo $totalHuman; ?>" readonly>
<input type="text" name="passenger_totalSeat" value="<?php echo $passenger_totalSeat; ?>" readonly>
<!-- Add similar lines for other variables -->

    <input type="text" name="total_seat_need" value="<?php echo  $totalSeat  ?>">
    <input type="hidden" name="booktwoid" value="<?php echo $book_two_id; ?>">
    <?php
            $sqlFetchFlightName = "SELECT f.flight_name
                                FROM flight f
                                JOIN book_one b ON f.flight_id = b.flight_id
                                JOIN passenger_details pd ON b.book_id = pd.book_id
                                WHERE pd.book_two_id = $book_two_id";

            $result = $con->query($sqlFetchFlightName);

            if ($result === false) {
                // Handle query execution error
                echo "Error executing the query: " . $con->error;
            } else {
                // Check if any rows were returned
                if ($result->num_rows > 0) {
                    // Output data of the first row (assuming you expect one row)
                    $row = $result->fetch_assoc();
                    $flight_Name = $row["flight_name"];
                    //echo $flightName;
                } else {
                    $flight_Name = "No results found";
                }
            }

            // Close the database connection
            $con->close();
    ?>
        <h2>Seat Selection : <?php  echo $flight_Name; ?></h2>
        <h4 class="card-title">Total Flight Price (INR):<?php //echo $total_price; ?> </h4>

    </div>


    <div class="card-header2">
        
    </div>
           
            <div class="card-body">
                <div class="form-group">
                    <label>Check the classes you prefer:</label><br>
                    <input type="checkbox" id="economyCheckbox" name="classCheck[]" value="economy" onchange="showHideSeatInput('economy')">
                    <label for="economyCheckbox"> Economy</label>
                    <div id="economySeatInput" class="seat-input">
                        <label for="economySeat">Number of Economy Seats Needed:</label>
                        <input type="number" id="economySeat" name="economySeat" min="0">
                    </div>

                    <br>
                    <input type="checkbox" id="premiumEconomyCheckbox" name="classCheck[]" value="premium_economy" onchange="showHideSeatInput('premiumEconomy')">
                    <label for="premiumEconomyCheckbox"> Premium Economy</label>
                    <div id="premiumEconomySeatInput" class="seat-input">
                        <label for="premiumEconomySeat">Number of Premium Economy Seats Needed:</label>
                        <input type="number" id="premiumEconomySeat" name="premiumEconomySeat" min="0">
                    </div>

                    <br>
                    <input type="checkbox" id="businessClassCheckbox" name="classCheck[]" value="business_class" onchange="showHideSeatInput('businessClass')">
                    <label for="businessClassCheckbox"> Business Class</label>
                    <div id="businessClassSeatInput" class="seat-input">
                        <label for="businessClassSeat">Number of Business Class Seats Needed:</label>
                        <input type="number" id="businessClassSeat" name="businessClassSeat" min="0">
                    </div>

                    <br>
                    <input type="checkbox" id="firstClassCheckbox" name="classCheck[]" value="first_class" onchange="showHideSeatInput('firstClass')">
                    <label for="firstClassCheckbox"> First Class</label>
                    <div id="firstClassSeatInput" class="seat-input">
                        <label for="firstClassSeat">Number of First Class Seats Needed:</label>
                        <input type="number" id="firstClassSeat" name="firstClassSeat" min="0">
                    </div>
                </div>

                <button onclick="submitForm()">Submit</button>
            </div>
    </form>
</div>

<script>
    function showHideSeatInput(className) {
        var seatInput = document.getElementById(className + 'SeatInput');
        var checkbox = document.getElementById(className + 'Checkbox');
        seatInput.style.display = checkbox.checked ? 'block' : 'none';
    }

    function submitForm() {
        // Add logic to submit the form data
    }
</script>

</body>
</html>

<!-- 

CREATE TABLE IF NOT EXISTS seat_selection (
    seat_selection_id INT PRIMARY KEY AUTO_INCREMENT,
    economy_checkbox BOOLEAN,
    num_economy_seat INT,
    premium_economy_checkbox BOOLEAN,
    num_premium_economy_seat INT,
    business_class_checkbox BOOLEAN,
    num_business_class_seat INT,
    first_class_checkbox BOOLEAN,
    num_first_class_seat INT,
    left_economy int,
	left_premium int,
	left_business int,
	left_first int,
	
); -->






























x book3



<?php
session_start();
include("includes/base.php");
include "../config/dbcon.php";


$book_two_id = isset($_GET['book_two_id']) ? $_GET['book_two_id'] : '';


// Assuming the form data is sent as a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['sub'])) {
    $Book_Two_ID=$_POST['booktwoid'];
   // echo $Book_Two_ID;
   $checkDuplicateQuery = "SELECT COUNT(*) as count FROM seat_selection WHERE book_two_id = '$Book_Two_ID'";
   $resultDuplicate = $con->query($checkDuplicateQuery);

   if ($resultDuplicate && $resultDuplicate->num_rows > 0) {
       $row = $resultDuplicate->fetch_assoc();
       $duplicateCount = $row['count'];

       if ($duplicateCount > 0) {
        echo "<script>alert('Error: Record with book_two_id $Book_Two_ID already exists.');</script>";
            
       } 
       else{
                    $sqlFetchDetails = "SELECT bo.total_human, fl.flight_name, bo.passenger_total_seat, st.total_seat, st.no_economy, st.economy_price,
                                    st.no_premium, st.premium_price, st.no_business, st.business_price,
                                    st.no_first, st.first_price, fl.price as flight_price
                                FROM book_one bo
                                JOIN flight fl ON bo.flight_id = fl.flight_id
                                JOIN seat st ON bo.flight_id = st.flight_id
                                WHERE bo.book_id = '$Book_Two_ID'";

                //echo "Debug: SQL Query = $sqlFetchDetails<br>";
                    $result = $con->query($sqlFetchDetails);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $flight_price = $row['flight_price'];
                        $totalHuman = $row['total_human'];
                        $passenger_totalSeat = $row['passenger_total_seat'];
                        $flightName = $row['flight_name'];
                        $totalSeat = $row['total_seat'];
                        $noEconomy = $row['no_economy'];
                        $economyPrice = $row['economy_price'];
                        $noPremium = $row['no_premium'];
                        $premiumPrice = $row['premium_price'];
                        $noBusiness = $row['no_business'];
                        $businessPrice = $row['business_price'];
                        $noFirst = $row['no_first'];
                        $firstPrice = $row['first_price'];

                        
                        
                        $numEconomySeat = isset($_POST['economySeat']) ? (int)$_POST['economySeat'] : 0;
                        $numPremiumEconomySeat = isset($_POST['premiumEconomySeat']) ? (int)$_POST['premiumEconomySeat'] : 0;
                        $numBusinessClassSeat = isset($_POST['businessClassSeat']) ? (int)$_POST['businessClassSeat'] : 0;
                        $numFirstClassSeat = isset($_POST['firstClassSeat']) ? (int)$_POST['firstClassSeat'] : 0;
                        
                        // Calculate variables based on form data
                        // Calculate variables based on form data
                $total_human_flight_price = (float)$flight_price * (int)$totalHuman;
                $economy_seat_price = (float)$economyPrice * (int)$numEconomySeat;
                $premium_seat_price = (float)$premiumPrice * (int)$numPremiumEconomySeat;
                $business_seat_price = (float)$businessPrice * (int)$numBusinessClassSeat;
                $first_seat_price = (float)$firstPrice * (int)$numFirstClassSeat;

                $total_price = $total_human_flight_price + $economy_seat_price + $premium_seat_price + $business_seat_price + $first_seat_price;

                        // Construct the INSERT query
                    // Construct the INSERT query with proper handling of checkbox values
                $insertQuery = "
                INSERT INTO seat_selection (
                    num_economy_seat,
                    num_premium_economy_seat,
                    num_business_class_seat,
                    num_first_class_seat,
                    total_price,
                    book_two_id
                ) VALUES (
                
                    $numEconomySeat,
                    $numPremiumEconomySeat,
                    $numBusinessClassSeat,
                    $numFirstClassSeat,
                    $total_price,
                    $Book_Two_ID
                );
                ";

                // Handle NULL values for checkboxes
                $insertQuery = str_replace('NULL,', '0,', $insertQuery);
                $insertQuery = str_replace(', NULL', ', 0', $insertQuery);

                // Execute the query
               
                if (mysqli_query($con, $insertQuery)) {
                    $lastInsertedId = mysqli_insert_id($con);
                    echo "New record created successfully with book_two_id: " . $lastInsertedId;
            
                    // Use JavaScript to redirect
                    echo "<script>";
                    echo "window.location.href = 'book4.php?book_three_id=" . $lastInsertedId . "';";
                    echo "</script>";
                    exit();

                } else {
                //echo "Error: " . $insertQuery . "<br>" . $con->error;
                }
            }
    }
}
}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 600px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        .seat-input {
            display: none;
            margin-top: 10px;
        }

        input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
    <form action="book3.php" method="post">

    <input type="hidden" name="booktwoid" value="<?php echo $book_two_id; ?>">

    <?php
            $sqlFetchFlightName = "SELECT bo.total_human, fl.flight_name, bo.passenger_total_seat, st.total_seat, st.no_economy, st.economy_price,
            st.no_premium, st.premium_price, st.no_business, st.business_price,
            st.no_first, st.first_price, fl.price as flight_price
            FROM book_one bo
            JOIN flight fl ON bo.flight_id = fl.flight_id
            JOIN seat st ON bo.flight_id = st.flight_id
            WHERE bo.book_id = '$book_two_id'";


            $result = $con->query($sqlFetchFlightName);

            if ($result === false)
             {
                // Handle query execution error
                echo "Error executing the query: " . $con->error;
            } 
            else 
            {
                // Check if any rows were returned
                if ($result->num_rows > 0)
                {
                    // Output data of the first row (assuming you expect one row)
                        $row = $result->fetch_assoc();
                        $flight_Name = $row["flight_name"];
                        $flight_price = $row['flight_price'];
                        $totalHuman = $row['total_human'];
                        $passenger_totalSeat = $row['passenger_total_seat'];
                        $totalSeat = $row['total_seat'];
                        $noEconomy = $row['no_economy'];
                        $economyPrice = $row['economy_price'];
                        $noPremium = $row['no_premium'];
                        $premiumPrice = $row['premium_price'];
                        $noBusiness = $row['no_business'];
                        $businessPrice = $row['business_price'];
                        $noFirst = $row['no_first'];
                        $firstPrice = $row['first_price'];
                    //echo $flightName;
                } 
                else 
                {
                    $flight_Name = "No results found";
                }
            }

            // Close the database connection
            $con->close();
    ?>


        <h2>Seat Selection : <?php  echo $flight_Name; ?></h2>
        <h4 class="card-title">Total Flight Price (INR):<?php //echo $total_price; ?> </h4>


        <input type="text" name="flight_price" value="<?php echo $flight_price; ?>" readonly>
       
        <input type="text" name="economy_one_price" value="<?php echo $economyPrice; ?>" readonly>

        <input type="text" name="totalHuman" value="<?php echo $totalHuman; ?>" readonly>
        <input type="text" name="passenger_totalSeat" value="<?php echo $passenger_totalSeat; ?>" readonly>

    </div>


    <div class="card-header2">
        
    </div>
           
            <div class="card-body">
                <div class="form-group">
                    <label>Check the classes you prefer:</label><br>
                    <input type="checkbox" id="economyCheckbox" name="classCheck[]" value="economy" onchange="showHideSeatInput('economy')">
                    <label for="economyCheckbox"> Economy</label>
                    <div id="economySeatInput" class="seat-input">
    <label for="economySeat">Number of Economy Seats Needed:</label>
    <input type="number" id="economySeat" name="economySeat" min="0">
    <button id="calculate_e_price">Calculate Economy Price</button>
    <span id="totalEconomyPrice"></span>
</div>


                    <br>
                    <input type="checkbox" id="premiumEconomyCheckbox" name="classCheck[]" value="premium_economy" onchange="showHideSeatInput('premiumEconomy')">
                    <label for="premiumEconomyCheckbox"> Premium Economy</label>
                    <div id="premiumEconomySeatInput" class="seat-input">
                        <label for="premiumEconomySeat">Number of Premium Economy Seats Needed:</label>
                        <input type="number" id="premiumEconomySeat" name="premiumEconomySeat" min="0">
                       
                    </div>

                    <br>
                    <input type="checkbox" id="businessClassCheckbox" name="classCheck[]" value="business_class" onchange="showHideSeatInput('businessClass')">
                    <label for="businessClassCheckbox"> Business Class</label>
                    <div id="businessClassSeatInput" class="seat-input">
                        <label for="businessClassSeat">Number of Business Class Seats Needed:</label>
                        <input type="number" id="businessClassSeat" name="businessClassSeat" min="0">
                    </div>

                    <br>
                    <input type="checkbox" id="firstClassCheckbox" name="classCheck[]" value="first_class" onchange="showHideSeatInput('firstClass')">
                    <label for="firstClassCheckbox"> First Class</label>
                    <div id="firstClassSeatInput" class="seat-input">
                        <label for="firstClassSeat">Number of First Class Seats Needed:</label>
                        <input type="number" id="firstClassSeat" name="firstClassSeat" min="0">
                    </div>
                </div>

                <button onclick="submitForm()">Submit</button>
            </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function showHideSeatInput(className) {
        var seatInput = document.getElementById(className + 'SeatInput');
        var checkbox = document.getElementById(className + 'Checkbox');
        seatInput.style.display = checkbox.checked ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
    var economySeatInput = document.getElementById('economySeat');
    var calculateButton = document.getElementById('calculate_e_price');  // Updated to match the correct ID

    // Attach the calculateTotalEconomyPrice function to the input event
    economySeatInput.addEventListener('input', calculateTotalEconomyPrice);

    // Add an event listener to the calculate button
    calculateButton.addEventListener('click', calculateEconomyPrice);
});

function calculateTotalEconomyPrice() {
    var economySeatInput = document.getElementById('economySeat');
    var economyPrice = parseFloat(document.getElementById('economy_one_price').value);
    var numEconomySeats = parseInt(economySeatInput.value);

    // Calculate total economy price
    var totalEconomyPrice = numEconomySeats * economyPrice;

    // Update the total economy price on the page
    document.getElementById('totalEconomyPrice').innerText = 'Total Economy Price: ' + totalEconomyPrice;
}

// Function to be called when the button is clicked
function calculateEconomyPrice() {
    // Call the existing function to calculate and update the total economy price
    calculateTotalEconomyPrice();
}



</script>


</body>
</html>

<!-- 

CREATE TABLE IF NOT EXISTS seat_selection (
    seat_selection_id INT PRIMARY KEY AUTO_INCREMENT,
    economy_checkbox BOOLEAN,
    num_economy_seat INT,
    premium_economy_checkbox BOOLEAN,
    num_premium_economy_seat INT,
    business_class_checkbox BOOLEAN,
    num_business_class_seat INT,
    first_class_checkbox BOOLEAN,
    num_first_class_seat INT,
    left_economy int,
	left_premium int,
	left_business int,
	left_first int,
	
); -->





































<?php
session_start();
include("includes/base.php");
include "../config/dbcon.php";


$book_two_id = isset($_GET['book_two_id']) ? $_GET['book_two_id'] : '';


// Assuming the form data is sent as a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Book_Two_ID=$_POST['booktwoid'];
   // echo $Book_Two_ID;
   $checkDuplicateQuery = "SELECT COUNT(*) as count FROM seat_selection WHERE book_two_id = '$Book_Two_ID'";
   $resultDuplicate = $con->query($checkDuplicateQuery);

   if ($resultDuplicate && $resultDuplicate->num_rows > 0) {
       $row = $resultDuplicate->fetch_assoc();
       $duplicateCount = $row['count'];

       if ($duplicateCount > 0) {
        echo "<script>alert('Error: Record with book_two_id $Book_Two_ID already exists.');</script>";

       } 
       else{
                    $sqlFetchDetails = "SELECT bo.total_human, fl.flight_name, bo.passenger_total_seat, st.total_seat, st.no_economy, st.economy_price,
                                    st.no_premium, st.premium_price, st.no_business, st.business_price,
                                    st.no_first, st.first_price, fl.price as flight_price
                                FROM book_one bo
                                JOIN flight fl ON bo.flight_id = fl.flight_id
                                JOIN seat st ON bo.flight_id = st.flight_id
                                WHERE bo.book_id = '$Book_Two_ID'";

                //echo "Debug: SQL Query = $sqlFetchDetails<br>";
                    $result = $con->query($sqlFetchDetails);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $flight_price = $row['flight_price'];
                        $totalHuman = $row['total_human'];
                        $passenger_totalSeat = $row['passenger_total_seat'];
                        $flightName = $row['flight_name'];
                        $totalSeat = $row['total_seat'];
                        $noEconomy = $row['no_economy'];
                        $economyPrice = $row['economy_price'];
                        $noPremium = $row['no_premium'];
                        $premiumPrice = $row['premium_price'];
                        $noBusiness = $row['no_business'];
                        $businessPrice = $row['business_price'];
                        $noFirst = $row['no_first'];
                        $firstPrice = $row['first_price'];

                        
                        
                        $numEconomySeat = isset($_POST['economySeat']) ? (int)$_POST['economySeat'] : 0;
                        $numPremiumEconomySeat = isset($_POST['premiumEconomySeat']) ? (int)$_POST['premiumEconomySeat'] : 0;
                        $numBusinessClassSeat = isset($_POST['businessClassSeat']) ? (int)$_POST['businessClassSeat'] : 0;
                        $numFirstClassSeat = isset($_POST['firstClassSeat']) ? (int)$_POST['firstClassSeat'] : 0;
                        
                        // Calculate variables based on form data
                        // Calculate variables based on form data
                $total_human_flight_price = (float)$flight_price * (int)$totalHuman;
                $economy_seat_price = (float)$economyPrice * (int)$numEconomySeat;
                $premium_seat_price = (float)$premiumPrice * (int)$numPremiumEconomySeat;
                $business_seat_price = (float)$businessPrice * (int)$numBusinessClassSeat;
                $first_seat_price = (float)$firstPrice * (int)$numFirstClassSeat;

                $total_price = $total_human_flight_price + $economy_seat_price + $premium_seat_price + $business_seat_price + $first_seat_price;

                        // Construct the INSERT query
                    // Construct the INSERT query with proper handling of checkbox values
                $insertQuery = "
                INSERT INTO seat_selection (
                    num_economy_seat,
                    num_premium_economy_seat,
                    num_business_class_seat,
                    num_first_class_seat,
                    total_price,
                    book_two_id
                ) VALUES (
                
                    $numEconomySeat,
                    $numPremiumEconomySeat,
                    $numBusinessClassSeat,
                    $numFirstClassSeat,
                    $total_price,
                    $Book_Two_ID
                );
                ";

                // Handle NULL values for checkboxes
                $insertQuery = str_replace('NULL,', '0,', $insertQuery);
                $insertQuery = str_replace(', NULL', ', 0', $insertQuery);

                // Execute the query
               
                if (mysqli_query($con, $insertQuery)) {
                    $lastInsertedId = mysqli_insert_id($con);
                    echo "New record created successfully with book_two_id: " . $lastInsertedId;
            
                    // Use JavaScript to redirect
                    echo "<script>";
                    echo "window.location.href = 'book4.php?book_three_id=" . $lastInsertedId . "';";
                    echo "</script>";
                    exit();

                } else {
                //echo "Error: " . $insertQuery . "<br>" . $con->error;
                }
            }
    }
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 600px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        .seat-input {
            display: none;
            margin-top: 10px;
        }

        input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
    <form action="book3.php" method="post">
  

    <input type="hidden" name="booktwoid" value="<?php echo $book_two_id; ?>">
    <?php
            $sqlFetchFlightName = "SELECT f.flight_name,f.price,b.total_human
                                FROM flight f
                                JOIN book_one b ON f.flight_id = b.flight_id
                                JOIN passenger_details pd ON b.book_id = pd.book_id
                                WHERE pd.book_two_id = $book_two_id";

            $result = $con->query($sqlFetchFlightName);

            if ($result === false) {
                // Handle query execution error
                echo "Error executing the query: " . $con->error;
            } else {
                // Check if any rows were returned
                if ($result->num_rows > 0) {
                    // Output data of the first row (assuming you expect one row)
                    $row = $result->fetch_assoc();
                    $flight_Name = $row["flight_name"];
                    $price=$row["price"];
                    $total_human=$row['total_human'];
                  
                } else {
                    $flight_Name = "No results found";
                }

                $total_price=$price*$total_human;
            }

            // Close the database connection
            $con->close();
    ?>
        <h2>Seat Selection : <?php  echo $flight_Name; ?></h2>
        <h4 class="card-title">Total Flight Price For <?php echo $total_human; ?> persons (INR):<?php echo $total_price; ?> </h4>

    </div>


    <div class="card-header2">
        
    </div>
           
            <div class="card-body">
                <div class="form-group">
                    <label>Check the classes you prefer:</label><br>
                    <input type="checkbox" id="economyCheckbox" name="classCheck[]" value="economy" onchange="showHideSeatInput('economy')">
                    <label for="economyCheckbox"> Economy</label>
                    <div id="economySeatInput" class="seat-input">
                        <label for="economySeat">Number of Economy Seats Needed:</label>
                        <input type="number" id="economySeat" name="economySeat" min="0">
                    </div>

                    <br>
                    <input type="checkbox" id="premiumEconomyCheckbox" name="classCheck[]" value="premium_economy" onchange="showHideSeatInput('premiumEconomy')">
                    <label for="premiumEconomyCheckbox"> Premium Economy</label>
                    <div id="premiumEconomySeatInput" class="seat-input">
                        <label for="premiumEconomySeat">Number of Premium Economy Seats Needed:</label>
                        <input type="number" id="premiumEconomySeat" name="premiumEconomySeat" min="0">
                    </div>

                    <br>
                    <input type="checkbox" id="businessClassCheckbox" name="classCheck[]" value="business_class" onchange="showHideSeatInput('businessClass')">
                    <label for="businessClassCheckbox"> Business Class</label>
                    <div id="businessClassSeatInput" class="seat-input">
                        <label for="businessClassSeat">Number of Business Class Seats Needed:</label>
                        <input type="number" id="businessClassSeat" name="businessClassSeat" min="0">
                    </div>

                    <br>
                    <input type="checkbox" id="firstClassCheckbox" name="classCheck[]" value="first_class" onchange="showHideSeatInput('firstClass')">
                    <label for="firstClassCheckbox"> First Class</label>
                    <div id="firstClassSeatInput" class="seat-input">
                        <label for="firstClassSeat">Number of First Class Seats Needed:</label>
                        <input type="number" id="firstClassSeat" name="firstClassSeat" min="0">
                    </div>
                </div>

                <button onclick="submitForm()">Submit</button>
            </div>
    </form>
</div>

<script>
    function showHideSeatInput(className) {
        var seatInput = document.getElementById(className + 'SeatInput');
        var checkbox = document.getElementById(className + 'Checkbox');
        seatInput.style.display = checkbox.checked ? 'block' : 'none';
    }

    function submitForm() {
        // Add logic to submit the form data
    }
</script>

</body>
</html>