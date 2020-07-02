<?php 


function plotNameGen($length){
  $plotSite                 = $_POST["plotSite"];
  
  global $ConnectingDB;
  $sql    = "SELECT cityShortCode FROM cities WHERE cityName=:plotSitE";
  $stmt   = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':plotSitE',$plotSite);
  $stmt->execute();
  $DataRows = $stmt->fetch();
  $id              = $DataRows["id"];
  $citySc          = $DataRows["cityShortCode"];

  $token = $citySc;
  $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

  $max = strlen($codeAlphabet);

    for ($i=0; $i < $length; $i++)
  {
      $token .= $codeAlphabet [random_int(0, $max-1)];
    }

    return $token;

}




function time_ago($DateTime){
  
  date_default_timezone_set("Africa/Lagos");         
  $time_ago        = strtotime($DateTime);
  $current_time    = time();
  $time_difference = $current_time - $time_ago;
  $seconds         = $time_difference;
  
  $minutes = round($seconds / 60); // value 60 is seconds  
  $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
  $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
  $weeks   = round($seconds / 604800); // 7*24*60*60;  
  $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
  $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
                
  if ($seconds <= 60){

    return "Just Now";

  } else if ($minutes <= 60){

    if ($minutes == 1){

      return "one minute ago";

    } else {

      return "$minutes minutes ago";

    }

  } else if ($hours <= 24){

    if ($hours == 1){

      return "an hour ago";

    } else {

      return "$hours hrs ago";

    }

  } else if ($days <= 7){

    if ($days == 1){

      return "yesterday";

    } else {

      return "$days days ago";

    }

  } else if ($weeks <= 4.3){

    if ($weeks == 1){

      return "a week ago";

    } else {

      return "$weeks weeks ago";

    }

  } else if ($months <= 12){

    if ($months == 1){

      return "a month ago";

    } else {

      return "$months months ago";

    }

  } else {
    
    if ($years == 1){

      return "one year ago";

    } else {

      return "$years years ago";

    }
  }
}


function Redirect_to($New_Location){
  header("Location:".$New_Location);
  exit;
}




function CheckUserNameExistsOrNot($Username){
  global $ConnectingDB;
  $sql    = "SELECT Username FROM admins WHERE Username=:userName";
  $stmt   = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':userName',$Username);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return true;
  }else {
    return false;
  }
}



function userLoginAttempt($emailAddress){
  global $ConnectingDB;
  $sql = "SELECT * FROM users WHERE emailAddress = :emailAddresS LIMIT 1";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':emailAddresS',$emailAddress);
  // $stmt->bindValue(':PassworD',$hash);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return $Found_Account=$stmt->fetch();
  }else {
    return null;
  }
}

function adminLoginAttempt($emailAddress){
  global $ConnectingDB;
  $sql = "SELECT * FROM admins WHERE emailAddress = :emailAddresS LIMIT 1";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':emailAddresS',$emailAddress);
  // $stmt->bindValue(':PassworD',$hash);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return $Found_Account=$stmt->fetch();
  }else {
    return null;
  }
}

function confirmUserLogin(){
if (isset($_SESSION["UserId"])) {
  return true;
}  else {
  $_SESSION["ErrorMessage"]="Login Required !";
  Redirect_to("index.php");
}
}

function confirmAdminLogin(){
  if (isset($_SESSION["adminId"])) {
    return true;
  }  else {
    $_SESSION["ErrorMessage"]="Login Required !";
    Redirect_to("index.php");
  }
  }












 ?>