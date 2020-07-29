<?php $pageTitle = "Send Message";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php 
confirmUserLogin();
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
?>

<?php

        $tenantId              = $_SESSION["userId"];
        $tenantFirstName       = $_SESSION["userFirstName"];
        $tenantLastName        = $_SESSION["userLastName"];

        global $ConnectingDB;
        $sql ="SELECT * FROM tenants WHERE tenantId = '$tenantId'  ";
        $stmt = $ConnectingDB->query($sql);
        $DataRows=$stmt->fetch();
        $idRow                     = $DataRows["id"];
        // $userIdRow                     = $DataRows["userId"];
        $tenantFirstName          = $DataRows["tenantFirstName"];
        $tenantLastName          = $DataRows["tenantLastName"];
        $tenantEmailAddress	          = $DataRows["tenantEmailAddress"];
        $tenantPhoneNum          = $DataRows["tenantPhoneNum"];
        $tenantCity           = $DataRows["tenantCity"];
        $siteCity          = $DataRows["siteCity"];
        


    if(isset($_POST["Send"])){
        date_default_timezone_set("Africa/Lagos");
        $CurrentTime            = time();
        $datetime               = strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
        $id                     = $idRow;
        $userId                 = $_SESSION["userId"];
        $tenantFirstName        = $_SESSION["userFirstName"];
        $tenantLastName         = $_SESSION["userLastName"];
        $tenantEmail            = $tenantEmailAddress;
        $siteName               = $siteCity;
        $smName                 = "Tenant";
        $msgFrom                = $tenantFirstName." ".$tenantLastName;

        $textMessage               = $_POST["textMessage"];
        
    
    
            // $emailTo    = $tenantEmail;
            // $subject    = "New Message Alert";
            // $message    = "Hello ".$tenantFirstName."\n"." You have a new message ";
            // $headers    = "From: "."Allotment";

            // mail($emailTo, $subject, $message, $headers);
   
        // Query to insert new city in DB When everything is fine
        global $ConnectingDB;
        $sql = "INSERT INTO messages(tenantId, userId, tenantFirstName, tenantLastName, tenantEmail, siteName, smName, msgFrom, textMessage, datetime )";
        $sql .= "VALUES('$idRow', '$userId', '$tenantFirstName', '$tenantLastName', '$tenantEmail', '$siteName', '$smName', '$msgFrom', '$textMessage', '$datetime' )";
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
                    <div class="mb-3">
                        <a class="btn btn-warning" href="tenantMessages.php" role="button">Conversations</a>
                    </div>
                    <form action="tenantSendMsg.php" method="POST">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Message</label>
                            <textarea name="textMessage" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <button type="submit" name="Send" class="btn btn-success">Send</button>
                        <br>
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


<!-- Footer Start -->
<?php include("inc/footer.php") ;?>
<!-- Footer End -->