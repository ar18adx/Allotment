<?php $pageTitle = "Inspection Report";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

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
                <div class="text-center mt-5 mb-5">
                    <h1>Inspection Reports!</h1>
                </div>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                            <th scope="col">No</th>
                            <th scope="col">PlotNumber</th>
                            <th scope="col">Site Name</th>
                            <th scope="col">Inspection Date</th>
                            <th scope="col">View Details</th>
                            
                            </tr>
                        </thead>
                        <?php 
                        global $ConnectingDB;
                        $sql = "SELECT * FROM inspectionreport ORDER BY id DESC";
                        $Execute =$ConnectingDB->query($sql);
                        $SrNo = 0;
                        while ($DataRows=$Execute->fetch()) {
                        $id          = $DataRows["id"];
                        $plotNumber          = $DataRows["plotNumber"];
                        $siteName           = $DataRows["siteName"];
                        $inspectionDate      = $DataRows["inspectionDate"];
                        
                        $SrNo++;
                        
                        ?>
                        <tbody>
                        
                            <tr>
                            <td><?php echo htmlentities($SrNo)?></td>
                            <td><?php echo htmlentities($plotNumber)?></td>
                            <td><?php echo htmlentities($siteName)?></td>
                            <td><?php echo htmlentities($inspectionDate)?></td>
                            <td><a class="btn btn-dark" href="inspectionDetails.php?id=<?php echo $id?>" role="button">View Details</a></td>
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