<?php
session_start();
// Check if user is logged in (using cookie for consistency with existing JS auth)
if (!isset($_COOKIE['user_auth'])) {
    header("Location: login.html");
    exit();
}
$username = $_COOKIE['user_auth'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout | CampusCravings</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --checkout-bg: #0d0d0d;
            --white: #1a1a1a;
            --swiggy-orange: #7cff1c;
            --swiggy-green: #7cff1c;
            --text-dark: #ffffff;
            --text-gray: #888888;
            --border-light: #333333;
        }

        body.checkout-page {
            background-color: var(--checkout-bg);
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* --- Header --- */
        .checkout-header {
            background: var(--bg-main);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .checkout-logo i {
            color: var(--swiggy-orange);
            font-size: 1.8rem;
        }

        .secure-title {
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #3d4152;
        }

        .header-right {
            display: flex;
            gap: 40px;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-dark);
        }

        /* --- Main Content --- */
        .checkout-container {
            max-width: 1200px;
            margin: 30px auto;
            display: grid;
            grid-template-columns: 1.8fr 1fr;
            gap: 30px;
            padding: 0 20px;
        }

        /* --- Left Side: Address --- */
        .address-section {
            background: var(--white);
            padding: 30px;
            position: relative;
        }

        .section-marker {
            position: absolute;
            left: -15px;
            top: 30px;
            background: var(--swiggy-orange);
            color: black;
            padding: 10px;
            font-size: 0.8rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.5);
        }

        .address-header {
            margin-bottom: 25px;
        }

        .address-header h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .address-header p {
            color: var(--text-gray);
            font-size: 0.9rem;
        }

        .address-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .address-card {
            border: 1px solid var(--border-light);
            padding: 20px;
            cursor: pointer;
            transition: box-shadow 0.3s;
            position: relative;
        }

        .address-card:hover {
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        }

        .address-card.active {
            border-color: var(--swiggy-green);
        }

        .addr-icon {
            font-size: 1.2rem;
            margin-bottom: 12px;
            color: #535665;
        }

        .addr-type {
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .addr-details {
            color: var(--text-gray);
            font-size: 0.85rem;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .deliver-btn {
            background: var(--swiggy-orange);
            color: black;
            border: none;
            padding: 10px 20px;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            cursor: pointer;
        }

        .add-new-card {
            border: 1px dashed #d4d5d9;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .add-new-btn {
            background: transparent;
            border: 1px solid var(--swiggy-green);
            color: var(--swiggy-green);
            padding: 8px 15px;
            font-weight: 700;
            margin-top: 10px;
            width: fit-content;
        }

        /* --- Right Side: Order Summary --- */
        .summary-sidebar {
            background: var(--white);
            padding: 20px;
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .restaurant-brief {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-light);
        }

        .res-img-mini {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .res-info-mini h3 { font-size: 1rem; }
        .res-info-mini p { font-size: 0.8rem; color: var(--text-gray); }

        .cart-item-list {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .item-name-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .veg-icon { color: var(--swiggy-green); font-size: 0.6rem; border: 1px solid currentColor; padding: 1px; }

        .qty-controls {
            display: flex;
            border: 1px solid #d4d5d9;
            align-items: center;
            gap: 10px;
            padding: 2px 8px;
            margin: 0 15px;
        }

        .qty-btn { cursor: pointer; color: var(--swiggy-green); font-weight: 700; }
        .qty-val { font-size: 0.85rem; min-width: 15px; text-align: center; }

        .item-price { font-weight: 500; font-size: 0.9rem; width: 50px; text-align: right; }

        .suggestions-box {
            background: #f9f9f9;
            padding: 10px;
            font-style: italic;
            font-size: 0.8rem;
            color: var(--text-gray);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .no-contact {
            border: 1px solid var(--border-light);
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
        }

        .coupon-box {
            border: 1px dashed #bebfc5;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #535665;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .bill-details h4 { font-size: 0.85rem; text-transform: uppercase; margin-bottom: 15px; }

        .bill-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--text-gray);
            margin-bottom: 10px;
        }

        .bill-row.total {
            border-top: 2px solid #282c3f;
            padding-top: 15px;
            margin-top: 15px;
            color: var(--text-dark);
            font-weight: 700;
            font-size: 1rem;
        }

        .info-tip { font-size: 0.75rem; color: #bebfc5; cursor: help; }

        /* --- Footer --- */
        .checkout-footer {
            text-align: center;
            padding: 40px;
            color: var(--text-gray);
            font-size: 0.8rem;
        }

        @media (max-width: 900px) {
            .checkout-container { grid-template-columns: 1fr; }
            .checkout-header { padding: 15px 5%; }
        }
    </style>
</head>
<body class="checkout-page">

    <header class="checkout-header">
        <div class="header-left">
            <a href="index.php" class="checkout-logo">
                <i class="fa-solid fa-utensils"></i>
            </a>
            <span class="secure-title">Secure Checkout</span>
        </div>
        <div class="header-right">
            <div class="nav-link"><i class="fa-regular fa-life-ring"></i> Help</div>
            <div class="nav-link"><i class="fa-regular fa-user"></i> <?php echo htmlspecialchars(strtoupper($username)); ?></div>
        </div>
    </header>

    <main class="checkout-container">
        <!-- Left Side -->
        <div class="left-content">
            <section class="address-section">
                <div class="header-left" style="margin-left: -30px; margin-bottom: 30px;">
                    <div class="section-marker" style="position: static; padding: 12px; margin-right: 20px;"><i class="fa-solid fa-location-dot"></i></div>
                    <div>
                        <h2 style="font-size: 1.25rem;">Select delivery address</h2>
                        <p style="color: var(--text-gray); font-size: 0.85rem;">You have a saved address in this location</p>
                    </div>
                </div>

                <div class="address-grid">
                    <div class="address-card active">
                        <div class="addr-icon"><i class="fa-solid fa-briefcase"></i></div>
                        <div class="addr-type">Work</div>
                        <div class="addr-details">121, Bhubaneswar, Odisha, India</div>
                        <div class="eta">32 MINS</div>
                        <button class="deliver-btn">Deliver Here</button>
                    </div>

                    <div class="address-card">
                        <div class="addr-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                        <div class="addr-type">Xim University</div>
                        <div class="addr-details">Xim University jatani ug hostel, Kakudia, Odisha, India</div>
                        <div class="eta">63 MINS</div>
                        <button class="deliver-btn" style="display:none">Deliver Here</button>
                    </div>

                    <div class="address-card add-new-card">
                        <div class="addr-icon"><i class="fa-solid fa-plus"></i></div>
                        <div class="addr-type">Add New Address</div>
                        <div class="addr-details">Hazaribagh, Jharkhand 825301, India (Natraj Nagar)</div>
                        <button class="add-new-btn">ADD NEW</button>
                    </div>
                </div>
            </section>
        </div>

        <!-- Right Side -->
        <aside class="summary-sidebar">
            <div class="restaurant-brief">
                <div class="res-img-mini" style="background: var(--swiggy-orange); display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                    <i class="fa-solid fa-utensils" style="color: #fff;"></i>
                </div>
                <div class="res-info-mini">
                    <h3 id="checkout-res-name">Campus Cravings</h3>
                    <p id="checkout-res-area">Main Campus</p>
                </div>
            </div>

            <div class="cart-item-list" id="checkout-cart-items">
                <!-- Items will be populated by JS -->
            </div>

            <div class="suggestions-box">
                <i class="fa-solid fa-quote-left"></i>
                <span>Any suggestions? We will pass it on...</span>
            </div>

            <div class="no-contact">
                <input type="checkbox" id="nocontact">
                <label for="nocontact" style="font-size: 0.8rem; line-height: 1.4;">
                    <strong>Opt in for No-contact Delivery</strong><br>
                    Unwell, or avoiding contact? Partner will safely place the order outside your door.
                </label>
            </div>

            <div class="coupon-box">
                <i class="fa-solid fa-percentage"></i>
                <span>Apply Coupon</span>
            </div>

            <div class="bill-details" id="bill-details-container">
                <h4>Bill Details</h4>
                <div class="bill-row">
                    <span>Item Total</span>
                    <span id="bill-item-total">₹0</span>
                </div>
                <div class="bill-row">
                    <span>Delivery Fee | 2.3 kms <i class="fa-solid fa-circle-info info-tip"></i></span>
                    <span>₹28</span>
                </div>
                <div class="bill-row">
                    <span>GST & Other Charges <i class="fa-solid fa-circle-info info-tip"></i></span>
                    <span id="bill-gst">₹0</span>
                </div>

                <div class="bill-row total">
                    <span>TO PAY</span>
                    <span id="bill-grand-total">₹0</span>
                </div>
            </div>

            <form action="php/order_process.php" method="POST" style="margin-top: 20px;">
                <input type="hidden" name="food_details" id="final-food-details">
                <input type="hidden" name="total_amount" id="final-total-amount">
                <button type="submit" class="deliver-btn" id="place-order-btn" style="width:100%; padding: 15px; font-size: 1rem;" onclick="clearCart()">
                    PLACE ORDER
                </button>
            </form>
        </aside>
    </main>

    <footer class="checkout-footer">
        &copy; 2026 Campus Cravings. All Rights Reserved.
    </footer>

    <script src="js/script.js"></script>
    <script>
        // Specific logic for Checkout page
        function refreshCheckout() {
            const cartItems = JSON.parse(localStorage.getItem("cart")) || [];
            const container = document.getElementById('checkout-cart-items');
            if(!container) return;

            container.innerHTML = '';
            let subtotal = 0;

            // Group common items
            const grouped = {};
            cartItems.forEach(item => {
                if (grouped[item.name]) {
                    grouped[item.name].qty++;
                } else {
                    grouped[item.name] = { ...item, qty: 1 };
                }
            });

            if (Object.keys(grouped).length === 0) {
                container.innerHTML = '<div class="empty-cart-msg" style="text-align:center; padding: 20px; color: var(--text-gray);">Your cart is empty. Please add items to order.</div>';
                document.getElementById('bill-details-container').style.opacity = '0.5';
                document.getElementById('place-order-btn').disabled = true;
                return;
            } else {
                document.getElementById('bill-details-container').style.opacity = '1';
                document.getElementById('place-order-btn').disabled = false;
            }

            Object.values(grouped).forEach(item => {
                const row = document.createElement('div');
                row.className = 'summary-item';
                const itemTotal = item.price * item.qty;
                subtotal += itemTotal;

                row.innerHTML = `
                    <div class="item-name-wrap">
                        <i class="fa-solid fa-caret-up veg-icon"></i>
                        <span>${item.name}</span>
                    </div>
                    <div class="qty-controls">
                        <span class="qty-btn" onclick="updateQty('${item.name}', -1)">-</span>
                        <span class="qty-val">${item.qty}</span>
                        <span class="qty-btn" onclick="updateQty('${item.name}', 1)">+</span>
                    </div>
                    <div class="item-price">₹${itemTotal}</div>
                `;
                container.appendChild(row);
            });

            // Update Bill
            const gst = Math.round(subtotal * 0.12); // 12% GST
            const delivery = 28;
            const grandTotal = subtotal + gst + delivery;

            document.getElementById('bill-item-total').innerText = `₹${subtotal}`;
            document.getElementById('bill-gst').innerText = `₹${gst}`;
            document.getElementById('bill-grand-total').innerText = `₹${grandTotal}`;

            // Set hidden inputs for form
            document.getElementById('final-food-details').value = JSON.stringify(grouped);
            document.getElementById('final-total-amount').value = grandTotal;
        }

        function updateQty(name, change) {
            let cartItems = JSON.parse(localStorage.getItem("cart")) || [];
            if (change > 0) {
                // Find and duplicate
                const item = cartItems.find(i => i.name === name);
                cartItems.push({ ...item });
            } else {
                // Find and remove one instance
                const index = cartItems.findIndex(i => i.name === name);
                if (index > -1) cartItems.splice(index, 1);
            }
            localStorage.setItem("cart", JSON.stringify(cartItems));
            refreshCheckout();
        }

        function clearCart() {
            localStorage.removeItem("cart");
        }

        document.addEventListener('DOMContentLoaded', refreshCheckout);
    </script>
</body>
</html>
