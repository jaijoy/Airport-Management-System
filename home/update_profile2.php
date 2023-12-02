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


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Profile Update</title>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .profile-container {
            max-width: 400px;
            margin: 50px auto;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }

        .edit-image-btn {
            display: none;
        }

        .profile-image-container:hover .edit-image-btn {
            display: block;
        }

        .card {
            width:100%;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-primary {
            border-radius: 0.5rem;
        }
        .img {
            max-width: 150px;
            border-radius: 50%;
        }

        /* Additional styles can be added here */

    </style>
</head>

<body>
    <div class="container profile-container">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="mb-0">Profile Update</h3>
            </div>
            <div class="card-body">
                <form action="#" method="post" enctype="multipart/form-data">
                <div class="mb-3 ">
                        
                        <img src="#" id="preview"class="img " style="display:none; max-width:300px; max-height:300px;" alt="Image Preview">
                         <br>
                        <label for="image" class="form-label">Profile Photo</label>
                        <input type="file" name="img" accept="image/*" id="img" onchange="previewImage()" required>
                        <br>
                        <img src="#" id="preview" style="display:none; max-width:300px; max-height:300px;" alt="Image Preview">
                         <br>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username'] ?? ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email'] ?? ''; ?>" required>
                    </div>
                   
                    
        

                    <button type="submit" class="btn btn-primary btn-block">Edit Profile</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script> 
        function previewImage() {
            var preview = document.getElementById('preview');
            var fileInput = document.getElementById('img');
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = null;
            }
        }
    </script>
</body>

</html>
<?php

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize form data
    $newUsername = mysqli_real_escape_string($con, $_POST['username']);
    $newEmail = mysqli_real_escape_string($con, $_POST['email']);

    $targetDir = "uploads_dp/";  // Specify your target directory
    $img = basename($_FILES["img"]["name"]);  // Get only the file name

    // Check if the new email is different from the existing email
    if ($newEmail !== $email) {
        // Check if the new email already exists in the database
        $checkEmailSql = "SELECT COUNT(*) FROM users WHERE email = '$newEmail'";
        $checkEmailResult = mysqli_query($con, $checkEmailSql);

        if ($checkEmailResult) {
            $emailCount = mysqli_fetch_row($checkEmailResult)[0];

            if ($emailCount == 0) {
                // The new email doesn't exist in the database, update both username and email
                $updateSql = "UPDATE users SET username='$newUsername', email='$newEmail', image='$img' WHERE email='$email'";
                
                $_SESSION['auth_user']['email'] = $newEmail;
              
            } else {
                // The new email already exists, update only the username
                $updateSql = "UPDATE users SET username='$newUsername', image='$img' WHERE email='$email'";
               
                echo "The email is already exists.";
            }
        } else {
            // Handle the case where checking the new email failed
            echo "Error checking the new email. Please try again.";
            exit();
        }
    } else {
        // If the new email is the same as the existing email, update only the username
        $updateSql = "UPDATE users SET username='$newUsername', image='$img' WHERE email='$email'";
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetDir . $img)) {
        // File uploaded successfully
    } else {
        echo "Error uploading the image. Please try again.";
        exit();
    }

    $updateResult = mysqli_query($con, $updateSql);

    if ($updateResult) {
        // Profile updated successfully, redirect to the profile page
        header("Location: update_profile.php");
        exit();
    } else {
        // Handle the case where the update failed
        echo "Update failed. Please try again.";
    }
}
?>
