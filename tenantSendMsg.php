<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

        $tenantId              = $_SESSION["userId"];
        $tenantFirstName       = $_SESSION["userFirstName"];
        $tenantLastName        = $_SESSION["userLastName"];

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
        


    if(isset($_POST["Send"])){
        date_default_timezone_set("Africa/Lagos");
        $CurrentTime            =  time();
        $datetime               = strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);
        $tenantId              = $_SESSION["userId"];
        $tenantFirstName        = $_SESSION["userFirstName"];
        $tenantLastName         = $_SESSION["userLastName"];
        $siteName               = $siteCity;

        $textMessage               = $_POST["textMessage"];
        
    
    

   
        // Query to insert new city in DB When everything is fine
        global $ConnectingDB;
        $sql = "INSERT INTO messages(tenantId, tenantFirstName, tenantLastName, siteName, textMessage, datetime )";
        $sql .= "VALUES('$tenantId', '$tenantFirstName', '$tenantLastName', '$siteName', '$textMessage', '$datetime' )";
        $stmt = $ConnectingDB->prepare($sql);
        // $stmt->bindValue(':textMessagE', $textMessage);
        
    
        
        $Execute=$stmt->execute();
        if($Execute){
        $_SESSION["SuccessMessage"]="New Message Sent Successfully";
        Redirect_to("tenantSendMsg.php");
        }else {
        $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
        Redirect_to("tenantSendMsg.php");
        }
    
    } //Ending of Submit Button If-Condition


?>

    



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
                <form action="tenantSendMsg.php" method="POST">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Message</label>
                        <textarea name="textMessage" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <button type="submit" name="Send" class="btn btn-success">Send</button>
                    <br>
                    <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                    echo ErrorMessageForRg();
                    ?>
                </form>  

                    
                   
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>