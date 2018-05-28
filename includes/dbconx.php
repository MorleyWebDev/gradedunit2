<?php
global $conn;
// connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbase = "gradedunit2";
// Create connection
global $conn;
$conn = new mysqli($servername, $username, $password, $dbase);
// Check connection
if ($conn->connect_error) {
die("<p class='centerText'>We can't connect to our database. This website is almost entirely
serverside, you will not be able to browse it without first connecting.
Please try again later</p><p class='light centerText'>If this problem persists
you could try asking our chatbot for information about exhibitions!</p> ");
}
?>
