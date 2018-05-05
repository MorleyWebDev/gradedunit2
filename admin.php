<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php
      session_start();
      require('includes/dbconx.php');

      $uid = $_SESSION['id'];
      $role = $_SESSION['userrole'];

      if($role != 'admin'){
        header('location: userProfile.php');
      }

     ?>

    <meta charset="utf-8">
    <title>admin features</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $( function() {
      $( ".accordion" ).accordion({
        collapsible: true
      });
    } );
    </script>

  </head>
  <body>
<?php require_once('includes/nav.php') ?>

    <div class="jumbotron">
       <h1> Administration </h1>
    </div>
    <div class="container">
    <h3>All users</h3>

    <div class="accordion">
    <?php
      $allusers = mysqli_query($conn, "SELECT * from users");

      while($row = mysqli_fetch_array($allusers)){
        $userid = $row['userid'];
        $username = $row['username'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $phonenumber = $row['phonenumber'];
        $role = $row['role'];


     ?>


       <h3>username : <?php echo $username; ?></h3>
       <div>
         <p>first name: <?php echo $firstname; ?></p>
         <p>last name: <?php echo $lastname; ?></p>
         <p>Phone Number: <?php echo $phonenumber; ?> </p>
         <p>Current Role: <?php echo $role; ?> </p>

         <select class="changeuserrole" name="userrole">
           <option value="blank">Select new role</option>
           <option value="admin">admin</option>
           <option value="creator">creator</option>
           <option value="readonly">read only</option>
         </select>
       </div>


<?php } ?>
   </div> <!-- end of all users accordion -->

    <h3>All exhibitons</h3>
   <div class="accordion">
   <?php
     $allusers = mysqli_query($conn, "SELECT * from exhibitions");

     while($row = mysqli_fetch_array($allusers)){
       $exid  = $row['exhibitionid'];
       $title = $row['title'];
       $spacesleft = $row['spacesleft'];
       $startdate = $row['startdate'];
       $enddate = $row['enddate'];
       $price = $row['price'];
    ?>


      <h3>Exhibition Title : <?php echo $title; ?></h3>
      <div>
        <p>spaces left: <?php echo $spacesleft; ?></p>
        <p>start date: <?php echo $startdate; ?></p>
        <p>end date: <?php echo $enddate; ?> </p>
        <p>Price:  <?php echo $price; ?> </p>

        <a href="CancelExhibition.php"> <input type="button" name="cancelEx" value="Cancel"></a>
        <a href="deleteExhibition.php"> <input type="button" name="delEx" value="Delete"></a>
      </div>


<?php } ?>
  </div> <!-- end of all users accordion -->
</div> <!--end container -->

  <div class="whitebgCutPage">
    <div class="container">
      <h3> Create new exhibition</h3>

      <form class="form-group" action="createExhibition" method="post">
        <input type="file" name="" value="Upload photo">
        <div class="form-group">
          <label for="title"></label>
          <input type="text" name="title" placeholder="Enter a title" value="">
        </div>

        <div class="form-group">
          <label for="title"></label>
          <input type="text" name="title" placeholder="Enter a title" value="">
        </div>
        <!--  DO THIS-->
      </form>
    </div>

  </div>

   </div>



  </body>
</html>
