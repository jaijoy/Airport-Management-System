<?php
session_start();
include("includes/base.php");
include "../config/dbcon.php";

$userEmail = $_SESSION['auth_user']['email'];

// Initialize variables to prevent null warnings
$total_human_flight_price = 0;
$economy_seat_price = 0;
$premium_seat_price = 0;
$business_seat_price = 0;
$first_seat_price = 0;

//seat_selection_id
$book_three_id = isset($_GET['book_three_id']) ? $_GET['book_three_id'] : null;

if ($book_three_id !== null) {
    // Fetch details from seat_selection table
    $sqlFetchSeatSelection = "
    SELECT num_economy_seat, num_premium_economy_seat, num_business_class_seat, num_first_class_seat, 
    bo1.total_human, bo1.passenger_total_seat, fl.flight_name, st.no_economy, st.economy_price,
    st.no_premium, st.premium_price, st.no_business, st.business_price, st.no_first, st.first_price, 
    fl.price as flight_price FROM seat_selection ss 
    JOIN passenger_details bo ON ss.book_two_id = bo.book_two_id 
    JOIN book_one bo1 ON bo.book_id = bo1.book_id 
    JOIN flight fl ON bo1.flight_id = fl.flight_id 
    JOIN seat st ON bo1.flight_id = st.flight_id 
    WHERE ss.seat_selection_id = '$book_three_id'";

    $resultSeatSelection = $con->query($sqlFetchSeatSelection);

    if ($resultSeatSelection === false) {
        // Handle query execution error
        echo "Error executing the query: " . $con->error;
    } elseif ($resultSeatSelection->num_rows > 0) {
        // Output data of the first row
        $row = $resultSeatSelection->fetch_assoc();

        // Extract details from the row
        $flight_price = $row['flight_price'];
        $totalHuman = $row['total_human'];
        $passenger_totalSeat = $row['passenger_total_seat'];
        $flightName = $row['flight_name'];
        //$totalSeat = $row['total_seat'];
        $noEconomy = $row['no_economy'];
        $economyPrice = $row['economy_price'];
        $noPremium = $row['no_premium'];
        $premiumPrice = $row['premium_price'];
        $noBusiness = $row['no_business'];
        $businessPrice = $row['business_price'];
        $noFirst = $row['no_first'];
        $firstPrice = $row['first_price'];

        $numEconomySeat = $row['num_economy_seat'];
        $numPremiumEconomySeat = $row['num_premium_economy_seat'];
        $numBusinessClassSeat = $row['num_business_class_seat'];
        $numFirstClassSeat = $row['num_first_class_seat'];

        // Calculate variables based on form data
        $total_human_flight_price = (float)$flight_price * (int)$totalHuman;
        $economy_seat_price = (float)$economyPrice * (int)$numEconomySeat;
        $premium_seat_price = (float)$premiumPrice * (int)$numPremiumEconomySeat;
        $business_seat_price = (float)$businessPrice * (int)$numBusinessClassSeat;
        $first_seat_price = (float)$firstPrice * (int)$numFirstClassSeat;

        $Grand_Total = $total_human_flight_price + $economy_seat_price + $premium_seat_price + $business_seat_price + $first_seat_price;
       

    } else {
        // No results found
        echo "No seat selection details found for book_three_id: $book_three_id";
    }
} else {
    // Handle the case when book_three_id is not set
    echo "book_three_id is not set";
}

// Close the database connection
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            width: 900px;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 40px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333; /* Darker color for headings */
        }

        h6 {
            margin-bottom: 10px;
            color: #555; /* Slightly darker color for details */
        }

        .total-field {
            font-size: 18px;
            font-weight: bold;
            color: #e44d26; /* Red color for total amounts */
        }

        /* Styles for Grand Total */
        .grand-total {
            margin-top: 30px;
            padding: 20px;
            
            color: #fff; /* White text for better visibility */
            border-radius: 5px;
        }


    </style>
</head>
<body>
<form method="post" action="../razorpay-php-2.9.0/Razorpay.php">
 <?php   echo '<input type="hidden" name="grand_total" value="' . $Grand_Total . '">';?>
 <?php   echo '<input type="hidden" name="book_three_id" value="' . $book_three_id . '">';?>


<div class="card">
    <div class="card-body">
        <h2 class="card-title">Flight Price Details</h2>

        <!-- Add these lines within your form -->
        <h6><?php echo "Flight Name: ".$flightName; ?></h6>
        <h6><?php echo "Flight Charge Per Person (INR): ".$flight_price; ?></h6>
        <h6><?php echo "Number of persons booked the flight: ".$totalHuman; ?></h6>
        <h6><?php echo "Total Flight Charge (INR): ".$total_human_flight_price; ?></h6>
        <h6><?php echo "Total Economy Seat Price: ".$economy_seat_price; ?></h6>
        <h6><?php echo "Total Premium Economy Seat Price (INR): ".$premium_seat_price; ?></h6>
        <h6><?php echo "Total Business Class Seat Price (INR): ".$business_seat_price; ?></h6>
        <h6><?php echo "Total First Class Seat Price (INR): ".$first_seat_price; ?></h6>

        <!-- Style for Grand Total -->
        <div class="grand-total">
            <h6 class="total-field"><?php echo "Total Flight Booking Price(INR): ".$Grand_Total; ?></h6>
        </div>

        <button type="submit" class="btn btn-primary">Proceed To Pay-></button>

    </div>
</div>
    </form>
</body>
</html>



<!-- Key ID rzp_test_TmNDncprLP8swN -->
<!-- Key secret XGHv4xegHRNRPeQNaueTWJBU -->