<!-- script for update detaails  -->

<!-- <script type="text/javascript">
// $(".updateDetailsBtn").click(function(){
//   $(this).data('clicked', true);
// });

// if($('#element').data('clicked')) {
//     alert('yes');
// } else {
// kill(thispage)
//}
</script> -->

<?php

include('includes/dbconx.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstnameExists = $lastnameExists = $unExists = $emailxExists = $noexists = 0;


   if (empty($_POST["frstName"])) {
     $firstnameEr = " - required field";
   } else {
     $firstN = $_POST['frstName'];
     $firstnameExists = 1;
   }

   if (empty($_POST["scndName"])) {
     $secondnameEr = " - required field";
   } else {
     $lastN = $_POST['scndName'];
     $lastnameExists = 1;
   }


   if (empty($_POST["usrname"])) {
     $unEr = " - required field";
   } else {
     $un = $_POST['usrname'];
     $unExists = 1;
   }


   if (empty($_POST["emailx"])) {
     $emailEr = " - required field";
   } else {
     $email = $_POST['emailx'];
     $emailxExists = 1;
   }


   if (empty($_POST["phoneNo"])) {
     $noEr = " - required field";
   } else {
     $phoneNo = $_POST['phoneNo'];
     $noExists = 1;
   }

   if(
     $noExists == 1 &&
     $emailxExists == 1 &&
     $unExists == 1 &&
     $lastnameExists == 1 &&
     $firstnameExists == 1
   ){
     $updateDetails = mysqli_query(
     $conn,"UPDATE users
     SET firstname = '$firstN',
     lastname = '$lastN',
     username = '$un',
     email = '$email',
     phonenumber = '$phoneNo'
     WHERE userid = '$uid'");



     if($updateDetails){
       //on username change the session for username
      $_SESSION['username'] = $un;
      header('location: userProfile.php?alertBarMsg=Details changed successfully!');

    }


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
