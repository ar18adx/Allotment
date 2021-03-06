<?php $pageTitle = "Profile";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php 
confirmUserLogin()
?>

    <?php
        if($_SESSION["userStatus"] == "Awaiting_Plot"){
            Redirect_to("confirmOffer.php");
        }elseif($_SESSION["userStatus"] == "New_User"){
            Redirect_to("applyForPlots.php");
        }
    ?>

    <?php

    $tenantId                 =   $_SESSION["userId"];

    global $ConnectingDB;
    $sql ="SELECT * FROM tenants WHERE tenantId = '$tenantId'  ";
    $stmt = $ConnectingDB->query($sql);
    $DataRows=$stmt->fetch();
    $id                     = $DataRows["id"];
    // $userIdRow                     = $DataRows["userId"];
    $tenantFirstName          = $DataRows["tenantFirstName"];
    $tenantLastName          = $DataRows["tenantLastName"];
    $tenantEmailAddress	          = $DataRows["tenantEmailAddress"];
    $tenantPhoneNum          = $DataRows["tenantPhoneNum"];
    $tenantCity           = $DataRows["tenantCity"];
    $siteCity          = $DataRows["siteCity"];
    $siteId          = $DataRows["siteId"];
    $plotNumber          = $DataRows["plotNumber"];
    $leaseDate          = $DataRows["leaseDate"];
    $expirationDate          = $DataRows["expirationDate"];
    $renewalStatus          = $DataRows["renewalStatus"];

    $changeLeaseDateFormat       = date("F-d-Y", strtotime($leaseDate));
    $changeExpDateFormat       = date("F-d-Y", strtotime($expirationDate));

    $expirationDateNotification        = date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDate)). " - 90 day "));

    $oneMonthToExp        = date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDate)). " - 30 day "));

    $expirationDateTrigger =    date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDate)). " - 91 day "));

    $expirationDateTrnsf =    date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDate)). " - 3 day "));

    $expirationDateMinus1 =    date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDate)). " - 1 day "));


    

            // Code to notify the tenant on the number of days before expiry 
            $start_date = date_create(date("Y-m-d"));
            $end_date   = date_create($expirationDate);
            
            //difference between two dates
            $diff = date_diff($start_date,$end_date);


    if(date("Y-m-d") >= $oneMonthToExp){
        $sqlSv = "UPDATE plots SET plotStatus = 'Soon_Vacant' WHERE plotNumber ='$plotNumber' ";
        $stmtSv = $ConnectingDB->prepare($sqlSv);
        $ExecuteSv=$stmtSv->execute();

    }

    
    if(date("Y-m-d") >= $expirationDate){
        // Insert Tenant's information into The formertenants table
        $sqlTrn = "INSERT INTO formertenants(tenantId, tenantFirstName, tenantLastName, tenantEmailAddress, tenantPhoneNum, tenantCity, siteCity, plotNumber, leaseDate, expirationDate )";
        $sqlTrn .= "VALUES('$tenantId', '$tenantFirstName', '$tenantLastName', '$tenantEmailAddress', '$tenantPhoneNum', '$tenantCity', '$siteCity', '$plotNumber', '$leaseDate', '$expirationDate')";
        $stmtTrn = $ConnectingDB->prepare($sqlTrn);
        $ExecuteTrn=$stmtTrn->execute();

        $sqlExp = "UPDATE plots SET plotStatus = 'Vacant' WHERE plotNumber ='$plotNumber' ";
        $stmtExp = $ConnectingDB->prepare($sqlExp);
        $ExecuteExp=$stmtExp->execute();

        // Transfer the plot number to a user on the waitinglist whoose city is the same as their site.
        $sql04 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity = siteCity ";
        $stmt04 = $ConnectingDB->prepare($sql04);
        $stmt04->execute();
        $Result04 = $stmt04->rowcount();
        if ($Result04 > 0) {

            $sqlCpa = "UPDATE waitinglist SET siteIdNum = '$siteId', plotIdNum = '$id', plotNumberApp = '$plotNumber', applicationStatus ='Pending_Confirmation' WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
            $stmtCpa = $ConnectingDB->prepare($sqlCpa);
            $ExecuteCpa=$stmtCpa->execute();

            // Send email to the user on the waiting list
            $sqlSk = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
            $stmtSk = $ConnectingDB->query($sqlSk);
            while ($DataRows=$stmtSk->fetch()) {
            $applicantId             = $DataRows["id"];
            $applicantEmail          = $DataRows["emailAddress"];
            $applicantFirstName      = $DataRows["firstName"];
            }

                $emailTo    = $applicantEmail;
                $subject    = "New Plot Availability Alert";
                $message    = "Hello ".$applicantFirstName."\n"." There is a new plot available for You."
                                ."\n"."Log into Your account below."
                                ."\n\n"."http://allotment-com.stackstaging.com/";

                $headers    = "From: "."Allotment";

                mail($emailTo, $subject, $message, $headers);

            $sqlE2 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumber' ";
            $stmtE2 = $ConnectingDB->prepare($sqlE2);
            $ExecuteE2=$stmtE2->execute();


        }elseif($Result04 == 0){
            // If there is no user on the waitinglist who lives in the same city as the site he/she applied for, then transfer 
            // the plot to a  user whoose city is different as the site he/she applied for.

            $sql07 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity !='siteCity' ";
            $stmt07 = $ConnectingDB->prepare($sql07);
            $stmt07->execute();
            $Result07 = $stmt07->rowcount();
                if ($Result07 > 0) {

                    $sql1x = "UPDATE waitinglist SET siteIdNum = '$siteId', plotIdNum = '$id', plotNumberApp = '$plotNumber', applicationStatus ='Pending_Confirmation' WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
                    $stmt1x = $ConnectingDB->prepare($sql1x);
                    $Execute1x=$stmt1x->execute();

                    $sqlSm = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
                    $stmtSm = $ConnectingDB->query($sqlSm);
                    while ($DataRows=$stmtSm->fetch()) {
                    $applicantIdDs                    = $DataRows["id"];
                    $applicantEmailDs          = $DataRows["emailAddress"];
                    $applicantFirstNameDs      = $DataRows["firstName"];
                    }

                        $emailTo    = $applicantEmailDs;
                        $subject    = "New Plot Availability Alert";
                        $message    = "Hello ".$applicantFirstNameDs."\n"." There is a new plot available for You."
                                        ."\n"."Log into Your account below."
                                        ."\n\n"."http://allotment-com.stackstaging.com/";
        
                        $headers    = "From: "."Allotment";
        
                        mail($emailTo, $subject, $message, $headers);

                    $sqlE6 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumber' ";
                    $stmtE6 = $ConnectingDB->prepare($sqlE6);
                    $ExecuteE6=$stmtE6->execute();

                }

                    // If there are no users on the waitinglist, then set the plot status to Vacant

                    if($Result07 == 0){

                        $sql92 = "UPDATE plots SET plotStatus = 'Vacant' WHERE plotNumber ='$plotNumber' ";
                        $stmt92 = $ConnectingDB->prepare($sql92);
                        $Execute92=$stmt92->execute();
                    }

        }
            // Set the tenant's status to a new User

            $sqlUpd = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
            $stmtUpd = $ConnectingDB->prepare($sqlUpd);
            $ExecuteUpd=$stmtUpd->execute();

        
            if($ExecuteTrn){
                    //If the tenant's records were successfully transfered to the formertenants table,
                    //then delete the tenant from the tenants tabl and then log the tenant out

                $sqlDel = "DELETE FROM tenants WHERE tenantId='$tenantId' ";
                $stmtDel = $ConnectingDB->prepare($sqlDel);
                $ExecuteDel=$stmtDel->execute();

                $_SESSION["userId"]=null;
                session_destroy();
                Redirect_to("index.php");

            }

    }

    
    ?>

<?php
 //Renew lease for one year
if(isset($_POST["oneYear"])){
    
    $renewLeaseForOneYear = date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDate)). " + 365 day "));
    
    // Query to insert values in DB When everything is fine
        $sqlR1 = "UPDATE tenants SET expirationDate = '$renewLeaseForOneYear' WHERE tenantId ='$tenantId' ";
        $stmtR1 = $ConnectingDB->prepare($sqlR1);
        $ExecuteR1=$stmtR1->execute(); 
        
            $sql2 = "UPDATE tenants SET renewalStatus = 'Will_Renew' WHERE tenantId ='$tenantId' ";
            $stmt2 = $ConnectingDB->prepare($sql2);
            $Execute2=$stmt2->execute();
    
    
    if($ExecuteR1 && $Execute2){
    $_SESSION["SuccessMessage"]="You have renewed successfully Your lease for One Year";
    Redirect_to("tenantProfile.php");
    }else {
    $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
    Redirect_to("tenantProfile.php");
    }
    

} //Ending of oneYear Button If-Condition

// Renew Lease For Six months
if(isset($_POST["sixMonths"])){
    
    $renewLeaseForSixMonths = date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDate)). " + 6 month "));
    
    // Query to insert values in DB When everything is fine
        global $ConnectingDB;
        $sqlR6 = "UPDATE tenants SET expirationDate = '$renewLeaseForSixMonths' WHERE tenantId ='$tenantId' ";
        $stmtR6 = $ConnectingDB->prepare($sqlR6);
        $ExecuteR6=$stmtR6->execute();  
        
            global $ConnectingDB;
            $sql3 = "UPDATE tenants SET renewalStatus = 'Will_Renew' WHERE tenantId ='$tenantId' ";
            $stmt3 = $ConnectingDB->prepare($sql3);
            $Execute3=$stmt3->execute();
    
    // $Execute3=$stmt3->execute();
    if($ExecuteR6 && $Execute3){
    $_SESSION["SuccessMessage"]="You have renewed successfully Your lease for six months";
    Redirect_to("tenantProfile.php");
    }else {
    $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
    Redirect_to("tenantProfile.php");
    }
    

} //Ending of Six Months Button If-Condition

?>

<?php //if($_SESSION["userStatus"] == "Tenant"){?>

    <!-- Header Start -->
    <?php include("inc/header.php"); ?>
    <!-- header End -->

        <div class="container">
            <div class="row">
                <!-- User Sidebar -->
                <?php include("inc/userSidebar.php");?>
                <!-- User Sidebar End -->
                <div class="col-md-9">
                    <div class="jumbotron mt-5">
                        <h1 class="">Hello, <?php echo $_SESSION["userFirstName"]." ".$_SESSION["userLastName"]; ?></h1>
                        <h3 class=""><b>You are a Tenant in : </b><?php echo htmlentities($siteCity)?></h3>
                        <h3 class=""><b>Your Plot-Number is : </b><?php echo htmlentities($plotNumber)?></h3>
                        <h3 class=""><b>Lease Date :</b> <?php echo htmlentities($changeLeaseDateFormat) ?></h3>
                        <h3 class=""><b>Expiry Date :</b> <?php echo htmlentities($changeExpDateFormat) ?></h3>
                                <br>
                                <?php
                                echo ErrorMessage();
                                echo SuccessMessage();
                                echo ErrorMessageForRg();
                                ?>

                        <hr class="my-4">
                        
                        <!-- Display a message to the tanant if the tenant did not renew his/her lease -->

                        <?php if(date("Y-m-d") >= $oneMonthToExp){?>
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">Notice!</h4>
                                <!-- Get the number of days remainig on lease when it is one month to expiry date -->
                                <p>Your Account will expire in <?php echo htmlentities($diff->format("%a")) ; ?> days.</p>
                                <p>You did not renew Your lease, So the plot will go to someone else after Your expiration date</p>
                                <hr>
                            </div>
                            
                        <!-- Display a message an options for the tenant to renew his/her Lease -->

                        <?php }elseif(date("Y-m-d") >= $expirationDateNotification){?>
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">Notice!</h4>
                                <!-- Get the number of days remainig on lease when it is one month to expiry date -->
                                <p>Your Account will expire in <?php echo htmlentities($diff->format("%a")) ; ?> days.</p>
                                <p><i>You will be unable to renew Your lease when it is 30 days to Your lease expiry date.</i></p>
                                <p>Select Your duration of renewal below:</p>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card alert-danger">
                                        <div class="card-body">
                                            <h5 class="card-title">Renew For 1 Year</h5>
                                            <p class="card-text"></p>
                                            <form action="tenantProfile.php" method="POST">
                                                <button type="submit" name="oneYear" class="btn btn-info">Renew For 1 Year</button>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card alert-danger">
                                        <div class="card-body">
                                            <h5 class="card-title">Renew For 6 Months</h5>
                                            <p class="card-text"></p>
                                            <form action="tenantProfile.php" method="POST">
                                                <button type="submit" name="sixMonths" class="btn btn-info">Renew For 6 Months</button>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>

    <!-- Footer Start -->
    <?php include("inc/footer.php") ;?>
    <!-- Footer End -->

<?php

// }else{
//     Redirect_to("errorPage.php");
// } 

?>