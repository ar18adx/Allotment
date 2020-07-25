<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php 

// $sql04 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity != siteCity ";
// $stmt04 = $ConnectingDB->prepare($sql04);
// $stmt04->execute();
// $Result04 = $stmt04->rowcount();

// echo $Result04

        $sql04 ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND userCity = siteCity ";
        $stmt04 = $ConnectingDB->prepare($sql04);
        $stmt04->execute();
        $Result04 = $stmt04->rowcount();
        echo $Result04;


// echo date("d-F-Y ");



        

// $leaseDate              = strtotime("d-F-Y");
// $date=date_create($leaseDate);
// date_add($date,date_interval_create_from_date_string("1 years"));
// echo date_format($date,"d-F-Y");


        // $leaseDate              = date("d-F-Y ");

         

        // $date=date_create($leaseDate);
        // date_add($date,date_interval_create_from_date_string("1 years"));
        // $expirationDate = date_format($date,"d-F-Y");
        // echo $expirationDate;

        // echo date("Y-M-d");

        // $start_date = date_create("2016-01-02");
        // $end_date   = date_create("2016-01-21");
        
        // //difference between two dates
        // $diff = date_diff($start_date,$end_date);
        
        // //find the number of days between two dates
        // echo "Difference between two dates: ".$diff->format("%a"). " Days ";

?>