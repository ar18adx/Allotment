<?php $pageTitle = "Sites";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
confirmAdminLogin(); 

?>

<?php if($_SESSION["adminRole"] == "Super_Admin"){?>

    <!-- Admin Header Start -->
    <?php include("inc/adminHeader.php"); ?>
    <!-- Admin Header End -->

        <div class="container"> 

            <div class="row mt-5">
                <!-- Include Admin Sidebar -->
                <?php include("inc/adminSidebar.php");?>
                <!-- Include Admin Sidebar -->    
                <div class="col-md-9">
                    
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a class="btn btn-success" href="addCity.php" role="button">Add New Site</a>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-danger" href="deleteExistingSite.php" role="button">Delete Existing Site</a>
                            </div>       
                        </div>
                        <div class="mb-4 text-center">
                            <h1>Sites</h1>
                        </div>
                    <div class="row">
                        <?php
                            if (isset($_GET["page"])) {
                                global $ConnectingDB;
                                $sql = "SELECT * FROM cities ";
                                $stmt = $ConnectingDB->prepare($sql);
                                $stmt->execute();
                                $Page = $_GET["page"];
                                if($Page==0||$Page<1){
                                $ShowPostFrom=0;
                            }else{
                                $ShowPostFrom=($Page*6)-6;
                            }
                                $sql = "SELECT * FROM cities ORDER BY id LIMIT $ShowPostFrom,6";
                                $stmt=$ConnectingDB->query($sql);
                            }

                            // The default SQL query
                            else{
                                $sql  = "SELECT * FROM cities ORDER BY id LIMIT $ShowPostFrom,6";
                                $stmt =$ConnectingDB->query($sql);
                            }
                        
                            while ($DataRows = $stmt->fetch()) {
                            $id                     = $DataRows["id"];
                            $cityName                     = $DataRows["cityName"];
                            $cityShortCode                     = $DataRows["cityShortCode"];
                            
                            $sqlCt ="SELECT * FROM plots WHERE plotSite ='$cityName'";
                            $stmtCt = $ConnectingDB->prepare($sqlCt);
                            $stmtCt->execute();
                            $ResultCt = $stmtCt->rowcount();

                            $sqlVc ="SELECT * FROM plots WHERE plotSite = '$cityName' AND plotStatus ='Vacant'";
                            $stmtVc = $ConnectingDB->prepare($sqlVc);
                            $stmtVc->execute();
                            $ResultVc = $stmtVc->rowcount();

                            $sqlTc ="SELECT * FROM tenants WHERE siteCity = '$cityName' ";
                            $stmtTc = $ConnectingDB->prepare($sqlTc);
                            $stmtTc->execute();
                            $ResultTc = $stmtTc->rowcount();

                            $sqlWl ="SELECT * FROM waitinglist WHERE siteCity = '$cityName' ";
                            $stmtWl = $ConnectingDB->prepare($sqlWl);
                            $stmtWl->execute();
                            $ResultWl = $stmtWl->rowcount();
                                    
                                
                            ?>
                        <div class="col-sm-6 mb-4">
                            <a class="bg-dark text-white" href="siteDetails.php?page=1&cityName=<?php echo $cityName; ?>">
                            <div class="card text-white bg-dark">
                            <div class="card-body">
                                <h2 class="card-title"><?php echo htmlentities($cityName." (".$cityShortCode).")";?></h2>
                                <h4 class="card-text"><?php echo htmlentities($ResultCt); ?> Total <?php if($ResultCt <=1){echo "Plot";}elseif($ResultCt >1){echo "Plots";}?> </h4>
                                <h5 class="card-text"><?php echo htmlentities($ResultTc); ?> <?php if($ResultTc <=1){echo "Tenant";}elseif($ResultTc >1){echo "Tenants";}?></h5>
                                <h5 class="card-text"><?php echo htmlentities($ResultVc); ?> Vacant <?php if($ResultVc <=1){echo "Plot";}elseif($ResultVc >1){echo "Plots";}?> </h5>
                                <h5 class="card-text"><?php echo htmlentities($ResultWl); ?> <?php if($ResultWl <=1){echo "Plot";}elseif($ResultWl >1){echo "Plots";}?> <?php if($ResultWl <=1){echo "is";}elseif($ResultWl >1){echo "are";}?> on the Waiting List</h5> 
                            </div>
                            </div>
                            </a> 
                        </div>
                        <?php }?>
                    </div>
                    <!-- Pagination -->
                    <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 mt-4">
                        <nav>
                            <ul class="pagination pagination-lg">
                                    <!-- Creating Backward Button -->
                                    <?php if( isset($Page) ) {
                                    if ( $Page>1 ) {?>
                                <li class="page-item">
                                    <a class="page-link text-dark" href="viewSites.php?page=<?php  echo $Page-1; ?>">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                    <?php } }?>
                                    <?php
                                    global $ConnectingDB;
                                    $sql           = "SELECT COUNT(*) FROM cities";
                                    $stmt          = $ConnectingDB->query($sql);
                                    $RowPagination = $stmt->fetch();
                                    $TotalPosts    = array_shift($RowPagination);
                                    // echo $TotalPosts."<br>";
                                    $PostPagination=$TotalPosts/6;
                                    $PostPagination=ceil($PostPagination);
                                    // echo $PostPagination;
                                    for ($i=1; $i <=$PostPagination ; $i++) {
                                    if( isset($Page) ){
                                        if ($i == $Page) { ?>
                                <li class="page-item active">
                                    <a class="page-link bg-dark" href="viewSites.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                </li>
                                    <?php
                                    }else {
                                    ?>
                                <li class="page-item">
                                    <a class="page-link" href="viewSites.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                </li>
                                    <?php  }
                                    } } ?>
                                
                                    <!-- Creating Forward Button -->
                                    <?php if ( isset($Page) && !empty($Page) ) {
                                        if ($Page+1 <= $PostPagination) {?>
                                <li class="page-item">
                                    <a class="page-link bg-dark text-white" href="viewSites.php?page=<?php  echo $Page+1; ?>">
                                    <span aria-hidden="true">&raquo;</span>
                                    </a> 
                                </li>
                                    <?php } }?>
                            </ul>
                        </nav>
                    </div>
                    <!-- Pagination Ends -->
                </div>
            </div>
            
            
        </div>


    <!-- Admin Footer Start -->
    <?php include("inc/adminFooter.php"); ?>
    <!-- Admin Footer End -->

<?php 
}else{
    Redirect_to("errorPage.php");
} 

?>