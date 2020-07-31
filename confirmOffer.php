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

    // Fetch all users on the waitinglist
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
            $sql = "INSERT INTO tenants(tenantId, tenantFirstName, tenantLastName, tenantEmailAddress, tenantPhoneNum, tenantCity, siteId, siteCity, plotId, plotNumber, leaseDate, expirationDate, renewalStatus, tenantStatus )";
            $sql .= "VALUES('$tenantId', '$firstName', '$lastName', '$tenantEmailAddress', '$tenantPhoneNum', '$tenantCity', '$siteIdNumRw', '$siteCity', '$plotIdNumRw', '$plotNumber', '$leaseDate', '$expirationDate', '$renewalStatus', '$tenantStatus' )";
            $stmt = $ConnectingDB->prepare($sql);
            $Execute=$stmt->execute();

            $sql2 = "UPDATE plots SET plotStatus = 'Occupied', dateLastModified = '$dateApplied' WHERE plotNumber ='$plotNumber' ";
            $stmt2 = $ConnectingDB->prepare($sql2);
            $Execute2=$stmt2->execute();

            $sql3 = "UPDATE users SET userStatus = 'Tenant' WHERE id ='$tenantId' ";
            $stmt3 = $ConnectingDB->prepare($sql3);
            $Execute3=$stmt3->execute();
            
            if($Execute && $Execute2 && $Execute3){
                
                $sql43 = "DELETE FROM waitinglist WHERE userId = '$tenantId' ";
                $stmt43 = $ConnectingDB->prepare($sql43);
                $Execute43=$stmt43->execute();

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
            // Query to insert values in DB
            global $ConnectingDB;
            // Transfer the plot number to a user on the waitinglist whoose city is the SAME as their site.
            $sql04 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity = siteCity ";
            $stmt04 = $ConnectingDB->prepare($sql04);
            $stmt04->execute();
            $Result04 = $stmt04->rowcount();
            if($Result04 > 0) {

                $sqlCpa = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation' WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
                $stmtCpa = $ConnectingDB->prepare($sqlCpa);
                $ExecuteCpa=$stmtCpa->execute();
    
                $sqlSm = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
                $stmtSm = $ConnectingDB->query($sqlSm);
                while($DataRows=$stmtSm->fetch()){
                $applicantId             = $DataRows["id"];
                $applicantEmail          = $DataRows["emailAddress"];
                $applicantUserId         = $DataRows["userId"];
                $applicantFirstName      = $DataRows["firstName"];

                }
                    $emailTo    = $applicantEmail;
                    $subject    = "New Plot Availability Alert";
                    $message    = "Hello ".$applicantFirstName."\n"." There is a new plot available for You."
                                    ."\n"."Log into Your account below."
                                    ."\n\n"."http://allotment-com.stackstaging.com/";

                    $headers    = "From: "."Allotment";
    
                    mail($emailTo, $subject, $message, $headers);

                    $sqlC = "UPDATE users SET userStatus = 'Pending_Confirmation' WHERE id ='$applicantUserId' ";
                    $stmtC = $ConnectingDB->prepare($sqlC);
                    $ExecuteC=$stmtC->execute();

                
                $sqlE2 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumberApp' ";
                $stmtE2 = $ConnectingDB->prepare($sqlE2);
                $ExecuteE2=$stmtE2->execute();

                $sqlG4 = "UPDATE users SET userStatus = 'Awaiting_Plot' WHERE id ='$tenantId' ";
                $stmtG4 = $ConnectingDB->prepare($sqlG4);
                $ExecuteG4=$stmtG4->execute();

                $sqlRjc = "UPDATE waitinglist SET siteIdNum  = 'None', siteCity = '$siteCity', plotIdNum = 'None', plotNumberApp = 'None', applicationStatus = 'Awaiting_Plot', offerCount = offerCount + 1 WHERE userId = '$tenantId' ";
                $stmtRjc = $ConnectingDB->prepare($sqlRjc);
                $ExecuteRjc=$stmtRjc->execute();

                
                
            }elseif($Result04 == 0){
                // If there is no user on the waitinglist who lives in the same city as the site he/she applied for, then transfer 
                // the plot to a  user whoose city is different as the site he/she applied for.
                
                $sql07 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity !='siteCity' ";
                $stmt07 = $ConnectingDB->prepare($sql07);
                $stmt07->execute();
                $Result07 = $stmt07->rowcount();
                    if ($Result07 > 0) {
    
                        $sql1x = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation' WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
                        $stmt1x = $ConnectingDB->prepare($sql1x);
                        $Execute1x=$stmt1x->execute();
    
                        $sqlSmc = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
                        $stmtSmc = $ConnectingDB->query($sqlSmc);
                        while($DataRows=$stmtSmc->fetch()){
                        $applicantIdDc                     = $DataRows["id"];
                        $applicantEmailDc          = $DataRows["emailAddress"];
                        $applicantUserIdDc          = $DataRows["userId"];
                        $applicantFirstNameDc       = $DataRows["firstName"];

                        }
                            $emailTo    = $applicantEmailDc;
                            $subject    = "New Plot Availability Alert";
                            $message    = "Hello ".$applicantFirstNameDc."\n"." There is a new plot available for You. "
                                            ."\n"."Log into Your account below."
                                            ."\n\n"."http://allotment-com.stackstaging.com/";

                            $headers    = "From: "."Allotment";
            
                            mail($emailTo, $subject, $message, $headers);

                            $sqlC2 = "UPDATE users SET userStatus = 'Pending_Confirmation' WHERE id ='$applicantUserIdDc' ";
                            $stmtC2 = $ConnectingDB->prepare($sqlC2);
                            $ExecuteC2=$stmtC2->execute();

                        
    
    
                        $sqlE6 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumberApp' ";
                        $stmtE6 = $ConnectingDB->prepare($sqlE6);
                        $ExecuteE6=$stmtE6->execute();

    
                    }
                    
                    // If There are no users on the waitinglist, then set plot status to Vacant

                        if($Result07 == 0){
    
                            $sql92 = "UPDATE plots SET plotStatus = 'Vacant' WHERE plotNumber ='$plotNumberApp' ";
                            $stmt92 = $ConnectingDB->prepare($sql92);
                            $Execute92=$stmt92->execute();
                        }
    
            }
                
            if($ExecuteRjc){
                
            $_SESSION["SuccessMessage"]="You have Rejected the plot";
            Redirect_to("applyForPlots.php");

            }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("confirmOffer.php");
            }

            //Series of actions to be taken if a user with an Offer count of 1 Rejects a plot
        }elseif($offerCount >=1){
            $sqlSt8 = "UPDATE plots SET plotStatus = 'Vacant', dateLastModified = '$dateApplied' WHERE plotNumber ='$plotNumberApp' ";
            $stmtSt8 = $ConnectingDB->prepare($sqlSt8);
            $ExecuteSt8=$stmtSt8->execute();

            $sqlCp1 = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation' WHERE applicationStatus = 'Awaiting_Plot' AND siteCity = '$siteCity' ORDER BY id ASC LIMIT 1 ";
            $stmtCp1 = $ConnectingDB->prepare($sqlCp1);
            $ExecuteCp1=$stmtCp1->execute();

            $sqlNu3 = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
            $stmtNu3 = $ConnectingDB->prepare($sqlNu3);
            $ExecuteNu3=$stmtNu3->execute();

                if($ExecuteNu3 && $ExecuteSt8 && $ExecuteCp1){
                    $sqlDel2 = "DELETE FROM waitinglist WHERE userId = '$tenantId' ";
                    $stmtDel2 = $ConnectingDB->prepare($sqlDel2);
                    $ExecuteDel2=$stmtDel2->execute();

            $_SESSION["SuccessMessage"]="You have Rejected the 2 plots that were allocated to You. You will have to apply as a new user in order to get a plot";
            Redirect_to("applyForPlots.php");

            }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("confirmOffer.php");
            }
        }
        

    } //Ending of Reject Button If-Condition


        // Fourteen days count function

        $daysCountFourteen         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateApplied)). " + 14 day "));
        $start_dateF = date_create(date("Y-m-d"));
        $end_dateF   = date_create($daysCountFourteen);
        
        //difference between two dates
        $diff4 = date_diff($start_dateF,$end_dateF);
    

        if(date("Y-m-d") >= $daysCountFourteen && $offerCount <1){

            $sqlD14 = "UPDATE waitinglist SET siteIdNum  = 'None', siteCity = 'None', plotIdNum = 'None', plotNumberApp = 'None', applicationStatus = 'Awaiting_Plot', offerCount = offerCount + 1 WHERE userId = '$tenantId' ";
            $stmtD14 = $ConnectingDB->prepare($sqlD14);
            $ExecuteD14=$stmtD14->execute();

            $sqlU4 = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', siteCity = '$siteCity', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation' WHERE applicationStatus = 'Awaiting_Plot' AND userCity=sitecity ORDER BY id ASC LIMIT 1 ";
            $stmtU4 = $ConnectingDB->prepare($sqlU4);
            $ExecuteU4=$stmtU4->execute();

            if($ExecuteD14 && $ExecuteU4){

            $_SESSION["SuccessMessage"]="You did not accept the plot within 14 days";
            Redirect_to("applyForPlots.php");

            }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("confirmOffer.php");
            }
            
        }elseif(date("Y-m-d") >= $daysCountFourteen && $offerCount >=1){
            $sqlD1 = "UPDATE plots SET plotStatus = 'Vacant', dateLastModified = '$dateApplied' WHERE plotNumber ='$plotNumber' ";
            $stmtD1 = $ConnectingDB->prepare($sqlD1);
            $ExecuteD1=$stmtD1->execute();

            $sqlB14 = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation' WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
            $stmtB14 = $ConnectingDB->prepare($sqlB14);
            $ExecuteB14=$stmtB14->execute();

            $sqlA1 = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
            $stmtA1 = $ConnectingDB->prepare($sqlA1);
            $ExecuteA1=$stmtA1->execute();

            if($ExecuteD1 && $ExecuteB14 && $ExecuteA1){
                $sqlDelb = "DELETE FROM waitinglist WHERE userId = '$tenantId' ";
                $stmtDelb = $ConnectingDB->prepare($sqlDelb);
                $ExecuteDelb=$stmtDelb->execute();

            $_SESSION["SuccessMessage"]="You did not accept the 2 plots that were allocated to You. You will have to apply as a new user in order to get a plot";
            Redirect_to("applyForPlots.php");

            }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("confirmOffer.php");
            }
    
        }

        

            $sqlRc ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' ORDER BY id ASC ";
            $stmtRc = $ConnectingDB->prepare($sqlRc);
            $stmtRc->execute();
            $ResultRc = $stmtRc->rowcount();
            
            // Count a User's position on waiting list

            $sql = "SELECT COUNT(*) FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND id<=$id ";
            $stmt = $ConnectingDB->query($sql);
            $TotalRows= $stmt->fetch();
            $userPositionOnList=array_shift($TotalRows);

    ?>



<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
    
        <h1 class="mt-4">Hello, <?php echo $_SESSION["userFirstName"]; ?> !</h1>
        <?php if ($applicationStatus == "Awaiting_Plot"){?>
            <h3>Your Application for a plot was successful. You are in number <?php echo $userPositionOnList ?> position on the Waiting List out of <?php echo $ResultRc ?> applicants</h3>

                <div class="mt-3">
                    <h4>Cancel Application?</h4>
                    <p><i>Cancelling this application will make You apply as a New User</i></p>

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
            <?php }else{?>
            <h3>You have been allocated Plot "<?php echo htmlentities($plotNumberApp);?>" in "<?php echo htmlentities($siteCity); ?>" Site. If you are OK with this. You have <?php echo htmlentities($diff4->format("%a")) ; ?> days to ACCEPT or REJECT the offer.</h3>
                   
                    <br>
                    <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                    echo ErrorMessageForRg();
                    ?>
            <form action="confirmOffer.php" method="POST">
                <div class="row">
                    <div class="col-sm-6">
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