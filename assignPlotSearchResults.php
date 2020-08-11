<?php $pageTitle = "Search Results (Awaiting Plot)";?>


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

            <div class="container"> 
                <div class="text-center mb-4 mt-4">
                    <?php if($_SESSION["adminRole"] == "Super_Admin" ){ ?>
                        <h2>Awaiting Plot (All Sites)</h2>
                    <?php }elseif($_SESSION["adminRole"] == "Site_Manager" ){ ?>
                        <h2>Awaiting Plot (<?php echo htmlentities($adminSiteName)?>)</h2>
                    <?php }?>
                </div>
                <div class="row">
                    <!-- Include Admin Sidebar -->
                    <?php include("inc/adminSidebar.php");?>
                    <!-- Include Admin Sidebar -->   
                    <div class="col-md-9">
                            <form action="assignPlotSearchResults.php" method="GET">
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
                            <div class="text-center mb-4">
                                <h5>Result(s)</h5>
                            </div>
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
                                <th scope="col">Assign Plot</th>
                                </tr>
                            </thead>
                            <?php 
                            global $ConnectingDB;
                            // SQL query when Search button is active
                            if(isset($_GET["SearchUser"])){
                                $userSearch = $_GET["userDetails"];
                                if(empty($userSearch)){
                                    Redirect_to("viewWaitingList.php?page=1");
                                    $_SESSION["ErrorMessage"]= "Search field can not be empty";       
                                }

                            }
                            
                            // }// Query When Pagination is Active i.e Blog.php?page=1
                            if (isset($_GET["page"])) {
                                if($_SESSION["adminRole"] == "Super_Admin"){
                                    $sql = "SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND plotNumberApp ='None' AND firstName LIKE :userSearch OR lastName LIKE :userSearch OR emailAddress LIKE :userSearch OR siteCity LIKE :userSearch ";
                                }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                    $sql = "SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND plotNumberApp ='None' AND firstName LIKE :userSearch OR lastName LIKE :userSearch OR emailAddress LIKE :userSearch OR siteCity LIKE :userSearch AND siteCity = '$adminSiteName' ";
                                }
                            $stmt = $ConnectingDB->prepare($sql);
                            $stmt->bindValue(':userSearch','%'.$userSearch.'%');
                            $stmt->execute();
                            $Page = $_GET["page"];
                            if($Page==0||$Page<1){
                            $ShowPostFrom=0;
                            }else{
                            $ShowPostFrom=($Page*12)-12;
                            }
                                if($_SESSION["adminRole"] == "Super_Admin"){
                                    $sql ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND plotNumberApp ='None' AND firstName LIKE :userSearch OR lastName LIKE :userSearch OR emailAddress LIKE :userSearch OR siteCity LIKE :userSearch ORDER BY id desc LIMIT $ShowPostFrom,12";
                                }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                    $sql ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND plotNumberApp ='None' AND firstName LIKE :userSearch OR lastName LIKE :userSearch OR emailAddress LIKE :userSearch OR siteCity LIKE :userSearch AND siteCity = '$adminSiteName' ORDER BY id desc LIMIT $ShowPostFrom,12";
                                }
                            $stmt=$ConnectingDB->prepare($sql);
                            $stmt->bindValue(':userSearch','%'.$userSearch.'%');
                            $stmt->execute();
                            }
                            // The default SQL query
                            else{
                                if($_SESSION["adminRole"] == "Super_Admin"){
                                    $sql  = "SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND plotNumberApp ='None' AND firstName LIKE :userSearch OR lastName LIKE :userSearch OR emailAddress LIKE :userSearch OR siteCity LIKE :userSearch ORDER BY id desc LIMIT 0,12";
                                }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                    $sql  = "SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND plotNumberApp ='None' AND firstName LIKE :userSearch OR lastName LIKE :userSearch OR emailAddress LIKE :userSearch OR siteCity LIKE :userSearch AND siteCity = '$adminSiteName' ORDER BY id desc LIMIT 0,12";
                                }    
                            $stmt =$ConnectingDB->prepare($sql);
                            $stmt->bindValue(':userSearch','%'.$userSearch.'%');
                            $stmt->execute();
                            }
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
                                <td><a class="btn btn-success" href="assignPlotToUser.php?userId=<?php echo $userId; ?>" role="button">Assign Plot</a></td>
                                </tr>   
                            </tbody>
                            <?php } ?>
                        </table>

                        <?php 
                        $SearchVariablesGet = '&userDetails='. $userSearch .'&SearchUser=' ;
                    ?>
                        <!-- Pagination -->
                        <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 mt-4">
                            <nav>
                                <ul class="pagination pagination-lg">
                                        <!-- Creating Backward Button -->
                                        <?php if( isset($Page) ) {
                                        if ( $Page>1 ) {?>
                                    <li class="page-item">
                                        <a class="page-link text-dark" href="assignPlotSearchResults.php?page=<?php  echo $Page-1 .$SearchVariablesGet; ?>">
                                        <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                        <?php } }?>
                                        <?php
                                        global $ConnectingDB;
                                        if($_SESSION["adminRole"] == "Super_Admin"){
                                            $sql = "SELECT COUNT(*) FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND plotNumberApp ='None' AND firstName LIKE :userSearch OR lastName LIKE :userSearch OR emailAddress LIKE :userSearch OR siteCity LIKE :userSearch ";
                                        }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                            $sql = "SELECT COUNT(*) FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND plotNumberApp ='None' AND firstName LIKE :userSearch OR lastName LIKE :userSearch OR emailAddress LIKE :userSearch OR siteCity LIKE :userSearch AND siteCity = '$adminSiteName' ";
                                        }
                                        $stmt          = $ConnectingDB->prepare($sql);
                                        $stmt->bindValue(':userSearch','%'.$userSearch.'%');
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
                                        <a class="page-link bg-dark" href="assignPlotSearchResults.php?page=<?php  echo $i .$SearchVariablesGet; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php
                                        }else {
                                        ?>
                                    <li class="page-item">
                                        <a class="page-link" href="assignPlotSearchResults.php?page=<?php  echo $i .$SearchVariablesGet; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php  }
                                        } } ?>
                                    
                                        <!-- Creating Forward Button -->
                                        <?php if ( isset($Page) && !empty($Page) ) {
                                            if ($Page+1 <= $PostPagination) {?>
                                    <li class="page-item">
                                        <a class="page-link bg-dark text-white" href="assignPlotSearchResults.php?page=<?php  echo $Page+1 .$SearchVariablesGet; ?>">
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