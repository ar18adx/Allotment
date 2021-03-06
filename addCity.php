<?php $pageTitle = "Add City";?>

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

if(isset($_POST["Submit"])){

    date_default_timezone_set("Africa/Lagos");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);

    $cityName               = $_POST["cityName"];
    $cityShortCode          = $_POST["cityShortCode"];
    $availabilityStatus     = "Open";
    $asUpdatedBy            = "None";
    $updateTime             = "None";
    

    $addedBy                = $_SESSION["adminFirstName"]." ".$_SESSION["adminLastName"];
  

    if(empty($cityName) ||empty($cityShortCode)){
      $_SESSION["ErrorMessage"]= "All fields must be filled out";
      Redirect_to("addCity.php");
    }elseif (strlen($cityShortCode)>3) {
      $_SESSION["ErrorMessage"]= "City Short Code should be Not be greater than 3 characters";
      Redirect_to("addCity.php");
    }elseif(CheckCityExistsOrNot($cityName)){
      $_SESSION["ErrorMessage"]= "Site Name already exists";
    }elseif(CheckCityCSCOrNot($cityShortCode)){
      $_SESSION["ErrorMessage"]= "City Short Code already exists";
    }else{
    // Query to insert new city in DB When everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO cities(cityName, cityShortCode, addedBy, datetime, availabilityStatus, asUpdatedBy, updateTime)";
    $sql .= "VALUES(:cityNAme, :cityShortCodE, :addeDBy, :dateTIme, '$availabilityStatus', '$asUpdatedBy', '$updateTime')";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':cityNAme', ucfirst($cityName));
    $stmt->bindValue(':cityShortCodE', strtoupper($cityShortCode));
    $stmt->bindValue(':addeDBy', $addedBy);
    $stmt->bindValue(':dateTIme', $DateTime);
    
    $Execute=$stmt->execute();
    if($Execute){
      $_SESSION["SuccessMessage"]="New Site added Successfully";
      Redirect_to("addCity.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("addCity.php");
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

          <div class='col-md-9'>
            <div class="mt-4">
                <h1>Add New Site</h1>
            </div>

            <form action="addCity.php" method="POST">
              <br>
              <?php
                  echo ErrorMessage();
                  echo SuccessMessage();
                  echo ErrorMessageForRg();
              ?>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Site Name</label>
                        <input type="text" name="cityName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        <small id="emailHelp" class="form-text text-muted">.</small>
                    </div>
                </div>
      
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">City Short Code</label>
                        <input type="text" name="cityShortCode" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        <small id="emailHelp" class="form-text text-muted"><i>IKJ, ABC, WST, GGE </i></small>
                    </div>
                    <!-- Must Be in Caps -->
                </div>
                <button type="submit" name="Submit" class="btn btn-success">Add City</button>

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