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
        </head>
    <!-- Add your head content here -->

<body>
    <!-- Your dashboard content here -->

    <h2>Airlines List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Airline Name</th>
                <th>Image</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection parameters
            include "../config/dbcon.php";
            // Check for a successful connection
           
            // Query data from the "airlines" table
            $sql = "SELECT id, a_name, a_image FROM airline";
            $result = $con->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Process and display data here
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["a_name"] . "</td>";
                    echo "<td><img src='functions/uploads/" . $row["a_image"] . "' width='100' height='100'></td>";

                    echo "</tr>";
                }
            } else {
                echo "No airlines found.";
            }
            
           
          
            ?>

          
        </tbody>
    </table>
    </main>
</div>
    <!-- Other content for your admin dashboard -->
</body>
</html>

