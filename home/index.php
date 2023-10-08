
<?php
session_start();
include("includes/base.php");
?>

<!--header end-->

<!--successful msg after logged in -->
<?php 
        if(isset($_SESSION['message']))
        {?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Hey!</strong><?=$_SESSION['message'];  ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
         <?php
            unset($_SESSION['message']);
         } ?>


<div class="content">
    <img src="images/front2.jpg" width="100%" height="100%">
</div>



    
    
 
</body>
</html>












