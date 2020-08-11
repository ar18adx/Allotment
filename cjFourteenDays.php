<?php require_once("inc/db.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

        global $ConnectingDB;
        $sql ="SELECT * FROM waitinglist WHERE applicationStatus ='Pending_Confirmation' LIMIT 1";
        $stmt = $ConnectingDB->query($sql);
        while($DataRows=$stmt->fetch()){
        $id                     = $DataRows["id"];
        $tenantId              = $DataRows["userId"];
        $firstName          = $DataRows["firstName"];
        $lastName          = $DataRows["lastName"];
        $emailAddress	          = $DataRows["emailAddress"];
        $telephoneNumber          = $DataRows["telephoneNumber"];
        $userCity          = $DataRows["userCity"];
        $siteIdNum           = $DataRows["siteIdNum"];
        $siteCity          = $DataRows["siteCity"];
        $plotIdNum          = $DataRows["plotIdNum"];
        $plotNumberApp          = $DataRows["plotNumberApp"];
        $applicationStatus          = $DataRows["applicationStatus"];
        $offerCount          = $DataRows["offerCount"];
        $dateApplied        =   $DataRows["dateApplied"];
        $dateRecvRow        =   $DataRows["dateRecv"];
        $dateRecv               = date("Y-m-d");

        $daysCountFourteen         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateRecvRow)). " + 14 day "));
        
        $todayDate = date("Y-m-d");

        }
        



    if(!empty($tenantId) && $todayDate >= $daysCountFourteen && $offerCount <1 && $applicationStatus =='Pending_Confirmation'){

        // Fourteen days count function for a user Who does not accept the plot within 14 days and Offercount is LESS than 1
        fourteenDaysCountLess1();
        
    }elseif(!empty($tenantId) && $todayDate >= $daysCountFourteen && $offerCount >=1 && $applicationStatus =='Pending_Confirmation'){
       // Fourteen days count function for a user Who does not accept the plot within 14 days and Offercount is LESS than 1
        fourteenDaysCountGt1();

    }else{
        echo "No Expired Application";
    }



?>