<?php
  session_start();
  require("includes/dbconx.php");

if(!isset($_GET['exid'])){
  header('location: exhibitionsMain.php');
}

  $exid = htmlspecialchars($_GET["exid"]);

  if(isset($_SESSION['id']))
  {
    $uid = $_SESSION['id'];
  }


  $sqlRating = mysqli_query($conn, "SELECT ROUND(AVG(ratings.rating),1) FROM Exhibitions INNER JOIN ratings ON
    ratings.exhibitionid = exhibitions.exhibitionid WHERE exhibitions.exhibitionid LIKE $exid");

//  $sqlBNM = mysqli_query($conn, "SELECT MAX(ROUND(AVG(ratings.rating),1)) FROM Exhibitions INNER JOIN ratings ON
  //    ratings.exhibitionid = exhibitions.exhibitionid");

  $sqlBNM = mysqli_query($conn, "SELECT E.exhibitionid, title, ROUND(AVG(rating),1) as average
                              FROM exhibitions E LEFT JOIN ratings R ON E.exhibitionid = R.exhibitionid
                              GROUP By E.exhibitionid, title ORDER BY average DESC LIMIT 1");

  $sqlex = mysqli_query($conn,  "SELECT * FROM exhibitions where exhibitionid LIKE $exid");
  $checkReviewsExist = mysqli_num_rows(mysqli_query($conn, "SELECT review from ratings where exhibitionid = $exid"));

  if($checkReviewsExist == 0){
    $numReviews = 0;
  } else {
    $numReviews = 1;
  }


  $CheckBooked = mysqli_query($conn, "SELECT * FROM tickets where userid = $uid and exhibitionid = $exid");
  if(mysqli_num_rows($CheckBooked) == 0){
    $CheckBooked = 0;
  } else {
    $CheckBooked = 1;
  }

  // $sqlex1 = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");
  // $sqlex2 = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");
  // $sqlex3 = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");

  while($row = mysqli_fetch_array($sqlex)){
    global $title; global $image; global $type; global $description;
    global $startdate; global $enddate; global $price; global $spacesleft;

    $title = $row['title'];
    $image = $row['image'];
    $type = $row['type'];
    $desc = $row['description'];
    $startdate = $row['startdate'];
    $enddate = $row['enddate'];
    $price = $row['price'];
    $spacesleft = $row['spacesleft'];
    $cancel = $row['cancel'];
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
          <p class='specExStatus'><span class='bold'>Exhibition field:</span> <?php echo $type; ?> </p> <!--if statement here for spaces free / cancelled-->
        </div><!-- end column -->

        <div class="col-sm-4">
          <img class='specExImg' src=<?php echo"'img/". $image . "'"; ?> alt='exhibitonimage'>
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
              <span class='specExType bold'>Status:
                <span class="light">
                <?php if($cancel == 1) {echo "Cancelled - Sorry!";}
                      else if($spacesleft > 5) {echo $spacesleft . " tickets remaining";}
                      else if($spacesleft <= 5 && $spacesleft > 0) {echo "Only " . $spacesleft . " tickets remaining - Book soon before its too late!" ;}
                      else {echo "Exhibition Full";}

                      if($CheckBooked == 1){echo "<br/> You have booked x tickets for this exhibition";}
                 ?>

              </span></span>


               <!--if statement here for spaces free / cancelled-->
              <p class='specExDesc'> <?php echo $desc; ?> </p>
            </div>  <!-- end of col-xs-10 Div -->




    <div class="col-md-2">
        <div class='specExDateTime NMScard'>
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
            <img class="userAvatar" src=<?php echo"'img/" . $image . "'"; ?> alt="">
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
              <input type="button" name="cancel" value="cancel"> <!--js for this? CLEAR input -->
              <input type="submit" name="submit" value="submit">
            </div>
          </div>
      </div>
      <span><?php
            if(isset($_GET['err'])){
              $emptyErr = $_GET['err'];
              echo   $emptyErr; // form
            } ?></span>
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
