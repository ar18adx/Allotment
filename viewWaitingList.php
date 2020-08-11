<?php $pageTitle = "Waiting List";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

confirmAdminLogin(); 

?>

<?php 
$adminSiteName = $_SESSION["adminSiteName"];

    if(isset($_POST["SendConVal"])){
        date_default_timezone_set("Africa/Lagos");
        $CurrentTime            =  time();
        $datetime               = strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);

            global $ConnectingDB;
            if($_SESSION["adminRole"] == "Super_Admin" ){ 
                $sqlMl ="SELECT * FROM Waitinglist ";
            }elseif($_SESSION["adminRole"] == "Site_Manager" ){
                $sqlMl ="SELECT * FROM Waitinglist WHERE siteCity = '$adminSiteName'";
            }
            

            $stmtMl = $ConnectingDB->query($sqlMl);
            while ($DataRows=$stmtMl->fetch()){;
            $idMl                     = $DataRows["id"];
            $emailAddressMl[]       = $DataRows["emailAddress"];

            }
            
                $emailTo    = implode(", ", $emailAddressMl);
                $subject    = "Contact And Interest Validation";
                $message    = "Please click on the link below to update Your contact details"
                                ."\n"."Log into Your account to accept or reject the plot"
                                ."\n\n"."http://allotment-com.stackstaging.com";
                $headers    = "From: "."Allotment";

            if(mail($emailTo, $subject, $message, $headers)){
            $_SESSION["SuccessMessage"]="Message was sent Successfully";
            Redirect_to("viewWaitingList.php?page=1");
            }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("viewWaitingList.php?page=1");
            }
        
    } //Ending of Submit Button If-Condition


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
                        <div class="text-center mb-4 mt-4">
                            <?php if($_SESSION["adminRole"] == "Super_Admin" ){ ?>
                                <h2>Waiting List (All Sites)</h2>
                            <?php }elseif($_SESSION["adminRole"] == "Site_Manager" ){ ?>
                                <h2>Waiting List (<?php echo htmlentities($adminSiteName) ?>)</h2>
                            <?php }?>
                            <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                            echo ErrorMessageForRg();
                            ?>
                            <div class="row text-center mb-3 mt-3" >
                                <div class="col-md-6">
                                    <a class="btn btn-success" href="closeOpenApplication.php" role="button">Close/Open Applications</a>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-warning" href="adminContactvalidation.php" role="button">Send Contact Validation</a>
                                </div>
                            </div>
                        </div>
                            <form action="waitingListSearchResults.php" method="GET">
                                <input type="hidden" name="page" value="1">
                                <div class="row text-center mb-3">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-4">
                                        <input type="text" name="userDetails" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" name="SearchUser" class="btn btn-success">Search User</button> 
                                    </div>
                                </div>
                            </form>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">User Id</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">Telephone</th>
                                <th scope="col">User City</th>
                                <th scope="col">Site City</th>
                                <th scope="col">Plot Number</th>
                                <th scope="col">Application Status</th>
                                <th scope="col">Offer Count</th>
                                <th scope="col">Date Applied</th>
                                <th scope="col">Date Received</th>
                                </tr>
                            </thead>
                            <?php 
            
                            if (isset($_GET["page"])) {
                                global $ConnectingDB;
                                if($_SESSION["adminRole"] == "Super_Admin"){ 
                                    $sql = "SELECT * FROM waitinglist ";
                                }elseif($_SESSION["adminRole"] == "Site_Manager"){ 
                                    $sql = "SELECT * FROM waitinglist WHERE siteCity = '$adminSiteName' ";
                                }
                                $stmt = $ConnectingDB->prepare($sql);
                                $stmt->execute();
                                $Page = $_GET["page"];
                                if($Page==0||$Page<1){
                                $ShowPostFrom=0;
                            }else{
                                $ShowPostFrom=($Page*10)-10;
                            }
                                if($_SESSION["adminRole"] == "Super_Admin"){
                                    $sql = "SELECT * FROM waitinglist ORDER BY id LIMIT $ShowPostFrom,10";
                                }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                    $sql = "SELECT * FROM waitinglist WHERE siteCity = '$adminSiteName' ORDER BY id LIMIT $ShowPostFrom,10";
                                }

                                $stmt=$ConnectingDB->query($sql);
                            }

                            // The default SQL query
                            else{
                                    if($_SESSION["adminRole"] == "Super_Admin"){
                                        $sql  = "SELECT * FROM waitinglist ORDER BY id LIMIT $ShowPostFrom,10";
                                    }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                        $sql  = "SELECT * FROM waitinglist WHERE siteCity = '$adminSiteName' ORDER BY id LIMIT $ShowPostFrom,10";
                                    }

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
                            $dateRecv        = $DataRows["dateRecv"];
                            $SrNo++;
                            
                            ?>
                            <tbody>
                                <tr>
                                <td><?php echo htmlentities($firstName)?></td>
                                <td><?php echo htmlentities($lastName)?></td>
                                <td><?php echo htmlentities($userId)?></td>
                                <td><?php echo htmlentities($emailAddress)?></td>
                                <td><?php echo htmlentities($telephoneNumber)?></td>
                                <td><?php echo htmlentities($userCity)?></td>
                                <td><?php echo htmlentities($siteCity)?></td>
                                <td><?php echo htmlentities($plotNumberApp)?></td>
                                <td><?php echo htmlentities($applicationStatus)?></td>
                                <td><?php echo htmlentities($offerCount)?></td>
                                <td><?php echo htmlentities($dateApplied)?></td>
                                <td><?php echo htmlentities($dateRecv)?></td>
                                </tr>   
                            </tbody>
                            <?php }?>
                        </table>
                        <div class="mb-3 mt-4 text-center">
                            <a class="btn btn-success btn-lg" href="viewPendingConfirmations.php?page=1" role="button">View Pending Confirmations</a>
                        </div>
                        <!-- Pagination -->
                        <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 mt-4">
                            <nav>
                                <ul class="pagination pagination-lg">
                                        <!-- Creating Backward Button -->
                                        <?php if( isset($Page) ) {
                                        if ( $Page>1 ) {?>
                                    <li class="page-item">
                                        <a class="page-link text-dark" href="viewTenants.php?page=<?php  echo $Page-1; ?>">
                                        <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                        <?php } }?>
                                        <?php
                                        global $ConnectingDB;
                                        if($_SESSION["adminRole"] == "Super_Admin"){
                                            $sql = "SELECT COUNT(*) FROM waitinglist ";
                                        }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                            $sql = "SELECT COUNT(*) FROM waitinglist WHERE siteCity = '$adminSiteName' ";
                                        }

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
                                        <a class="page-link bg-dark" href="viewWaitingList.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php
                                        }else {
                                        ?>
                                    <li class="page-item">
                                        <a class="page-link" href="viewWaitingList.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php  }
                                        } } ?>
                                    
                                        <!-- Creating Forward Button -->
                                        <?php if ( isset($Page) && !empty($Page) ) {
                                            if ($Page+1 <= $PostPagination) {?>
                                    <li class="page-item">
                                        <a class="page-link bg-dark text-white" href="viewWaitingList.php?page=<?php  echo $Page+1; ?>">
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
        
            
         
   
<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->