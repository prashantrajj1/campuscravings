<?php
$servername = "localhost";
$username = "root"; // Default XAMPP/WAMP username
$password = ""; // Default empty password
$dbname = "food_system";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
