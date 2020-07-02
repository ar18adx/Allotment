<?php require_once("inc/functions.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php
$_SESSION["adminId"]=null;
session_destroy();
Redirect_to("adminLogin97.php");