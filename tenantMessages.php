<?php $pageTitle = "Messages";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

        $tenantId              = $_SESSION["userId"];
        $tenantFirstName       = $_SESSION["userFirstName"];
        $tenantLastName        = $_SESSION["userLastName"];

        global $ConnectingDB;
        $sql ="SELECT * FROM tenants WHERE tenantId = '$tenantId'  ";
        $stmt = $ConnectingDB->query($sql);
        $DataRows=$stmt->fetch();
        $idRow                     = $DataRows["id"];
        // $userIdRow                     = $DataRows["userId"];
        $tenantFirstName          = $DataRows["tenantFirstName"];
        $tenantLastName          = $DataRows["tenantLastName"];
        $tenantEmailAddress	          = $DataRows["tenantEmailAddress"];
        $tenantPhoneNum          = $DataRows["tenantPhoneNum"];
        $tenantCity           = $DataRows["tenantCity"];
        $siteCity          = $DataRows["siteCity"];
        
        $tenantFullName  = $tenantFirstName." ".$tenantLastName;

    


?>

    



<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
        <div class="row">
            <!-- User Sidebar -->
            <?php include("inc/userSidebar.php");?>
            <!-- User Sidebar End -->
            <div class="col-md-9">
                <div class="jumbotron mt-5">
                    <div class="mb-3">
                        <a class="btn btn-warning" href="tenantSendMsg.php" role="button">Send Message</a>
                    </div>
                        <?php
                            global $ConnectingDB;
                            $sql ="SELECT * FROM messages WHERE userId = '$tenantId' ORDER BY id DESC ";
                            $stmt = $ConnectingDB->query($sql);
                            while ($DataRows = $stmt->fetch()) {
                                $id                     = $DataRows["id"];
                                
                                $msgFrom          = $DataRows["msgFrom"];
                                $smName          = $DataRows["smName"];
                                $textMessage          = $DataRows["textMessage"];
                                $textSender         = $msgFrom." (".$smName.")";
                                $dateTime           = $DataRows["datetime"];
                                
                                

                        ?>
                        
                        
                        <div class="card text-white <?php if($msgFrom =="Site Manager"){?> bg-success <?php }else{?>bg-info <?php }?> mb-5">
                        <div class="card-body">
                            <h5 class="card-title"> <?php echo htmlentities($textSender)?></h5>
                            <p class="card-text"><?php echo htmlentities($textMessage)?> </p>
                            <div class="text-right">
                            <?php if($msgFrom =="Site Manager") {?>
                            <div class="row">
                                <div class="col-md-6 text-left">
                                <p class="text-white"><a href=""><a class="btn btn-success" href="tenantSendMsg.php" role="button">Reply</a></p>
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
                    </div> 
                    <?php }?>
                    
                   
                </div>
            </div>
        </div>
    </div>
   
<!-- Footer Start -->
<?php include("inc/footer.php") ;?>
<!-- Footer End -->