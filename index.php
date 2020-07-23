<?php $pageTitle = "Allotment";?>

<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>


<?php 

if(isset($_SESSION["userId"]) && ($_SESSION["userStatus"]=="New_User")){
  Redirect_to("applyForPlots.php");
}elseif(isset($_SESSION["userId"]) && ($_SESSION["userStatus"]=="Awaiting_Plot")){
  Redirect_to("confirmOffer.php");
}elseif(isset($_SESSION["userId"]) && ($_SESSION["userStatus"]=="Pending_Confirmation")){
  Redirect_to("confirmOffer.php");
}elseif(isset($_SESSION["userId"]) && ($_SESSION["userStatus"]=="Tenant")){
  Redirect_to("tenantProfile.php");
}

// if($_SESSION["userStatus"] == "New_User"){
//   Redirect_to("applyForPlots.php");
// }
// if($_SESSION["userStatus"] == "Applied_For_Plot"){
//   Redirect_to("confirmOffer.php");
// }
// if($_SESSION["userStatus"] == "Tenant"){
//   Redirect_to("tenantProfile.php");
// }

if (isset($_POST["Submit"])) {
  $emailAddress = $_POST["emailAddress"];
  $password = $_POST["password"];

  if (empty($emailAddress)||empty($password)) {
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("index.php");
  }else {
    // code for checking email and password from Database
  
    $Found_Account=userLoginAttempt($emailAddress);
    if ($Found_Account && password_verify($_POST["password"], $Found_Account["password"])) {

        $_SESSION["userId"]=$Found_Account["id"];
        $_SESSION["userFirstName"]=$Found_Account["firstName"];
        $_SESSION["userLastName"]=$Found_Account["lastName"];
        $_SESSION["userEmailAddress"]=$Found_Account["emailAddress"];
        $_SESSION["userTelephone"]=$Found_Account["telephone"];
        $_SESSION["userHomeAddress"]=$Found_Account["homeAddress"];
        $_SESSION["userCity"]=$Found_Account["city"];
        $_SESSION["userGender"]=$Found_Account["gender"];
        $_SESSION["userStatus"]=$Found_Account["userStatus"];
        
        if (isset($_SESSION["TrackingURL"])) {
          Redirect_to($_SESSION["TrackingURL"]);
        }elseif($_SESSION["userStatus"] == "Awaiting_Plot"){
          Redirect_to("confirmOffer.php");
        }elseif($_SESSION["userStatus"] == "Tenant"){
          Redirect_to("tenantProfile.php");
        }elseif($_SESSION["userStatus"] == "Pending_Confirmation"){
          Redirect_to("confirmOffer.php");
        }else{
          Redirect_to("applyForPlots.php");
        }
    
      }else {
        $_SESSION["ErrorMessage"]="Incorrect Email OR Password";
        Redirect_to("index.php");
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
            <div class="col-md-8">
            </div>
            <div class="col-md-4">
                <form action="index.php" method="POST">
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

                <div class="mt-5">
                    <div class="card text-center" style="width: 18rem;">
                        <p class="list-group list-group-flush">
                            Don't have an account? <a href="registerUser.php" class="card-link">Register</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Start -->
    <?php include("inc/footer.php") ;?>
    <!-- Footer End -->