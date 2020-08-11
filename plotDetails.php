<?php $pageTitle = "Plot Details";?>

<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

confirmAdminLogin(); 

?>

<?php 

if($_SESSION["adminRole"] != "Site_Manager"){
    Redirect_to("errorPage.php");
  }

$adminCity = $_SESSION["adminSiteName"];

?>

<?php if($_SESSION["adminRole"] == "Site_Manager"){?>

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
                        <h2><?php echo htmlentities($adminCity)?></h2>
                            <!-- Plot search form Start -->
                            <?php include("plotSearchForm.php");?>
                            <!-- Plot search form End -->
                    </div>
                    <div class="row">
                        <?php
                            
                            global $ConnectingDB;
                            // $sql ="SELECT * FROM plots WHERE plotsite ='$siteQueryParameter' ORDER BY id ASC";
                            // $stmt = $ConnectingDB->query($sql);
                            if (isset($_GET["page"])) {
                                $sql = "SELECT * FROM plots WHERE plotsite ='$adminCity' ORDER BY id ASC";
                                $stmt = $ConnectingDB->prepare($sql);
                                $stmt->execute();
                                $Page = $_GET["page"];
                                if($Page==0||$Page<1){
                                $ShowPostFrom=0;
                            }else{
                                $ShowPostFrom=($Page*6)-6;
                            }
                                $sql = "SELECT * FROM plots WHERE plotsite ='$adminCity' ORDER BY id ASC LIMIT $ShowPostFrom,6";
                                $stmt=$ConnectingDB->query($sql);
                            }

                            // The default SQL query
                            else{
                                $sql  = "SELECT * FROM plots WHERE plotsite ='$adminCity' ORDER BY id ASC LIMIT $ShowPostFrom,6";
                                $stmt =$ConnectingDB->query($sql);
                            }
                            while ($DataRows = $stmt->fetch()) {
                            $id                     = $DataRows["id"];
                            $plotNumber                     = $DataRows["plotNumber"];
                            $plotSize                     = $DataRows["plotSize"];
                            $plotDescription                     = $DataRows["plotDescription"];
                            $plotStatus                    = $DataRows["plotStatus"];
                            $addedBy                     = $DataRows["addedBy"];
                            
                            global $ConnectingDB;
                            $sql6 ="SELECT * FROM tenants WHERE plotNumber = '$plotNumber' ";
                            $stmt6 = $ConnectingDB->query($sql6);
                            $DataRows6=$stmt6->fetch();
                            $tntRowId                     = $DataRows6["id"];
                            $tenantIdUn                    = $DataRows6["tenantId"];
                            $tenantFirstName          = $DataRows6["tenantFirstName"];
                            $tenantLastName          = $DataRows6["tenantLastName"];
                            $tenantFullName = $tenantFirstName." ".$tenantLastName;

                            $sql97 ="SELECT * FROM waitinglist WHERE plotNumberApp = '$plotNumber' AND applicationStatus ='Pending_Confirmation' ";
                            $stmt97 = $ConnectingDB->query($sql97);
                            $DataRows97=$stmt97->fetch();
                            $userRowId                     = $DataRows97["id"];
                            $userIdUn                    = $DataRows97["userId"];
                            $userFirstName          = $DataRows97["firstName"];
                            $userLastName          = $DataRows97["lastName"];
                            $userFullName = $userFirstName." ".$userLastName;

                            $sql042 ="SELECT * FROM inspectionreport WHERE plotNumber ='$plotNumber' ";
                            $stmt042 = $ConnectingDB->prepare($sql042);
                            $stmt042->execute();
                            $Result042 = $stmt042->rowcount();
                            
                            $sqlIr ="SELECT * FROM inspectionreport WHERE plotNumber ='$plotNumber' ";
                            $stmtIr = $ConnectingDB->query($sqlIr);
                            $DataRowsIr=$stmtIr->fetch();
                            $idIr                     = $DataRowsIr["id"];
                            $tenantIdIr               = $DataRowsIr["tenantId"];
                                

                                
                            ?>
                        <div class="col-md-6 mb-4">
                            <div class="card text-white bg-dark">
                            <div class="card-body">
                                <h2 class="card-title"><?php echo htmlentities($plotNumber)?></h2>
                                <h5 class="card-text"><?php echo htmlentities($plotSize)?> </h5>
                                <h5 class="card-text"><?php echo htmlentities($plotDescription)?> </h5>
                                <h5 class="card-text"><?php if($plotStatus =='Occupied'){?>Occupied By <a class="" href="viewTenantProfile.php?tenantId=<?php echo $tenantIdUn?>" role="button"><?php echo htmlentities($tenantFullName); ?></a> 
                                <?php }elseif($plotStatus =='On_Offer'){?> <b>On Offer With :</b> <?php echo htmlentities($userFullName);?>
                                <?php }else{ echo htmlentities($plotStatus); }?></h5>
                                <h5 class="card-text"><b>Added By:</b> <?php echo htmlentities($addedBy)?> </h5>
                                <?php if($Result042 < 1){?>
                                <h5 class="card-text">No Inspection Report available</h5>
                                <?php }elseif($Result042 >0){?>
                                <h5 class="card-text mt-2"><a class="btn btn-warning" href="viewTenantInspectionRecord.php?page=1&tenantId=<?php echo $tenantIdIr?>" role="button">View Inspection Report</a></h5>
                                <?php }?>

                                
                                
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
                                    <a class="page-link text-dark" href="plotDetails.php?page=<?php  echo $Page-1; ?>">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                    <?php } }?>
                                    <?php
                                    global $ConnectingDB;
                                    $sql           = "SELECT COUNT(*) FROM plots WHERE plotsite ='$adminCity' ORDER BY id ASC";
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
                                    <a class="page-link bg-dark" href="plotDetails.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                </li>
                                    <?php
                                    }else {
                                    ?>
                                <li class="page-item">
                                    <a class="page-link" href="plotDetails.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                </li>
                                    <?php  }
                                    } } ?>
                                
                                    <!-- Creating Forward Button -->
                                    <?php if ( isset($Page) && !empty($Page) ) {
                                        if ($Page+1 <= $PostPagination) {?>
                                <li class="page-item">
                                    <a class="page-link bg-dark text-white" href="plotDetails.php?page=<?php  echo $Page+1; ?>">
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