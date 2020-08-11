<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

$adminSiteName = $_SESSION["adminSiteName"];

if(isset($_GET["id"])){
        $closeOpen = $_GET["id"];
    
          global $ConnectingDB;
          $sql ="SELECT * FROM cities WHERE id='$closeOpen' ";
          $stmt = $ConnectingDB->query($sql);
          $DataRows = $stmt->fetch();
          $idcity                     = $DataRows["id"];
          $cityName23                = $DataRows["cityName"];

          if($_SESSION["adminRole"] == "Super_Admin" && !isset($closeOpen)){ 
            Redirect_to("errorPage.php");
          }
      
          if($_SESSION["adminRole"] == "Site_Manager" && $cityName23 != $adminSiteName ){ 
            Redirect_to("errorPage.php");
          }

    $updatedBy   = $_SESSION["adminFirstName"]." ".$_SESSION["adminLastName"];
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime                 =time();
    $updateTime                =strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);
    global $ConnectingDB;
    if($_SESSION["adminRole"] == "Super_Admin" ){
      $sql = "UPDATE cities SET availabilityStatus='Open', asUpdatedBy ='$updatedBy', updateTime ='$updateTime' WHERE id='$closeOpen' ";
    }elseif($_SESSION["adminRole"] == "Site_Manager" ){
      $sql = "UPDATE cities SET availabilityStatus='Open', asUpdatedBy ='$updatedBy', updateTime ='$updateTime' WHERE id='$closeOpen' AND cityName = '$adminSiteName' ";
    }

    



    $Execute = $ConnectingDB->query($sql);
    if ($Execute) {
      $_SESSION["WarningMessage"]="Availability Status Has Been Changed To \"Open\" ";
      Redirect_to("closeOpenApplication.php");
      // code...
    }else {
      $_SESSION["WarningMessage"]="Something Went Wrong. Try Again !";
      Redirect_to("closeOpenApplication.php");
    }
  }