<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <title>register page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
  </head>
  <body>
    <?php
    require("includes/nav.php");
    require('includes/dbconx.php');
    ?>


      <div class="jumbotron">
        <h2>Register form</h2>
        <p class="light pNoMarginBelow">Complete the form below and click submit to register a new account with us.</p>
      </div>

    <div class="container">
      <a href="javascript:history.go(-1)"><span class="backbtn">Back</span></a>
<!-- registerUsr executes code when post request -->
    <?php  require('php/registerUser.php'); ?>
    <!-- form posts back to itself - regusterUser.php deals with the code and uploads -->
      <form class="form-horizontal registerform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-group">
          <span class="control-label col-sm-2">Email <?php echo $emailErr ?> </span>
          <div class="col-sm-12">
            <input type="email" value=" <?php echo $email ?> " class="form-control" id="email" placeholder="Enter email" name="email">
          </div>
        </div>
        <div class="form-group">
          <span class="control-label col-sm-2">First Name <?php echo $firstnameErr ?> </span>
          <div class="col-sm-12">
            <input type="text" value="<?php echo $firstname ?>" class="form-control" id="firstname" placeholder="Enter first name" name="firstname">
          </div>
        </div>
        <div class="form-group">
          <span class="control-label col-sm-2">Last Name <?php echo $lastnameErr ?> </span>
          <div class="col-sm-12">
            <input type="text" class="form-control" id="lastname"  value="<?php echo $lastname ?>" placeholder="Enter last name" name="lastname">
          </div>
        </div>
        <div class="form-group">
          <span class="control-label col-sm-2">Phone Number <?php echo $noErr ?> </span>
          <div class="col-sm-12">
            <input type="number" value="<?php echo $no ?>" class="form-control" id="phonenumber" placeholder="Enter phone number" name="phonenumber">
          </div>
        </div>
        <div class="form-group">
          <span class="control-label col-sm-2">Username <?php echo $unameErr ?> </span>
          <div class="col-sm-12">
            <input type="text" value="<?php echo $uname ?>" class="form-control" id="username" placeholder="Enter username" name="username">
          </div>
        </div>

        <div class="form-group">
          <span class="control-label col-sm-2">Password  <?php echo $passwordErr ?>  </span>
          <div class="col-sm-12">
            <input type="password" class="form-control" value="<?php echo $passwordNew; ?>" id="password" placeholder="Enter password" name="password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btnStyle aWhiteHover">submit</button>
          </div>
        </div>
      </form>
    </div>

    <?php
  if(isset($_GET['message']))
  {
    $message = $_GET['message'];
    echo "<div class ='alertMessage'>" .  $message . "</div>";
  }
   ?>




    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
      <script src="js/bookingAlerts.js"></script>
      <script src="js/letterBoxAlerts.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="js/loginForm.js"></script>

    <script>
    // Highlight the navpage page link
    $(document).ready(function(){
        $('a[href^="register.php"]').addClass('active');
    });
    </script>

  </body>
</html>
