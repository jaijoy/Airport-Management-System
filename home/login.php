<?php
        include("includes/base.php");
?>

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
   
    <title>login</title>
   
    <style>

             @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
        
        /*login design start here */
      
        * {
            /* font-family: 'Poppins', sans-serif; */
            margin:0;
            padding: 0;
            box-sizing: border-box;
        }
        .main{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('images/img2.jpg') no-repeat;
            background-size: cover;
            background-position: center;
            font-family: 'Poppins', sans-serif;
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
            top:50%;
            transform: translateY(-50%);
            font-size: 20px;
        }

        

        .box_forgot a{
            display: flex;
            justify-content: space-between;
            font-size: 14.5px;
            color: white;
            margin-top: -20px;
            margin-left: 23px;
            margin-bottom: 12px;
            text-decoration: none;
            
            
        }

        .box_forgot a:hover{
            text-decoration: underline;
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

        .sec_msg{
            color:red;
        }
        /* login design end here */

        
          

    </style>
</head>
<body>
<div class="main">
    <!-- header-->
    
    <!--header end here-->

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

        <form action="../functions/rusers.php" method="POST">
            <h1>Login</h1>
            <div class="box1">
                Email
                <input type="email" placeholder="" name="email" required>
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="box1">
                Password
                <input type="password" placeholder="" name="pswd" required>
                <i class='bx bxs-lock'></i>
            </div>

            <div class="box_forgot">
                <a href="forgot_pswd.php">Forgot password?</a>
            </div>

            <button type="submit" class="btn" name="lbtn">Login</button>

            <div class="register_link">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>

        </form>

    </div>
</div>

<?php
        include("includes/foot.php");
?>

</body>
</html>