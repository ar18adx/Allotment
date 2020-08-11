<?php $pageTitle = "Inspection Search Result";?>


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
                
                <div class="row">
                    <!-- Include Admin Sidebar -->
                    <?php include("inc/adminSidebar.php");?>
                    <!-- Include Admin Sidebar -->   
                    <div class="col-md-9">
                        <form action="inspectionSearchResult.php" method="GET">
                                <?php
                                echo ErrorMessage();
                                echo SuccessMessage();
                                echo ErrorMessageForRg();
                                ?>
                            <input type="hidden" name="page" value="1">
                            <div class="row text-center mb-3">
                                <div class="col-md-3"></div>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Plot Number" name="plotNumSearch" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" name="inspectionSearch" class="btn btn-success">Search Records</button> 
                                </div>
                            </div>
                        </form>
                            <div class="text-center mb-4">
                                <h5> Result(s)</h5>
                            </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                <tr>
                                <th scope="col">PlotNumber</th>
                                <th scope="col">Site Name</th>
                                <th scope="col">Inspection Date</th>
                                <th scope="col">View Details</th>                                
                                </tr> 
                                </tr>
                            </thead>
                            <?php 
                            global $ConnectingDB;
                            // SQL query when Search button is active
                            if(isset($_GET["inspectionSearch"])){
                            $plotNumSearch = $_GET["plotNumSearch"];
                            if(empty($plotNumSearch)){
                                Redirect_to("inspectionReports.php?page=1");
                                $_SESSION["ErrorMessage"]= "Search field can not be empty";       
                            }

                            }
                            
                            // }// Query When Pagination is Active i.e Blog.php?page=1
                            if (isset($_GET["page"])) {
                                if($_SESSION["adminRole"] == "Super_Admin"){
                                    $sql = "SELECT * FROM inspectionreport WHERE plotNumber LIKE '$plotNumSearch' ";
                                }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                    $sql = "SELECT * FROM inspectionreport WHERE plotNumber LIKE '$plotNumSearch' AND siteName = '$adminSiteName' ";
                                }
                            $stmt = $ConnectingDB->prepare($sql);
                            // $stmt->bindValue(':search','%'.$Search.'%');
                            $stmt->execute();
                            $Page = $_GET["page"];
                            if($Page==0||$Page<1){
                            $ShowPostFrom=0;
                            }else{
                            $ShowPostFrom=($Page*12)-12;
                            }
                                if($_SESSION["adminRole"] == "Super_Admin"){
                                    $sql ="SELECT * FROM inspectionreport WHERE plotNumber LIKE '$plotNumSearch' ORDER BY id desc LIMIT $ShowPostFrom,12";
                                }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                    $sql ="SELECT * FROM inspectionreport WHERE plotNumber LIKE '$plotNumSearch' AND siteName = '$adminSiteName' ORDER BY id desc LIMIT $ShowPostFrom,12";
                                }
                            $stmt=$ConnectingDB->query($sql);
                            }
                            // The default SQL query
                            else{
                                if($_SESSION["adminRole"] == "Super_Admin"){
                                    $sql  = "SELECT * FROM inspectionreport WHERE plotNumber LIKE '$plotNumSearch' ORDER BY id desc LIMIT 0,12";
                                }elseif($_SESSION["adminRole"] == "Site_Manager"){
                                    $sql  = "SELECT * FROM inspectionreport WHERE plotNumber LIKE '$plotNumSearch' AND siteName = '$adminSiteName' ORDER BY id desc LIMIT 0,12";
                                }    
                            $stmt =$ConnectingDB->query($sql);
                            }
                            while ($DataRows=$stmt->fetch()) {
                                $id          = $DataRows["id"];
                                $plotNumber          = $DataRows["plotNumber"];
                                $siteName           = $DataRows["siteName"];
                                $inspectionDate      = $DataRows["inspectionDate"];
    
                            ?>
                            <tbody>
                                <tr>
                                <td><?php echo htmlentities($plotNumber)?></td>
                                <td><?php echo htmlentities($siteName)?></td>
                                <td><?php echo htmlentities($inspectionDate)?></td>
                                <td><a class="btn btn-dark" href="inspectionDetails.php?id=<?php echo $id?>" role="button">View Details</a></td>
                                </tr>   
                            </tbody>
                            <?php }?>
                        </table>
                        

                        <?php 
                        $SearchVariablesGet = '&plotNumSearch='. $plotNumSearch .'&inspectionSearch=' ;
                    ?>
                      
                                    
                    </div>
                </div>           
            </div>



<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->