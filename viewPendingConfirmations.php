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
                        global $ConnectingDB;
                        $sql = "SELECT * FROM waitinglist WHERE applicationStatus = 'Pending_Confirmation' ORDER BY id asc";
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

                        $daysCountFourteen         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateApplied)). " + 14 day "));
                        $start_dateF = date_create(date("Y-m-d"));
                        $end_dateF   = date_create($daysCountFourteen);
                        
                        //difference between two dates
                        $diff4 = date_diff($start_dateF,$end_dateF);
                        
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
                            <td><?php echo htmlentities($diff4->format("%a"))?> Days</td>
                            </tr>   
                        </tbody>
                        <?php }?>
                    </table>
                    <div class="mb-3 mt-4 text-center">
                        <a class="btn btn-success btn-lg" href="viewWaitingList.php" role="button">View Waiting List</a>
                    </div>
                </div>
            </div>
            <div>
            </div>     
        </div>
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
                        global $ConnectingDB;
                        $sql = "SELECT * FROM waitinglist WHERE siteCity = '$adminSiteName' AND applicationStatus = 'Pending_Confirmation' ORDER BY id asc";
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

                        $daysCountFourteen         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateApplied)). " + 14 day "));
                        $start_dateF = date_create(date("Y-m-d"));
                        $end_dateF   = date_create($daysCountFourteen);
                        
                        //difference between two dates
                        $diff4 = date_diff($start_dateF,$end_dateF);

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
                            <td><?php echo htmlentities($diff4->format("%a"))?> Days</td>
                            </tr>   
                        </tbody>
                        <?php }?>
                    </table>
                    <div class="mb-3 mt-4 text-center">
                        <a class="btn btn-success btn-lg" href="viewWaitingList.php" role="button">View Waiting List</a>
                    </div>
                </div>
            </div>           
        </div>
    <?php }?>  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>