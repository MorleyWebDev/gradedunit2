<!-- script for  -->

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   if (empty($_POST["frstName"])) {
     $firstnameEr = " - required field";
   }

   if (empty($_POST["scndName"])) {
     $secondnameEr = " - required field";
   }

   if (empty($_POST["usrname"])) {
     $unEr = " - required field";
   }

   if (empty($_POST["emailx"])) {
     $emailEr = " - required field";
   }

   if (empty($_POST["phoneno"])) {
     $noEr = " - required field";
   }

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = (htmlspecialchars($data));
    return $data;
}


 ?>
