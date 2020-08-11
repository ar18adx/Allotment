<?php require_once("inc/db.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

        global $ConnectingDB;
        $sql ="SELECT * FROM tenants";
        $stmt = $ConnectingDB->query($sql);
        while($DataRows=$stmt->fetch()){
        $id                     = $DataRows["id"];
        $tenantId                     = $DataRows["tenantId"];
        $tenantLastName          = $DataRows["tenantLastName"];
        $tenantEmailAddress	          = $DataRows["tenantEmailAddress"];
        $plotNumber          = $DataRows["plotNumber"];
        $leaseDate          = $DataRows["leaseDate"];
        $expirationDate          = $DataRows["expirationDate"];
        $renewalStatus          = $DataRows["renewalStatus"];

        $oneMonthToExp        = date("Y-m-d", strtotime(date("Y-m-d", strtotime($expirationDate)). " - 30 day "));
        $todayDate          = date("Y-m-d");

            if($todayDate >= $oneMonthToExp){
                $sqlSv = "UPDATE plots SET plotStatus = 'Soon_Vacant' WHERE plotNumber ='$plotNumber' ";
                $stmtSv = $ConnectingDB->prepare($sqlSv);
                $ExecuteSv=$stmtSv->execute();

                echo "Plot Status Updated"."<br>";

            }else{
                echo "No Lease will expire soon"."<br>";
            }

            
        
        }



?>