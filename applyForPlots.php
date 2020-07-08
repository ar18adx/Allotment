<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

    if(isset($_POST["Apply"])){
        date_default_timezone_set("Africa/Lagos");
        $CurrentTime            =  time();
        $dateApplied            = strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);
        $userId                 =   $_SESSION["userId"];
        $firstName              = $_SESSION["userFirstName"];
        $lastName               = $_SESSION["userLastName"];
        $emailAddress           = $_SESSION["userEmailAddress"];
        $telephoneNumber        = $_SESSION["userTelephone"];
        $userCity               = $_SESSION["userCity"];
        $siteCity               = $_POST["siteCity"];
        $plotNumberApp          = $_POST["plotNumberApp"];
        $applicationStatus      = "Pending";
        $offerCount             = 0;

        //Code to 
        //
            
            $userCity = $_SESSION["userCity"];
            global $ConnectingDB;
            $sql ="SELECT * FROM plots WHERE plotSite ='$siteCity' AND plotStatus = 'Vacant' ORDER BY RAND() ";
            $stmt = $ConnectingDB->query($sql);
            $DataRows=$stmt->fetch();
            $id                     = $DataRows["id"];
            $plotNumber          = $DataRows["plotNumber"];
            $plotStatus          = $DataRows["plotStatus"];
            
            if(empty($plotNumberApp)){
                $plotNumberApp = $plotNumber;
            }    
        

        
        
        // Query to insert values in DB When everything is fine
        global $ConnectingDB;
        $sql = "INSERT INTO waitinglist( userId, firstName, lastName, emailAddress, telephoneNumber, userCity, siteCity, plotNumberApp, applicationStatus, offerCount, dateApplied )";
        $sql .= "VALUES(:userID, :firstNamE, :lastNamE, :emailAddresS, :telephoneNumbeR, :userCitY, :siteCitY, :plotNumberApP, :applicationStatuS, :offerCounT, :dateApplieD  )";
        
        $sql2 = "UPDATE plots SET plotStatus = 'Pending_Acceptance', dateLastModified = '$dateApplied' WHERE plotNumber ='$plotNumberApp' ";
        $stmt2 = $ConnectingDB->prepare($sql2);
        $Execute2=$stmt2->execute();

        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':userID', $userId);
        $stmt->bindValue(':firstNamE', $firstName);
        $stmt->bindValue(':lastNamE', $lastName);
        $stmt->bindValue(':emailAddresS', $emailAddress);
        $stmt->bindValue(':telephoneNumbeR', $telephoneNumber);
        $stmt->bindValue(':userCitY', $userCity);
        $stmt->bindValue(':siteCitY', $siteCity);
        $stmt->bindValue(':plotNumberApP', $plotNumberApp);
        $stmt->bindValue(':applicationStatuS', $applicationStatus);
        $stmt->bindValue(':offerCounT', $offerCount);
        $stmt->bindValue(':dateApplieD', $dateApplied);

        // $sql2 = "UPDATE plots SET plotStatus = 'Pending_Acceptance' WHERE plotNumber ='$plotNumberApp' ";
        // $stmt = $ConnectingDB->prepare($sql2);
        
        
        
        $Execute=$stmt->execute();
        if($plotStatus == "Vacant"){
        Redirect_to("confirmOffer.php");
        }
        if($Execute && $Execute2){
        $_SESSION["SuccessMessage"]="Your Application For a Plot Was Successful";
        Redirect_to("applyForPlots.php");
        }else {
        $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
        Redirect_to("applyForPlots.php");
        }
        

    } //Ending of Submit Button If-Condition

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
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>