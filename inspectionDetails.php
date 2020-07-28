<?php $pageTitle = "Inspection Report";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
confirmAdminLogin(); 

?>

<?php 
    
                    $inspDetParameter = $_GET["id"];
                    global $ConnectingDB;
                    $sql ="SELECT * FROM inspectionreport WHERE id='$inspDetParameter'";
                    $stmt = $ConnectingDB->query($sql);
                    $DataRows = $stmt->fetch();
                    $plotNumber          = $DataRows["plotNumber"];
                    $siteName           = $DataRows["siteName"];
                    $inspectionDate      = $DataRows["inspectionDate"];
                    $inspectionReport      = $DataRows["inspectionReport"];
                    $inspectionOfficer      = $DataRows["inspectionOfficer"];
                    $tenantFirstName      = $DataRows["tenantFirstName"];
                    $tenantLastName       = $DataRows["tenantLastName"];
                    $tenantFullName        = $tenantFirstName." ".$tenantLastName;


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
                    <h1>Inspection Details</h1>
                </div>
                <h3><b>Plot Number :</b> <?php echo htmlentities($plotNumber);?></h3>
                <h3><b>Site Name :</b> <?php echo htmlentities($siteName);?></h3>
                <h3><b>Tenant's Name :</b> <?php echo htmlentities($tenantFullName);?></h3>
                <h3><b>Inspection Officer :</b> <?php echo htmlentities($inspectionOfficer);?></h3>
                <h3><b>Inspection Date : </b> <?php echo htmlentities($inspectionDate);?></h3>
                
                <div class="text-center mt-5 mb-5">
                    <h1>Inspection Evidence</h1>
                        
                    <div id="carouselExampleControls" class="carousel slide mb-5 mt-5" data-ride="carousel">
                        <ol class="carousel-indicators">
                        <div class="carousel-inner">
                                <?php
                                   $inspDetParameter = $_GET["id"];
                                   global $ConnectingDB;
                                   $sql ="SELECT * FROM inspectionreport WHERE id ='$inspDetParameter'";
                                   $stmt = $ConnectingDB->query($sql);
                                   $DataRows = $stmt->fetch();
                                    $id                     = $DataRows["id"];
                                    $evidence        = $DataRows["evidence"];
                                     $evdIM = explode(",", $evidence);
                                     array_pop($evdIM);
                                        foreach ($evdIM as $key => $evidence) {
                                    ?>

                            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $key ?>" class="indicatorClass"></li>
                                        <?php }?>
                        </ol>
                        <div class="carousel-inner">
                                <?php
                                   $inspDetParameter = $_GET["id"];
                                   global $ConnectingDB;
                                   $sql ="SELECT * FROM inspectionreport WHERE id ='$inspDetParameter'";
                                   $stmt = $ConnectingDB->query($sql);
                                   $DataRows = $stmt->fetch();
                                    $id                     = $DataRows["id"];
                                    $evidence        = $DataRows["evidence"];
                                     $evdIM = explode(",", $evidence);
                                     array_pop($evdIM);
                                        foreach ($evdIM as $key => $evidence) {
                                    ?>
                            <div class="carousel-item">
                                <img style="max-height:500px;" src="Uploads/Reports/<?php echo htmlentities($evidence); ?>" class="d-block w-100" alt="...">
                            </div>
                            <?php }?>
                            
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span style="background-color: #92a8d1;" class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span style="background-color: #92a8d1;" class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                    <div class="text-center mt-3 mb-5">
                        <h2>Inspection Report</h2>
                    </div>
                        <div>
                            <p><?php echo htmlentities($inspectionReport);?></p>
                        </div>
               
                
        </div>
        
        
    </div>

    <!-- code for adding a class to the first-child in the carousel -->    
 

<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->

<script type="text/javascript">
    // $('.carousel-indicators > :first-child > :first-child')
    // .addClass("selected");

    // $('.carousel-inner > :first-child')
    // .addClass("active");

    // $('.carousel-indicators > :first-child')
    // .addClass("active");

        const demoClasses = document.querySelectorAll('.carousel-item');
        demoClasses[0].className +=" active";

        const indicatorClasses = document.querySelectorAll('.indicatorClass');
        indicatorClasses[0].className +=" active";
</script>