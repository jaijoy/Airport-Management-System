<!-- PHP code to fetch $totalHuman from book_one table -->
<?php
session_start();
include("includes/base.php");
include "../config/dbcon.php";

// Start the session


// Check if the email is set in the session
if (!isset($_SESSION['auth_user']['email'])) {
    // Retrieve the email from the session
    header("Location: login.php"); // Redirect to your login page
    exit();
}

$userEmail = $_SESSION['auth_user']['email'];

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['bookid'];
    $total_Human = $_POST['total_human'];
    echo "Book ID from form submission".$book_id;

    echo "human ID from form submission".$total_Human;

    // Loop to insert data for each passenger
    for ($i = 1; $i <= $total_Human; $i++) {
        
        // Check if the required fields are set
        if (
            isset($_POST['fullName' . $i]) &&
            isset($_POST['email' . $i]) &&
            isset($_POST['gender' . $i]) &&
            isset($_POST['dateOfBirth' . $i]) &&
            isset($_POST['nationality' . $i]) &&
            isset($_POST['passportId' . $i]) &&
            isset($_POST['contactNumber' . $i]) &&
            isset($_POST['emergencyContact' . $i])
        ) {

            // Assign form values to variables
            $fullName = $_POST['fullName' . $i];
            $email = $_POST['email' . $i];
            $gender = $_POST['gender' . $i];
            $dateOfBirth = $_POST['dateOfBirth' . $i];
            $nationality = $_POST['nationality' . $i];
            $passportId = $_POST['passportId' . $i];
            $occupation = isset($_POST['occupation' . $i]) ? $_POST['occupation' . $i] : null;
            $contactNumber = $_POST['contactNumber' . $i];
            $emergencyContact = $_POST['emergencyContact' . $i];
            $wheelchairAssistance = isset($_POST['wheelchairAssistance' . $i]) ? 1 : 0;
            $specialRequests = isset($_POST['specialRequests' . $i]) ? $_POST['specialRequests' . $i] : null;

            // Insert data into the passenger_details table
            $insertPassengerQuery = "INSERT INTO passenger_details (book_id, full_name, email, gender, date_of_birth, nationality, passport_id, occupation, contact_number, emergency_contact_number, wheelchair_assistance, special_requests)
                                     VALUES ('$book_id', '$fullName', '$email', '$gender', '$dateOfBirth', '$nationality', '$passportId', '$occupation', '$contactNumber', '$emergencyContact', '$wheelchairAssistance', '$specialRequests')";
        }
        if (mysqli_query($con, $insertPassengerQuery)) {
            $lastInsertedId = mysqli_insert_id($con);
            echo "New record created successfully with book_two_id: " . $lastInsertedId;
    
            // Use JavaScript to redirect
            echo "<script>";
            echo "window.location.href = 'book3.php?book_two_id=" . $lastInsertedId . "';";
            echo "</script>";
            exit();
        } else {
            echo "Error: " . $insertPassengerQuery . "<br>" . mysqli_error($con);
        }
    }
    
}

?>





<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Optional: Add your custom styles here -->
    <style>
        /* Add your custom styles if needed */
        body {
            padding: 20px;
        }

        .passenger-section {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }

        .assistance-section {
            border: 1px solid #ddd;
            padding: 20px;
            margin-top: 20px;
        }
        
        
        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        
        .card-header {
            background-color: #007bff;
            color: #fff;
            border-radius: 15px 15px 0 0;
        }
        .card-body {
            padding: 20px;
        }

        h4.card-title {
            color: #007bff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        button {
            margin-top: 20px;
        }
        .container{
            margin-top: 104px;
        }
    </style>
</head>

<body>
<br>
<br>

    <div class="container">

        <h2>Flight Booking Form</h2>

    <form action="book2.php" method="post">
    <input type="hidden" name="bookid" value="<?php echo $book_id; ?>">

        <div class="card">
            <?php
            
            $sqlFetchTotalHuman = "SELECT total_human FROM book_one WHERE email = '$userEmail' AND book_id = '$book_id'";
            $result = $con->query($sqlFetchTotalHuman);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $totalHuman = $row['total_human'];
            } ?>
                <input type="hidden" name="total_human" value="<?php echo $totalHuman; ?>">

                <?php
            // Loop to generate passenger sections based on total_human
            for ($i = 1; $i <= $totalHuman; $i++) {
            ?>
                <!-- Passenger Details -->
                <div class="card-header">

                </div>

                <div class="passenger-section">
                    <h4>Passenger <?php echo $i; ?></h4>

                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fullName<?php echo $i; ?>">Full Name:</label>
                            <input type="text" class="form-control" id="fullName<?php echo $i; ?>" name="fullName<?php echo $i; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email<?php echo $i; ?>">Email:</label>
                            <input type="email" class="form-control" id="email<?php echo $i; ?>" name="email<?php echo $i; ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                            <label for="gender<?php echo $i; ?>">Gender:</label>
                            <select class="form-control" id="gender<?php echo $i; ?>" name="gender<?php echo $i; ?>" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                        
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="dateOfBirth<?php echo $i; ?>">Date of Birth:</label>
                            <input type="date" class="form-control" id="dateOfBirth<?php echo $i; ?>" name="dateOfBirth<?php echo $i; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nationality<?php echo $i; ?>">Nationality:</label>
                            <select class="form-control" id="nationality<?php echo $i; ?>" name="nationality<?php echo $i; ?>" required>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                            <option value="GB">United Kingdom</option>
                            <option value="FR">France</option>
                            <option value="DE">Germany</option>
                            <option value="IT">Italy</option>
                            <option value="JP">Japan</option>
                            <option value="AU">Australia</option>
                            <option value="BR">Brazil</option>
                            <option value="IN">India</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="passportId<?php echo $i; ?>">Passport or ID Number:</label>
                            <input type="text" class="form-control" id="passportId<?php echo $i; ?>" name="passportId<?php echo $i; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="occupation<?php echo $i; ?>">Occupation:</label>
                            <input type="text" class="form-control" id="occupation<?php echo $i; ?>" name="occupation<?php echo $i; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="contactNumber<?php echo $i; ?>">Contact Number:</label>
                            <input type="tel" class="form-control" id="contactNumber<?php echo $i; ?>" name="contactNumber<?php echo $i; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emergencyContact<?php echo $i; ?>">Emergency Contact Number:</label>
                            <input type="tel" class="form-control" id="emergencyContact<?php echo $i; ?>" name="emergencyContact<?php echo $i; ?>" required>
                        </div>
                    </div>

                    
                

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="wheelchairAssistance<?php echo $i; ?>" name="wheelchairAssistance<?php echo $i; ?>">
                        <label class="form-check-label" for="wheelchairAssistance<?php echo $i; ?>">Wheelchair Assistance Needed</label>
                    </div>

                    <div class="form-group">
                        <label for="specialRequests<?php echo $i; ?>">Special Requests:</label>
                        <textarea class="form-control" id="specialRequests<?php echo $i; ?>" name="specialRequests<?php echo $i; ?>" rows="3"></textarea>
                    </div>
                </div>
                </div>
            <?php
            }
            ?>

            <!-- Your existing form fields... -->

            <button type="submit" class="btn btn-primary">Proceed-></button>

        </div>
    </form>
</div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        // Add JavaScript for dynamic functionality if needed
    </script>

</body>

</html>


<?php

?>