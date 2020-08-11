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
//If email exists,  the User details will not be submitted

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

//Function to check if a plot is occupied

function checkPlotOccupied($plotNumber){
  global $ConnectingDB;
  $sql    = "SELECT plotNumber FROM tenants WHERE plotNumber = :plotNuMber";
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

// Function to check if a plot is vacant

function CheckPlotVacant($plotNumberAssign){
  global $ConnectingDB;
  $sql    = "SELECT plotNumber FROM plots WHERE plotNumber=:plotNuMberAssign AND plotStatus = 'Vacant' ";
  $stmt   = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':plotNuMberAssign',$plotNumberAssign);
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
    Redirect_to("adminLogin.php");
  }
  }

 //MAP FUNCTIONALITY START /////////
 //Total number of plots
 function TotalNumberPlots($cityName){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM plots WHERE plotSite ='$cityName' ";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalNumberPlots=array_shift($TotalRows);
  echo $TotalNumberPlots;

}

function TotalWlNum($cityName){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM waitinglist WHERE siteCity = '$cityName' ";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalWlNum=array_shift($TotalRows);
  echo $TotalWlNum;

}

function TotalSoonVacantPlots($cityName){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM plots WHERE plotSite = '$cityName' AND plotStatus ='Soon_Vacant' ";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalSoonVacantPlots=array_shift($TotalRows);
  echo $TotalSoonVacantPlots;

}

function TotalVacantPlotsMp($cityName){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM plots WHERE plotSite = '$cityName' AND plotStatus ='Vacant' ";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows= $stmt->fetch();
  $TotalSoonVacantPlots=array_shift($TotalRows);
  echo $TotalSoonVacantPlots;

}



 //MAP FUNCTIONALITY END ///////////////

 //Total Tenant search results
 function TotalTenantSearchResults(){
  $adminSiteName = $_SESSION["adminSiteName"];
  if(isset($_GET["SearchTenant"])){
    $tenantNameSearch = $_GET["tenantName"];
  
    global $ConnectingDB;
    if($_SESSION["adminRole"] == "Super_Admin"){
      $sql = "SELECT COUNT(*) FROM tenants WHERE tenantFirstName LIKE :tenantNameSearch OR tenantLastName LIKE :tenantNameSearch ";
    }elseif($_SESSION["adminRole"] == "Site_Manager"){
      $sql = "SELECT COUNT(*) FROM tenants WHERE tenantFirstName LIKE :tenantNameSearch OR tenantLastName LIKE :tenantNameSearch AND siteCity = '$adminSiteName' ";
    }
    
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':tenantNameSearch','%'.$tenantNameSearch.'%');
    $TotalRows= $stmt->fetch();
    $TotalTenantSearchResults=array_shift($TotalRows);
    echo $TotalTenantSearchResults;
  }
}

//Total Plot Search Results
function TotalPlotSearchResults(){
  if(isset($_GET["SearchPlot"])){
    $plotNumberSearch = $_GET["PlotNumberSh"];
    
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM plots WHERE plotNumber = '$plotNumberSearch' ";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows= $stmt->fetch();
    $TotalPlotSearchResults=array_shift($TotalRows);
    echo $TotalPlotSearchResults;
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

// Function to send emails to tenant whose lease will expire in 30 days
  function tenantNotificationFor30Days(){
      global $ConnectingDB;
      $sql ="SELECT * FROM tenants";
      $stmt = $ConnectingDB->query($sql);
      $DataRows=$stmt->fetch();
      $id                     = $DataRows["id"];
      $tenantFirstNameRow          = $DataRows["tenantFirstName"];
      $tenantLastNameRow          = $DataRows["tenantLastName"];
      $leaseDateRow          = $DataRows["leaseDate"];
      $expirationDateRow         = $DataRows["expirationDate"];

      $oneMonthToExp        = date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDateRow)). " - 30 day "));
      
      $todayDate = date("Y-m-d");
      
      global $ConnectingDB;
      $sql ="SELECT * FROM tenants WHERE '$todayDate' = '$oneMonthToExp' ";
      $stmt = $ConnectingDB->query($sql);
      while($DataRows=$stmt->fetch()){
      $id                     = $DataRows["id"];
      $tenantFirstName          = $DataRows["tenantFirstName"];
      $tenantEmailAddress[]	          = $DataRows["tenantEmailAddress"];
      $leaseDate          = $DataRows["leaseDate"];
      $expirationDate          = $DataRows["expirationDate"];


          if(!empty($id) && !empty($tenantEmailAddress) && !empty($leaseDate) && !empty($expirationDate)){

              $emailTo    = implode(", ", $tenantEmailAddress);
              $subject    = "Lease Expiration Alert";
              $message    = "Hello ".$tenantFirstName."\n"." Your Lease Will expire in one month."
                              ."\n"."You did not renew Your lease, So Your plot will be vacant after the expiration of your lease";
                              

              $headers    = "From: "."Allotment";

            if(mail($emailTo, $subject, $message, $headers)){

                  echo "Message Sent"."<br>";
            
              }
          
          
          }else{
              echo "No Lease";
          }
      

      }
    
  }

// Function to send emails to tenant whose lease will expire in 90 days
function tenantNotificationFor90Days(){
      global $ConnectingDB;
      $sql ="SELECT * FROM tenants";
      $stmt = $ConnectingDB->query($sql);
      $DataRows=$stmt->fetch();
      $id                     = $DataRows["id"];
      $tenantFirstNameRow          = $DataRows["tenantFirstName"];
      $tenantLastNameRow          = $DataRows["tenantLastName"];
      $leaseDateRow          = $DataRows["leaseDate"];
      $expirationDateRow         = $DataRows["expirationDate"];

      $expirationDate90        = date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDateRow)). " - 90 day "));

      $todayDate = date("Y-m-d");

      global $ConnectingDB;
      $sql ="SELECT * FROM tenants WHERE '$todayDate' = '$expirationDate90' ";
      $stmt = $ConnectingDB->query($sql);
      while($DataRows=$stmt->fetch()){
      $id                     = $DataRows["id"];
      $tenantFirstName          = $DataRows["tenantFirstName"];
      $tenantEmailAddress[]	        = $DataRows["tenantEmailAddress"];
      $leaseDate              = $DataRows["leaseDate"];
      $expirationDate          = $DataRows["expirationDate"];

          if(!empty($id) && !empty($tenantEmailAddress) && !empty($leaseDate) && !empty($expirationDate)){

              $emailTo    = implode(", ", $tenantEmailAddress);
              $subject    = "Lease Expiration Alert";
              $message    = "Hello ".$tenantFirstName."\n"." Your Lease Will expire soon."
                              ."\n"."Log into Your account below If You are interested in renewing Your lease."
                              ."\n\n"."http://allotment-com.stackstaging.com/";

              $headers    = "From: "."Allotment";

            if(mail($emailTo, $subject, $message, $headers)){

                  echo "Message Sent"."<br>";
            
              }
          
          
          }else{
              echo "No Lease";
          }
      

      }
}

  // Function to send Contact validation Emails to Users on the waiting list
  function sendContactValidationToUsers(){
      global $ConnectingDB;
      $sql ="SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' ";
      $stmt = $ConnectingDB->query($sql);
      while ($DataRows=$stmt->fetch()){;
      $id                     = $DataRows["id"];
      $emailAddress[]       = $DataRows["emailAddress"];

      }

      if(!empty($emailAddress)){
          
          $emailTo    = implode(", ", $emailAddress);
          $subject    = "Contact And Interest Validation";
          $message    = "Please click on the link below to update Your contact details"
                          ."\n\n"."http://allotment-com.stackstaging.com/userContactVald.php";
          $headers    = "From: "."Allotment";

      

            if(mail($emailTo, $subject, $message, $headers)){
                echo "Contact Validation Sent";
            }else {
                echo "Something Went Wrong";
            }
      
        }else{
          echo "No User On Waiting list";
        }

  
  }


  // Fourteen days count function for a user Who does not accept the plot within 14 days and Offercount is LESS than 1
  function fourteenDaysCountLess1(){
        global $ConnectingDB;
        $sql ="SELECT * FROM waitinglist WHERE applicationStatus ='Pending_Confirmation' LIMIT 1";
        $stmt = $ConnectingDB->query($sql);
        while($DataRows=$stmt->fetch()){
        $id                     = $DataRows["id"];
        $tenantId              = $DataRows["userId"];
        $firstName          = $DataRows["firstName"];
        $lastName          = $DataRows["lastName"];
        $emailAddress	          = $DataRows["emailAddress"];
        $telephoneNumber          = $DataRows["telephoneNumber"];
        $userCity          = $DataRows["userCity"];
        $siteIdNum           = $DataRows["siteIdNum"];
        $siteCity          = $DataRows["siteCity"];
        $plotIdNum          = $DataRows["plotIdNum"];
        $plotNumberApp          = $DataRows["plotNumberApp"];
        $applicationStatus          = $DataRows["applicationStatus"];
        $offerCount          = $DataRows["offerCount"];
        $dateApplied        =   $DataRows["dateApplied"];
        $dateRecvRow        =   $DataRows["dateRecv"];
        $dateRecv               = date("Y-m-d");

        $daysCountFourteen         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateRecvRow)). " + 14 day "));
        
        $todayDate = date("Y-m-d");
        }

    // Query to insert values in DB
    global $ConnectingDB;
    // Transfer the plot number to a user on the waitinglist whose city is the SAME as their site.
    $sql04 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity = siteCity ";
    $stmt04 = $ConnectingDB->prepare($sql04);
    $stmt04->execute();
    $Result04 = $stmt04->rowcount();
    if($Result04 > 0) {

        $sqlCpa = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation', dateRecv ='$dateRecv' WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
        $stmtCpa = $ConnectingDB->prepare($sqlCpa);
        $ExecuteCpa=$stmtCpa->execute();

        $sqlSm = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
        $stmtSm = $ConnectingDB->query($sqlSm);
        while($DataRows=$stmtSm->fetch()){
        $applicantId             = $DataRows["id"];
        $applicantEmail          = $DataRows["emailAddress"];
        $applicantUserId         = $DataRows["userId"];
        $applicantFirstName      = $DataRows["firstName"];

        }

        if(!empty($applicantId) && !empty($applicantEmail) && !empty($applicantUserId) && !empty($applicantFirstName)){

            $emailTo    = $applicantEmail;
            $subject    = "New Plot Availability Alert";
            $message    = "Hello ".$applicantFirstName."\n"." There is a new plot available for You."
                            ."\n"."Log into Your account below."
                            ."\n\n"."http://allotment-com.stackstaging.com/";

            $headers    = "From: "."Allotment";

            mail($emailTo, $subject, $message, $headers);

            $sqlC = "UPDATE users SET userStatus = 'Pending_Confirmation' WHERE id ='$applicantUserId' ";
            $stmtC = $ConnectingDB->prepare($sqlC);
            $ExecuteC=$stmtC->execute();
        
        }

        
        $sqlE2 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumberApp' ";
        $stmtE2 = $ConnectingDB->prepare($sqlE2);
        $ExecuteE2=$stmtE2->execute();

        $sqlG4 = "UPDATE users SET userStatus = 'Awaiting_Plot' WHERE id ='$tenantId' ";
        $stmtG4 = $ConnectingDB->prepare($sqlG4);
        $ExecuteG4=$stmtG4->execute();

        $sqlRjc = "UPDATE waitinglist SET siteIdNum  = 'None', siteCity = '$siteCity', plotIdNum = 'None', plotNumberApp = 'None', applicationStatus = 'Awaiting_Plot', dateRecv = 'None', offerCount = offerCount + 1 WHERE userId = '$tenantId' ";
        $stmtRjc = $ConnectingDB->prepare($sqlRjc);
        $ExecuteRjc=$stmtRjc->execute();

        
        
    }elseif($Result04 == 0){
        // If there is no user on the waitinglist who lives in the same city as the site he/she applied for, then transfer 
        // the plot to a  user whoose city is different as the site he/she applied for.
        
        $sql07 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity !='siteCity' ";
        $stmt07 = $ConnectingDB->prepare($sql07);
        $stmt07->execute();
        $Result07 = $stmt07->rowcount();
            if ($Result07 > 0) {

                $sql1x = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation', dateRecv ='$dateRecv' WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
                $stmt1x = $ConnectingDB->prepare($sql1x);
                $Execute1x=$stmt1x->execute();

                $sqlSmc = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
                $stmtSmc = $ConnectingDB->query($sqlSmc);
                while($DataRows=$stmtSmc->fetch()){
                $applicantIdDc                     = $DataRows["id"];
                $applicantEmailDc          = $DataRows["emailAddress"];
                $applicantUserIdDc          = $DataRows["userId"];
                $applicantFirstNameDc       = $DataRows["firstName"];

                }

                if(!empty($applicantIdDc) && !empty($applicantEmailDc) && !empty($applicantUserIdDc) && !empty($applicantFirstNameDc)){
                    $emailTo    = $applicantEmailDc;
                    $subject    = "New Plot Availability Alert";
                    $message    = "Hello ".$applicantFirstNameDc."\n"." There is a new plot available for You. "
                                    ."\n"."Log into Your account below."
                                    ."\n\n"."http://allotment-com.stackstaging.com/";

                    $headers    = "From: "."Allotment";
    
                    mail($emailTo, $subject, $message, $headers);
                

                    $sqlC2 = "UPDATE users SET userStatus = 'Pending_Confirmation' WHERE id ='$applicantUserIdDc' ";
                    $stmtC2 = $ConnectingDB->prepare($sqlC2);
                    $ExecuteC2=$stmtC2->execute();
                
                  }

                
                $sqlE6 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumberApp' ";
                $stmtE6 = $ConnectingDB->prepare($sqlE6);
                $ExecuteE6=$stmtE6->execute();

                $sqlRj9 = "UPDATE waitinglist SET siteIdNum  = 'None', siteCity = '$siteCity', plotIdNum = 'None', plotNumberApp = 'None', applicationStatus = 'Awaiting_Plot', dateRecv = 'None', offerCount = offerCount + 1 WHERE userId = '$tenantId' ";
                $stmtRj9 = $ConnectingDB->prepare($sqlRj9);
                $ExecuteRj9=$stmtRj9->execute();


            }
            
            // If There are no users on the waitinglist, then set plot status to Vacant

                if($Result07 == 0){

                    $sql92 = "UPDATE plots SET plotStatus = 'Vacant' WHERE plotNumber ='$plotNumberApp' ";
                    $stmt92 = $ConnectingDB->prepare($sql92);
                    $Execute92=$stmt92->execute();
                
                $sqlRjz = "UPDATE waitinglist SET siteIdNum  = 'None', siteCity = '$siteCity', plotIdNum = 'None', plotNumberApp = 'None', applicationStatus = 'Awaiting_Plot', dateRecv = 'None', offerCount = offerCount + 1 WHERE userId = '$tenantId' ";
                $stmtRjz = $ConnectingDB->prepare($sqlRjz);
                $ExecuteRjz=$stmtRjz->execute();
                }

    }
        
}

// Fourteen days count function for a user Who does not accept the plot within 14 days and Offercount is GREATER than 1
function fourteenDaysCountGt1(){

  global $ConnectingDB;
  $sql ="SELECT * FROM waitinglist WHERE applicationStatus ='Pending_Confirmation' LIMIT 1";
  $stmt = $ConnectingDB->query($sql);
  while($DataRows=$stmt->fetch()){
  $id                     = $DataRows["id"];
  $tenantId                     = $DataRows["userId"];
  $firstName          = $DataRows["firstName"];
  $lastName          = $DataRows["lastName"];
  $emailAddress	          = $DataRows["emailAddress"];
  $telephoneNumber          = $DataRows["telephoneNumber"];
  $userCity          = $DataRows["userCity"];
  $siteIdNum           = $DataRows["siteIdNum"];
  $siteCity          = $DataRows["siteCity"];
  $plotIdNum          = $DataRows["plotIdNum"];
  $plotNumberApp          = $DataRows["plotNumberApp"];
  $applicationStatus          = $DataRows["applicationStatus"];
  $offerCount          = $DataRows["offerCount"];
  $dateApplied        =   $DataRows["dateApplied"];
  $dateRecvRow        =   $DataRows["dateRecv"];
  $dateRecv               = date("Y-m-d");

  $daysCountFourteen         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateRecvRow)). " + 14 day "));
  $start_dateF = date_create(date("Y-m-d"));
  $end_dateF   = date_create($daysCountFourteen);

  //difference between two dates
  $diff4 = date_diff($start_dateF,$end_dateF);
  $todayDate = date("Y-m-d");

  }
  // Transfer the plot number to a user on the waitinglist whose city is the SAME as their site.
  $sql04 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity = siteCity ";
  $stmt04 = $ConnectingDB->prepare($sql04);
  $stmt04->execute();
  $Result04 = $stmt04->rowcount();
  if($Result04 > 0) {

      $sqlCpa = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation', dateRecv ='$dateRecv' WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
      $stmtCpa = $ConnectingDB->prepare($sqlCpa);
      $ExecuteCpa=$stmtCpa->execute();

      $sqlSm = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
      $stmtSm = $ConnectingDB->query($sqlSm);
      while($DataRows=$stmtSm->fetch()){
      $applicantId             = $DataRows["id"];
      $applicantEmail          = $DataRows["emailAddress"];
      $applicantUserId         = $DataRows["userId"];
      $applicantFirstName      = $DataRows["firstName"];

      }

          if(!empty($applicantId) && !empty($applicantEmail) && !empty($applicantUserId) && !empty($applicantFirstName)){
              $emailTo    = $applicantEmail;
              $subject    = "New Plot Availability Alert";
              $message    = "Hello ".$applicantFirstName."\n"." There is a new plot available for You."
                              ."\n"."Log into Your account below."
                              ."\n\n"."http://allotment-com.stackstaging.com/";

              $headers    = "From: "."Allotment";

              mail($emailTo, $subject, $message, $headers);

              $sqlC = "UPDATE users SET userStatus = 'Pending_Confirmation' WHERE id ='$applicantUserId' ";
              $stmtC = $ConnectingDB->prepare($sqlC);
              $ExecuteC=$stmtC->execute();
          }

      
          $sqlE2 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumberApp' ";
          $stmtE2 = $ConnectingDB->prepare($sqlE2);
          $ExecuteE2=$stmtE2->execute();

          $sqlG4 = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
          $stmtG4 = $ConnectingDB->prepare($sqlG4);
          $ExecuteG4=$stmtG4->execute();

          $sqlDel2 = "DELETE FROM waitinglist WHERE userId = '$tenantId' ";
          $stmtDel2 = $ConnectingDB->prepare($sqlDel2);
          $ExecuteDel2=$stmtDel2->execute();
          
          if($ExecuteDel2){
            echo "Plot transfered - The user is now a new user";
          }else{
            echo "No Plot was transfered";
          }

      
      
  }elseif($Result04 == 0){
      // If there is no user on the waitinglist who lives in the same city as the site he/she applied for, then transfer 
      // the plot to a  user whoose city is different as the site he/she applied for.
      
      $sql07 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity !='siteCity' ";
      $stmt07 = $ConnectingDB->prepare($sql07);
      $stmt07->execute();
      $Result07 = $stmt07->rowcount();
          if ($Result07 > 0) {

              $sql1x = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation', dateRecv ='$dateRecv' WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
              $stmt1x = $ConnectingDB->prepare($sql1x);
              $Execute1x=$stmt1x->execute();

              $sqlSmc = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
              $stmtSmc = $ConnectingDB->query($sqlSmc);
              while($DataRows=$stmtSmc->fetch()){
              $applicantIdDc                     = $DataRows["id"];
              $applicantEmailDc          = $DataRows["emailAddress"];
              $applicantUserIdDc          = $DataRows["userId"];
              $applicantFirstNameDc       = $DataRows["firstName"];

              }

              if(!empty($applicantIdDc) && !empty($applicantEmailDc) && !empty($applicantUserIdDc) && !empty($applicantFirstNameDc)){
                  $emailTo    = $applicantEmailDc;
                  $subject    = "New Plot Availability Alert";
                  $message    = "Hello ".$applicantFirstNameDc."\n"." There is a new plot available for You. "
                                  ."\n"."Log into Your account below."
                                  ."\n\n"."http://allotment-com.stackstaging.com/";

                  $headers    = "From: "."Allotment";
  
                  mail($emailTo, $subject, $message, $headers);

                  $sqlC2 = "UPDATE users SET userStatus = 'Pending_Confirmation' WHERE id ='$applicantUserIdDc' ";
                  $stmtC2 = $ConnectingDB->prepare($sqlC2);
                  $ExecuteC2=$stmtC2->execute();
              }

              
              $sqlE6 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumberApp' ";
              $stmtE6 = $ConnectingDB->prepare($sqlE6);
              $ExecuteE6=$stmtE6->execute();

              $sqlG4 = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
              $stmtG4 = $ConnectingDB->prepare($sqlG4);
              $ExecuteG4=$stmtG4->execute();

              $sqlDel2 = "DELETE FROM waitinglist WHERE userId = '$tenantId' ";
              $stmtDel2 = $ConnectingDB->prepare($sqlDel2);
              $ExecuteDel2=$stmtDel2->execute();

                  if($ExecuteDel2){
                  echo "Plot Transfered - The user is now a new user";
                  }else{
                  echo "No Plot transfered";
                  }

          }
          
          // If There are no users on the waitinglist, then set plot status to Vacant

              if($Result07 == 0){

                  $sql92 = "UPDATE plots SET plotStatus = 'Vacant' WHERE plotNumber ='$plotNumberApp' ";
                  $stmt92 = $ConnectingDB->prepare($sql92);
                  $Execute92=$stmt92->execute();

                  $sqlG4 = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
                  $stmtG4 = $ConnectingDB->prepare($sqlG4);
                  $ExecuteG4=$stmtG4->execute();

                  $sqlDel2 = "DELETE FROM waitinglist WHERE userId = '$tenantId' ";
                  $stmtDel2 = $ConnectingDB->prepare($sqlDel2);
                  $ExecuteDel2=$stmtDel2->execute();

              }

            echo "The Plot has been transfered";

            }else {
            echo "No plot transfered";
            }

}

  // Waiting list function for a user Who rejects with an Offercount LESS than 1
  function waitingListPlotTransferOcLess1(){

        $tenantId                 =   $_SESSION["userId"];

        // Fetch users details on the waitinglist
        global $ConnectingDB;
        $sql ="SELECT * FROM waitinglist WHERE userId = '$tenantId'  ";
        $stmt = $ConnectingDB->query($sql);
        $DataRows=$stmt->fetch();
        $id                     = $DataRows["id"];
        // $userIdRow                     = $DataRows["userId"];
        $firstName          = $DataRows["firstName"];
        $lastName          = $DataRows["lastName"];
        $emailAddress	          = $DataRows["emailAddress"];
        $telephoneNumber          = $DataRows["telephoneNumber"];
        $userCity          = $DataRows["userCity"];
        $siteIdNum           = $DataRows["siteIdNum"];
        $siteCity          = $DataRows["siteCity"];
        $plotIdNum          = $DataRows["plotIdNum"];
        $plotNumberApp          = $DataRows["plotNumberApp"];
        $applicationStatus          = $DataRows["applicationStatus"];
        $offerCount          = $DataRows["offerCount"];
        $dateApplied        =   $DataRows["dateApplied"];
        $dateRecvRow        =   $DataRows["dateRecv"];
        $dateRecv               = date("Y-m-d");

        //Fetch Site City with plot Number
        $sql2t    = "SELECT plotSite FROM plots WHERE plotNumber=:plotNumberApP";
        $stmt2t   = $ConnectingDB->prepare($sql2t);
        $stmt2t->bindValue(':plotNumberApP',$plotNumberApp);
        $stmt2t->execute();
        $DataRows2t = $stmt2t->fetch();
        $plotNumberRw              = $DataRows2t["plotNumber"];
        $plotSiteRow          = $DataRows2t["plotSite"];

        // Query to insert values in DB
        global $ConnectingDB;
        // Transfer the plot number to a user on the waitinglist whose city is the SAME as their site.
        $sql04 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity = siteCity ";
        $stmt04 = $ConnectingDB->prepare($sql04);
        $stmt04->execute();
        $Result04 = $stmt04->rowcount();
        if($Result04 > 0) {


            $sqlSm = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
            $stmtSm = $ConnectingDB->query($sqlSm);
            while($DataRows=$stmtSm->fetch()){
            $applicantId             = $DataRows["id"];
            $applicantEmail          = $DataRows["emailAddress"];
            $applicantUserId         = $DataRows["userId"];
            $applicantFirstName      = $DataRows["firstName"];

            }

            if(!empty($applicantId) && !empty($applicantEmail) && !empty($applicantUserId) && !empty($applicantFirstName)){

                $emailTo    = $applicantEmail;
                $subject    = "New Plot Availability Alert";
                $message    = "Hello ".$applicantFirstName."\n"." There is a new plot available for You."
                                ."\n"."Log into Your account below."
                                ."\n\n"."http://allotment-com.stackstaging.com/";

                $headers    = "From: "."Allotment";

                mail($emailTo, $subject, $message, $headers);

                $sqlC = "UPDATE users SET userStatus = 'Pending_Confirmation' WHERE id ='$applicantUserId' ";
                $stmtC = $ConnectingDB->prepare($sqlC);
                $ExecuteC=$stmtC->execute();
            
            }

            $sqlCpa = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', siteCity ='$plotSiteRow', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation', dateRecv ='$dateRecv' WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
            $stmtCpa = $ConnectingDB->prepare($sqlCpa);
            $ExecuteCpa=$stmtCpa->execute();
            
            $sqlE2 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumberApp' ";
            $stmtE2 = $ConnectingDB->prepare($sqlE2);
            $ExecuteE2=$stmtE2->execute();

            $sqlG4 = "UPDATE users SET userStatus = 'Awaiting_Plot' WHERE id ='$tenantId' ";
            $stmtG4 = $ConnectingDB->prepare($sqlG4);
            $ExecuteG4=$stmtG4->execute();

            $sqlRjc = "UPDATE waitinglist SET siteIdNum  = 'None', siteCity = '$siteCity', plotIdNum = 'None', plotNumberApp = 'None', applicationStatus = 'Awaiting_Plot', dateRecv = 'None', offerCount = offerCount + 1 WHERE userId = '$tenantId' ";
            $stmtRjc = $ConnectingDB->prepare($sqlRjc);
            $ExecuteRjc=$stmtRjc->execute();

            
            
        }elseif($Result04 == 0){
            // If there is no user on the waitinglist who lives in the same city as the site he/she applied for, then transfer 
            // the plot to a  user whoose city is different as the site he/she applied for.
            
            $sql07 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity !='siteCity' ";
            $stmt07 = $ConnectingDB->prepare($sql07);
            $stmt07->execute();
            $Result07 = $stmt07->rowcount();
                if ($Result07 > 0) {

                    $sqlSmc = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
                    $stmtSmc = $ConnectingDB->query($sqlSmc);
                    while($DataRows=$stmtSmc->fetch()){
                    $applicantIdDc                     = $DataRows["id"];
                    $applicantEmailDc          = $DataRows["emailAddress"];
                    $applicantUserIdDc          = $DataRows["userId"];
                    $applicantFirstNameDc       = $DataRows["firstName"];

                    }

                    if(!empty($applicantIdDc) && !empty($applicantEmailDc) && !empty($applicantUserIdDc) && !empty($applicantFirstNameDc)){

                        $emailTo    = $applicantEmailDc;
                        $subject    = "New Plot Availability Alert";
                        $message    = "Hello ".$applicantFirstNameDc."\n"." There is a new plot available for You. "
                                        ."\n"."Log into Your account below."
                                        ."\n\n"."http://allotment-com.stackstaging.com/";

                        $headers    = "From: "."Allotment";
        
                        mail($emailTo, $subject, $message, $headers);

                        $sqlC2 = "UPDATE users SET userStatus = 'Pending_Confirmation' WHERE id ='$applicantUserIdDc' ";
                        $stmtC2 = $ConnectingDB->prepare($sqlC2);
                        $ExecuteC2=$stmtC2->execute();

                    }

                    $sql1x = "UPDATE waitinglist SET siteIdNum = '$siteIdNum',siteCity ='$plotSiteRow', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation', dateRecv ='$dateRecv' WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
                    $stmt1x = $ConnectingDB->prepare($sql1x);
                    $Execute1x=$stmt1x->execute();
                    
                    $sqlE6 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumberApp' ";
                    $stmtE6 = $ConnectingDB->prepare($sqlE6);
                    $ExecuteE6=$stmtE6->execute();

                    $sqlRj9 = "UPDATE waitinglist SET siteIdNum  = 'None', siteCity = '$siteCity', plotIdNum = 'None', plotNumberApp = 'None', applicationStatus = 'Awaiting_Plot', dateRecv = 'None', offerCount = offerCount + 1 WHERE userId = '$tenantId' ";
                    $stmtRj9 = $ConnectingDB->prepare($sqlRj9);
                    $ExecuteRj9=$stmtRj9->execute();


                }
                
                // If There are no users on the waitinglist, then set plot status to Vacant

                    if($Result07 == 0){

                        $sql92 = "UPDATE plots SET plotStatus = 'Vacant' WHERE plotNumber ='$plotNumberApp' ";
                        $stmt92 = $ConnectingDB->prepare($sql92);
                        $Execute92=$stmt92->execute();
                    }
                    $sqlRjz = "UPDATE waitinglist SET siteIdNum  = 'None', siteCity = '$siteCity', plotIdNum = 'None', plotNumberApp = 'None', applicationStatus = 'Awaiting_Plot', dateRecv = 'None', offerCount = offerCount + 1 WHERE userId = '$tenantId' ";
                    $stmtRjz = $ConnectingDB->prepare($sqlRjz);
                    $ExecuteRjz=$stmtRjz->execute();

        }
            
        if($ExecuteRjc){
            
        $_SESSION["SuccessMessage"]="You have Rejected the plot";
        Redirect_to("applyForPlots.php");

        }else {
        $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
        Redirect_to("confirmOffer.php");
        }
    
  }

 

  // Waiting list function for a user Who rejects with an Offercount Greater than 1
   function waitingListPlotTransferOcg1(){
        global $ConnectingDB;

        $tenantId                 =   $_SESSION["userId"];

        // Fetch users details on the waitinglist
        global $ConnectingDB;
        $sql ="SELECT * FROM waitinglist WHERE userId = '$tenantId'  ";
        $stmt = $ConnectingDB->query($sql);
        $DataRows=$stmt->fetch();
        $id                     = $DataRows["id"];
        // $userIdRow                     = $DataRows["userId"];
        $firstName          = $DataRows["firstName"];
        $lastName          = $DataRows["lastName"];
        $emailAddress	          = $DataRows["emailAddress"];
        $telephoneNumber          = $DataRows["telephoneNumber"];
        $userCity          = $DataRows["userCity"];
        $siteIdNum           = $DataRows["siteIdNum"];
        $siteCity          = $DataRows["siteCity"];
        $plotIdNum          = $DataRows["plotIdNum"];
        $plotNumberApp          = $DataRows["plotNumberApp"];
        $applicationStatus          = $DataRows["applicationStatus"];
        $offerCount          = $DataRows["offerCount"];
        $dateApplied        =   $DataRows["dateApplied"];
        $dateRecvRow        =   $DataRows["dateRecv"];
        $dateRecv               = date("Y-m-d");

        //Fetch Site City with plot Number
        $sql2t    = "SELECT plotSite FROM plots WHERE plotNumber=:plotNumberApP";
        $stmt2t   = $ConnectingDB->prepare($sql2t);
        $stmt2t->bindValue(':plotNumberApP',$plotNumberApp);
        $stmt2t->execute();
        $DataRows2t = $stmt2t->fetch();
        $plotNumberRw              = $DataRows2t["plotNumber"];
        $plotSiteRow          = $DataRows2t["plotSite"];

        // Transfer the plot number to a user on the waitinglist whose city is the SAME as their site.
        $sql04 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity = siteCity ";
        $stmt04 = $ConnectingDB->prepare($sql04);
        $stmt04->execute();
        $Result04 = $stmt04->rowcount();
        if($Result04 > 0) {

            $sqlSm = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
            $stmtSm = $ConnectingDB->query($sqlSm);
            while($DataRows=$stmtSm->fetch()){
            $applicantId             = $DataRows["id"];
            $applicantEmail          = $DataRows["emailAddress"];
            $applicantUserId         = $DataRows["userId"];
            $applicantFirstName      = $DataRows["firstName"];

            }

                if(!empty($applicantId) && !empty($applicantEmail) && !empty($applicantUserId) && !empty($applicantFirstName)){
                    $emailTo    = $applicantEmail;
                    $subject    = "New Plot Availability Alert";
                    $message    = "Hello ".$applicantFirstName."\n"." There is a new plot available for You."
                                    ."\n"."Log into Your account below."
                                    ."\n\n"."http://allotment-com.stackstaging.com/";

                    $headers    = "From: "."Allotment";

                    mail($emailTo, $subject, $message, $headers);

                    $sqlC = "UPDATE users SET userStatus = 'Pending_Confirmation' WHERE id ='$applicantUserId' ";
                    $stmtC = $ConnectingDB->prepare($sqlC);
                    $ExecuteC=$stmtC->execute();
                }

                $sqlCpa = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', siteCity ='$plotSiteRow', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation', dateRecv ='$dateRecv' WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
                $stmtCpa = $ConnectingDB->prepare($sqlCpa);
                $ExecuteCpa=$stmtCpa->execute();
            
                $sqlE2 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumberApp' ";
                $stmtE2 = $ConnectingDB->prepare($sqlE2);
                $ExecuteE2=$stmtE2->execute();

                $sqlG4 = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
                $stmtG4 = $ConnectingDB->prepare($sqlG4);
                $ExecuteG4=$stmtG4->execute();

                $sqlDel2 = "DELETE FROM waitinglist WHERE userId = '$tenantId' ";
                $stmtDel2 = $ConnectingDB->prepare($sqlDel2);
                $ExecuteDel2=$stmtDel2->execute();
                
                if($ExecuteDel2){

                  $_SESSION["userStatus"] = 'New_User';

                $_SESSION["SuccessMessage"]="You have Rejected the 2 plots that were allocated to You. You will have to apply as a new user in order to get a plot";
                Redirect_to("applyForPlots.php");
                }else{
                $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
                Redirect_to("confirmOffer.php");
                }

            
            
        }elseif($Result04 == 0){
            // If there is no user on the waitinglist who lives in the same city as the site he/she applied for, then transfer 
            // the plot to a  user whoose city is different as the site he/she applied for.
            
            $sql07 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity !='siteCity' ";
            $stmt07 = $ConnectingDB->prepare($sql07);
            $stmt07->execute();
            $Result07 = $stmt07->rowcount();
                if ($Result07 > 0) {

                    $sqlSmc = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
                    $stmtSmc = $ConnectingDB->query($sqlSmc);
                    while($DataRows=$stmtSmc->fetch()){
                    $applicantIdDc                     = $DataRows["id"];
                    $applicantEmailDc          = $DataRows["emailAddress"];
                    $applicantUserIdDc          = $DataRows["userId"];
                    $applicantFirstNameDc       = $DataRows["firstName"];

                    }

                    if(!empty($applicantIdDc) && !empty($applicantEmailDc) && !empty($applicantUserIdDc) && !empty($applicantFirstNameDc)){

                        $emailTo    = $applicantEmailDc;
                        $subject    = "New Plot Availability Alert";
                        $message    = "Hello ".$applicantFirstNameDc."\n"." There is a new plot available for You. "
                                        ."\n"."Log into Your account below."
                                        ."\n\n"."http://allotment-com.stackstaging.com/";

                        $headers    = "From: "."Allotment";
        
                        mail($emailTo, $subject, $message, $headers);

                        $sqlC2 = "UPDATE users SET userStatus = 'Pending_Confirmation' WHERE id ='$applicantUserIdDc' ";
                        $stmtC2 = $ConnectingDB->prepare($sqlC2);
                        $ExecuteC2=$stmtC2->execute();
                    
                      }

                    $sql1x = "UPDATE waitinglist SET siteIdNum = '$siteIdNum', siteCity ='$plotSiteRow', plotIdNum = '$plotIdNum', plotNumberApp = '$plotNumberApp', applicationStatus ='Pending_Confirmation', dateRecv ='$dateRecv' WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
                    $stmt1x = $ConnectingDB->prepare($sql1x);
                    $Execute1x=$stmt1x->execute();
                    
                    $sqlE6 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumberApp' ";
                    $stmtE6 = $ConnectingDB->prepare($sqlE6);
                    $ExecuteE6=$stmtE6->execute();

                    $sqlG4 = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
                    $stmtG4 = $ConnectingDB->prepare($sqlG4);
                    $ExecuteG4=$stmtG4->execute();

                    $sqlDel2 = "DELETE FROM waitinglist WHERE userId = '$tenantId' ";
                    $stmtDel2 = $ConnectingDB->prepare($sqlDel2);
                    $ExecuteDel2=$stmtDel2->execute();

                        if($ExecuteDel2){

                          $_SESSION["userStatus"] = 'New_User';

                        $_SESSION["SuccessMessage"]="You have Rejected the 2 plots that were allocated to You. You will have to apply as a new user in order to get a plot";
                        Redirect_to("applyForPlots.php");
                        }else{
                        $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
                        Redirect_to("confirmOffer.php");
                        }

                }
                
                // If There are no users on the waitinglist, then set plot status to Vacant

                    if($Result07 == 0){

                        $sql92 = "UPDATE plots SET plotStatus = 'Vacant' WHERE plotNumber ='$plotNumberApp' ";
                        $stmt92 = $ConnectingDB->prepare($sql92);
                        $Execute92=$stmt92->execute();

                        $sqlG4 = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
                        $stmtG4 = $ConnectingDB->prepare($sqlG4);
                        $ExecuteG4=$stmtG4->execute();

                        $sqlDel2 = "DELETE FROM waitinglist WHERE userId = '$tenantId' ";
                        $stmtDel2 = $ConnectingDB->prepare($sqlDel2);
                        $ExecuteDel2=$stmtDel2->execute();

                    }

                    $_SESSION["userStatus"] = 'New_User';

          $_SESSION["SuccessMessage"]="You have Rejected the 2 plots that were allocated to You. You will have to apply as a new user in order to get a plot";
          Redirect_to("applyForPlots.php");

          }else {
          $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
          Redirect_to("confirmOffer.php");
          }
    
  
  }

  //Function to handle an expired lease
  function AutomatedExpPlotTrnsf(){
    
        global $ConnectingDB;
        
        $todayDate = date("Y-m-d ");
        
            $sql ="SELECT * FROM tenants WHERE expirationDate <= '$todayDate' LIMIT 1 ";
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

                //Fetch Site City with plot Number
                $sql2t    = "SELECT plotSite FROM plots WHERE plotNumber=:plotNumberApP";
                $stmt2t   = $ConnectingDB->prepare($sql2t);
                $stmt2t->bindValue(':plotNumberApP',$plotNumberApp);
                $stmt2t->execute();
                $DataRows2t = $stmt2t->fetch();
                $plotNumberRw              = $DataRows2t["plotNumber"];
                $plotSiteRow          = $DataRows2t["plotSite"];

            }    
            
            
            if(!empty($tenantId) && $todayDate >= $expirationDate){
                // Insert Tenant's information into The formertenants table
                $sqlTrn = "INSERT INTO formertenants(tenantId, tenantFirstName, tenantLastName, tenantEmailAddress, tenantPhoneNum, tenantCity, siteCity, plotNumber, leaseDate, expirationDate )";
                $sqlTrn .= "VALUES('$tenantId', '$tenantFirstName', '$tenantLastName', '$tenantEmailAddress', '$tenantPhoneNum', '$tenantCity', '$siteCity', '$plotNumber', '$leaseDate', '$expirationDate')";
                $stmtTrn = $ConnectingDB->prepare($sqlTrn);
                $ExecuteTrn=$stmtTrn->execute();
        
                $sqlExp = "UPDATE plots SET plotStatus = 'Vacant' WHERE plotNumber ='$plotNumber' ";
                $stmtExp = $ConnectingDB->prepare($sqlExp);
                $ExecuteExp=$stmtExp->execute();
        
                // Transfer the plot number to a user on the waitinglist whoose city is the same as their site.
                $sql04 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity = siteCity ";
                $stmt04 = $ConnectingDB->prepare($sql04);
                $stmt04->execute();
                $Result04 = $stmt04->rowcount();
                if ($Result04 > 0) {
      
                  // Send email to the user on the waiting list
                  $sqlSk = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
                  $stmtSk = $ConnectingDB->query($sqlSk);
                  while ($DataRows=$stmtSk->fetch()) {
                  $applicantId             = $DataRows["id"];
                  $applicantEmail          = $DataRows["emailAddress"];
                  $applicantFirstName      = $DataRows["firstName"];
                  }
      
                  if(!empty($applicantId) && !empty($applicantEmail) && !empty($applicantUserId) && !empty($applicantFirstName)){

                      $emailTo    = $applicantEmail;
                      $subject    = "New Plot Availability Alert";
                      $message    = "Hello ".$applicantFirstName."\n"." There is a new plot available for You."
                                      ."\n"."Log into Your account below."
                                      ."\n\n"."http://allotment-com.stackstaging.com/";
      
                      $headers    = "From: "."Allotment";
      
                      mail($emailTo, $subject, $message, $headers);
                  
                  }

                  $sqlE2 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumber' ";
                  $stmtE2 = $ConnectingDB->prepare($sqlE2);
                  $ExecuteE2=$stmtE2->execute();

                  $sqlCpa = "UPDATE waitinglist SET siteIdNum = '$siteId', siteCity = '$plotSiteRow', plotIdNum = '$id', plotNumberApp = '$plotNumber', applicationStatus ='Pending_Confirmation' WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
                  $stmtCpa = $ConnectingDB->prepare($sqlCpa);
                  $ExecuteCpa=$stmtCpa->execute();
      
      
              }elseif($Result04 == 0){
                  // If there is no user on the waitinglist who lives in the same city as the site he/she applied for, then transfer 
                  // the plot to a  user whoose city is different as the site he/she applied for.
      
                  $sql07 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity !='siteCity' ";
                  $stmt07 = $ConnectingDB->prepare($sql07);
                  $stmt07->execute();
                  $Result07 = $stmt07->rowcount();
                      if ($Result07 > 0) {
      
                          $sqlSm = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
                          $stmtSm = $ConnectingDB->query($sqlSm);
                          while ($DataRows=$stmtSm->fetch()) {
                          $applicantIdDs                    = $DataRows["id"];
                          $applicantEmailDs          = $DataRows["emailAddress"];
                          $applicantFirstNameDs      = $DataRows["firstName"];
                          }
      
                          if(!empty($applicantIdDs) && !empty($applicantEmailDs) && !empty($applicantUserIdDs) && !empty($applicantFirstNameDs)){

                              $emailTo    = $applicantEmailDs;
                              $subject    = "New Plot Availability Alert";
                              $message    = "Hello ".$applicantFirstNameDs."\n"." There is a new plot available for You."
                                              ."\n"."Log into Your account below."
                                              ."\n\n"."http://allotment-com.stackstaging.com/";
              
                              $headers    = "From: "."Allotment";
              
                              mail($emailTo, $subject, $message, $headers);

                          }
      
                          $sqlE6 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumber' ";
                          $stmtE6 = $ConnectingDB->prepare($sqlE6);
                          $ExecuteE6=$stmtE6->execute();

                          $sql1x = "UPDATE waitinglist SET siteIdNum = '$siteId', siteCity = '$plotSiteRow', plotIdNum = '$id', plotNumberApp = '$plotNumber', applicationStatus ='Pending_Confirmation' WHERE applicationStatus = 'Awaiting_Plot' AND userCity != siteCity ORDER BY id ASC LIMIT 1 ";
                          $stmt1x = $ConnectingDB->prepare($sql1x);
                          $Execute1x=$stmt1x->execute();
      
                      }
      
                          // If there are no users on the waitinglist, then set the plot status to Vacant
      
                          if($Result07 == 0 && !empty($plotNumber)){
      
                              $sql92 = "UPDATE plots SET plotStatus = 'Vacant' WHERE plotNumber ='$plotNumber' ";
                              $stmt92 = $ConnectingDB->prepare($sql92);
                              $Execute92=$stmt92->execute();
                          }
      
              }
                  // Set the tenant's status to a new User
      
                  $sqlUpd = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
                  $stmtUpd = $ConnectingDB->prepare($sqlUpd);
                  $ExecuteUpd=$stmtUpd->execute();
      
              
                  if($ExecuteTrn){
                          //If the tenant's records were successfully transfered to the formertenants table,
                          //then delete the tenant from the tenants tabl and then log the tenant out
      
                      $sqlDel = "DELETE FROM tenants WHERE tenantId='$tenantId' ";
                      $stmtDel = $ConnectingDB->prepare($sqlDel);
                      $ExecuteDel=$stmtDel->execute();
      
                  }

                  echo "Tenant Deleted";
      
            }else{
              echo "No Expired Tenant";
            }
  
  }



 ?>