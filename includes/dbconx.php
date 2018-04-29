<?php
global $conn;
$servername = "localhost";
$username = "root";
$password = "root";
$dbase = "gradedunit2";
// Create connection
global $conn;
$conn = new mysqli($servername, $username, $password, $dbase);
// Check connection
if ($conn->connect_error) {
die("<p> error connecting to db try</p>
    <p><a href='../index.php'>this</a></p>");
}
?>
