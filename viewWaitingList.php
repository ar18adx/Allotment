<?php $pageTitle = "Waiting List";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php 
$adminSiteName = $_SESSION["adminSiteName"];



?>

<!-- Admin Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- Admin Header End -->

        <?php if($_SESSION["adminRole"] == "Super_Admin" ){ ?>
        <div class="container"> 
            <div class="text-center mb-4 mt-4">
                <h2>Waiting List (All Sites)</h2>
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
                            </tr>
                        </thead>
                        <?php 
                        global $ConnectingDB;
                        $sql = "SELECT * FROM waitinglist ORDER BY id asc";
                        $Execute =$ConnectingDB->query($sql);
                        $SrNo = 0;
                        while ($DataRows=$Execute->fetch()) {
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
                        
                        ?>
                        <tbody>
                            <tr>
                            <td><?php echo htmlentities($SrNo)?></td>
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
                            </tr>   
                        </tbody>
                        <?php }?>
                    </table>
                    <div class="mb-3 mt-4 text-center">
                        <a class="btn btn-success btn-lg" href="viewPendingConfirmations.php" role="button">View Pending Confirmations</a>
                    </div>
                </div>
            </div>
            <div>
            </div>     
        </div>
        <?php }elseif($_SESSION["adminRole"] == "Site_Manager"){ ?>
        <div class="container"> 
            <div class="text-center mb-4 mt-4">
                <h2>Waiting List (<?php echo htmlentities($adminSiteName) ?>)</h2>
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
                            </tr>
                        </thead>
                        <?php 
                        global $ConnectingDB;
                        $sql = "SELECT * FROM waitinglist WHERE siteCity = '$adminSiteName' ORDER BY id asc";
                        $Execute =$ConnectingDB->query($sql);
                        $SrNo = 0;
                        while ($DataRows=$Execute->fetch()) {
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

                        ?>
                        <tbody>
                            <tr>
                            <td><?php echo htmlentities($SrNo)?></td>
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
                            </tr>   
                        </tbody>
                        <?php }?>
                    </table>
                    <div class="mb-3 mt-4 text-center">
                        <a class="btn btn-success btn-lg" href="viewPendingConfirmations.php" role="button">View Pending Confirmations</a>
                    </div>
                </div>
            </div>           
        </div>
    <?php }?>  
   
<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->