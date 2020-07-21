<?php $pageTitle = "Admin Messages";?>


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
    
<!-- Admin Footer Start -->
<?php include("inc/adminFooter.php"); ?>
<!-- Admin Footer End -->