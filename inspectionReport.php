<?php $pageTitle = "Inspection Report";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php 

    // global $ConnectingDB;
    // $sql ="SELECT * FROM waitinglist";
    // $stmt = $ConnectingDB->query($sql);
    // $DataRows=$stmt->fetch();
    // $id1                     = $DataRows["id"];
    // // $userIdRow                     = $DataRows["userId"];
    // $firstName1         = $DataRows["firstName"];
    // $lastName1          = $DataRows["lastName"];
    // $emailAddress1	          = $DataRows["emailAddress"];
    // $telephoneNumber1          = $DataRows["telephoneNumber"];
    // $userCity1          = $DataRows["userCity"];
    // $siteIdNum1           = $DataRows["siteIdNum"];
    // $siteCity1          = $DataRows["siteCity"];
    // $plotIdNum1          = $DataRows["plotIdNum"];
    // $plotNumberApp1          = $DataRows["plotNumberApp"];
    // $offerCount1          = $DataRows["offerCount"];
    // $dateApplied1        =   $DataRows["dateApplied"];
    // $todayDate1          = date("2020-08-15") ;

    // $daysCountFourteen1         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateApplied1)). " + 14 day "));
    
    // $sql13 = "DELETE FROM waitinglist WHERE offerCount1 > 1 AND '$todayDate1' >= '$daysCountFourteen1' ";
    // $stmt13 = $ConnectingDB->prepare($sql13);
    // $Execute13=$stmt13->execute();



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
                <div class="mt-5 mb-5">
                    <h1>Please fill in inspection details correctly!</h1>
                </div>

                <form class="mb-5" action="inspectionReport.php" method="POST">
                    <br>
                    <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                        echo ErrorMessageForRg();
                    ?>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">First Name</label>
                            <input type="text" name="firstName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Last Name</label>
                            <input type="text" name="lastName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="emailAddress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Telephone</label>
                            <input type="text" name="telephone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="exampleInputEmail1">Message</label>
                            <textarea placeholder="Message" name="message" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
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