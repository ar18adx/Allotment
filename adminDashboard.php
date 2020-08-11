<?php $pageTitle = "Dashboard";?>


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
            <div class="mb-4">
                <h1>Hello, <?php echo $_SESSION["adminFirstName"]." ".$_SESSION["adminLastName"] ;?></h1>
                <?php if($_SESSION["adminRole"] == 'Super_Admin'){ ?>
                    <h5>Allotment Officer</h5>
                <?php }elseif($_SESSION["adminRole"] == 'Site_Manager'){ ?>
                    <h5>Site Manager, <?php echo htmlentities($_SESSION["adminSiteName"])?></h5>
                <?php }?>
            </div>
        <div class="row">
            <!-- Include Admin Sidebar -->
            <?php include("inc/adminSidebar.php");?>
            <!-- Include Admin Sidebar -->    
            <div class="col-md-9">
                <div class="row">
                    <?php if($_SESSION["adminRole"] == "Super_Admin"){?>
                    <div class="col-sm-4 mb-4">
                        <a href="viewSites.php?page=1">
                            <div class="card text-white bg-info">
                            <div class="card-body">
                                <h3 class="card-title"><?php TotalSitesAdded()?> Sites</h3>
                                <p class="card-text">Total number of Sites </p>
                            </div>
                            </div>
                        </a>
                    </div>
                    <?php }?>
                    
                    <?php if($_SESSION["adminRole"] == "Super_Admin"){?>
                    <div class="col-sm-4">
                        <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <h3 class="card-title"><?php TotalPlotsAdded()?> Plots</h3>
                            <p class="card-text">Total number of Plots</p>
                        </div>
                        </div>
                    </div>
                    <?php }elseif($_SESSION["adminRole"] == "Site_Manager"){?>
                    <div class="col-sm-4">
                        <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <h3 class="card-title"><?php TotalPlotsSm()?> Plots</h3>
                            <p class="card-text">Total number of Plots</p>
                        </div>
                        </div>
                    </div>
                    <?php }?>
                    
                    <?php if($_SESSION["adminRole"] == "Super_Admin"){?>
                    <div class="col-sm-4">
                        <div class="card text-white bg-success">
                        <div class="card-body">
                            <h3 class="card-title"><?php TotalTenants()?> Tenants</h3>
                            <p class="card-text">Total number of Tenants</p>
                        </div>
                        </div>
                    </div>
                    <?php }elseif($_SESSION["adminRole"] == "Site_Manager"){?>
                    <div class="col-sm-4">
                        <div class="card text-white bg-success">
                        <div class="card-body">
                            <h3 class="card-title"><?php TotalTenantsSm()?> Tenant(s)</h3>
                            <p class="card-text">Total number of Tenants</p>
                        </div>
                        </div>
                    </div>
                    <?php }?>

                    <?php if($_SESSION["adminRole"] == "Super_Admin"){?>
                    <div class="col-sm-4">
                        <div class="card text-white text-white bg-warning">
                        <div class="card-body">
                            <h3 class="card-title"><?php TotalWaitingListNum()?> User(s) are on the waiting list</h3>
                            <p class="card-text">Number of users on waiting list</p>
                            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                        </div>
                        </div>
                    </div>
                    <?php }elseif($_SESSION["adminRole"] == "Site_Manager"){?>
                    <div class="col-sm-4">
                        <div class="card text-white text-white bg-warning">
                        <div class="card-body">
                            <h3 class="card-title"><?php TotalWaitingListSm()?> User(s) are on the waiting list</h3>
                            <p class="card-text">Number of users on waiting list</p>
                            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                        </div>
                        </div>
                    </div>
                    <?php }?>
                    <?php if($_SESSION["adminRole"] == "Super_Admin"){?>
                    <div class="col-sm-4">
                        <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h3 class="card-title"><?php SoonToBeExpLease()?> Tenant's lease will expire soon</h3>
                            <p class="card-text"></p>
                        </div>
                        </div>
                    </div>
                    <?php }elseif($_SESSION["adminRole"] == "Site_Manager"){?>
                    <div class="col-sm-4">
                        <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h3 class="card-title"><?php SoonToBeExpLeaseSm()?> Tenant's lease will expire soon</h3>
                            <p class="card-text"></p>
                        </div>
                        </div>
                    </div>
                    <?php }?>
                    <?php if($_SESSION["adminRole"] == "Super_Admin"){?>
                    <div class="col-sm-4">
                        <div class="card text-white bg-info">
                        <div class="card-body">
                            <h3 class="card-title"><?php TotalSiteManager() ?> Site Manager(s)</h3>
                            <p class="card-text"></p>
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