<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

if(isset($_GET["id"])){
    $closeOpen = $_GET["id"];
    $updatedBy   = $_SESSION["adminFirstName"]." ".$_SESSION["adminLastName"];
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime                 =time();
    $updateTime                =strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);
    global $ConnectingDB;
    $sql = "UPDATE cities SET availabilityStatus='Closed', asUpdatedBy ='$updatedBy', updateTime ='$updateTime' WHERE id='$closeOpen'";
    $Execute = $ConnectingDB->query($sql);
    if ($Execute) {
      $_SESSION["WarningMessage"]="Availability Status Has Been Changed To \"Closed\" ! ";
      Redirect_to("closeOpenApplication.php");
      // code...
    }else {
      $_SESSION["WarningMessage"]="Something Went Wrong. Try Again !";
      Redirect_to("closeOpenApplication.php");
    }
  }

