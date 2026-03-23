<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campuscravings";


$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
