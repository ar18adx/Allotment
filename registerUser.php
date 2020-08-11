<?php $pageTitle = "Register User";?>


<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>

<?php

    if(isset($_POST["Submit"])){
        date_default_timezone_set("Africa/Lagos");
        $CurrentTime            =  time();
        $datetime               = strftime("%B-%d-%Y at %I:%M:%p",$CurrentTime);
        $firstName               = $_POST["firstName"];
        $lastName               = $_POST["lastName"];
        $emailAddress           = $_POST["emailAddress"];
        $telephone               = $_POST["telephone"];
        $homeAddress               = $_POST["homeAddress"];
        $city               = $_POST["city"];
        $gender               = $_POST["gender"];
        $password               = $_POST["password"];
        $confirmPassword        = $_POST["confirmPassword"];
        $hash                   = password_hash($password, PASSWORD_BCRYPT);
        $userStatus             = "New_User";
    
    

        if(empty($firstName) ||empty($lastName) ||empty($emailAddress) ||empty($telephone) ||empty($homeAddress) ||empty($password) ||empty($confirmPassword)){
            $_SESSION["ErrorMessage"]= "All fields must be filled out";
            Redirect_to("registerUser.php");
        }elseif (strlen($password)<4) {
            $_SESSION["ErrorMessage"]= "Password should be greater than 3 characters";
            Redirect_to("registerUser.php");
        }elseif ($password !== $confirmPassword) {
            $_SESSION["ErrorMessage"]= "Password and Confirm Password should match";
            Redirect_to("registerUser.php");
        }elseif(CheckEmailExistsOrNot($emailAddress)){
            $_SESSION["ErrorMessage"]= "Your email address exists in our system";
            Redirect_to("registerUser.php");
        }else{

            // Send email to new user to check if email is correct
                $emailTo    = $emailAddress;
                $subject    = "Email Address Validation";
                $message    = "Hello, ".$firstName."\n\n"." Your registration was successful.";
                $headers    = "From: "."Allotment";

                mail($emailTo, $subject, $message, $headers);

            // Query to insert new User in DB When everything is fine
            global $ConnectingDB;
            $sql = "INSERT INTO users(datetime, firstName, lastName, emailAddress, telephone, homeAddress, city, gender, password, userStatus )";
            $sql .= "VALUES(:dateTIme, :firstNAme, :lastNAme, :emailADdress, :telePhone, :homeADdress, :citY, :gendeR, :passworD, :userStatuS)";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':dateTIme', $datetime);
            $stmt->bindValue(':firstNAme', ucfirst($firstName));
            $stmt->bindValue(':lastNAme', ucfirst($lastName));
            $stmt->bindValue(':emailADdress', $emailAddress);
            $stmt->bindValue(':telePhone', $telephone);
            $stmt->bindValue(':homeADdress', ucfirst($homeAddress));
            $stmt->bindValue(':citY', $city);
            $stmt->bindValue(':gendeR', $gender);
            $stmt->bindValue(':passworD', $hash);
            $stmt->bindValue(':userStatuS', $userStatus);
            
            $Execute=$stmt->execute();
            if($Execute){
            $_SESSION["SuccessMessage"]="Your registration was successful, A verification message has been sent to Your mail";
            Redirect_to("index.php");
            }else {
            $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
            Redirect_to("registerUser.php");
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

                <form class="mb-5" action="registerUser.php" method="POST">
                    <br>
                    <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                        echo ErrorMessageForRg();
                    ?>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">First Name</label>
                            <input type="text" name="firstName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Last Name</label>
                            <input type="text" name="lastName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="emailAddress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Telephone</label>
                            <input type="text" name="telephone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Address</label>
                            <input type="text" name="homeAddress" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">City</label>
                            <select name="city" class="custom-select">
                                <?php
                                //Fetchinng all the categories from category table
                                global $ConnectingDB;
                                $sql = "SELECT id, cityName FROM cities ORDER BY cityName ASC";
                                $stmt = $ConnectingDB->query($sql);
                                while ($DataRows = $stmt->fetch()) {
                                $Id = $DataRows["id"];
                                $cityName = $DataRows["cityName"];
                                ?>
                                <option> <?php echo $cityName; ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Gender</label>
                            <select name="gender" class="custom-select">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Confirm Password</label>
                            <input type="password" name="confirmPassword" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                            
                        </div>
                    </div>
                    
                    <button type="submit" name="Submit" class="btn btn-success">Register</button>

                </form>
                


    </div>

<!-- Footer Start -->
<?php include("inc/footer.php") ;?>
<!-- Footer End -->