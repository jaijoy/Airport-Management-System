<head>

    

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<style>
                    /* Add this CSS to make the navigation menu attractive */
            /* Add this CSS to make the navigation menu more attractive with hover effect */
            .navbar-nav {
                display: flex;
                align-items: center;
                padding-top: 0px;
            }

            .navbar-nav .nav-item {
                margin: 0 10px;
            }

            .navbar-nav .nav-link {
                color: #fff;
                font-weight: bold;
                transition: color 0.3s ease-in-out;
            }

            .navbar-nav .nav-link:hover {
                color: #ffc107; /* Change to your desired hover color */
                transform: scale(1.1); /* Optional: Add a slight scale effect on hover */
            }

            .navbar-brand {
                font-size: 1.5rem;
                font-weight: bold;
                transition: color 0.3s ease-in-out;
            }

            .navbar-brand:hover {
                color: #ffc107; /* Change to your desired hover color */
            }

            /* Optionally, you can add a background color to the navbar */
            .navbar {
                background-color: #343a40; /* Change to your desired background color */
            }

            /* Optional: Add some padding to the navbar items for better spacing */
            .navbar-nav .nav-item {
                padding: 8px 15px;
            }

            /* Optional: Style the active link differently */
            .navbar-nav .nav-item.active .nav-link {
                color: #ffc107; /* Change to your desired active color */
            }


</style>
</head>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">FlyEasy</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                    <a class="nav-link text-white" href="index.php">Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link text-white" href="flight_result3.php">Flights</a>
                </li>
                <?php
        if (isset($_SESSION['auth'])) {
            // User is logged in, display a welcome message with the username
            ?>

                <li class="nav-item">
                    <a class="nav-link text-white" href="#">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Contact</a>
                </li>
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <i class="fas fa-user mx-1"></i> Profile
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">My account</a>
                    <a class="dropdown-item" href="logout.php">Log out</a>
                </div>
            </li>
            
            <?php } else { ?>

                <li class="nav-item">
                    <a class="nav-link text-white" href="login.php">Log In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Contact</a>
                </li>

            <?php } ?>
            </ul>
            
        </div>
    </nav>

  
<script>
    $(document).ready(function () {
        $('.dropdown-toggle').dropdown();
    });
</script>



   
