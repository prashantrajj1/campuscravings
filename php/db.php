<?php

$conn = new mysqli("localhost","root","","campuscravings");

if($conn->connect_error){
die("Connection failed");
}

?>