<?php $pageTitle = "Contact Us";?>

<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

if(isset($_POST["Send"])){
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime            =  time();
    $datetime               = strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);
    $firstName               = $_POST["firstName"];
    $lastName               = $_POST["lastName"];
    $emailAddress           = $_POST["emailAddress"];
    $telephone               = $_POST["telephone"];
    $subjectMsg               = $_POST["subjectMsg"];
    $textMessage               = $_POST["textMessage"];



    if(empty($firstName) ||empty($lastName) ||empty($emailAddress) ||empty($telephone) ||empty($subjectMsg) ||empty($textMessage)){
        $_SESSION["ErrorMessage"]= "All fields must be filled out";
        Redirect_to("contact.php");
    }else{

            // $emailTo    = "";
            // $subject    = $subjectMsg;
            // $message    = "First Name: ".$firstName."\n"."Last Name: ".$lastName."\n"."Phone Number: ".$telephone."\n"." Wrote The Following: "." \n\n".$textMessage;
            // $headers    = "From: ".$emailAddress;

            // mail($emailTo, $subject, $message, $headers);

        // Query to insert new city in DB When everything is fine
        global $ConnectingDB;
        $sql = "INSERT INTO contactmessages(firstName, lastName, emailAddress, telephone, subjectMsg, textMessage, dateTime )";
        $sql .= "VALUES(:firstNAme, :lastNAme, :emailADdress, :telePhone, :subjectMsG, :textmessaGe, :dateTIme)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':firstNAme', $firstName);
        $stmt->bindValue(':lastNAme', $lastName);
        $stmt->bindValue(':emailADdress', $emailAddress);
        $stmt->bindValue(':telePhone', $telephone);
        $stmt->bindValue(':subjectMsG', $subjectMsg);
        $stmt->bindValue(':textmessaGe', $textMessage);
        $stmt->bindValue(':dateTIme', $datetime);

        $Execute=$stmt->execute();

        if($Execute){
        $_SESSION["SuccessMessage"]="Message was sent Successfully";
        Redirect_to("contact.php");
        }else {
        $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
        Redirect_to("contact.php");
        }
    }
} //Ending of Submit Button If-Condition


?>


<!-- Header Start -->
<?php include("inc/header.php"); ?>
<!-- header End -->

    <div class="container">
        <div class="mt-5 mb-5">
            <h1>Please fill in all details correctly!</h1>
        </div>

        <form class="mb-5" action="contact.php" method="POST">
            <br>
            <?php
                echo ErrorMessage();
                echo SuccessMessage();
                echo ErrorMessageForRg();
            ?>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="exampleInputEmail1">First Name</label>
                    <input type="text" name="firstName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group col-md-4">
                    <label for="exampleInputEmail1">Last Name</label>
                    <input type="text" name="lastName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
            </div>
      
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="emailAddress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group col-md-4">
                    <label for="exampleInputEmail1">Telephone</label>
                    <input type="text" name="telephone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="exampleInputEmail1">Subject</label>
                    <input type="text" name="subjectMsg" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="exampleInputEmail1">Message</label>
                    <textarea placeholder="Message" name="textMessage" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div>
            
          
            <button type="submit" name="Send" class="btn btn-success">Send</button>

        </form>
        

        
    </div>
    
<!-- Footer Start -->
<?php include("inc/footer.php") ;?>
<!-- Footer End -->