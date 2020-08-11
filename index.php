<?php $pageTitle = "Allotment";?>

<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>


<?php 

if (isset($_POST["Submit"])) {
  $emailAddress = $_POST["emailAddress"];
  $password = $_POST["password"];

  if (empty($emailAddress)||empty($password)) {
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("index.php");
  }else {
    // code for checking email and password from Database
  
    $Found_Account=userLoginAttempt($emailAddress);
    if ($Found_Account && password_verify($_POST["password"], $Found_Account["password"])) {

        $_SESSION["userId"]=$Found_Account["id"];
        $_SESSION["userFirstName"]=$Found_Account["firstName"];
        $_SESSION["userLastName"]=$Found_Account["lastName"];
        $_SESSION["userEmailAddress"]=$Found_Account["emailAddress"];
        $_SESSION["userTelephone"]=$Found_Account["telephone"];
        $_SESSION["userHomeAddress"]=$Found_Account["homeAddress"];
        $_SESSION["userCity"]=$Found_Account["city"];
        $_SESSION["userGender"]=$Found_Account["gender"];
        $_SESSION["userStatus"]=$Found_Account["userStatus"];
        
        if (isset($_SESSION["TrackingURL"])) {
          Redirect_to($_SESSION["TrackingURL"]);
        }elseif($_SESSION["userStatus"] == "Awaiting_Plot"){
          Redirect_to("confirmOffer.php");
        }elseif($_SESSION["userStatus"] == "Tenant"){
          Redirect_to("tenantProfile.php");
        }elseif($_SESSION["userStatus"] == "Pending_Confirmation"){
          Redirect_to("confirmOffer.php");
        }else{
          Redirect_to("applyForPlots.php");
        }
    
      }else {
        $_SESSION["ErrorMessage"]="Incorrect Email OR Password";
        Redirect_to("index.php");
      }
    
  }
}

?>   


<!DOCTYPE html>
<html lang="en">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-42291951-2"></script> -->
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-42291951-2');
</script>
<script src="assets/js/jquery.min.js"></script>
<!-- <script src="assets/js/map-scripts/ireland-min.js"></script> -->
<script>
    var iejsconfig = {
        "iejs1": {
            "hover": "<b><u>ANTRIM</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Antrim'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Antrim'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Antrim'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Antrim'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs2": {
            "hover": "<b><u>ARMGAH</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Armgah'; TotalNumberPlots($cityName);?> </span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Armgah'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Armgah'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Armgah'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#f1ffc8",
            "overColor": "#d9ff66",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs3": {
            "hover": "<b><u>CARLOW</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Carlow'; TotalNumberPlots($cityName);?> </span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Carlow'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Carlow'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Carlow'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#d7f57a",
            "overColor": "#beef2a",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs4": {
            "hover": "<b><u>CAVAN</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Cavan'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Cavan'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Cavan'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Cavan'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#f1ffc8",
            "overColor": "#d9ff66",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs5": {
            "hover": "<b><u>CLARE</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Clare'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Clare'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Clare'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Clare'; TotalVacantPlotsMp($cityName)?>",
            "url": "#mymodal",
            "target": "modal",
            "upColor": "#edff66",
            "overColor": "#cbe600",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs6": {
            "hover": "<b><u>CORK</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Cork'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Cork'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Cork'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Cork'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#E0E2E2",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs7": {
            "hover": "<b><u>DONEGAL</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Donegal'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Donegal'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Donegal'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Donegal'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs8": {
            "hover": "<b><u>DOWN</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Down'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Down'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Down'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Down'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs9": {
            "hover": "<b><u>DUBLIN</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Dublin'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Dublin'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Dublin'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Dublin'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs10": {
            "hover": "<b><u>FERMANAGH</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Fermanagh'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Fermanagh'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Fermanagh'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Fermanagh'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs11": {
            "hover": "<b><u>GALWAY</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Galway'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Galway'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Galway'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Galway'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs12": {
            "hover": "<b><u>KERRY</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Kerry'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Kerry'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Kerry'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Kerry'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs13": {
            "hover": "<b><u>KILDARE</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Kildare'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Kildare'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Kildare'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Kildare'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#f1ffc8",
            "overColor": "#d9ff66",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs14": {
            "hover": "<b><u>KILKENNY</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Kilkenny'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Kilkenny'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Kilkenny'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Kilkenny'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs15": {
            "hover": "<b><u>LAOIS</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Laois'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Laois'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Laois'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Laois'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs16": {
            "hover": "<b><u>LEITRIM</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Leitrim'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Leitrim'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Leitrim'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Leitrim'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs17": {
            "hover": "<b><u>LIMERICK</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Limerick'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Limerick'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Limerick'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Limerick'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs18": {
            "hover": "<b><u>LONDONBERRY</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Londonberry'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Londonberry'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Londonberry'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Londonberry'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs19": {
            "hover": "<b><u>LONGFORD</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Longford'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Longford'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Longford'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Longford'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#f1ffc8",
            "overColor": "#d9ff66",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs20": {
            "hover": "<b><u>LOUTH</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Louth'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Louth'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Louth'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Louth'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs21": {
            "hover": "<b><u>MAYO</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Mayo'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Mayo'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Mayo'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Mayo'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs22": {
            "hover": "<b><u>MEATH</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Meath'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Meath'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Meath'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Meath'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs23": {
            "hover": "<b><u>MONAGHAN</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Monaghan'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Monaghan'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Monaghan'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Monaghan'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs24": {
            "hover": "<b><u>OFFALY</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Offaly'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Offaly'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Offaly'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Offaly'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#E0E2E2",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs25": {
            "hover": "<b><u>ROSCOMMON</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Roscommon'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Roscommon'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Roscommon'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Roscommon'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#f1ffc8",
            "overColor": "#d9ff66",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs26": {
            "hover": "<b><u>SLIGO</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Sligo'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Sligo'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Sligo'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Sligo'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs27": {
            "hover": "<b><u>TIPPERARY</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Tipperary'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Tipperary'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Tipperary'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Tipperary'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs28": {
            "hover": "<b><u>TYRONE</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Tyrone'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Tyrone'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Tyrone'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Tyrone'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs29": {
            "hover": "<b><u>WATERFORD</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Waterford'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Waterford'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Waterford'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Waterford'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs30": {
            "hover": "<b><u>WESTMEATH</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Westmeath'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Westmeath'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Westmeath'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Westmeath'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs31": {
            "hover": "<b><u>WEXFORD</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Wexford'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Wexford'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Wexford'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Wexford'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#f1ffc8",
            "overColor": "#d9ff66",
            "downColor": "#cae9af",
            "active": !0
        },
        "iejs32": {
            "hover": "<b><u>WICKLOW</u></b><br><span style='color: #bcbcbc;'>Number OF Plots: <?php $cityName='Wicklow'; TotalNumberPlots($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Number Of Users On The Waiting List: <?php $cityName ='Wicklow'; TotalWlNum($cityName);?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Soon To Be Vacant Plots: <?php $cityName ='Wicklow'; TotalSoonVacantPlots($cityName)?></span><br>&nbsp;<br><span style='color: #bcbcbc;'>Vacant Plots: <?php $cityName ='Wicklow'; TotalVacantPlotsMp($cityName)?>",
            "url": "",
            "target": "same_window",
            "upColor": "#FFFFF3",
            "overColor": "#ECFFB3",
            "downColor": "#cae9af",
            "active": !0
        },
        "general": {
            "borderColor": "#9CA8B6",
            "visibleNames": "#adadad",
            "lakesFill": "#C5E8FF",
            "lakesOutline": "#9CA8B6"
        }
    };

    function isTouchEnabled() {
        return (("ontouchstart" in window) || (navigator.MaxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0))
    }
    jQuery(function() {
        jQuery("path[id^=iejs]").each(function(i, e) {
            ieaddEvent(jQuery(e).attr("id"))
        })
    });
    jQuery(function() {
        jQuery('#lakes').find('path').attr({
            'fill': iejsconfig.general.lakesFill
        }).css({
            'stroke': iejsconfig.general.lakesOutline
        })
    });

    function ieaddEvent(id, relationId) {
        var _obj = jQuery("#" + id);
        var arr = id.split("");
        var _Textobj = jQuery("#" + id + "," + "#iejsvn" + arr.slice(4).join(""));
        jQuery("#" + ["visnames"]).attr({
            "fill": iejsconfig.general.visibleNames
        });
        _obj.attr({
            "fill": iejsconfig[id].upColor,
            "stroke": iejsconfig.general.borderColor
        });
        _Textobj.attr({
            "cursor": "default"
        });
        if (iejsconfig[id].active === !0) {
            _Textobj.attr({
                "cursor": "pointer"
            });
            _Textobj.hover(function() {
                jQuery("#jstip").show().html(iejsconfig[id].hover);
                _obj.css({
                    "fill": iejsconfig[id].overColor
                })
            }, function() {
                jQuery("#jstip").hide();
                jQuery("#" + id).css({
                    "fill": iejsconfig[id].upColor
                })
            });
            if (iejsconfig[id].target !== "none") {
                _Textobj.mousedown(function() {
                    jQuery("#" + id).css({
                        "fill": iejsconfig[id].downColor
                    })
                })
            }
            _Textobj.mouseup(function() {
                jQuery("#" + id).css({
                    "fill": iejsconfig[id].overColor
                });
                if (iejsconfig[id].target === "new_window") {
                    window.open(iejsconfig[id].url)
                } else if (iejsconfig[id].target === "same_window") {
                    window.parent.location.href = iejsconfig[id].url
                } else if (iejsconfig[id].target === "modal") {
                    jQuery(iejsconfig[id].url).modal("show")
                }
            });
            _Textobj.mousemove(function(e) {
                var x = e.pageX + 10,
                    y = e.pageY + 15;
                var tipw = jQuery("#jstip").outerWidth(),
                    tiph = jQuery("#jstip").outerHeight(),
                    x = (x + tipw > jQuery(document).scrollLeft() + jQuery(window).width()) ? x - tipw - (20 * 2) : x;
                y = (y + tiph > jQuery(document).scrollTop() + jQuery(window).height()) ? jQuery(document).scrollTop() + jQuery(window).height() - tiph - 10 : y;
                jQuery("#jstip").css({
                    left: x,
                    top: y
                })
            });
            if (isTouchEnabled()) {
                _Textobj.on("touchstart", function(e) {
                    var touch = e.originalEvent.touches[0];
                    var x = touch.pageX + 10,
                        y = touch.pageY + 15;
                    var tipw = jQuery("#jstip").outerWidth(),
                        tiph = jQuery("#jstip").outerHeight(),
                        x = (x + tipw > jQuery(document).scrollLeft() + jQuery(window).width()) ? x - tipw - (20 * 2) : x;
                    y = (y + tiph > jQuery(document).scrollTop() + jQuery(window).height()) ? jQuery(document).scrollTop() + jQuery(window).height() - tiph - 10 : y;
                    jQuery("#" + id).css({
                        "fill": iejsconfig[id].downColor
                    });
                    jQuery("#jstip").show().html(iejsconfig[id].hover);
                    jQuery("#jstip").css({
                        left: x,
                        top: y
                    })
                });
                _Textobj.on("touchend", function() {
                    jQuery("#" + id).css({
                        "fill": iejsconfig[id].upColor
                    });
                    if (iejsconfig[id].target === "new_window") {
                        window.open(iejsconfig[id].url)
                    } else if (iejsconfig[id].target === "same_window") {
                        window.parent.location.href = iejsconfig[id].url
                    } else if (iejsconfig[id].target === "modal") {
                        jQuery(iejsconfig[id].url).modal("show")
                    }
                })
            }
        }
    }
   

    function isTouchEnabled() {
        return (("ontouchstart" in window) || (navigator.MaxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0))
    }
    jQuery(function() {
        var pins_len = pins_config.pins.length;
        if (pins_len > 0) {
            var xmlns = "http://www.w3.org/2000/svg";
            var tsvg_obj = document.getElementById("iejspins");
            var svg_circle, svg_rect;
            for (var i = 0; i < pins_len; i++) {
                if (pins_config.pins[i].shape === "circle") {
                    svg_circle = document.createElementNS(xmlns, "circle");
                    svg_circle.setAttributeNS(null, "cx", pins_config.pins[i].pos_X + 1);
                    svg_circle.setAttributeNS(null, "cy", pins_config.pins[i].pos_Y + 1);
                    svg_circle.setAttributeNS(null, "r", pins_config.pins[i].size / 2);
                    svg_circle.setAttributeNS(null, "fill", "rgba(0, 0, 0, 0.5)");
                    tsvg_obj.appendChild(svg_circle);
                    svg_circle = document.createElementNS(xmlns, "circle");
                    svg_circle.setAttributeNS(null, "cx", pins_config.pins[i].pos_X);
                    svg_circle.setAttributeNS(null, "cy", pins_config.pins[i].pos_Y);
                    svg_circle.setAttributeNS(null, "r", pins_config.pins[i].size / 2);
                    svg_circle.setAttributeNS(null, "fill", pins_config.pins[i].upColor);
                    svg_circle.setAttributeNS(null, "stroke", pins_config.pins[i].outline);
                    svg_circle.setAttributeNS(null, "stroke-width", 1);
                    svg_circle.setAttributeNS(null, "id", "iejspins_" + i);
                    tsvg_obj.appendChild(svg_circle);
                    iejsAddEvent(i)
                } else if (pins_config.pins[i].shape === "square") {
                    svg_rect = document.createElementNS(xmlns, "rect");
                    svg_rect.setAttributeNS(null, "x", pins_config.pins[i].pos_X - pins_config.pins[i].size / 2 + 1);
                    svg_rect.setAttributeNS(null, "y", pins_config.pins[i].pos_Y - pins_config.pins[i].size / 2 + 1);
                    svg_rect.setAttributeNS(null, "width", pins_config.pins[i].size);
                    svg_rect.setAttributeNS(null, "height", pins_config.pins[i].size);
                    svg_rect.setAttributeNS(null, "fill", "rgba(0, 0, 0, 0.5)");
                    tsvg_obj.appendChild(svg_rect);
                    svg_rect = document.createElementNS(xmlns, "rect");
                    svg_rect.setAttributeNS(null, "x", pins_config.pins[i].pos_X - pins_config.pins[i].size / 2);
                    svg_rect.setAttributeNS(null, "y", pins_config.pins[i].pos_Y - pins_config.pins[i].size / 2);
                    svg_rect.setAttributeNS(null, "width", pins_config.pins[i].size);
                    svg_rect.setAttributeNS(null, "height", pins_config.pins[i].size);
                    svg_rect.setAttributeNS(null, "fill", pins_config.pins[i].upColor);
                    svg_rect.setAttributeNS(null, "stroke", pins_config.pins[i].outline);
                    svg_rect.setAttributeNS(null, "stroke-width", 1);
                    svg_rect.setAttributeNS(null, "id", "iejspins_" + i);
                    tsvg_obj.appendChild(svg_rect);
                    iejsAddEvent(i)
                }
            }
        }
    });

    function iejsAddEvent(id) {
        var obj = jQuery("#iejspins_" + id);
        if (pins_config.pins[id].active === !0) {
            obj.attr({
                "cursor": "pointer"
            });
            obj.hover(function() {
                jQuery("#jstip").show().html(pins_config.pins[id].hover);
                obj.css({
                    "fill": pins_config.pins[id].overColor
                })
            }, function() {
                jQuery("#jstip").hide();
                obj.css({
                    "fill": pins_config.pins[id].upColor
                })
            });
            obj.mouseup(function() {
                obj.css({
                    "fill": pins_config.pins[id].overColor
                });
                if (pins_config.pins[id].target === "new_window") {
                    window.open(pins_config.pins[id].url)
                } else if (pins_config.pins[id].target === "same_window") {
                    window.parent.location.href = pins_config.pins[id].url
                } else if (pins_config.pins[id].target === "modal") {
                    jQuery(pins_config.pins[id].url).modal("show")
                }
            });
            obj.mousemove(function(e) {
                var x = e.pageX + 10,
                    y = e.pageY + 15;
                var tipw = jQuery("#jstip").outerWidth(),
                    tiph = jQuery("#jstip").outerHeight(),
                    x = (x + tipw > jQuery(document).scrollLeft() + jQuery(window).width()) ? x - tipw - (20 * 2) : x;
                y = (y + tiph > jQuery(document).scrollTop() + jQuery(window).height()) ? jQuery(document).scrollTop() + jQuery(window).height() - tiph - 10 : y;
                jQuery("#jstip").css({
                    left: x,
                    top: y
                })
            });
            if (isTouchEnabled()) {
                obj.on("touchstart", function(e) {
                    var touch = e.originalEvent.touches[0];
                    var x = touch.pageX + 10,
                        y = touch.pageY + 15;
                    var tipw = jQuery("#jstip").outerWidth(),
                        tiph = jQuery("#jstip").outerHeight(),
                        x = (x + tipw > jQuery(document).scrollLeft() + jQuery(window).width()) ? x - tipw - (20 * 2) : x;
                    y = (y + tiph > jQuery(document).scrollTop() + jQuery(window).height()) ? jQuery(document).scrollTop() + jQuery(window).height() - tiph - 10 : y;
                    jQuery("#jstip").show().html(pins_config.pins[id].hover);
                    jQuery("#jstip").css({
                        left: x,
                        top: y
                    })
                });
                obj.on("touchend", function() {
                    jQuery("#" + id).css({
                        "fill": pins_config.pins[id].upColor
                    });
                    if (pins_config.pins[id].target === "new_window") {
                        window.open(pins_config.pins[id].url)
                    } else if (pins_config.pins[id].target === "same_window") {
                        window.parent.location.href = pins_config.pins[id].url
                    } else if (pins_config.pins[id].target === "modal") {
                        jQuery(pins_config.pins[id].url).modal("show")
                    }
                })
            }
        }
    }
</script>
<script src="assets/js/bootstrap.min.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="canonical" href="interactive-map-of-ireland.html" /> -->
  
  <title>Allotment</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/custom.min.css" rel="stylesheet">
</head>

<body>
<div id="top-line"></div><!--end top-line-->

<!-- Navbar Here -->
<!-- Navbar Here -->
<!-- Navbar Here -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Allotment</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
            <a class="nav-link bg-dark text-light" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link bg-dark text-light" href="contact.php">Contact Us</a>
        </li>
        <?php if(isset($_SESSION["userId"])) {?>
            <li class="nav-item">
                <a class="nav-link bg-dark text-light" href="userLogout.php">Log Out</a>
            </li>
        <?php }?>

        </ul>
    </div>
</nav>

<div class="demo text-left bg-light">
  <div class="container">
    <h1 class="mt-3 mb-3 text-center"></h1>
                <?php
                  echo WarningMessage();
                  echo ErrorMessageForRg();
                  ?>
    <!-- Main Page Row -->
    <div class="row mt-5">
      <div class="col-md-8 prev-right taller">
        <div id="mapwrapper">
          <div id="map_base">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 760" xml:space="preserve">
                <g>
                <path id="iejs1" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M446.75,54.5c-1-6.5-3-4.75-4.125-10.125c0.375-0.625,6.625,1.375,7.625-1.25s7.625-1,7.375-1.875s2.5-6.875,4.5-4.875s4.5,0.75,6.125,2.5s2.875,2.25,4.25,0.125s3.25-3.5,5.125-1.5s5.5,1.625,6.625,3.5s2.5,2,3.75,1.125s8.625-4.125,10.25-1.375s3.625,0.875,5.625,3.75s4.75,2.5,5,4.75s4.375,4.875,1.875,8.375s0.454,5.468-0.791,7.979c-2.197,4.433-2.229,8.031,2.104,7.031s7.301,0.016,5.635,5.849s-3.016,8.507,2.484,10.174s5.659,5.671,6.326,8.671s5.329,5.835,6.829,9.502s7.665,2.334,10.665,7.501s4.832,9.834,3.499,10.334s0.332,6.167-1.168,8.167s-5,5.167-7.5,5.167s-2.833,2.834-5.833,3.667s-5.333,4.833-7.5,7.333s-2.333,4.5,1.667,4.833c-4.082,8.333,3.082,12.167-2.668,16.667c-2.371,1.855-1.75-2.5-7-1.75s-2,6.5-5,5.836s-5.25,7.914-11.75,9.527S495.5,181,487,181c-3.26,0-4.25-3.5-5.75-3.5s-2.809-2.619-6.5-2.914s-0.5-9.336-2.75-9.336s-4.75-6.5-3.364-9c0.588-1.06,0.062-1.716-1.017-2.463c0.486-0.809,0.88-1.581,1.017-2.287c0.207-1.064,2.947-2.996,1.393-5.268c-2.332-3.409-10.278-0.982-9.028-10.732c0.671-5.231-1.75-10-1.68-12s-0.82-5.5-0.07-9.25s-4.75-9-4-12.403s-6-8.347-4.493-11.347s-2.507-4.75-2.927-8.25s2.92-11.5,0-13s0.42-3.5,2.42-6S447.75,61,446.75,54.5z M484.313,27.375c3.688,0.375,4.188-1.25,5.875-0.688c1.246,0.416,4.25-0.5,3,1.063s-2.25,4.938-0.75,5.5s2.813-1.666,2.375-3.333s1.188-2.479,0.813-4.792s-3.375-0.625-5.438-1.813s-3.5-1-4.375,0S480.625,27,484.313,27.375z"/>
                <path id="iejs2" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M482.166,251.5c-2.167-0.667-1.5-7.833-4.182-9.167s2.682-8.833,0-12.5s0.349-5-1.151-7.333s0.667-5,3-7s4.667-6.167-1.849-7s-4.151-3.5-7.48-5.667S469.5,196,475.166,197s0.167-4,2.167-4.333s0.667-3.333,5.167-4.5s-0.667-3.833,4.5-7.167c-3.26,0-4.25-3.5-5.75-3.5s-2.809-2.619-6.5-2.914s-0.5-9.336-2.75-9.336s-4.75-6.5-3.364-9c0.588-1.06,0.062-1.716-1.017-2.463c-1.346,2.238-3.42,4.759-2.869,6.963c0.75,3-2,11-5,11.5s-6,3.75-9,6.5s-8.082,2.476-7.416,5.363S443.5,195,439,195.5s-4.495,1.942-7.25,1.75c-10.75-0.75-2,13-10.75,14c1,4.5,3.25,5.75,2,9.75s4.75,6,5,12.25s5.5,12.75,9.75,8.75s8.75-1.75,8.5,1s1.383,4.551,0.01,12.75c-2.01,12,7.49,12.75,8.49,16.5c3.75-7,6.285-2.956,10.5-3.5c7.75-1,3.25-4.5,7.75-5.5s4.144-5.127,13.35-2.608c-0.237-0.786-0.088-1.681,0.651-2.642C483.502,256.167,484.333,252.167,482.166,251.5z"/>
                <path id="iejs3" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M432.308,488.667c-2.692-1-5.141,4.834-7.308,3.501s-1.833,1.499-6.833,0c1,3-1.001,1.167-1.667,5s-1.667-0.167-4,3.333s-8.499,3.167-9.166,7s-2.501,5.166-2.334,8.166s-4.001,3.165-2.167,6.166s11,2.667,10.5,7.834s0.811,4.256,0,6.5c-2.166,6,7.834,4.834,7.834,9.167s5.832,2.833,4.166,7S412,561.335,420,566.668c2-1.834,7.333-2.333,8.5-7.167s6.334-2.001,8.167-5.334s-2-4.499-1-6.666s-0.334-5.167,3.166-10.667s10.833,1.501,14-3.333s-4-1.834-2.5-5.167s4.333-1.335,6-6.501c-5-6.666,2.167-6.833-2.833-9.333s-5.999-5.501-2.333-8.167s10.666,0,12.333-4s0.333-9.666,1.5-12.333s0.001-5.334-2.333-3.167s-4.334,3.5-6.334,1.667s-6.833-0.424-8.666-2.462S439.166,485,437.5,481.5C433.833,482.666,435,489.667,432.308,488.667z"/>
                <path id="iejs4" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M434.667,293.167c-4.5-5.167-12.167-5-12.5-10.5s-4.167-5.833-7-8.5s-4.667-3-4.667-5.167s-8.187-2.985-8-5.5c0.667-9-4.833-4.333-7.333-5.5S387,261.012,383,259.839S372.666,262,374,258s-1-3.833,0.834-6.167c1.833-2.333-1.168-3.833-1.834-6.083c-4,1-12.25,10-14,6.5s-2.25,2.5-4.5,0s-6.75,8-8.25-3.5c-0.824-6.32-14.75,0.75-14.75-9.25c0-4.75-9-0.75-11-2.25s-7.75,0.5-8.5-6s-9-5-11.25-10c0.083,3.75-3.917,3.25-4.583,5.75s-4.833,0-3.333,4.667s-4.813,7.5-0.323,12s5.49,1,6.99,2.083s4.5-3.583,5.5,1.25s6.666,5.5,7.666,7.667s10.333,1.833,10,5c-0.332,3.167,7.334,4.667,7.334,8.5s2.5,0.833,2.334,3c-0.168,2.167,5.994,3.861,4.832,7.167c-2.166,6.167,2,4.833,0,11.167c7.334,0,3.833,3.833,6,4.5c2.168,0.667,4.5,6.562,6.334,6.198s5.225,8.321,7.834,10.698c6.332,5.771-1.153,6.938,3.756,11.354c1.591-2.25,3.41-1.5,4.91-4.25s4.5-1,7-2.75s7,4,14.25-1c4.787-3.302,10.25,4.25,13,1.5s10.5,3.5,13.25,0s-2.5-6-1-7.25s-2.5-2.5,1-6.236s-1.5-4.014,2.5-5.014s2,3,8,4.75c5.816,1.696,9.054-5.282,13.801-6.395C436.694,295.024,435.617,294.258,434.667,293.167z"/>
                <path id="iejs5" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M221.25,527.5c1.75,2,1.875-2.5,4.875,0s4.375-1,7.375-1.875s3.125-6.125,5.5-7.25s1.912-4.709,3.831-5.542c-2.498-3.166,6.634-12.11,5.169-14.666s2.333-7.282,3-9.225s0.5-4.442,2.333-6.942s8.833-2.499,9.167-6.833c0.137-1.779-0.173-3.672-0.368-5.445c-1.618-0.778-3.757,1.778-6.132-0.472c-0.812-0.769-3.25,2.625-4.5-0.125s-9.5,2.75-11.125-3.125s-6.375-0.875-7.875-3.875s-1.625-0.625-6.125-1.5s-6.5,7.75-11,5.25s-8.375,5.125-11.25,3.75s-3.125,4.75-7.5,2.25s0.125-11.125-2.625-12.25s0.25-6.375-4.75-8.25s-4.625-5.875-7.25-8.125s2.75-5.125,0-8.75c-5.75,0.25-5.25,5.5-8.75,7.375S169,439,166,438.5s-2-3.625-5.625-3.75s-4.125,9.125-4.75,11.625s-7.125,4.625-6.25,8.25s-5.5,4-4.375,7.875s-2.875,2.5-2.625,6.25s-6.25,7.625-6.125,9.125s3.75-1.375,6.25,0.375s3.375-1.75,6.125-2.25s2.25,4.125-1.375,5.75s-1.125,2.25-4,4.125s0,3.125-2.5,5.125s1.875,6.75-4,9.375s4.625,8.625-3.25,12.25s-2.5-2.5-7.375-1.625c-8.443,1.516-2.375,6.125-6.125,6.5s-1.375,4.25-6.125,6.25s-1.375,7.125-8.5,9.25s-4.625,6.5-9.75,7.125s-2.125,1.75-6.75,3.875s-1.375,1.5,2.25,2.875s1.75-4.25,7.75-1.625c2.259,0.988,7.375-1.5,7.5-2.625s3-2.125,4.25-0.125s2.5-1,1.125-3.25s5-3,8.375-3s4.25-2.375,6.5-2.625s1.5-4-0.875-5.5s3.75-1.5,3.75,1.375s1.375,2.25,3.875,3.5s3.125,2.125,7.25,4.625s4.625-1,7.875-0.5s2.25-3.875,4-3.25s3.75-2.25,5.5-1s-4.25,3.75-6.25,5.875s3.25,2.375,6.125,1.25s0-6,7.5-4.625c4.087,0.749,6.125-0.25,6.875-2.875s4.375-3,4.875-5.875s5.5-1.375,4.5-5.875s5.5,0.75,2.75-8.25c-1.214-3.974,5.125-3.25,5.625-2s2.375,0.125,4.375,3.5s0.25,4-2.375,6.625s-0.625,2.375,1.75,3.125s9.75-3.5,11.75-1.375s3.25-0.25,5.375,1.625s4.25,0.125,4.25,1.625C217.5,526.875,219.5,525.5,221.25,527.5z"/>
                <path id="iejs6" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M312.75,660.596c-1.125,1.779-1.875,6.029-4.25,4.904s-4.875,1-2.125,2s6.875,2.625,3.25,3.625s-12.65,1.977-14.5,4c-4,4.375,3.375,4.625,0.625,6s-4,3.25-7.5,2.25s-4.375,2.25-7.625,2s-7.75,3.125-10.25,2.625s-4.25-2.375-2.375-4.375s3.375-1.75,3-3s3.875-1.25,4.375-3.5s-2-1-5.875-1.5s-2.25,3.75-4.75,4.125s1.125,3.5,0,3.75s1.25,3.102,0.125,4.551s2.991,4.241-0.375,6.824c-5.375,4.125-1.875,6.375-5.375,5.875s-3.25,2.25-6.25,2.125s-0.75,4.125-4.875,3.75s-3.75-0.25-4.75-1.625s-2.375-1.875-2.375,0.375s-4.5,6-3.5,8.125s-0.25,5.25-1.625,2.25s-4.5,1-7.25-0.375s-7.125-0.521-5.375,1.614s-4.5,2.886-2.625,5.386s-1.5,5.75-4.75,2.75s-5.75-0.5-6.75-2.5s-2.5-0.375-3.875-1.125S202,721.75,203,723s-0.125,2.908-1.5,3.329s-1.25,8.421-5.625,6.671s-3.875-4.75-8.625-5.125s-6.75,4.75-9,3s-3.5,0.375-2.75,1s-1.125,4-4.125,3.125s-2.625,3.5-4.875,3.25s-1.25,4.5-3.625,3.5s-3.5-3.5-6.375-2.375s0,2.152-1.25,2.514s-6.25,3.986-7.5,3.236s-0.125-3.75-2.25-1.625s-0.75,2.625-2.75,4.125S140,746.75,141,745s3.625-1.75,2.875-4.875S141,740.75,141.25,738.5s2-3,1-4.125s2.75-2.875,0.125-3.75s-2.375,5.375-4.5,4.75s-3.75,3.5-6.125,1.625s-2,3.5-4.75,2.125s-3,2-5.375,0.75s-2.5-5.25-4.125-3.875s0,2.75-2.125,3.25s-4,0.5-4,2.25s0.875,3-1.25,4s-3.25-0.75-3.875,0.75s-1.625,1.625-2.375-0.375s-0.875,4.451-3.75,2.226s0.875-3.351,0-4.601s-1.5-2,1.5-3.25s3.375-5.125,6.75-4.75s5.625-4.125,7.875-4.125s1.625-4,3.875-3.875s-0.5-1.625,3-2.5s-0.875-4,4.25-3.75s3.125-1.75,0.25-1.875s-5.375,3.125-8,2.625s-0.375,2.875-2.75,2.5s-5.375,3.875-9.375,4.5s-7.375,3.75-10,2.375s3.875-1.5,4.875-4.5s6-3.5,8-5.75s10-3.75,11.5-6.125s4.5-1.25,6.25-3.25s5.375-1.875,6.125-3.375s5.375-0.375,5.5-4.5s-1.625-2.875-4-3.625s-4.625-1.125-4.875-3s-4.375-1.75-3,0s1.5,5.625-1.5,5.25s-6.625,6.75-9.375,5.625s-5.5,0.25-6.375-1.375s-2.25,3.125-3.75,3.375s-6,2.375-8.375,1.5s-2,0.25-4-0.125s-1.5,1.125-3.375,0.75s-3,2.25,0,2.375s5.875,0.5,7-0.25s4.5-0.375,1.875,1.75s-4.125,0.5-6.125,1.625s-3.704,2-4.602,0.75s-1.898-3.5-2.398-2S84.5,719.875,82,719.375S80.875,722,76.875,722s-1.875-1.875-5.75-1.125s-3.375-1.125-5.75,1s-1-1.75-3.25-1s-5,3.375-6.375,2.75s1.009-3.369,3.25-2.875s0.75-2.625,3.875-2.625s4,1.5,5.5-0.125s-2.125-1.75-0.375-3s3.875,0.5,5-1s-7.875-3.75-4.25-5.75s5.125,2.125,6.625,0s2.375,1.75,3.5-0.125s5.25-0.25,5.75-3.5S77.5,700,81,698.375s7.5-3.125,9.125-5.375s1.375,3,3.875,1.25c-1,3.75,2,4.25,0,6.083s-3,6.834,2,5.667s4.334-6.576,8.667-5.788s-0.833-5.712,3.167-4.212s9.5-2.5,13.333-1.75s2.166-3.584,4.333-2.584s3.667-9,8.833-7.833s6.333-2.5,8.667-2s3.667,0.334,2.667-3.333s1.339-8.668,0.336-11.334s8.497-2.833,8.831-6.333s5.333,0.334,4.667-5.333s-7-0.666-5.167-5s5.667-2.5,2.667-8s-1.5-6.667-2.167-12.167s-2.833-5.333-3-7.833S143,620.334,145.5,614s6.167-2.5,6.833-6.167s5.667-4.001,2.333-8.667c5.167-2.166,3.333-7,8.167-6.833s2.5,3.828,8.167,3.414s3.333-2.746,8.5-2.08s-0.167,4.834,6.833,4.5s11.667-2.176,10.333-5.838s-3.04-5.429,1.167-4.828c10.5,1.499,1.5-6.667,7.667-3.834s10.834,0.002,12.667,3.834s7.833,0.832,7.167,5.832s4.5,0.166,5,5.833s6,2.834,9.167,4.834s8.167-4,11.833-3s2.666-5.501,6.333-2.834s8.167,0,11.167,2.167s5-0.834,7.833,0.333s-2.833,6.666-0.833,8.5s-1.379,6.168,1.644,6.834s4.023-0.167,6.69,1.333c-1.167,2-2.333,2.5-3.667,5s-2-0.166-2,5.5s7.667,7.834,10.167,11.5s8,1.5,8.167,4.667s2.5,1.833,2.5,4.833s2.333,2,4.665,7S310.334,657.167,312.75,660.596z M137.063,747.875c-0.448-0.239-1.563-0.25-1.625,0.699s-0.813,0.676-4.063,1.957s-1.188,2.656,1.688,2.656s2.5-2.438,3.688-2.75S138.199,748.482,137.063,747.875z"/>
                <path id="iejs7" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M273,190.833c9.25,2.167,5-3.083,9.5-2.333s3.75-3.25,7.5-3.375s3.75-2.625,4.25-5.125s-0.749-4.078,3.75-5.414s5-5.336,7-2.336s6.75,0.25,10.25,0.5s2.25-3.5,3.5-3.75s1.75-7,5-6.75s3.75-0.75,3.75-2s3.75-4.75,0-6.25s-3.25,2.5-6.25,1.75s1,6.5-2.75,6.25s-3-4.25-6.75-4.5s-8.607-4.064-4-7.75c2.5-2-2.25-3.75,2.25-5.5s-1-7.75,5-6.75s9-2,12,1.25s10,0.38,10-1.56s1.75-5.69,3.5-3.19s5,2.087,5-0.832s-2.75-14.168,3.25-13.918s0-6.75,4-8.25s3-4.75,6.75-7.5s-2-3.75,0-5.75s-5-1-2.75-7s-1-4.5,1.5-8.25s1.75-1.25,7.25-4.5s9,1.5,10.5,0s-0.063-2.563,2.969-5.906c-0.5-0.625-0.656-1.406-0.719-2.094c-0.125-1.375,3.25-6.25,5.625-8.875s8.5-8.875,11.875-10s3-4,7.625-4.625s7.5-4.125,9.5-6.25s-1.25-5.375-5-6.125s-8.625-4.125-11.625-4.5s-3.5-2.25-5.125-2.5s-3.375-3.625-3.875-6.5s-0.5-3.5-3.25-3.5s-2.75-2.25-5-2.25s-5.75-3.5-8-3s-6-4.75-8-2.375s1.625,3.75,3.125,3.75s1.625,2.625,1.25,5s2.375,1.5,2.125,3.25s4.875,4,7.75,5.375s-1.25,2.875-4.5,3s-3.875-2.5-1.375-2.125s0.5-2.5-1.875-4s-2.125-2.25-4-1s0.875,3.25-1.25,4.25s-2.375-1.072-4.625,1.5c-1.406,1.608-2-1.75-4.5-2.5s3.125,4.625-2.5,2.625s0.125,3.25-3.75,5.25s-0.5,2.125,1,2.625s-0.125,1.875-3.25,4.5s4.5,11.25,6.75,14.375s1.25,6.125-0.5,8.625s2.625,4,3,5.875s2.25,4.625,1.125,5s-1.625-1.125-1.125-1.25s-1.875-1.75-2.125-3.375s-3.125-2.875-4.875-2.375s-1.625,4.125,0,4.875s2.625,1.5,4.5,1.625s0,2-2.5,1.625s-1.375,3.625-3.25,3.5s0,2-4.75,3.375S341,86.5,338.625,88.75s-4.25-0.375-3.125-0.625s2.25-4.125,3.375-4.625s0.75-2.875,2.875-3.875s3-3.5,2.625-5.25s-5.625,0-6.625-0.625s1.125-1.125,2.75-2s-1.625-1.25,0.375-3.875s5.5-1.5,7.125-2.25s-1-3.375,1.25-5.25s-3.125-8.25-5.625-9.375s-0.25-3.875-2.375-3.875s-3.625-4.125-1.625-6.5s-2.125-1.5-1.75-5.125s1-5.25-2.25-5.875s-2,2.375-3.625,2.25S331.125,36.5,326.375,35s-0.5,5-5.625,4.875s0.25-2.875-1.125-3.75s-2.25,0.375-2.5,3.121s-1.75,1.379-4.25,0.254s-2.75,1.625-2,5.5s2.75,2.375,4.625,2.375s0.375,5.875-1,5.875s-2.5,5.125-5,4s1-2.25,1.875-3.375S311.125,51,309.125,51s0.25-3.75-1.625-4s-2.125,1.625-5.619,0.875c-3.493-0.75,2.494-5.625,0.869-5.625s-1.125-1.625-3.75-2.125s1.5,1.875-3.125,2.75s-0.125,8.875-3.625,8s-4.125,2.25-7.375,2.125s0.625,4.875-3.5,5.5s0-4.875-6.25-3.25c-2.113,0.549-4.75-1-9-1s0.125,5.875-1.625,6.875s0.125,4-2,5.875s-0.25,5,0.5,6s-0.125,3.875-1.25,5.75s-1.75,0.75-1.375-1.25s-1,0-4.875-0.5s-2,8-4.75,6.25s-3.25,1.625-2.625,3.125s-1.125,1-4.625,0.375s2-2.625-4-4.25c-1.793-0.486-2.75,0.375-2.75,2.5s-1,2.875-0.25,5.25s6.25,1.125,8,2.375s3.625,0.5,4.875-0.375s7.875,1.375,7.25,2.375s-3.75,1.5-6,1.75s-2.792,6.458-0.292,6.458s0.833,1.667,4,3.333s2-2.333,3-4.167s3,1.833,4.167,4.167s-0.5,2.667-1.167,2.5s-5.667-1.167-5.333,2s-4.5,2.5-5.167,3.5s-5.167,0.667-6.333,2s-6.5-1-6.667,0.833s4.333,2.167,4.667,4.167s3.667,1.5,2.167,3.5s-2.667,0.5-5.5,1s3.167,2.667,1.167,3.5S232,127,226.5,127.833s-5.167,6.167-8,6.167s-1.75,8.375-5.625,8.375s-2.875,1.375-1.375,2s2.125,1.375-0.25,4s5,4.5,9.875,5s0.25,1.5,1.875,4.125s2.875,1.25,5-1.5s2,0.75,4.25,3.375s3.875-2,4.75-1.25s2.75-0.125,6.375-2.25s0.375,1.375,0.75,4.5s3.25,0,3.625-1.75s2.125-3.375,3.25-1.75s2.75-1.375,4,0.375s-1.25,3.375-1.875,4.875s-4.25,1-5.125,3.375s1,1.75,1.5,0.25s3.75-1.25,4.625-2.875s3.5-2.125,4.375-4.5s1.125-2.375,4.75-4.5s3.5,1.625,1.75,2.625s1,1.375-1.125,4.125s4,1.125,6-0.625s4.75-3.375,6.5-5.5s0.875,2.125,4.75-0.75s3.625,4,2.5,6s-1.625-0.5-4-0.125s-1.875,6-5.5,6.5s3.25,6.125-3.5,7.625c-2.628,0.584-3.375,2.5-1.375,5.125s-0.625,3.125-3.375,6.25C270,187.75,272,186.665,273,190.833z"/>
                <path id="iejs8" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M573.001,179.667c0.333-2.5-3-3-2-7.667s-5.167-10.667-4.667-14.833s-1.833-5.167-5.5-9s-5.833,2.833-8.833,0.667s-6.167,1.333-9-1s-5.167,2.667-9.667,6s-2.166,0.333-6.166,0c-4.082,8.333,3.082,12.167-2.668,16.667c-2.371,1.855-1.75-2.5-7-1.75s-2,6.5-5,5.836s-5.25,7.914-11.75,9.527S495.5,181,487,181c-5.167,3.333,0,6-4.5,7.167s-3.167,4.167-5.167,4.5s3.499,5.333-2.167,4.333s-7.991,3.667-4.662,5.833s0.965,4.833,7.48,5.667s4.182,5,1.849,7s-4.5,4.667-3,7s-1.53,3.667,1.151,7.333s-2.682,11.167,0,12.5s2.015,8.5,4.182,9.167s1.336,4.667,4.835,6.5c1.667-2.167,7,1.333,7.666,3.667s3.5,3.167,6.167,3s6.833,1.333,3.833,2.333s-3.333,1.167,1.5,4s6.834-1.167,7.167-3.333s5.833-4.333,6.167-6s8-4,6.667-8.5s4.666-7.833,1.5-15.333c-1.541-3.649,5.666-5.5,4.333-7.668s2-2.832,1.833-1.832s2,1,4,1s9.834-0.833,12.667,0.5s3.167-1.833,5.333-1s6.5-8,7.167-9.833s1.833-2,1.167-3.333s-0.5-4-0.5-7s-2.167-1.167-3-4.333s-6.167,2.333-9.167,1.667s0-2.833,1.667-5.667s-0.167-4.667,1.833-8.333s-3.667-6.5-2.833-8.333s-3.167-3.167-1.667-4.5s-0.5-4-3.333-5.167s1.333-3.333,0.666-5.5s0.5-5.333,1.334-2.833s1.166,1.667,3.166,3.333s5.667,2.167,6,4.5s5,2.333,4.5,6s2.667,6.333,1.5,7.667s0.334,6.333-2.333,6.667s-2.833,7-1,7.667s5,6.333,4,9s0,4,2.833,1.333s0.5-6.333,3.334-8.5s-1.834-7.167,0.666-9.167s1.5-2.667,3.667-7.167S572.668,182.167,573.001,179.667z"/>
                <path id="iejs9" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M485.667,355.5c-3.333-2-0.333-1-4.833-1.667s-2.668,4.666-5.834,3.833s-4,3.667,0,5.167s2.834,4.834,5.334,5.167s-0.028,5.332,1.402,7.166s-2.902,7.168-3.069,7.834s-4.333,2.999-5,5.666s-2.333,1.666-2.5,3.5s0.333,8.834-2.5,8.834s-2.5,5.167-5,5.5s-1.333,4.5-1.833,5.333s2.833,5.833,1.833,7s0.667,3.001,4.167,3.667s8.5-1.167,9.833,1.833s5.333,1.166,6,3.833s3.334,1.334,3.667-0.833s3.168-3.666,3.834-1.833s4.499,0.299,4.999,4.149s1.997-5.257,3.667-3.483s4,4.667,6.5,6.667c1-3.167-4-6-3.833-9.667s-2-4.666,0.5-7.666s-1.5-3.334-3-5s-3-3-6.167-3.5s-3.333-1.667-3.333-4s3.167,0.666,2.667-2.667s1.833-0.833,3.5-2.833s3.166-4.334,4.166-5s-1-4.167-0.166-6.667s0.166-4-4.167-5.166s-1.333-4.834,2.833-3.167s0-1.167,3-2.667s2.5-2.833-2.166-3.833s0.666-1.833,2.5-2s3-4.333,3.5-7.5s-5-4.333-4.834-5.667s-6.5-4.166-6.5-5.5s-3.666-3.166-3.666-5c-1.834,3.5-1,2.667-1.834,6.5S489,357.5,485.667,355.5z"/>
                <path id="iejs10" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M312,231.25c0.75,6.5,6.5,4.5,8.5,6s11-2.5,11,2.25c0,10,13.926,2.93,14.75,9.25c1.5,11.5,6,1,8.25,3.5s2.75-3.5,4.5,0s10-5.5,14-6.5s2.5-5.75,5.75-7s-2.25-5.25,4.25-5.5s3.25-4,2.75-7.5s-4.493-11.75,1.253-13.25c-4.33-3-10.836,0-11.003-3.167s-5.166-3.667-5.5-7s-7-4.667-8.666-8c-1.667-3.333-3.834,2.667-5.5-0.167c-1.667-2.833-7.167,3.833-11.167,0s-4.333,3.5-8,1.5s2.833-4.667-1.279-7s2.279-7.5,5.446-7.667c3.166-0.167-0.5-6.667,1.833-7.833s-0.333-3.667-4.5-3.667s-3-5-5.833-5.167c-2.834-0.167-0.5-3.5-5.334-4.083c0,1.25-0.5,2.25-3.75,2s-3.75,6.5-5,6.75s0,4-3.5,3.75s-8.25,2.5-10.25-0.5s-2.5,1-7,2.336s-3.25,2.914-3.75,5.414s-0.5,5-4.25,5.125s-3,4.125-7.5,3.375s-0.25,4.5-9.5,2.333c1,4.167,9.25,6.667,9.5,12.167s8,5.5,9,10.25s7,3,9.25,8S311.25,224.75,312,231.25z"/>
                <path id="iejs11" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M182,434.5c5.75-0.25,5.625,1,9.25,1.5s5,1.625,3.125-1.5s-2.375-2,0.375-4.125s6.625-8.5,1-5s-3.375,2-5.375,0s-2.5-3.75,1.25-4.5s-1.875-1.75,1.25-3.625s1.25-4-1.875-3s-1,3.75-4.875,1.625s-4.875,2.625-9,1.5s-7.125,3.25-11.375,2s-4.375,1.875-9.625,0.25S153,421,150.25,420.375s-1.875,2.125-5.375,1.75s-13,1.75-15,0.5s-3.5-5-2.5-8.25s-3.375-0.875-2.625,1.5s0.375,4.875-1.5,5.375s-2.25,1.5-2.875-0.5s-2.75-3.375-2.375-1.5s-0.375,4.625-2.875,4s-3.875-0.125-4.375-1.75s-0.5-1-1.125,0.375s-2.375,2.375-3.5-0.125s-0.5-5.75,1.25-5.125s1.75,2.875,3,1.5s-0.375-2.125,1.75-3.5s3.625-0.375,1.875-2s-3.875-3.5-1.5-4.625s3.5-1.5,4.25,0.5s-0.875,2.125-0.125,4.375s1.75,2.75,1.75,3.375s0,2,1.75,0.125s5-4.75,3-6.875s-2.5-2-2-4s-4.125-0.375-3.5-3.125s-2.25-2,0.625-4.5s3.25-3.25,1.125-4.375s-2.875,0.125-2.75,2s-3.5,0.5-3.125,2.125s-2,0.25-1.75,2.75s-2.375,1.5-2.375,4.25s-2.75,1.625-3.375,3.875s-6.125,0.125-6.5-2.5s-2.75-1.26-2.375,1.12s0,4.005-1.875,1.755s-1.75-3.375-3.25-3.75s-3-2.125-0.25-3.25s-3.25-6.25,1.25-5.625s3.75-2.875,5.125-1.5s0.625-3.125,3.375-3s-0.375-4-2-4s-2.5-0.188-2.75,1.563s-2.125-0.813-2.125,0.188s-2.625-2-2.625,0s0.75,3.75-0.875,3.25s-2.625-2.625-3.25-0.125s-3.625,0.25-5.5,1.5s-7.625,0.75-6.875-2.25s-1.25-6.25-3.875-4.75s-3.75,0.375-4.375,0.625s-3.5,1.125-3.875-0.625s-2.5,2.75-3.25,0.625s2.875-8.125,5.75-7s3.625,2,5.375,1.625s3.625-1.504,1.75-2.877s-6.5-1.623-4.875-4.373s3.125,1.75,3.75,0.125s-3.75-2.5-5.125-4s-4.125-1.25-4-2.75s1.375-0.375,1.125-2.125s-4.25,0.5-4.75-3s2-1.5,3.125-2.875s3.5,1.375,4.5,0.125s-4.25-2.75-0.75-4s2.875,0.5,6-0.125s4.75,0.375,3.125-1.5s-1.625-5,0.625-3.875s3.125-1.5,4.875,0.625s6.375-0.25,8.25,1.125s2.75-4.625,4.875-3.25s5.375,4,7.125,3.125c4.125,1,2.875-3.125,6.25-1.75s9.625-2.375,11.875,0.813s5.5,1.313,4.625,4.438s4,4.25,5.125,3.25s1.935,1.17,3.988,1.588c-0.137,0.655,0.921,0.991,2.929,0.079c3.667-1.667,4.833-0.667,6.333-0.667s3.5-1.166,5.5,0.5s5.167,1.334,5.861,0c0.639,1.584,2.186,4.679,3.037,5.59c1.991-0.225,4.004-0.328,5.435,0.244c2.253,0.901-3,5.5,0,6c2.333-0.75,8.25,1.25,10,0s2-4.859,6.167-5.18s0.667-3.73,4-5.525s-1-9.462,2.5-10.795s3.667-7.771,7-6.886s4.167-4.447,9.167-4.614s3.667-3.501,6.667-3.667c0.167,2.667,3.333,1.667,4.833,3.167s4,0.5,7.667,1s1.5-3.5,1.667-7.667s1.833-2.167,6.833-1.333s1.833-0.5,4.167-3s3.167,0.333,4.167,3s4.5,0.166,6.667,2s3.5,0.333,5.5,5.036s5,2.797,5.667,5.797s-8.167,1.5-6.167,5.666s3,1.834,6.167,3.667s5.333-0.167,7.667,3.167s1.167,3.333,2.333,6.166s-1.833,3.667-0.667,6.5s-0.667,6.667,2.042,12s-3.042,4.334,1.625,7.667s-0.167,8,0.813,11.667s3.688,0.5,5.354,5.666s2.167,2,5.167,3.5s8.167-5.166,7.58,0s0.42,4.167,1.42,7.667s6.337,0,6.333,5c-0.001,1.675,0.667,4-2.333,5.667S288,433.833,285.5,436s-3.667-0.833-5.5,1.667s-0.833,0.5-4.833,3.5s-2,8.666-2.789,10.289s-1.877,1.711-3.71,3.21c-2.58,2.11-1.848,6.506-5,8.834c-1.858,1.372-1.815,3.675-1.535,6.222c-1.618-0.778-3.757,1.778-6.132-0.472c-0.812-0.769-3.25,2.625-4.5-0.125s-9.5,2.75-11.125-3.125s-6.375-0.875-7.875-3.875s-1.625-0.625-6.125-1.5s-6.5,7.75-11,5.25s-8.375,5.125-11.25,3.75s-3.125,4.75-7.5,2.25s0.125-11.125-2.625-12.25s0.25-6.375-4.75-8.25s-4.625-5.875-7.25-8.125S184.75,438.125,182,434.5z M50.5,352c1.417,0,3.25-2.334,5.917-1s3.75-2.084,2.667-2.75s1.265-1.753-0.75-3c-1.75-1.083-2-0.167-3.167,1s-4.5,0.5-5.417,2.627s-4.25,1.123-3.5,2.789S49.083,352,50.5,352z M131.917,456.25c1.167-0.75,1.993-3.319,0.417-4.084c-2.75-1.334-5.583,2.667-5.083,3.75S130.75,457,131.917,456.25z M123.583,453c2.667-0.5,1.583-2.083,2.75-3.333s0.5-3.417-1-3.417c-2.667,0-2.75,0.833-2.667,2s-0.417,1-1.5,2.667S120.917,453.5,123.583,453z M116.083,442.5c1.75-0.917,0.917-2-0.167-1.917s-2.667-0.666-2.667-2.333s-4.917-1.417-5.25-0.083s-1.167,1.416-2.833-0.584s-3.333-1.916-6.167-0.5s-1.667,2.75,0,2.834s5.333,1.5,7.5,3.083s1.5,0.083,2.833,1.75s4.583,0.917,5.083,2.25s3.083,2.333,4.333,1.333s1.333-3.416-1.083-3.25S114.826,443.159,116.083,442.5z"/>
                <path id="iejs12" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M94,700.333c-2,1.833-3,6.834,2,5.667s4.334-6.576,8.667-5.788s-0.833-5.712,3.167-4.212s9.5-2.5,13.333-1.75s2.166-3.584,4.333-2.584s3.667-9,8.833-7.833s6.333-2.5,8.667-2s3.667,0.334,2.667-3.333s1.339-8.668,0.336-11.334s8.497-2.833,8.831-6.333s5.333,0.334,4.667-5.333s-7-0.666-5.167-5s5.667-2.5,2.667-8s-1.5-6.667-2.167-12.167s-2.833-5.333-3-7.833S143,620.334,145.5,614s6.167-2.5,6.833-6.167s5.667-4.001,2.333-8.667s-7.5-2.332-8.833-6.166s-5,3.834-6.667-1s5.5-5.001,3.167-9.334s3.333-4.834,2.167-9.5s3.5-9.5,0.5-14.333s-4.167-2.333-4.667-6s3.676-4.858,3.417-9.583c-3-2.25-3.125,0.375-6.5,2.5s-0.75-3.875-4.125-1.625s-5.625,2.375-7.875,0.25s-4.625-1.5-5.875,0s-6.25,3.75-4.125,5.625s-3,4.5-0.875,5.375s-0.5,4,2.25,5.125s-0.625,1.75-2.375,1s-3.125,0.25-5.625,1.375S100.875,573.75,89,569.75c-4.022-1.354-2.25,2.125-3.875,4.5s13,1.375,12,5.75s1.5,9.25,0.875,11.875s-2,2.25-3.875,1.375s-3.375,1.125-2,4.125s4.875-0.25,7,1.75s4.375,0.75,6.25,1.625s1.75,4-0.625,3s-3.75,2.75-7.5,0.875S88.5,609,87.75,607s-4.125,1.875-8.625-4.5c-1.387-1.964-3.125-3-1.875-4.625s0.25-5.125-2.125-5.125s2.125,5.125-1,6.625C72.998,599.916,70.5,605.5,68,604.5s-4.375,1.625-7.125,1.625s0-2.5,1.875-2.75s0.875-4.375-1.375-7s-4.75,3.25-6.875,3.125s-1.25,2.5-4.625,2.25s-3,4.625-5.75,4.25s-6.25,1.75-4.375,3.875s-2,3.25-0.5,5.5S34.5,617.25,34,613.75s-5.25,1.875-3.75,4.25s-5.75,0.875-0.75,8c1.831,2.608-2.125,2.125,0,4.25s5.5-0.75,8.125-0.375s4.875,0.875,1.625-1.625s1.75-3.625,3.125-2s4,3.125,6.75,2.125s-6.25-3-1.625-4.125c1.536-0.374,2.75,0.125,4.625,2.625s2.25-0.25,4.875,1.375s2-2.125,5.5-0.5s4.75-1.625,6.125-1.125S70.25,624.375,73,625s6.5-2.875,9.25-1s1.375,6,3.625,5.5s-0.625-3.625-1.625-5.75s1.625-1.75,3.625-0.375s2.125,0.25,2.5-1.125S92.75,622,94,620.75s2.625,0,5.125-0.875s1.125,1,3.25,1s3.75,1.75,0.25,2.25s-0.25,3-3.5,3.125s-1.875,2.5-5,2.5S92.75,625,90.5,625s0.125,4.5-1,5.375s-0.875,4.875-4.25,5.875s-3.25,4.625-6,4.5s-4.25,2.5-10.625,2.625s-2.875,3.75-8.625,3.25S57.75,651.5,54.125,651S51.5,655.625,48,655.25s-3,2.125-0.625,2.125s1.25,1.75,3.25,1.75s1.75,1.75,0.5,1.75s-1.5,1.25-0.125,1.625s2.625,3.375,1,3.875s-0.25-1.625-2.75-1.625s-2.375,3.25-5.375,3.5s-1.25-2.125,2.5-3.75s1.5-2.625-2.875-3.125s-1,3.625-5.25,3.25S34,665.5,32.625,669s4-0.25,5.25-0.125s0.75,2-1.301,2.125s0.176,1.375,1.551,2.875s-2,0.125-1.5,2.875s4.875,0.125,6.875,1.375s-1.5,6.75-1.625,8.25s4.5,0.375,5.25-1.75s2.875-2.5,3.375-4.875s1.25-0.875,5.375-2.875s2.875,1.25,4.125,2.875s10.375-0.5,9.375,1.25s-2.125,0.25-7,0.875s-0.875,2-4.5,6.5s6.5,2.25,7.5,4.625s1.75,0.75,4.75,1.375s1.25-5.375,5.5-4S84.125,685,86.75,685s4.125-2.5,8-1.625s3.25-4,6.625-3.5s1.375-2.25,4.75-2.125s6.75-6.125,9.75-5.125s2.75-0.25,6.125-0.25s1,2-1,2.875s-6,3.25-9.625,3.125s-7.125,6.25-10.875,8.25s3.75,2.5,0.375,4.625s-3.125-3-5.375-1.625s1,2.875-1.5,4.625C93,698,96,698.5,94,700.333z"/>
                <path id="iejs13" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M399.875,398.25c-0.125,4,4.625,3.375,3.75,7.875s3,3.375,1.25,8.125s-5.807,1.5-3.403,6.875s1.153,5.5-1.222,7.375s-8.625,0-9.625,0.875s-1.875-0.625-3.375,0.625s9.459,4.793,8.917,6.834c2.333,0.834,7.667,3.001,5.5,4.834s2.499,8.5,0.666,11.333s1.668,6.332-2.499,8.666s0.166,5.668,1.166,7.334s6.5-1.333,8,2s8.5,4.333,9.167,9.5s-1,8.667,0,11.667c5,1.499,4.666-1.333,6.833,0s4.615-4.501,7.308-3.501s1.525-6.001,5.192-7.167c-1.666-3.5-0.5-6.5-4-9s1.834-5.167,1.667-8.167s6.334-8.667,8-12.167s4.333,1,7.333-4.333s8.167-6.167,9.5-9s-0.488-2.069,0.333-7.833c1.449-10.167,7.668-1.833,7.501-8.5c-3.5-0.666-5.167-2.5-4.167-3.667s-2.333-6.167-1.833-7s-0.667-5,1.833-5.333s2.167-5.5,5-5.5s2.333-7,2.5-8.834c-2.083-3.084-8.167-0.166-10.917-4.916s-6.625,1.833-10.125-0.719c-1.359-0.991-8.25,2.552-13.75-3.156c-2.516-2.61-15.125,3.125-18.5-0.25s-5.25,2.875-7.25,2s-9.75,6.625-13,5.75C397.375,396.75,400,394.25,399.875,398.25z"/>
                <path id="iejs14" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M409.167,596.668c0.5-3.167,4.5-5.834,4.5-9.167s4.167-2.999,3-6.833s6.5,0.166,6.5-4.667s-4.499-4.499-3.833-5.833s-1.334-1.666,0.666-3.5c-8-5.333-0.333-10.167,1.333-14.334s-4.166-2.667-4.166-7s-10-3.167-7.834-9.167c0.811-2.244-0.5-1.333,0-6.5s-8.666-4.833-10.5-7.834s2.334-3.166,2.167-6.166s1.667-4.333,2.334-8.166c-0.333-3.666-2.167-2.667-2.5-7.667s-5.5,1.5-8.5-0.678s4.166-5.322,1.333-8.655s-6.833-0.334-12.333,0s1.333,9.435-7.678,6.666c-3.371-1.035-4.489,2.834-7.489,3.454s2.667,7.213-7.167,4.252c-2.919-0.879-3.5,9.128-7.333,1.794c-1.392-2.663-3.667-0.333-5.333-4.666c-1.667-4.333-4.5,3-7.834,2.166s3.834,7.5-6,4.167c-3.262,10.874,5,9.5,7.667,13.499s6.167,0,7.333,7.501c0.668,4.294,3.5,1.5,3.5,7s5,2.833,6,7.333s-4.834,3.5-4.334,8.167s5.168,0.833,5.668,6.167s-3,5.166-1.667,11.333s2.667,2.333,8.167,5.667s0,4.166,1.5,12.5s9.333,4.667,11.666,12s4.667,6.333,4.5,9.092s4.834-0.925,6.834,1.575s7.333-3.834,8.333-0.667s8,1,10.583,4.749c1.125-1.75,0.125-4.75,0.25-6.5s-1.875-3-1.75-5.5C405.167,599.334,408.667,599.835,409.167,596.668z"/>
                <path id="iejs15" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M412.5,500.501c2.333-3.5,3.334,0.5,4-3.333s2.667-2,1.667-5s0.667-6.5,0-11.667s-7.667-6.167-9.167-9.5s-7-0.334-8-2s-5.333-5-1.166-7.334s0.666-5.833,2.499-8.666s-2.833-9.5-0.666-11.333s-3.167-4-5.5-4.834s-2,3.667-4.167,2s-9.5,1.5-12.166-0.333c-2.667-1.833-4.334,3.333-7,1.5c-2.667-1.833-1.334-6.167-1-9.5c0.333-3.333-2.834-2.834-3.834-4.71s-4.834,2.71-8.666,0.376c-3.834-2.334-5.834,7-7.5,5.834c-1.667-1.166-3.5,2.833-7.834,1.833s0.666,8-5,7.333s-0.834,5.834,0.166,9.023s1.334,4.311-1.332,4.811c-2.667,0.5-3.5,4.666-5.5,5.166s-3.834,0.334-2.668,5.334c1.167,5-5.5,5.666-3.666,10.166s6.334,1.5,7.834,4s-2.167,4.167-4.834,8s1.834,4.834-0.5,10.536s5,6.798,4,10.131c9.834,3.333,2.666-5.001,6-4.167s6.167-6.499,7.834-2.166c1.666,4.333,3.941,2.003,5.333,4.666c3.833,7.334,4.414-2.673,7.333-1.794c9.834,2.961,4.167-3.632,7.167-4.252s4.118-4.489,7.489-3.454c9.011,2.769,2.178-6.332,7.678-6.666s9.5-3.333,12.333,0s-4.333,6.478-1.333,8.655s8.167-4.322,8.5,0.678s2.167,4.001,2.5,7.667C404.001,503.668,410.167,504.001,412.5,500.501z"/>
                <path id="iejs16" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M251.333,195.5c1.5,4.333,4.5,0.667,4.667,3.5s3.333,1.5,2.5,4.333s0.833,6.167-1.667,7.833s3.445,6.333,1.806,9s2.361,5.333,1.028,7.333s3.167,2.833,1.667,6.333s3.287,7.5,0.31,9.167s3.779,4.701,4.917,4.5c3.773-0.667,2.606,2.333,5.106,1.833s0.5,3.333,3,5.833c3.167-2.333,3.167-3.167,6.167-1.333s0.667,3.667,3.5,5.833s-1.34,6.333,2.08,9.5s-1.586,7.5,0,9.667s-3.448,1.527-2.08,3.667c3.303,5.167-3.667,4.5,1.167,7.833s6.959,0.666,8.729,4.833s3.104,1.667,2.771,5.333s6.333,4.834,5.666,9.167c4.334,3,5-0.5,7.834,0s2.666-3.499,6.5-2.833s1.5-4.501,4.834-5.334c3.332-0.833,0.5-9.333,7.166-8.833s4.999-3.167,8.166-3.167c2-6.333-2.166-5,0-11.167c1.162-3.306-5-5-4.832-7.167C332.5,269,330,272,330,268.167s-7.666-5.333-7.334-8.5c0.333-3.167-9-2.833-10-5S306,251.833,305,247s-4-0.167-5.5-1.25s-2.5,2.417-6.99-2.083s1.823-7.333,0.323-12s2.667-2.167,3.333-4.667s4.667-2,4.583-5.75c-2.25-5-8.25-3.25-9.25-8s-8.75-4.75-9-10.25s-8.5-8-9.5-12.167s-3-3.083-7.125-5.708c-2.75,3.125-9.5,0.5-11.5,2.5C256.167,191,249.833,191.167,251.333,195.5z"/>
                <path id="iejs17" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M140.333,552.833c0.5,3.667,1.667,1.167,4.667,6s-1.667,9.667-0.5,14.333s-4.5,5.167-2.167,9.5s-4.833,4.5-3.167,9.334s5.333-2.834,6.667,1s5.5,1.5,8.833,6.166c5.167-2.166,3.333-7,8.167-6.833s2.5,3.828,8.167,3.414s3.333-2.746,8.5-2.08s-0.167,4.834,6.833,4.5s11.667-2.176,10.333-5.838s-3.04-5.429,1.167-4.828c10.5,1.499,1.5-6.667,7.667-3.834s10.834,0.002,12.667,3.834s7.833,0.832,7.167,5.832s4.5,0.166,5,5.833s6,2.834,9.167,4.834s8.167-4,11.833-3s2.666-5.501,6.333-2.834s8.167,0,11.167,2.167s5-0.834,7.833,0.333c2.833-3.166-1.167-2.167,0-4s0-3.833-2.167-4.333s-2.666-3.997-4.833-4.832s-3-2.205-2.667-4.437s2-4.565-1.333-3.898s-5.667,3.434-6-0.116s1.667-7.55-4.5-6.217s-4.5,0.834-3.5-4.333s3.5-4.334,3.667-6.167s10.833-2.334,11.833-4.667s4.333-1.333,3.5-3.833s-2.5-6.501-0.5-8.667s2-2.166-0.5-4.166s-3.334-2.834,0.333-5.167s9.167-9.499,5.167-8.833s-4.167,1.246-8-0.044s-2.167,2.456-3.833,0s-3.333-0.123-5.167-1.623s-3.167,3.667-5.333,2.5s-5.333,4.166-7,1.333s-0.505-13.167-3.002-16.333c-1.919,0.833-1.456,4.417-3.831,5.542s-2.5,6.375-5.5,7.25s-4.375,4.375-7.375,1.875s-3.125,2-4.875,0s-3.75-0.625-6.125-1.875c0,1.5-3.875,2.375-5.25,1.5S207.625,528,204,526.25s-6.5,3.625-9.625,2.125s-6,3.25-6.25,5.625s-4.375,3.75-4.25,1.625s-3.25-3.75-4-0.625s-2.125-1-3.25,1.375s-4.5,0.125-8.25,2.375s-7.125,0.625-7.25,2.75s-8.875,3.5-10.875,2.875s-0.375-1.625-2-2.875s-1.5,4-4.5,1.75C144.01,547.975,139.833,549.166,140.333,552.833z"/>
                <path id="iejs18" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M365.5,78c-5.5,3.25-4.75,0.75-7.25,4.5s0.75,2.25-1.5,8.25s4.75,5,2.75,7s3.75,3,0,5.75c5.75,3.25,10.75-5,12.25,0s10,0.75,9.75,7s3,3.5,5.5,6.5s9-2.75,11,2s15-2.75,14.75,2s5,5,1.5,6.75s-5.75,6.5-2.25,7.5s7.25-3.75,8.5,1.5s10.586,1.034,9.5,5.5c-2.25,9.25,2.972,7.382,4.25,9.25c6.5,9.5,11.66-2.5,13.58,0s9.92-7,13.67-2.5c2.16,2.592,4.653,3.773,6.119,4.787c0.486-0.809,0.88-1.581,1.017-2.287c0.207-1.064,2.947-2.996,1.393-5.268c-2.332-3.409-10.278-0.982-9.028-10.732c0.671-5.231-1.75-10-1.68-12s-0.82-5.5-0.07-9.25s-4.75-9-4-12.403s-6-8.347-4.493-11.347s-2.507-4.75-2.927-8.25s2.92-11.5,0-13s0.42-3.5,2.42-6s-2.5-2.25-3.5-8.75s-3-4.75-4.125-10.125c-0.375,0.625-6.5,2.375-6.375,3.375s-5.625,5.125-8.25,4s-6,1.5-8.625-1.125s-4.625,0-7.75-2.875S409,51.375,409.5,52.625s-1.25,5-2.25,7s1.625,2.75,1,4s-3.75-0.875-5,1.875s0.75,4.5-0.875,6s-3.25,3.625-6.625,3.625s-3.375,0.5-7.375-1.75s-3.75,0-6.625-0.125c-1.438-0.063-2.281-0.531-2.781-1.156C375.938,75.438,377.5,76.5,376,78S371,74.75,365.5,78z"/>
                <path id="iejs19" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M298.833,313.667c-1.167,3.5,6.329,3,5.165,7.5s-3.832-0.167-4.498,4s-3.667,0.5-3.167,4.5s-2.333,5.667,0.667,9c2.333,1.166-3.333,3.667-1.5,6s-2.762,6.166-0.381,7.166s6.381,5.666,5.214,6c-1.167,0.334,0.5,7.834,2.667,5.834c2.166-2,8.666-5.333,9.666-3.5c2.834,1.666,4.668-0.668,7.001,3.749s6.333-0.489,8.583,2.214c3.197,3.841,4-0.88,6.5-0.13s5.5-1.75,1.75-7.75s4.75-4.75,3-11.5c-0.596-2.296-0.75-5.5,4-5.25s1.75-6.75,5.5-9s0.75-2.5,4.25-8s2,6.75,6.75,5s-0.5-5,1.09-7.25c-4.909-4.417,2.576-5.583-3.756-11.354c-2.609-2.377-6-11.062-7.834-10.698s-4.166-5.531-6.334-6.198c-2.167-0.667,1.334-4.5-6-4.5c-3.167,0-1.5,3.667-8.166,3.167s-3.834,8-7.166,8.833c-3.334,0.833-1,6-4.834,5.334s-3.666,3.333-6.5,2.833s-3.5,3-7.834,0C302,314,300,310.167,298.833,313.667z"/>
                <path id="iejs20" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M473,263.25c-4.5,1,0,4.5-7.75,5.5c-4.215,0.544-6.75-3.5-10.5,3.5c1,3.75,3.5,5.75-1.25,8s0,10.75-6.5,12s-3.75,2.5-8.75,3.25c-0.152,0.023-0.299,0.07-0.449,0.105c4.137,2.172,8.699,1.598,8.699,4.228c0,3.333,8,5,6.834,9.333s-1.167,1.833,1.999,7.667S459,317.167,460.5,318s7.833-1,9.5,2.667s4.833,2.667,8.333,4.667s2.334-1,8.168,0c1.333-3-0.5-3.667,1-6.334s0.833-5-0.667-5s-0.5-8.667,0.167-10s-0.667-3.333-3.667-2.667c-3,0.667-2.833-1.167-7.666-3.167s-1-7.667-2.334-10.5s2.667-2.833,1.538-5.333s4.962-4.833,0.795-6c-2.086-0.584,0.167-2.667,2.167-2s4.833-0.333,6.333,2.5s3.667,2.5,9.834,4s5-1.5,6.5-2s3-3.667,0.833-4.333s-1.167-4.333-3.833-4.333S490.667,264,488.667,263c-1.113-0.557-2.02-1.372-2.317-2.358C477.144,258.123,477.5,262.25,473,263.25z"/>
                <path id="iejs21" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M100.875,352.75c1.75-0.875-7.75-4.125-8.625-6.5s-4.375-2.75-4-5.125s-1.375-5.625,0.5-7.375s-0.375-3.125,3-6.5s-6.125-2.5-2.375-5.375s7.712,0.603,10.375-1.75c5.375-4.75,6.625,1.5,10.125-0.875s5.125,2.5,9.875-0.875s5.375-0.25,7-2s-8.625,0-8.5-3s2.813-0.756,3.125-3.625C122,304,127,308,127.625,305s0.375-8.5-2.5-8.5s-6.375,1.375-8.375-0.125s-4.625,0.625-7.375-0.625s-4.25-1-5.5,0.375s-10.329,7.786-12.75,7.375c-6.625-1.125-1.5-4.125-3.75-4.875s-0.875,5.125-4.125,2.125s-1.875-4-4.125-6.125s-2.125,0.5-5-1.25s2.75-6.75-0.25-9.25s-3.375,0.875-6.125,0.5s-2.5-2.5-4.5-1.5s-3.625-0.375-5,0.25s-6.375-1.25-3-2s4.625-0.5,4.125-3.375s-0.375-5,0.875-3.125s0.875-3.125,3,0.375s4.625,2.625,5.25,0s5.625-4.625,6.875-2s6.5-2.75,8.5,0.125s4.25,5.5,3.125,5.5s-6,1-3.625,2.875s0.375,3,1.625,3.5s3.375-1.875,2.75,0.75s-2.625,3.375-1.625,3.75s-1.875,2.375,0.375,2.75s4-2.5,3.375-2.5s-1.25-3.5,0.5-3.625s5.5-2.125,6.875-0.75s2.875,2.75,3.875,0.75s0.75-3.625-2.125-3.875s-6-0.25-5.5-2.75s4.75,0.625,2.75-2.75s-3.875,1.25-4.75-1.5s2.75-2,0.25-4.25s-2.125-2.375,0.125-3.5s2.75-2.125,2.25-4.5s2.375-0.75,2-4s-2-6.375-3-3.25s-3.875,2.125-2.875,4.25s0,4.375-2.25,4.375s-4.125,1.375-4.25-1.25s-5.5-7.25-2.25-7.25s5.75-0.625,4.625-3.125s-3.5-3.25-1.25-4s-2.75-5,0.25-6.125s4.25-2.625,0.875-3.625s-6.25-2.75-3.5-2.875s10,0.25,10.5-1.375s-1.5-2.75-3.25-2.625S85.5,235,84,234.625s-4.125,0-3.875,1s-4-0.875-2,2.25s-0.125,4-1.875,3.125s0.75,3.25-1.5,3.125s-5.75,4-3.375,4.25s2,3.25,0.5,3.75s-2,2.25-0.625,3s2,4.25,0.875,4.75s-2.25,0.625-3.625-0.5s-6-0.5-3.625-3.5s-0.625-3.5,2.375-7s2.375-4.625,3.375-6.625s-2.25-2.5,1.375-4.75s-1.375-3.375-1.5-6.625S68.375,227,71,225s5.5-1.25,6.625-3.625s2.75-3,3.125-1s6.625,3.75,6.875,6s1.75-1,2.875,0.5s2.625-3.375,6.25-3.125s2.125-4.375-0.125-4.875s-2.5-4.625-0.25-4.625s3.375-4,5.75-1.875s1.437-1.155,5.125,1.25c11.5,7.5,11.125-0.375,13.75,0.875s7.625,1.75,8.875,3.125s5-1.375,6.25-0.25s7.875-2.75,9.375,0.75s3.25-0.375,3.75-1.375S150.5,214,153,216s9.625,0.875,8.25,3.75s-0.25,4.625,1.75,3.875s2.901-0.303,2.125,1.25c-2.25,4.5,5,6,1.625,8.125s-4,3.25,0.125,3.25s4.125,1.875,4.875,4.875c-1.25,0.792-3.917,0.208-2.25,2.375s-5.167,1.667,0,5.167s5.167-3.667,7.333-2.244s3.5-1.423,5.333,0.577s5-2,7.167,0s4.167,1.333,5.167,3.833s4.833,2.5-0.167,3.5s-1.333,3.5-3.167,6s-0.667,3.5-1.833,5.667s-4.5,1.167-7.333,3.833s0.333,4.167,4.333,3.667s1.667,1.167,7.833,0.333s4.167,6.5,6.667,6s1.333,2.167,5.667,3.833s4.667-5.833,7.833-5s1-0.833,6.833-2.543s2-3.124,5.833-4.291s2.333,3.333,1.667,5.667s1.833,1.667,0.333,4s-6-1.667-8.333,0s0.5,1.5,0.667,5.621s3.833,5.546,4.667,7.046s3.5,1,1.833,3.167s-5.667-1.167-7,0.833s-5.667,0.5-5.5,3.167s-4.333,5.333-3.667,7.833S211,312,211.333,315.333s2.5,1.667,4.833-0.333s2.667-0.833,2.667,2.167s3.5,5.167,2.5,7.667s-3,1.333-5.667,2.533s-3.333,3.133-3.667,5.3s-4.833,0.833-4.667,3.5c-3,0.166-1.667,3.5-6.667,3.667s-5.833,5.5-9.167,4.614s-3.5,5.553-7,6.886s0.833,9-2.5,10.795s0.167,5.205-4,5.525s-4.417,3.93-6.167,5.18s-7.667-0.75-10,0c-3-0.5,2.253-5.099,0-6c-1.431-0.572-3.444-0.469-5.435-0.244c-0.852-0.911-2.398-4.006-3.037-5.59c-0.694,1.334-3.861,1.666-5.861,0s-4-0.5-5.5-0.5s-2.666-1-6.333,0.667c-2.007,0.912-3.065,0.576-2.929-0.079c-2.054-0.418-2.863-2.588-3.988-1.588s-6-0.125-5.125-3.25S121.25,355,119,351.813s-8.5,0.563-11.875-0.813S105,353.75,100.875,352.75z M77.083,316.25c0.833,0.417,3.583,1.333,4.5,0.583s3.75-1.167,3.833-3.333s-3.002-0.448-3.167-2.417c-0.167-2-2-1.167-1.917,0s-2.25,0.833-2.917,2.083s-5.5-0.666-3.667,2.667C74.687,317.536,76.25,315.833,77.083,316.25z M66.583,334.833c1.083-1,2.646,0.18,3.5-2.75c0.583-2-3-1.333-3.917-0.583s-1.5,0-2.5,1.958S65.5,335.833,66.583,334.833z"/>
                <path id="iejs22" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M478.333,325.334c-3.5-2-6.666-1-8.333-4.667s-8-1.834-9.5-2.667s-2.001,4.668-5.167-1.166s-3.165-3.334-1.999-7.667s-6.834-6-6.834-9.333c0-2.63-4.563-2.056-8.699-4.228c-4.747,1.112-7.984,8.091-13.801,6.395c-6-1.75-4-5.75-8-4.75s1,1.277-2.5,5.014s0.5,4.986-1,6.236s3.75,3.75,1,7.25s-10.5-2.75-13.25,0s-8.213-4.802-13-1.5c-7.25,5-11.75-0.75-14.25,1s-5.5,0-7,2.75c2.5,2.667,2.5-0.666,5.5,2.167s7.167,2.742,5.834,5.871c-1.334,3.129,3,3.961,3.833,6.295s8.334,1.5,11.167,5.167s6.666,2.166,7.166,5.333s4.334,4.5,4.334,2.5s-1.666-5.666,0-7.833s1.833,1.833,3.833,2.5s-0.667,9.333,2,10.833s2,4.833-1,4s-5.5-1.834-4,3s-1.834,6.168-0.667,8.334s1.833,10.333-2,8.333s-4.999-1.5-4.833,1s-6.156,2.262-6.833,4.5c-1.665,5.5-3.835,0.899-7.168,4.116c3.459,3.634,5.584,1.925,7.084,4.967s4.125,0.917,7.375,1.792s11-6.625,13-5.75s3.875-5.375,7.25-2s15.984-2.36,18.5,0.25c5.5,5.708,12.391,2.165,13.75,3.156c3.5,2.552,7.375-4.031,10.125,0.719s8.834,1.832,10.917,4.916c0.167-1.834,1.833-0.833,2.5-3.5s4.833-5,5-5.666s4.5-6,3.069-7.834s1.098-6.833-1.402-7.166S479,364.333,475,362.833s-3.166-6,0-5.167s1.334-4.5,5.834-3.833s1.5-0.333,4.833,1.667s2.833,0.166,3.667-3.667s0-3,1.834-6.5c0-1.834-3.834-4.833-3.334-10.499s-2.666-6.5-1.333-9.5C480.667,324.334,481.833,327.334,478.333,325.334z"/>
                <path id="iejs23" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M413,199.75c0.203-5.27-4.25,2.5-7-1s-4-3-5.5,0.5s-3.75,2-5,6.5s-2.75,5.25-8.497,6.75c-5.746,1.5-1.753,9.75-1.253,13.25s3.75,7.25-2.75,7.5s-1,4.25-4.25,5.5s-1.75,6-5.75,7c0.666,2.25,3.667,3.75,1.834,6.083C373,254.167,375.334,254,374,258s5,0.667,9,1.839s9.667-3.006,12.167-1.839s8-3.5,7.333,5.5c-0.187,2.515,8,3.333,8,5.5s1.834,2.5,4.667,5.167s6.667,3,7,8.5s8,5.333,12.5,10.5c0.95,1.091,2.027,1.857,3.134,2.438c0.15-0.035,0.297-0.083,0.449-0.105c5-0.75,2.25-2,8.75-3.25s1.75-9.75,6.5-12s2.25-4.25,1.25-8s-10.5-4.5-8.49-16.5c1.373-8.199-0.26-10-0.01-12.75s-4.25-5-8.5-1s-9.5-2.5-9.75-8.75s-6.25-8.25-5-12.25s-1-5.25-2-9.75S412.5,212.75,413,199.75z"/>
                <path id="iejs24" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M376.667,391.166c-3.833,2.167-1.833,5.167-5.833,5.167s-4.667,8.666-11.5,8.333c-6.834-0.333-7.334-1.999-11.167-1.166s-5.758-1.383-5-4.667c1.5-6.5-2.501-5.5-3.667-8s-7.166-5.667-6.666-1.75s-1.335,5.75-3.168,5.75c-1.832,0-2.166,4.166-7.332,2.833c-5.168-1.333-7.001,0.834-11.334,0.834s-4.237,1.832-9.119,1.666c-4.881-0.166-4.214,2.5-6.214,3s-3.007,4.167-9.253,6.667c-0.586,5.166,0.42,4.167,1.42,7.667s6.337,0,6.333,5c-0.001,1.675,0.667,4-2.333,5.667S288,433.833,285.5,436c4.25-0.375,2.375,6,4.5,6.625s0.875,5.75,5.125,5.25s5.75-3.625,6.125,1.25s-4.25,4.125-3.25,9.75s-4.291,6.625-3.771,11.625s-5.604,3.75-5.104,8.125s-3,4.5-0.875,8.375s2.875,6.75,6.875,7.125s0.75,4.25,4.375,4.5s2.625-2.5,1.25-4.375s-1.625-7.625,2.625-6.375s4.25-3.75,7.625-3.5s1.125-7.875,3.875-8.875s2.25-2.875,4.75,0.25s3.25,0.334,6.375-0.083c-1.834-4.5,4.833-5.166,3.666-10.166c-1.166-5,0.668-4.834,2.668-5.334s2.833-4.666,5.5-5.166c2.666-0.5,2.332-1.621,1.332-4.811s-5.832-9.69-0.166-9.023s0.666-8.333,5-7.333s6.167-2.999,7.834-1.833c1.666,1.166,3.666-8.168,7.5-5.834c3.832,2.334,7.666-2.252,8.666-0.376s4.167,1.377,3.834,4.71c-0.334,3.333-1.667,7.667,1,9.5c2.666,1.833,4.333-3.333,7-1.5c2.666,1.833,9.999-1.334,12.166,0.333s1.834-2.834,4.167-2c0.542-2.041-10.417-5.584-8.917-6.834s2.375,0.25,3.375-0.625s7.25,1,9.625-0.875s3.625-2,1.222-7.375s1.653-2.125,3.403-6.875s-2.125-3.625-1.25-8.125s-3.875-3.875-3.75-7.875s-2.5-1.5-2.25-7.375c-3.25-0.875-5.875,1.25-7.375-1.792s-3.625-1.333-7.084-4.967C379.834,387.333,380.5,388.999,376.667,391.166z"/>
                <path id="iejs25" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M295.667,403.166c2-0.5,1.333-3.166,6.214-3c1.882-3.001-2.047-5.666-1.082-8.166c0.966-2.5-2.465-3.5-1.799-5.833s-1-3.167,0-6.669c2,3.498,1.833,3.669,5.666,0.502c3.833-3.167,4.168,0.667,5-1.272c0.833-1.939-3.832-3.895-3-5.395c0.833-1.5,0,0-0.832-4.833c-0.834-4.833,7.832-6.5,6.832-8.333s-7.5,1.5-9.666,3.5c-2.167,2-3.833-5.5-2.667-5.834c1.167-0.334-2.833-5-5.214-6s2.214-4.833,0.381-7.166s3.833-4.834,1.5-6c-3-3.333-0.167-5-0.667-9s2.5-0.333,3.167-4.5s3.334,0.5,4.498-4s-6.332-4-5.165-7.5s3.167,0.333,3.833-4c0.667-4.333-6-5.5-5.666-9.167s-1-1.167-2.771-5.333s-3.896-1.5-8.729-4.833s2.137-2.667-1.167-7.833c-1.368-2.139,3.667-1.5,2.08-3.667s3.42-6.5,0-9.667s0.753-7.333-2.08-9.5s-0.5-4-3.5-5.833s-3-1-6.167,1.333s-0.167,2-1.333,3.833s-0.667,3.167-6.127,6s0.794,4.833-2.539,5.333s-3.5,3-4.667,5.791s-2.833,1.376-6-0.791s-5.333,0.5-2.833,3.5s-1.167,4,1,7.061s6.167,0.273,6,4.439s3,1.167,6,3.167s4.167,4.5,1.708,4.667s-3.208,2.333-5.208,3.833s-4,1-4.667-2.5s-4.333-1.833-5.5-6.5s-6.5,1-10.667-1.667s1.167-2-3.167-6.833s-4,0.5-7.667-3c-1.5,2.333-6-1.667-8.333,0s0.5,1.5,0.667,5.621s3.833,5.546,4.667,7.046s3.5,1,1.833,3.167s-5.667-1.167-7,0.833s-5.667,0.5-5.5,3.167s-4.333,5.333-3.667,7.833S211,312,211.333,315.333s2.5,1.667,4.833-0.333s2.667-0.833,2.667,2.167s3.5,5.167,2.5,7.667s-3,1.333-5.667,2.533s-3.333,3.133-3.667,5.3s-4.833,0.833-4.667,3.5s3.333,1.667,4.833,3.167s4,0.5,7.667,1s1.5-3.5,1.667-7.667s1.833-2.167,6.833-1.333s1.833-0.5,4.167-3s3.167,0.333,4.167,3s4.5,0.166,6.667,2s3.5,0.333,5.5,5.036s5,2.797,5.667,5.797s-8.167,1.5-6.167,5.666s3,1.834,6.167,3.667s5.333-0.167,7.667,3.167s1.167,3.333,2.333,6.166s-1.833,3.667-0.667,6.5s-0.667,6.667,2.042,12s-3.042,4.334,1.625,7.667s-0.167,8,0.813,11.667s3.688,0.5,5.354,5.666s2.167,2,5.167,3.5s8.167-5.166,7.58,0C292.66,407.333,293.667,403.666,295.667,403.166z"/>
                <path id="iejs26" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M169.5,243.5c1.667,2.167-5.167,1.667,0,5.167s5.167-3.667,7.333-2.244s3.5-1.423,5.333,0.577s5-2,7.167,0s4.167,1.333,5.167,3.833s4.833,2.5-0.167,3.5s-1.333,3.5-3.167,6s-0.667,3.5-1.833,5.667s-4.5,1.167-7.333,3.833s0.333,4.167,4.333,3.667s1.667,1.167,7.833,0.333s4.167,6.5,6.667,6s1.333,2.167,5.667,3.833s4.667-5.833,7.833-5s1-0.833,6.833-2.543s2-3.124,5.833-4.291s2.333,3.333,1.667,5.667s1.833,1.667,0.333,4c3.667,3.5,3.334-1.833,7.667,3s-1,4.167,3.167,6.833s9.5-3,10.667,1.667s4.833,3,5.5,6.5s2.667,4,4.667,2.5s2.75-3.666,5.208-3.833s1.292-2.667-1.708-4.667s-6.167,1-6-3.167s-3.833-1.379-6-4.439s1.5-4.061-1-7.061s-0.334-5.667,2.833-3.5s4.833,3.581,6,0.791s1.334-5.291,4.667-5.791s-2.922-2.5,2.539-5.333s4.961-4.167,6.127-6s-1.833-1.5,1.333-3.833c-2.5-2.5-0.5-6.333-3-5.833s-1.333-2.5-5.106-1.833c-1.138,0.201-7.894-2.833-4.917-4.5s-1.81-5.667-0.31-9.167s-3-4.333-1.667-6.333s-2.667-4.667-1.028-7.333s-4.306-7.333-1.806-9s0.833-5,1.667-7.833s-2.333-1.5-2.5-4.333s-3.167,0.833-4.667-3.5s4.833-4.5,3.042-7.875c-2,2-4.125,3.125-8.25-0.5s-1.5,2-0.875,4.375s-2.375,3.125-3.5,6.375s-7.875-0.375-8.875,4.5s-7,3-10.375,6s1.125,1.25,2.5,4s3.625,1.125,6.625-0.75s10.5,1.75,10.375,3.375s-6.375,1.875-6.875,3.125s2.25,0.75,4.5,0.875s3.25,2.25,2.25,4.125s-4.25,0.375-8.75,0.25s-1.625,5-3.75,5.875s-1.875-1.875-4.125-4.125s-2.375,0-6.375,0.375s-0.875-0.875-4.375-1.25s-4.875,2.625-6.375,3.625s-9-2.875-11.375-5.5s-10.25-2.5-13.625-2.125s1,8.375-7.75,16c-1.534,1.337-1.125,1.75-1.125,5.25s-1.75,2.625-2.5-0.375C170.5,241.917,167.833,241.333,169.5,243.5z"/>
                <path id="iejs27" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M328.5,498.203c2.334-5.702-2.167-6.703,0.5-10.536s6.334-5.5,4.834-8s-6,0.5-7.834-4c-3.125,0.417-3.875,3.208-6.375,0.083s-2-1.25-4.75-0.25s-0.5,9.125-3.875,8.875s-3.375,4.75-7.625,3.5s-4,4.5-2.625,6.375s2.375,4.625-1.25,4.375s-0.375-4.125-4.375-4.5s-4.75-3.25-6.875-7.125s1.375-4,0.875-8.375s5.625-3.125,5.104-8.125s4.771-6,3.771-11.625s3.625-4.875,3.25-9.75s-1.875-1.75-6.125-1.25s-3-4.625-5.125-5.25s-0.25-7-4.5-6.625c-2.5,2.167-3.667-0.833-5.5,1.667s-0.833,0.5-4.833,3.5s-2,8.666-2.789,10.289s-1.877,1.711-3.71,3.21c-2.58,2.11-1.848,6.506-5,8.834c-1.858,1.372-1.815,3.675-1.535,6.222c0.195,1.773,0.505,3.666,0.368,5.445c-0.333,4.334-7.333,4.333-9.167,6.833s-1.667,5-2.333,6.942s-4.465,6.669-3,9.225s-7.667,11.5-5.169,14.666s1.336,13.5,3.002,16.333s4.833-2.5,7-1.333s3.5-4,5.333-2.5s3.5-0.833,5.167,1.623s0-1.29,3.833,0s4,0.71,8,0.044s-1.5,6.5-5.167,8.833S267.167,539,269.667,541s2.5,2,0.5,4.166s-0.333,6.167,0.5,8.667s-2.5,1.5-3.5,3.833s-11.667,2.834-11.833,4.667s-2.667,1-3.667,6.167s-2.667,5.666,3.5,4.333s4.167,2.667,4.5,6.217s2.667,0.783,6,0.116s1.667,1.667,1.333,3.898s0.5,3.602,2.667,4.437s2.667,4.332,4.833,4.832s3.333,2.5,2.167,4.333s2.833,0.834,0,4c2.833,1.167-2.833,6.666-0.833,8.5s-1.379,6.168,1.644,6.834s4.023-0.167,6.69,1.333c1.167-2,10.416,1.334,11.458-3.083s3.042-1.083,4.708,0s5.833-1.583,7.667,1.25s5-0.834,7.334,0.833c2.333,1.667,4.5-1.166,6,0.334s5.023-1.953,4.345-4.644s-3.345-0.357-4.345-4.69s2.5-3.666,0.833-8.833s4-2,6-5.5s9.166,1.499,12.333-2.167s8.5,2.5,11.5,0.667s6,0.834,7-0.833s5.667-0.832,7.334-3.166c-1.5-8.334,4-9.166-1.5-12.5s-6.834,0.5-8.167-5.667s2.167-5.999,1.667-11.333s-5.168-1.5-5.668-6.167s5.334-3.667,4.334-8.167s-6-1.833-6-7.333s-2.832-2.706-3.5-7c-1.166-7.501-4.666-3.502-7.333-7.501s-10.929-2.625-7.667-13.499C333.5,505.001,326.166,503.905,328.5,498.203z"/>
                <path id="iejs28" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M461.5,149c-3.75-4.5-11.75,5-13.67,2.5s-7.08,9.5-13.58,0c-1.278-1.868-6.5,0-4.25-9.25c1.086-4.466-8.25-0.25-9.5-5.5s-5-0.5-8.5-1.5s-1.25-5.75,2.25-7.5s-1.75-2-1.5-6.75S400,123.75,398,119s-8.5,1-11-2s-5.75-0.25-5.5-6.5s-8.25-2-9.75-7s-6.5,3.25-12.25,0c-3.75,2.75-2.75,6-6.75,7.5s2,8.5-4,8.25s-3.25,11-3.25,13.918s-3.25,3.332-5,0.832s-3.5,1.25-3.5,3.19s-7,4.81-10,1.56s-6-0.25-12-1.25s-0.5,5-5,6.75s0.25,3.5-2.25,5.5c-4.607,3.686,0.25,7.5,4,7.75s3,4.25,6.75,4.5s-0.25-7,2.75-6.25s2.5-3.25,6.25-1.75s0,5,0,6.25c4.834,0.583,2.5,3.917,5.334,4.083c2.833,0.167,1.666,5.167,5.833,5.167s6.833,2.5,4.5,3.667s1.333,7.667-1.833,7.833c-3.167,0.167-9.559,5.333-5.446,7.667s-2.388,5,1.279,7s4-5.333,8-1.5s9.5-2.833,11.167,0c1.666,2.833,3.833-3.166,5.5,0.167c1.666,3.333,8.332,4.667,8.666,8s5.333,3.833,5.5,7s6.673,0.167,11.003,3.167c5.747-1.5,7.247-2.25,8.497-6.75s3.5-3,5-6.5s2.75-4,5.5-0.5s7.203-4.27,7,1c-0.5,13,7,7,8,11.5c8.75-1,0-14.75,10.75-14c2.755,0.192,2.75-1.25,7.25-1.75s5-8.5,4.334-11.387s4.416-2.613,7.416-5.363s6-6,9-6.5s5.75-8.5,5-11.5c-0.551-2.204,1.523-4.725,2.869-6.963C466.153,152.773,463.66,151.592,461.5,149z"/>
                <path id="iejs29" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M397.667,609.501c-1-3.167-6.333,3.167-8.333,0.667s-7.001,1.184-6.834-1.575s-2.167-1.759-4.5-9.092s-10.166-3.666-11.666-12C364.667,589.835,360,589,359,590.667s-4-1-7,0.833s-8.333-4.333-11.5-0.667S330.167,589.5,328.167,593s-7.667,0.333-6,5.5s-1.833,4.5-0.833,8.833s3.666,2,4.345,4.69s-2.845,6.144-4.345,4.644s-3.667,1.333-6-0.334c-2.334-1.667-5.5,2-7.334-0.833s-6-0.167-7.667-1.25s-3.667-4.417-4.708,0s-10.292,1.083-11.458,3.083s-2.333,2.5-3.667,5s-2-0.166-2,5.5s7.667,7.834,10.167,11.5s8,1.5,8.167,4.667s2.5,1.833,2.5,4.833s2.333,2,4.665,7s6.336,1.334,8.752,4.763c1.125-1.779,1.25-0.721,4.25-0.08s1.625-2.766,3.5-2.516s1.875,2.125,5.125,2.5s3.625-6,7.625-4.625s5-4.625,7.75-4.875s1.125-5.25,1.125-7.125s4.375-2.375,4.875-4.75s-4.75,1.875-4.625,0s-1.875-2.25-3.75-2.625s-3.75-3.625-1-3.125s1.625-2.75,4.5-1.875s-0.875,2.625,2.75,3.375s3.25-5.625,7.875-4.625s5.625-4.625,7.25-4.25s3.5-2.5,6.625-1.875S374.5,622.75,377,624s5.5,0.25,8.625,0.25s1.875-2.875,3.375-2.875s1.625-3.75,3.375-3s3.25-2.5,4.75,0.125s-0.375,0.625-1.875,5s6.625,3,9.25,3s3-3.375,2.244-4s-2.119-0.625,0-2.75s0.381-3.75,1.506-5.5C405.667,610.501,398.667,612.668,397.667,609.501z"/>
                <path id="iejs30" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M361.09,322.25c-1.59,2.25,3.66,5.5-1.09,7.25s-3.25-10.5-6.75-5s-0.5,5.75-4.25,8s-0.75,9.25-5.5,9s-4.596,2.954-4,5.25c1.75,6.75-6.75,5.5-3,11.5s0.75,8.5-1.75,7.75s-3.303,3.971-6.5,0.13c-2.25-2.703-6.25,2.203-8.583-2.214s-4.167-2.083-7.001-3.749c1,1.833-7.666,3.5-6.832,8.333c0.832,4.833,1.665,3.333,0.832,4.833c-0.832,1.5,3.833,3.455,3,5.395c-0.832,1.939-1.167-1.895-5,1.272c-3.833,3.167-3.666,2.996-5.666-0.502c-1,3.502,0.667,4.336,0,6.669s2.765,3.333,1.799,5.833c-0.965,2.5,2.964,5.165,1.082,8.166c4.882,0.166,4.786-1.666,9.119-1.666s6.166-2.167,11.334-0.834c5.166,1.333,5.5-2.833,7.332-2.833c1.833,0,3.668-1.833,3.168-5.75s5.5-0.75,6.666,1.75s5.167,1.5,3.667,8c-0.758,3.284,1.167,5.5,5,4.667s4.333,0.833,11.167,1.166c6.833,0.333,7.5-8.333,11.5-8.333s2-3,5.833-5.167s3.167-3.833,6.499-7.05c3.333-3.217,5.503,1.384,7.168-4.116c0.677-2.238,6.999-2,6.833-4.5s1-3,4.833-1s3.167-6.167,2-8.333s2.167-3.5,0.667-8.334s1-3.833,4-3s3.667-2.5,1-4s0-10.166-2-10.833s-2.167-4.667-3.833-2.5s0,5.833,0,7.833S400,346,399.5,342.833s-4.333-1.666-7.166-5.333s-10.334-2.833-11.167-5.167s-5.167-3.166-3.833-6.295c1.333-3.129-2.834-3.038-5.834-5.871s-3,0.5-5.5-2.167C364.5,320.75,362.681,320,361.09,322.25z"/>
                <path id="iejs31" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M487.667,511.167c-1-2.5-0.834-6-3.667-7.5s-5.333-1.334-7-1.167s-2.5,3.5-1,4.5s-1.167,3.334,0.5,5.667s-2.167,4.5-3.5,5s-5.167,0.166-6,2.833s-5.667,7.999-10.667,1.333c-1.667,5.166-4.5,3.168-6,6.501s5.667,0.333,2.5,5.167s-10.5-2.167-14,3.333s-2.166,8.5-3.166,10.667s2.833,3.333,1,6.666s-7,0.5-8.167,5.334s-6.5,5.333-8.5,7.167s0,2.166-0.666,3.5s3.833,1,3.833,5.833s-7.667,0.833-6.5,4.667s-3,3.5-3,6.833s-4,6-4.5,9.167s-4,2.666-2.417,5.582c0.125-2.5,1.75-1,1.75,1.125s4.125,1.75,4,4.25s5.5,5.375,3.5,7s1.5,5.625-0.125,6.75s-0.875,3.625,0,2.25s5.75-5.875,7.75-6.142s-1-5.608,1.179-5.858s0.696-1.25,0.071-1.75s3-6.25,4.5-4.125s-2.5,3.5-1.25,5.25s5.625-1.375,7.75-0.75s4.875-1.875,6.125,1.75s6.375,1.875,7.75,3.75s2.75,2.5,5.625,0.5s3.875-0.5,5.403-1.5s4.347,0,7.222,0.625s2.5-2.375,3.75-1.75s-1.625,2.125,1,3.25s3.375-3.625,4.875-4.75s-1.375-3.25,1.125-5.5s-0.125-4.375-1.375-3.75s-4.75-0.125-5-3s-3.5-2.75-3.75-4.75s-3.625-2.25-3.25-3.875s0.375-3-1.5-4.625s-3.75-1.125-2.875-3.75s2.25-0.75,2.25,0.25s1.25,1.375,2.75,3.625s3.25,0,5.25,0s4.375-13.125,6.625-14.625s3.5-7.875,6.125-9s1.875-6.25,5-8.75s4.5-8.375,3-11s-0.375-4.875-2-6.375s-0.875-7.375,0.875-9c1.163-1.08,3.594-5.636,5.425-9.269C493.833,515.5,488.667,513.667,487.667,511.167z"/>
                <path id="iejs32" fill="#EBECED" stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M499.834,426.166c-1.67-1.773-3.167,7.334-3.667,3.483s-4.333-2.316-4.999-4.149s-3.501-0.334-3.834,1.833s-3,3.5-3.667,0.833s-4.667-0.833-6-3.833s-6.333-1.167-9.833-1.833c0.167,6.667-6.052-1.667-7.501,8.5c-0.821,5.764,1,5-0.333,7.833s-6.5,3.667-9.5,9s-5.667,0.833-7.333,4.333s-8.167,9.167-8,12.167S430,470,433.5,472.5s2.334,5.5,4,9s8.334,0.5,10.167,2.538s6.666,0.629,8.666,2.462s4,0.5,6.334-1.667s3.5,0.5,2.333,3.167s0.167,8.333-1.5,12.333s-8.667,1.334-12.333,4S448.5,510,453.5,512.5s-2.167,2.667,2.833,9.333s9.834,1.334,10.667-1.333s4.667-2.333,6-2.833s5.167-2.667,3.5-5s1-4.667-0.5-5.667s-0.667-4.333,1-4.5s4.167-0.333,7,1.167s2.667,5,3.667,7.5s6.166,4.333,8.633,7.564c0.926-1.835,1.697-3.435,2.075-4.231c1.125-2.375-3.5-4.375-0.625-7.25s2.25-8.5,4.875-10.25s2.625-7.125,4.5-8.125s1.625-6.5,3.25-7.75s0.459-2.459,2.626-6.292s0.833-4.167-2.5-7.667s-0.333-14.833,0.333-21s-5.5-10.166-4.5-13.333C503.834,430.833,501.504,427.939,499.834,426.166z"/>
                </g>
                <g id="lakes">
                <path stroke="#FFFFFF" vector-effect="non-scaling-stroke" d="M484.834,148.667c-4.073,4.737-1.667,6.667-3,7.833s-2,3.667,0,3.667s4.667,0,3.667,4.167s-4.357,2.166-4.929,4.333s-2.904,2.333-3.071,3s4,1.167,1.5,2.833s-3.499,2.667-2.333,3.667s3.667,3.167,1,3.5s-3.666,2.5-4.5,1.333s-2.833,2.684-3.5,0.342s-2.333-4.842-3.5-4.508s-4.668-0.833-6.334-0.667s-4.5-2.167-7-2.167s-6.832-1.833-4.166-3.333s-0.501-3.667,2.166-4.833s5.333-4.5,7.5-6.5s0.5-9,0-11.667s-1.833-6.167-1.333-8.5s0.167-5.167,2-7.167s5.5-0.667,5,0.833s-1.333,5.667,1,5.667s2.499,2,5.333,1.667s7.834-0.833,8.667-2.833s2.5,1,5-1.333s6.833,2,5,4.167S486.418,146.824,484.834,148.667z M299.167,183.167c0.833,1.333-3,2.833,0,3.833s6.167-1.167,7.5-0.5s8.833-0.333,9.5,1.833s3.5,2.5,5.5,4.5s4.5,3.833,5.333,5.333s3.5-0.667,5.667,6.5c0.824,2.726,1.833,2.833,3,1.833s-2.667-7-2.833-8.833C332.667,195.833,331.667,193,330,193s-4.166-7.833-3.333-7.833S327.334,182,325.91,182c-1.425,0-2.576-1.833-0.41-4.707s-4.833-1.126-7.666-2.293c-2.834-1.167-2.667,0.333-3.834,2s-4.166,0.667-6.5,1.833s-4.92-0.731-8.333,1.167C297.484,180.936,298.333,181.833,299.167,183.167z M155.833,261.833c0.833,3.833-0.333,2.667-0.833,5s1.667,2,3.667,5s0,4.5-0.833,5.333s5.333,1.833,7.833,2.833s0,0-0.333,2.5s2.167,2.167,3.167,4s1.833-0.833,3.167-2.333s-2.5-5-2.167-7.167s-4.167-3.667-5.295-3.833s-1.538-3.167-2.538-3.833s1.5-1.333,2.333-2.5s-1.273-5.073-3.333-7.5C159.094,257.48,155,258,155.833,261.833z M159.5,326.834c-2.26-0.67-1.833,4-0.667,5.03s0.333,3.303-1,3.303s-1.167,1.843-5.167,1.167s-1.667,6.5-3.724,7.833s-2.443,5.167-4.776,5.833s-1.333,3-4.833,3.167s-7.5,2.333-2.5,1.5s4.5,0.5,6.333,1.167s1,2.833-0.833,3.166s-2.5-0.666-6.667,0.334s-3.667,3.5,0,1.833S140.5,360.5,142,360.5s3.5-1.166,5.5,0.5s5.167,1.334,5.861,0s0.306-3.5,1.306-3.833s1.333-5.333,1-6s0.333-2.667,1.5-2.833s1.833-2.5-2.333-4.667s1.833-5,1.833-6.657s0.5-0.843,1.667-1.343s1.333,3.833,1.333,5s2.667,2.667,3,0s3.5-6.5,2.167-8.333s-3.313,2.541-4.333,1.666C159.333,333,164,328.167,159.5,326.834z M150,366.834c-2-1-3.833,2-7.5,2.5s5,2.333,1.5,2.833s-6-2.5-6.5-1.166s-2.333,1.666,0,3.5s3.5-0.5,5.167,0.833s3.5-0.5,5,0.667s3.667-1,5.167,0.333s-2,2.167,0,5.667s4.833,2.166,5.667,3.666s0.667-2,3.667,0.5s2.5,0.5,7.333,0.756s2.667,0.244,4.167,3.078s-1.333,0.666-1.499,2.666s3.665,2,3.499,4.167s-5.5,3.167-2.167,4.333s1.167,3.834,4.5,5.334s2.333-0.667,4.353-1.834s1.147-4.833-1.853-6.666s-0.167-4.334-1.833-5.167s0-2.833,2.5-2.833s0.833-2.834-3-2.334s-3.833-4.333-6.833-3.666s-0.667-1.167-5.78-2s-1.554-4-0.394-4.834s-0.326-3.833-3.326-4.333s2.253-5.099,0-6C158.5,365.501,152,367.834,150,366.834z M291.667,343.167c-0.5,2.334-5.167-1.834-0.833,7.5c1.177,2.534-5,4.333,0,6.166s1.333,2.667,2.833,3.628s2,0.872,3.333,2.539s-1.833,1,0.167,5.5S297,376,299,379.498s1.833,3.669,5.666,0.502c3.833-3.167,4.168,0.667,5-1.272c0.833-1.939-3.832-3.895-3-5.395c0.833-1.5,0,0-0.832-4.833c-0.834-4.833,7.832-6.5,6.832-8.333s-7.5,1.5-9.666,3.5c-2.167,2-3.833-5.5-2.667-5.834c1.167-0.334-2.833-5-5.214-6s2.214-4.833,0.381-7.166s3.833-4.834,1.5-6C294.312,337.324,292.167,340.833,291.667,343.167z M259.5,469.334c2.176,2.993,1.167,7.667-1.667,7.5s-3,2.834-6,1.667s-3.334-0.166-5.667,1s-5.333,1.5-1.5,3.5s6.667,0.666,5.667,3.666s-6.833,5-5,6.667s0.833,4.333,2.667,4.833s-1-4.333,2.167-4.333s2.333-11.166,5.5-10.833s6,1.535,9,0.768s-4.333-3.435,0-3.935s-2.013-3.501,0.744-4.667s-3.744-8-0.244-10.333s-0.333-6.501,3.667-7.167s1.667-3,5-3s4.167-2.667,1.5-3.5c-1.095-0.342-2.05-0.038-2.956,0.289c-1.301,0.47-2.502,0.987-3.877-0.289c-2.333-2.166-7.333-0.333-4.833,1.667s0,3.667,1.5,4.167s0.5,5.833-1.833,4.833S256.833,465.667,259.5,469.334z"/>
                </g>

                <g id="visnames">
                <text id="iejsvn1" transform="matrix(1 0 0 1 474 113)" font-size="14">Antrim</text>
                <text id="iejsvn2" transform="matrix(1 0 0 1 428 223)" font-size="13">Armagh</text>
                <text id="iejsvn3" transform="matrix(1 0 0 1 406 521)" font-size="14">Carlow</text>
                <text id="iejsvn4" transform="matrix(1 0 0 1 353 286)" font-size="14">Cavan</text>
                <text id="iejsvn5" transform="matrix(1 0 0 1 169 493)" font-size="14">Clare</text>
                <text id="iejsvn6" transform="matrix(1 0 0 1 197 664)" font-size="18">Cork</text>
                <text id="iejsvn7" transform="matrix(1 0 0 1 272 106)" font-size="15">Donegal</text>
                <text id="iejsvn8" transform="matrix(1 0 0 1 500 214)" font-size="14">Down</text>
                <text id="iejsvn9" transform="matrix(1 0 0 1 502 408)" font-size="16">Dublin</text>
                <text id="iejsvn10" transform="matrix(1 0 0 1 299 216)" font-size="13">Fermanagh</text>
                <text id="iejsvn11" transform="matrix(1 0 0 1 196 406)" font-size="17">Galway</text>
                <text id="iejsvn12" transform="matrix(1 0 0 1 95 653)" font-size="16">Kerry</text>
                <text id="iejsvn13" transform="matrix(1 0 0 1 408 435)" font-size="14">Kildare</text>
                <text id="iejsvn14" transform="matrix(1 0 0 1 361 558)" font-size="14">Kilkenny</text>
                <text id="iejsvn15" transform="matrix(1 0 0 1 349 472)" font-size="15">Laois</text>
                <text id="iejsvn16" transform="matrix(1 0 0 1 290 286)" font-size="14">Leitrim</text>
                <text id="iejsvn17" transform="matrix(1 0 0 1 177 565)" font-size="16">Limerick</text>
                <text id="iejsvn18" transform="matrix(1 0 0 1 371 96)" font-size="13">Londonderry</text>
                <text id="iejsvn19" transform="matrix(1 0 0 1 296 338)" font-size="13">Longford</text>
                <text id="iejsvn20" transform="matrix(1 0 0 1 483 295)" font-size="14">Louth</text>
                <text id="iejsvn21" transform="matrix(1 0 0 1 141 305)" font-size="16">Mayo</text>
                <text id="iejsvn22" transform="matrix(1 0 0 1 419 351)" font-size="13">Meath</text>
                <text id="iejsvn31" transform="matrix(1 0 0 1 424 576)" font-size="14">Wexford</text>
                <text id="iejsvn23" transform="matrix(1 0 0 1 378 253)" font-size="13">Monaghan</text>
                <text id="iejsvn24" transform="matrix(1 0 0 1 308 423)" font-size="15">Offaly</text>
                <text id="iejsvn25" transform="matrix(1 0 0 1 223 324)" font-size="13">Roscommon</text>
                <text id="iejsvn26" transform="matrix(1 0 0 1 210 250)" font-size="15">Sligo</text>
                <text id="iejsvn27" transform="matrix(1 0 0 1 279 565)" font-size="16">Tipperary</text>
                <text id="iejsvn28" transform="matrix(1 0 0 1 359 162)" font-size="15">Tyrone</text>
                <text id="iejsvn29" transform="matrix(1 0 0 1 351 647)" font-size="14">Waterford</text>
                <text id="iejsvn30" transform="matrix(1 0 0 1 312 381)" font-size="14">Westmeath</text>
                <text id="iejsvn32" transform="matrix(1 0 0 1 449 467)" font-size="13">Wicklow</text>
                </g>
                <g id="iejspins"></g>
            </svg>
          </div>
        </div>
        <div class="row mb-4 mt-3">
            <div class="col-md-4 mb-2">
                <button class="btn btn-block btn-lg btn-info"><?php TotalSitesAdded()?> Site(s)</button>
            </div>
            <div class="col-md-4 mb-2">
                <button class="btn btn-block btn-lg btn-warning"><?php TotalPlotsAdded()?> Plot(s)</button>
            </div>
            <div class="col-md-4 mb-2">
                <button class="btn btn-block btn-lg btn-dark"><?php TotalTenants()?> Tenant(s)</button>
            </div>
        </div>
      </div>
      <div class="col-md-4">
        <form class="mt-5" action="index.php" method="POST">
                  <?php
                  echo ErrorMessage();
                  echo SuccessMessage();
                  echo ErrorMessageForRg();
                  ?>
              <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" name="emailAddress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>
              <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
              </div>
              <button type="submit" name="Submit" class="btn btn-primary">Log In</button>
          </form>

          <div class="mt-5">
              <div class="text-center" >
                  <p class="">
                      Don't have an account? 
                      <div class="mb-3">
                          <a class="btn text-light btn-info" href="registerUser.php" role="button"> Register</a>
                      </div>

                  </p>
              </div>
          </div>
      </div>
    </div>
  </div><!--container-->
</div><!--end demo-->



<!-- Scroll Top Here -->


<span id="jstip"></span>


<!--scroll-top script-->
<script>
  $(function(){$(document).on( 'scroll', function(){ if ($(window).scrollTop() > 600) {$('.scroll-top').addClass('show');} else {$('.scroll-top').removeClass('show');}});$('.scroll-top').on('click', scrollToTop);});function scrollToTop() {verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;element = $('body');offset = element.offset();offsetTop = offset.top;$('html, body').animate({scrollTop: offsetTop}, 500, 'linear');}
</script>
</body>
</html>