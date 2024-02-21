

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
        h6{
            color:blue;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
    <form action="book3.php" method="post">
    
<!-- Add similar lines for other variables -->

   
    <input type="hidden" name="booktwoid" value="<?php echo $book_two_id; ?>">
    <?php
            
        $sqlFetchDetails = "SELECT bo.total_human, fl.flight_name, bo.passenger_total_seat, st.total_seat, st.no_economy, st.economy_price,
        st.no_premium, st.premium_price, st.no_business, st.business_price,
        st.no_first,st.first_price,fl.price as flight_price
         FROM book_one bo
         JOIN flight fl ON bo.flight_id = fl.flight_id
         JOIN seat st ON bo.flight_id = st.flight_id
         WHERE bo.book_id = '$book_two_id'";


            $result = $con->query($sqlFetchDetails);

            if ($result === false) {
                // Handle query execution error
                echo "Error executing the query: " . $con->error;
            } else {
                // Check if any rows were returned
                if ($result->num_rows > 0) {
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
                    
                } 
            }

            // Close the database connection
            $con->close();
    ?>


        <h2>Seat Selection : <?php // echo $flight_Name; ?></h2>
        <h4 class="card-title"> Flight Price (INR):<?php //echo  $flight_price; ?> </h4>

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
                        <input type="number" id="economySeat" name="economySeat" min="0"><br><br>

                    <h6><?php //echo "Economy class price per seat(INR) : " .$economyPrice; ?></h6>

                    </div>

                    <br>
                    <input type="checkbox" id="premiumEconomyCheckbox" name="classCheck[]" value="premium_economy" onchange="showHideSeatInput('premiumEconomy')">
                    <label for="premiumEconomyCheckbox"> Premium Economy</label>
                    <div id="premiumEconomySeatInput" class="seat-input">
                        <label for="premiumEconomySeat">Number of Premium Economy Seats Needed:</label>
                        <input type="number" id="premiumEconomySeat" name="premiumEconomySeat" min="0"><br><br>
                        <h6><?php // echo "Premium Economy class price per seat(INR) :" .$premiumPrice ; ?></h6>
                    </div>

                    <br>
                    <input type="checkbox" id="businessClassCheckbox" name="classCheck[]" value="business_class" onchange="showHideSeatInput('businessClass')">
                    <label for="businessClassCheckbox"> Business Class</label>
                    <div id="businessClassSeatInput" class="seat-input">
                        <label for="businessClassSeat">Number of Business Class Seats Needed:</label>
                        <input type="number" id="businessClassSeat" name="businessClassSeat" min="0"><br><br>
                        <h6><?php //echo "Business class price per seat(INR) :" .$businessPrice; ?></h6>
                    </div>

                    <br>
                    <input type="checkbox" id="firstClassCheckbox" name="classCheck[]" value="first_class" onchange="showHideSeatInput('firstClass')">
                    <label for="firstClassCheckbox"> First Class</label>
                    <div id="firstClassSeatInput" class="seat-input">
                        <label for="firstClassSeat">Number of First Class Seats Needed:</label>
                        <input type="number" id="firstClassSeat" name="firstClassSeat" min="0"><br><br>
                        <h6><?php //echo "First class price per seat(INR) :" .$firstPrice ; ?></h6>
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
