<?php require_once("inc/db.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

global $ConnectingDB;
  $sql ="SELECT * FROM waitinglist WHERE applicationStatus ='Awaiting_Plot' AND validationStatus = 'Not_Updated' ";
  $stmt = $ConnectingDB->query($sql);
  while($DataRows=$stmt->fetch()){
    $id                     = $DataRows["id"];
    $tenantId                     = $DataRows["userId"];
    $firstName          = $DataRows["firstName"];
    $emailAddress	          = $DataRows["emailAddress"];
    $telephoneNumber          = $DataRows["telephoneNumber"];
    $plotNumberApp          = $DataRows["plotNumberApp"];
    $applicationStatus          = $DataRows["applicationStatus"];
    $validationStatus          = $DataRows["validationStatus"];
    $dateApplied        =   $DataRows["dateApplied"];
    
    $OneMonthAfterApp         = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dateApplied)). " + 90 day "));
    $todayDate          = date("Y-m-d");

    if($todayDate >= $OneMonthAfterApp && $applicationStatus =='Awaiting_Plot' && $validationStatus == 'Not_Updated'){
        $sqlDel2 = "DELETE FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND validationStatus = 'Not_Updated' AND $todayDate >= $OneMonthAfterApp ";
        $stmtDel2 = $ConnectingDB->prepare($sqlDel2);
        $ExecuteDel2=$stmtDel2->execute();

        echo "User Deleted"."<br>";

    }else{
        echo "No Such User"."<br>";
    }
  
 }


?>