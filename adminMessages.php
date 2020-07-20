<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

        
        
    

        $adminSiteName = $_SESSION["adminSiteName"];


?>

    



<!-- Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- header End -->

    <div class="container">
        <div class="row">
            <!-- User Sidebar -->
            <?php include("inc/adminSidebar.php");?>
            <!-- User Sidebar End -->
            <div class="col-md-9">
                <div class="jumbotron mt-5">
                    <div class="mb-3">
                        <a class="btn btn-warning" href="#" role="button">Send Message</a>
                    </div>
                        <?php
                            global $ConnectingDB;
                            $sql ="SELECT * FROM messages WHERE siteName = '$adminSiteName' ORDER BY id DESC ";
                            $stmt = $ConnectingDB->query($sql);
                            while ($DataRows = $stmt->fetch()) {
                                $id                     = $DataRows["id"];
                                
                                $msgFrom          = $DataRows["msgFrom"];
                                $smName          = $DataRows["smName"];
                                $textMessage          = $DataRows["textMessage"];
                                $tenantId          = $DataRows["tenantId"];
                                $textSender         = $msgFrom." (".$smName.")";
                                $dateTime           = $DataRows["datetime"];
                                
                                

                        ?>
                        
                        
                        <div class="card text-white <?php if($msgFrom =="Site Manager"){?> bg-success <?php }else{?>bg-info <?php }?> mb-5">
                        <div class="card-body">
                            <h5 class="card-title"> <?php echo htmlentities($textSender)?></h5>
                            <p class="card-text"><?php echo htmlentities($textMessage)?> </p>

                            <?php if($msgFrom !="Site Manager") {?>
                            <div class="row">
                                <div class="col-md-6">
                                <p class="text-white"><a href=""><a class="btn btn-info" href="adminSendMsg.php?id=<?php echo $tenantId; ?>" role="button">Reply</a></p>
                                </div>
                                <div class="col-md-6 text-right">
                                <p class="card-text"><i><?php echo htmlentities(time_ago( $dateTime )); ?></i></p>
                                </div>
                            </div>
                            <?php }else{?>
                            <div class="row">
                                <div class="col-md-6">
                                <p class="text-white"></p>
                                </div>
                                <div class="col-md-6 text-right">
                                <p class="card-text"><i><?php echo htmlentities(time_ago( $dateTime )); ?></i></p>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div> 
                    <?php }?>
                    
                   
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>