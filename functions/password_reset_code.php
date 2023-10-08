<?php
session_start();
include "../config/dbcon.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require '../vendor/autoload.php';


function send_password_reset($get_name,$get_email,$token)
{
    
    //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
            //Server settings
           //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
            $mail->isSMTP();                                            //Send using SMTP
            $mail->SMTPAuth = true;  
            
            $mail->Host = "smtp.gmail.com";
            $mail->Username = 'jaimoljoy2024@gmail.com';                     //SMTP username
            $mail->Password = 'gepxqpbohvhfdjyd'; // two step enable eduthite , app password generate cheithu edukuk
            $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
            $mail->Port = 587;               //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('jaimoljoy2024@gmail.com',$get_name);
            $mail->addAddress($get_email);     //Add a recipient
           
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Reset password notification";
            
            $email_template="
                <h2>Hello..</h2>
                <h3>You are receiving this email because we received a password request for your account.</h3>
                <br><br>
                <a href='http://localhost/Airport/home/pswd_change.php/token=$token&email=$get_email'>Click Me</a>
            ";
            
            $mail->Body=$email_template;
            $mail->send();
            //echo 'Message has been sent';
       
}



if(isset($_POST['reset']))
{
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT email FROM users WHERE email='$email' LIMIT 1 ";
    $check_email_run = mysqli_query($con,$check_email);

    if(mysqli_num_rows($check_email_run)>0)
    {
        $row = mysqli_fetch_array($check_email_run);
        
            $get_name = $row['username'];
            $get_email = $row['email'];
        

            $update_token = "UPDATE users SET verify_token='$token' WHERE email='$get_email' LIMIT 1 ";
            $update_token_run = mysqli_query($con, $update_token);

            if($update_token_run)
            {
                send_password_reset($get_name,$get_email,$token);
                $_SESSION['message'] = "we e-mailed you a password reset link ";
                header('Location: ../home/forgot_pswd.php');
                exit(0);
            }
            else{
                $_SESSION['message'] = "something went wrong. #1";
                header('Location: ../home/forgot_pswd.php');
                exit(0);
            }
        //}
    }
    else{
        $_SESSION['message'] = "No email found";
        header('Location: ../home/forgot_pswd.php');
        exit(0);
    }
}





if(isset($_POST['pswd_update']))
{
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $new_password = mysqli_real_escape_string($con, $_POST['pswd']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['cpswd']);

    $token = mysqli_real_escape_string($con, $_POST['password_token']);
    echo $token;
    if(!empty($token))
    {
        if(!empty($email) && !empty($new_password ) && !empty($confirm_password))
        {
            //checking token is valid or not
            $check_token="SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($con,$check_token);

            if(mysqli_num_rows($check_token_run)>0)
            {

                $update_password = "UPDATE users SET password='$new_password' WHERE verify_token='$token' LIMIT 1";
                $update_password_run = mysqli_query($con,$update_password);
                if($update_password_run )
                {
                    $_SESSION['message'] = "New Password Succesfully updated.!";
                    header("Location: ../home/login.php");
                    exit(0);
                }
                else{
                    $_SESSION['message'] = "Did n't update the password ,something went wrong.!";
                    header("Location: ../home/forgot_pswd.php?token=$token&&email=$email");
                    exit(0);
                }
               /* if()
                {

                }
                else
                {
                $_SESSION['message'] = "Invalid token";
                header("Location: ../home/forgot_pswd.php?token=$token&&email=$email");
                exit(0);
                } */
            }
            else
            {
                $_SESSION['message'] = "Invalid token";
                header("Location: ../home/forgot_pswd.php?token=$token&&email=$email");
                exit(0);
            }
        }
        else
        {
            $_SESSION['message'] = "All field are mandatory";
            header("Location: ../home/forgot_pswd.php?token=$token&&email=$email");
            exit(0);
        }
    }
    else{
        $_SESSION['message'] = "No token available";
        //header('Location: ../home/forgot_pswd.php');
        // exit(0);
    }

}
?>