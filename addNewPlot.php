<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

if(isset($_POST["Submit"])){
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime        =time();
    $dateCreated        =strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);
    $dateLastModified  =        strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);
    $plotNumber                 = plotNameGen(10);
    $plotSize                 = $_POST["plotSize"];
    $plotDescription          = $_POST["plotDescription"];
    $plotSite                 = $_POST["plotSite"];
    
    
    $addedBy                  = $_SESSION["adminFirstName"]." ".$_SESSION["adminLastName"] ;
    

  
  

  if(empty($plotDescription)){
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("addNewPlot.php");
  }else{
    // Query to insert new Plot in DB When everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO plots(plotNumber, plotSize, plotDescription, plotSite, addedBy, dateCreated, dateLastModified )";
    $sql .= "VALUES( :plotNumbeR, :plotSizE, :plotDescriptioN, :plotSitE, :addedBY, :dateCreateD, :dateLastModifieD )";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':plotNumbeR', $plotNumber);
    $stmt->bindValue(':plotSizE', $plotSize);
    $stmt->bindValue(':plotDescriptioN', $plotDescription);
    $stmt->bindValue(':plotSitE', $plotSite);
    $stmt->bindValue(':addedBY', $addedBy);
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
                        <input type="text" name="plotSize" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Plot Description</label>
                        <input type="text" name="plotDescription" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Plot Site</label>
                        <select name="plotSite" class="custom-select">
                            <?php
                            //Fetching all cities from table
                            global $ConnectingDB;
                            $sql = "SELECT id, cityName FROM cities";
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
                <div class="row">
                
                

                
                <button type="submit" name="Submit" class="btn btn-success">Register</button>

            </form>
            


</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>