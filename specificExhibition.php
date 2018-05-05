<?php
  session_start();
  require("includes/dbconx.php");
  $exid = $_GET["id"];

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

  // $sqlex1 = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");
  // $sqlex2 = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");
  // $sqlex3 = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");

  while($row = mysqli_fetch_array($sqlex)){
    global $title; global $image; global $type; global $description;
    global $startdate; global $enddate; global $price;

    $title = $row['title'];
    $image = $row['image'];
    $type = $row['type'];
    $desc = $row['description'];
    $startdate = $row['startdate'];
    $enddate = $row['enddate'];
    $price = $row['price'];
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
    <div class="alertBar" id="alertBar"></div>
    <?php
    require("includes/nav.php");
    ?>
    <div class="container">
      <div class='specExHeader row'>
        <div class='flexColumn specExStatus'>
          <h1 class='specExTitle'> <?php echo $title; ?> </h1>
          <p class='specExStatus'><span class='bold'>Exhibition field:</span> <?php echo $type; ?> </p> <!--if statement here for spaces free / cancelled-->
        </div><!-- end column -->
        <img class='specExImg' src=<?php echo"'img/". $image . "'"; ?> alt='exhibitonimage'>


      <div class='bestNewBox'>

    <?php
      $fetchTOP = mysqli_fetch_array($sqlBNM);  //LEAVE THIS ALONE -  are you sure?
      //logic for before start date here
      if($fetchTOP[0] === $exid){ //if the id is equal to the highest average ex id

        echo "<h2 class='p4kbnm'> ". $fetchTOP['average'] . "</h2>";
        echo "<p>🔥 Top Exhibit!<p>";
      } else {
        while ($row = mysqli_fetch_array($sqlRating)){
        echo "<h2 class='p4kst'> ". $row[0] . "</h2>";
        }
      } ?>
    </div></div></div>
        <div class="container">
          <a href="javascript:history.go(-1)"><span class="backbtn">Back</span></a><br/>
          <div class='row  margintop paddingbottom '>
            <div class='col'>
              <p class='specExType bold'>Status: <span class="light"><?php echo "Spaces Free"; ?></span></p> <!--if statement here for spaces free / cancelled-->
              <p class='specExDesc'> <?php echo $desc; ?> </p>
            </div>  <!-- end of col-xs-10 Div -->




    <div class="col-sm-2">
        <div class='specExDateTime'>
          <p class='bold'> Opens: </p>
          <p> <?php echo $enddate; ?> </p>
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
    <script src="js/bookingAlerts.js"></script>

</html>
