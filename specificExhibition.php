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

  $sqlex = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");
  $sqlex1 = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");
  $sqlex2 = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");
  $sqlex3 = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="alertBar" id="alertBar"></div>
    <?php
    require("includes/nav.php");
    ?>
    <div class="container">
    <?php
      while($row = mysqli_fetch_array($sqlex)){
        echo "<div class='specExHeader'>";
        echo "<div class='flexColumn specExStatus'>";
          echo "<h1 class='specExTitle'>" . $row['title'] . "</h1>";
          echo "<p class='specExStatus'><span class='bold'>Status:</span> Spaces free! </p>"; //if statement here for spaces free / cancelled
        echo "</div>";
        echo "<img class='specExImg' src='img/" . $row['image'] . "' alt='exhibitonimage'" . "/>";
    }

      $fetchTOP = mysqli_fetch_array($sqlBNM);
      //logic for before start date here
      if($fetchTOP[0] === $exid){ //if the id is equal to the highest average ex id
        echo "<div class='bestNewBox'>";
        echo "<h2 class='p4kbnm'> ". $fetchTOP['average'] . "</h2>";
        echo "<p>🔥 Top Exhibit!</div></div>";
      }else{
        while ($row = mysqli_fetch_array($sqlRating)){
        echo "<h2 class='p4kst'> ". $row[0] . "</h2></div>";
        }
      }
      //ex details
       while($row = mysqli_fetch_array($sqlex1)){
        echo "<div class='row  margintop'>";
        echo "<div class='specExDeskContainer col-sm-10'>";
        echo "<h3 class='spexExType'>Exhibition field: " . $row['type'] . "</h3><br>";
        echo "<p class='specExDesc'>" . $row['description'] . "</p>";
        echo "</div>";
      }
      //booking while statement
      ?>

    <div class="bookingContainer col-sm-2">
    <?php
    //$endDate = mysqli_query($conn, "select enddate from exhibitions where exhibitionid like $exid");
      while($row = mysqli_fetch_array($sqlex2)){
        echo "<div class='specExDateTime'>";
        echo "<p class='bold'> Opens: </p>";
        echo "<p>" . $row['startdate'] . "</p>";
        echo "<br><p class='bold'> Closing date: </p>";
        echo "<p>" . $row['enddate'] . "</p>";
        echo "<br><p class='bold'>Price:</p>";
        echo "<p>£" . $row['price'] . "<p>";
      }
    ?>

    <?php  require_once('php/bookingBtnLogic.php');?> <!--booking Button logic-->



      <?php if(isset($_GET['message'])){
            $message = $_GET['message'];
            echo "<div class ='alertMessage'>" .  $message . "</div>";} ?>
          </div></div>

      <div class="postReviewBox">
        <form class="reviewForm" action="php/reviewsLogic.php?exid=<?php echo$exid ?>" method="post">
          <div class="row">
          <div class="col-sm-10">
            <span><?php
                  if(isset($_GET['err'])){
                    $emptyErr = $_GET['err'];
                    echo   $emptyErr; // form
                  } ?></span>
            <div class="flexRow">
              <input type="text" class="reviewInput" name="reviewPost" value="" placeholder="Add a public review here - be sure to attach a score!">
              <select name="ratingPost" class='ratingPost'>
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
              </select>
            </div>
          </div>
          <div class="col-sm-2">
            <input type="button" name="cancel" value="cancel"> <!--js for this? CLEAR input -->
            <input type="submit" name="submit" value="submit">
          </div>
        </div>
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
