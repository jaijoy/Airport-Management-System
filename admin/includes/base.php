<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="css/admin.css"> -->
    <title>Admin Panel</title>
    <style>
                /* Reset some default styles */
        body, h1, ul, li, a {
            margin: 0;
            padding: 0;
            list-style: none;
            text-decoration: none;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Admin Panel Container */
        .admin-panel {
            display: flex;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 146px;
            background-color: #0b004c;
            color: #fff;
            padding: 68px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .menu li {
            margin-bottom: 10px;
        }

        .menu a {
            color: #fff;
            display: block;
            padding: 5px 0;
        }

        .menu a:hover {
            background-color: #755eb4;
            border-radius: 5px;
        }

        /* Main Content Styles */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: #dcdaed;
        }

        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .user-profile img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .logout-btn {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #56a1ed;
        }

        /* Content Area Styles */
        .content {
            padding: 20px;
            overflow: auto;
        }

    </style>
</head>
<body>
    
    <div class="admin-panel">
    
            
        <!-- Sidebar -->
        <nav class="sidebar">
        <div class="logo">Fly Easy</div>
            <div class="logo">Admin Panel</div>
            <ul class="menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Booked</a></li>

                <li><a href="#">Flight Schedule</a></li>
                
                <li><a href="one_stop.php">One Stop Deatails</a></li>
                <li><a href="seat.php">Seat Deatails</a></li>
                <li><a href="flight_one.php">Add Flight</a></li>
                

                
                <li><a href="airport.php">Airport</a></li>
                <li><a href="Aircraft.php">Airbus</a></li>
                <li><a href="airline.php">Airlines</a></li>
                
                <li><a href="#">Users</a></li>
                
            </ul>
        </nav>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
   
