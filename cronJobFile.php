<?php require_once("inc/db.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

        global $ConnectingDB;
        $sql ="SELECT * FROM tenants ";
        $stmt = $ConnectingDB->query($sql);
        $DataRows=$stmt->fetch();
        $tenantFirstName          = $DataRows["tenantFirstName"];
        $tenantLastName           = $DataRows["tenantLastName"];
        $id                       = $DataRows["id"];
        $tenantId                 = $DataRows["tenantId"];
        $tenantEmailAddress       = $DataRows["tenantEmailAddress"];
        $tenantPhoneNum           = $DataRows["tenantPhoneNum"];
        $tenantCity              = $DataRows["tenantCity"];
        $siteId               = $DataRows["siteId"];
        $siteCity               = $DataRows["siteCity"];
        $plotId               = $DataRows["plotId"];
        $plotNumber             = $DataRows["plotNumber"];
        $leaseDate              = $DataRows["leaseDate"];
        $expirationDate         = $DataRows["expirationDate"];
        $renewalStatus          = $DataRows["renewalStatus"];
        $tenantStatus           = $DataRows["tenantStatus"];

        $todayDate = date("Y-m-d ");

        $sql ="SELECT * FROM tenants WHERE '$todayDate' >= '$expirationDate' LIMIT 1 ";
        $stmt = $ConnectingDB->query($sql);
        while($DataRows=$stmt->fetch()){

            $tenantFirstName          = $DataRows["tenantFirstName"];
            $tenantLastName           = $DataRows["tenantLastName"];
            $id                       = $DataRows["id"];
            $tenantId                 = $DataRows["tenantId"];
            $tenantEmailAddress       = $DataRows["tenantEmailAddress"];
            $tenantPhoneNum           = $DataRows["tenantPhoneNum"];
            $tenantCity              = $DataRows["tenantCity"];
            $siteId               = $DataRows["siteId"];
            $siteCity               = $DataRows["siteCity"];
            $plotId               = $DataRows["plotId"];
            $plotNumber             = $DataRows["plotNumber"];
            $leaseDate              = $DataRows["leaseDate"];
            $expirationDate         = $DataRows["expirationDate"];
            $renewalStatus          = $DataRows["renewalStatus"];
            $tenantStatus           = $DataRows["tenantStatus"];


            $sqlTrn = "INSERT INTO formertenants(tenantId, tenantFirstName, tenantLastName, tenantEmailAddress, tenantPhoneNum, tenantCity, siteCity, plotNumber, leaseDate, expirationDate )";
            $sqlTrn .= "VALUES('$tenantId', '$tenantFirstName', '$tenantLastName', '$tenantEmailAddress', '$tenantPhoneNum', '$tenantCity', '$siteCity', '$plotNumber', '$leaseDate', '$expirationDate')";
            $stmtTrn = $ConnectingDB->prepare($sqlTrn);
            $ExecuteTrn=$stmtTrn->execute();

            $sqlCpa = "UPDATE waitinglist SET siteIdNum = '$siteId', plotIdNum = '$plotId', plotNumberApp = '$plotNumber', applicationStatus ='Pending_Confirmation' WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
            $stmtCpa = $ConnectingDB->prepare($sqlCpa);
            $ExecuteCpa=$stmtCpa->execute();

            // Send email to the user on the waiting list
            $sqlSk = "SELECT * FROM waitinglist WHERE applicationStatus = 'Awaiting_Plot' AND userCity = siteCity ORDER BY id ASC LIMIT 1 ";
            $stmtSk = $ConnectingDB->query($sqlSk);
            while ($DataRows=$stmtSk->fetch()) {
            $applicantId             = $DataRows["id"];
            $applicantEmail          = $DataRows["emailAddress"];
            $applicantFirstName      = $DataRows["firstName"];
            }

                $emailTo    = $applicantEmail;
                $subject    = "New Plot Availability Alert";
                $message    = "Hello ".$applicantFirstName."\n"." There is a new plot available for You."
                                ."\n"."Log into Your account below."
                                ."\n\n"."http://allotment-com.stackstaging.com/";

                $headers    = "From: "."Allotment";
                
                mail($emailTo, $subject, $message, $headers);

                $sqlE2 = "UPDATE plots SET plotStatus = 'On_Offer' WHERE plotNumber ='$plotNumber' ";
                $stmtE2 = $ConnectingDB->prepare($sqlE2);
                $ExecuteE2=$stmtE2->execute();

                $sqlUpd = "UPDATE users SET userStatus = 'New_User' WHERE id ='$tenantId' ";
                $stmtUpd = $ConnectingDB->prepare($sqlUpd);
                $ExecuteUpd=$stmtUpd->execute();


        }



?>