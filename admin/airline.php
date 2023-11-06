
<?php
include("includes/base.php");

include "../config/dbcon.php";




if (isset($_POST["submit"])) {
    // Get the values from the form
    $airlineName = $_POST["airline_name"];

    // Escape any special characters to prevent SQL injection
    $airlineName = mysqli_real_escape_string($con, $airlineName);

    // Check if the airline name already exists
    $existing_airline = mysqli_query($con, "SELECT * FROM airline WHERE airline_name = '$airlineName'");
    if (mysqli_num_rows($existing_airline) > 0) {
        $errorMessage = "Error: An airline with the same name already exists.";
    } else {
        // Handle the file upload
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["img"]["name"]);

        if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) {
            // The file has been uploaded, insert the data into the database
            $insert_sql = "INSERT INTO airline (airline_name, logo) VALUES ('$airlineName', '$targetFile')";

            if (mysqli_query($con, $insert_sql)) {
                //$errorMessage =  "New record created successfully";
            } else {
               // $errorMessage =  "Error: " . $insert_sql . "<br>" . mysqli_error($con);
            }
        } else {
            //$errorMessage =  "Sorry, there was an error uploading your image.";
        }
    }
}

if (isset($_POST["update"])) {
    // Get the values from the form
    $airlineId = $_POST["airline_id"];
    $airlineName = $_POST["airline_name"];

    // Check if the new airline name is not already in the database
    $existing_airline = mysqli_query($con, "SELECT * FROM airline WHERE airline_name = '$airlineName' AND airline_id <> $airlineId");
    if (mysqli_num_rows($existing_airline) > 0) {
        $errorMessage="Error: An airline with the same name already exists.";
    } else {
        // Update data in the database
        $update_sql = "UPDATE airline SET airline_name='$airlineName' WHERE airline_id=$airlineId";

        if (mysqli_query($con, $update_sql)) {
            if (!empty($_FILES["img"]["name"])) {
                $targetDirectory = "uploads/";
                $targetFile = $targetDirectory . basename($_FILES["img"]["name"]);
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) {
                    $update_image_sql = "UPDATE airline SET logo='$targetFile' WHERE airline_id=$airlineId";

                    if (mysqli_query($con, $update_image_sql)) {
                        header('Location: ' . $_SERVER['PHP_SELF']);
                    } else {
                        //echo "Error updating image path: " . mysqli_error($con);
                    }
                } else {
                    //echo "Sorry, there was an error uploading your image.";
                }
            } else {
                // If no new image is provided, still allow the update to proceed
                header('Location: ' . $_SERVER['PHP_SELF']);
            }
        } else {
            // echo "Error updating record: " . mysqli_error($con);
        }
    }
}


if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    $update_status_sql = "UPDATE airline SET status=$status WHERE airline_id=$id";

    if (mysqli_query($con, $update_status_sql)) {
        //echo "Status updated successfully";
    } else {
       // echo "Error updating status: " . mysqli_error($con);
    }
}
?>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
        .heading {
            text-align: center;
            margin-top: 20px;
            color: #333;
            font-size: 50px;
            font-weight: 600;
            background-image: radial-gradient(#553c9a, #ee4b2b);;
            color: transparent;
            background-clip: text;
            -webkit-background-clip: text;
        }
        h2{
            text-align: center;
            margin-top: 20px;
            
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 30px;
            margin-left: 130px;
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #003366;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ccebff;
        }

        img {
            max-width: 80px;
            max-height: 80px;
            border-radius: 5px;
        }

        input[type="text"], input[type="file"], input[type="submit"] {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }

        span {
            display: block;
            margin-top: 5px;
            font-size: 14px;
            color: red;
        }

        button {
            padding: 10px 20px;
            background-color: #003366;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-top: 15px;
        }

        button:hover {
            background-color: #0044cc;
        }

        .form-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9;
            background-color: #ffffff;
            max-width: 500px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-popup button {
            background-color: #003366;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        .form-popup button:hover {
            background-color: #0044cc;
        }

        .close-icon {
            float: right;
            cursor: pointer;
            color: #aaaaaa;
        }

        .close-icon:hover {
            color: #000000;
        }

        .form-popup h2 {
            margin-bottom: 20px;
            color: #333333;
        }

        .form-container {
            text-align: left;
        }
        .card {
            width: 300px;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ff8080;
            background-color: #ffe6e6;
            position: relative;
        }

        .close-icon {
            float: right;
            cursor: pointer;
            color: #000000;
            padding: 5px;
            background-color: #f2f2f2;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            text-align: center;
            line-height: 20px;
        }

        .close-icon:hover {
            color: red;
        }
        input[type="text"]#searchInput {
            width: 30%;
            padding: 12px 20px;
            margin: 8px 0;
            margin-left: 10%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button#searchButton {
            background-color: #003366;
            color: white;
            padding: 10px 15px;
            margin: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button#searchButton:hover {
            background-color: #0044cc;
        }
        .add_air {
            text-align: right;
            margin-left: 37%;
        }

        .add_airline {
            padding: 12px 20px;
            background-color: #003366;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .add_airline:hover {
            background-color: #0044cc;
        }
        .status-button-disabled {
        background-color: #ccc; /* Change the color to a desired disabled state color */
        color: #888; /* Change the text color to a lighter color */
        }
        #editForm {
        /* Add your custom styles here */
        border: 2px solid #003366;
        padding: 30px;
        width: 400px;
        position: fixed;
        top: 50%;
        left: 60%;
        transform: translate(-50%, -50%);
        background-color: #f2f2f2;
        z-index: 1;
    }
    #addForm {
        /* Add your custom styles here */
        border: 2px solid #003366;
        padding: 30px;
        width: 400px;
        position: fixed;
        top: 50%;
        left: 60%;
        transform: translate(-50%, -50%);
        background-color: #f2f2f2;
        z-index: 1;
    }
    input[type="submit"] {
        /* Add your custom styles here */
        background-color: #003366;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
        /* Add your custom styles here */
        background-color: #0044cc;
    }
    </style>
</head>
<body >


<div class="form-popup" id="addForm" style="display: none;">
        <form method="post" action="#" enctype="multipart/form-data" onsubmit="return validateAddForm()">
        <span class="close-icon" onclick="closeAddForm()">&times;</span>
        <br>
        
        <h2>Add Airline</h2><br>
            Airline Name: <input type="text" name="airline_name" id="airline_name" required onclick="validateFor('add')">
            <span id="airlineNameError" style="color: red; display: none;"></span>
            <br><br>
            
            Airline Logo:
            <input type="file" name="img" accept="image/*" id="img" onchange="previewImage()" required>
            <br><br>
            <img src="#" id="preview" style="display:none; max-width:300px; max-height:300px;" alt="Image Preview">
            <br>
            <input type="submit" class="ad" name="submit" value="Add">
            
        </form>
    </div>


<br>

<?php
if (isset($errorMessage) && !empty($errorMessage)) {
        echo "<div class='card'>";
        echo $errorMessage;
        echo "<span class='close-icon' onclick='this.parentElement.style.display=\"none\";'>&times;</span>";
        echo "</div>";
    }
    ?>

<h2 class="heading" >Airline List</h2>
<div style="display: flex;">
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for Airline name...">
        <button id="searchButton" onclick="searchTable()">
            <i class="fas fa-search"></i>
        </button>
        <div class="add_air">
<button class="add_airline" onclick="toggleAddForm()">+ Add Airline</button>

</div>

</div>


<table border="1">
    <tr>
        <th>SI No</th>
        <th>Airline Name</th>
        <th>Airline Logo</th>
        <th>Edit</th>
        <th>Disable/Enable</th>
    </tr>

    <?php
    $result = mysqli_query($con, "SELECT * FROM airline");
    $counter = 1;
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $counter . "</td>";
        echo "<td>" . $row['airline_name'] . "</td>";
        echo "<td><img src='" . $row['logo'] . "' style='max-width:100px; max-height:100px;' alt='Airline Logo'></td>";
        if ($row["status"] == 1) {
            echo "<td><button class='edit-button' onclick='openEditForm(" . $row['airline_id'] . ", \"" . $row['airline_name'] . "\", \"" . $row['logo'] . "\", \"" . $row['status'] . "\")'>Edit</button></td>";
        } else {
            echo "<td><button class='edit-button status-button-disabled' disabled>Edit</button></td>";
        }
        
        echo "<td>";
        if ($row["status"] == 1) {
            echo "<button onclick='changeStatus(" . $row["airline_id"] . ", 0, event)' class='status-button status-button-enabled'>Enabled</button>";
        } else {
            echo "<button onclick='changeStatus(" . $row["airline_id"] . ", 1, event)' class='status-button status-button-disabled'>Disabled</button>";
        }
        echo "</td>";
        
        echo "</td>";
                echo "</tr>";
                $counter++;
            }
    ?>


</table><br><br>





<div class="form-popup" id="editForm">
        <form method="post" class="form-container" enctype="multipart/form-data" onsubmit="return validateEditForm()">
        <span class="close-icon" onclick="closeEditForm()">&times;</span>
                <br>
            <h2>Edit Airlines</h2>
            <input type="hidden" id="airline_id" name="airline_id" value="">
           
            Airline Name: <input type="text" id="edit_airline_name" name="airline_name" required onclick="validateFor('edit')">
            <span id="airlineNameError" style="color: red; display: none;"></span>

            <br><br>
            Airline Logo: <input type="file" name="img" accept="image/*" id="editImg" onchange="previewEditImage()" >
            <br><br>
            <img src="#" id="editPreview" style="display:none; max-width:300px; max-height:300px;" alt="Image Preview">
            <br>
            <input type="submit" class="up" name="update" value="Update">
        </form>
    </div>







</body>
<script>
    function toggleAddForm() {
        var addForm = document.getElementById("addForm");
        if (addForm.style.display === "none") {
            addForm.style.display = "block";
        } else {
            addForm.style.display = "none";
        }
    }

    function previewImage() {
        var preview = document.querySelector('#preview');
        var file = document.querySelector('#img').files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
            preview.style.display = "block";
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    function openEditForm(id, name, logo, status) {
        if (status === "0") {
            alert("Cannot edit a disabled airline.");
            return;
        }
        document.getElementById("editForm").style.display = "block";
        document.getElementById("airline_id").value = id;
        document.getElementById("edit_airline_name").value = name;

        var imgPreview = document.getElementById("editPreview");
        imgPreview.src = logo;
        imgPreview.style.display = "block";

        // Set the value of the image input field to the existing image path
        var imgInput = document.getElementById("editImg");
        imgInput.value = ""; // Clear the previous value
        imgInput.setAttribute("data-old-value", logo);
}
        
        function previewEditImage() {
            var preview = document.querySelector('#editPreview');
            var file = document.querySelector('#editImg').files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = "block";
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
        function closeAddForm() {
            document.getElementById("addForm").style.display = "none";
    }
    function closeEditForm() {
    document.getElementById("editForm").style.display = "none";
    }
    window.onclick = function(event) {
        var addForm = document.getElementById("addForm");
        var editForm = document.getElementById("editForm");
        if (event.target == addForm) {
            addForm.style.display = "none";
        }
        if (event.target == editForm) {
            editForm.style.display = "none";
        }
    }

   


    function changeStatus(id, status, event) {
        event.preventDefault(); // Prevent the form submission
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                location.reload(); // Reload the page to reflect the updated status
            }
        };

        // Replace 'your_php_script_name.php' with the actual script name
        xhttp.open("GET", 'airline.php?id=' + id + '&status=' + status, true);
        xhttp.send();

    }

            // Add an event listener for form submission
        document.querySelector('#addForm form').addEventListener('submit', function (event) {
            if (!validateAddForm()) {
                event.preventDefault(); // Prevent form submission if there are errors
            }
        });

        // Add an event listener for form submission in the edit form
        document.querySelector('#editForm form').addEventListener('submit', function (event) {
            if (!validateEditForm()) {
                event.preventDefault(); // Prevent form submission if there are errors
            }
        });

        // Update the validation functions to return a boolean value
        function validateAddForm() {
        var formPrefix = '';
        var airlineName = document.getElementById(formPrefix + 'airline_name').value;
        var letters = /^[A-Za-z]+( [A-Za-z]+)*$/;
        var errorElement = document.getElementById('airlineNameError');

        if (!airlineName.match(letters)) {
            errorElement.textContent = 'Error: Airline name should start with a letter and contain letters with at most one space between them.';
            errorElement.style.display = 'block';
            return false;
        } else {
            errorElement.style.display = 'none';
        }

        return true;
    }

    function validateEditForm() {
        var formPrefix = 'edit_';
        var airlineName = document.getElementById(formPrefix + 'airline_name').value;
        var letters = /^[A-Za-z]+( [A-Za-z]+)*$/;
        var errorElement = document.getElementById('airlineNameError');

        if (!airlineName.match(letters)) {
            errorElement.textContent = ' Airline name should start with a letter ';
            errorElement.style.display = 'block';
            return false;
        } else {
            errorElement.style.display = 'none';
        }

        return true;
    }
    function searchTable() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.querySelector("table");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those that don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1]; // Use index 1 to target the Airline Name column
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

}


</script>
</html>
