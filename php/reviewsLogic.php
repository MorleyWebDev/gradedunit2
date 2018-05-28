<?php
session_start();
// only execute code on post req
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exid = $_GET["exid"];
// get user id if they have one
   if(isset($_SESSION['id'])){
     $uid = $_SESSION['id'];
   }
// if no review link back - no longer needed with required field
  if(empty($_POST['reviewPost'])){
    header('Location: ' . $_SERVER['HTTP_REFERER'] ."&alertBarMsg=Make Sure you type a review before posting!");
  }

// if trying to post dup review - link back to ex with error
  else if(check_dplc($uid, $exid) == 1) {
    header('Location: ' . $_SERVER['HTTP_REFERER'] ."&alertBarMsg=Sorry, you have already posted a review for this exhibiton! You could always delete it if you want to post another.");
  }

  #this will not fire anymore. jQuery stops users who have not booked from submitting data.
  #kept in anyway incase user accesses this page through url with a fake post req
  else if(check_booked($uid, $exid) == 0) {
    header('Location: ' . $_SERVER['HTTP_REFERER'] ."&alertBarMsg=you need to book a ticket. - ");
  }

// if its the users first review on the ex and they have booked a ticket post the review
     else {
      $dateTime = gmdate('Y-m-d h:i:s \G\M\T', time());
      $reviewP = test_input($_POST['reviewPost']);
      // prevent sql inject
      $reviewP = mysqli_real_escape_string($conn, $reviewP);
       $ratingP = $_POST['ratingPost'];
       // fix for editing html value to post a score above 10
       if($ratingP <= 10) {
         // the insert
         $reviewInsert = mysqli_query($conn, "insert into ratings (userid, exhibitionid, rating, review, datePosted)
         VALUE ('$uid', '$exid', '$ratingP', '$reviewP', now() )");

         $reviewInsert;
         // when posted link urser back to page
         header('Location: ' . $_SERVER['HTTP_REFERER'] ."&alertBarMsg=Review Posted!");

      } else {
        // if user edits html value to post a score above 10
        header('location:' . $_SERVER['HTTP_REFERER'] . "&alertBarMsg=Watch it bucko - you are not allowed to post ratings above 10.");}
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

 ?>

<div class="container">
  <div class="reviewsContainer">
<?php
$username = $review = $rating = $image = $role=""; $times;
// view exibitions select statement
$sqlReviewUser = mysqli_query($conn, "SELECT U.userid, R.review, R.rating, R.userid, R.datePosted, U.username, U.avatar, U.role, R.exhibitionid FROM users U
    INNER JOIN ratings R ON R.userid = U.userid
    WHERE R.exhibitionid LIKE $exid ORDER BY datePosted DESC");

    $rowcount = mysqli_num_rows($sqlReviewUser);

    //function below figures out how long ago the review was posted
    include('timeAgoFunc.php');
#if no reviews display encouraging message
if($rowcount == 0){
     echo "<div class='NMScard'> <p class='centerText pNoMarginBelow'> Be the first to review this exhibition!</p></div>";
   }

while($row = mysqli_fetch_array($sqlReviewUser))
  {
    global $username; global $review; global $rating; global $avatar;
    global $datePost; global $role; global $uid; global $rowcount;
    $specUid = $row['userid'];
    $username = $row['username'];
    $review = $row['review'];
    $datePost = $row['datePosted'];
    $rating =  $row['rating'];
    $image =  $row['avatar'];
    $role = $row['role'];
    ?>

<!-- below is for displaying the reviews -->

    <div class="singleReview row">
      <div class="col-xs-2">
        <img class="userAvatar" src='img/userUploaded/<?php echo $image; ?>' alt="user avatar">
      </div>
      <div class="reviewText col">
        <div class="topofReview">
          <p class="userUsername bold"><?php echo $username; ?></p>
          <!-- below uses the ago func defined in timeagofunc.php to display how long ago the review was posted. -->
          <p class="xHoursAgo"> - <?php echo " " . ago(strtotime($datePost)); ?> </p><br/>

        </div>
          <p class="reviewText"> <?php echo $review; ?> </p>
          <!-- only display delete when user posted review or when usr is admin -->
        <?php if($uid === $specUid || $_SESSION['userrole'] == 'admin') {?>
          <button type="button" class="btnStyle" data-toggle="modal" data-target="#ConfirmReviewDelete<?php echo $specUid;?>">Delete</button>
        <?php  }?>

        </div>

      <?php if($rating == 3 || $rating == 2 || $rating == 1){ ?>
        <div class="col-xs-4 userRatingRED"> <!-- red for low score -->
          <span><?php echo $rating; ?></span>
        </div>
      <?php } ?>

      <?php if($rating == 6 || $rating == 5 || $rating == 4){ ?>
        <div class="col-xs-4 userRatingORANGE"> <!-- orange for mid score -->
          <span><?php echo $rating; ?></span>
        </div>
      <?php } ?>

    <?php if($rating == 7 || $rating == 8 || $rating == 9){ ?>
      <div class="col-xs-4 userRatingGREEN"> <!-- green for high score -->
        <span><?php echo $rating; ?></span>
      </div>
    <?php } ?>

    <?php if($rating == 10){ ?>
      <div class="col-xs-8 userRatingTEN"> <!-- site cyan for 10 -->
        <span><?php echo $rating; ?></span>
      </div>
    <?php } ?>

    </div>


    <div id="ConfirmReviewDelete<?php echo $specUid; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content for the delete review confiramtion-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirm Delete</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>Are you sure you wish to delete this review?</p>

          <a class="btnStyle" href="php/delReview.php?uid=<?php echo $specUid;?>&exid=<?php echo $exid;?>">Delete it</a>

      </div>
      <div class="modal-footer">
        <button type="button" class="btnStyle btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
</div></div>
  <?php } ?>






  </div>
</div>
