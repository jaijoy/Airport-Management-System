<?php
include "../config/dbcon.php";
include("includes/base.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Airline Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .list-group-item {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="container">
    <ul class="list-group">
        <?php
        $sql = "SELECT `airline_id`, `airline_name`, `airline_type`, `logo`, `status` FROM `airline`";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="' . $row["logo"] . '" alt="' . $row["airline_name"] . '" style="width:64px;height:64px;">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">' . $row["airline_name"] . '</h4>
                            <p>' . $row["status"] . '</p>
                            <a href="flights.php?id=' . $row["airline_id"] . '" class="btn btn-primary">Add Details</a>
                        </div>
                    </div>
                </li>';
            }
        } else {
            echo "0 results";
        }
        $con->close();
        ?>
    </ul>
</div>

</body>
</html>
