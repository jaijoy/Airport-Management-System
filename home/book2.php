<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Optional: Add your custom styles here -->
    <style>
        /* Add your custom styles if needed */
        body {
            padding: 20px;
        }

        .passenger-section {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }

        .assistance-section {
            border: 1px solid #ddd;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Flight Booking Form</h2>
        <form action="process_booking.php" method="post">

            <!-- Passenger 1 Details -->
            <div class="passenger-section">
                <h4>Passenger 1</h4>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fullName1">Full Name:</label>
                        <input type="text" class="form-control" id="fullName1" name="fullName1" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email1">Email:</label>
                        <input type="email" class="form-control" id="email1" name="email1" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="age1">Age:</label>
                        <input type="number" class="form-control" id="age1" name="age1" min="0" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="seatPreference1">Seat Preference:</label>
                        <select class="form-control" id="seatPreference1" name="seatPreference1">
                            <option value="window">Window</option>
                            <option value="aisle">Aisle</option>
                            <option value="middle">Middle</option>
                        </select>
                    </div>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="wheelchairAssistance1" name="wheelchairAssistance1">
                    <label class="form-check-label" for="wheelchairAssistance1">Wheelchair Assistance Needed</label>
                </div>
            </div>

            <!-- Passenger 2 Details -->
            <div class="passenger-section">
                <h4>Passenger 2</h4>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fullName2">Full Name:</label>
                        <input type="text" class="form-control" id="fullName2" name="fullName2" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email2">Email:</label>
                        <input type="email" class="form-control" id="email2" name="email2" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="age2">Age:</label>
                        <input type="number" class="form-control" id="age2" name="age2" min="0" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="seatPreference2">Seat Preference:</label>
                        <select class="form-control" id="seatPreference2" name="seatPreference2">
                            <option value="window">Window</option>
                            <option value="aisle">Aisle</option>
                            <option value="middle">Middle</option>
                        </select>
                    </div>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="wheelchairAssistance2" name="wheelchairAssistance2">
                    <label class="form-check-label" for="wheelchairAssistance2">Wheelchair Assistance Needed</label>
                </div>
            </div>

            <!-- Repeat similar blocks for additional passengers -->

            <!-- Your existing form fields... -->

            <button type="submit" class="btn btn-primary">Proceed-></button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        // Add JavaScript for dynamic functionality if needed
    </script>

</body>

</html>
