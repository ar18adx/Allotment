<?php $pageTitle = "Search Results (Tenants)";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

confirmAdminLogin(); 

?>

<?php 
$adminSiteName = $_SESSION["adminSiteName"];

?>

<!-- Admin Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- Admin Header End -->

            <div class="container"> 
                <div class="text-center mb-4 mt-4">
                    <?php if($_SESSION["adminRole"] == "Super_Admin" ){ ?>
                        <h2>Tenants (All Sites)</h2>
                    <?php }elseif($_SESSION["adminRole"] == "Site_Manager" ){ ?>
                        <h2>Tenants (<?php echo htmlentities($adminSiteName)?>)</h2>
                    <?php }?>
                </div>
                <div class="row">
                    <!-- Include Admin Sidebar -->
                    <?php include("inc/adminSidebar.php");?>
                    <!-- Include Admin Sidebar -->   
                    <div class="col-md-9">
                            <form action="tenantSearchResult.php" method="GET">
                                    <?php
                                    echo ErrorMessage();
                                    echo SuccessMessage();
                                    echo ErrorMessageForRg();
                                    ?>
                                <input type="hidden" name="page" value="1">
                                <div class="row text-center mb-3">
                                    <div class="col-md-4">
                                        <input type="text" name="tenantName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" name="SearchTenant" class="btn btn-success">Search Tenants</button> 
                                    </div>
                                </div>
                            </form>
                            <div class="text-center mb-4">
                                
                            </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Tenant FirstName</th>
                                <th scope="col">tenantLastName	</th>
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
                            // SQL query when Search button is active
                            if(isset($_GET["SearchTenant"])){
                            $tenantNameSearch = $_GET["tenantName"];
                                if(empty($tenantNameSearch)){
                                    Redirect_to("viewTenants.php?page=1");
                                    $_SESSION["ErrorMessage"]= "Search field can not be empty";       
                                }

                            }
                            
                            // }// Query When Pagination is Active i.e Blog.php?page=1
                            if (isset($_GET["page"])) {
                                if($_SESSION["adminRole"] == "Super_Admin"){
                                    $sql = "SELECT * FROM tenants WHERE tenantFirstName LIKE :tenantNameSearch OR tenantLastName LIKE :tenantNameSearch ";
                                }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                    $sql = "SELECT * FROM tenants WHERE tenantFirstName LIKE :tenantNameSearch OR tenantLastName LIKE :tenantNameSearch AND siteCity = '$adminSiteName' ";
                                }
                            $stmt = $ConnectingDB->prepare($sql);
                            $stmt->bindValue(':tenantNameSearch','%'.$tenantNameSearch.'%');
                            $stmt->execute();
                            $Page = $_GET["page"];
                            if($Page==0||$Page<1){
                            $ShowPostFrom=0;
                            }else{
                            $ShowPostFrom=($Page*12)-12;
                            }
                                if($_SESSION["adminRole"] == "Super_Admin"){
                                    $sql ="SELECT * FROM tenants WHERE tenantFirstName LIKE :tenantNameSearch OR tenantLastName LIKE :tenantNameSearch ORDER BY id desc LIMIT $ShowPostFrom,12";
                                }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                    $sql ="SELECT * FROM tenants WHERE tenantFirstName LIKE :tenantNameSearch OR tenantLastName LIKE :tenantNameSearch AND siteCity = '$adminSiteName' ORDER BY id desc LIMIT $ShowPostFrom,12";
                                }
                            $stmt = $ConnectingDB->prepare($sql);
                            $stmt->bindValue(':tenantNameSearch','%'.$tenantNameSearch.'%');
                            $stmt->execute();
                            }
                            // The default SQL query
                            else{
                                if($_SESSION["adminRole"] == "Super_Admin"){
                                    $sql  = "SELECT * FROM tenants WHERE tenantFirstName LIKE :tenantNameSearch OR tenantLastName LIKE :tenantNameSearch ORDER BY id desc LIMIT 0,12";
                                }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                    $sql  = "SELECT * FROM tenants WHERE tenantFirstName LIKE :tenantNameSearch OR tenantLastName LIKE :tenantNameSearch AND siteCity = '$adminSiteName' ORDER BY id desc LIMIT 0,12";
                                }    
                            $stmt = $ConnectingDB->prepare($sql);
                            $stmt->bindValue(':tenantNameSearch','%'.$tenantNameSearch.'%');
                            $stmt->execute();
                            }
                            while ($DataRows=$stmt->fetch()) {
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
                                
    
                                $start_date = date_create(date("Y-m-d"));
                                $end_date   = date_create($expirationDate);
                                
                                //difference between two dates
                                $diff = date_diff($start_date,$end_date);
    
                            ?>
                            <tbody>
                                <tr>
                                <td><?php echo htmlentities($tenantFirstName)?></td>
                                <td><?php echo htmlentities($tenantLastName)?></td>
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
                        <div class="mb-3 mt-4 text-center">
                            <a class="btn btn-warning btn-lg" href="viewSoonToBeExpiredLease.php?page=1" role="button">Soon To Be Expired Lease</a>
                        </div>

                        <?php 
                        $SearchVariablesGet = '&tenantName='. $tenantNameSearch .'&searchTenant=' ;
                    ?>
                        <!-- Pagination -->
                        <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 mt-4">
                            <nav>
                                <ul class="pagination pagination-lg">
                                        <!-- Creating Backward Button -->
                                        <?php if( isset($Page) ) {
                                        if ( $Page>1 ) {?>
                                    <li class="page-item">
                                        <a class="page-link text-dark" href="viewTenants.php?page=<?php  echo $Page-1 .$SearchVariablesGet; ?>">
                                        <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                        <?php } }?>
                                        <?php
                                        global $ConnectingDB;
                                        if($_SESSION["adminRole"] == "Super_Admin"){
                                            $sql = "SELECT COUNT(*) FROM tenants WHERE tenantFirstName LIKE :tenantNameSearch OR tenantLastName LIKE :tenantNameSearch ";
                                        }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                            $sql = "SELECT COUNT(*) FROM tenants WHERE tenantFirstName LIKE :tenantNameSearch OR tenantLastName LIKE :tenantNameSearch AND siteCity = '$adminSiteName' ";
                                        }
                                        $stmt = $ConnectingDB->prepare($sql);
                                        $stmt->bindValue(':tenantNameSearch','%'.$tenantNameSearch.'%');
                                        $stmt->execute();
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
                                        <a class="page-link bg-dark" href="viewTenants.php?page=<?php  echo $i .$SearchVariablesGet; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php
                                        }else {
                                        ?>
                                    <li class="page-item">
                                        <a class="page-link" href="viewTenants.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php  }
                                        } } ?>
                                    
                                        <!-- Creating Forward Button -->
                                        <?php if ( isset($Page) && !empty($Page) ) {
                                            if ($Page+1 <= $PostPagination) {?>
                                    <li class="page-item">
                                        <a class="page-link bg-dark text-white" href="viewTenants.php?page=<?php  echo $Page+1 .$SearchVariablesGet; ?>">
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
 


<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->