<?php
session_start();
include "../config/dbcon.php";

if(isset($_GET['token']))
{
    $token=$_GET['token'];
    $verify_query = "SELECT verify_token,verify_status FROM users WHERE verify_token='$token' LIMIT 1 ";
    $verify_query_run = mysqli_query($con,$verify_query);

    if(mysqli_num_rows($verify_query_run)>0)
    {
        $row = mysqli_fetch_array($verify_query_run);
        //echo $row['verify_token'];
        if($row['verify_status']== "0")
        {
                $clicked_token = $row['verify_token'];
                $update_query = "UPDATE users SET verify_status='1' WHERE verify_token='$clicked_token' LIMIT 1 ";
                $update_query_run = mysqli_query($con,$update_query);
                if($update_query_run)
                {
                    $_SESSION["message"] = "Your Account has been verified successfully!";
                    header('Location:login.php'); 
                    exit(0);
                }
                else
                {
                    $_SESSION["message"] = "Verification failed.!";
                     header('Location:login.php');
                     exit(0);
                }
        }
        else
        {
            $_SESSION["message"] = "Email Already verified.please Login";
            header('Location:login.php');
            exit(0);
        }
    }
    else
    {
        $_SESSION["message"] = "This token does not Exists";
        header('Location:login.php');
    }
}
else{
    $_SESSION["message"] = "Not Allowed";
     header('Location:login.php');
}

?>