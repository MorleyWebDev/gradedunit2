<?php
// start session
session_start();
// db connect
include('../includes/dbconx.php');

$uid = $_SESSION['uid'];
$role = $_SESSION['userrole'];
// if user not admin role take them back to their profile
if($role != 'admin'){
    header('location: userProfile.php');
}

$exid = $_GET['exid'];

#set cancel to 1 - set canceledOn to now.
$setCancel = mysqli_query($conn, "UPDATE exhibitions SET cancel = 1, canceledOn = now() WHERE exhibitionid = $exid");
// if the cancel was correct
if($setCancel){
  #select users who have booked a ticket to notify them later
  $usersOnEx = mysqli_query($conn, "SELECT * FROM tickets T INNER JOIN exhibitions E ON T.exhibitionid = E.exhibitionid WHERE E.exhibitionid = $exid");

  while($row = mysqli_fetch_array($usersOnEx)){
    $ALERTuid = $row['userid'];
    // get users to notify
    $selectAlertedUid = mysqli_query($conn, "SELECT * FROM users where userid like $ALERTuid");
    $useridsNotified = mysqli_fetch_assoc($selectAlertedUid);
    $notifyUid = $useridsNotified['userid'];
// notify the users who are on the exhibition
    $notifyUsers = mysqli_query($conn, "UPDATE users SET needsNotified = 1 where userid = $notifyUid");
    $notifyUsers;
  }
  // confirmation message for admin  when they cancelels it
  header('location: ../admin.php?alertBarMsg=Cancelled Exhibition and notified attending users.');

} else {
  header('location: ../admin.php?alertBarMsg=server error - try again later');
}

 ?>
