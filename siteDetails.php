<?php $pageTitle = "Site Details";?>

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
                    <div class="mb-4 text-center">
                        <h1>Plots</h1>
                        <a class="btn btn-success" href="addNewPlot.php" role="button">Add New Plot</a>
                        <h2><?php echo htmlentities($_GET["cityName"])?></h2>
                    </div>
                    <div class="row">
                        <?php
                            $siteQueryParameter = $_GET["cityName"];
                            global $ConnectingDB;
                            // $sql ="SELECT * FROM plots WHERE plotsite ='$siteQueryParameter' ORDER BY id ASC";
                            // $stmt = $ConnectingDB->query($sql);
                            if (isset($_GET["page"]) && isset($_GET["cityName"])) {
                                $sql = "SELECT * FROM plots WHERE plotsite ='$siteQueryParameter' ORDER BY id ASC";
                                $stmt = $ConnectingDB->prepare($sql);
                                $stmt->execute();
                                $Page = $_GET["page"];
                                if($Page==0||$Page<1){
                                $ShowPostFrom=0;
                            }else{
                                $ShowPostFrom=($Page*6)-6;
                            }
                                $sql = "SELECT * FROM plots WHERE plotsite ='$siteQueryParameter' ORDER BY id ASC LIMIT $ShowPostFrom,6";
                                $stmt=$ConnectingDB->query($sql);
                            }

                            // The default SQL query
                            else{
                                $sql  = "SELECT * FROM plots WHERE plotsite ='$siteQueryParameter' ORDER BY id ASC LIMIT $ShowPostFrom,6";
                                $stmt =$ConnectingDB->query($sql);
                            }
                            while ($DataRows = $stmt->fetch()) {
                            $id                     = $DataRows["id"];
                            $plotNumber                     = $DataRows["plotNumber"];
                            $plotSize                     = $DataRows["plotSize"];
                            $plotDescription                     = $DataRows["plotDescription"];
                            $plotStatus                    = $DataRows["plotStatus"];
                            $addedBy                     = $DataRows["addedBy"];
                            

                        
                                
                            ?>
                        <div class="col-sm-6 mb-4">
                            <div class="card text-white bg-dark">
                            <div class="card-body">
                                <h2 class="card-title"><?php echo htmlentities($plotNumber)?></h2>
                                <h5 class="card-text"><?php echo htmlentities($plotSize)?> </h5>
                                <h5 class="card-text"><?php echo htmlentities($plotDescription)?> </h5>
                                <h5 class="card-text"><?php echo htmlentities($plotStatus)?> </h5>
                                <h5 class="card-text"><b>Added By:</b> <?php echo htmlentities($addedBy)?> </h5>
                                    
                                <h5 class="card-text"><?php ?> </h5>
                                
                            </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <!-- Pagination -->
                    <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 mt-4">
                        <nav>
                            <ul class="pagination pagination-lg">
                                    <!-- Creating Backward Button -->
                                    <?php if( isset($Page)) {
                                    if ( $Page>1 ) {?>
                                <li class="page-item">
                                    <a class="page-link text-dark" href="siteDetails.php?page=<?php  echo $Page-1; ?>&cityName=<?php echo $siteQueryParameter ?>">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                    <?php } }?>
                                    <?php
                                    global $ConnectingDB;
                                    $sql           = "SELECT COUNT(*) FROM plots WHERE plotsite ='$siteQueryParameter' ORDER BY id ASC";
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
                                    <a class="page-link bg-dark" href="siteDetails.php?page=<?php  echo $i; ?>&cityName=<?php echo $siteQueryParameter ?>"><?php  echo $i; ?></a>
                                </li>
                                    <?php
                                    }else {
                                    ?>
                                <li class="page-item">
                                    <a class="page-link" href="siteDetails.php?page=<?php  echo $i; ?>&cityName=<?php echo $siteQueryParameter ?>"><?php  echo $i; ?></a>
                                </li>
                                    <?php  }
                                    } } ?>
                                
                                    <!-- Creating Forward Button -->
                                    <?php if ( isset($Page) && !empty($Page) ) {
                                        if ($Page+1 <= $PostPagination) {?>
                                <li class="page-item">
                                    <a class="page-link bg-dark text-white" href="siteDetails.php?page=<?php  echo $Page+1; ?>&cityName=<?php echo $siteQueryParameter ?>">
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