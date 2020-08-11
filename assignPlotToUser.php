<?php $pageTitle = "Assign Plot To User";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
confirmAdminLogin(); 

////////////////////////////////////

                    $adminSiteName = $_SESSION["adminSiteName"];

                    $profileQueryParameter = $_GET["userId"];
                    global $ConnectingDB;
                    if($_SESSION["adminRole"] == "Super_Admin" ){
                        $sql ="SELECT * FROM waitinglist WHERE userId='$profileQueryParameter' AND applicationStatus = 'Awaiting_Plot' ";
                    }elseif($_SESSION["adminRole"] == "Site_Manager" ){
                        $sql ="SELECT * FROM waitinglist WHERE userId='$profileQueryParameter' AND applicationStatus = 'Awaiting_Plot' AND siteCity = '$adminSiteName' ";
                    }

                    $stmt = $ConnectingDB->query($sql);
                    $DataRows = $stmt->fetch();
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
                        $userFullName       = $firstName." ".$lastName;   
                        
                    
                        if($_SESSION["adminRole"] == "Super_Admin" && !isset($userId)){ 
                            Redirect_to("errorPage.php");
                            
                        }
                    
                        if($_SESSION["adminRole"] == "Site_Manager" && $siteCity != $adminSiteName ){ 
                            Redirect_to("errorPage.php");
                            
                        }

                        if (isset($_POST["AssignPlot"])) {
        
                            $plotNumberAssign           = $_POST["plotNumberAssign"];
                            $applicationStatusNew         = 'Pending_Confirmation';
                            $dateRecvNew      = date("Y-m-d");

                            if (CheckPlotNumExistsOrNot($plotNumberAssign)) {
                                $_SESSION["ErrorMessage"]= "Plot Does Not Exist !!! ";
                                Redirect_to("assignPlot.php?page=1");
                            }elseif(CheckPlotVacant($plotNumberAssign)){
                                $_SESSION["ErrorMessage"]= "Plot is not Vacant !!! ";
                                Redirect_to("assignPlot.php?page=1");
                            }else{

                                $emailTo    = $emailAddress;
                                $subject    = "Plot Availability Alert";
                                $message    = "Hello, There is a plot available for You."
                                                ."\n"."Log in to Your account to accept or reject the plot"
                                                ."\n\n"."http://allotment-com.stackstaging.com";
                                $headers    = "From: "."Allotment";

                                mail($emailTo, $subject, $message, $headers);

                                global $ConnectingDB;
                                $sql2t    = "SELECT id, plotSite, siteIdNum FROM plots WHERE plotNumber=:plotNumberAssigN";
                                $stmt2t   = $ConnectingDB->prepare($sql2t);
                                $stmt2t->bindValue(':plotNumberAssigN',$plotNumberAssign);
                                $stmt2t->execute();
                                $DataRows2t = $stmt2t->fetch();
                                $plotNumberRw              = $DataRows2t["plotNumber"];
                                $plotSiteRow          = $DataRows2t["plotSite"];
                                $idRow          = $DataRows2t["id"];
                                $siteIdRow          = $DataRows2t["siteIdNum"];

                                $sql ="UPDATE waitinglist SET siteCity ='$plotSiteRow', siteIdNum = '$siteIdRow', plotIdNum = '$idRow', plotNumberApp ='$plotNumberAssign', applicationStatus = '$applicationStatusNew', dateRecv = '$dateRecvNew' WHERE userId = '$userId' ";
                                $stmt = $ConnectingDB->prepare($sql);
                                $Execute=$stmt->execute();

                                $sqlD1 = "UPDATE users SET userStatus = 'Pending_Confirmation' WHERE id ='$userId' ";
                                $stmtD1 = $ConnectingDB->prepare($sqlD1);
                                $ExecuteD1=$stmtD1->execute();

                                $sql2 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumberAssign' ";
                                $stmt2 = $ConnectingDB->prepare($sql2);
                                $Execute2=$stmt2->execute();
                                    
                    
        
                                    
                                    if($Execute && $ExecuteD1 && $Execute2){
                                    $_SESSION["SuccessMessage"]="You have assigned a plot successfully";
                                    Redirect_to("assignPlot.php?page=1");
                                    }else {
                                    $_SESSION["ErrorMessageForRg"]= "Something went wrong. Try Again !";
                                    Redirect_to("assignPlot.php?page=1");
                                }
                        
                            }
                        
                        }

?>

    <!-- Admin Header Start -->
    <?php include("inc/adminHeader.php"); ?>
    <!-- Admin Header End -->

        <div class="container"> 

            <div class="row mt-5">
                <!-- Include Admin Sidebar -->
                <?php include("inc/adminSidebar.php");?>
                <!-- Include Admin Sidebar -->    
                <div class="col-md-9">
                    
                        <div class="mb-4 text-center">
                            <h1>User Profile</h1>
                        </div>
                        <br>
                            <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                            echo ErrorMessageForRg();
                            ?>
                                    
                        <div class="col-md-12 mb-4">
                            <div class="card text-white bg-dark">
                            <div class="card-body">
                                <h3 class="card-title"><b>User Name : </b> <?php echo htmlentities($userFullName)?></h3>
                                <h5 class="card-text"><b>Email Address : </b> <?php echo htmlentities($emailAddress)?></h5>
                                <h5 class="card-text"><b>Phone Number :</b> <?php echo htmlentities($telephoneNumber)?></h5>
                                <h5 class="card-text"><b>User City : </b> <?php echo htmlentities($userCity)?></h5>
                                <h5 class="card-text"><b>Site City :</b> <?php echo htmlentities($siteCity)?></h5> 
                                                                
                            <form action="assignPlotToUser.php?userId=<?php echo $userId; ?>" method="POST">    
                                <h3 class="card-text"><b>Plot Number :</b><input type="text" value="<?php echo htmlentities($plotNumberApp)?>" name="plotNumberAssign" aria-describedby="emailHelp"></h3> 
                                <h3 class="card-text"><button type="submit" name="AssignPlot" class="btn btn-warning">Assign Plot</button> </h3>                                         
                            </form>
                                
                            </div>
                            </div>
                            </a> 
                        </div>
                
                    
                </div>
            </div>
            
            
        </div>


    <!-- Admin Footer Start -->
    <?php include("inc/adminFooter.php"); ?>
    <!-- Admin Footer End -->


