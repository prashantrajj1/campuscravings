<?php
// payment page - shows QR code and confirms payment
// the qr is just a placeholder image rn - need to integrate actual UPI later
// campuscravings
session_start();
if (!isset($_SESSION['user_id'])) {
header("Location: login.php");
    exit;
}

require_once 'php/db_connect.php';

$msg = "";
$done = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amt = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0;

    // user clicked "I have completed payment"
if (isset($_POST['confirm_payment'])) {
        $uid = $_SESSION['user_id'];

        // save order to database
        // restaurant_id is NULL because cart can have items from multiple restaurants
        // TODO: fix this to track restaurant properly
        $sql = "INSERT INTO orders (user_id, total_amount, status) VALUES ('$uid', '$amt', 'Pending')";

    if (mysqli_query($conn, $sql)) {
            $done = true;
            $newOrderId = mysqli_insert_id($conn);
            // echo "order saved: #" . $newOrderId; // debug
        }
    else {
            $msg = "Failed to place order. Try again.";
            // log error for debugging
            // echo mysqli_error($conn);
        }
    }
}
else {
    // if someone tries to open this page directly without POST data
header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - CampusCravings</title>
    <link rel="stylesheet" href="css/home.css">
<link rel="stylesheet" href="css/payment.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍴</text></svg>">
</head>

<body>

<div class="wrapper">
        <header class="topbar">
            <div class="sitename">Campus<span>Cravings</span></div>
        </header>

        <div class="pay-box">

        <?php if ($done): ?>
            <!-- success screen after payment confirmed -->
            <h1 class="success-heading">Order Placed Successfully!</h1>
            <p class="success-msg">Your Order ID is <strong>#<?php echo $newOrderId; ?></strong>.</p>
        <p>We are preparing your food. You can track your order in your profile.</p>
            <a href="profile.php" class="orange-btn block-link">View Order History</a>

            <script>
            // clear the cart from localStorage since order is placed
        console.log("order placed!! clearing cart");
            localStorage.removeItem('cart');
            console.log("cart cleared from localStorage");
            </script>

            <?php else: ?>
            <!-- QR code screen - payment pending -->
        <h2 class="qr-heading">Scan to Pay</h2>
            <div class="qr-box">
                <!-- TODO: replace with actual UPI QR code -->
                <img src="assets/images/qr.png" alt="QR Code">
            </div>
        <p>Scan the QR code with any UPI app</p>
            <div class="total-amount">₹ <?php echo number_format($amt, 2); ?></div>

        <?php if ($msg): ?>
            <p class="error-msg"><?php echo $msg; ?></p>
            <?php endif; ?>

        <form action="payment.php" method="POST">
                <input type="hidden" name="total_amount"
                    value="<?php echo htmlspecialchars($amt); ?>">
                <button type="submit" name="confirm_payment" class="confirm-btn">
                    I have completed payment
                </button>
            </form>
        <?php endif; ?>
        </div>
    </div>

</body>

</html>