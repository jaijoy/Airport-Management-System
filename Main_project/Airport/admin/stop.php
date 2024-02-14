
<?php
include "../config/dbcon.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        /* Center the container content vertically and horizontally */
       

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            background-color: #f8f9fa;
        }

        /* Change the color of buttons on hover */
        .btn-card:hover {
            transform: translateY(-5px); /* Add a slight lift on hover */
        }
    </style>
</head>
<?php
        include("includes/header.php");
?>
<body class="bodyy">
<div class="container">

    <?php
    include 'includes/header2.php';
    ?>

    <main>

        <div class="container text-center">
            <div class="row">
                <div class="col-md-6 mx-auto mb-3">
                    <div class="card">
                        <div class="card-body">
                            <a href="stop_one.php" class="btn btn-primary btn-lg btn-block btn-card">ADD ONE STOP</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mx-auto mb-3">
                    <div class="card">
                        <div class="card-body">
                            <a href="stop_two.php" class="btn btn-primary btn-lg btn-block btn-card">ADD TWO STOP</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mx-auto mb-3">
                    <div class="card">
                        <div class="card-body">
                            <a href="stop_three.php" class="btn btn-primary btn-lg btn-block btn-card">ADD THREE STOP</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <a href="stop_four.php" class="btn btn-primary btn-lg btn-block btn-card">ADD FOUR STOP</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Include Bootstrap JS and Popper.js -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </main>
</div>
</body>
</html>