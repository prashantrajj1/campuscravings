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
    <title>Checkout - CampusCravings</title>
    <link rel="stylesheet" href="css/checkout.css">
</head>
<body>

<table width="100%" cellpadding="20" class="header-table">
    <tr>
        <td width="30%">
            <a href="home.php" style="color: #282c3f; text-decoration: none; font-weight: bold;"> &lt; Back</a>
        </td>
        <td width="40%" align="center">
            <div class="logo-text">Campus<span>Cravings</span></div>
        </td>
        <td width="30%"></td>
    </tr>
</table>

<div class="checkout-container">
    <h2>Order Summary</h2>
    
    <table width="100%" cellpadding="15">
        <tbody id="cart-list">
            <!-- Items loaded via JS -->
        </tbody>
    </table>
    
    <table width="100%" cellpadding="15" id="total-container" style="display:none; border-top: 2px solid #e9ecee;">
        <tr class="total-row">
            <td>Total Amount</td>
            <td align="right" id="display-total">₹0</td>
        </tr>
    </table>

    <div id="empty-cart-msg" style="text-align: center; color: #686b78; padding: 30px;">
        <p>Your cart is empty.</p>
        <a href="home.php" style="color: #fc8019; text-decoration: none; font-weight: bold;">Go add some food!</a>
    </div>

    <form action="payment.php" method="POST" id="checkout-form" style="display:none; margin-top: 20px;">
        <input type="hidden" name="total_amount" id="form-total" value="0">
        <button type="submit" class="checkout-btn">Proceed to Pay</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        if (cart.length > 0) {
            document.getElementById('empty-cart-msg').style.display = 'none';
            document.getElementById('total-container').style.display = 'table';
            document.getElementById('checkout-form').style.display = 'block';
            
            let list = document.getElementById("cart-list");
            let total = 0;
            
            cart.forEach(item => {
                let tr = document.createElement("tr");
                tr.className = "cart-item";
                tr.innerHTML = `<td>${item.name}</td><td align="right">₹${item.price}</td>`;
                list.appendChild(tr);
                total += parseFloat(item.price);
            });
            
            document.getElementById("display-total").innerText = "₹" + total;
            document.getElementById("form-total").value = total;
        }
    });
</script>
</body>
</html>
