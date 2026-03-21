<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'php/db_connect.php';

$message = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total_amount = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0;
    
    if (isset($_POST['confirm_payment'])) {
        // Process the final order insertion
        $user_id = $_SESSION['user_id'];
        
        $insert_order = "INSERT INTO orders (user_id, total_amount, status) VALUES ('$user_id', '$total_amount', 'Pending')";
        
        if (mysqli_query($conn, $insert_order)) {
            $success = true;
            $order_id = mysqli_insert_id($conn);
        } else {
            $message = "Failed to place order. Try again.";
        }
    }
} else {
    // If not POST, redirect back to home
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
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        .payment-box {
            max-width: 500px;
            margin: 50px auto;
            background: var(--card-bg);
            padding: 40px;
            text-align: center;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .qr-placeholder {
            width: 250px;
            height: 250px;
            margin: 20px auto;
            background: #f1f2f6;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            border: 2px dashed #ccc;
        }
        .total-pay {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 15px 0;
        }
        .btn-confirm {
            background: var(--swiggy-green);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            text-transform: uppercase;
        }
        .success-icon {
            font-size: 5rem;
            color: var(--swiggy-green);
            margin-bottom: 20px;
        }
    </style>
</head>
<body style="background: var(--bg-light);">

    <div class="app-container">
        <header class="app-header">
            <div class="logo-desktop">Campus<span>Cravings</span></div>
        </header>

        <div class="payment-box">
            <?php if ($success): ?>
                <i class="fa-solid fa-circle-check success-icon"></i>
                <h1 style="color: var(--swiggy-green);">Order Placed Successfully!</h1>
                <p style="color: #666; margin: 20px 0; font-size: 1.1rem;">Your Order ID is <strong>#<?php echo $order_id; ?></strong>.</p>
                <p>We are preparing your food. You can track your order in your profile.</p>
                <a href="profile.php" class="btn-primary" style="display: block; margin-top: 30px;">View Order History</a>
                
                <script>
                    // Clear the cart since the order was successful
                    localStorage.removeItem('cart');
                </script>
            <?php else: ?>
                <h2 style="color: var(--text-main);">Scan to Pay</h2>
                <div class="qr-placeholder">
                    <i class="fa-solid fa-qrcode" style="font-size: 8rem; color: #cbd5e1;"></i>
                </div>
                <p>Scan the QR code with any UPI app</p>
                <div class="total-pay">₹<?php echo number_format($total_amount, 2); ?></div>
                
                <?php if($message): ?>
                    <p style="color: red;"><?php echo $message; ?></p>
                <?php endif; ?>

                <form action="payment.php" method="POST">
                    <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($total_amount); ?>">
                    <button type="submit" name="confirm_payment" class="btn-confirm">I have completed payment</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
