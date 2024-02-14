
<?php
include "../config/dbcon.php";

if (isset($_GET['flight_id'])) {
    $id = $_GET['flight_id'];
}

$airbusCapacityQuery = "SELECT airbus.passenger_capacity
                        FROM flight
                        JOIN airbus ON flight.airbus_id = airbus.airbus_id
                        WHERE flight.flight_id = '$id'";
$airbusCapacityResult = mysqli_query($con, $airbusCapacityQuery);

if ($airbusCapacityResult) {
    $airbusCapacityRow = mysqli_fetch_assoc($airbusCapacityResult);
    $airbusCapacity = $airbusCapacityRow['passenger_capacity'];
} else {
    // Handle the error if needed
    $airbusCapacity = 0;
}

$errors = array();
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total = mysqli_real_escape_string($con, $_POST['total']);
    $numberOfEconomy = mysqli_real_escape_string($con, $_POST['numberOfEconomy_economy']);
    $economyPrice = mysqli_real_escape_string($con, $_POST['economyPrice']);

    $numberOfPreEconomy = mysqli_real_escape_string($con, $_POST['numberOfEconomy_pre']);
    $preEconomyPrice = mysqli_real_escape_string($con, $_POST['preEconomyPrice']);

    $numberOfBusiness = mysqli_real_escape_string($con, $_POST['numberOfBusiness']);
    $businessPrice = mysqli_real_escape_string($con, $_POST['businessPrice']);

    $numberOfFirst = mysqli_real_escape_string($con, $_POST['numberOfFirst']);
    $firstClassPrice = mysqli_real_escape_string($con, $_POST['firstClassPrice']);

    $flight_id = mysqli_real_escape_string($con, $_GET['flight_id']);

    // Check if total seats exceed Airbus capacity
    $totalSeats = (int)$numberOfEconomy + (int)$numberOfPreEconomy + (int)$numberOfBusiness + (int)$numberOfFirst;

    $total_economy_price = $numberOfEconomy * $economyPrice;
    $total_premium_price = $numberOfPreEconomy * $preEconomyPrice;
    $total_business_price = $numberOfBusiness * $businessPrice;
    $total_first_price = $numberOfFirst * $firstClassPrice;
    $total_seat_price = $total_economy_price + $total_premium_price + $total_business_price + $total_first_price;


    if ($totalSeats > $airbusCapacity) {
        $errors[] = "Total number of seats exceeds Airbus capacity.";
    } else {
        $checkQuery = "SELECT * FROM seat WHERE flight_id = '$flight_id'";
        $checkResult = mysqli_query($con, $checkQuery);
        
        if (mysqli_num_rows($checkResult) > 0) {
            // Record already exists, perform update or take appropriate action
            $errors[] = "Record already exists!";
        } else {
            // Constructing the SQL query
            $insertQuery = "INSERT INTO seat (total_seat, `no_economy`, `economy_price`, `no_premium`, `premium_price`, `no_business`, `business_price`, `no_first`, `first_price`, `total_economy_price`, `total_premium_price`, `total_business_price`, `total_first_price`, `total_seat_price`, flight_id) 
                            VALUES ('$totalSeats', '$numberOfEconomy','$economyPrice', '$numberOfPreEconomy','$preEconomyPrice', '$numberOfBusiness','$businessPrice', '$numberOfFirst','$firstClassPrice',' $total_economy_price','$total_premium_price','$total_business_price','$total_first_price ','$total_seat_price', '$flight_id')";

            // Executing the query
            $result = mysqli_query($con, $insertQuery);
            
            if ($result) {
                $success_message = "Insertion successful!";
                // Redirect to the same page to clear form fields
                header("Location: {$_SERVER['PHP_SELF']}?flight_id=$id");
                exit();
            } else {
                $errors[] = "Error: " . mysqli_error($con);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Form Fields</title>

    <style>
        form {
            margin: 250px;
            margin-top: 5%;
            margin-left: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            min-height: 300px; /* Add a minimum height to prevent collapsing */
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-size: 16px;
            font-weight: bold;
        }

        input[type="checkbox"] {
            margin-right: 8px;
            transform: scale(1.5); /* Increase the size of the checkboxes */
        }

        div {
            margin-bottom: 16px;
        }

        input[type="number"],
        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Add some styling for the success message */
        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>

    <?php
        include("includes/header.php");
    ?>
</head>
<body>


<div class="container">
    
<?php
include 'includes/header2.php';
?>

<main>
<form method="POST" action="#" onsubmit="return validateForm()">
<div id="errorContainer"></div>


    <?php
    // Display errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div style="color: red;">' . $error . '</div>';
        }
    }

    // Display success message
    if (!empty($success_message)) {
        echo '<div class="success-message">' . $success_message . '</div>';
    }
    ?>
    
    <label for="total">Airbus Seat Capacity:</label>
    <input type="text" id="total" name="total" value="<?php echo $airbusCapacity; ?>" readonly><br><br>

    <input type="checkbox" id="economyCheckbox" onchange="toggleField('economyCheckbox', 'economyField')">
    <label for="economyCheckbox">Economy Class</label><br>

    <div id="economyField" style="display: none;">
        <label for="numberOfEconomy">Number of Economy</label>
        <input type="number" id="numberOfEconomy" name="numberOfEconomy_economy"><br>

        <label for="economyPrice">Economy Class  Price Per Seat(INR):</label>
        <input type="number" id="economyPrice" name="economyPrice"><br>
    </div>

    

    <input type="checkbox" id="preEconomyCheckbox" onchange="toggleField('preEconomyCheckbox', 'preEconomyField')">
    <label for="preEconomyCheckbox">Premium Economy Class</label><br>

    <div id="preEconomyField" style="display: none;">
        <label for="numberOfPreEconomy">Number of Premium Economy</label>
        <input type="number" id="numberOfPreEconomy" name="numberOfEconomy_pre"><br>

            
        <label for="preEconomyPrice">Premium Economy Class  Price Per Seat(INR):</label>
        <input type="number" id="preEconomyPrice" name="preEconomyPrice"><br>
    </div>


    <input type="checkbox" id="businessCheckbox" onchange="toggleField('businessCheckbox', 'businessField')">
    <label for="businessCheckbox">Business Class</label><br>

    <div id="businessField" style="display: none;">
        <label for="numberOfBusiness">Number of Business</label>
        <input type="number" id="numberOfBusiness" name="numberOfBusiness" >

        <label for="businessPrice">Business Class Price Per Seat(INR):</label>
        <input type="number" id="businessPrice" name="businessPrice"><br>
    </div>

   

    <input type="checkbox" id="firstCheckbox" onchange="toggleField('firstCheckbox', 'firstField')">
    <label for="firstCheckbox">First Class</label><br>

    <div id="firstField" style="display: none;">
        <label for="numberOfFirst">Number of First Class</label>
        <input type="number" id="numberOfFirst" name="numberOfFirst">

        <label for="firstClassPrice">First Class  Price Per Seat(INR):</label>
    <input type="number" id="firstClassPrice" name="firstClassPrice"><br>
    </div>

   
    <br>
    <center>    <button type="submit">+Add Seats</button>
</center>
<br>
</form>

<script>
    function toggleField(checkboxId, fieldId) {
        var checkbox = document.getElementById(checkboxId);
        var field = document.getElementById(fieldId);

        field.style.display = checkbox.checked ? "block" : "none";
    }
</script>
<script>
    function toggleField(checkboxId, fieldId) {
        var checkbox = document.getElementById(checkboxId);
        var field = document.getElementById(fieldId);

        field.style.display = checkbox.checked ? "block" : "none";
    }

    function validateForm() {
        var preEconomyPrice = parseFloat(document.getElementById("preEconomyPrice").value);
        var economyPrice = parseFloat(document.getElementById("economyPrice").value);
        var businessPrice = parseFloat(document.getElementById("businessPrice").value);
        var firstClassPrice = parseFloat(document.getElementById("firstClassPrice").value);

        var errorContainer = document.getElementById("errorContainer");
        errorContainer.innerHTML = "";  // Clear previous error messages

        if (isNaN(preEconomyPrice) || isNaN(economyPrice) || isNaN(businessPrice) || isNaN(firstClassPrice)) {
            showError("Please enter valid numeric values for all prices.");
            return false;
        }

        if (preEconomyPrice <= economyPrice) {
            showError("Premium Economy Class price must be greater than Economy Class price.");
            return false;
        }

        if (businessPrice <= economyPrice || businessPrice <= preEconomyPrice) {
            showError("Business Class price must be greater than Economy Class and Premium Economy Class prices.");
            return false;
        }

        if (firstClassPrice <= economyPrice || firstClassPrice <= preEconomyPrice || firstClassPrice <= businessPrice) {
            showError("First Class price must be greater than Economy Class, Premium Economy Class, and Business Class prices.");
            return false;
        }

        return true;
    }

    function showError(message) {
        var errorContainer = document.getElementById("errorContainer");
        var errorMessage = document.createElement("div");
        errorMessage.style.color = "red";
        errorMessage.textContent = message;
        errorContainer.appendChild(errorMessage);
    }
</script>


</main>
</div>
</body>
</html>



<!-- 
<script>
    function toggleField(checkboxId, fieldId) {
        var checkbox = document.getElementById(checkboxId);
        var field = document.getElementById(fieldId);

        field.style.display = checkbox.checked ? "block" : "none";
    }

    function validateForm() {
        var preEconomyCheckbox = document.getElementById("preEconomyCheckbox");
        var businessCheckbox = document.getElementById("businessCheckbox");
        var firstCheckbox = document.getElementById("firstCheckbox");

        var numberOfEconomy = document.getElementById("numberOfEconomy").value;
        var economyPrice = document.getElementById("economyPrice").value;

        var numberOfPreEconomy = document.getElementById("numberOfPreEconomy").value;
        var preEconomyPrice = document.getElementById("preEconomyPrice").value;

        var numberOfBusiness = document.getElementById("numberOfBusiness").value;
        var businessPrice = document.getElementById("businessPrice").value;

        var numberOfFirst = document.getElementById("numberOfFirst").value;
        var firstClassPrice = document.getElementById("firstClassPrice").value;

        var errorContainer = document.getElementById("errorContainer");
        errorContainer.innerHTML = "";  // Clear previous error messages

        if (preEconomyCheckbox.checked && (numberOfPreEconomy === "" || preEconomyPrice === "")) {
            showError("Please enter Number of Premium Economy and Premium Economy Class Price Per Seat(INR).");
            return false;
        }

        if (businessCheckbox.checked && (numberOfBusiness === "" || businessPrice === "")) {
            showError("Please enter Number of Business and Business Class Price Per Seat(INR).");
            return false;
        }

        if (firstCheckbox.checked && (numberOfFirst === "" || firstClassPrice === "")) {
            showError("Please enter Number of First Class and First Class Price Per Seat(INR).");
            return false;
        }

        

        if (isNaN(preEconomyPrice) || isNaN(economyPrice) || isNaN(businessPrice) || isNaN(firstClassPrice)) {
            showError("Please enter valid numeric values for all prices.");
            return false;
        }

        if (preEconomyPrice <= economyPrice) {
            showError("Premium Economy Class price must be greater than Economy Class price.");
            return false;
        }

        if (businessPrice <= economyPrice || businessPrice <= preEconomyPrice) {
            showError("Business Class price must be greater than Economy Class and Premium Economy Class prices.");
            return false;
        }

        if (firstClassPrice <= economyPrice || firstClassPrice <= preEconomyPrice || firstClassPrice <= businessPrice) {
            showError("First Class price must be greater than Economy Class, Premium Economy Class, and Business Class prices.");
            return false;
        }


        return true;
    }

    function showError(message) {
        var errorContainer = document.getElementById("errorContainer");
        var errorMessage = document.createElement("div");
        errorMessage.style.color = "red";
        errorMessage.textContent = message;
        errorContainer.appendChild(errorMessage);
    }
</script> -->


<script>
    function toggleField(checkboxId, fieldId) {
        var checkbox = document.getElementById(checkboxId);
        var field = document.getElementById(fieldId);

        field.style.display = checkbox.checked ? "block" : "none";
    }

    function validateForm() {
        var preEconomyCheckbox = document.getElementById("preEconomyCheckbox");
        var businessCheckbox = document.getElementById("businessCheckbox");
        var firstCheckbox = document.getElementById("firstCheckbox");

        var numberOfEconomy = document.getElementById("numberOfEconomy").value;
        var economyPrice = document.getElementById("economyPrice").value;

        var numberOfPreEconomy = document.getElementById("numberOfPreEconomy").value;
        var preEconomyPrice = document.getElementById("preEconomyPrice").value;

        var numberOfBusiness = document.getElementById("numberOfBusiness").value;
        var businessPrice = document.getElementById("businessPrice").value;

        var numberOfFirst = document.getElementById("numberOfFirst").value;
        var firstClassPrice = document.getElementById("firstClassPrice").value;

        var errorContainer = document.getElementById("errorContainer");
        errorContainer.innerHTML = "";  // Clear previous error messages

        function validatePrice(price, errorMessage) {
            if (isNaN(price) || price <= 0) {
                showError(errorMessage);
                return false;
            }
            return true;
        }

        if (preEconomyCheckbox.checked) {
            var numberOfPreEconomy = document.getElementById("numberOfPreEconomy").value;
            var preEconomyPrice = parseFloat(document.getElementById("preEconomyPrice").value);
             var numberOfEconomy = document.getElementById("numberOfEconomy").value;
        var economyPrice = document.getElementById("economyPrice").value;

        var numberOfPreEconomy = document.getElementById("numberOfPreEconomy").value;
        var preEconomyPrice = document.getElementById("preEconomyPrice").value;

        var numberOfBusiness = document.getElementById("numberOfBusiness").value;
        var businessPrice = document.getElementById("businessPrice").value;

        var numberOfFirst = document.getElementById("numberOfFirst").value;
        var firstClassPrice = document.getElementById("firstClassPrice").value;

            if (!validatePrice(preEconomyPrice, "Please enter a valid Premium Economy Class Price Per Seat(INR).")) {
                return false;
            }

            if (numberOfPreEconomy === "") {
                showError("Please enter Number of Premium Economy.");
                return false;
            }

             if (preEconomyPrice <= economyPrice) {
            showError("Premium Economy Class price must be greater than Economy Class price.");
            return false;
        }

        
        if (isNaN(preEconomyPrice) || isNaN(economyPrice) || isNaN(businessPrice) || isNaN(firstClassPrice)) {
            showError("Please enter valid numeric values for all prices.");
            return false;
        }

        }

        if (businessCheckbox.checked) {
            var numberOfBusiness = document.getElementById("numberOfBusiness").value;
            var businessPrice = parseFloat(document.getElementById("businessPrice").value);
             var numberOfEconomy = document.getElementById("numberOfEconomy").value;
        var economyPrice = document.getElementById("economyPrice").value;

        var numberOfPreEconomy = document.getElementById("numberOfPreEconomy").value;
        var preEconomyPrice = document.getElementById("preEconomyPrice").value;

        var numberOfBusiness = document.getElementById("numberOfBusiness").value;
        var businessPrice = document.getElementById("businessPrice").value;

        var numberOfFirst = document.getElementById("numberOfFirst").value;
        var firstClassPrice = document.getElementById("firstClassPrice").value;

            if (!validatePrice(businessPrice, "Please enter a valid Business Class Price Per Seat(INR).")) {
                return false;
            }

            if (numberOfBusiness === "") {
                showError("Please enter Number of Business.");
                return false;
            }

             if (businessPrice <= economyPrice || businessPrice <= preEconomyPrice) {
            showError("Business Class price must be greater than Economy Class and Premium Economy Class prices.");
            return false;
        }
        
        if (isNaN(preEconomyPrice) || isNaN(economyPrice) || isNaN(businessPrice) || isNaN(firstClassPrice)) {
            showError("Please enter valid numeric values for all prices.");
            return false;
        }
        }

        if (firstCheckbox.checked) {
            var numberOfFirst = document.getElementById("numberOfFirst").value;
            var firstClassPrice = parseFloat(document.getElementById("firstClassPrice").value);
             var numberOfEconomy = document.getElementById("numberOfEconomy").value;
        var economyPrice = document.getElementById("economyPrice").value;

        var numberOfPreEconomy = document.getElementById("numberOfPreEconomy").value;
        var preEconomyPrice = document.getElementById("preEconomyPrice").value;

        var numberOfBusiness = document.getElementById("numberOfBusiness").value;
        var businessPrice = document.getElementById("businessPrice").value;

        var numberOfFirst = document.getElementById("numberOfFirst").value;
        var firstClassPrice = document.getElementById("firstClassPrice").value;

            if (!validatePrice(firstClassPrice, "Please enter a valid First Class Price Per Seat(INR).")) {
                return false;
            }

            if (numberOfFirst === "") {
                showError("Please enter Number of First Class.");
                return false;
            }
             if (firstClassPrice <= economyPrice || firstClassPrice <= preEconomyPrice || firstClassPrice <= businessPrice) {
            showError("First Class price must be greater than Economy Class, Premium Economy Class, and Business Class prices.");
            return false;
        }
        
        if (isNaN(preEconomyPrice) || isNaN(economyPrice) || isNaN(businessPrice) || isNaN(firstClassPrice)) {
            showError("Please enter valid numeric values for all prices.");
            return false;
        }
        }


        return true;
    }

    function showError(message) {
        var errorContainer = document.getElementById("errorContainer");
        var errorMessage = document.createElement("div");
        errorMessage.style.color = "red";
        errorMessage.textContent = message;
        errorContainer.appendChild(errorMessage);
    }
</script>
