<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php 





// echo date("d-F-Y ");



        

// $leaseDate              = strtotime("d-F-Y");
// $date=date_create($leaseDate);
// date_add($date,date_interval_create_from_date_string("1 years"));
// echo date_format($date,"d-F-Y");


        $leaseDate              = date("d-F-Y ");

         

        $date=date_create($leaseDate);
        date_add($date,date_interval_create_from_date_string("1 years"));
        $expirationDate = date_format($date,"d-F-Y");
        echo $expirationDate;

?>