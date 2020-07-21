<?php $pageTitle = "Contact Us";?>

<?php require_once("inc/db.php"); ?>
<?php require_once("inc/sessions.php"); ?>
<?php require_once("inc/functions.php"); ?>




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
                    <label for="exampleInputEmail1">Message</label>
                    <textarea placeholder="Message" name="message" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div>
            
          
            <button type="submit" name="Send" class="btn btn-success">Send</button>

        </form>
        

        
    </div>
    
<!-- Footer Start -->
<?php include("inc/footer.php") ;?>
<!-- Footer End -->