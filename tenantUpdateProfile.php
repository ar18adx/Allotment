<?php $pageTitle = "Tenant Update Profile";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

        $tenantId                 =   $_SESSION["userId"];
        global $ConnectingDB;
        $sql ="SELECT * FROM users WHERE id='$tenantId'";
        $stmt = $ConnectingDB->query($sql);
        $DataRows = $stmt->fetch();
        $id                             = $DataRows["id"];
        $emailAddress                  = $DataRows["emailAddress"];
        $telephone                 = $DataRows["telephone"];

        if (isset($_POST["Update"])) {
    
            $emailAddress           = $_POST["emailAddress"];
            $telephone          = $_POST["telephone"];

            global $ConnectingDB;
            $sql ="UPDATE users SET emailAddress='$emailAddress', telephone = '$telephone' WHERE id='$userId' ";
            $Execute=$ConnectingDB->query($sql);
                
            if($Execute){
                $_SESSION["SuccessMessage"]="Your contact details were updated successfully";
                Redirect_to("tenantUpdateProfile.php");
                }else {
                $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
                Redirect_to("tenantUpdateProfile.php");
            }

        }

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
                <div class="mt-5 mb-5">
                    <h1>Please update Your contact details correctly!</h1>
                </div>

                    <form class="mb-5" action="tenantUpdateProfile.php" method="POST">
                        <br>
                        <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                            echo ErrorMessageForRg();
                        ?>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="text" name="emailAddress" value="<?php echo htmlentities($emailAddress); ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Telephone Number</label>
                                <input type="text" name="telephone" value="<?php echo htmlentities($telephone); ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                        </div>
                        
                        <button type="submit" name="Update" class="btn btn-success">Update Profile</button>

                    </form>        
            </div>
        </div>
    </div>

<!-- Footer Start -->
<?php include("inc/footer.php") ;?>
<!-- Footer End -->