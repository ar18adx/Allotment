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
                            </tr>   
                        </tbody>
                        <?php }?>
                    </table>
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