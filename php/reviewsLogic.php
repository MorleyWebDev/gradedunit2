<?php

session_start();
// if ($_SERVER["REQUEST_METHOD"] == "POST") { //this is ALL broken fix it on sunday.
//   require("../includes/dbconx.php");
//
//   if(isset($_SESSION['id'])){
//    $uid = $_SESSION['id'];}
//    $exid = $_GET["exid"];
//
//   if(empty($_POST['reviewPost'])){
//     header('Location: ' . $_SERVER['HTTP_REFERER'] ."&err=Make Sure you type a review!");
//   } else {
//     $count;
//   //  checkDupInsert()
//     global $conn; global $uid; global $exid;
//     test_input($_POST['reviewPost']);
//
//     $ratingP = $_POST['ratingPost'];
//     $reviewP = $_POST['reviewPost'];
//s
//
//
//     $dupReview = "SELECT userid, exhibitonid FROM ratings WHERE userid LIKE $uid AND exhibitionid LIKE $exid";
//
//       if(($row = mysqli_fetch_assoc($dupReview)){ // this is broken. try to fix with the method used in registerUser.php
//           $reviewInsert = mysqli_query($conn, "insert into ratings (userid, exhibitionid, rating, review)
//                          VALUE ('$uid', '$exid', '$ratingP', '$reviewP')"); // insert review + rating
//       } else {
//         echo "thinks count doesnt = 0 count actually equals: " .$count;
//         //header('location: ../specificExhibition.php?id=' . $exid . "&err=You can only rate and review your exhibiton once!");
//         //die();
//       }
//
//   }
// } Old method above, did not work






 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exid = $_GET["exid"];

   if(isset($_SESSION['id'])){
     $uid = $_SESSION['id'];
   }


  if(empty($_POST['reviewPost'])){
    header('Location: ' . $_SERVER['HTTP_REFERER'] ."&err=Make Sure you type a review!");
  }

  else if(check_dplc($uid, $exid) == 1) {
    header('Location: ' . $_SERVER['HTTP_REFERER'] ."&err=Sorry, you have already posted a review for this exhibiton! You could always delete it if you want to post another.");
  }

  else if(check_booked($uid, $exid) == 0) {
    header('Location: ' . $_SERVER['HTTP_REFERER'] ."&err=you need to book a ticket. - ");
  }


     else {
      /*REGEX HERE?*/
      /*IF USER HAS BOOKED A TICEKT*/
      $dateTime = gmdate('Y-m-d h:i:s \G\M\T', time());
       test_input($_POST['reviewPost']);
       $ratingP = $_POST['ratingPost'];
       $reviewP = $_POST['reviewPost'];

       $reviewInsert = mysqli_query($conn, "insert into ratings (userid, exhibitionid, rating, review, datePosted)
       VALUE ('$uid', '$exid', '$ratingP', '$reviewP', now() )");

       $reviewInsert;
       header('Location: ' . $_SERVER['HTTP_REFERER'] ."&err=Review Posted!");
      }
  }


//users should only be allowed to rate/review once.
//func to check if the present user has already posted a review on the specific exhibition.
function check_dplc($u, $e) {
  require("../includes/dbconx.php");
  $dplcReview = "SELECT userid, exhibitionid FROM ratings WHERE userid LIKE $u AND exhibitionid LIKE $e";

  $check = $conn->query($dplcReview);
  if
    (
    $check->num_rows > 0
    ){
    //user has already posted a review on this exhibition - above func will deny insert
    return 1;
    }
  else  {
    //user has not posted a reivew on this ehxibiton - above function will insert if not empty
    return 0;
  }
}

function check_booked($u, $e){
  require("../includes/dbconx.php");
  $bookingSql = "SELECT userid, exhibitionid from tickets where userid LIKE $u AND exhibitionid LIKE $e";

  $check = $conn->query($bookingSql);
  if
    (
    $check->num_rows > 0
    ){
    //user has booked a ticket
    return 1;
    }
  else  {
    //user has not posted a reivew on this ehxibiton - above function will insert if not empty
    return 0;
  }

}

//func to validate user data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//fix / add this one later

// function checkuname($_POST['reviewPost']){
// {
//     $regex = "/^[\w.-]*$/";
//     if (!preg_match($regex, $_POST['reviewPost']))
//     {
//         return 0;
//     }
//      else
//     {
//         return 1;
//     }
// }
//}


 ?>

<div class="container">
  <div class="reviewsContainer">
<?php
$username = $review = $rating = $image = $role=""; $times;
// view exibitions select statement
$sqlReviewUser = mysqli_query($conn, "SELECT U.userid, R.review, R.rating, R.userid, R.datePosted, U.username, U.image, U.role, R.exhibitionid FROM users U
    INNER JOIN ratings R ON R.userid = U.userid
    WHERE R.exhibitionid LIKE $exid");

    //function below figures out how long ago the review was posted
    include('timeAgoFunc.php');
//this.review

while($row = mysqli_fetch_array($sqlReviewUser))
  {
    global $username; global $review; global $rating; global $image; global $datePost; global $role; global $uid;
    $specUid = $row['userid'];
    $username = $row['username'];
    $review = $row['review'];
    $datePost = $row['datePosted'];
    $rating =  $row['rating'];
    $image =  $row['image'];
    $role = $row['role'];

    ?>

    <div class="singleReview row">
      <div class="col-xs-2">
        <img class="userAvatar" src='img/<?php echo $image; ?>' alt="user avatar">
      </div>
      <div class="reviewText col">
        <div class="topofReview">
          <p class="userUsername bold"><?php echo $username; ?></p>
          <!-- below uses the ago func defined in timeagofunc.php to display how long ago the review was posted. -->
          <p class="xHoursAgo"> - <?php echo ago(strtotime($datePost)); ?> </p><br/>

        </div>
          <p class="reviewText"> <?php echo $review; ?> </p>

        <?php if($uid === $specUid /*|| isAdmin*/ ) {?>
        <a href="php/delReview.php?uid=<?php echo $specUid;?>&exid=<?php echo $exid;?>"><button type="button" class="deleteReviewBtn" name="button">delete</button></a>
        <?php  }?>

        </div>

      <?php if($rating == 3 || $rating == 2 || $rating == 1){ ?>
        <div class="col-xs-2 userRatingRED"> <!-- if its 10 do something else -->
          <span><?php echo $rating; ?></span>
        </div>
      <?php } ?>

      <?php if($rating == 6 || $rating == 5 || $rating == 4){ ?>
        <div class="col-xs-2 userRatingORANGE"> <!-- if its 10 do something else -->
          <span><?php echo $rating; ?></span>
        </div>
      <?php } ?>

    <?php if($rating == 7 || $rating == 8 || $rating == 9){ ?>
      <div class="col-xs-2 userRatingGREEN"> <!-- if its 10 do something else -->
        <span><?php echo $rating; ?></span>
      </div>
    <?php } ?>

    <?php if($rating == 10){ ?>
      <div class="col-xs-2 userRatingTEN"> <!-- if its 10 do something else -->
        <span><?php echo $rating; ?></span>
      </div>
    <?php } ?>

    </div>
  <?php } ?>

  </div>
</div>
