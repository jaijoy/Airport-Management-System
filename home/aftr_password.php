<?php
        include("includes/base.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        .error{
            color: red;
        }
    </style>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                session_start();
                include "../config/dbcon.php";

                if (isset($_POST["changePasswordBtn"])) {
                    $currentPassword = $_POST["currentPassword"];
                    $newPassword = $_POST["newPassword"];
                    $confirmNewPassword = $_POST["confirmNewPassword"];

                    $email = $_SESSION['auth_user']['email'];
                    $op = password_hash($currentPassword, PASSWORD_DEFAULT);
                    $np = password_hash($newPassword, PASSWORD_DEFAULT);

                    $sql = "SELECT pass1 FROM users WHERE `email`='$email'";
                    $result = mysqli_query($con, $sql);

                    if ($result && mysqli_num_rows($result) === 1) {
                        $userdata = mysqli_fetch_assoc($result);
                        $hashedPasswordFromDB = $userdata['pass1'];

                        if (password_verify($currentPassword, $hashedPasswordFromDB)) {
                            $sql_2 = "UPDATE users SET pass1='$np' WHERE `email`='$email'";
                            mysqli_query($con, $sql_2);
                            
                            // Display Bootstrap success alert with close icon
                            echo '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                    Password updated successfully
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                        } else {
                            // Display Bootstrap error alert for incorrect current password with close icon
                            echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                    Incorrect current password
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                        }
                    } else {
                        // Display Bootstrap error alert for user not found or database error with close icon
                        echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                User not found or database error
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                    }
                }
                ?>
                <form action="#" method="POST" class="bg-light p-4 rounded" onsubmit="return validateForm();">
                    <h1 class="mb-4">Change Password</h1>

                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" class="form-control" name="currentPassword" id="currentPassword" required>
                    </div>

                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" class="form-control" name="newPassword" id="newPassword" required>
                        <span class="error" id="passwordError"></span>

                    </div>

                    <div class="form-group">
                        <label for="confirmNewPassword">Confirm New Password</label>
                        <input type="password" class="form-control" name="confirmNewPassword" id="confirmNewPassword" required>
                        <span class="error" id="confirmPasswordError"></span>

                    </div>

                    <button type="submit" class="btn btn-primary" name="changePasswordBtn">Change Password</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- ... (previous HTML code) ... -->

<script>
    // Function to clear an error message
    function clearError(elementId) {
        var errorElement = document.getElementById(elementId);
        errorElement.textContent = '';
    }

    // Function to validate password field
    function validatePassword() {
        var password = document.getElementById('newPassword').value;
        var passwordError = document.getElementById('passwordError');

        // Password regex pattern for complexity: 
        // - At least one special symbol from !@#$%^&*.
        // - At least one digit (number).
        // - At least one lowercase letter.
        // - At least one uppercase letter.
        // - The total length of the password should be between 6 and 8 characters.
        var passwordPattern = /^(?=.*[!@#$%^&*])(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,8}$/;

        if (!passwordPattern.test(password)) {
            passwordError.textContent = 'Password must meet the specified requirements';
        } else {
            clearError('passwordError');
        }
    }

    // Function to validate confirm password field
    function validateConfirmPassword() {
        var password = document.getElementById('newPassword').value;
        var confirmPassword = document.getElementById('confirmNewPassword').value;
        var confirmPasswordError = document.getElementById('confirmPasswordError');
        if (confirmPassword !== password) {
            confirmPasswordError.textContent = 'Passwords do not match';
        } else {
            clearError('confirmPasswordError');
        }
    }

    // Event listeners for real-time validation
    document.getElementById('newPassword').addEventListener('input', validatePassword);
    document.getElementById('confirmNewPassword').addEventListener('input', validateConfirmPassword);

    // Function to validate the entire form on submission
    function validateForm() {
        validatePassword();
        validateConfirmPassword();

        // Check if any error messages are displayed
        var errorElements = document.querySelectorAll('.error');
        for (var i = 0; i < errorElements.length; i++) {
            if (errorElements[i].textContent !== '') {
                return false; // Prevent form submission if there are errors
            }
        }

        return true; // Submit the form if all validation checks pass
    }
</script>

<!-- ... (remaining HTML code) ... -->

</body>
</html>
