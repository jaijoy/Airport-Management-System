<?php
include "../config/dbcon.php";
include("includes/base.php");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Terminal Form</title>
</head>
<body>
    <form action="" method="post">
        <label for="terminal_name">Terminal Name:</label><br>
        <input type="text" id="terminal_name" name="terminal_name"><br><br>
        <input type="submit" value="Submit">
    </form>

    <?php
    
        if(isset($_POST['terminal_name'])){
            $terminal_name = $_POST['terminal_name'];
            $query = "INSERT INTO terminal (terminal_type) VALUES ('$terminal_name')";
            if(mysqli_query($con, $query)){
                echo "Data inserted successfully.";
            } else{
                echo "ERROR: Could not able to execute $query. " . mysqli_error($con);
            }
        }
    
    ?>
</body>
</html>
