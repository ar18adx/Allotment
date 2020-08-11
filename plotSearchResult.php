<?php $pageTitle = "Search Results (Plots)";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
confirmAdminLogin(); 

?>

<?php 
$adminSiteName = $_SESSION["adminSiteName"];

?>

<!-- Admin Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- Admin Header End -->

            <div class="container"> 
                <div class="text-center mb-4 mt-4">
                    <?php if($_SESSION["adminRole"] == "Super_Admin" ){ ?>
                        <h2>Plots (All Sites)</h2>
                    <?php }elseif($_SESSION["adminRole"] == "Site_Manager" ){ ?>
                        <h2>Plots (<?php echo htmlentities($adminSiteName)?>)</h2>
                    <?php }?>
                </div>
                <div class="row">
                    <!-- Include Admin Sidebar -->
                    <?php include("inc/adminSidebar.php");?>
                    <!-- Include Admin Sidebar -->   
                    <div class="col-md-9">
                            <!-- Plot search form Start -->
                            <?php include("plotSearchForm.php");?>
                            <!-- Plot search form End -->
                            <div class="text-center mb-4">
                                <h5><?php TotalPlotSearchResults()?> Result(s)</h5>
                            </div>
                        <div class="row">    
                            <?php 
                                global $ConnectingDB;
                                // SQL query when Search button is active
                                if(isset($_GET["SearchPlot"])){
                                    $plotNumberSearch = $_GET["PlotNumberSh"];
                                }
                                $sql ="SELECT * FROM plots WHERE plotNumber = '$plotNumberSearch' ";
                                $stmt = $ConnectingDB->query($sql);
                               
                                while ($DataRows = $stmt->fetch()) {
                                    $id                     = $DataRows["id"];
                                    $plotNumber                     = $DataRows["plotNumber"];
                                    $plotSize                     = $DataRows["plotSize"];
                                    $plotDescription                     = $DataRows["plotDescription"];
                                    $plotStatus                    = $DataRows["plotStatus"];
                                    $addedBy                     = $DataRows["addedBy"];
        
                            ?>
                            <div class="col-sm-8 mb-4">
                                <div class="card text-white bg-dark">
                                <div class="card-body">
                                    <h2 class="card-title"><?php echo htmlentities($plotNumber)?></h2>
                                    <h5 class="card-text"><b>Plot Size : </b><?php echo htmlentities($plotSize)?> </h5>
                                    <h5 class="card-text"><b>Plot Description : </b><?php echo htmlentities($plotDescription)?> </h5>
                                    <h5 class="card-text"><b>Plot Status : </b><?php echo htmlentities($plotStatus)?> </h5>
                                    <h5 class="card-text"><b>Added By:</b> <?php echo htmlentities($addedBy)?> </h5>
                                        
                                    <h5 class="card-text"><?php ?> </h5>
                                    
                                </div>
                                </div>
                            </div>
                            <?php }?>
                        </div>

                                    
                    </div>
                </div>           
            </div>
 


<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->