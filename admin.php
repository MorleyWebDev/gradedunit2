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
      // $canceledExes = mysqli_query($conn, "SELECT canceledOn, exhibitionid FROM exhibitions WHERE cancel = 1");
      $canceledExes = mysqli_query($conn, "SELECT e.exhibitionid, e.canceledOn, t.userid FROM exhibitions e LEFT JOIN tickets t ON e.exhibitionid = t.exhibitionid WHERE e.cancel = 1 AND e.active = 1");
      #$cancelRows = mysqli_fetch_assoc($canceledExes);

      while($row = mysqli_fetch_array($canceledExes)){
          $canceledOn = strtotime($row['canceledOn']);
          $Unnotify = $row['userid'];
          $delExid = $row['exhibitionid'];


          $datedDiff1 = $canceledOn - strtotime('today GMT');
          $daysBetween1 = round($datedDiff1 / (60 * 60 * 24));

          #if the exhibition has been canceled for over 30 days
          // if($canceledOn < strtotime('-30 days')){
          if($daysBetween1 < -30) {
            //get all users who belong to cancelled + active exhibitions

            //get all exhibitions which have been cancelled and are still active

            $SqlsetActive = mysqli_query($conn, "UPDATE exhibitions SET active = 0 WHERE exhibitionid = $delExid");
            #it is jarring for users to have a new message only to find they dont have any exhibitions on their profile.
            #remove notification when its deleted
            $unNotifyUser = mysqli_query($conn, "UPDATE users SET needsNotified = 0 WHERE userid = $Unnotify");
            echo "<div id='alertBar'>An exhibition has been canceled for 30 days and has been deleted.</div>";

          }
        }




            // if($SqlsetActive){
              //the old exhibition has been deleted. Now check if they have any more
              // $howManyCancels = mysqli_num_rows(mysqli_query($conn, "SELECT t.tickets from tickets t INNER JOIN exhibitions e ON e.exhibitionid = t.exhibitionid where t.userid = $Unnotify AND e.cancel=1 AND e.active=1"));
              // if($howManyCancels == 0){
                // echo "no of other ex" . $howManyCancels;
            // } else {echo "user still needs to be notified. - lets do nothing.";}

            //there will never be a situation where an exhibition
            //if user has more than one exhibition canceled then




            //SELECT r.*,t.*,e.*
          // FROM exhibitions e
          // FULL JOIN ratings r ON e.exhibitionid = r.exhibitionid
          // FULL JOIN tickets t ON r.exhibitionid = t.exhibitionid
          // WHERE e.exhibitionid = 2

          //     if($unNotifyUser){
          //       echo "g o o d";
          //     } else { echo "server error but it fired";}
          // } else{
          //



      #if any are older than 30 days
      #delete where older than 30 days
      #delete if (cancelled == 1 && (CancelledOn + 30 days) > now())

      #https://stackoverflow.com/questions/7130738/find-if-date-is-older-than-30-days
     ?>


    <title>admin features</title>

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
<script>
$( function() {
  $( ".accordion" ).accordion({
    collapsible: true
  });
});
</script>

    <div class="jumbotron">
       <h1 > Administration </h1>
       <p class="pNoMarginBelow light">"A great opera house isn't run by a director, but by a great administrator."</p>
       <p class="light pNoMarginBelow">-Steven Berkoff</p>
    </div>
    <div class="container">
    <h3 class="centerText">All users</h3>
    <p class="centerText marginbottom light">Here you can edit the roles of each user on the website</p>

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

         <button type="button" class="changeUsrBtn btnStyle" data-toggle="modal" data-target="#usrid<?php echo $userid?>" name="button">Change</button>


         <div id="usrid<?php echo $userid?>" class="modal fade" role="dialog">
           <div class="modal-dialog">

             <!-- Modal content-->
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Are you suer you wish to change <?php echo $username ?>'s role?'</h4>
               </div>
               <div class="modal-body">
                 <p> <?php echo $username ?> previously had the role of <?php echo $role; ?> Do you wish to modify this to your selected role?</p>
                 <input type="submit" class="btnStyle" value="Change role">
               </div>
               <div class="modal-footer">
                 <button type="button" class="btnStyle btn-default" data-dismiss="modal">Close</button>
               </div>
             </div>

           </div>
         </div>
       </form>



       </div>


<?php } ?>
   </div> <!-- end of all users accordion -->

    <h3 class="centerText margintop">All exhibitons</h3>
    <p class="centerText marginbottom light">Here you can cancel, delete or edit each exhibition on the website.</p>
   <div class="accordion">
   <?php
     $allexhibitions = mysqli_query($conn, "SELECT * from exhibitions where active = 1");

     while($row = mysqli_fetch_array($allexhibitions)){
       $exid  = $row['exhibitionid'];
       $title = $row['title'];
       $spacesleft = $row['spacesleft'];
       $startdate = $row['startdate'];
       $enddate = $row['enddate'];
       $price = $row['price'];
       $cancel = $row['cancel'];
       $canceledOnALL = $row['canceledOn'];
    ?>


      <h3>Exhibition Title : <?php echo $title; ?></h3>
      <div class='adminExAccord'>
        <p>spaces left: <?php echo $spacesleft; ?></p>
        <p>start date: <?php echo $startdate; ?></p>
        <p>end date: <?php echo $enddate; ?> </p>
        <p>Price:  <?php echo $price; ?> </p>
      <a class="btnStyle" href="editExhibition.php?exid=<?php echo $exid;?>">Edit Exhibition</a>
        <button class="btnStyle" type="button" data-toggle="modal" data-target="#DELETEexid<?php echo $exid?>">Delete exhibition</button>
      <?php if($cancel == 1){
        $now = time();
        $canceledOnTIME = strtotime($canceledOnALL);
        $datedDiff = $canceledOnTIME- $now;
        $daysBetween = round($datedDiff / (60 * 60 * 24));
        $daysTillDeleted = $daysBetween + 30;
        echo "<p>this exhibition was cancelled on " . $canceledOnALL . "</p>";
        echo "This exhibition will be deleted in <span class='bold'>"
        . $daysTillDeleted . "</span> days";
      } else {?>
       <button type="button" class="btnStyle" data-toggle="modal" data-target="#exid<?php echo $exid?>">Cancel exhibition</button>
        <?php } ?>

         <div id="exid<?php echo $exid?>" class="modal fade" role="dialog">
           <div class="modal-dialog activemodal">

             <!-- Modal content-->
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Are you sure you wish to cancel <?php echo $title ?>?</h4>
               </div>
               <div class="modal-body">
                 <p>Exhibitions are deleted 30 days after they are cancelled. This action cannot be undone</p>

                 <a class="btnStyle" href="php/cancelExhibition.php?exid=<?php echo $exid; ?>"> Cancel the exhibition</a>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btnStyle btn-default" data-dismiss="modal">Close</button>
               </div>
             </div>

           </div>
         </div>

         <div id="DELETEexid<?php echo $exid?>" class="modal fade" role="dialog">
           <div class="modal-dialog activemodal">

             <!-- Modal content-->
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Are you sure you wish to Delete <?php echo $title ?>?</h4>
               </div>
               <div class="modal-body">
                 <p>This will comnpletely delete the exhibition without providing 30 days notice to the users.
                   This should be used as a fail safe or if an exhibition has been mistakenly uploaded. Consider canceling the exhibition instead.</p>

                 <a class="btnStyle" href="php/hardDeleteExhibition.php?exid=<?php echo $exid; ?>"> Delete the exhibition</a>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btnStyle btn-default" data-dismiss="modal">Close</button>
               </div>
             </div>

           </div>
         </div>

      </div>

<?php } ?>
 <!-- end of all users accordion -->
</div> <!--end container -->

  <div class="whitebgCutPage">
    <div class="container">
      <h3 class="margintop centerText"> Create new exhibition</h3>
      <p class="centerText light"></p>
      <?php include('php/createExhibition.php'); ?>
      <form class="adminCreateExFrm"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="post">
        <div class="form-group">
          <input type="file" required id="createExImage" class="FormInput" name="createExImage">
        </div>
        <div class="form-group">
          <label for="title">Title <span> <?php echo $titleErr ?> </span> </label>
          <input type="text" required  id="title" name="title" placeholder="Enter a title" value="<?php echo $titleCreate ?>">
        </div>

        <div class="form-group">
          <label for="description">Description <span> <?php echo $descErr ?> </span></label>
          <input type="text" required id="description" name="description" placeholder="Enter a title" value="<?php echo $desc?>">
        </div>

        <div class="form-group">
          <label for="type">Category <span> <?php echo $catErr ?> </span></label>
          <input type="text" required id="type" name="type" placeholder="Enter the exhibition type" value="<?php echo $cat ?>">
        </div>

        <div class="form-group">
          <label for="startdate">Starting date <span> <?php echo $SDErr ?> </span></label>
          <input type="text" required id="startdate" name="startdate" class="datepicker" placeholder="Enter an opening date" value="<?php echo $SD ?>">
        </div>

        <div class="form-group">
          <label for="enddate">Ending date <span> <?php echo $EDErr ?> </span></label>
          <input type="text" required id="enddate" name="enddate" class="datepicker" placeholder="Enter the closing date" value="<?php echo $ED ?>">
        </div>

        <div class="form-group">
          <label for="price">Price per ticket <span> <?php echo $priceErr ?> </span></label>
          <input type="number" required id="price" name="price" placeholder="Enter a price for the exhibition" value="<?php echo $priceCreate ?>">
        </div>

        <div class="form-group">
          <label for="ticketlimit">Ticket limit <span> <?php echo $limitErr ?> </span></label>
          <input type="number" required id="ticketlimit" name="ticketlimit" placeholder="Enter the amount of tickets avaliable for purchase" value="<?php echo $limit ?>">
        </div>

        <input type="submit" class="btnStyle" name="submit" value="submit">
      </form>

    </div>
    </div>
   </div>




  </body>


  <script src="js/letterBoxAlerts.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="js/modalHandle.js"></script>
  <script src="js/bookingAlerts.js"></script>
  <script src="js/loginForm.js"></script>

     <script>
     $( function() {
       $( ".datepicker" ).datepicker({
         dateFormat: 'yy-mm-dd'
       });
     } );
     </script>


     <script>
     // Highlight the navpage page link
     $(document).ready(function(){
         $('a[href^="admin.php"]').addClass('active');
     });
     </script>

</html>
