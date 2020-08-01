<?php $pageTitle = "Delete Site";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
confirmAdminLogin(); 

?>

<?php 


?>


<!-- Admin Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- Admin Header End -->

    <div class="container"> 
    
        
        <div class="row">
            <!-- Include Admin Sidebar -->
            <?php include("inc/adminSidebar.php");?>
            <!-- Include Admin Sidebar -->    
            <div class="col-md-9">
                <div class="col-md-12 mb-3 text-center">
                    <a class="btn btn-success" href="viewSites.php?page=1" role="button">View Sites</a>
                </div>
                <div class="text-center mb-2">
                    <h1>Delete Site</h1>
                </div>
                        <br>
                        <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                        echo WarningMessage();
                        echo ErrorMessageForRg();
                        ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                            <th scope="col">id</th>
                            <th scope="col">City Name</th>
                            <th scope="col">City Short Code</th>
                            <th scope="col">Added By</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Delete Site</th>
                            </tr>
                        </thead>
                        <?php
                            global $ConnectingDB;
                            $sql ="SELECT * FROM cities";
                            $stmt = $ConnectingDB->query($sql);
                            while($DataRows=$stmt->fetch()){;
                            $id      = $DataRows["id"];
                            $cityName      = $DataRows["cityName"];
                            $cityShortCode      = $DataRows["cityShortCode"];
                            $addedBy      = $DataRows["addedBy"];
                            $datetime      = $DataRows["datetime"];

                        ?> 
                        <tbody>
                        
                            <tr>
                            <td><?php echo htmlentities($id)?></td>
                            <td><?php echo htmlentities($cityName)?></td>
                            <td><?php echo htmlentities($cityShortCode)?></td>
                            <td><?php echo htmlentities($addedBy)?></td>
                            <td><?php echo htmlentities($datetime)?></td>
                            <td><a class="btn btn-danger delConfirmMsg" href="deleteSiteFrmTb.php?id=<?php echo $id?>" role="button">Delete Site</a></td>
                            </tr>
                        </tbody>
                        <?php }?>
                    </table>
               
            </div>
        </div>
        
        
    </div>
    
    

<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->

    <!-- Javascript for the delete Site -->
    <script type="text/javascript">
        $('.delConfirmMsg').on('click', function () {
            return confirm('Are You Sure You Want To Delete this Site?');
        })    
    </script>