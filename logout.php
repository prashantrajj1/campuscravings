<?php
// Clear the user_auth cookie by setting its expiration time in the past
setcookie("user_auth", "", time() - 3600, "/");
header("Location: login.php");
exit;
?>
