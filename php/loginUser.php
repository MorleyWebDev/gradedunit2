<?php
ini_set('desplay_errors', 'on');
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include('../includes/dbconx.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["un"]);
  $pw = test_input($_POST["pw"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$username = mysqli_real_escape_string($conn, $name);
$password = mysqli_real_escape_string($conn, $pw);

$sql = "select * from users where username = '".$username."'";

$query = mysqli_query($conn, $sql);
$numRows = mysqli_num_rows($query);

if($numRows == 1){
  $row = mysqli_fetch_assoc($query); //return the matched result set which will contain a username and a password
  if(password_verify($password, $row['password'])){ //verify submitted password
    $_SESSION['id'] = $row['userid'];
    $_SESSION['name'] = $row['firstname'];
    $_SESSION["username"] = $username;
    $_SESSION['authuser'] = 1; //if statement above this one for admin login
    $_SESSION['userrole'] = $row['role'];
    $_SESSION['needsNotify'] = $row['needsNotified'];
    //take user back to previous page
    header('Location: ../index.php?alertBarMsg=Log in succesful! We will occasionally post notifications up here. Just click to close them');
  } else {
  header("location: ../register.php?alertBarMsg=Incorrect username/password combination, please try again Hits");
  }
} else {  header("location: ../register.php?alertBarMsg=Incorrect username / password combination, please try again"); }
?>
