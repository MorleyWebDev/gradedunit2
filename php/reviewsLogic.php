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
// } div - userid is 6






 if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if(isset($_SESSION['id']))
   {
     $uid = $_SESSION['id'];
   }

   $exid = $_GET["exid"];

  if(empty($_POST['reviewPost'])){
    header('Location: ' . $_SERVER['HTTP_REFERER'] ."&err=Make Sure you type a review!");
  } else {

    if( check_dupes($uid, $exid) == 1 ){
      header('Location: ' . $_SERVER['HTTP_REFERER'] ."&err=Sorry, you have already posted a review for this exhibiton! You could always delete it if you want to post another.");
    } else {
      /*REGEX HERE?*/
       test_input($_POST['reviewPost']);

       $ratingP = $_POST['ratingPost'];
       $reviewP = $_POST['reviewPost'];

       $reviewInsert = mysqli_query($conn, "insert into ratings (userid, exhibitionid, rating, review)
                              VALUE ('$uid', '$exid', '$ratingP', '$reviewP')");
      $reviewInsert;
       echo "inserted";
      }
  }
}



function check_dupes($u, $e) {
  require("../includes/dbconx.php");
  global $dups;
  $dupReview = "SELECT userid, exhibitionid FROM ratings WHERE userid LIKE $u AND exhibitionid LIKE $e";

  $check = $conn->query($dupReview);
  if($check->num_rows > 0){
    //user has already posted a review on this exhibition - above func will deny insert
    return 1;
  } else {
    //user has not posted a reivew on this ehxibiton - above function will insert if not empty
    return 0;
  }
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//fix / add this one later

// function checkuname($_POST['reviewPost'])
// {
//     $regex = "/^[\w.-]*$/";
//     if (!preg_match($regex, $un)) {
//         return 0;
//     } else {
//         return 1;
//     }
// }


 ?>



<?php
// view exibitions
$sqlReviewUser = mysqli_query($conn, "SELECT R.review, R.rating, R.userid, U.username, U.image, R.exhibitionid
                              FROM users U INNER JOIN ratings R ON R.userid = U.userid WHERE R.exhibitionid LIKE $exid");

//this.review
while($row = mysqli_fetch_array($sqlReviewUser)){
echo "<div class='reviewBox'>";

echo "<p> Username - " . $row['username'];
echo "<p> Review -" . $row['review'];
echo "<p> Rating -" . $row['rating'];
echo "<p> image url - " . $row['image'];

echo "</div>";
}

 ?>
