<?php
session_start();
include('../includes/dbconx.php');

$uid = $_SESSION['uid'];
$role = $_SESSION['userrole'];

if($role != 'admin'){
    header('location: userProfile.php');
}

$exid = $_GET['exid'];

#set cancel to 1
#change this to update the cancelTime
$setCancel = mysqli_query($conn, "UPDATE exhibitions SET cancel = 1, canceledOn = now() WHERE exhibitionid = $exid");

if($setCancel){
  #select users who have booked a ticket
  $usersOnEx = mysqli_query($conn, "SELECT * FROM tickets T INNER JOIN exhibitions E ON T.exhibitionid = E.exhibitionid WHERE E.exhibitionid = $exid");

  while($row = mysqli_fetch_array($usersOnEx)){
    $ALERTuid = $row['userid'];

    $selectAlertedUid = mysqli_query($conn, "SELECT * FROM users where userid like $ALERTuid");
    $useridsNotified = mysqli_fetch_assoc($selectAlertedUid);
    $notifyUid = $useridsNotified['userid'];

    $notifyUsers = mysqli_query($conn, "UPDATE users SET needsNotified = 1 where userid = $notifyUid");
    $notifyUsers;
  }
  header('location: ../admin.php?alertBarMsg=Cancelled Exhibition and notified attending users.');




#  echo $cancelExUserid;

} else {
  header('location: ../admin.php?alertBarMsg=server error - try again later');
}

#set cancelledOn to the present date/time


#set user notified to 1

#delete user Tickets



 ?>
