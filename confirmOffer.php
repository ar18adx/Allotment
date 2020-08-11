<?php $pageTitle = "Confirm Offer";?>

<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php 


confirmUserLogin();
?>

    <?php
        if($_SESSION["userStatus"] == "Tenant"){
            Redirect_to("tenantProfile.php");
        }elseif($_SESSION["userStatus"] == "New_User"){
            Redirect_to("applyForPlots.php");
        }
    ?>

    <?php

    $tenantId                 =   $_SESSION["userId"];

    // Fetch users details on the waitinglist
    global $ConnectingDB;
    $sql ="SELECT * FROM waitinglist WHERE userId = '$tenantId'  ";
    $stmt = $ConnectingDB->query($sql);
    $DataRows=$stmt->fetch();
    $id                     = $DataRows["id"];
    // $userIdRow                     = $DataRows["userId"];
    $firstName          = $DataRows["firstName"];
    $lastName          = $DataRows["lastName"];
    $emailAddress	          = $DataRows["emailAddress"];
    $telephoneNumber          = $DataRows["telephoneNumber"];
    $userCity          = $DataRows["userCity"];
    $siteIdNum           = $DataRows["siteIdNum"];
    $siteCity          = $DataRows["siteCity"];
    $plotIdNum          = $DataRows["plotIdNum"];
    $plotNumberApp          = $DataRows["plotNumberApp"];
    $applicationStatus          = $DataRows["applicationStatus"];
    $offerCount          = $DataRows["offerCount"];
    $dateApplied        =   $DataRows["dateApplied"];
    $dateRecvRow        =   $DataRows["dateRecv"];
    $dateRecv               = date("Y-m-d");
    
    

    ?>

    
    <?php

    // Code for cancelling an existing Application

    if(isset($_POST["cancelApplication"])){

        $tenantId                 =   $_SESSION["userId"];
        
        $sqlD = "DELETE FROM waitinglist WHERE userId = '$tenantId' ";
        $stmtD = $ConnectingDB->prepare($sqlD);
        $ExecuteD=$stmtD->execute();

        $sqlGu = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
        $stmtGu = $ConnectingDB->prepare($sqlGu);
        $ExecuteGu=$stmtGu->execute();

            if($ExecuteD && $ExecuteGu){
                    
                $_SESSION["SuccessMessage"]="You have Cancelled Your application for a plot. You can now apply as a new user";
                Redirect_to("applyForPlots.php");

                }else {
                $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
                Redirect_to("confirmOffer.php");
            }

        
    } //Ending of Cancel Application Button If-Condition


    // Integrating the Accept button with the information to be sent to the Tenants table

    if(isset($_POST["Accept"])){
        
        $tenantId               =   $_SESSION["userId"];;
        $tenantFirstName        =   $firstName;
        $tenantLastName         =   $lastName;
        $tenantEmailAddress     =   $emailAddress;
        $tenantPhoneNum         =   $telephoneNumber;
        $tenantCity             =   $userCity;
        $siteIdNumRw            =   $siteIdNum;
        $siteCity               =   $siteCity;
        $plotIdNumRw            =   $plotIdNum;
        $plotNumber             =   $plotNumberApp;
        
        date_default_timezone_set("Africa/Lagos");
        
        $leaseDate              = date("Y-m-d "); 
        $expirationDate         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($leaseDate)). " + 365 day "));
        $renewalStatus          = "Pending";
        $tenantStatus           = "Active";
        
        // Check if the plot exists on the tenant table in order to avoid duplicate records
         
        if (CheckPlotNumTnt($plotNumberApp)) {
            $_SESSION["ErrorMessage"]= "This Plot is occupied already !!! ";
            Redirect_to("confirmOffer.php");
        }else{
            
        
            // Query to insert values into the tenants table
            global $ConnectingDB;
            $sql3 = "UPDATE users SET userStatus = 'Tenant' WHERE id ='$tenantId' ";
            $stmt3 = $ConnectingDB->prepare($sql3);
            $Execute3=$stmt3->execute();
            
            $sql = "INSERT INTO tenants(tenantId, tenantFirstName, tenantLastName, tenantEmailAddress, tenantPhoneNum, tenantCity, siteId, siteCity, plotId, plotNumber, leaseDate, expirationDate, renewalStatus, tenantStatus )";
            $sql .= "VALUES('$tenantId', '$firstName', '$lastName', '$tenantEmailAddress', '$tenantPhoneNum', '$tenantCity', '$siteIdNumRw', '$siteCity', '$plotIdNumRw', '$plotNumber', '$leaseDate', '$expirationDate', '$renewalStatus', '$tenantStatus' )";
            $stmt = $ConnectingDB->prepare($sql);
            $Execute=$stmt->execute();

            $sql2 = "UPDATE plots SET plotStatus = 'Occupied', dateLastModified = '$dateApplied' WHERE plotNumber ='$plotNumber' ";
            $stmt2 = $ConnectingDB->prepare($sql2);
            $Execute2=$stmt2->execute();

            
            if($Execute && $Execute2 && $Execute3){
                
                $sql43 = "DELETE FROM waitinglist WHERE userId = '$tenantId' ";
                $stmt43 = $ConnectingDB->prepare($sql43);
                $Execute43=$stmt43->execute();

                $_SESSION["userStatus"] = 'Tenant';

                $_SESSION["SuccessMessage"]="You have accepted the plot";
                Redirect_to("tenantProfile.php");
                

            }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("confirmOffer.php");
            }
        
        }
    } //Ending of Accept Button If-Condition

    //Series of action to be taken when a user with an Offer count lower than 1 rejects a plot

    if(isset($_POST["Reject"])){
        
        if($offerCount <1){
            //Waiting List Function For an offer count LESS than 1
            waitingListPlotTransferOcLess1();

            //Series of actions to be taken if a user with an Offer count of 1 Rejects a plot
        }elseif($offerCount >=1){
            //Waiting List Function For an offer count greater than 1
            waitingListPlotTransferOcg1();
           
        }
        

    } //Ending of Reject Button If-Condition


        // Fourteen days count function

        $daysCountFourteen         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateRecvRow)). " + 14 day "));
        $start_dateF = date_create(date("Y-m-d"));
        $end_dateF   = date_create($daysCountFourteen);
        
        //difference between two dates
        $diff4 = date_diff($start_dateF,$end_dateF);
        $todayDate = date("Y-m-d");

            //Total Number of users on the waiting list
            $sqlRc ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' ORDER BY id ASC ";
            $stmtRc = $ConnectingDB->prepare($sqlRc);
            $stmtRc->execute();
            $ResultRc = $stmtRc->rowcount();
            
            ///SQL query to count a user's Poaition on the waiting list
            $sql ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND id <= $id ";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->execute();
            $userPositionOnList = $stmt->rowcount();
    ?>



<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
    
        <h1 class="mt-4">Hello, <?php echo $_SESSION["userFirstName"]; ?> !</h1>
        <?php if ($applicationStatus == "Awaiting_Plot"){?>
            <h3>You are in number <?php echo $userPositionOnList ?> position on the Waiting List out of <?php echo $ResultRc ?> applicant(s)</h3>

                <div class="mt-3">
                    <h4>Cancel Application?</h4>
                    <p><i>Cancelling this application will take You Off the waiting list.</i></p>

                        <div class="card alert-warning">
                            <div class="card-body">
                                <form action="confirmOffer.php" method="POST">
                                    <h5 class="card-title">Cancel Application</h5>
                                    <p class="card-text"></p>
                                        <button type="submit" name="cancelApplication" class="btn btn-lg btn-danger">Cancel Application</button>
                                </form>
                            </div>
                        </div>

                </div>
            <?php }elseif($applicationStatus == 'Pending_Confirmation'){?>
            <h3>You have been allocated Plot "<?php echo htmlentities($plotNumberApp);?>" in "<?php echo htmlentities($siteCity); ?>" Site. If you are OK with this. You have <?php echo htmlentities($diff4->format("%a")) ; ?> days to ACCEPT or REJECT the offer.</h3>
                   
                    <br>
                    <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                    echo ErrorMessageForRg();
                    ?>
            <form action="confirmOffer.php" method="POST">
                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <div class="card alert-success">
                        <div class="card-body">
                            <h5 class="card-title">Accept</h5>
                            <p class="card-text"></p>
                                <button type="submit" name="Accept" class="btn btn-lg btn-success">Accept</button>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card alert-danger">
                        <div class="card-body">
                            <h5 class="card-title">Reject</h5>
                            <p class="card-text"></p>
                                <button type="submit" name="Reject" class="btn btn-lg btn-danger">Reject</button>
                        </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php }?>
    

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>