<div class="col-md-3 mt-5">
    <div class="mb-3">
        <a class="btn btn-success" href="adminDashboard99.php" role="button">Dashboard</a>
    </div>
    <div class="mb-3">
        <a class="btn btn-success" href="adminMessages.php" role="button">Messages</a>
    </div>
    <div class="mb-3">
        <a class="btn btn-success" href="inspectionReport.php" role="button">Inspection Report</a>
    </div>
    <div class="mb-3">
        <a class="btn btn-success" href="viewWaitingList.php" role="button">View Waiting List</a>
    </div>
    <div class="mb-3">
        <a class="btn btn-success" href="viewTenants.php" role="button">View Tenants</a>
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
            <a class="btn btn-success" href="addSiteManager.php" role="button">Add Site Manager</a>
        </div>
        <div class="mb-3">
            <a class="btn btn-success" href="#" role="button">View Site Managers</a>
        </div>
        <div class="mb-3">
            <a class="btn btn-success" href="#" role="button">Delete Site Managers</a>
        </div>
        <div class="mb-3">
            <a class="btn btn-success" href="addNewAdmin.php" role="button">Add New Allotment Officer</a>
        </div>
    <?php }?>
    
</div>