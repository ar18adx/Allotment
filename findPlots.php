<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>




<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
    
        <h1>Hello, world!</h1>
                    <br>
                    <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                    echo ErrorMessageForRg();
                    ?>

        <div class="row">
        <?php
            
            global $ConnectingDB;
            $userCity = $_SESSION["userCity"];
            $sql ="SELECT * FROM plots WHERE plotSite ='$userCity'";
            $stmt = $ConnectingDB->query($sql);
            while ($DataRows=$stmt->fetch()) {
            $id                     = $DataRows["id"];
            $plotNumber          = $DataRows["plotNumber"];
            $plotDescription         = $DataRows["plotDescription"];
            $plotSize         = $DataRows["plotSize"];
            $plotSite         = $DataRows["plotSite"];
                    
        ?> 

        <?php

        if(isset($_POST["Apply"])){
            date_default_timezone_set("Africa/Lagos");
            $CurrentTime            =  time();
            $dateApplied               = strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);
            $userId                 =   $_SESSION["userId"];
            $firstName               = $_SESSION["userFirstName"];
            $lastName               = $_SESSION["userLastName"];
            $emailAddress           = $_SESSION["userEmailAddress"];
            $telephoneNumber               = $_SESSION["userTelephone"];
            $userCity               = $_SESSION["userCity"];
            $siteCity               = $plotSite;
            $plotNumberApp          = $plotNumber;
            $applicationStatus      = "Pending";
            
            
            // Query to insert records in DB When everything is fine
            global $ConnectingDB;
            $sql = "INSERT INTO waitinglist( userId, firstName, lastName, emailAddress, telephoneNumber, userCity, siteCity, plotNumberApp, applicationStatus, dateApplied )";
            $sql .= "VALUES(:userID, :firstNamE, :lastNamE, :emailAddresS, :telephoneNumbeR, :userCitY, :siteCitY, :plotNumberApP, :applicationStatuS, :dateApplieD  )";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':userID', $userId);
            $stmt->bindValue(':firstNamE', $firstName);
            $stmt->bindValue(':lastNamE', $lastName);
            $stmt->bindValue(':emailAddresS', $emailAddress);
            $stmt->bindValue(':telephoneNumbeR', $telephoneNumber);
            $stmt->bindValue(':userCitY', $userCity);
            $stmt->bindValue(':siteCitY', $siteCity);
            $stmt->bindValue(':plotNumberApP', $plotNumberApp);
            $stmt->bindValue(':applicationStatuS', $applicationStatus);
            $stmt->bindValue(':dateApplieD', $dateApplied);
            
            $Execute=$stmt->execute();
            if($Execute){
            $_SESSION["SuccessMessage"]="Application For Plot Was Successful";
            Redirect_to("findPlots.php");
            }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("findPlots.php");
            }

        } //Ending of Submit Button If-Condition


        ?>


            <div class="col-sm-4 mb-4">
                <div class="card">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                       
                        <h5 class="card-title"><b>Plot Number :</b> <?php echo htmlentities($plotNumber); ?></h5>
                        <h5 class="card-title"><b>Plot Site :</b> <?php echo htmlentities($plotSite); ?> </h5>
                        <h5 class="card-title"><b>Plot Size :</b> <?php echo htmlentities($plotSize); ?></h5>
                        <p class="card-text"><b>Plot Description :</b> <?php echo htmlentities($plotDescription); ?></p>

                        <form action="findPlots.php" method="POST">
                        <!-- <a href="#" class="btn btn-primary">Apply For Plot</a> -->
                        <button type="submit" name="Apply" class="btn btn-primary">Apply For Plot</button>

                        </form>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>

        <div class="mt-5">
            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>