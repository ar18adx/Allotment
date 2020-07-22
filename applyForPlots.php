<?php $pageTitle = "Apply For a Plot";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

    if(isset($_POST["Apply"])){
        date_default_timezone_set("Africa/Lagos");
        $CurrentTime            =  time();
        $dateApplied            = date("Y-m-d");
        $userId                 =   $_SESSION["userId"];
        $firstName              = $_SESSION["userFirstName"];
        $lastName               = $_SESSION["userLastName"];
        $emailAddress           = $_SESSION["userEmailAddress"];
        $telephoneNumber        = $_SESSION["userTelephone"];
        $userCity               = $_SESSION["userCity"];
        $siteCity               = $_POST["siteCity"];
        $plotNumberApp          = $_POST["plotNumberApp"];
        // $applicationStatus      = "Pending";
        $offerCount             = 0;
        

        //Code to 
        //
        // $sql ="SELECT * FROM plots WHERE plotSite ='$siteCity' AND plotStatus = 'Vacant' ORDER BY RAND() ";    

            $userCity = $_SESSION["userCity"];
            global $ConnectingDB;
            $sql ="SELECT * FROM plots WHERE plotSite ='$siteCity' AND plotStatus = 'Vacant' ORDER BY RAND() LIMIT 1 ";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->execute();
            $Result = $stmt->rowcount();
            if ($Result > 0) {
                 
                $DataRows=$stmt->fetch();
                $plotIdNum                     = $DataRows["id"];
                $plotNumber          = $DataRows["plotNumber"];
                $plotStatus          = $DataRows["plotStatus"];
                $siteIdNum           = $DataRows["siteIdNum"];
                if(empty($plotNumberApp)){
                    $plotNumberApp = $plotNumber;
                }    
        
                if (CheckPlotNumExistsOrNot($plotNumberApp)) {
                    $_SESSION["ErrorMessage"]= "Plot Number Does Not Exists.!! ";
                    Redirect_to("applyForPlots.php");
                }
           
        
                // Query to insert values in DB
                $sql = "INSERT INTO waitinglist( userId, firstName, lastName, emailAddress, telephoneNumber, userCity, siteIdNum, siteCity, plotIdNum, plotNumberApp, applicationStatus, offerCount, dateApplied )";
                $sql .= "VALUES('$userId', '$firstName', '$lastName', '$emailAddress', '$telephoneNumber', '$userCity', '$siteIdNum', '$siteCity', '$plotIdNum', '$plotNumberApp', 'Pending_Confirmation', '$offerCount', '$dateApplied'  )";
                $stmt = $ConnectingDB->prepare($sql);
                $Execute=$stmt->execute();
                // if($plotStatus == "Vacant"){

                    $sql2 = "UPDATE plots SET plotStatus = 'On_Offer', dateLastModified = '$dateApplied' WHERE plotNumber ='$plotNumberApp' ";
                    $stmt2 = $ConnectingDB->prepare($sql2);
                    $Execute2=$stmt2->execute();
                //}

                $sql3 = "UPDATE users SET userStatus = 'Pending_Confirmation' WHERE id ='$userId' ";
                $stmt3 = $ConnectingDB->prepare($sql3);
                $Execute3=$stmt3->execute();

                Redirect_to("confirmOffer.php");
        
            }elseif($Result == 0){

                $noValEmpty    = "None";
                
                // if(empty($plotNumberApp)){
                //     $plotNumberApp = $noValEmpty;
                // } 

                $sql77 = "INSERT INTO waitinglist( userId, firstName, lastName, emailAddress, telephoneNumber, userCity, siteIdNum, siteCity, plotIdNum, plotNumberApp, applicationStatus, offerCount, dateApplied )";
                $sql77 .= "VALUES('$userId', '$firstName', '$lastName', '$emailAddress', '$telephoneNumber', '$userCity', 'None', '$siteCity', 'None', 'None', 'Awaiting_Plot', '$offerCount', '$dateApplied'  )";
                $stmt77 = $ConnectingDB->prepare($sql77);
                $Execute77=$stmt77->execute();

                $sql44 = "UPDATE users SET userStatus = 'Awaiting_Plot' WHERE id ='$userId' ";
                $stmt44 = $ConnectingDB->prepare($sql44);
                $Execute44=$stmt44->execute();

                if($Execute77 && $Execute44 && $Result == 0){
                    $_SESSION["SuccessMessage"]="Your application for a plot was successful. But no plot is available";
                    Redirect_to("applyForPlots.php");
                }else {
                    $_SESSION["ErrorMessage"]= "Something went wrong. Try Again later !";
                    Redirect_to("applyForPlots.php");
                }

            }

        
        // $stmt->bindValue(':userID', $userId);
        // $stmt->bindValue(':firstNamE', $firstName);
        // $stmt->bindValue(':lastNamE', $lastName);
        // $stmt->bindValue(':emailAddresS', $emailAddress);
        // $stmt->bindValue(':telephoneNumbeR', $telephoneNumber);
        // $stmt->bindValue(':userCitY', $userCity);
        // $stmt->bindValue(':siteIdNuM',$siteIdNum);
        // $stmt->bindValue(':siteCitY', $siteCity);
        // $stmt->bindValue(':plotIdNuM', $plotIdNum);
        // $stmt->bindValue(':plotNumberApP', $plotNumberApp);
        // $stmt->bindValue(':applicationStatuS', $applicationStatus);
        // $stmt->bindValue(':offerCounT', $offerCount);
        // $stmt->bindValue(':dateApplieD', $dateApplied);

        // $sql2 = "UPDATE plots SET plotStatus = 'Pending_Acceptance' WHERE plotNumber ='$plotNumberApp' ";
        // $stmt = $ConnectingDB->prepare($sql2);
        
        
        
        
        // if($plotStatus == "Vacant"){
        // Redirect_to("confirmOffer.php");
        // }else
        // if($Execute && $Execute2 && $Execute3 && $plotStatus =="Vacant"){
        //     $_SESSION["SuccessMessage"]="Your Application For a Plot Was Successful Vacant";
        //     Redirect_to("confirmOffer.php");
        // }else
        
        // if($Execute && $Execute2 && $Execute3){
        //     $_SESSION["SuccessMessage"]="Your Application For a Plot Was Successful On Offer";
        //     Redirect_to("applyForPlots.php");
        // }else {
        //     $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
        //     Redirect_to("applyForPlots.php");
        // }
           

    } //Ending of Apply Button If-Condition

    
            

?>


<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
    
        <h1>Hello, <?php echo $_SESSION["userFirstName"]; ?> !</h1>
        <h3>You haven't applied for a plot yet. Complete the form below to apply</p>
                    <br>
                    <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                    echo ErrorMessageForRg();
                    ?>
        <form action="applyForPlots.php" method="POST">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="exampleInputEmail1">Plot Site</label>
                    <select name="siteCity" class="custom-select">
                        <?php
                        //Fetching all cities from table
                        global $ConnectingDB;
                        $sql = "SELECT id, cityName FROM cities";
                        $stmt = $ConnectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()) {
                        $Id = $DataRows["id"];
                        $cityName = $DataRows["cityName"];
                        ?>
                        <option> <?php echo $cityName; ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="exampleInputEmail1">Plot Number</label>
                    <input type="text" name="plotNumberApp" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Apply</label>
                        <div class="">
                            <button type="submit" name="Apply" class="btn btn-success">Apply</button>
                        </div>
                </div>
            </div>
        </form>

    

    </div>
   
<!-- Footer Start -->
<?php include("inc/footer.php") ;?>
<!-- Footer End -->