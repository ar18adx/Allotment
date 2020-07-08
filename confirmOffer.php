<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

    <?php

    $userId                 =   $_SESSION["userId"];

    global $ConnectingDB;
    $sql ="SELECT * FROM waitinglist WHERE userId = '$userId'  ";
    $stmt = $ConnectingDB->query($sql);
    $DataRows=$stmt->fetch();
    $id                     = $DataRows["id"];
    $userIdRow                     = $DataRows["userId"];
    $firstName          = $DataRows["firstName"];
    $lastName          = $DataRows["lastName"];
    $emailAddress	          = $DataRows["emailAddress"];
    $telephoneNumber          = $DataRows["telephoneNumber"];
    $userCity          = $DataRows["userCity"];
    $siteCity          = $DataRows["siteCity"];
    $plotNumberApp          = $DataRows["plotNumberApp"];
    $applicationStatus	          = $DataRows["applicationStatus"];
    $offerCount          = $DataRows["offerCount"];
    $dateApplied          = $DataRows["dateApplied"];

    ?>


<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
    
        <h1>Hello, <?php echo $_SESSION["userFirstName"]; ?> !</h1>
        <h3>You have been allocated Plot "<?php echo htmlentities($plotNumberApp);?>" in "<?php echo htmlentities($siteCity); ?>" Site. If you are OK with this. You have 14 days to ACCEPT or REJECT the offer.</p>
                    <br>
                    <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                    echo ErrorMessageForRg();
                    ?>
        <form action="applyForPlots.php" method="POST">
            <div class="row">
                <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Accept</label>
                        <div class="">
                            <button type="submit" name="Accept" class="btn btn-success">Apply</button>
                        </div>
                </div>
                <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Reject</label>
                        <div class="">
                            <button type="submit" name="Reject" class="btn btn-success">Apply</button>
                        </div>
                </div>
            </div>
        </form>

    

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>