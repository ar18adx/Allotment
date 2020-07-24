<?php $pageTitle = "Inspection Report";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php 

    if(isset($_POST["Send"])){
        date_default_timezone_set("Africa/Lagos");
        $CurrentTime                 =time();
        $inspectionDate              =strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);
        $plotNumber                  = $_POST["plotNumber"];
        $inspectionReport            = $_POST["inspectionReport"];
        $inspectionOfficer           = $_SESSION["adminFirstName"]." ".$_SESSION["adminLastName"];
        

        
        global $ConnectingDB;
        $sql    = "SELECT tenantFirstName, tenantLastName, siteCity FROM tenants WHERE plotNumber ='$plotNumber' ";
        $stmt   = $ConnectingDB->prepare($sql);
        // $stmt->bindValue(':plotNumbeR',$plotNumber);
        $stmt->execute();
        $DataRows = $stmt->fetch();
        $id                     = $DataRows["id"];
        $tenantFnRow              = $DataRows["tenantFirstName"];
        $tenantLnRow              = $DataRows["tenantLastName"];
        $siteCityRow              = $DataRows["siteCity"];

        $tenantFirstName       = $tenantFnRow;
        $tenantLastName         = $tenantLnRow;
        $adminId                = $_SESSION["adminId"];
        $siteCity               = $siteCityRow;

        $evidence        = $_FILES['evidence']['tmp_name'];
                    foreach($_FILES['evidence']['name'] as $i => $name) {
                        $name = $_FILES['evidence']['name'][$i];
                        $size = $_FILES['evidence']['size'][$i];
                        $type = $_FILES['evidence']['type'][$i];
                        $tmp = $_FILES['evidence']['tmp_name'][$i];

                        $explode = explode('.', $name);

                        $ext = end($explode);
                        $updatdName = $explode[0] . time() .'.'. $ext;
                        $path = 'Uploads/Reports/';
                        $path = $path . basename( $updatdName );

                            if(empty($_FILES['evidence']['tmp_name'][$i])) {
                                $_SESSION["ErrorMessage"] = 'Please choose at least 1 file to be uploaded.';
                                Redirect_to("inspectionReport.php");

                            }else {

                                $allowed = array('jpg','jpeg','gif','bmp','png', 'PNG');

                                $max_size = 6000000; // 6MB

                                if(in_array($ext, $allowed) === false) {
                                    $_SESSION["ErrorMessage"] = 'The file '.$name.' extension is not allowed.';
                                    Redirect_to("inspectionReport.php");
                                }

                                if($size > $max_size) {
                                    $_SESSION["ErrorMessage"] = 'The file '.$name.'size is too high.';
                                    Redirect_to("inspectionReport.php");
                                }
                    }

                            if(empty($errors)) {

                                // if there is no error then set values
                                $evidence['evidence'][] = $updatdName;
                                $errors = array();
                                if(!file_exists('Uploads/Reports/')) {
                                    mkdir('Uploads/Reports/', 0777);
                                }

                                if(move_uploaded_file($tmp, $path)) {
                                    // echo '<p>The file <b>'.$name.'</b> successful upload</p>';
                                }else {
                             //        echo 'Something went wrong while uploading 
                             // <b>'.$name.'</b>';
                                }

                            }else {
                                foreach($errors as $error) {
                                    echo '<p>'.$error.'<p>';
                                }
                            }

                        }

                        if(!empty($evidence)) {

                            $evidence['evidence'][] = $updatdName;
                            $evidence = implode(',', $evidence['evidence']);
                        }


        if(empty($plotNumber)){
            $_SESSION["ErrorMessage"]= "All fields must be filled out";
            Redirect_to("inspectionReport.php");
        }elseif (CheckPlotNumExistsOrNot($plotNumber)) {
            $_SESSION["ErrorMessage"]= "Plot Number Does Not Exists.!! ";
            Redirect_to("inspectionReport.php");
        }else{
            // Query to insert new Plot in DB When everything is fine
            global $ConnectingDB;
            $sql = "INSERT INTO inspectionreport(siteName, plotNumber, inspectionDate, tenantFirstName, tenantLastName, adminId, inspectionOfficer, inspectionReport, evidence)";
            $sql .= "VALUES( '$siteCity', :plotNumbeR, '$inspectionDate', '$tenantFirstName', '$tenantLastName', '$adminId', '$inspectionOfficer', '$inspectionReport', '$evidence' )";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':plotNumbeR', $plotNumber);
            
            
            
            $Execute=$stmt->execute();
            if($Execute){
            $_SESSION["SuccessMessage"]="Inspection Report was Successfully Sent";
            Redirect_to("inspectionReport.php");
            }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("inspectionReport.php");
            }
        }
    } //Ending of Submit Button If-Condition
   



?>


<!-- Admin Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- Admin Header End -->

    <div class="container"> 
    
        
        <div class="row">
            <!-- Include Admin Sidebar -->
            <?php include("inc/adminSidebar.php");?>
            <!-- Include Admin Sidebar -->    
            <div class="col-md-9">
                <div class="text-center mt-5 mb-2">
                    <a class="btn btn-success" href="viewInspectionReports.php?page=1" role="button">View Inspection Reports</a>
                </div>
                <div class="mt-5 mb-2">
                    <h1>Please fill in inspection details correctly!</h1>
                </div>

                <form class="mb-5" action="inspectionReport.php" method="POST" enctype="multipart/form-data" >
                    <br>
                    <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                        echo ErrorMessageForRg();
                    ?>
                    
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Plot Number</label>
                            <input type="text" name="plotNumber" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text text-muted">Please enter a correct plot Number.</small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Evidence</label>
                            <input type="file" name="evidence[]" class="form-control-file" id="exampleFormControlFile1" multiple>
                            <small id="emailHelp" class="form-text text-muted">Choose a picture or video file.</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="exampleInputEmail1">Inspection Report</label>
                            <textarea placeholder="Inspection Report" name="inspectionReport" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                    </div>
                    
                
                    <button type="submit" name="Send" class="btn btn-success">Send</button>

                </form>
            </div>
        </div>
        
        
    </div>

<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->