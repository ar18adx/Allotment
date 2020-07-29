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

    // global $ConnectingDB;
    // $sql ="SELECT * FROM waitinglist";
    // $stmt = $ConnectingDB->query($sql);
    // $DataRows=$stmt->fetch();
    // $id1                     = $DataRows["id"];
    // // $userIdRow                     = $DataRows["userId"];
    // $firstName1         = $DataRows["firstName"];
    // $lastName1          = $DataRows["lastName"];
    // $emailAddress1	          = $DataRows["emailAddress"];
    // $telephoneNumber1          = $DataRows["telephoneNumber"];
    // $userCity1          = $DataRows["userCity"];
    // $siteIdNum1           = $DataRows["siteIdNum"];
    // $siteCity1          = $DataRows["siteCity"];
    // $plotIdNum1          = $DataRows["plotIdNum"];
    // $plotNumberApp1          = $DataRows["plotNumberApp"];
    // $offerCount1          = $DataRows["offerCount"];
    // $dateApplied1        =   $DataRows["dateApplied"];
    // $todayDate1          = date("2020-08-15") ;

    // $daysCountFourteen1         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateApplied1)). " + 14 day "));
    
    // $sql13 = "DELETE FROM waitinglist WHERE offerCount1 > 1 AND '$todayDate1' >= '$daysCountFourteen1' ";
    // $stmt13 = $ConnectingDB->prepare($sql13);
    // $Execute13=$stmt13->execute();



?>


<!-- Admin Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- Admin Header End -->

    <div class="container"> 
    
        <h1 class="mb-5">Hello, <?php echo $_SESSION["adminFirstName"]." ".$_SESSION["adminLastName"] ;?></h1>
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

                <!-- <div class="row">
                    <div class="col-sm-3">
                        <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card text-white bg-dark">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        
        
    </div>

<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->