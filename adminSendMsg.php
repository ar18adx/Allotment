<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

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
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>