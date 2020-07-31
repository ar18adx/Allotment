<?php $pageTitle = "Apply For a Plot";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php 

confirmUserLogin();



if($_SESSION["userStatus"] == "Tenant"){
    Redirect_to("tenantProfile.php");
}

?>

<?php

    // Integrating the Apply Button with the data to be sent to the database

    if(isset($_POST["Apply"])){
        date_default_timezone_set("Africa/Lagos");
        $CurrentTime            =  time();
        $dateApplied            = date("Y-m-d");
        $userId                 = $_SESSION["userId"];
        $firstName              = $_SESSION["userFirstName"];
        $lastName               = $_SESSION["userLastName"];
        $emailAddress           = $_SESSION["userEmailAddress"];
        $telephoneNumber        = $_SESSION["userTelephone"];
        $userCity               = $_SESSION["userCity"];
        $siteCity               = $_POST["siteCity"];
        $plotNumberApp          = $_POST["plotNumberApp"];
        // $applicationStatus      = "Pending";
        $offerCount             = 0;
        
            // Check if a user has previously applied for a plot on the waiting list

            if (CheckUserExistsOnWl($userId)) {
                $_SESSION["ErrorMessage"]= "You have previously applied for a plot !!! ";
                Redirect_to("applyForPlots.php");
            }
            
            // Ckeck if the plot number to be submitted is valid. This is for users who want to apply and wait for a specific plot

            if(!empty($plotNumberApp)){

                if (CheckPlotNumExistsOrNot($plotNumberApp)) {
                    $_SESSION["ErrorMessage"]= "Plot Number Does Not Exist !!! ";
                    Redirect_to("applyForPlots.php");
                }

                //Query to get the plotid and other plot information
                global $ConnectingDB;
                $sql ="SELECT * FROM plots WHERE plotNumber = '$plotNumberApp'  ";
                $stmt = $ConnectingDB->query($sql);
                $DataRows=$stmt->fetch();
                $PlotId                     = $DataRows["id"];
                
                $plotSiteRw1          = $DataRows["plotSite"];
                $siteIdNumRw1         = $DataRows["siteIdNum"];


                // Query to insert values in DB For Users awaiting a specific Plot
                $sqlA1 = "INSERT INTO waitinglist( userId, firstName, lastName, emailAddress, telephoneNumber, userCity, siteIdNum, siteCity, plotIdNum, plotNumberApp, applicationStatus, offerCount, dateApplied, validationStatus )";
                $sqlA1 .= "VALUES('$userId', '$firstName', '$lastName', '$emailAddress', '$telephoneNumber', '$userCity', '$siteIdNumRw1', '$plotSiteRw1', '$PlotId', '$plotNumberApp', 'Awaiting_Specific_Plot', '$offerCount', '$dateApplied', 'Not_Updated')";
                $stmtA1 = $ConnectingDB->prepare($sqlA1);
                $ExecuteA1=$stmtA1->execute();

                if($ExecuteA1){
                    $_SESSION["SuccessMessage"]="Your application for a plot was successful";
                    Redirect_to("applyForPlots.php");
                }

                // Code for the users applying without a plot number

            }elseif(empty($plotNumberApp)){
            
           
                // Check if there is a vacant plot or not
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
            
                
           
        
                    // Query to insert values in DB If there is a vacant plot
                    $sql = "INSERT INTO waitinglist( userId, firstName, lastName, emailAddress, telephoneNumber, userCity, siteIdNum, siteCity, plotIdNum, plotNumberApp, applicationStatus, offerCount, dateApplied, validationStatus )";
                    $sql .= "VALUES('$userId', '$firstName', '$lastName', '$emailAddress', '$telephoneNumber', '$userCity', '$siteIdNum', '$siteCity', '$plotIdNum', '$plotNumberApp', 'Pending_Confirmation', '$offerCount', '$dateApplied', 'Not_Updated')";
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
        
                // Check if there are no vacant Plots

                }elseif($Result == 0){

                    $noValEmpty    = "None";
                    
                    
                    // Query to insert values into db if there is no vacant plot 

                    $sql77 = "INSERT INTO waitinglist( userId, firstName, lastName, emailAddress, telephoneNumber, userCity, siteIdNum, siteCity, plotIdNum, plotNumberApp, applicationStatus, offerCount, dateApplied, validationStatus )";
                    $sql77 .= "VALUES('$userId', '$firstName', '$lastName', '$emailAddress', '$telephoneNumber', '$userCity', 'None', '$siteCity', 'None', 'None', 'Awaiting_Plot', '$offerCount', '$dateApplied', 'Not_Updated')";
                    $stmt77 = $ConnectingDB->prepare($sql77);
                    $Execute77=$stmt77->execute();

                    $sql44 = "UPDATE users SET userStatus = 'Awaiting_Plot' WHERE id ='$userId' ";
                    $stmt44 = $ConnectingDB->prepare($sql44);
                    $Execute44=$stmt44->execute();

                    if($Execute77 && $Execute44 && $Result == 0){
                        $_SESSION["SuccessMessage"]="Your application for a plot was successful. But no plot is available";
                        Redirect_to("confirmOffer.php");
                    }else {
                        $_SESSION["ErrorMessage"]= "Something went wrong. Try Again later !";
                        Redirect_to("applyForPlots.php");
                    }

                }
           
        }
    } //Ending of Apply Button If-Condition

    
            

?>


<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
    
        <h1 class="mt-4">Hello, <?php echo $_SESSION["userFirstName"]; ?> !</h1>
        <h3>You haven't applied for a plot yet. Complete the form below to apply</h3>
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
                    <!-- Cities dropdown -->
                    <select name="siteCity" class="custom-select">
                        <?php
                        //Fetching all cities from table
                        global $ConnectingDB;
                        $sql = "SELECT id, cityName FROM cities WHERE availabilityStatus = 'Open' ORDER BY cityName ASC ";
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
                    <label for="exampleInputEmail1">Plot Number (Optional)</label>
                    <input type="text" name="plotNumberApp" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Apply</label>
                        <div class="">
                            <button type="submit" name="Apply" class="btn btn-success">Apply</button>
                        </div>
                </div>
                <div class="mt-3">
                    <h3><i>You can apply without a Plot Number</i></h3>
                </div>
            </div>
        </form>

    

    </div>
   
<!-- Footer Start -->
<?php include("inc/footer.php") ;?>
<!-- Footer End -->