<?php require_once("inc/functions.php"); ?>
<?php require_once("inc/sessions.php"); ?>

<?php
$_SESSION["userId"]=null;
session_destroy();
Redirect_to("index.php");