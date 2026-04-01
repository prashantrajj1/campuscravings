<?php
// checkout page - shows whats in the cart before payment
// cart data is stored in localStorage (javascript side)
// so this page mostly just has JS to load it
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - CampusCravings</title>
<link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/checkout.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍴</text></svg>">
</head>

<body>

    <div class="wrapper">
    <header class="topbar">
            <a href="home.php" class="backbtn">Back</a>
            <div class="sitename">🍴 Campus<span>Cravings</span></div>
        <div class="spacer"></div>
        </header>

        <main class="checkout-box">
            <h2 class="order-title">Order Summary</h2>

        <!-- JS fills this div with cart items from localStorage -->
        <div id="cart-list"></div>

            <div class="total" id="totalDiv" style="display:none;">
            <span>Total Amount</span>
                <span id="totalDisplay">₹0</span>
            </div>

            <!-- shown when cart is empty -->
            <div id="emptyMsg" class="empty-msg">
            <p>Your cart is empty.</p>
                <a href="home.php" class="empty-link">Go add some food!</a>
            </div>

            <!-- hidden form that submits to payment.php -->
            <form action="payment.php" method="POST" id="payForm" class="checkout-form" style="display:none;">
            <input type="hidden" name="total_amount" id="totalInput" value="0">
                <button type="submit" class="pay-btn">Proceed to Pay</button>
            </form>
        </main>
</div>

    <script>
    // load cart from localStorage and display it
    // the cart is an array of {name, price} objects saved as JSON
    console.log("checkout page ready");

document.addEventListener('DOMContentLoaded', function() {
        var cartData = JSON.parse(localStorage.getItem("cart")) || [];
        console.log("items in cart: " + cartData.length);
    console.log(cartData);

        if (cartData.length > 0) {
            // hide empty message, show total and pay button
            document.getElementById('emptyMsg').style.display = 'none';
        document.getElementById('totalDiv').style.display = 'flex';
            document.getElementById('payForm').style.display = 'block';

            var listDiv = document.getElementById("cart-list");
        var sum = 0;

            // add each item as a row
            cartData.forEach(function(item) {
                var row = document.createElement("div");
            row.className = "cart-row";
                row.innerHTML = '<span>' + item.name + '</span><span>₹' + item.price + '</span>';
                listDiv.appendChild(row);
                sum += parseFloat(item.price);
            console.log("  " + item.name + " = " + item.price);
            });

            // update total displays
            document.getElementById("totalDisplay").innerText = "₹" + sum;
        document.getElementById("totalInput").value = sum;
            console.log("cart total: ₹" + sum);
        }
    });
</script>
</body>

</html>