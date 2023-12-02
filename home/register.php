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
    
        
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('images/img2.jpg') no-repeat;
            background-size: cover;
            background-position: center;
        }

        .wrapper {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 30px 20px;
            margin-top: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .wrapper h1 {
            font-size: 24px;
            text-align: center;
            color: #007bff;
        }

        .box1 {
            position: relative;
            margin-bottom: 20px;
        }

        .box1 label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .box1 input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        /* .box1 i {
            position: absolute;
            right: 20px;
            top:70%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #007bff;
        } */

        .error {
            color: #dc3545;
            font-size: 14px;
            font-weight: 20px;
        }

        .but {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 152px;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .but:hover {
            background-color: #0056b3;
        }

        .register_link {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
        }

        .register_link a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }

        .register_link a:hover {
            text-decoration: underline;
        }
    </style>
    <title>SignUp</title>
</head>
<body>
    <div class="main">
        <?php
        include("includes/base.php");
    ?>
        <div class="wrapper">
            <div class="sec_msg">
                
                <?php 
                    if(isset($_SESSION['message']))
                {?>
                    <!--succesful msg aftr register -->
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Hey!</strong><?=$_SESSION['message'];  ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                    unset($_SESSION['message']);
                } ?>
        
            </div>
            <form action="../functions/rusers.php" method="POST" onsubmit="return validateForm();">
                <h1 class="mb-4">SignUp</h1>

                <div class="form-group box1">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" placeholder="" name="username" id="name" required
                        oninput="validateName()">
                    <!-- <i class='bx bxs-user'></i> -->
                    <span class="error" id="nameError"></span>
                </div>

                <div class="form-group box1">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" placeholder="" name="email" id="email" required
                        oninput="validateEmail()">
                    <!-- <i class='bx bxs-envelope'></i> -->
                    <span class="error" id="emailError"></span>
                </div>

                <div class="form-group box1">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" placeholder="" name="psw1" id="password" required
                        oninput="validatePassword()">
                    <!-- <i class='bx bxs-lock'></i> -->
                    <span class="error" id="passwordError"></span>
                </div>

                
                
                <div class="form-group box1">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" placeholder="" name="psw2" id="confirmPassword" required
                        oninput="validateConfirmPassword()">
                    <!-- <i class='bx bxs-lock'></i> -->
                    <span class="error" id="confirmPasswordError"></span>
                </div>

                <div class="register">
                    <p>Forgot Password? <a href="forgot_pswd.php">Click here..</a></p>
                </div>
                
                <button type="submit" class="but" name="register_btn">SignUp</button>

                <div class="register_link mt-3">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
            // Function to clear an error message
            function clearError(elementId) {
            var errorElement = document.getElementById(elementId);
            errorElement.textContent = '';
        }

        function validateName() {
            var name = document.getElementById('name').value;
            var nameError = document.getElementById('nameError');
            
            // Name pattern: starts with an alphabet, followed by spaces, up to a maximum of 20 characters,
            // and at least 3 characters in total
            var namePattern = /^[a-zA-Z][a-zA-Z\s]{1,18}[a-zA-Z]$/;
        
            if (!namePattern.test(name)) {
                nameError.textContent = 'Name must start with an alphabet';
            } else {
                clearError('nameError');
            }
        }
        

        // Function to validate email field
        function validateEmail() {
            var email = document.getElementById('email').value;
            var emailError = document.getElementById('emailError');
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!emailPattern.test(email)) {
                emailError.textContent = 'Invalid email address';
            } else {
                clearError('emailError');
            }
        }

        // Function to validate password field
        function validatePassword() {
    var password = document.getElementById('password').value;
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
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            var confirmPasswordError = document.getElementById('confirmPasswordError');
            if (confirmPassword !== password) {
                confirmPasswordError.textContent = 'Passwords do not match';
            } else {
                clearError('confirmPasswordError');
            }
        }

        // Event listeners for real-time validation
        document.getElementById('name').addEventListener('input', validateName);
        document.getElementById('email').addEventListener('input', validateEmail);
        document.getElementById('password').addEventListener('input', validatePassword);
        document.getElementById('confirmPassword').addEventListener('input', validateConfirmPassword);

        // Function to validate the entire form on submission
        function validateForm() {
            validateName();
            validateEmail();
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
<?php
        include("includes/foot.php");
?>
</body>
</html>