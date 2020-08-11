<?php $pageTitle = "Add New Plot";?>

<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
confirmAdminLogin(); 

?>
    

<?php

    
$adminCity = $_SESSION["adminSiteName"];

if(isset($_POST["Submit"])){
    $adminCity = $_SESSION["adminSiteName"];
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime                 =time();
    $dateCreated                =strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);
    $dateLastModified           =        strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);
    $plotNumber                 = plotNameGen(10);
    $plotSize                   = $_POST["plotSize"];
    $plotDescription            = $_POST["plotDescription"];
    if($_SESSION["adminRole"] == "Super_Admin"){
        $plotSite                 = $_POST["plotSite"];
    }elseif($_SESSION["adminRole"] == "Site_Manager"){
        $plotSite               = $adminCity;
    }
    $plotStatus                 = "Vacant";
    
    global $ConnectingDB;
    $sql    = "SELECT id FROM cities WHERE cityName=:plotSitE";
    $stmt   = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':plotSitE',$plotSite);
    $stmt->execute();
    $DataRows = $stmt->fetch();
    $cityId              = $DataRows["id"];
    $cityName          = $DataRows["cityName"];
    
    $addedBy                  = $_SESSION["adminFirstName"]." ".$_SESSION["adminLastName"] ;
    $siteIdNum                = $cityId ;
    

  
  

  if(empty($plotDescription) ||empty($plotSize)){
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("addNewPlot.php");
  }else{
    // Query to insert new Plot in DB When everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO plots(plotNumber, plotSize, plotDescription, plotSite, plotStatus, addedBy, siteIdNum, dateCreated, dateLastModified )";
    $sql .= "VALUES( :plotNumbeR, :plotSizE, :plotDescriptioN, :plotSitE, :plotStatuS, :addedBY, :siteIdNuM, :dateCreateD, :dateLastModifieD )";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':plotNumbeR', $plotNumber);
    $stmt->bindValue(':plotSizE', $plotSize);
    $stmt->bindValue(':plotDescriptioN', $plotDescription);
    $stmt->bindValue(':plotSitE', $plotSite);
    $stmt->bindValue(':plotStatuS', $plotStatus);
    $stmt->bindValue(':addedBY', $addedBy);
    $stmt->bindValue(':siteIdNuM', $siteIdNum);
    $stmt->bindValue(':dateCreateD', $dateCreated);
    $stmt->bindValue(':dateLastModifieD', $dateLastModified);
    
    $Execute=$stmt->execute();
    if($Execute){
      $_SESSION["SuccessMessage"]="New Plot added Successfully";
      Redirect_to("addNewPlot.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("addNewPlot.php");
    }
  }
} //Ending of Submit Button If-Condition


?>



<!-- Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- header End -->

<div class="container">
    <div class="row">
        <!-- Include Admin Sidebar -->
        <?php include("inc/adminSidebar.php");?>
        <!-- Include Admin Sidebar -->
        <div class="col-md-9">
            <div class="mt-4 mb-4">
                <h1>Add New Plot</h1>
            </div>
            <form class="mb-4 mt-4" action="addNewPlot.php" method="POST">
                <br>
                <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                    echo ErrorMessageForRg();
                ?>
                <!-- <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Plot Number</label>
                        <input type="text" name="plotNumber" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                </div> -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Plot Size</label>
                        <input type="text" name="plotSize" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Plot Description</label>
                        <input type="text" name="plotDescription" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>
                </div>
                <?php if($_SESSION["adminRole"] == "Super_Admin"){?>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Plot Site</label>
                            <select name="plotSite" class="custom-select">
                                <?php
                                //Fetching all cities from table
                                global $ConnectingDB;
                                $sql = "SELECT id, cityName FROM cities ORDER BY cityName";
                                $stmt = $ConnectingDB->query($sql);
                                while ($DataRows = $stmt->fetch()) {
                                $Id = $DataRows["id"];
                                $cityName = $DataRows["cityName"];
                                ?>
                                <option> <?php echo $cityName; ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                <?php }?>
                <div class="row">
                    <button type="submit" name="Submit" class="btn btn-success">Add Plot</button>
                </div>

            </form>
        </div>  
    </div>
</div>
   
<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->