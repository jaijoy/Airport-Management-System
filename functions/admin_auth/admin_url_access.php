<?php
 if(isset($_SESSION['auth']))
    {
       if($_SESSION['role'] != 1)
       {
         $_SESSION['message'] = 'You are not authorized to access this page';
         header('Location: ../home/index.php');
         exit();
       }
    }
else{
    $_SESSION['message'] = 'Login to continue..';
     header('Location: ../home/login.php');
     exit();
}

?>