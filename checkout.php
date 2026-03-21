<?php
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
    <title>Checkout - 🍴 CampusCravings</title>
    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/checkout.css">
</head>

<body>

    <div class="app-container">
        <header class="app-header">
            <a href="home.php" class="back-link">Back</a>
            <div class="logo-desktop">Campus<span>Cravings</span></div>
            <div class="checkout-spacer"></div>
        </header>

        <main class="checkout-container">
            <h2 class="checkout-h2">Order Summary</h2>

            <div id="cart-list">
                <!-- Items will be loaded here via JS -->
            </div>

            <div class="total-row" id="total-container" style="display:none;">
                <span>Total Amount</span>
                <span id="display-total">₹0</span>
            </div>

            <div id="empty-cart-msg" class="empty-cart-msg">

                <p>Your cart is empty.</p>
                <a href="home.php" class="empty-cart-link">Go add some food!</a>
            </div>

            <form action="payment.php" method="POST" id="checkout-form" class="checkout-form" style="display:none;">
                <input type="hidden" name="total_amount" id="form-total" value="0">
                <button type="submit" class="checkout-btn">Proceed to Pay</button>
            </form>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            if (cart.length > 0) {
                document.getElementById('empty-cart-msg').style.display = 'none';
                document.getElementById('total-container').style.display = 'flex';
                document.getElementById('checkout-form').style.display = 'block';

                let list = document.getElementById("cart-list");
                let total = 0;

                cart.forEach(item => {
                    let div = document.createElement("div");
                    div.className = "cart-item";
                    div.innerHTML = `<span>${item.name}</span><span>₹${item.price}</span>`;
                    list.appendChild(div);
                    total += parseFloat(item.price);
                });

                document.getElementById("display-total").innerText = "₹" + total;
                document.getElementById("form-total").value = total;
            }
        });
    </script>
</body>

</html>