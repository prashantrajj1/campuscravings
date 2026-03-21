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
    <title>Checkout - CampusCravings</title>
    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        .checkout-container {
            max-width: 600px;
            margin: 40px auto;
            background: var(--card-bg);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            font-size: 1.1rem;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 20px 0;
            font-size: 1.3rem;
            font-weight: 800;
        }
        .checkout-btn {
            background: var(--swiggy-orange);
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
        }
        .checkout-btn:hover { background: #e67012; }
    </style>
</head>
<body style="background: var(--bg-light);">

    <div class="app-container">
        <header class="app-header">
            <a href="home.php" style="color: var(--text-main); text-decoration: none; font-weight: 700;"><i class="fa-solid fa-arrow-left"></i> Back</a>
            <div class="logo-desktop">Campus<span>Cravings</span></div>
            <div style="width: 50px;"></div>
        </header>

        <main class="checkout-container">
            <h2 style="margin-bottom: 20px;">Order Summary</h2>
            
            <div id="cart-list">
                <!-- Items will be loaded here via JS -->
            </div>
            
            <div class="total-row" id="total-container" style="display:none;">
                <span>Total Amount</span>
                <span id="display-total">₹0</span>
            </div>

            <div id="empty-cart-msg" style="text-align: center; color: #888; padding: 30px;">
                <i class="fa-solid fa-basket-shopping" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.3;"></i>
                <p>Your cart is empty.</p>
                <a href="home.php" style="color: var(--swiggy-orange); text-decoration: none; font-weight: bold; margin-top: 10px; display: inline-block;">Go add some food!</a>
            </div>

            <form action="payment.php" method="POST" id="checkout-form" style="display:none; margin-top: 20px;">
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
