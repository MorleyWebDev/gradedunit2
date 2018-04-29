<?php
ini_set('desplay_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('includes/dbconx.php');
require('includes/consolelog.php');


$unameErr = $passwordErr = $emailErr = $firstnameErr = $lastnameErr = $noErr = $roleErr = "";
$uname = $password = $email = $firstname = $lastname = $no = $role = "";
$unameV = $passwordV = $emailV = $firstnameV = $lastnameV = $noV = $roleV = $unameSyntax = 0;




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstname"])) {
        $firstnameErr = "A first name is required";
    } else {
        $firstname = test_input($_POST["firstname"]);
        $firstnameV = 1;
    }
    if (empty($_POST["email"])) {
        $emailErr = "An email is required";
    } else {
        $email = test_input($_POST["email"]);
        $emailV = 1;
    }
    if (empty($_POST["phonenumber"])) {
        $noErr = "A phone number is required";
    } else {
        $no = test_input($_POST["phonenumber"]);
        $noV = 1;
    }
    if (empty($_POST["lastname"])) {
        $lastnameErr = "A last name is required";
    } else {
        $lastname = test_input($_POST["lastname"]);
        $lastnameV = 1;
    }
    if (empty($_POST["username"])) {
        $unameErr = "A username is required";
    } else
    {
        $uname = test_input($_POST["username"]);
        $unameV = 1;
    }
    if (checkuname($_POST['username'])!==1){
        $unameErr = "Username must be letters and numbers only, sorry!";
    } else{
        $unameSyntax = 1;
    }
    if (empty($_POST["password"])) {
        $passwordErr = "A password is required";
    } else {
        $password = test_input($_POST["password"]);
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $passwordV = 1;
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = (htmlspecialchars($data));
    return $data;
}

function checkExists($name)
{
    global $conn;
    require('includes/dbconx.php');
    $check = "select * from users where username = '$name'";
    $userCheck = $conn->query($check);

    if ($userCheck->num_rows > 0) {
        return 0;
    } else {
        return 1;
    }
}

function checkuname($un)
{
    $regex = "/^[\w.-]*$/";
    if (!preg_match($regex, $un)) {
        return 0;
    } else {
        return 1;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        $firstnameV == 1
        && $emailV == 1
        && $noV == 1
        && $lastnameV == 1
        && $unameV == 1
        && $passwordV == 1
        //&& (checkExists($uname) == 1)
    ) {
      if (checkExists($uname) ==1 ) {
          if (checkuname($uname) == 1) {
              $sql = "insert into users (username, password, firstname, lastname, email, phonenumber, role)
                      VALUE ('$uname', '$hashPassword', '$firstname', '$lastname', '$email', '$no', 'creator')";

              $result = mysqli_query($conn, $sql);
              if ($result) {
                  header("location: register.php?message=Account Created, you can now login");

              } else {
                  echo "something went wrong iwth insert... - " . $result;
              }
          } else {
              $unameErr = "Username must be letters and numbers only, sorry!";
          }
      } else{
          $unameErr = "Username already in use, sorry!";
      }
  }
}



?>
