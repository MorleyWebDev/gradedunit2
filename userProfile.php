<html>
<head>
  <?php
  session_start();
  //need to add a check if on correct profile
    require('includes/dbconx.php');



    if(!isset($_SESSION['id'])){
      header("location: register.php");
    }

    $uid = $_SESSION['id'];

    if($_GET['Notified'] == 1){
      $_SESSION['needsNotify'] = 0;
      $Notified = mysqli_query($conn,"UPDATE users  SET needsNotified = 0 where userid = $uid");
      if(!$Notified){
        header('location: userProfile.php?alertBarMsg=server error');
      }
    }

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
    //js script here to add class "active to all the "profile" links in the
    ?>

    <div class="jumbotron">
      <h1><?php echo $un ?></h1>
      <p>Welcome to your profile page. no one else can see this. </p>
    </div>

    <div class="container">
      <a href="javascript:history.go(-1)"><span class="backbtn">Back</span></a><br/>
      <div class="row">
        <div class="col-md-5 justify-content-center">
          <h3 class="hdrUnderBackBtn">My Details</h3>

           <div class="profPicBox d-flex justify-content-center">
            <img class="profilePageAvatar" src="img/userUploaded/<?php echo $imageUrl; ?>" alt=""><br/>

            <form action="php/updateProfilePic.php" method="post" enctype="multipart/form-data">
              <label for="profpicUpdater" class="updateProfPic">Update Profile Picture</label>
              <input style="display:none" type="file" id="profpicUpdater" placeholder="update your profile picture" onchange="this.form.submit()" id="updatedProfPic" name="updatedProfPic"></input>
            </form>
          </div>

          <form class="align-items-start form-group updatePw" action="php/changePassword.php" method="post">
            <h5>Change Password</h5>
            <div class="form-group">
              <label for="crrntPassword">Current Password</label>
              <input class="form-control" type="text" name="crrntPassword" id="crrntPassword" value="">
            </div>
            <div class="form-group">
              <label for="newPassword">New Password</label>
              <input class="form-control" type="text" id="newPassword" name="newPassword" value="">
            </div>
            <input type="submit" name="" value="Update Password">
          </form>
        </div>

        <?php require('php/updateDetails.php'); ?>

        <div class="col-md-7 d-flex justify-content-end align-items-end">
          <form class="form-group updateInfo" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <h5>Update my personal information</h5>
            <div class="form-group">
              <label for="frstName">First Name: <?php echo $firstnameEr ?> </label>
              <input type="text" placeholder="Enter your first name" id="frstName" class="form-control" name="frstName" value="<?php echo htmlspecialchars($firstN); ?>">
            </div>
            <div class="form-group">
              <label for="scndName">Second Name: <?php echo $secondnameEr ?></label>
              <input type="text" placeholder="Enter your second name" id="scndName" class="form-control" name="scndName" value="<?php echo htmlspecialchars($lastN); ?>">
            </div>
            <div class="form-group">
              <label for="usrname">Username: <?php echo $unEr ?></label>
              <input type="text" placeholder="username" id="usrname" class="form-control" name="usrname" value="<?php echo htmlspecialchars($un); ?>">
            </div>
            <div class="form-group">
              <label for="emailx">Email: <?php echo $emailEr ?> </label>
              <input type="text" placeholder="email" id="emailx" class="form-control" name="emailx" value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="form-group">
              <label for="phoneno">Phone Number: <?php echo $noEr; ?> </label>
              <input type="text" placeholder="phone number" id="phoneNo" class="form-control" name="phoneNo" value="<?php echo htmlspecialchars($phoneNo); ?>">
            </div>
            <input class="updateDetailsBtn"type="submit" name="" value="Update Details">
          </form>
        </div>
      </div>

      <h3 class="mybookingsH">My Bookings</h3>
          <div class="row mybookings NMScard justify-content-between">
          <?php $usersBookings = mysqli_query($conn, "SELECT
            t.userid, t.exhibitionid, t.tickets, t.totalcost, e.title, e.startdate, e.enddate, e.spacesleft, e.cancel, e.image
            from tickets t INNER JOIN exhibitions e ON t.exhibitionid = e.exhibitionid
             WHERE t.userid LIKE $uid");
             if(mysqli_num_rows($usersBookings) == 0){
               echo "<p class='marginauto'>You haven't booked any exhibitions yet! you can view all the current exhibitions <a href='exhibitionsMain.php'>here</a>  </p>";
             }

             while ($row = mysqli_fetch_array($usersBookings)) {
               $title = $row['title'];
               $tickets = $row['tickets'];
               $eximage = $row['image'];
               $totalcost = $row['totalcost'];
               $exid = $row['exhibitionid'];
               $startdate = strtotime($row['startdate']);
               $enddate = strtotime($row['enddate']);
               $cancel = $row['cancel'];
          ?>



          <div class="col-md-3">
            <img class = "bookedExImage" src="img/<?php echo $eximage; ?>" alt="exhibition picture">
      <?php if($cancel == 0) { ?> <input type="button" class="margintop" id="userCancelsBookingBtn" name="" value="cancel booking"> <?php } ?>
      <?php if($cancel == 1) { ?>
         <p class="pNoMarginBelow">This exhibition is cancelled, click the button below to remove it from your bookings list</p>
         <a href="userRemovesBkNotification.php?exid= <?php echo $exid; ?> "><input type="button" class="margintop" name="" value="Remove Notification"></a>
       <?php } ?>
          </div>

          <div class="modal fade" id="userCancelsBookingBtnModal" role="dialog">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
              <h4 class="modal-title">Confirm booking cancel</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <p>Are you sure you wish to cancel your booking for <?php echo $title ?></p>
                <a href="php/userCancelsBooking.php?exid=<?php echo $exid; ?>"> <input type="button" class="margintop" name="" value="cancel booking"></a>
              </div>
            </div>
          </div>
          </div>

          <?php   $sqlRating = mysqli_query($conn, "SELECT ROUND(AVG(ratings.rating),1) as score FROM Exhibitions INNER JOIN ratings ON
              ratings.exhibitionid = exhibitions.exhibitionid WHERE exhibitions.exhibitionid LIKE $exid");

              $fetchscr = mysqli_fetch_assoc($sqlRating);


               ?>

          <div class="col-md-5 vertical-align-middle align-self-center justify-content-center">
            <h3><?php echo $title ?></h3>

            <p><span class="bold">Status:</span> <?php
                          if($cancel == 1){echo "Cancelled.";}

                          else if(strtotime('today GMT') < $startdate){
                          $diff = $startdate - strtotime('today GMT') ;
                          #calculate number of days till exhibition starts
                          echo "Exhibition opens in " .round($diff / (60 * 60 * 24)). " days!";
                          }
                          else if(strtotime('today GMT') > $startdate && strtotime('today GMT') < $enddate ){
                            $diff = $enddate - strtotime('today GMT');
                            echo "Open for " . round($diff / (60 * 60 * 24)) . " more days";
                          }

                          else if(strtotime('today GMT') > $enddate){
                            echo "Exhibition has ended! Be sure to post a review if you have not already!";
                          }
             ?>

            </p>

            <p><span class="bold">Tickets Purchased</span> - <?php echo $tickets; ?></p>
            <p><span class="bold">total cost</span> -£<?php echo $totalcost; ?> (pay at door)</p>
            <a href="specificExhibition.php?exid=<?php echo $exid; ?>"><input type="button" name="" value="View exhibition"></a>
            <p></p>
          </div>
<?php   $checkReviewsExist = mysqli_num_rows(mysqli_query($conn, "SELECT review from ratings where exhibitionid = $exid"));
        if($checkReviewsExist > 0){
 ?>
          <div class="col vertical-align-middle align-self-center justify-content-center rightProfileBooking">
            <h3 class="align-middle">Rating</h3> </br>
            <span class="p4kProfileBooking"><?php echo $fetchscr['score']; ?></span>
          </div>

        </div>
      <?php }}?>

      </div>


</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <?php include('js/letterBoxAlerts.php'); ?>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="js/modalHandle.js"></script>
  <script src="js/bookingAlerts.js"></script>
</html>
