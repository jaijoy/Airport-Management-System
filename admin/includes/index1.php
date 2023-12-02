<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Admin Panel Container */
        .admin-panel {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #2C3E50; /* Updated sidebar color */
            color: #fff;
            padding: 20px;
            transition: width 0.3s;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #ECF0F1; /* Updated logo color */
            text-align: center;
        }

        .menu {
            padding: 0;
            list-style: none; /* Remove default list styling */
        }

        .menu a {
            color: #ECF0F1; /* Updated menu item color */
            display: block;
            padding: 10px;
            transition: background-color 0.3s;
            border-radius: 5px;
            margin-bottom: 5px;
            text-decoration: none; /* Remove underlines */
        }

        .menu a:hover {
            background-color: #3498DB; /* Updated hover color */
            text-decoration: none;
        }

        /* Main Content Styles */
        .main-content {
            flex-grow: 1;
            background-color: #ECF0F1;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        /* Header Styles */
        .header {
            background-color: #3498DB; /* Updated header color */
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .logout-btn {
            background-color: #E74C3C; /* Updated logout button color */
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #C0392B; /* Updated logout button hover color */
            text-decoration: none;
        }

        /* Content Area Styles */
        .content {
            padding: 20px;
            background-color: #fff; /* Updated content area background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2C3E50; /* Updated heading color */
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
<script>
    function showStopDetails() {
        var stopDetails = document.getElementById("stopDetails");
        stopDetails.style.display = "block";
    }

    function toggleSidebar() {
        var sidebar = document.querySelector('.sidebar');
        var mainContent = document.querySelector('.main-content');

        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    }
</script>
<div class="admin-panel">
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="logo">Fly Easy</div>
        <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="#">Booked</a></li>
            <li><a href="schedule_view.php">Flight Schedule</a></li>
            <li><a href="stop.php">Stop Details</a></li>
            <li><a href="seat_view.php">Seat Details</a></li>
            <li><a href="flights.php">Flight Details</a></li>
            <li><a href="flight_one.php">Add Flight</a></li>
            <li><a href="airport.php">Airport</a></li>
            <li><a href="Aircraft.php">Airbus</a></li>
            <li><a href="airline.php">Airlines</a></li>
            <li><a href="users.php">Users</a></li>
        </ul>
    </nav>

    <!-- Menu toggle button for small screens -->
    <div class="menu-toggle" onclick="toggleSidebar()">☰</div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="user-profile">
                <!-- Your user profile content here -->
            </div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <!-- Content Area -->
        <div class="content">
            <h1>Welcome to the Admin Panel</h1>
        </div>
    </main>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>
