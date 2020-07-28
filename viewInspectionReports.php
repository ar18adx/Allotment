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
$adminSiteName = $_SESSION["adminSiteName"];

?>


<!-- Admin Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- Admin Header End -->

    <!-- 
        
            Allotment Officer's View
        
        -->

    <?php if($_SESSION["adminRole"] == "Super_Admin" ){ ?>
        <div class="container">   
            <div class="row">
                <!-- Include Admin Sidebar -->
                <?php include("inc/adminSidebar.php");?>
                <!-- Include Admin Sidebar -->    
                <div class="col-md-9">
                    <div class="text-center mt-5 mb-5">
                        <h1>Inspection Reports All Plots</h1>
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
                            // global $ConnectingDB;
                            // $sql = "SELECT * FROM inspectionreport ORDER BY id DESC";
                            // $Execute =$ConnectingDB->query($sql);
                            // $SrNo = 0;
                            // while ($DataRows=$Execute->fetch()) {
                            if (isset($_GET["page"])) {
                                global $ConnectingDB;
                                $sql = "SELECT * FROM inspectionreport ";
                                $stmt = $ConnectingDB->prepare($sql);
                                $stmt->execute();
                                $Page = $_GET["page"];
                                if($Page==0||$Page<1){
                                $ShowPostFrom=0;
                            }else{
                                $ShowPostFrom=($Page*10)-10;
                            }
                                $sql = "SELECT * FROM inspectionreport ORDER BY id LIMIT $ShowPostFrom,10";
                                $stmt=$ConnectingDB->query($sql);
                            }

                            // The default SQL query
                            else{
                                $sql  = "SELECT * FROM inspectionreport ORDER BY id LIMIT $ShowPostFrom,10";
                                $stmt =$ConnectingDB->query($sql);
                            }
                            $SrNo = 0;
                            while ($DataRows=$stmt->fetch()) {
                            $id          = $DataRows["id"];
                            $plotNumber          = $DataRows["plotNumber"];
                            $siteName           = $DataRows["siteName"];
                            $inspectionDate      = $DataRows["inspectionDate"];
                            
                            $SrNo++;
                            
                            ?>
                            <tbody>
                            
                                <tr>
                                <td><?php echo htmlentities($id)?></td>
                                <td><?php echo htmlentities($plotNumber)?></td>
                                <td><?php echo htmlentities($siteName)?></td>
                                <td><?php echo htmlentities($inspectionDate)?></td>
                                <td><a class="btn btn-dark" href="inspectionDetails.php?id=<?php echo $id?>" role="button">View Details</a></td>
                                </tr>
                            </tbody>
                            <?php }?>
                        </table>
                        <!-- Pagination -->
                        <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 mt-4">
                            <nav>
                                <ul class="pagination pagination-lg">
                                        <!-- Creating Backward Button -->
                                        <?php if( isset($Page) ) {
                                        if ( $Page>1 ) {?>
                                    <li class="page-item">
                                        <a class="page-link text-dark" href="viewInspectionReports.php?page=<?php  echo $Page-1; ?>">
                                        <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                        <?php } }?>
                                        <?php
                                        global $ConnectingDB;
                                        $sql           = "SELECT COUNT(*) FROM inspectionreport ";
                                        $stmt          = $ConnectingDB->query($sql);
                                        $RowPagination = $stmt->fetch();
                                        $TotalPosts    = array_shift($RowPagination);
                                        // echo $TotalPosts."<br>";
                                        $PostPagination=$TotalPosts/10;
                                        $PostPagination=ceil($PostPagination);
                                        // echo $PostPagination;
                                        for ($i=1; $i <=$PostPagination ; $i++) {
                                        if( isset($Page) ){
                                            if ($i == $Page) { ?>
                                    <li class="page-item active">
                                        <a class="page-link bg-dark" href="viewInspectionReports.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php
                                        }else {
                                        ?>
                                    <li class="page-item">
                                        <a class="page-link" href="viewInspectionReports.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php  }
                                        } } ?>
                                    
                                        <!-- Creating Forward Button -->
                                        <?php if ( isset($Page) && !empty($Page) ) {
                                            if ($Page+1 <= $PostPagination) {?>
                                    <li class="page-item">
                                        <a class="page-link bg-dark text-white" href="viewInspectionReports.php?page=<?php  echo $Page+1; ?>">
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
    <!--
            
             Site Manager's View
             
              -->

    <?php }elseif($_SESSION["adminRole"] == "Site_Manager"){ ?>
        <div class="container">   
            <div class="row">
                <!-- Include Admin Sidebar -->
                <?php include("inc/adminSidebar.php");?>
                <!-- Include Admin Sidebar -->    
                <div class="col-md-9">
                    <div class="text-center mt-5 mb-5">
                        <h1>Inspection Reports (<?php echo htmlentities($adminSiteName)?>)</h1>
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
                            
                            if (isset($_GET["page"])) {
                                global $ConnectingDB;
                                $sql = "SELECT * FROM waitinglist WHERE siteCity = '$adminSiteName' ORDER BY id ASC ";
                                $stmt = $ConnectingDB->prepare($sql);
                                $stmt->execute();
                                $Page = $_GET["page"];
                                if($Page==0||$Page<1){
                                $ShowPostFrom=0;
                            }else{
                                $ShowPostFrom=($Page*10)-10;
                            }
                                $sql = "SELECT * FROM inspectionreport WHERE siteName = '$adminSiteName' ORDER BY id DESC LIMIT $ShowPostFrom,10";
                                $stmt=$ConnectingDB->query($sql);
                            }

                            // The default SQL query
                            else{
                                $sql  = "SELECT * FROM inspectionreport WHERE siteName = '$adminSiteName' ORDER BY id DESC LIMIT $ShowPostFrom,10";
                                $stmt =$ConnectingDB->query($sql);
                            }
                            $SrNo = 0;
                            while ($DataRows=$stmt->fetch()) {
                            $id          = $DataRows["id"];
                            $plotNumber          = $DataRows["plotNumber"];
                            $siteName           = $DataRows["siteName"];
                            $inspectionDate      = $DataRows["inspectionDate"];
                            
                            $SrNo++;
                            
                            ?>
                            <tbody>
                            
                                <tr>
                                <td><?php echo htmlentities($id)?></td>
                                <td><?php echo htmlentities($plotNumber)?></td>
                                <td><?php echo htmlentities($siteName)?></td>
                                <td><?php echo htmlentities($inspectionDate)?></td>
                                <td><a class="btn btn-dark" href="inspectionDetails.php?id=<?php echo $id?>" role="button">View Details</a></td>
                                </tr>
                            </tbody>
                            <?php }?>
                        </table>
                        <!-- Pagination -->
                        <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 mt-4">
                            <nav>
                                <ul class="pagination pagination-lg">
                                        <!-- Creating Backward Button -->
                                        <?php if( isset($Page) ) {
                                        if ( $Page>1 ) {?>
                                    <li class="page-item">
                                        <a class="page-link text-dark" href="viewInspectionReports.php?page=<?php  echo $Page-1; ?>">
                                        <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                        <?php } }?>
                                        <?php
                                        global $ConnectingDB;
                                        $sql           = "SELECT COUNT(*) FROM inspectionreport WHERE siteName = '$adminSiteName' ";
                                        $stmt          = $ConnectingDB->query($sql);
                                        $RowPagination = $stmt->fetch();
                                        $TotalPosts    = array_shift($RowPagination);
                                        // echo $TotalPosts."<br>";
                                        $PostPagination=$TotalPosts/10;
                                        $PostPagination=ceil($PostPagination);
                                        // echo $PostPagination;
                                        for ($i=1; $i <=$PostPagination ; $i++) {
                                        if( isset($Page) ){
                                            if ($i == $Page) { ?>
                                    <li class="page-item active">
                                        <a class="page-link bg-dark" href="viewInspectionReports.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php
                                        }else {
                                        ?>
                                    <li class="page-item">
                                        <a class="page-link" href="viewInspectionReports.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php  }
                                        } } ?>
                                    
                                        <!-- Creating Forward Button -->
                                        <?php if ( isset($Page) && !empty($Page) ) {
                                            if ($Page+1 <= $PostPagination) {?>
                                    <li class="page-item">
                                        <a class="page-link bg-dark text-white" href="viewInspectionReports.php?page=<?php  echo $Page+1; ?>">
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
    <?php }?>

<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->