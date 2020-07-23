<?php $pageTitle = "Contact Validation";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php 
confirmUserLogin();
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
?>

<?php

        $userId = $_SESSION["userId"];
        global $ConnectingDB;
        $sql ="SELECT * FROM users WHERE id='$userId'";
        $stmt = $ConnectingDB->query($sql);
        $DataRows = $stmt->fetch();
        $id                             = $DataRows["id"];
        $emailAddress                  = $DataRows["emailAddress"];
        $telephone                 = $DataRows["telephone"];

        if (isset($_POST["Yes"])) {
        
            $emailAddress           = $_POST["emailAddress"];
            $telephone          = $_POST["telephone"];

            global $ConnectingDB;
            $sql ="UPDATE users SET emailAddress='$emailAddress', telephone = '$telephone' WHERE id='$userId' ";
            $Execute=$ConnectingDB->query($sql);
                
            if($Execute){
                $_SESSION["SuccessMessage"]="Your contact details and interest validation were updated successfully";
                Redirect_to("userContactVald.php");
                }else {
                $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
                Redirect_to("userContactVald.php");
            }

        }

        if (isset($_POST["No"])) {
        
            

            $sqlD1 = "UPDATE users SET userStatus = 'New_User' WHERE id ='$userId' ";
            $stmtD1 = $ConnectingDB->prepare($sqlD1);
            $ExecuteD1=$stmtD1->execute();
                
            if($ExecuteD1){
                $sqlD2 = "DELETE FROM waitinglist WHERE userId = '$userId' ";
                $stmtD2 = $ConnectingDB->prepare($sqlD2);
                $ExecuteD2=$stmtD2->execute();

                $_SESSION["SuccessMessage"]="You have been removed from the waiting list. You can now apply for a plot as a new user";
                Redirect_to("applyForPlots.php");
                }else {
                $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
                Redirect_to("userContactVald.php");
            }

        }
    
    
            

?>


<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
            <div class="mt-4 mb-4">
                <h1>Contact and interest validation</h1>
            </div>
        <h3>Hello, <?php echo $_SESSION["userFirstName"]; ?> !, Please indicate your interest below</h3>
        
                    <br>
                    <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                    echo ErrorMessageForRg();
                    ?>
        <form action="userContactVald.php" method="POST">
            <div class="mt-1 mb-3">
                <h2>Section One</h2>
            </div>
            <div class="mb-4">
                <h5>Do You want to update Your contact details?
                <br><i>If "Yes", edit Your contact details below and If "No", Proceed to section 2.</i>
                </h5>
                        
            <div class="row">
                <div class="form-group col-md-4 mt-4">
                    <label for="exampleInputEmail1">Email Address</label>
                    <input type="text" name="emailAddress" value="<?php echo htmlentities($emailAddress); ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="exampleInputEmail1">Telephone</label>
                    <input type="text" name="telephone" value="<?php echo htmlentities($telephone); ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
            </div>
                               
            </div>
            <div class="mt-1 mb-3">
                <h2>Section Two</h2>
            </div>
            <div class="mb-4">
                <h4>Are You still interested in the plot You applied for?</h4>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <button type="submit" name="Yes" class="btn btn-lg btn-success">Yes</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <button type="submit" name="No" class="btn btn-lg btn-danger">No</button>
                    </div>
                </div>
                
            </div>
        </form>

    

    </div>
   
<!-- Footer Start -->
<?php include("inc/footer.php") ;?>
<!-- Footer End -->