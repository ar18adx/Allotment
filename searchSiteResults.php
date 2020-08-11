<?php $pageTitle = "Search Site Results";?>


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
            
                </div>
                <div class="row">
                    <!-- Include Admin Sidebar -->
                    <?php include("inc/adminSidebar.php");?>
                    <!-- Include Admin Sidebar -->   
                    <div class="col-md-9">
                            <form action="searchSiteResults.php" method="GET">
                                <input type="hidden" name="page" value="1">
                                <div class="row text-center mb-3">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-4">
                                        <input type="text" name="siteDetails" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" name="SearchSite" class="btn btn-success">Search Site</button> 
                                    </div>
                                </div>
                            </form>
                            <div class="text-center mb-4">
                                <h5>Result(s)</h5>
                            </div>

                        <div class="row">
                            <?php 
                            global $ConnectingDB;
                            // SQL query when Search button is active
                            if(isset($_GET["SearchSite"])){
                                $siteDetailsSearch = $_GET["siteDetails"];
                                if(empty($siteDetailsSearch)){
                                    Redirect_to("viewSites.php?page=1");
                                    $_SESSION["ErrorMessage"]= "Search field can not be empty";       
                                }

                            }

                        
                            // }// Query When Pagination is Active i.e Blog.php?page=1
                            if (isset($_GET["page"])) {

                                $sql = "SELECT * FROM cities WHERE cityName LIKE :siteDetailsSearch OR cityShortCode LIKE :siteDetailsSearch ORDER BY cityName ";

                            $stmt = $ConnectingDB->prepare($sql);
                            $stmt->bindValue(':siteDetailsSearch','%'.$siteDetailsSearch.'%');
                            $stmt->execute();
                            $Page = $_GET["page"];
                            if($Page==0||$Page<1){
                            $ShowPostFrom=0;
                            }else{
                            $ShowPostFrom=($Page*12)-12;
                            }
                
                                    $sql ="SELECT * FROM cities WHERE cityName LIKE :siteDetailsSearch OR cityShortCode LIKE :siteDetailsSearch ORDER BY id desc LIMIT $ShowPostFrom,12";
                        
                            $stmt=$ConnectingDB->prepare($sql);
                            $stmt->bindValue(':siteDetailsSearch','%'.$siteDetailsSearch.'%');
                            $stmt->execute();
                            }
                            // The default SQL query
                            else{
                                
                                    $sql  = "SELECT * FROM cities WHERE cityName LIKE :siteDetailsSearch OR cityShortCode LIKE :siteDetailsSearch ORDER BY id desc LIMIT 0,12";
                                   
                            $stmt =$ConnectingDB->prepare($sql);
                            $stmt->bindValue(':siteDetailsSearch','%'.$siteDetailsSearch.'%');
                            $stmt->execute();
                            }
                                while ($DataRows = $stmt->fetch()) {
                                $id                     = $DataRows["id"];
                                $cityName                     = $DataRows["cityName"];
                                $cityShortCode                     = $DataRows["cityShortCode"];
                                
                                    $sqlCt ="SELECT * FROM plots WHERE plotSite ='$cityName'";
                                    $stmtCt = $ConnectingDB->prepare($sqlCt);
                                    $stmtCt->execute();
                                    $ResultCt = $stmtCt->rowcount();
        
                                    $sqlVc ="SELECT * FROM plots WHERE plotSite = '$cityName' AND plotStatus ='Vacant'";
                                    $stmtVc = $ConnectingDB->prepare($sqlVc);
                                    $stmtVc->execute();
                                    $ResultVc = $stmtVc->rowcount();
        
                                    $sqlTc ="SELECT * FROM tenants WHERE siteCity = '$cityName' ";
                                    $stmtTc = $ConnectingDB->prepare($sqlTc);
                                    $stmtTc->execute();
                                    $ResultTc = $stmtTc->rowcount();
        
                                    $sqlWl ="SELECT * FROM waitinglist WHERE siteCity = '$cityName' ";
                                    $stmtWl = $ConnectingDB->prepare($sqlWl);
                                    $stmtWl->execute();
                                    $ResultWl = $stmtWl->rowcount();
            

                            ?>

                            <div class="col-sm-6 mb-4">
                                <a class="bg-dark text-white" href="siteDetails.php?page=1&cityName=<?php echo $cityName; ?>">
                                <div class="card text-white bg-dark">
                                <div class="card-body">
                                    <h2 class="card-title"><?php echo htmlentities($cityName." (".$cityShortCode).")";?></h2>
                                    <h4 class="card-text"><?php echo htmlentities($ResultCt); ?> Total <?php if($ResultCt <=1){echo "Plot";}elseif($ResultCt >1){echo "Plots";}?> </h4>
                                    <h5 class="card-text"><?php echo htmlentities($ResultTc); ?> <?php if($ResultTc <=1){echo "Tenant";}elseif($ResultTc >1){echo "Tenants";}?></h5>
                                    <h5 class="card-text"><?php echo htmlentities($ResultVc); ?> Vacant <?php if($ResultVc <=1){echo "Plot";}elseif($ResultVc >1){echo "Plots";}?> </h5>
                                    <h5 class="card-text"><?php echo htmlentities($ResultWl); ?> <?php if($ResultWl <=1){echo "User";}elseif($ResultWl >1){echo "Users";}?> <?php if($ResultWl <=1){echo "is";}elseif($ResultWl >1){echo "are";}?> on the Waiting List</h5> 
                                    <h5 class="card-text mt-3"><td><a class="btn btn-danger delConfirmMsg" href="deleteSiteFrmTb.php?id=<?php echo $id?>" role="button">Delete Site</a></td></h5> 
                                    
                                </div>
                                </div>
                                </a> 
                            </div>
                            
                            <?php } ?>
                        </div>

                        <?php 
                        $SearchVariablesGet = '&siteDetails='. $siteDetailsSearch .'&SearchSite=' ;
                    ?>
                        <!-- Pagination -->
                        <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 mt-4">
                            <nav>
                                <ul class="pagination pagination-lg">
                                        <!-- Creating Backward Button -->
                                        <?php if( isset($Page) ) {
                                        if ( $Page>1 ) {?>
                                    <li class="page-item">
                                        <a class="page-link text-dark" href="searchSiteResults.php?page=<?php echo $Page-1 .$SearchVariablesGet ; ?>">
                                        <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                        <?php } }?>
                                        <?php
                                        global $ConnectingDB;
                                            $sql = "SELECT COUNT(*) FROM cities WHERE cityName LIKE :siteDetailsSearch OR cityShortCode LIKE :siteDetailsSearch ";
                                        
                                        $stmt          = $ConnectingDB->prepare($sql);
                                        $stmt->bindValue(':siteDetailsSearch','%'.$siteDetailsSearch.'%');
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
                                        <a class="page-link bg-dark" href="searchSiteResults.php?page=<?php  echo $i .$SearchVariablesGet; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php
                                        }else {
                                        ?>
                                    <li class="page-item">
                                        <a class="page-link" href="searchSiteResults.php?page=<?php  echo $i .$SearchVariablesGet; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php  }
                                        } } ?>
                                    
                                        <!-- Creating Forward Button -->
                                        <?php if ( isset($Page) && !empty($Page) ) {
                                            if ($Page+1 <= $PostPagination) {?>
                                    <li class="page-item">
                                        <a class="page-link bg-dark text-white" href="searchSiteResults.php?page=<?php  echo $Page+1 .$SearchVariablesGet; ?>">
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

<!-- Javascript for the delete Site -->
<script type="text/javascript">
    $('.delConfirmMsg').on('click', function () {
        return confirm('Are You Sure You Want To Delete this Site?');
    })    
</script>