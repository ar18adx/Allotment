<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>


<?php
if(isset($_GET["id"])){
  $QueryParameter = $_GET["id"];
  global $ConnectingDB;
  $sql = "DELETE FROM admins WHERE id='$QueryParameter' AND AdminRole = 'Site_Manager' ";
  $Execute = $ConnectingDB->query($sql);
  if ($Execute) {
    $_SESSION["WarningMessage"]="Site Manager Deleted Successfully ! ";
    Redirect_to("ViewSiteManagers.php?page=1");
    // code...
  }else {
    $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
    Redirect_to("deleteSiteManager.php?page=1");
  }
}