<?php $pageTitle = "Tenants";?>


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
                <h2>Tenants (All Sites)</h2>
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
                            <th scope="col">Tenant FirstName</th>
                            <th scope="col">tenantLastName	</th>
                            <th scope="col">Id</th>
                            <th scope="col">Tenant Id</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Telephone</th>
                            <th scope="col">Tenant City</th>
                            <th scope="col">Site City</th>
                            <th scope="col">Plot Number</th>
                            <th scope="col"> Lease Date</th>
                            <th scope="col">Expiration Date</th>
                            <th scope="col">Renewal Status</th>
                            <th scope="col">Tenant Status</th>
                            <th scope="col">Days Count</th>
                            <th scope="col">Send Message</th>
                            
                            </tr>
                        </thead>
                        <?php 
                        global $ConnectingDB;
                        $sql = "SELECT * FROM tenants ORDER BY id asc";
                        $Execute =$ConnectingDB->query($sql);
                        $SrNo = 0;
                        while ($DataRows=$Execute->fetch()) {
                        $tenantFirstName          = $DataRows["tenantFirstName"];
                        $tenantLastName           = $DataRows["tenantLastName"];
                        $id                       = $DataRows["id"];
                        $tenantId                 = $DataRows["tenantId"];
                        $tenantEmailAddress       = $DataRows["tenantEmailAddress"];
                        $tenantPhoneNum           = $DataRows["tenantPhoneNum"];
                        $tenantCity              = $DataRows["tenantCity"];
                        $siteCity               = $DataRows["siteCity"];
                        $plotNumber             = $DataRows["plotNumber"];
                        $leaseDate              = $DataRows["leaseDate"];
                        $expirationDate         = $DataRows["expirationDate"];
                        $renewalStatus          = $DataRows["renewalStatus"];
                        $tenantStatus           = $DataRows["tenantStatus"];
                        $SrNo++;

                        $start_date = date_create(date("Y-m-d"));
                        $end_date   = date_create($expirationDate);
                        
                        //difference between two dates
                        $diff = date_diff($start_date,$end_date);
                        
                        ?>
                        <tbody>
                            <tr>
                            <td><?php echo htmlentities($SrNo)?></td>
                            <td><?php echo htmlentities($tenantFirstName)?></td>
                            <td><?php echo htmlentities($tenantLastName)?></td>
                            <td><?php echo htmlentities($id)?></td>
                            <td><?php echo htmlentities($tenantId)?></td>
                            <td><?php echo htmlentities($tenantEmailAddress)?></td>
                            <td><?php echo htmlentities($tenantPhoneNum)?></td>
                            <td><?php echo htmlentities($tenantCity)?></td>
                            <td><?php echo htmlentities($siteCity)?></td>
                            <td><?php echo htmlentities($plotNumber)?></td>
                            <td><?php echo htmlentities($leaseDate)?></td>
                            <td><?php echo htmlentities($expirationDate)?></td>
                            <td><?php echo htmlentities($renewalStatus)?></td>
                            <td><?php echo htmlentities($tenantStatus)?></td>
                            <?php if($diff->format("%a") <= 30){?>
                            <td class="bg-danger text-white"><?php echo htmlentities($diff->format("%a"))?> day(s)</td>
                            <?php }elseif($diff->format("%a") <= 90){?>
                            <td class="bg-warning text-white"><?php echo htmlentities($diff->format("%a"))?> day(s)</td>
                            <?php }elseif($diff->format("%a") > 90){?>
                            <td class="bg-success text-white"><?php echo htmlentities($diff->format("%a"))?> day(s)</td>
                            <?php }?>
                            <td><a class="btn btn-success" href="#" role="button">Send Message</a></td>
                            
                            </tr>   
                        </tbody>
                        <?php }?>
                    </table>
                </div>
            </div>           
        </div>
        <?php }elseif($_SESSION["adminRole"] == "Site_Manager"){ ?>
        <div class="container"> 
            <div class="text-center mb-4 mt-4" >
                <h2>Tenants (<?php echo htmlentities($adminSiteName) ?>)</h2>
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
                            <th scope="col">Tenant FirstName</th>
                            <th scope="col">tenantLastName	</th>
                            <th scope="col">Id</th>
                            <th scope="col">Tenant Id</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Telephone</th>
                            <th scope="col">Tenant City</th>
                            <th scope="col">Site City</th>
                            <th scope="col">Plot Number</th>
                            <th scope="col"> Lease Date</th>
                            <th scope="col">Expiration Date</th>
                            <th scope="col">Renewal Status</th>
                            <th scope="col">Tenant Status</th>
                            <th scope="col">Days Count</th>
                            <th scope="col">Send Message</th>
                            
                            </tr>
                        </thead>
                        <?php 
                        global $ConnectingDB;
                        $sql = "SELECT * FROM tenants WHERE siteCity = '$adminSiteName' ORDER BY id asc";
                        $Execute =$ConnectingDB->query($sql);
                        $SrNo = 0;
                        while ($DataRows=$Execute->fetch()) {
                        $tenantFirstName          = $DataRows["tenantFirstName"];
                        $tenantLastName           = $DataRows["tenantLastName"];
                        $id                       = $DataRows["id"];
                        $tenantId                 = $DataRows["tenantId"];
                        $tenantEmailAddress       = $DataRows["tenantEmailAddress"];
                        $tenantPhoneNum           = $DataRows["tenantPhoneNum"];
                        $tenantCity              = $DataRows["tenantCity"];
                        $siteCity               = $DataRows["siteCity"];
                        $plotNumber             = $DataRows["plotNumber"];
                        $leaseDate              = $DataRows["leaseDate"];
                        $expirationDate         = $DataRows["expirationDate"];
                        $renewalStatus          = $DataRows["renewalStatus"];
                        $tenantStatus           = $DataRows["tenantStatus"];
                        $SrNo++;
                        $start_date = date_create(date("Y-m-d"));
                        $end_date   = date_create($expirationDate);
                        
                        //difference between two dates
                        $diff = date_diff($start_date,$end_date);

                        ?>
                        <tbody>
                            <tr>
                            <td><?php echo htmlentities($SrNo)?></td>
                            <td><?php echo htmlentities($tenantFirstName)?></td>
                            <td><?php echo htmlentities($tenantLastName)?></td>
                            <td><?php echo htmlentities($id)?></td>
                            <td><?php echo htmlentities($tenantId)?></td>
                            <td><?php echo htmlentities($tenantEmailAddress)?></td>
                            <td><?php echo htmlentities($tenantPhoneNum)?></td>
                            <td><?php echo htmlentities($tenantCity)?></td>
                            <td><?php echo htmlentities($siteCity)?></td>
                            <td><?php echo htmlentities($plotNumber)?></td>
                            <td><?php echo htmlentities($leaseDate)?></td>
                            <td><?php echo htmlentities($expirationDate)?></td>
                            <td><?php echo htmlentities($renewalStatus)?></td>
                            <td><?php echo htmlentities($tenantStatus)?></td>
                            <?php if($diff->format("%a") <= 30){?>
                            <td class="bg-danger text-white"><?php echo htmlentities($diff->format("%a"))?> day(s)</td>
                            <?php }elseif($diff->format("%a") <= 90){?>
                            <td class="bg-warning text-white"><?php echo htmlentities($diff->format("%a"))?> day(s)</td>
                            <?php }elseif($diff->format("%a") > 90){?>
                            <td class="bg-success text-white"><?php echo htmlentities($diff->format("%a"))?> day(s)</td>
                            <?php }?>
                            <td><a class="btn btn-success" href="adminSendMsg.php?id=<?php echo $id; ?>" role="button">Send Message</a></td>
                            </tr>   
                        </tbody>
                        <?php }?>
                    </table>
                </div>
            </div>           
        </div>
    <?php }?>  


<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->