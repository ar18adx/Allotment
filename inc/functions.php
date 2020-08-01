<?php 

// Function to generate random plot Numbers

function plotNameGen($length){
  
  $adminCity = $_SESSION["adminSiteName"];

  if($_SESSION["adminRole"] == "Super_Admin"){
    $plotSite                 = $_POST["plotSite"];
  }elseif($_SESSION["adminRole"] == "Site_Manager"){
      $plotSite               = $adminCity;
  }
  
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


// Function for a (1 hour ago) time format

function time_ago($dateTime){
  
  date_default_timezone_set("Africa/Lagos");         
  $time_ago        = strtotime($dateTime);
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

// Function to redirect web pages

function Redirect_to($New_Location){
  header("Location:".$New_Location);
  exit;
}

//Function to check if a user exists on the Waiting list
//If a user exist on the waiting list, the application won't process.

function CheckUserExistsOnWl($userId){
  global $ConnectingDB;
  $sql    = "SELECT userId FROM waitinglist WHERE userId=:userID";
  $stmt   = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':userID',$userId);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return true;
  }else {
    return false;
  }
}

// Function to check if email exists in the Users table during a New user registration
//If email exists,  the registration will not be submitted

function CheckEmailExistsOrNot($emailAddress){
  global $ConnectingDB;
  $sql    = "SELECT emailAddress FROM users WHERE emailAddress=:emailAddresS";
  $stmt   = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':emailAddresS',$emailAddress);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return true;
  }else {
    return false;
  }
}


// Function to check if a city exists in the Cities table when adding a new city
// If city exists, A duplicate city will not be added

function CheckCityExistsOrNot($cityName){
  global $ConnectingDB;
  $sql    = "SELECT cityName FROM cities WHERE cityName=:cityName";
  $stmt   = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':cityName',$cityName);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return true;
  }else {
    return false;
  }
}

// Function to check if the city short code (ABS, AKU, XYZ) exists in  the city table
// Duplicate city short codes can't exist on the table

function CheckCityCSCOrNot($cityShortCode){
  global $ConnectingDB;
  $sql    = "SELECT cityShortCode FROM cities WHERE cityShortCode=:cityShortCoDe";
  $stmt   = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':cityShortCoDe',$cityShortCode);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return true;
  }else {
    return false;
  }
}

// Function to check if a plot number is valid in the plots table
// This is for users who have a specific plot number they are applying with

function CheckPlotNumExistsOrNot($plotNumber){
  global $ConnectingDB;
  $sql    = "SELECT plotNumber FROM plots WHERE plotNumber=:plotNuMber";
  $stmt   = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':plotNuMber',$plotNumber);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==0) {
    return true;
  }else {
    return false;
  }
}

// Check if plot Number exists in Tenant's table
// This is to prevent two tenants from occupying the same plot

function CheckPlotNumTnt($plotNumber){
  global $ConnectingDB;
  $sql    = "SELECT plotNumber FROM tenants WHERE plotNumber=:plotNuMber";
  $stmt   = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':plotNuMber',$plotNumber);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1) {
    return true;
  }else {
    return false;
  }
}

// Function to check if a plot number is valid in the plots table
// This is for users who have a specific plot number they are applying with

function CheckPlotNumAppExistsOrNot($plotNumberApp){
  global $ConnectingDB;
  $sql    = "SELECT plotNumber FROM plots WHERE plotNumber=:plotNuMberApp";
  $stmt   = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':plotNuMberApp',$plotNumberApp);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==0) {
    return true;
  }else {
    return false;
  }
}


// // Function to make sure a user does not apply for a plot more than once.
// function checkUserIdPltExists($userId){
//   global $ConnectingDB;
//   $sql    = "SELECT userId FROM waitinglist WHERE userId=:userID";
//   $stmt   = $ConnectingDB->prepare($sql);
//   $stmt->bindValue(':userID',$userId);
//   $stmt->execute();
//   $Result = $stmt->rowcount();
//   if ($Result==2) {
//     return true;
//   }else {
//     return false;
//   }
// }

// // Function to check if A user has previously applied for a particular Plot
// function checkPltNumExists($userId, $plotNumberApp){
//   global $ConnectingDB;
//   $sql    = "SELECT userId AND plotNumberApp FROM waitinglist WHERE userId=:userID AND plotNumberApp=:plotNumberApP " ;
//   // $sql = "SELECT plotNumberApp FROM waitinglist WHERE userId = :userID OR plotNumberApp=:plotNumberApP";
//   // $sql    = "SELECT plotNumberApp FROM waitinglist WHERE plotNumberApp=:plotNumberApP";
//   $stmt   = $ConnectingDB->prepare($sql);
//   $stmt->bindValue(':userID',$userId);
//   $stmt->bindValue(':plotNumberApP',$plotNumberApp);
//   $stmt->execute();
//   $Result = $stmt->rowcount();
//   if ($Result == 1 ) {
//     return true;
//   }else {
//     return false;
//   }
// }


// User Login Authentication Function
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

//Admin Login Authentication Function
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

// Confirm if a user is logged in, If not redirect the user to the login page

function confirmUserLogin(){
if (isset($_SESSION["userId"])) {
  return true;
}  else {
  $_SESSION["ErrorMessage"]="Login Required !";
  Redirect_to("index.php");
}
}

// Confirm if admin is logged in, If not redirect Admin to the admin login page

function confirmAdminLogin(){
  if (isset($_SESSION["adminId"])) {
    return true;
  }  else {
    $_SESSION["ErrorMessage"]="Login Required !";
    Redirect_to("adminLogin97.php");
  }
  }

  

// Count The total number of sites or Cities added

  function TotalSitesAdded(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM cities ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $TotalSitesAdded=array_shift($TotalRows);
    echo $TotalSitesAdded;

  }

  // Count the total number of Plots added

  function TotalPlotsAdded(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM plots ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $TotalPlotsAdded=array_shift($TotalRows);
    echo $TotalPlotsAdded;
  
  }

// Count the total number of plots in a particular site for a site manager

  function TotalPlotsSm(){
    $adminCity = $_SESSION["adminSiteName"];
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM plots WHERE plotSite = '$adminCity' ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $TotalPlotsSm=array_shift($TotalRows);
    echo $TotalPlotsSm;
  
  }

  // Count the total number of tenants on the tenants table

  function TotalTenants(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM tenants ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $TotalTenants=array_shift($TotalRows);
    echo $TotalTenants;
  
  }

  // Count the total number of tenants whose lease will expire in 90 days or below

  function SoonToBeExpLease(){
    global $ConnectingDB;
    $sql ="SELECT * FROM tenants ";
    $stmt = $ConnectingDB->query($sql);
    $DataRows=$stmt->fetch();
    $leaseDate              = $DataRows["leaseDate"];
    $oneMonthFromToday = date("Y-m-d", strtotime(date("Y-m-d", strtotime($leaseDate)). " + 90 day "));
    $sql = "SELECT COUNT(*) FROM tenants WHERE expirationDate <= '$oneMonthFromToday' ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $SoonToBeExpLease=array_shift($TotalRows);
    echo $SoonToBeExpLease;
  
  }

  // Count the total number of tenants whose lease will expire in 90 days or below in a particular site

  function SoonToBeExpLeaseSm(){
    $adminSiteName = $_SESSION["adminSiteName"];
    global $ConnectingDB;
    $sql ="SELECT * FROM tenants ";
    $stmt = $ConnectingDB->query($sql);
    $DataRows=$stmt->fetch();
    $leaseDate              = $DataRows["leaseDate"];
    $oneMonthFromToday = date("Y-m-d", strtotime(date("Y-m-d", strtotime($leaseDate)). " + 90 day "));
    $sql = "SELECT COUNT(*) FROM tenants WHERE siteCity = '$adminSiteName' AND expirationDate <= '$oneMonthFromToday' ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $SoonToBeExpLeaseSm=array_shift($TotalRows);
    echo $SoonToBeExpLeaseSm;
  
  }

  // Count the total number of unread messages for a tenant

  function TotalUnreadMsg(){
    $tenantId              = $_SESSION["userId"];
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM messages WHERE userId = '$tenantId' AND msgFrom = 'Site Manager' AND readMsg = 0  ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $TotalUnreadMsg=array_shift($TotalRows);
    echo $TotalUnreadMsg;
  
  }

  // Count the total number of unread messages for an Admin

  function TotalUnreadMsgSm(){
    $adminSiteName = $_SESSION["adminSiteName"];
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM messages WHERE siteName ='$adminSiteName' AND msgFrom != 'Site Manager' AND readMsg = 0  ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $TotalUnreadMsgSm=array_shift($TotalRows);
    echo $TotalUnreadMsgSm;
  
  }

  // Count the total number of tenants in a particular site
  function TotalTenantsSm(){
    $adminCity = $_SESSION["adminSiteName"];
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM tenants  WHERE siteCity ='$adminCity' ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $TotalTenantsSm=array_shift($TotalRows);
    echo $TotalTenantsSm;
  
  }

// Count the total number of users on the waiting list
  function TotalWaitingListNum(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM waitinglist ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $TotalWaitingListNum=array_shift($TotalRows);
    echo $TotalWaitingListNum;
  
  }

  // Count the total number of users on the waiting list for a particular site

  function TotalWaitingListSm(){
    $adminCity = $_SESSION["adminSiteName"];
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM waitinglist WHERE siteCity ='$adminCity' ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $TotalWaitingListSm=array_shift($TotalRows);
    echo $TotalWaitingListSm;
  
  }

  //Count the total number of Site managers on the admin table

  function TotalSiteManager(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM admins WHERE adminRole = 'Site_Manager' ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $TotalSiteManager=array_shift($TotalRows);
    echo $TotalSiteManager;
  
  }

  // Count the total number of plots per a particular site

  function TotalPlotsPerSite(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM plots WHERE plotSite = '$cityName' ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $TotalPlotsPerSite=array_shift($TotalRows);
    echo $TotalPlotsPerSite;
  
  }

  // function userPositionOnList(){
  //   global $ConnectingDB;
  //   $sql = "SELECT COUNT(*) FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND id = ";
  //   $stmt = $ConnectingDB->query($sql);
  //   $TotalRows= $stmt->fetch();
  //   $userPositionOnList=array_shift($TotalRows);
  //   echo $userPositionOnList;
  
  // }

  function AutomatedExpPlotTrnsf(){
    
        global $ConnectingDB;
        $sql ="SELECT * FROM tenants ";
        $stmt = $ConnectingDB->query($sql);
        while($DataRows=$stmt->fetch()){
        $id                       = $DataRows["id"];
        $plotId                 = $DataRows["plotId"];
        $plotNumber             = $DataRows["plotNumber"];
        $leaseDate              = $DataRows["leaseDate"];
        $expirationDate         = $DataRows["expirationDate"];
        }

        $todayDate = date("Y-m-d ");

        if($todayDate >= $expirationDate){

            $sql ="SELECT * FROM tenants WHERE '$todayDate' >= '$expirationDate' LIMIT 1 ";
            $stmt = $ConnectingDB->query($sql);
            while($DataRows=$stmt->fetch()){

                $tenantFirstName          = $DataRows["tenantFirstName"];
                $tenantLastName           = $DataRows["tenantLastName"];
                $id                       = $DataRows["id"];
                $tenantId                 = $DataRows["tenantId"];
                $tenantEmailAddress       = $DataRows["tenantEmailAddress"];
                $tenantPhoneNum           = $DataRows["tenantPhoneNum"];
                $tenantCity              = $DataRows["tenantCity"];
                $siteId               = $DataRows["siteId"];
                $siteCity               = $DataRows["siteCity"];
                $plotId               = $DataRows["plotId"];
                $plotNumber             = $DataRows["plotNumber"];
                $leaseDate              = $DataRows["leaseDate"];
                $expirationDate         = $DataRows["expirationDate"];
                $renewalStatus          = $DataRows["renewalStatus"];
                $tenantStatus           = $DataRows["tenantStatus"];

            }


          

              $sqlTrn = "INSERT INTO formertenants(tenantId, tenantFirstName, tenantLastName, tenantEmailAddress, tenantPhoneNum, tenantCity, siteCity, plotNumber, leaseDate, expirationDate )";
              $sqlTrn .= "VALUES('$tenantId', '$tenantFirstName', '$tenantLastName', '$tenantEmailAddress', '$tenantPhoneNum', '$tenantCity', '$siteCity', '$plotNumber', '$leaseDate', '$expirationDate')";
              $stmtTrn = $ConnectingDB->prepare($sqlTrn);
              $ExecuteTrn=$stmtTrn->execute();

              $sqlCpa = "UPDATE waitinglist SET siteIdNum = '$siteId', plotIdNum = '$plotId', plotNumberApp = '$plotNumber', applicationStatus ='Pending_Confirmation' WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
              $stmtCpa = $ConnectingDB->prepare($sqlCpa);
              $ExecuteCpa=$stmtCpa->execute();

              // Send email to the user on the waiting list
              $sqlSk = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
              $stmtSk = $ConnectingDB->query($sqlSk);
              while ($DataRows=$stmtSk->fetch()) {
              $applicantId             = $DataRows["id"];
              $applicantEmail          = $DataRows["emailAddress"];
              $applicantFirstName      = $DataRows["firstName"];
              }

                  $emailTo    = $applicantEmail;
                  $subject    = "New Plot Availability Alert";
                  $message    = "Hello ".$applicantFirstName."\n"." There is a new plot available for You."
                                  ."\n"."Log into Your account below."
                                  ."\n\n"."http://allotment-com.stackstaging.com/";

                  $headers    = "From: "."Allotment";
                  
                  mail($emailTo, $subject, $message, $headers);

                  $sqlE2 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumber' ";
                  $stmtE2 = $ConnectingDB->prepare($sqlE2);
                  $ExecuteE2=$stmtE2->execute();

                  $sqlUpd = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
                  $stmtUpd = $ConnectingDB->prepare($sqlUpd);
                  $ExecuteUpd=$stmtUpd->execute();

                  $sqlDel = "DELETE FROM tenants WHERE tenantId='$tenantId' ";
                  $stmtDel = $ConnectingDB->prepare($sqlDel);
                  $ExecuteDel=$stmtDel->execute();

           }
  
  }



 ?>