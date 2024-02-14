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
    $flightId = $_GET['flightId'];
}


include "../config/dbcon.php";
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
                <input type="number" class="form-control" id="numInfants" name="numInfants" min="0" value="0" >
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="infantsNeedSeat" name="infantsNeedSeat">
                <label class="form-check-label" for="infantsNeedSeat">Infants Need a Seat</label>
            </div>

            <div class="form-group" id="infantSeatInput" style="display: none;">
                <label for="numInfantSeats">Number of Infant Seats:</label>
                <input type="number" class="form-control" id="numInfantSeats" name="numInfantSeats" min="0" value="0">
            </div>

            <div class="form-group">
                <label for="numChildren">Number of Children (2 - 12 years):</label>
                <input type="number" class="form-control" id="numChildren" name="numChildren" min="0" value="0">
            </div>

            <div class="form-group">
                <label for="numAdults">Number of Adults (12 years and above):</label>
                <input type="number" class="form-control" id="numAdults" name="numAdults" min="1" value="1">
            </div>

           
<a href="book2.php?flightId=<?php echo $flightId ?>" class="btn btn-primary btn-add-details">Next-></a>

            
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

include "../config/dbcon.php";

// Process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $numInfants = $_POST["numInfants"];
    $infantsNeedSeat = isset($_POST["infantsNeedSeat"]) ? 1 : 0;
    $numInfantSeats = isset($_POST["numInfantSeats"]) ? $_POST["numInfantSeats"] : 0;
    $numChildren = $_POST["numChildren"];
    $numAdults = $_POST["numAdults"];

    // Calculate total_human
    $totalHuman = $numInfantSeats + $numChildren + $numAdults;

    // Insert data into the database
    $sql = "INSERT INTO book_one (numInfants, infantsNeedSeat, numInfantSeats, numChildren, numAdults, total_human, email,flight_id)
            VALUES ('$numInfants', '$infantsNeedSeat', '$numInfantSeats', '$numChildren', '$numAdults', '$totalHuman', '$userEmail','$flightId')";

    if ($con->query($sql) === TRUE) {
        echo "Booking successfully submitted!";
        exit();
        
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Close the database connection
$con->close();
?>
