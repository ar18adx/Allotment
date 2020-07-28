<?php $pageTitle = "Send Message";?>

<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
confirmAdminLogin(); 

?>

<?php

        $msgQueryParameter = $_GET["id"];

        global $ConnectingDB;
        $sql ="SELECT * FROM tenants WHERE id = '$msgQueryParameter'  ";
        $stmt = $ConnectingDB->query($sql);
        $DataRows=$stmt->fetch();
        $id                   = $DataRows["id"];
        // $userIdRow                     = $DataRows["userId"];
        
        $tenantId          = $DataRows["tenantId"];
        $tenantFirstName          = $DataRows["tenantFirstName"];
        $tenantLastName          = $DataRows["tenantLastName"];
        $tenantEmailAddress	          = $DataRows["tenantEmailAddress"];
        $tenantPhoneNum          = $DataRows["tenantPhoneNum"];
        $tenantCity           = $DataRows["tenantCity"];
        $siteCity         = $DataRows["siteCity"];
        


    if(isset($_POST["Send"])){
        date_default_timezone_set("Africa/Lagos");
        $CurrentTime            =  time();
        $datetime               = strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
        $idRow                   =  $id;
        $tenantIdRow            = $tenantId;
        $tenantFirstNameRow        = $tenantFirstName;
        $tenantLastNameRow         = $tenantLastName;
        $tenantEmailRow            = $tenantEmailAddress;
        $siteNameRow               = $tenantCity;
        $smName                    = $_SESSION["adminFirstName"]." ".$_SESSION["adminLastName"] ;
        $msgFrom                   = "Site Manager";

        $textMessage               = $_POST["textMessage"];
        
    
    

   
        // Query to insert new city in DB When everything is fine
        global $ConnectingDB;
        $sql = "INSERT INTO messages(tenantId, userId, tenantFirstName, tenantLastName, tenantEmail, siteName, smName, msgFrom, textMessage, datetime )";
        $sql .= "VALUES('$idRow', '$tenantIdRow', '$tenantFirstNameRow', '$tenantLastNameRow', '$tenantEmailRow', '$siteNameRow', '$smName', '$msgFrom', '$textMessage', '$datetime' )";
        $stmt = $ConnectingDB->prepare($sql);
        // $stmt->bindValue(':textMessagE', $textMessage);
        
    
        
        $Execute=$stmt->execute();
        if($Execute){
        $_SESSION["SuccessMessage"]="New Message Sent Successfully";
        Redirect_to("adminSendMsg.php?id=".$msgQueryParameter);
        }else {
        $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
        Redirect_to("adminSendMsg.php".$msgQueryParameter);
        }
    
    } //Ending of Submit Button If-Condition


?>

    



<!-- Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- header End -->

    <div class="container">
        <div class="row">
            <!-- User Sidebar -->
            <?php include("inc/adminSidebar.php");?>
            <!-- User Sidebar End -->
            <div class="col-md-9">
                <div class="jumbotron mt-5">
                <form action="adminSendMsg.php?id=<?php echo $id; ?>" method="POST">
                    <div class="form-group">
                    <p><b>Tenant Name :</b> <?php echo $tenantFirstName." ".$tenantLastName ;?></p>
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

<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->