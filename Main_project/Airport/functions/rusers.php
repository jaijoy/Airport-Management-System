<?php
session_start();
include "../config/dbcon.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require '../vendor/autoload.php';

function sendemail_verify($name,$eemail,$verify_token){
    //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
            //Server settings
           //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
            $mail->isSMTP();                                            //Send using SMTP
            $mail->SMTPAuth   = true;  
            
            $mail->Host = "smtp.gmail.com";
            $mail->Username   = 'jaimoljoy2024@gmail.com';                     //SMTP username
            $mail->Password   = 'gepxqpbohvhfdjyd'; // two step enable eduthite , app password generate cheithu edukuk
            $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
            $mail->Port       = 587;               //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('jaimoljoy2024@gmail.com',$name);
            $mail->addAddress($eemail);     //Add a recipient
           
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Email verification from FlyEasy";
            
            $email_template="
                <h2>You have registered with flyeasy</h2>
                <h5>verify your email address to login with the below given link</h5>
                <br><br>
                <a href='http://localhost/Airport/home/verify-email.php?token=$verify_token'>Click Me</a>
            ";
            
            $mail->Body=$email_template;
            $mail->send();
            //echo 'Message has been sent';
       
}

if(isset($_POST["register_btn"]))
{
	$name = $_POST["username"];
	$eemail = $_POST["email"];
    $password = $_POST["psw1"];
    $rpassword = $_POST["psw2"];
    $verify_token = md5(rand());

    //sendemail_verify("$name","$eemail","$verify_token");
    //echo "send or not";
    // Rest of your code for email check and registration...
    //password crt ahnonne nokann
    //session start cheithuu.i mean...email password equal nokann ..session use cheithu error msg
    //email already exist ahnonne nokan
       $email_crt= "SELECT `email`  FROM `users` WHERE `email`='$eemail'";
        $email_run = mysqli_query($con, $email_crt);
        if(mysqli_num_rows($email_run) > 0)
        {
            $_SESSION["message"] = "Email already registered,please login";
            header('Location: ../home/register.php');
            exit();
        }
        else {
            // Hash the user's password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert hashed password into the database
            $sql = "INSERT INTO `users` (`username`, `email`, `pass1`,`verify_token`) VALUES ('$name', '$eemail', '$hashed_password','$verify_token')";
            //echo $sql;
            $result = mysqli_query($con, $sql);

            if ($result) {
                sendemail_verify("$name","$eemail","$verify_token");
                $_SESSION['message'] = "Registered successfully, please verify your Email Address.";
                header('Location: ../home/register.php');
                exit();
            }

        } 

    }




    //for login button


    if (isset($_POST["lbtn"])) {
        $mail = $_POST["email"];
        $provided_password = $_POST["pswd"];

    $flight_Id = $_POST["flightId"];
        // Fetch the hashed password, role, and verify_status from the database
        $sql = "SELECT `username`, `email`, `pass1`, `role`, `verify_status` FROM `users` WHERE `email`='$mail'";
        $result = mysqli_query($con, $sql);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $userdata = mysqli_fetch_assoc($result);
            $verify_status = $userdata['verify_status'];
    
            if ($verify_status == "1") {
                $hashed_password = $userdata['pass1'];
                $role = $userdata['role'];
    
                // Verify the provided password
                if (password_verify($provided_password, $hashed_password)) {
                    // Password is correct, proceed with login
                    $_SESSION['auth'] = true;
                    $name = $userdata['username'];
                    $mail = $userdata['email'];
                    $_SESSION['auth_user'] = [
                        'username' => $name,
                        'email' => $mail
                    ];
    
                    $_SESSION['role'] = $role;
                     

                    $redirectUrl = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'book1.php';

                    
                    if ($role == 1) {
                        header('Location: ../admin/index.php');
                        exit(0);
                    } 
                    else if(  $redirectUrl){
                        
                        unset($_SESSION['redirect_url']); // Clear the redirect URL from session
                        
                            header("Location: ../home/$redirectUrl?flightId=$flight_Id");
                             
                        
                        
                    }
                    else  {
                        header('Location: ../home/index.php');
                    }

                } else {
                    // Password is incorrect
                    $_SESSION['message'] = 'Invalid credentials';
                    header('Location: ../home/login.php');
                }
            } else {
                // Email not verified
                $_SESSION['message'] = 'Please verify your email address';
                header('Location: ../home/login.php');
            }
        } else {
            // User not found
            $_SESSION['message'] = 'Invalid credentials';
            header('Location: ../home/login.php');
        }
    }
    