<html>
<head>

  <?php
  session_start();
  //need to add a check if on correct profile
    require('includes/dbconx.php');

    if(!isset($_SESSION['id'])){
      echo "DICKS";
      header("location: register.php");
    }

    $uid = $_SESSION['id'];



    $un = $email = $firstN = $lastN = $phoneNo = $role = "";
    $sqluser = mysqli_query($conn, "SELECT * FROM users where userid LIKE $uid");

    while($row = mysqli_fetch_array($sqluser)){
      global $un; global $email; global $firstN; global $lastN; global $phoneNo; global  $role;
      $un = $row['username'];
      $email = $row['email'];
      $pw = $row['password'];
      $firstN = $row['firstname'];
      $lastN = $row['lastname'];
      $phoneNo = $row['phonenumber'];
      $role = $row['role'];
      $imageUrl = $row['image'];

    }

   ?>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles/style.css">
  <title> <?php echo $un ?>- Profile </title>
</head>

<body>
    <?php

    require_once("includes/nav.php");
    //js script here to add class "active to all the "home" links in the
    ?>

    <div class="jumbotron">
      <h1><?php echo $un ?></h1>
      <p>Welcome to your profile page. no one else can see this. </p>
    </div>

    <div class="container">
      <a href="javascript:history.go(-1)"><span class="backbtn">Back</span></a><br/>
      <div class="row">
        <div class="col-md-5 justify-content-start">
          <h3>My Details</h3>
          <img class="profilePageAvatar" src="img/<?php echo $imageUrl; ?>" alt=""><br/>

          <form action="php/updateProfilePic.php" method="post" enctype="multipart/form-data">
            <input type="file" onchange="this.form.submit()" id="updatedProfPic" name="updatedProfPic"></input>
          </form>

          <form class="form-group updatePw" action="php/changePassword.php" method="post">
            <h5>Password</h5>
            <div class="form-group">
              <label for="crrntPassword">Current Password</label>
              <input class="form-control" type="text" name="crrntPassword" value="">
            </div>
            <div class="form-group">
              <label for="newPassword">New Password</label>
              <input class="form-control" type="text" name="" value="">
            </div>
            <input type="submit" name="" value="Update Password">
          </form>
        </div>

        <?php require('php/updateDetails.php'); ?>
        <div class="col-md-7 d-flex justify-content-end">
          <form class="form-group updateInfo" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <h5>Update my personal information</h5>
            <div class="form-group">
              <label for="frstName">First Name: <?php echo $firstnameEr ?> </label>
              <input type="text" placeholder="Enter your first name" id="frstName" class="form-control" name="frstName" value=" <?php echo $firstN ?> ">
            </div>
            <div class="form-group">
              <label for="scndName">Second Name: <?php echo $secondnameEr ?></label>
              <input type="text" placeholder="Enter your second name" id="scndName" class="form-control" name="scndName" value=" <?php echo $lastN ?> ">
            </div>
            <div class="form-group">
              <label for="usrname">Username: <?php echo $unEr ?></label>
              <input type="text" placeholder="username" id="usrname" class="form-control" name="usrname" value=" <?php echo $un ?> ">
            </div>
            <div class="form-group">
              <label for="emailx">Email: <?php echo $emailEr ?> </label>
              <input type="text" placeholder="email" id="emailx" class="form-control" name="emailx" value=" <?php echo $email ?> ">
            </div>
            <div class="form-group">
              <label for="phoneno">Phone Number: <?php $noEr ?> </label>
              <input type="text" placeholder="phone number" id="phoneno" class="form-control" name="phoneno" value=" <?php echo $phoneNo ?> ">
            </div>
            <input type="submit" name="" value="Update Details">
          </form>
        </div>
      </div>

      <h2>My Bookings</h2>
      <div class="row Flex">

          <?php $usersBookings = mysqli_query($conn, "SELECT
            t.userid, t.exhibitionid, t.tickets, t.totalcost, e.title, e.startdate, e.enddate, e.spacesleft, e.cancel, e.image
            from tickets t INNER JOIN exhibitions e ON t.exhibitionid = e.exhibitionid
             WHERE t.userid LIKE $realuid");

             while ($row = mysqli_fetch_array($usersBookings)) {
               $title = $row['title'];
               $tickets = $row['tickets'];
               $eximage = $row['image'];
               $totalcost = $row['totalcost'];

          ?>


          <div class="col-md-3">
            <img class = "bookedExImage" src="img/<?php echo $eximage; ?>" alt="exhibition picture">
            <input type="button" name="" value="cancel booking">
          </div>
          <div class="col-md-3">
            <h4><?php echo $title ?></h4>
            <p>tickets purchased - <?php echo $tickets; ?></p>
            <p>total cost - <?php echo $totalcost; ?></p>

          </div>

      <?php }?>

        </div>


      </div>


</body>
