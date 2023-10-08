<!--database connection db name= -->

<?php
$con = mysqli_connect("localhost","root","","project");

if(!$con){
	echo " db not connected";
}
else{
    echo "connected";
}

?>




