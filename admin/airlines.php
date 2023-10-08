<?php
include("includes/base.php");
?>
<head>
         <header class="header">
                <div class="user-profile">
                    
                </div>
                <a href="logout.php" class="logout-btn">Logout</a>
            </header>
            
            <!-- Content Area -->
            <div class="content">




                <!-- Your content goes here -->

    <style>
                        /* Your existing CSS styles here */
                        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 43px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="file"] {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
 </head>
 <body>
                    <h1>Airline Form</h1>
                    <form action="../functions/f_airline.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <label for="airlineName">Airline Name:</label>
                        <input type="text" id="airlineName" name="airlineName" required minlength="3">
                        
                        <label for="airlineImage">Airline Image:</label>
                        <input type="file" id="airlineImage" name="img" accept="image/*" required>
                        
                        <input type="submit" value="Add Airline" name="abtn">
                    </form>

                    <script>
                        function validateForm() {
                            var airlineName = document.getElementById("airlineName").value;
                            var airlineImage = document.getElementById("airlineImage").value;
                            
                            if (airlineName.length < 3) {
                                alert("Airline Name must be at least 3 characters.");
                                return false;
                            }

                            // Check if an image is selected
                            if (airlineImage === "") {
                                alert("Please select an image for the airline.");
                                return false;
                            }

                            return true; // Form is valid and can be submitted
                        }
                    </script>


            </div>
                
        </main>
        </div>
    </body>
    </html>


    