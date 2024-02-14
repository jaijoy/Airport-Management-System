
<!-- Featured Flights Section -->
<div class="container featured-flights">
    <h2 class="text-center mb-4">Featured Airlines</h2>
    <div class="row">
        <?php
        // Fetch featured flights from the database
        $featuredFlightsQuery = "SELECT * FROM airline WHERE `status` = 1";
        $featuredFlightsResult = mysqli_query($con, $featuredFlightsQuery);

        if (!$featuredFlightsResult) {
            die("Error in SQL query: " . mysqli_error($con));
        }

        while ($row = mysqli_fetch_assoc($featuredFlightsResult)) {
            ?>
            <!-- Featured Flight Cards -->
            <div class="col-md-4 mb-4">
                <div class="card flight-card">
                    <?php
                    // define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
                    $logoPath = '../admin/' . $row['logo'];

                    // $logoPath ="../admin/uploads/air_india.png";

                    // echo 'Logo Path: ' . $logoPath . '<br>';  // Debugging line
                    
                   
                    
                    if (file_exists($logoPath)) {
                        ?>
                        <img src="<?php echo $logoPath; ?>" class="card-img-top" alt="<?php echo $row['airline_name']; ?>">
                        <?php
                    } else {
                        echo '<p>Error: Logo not found</p>';
                    }
                    ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['airline_name']; ?></h5>
                        <p class="card-text"><?php echo $row['airline_name']; ?> Airlines,your gateway to unparalleled travel experiences. We take pride in providing top-notch service, ensuring your journey is not just a flight but a memorable adventure. With a fleet of modern aircraft and a commitment to safety, comfort, and efficiency, we aim to make every trip with us an extraordinary voyage.

Our dedicated crew is here to cater to your needs, and our diverse range of destinations ensures you can explore the world with convenience. Whether you're a business traveler or a leisure explorer, <?php echo $row['airline_name']; ?> is your reliable partner in the skies.

Experience the joy of flying with <?php echo $row['airline_name']; ?> Airlines, where every flight is a step closer to a new adventure.</p>
                        <a href="#" class="btn btn-primary">Book Now</a>
                    </div>
                </div>
            </div>
            <?php
        }

        // Free the result set
        mysqli_free_result($featuredFlightsResult);
    ?>
    </div>
</div>
