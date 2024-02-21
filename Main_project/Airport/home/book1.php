<?php
// Start the session
session_start();

include("includes/base.php");
include "../config/dbcon.php";

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
   // echo "no fk";
}


?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['sub'])) {

    
    // Your existing logic here...
    $flight_Id = $_POST['flightId'];

    //echo "new ".$flight_Id;
    $userEmail=$_POST['uemail'];
    $numInfants = $_POST["numInfants"];
    $infantsNeedSeat = isset($_POST["infantsNeedSeat"]) ? $_POST["infantsNeedSeat"] : 0;
    $numInfantSeats = $_POST["numInfantSeats"];
    $numChildren = $_POST["numChildren"];
    $numAdults = $_POST["numAdults"];
    //echo "numInfants: $numInfants, infantsNeedSeat: $infantsNeedSeat, numInfantSeats: $numInfantSeats, numChildren: $numChildren, numAdults: $numAdults";

    // Calculate total_human
    $totalHuman = (int)$numInfants + (int)$numChildren + (int)$numAdults;
    $total_seat=(int) $numInfantSeats + (int)$numChildren + (int)$numAdults;

    // Sanitize inputs to prevent SQL injection
    $numInfants = mysqli_real_escape_string($con, $numInfants);
    $infantsNeedSeat = mysqli_real_escape_string($con, $infantsNeedSeat);
    $numInfantSeats = mysqli_real_escape_string($con, $numInfantSeats);
    $numChildren = mysqli_real_escape_string($con, $numChildren);
    $numAdults = mysqli_real_escape_string($con, $numAdults);
    $userEmail = mysqli_real_escape_string($con, $userEmail);
    $flight_Id = mysqli_real_escape_string($con, $flight_Id);

    // Insert data into the database
    $insert_query = "INSERT INTO book_one (numInfants, infantsNeedSeat, numInfantSeats, numChildren, numAdults, total_human, passenger_total_seat, email, flight_id)
    VALUES ('$numInfants', '$infantsNeedSeat', '$numInfantSeats', '$numChildren', '$numAdults', '$totalHuman', '$total_seat', '$userEmail', '$flight_Id')";

if (mysqli_query($con, $insert_query)) {
    $lastInsertedId = mysqli_insert_id($con);
    echo "New record created successfully with book_id: " . $lastInsertedId;

    // Use JavaScript to redirect
    echo "<script>window.location.href = 'book2.php?book_id=" . $lastInsertedId . "';</script>";
    exit();
} else {
    echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
}


}
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book One Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            border-radius: 15px;
        }

        .card-header {
          
            background-color: #007bff;
            color: #fff;
            border-radius: 15px 15px 0 0;
        }

        h2 {
            
        }

        label {
            font-weight: bold;
            color: #007bff;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border: 1px solid #007bff;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border: 1px solid #0056b3;
        }

        .error-message {
            color: #dc3545;
            font-size: 80%;
            margin-top: 5px;
        }
    </style>
</head>



<body>
<br>
<br><br>

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
            

                <h2>Booking Form</h2>
            </div>
            <div class="card-body">
                <form id="bookOneForm" action="book1.php" method="post">
                <input type="hidden" name="flightId" value="<?php echo $flight_Id; ?>">
            <input type="hidden" name="uemail" value="<?php echo $userEmail; ?>">
                    <div class="form-group">
                        <label for="numInfants">Number of Infants (below 2 years):</label>
                        <input type="number" class="form-control" id="numInfants" name="numInfants" min="0" required>
                        <div id="infantsError" class="error-message"></div>
                    </div>

                    <div class="form-group" id="infantDetails" style="display: none;">
                        <label for="infantsNeedSeat">Infants Need a Seat:</label>
                        <select class="form-control" id="infantsNeedSeat" name="infantsNeedSeat">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div class="form-group" id="numInfantSeats" style="display: none;">
                        <label for="numInfantSeats">Number of Infant Seats:</label>
                        <input type="number" class="form-control" name="numInfantSeats" min="0">
                        <div id="infantSeatsError" class="error-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="numChildren">Number of Children (2 - 12 years):</label>
                        <input type="number" class="form-control" id="numChildren" name="numChildren" min="0" required>
                        <div id="childrenError" class="error-message"></div>
                    </div>

                    <div class="form-group">
                        <label for="numAdults">Number of Adults (12 years and above):</label>
                        <input type="number" class="form-control" id="numAdults" name="numAdults" min="0" required>
                        <div id="adultsError" class="error-message"></div>
                    </div>

                    <button type="submit" name="sub" class="btn btn-primary btn-add-details">Next-></button>
                    <!-- <a href="book2.php?flightId=<?php echo $flight_Id ?>" class="btn btn-primary btn-add-details" id="nextButton" style="display: none;">Next-></a> -->

                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- ... Your previous HTML code ... -->

<script>
    $(document).ready(function () {
        var formSubmitted = false;

        function updateInfantDetailsVisibility() {
            var numInfants = $('#numInfants').val();
            var infantDetails = $('#infantDetails');
            var numInfantSeats = $('#numInfantSeats');
            var infantsError = $('#infantsError');
            var infantSeatsError = $('#infantSeatsError');

            infantsError.text('');
            infantSeatsError.text('');

            if (numInfants >= 1) {
                infantDetails.show();
                if ($('#infantsNeedSeat').val() === '1') {
                    numInfantSeats.show();
                }
            } else {
                infantDetails.hide();
                numInfantSeats.hide();
            }
        }

        $('#numInfants').on('input', function () {
            updateInfantDetailsVisibility();
            validateForm();
        });

        $('#infantsNeedSeat').on('change', function () {
            var infantsNeedSeat = $(this).val();
            var numInfantSeats = $('#numInfantSeats');
            var infantSeatsError = $('#infantSeatsError');

            numInfantSeats.hide();
            infantSeatsError.text('');

            if (infantsNeedSeat === '1') {
                numInfantSeats.show();
            }

            validateForm();
        });

        function validateForm() {
            var numInfants = parseInt($('#numInfants').val()) || 0;
            var numInfantSeats = parseInt($('#numInfantSeats').val()) || 0;
            var numChildren = parseInt($('#numChildren').val()) || 0;
            var numAdults = parseInt($('#numAdults').val()) || 0;
            var infantsError = $('#infantsError');
            var infantSeatsError = $('#infantSeatsError');
            var childrenError = $('#childrenError');
            var adultsError = $('#adultsError');

            infantsError.text('');
            infantSeatsError.text('');
            childrenError.text('');
            adultsError.text('');

            var totalPeople = numInfants + numChildren + numAdults;

            if (totalPeople > 9) {
                infantsError.text('Total number of people cannot exceed 9.');
            }

            if (numInfants >= 2 && numAdults < 1) {
                adultsError.text('At least one adult is required for two or more infants.');
            }

            if (numInfants >= 3 && numAdults < 2) {
                adultsError.text('At least two adults are required for three or more infants.');
            }

            if (numInfants >= 5 && numAdults < 3) {
                adultsError.text('At least three adults are required for five or more infants.');
            }
        }

        // Submit the form only if no errors
        $('#bookOneForm').submit(function (e) {
            if (formSubmitted) {
                // If form already submitted, prevent further submissions
                e.preventDefault();
            } else {
                // Check for validation errors before submission
                validateForm();
                if ($('#infantsError').text() === '' && $('#infantSeatsError').text() === '' &&
                    $('#childrenError').text() === '' && $('#adultsError').text() === '') {
                    formSubmitted = true; // Set flag to prevent multiple submissions
                    $('#nextButton').show(); // Show the "Next" button
                } else {
                    e.preventDefault(); // Prevent form submission if there are errors
                }
            }
        });
    });
</script>


<!-- ... Your remaining HTML code ... -->

</body>

</html>


































