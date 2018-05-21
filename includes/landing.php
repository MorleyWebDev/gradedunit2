<?php
session_start();

 if(!isset($_SESSION["authuser"])){
  ?>
  <div class="jumbotron">
    <h2>Welcome </h2>
      <div class="container">
        <p class="light centerText margintop">we host a variety of exhibitions which will take you on an extensive, once in a lifetime journey through science, religion and art. ntum, nibh magna blandit ipsum, eget porttitor augue lectus aliquam tortor. Nam bibendum risus in finibus luctus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean rutrum, velit id condimentum sodales, dui nisi feugiat urna, eu sagittis diam velit nec lacus. Aliquam mi ipsum, bibendum et ex at, suscipit feugiat nisi. Aliquam feugiat rutrum justo nec tempus. Vivamus ornare nulla porttitor massa imperdiet ornare. Donec turpis lectus, interdum at purus vel, accumsan dictum tellus. Pellentesque fringilla varius imperdiet.</p>
      </div>
  </div>
  <div class="container midIndex">
    <div class="midIndexContent">
      <h3 class="centerText marginbottom">That all sounds great, but why should I register an account?</h3>
      <p class="margintop">An excellent question, most of our exhibitions have a limited amount of tickets avaliable, we need to keep track of who is attending which exhibits and when. So whilst creating an account is mostly to help us stay organized. Creating an account will also allow you to
        <ul>
          <li>Book/cancel tickets for exhibitions / display them on your profile page so you wont forget when they open/close.</li>
          <li>Post Reviews for exhibitions</li>
          <li>Rate Exhibitions on a 1-10 scale (Your rating will impact the exhibitions average score)</li>
          <li>Stay notified - You will be messaged on the site if any exhibitions you book have urgent changes</li>
        </ul>
        <p>Still not convinced? You could always ask our <a href="chatbot/bot.php">chatbot</a> if he knows any other benefits of registering. But for everyone else:</p>
        <a href="register.php"><button type="button" name="button">Let's Register!</button></a>
    </div>
  </div>


  <?php
  } else {
    $uid = $_SESSION['id'];
    $userDetails = mysqli_query($conn, "SELECT username from users where userid = $uid");
    while($row = mysqli_fetch_array($userDetails)){
      $un = $row['username'];

  ?>
  <div class="jumbotron">
    <h2>Welcome, <?php echo $un; }?>. </h2>
    <div class="container">
      <p class="light centerText margintop">we host a variety of exhibitions which will take you on an extensive, once in a lifetime journey through science, religion and art. ntum, nibh magna blandit ipsum, eget porttitor augue lectus aliquam tortor. Nam bibendum risus in finibus luctus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean rutrum, velit id condimentum sodales, dui nisi feugiat urna, eu sagittis diam velit nec lacus. Aliquam mi ipsum, bibendum et ex at, suscipit feugiat nisi. Aliquam feugiat rutrum justo nec tempus. Vivamus ornare nulla porttitor massa imperdiet ornare. Donec turpis lectus, interdum at purus vel, accumsan dictum tellus. Pellentesque fringilla varius imperdiet.</p>
    </div>
  </div>

  <div class="container midIndex">
    <div class="midIndexContent">
      <h2>So, what happens now?</h2>
      <ul>
        <li>You could visit <a href="userProfile.php">your profile</a> page where you can view your bookings / change any personal details</li>
        <li>You could ask our <a href="chatbot/bot.php">chatbot</a> what exhibitions are currently on</li>
        <li>You could take a look at <a href="exhibitionsMain.php"> all the exhibitions</a> currently running</li>
        <li>You could scroll down the page to see what the top 3 exhibits are at the moment</li>
        <li>Looking for something specific? Our search bar at the top of the page will let you filter through all our exhibitions</li>
      </ul>

    <p>You can only review exhibitions you own tickets for.</p>
</div>
  </div>


  <?php
  }
  ?>
