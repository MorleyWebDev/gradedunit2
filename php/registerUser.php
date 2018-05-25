<?php
require('includes/dbconx.php');
require('includes/consolelog.php');






if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $unameErr = $passwordErr = $emailErr = $firstnameErr = $lastnameErr = $noErr = $roleErr = "";
  $uname = $password = $email = $firstname = $lastname = $no = $role = "";
  $unameV = $passwordV = $emailV = $firstnameV = $lastnameV = $noV = $roleV = $unameSyntax = 0;


    if (empty($_POST["firstname"])) {
        $firstnameErr = "- required field";
    } else {
        $firstname = test_input($_POST["firstname"]);
        $firstnameV = 1;
    }
    if (empty($_POST["email"])) {
        $emailErr = "- required field";
    } else {
        $email = test_input($_POST["email"]);
        $emailV = 1;
    }
    if (empty($_POST["phonenumber"])) {
        $noErr = "- required field";
    } else {
        $no = test_input($_POST["phonenumber"]);
        $noV = 1;
    }
    if (empty($_POST["lastname"])) {
        $lastnameErr = "- required field";
    } else {
        $lastname = test_input($_POST["lastname"]);
        $lastnameV = 1;
    }
    if (empty($_POST["username"])) {
        $unameErr = "- required field";
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
        $passwordErr = "- required field";
    } else {
        $passwordNew = test_input($_POST["password"]);
        $hashPassword = password_hash($passwordNew, PASSWORD_DEFAULT);
        $passwordV = 1;
    }
}

function test_input($data)
{
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
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
              $sql = "insert into users (username, password, firstname, lastname, email, phonenumber, role, avatar)
                      VALUE ('$uname', '$hashPassword', '$firstname', '$lastname', '$email', '$no', 'creator', 'defaultAvatar.png')";

              $result = mysqli_query($conn, $sql);
              if ($result) {
                 $uname = $passwordNew = $firstname = $lastname = $email = $password = $firstname = $no = "";
                  echo "<div class='container'><div class='registerSuccess'>Account created. Try logging in with your username and password!</div></div>";

              } else {
                  echo "something went wrong iwth insert... - " . $result;
              }
          } else {
              $unameErr = "Username must be letters and numbers only with no spaces. Sorry!";
          }
      } else{
          $unameErr = "Username already in use, sorry!";
      }
  }
}



?>
