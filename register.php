<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>register page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
  </head>
  <body>
    <?php
    require("includes/nav.php");
    require('includes/dbconx.php');
    require('php/registerUser.php');
    ?>

    <div class="container">
      <h2>Register form</h2>
      <form class="form-horizontal registerform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-group">
          <span class="control-label col-sm-2" for="email"> <?php echo $emailErr ?> </span>
          <div class="col-sm-10">
            <input type="email" value=" <?php echo $email ?> " class="form-control" id="email" placeholder="Enter email" name="email">
          </div>
        </div>
        <div class="form-group">
          <span class="control-label col-sm-2" for="firstname"> <?php echo $firstnameErr ?> </span>
          <div class="col-sm-10">
            <input type="text" value="<?php echo $firstname ?>" class="form-control" id="firstname" placeholder="Enter first name" name="firstname">
          </div>
        </div>
        <div class="form-group">
          <span class="control-label col-sm-2" for="lastname"> <?php echo $lastnameErr ?> </span>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="lastname"  value="<?php echo $lastname ?>" placeholder="Enter last name" name="lastname">
          </div>
        </div>
        <div class="form-group">
          <span class="control-label col-sm-2" for="phonenumber"> <?php echo $noErr ?> </span>
          <div class="col-sm-10">
            <input type="text" value="<?php echo $no ?>" class="form-control" id="phonenumber" placeholder="Enter phone number" name="phonenumber">
          </div>
        </div>
        <div class="form-group">
          <span class="control-label col-sm-2" for="username"> <?php echo $unameErr ?> </span>
          <div class="col-sm-10">
            <input type="text" value="<?php echo $uname ?>" class="form-control" id="username" placeholder="Enter username" name="username">
          </div>
        </div>

        <div class="form-group">
          <span class="control-label col-sm-2" for="password"> <?php echo $passwordErr ?>  </span>
          <div class="col-sm-10">
            <input type="password" class="form-control" value="<?php echo $password ?>" id="password" placeholder="Enter password" name="password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">submit</button>
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="js/loginForm.js"></script>
  </body>
</html>
