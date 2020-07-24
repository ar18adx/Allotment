<?php $pageTitle = "Pending Confirmations";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

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
            <div class="text-center mb-4 mt-4">
                <h2>Pending Confirmations (All Sites)</h2>
            </div>
            <div class="row">
                <!-- Include Admin Sidebar -->
                <?php include("inc/adminSidebar.php");?>
                <!-- Include Admin Sidebar -->   
                <div class="col-md-9">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                            <th scope="col">No</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Id</th>
                            <th scope="col">User Id</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Telephone</th>
                            <th scope="col">User City</th>
                            <th scope="col">Site City</th>
                            <th scope="col">Plot Number</th>
                            <th scope="col">Application Status</th>
                            <th scope="col">Offer Count</th>
                            <th scope="col">Date Applied</th>
                            <th scope="col">Days Count</th>
                            </tr>
                        </thead>
                        <?php 
                        // global $ConnectingDB;
                        // $sql = "SELECT * FROM waitinglist WHERE applicationStatus = 'Pending_Confirmation' ORDER BY id asc";
                        // $Execute =$ConnectingDB->query($sql);
                        // $SrNo = 0;
                        // while ($DataRows=$Execute->fetch()) {
                        if (isset($_GET["page"])) {
                            global $ConnectingDB;
                            $sql = "SELECT * FROM waitinglist WHERE applicationStatus = 'Pending_Confirmation' ORDER BY id ASC";
                            $stmt = $ConnectingDB->prepare($sql);
                            $stmt->execute();
                            $Page = $_GET["page"];
                            if($Page==0||$Page<1){
                            $ShowPostFrom=0;
                        }else{
                            $ShowPostFrom=($Page*10)-10;
                        }
                            $sql = "SELECT * FROM waitinglist WHERE applicationStatus = 'Pending_Confirmation' ORDER BY id ASC LIMIT $ShowPostFrom,10";
                            $stmt=$ConnectingDB->query($sql);
                        }

                        // The default SQL query
                        else{
                            $sql  = "SELECT * FROM waitinglist WHERE applicationStatus = 'Pending_Confirmation' ORDER BY id ASC LIMIT $ShowPostFrom,10";
                            $stmt =$ConnectingDB->query($sql);
                        }
                        $SrNo = 0;
                        while ($DataRows=$stmt->fetch()) {
                        $firstName          = $DataRows["firstName"];
                        $lastName           = $DataRows["lastName"];
                        $id                 = $DataRows["id"];
                        $userId             = $DataRows["userId"];
                        $emailAddress       = $DataRows["emailAddress"];
                        $telephoneNumber    = $DataRows["telephoneNumber"];
                        $userCity           = $DataRows["userCity"];
                        $siteCity           = $DataRows["siteCity"];
                        $plotNumberApp      = $DataRows["plotNumberApp"];
                        $applicationStatus  = $DataRows["applicationStatus"];
                        $offerCount         = $DataRows["offerCount"];
                        $dateApplied        = $DataRows["dateApplied"];
                        $SrNo++;

                        $daysCountFourteen         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateApplied)). " + 14 day "));
                        $start_dateF = date_create(date("Y-m-d"));
                        $end_dateF   = date_create($daysCountFourteen);
                        
                        //difference between two dates
                        $diff4 = date_diff($start_dateF,$end_dateF);
                        
                        ?>
                        <tbody>
                            <tr>
                            <td><?php echo htmlentities($id)?></td>
                            <td><?php echo htmlentities($firstName)?></td>
                            <td><?php echo htmlentities($lastName)?></td>
                            <td><?php echo htmlentities($id)?></td>
                            <td><?php echo htmlentities($userId)?></td>
                            <td><?php echo htmlentities($emailAddress)?></td>
                            <td><?php echo htmlentities($telephoneNumber)?></td>
                            <td><?php echo htmlentities($userCity)?></td>
                            <td><?php echo htmlentities($siteCity)?></td>
                            <td><?php echo htmlentities($plotNumberApp)?></td>
                            <td><?php echo htmlentities($applicationStatus)?></td>
                            <td><?php echo htmlentities($offerCount)?></td>
                            <td><?php echo htmlentities($dateApplied)?></td>
                            <td><?php echo htmlentities($diff4->format("%a"))?> Days</td>
                            </tr>   
                        </tbody>
                        <?php }?>
                    </table>
                    <div class="mb-3 mt-4 text-center">
                        <a class="btn btn-success btn-lg" href="viewWaitingList.php?page=1" role="button">View Waiting List</a>
                    </div>
                    <!-- Pagination -->
                    <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 mt-4">
                        <nav>
                            <ul class="pagination pagination-lg">
                                    <!-- Creating Backward Button -->
                                    <?php if( isset($Page) ) {
                                    if ( $Page>1 ) {?>
                                <li class="page-item">
                                    <a class="page-link text-dark" href="viewPendingConfirmations.php?page=<?php  echo $Page-1; ?>">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                    <?php } }?>
                                    <?php
                                    global $ConnectingDB;
                                    $sql           = "SELECT COUNT(*) FROM waitinglist WHERE applicationStatus = 'Pending_Confirmation' ";
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
                                    <a class="page-link bg-dark" href="viewPendingConfirmations.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                </li>
                                    <?php
                                    }else {
                                    ?>
                                <li class="page-item">
                                    <a class="page-link" href="viewPendingConfirmations.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                </li>
                                    <?php  }
                                    } } ?>
                                
                                    <!-- Creating Forward Button -->
                                    <?php if ( isset($Page) && !empty($Page) ) {
                                        if ($Page+1 <= $PostPagination) {?>
                                <li class="page-item">
                                    <a class="page-link bg-dark text-white" href="viewPendingConfirmations.php?page=<?php  echo $Page+1; ?>">
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
            <div>
            </div>     
        </div>

        <!-- 
            
            Site Manager's View
        
         -->

        <?php }elseif($_SESSION["adminRole"] == "Site_Manager"){ ?>
        <div class="container"> 
            <div class="text-center mb-4 mt-4">
                <h2>Pending Confirmations (<?php echo htmlentities($adminSiteName) ?>)</h2>
            </div>
            <div class="row">
                <!-- Include Admin Sidebar -->
                <?php include("inc/adminSidebar.php");?>
                <!-- Include Admin Sidebar -->   
                <div class="col-md-9">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                            <th scope="col">No</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Id</th>
                            <th scope="col">User Id</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Telephone</th>
                            <th scope="col">User City</th>
                            <th scope="col">Site City</th>
                            <th scope="col">Plot Number</th>
                            <th scope="col">Application Status</th>
                            <th scope="col">Offer Count</th>
                            <th scope="col">Date Applied</th>
                            <th scope="col">Days Count</th>
                            </tr>
                        </thead>
                        <?php 
                        // global $ConnectingDB;
                        // $sql = "SELECT * FROM waitinglist WHERE siteCity = '$adminSiteName' AND applicationStatus = 'Pending_Confirmation' ORDER BY id asc";
                        // $Execute =$ConnectingDB->query($sql);
                        // $SrNo = 0;
                        // while ($DataRows=$Execute->fetch()) {
                        if (isset($_GET["page"])) {
                            global $ConnectingDB;
                            $sql = "SELECT * FROM waitinglist WHERE siteCity = '$adminSiteName' AND applicationStatus = 'Pending_Confirmation' ORDER BY id ASC ";
                            $stmt = $ConnectingDB->prepare($sql);
                            $stmt->execute();
                            $Page = $_GET["page"];
                            if($Page==0||$Page<1){
                            $ShowPostFrom=0;
                        }else{
                            $ShowPostFrom=($Page*10)-10;
                        }
                            $sql = "SELECT * FROM waitinglist WHERE siteCity = '$adminSiteName' AND applicationStatus = 'Pending_Confirmation' ORDER BY id ASC LIMIT $ShowPostFrom,10";
                            $stmt=$ConnectingDB->query($sql);
                        }

                        // The default SQL query
                        else{
                            $sql  = "SELECT * FROM waitinglist WHERE siteCity = '$adminSiteName' AND applicationStatus = 'Pending_Confirmation' ORDER BY id ASC LIMIT $ShowPostFrom,10";
                            $stmt =$ConnectingDB->query($sql);
                        }
                        $SrNo = 0;
                        while ($DataRows=$stmt->fetch()) {
                        $firstName          = $DataRows["firstName"];
                        $lastName           = $DataRows["lastName"];
                        $id                 = $DataRows["id"];
                        $userId             = $DataRows["userId"];
                        $emailAddress       = $DataRows["emailAddress"];
                        $telephoneNumber    = $DataRows["telephoneNumber"];
                        $userCity           = $DataRows["userCity"];
                        $siteCity           = $DataRows["siteCity"];
                        $plotNumberApp      = $DataRows["plotNumberApp"];
                        $applicationStatus  = $DataRows["applicationStatus"];
                        $offerCount         = $DataRows["offerCount"];
                        $dateApplied        = $DataRows["dateApplied"];
                        $SrNo++;

                        $daysCountFourteen         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateApplied)). " + 14 day "));
                        $start_dateF = date_create(date("Y-m-d"));
                        $end_dateF   = date_create($daysCountFourteen);
                        
                        //difference between two dates
                        $diff4 = date_diff($start_dateF,$end_dateF);

                        ?>
                        <tbody>
                            <tr>
                            <td><?php echo htmlentities($id)?></td>
                            <td><?php echo htmlentities($firstName)?></td>
                            <td><?php echo htmlentities($lastName)?></td>
                            <td><?php echo htmlentities($id)?></td>
                            <td><?php echo htmlentities($userId)?></td>
                            <td><?php echo htmlentities($emailAddress)?></td>
                            <td><?php echo htmlentities($telephoneNumber)?></td>
                            <td><?php echo htmlentities($userCity)?></td>
                            <td><?php echo htmlentities($siteCity)?></td>
                            <td><?php echo htmlentities($plotNumberApp)?></td>
                            <td><?php echo htmlentities($applicationStatus)?></td>
                            <td><?php echo htmlentities($offerCount)?></td>
                            <td><?php echo htmlentities($dateApplied)?></td>
                            <td><?php echo htmlentities($diff4->format("%a"))?> Days</td>
                            </tr>   
                        </tbody>
                        <?php }?>
                    </table>
                    <div class="mb-3 mt-4 text-center">
                        <a class="btn btn-success btn-lg" href="viewWaitingList.php?page=1" role="button">View Waiting List</a>
                    </div>
                    <!-- Pagination -->
                    <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 mt-4">
                        <nav>
                            <ul class="pagination pagination-lg">
                                    <!-- Creating Backward Button -->
                                    <?php if( isset($Page) ) {
                                    if ( $Page>1 ) {?>
                                <li class="page-item">
                                    <a class="page-link text-dark" href="viewPendingConfirmations.php?page=<?php  echo $Page-1; ?>">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                    <?php } }?>
                                    <?php
                                    global $ConnectingDB;
                                    $sql           = "SELECT COUNT(*) FROM waitinglist WHERE siteCity = '$adminSiteName' AND applicationStatus = 'Pending_Confirmation' ";
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
                                    <a class="page-link bg-dark" href="viewPendingConfirmations.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                </li>
                                    <?php
                                    }else {
                                    ?>
                                <li class="page-item">
                                    <a class="page-link" href="viewPendingConfirmations.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                </li>
                                    <?php  }
                                    } } ?>
                                
                                    <!-- Creating Forward Button -->
                                    <?php if ( isset($Page) && !empty($Page) ) {
                                        if ($Page+1 <= $PostPagination) {?>
                                <li class="page-item">
                                    <a class="page-link bg-dark text-white" href="viewPendingConfirmations.php?page=<?php  echo $Page+1; ?>">
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