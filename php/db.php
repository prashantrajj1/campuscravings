<?php

$conn = new mysqli("localhost","root","","food_system");

if($conn->connect_error){
die("Connection failed");
}

?>