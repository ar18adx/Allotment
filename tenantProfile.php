<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

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
    $plotNumber          = $DataRows["plotNumber"];
    $leaseDate          = $DataRows["leaseDate"];
    $expirationDate          = $DataRows["expirationDate"];
    $renewalStatus          = $DataRows["renewalStatus"];

    // $expirationDate         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($leaseDate)). " + 365 day "));

    $expirationDateNotification        = date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDate)). " - 90 day "));

    $oneMonthToExp        = date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDate)). " - 30 day "));

    echo $expirationDateNotification. "<br>";
    
    echo $oneMonthToExp;

            // Code to notify the tenant on the number of days before expiry 
            $start_date = date_create(date("Y-m-d"));
            $end_date   = date_create($expirationDate);
            
            //difference between two dates
            $diff = date_diff($start_date,$end_date);

    // Code to set Plot Status to "Soon Vacant" If user does not renew lease

            
        
    ?>

<?php

if(isset($_POST["oneYear"])){
    
    $renewLeaseForOneYear = date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDate)). " + 365 day "));
    
    // Query to insert values in DB When everything is fine
        global $ConnectingDB;
        $sql = "UPDATE tenants SET expirationDate = '$renewLeaseForOneYear' WHERE tenantId ='$tenantId' ";
        $stmt = $ConnectingDB->prepare($sql);
        $Execute=$stmt->execute();    
    
    $Execute=$stmt->execute();
    if($Execute){
    $_SESSION["SuccessMessage"]="You have renewed successfully Your lease for One Year";
    Redirect_to("tenantProfile.php");
    }else {
    $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
    Redirect_to("tenantProfile.php");
    }
    

} //Ending of oneYear Button If-Condition

if(isset($_POST["sixMonths"])){
    
    $renewLeaseForSixMonths = date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDate)). " + 6 month "));
    
    // Query to insert values in DB When everything is fine
        global $ConnectingDB;
        $sql = "UPDATE tenants SET expirationDate = '$renewLeaseForSixMonths' WHERE tenantId ='$tenantId' ";
        $stmt = $ConnectingDB->prepare($sql);
        $Execute=$stmt->execute();    
    
    $Execute=$stmt->execute();
    if($Execute){
    $_SESSION["SuccessMessage"]="You have renewed successfully Your lease for six months";
    Redirect_to("tenantProfile.php");
    }else {
    $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
    Redirect_to("tenantProfile.php");
    }
    

} //Ending of Six Months Button If-Condition

?>

<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
        <div class="jumbotron mt-5">
            <h1 class="display-4">Hello, <?php echo $_SESSION["userFirstName"]." ".$_SESSION["userLastName"]; ?></h1>
                    <br>
                    <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                    echo ErrorMessageForRg();
                    ?>
            <!-- <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p> -->
            <hr class="my-4">
            <!-- <p>It uses utility classes for typography and spacing to space content out within the larger container.</p> -->
            <p><b>Expiry Date: <?php echo htmlentities($expirationDate) ?></p>

            
            <?php if(date("Y-m-d") >= $oneMonthToExp){?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Notice!</h4>
                    <!-- Get the number of days remainig on lease when it is one month to expiry date -->
                    <p>Your Account will expire in <?php echo htmlentities($diff->format("%a")) ; ?> days.</p>
                    <p>You did not renew Your lease, So the plot will go to someone else after Your expiration date</p>
                    <hr>
                </div>
            
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
            <!-- <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a> -->
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>