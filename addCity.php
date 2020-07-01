<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

if(isset($_POST["Submit"])){

  date_default_timezone_set("Africa/Lagos");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);

  $cityName               = $_POST["cityName"];
  $cityShortCode          = $_POST["cityShortCode"];
  

  $addedBy                = "Wale Borokini";
  

  if(empty($cityName)){
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("addCity.php");
  }else{
    // Query to insert new city in DB When everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO cities(cityName, cityShortCode, addedBy, datetime)";
    $sql .= "VALUES(:cityNAme, :cityShortCodE, :addeDBy, :dateTIme)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':cityNAme', $cityName);
    $stmt->bindValue(':cityShortCodE', $cityShortCode);
    $stmt->bindValue(':addeDBy', $addedBy);
    $stmt->bindValue(':dateTIme', $DateTime);
    
    $Execute=$stmt->execute();
    if($Execute){
      $_SESSION["SuccessMessage"]="New City added Successfully";
      Redirect_to("addCity.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("addCity.php");
    }
  }
} //Ending of Submit Button If-Condition


?>


<!-- Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- header End -->

<div class="container">
    <div class="mt-4">
        <h1>Add City</h1>
    </div>

            <form action="addCity.php" method="POST">
            <br>
            <?php
                echo ErrorMessage();
                echo SuccessMessage();
                echo ErrorMessageForRg();
            ?>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">City Name</label>
                        <input type="text" name="cityName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">.</small>
                    </div>
                </div>
      
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">City Short Code</label>
                        <input type="text" name="cityShortCode" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">.</small>
                    </div>
                    <!-- Must Be in Caps -->
                </div>
                <button type="submit" name="Submit" class="btn btn-success">Add City</button>

            </form>
            
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>