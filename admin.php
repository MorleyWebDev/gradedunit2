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

      #select all exhibitions which have been cancelled
      $canceledExes = mysqli_query($conn, "SELECT canceledOn, exhibitionid FROM exhibitions WHERE cancel = 1");
      #$cancelRows = mysqli_fetch_assoc($canceledExes);


      while($row = mysqli_fetch_array($canceledExes)){
          $canceledOn = strtotime($row['canceledOn']);
          if($canceledOn < strtotime('-30 days')){
            $delExid = $row['exhibitionid'];
            $thirtyDaysAfterCncl = mysqli_query("DELETE FROM exhibitions WHERE exhibitionid = $delExid");
              if($thirtyDaysAfterCncl){
                header('location: admin.php?alertBarMsg="One or more cancelled exhibitions have been deleted"');
              }
          }
      }

      #if any are older than 30 days
      #delete where older than 30 days
      #delete if (cancelled == 1 && (CancelledOn + 30 days) > now())

      #https://stackoverflow.com/questions/7130738/find-if-date-is-older-than-30-days
     ?>

    <meta charset="utf-8">
    <title>admin features</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



  </head>
  <body>
<?php include('includes/nav.php') ?>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
  $( ".accordion" ).accordion({
    collapsible: true
  });
} );
</script>

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
         <p>User id : <?php echo $userid; ?></p>
         <p>first name: <?php echo $firstname; ?></p>
         <p>last name: <?php echo $lastname; ?></p>
         <p>Phone Number: <?php echo $phonenumber; ?> </p>
         <p>Current Role: <span class='currentRole'><?php echo $role; ?></span></p>
<form class="changeuserroleForm" action="php/changeUserRole.php" method="post">
         <select class="changeuserrole" name="userrole">
           <option value="none">Select a new role</option>
           <option class="OPTNadmin"value="admin">admin</option>
           <option class="OPTNcreator"value="creator">creator</option>
           <option class="OPTNreadonly"value="readonly">read only</option>
         </select>
         <input type="hidden" name="postuserId" value=" <?php echo $userid; ?> ">
         <button type="button"  data-toggle="modal" data-target="#changeroleCnfrm">Click here to change it</button>

         <!-- modal for confirmation -->
         <div class="modal fade" id="changeroleCnfrm" role="dialog">
           <div class="modal-dialog">

    <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Are you sure you wish to change <?php echo $username ?>'s role on the website'</h4>
            </div>
            <div class="modal-body">
              <p>This user was previously a <?php echo $role; ?> user</p>
              <p>Click below to change the user's role</p>
              <input type="submit" name="submit" value="Change role">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>

</form>


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

        <a href="php/cancelExhibition.php?exid=<?php echo $exid; ?>"> <input type="button" name="cancelEx" value="Cancel"></a>
        <a href="deleteExhibition.php"> <input type="button" name="delEx" value="Delete"></a>
      </div>


<?php } ?>
  </div> <!-- end of all users accordion -->
</div> <!--end container -->

  <div class="whitebgCutPage">
    <div class="container">
      <h3> Create new exhibition</h3>
    this  <!-- <?php include('') ?> -->
      <form class="form-group adminCreateExFrm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <input type="file" name="" value="Upload photo">

        <div class="form-group">
          <label for="title">Title <span> <?php echo $titleErr ?> </span> </label>
          <input type="text" name="title" placeholder="Enter a title" value="">
        </div>

        <div class="form-group">
          <label for="description">Description <span> <?php echo $descErr ?> </span></label>
          <input type="text" name="description" placeholder="Enter a title" value="">
        </div>

        <div class="form-group">
          <label for="type">Category <span> <?php echo $catErr ?> </span></label>
          <input type="text" name="type" placeholder="Enter the exhibition type" value="">
        </div>

        <div class="form-group">
          <label for="stardate">Starting date <span> <?php echo $SDErr ?> </span></label>
          <input type="text" name="startdate" class="datepicker" placeholder="Enter an opening date" value="">
        </div>

        <div class="form-group">
          <label for="enddate">Ending date <span> <?php echo $EDErr ?> </span></label>
          <input type="text" name="enddate" class="datepicker" placeholder="Enter the closing date" value="">
        </div>

        <div class="form-group">
          <label for="price">Price per ticket <span> <?php echo $priceErr ?> </span></label>
          <input type="text" name="price" placeholder="Enter a price for the exhibition" value="">
        </div>

        <div class="form-group">
          <label for="ticketlimit">Ticket limit <span> <?php echo $limitErr ?> </span></label>
          <input type="text" name="ticketlimit" placeholder="Enter the amount of tickets avaliable for purchase" value="">
        </div>

        <input type="submit" name="submit" value="submit">

      </form>
    </div>
    </div>
   </div>


  </body>


      <?php include('js/letterBoxAlerts.php'); ?>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="js/modalHandle.js"></script>
  <script src="js/bookingAlerts.js"></script>
  <script src="js/loginForm.js"></script>

     <script>
     $( function() {
       $( ".datepicker" ).datepicker();
     } );
     </script>
</html>
