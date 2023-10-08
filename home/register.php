<?php
include "../config/dbcon.php";
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
   
    <title>login</title>
   
    <style>

             @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
        
        /*login design start here */
      
        * {
            font-family: 'Poppins', sans-serif;
            margin:0;
            padding: 0;
            box-sizing: border-box;
        }
        .main{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('images/regbg.jpg') no-repeat;
            background-size: cover;
            background-position: center;
        }

        .wrapper {
            width: 420px;
            background: transparent;
            border:2px solid rgba(225, 225, 255, .2);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            color:white;
            border-radius: 10px;
            padding: 30px 40px;
            margin-top: 130px;
        }
        .wrapper h1{
            font-size: 36px;
            text-align: center;

        }
        .wrapper .box1{
            position: relative;
            width: 100%;
            height: 50px;
            margin: 30px 0;
            

        }

        .box1 input{
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline:none;
            border:2px solid rgba(225, 225, 255, .2);
            border-radius: 40px;
            font-size: 16px;
            color: white;
            padding: 20px 45px 20px 20px;

        }

        .box1 input::placeholder{
            color: white;
        }
        .box1 i {
            position: absolute;
            right: 20px;
            top:90%;
            transform: translateY(-50%);
            font-size: 20px;
        }

       

       

        .wrapper .btn{
            width:100% ;
            height: 45px;
            background: white;
            border:none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0,0, 0, 1);
            cursor: pointer;
            font-size:16px;
            color:#333;
            font-weight: 600;


        }

        .wrapper .register_link {
            font-size: 14.5px;
            text-align: center;
            margin: 20px 0 15px;


        }

        .register_link p a{
            color:white;
            text-decoration: none;
            font-weight: 600;
        }

        .register_link p a:hover{
            text-decoration: underline;
        }
        /* login design end here */

        /*header design start here */

        nav{
        width: 100%;
        height: 75px;
        line-height: 75px;
        position: fixed;
        padding: 0px 100px;
        margin-top: -666px;
        background-image: linear-gradient(#033747,#012733);
        }
        nav .logo p{
            font-size: 30px;
            font-weight: bold;
            float:left;
            color:white;
            letter-spacing: 1.5px;
            cursor: pointer;
        }
        
        nav ul{
            float:right;
        }
        
        nav li{
            display: inline-block;
            list-style: none;

        }
        nav li a{
            font-size: 18px;
            text-transform: uppercase;
            padding: 0px 30px;
            color: white;
            text-decoration: none;

        }
        nav li a:hover{
            color: aqua;
            
        }
        .sec_msg{
            color:red;
        }
        .error{
            color:red;
        }

        .content{
            /* padding: 250px; */
        }
        /*header design end */    

    </style>
</head>
<body>
  
<div class="main">
    
    <!-- header-->
    <?php
        include("includes/base.php");
    ?>
    <!--header end here-->
    

<div class="wrapper">
     <!-- displaying error from getbootsrap.com -->

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
            <h1>SignUp</h1>
            
        <div class="box1">
            
            Name
            <input type="text" placeholder="" name="username" id="name" required>
            <i class='bx bxs-user'></i>
            <span class="error" id="nameError"></span>
        </div>
        <div class="box1">
            Email<input type="email" placeholder="" name="email" id="email" required>
            <i class='bx bxs-envelope'></i>
            <span class="error" id="emailError"></span>
        </div>
        <div class="box1">
            Password<input type="password" placeholder="" name="psw1" id="password" required>
            <i class='bx bxs-lock'></i>
            <span class="error" id="passwordError"></span>
        </div>
        <div class="box1">
            Confirm Password<input type="password" placeholder="" name="psw2" id="confirmPassword" required>
            <i class='bx bxs-lock'></i>
            <span class="error" id="confirmPasswordError"></span>
        </div>

        <button type="submit" class="btn" name="register_btn">SignUp</button>

        <div class="register_link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
        </form>
        </div>
        

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

</body>
</html>