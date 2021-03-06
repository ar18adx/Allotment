<?php $pageTitle = "Add Allotment Officer";?>

<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
confirmAdminLogin(); 

if($_SESSION["adminRole"] != "Super_Admin"){
    Redirect_to("errorPage.php");
}

?>

<?php

if($_SESSION["adminRole"] != "Super_Admin"){
    Redirect_to("errorPage.php");
}

if(isset($_POST["Submit"])){

    date_default_timezone_set("Africa/Lagos");
    $CurrentTime=time();
    $datetime=strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);

    $firstName                 = $_POST["firstName"];
    $lastName                = $_POST["lastName"];
    $emailAddress                = $_POST["emailAddress"];
    $telephone                = $_POST["telephone"];
    $homeAddress                = $_POST["homeAddress"];
    $siteName                       = "All";
    $gender                = $_POST["gender"];
    $password                = $_POST["password"];
    $confirmPassword        = $_POST["confirmPassword"];
    $hash                   = password_hash($password, PASSWORD_BCRYPT);
    $adminRole                = "Super_Admin";
    $addedBy                = $_SESSION["adminFirstName"]." ".$_SESSION["adminLastName"];
 

  if(empty($firstName)||empty($lastName)||empty($emailAddress)||empty($telephone)){
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("addNewAdmin.php");
  }elseif (strlen($password)<4) {
    $_SESSION["ErrorMessage"]= "Password should be greater than 3 characters";
    Redirect_to("addNewAdmin.php");
  }elseif ($password !== $confirmPassword) {
    $_SESSION["ErrorMessage"]= "Password and Confirm Password should match";
    Redirect_to("addNewAdmin.php");
  }else{
    // Query to insert new admin in DB When everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO admins(firstName, lastName, emailAddress, telephone, homeAddress, siteName, gender, password, adminRole, addedBy, datetime )";
    $sql .= "VALUES(:firstNamE, :lastNamE, :emailAddresS, :telephonE, :homeAddresS, :siteNaMe, :gendeR, :passworD, :adminRolE, :addedBY, :datetimE )";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':firstNamE', $firstName);
    $stmt->bindValue(':lastNamE', $lastName);
    $stmt->bindValue(':emailAddresS', $emailAddress);
    $stmt->bindValue(':telephonE', $telephone);
    $stmt->bindValue(':homeAddresS', $homeAddress);
    $stmt->bindValue(':siteNaMe', $siteName);
    $stmt->bindValue(':gendeR', $gender);
    $stmt->bindValue(':passworD', $hash);
    $stmt->bindValue(':adminRolE', $adminRole);
    $stmt->bindValue(':addedBY', $addedBy);
    $stmt->bindValue(':datetimE', $datetime);

    $Execute=$stmt->execute();
    if($Execute){
      $_SESSION["SuccessMessage"]="New Admin added Successfully";
      Redirect_to("addNewAdmin.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("addNewAdmin.php");
    }
  }
} //Ending of Submit Button If-Condition


?>


<?php if($_SESSION["adminRole"] == "Super_Admin"){?>

    <!-- Header Start -->
    <?php include("inc/adminHeader.php"); ?>
    <!-- header End -->

        <div class="container">
            <div class="row">
                <!-- Include Admin Sidebar -->
                <?php include("inc/adminSidebar.php");?>
                <!-- Include Admin Sidebar --> 
                <div class="col-md-9">
                    <h1>Add New Allotment officer</h1>

                    <form class="mb-5" action="addNewAdmin.php" method="POST">
                        <br>
                        <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                            echo ErrorMessageForRg();
                        ?>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">First Name</label>
                                <input type="text" name="firstName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Last Name</label>
                                <input type="text" name="lastName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="emailAddress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Telephone</label>
                                <input type="text" name="telephone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Home Address</label>
                                <input type="text" name="homeAddress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Gender</label>
                                <select name="gender" class="custom-select">
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        
                        
                        <button type="submit" name="Submit" class="btn btn-success">Add Allotment Officer</button>

                    </form>
                </div>
            </div>

        </div>

    <!-- Admin Footer Start -->
    <?php include("inc/adminFooter.php"); ?>
    <!-- Admin Footer End -->

<?php
 
}else{
    Redirect_to("errorPage.php");
} 

?>