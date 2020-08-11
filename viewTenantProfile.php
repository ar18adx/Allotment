<?php $pageTitle = "View Tenant Profile";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
confirmAdminLogin(); 

////////////////////////////////////////

                    $adminSiteName = $_SESSION["adminSiteName"];

                    $profileQueryParameter = $_GET["tenantId"];
                    global $ConnectingDB;

                    if($_SESSION["adminRole"] == "Super_Admin" ){ 
                        $sql ="SELECT * FROM tenants WHERE tenantId='$profileQueryParameter' ";
                    }elseif($_SESSION["adminRole"] == "Site_Manager" ){
                        $sql ="SELECT * FROM tenants WHERE tenantId='$profileQueryParameter' AND siteCity = '$adminSiteName' ";
                    }

                    $stmt = $ConnectingDB->query($sql);
                    $DataRows = $stmt->fetch();
                    $id                     = $DataRows["id"];
                    $tenantId                = $DataRows["tenantId"];
                    $tenantFirstName          = $DataRows["tenantFirstName"];
                    $tenantLastName          = $DataRows["tenantLastName"];
                    $tenantEmailAddress	          = $DataRows["tenantEmailAddress"];
                    $tenantPhoneNum          = $DataRows["tenantPhoneNum"];
                    $tenantCity           = $DataRows["tenantCity"];
                    $siteCity          = $DataRows["siteCity"];
                    $siteId          = $DataRows["siteId"];
                    $plotNumber          = $DataRows["plotNumber"];
                    $leaseDate          = $DataRows["leaseDate"];
                    $expirationDate          = $DataRows["expirationDate"];
                    $renewalStatus          = $DataRows["renewalStatus"];
                    $tenantFullName = $tenantFirstName." ".$tenantLastName;
                
                    $changeLeaseDateFormat       = date("F-d-Y", strtotime($leaseDate));
                    $changeExpDateFormat       = date("F-d-Y", strtotime($expirationDate));

?>

    <?php

    if($_SESSION["adminRole"] == "Super_Admin" && !isset($tenantId)){ 
        Redirect_to("errorPage.php");
        
    }

    if($_SESSION["adminRole"] == "Site_Manager" && $siteCity != $adminSiteName ){ 
        Redirect_to("errorPage.php");
        
    }

    ?>
        <!-- Admin Header Start -->
        <?php include("inc/adminHeader.php"); ?>
        <!-- Admin Header End -->

            <div class="container"> 

                <div class="row mt-5">
                    <!-- Include Admin Sidebar -->
                    <?php include("inc/adminSidebar.php");?>
                    <!-- Include Admin Sidebar -->    
                    <div class="col-md-9">
                        
                            <div class="mb-4 text-center">
                                <h1>Tenant Profile</h1>
                            </div>
                                
                            <div class="col-md-12 mb-4">
                                <div class="card text-white bg-dark">
                                <div class="card-body">
                                    <h3 class="card-title"><b>Tenant name : </b> <?php echo htmlentities($tenantFullName)?></h3>
                                    <h5 class="card-text"><b>Email Address : </b> <?php echo htmlentities($tenantEmailAddress)?></h5>
                                    <h5 class="card-text"><b>Phone Number :</b> <?php echo htmlentities($tenantPhoneNum)?></h5>
                                    <h5 class="card-text"><b>Tenant City : </b> <?php echo htmlentities($tenantCity)?></h5>
                                    <h5 class="card-text"><b>Site City :</b> <?php echo htmlentities($siteCity)?></h5> 
                                    <h3 class="card-text"><b>Plot Number :</b> <?php echo htmlentities($plotNumber)?></h3> 
                                    <h5 class="card-text"><b>Lease Date :</b> <?php echo htmlentities($changeLeaseDateFormat)?></h5>
                                    <h5 class="card-text"><b>Expiration Date :</b> <?php echo htmlentities($changeExpDateFormat)?></h5>
                                    <h5 class="card-text mt-3"><a class="btn btn-warning" href="adminSendMsg.php?tenantId=<?php echo $tenantId?>" role="button">Send Message</a></h5>
                                    
                                </div>
                                </div>
                                </a> 
                            </div>
                    
                        
                    </div>
                </div>
                
                
            </div>


        <!-- Admin Footer Start -->
        <?php include("inc/adminFooter.php"); ?>
        <!-- Admin Footer End -->


