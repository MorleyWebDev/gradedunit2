<?php
session_start();
session_destroy();
$message = "You have logged out successfully!";
header("location: ../index.php?message={$message}");
 ?>
