<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    
    <title>FlyEasy</title>
</head>
<body>
            <!-- header-->
            <nav>
                <!-- <img src="images/flyeasy-logo.png" class="logo1" width=50 height=50> -->
                <div class ="logo">
                    <p>FlyEasy</p>
                </div>
                <ul>
                                        <li><a href="index.php">home</a></li>
                                        <li><a href="index.php">flights</a></li>
                                        <?php
                                        if(isset($_SESSION['auth']))
                                        { ?>

                                             <li><a href="index.php">About</a></li>
                                             <li><a href="index.php">Contact Us</a></li>
                                             <li> <a href="logout.php">logout</a> </li> 
                                             <li></li>
                                             

                                         <?php  } 
                                         else{ ?>
                                            <li><a href="login.php">login</a></li>
                                            <li><a href="index.php">About</a></li>
                                            <li><a href="index.php">Contact Us</a></li>
                                            <li class="last">
                                            <a href="#"><img src="images/search_icon.png" alt="icon" /></a>
                                        </li>
                                            
                                        <?php }
                                         
                                         ?>
                </ul>
            </nav>


         