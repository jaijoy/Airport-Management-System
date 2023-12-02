<?php

session_start();

include("includes/base.php");
?>

<?php
// Assuming you have a session started after the user logs in
session_start();
include "../config/dbcon.php";

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection code here

// Fetch user data from the database based on the user's session ID
$email = $_SESSION['auth_user']['email'];
// Use prepared statements to prevent SQL injection
$sql = "SELECT * FROM users WHERE `email`='$email'";
$result = mysqli_query($con, $sql);

// Check if the query was successful and if a row was returned
if ($result && $user = mysqli_fetch_assoc($result)) {
    // Now, $user contains all the user details
} else {
    // Handle the case where the user data couldn't be fetched
    $user = null;
}

// Fetch the image path from the user data
$imagePath = 'uploads_dp/' .$user['image'] ?? ''; // Assuming the column name for the image path is 'image'

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Profile Update</title>
    <style>
        /* Additional CSS styling can be added here */
        .profile-image {
            max-width: 150px;
            border-radius: 50%;
        }
        
        .mt-5{
            margin-top: 12rem!important;
        }
        
        
    </style>
</head>
<body >

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Welcome ,<?php  echo $user['username'] ?? ''; ?><h3>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group text-center">
                            <?php
                            if (!empty($imagePath)) {
                                // If the image path is not empty, show the user's profile image
                                echo '<img src="' . $imagePath . '" alt="Profile Image" class="profile-image">';
                            }
                            ?>
                        </div>
                        <div class="class1 text-center">
                            <h3>
                                <?php
                                 echo $user['username'] ?? '';
                                ?>

                            </h3>
                            
                        </div>

                        <div class="class1 text-center">
                            <h5>
                        <?php
                        echo $user['email'] ?? '';
                        ?>
                            </h5>
                        </div><br>

                      <a href="update_profile2.php" class="btn btn-primary btn-block">Edit Profile</a>
                    <a href="aftr_password.php" class="btn btn-secondary btn-block mt-2">Change Password</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
