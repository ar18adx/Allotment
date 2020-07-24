<?php $pageTitle = "Close/Open Application";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php 
    
    $adminSiteName = $_SESSION["adminSiteName"];


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
                <div class="text-center mt-5 mb-5">
                    <h1>Close/Open Application</h1>
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
                            <th scope="col">No</th>
                            <th scope="col">City Name</th>
                            <th scope="col">City Short Code</th>
                            <th scope="col">Added By</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Availability Status</th>
                            <th scope="col">Set Status</th>
                            <th scope="col">Status Updated By</th>
                            <th scope="col">Update Time</th>
                            </tr>
                        </thead>
                        <?php 
                        global $ConnectingDB;
                         if($_SESSION["adminRole"] == "Super_Admin" ){ 
                            $sql = "SELECT * FROM cities ORDER BY id DESC";
                         }elseif($_SESSION["adminRole"] == "Site_Manager"){
                            $sql = "SELECT * FROM cities WHERE cityName ='$adminSiteName' ORDER BY id DESC";
                         }
                        $Execute =$ConnectingDB->query($sql);
                        $SrNo = 0;
                        while ($DataRows=$Execute->fetch()) {
                        $id          = $DataRows["id"];
                        $cityName          = $DataRows["cityName"];
                        $cityShortCode           = $DataRows["cityShortCode"];
                        $addedBy      = $DataRows["addedBy"];
                        $datetime      = $DataRows["datetime"];
                        $availabilityStatus      = $DataRows["availabilityStatus"];
                        $asUpdatedBy      = $DataRows["asUpdatedBy"];
                        $updateTime      = $DataRows["updateTime"];
                        
                        $SrNo++;
                        
                        ?>
                        <tbody>
                        
                            <tr>
                            <td><?php echo htmlentities($SrNo)?></td>
                            <td><?php echo htmlentities($cityName)?></td>
                            <td><?php echo htmlentities($cityShortCode)?></td>
                            <td><?php echo htmlentities($addedBy)?></td>
                            <td><?php echo htmlentities($datetime)?></td>
                            <?php if($availabilityStatus =="Open"){?>
                                <td><button class="btn btn-success"><?php echo htmlentities($availabilityStatus)?></button></td>
                            <?php }elseif($availabilityStatus =="Closed"){?>
                                <td><button class="btn btn-danger"><?php echo htmlentities($availabilityStatus)?></button></td> 
                            <?php }?>
                            <?php if($availabilityStatus == "Open"){?>
                                <td><a class="btn btn-danger editConfirmMsg" href="closeApplication.php?id=<?php echo $id?>" role="button">Close Applications</a></td>
                            <?php }elseif($availabilityStatus == "Closed"){?>
                                <td><a class="btn btn-success editConfirmMsg" href="openApplication.php?id=<?php echo $id?>" role="button">Open Applications</a></td>
                            <?php }?>
                            <td><?php echo htmlentities($asUpdatedBy)?></td>
                            <td><?php echo htmlentities($updateTime)?></td>
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

    <script>
         $('.editConfirmMsg').on('click', function () {
        return confirm('Do You want to change the Availability Status for this Site?');
    })
    </script>