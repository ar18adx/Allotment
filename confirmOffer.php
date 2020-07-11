<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

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
        $expirationDate         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($leaseDate)). " + 365 day "));
        $renewalStatus          = "Pending";
        

        //Code to 
        //
            
        
        // Query to insert values in DB When everything is fine
        global $ConnectingDB;
        $sql = "INSERT INTO tenants(tenantId, tenantFirstName, tenantLastName, tenantEmailAddress, tenantPhoneNum, tenantCity, siteId, siteCity, plotId, plotNumber, leaseDate, expirationDate, renewalStatus )";
        $sql .= "VALUES(:tenantID, :tenantFirstNamE, :tenantLastNamE, :tenantEmailAddresS, :tenantPhoneNuM, :tenantCitY, :siteID, :siteCitY,  :plotID, :plotNumbeR, :leaseDatE, :expirationDatE, :renewalStatuS )";
        
        $sql2 = "UPDATE plots SET plotStatus = 'Occupied', dateLastModified = '$dateApplied' WHERE plotNumber ='$plotNumber' ";
        $stmt2 = $ConnectingDB->prepare($sql2);
        $Execute2=$stmt2->execute();

        $sql3 = "UPDATE users SET userStatus = 'Tenant' WHERE id ='$tenantId' ";
        $stmt3 = $ConnectingDB->prepare($sql3);
        $Execute3=$stmt3->execute();

        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':tenantID', $tenantId);
        $stmt->bindValue(':tenantFirstNamE', $firstName);
        $stmt->bindValue(':tenantLastNamE', $lastName);
        $stmt->bindValue(':tenantEmailAddresS', $tenantEmailAddress);
        $stmt->bindValue(':tenantPhoneNuM', $tenantPhoneNum);
        $stmt->bindValue(':tenantCitY', $tenantCity);
        $stmt->bindValue(':siteID', $siteIdNumRw);
        $stmt->bindValue(':siteCitY', $siteCity);
        $stmt->bindValue(':plotID', $plotIdNumRw);
        $stmt->bindValue(':plotNumbeR', $plotNumber);
        $stmt->bindValue(':leaseDatE', $leaseDate);
        $stmt->bindValue(':expirationDatE', $expirationDate);
        $stmt->bindValue(':renewalStatuS', $renewalStatus);

        // $sql2 = "UPDATE plots SET plotStatus = 'Pending_Acceptance' WHERE plotNumber ='$plotNumberApp' ";
        // $stmt = $ConnectingDB->prepare($sql2);
        
        
        
        $Execute=$stmt->execute();
        if($Execute && $Execute2 && $Execute3){
        $_SESSION["SuccessMessage"]="You have accepted the plot";
        Redirect_to("confirmOffer.php");
        }else {
        $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
        Redirect_to("confirmOffer.php");
        }
        

    } //Ending of Apply Button If-Condition

    ?>



<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
    
        <h1>Hello, <?php echo $_SESSION["userFirstName"]; ?> !</h1>
        <h3>You have been allocated Plot "<?php echo htmlentities($plotNumberApp);?>" in "<?php echo htmlentities($siteCity); ?>" Site. If you are OK with this. You have 14 days to ACCEPT or REJECT the offer.</p>
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
                            <button type="submit" name="Accept" class="btn btn-success">Apply</button>
                        </div>
                </div>
                <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Reject</label>
                        <div class="">
                            <button type="submit" name="Reject" class="btn btn-success">Apply</button>
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