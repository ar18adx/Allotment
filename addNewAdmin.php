<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>


<?php

if(isset($_POST["Submit"])){

    date_default_timezone_set("Africa/Lagos");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);

    $firstName                 = $_POST["firstName"];
    $lastName                = $_POST["lastName"];
    $emailAddress                = $_POST["emailAddress"];
    $telephone                = $_POST["telephone"];
    $homeAddress                = $_POST["homeAddress"];
    $gender                = $_POST["gender"];
    $password                = $_POST["password"];
    $addedby                = "Wale Borokini";
 

  if(empty($firstName)||empty($lastName)||empty($emailAddress)||empty($telephone)){
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("addNewAdmin.php");
  }elseif (strlen($Password)<4) {
    $_SESSION["ErrorMessage"]= "Password should be greater than 3 characters";
    Redirect_to("addNewAdmin.php");
  }elseif ($Password !== $ConfirmPassword) {
    $_SESSION["ErrorMessage"]= "Password and Confirm Password should match";
    Redirect_to("addNewAdmin.php");
  }elseif (CheckUserNameExistsOrNot($Username)) {
    $_SESSION["ErrorMessage"]= "Username Exists. Try Another One! ";
    Redirect_to("addNewAdmin.php");
  }else{
    // Query to insert new admin in DB When everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO admins(firstName, lastName, emailAddress, telephone, homeAddress, gender, password, dateTime)";
    $sql .= "VALUES(:firstNamE, :lastNamE, :emailAddresS, :telephonE, :homeAddresS, :gendeR, :passworD, deteTimE)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':firstNamE', $firstName);
    $stmt->bindValue(':lastNamE', $lastName);
    $stmt->bindValue(':emailAddresE', $hash);
    $stmt->bindValue(':telephonE', $AdminName);
    $stmt->bindValue(':homeAddresS', $AdminRole);
    $stmt->bindValue(':gendeR', $AdminImage);
    $stmt->bindValue(':passworD', $Admin);
    $Execute=$stmt->execute();
    move_uploaded_file($Temp_Admin_Image, $Target_Admin_Image);
    if($Execute){
      $_SESSION["SuccessMessage"]="New Admin with the name of ".$AdminName." added Successfully";
      Redirect_to("manage_admins.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("manage_admins.php");
    }
  }
} //Ending of Submit Button If-Condition


?>



<!-- Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- header End -->

<div class="container">
    
    <h1>Add New Admin</h1>

            <form>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">First Name</label>
                        <input type="text" name="firstName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Last Name</label>
                        <input type="text" name="lastName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="text" name="emailAddress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Telephone</label>
                        <input type="text" name="telephone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Home Address</label>
                        <input type="text" name="homeAddress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Gender</label>
                        <input type="text" name="gender" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="text" name="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Confirm Password</label>
                        <input type="text" name="confirmPassword" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted"></small>
                    </div>
                </div>
                
                
                <button type="submit" name="Submit" class="btn btn-success">Register</button>

            </form>
            


</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>