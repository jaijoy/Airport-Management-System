<?php
session_start();
include("includes/base.php");
include "../config/dbcon.php";

$book_two_id = isset($_GET['book_two_id']) ? $_GET['book_two_id'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the book_two_id exists in passenger_details table
    $book_two_id =$_POST['book_two_id'];
    $checkPassengerQuery = "SELECT * FROM passenger_details WHERE book_two_id = '$book_two_id'";
    $resultPassenger = $con->query($checkPassengerQuery);

    if ($resultPassenger && $resultPassenger->num_rows > 0) {
        // Book_two_id exists, proceed with seat_selection insertion
        $numEconomySeat = isset($_POST['economySeat']) ? $_POST['economySeat'] : 0;
        $numPremiumEconomySeat = isset($_POST['premiumEconomySeat']) ? $_POST['premiumEconomySeat'] : 0;
        $numBusinessClassSeat = isset($_POST['businessClassSeat']) ? $_POST['businessClassSeat'] : 0;
        $numFirstClassSeat = isset($_POST['firstClassSeat']) ? $_POST['firstClassSeat'] : 0;

        $insertQuery = "INSERT INTO seat_selection (num_economy_seat, num_premium_economy_seat, num_business_class_seat, num_first_class_seat, book_two_id
        ) VALUES ('$numEconomySeat', '$numPremiumEconomySeat', '$numBusinessClassSeat', '$numFirstClassSeat', '$book_two_id')";
        
        if (mysqli_query($con, $insertQuery)) {
            $lastInsertedId = mysqli_insert_id($con);
            echo "New record created successfully with book_two_id: " . $lastInsertedId;

            // Use JavaScript to redirect
            echo "<script>";
            echo "window.location.href = 'book4.php?book_three_id=" . $lastInsertedId . "';";
            echo "</script>";
            exit();
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($con);
        }
    } else {
        // Book_two_id does not exist in passenger_details table
        echo "<script>alert('Error: Book_two_id does not exist.');</script>";
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
    <form action="book3.php" method="post">
        <input type="text" name="book_two_id" value="<?php echo $book_two_id; ?>">

        <div class="card-header">
            <h2>Seat Selection : </h2>
            <h4 class="card-title"> Flight Price (INR): </h4>
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
                </div>

                <br>
                <input type="checkbox" id="premiumEconomyCheckbox" name="classCheck[]" value="premium_economy" onchange="showHideSeatInput('premiumEconomy')">
                <label for="premiumEconomyCheckbox"> Premium Economy</label>
                <div id="premiumEconomySeatInput" class="seat-input">
                    <label for="premiumEconomySeat">Number of Premium Economy Seats Needed:</label>
                    <input type="number" id="premiumEconomySeat" name="premiumEconomySeat" min="0"><br><br>
                </div>

                <br>
                <input type="checkbox" id="businessClassCheckbox" name="classCheck[]" value="business_class" onchange="showHideSeatInput('businessClass')">
                <label for="businessClassCheckbox"> Business Class</label>
                <div id="businessClassSeatInput" class="seat-input">
                    <label for="businessClassSeat">Number of Business Class Seats Needed:</label>
                    <input type="number" id="businessClassSeat" name="businessClassSeat" min="0"><br><br>
                </div>

                <br>
                <input type="checkbox" id="firstClassCheckbox" name="classCheck[]" value="first_class" onchange="showHideSeatInput('firstClass')">
                <label for="firstClassCheckbox"> First Class</label>
                <div id="firstClassSeatInput" class="seat-input">
                    <label for="firstClassSeat">Number of First Class Seats Needed:</label>
                    <input type="number" id="firstClassSeat" name="firstClassSeat" min="0"><br><br>
                </div>
            </div>

            <button type="button" onclick="submitForm()">Submit</button>
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
        document.forms[0].submit();
    }
</script>

</body>
</html>




<?php
// $checkDuplicateQuery = "SELECT COUNT(*) as count FROM seat_selection WHERE book_two_id = '$book_two_id'";
    // $resultDuplicate = $con->query($checkDuplicateQuery);

    // if ($resultDuplicate && $resultDuplicate->num_rows > 0) {
    //     $row = $resultDuplicate->fetch_assoc();
    //     $duplicateCount = $row['count'];

    //     if ($duplicateCount > 0) {
    //         echo "<script>alert('Error: Record with book_two_id $book_two_id already exists.');</script>";
    //     } else {
    //         $insertQuery = "INSERT INTO seat_selection(num_economy_seat, num_premium_economy_seat, num_business_class_seat, num_first_class_seat, book_two_id
    //         ) VALUES ($numEconomySeat, $numPremiumEconomySeat, $numBusinessClassSeat, $numFirstClassSeat, $book_two_id)";
            
    //         if (mysqli_query($con, $insertQuery)) {
    //             $lastInsertedId = mysqli_insert_id($con);
    //             echo "New record created successfully with book_two_id: " . $lastInsertedId;
            
    //             // Use JavaScript to redirect
    //             echo "<script>";
    //             echo "window.location.href = 'book4.php?book_three_id=" . $lastInsertedId . "';";
    //             echo "</script>";
    //             exit();
    //         } else {
    //             echo "Error: " . $insertQuery . "<br>" . mysqli_error($con);
    //         }
    //     }
    // }

    ?>