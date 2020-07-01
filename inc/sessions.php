<?php
session_start();

function ErrorMessage(){
  if(isset($_SESSION["ErrorMessage"])){
    $Output = "<div class=\"alert alert-danger text-center\">" ;
    $Output .= htmlentities($_SESSION["ErrorMessage"]);
    $Output .= "</div>";
    $_SESSION["ErrorMessage"] = null;
    return $Output;
  }
}

function ErrorMessageForRg(){
  if(isset($_SESSION["ErrorMessageForRg"])){
    $Output = "<div class=\"alert alert-danger text-center\">" ;
    $Output .= htmlentities($_SESSION["ErrorMessageForRg"]);
    $Output .= "</div>";
    $_SESSION["ErrorMessageForRg"] = null;
    return $Output;
  }
}

function SuccessMessage(){
  if(isset($_SESSION["SuccessMessage"])){
    $Output = "<div class=\"alert alert-success text-center\">" ;
    $Output .= htmlentities($_SESSION["SuccessMessage"]);
    $Output .= "</div>";
    $_SESSION["SuccessMessage"] = null;
    return $Output;
  }
}

 ?>
