<?php

include 'connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $food_details = $_POST['food_details'];
    $total_amount = $_POST['total_amount'];
    
    
    $sql = "INSERT INTO orders (customer_name, customer_email, food_details, total_amount)
            VALUES ('$customer_name', '$customer_email', '$food_details', '$total_amount')";

    
    if (mysqli_query($conn, $sql)) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Order Confirmed</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body style="background-color: #F8F9FA; text-align: center; padding: 50px;">
            <div class="container" style="max-width: 600px; display: inline-block;">
                <h1 style="color: #7BB21B;">Order Placed Successfully!</h1>
                <h3 style="color: #2B2B2B;">Thank you, <?php echo htmlspecialchars($customer_name); ?>!</h3>
                
                <p style="font-size: 18px; margin: 20px 0;">
                    Your delicious items: <strong><?php echo htmlspecialchars($food_details); ?></strong><br><br>
                    Total Amount: <strong>₹<?php echo htmlspecialchars($total_amount); ?></strong>
                </p>
                
                <a href="../index.html" class="btn-primary">Return to Home</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Error placing order: " . mysqli_error($conn);
    }
    
    
    mysqli_close($conn);
}
?>
