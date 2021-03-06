<?php $pageTitle = "Site Managers";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

confirmAdminLogin(); 


if($_SESSION["adminRole"] != "Super_Admin"){
    Redirect_to("errorPage.php");
}

?>

<?php if($_SESSION["adminRole"] == "Super_Admin"){?>

    <!-- Admin Header Start -->
    <?php include("inc/adminHeader.php"); ?>
    <!-- Admin Header End -->

        <div class="container"> 
        
            
            <div class="row">
                <!-- Include Admin Sidebar -->
                <?php include("inc/adminSidebar.php");?>
                <!-- Include Admin Sidebar -->    
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-2 mt-5 text-center">
                                <a class="btn btn-success" href="addSiteManager.php" role="button">Add Site Manager</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2 mt-5 text-center">
                                <a class="btn btn-danger" href="deleteSiteManager.php?page=1" role="button">Delete Site Manager</a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3 mb-2">
                        <h1>Site Managers</h1>
                    </div>
                            <br>
                            <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                            echo WarningMessage();
                            echo ErrorMessageForRg();
                            ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">Telephone</th>
                                <th scope="col">Site</th>
                                <th scope="col">Added By</th>
                                <th scope="col">Date Added</th>
                                
                                </tr>
                            </thead>
                            <?php 
                            
                            if (isset($_GET["page"])) {
                                global $ConnectingDB;
                                $sql = "SELECT * FROM admins WHERE adminRole ='Site_Manager' ORDER BY id ";
                                $stmt = $ConnectingDB->prepare($sql);
                                $stmt->execute();
                                $Page = $_GET["page"];
                                if($Page==0||$Page<1){
                                $ShowPostFrom=0;
                            }else{
                                $ShowPostFrom=($Page*10)-10;
                            }
                                $sql = "SELECT * FROM admins WHERE adminRole = 'Site_Manager' ORDER BY id LIMIT $ShowPostFrom,10";
                                $stmt=$ConnectingDB->query($sql);
                            }

                            // The default SQL query
                            else{
                                $sql  = "SELECT * FROM admins WHERE adminRole = 'Site_Manager' ORDER BY id LIMIT $ShowPostFrom,10";
                                $stmt =$ConnectingDB->query($sql);
                            }
                            $SrNo = 0;
                            while ($DataRows=$stmt->fetch()) {
                            $id                 = $DataRows["id"];
                            $firstName          = $DataRows["firstName"];
                            $lastName           = $DataRows["lastName"];
                            $emailAddress       = $DataRows["emailAddress"];
                            $telephone          = $DataRows["telephone"];
                            $homeAddress        = $DataRows["homeAddress"];
                            $siteName           = $DataRows["siteName"];
                            $gender             = $DataRows["gender"];
                            $password           = $DataRows["password"];
                            $adminRole          = $DataRows["adminRole"];
                            $addedBy            = $DataRows["addedBy"];
                            $datetime           = $DataRows["datetime"];
                            $fullName           = $firstName." ".$lastName;
                            
                            $SrNo++;
                            
                            ?>
                            <tbody>
                            
                                <tr>
                                <td><?php echo htmlentities($id)?></td>
                                <td><?php echo htmlentities($fullName)?></td>
                                <td><?php echo htmlentities($gender)?></td>
                                <td><?php echo htmlentities($emailAddress)?></td>
                                <td><?php echo htmlentities($telephone)?></td>
                                <td><?php echo htmlentities($siteName)?></td>
                                <td><?php echo htmlentities($addedBy)?></td>
                                <td><?php echo htmlentities($datetime)?></td>
                                </tr>
                            </tbody>
                            <?php }?>
                        </table>

                        <!-- Pagination -->
                        <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-12 mt-4">
                            <nav>
                                <ul class="pagination pagination-lg">
                                        <!-- Creating Backward Button -->
                                        <?php if( isset($Page) ) {
                                        if ( $Page>1 ) {?>
                                    <li class="page-item">
                                        <a class="page-link text-dark" href="viewSiteManagers.php?page=<?php  echo $Page-1; ?>">
                                        <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                        <?php } }?>
                                        <?php
                                        global $ConnectingDB;
                                        $sql           = "SELECT COUNT(*) FROM admins WHERE adminRole ='Site_Manager'";
                                        $stmt          = $ConnectingDB->query($sql);
                                        $RowPagination = $stmt->fetch();
                                        $TotalPosts    = array_shift($RowPagination);
                                        // echo $TotalPosts."<br>";
                                        $PostPagination=$TotalPosts/10;
                                        $PostPagination=ceil($PostPagination);
                                        // echo $PostPagination;
                                        for ($i=1; $i <=$PostPagination ; $i++) {
                                        if( isset($Page) ){
                                            if ($i == $Page) { ?>
                                    <li class="page-item active">
                                        <a class="page-link bg-dark" href="viewSiteManagers.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php
                                        }else {
                                        ?>
                                    <li class="page-item">
                                        <a class="page-link" href="viewSiteManagers.php?page=<?php  echo $i; ?>"><?php  echo $i; ?></a>
                                    </li>
                                        <?php  }
                                        } } ?>
                                    
                                        <!-- Creating Forward Button -->
                                        <?php if ( isset($Page) && !empty($Page) ) {
                                            if ($Page+1 <= $PostPagination) {?>
                                    <li class="page-item">
                                        <a class="page-link bg-dark text-white" href="viewSiteManagers.php?page=<?php  echo $Page+1; ?>">
                                        <span aria-hidden="true">&raquo;</span>
                                        </a> 
                                    </li>
                                        <?php } }?>
                                </ul>
                            </nav>
                        </div>
                        <!-- Pagination Ends -->
                
                </div>
            </div>
            
            
        </div>

    <!-- Admin Footer Start -->
    <?php include("inc/adminFooter.php"); ?>
    <!-- Admin Footer End -->

<?php

}else{
    Redirect_to("errorPage.php");
} 

?>