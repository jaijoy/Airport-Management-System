<?php
session_start();
include("includes/base.php");
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$book_three_id = $_SESSION['book_three_id'];

include "../config/dbcon.php";

$userEmail = $_SESSION['auth_user']['email'];

// Initialize variables to prevent null warnings
$total_human_flight_price = 0;
$economy_seat_price = 0;
$premium_seat_price = 0;
$business_seat_price = 0;
$first_seat_price = 0;

if ($book_three_id !== null) {
    // Fetch details from seat_selection table
    $sqlFetchSeatSelection = "SELECT
        ss.num_economy_seat,
        ss.num_premium_economy_seat,
        ss.num_business_class_seat,
        ss.num_first_class_seat,
        bo1.total_human,
        bo1.passenger_total_seat,
        fl.flight_name,
        departure.airport_name AS departure_name,
        departure.airport_location AS departure_location,
        arrival.airport_name AS arrival_name,
        arrival.airport_location AS arrival_location,
        fl.price AS flight_price,
        al.airline_name,
        ab.airbus_name,
        st.no_economy,
        st.economy_price,
        st.no_premium,
        st.premium_price,
        st.no_business,
        st.business_price,
        st.no_first,
        st.first_price
    FROM
        seat_selection ss
    JOIN passenger_details bo ON ss.book_two_id = bo.book_two_id
    JOIN book_one bo1 ON bo.book_id = bo1.book_id
    JOIN flight fl ON bo1.flight_id = fl.flight_id
    JOIN seat st ON bo1.flight_id = st.flight_id
    JOIN airline al ON fl.airline_id = al.airline_id
    JOIN airbus ab ON fl.airbus_id = ab.airbus_id
    JOIN airport departure ON fl.f_departure = departure.airport_id
    JOIN airport arrival ON fl.f_arrival = arrival.airport_id
    WHERE
        ss.seat_selection_id = '$book_three_id'";

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

        $departure = $row['departure_name'];
        $departure_loc = $row['departure_location'];

        $arrival = $row['arrival_name'];
        $arrival_loc = $row['arrival_location'];

        $airline_name = $row['airline_name'];
        $airbus_name = $row['airbus_name'];

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

        // Build HTML content
   // Build HTML content
$html = <<<HTML
<html>
<head>
    <style>
       .jai{
        margin-left: 50px;
       }
        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body class="jai">
<br><br><br>
    <center><h1>FLY EASY</h1></center>
    <h2>TAX INVOICE</h2>

    <h4>Flight Details</h4>
    <table>
        <tr>
            <th>Flight Name</th>
            <td>$flightName</td>
        </tr>
        <tr>
            <th>Airline Name</th>
            <td>$airline_name</td>
        </tr>
        <tr>
            <th>Airbus Name</th>
            <td>$airbus_name</td>
        </tr>
        <tr>
            <th>Departure Location</th>
            <td>$departure - $departure_loc</td>
        </tr>
        <tr>
            <th>Arrival Location</th>
            <td>$arrival - $arrival_loc</td>
        </tr>
    </table>

    <h4>Flight Charges</h4>
    <table>
        <tr>
            <th>Flight Charge Per Person (INR)</th>
            <td>$flight_price</td>
        </tr>
        <tr>
            <th>Passengers</th>
            <td>$totalHuman</td>
        </tr>
        <tr>
            <th>Total Flight Charge (INR)</th>
            <td>$total_human_flight_price</td>
        </tr>
    </table>

    <h4>Seat Charge</h4>
    <table>
        <tr>
            <th>Class</th>
            <th>Price per seat (INR)</th>
            <th>Quantity</th>
            <th>Total (INR)</th>
        </tr>
        <tr>
            <th>Economy</th>
            <td>$economyPrice</td>
            <td>$numEconomySeat</td>
            <td>$economy_seat_price</td>
        </tr>
        <tr>
            <th>Premium Economy</th>
            <td>$premiumPrice</td>
            <td>$numPremiumEconomySeat</td>
            <td>$premium_seat_price</td>
        </tr>
        <tr>
            <th>Business</th>
            <td>$businessPrice</td>
            <td>$numBusinessClassSeat</td>
            <td>$business_seat_price</td>
        </tr>
        <tr>
            <th>First Class</th>
            <td>$firstPrice</td>
            <td>$numFirstClassSeat</td>
            <td>$first_seat_price</td>
        </tr>
    </table>

    <h3>Total Booking Amount: $Grand_Total</h3>

    <!-- Add download PDF option below -->
    <form action='generate_pdf.php' method='post'>
        <input type='hidden' name='html_content' value='$html'>
        <button type='submit'>Download PDF</button>
    </form>
</body>
</html>
HTML;


        // Echo out the HTML content
        echo $html;
    } else {
        // No results found
        echo "No seat selection details found for book_three_id: $book_three_id";
    }
} else {
    // Handle the case when book_three_id is not set
    echo "book_three_id is not set";
}
?>
