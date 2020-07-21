<?php $pageTitle = "Admin Login";?>

<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>


<?php 

if(isset($_SESSION["adminId"])){
  Redirect_to("adminDashboard99.php");
}

if (isset($_POST["Submit"])) {
  $emailAddress = $_POST["emailAddress"];
  $password = $_POST["password"];

  if (empty($emailAddress)||empty($password)) {
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("index.php");
  }else {
    // code for checking email and password from Database
  
    $Found_Account=adminLoginAttempt($emailAddress);
    if ($Found_Account && password_verify($_POST["password"], $Found_Account["password"])) {

      $_SESSION["adminId"]=$Found_Account["id"];
      $_SESSION["adminFirstName"]=$Found_Account["firstName"];
      $_SESSION["adminLastName"]=$Found_Account["lastName"];
      $_SESSION["adminEmailAddress"]=$Found_Account["emailAddress"];
      $_SESSION["adminHomeAddress"]=$Found_Account["homeAddress"];
      $_SESSION["adminSiteName"]=$Found_Account["siteName"];
      $_SESSION["adminRole"]=$Found_Account["adminRole"];
      $_SESSION["adminGender"]=$Found_Account["gender"];
      
    if (isset($_SESSION["TrackingURL"])) {
    Redirect_to($_SESSION["TrackingURL"]);
    }else{
    Redirect_to("adminDashboard99.php");
    }
    }else {
      $_SESSION["ErrorMessage"]="Incorrect Email OR Password";
      Redirect_to("adminLogin97.php");
    }
  }
}

?>   


<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
    
        <h1>Hello, world!</h1>

        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <form action="adminLogin97.php" method="POST">
                        <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                        echo ErrorMessageForRg();
                        ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name="emailAddress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <button type="submit" name="Submit" class="btn btn-primary">Log In</button>
                </form>

            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>


<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->