<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>


<!-- Admin Header Start -->
<?php include("inc/adminHeader.php"); ?>
<!-- Admin Header End -->

    <div class="container"> 
    
        <h1 class="mb-5">Hello, <?php echo $_SESSION["adminFirstName"]." ".$_SESSION["adminLastName"] ;?></h1>
        <div class="row">
            <!-- Include Admin Sidebar -->
            <?php include("inc/adminSidebar.php");?>
            <!-- Include Admin Sidebar -->    
            <div class="col-md-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5 mb-5">
                    <div class="col-sm-6">
                        <div class="card text-white text-white bg-danger">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card text-white bg-dark">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>