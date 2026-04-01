<?php
// login page - campuscravings
// handles POST login and shows login form
session_start();
require_once 'php/db_connect.php';

$err = "";

// check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $userPass = $_POST['password'];

    // basic check - both fields required
    if (empty($userEmail) || empty($userPass)) {
        $err = "Email and Password are required.";
    }
    else {
        // look up user by email
        $q = "SELECT id, email, password FROM users WHERE email = '$userEmail'";
        $res = mysqli_query($conn, $q);
        $found = mysqli_fetch_assoc($res);

        // password_verify checks the hashed password from db
        if ($found && password_verify($userPass, $found['password'])) {
            $_SESSION['user_id'] = $found['id'];
            $_SESSION['email'] = $found['email'];
            // echo "login success!"; // debug
            header("Location: home.php");
            exit;
        }
        else {
            $err = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CampusCravings</title>
    <link rel="stylesheet" href="css/login.css">
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍴</text></svg>">
</head>

<body>
    <div class="logo">
    Campus <span>Cravings</span>
    </div>

    <div class="login-box">
        <div class="form">
        <?php if (!empty($err)): ?>
            <h2 id="errlogs" style="color:red; font-size:14px;"><?php echo $err; ?></h2>
            <?php else: ?>
            <h2 id="errlogs"></h2>
        <?php endif; ?>

            <form action="login.php" method="POST">
                <label for="email">Email: </label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="password">Password: </label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>

            <button type="submit" class="btn">Login</button><br><br>
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </form>
        </div>
</div>
</body>

</html>