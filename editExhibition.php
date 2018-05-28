<!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <?php
     session_start();
     $role = $_SESSION['userrole'];
     // if user not admin do not let them in
     if($role != 'admin'){
       header('location: userProfile.php');
     }



     if(!isset($_GET['exid'])){     #Not really needed due to line 21 being added.
       header('location: admin.php');
     } else {
       $exid = $_GET['exid'];
     }

     include('includes/dbconx.php');
     
     $getEx = mysqli_query($conn, "SELECT exhibitionid, title, description, spacesleft, price, type, startdate, enddate FROM exhibitions where active = 1 AND exhibitionid = $exid");

     if(mysqli_num_rows($getEx) == 0) {
       header('location: admin.php?alertBarMsg=We dont have that exhibition id on our server. Try one from the "all exhibitions list"');
     }

     while($row = mysqli_fetch_array($getEx)){
       $title = $row['title'];
       $desc = $row['description'];
       $spacesleft = $row['spacesleft'];
       $price = $row['price'];
       $type = $row['type'];
       $sdate = $row['startdate'];
       $edate = $row['enddate'];
       $exid = $row['exhibitionid'];
     }
      ?>

      <title>Edit Ex</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
      <link rel="stylesheet" href="styles/style.css">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   </head>
   <body>
<?php include('includes/nav.php') ?>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


     <div class="container">
       <h3> editing <?php echo $title; ?></h3>
       <form class="adminCreateExFrm"  action="php/editExAttempt.php" method="post">

         <input type="hidden" name="exid" value="<?php echo $exid; ?>">

         <div class="form-group">
           <label for="title">Title <span> <?php echo $titleErr ?> </span> </label>
           <input required id="title" type="text" name="title" placeholder="Enter a title" value="<?php echo $title ?>">
         </div>

         <div class="form-group">
           <label for="description">Description <span> <?php echo $descErr ?> </span></label>
           <input required id="description" type="text" name="description" placeholder="Enter a title" value="<?php echo $desc?>">
         </div>

         <div class="form-group">
           <label for="type">Category <span> <?php echo $typeErr ?> </span></label>
           <input required id="type" type="text" name="type" placeholder="Enter the exhibition type" value="<?php echo $type ?>">
         </div>

         <div class="form-group">
           <label for="startdate">Starting date <span> <?php echo $SDErr ?> </span></label>
           <input required id="startdate" type="text" name="startdate" class="datepicker" placeholder="Enter an opening date" value="<?php echo $sdate ?>">
         </div>

         <div class="form-group">
           <label for="enddate">Ending date <span> <?php echo $EDErr ?> </span></label>
           <input required id="enddate" type="text" name="enddate" class="datepicker" placeholder="Enter the closing date" value="<?php echo $edate ?>">
         </div>

         <div class="form-group">
           <label for="price">Price per ticket <span> <?php echo $priceErr ?> </span></label>
           <input required id="price" type="number" name="price" placeholder="Enter a price for the exhibition" value="<?php echo $price ?>">
         </div>

         <div class="form-group">
           <label for="ticketlimit">Number of tickets left <span> <?php echo $limitErr ?> </span></label>
           <input required id="ticketlimit" type="number" name="ticketlimit" placeholder="Enter the amount of tickets avaliable for purchase" value="<?php echo $spacesleft ?>">
         </div>
        <a class="btnStyle" href="admin.php">Cancel Editing</a>
         <input type="submit" class="btnStyle" name="submit" value="Submit">
       </form>

     </div>

     <script>
     // script for jquery datepicker used in the form
     $( function() {
       $( ".datepicker" ).datepicker({
         dateFormat: 'yy-mm-dd'
       });
     } );
     </script>

     <script src="js/letterBoxAlerts.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
 <script src="js/modalHandle.js"></script>
 <script src="js/bookingAlerts.js"></script>
 <script src="js/loginForm.js"></script>

 <script>
 // Highlight the navpage page link
 $(document).ready(function(){
     $('a[href^="admin.php"]').addClass('active');
 });
 </script>

   </body>
 </html>
