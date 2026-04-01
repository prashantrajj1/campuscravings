<?php
// register page - campuscravings
// by prashant
session_start();
require_once 'php/db_connect.php';

$err = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nm = mysqli_real_escape_string($conn, $_POST['name']);
$em = mysqli_real_escape_string($conn, $_POST['email']);
    $ph = mysqli_real_escape_string($conn, $_POST['phone']);
    $pw = $_POST['password'];

    // all fields must be filled
if (empty($nm) || empty($em) || empty($ph) || empty($pw)) {
        $err = "All fields are required";
    } else {
        // check if email already taken
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$em'");
    
        if ($check && mysqli_num_rows($check) > 0) {
            $err = "Email already registered";
    } else {
            // hash the password before storing
            $hashedPw = password_hash($pw, PASSWORD_DEFAULT);
            $ins = "INSERT INTO users (name, email, phone, password) VALUES ('$nm', '$em', '$ph', '$hashedPw')";
            
        if (mysqli_query($conn, $ins)) {
                // auto login after register
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                $_SESSION['email'] = $em;
            header("Location: home.php");
                exit;
            } else {
                $err = "Registration failed: " . mysqli_error($conn);
            // should probably log this somewhere - TODO
            }
        }
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CampusCravings</title>
    <link rel="stylesheet" href="css/login.css">
    <script>
    // client side password validation
    // ayush added this because people kept submitting mismatched passwords
    console.log("register page loaded");
document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('form');
        var errDiv = document.getElementById('errlogs');
    var pw1 = document.getElementById('password');
        var pw2 = document.getElementById('confirm-password');

        console.log("form elements found");

    function checkPasswords() {
            var pass = pw1.value;
            var confirm = pw2.value;
            console.log("checking passwords, length: " + pass.length);

        if (confirm !== "" && pass !== confirm) {
                errDiv.textContent = "Passwords do not match";
                errDiv.style.color = "red";
            errDiv.style.fontSize = "14px";
                console.log("passwords dont match!");
                return false;
        } else {
                errDiv.textContent = "";
                return true;
            }
        }

    pw1.addEventListener('input', checkPasswords);
        pw2.addEventListener('input', checkPasswords);

        form.addEventListener('submit', function(e) {
        console.log("form submitted, validating...");
            if (!checkPasswords()) {
                e.preventDefault();
                console.log("stopped form - passwords dont match");
        }
        });
    });
    </script>
</head>
<body>
<div class="logo">
        Campus<span>Cravings</span>
    </div>

    <div class="login-box" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="form">
            <?php if (!empty($err)): ?>
                <h2 id="errlogs" style="color:red; font-size:14px;"><?php echo $err; ?></h2>
            <?php else: ?>
            <h2 id="errlogs"></h2>
            <?php endif; ?>
            
            <form action="register.php" method="POST">
                <label for="name">Full Name: </label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="email">Email: </label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                
            <label for="phone">Phone Number: </label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                
                <label for="password">Password: </label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>
                
                <label for="confirm-password">Confirm Password: </label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm password" required>

            <button type="submit" class="btn">Register</button><br><br>
                <p>Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
</div>
</body>
</html>
