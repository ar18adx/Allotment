<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

    <?php
        // if($_SESSION["userStatus"] == "New_User"){
        //     Redirect_to("applyForPlots.php");
        // }elseif($_SESSION["userStatus"] == "Applied_For_Plot"){
        //     Redirect_to("confirmOffer.php");
        // }
    ?>

    <?php

    $tenantId                 =   $_SESSION["userId"];

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
    $offerCount          = $DataRows["offerCount"];
    $dateApplied        =   $DataRows["dateApplied"];
    
    

    ?>

    
    <?php

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

        // $leaseDate              = '';

        // $date=date_create($leaseDate);
        // date_add($date,date_interval_create_from_date_string("1 years"));
        $expirationDate         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($leaseDate)). " + 366 day "));
        $renewalStatus          = "Pending";
        $tenantStatus           = "Active";
        

        //Code to 
        //
            
        
        // Query to insert values in DB When everything is fine
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
        

    } //Ending of Accept Button If-Condition

    if(isset($_POST["Reject"])){
        
        
        if($offerCount <1){
            // Query to insert values in DB When everything is fine
            $sqlRjc = "UPDATE waitinglist SET siteIdNum  = 'None', siteCity = 'None', plotIdNum = 'None', plotNumberApp = 'None', applicationStatus = 'Awaiting_Plot', offerCount = offerCount + 1 WHERE userId = '$tenantId' ";
            $stmtRjc = $ConnectingDB->prepare($sqlRjc);
            $ExecuteRjc=$stmtRjc->execute();

            $sqlCp22 = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation' WHERE applicationStatus = 'Awaiting_Plot' AND siteCity = '$siteCity' ORDER BY id ASC LIMIT 1 ";
            $stmtCp22 = $ConnectingDB->prepare($sqlCp22);
            $ExecuteCp22=$stmtCp22->execute();
                
            if($ExecuteRjc && $ExecuteCp22){
                
            $_SESSION["SuccessMessage"]="You have Rejected the plot";
            Redirect_to("applyForPlots.php");

            }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("confirmOffer.php");
            }

        }elseif($offerCount >=1){
            $sqlSt8 = "UPDATE plots SET plotStatus = 'Vacant', dateLastModified = '$dateApplied' WHERE plotNumber ='$plotNumber' ";
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



        $daysCountFourteen         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateApplied)). " + 14 day "));
        $start_dateF = date_create(date("Y-m-d"));
        $end_dateF   = date_create($daysCountFourteen);
        
        //difference between two dates
        $diff4 = date_diff($start_dateF,$end_dateF);

        echo $daysCountFourteen;
        echo $plotNumberApp;
    

        // if(date("2020-07-26") >= $daysCountFourteen){
        //     $sqlExp = "UPDATE waitinglist SET offerCount = offerCount + 1 WHERE userId ='$tenantId' ";
        //     $stmtExp = $ConnectingDB->prepare($sqlExp);
        //     $ExecuteExp=$stmtExp->execute();
    
        // }

        // if($offerCount >= 1){
        //     $sqlDelof = "DELETE FROM waitinglist WHERE tenantId = '$tenantId' ";
        //     $stmtDelof = $ConnectingDB->prepare($sqlDelof);
        //     $ExecuteDelof=$stmtDelof->execute();
        // }
    ?>



<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
    
        <h1>Hello, <?php echo $_SESSION["userFirstName"]; ?> !</h1>
        <?php if ($plotNumberApp == "None"){?>
            <h3>Your Application for a plot was successful. A plot will be allocated to you soon.</h3>
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
                    <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Accept</label>
                            <div class="">
                                <button type="submit" name="Accept" class="btn btn-success">Accept</button>
                            </div>
                    </div>
                    <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Reject</label>
                            <div class="">
                                <button type="submit" name="Reject" class="btn btn-success">Reject</button>
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