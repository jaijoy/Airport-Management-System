<?php
// Start the session
session_start();

include("includes/base.php");
include "../config/dbcon.php";

// Check if the email is set in the session
if (!isset($_SESSION['auth_user']['email'])) {
    // Retrieve the email from the session
    header("Location: login.php"); // Redirect to your login page
    exit();
}
$payment_id=$_SESSION['payment_id'];

// Check if the check-in button is clicked
if (isset($_POST['check_in'])) {
    // Update the check-in status to 1 in the database
    $book_reference_id = $_SESSION['book_reference_id'];
    $update_sql = "UPDATE payment SET checkin_status = 1 where payment_id = $payment_id";
    if ($con->query($update_sql) === TRUE) {
        // Check-in status updated successfully
        echo '<script>alert("Check-in status updated successfully."); window.location.href = "interface_three.php";</script>';
        exit; // Stop further execution
    } else {
        // Error updating check-in status
        echo "Error updating check-in status: " . $con->error;
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flight Check-in Details</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* General styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f8f8;
      margin-top: 10%;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 800px;
      margin: 20px auto;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }
    h1, h2, h3 {
      color: #333;
    }
    p, ul {
      color: #666;
    }
    .card-section {
      background-color: #f9f9f9;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .card-section h2 {
      color: #333;
      margin-bottom: 10px;
      border-bottom: 1px solid #ccc;
      padding-bottom: 5px;
    }
    .icon {
      margin-right: 10px;
    }
    .bags {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
      border-radius: 8px;
      overflow: hidden;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .bag-info {
      padding: 20px;
      flex: 1;
      box-sizing: border-box;
    }
    .bag-info h2 {
      color: #333;
      margin-bottom: 15px;
      border-bottom: 1px solid #ccc;
      padding-bottom: 10px;
    }
    .bag-info p {
      margin-bottom: 10px;
    }

    /* Responsive styles */
    @media only screen and (max-width: 600px) {
      .container {
        padding: 10px;
      }
      .bags {
        flex-direction: column;
      }
      .bag-info {
        margin-right: 0;
        margin-bottom: 20px;
        border-radius: 0;
      }
    }
  </style>
</head>
<body><br><br><br><br><br><br>
  <div class="container">
    <h2>Are Your Bags Safe for Take-off?</h2>

    <div class="bags">
      <div class="bag-info">
        <h2>Carry-on Baggage</h2>
        <p><strong>Bag Type:</strong> Small</p>
        <p><strong>Weight Limit:</strong> 10 kg</p>
        <p><strong>Dimensions:</strong> 20x30x40 cm</p>
      </div>
      <div class="bag-info">
        <h2>Checked Baggage</h2>
        <p><strong>Bag Type:</strong> Large</p>
        <p><strong>Weight Limit:</strong> 25 kg</p>
        <p><strong>Dimensions:</strong> 50x60x80 cm</p>
      </div>
    </div>

    <div class="card-section">
      <h3>Pack in your carry-on bags</h3>
      <ul>
        <li><i class="fas fa-smoking icon"></i>E-cigarettes</li>
        <li><i class="fas fa-laptop icon"></i>Electronic devices</li>
        <li><i class="fas fa-battery icon"></i>Spare batteries, lighters, and matches</li>
        <li><i class="fas fa-battery-full icon"></i>Power banks (Lithium-ion battery should not exceed 100-160Wh, maximum 2)</li>
      </ul>
    </div>

    <div class="card-section">
      <h3>Pack in your checked bags</h3>
      <ul>
        <li><i class="fas fa-spray-can icon"></i>Aerosol</li>
        <li><i class="fas fa-snowflake icon"></i>Dry ice</li>
        <li><i class="fas fa-gun icon"></i>Firearms & ammunition</li>
        <li><i class="fas fa-campground icon"></i>Camp stoves</li>
        <li><i class="fas fa-swimmer icon"></i>Scuba tank</li>
        <li><i class="fas fa-gas-pump icon"></i>Gasoline Powered equipment</li>
      </ul>
    </div>

    <div class="card-section">
      <h3>Prohibited items</h3>
      <ul>
        <li><i class="fas fa-fire icon"></i>Flammable items</li>
        <li><i class="fas fa-fire-alt icon"></i>Fireworks</li>
        <li><i class="fas fa-flask icon"></i>Corrosive chemicals & household cleaners</li>
        <li><i class="fas fa-gas-can icon"></i>Propane</li>
        <li><i class="fas fa-radiation-alt icon"></i>Radioactive products</li>
        <li><i class="fas fa-biohazard icon"></i>Biohazard or infectious materials</li>
        <li><i class="fas fa-car icon"></i>Small lithium battery-operated vehicles</li>
      </ul>
    </div>
    <form method="POST">
    <button type="submit" name="check_in" style="background-color: #4CAF50; /* Green */
      border: none;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      margin-left:40%;
      cursor: pointer;
      border-radius: 8px;
      transition-duration: 0.4s;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      outline: none;
    "> Check-in</button>
  </form>
   
  </div>
</body>
</html>
