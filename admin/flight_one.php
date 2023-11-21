<?php
include "../config/dbcon.php";
include("includes/base.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Airline Data</title>
    <style>
        .list-group {
            list-style: none;
            padding: 0;
        }

        .list-group-item {
            width: 50%;
            margin: 0 auto;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 10px;
            display: flex;
            align-items: center;
        }

        .media {
            display: flex;
            align-items: center;
        }

        .media-left {
            margin-right: 10px;
        }

        .media-object {
            width: 64px;
            height: 64px;
        }

        .media-body {
            flex: 1;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            touch-action: manipulation;
            cursor: pointer;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .btn-primary {
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #286090;
            border-color: #204d74;
        }
    </style>
</head>
<body>
<br><br>
<div class="container">
    <ul class="list-group">
        <?php
        $sql = "SELECT `airline_id`, `airline_name`, `airline_type`, `logo`, `status` FROM `airline` WHERE `status` = 1";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="' . $row["logo"] . '" alt="' . $row["airline_name"] . '">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">' . $row["airline_name"] . '</h4>
                            <a href="flight_two.php?id=' . $row["airline_id"] . '" class="btn btn-primary">Add Flight</a>
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
