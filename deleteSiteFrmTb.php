<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>



<?php

if($_SESSION["adminRole"] != "Super_Admin"){ 
  Redirect_to("errorPage.php");
}


if(isset($_GET["id"])){
  $QueryParameter = $_GET["id"];
  global $ConnectingDB;
  $sql = "DELETE FROM cities WHERE id='$QueryParameter' ";
  $Execute = $ConnectingDB->query($sql);
  if ($Execute) {
    $_SESSION["WarningMessage"]="Site Deleted Successfully ! ";
    Redirect_to("viewSites.php?page=1");
    // code...
  }else {
    $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
    Redirect_to("viewSites.php?page=1");
  }
}