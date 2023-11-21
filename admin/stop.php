<?php
include "../config/dbcon.php";
include("includes/base.php");
?>

<!DOCTYPE html>
<html>
<head>
<style>
  /* Style the navigation bar */
  .navbar {
    overflow: hidden;
   
    background-color: #601093;
    

  }

  /* Style the links inside the navigation bar */
  .navbar a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 20px;
    text-decoration: none;
    margin-top: 30px;
    margin-left:100px;
  }

  /* Change the color of links on hover */
  .navbar a:hover {
    background-color: #ddd;
    color: black;
  }
</style>
</head>
<body>

<div class="navbar">

  <a href="onestop_view.php">ONE STOP</a>
  <a href="twostop_view.php">TWO STOP</a></a>
  <a href="threeStop_view.php">THREE STOP</a>
  <a href="fourstop.php">FOUR STOP</a>
  <a href="nonstop.php">NON STOP</a>
</div>

</body>
</html>
