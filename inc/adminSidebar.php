<div class="col-md-3 mt-5">
    <div class="mb-3">
        <a class="btn btn-success" href="adminDashboard.php" role="button">Dashboard</a>
    </div>
    <div class="mb-3">
        <a class="btn btn-success" href="adminMessages.php" role="button">Messages<span class="badge badge-light"><?php TotalUnreadMsgSm()?></span></a>
    </div>
    <div class="mb-3">
        <a class="btn btn-success" href="inspectionReport.php" role="button">Inspection Report</a>
    </div>
    <div class="mb-3">
        <a class="btn btn-success" href="viewWaitingList.php?page=1" role="button">Waiting List</a>
    </div>
    <div class="mb-3">
        <a class="btn btn-success" href="viewTenants.php?page=1" role="button">Tenants</a>
    </div>
    <div class="mb-3">
        <a class="btn btn-success" href="assignPlot.php?page=1" role="button">Assign Plot</a>
    </div>

    <?php if($_SESSION["adminRole"] == "Site_Manager"){?>
    <div class="mb-3">
        <a class="btn btn-success" href="plotDetails.php?page=1" role="button">Plots</a>
    </div>
    <?php }?>
    
    <?php if($_SESSION["adminRole"] == "Super_Admin"){?>
        <div class="mb-3">
            <a class="btn btn-success" href="viewSites.php?page=1" role="button">Sites</a>
        </div>
        <div class="mb-3">
            <a class="btn btn-success" href="viewSiteManagers.php?page=1" role="button">Site Managers</a>
        </div>
        <div class="mb-3">
            <a class="btn btn-success" href="viewAllotmentOfficers.php?page=1" role="button">Allotment Officers</a>
        </div>
    <?php }?>
    
</div>