<?php
session_start();
include('../includes/dbconx.php');
$uid = $_SESSION['id'];
$role = $_SESSION['userrole'];
#if user is not using an admin account - take them to their profile page
if($role != 'admin'){
  header('location: ../userProfile.php');
}
#only execute php on post request to the page.
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  #gets the user id of the user whos role you wish to edit
  $uidToEdit = $_POST['postuserId'];
  #gets the new role the administrator selected for the user
  $newRole = $_POST['userrole'];
  #update the users role

if($newRole != 'none'){
    $sqlUpdate = mysqli_query($conn, "UPDATE users SET role = '$newRole' WHERE userid = '$uidToEdit'");
    if($sqlUpdate){
      header('location: ../admin.php?alertBarMsg=User role updated');
    } else {
      echo "server error?" . $newRole . $uidToEdit;
    }
} else {
      header('location: ../admin.php?alertBarMsg=You were warned bucko. Make sure you select a real role next time.');
}

}

?>
