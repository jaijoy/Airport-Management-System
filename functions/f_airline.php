<?php
include "../config/dbcon.php";


if (isset($_POST["abtn"])) {
    // Get the values from the form
    $airlineName = $_POST["airlineName"];
    
    // Handle image upload
    $targetDirectory = "uploads/"; // Directory to store uploaded images
    $targetFile = $targetDirectory . basename($_FILES["img"]["name"]);
    
    if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) {
        // Image uploaded successfully
        // Insert data into the database
        $sql = "INSERT INTO airline(a_name, a_image) VALUES ('$airlineName', '$targetFile')";

        if ($con->query($sql) === TRUE) {
            // Data inserted successfully
            echo "Airline added successfully.";
            header('Location: ../admin/airlineview.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your image.";
    }
}
?>