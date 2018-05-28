<?php

// code to log he user out and link them back to index page.
session_start();
session_destroy();
$message = "You have logged out successfully!";
header("location: ../index.php?alertBarMsg={$message}");
 ?>
