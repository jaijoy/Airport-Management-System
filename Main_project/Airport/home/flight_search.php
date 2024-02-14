
	
<?php
include("includes/base.php");
include "../config/dbcon.php";
$sql = "SELECT * FROM airport";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Flight Search</title>
    <style>
        /* your CSS styles here */
		.container {
			width: 50%;
			margin: 0 auto;
			padding: 20px;
			border: 1px solid #ccc;
			border-radius: 5px;
		}

		form {
			
			flex-direction: column;
		}

		label {
			margin-top: 10px;
		}

		input[type="date"], select, input[type="number"] {
			width: 100%;
			padding: 8px;
			margin: 5px 0;
			border: 1px solid #ccc;
			border-radius: 4px;
		}

		input[type="submit"] {
			width: 100%;
			background-color: #4CAF50;
			color: white;
			padding: 10px 15px;
			margin: 8px 0;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}

		input[type="submit"]:hover {
			background-color: #45a049;
		}
        
    </style>
</head>
<body>

<br><br><br><br><br>
<div class="container">
    <h2>Flight Search</h2>
    <form action="/search" method="post">
        <label for="from">From:</label>
        <select id="from" name="from">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['airport_name'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
            }
            ?>
        </select>
        <label for="to">To:</label>
        <select id="to" name="to">
            <?php
            // Reset the pointer to the beginning of the result set
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['airport_name'] . "'>" . $row['airport_name'] . " - " . $row['airport_location'] . "</option>";
            }
            mysqli_close($con);
            ?>
        </select>
        <label for="passengers">Passengers:</label>
        <input type="number" id="passengers" name="passengers" min="1">
        <label for="class">Class:</label>
        <select id="class" name="class">
            <option value="Economy">Economy</option>
            <option value="Business">Business</option>
            <option value="First">First</option>
        </select>
        <label for="departure">Departure date:</label>
        <input type="date" id="departure" name="departure">
        <label for="return">Return date:</label>
        <input type="date" id="return" name="return">
        <input type="submit" value="Search">
    </form>
</div>

<!-- Add your PHP code here -->
<!-- Your existing PHP code follows -->
<!-- ... -->

</body>
</html>
