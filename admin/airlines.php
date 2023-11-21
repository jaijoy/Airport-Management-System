<?php
include("includes/base.php");
include("includes/header.php");
include "../config/dbcon.php";

// Inserting data into the database
// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


// Inserting data into the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $airline_name = test_input($_POST["airline_name"]);
    $airline_type = test_input($_POST["airline_type"]);

    // Handle image upload
    $targetDirectory = "uploads/"; // Directory to store uploaded images
    $targetFile = $targetDirectory . basename($_FILES["airline_logo"]["name"]);
    
    if (move_uploaded_file($_FILES["airline_lo"]["tmp_name"], $targetFile)) {
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    }
    // Check file size
    if ($_FILES["airline_logo"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["airline_logo"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["airline_logo"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Check if the entry already exists
    $check_query = "SELECT * FROM airline WHERE airline_name='$airline_name' AND airline_type='$airline_type'";
    $check_result = mysqli_query($con, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "Error: The entry already exists in the database.";
    } else {
        $sql = "INSERT INTO airline (airline_name, airline_type, logo) VALUES ('$airline_name', '$airline_type', '$target_file')";

        if (mysqli_query($con, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }
}
// Editing data in the database
if(isset($_POST['airline_id'])) {
    $airline_id = $_POST['airline_id'];
    $airline_name = $_POST['airline_name'];
    $airline_type = $_POST['airline_type'];

    $update_sql = "UPDATE airline SET airline_name='$airline_name', airline_type='$airline_type' WHERE airline_id=$airline_id";

    if (mysqli_query($con, $update_sql)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}

// Deleting data from the database
if(isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM airline WHERE airline_id = $delete_id";

    if (mysqli_query($con, $delete_sql)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Airlines Form</title>
    <style>
        /* Add CSS for the pop-up form */
        .form-popup {
            display: none;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

<?php

    // Check if the entry already exists
    $check_query = "SELECT * FROM airline WHERE airline_name='$airline_name' AND airline_type='$airline_type'";
    $check_result = mysqli_query($con, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "Error: The entry already exists in the database.";
    } else {
        $sql = "INSERT INTO airline (airline_name, airline_type) VALUES ('$airline_name', '$airline_type')";

        if (mysqli_query($con, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }

// Editing data in the database
if(isset($_POST['airline_id'])) {
    $airline_id = $_POST['airline_id'];
    $airline_name = $_POST['airline_name'];
    $airline_type = $_POST['airline_type'];

    $update_sql = "UPDATE airline SET airline_name='$airline_name', airline_type='$airline_type' WHERE airline_id=$airline_id";

    if (mysqli_query($con, $update_sql)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}

// Deleting data from the database
if(isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM airline WHERE airline_id = $delete_id";

    if (mysqli_query($con, $delete_sql)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}



?>

<!DOCTYPE html>
<html>
<head>
    <title>Airlines Form</title>
    <style>
        /* Add CSS for the pop-up form */
        .form-popup {
            display: none;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }
        
        .form-container {
            background-color: #fefefe;
            padding: 20px;
            width: 300px;
            margin: auto;
        }

        .form-container {
            background-color: #fefefe;
            padding: 20px;
            width: 300px;
        }

        table {
            width: 50%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<h2>Add Airlines </h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Airline Name: <input type="text" name="airline_name" required>
    <br><br>
    Airline Type:
    <select name="airline_type">
        <option value="Cargo Airline">Cargo Airline</option>
        
        <option value="Domestic Airline">Domestic Airline</option>
    </select>
    <br><br>
    Airline Logo:
     <input type="file" name="airline_logo" accept="image/*">

    <br><br>
    <input type="submit" name="submit" value="Add">
</form>

<h2>Airlines List</h2>
<table border="1">
    <tr>
        <th>SI No</th>
        <th>Airline Name</th>
        <th>Airline Type</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php
    $result = mysqli_query($con, "SELECT * FROM airline");
    $counter = 1;
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $counter . "</td>";
        echo "<td>" . $row['airline_name'] . "</td>";
        echo "<td>" . $row['airline_type'] . "</td>";
        echo "<td><a href='javascript:void(0)' onclick='openEditForm(" . $row["airline_id"] . ", \"" . $row["airline_name"] . "\", \"" . $row["airline_type"] . "\")'>Edit</a></td>";
        echo "<td><a href='?delete_id=".$row['airline_id']."'>Delete</a></td>";
        echo "</tr>";
        $counter++;
    }
    ?>
</table>

<div class="form-popup" id="editForm">
    <div class="form-container">
        <h2>Edit Airlines</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" name="airline_id" id="airline_id" value="">
            Airline Name: <input type="text" name="airline_name" id="airline_name" required>
            <br><br>
            Airline Type:
            <select name="airline_type" id="airline_type">
                <option value="Cargo Airline">Cargo Airline</option>
                <option value="Domestic Airline">Domestic Airline</option>
            </select>
            <br><br>
            Airline Logo: <input type="file" name="airline_logo" accept="image/*">

            <br><br>
            
            <input type="submit" name="update" value="Update">
            <button type="button" onclick="closeEditForm()">Close</button>
        </form>
    </div>
</div>

<script>
    function openEditForm(id, name, type) {
        document.getElementById("editForm").style.display = "block";
        document.getElementById("airline_id").value = id;
        document.getElementById("airline_name").value = name;
        document.getElementById("airline_type").value = type;
    }

    function closeEditForm() {
        document.getElementById("editForm").style.display = "none";
    }
</script>

</body>
</html>























<?php
// Your PHP code for querying and displaying the table

$select_query = "SELECT airbus.airbus_id, airline.airline_name, airbus.airbus_name, airbus.passenger_capacity, airbus.status FROM airbus JOIN airline ON airbus.airline_id = airline.airline_id";
$result = mysqli_query($con, $select_query);

if (mysqli_num_rows($result) > 0) {
    echo "<table>
    <tr>
    <th>Si. No.</th>
    <th>Airline Name</th>
    <th>Airbus Name</th>
    <th>Passenger Capacity</th>
    <th>Edit</th>
    <th>Enable/Disable</th>
    </tr>";

    $serial_no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $serial_no . "</td>";
        echo "<td>" . $row['airline_name'] . "</td>";
        echo "<td>" . $row['airbus_name'] . "</td>";
        echo "<td>" . $row['passenger_capacity'] . "</td>";
        if ($row["status"] == 1) {

            $select_query1 = "update .........query";
            $result1 = mysqli_query($con, $select_query);


            echo "<td><button  class='edit-button-disabled' disabled>Edit</button></td>";
            echo "<td><button>Disable</button></td>";
        } else {
            
            echo "<td><button>Edit</button></td>";
            echo "<td><button>Enalble</button></td>";
        }
    }
}
       

mysqli_close($con);
?>



