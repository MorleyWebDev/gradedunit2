<?php
  session_start();
  require("includes/dbconx.php");

if(!isset($_GET['exid'])){
  header('location: exhibitionsMain.php');
}

  $exid = htmlspecialchars($_GET["exid"]);
 #get all data from exhibitions.
  $sqlex = mysqli_query($conn,  "SELECT * FROM exhibitions where exhibitionid LIKE $exid");

  #if the value in the get querystring doesnt exist redirect them to  the main exhibitions page
  $doesExidExist = mysqli_num_rows($sqlex);
  if($doesExidExist == 0){
    header('location: exhibitionsMain.php?alertBarMsg=That exhibition id does not exist on our servers. (Something went wrong!)');
  }



  #set id to variable if user has one.
  if(isset($_SESSION['id']))
  {
    $uid = $_SESSION['id'];
  }

  #sql query to get users role into a string variable
  $userRole = mysqli_query($conn, "select role, avatar from users where userid = $uid");
  while($row = mysqli_fetch_row($userRole)){
    #get user role on string
    $uRole = $row[0];
    #get user avatar URL on string
    $userimage = $row[1];
  }




  $sqlRating = mysqli_query($conn, "SELECT ROUND(AVG(ratings.rating),1) FROM Exhibitions INNER JOIN ratings ON
    ratings.exhibitionid = exhibitions.exhibitionid WHERE exhibitions.exhibitionid LIKE $exid");

//  $sqlBNM = mysqli_query($conn, "SELECT MAX(ROUND(AVG(ratings.rating),1)) FROM Exhibitions INNER JOIN ratings ON
  //    ratings.exhibitionid = exhibitions.exhibitionid");

  $sqlBNM = mysqli_query($conn, "SELECT E.exhibitionid, title, ROUND(AVG(rating),1) as average
                              FROM exhibitions E LEFT JOIN ratings R ON E.exhibitionid = R.exhibitionid
                              GROUP By E.exhibitionid, title ORDER BY average DESC LIMIT 1");


  $checkReviewsExist = mysqli_num_rows(mysqli_query($conn, "SELECT review from ratings where exhibitionid = $exid"));

  if($checkReviewsExist == 0){
    $numReviews = 0;
  } else {
    $numReviews = 1;
  }


  $CheckBook = mysqli_query($conn, "SELECT * FROM tickets where userid = $uid and exhibitionid = $exid");
  if(mysqli_num_rows($CheckBook) == 0){
    $CheckBooked = 0;
  } else {
    $CheckBooked = 1;
  }

  while($row = mysqli_fetch_row($CheckBook)){
    #row2 is the number of tickets the user booked for this exhibition.
    $ticketsUserHasBooked = $row[2];
  }

  // $sqlex1 = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");
  // $sqlex2 = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");
  // $sqlex3 = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");

  while($row = mysqli_fetch_array($sqlex)){
    global $title; global $image; global $type; global $description;
    global $startdate; global $enddateTIME; global $price; global $spacesleft;
    $isActive = $row['active'];
    $title = $row['title'];
    $image = $row['image'];
    $type = $row['type'];
    $desc = $row['description'];
    $startdate = $row['startdate'];
    $enddate = $row['enddate'];
    $price = $row['price'];
    $spacesleft = $row['spacesleft'];
    $cancel = $row['cancel'];
    $canceledOn = $row['canceledOn'];

    $enddateTIME = strtotime($enddate);
    $startdateTIME = strtotime($startdate);
  }

  if($isActive == 0){
    header('location: exhibitionsMain.php?alertBarMsg=This exhibition has been deleted. We wont force you to remove the booking from your profile page. But the page itself will not work anymore');
  }


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:100|Lobster+Two" rel="stylesheet">
    <meta charset="utf-8">
    <title> <?php echo $title; ?> </title>
  </head>
  <body>
    <?php
    require("includes/nav.php");
    ?>
    <div class="container">
      <div class='specExHeader row'>
        <div class='flexColumn col-sm-4 d-flex align-items-center justify-content-center'>
          <h1 class='specExTitle'> <?php echo $title; ?> </h1>
          <p class="centerText"><span class='bold'>Status:</span>
          <?php if($cancel == 1) {
            $now = time();
            $canceledOnTIME = strtotime($canceledOn);
            $datedDiff = $canceledOnTIME- $now;
            $daysBetween = round($datedDiff / (60 * 60 * 24));
            $daysTillDeleted = $daysBetween + 31;
            $shouldBeGone = 0;
            if($daysTillDeleted <= 0 ){$shouldBeGone = 1;}
            if($shouldBeGone = 1){ echo "This exhibiton has been canceled for over 30 days and will be deleted shortly.";}
            else {
            echo "Cancelled, this page will be deleted in - <span class='bold'>" . $daysTillDeleted . "</span> days. Sorry!";

          } }   if($enddateTIME < strtotime('today GMT')) {echo "Exhibition has ended.";}
                else if($spacesleft > 5 && $shouldBeGone == 0) {echo $spacesleft . " tickets remaining";}
                else if($spacesleft <= 5 && $spacesleft > 0 && $shouldBeGone == 0) {echo "Only " . $spacesleft . " tickets remaining - Book soon before its too late!" ;}
                else if($shouldBeGone == 0) {echo "Exhibition Full";}
           ?>
         </p>

        </div><!-- end column -->

        <div class="col-sm-4 align-self-center specExImgBox">
          <img class='specExImg' src=<?php echo"'img/exhibitions/". $image . "'"; ?> alt='exhibitonimage'>
        </div>
<div class="col-sm-4 align-self-center forceColumn">
    <?php
      $fetchTOP = mysqli_fetch_array($sqlBNM);  //LEAVE THIS ALONE -  are you sure?
      //logic for before start date here
      if($fetchTOP[0] === $exid){ //if the id is equal to the highest average ex id
        echo "<h2 class='p4kbnm'> ". $fetchTOP['average'] . "</h2>";
        echo "<p class='topExhibit pNoMarginBelow'>🔥 Top Exhibit!<p>";

      } else {   if($numReviews == 1){
        while ($row = mysqli_fetch_array($sqlRating)){
        echo "<h2 class='p4kst'> ". $row[0] . "</h2>";

        }
      } else {echo "Not yet rated.";}
      } ?>




  </div></div></div>
        <div class="container">
          <a href="javascript:history.go(-1)"><span class="backbtn">Back</span></a><br/>
          <div class='row margintop paddingbottom align-items-center'>
            <div class='col align-self-center'>
              <span class='specExType bold'>Exhibition Field:</span>
                <span>
                    <?php echo $type; ?>
 <!--if statement here for spaces free / cancelled-->
                </span>


               <!--if statement here for spaces free / cancelled-->
              <p class='specExDesc'> <?php echo $desc; ?> </p>
            </div>  <!-- end of col-xs-10 Div -->




    <div class="col-md-5">
        <div class='specExDateTime NMScard'>
          <?php if($CheckBooked == 1){
            echo "<p class='YouHaveBooked'>
            You have booked"?> <?php echo $ticketsUserHasBooked; ?> <?php  echo "tickets for this exhibition</p>";
          } ?>
          <p class='bold'> Opens: </p>
          <p> <?php echo $startdate; ?> </p>
          <br><p class='bold'> Closing date: </p>
          <p> <?php echo $enddate; ?> </p>
          <br><p class='bold'>Price:</p>
          <p>£ <?php echo $price; ?> <p>


    <?php  require_once('php/bookingBtnLogic.php');?> <!--booking Button logic-->
  </div>
</div> <!--end of col-sm-2 -->

</div> <!-- end of 2nd row-->
</div>
<!--GOOD ABOVE -->
<div class="container">

      <?php if(isset($_GET['message'])){
            $message = $_GET['message'];
            echo "<div class ='alertMessage'>" .  $message . "</div>";} ?>


    <form class="reviewForm" action="php/reviewsLogic.php?exid=<?php echo$exid ?>" method="post">
      <div class="postReviewBox row">
          <div class="col-xs-3">
            <img class="userAvatar userAvatarMine" src=<?php echo"'img/userUploaded/" . $userimage . "'"; ?> alt="">
          </div>
          <div class="col notOnMobile">


              <textarea  class="reviewInput" rows='5' name="reviewPost" value="" placeholder="Add a public review here - be sure to attach a score!"></textarea>
          </div>

          <div class="col-xs-3">
            <div class="ratingPost">
              <span>Score - </span>
              <select name="ratingPost">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
              </select> <br/>
            </div>
            <div class="reviewInputBtn">
              <input type="button" name="cancel" class="cnclReviewTextBtn" value="cancel"> <!--js for this? CLEAR input -->
              <?php
              if(ISSET($_SESSION['id'])){
                if($uRole == 'admin' || $uRole == 'creator'){
                  if($CheckBooked == 1) {
                    if(strtotime('today GMT') > strtotime($startdate)){
                      echo '<input type="submit" name="submit" class="" value="submit">';
                    } else {
                      echo '<input type="button" name="submit" class="btnDisable revwBtnNotStartedYet" value="submit">';
                    }
                  } else {
                    echo '<input type="button" name="submit" class="btnDisable revwBtnNoBooking" value="submit">';
                  }
                } else {
                  echo '<input type="button" name="submit" class="btnDisable revwBtnReadOnly" value="submit">';
                }
              } else {
                echo '<input type="button" name="submit" class="btnDisable revwBtnNotLogged" value="submit">';
              }
              ?>
            </div>
          </div>
      </div>
      <p class='reviewBtnErr hideOnClick'><?php
            if(isset($_GET['err'])){
              $emptyErr = $_GET['err'];
              echo   $emptyErr; // form
            } ?></p>
    </form>
  </div>

      <?php  require_once('php/reviewsLogic.php');?>
  </body>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="js/loginForm.js"></script>
    <?php include('js/letterBoxAlerts.php'); ?>
    <script src="js/bookingAlerts.js"></script>



</html>
