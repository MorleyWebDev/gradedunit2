<?php
session_start();
 if(!isset($_SESSION["authuser"])){
  ?>

  <div class="container">
    <h1>You are not logged in atm. Click register or login @ the nav bar</h1>
  </div>


  <?php
  } else {
  ?>
  <div class="container">
    <h1>You are now logged in.</h1>
    <p>Looking for a more INTERACTIVE EXPERIENCE? Try out our  <a href="chatbot.php">chatbot</a> - Try asking it about what exhibitions are on! </p>
  </div>


  <?php
  }
  ?>
