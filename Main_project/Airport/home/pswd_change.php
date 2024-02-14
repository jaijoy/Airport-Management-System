
<?php
include "../config/dbcon.php";
session_start();
if (isset($_SESSION['auth'])) {
    // User is already logged in, so redirect to the home page or another appropriate page.
    header('Location: index.php'); // You can change 'index.php' to the desired page.
    exit(); // Ensure no further code execution on this page.
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Password Reset</title>
    <style>
        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('http://localhost/Airport/home/images/regbg.jpg') no-repeat;
            background-size: cover;
            background-position: center;
        }

        .wrapper {
            width: 420px;
            background-color: black;
            border: 2px solid rgba(225, 225, 255, .2);
            /* backdrop-filter: blur(100px); */
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            color: white;
            border-radius: 10px;
            padding: 30px 40px;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="wrapper">
            <form action="http://localhost/Airport/functions/password_reset_code.php" method="POST" onsubmit="return validateForm();" class="needs-validation" novalidate>
                <h1 class="text-center">Change Password</h1>

                <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) { echo $_GET['token']; } ?>">
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your Email Address" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" required>
                    <!-- <i class='bx bxs-envelope'></i> -->
                </div>

                <div class="form-group">
                    <label for="pswd">New Password</label>
                    <input type="password" class="form-control" id="pswd" placeholder="New Password" name="pswd" required>
                    <span class="error" id="passwordError"></span>
                </div>

                <div class="form-group">
                    <label for="cpswd">Confirm Password</label>
                    <input type="password" class="form-control" id="cpswd" placeholder="Confirm Password" name="cpswd" required>
                    <span class="error" id="confirmPasswordError"></span>
                </div>

                <button type="submit" class="btn btn-primary" name="pswd_update">Update Password</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
         function clearError(elementId) {
        var errorElement = document.getElementById(elementId);
        errorElement.textContent = '';
    }

    // Function to validate password field
    function validatePassword() {
        var password = document.getElementById('pswd').value;
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

        function validateConfirmPassword() {
            var password = document.getElementById('pswd').value;
            var confirmPassword = document.getElementById('cpswd').value;
            var confirmPasswordError = document.getElementById('confirmPasswordError');

            if (confirmPassword !== password) {
                confirmPasswordError.textContent = 'Passwords do not match';
            } else {
                clearError('confirmPasswordError');
            }
        }

        document.getElementById('pswd').addEventListener('input', validatePassword);
        document.getElementById('cpswd').addEventListener('input', validateConfirmPassword);

        function validateForm() {
            validatePassword();
            validateConfirmPassword();

            var errorElements = document.querySelectorAll('.error');
            for (var i = 0; i < errorElements.length; i++) {
                if (errorElements[i].textContent !== '') {
                    return false;
                }
            }

            return true;
        }
    </script>
</body>
</html>
