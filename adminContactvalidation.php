<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

    // date_default_timezone_set("Africa/Lagos");
    // $CurrentTime            =  time();
    // $datetime               = strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);

           
        global $ConnectingDB;
        $sql ="SELECT * FROM waitinglist ";
        $stmt = $ConnectingDB->query($sql);
        while ($DataRows=$stmt->fetch()){;
        $id                     = $DataRows["id"];
        $emailAddress[]       = $DataRows["emailAddress"];

        }
            $emailTo    = implode(", ", $emailAddress);
            $subject    = "Contact And Interest Validation";
            $message    = "Please click on the link below to update Your contact details"
                            ."\n\n"."http://allotment-com.stackstaging.com/userContactVald.php";
            $headers    = "From: "."Allotment";

            

        if(mail($emailTo, $subject, $message, $headers)){
            $_SESSION["SuccessMessage"]="Message was sent Successfully";
            Redirect_to("viewWaitingList.php?page=1");
        }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("viewWaitingList.php?page=1");
        }

?>
        
    


