<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'php/db_connect.php';

// Specifically fetching restaurant based on URL ID
$res_id = isset($_GET['id']) ? (int)mysqli_real_escape_string($conn, $_GET['id']) : 1; 

// Fetch restaurant details
$stmt_query = "SELECT * FROM restaurants WHERE id = '$res_id'";
$stmt_result = mysqli_query($conn, $stmt_query);
$restaurant = mysqli_fetch_assoc($stmt_result);

if (!$restaurant) {
    die("Restaurant not found in database.");
}

// Fetch menu items with category names
$menu_query = "
    SELECT m.*, c.category_name 
    FROM menu_items m 
    JOIN menu_categories c ON m.category_id = c.id 
    WHERE m.restaurant_id = '$res_id' 
    ORDER BY c.id ASC
";
$menu_result = mysqli_query($conn, $menu_query);
$menu_items = [];
if ($menu_result) {
    while ($row = mysqli_fetch_assoc($menu_result)) {
        $menu_items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - <?php echo $restaurant['name']; ?></title>
    <!-- Local Font Setup (Outfit) -->
    <link rel="stylesheet" href="css/home.css">
    <style>
        .search-container {
            margin: 20px 0;
            position: sticky;
            top: 10px;
            z-index: 100;
        }
        .search-bar {
            width: 100%;
            padding: 15px 25px;
            border-radius: 12px;
            border: 1px solid #e9ecee;
            background: #fff;
            color: #282c3f;
            font-size: 1rem;
            outline: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .search-bar::placeholder { color: #93959f; }
        
        .category-header {
            margin: 40px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #282c3f;
            grid-column: 1 / -1;
        }
        
        .category-header h2 {
            color: #282c3f;
            font-size: 1.4rem;
            font-weight: 800;
        }

        .hidden { display: none !important; }
        
        .cart-count {
            position: fixed;
            bottom: 90px;
            left: 20px;
            right: 20px;
            background: #fc8019;
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(252, 128, 25, 0.4);
            font-weight: 800;
            z-index: 999;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="app-container">
        <header class="app-header">
            <a href="home.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> <?php echo $restaurant['name']; ?></a>
            <div class="logo-desktop">Campus<span>Cravings</span></div>
            <a href="checkout.php" class="cart-link"><i class="fa-solid fa-basket-shopping"></i></a>
        </header>

        <main class="app-main">
            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" id="searchInput" class="search-bar" placeholder="Search in <?php echo $restaurant['name']; ?>..." onkeyup="searchMenu()">
            </div>

            <div id="menuContainer" class="products-grid">
                <?php 
                $current_cat = "";
                foreach ($menu_items as $item): 
                    if ($current_cat != $item['category_name']):
                        $current_cat = $item['category_name'];
                ?>
                    <div class="category-header" data-category="<?php echo $current_cat; ?>">
                        <h2><?php echo $current_cat; ?></h2>
                    </div>
                <?php endif; ?>

                <div class="product-card" data-name="<?php echo strtolower($item['item_name']); ?>">
                    <div class="menu-image-wrap">
                        <?php if ($item['image_url']): ?>
                            <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['item_name']; ?>">
                        <?php else: ?>
                            <i class="fa-solid fa-utensils menu-image-placeholder"></i>
                        <?php endif; ?>
                    </div>
                    <div class="card-info">
                        <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                        <div class="card-badge">MENU</div>
                        <p class="menu-item-desc">Delicious <?php echo strtolower($item['item_name']); ?> prepared fresh.</p>
                        <div class="price-row menu-price-row">
                            <span class="price">₹<?php echo number_format($item['price'], 0); ?></span>
                        </div>
                    </div>
                    <button class="add-btn" onclick="addToCart('<?php echo addslashes($item['item_name']); ?>', <?php echo $item['price']; ?>)">+</button>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div id="noResults" class="hidden no-results">
                <i class="fa-solid fa-cloud-meatball no-results-icon"></i>
                <h3 class="no-results-text">Dish not found</h3>
                <p>We couldn't find any items matching your search. Try something else!</p>
            </div>
        </main>

        <!-- Dynamic Cart Counter -->
        <div id="floatingCart" class="cart-count" onclick="window.location.href='checkout.php'" style="display: none;">
            <span><i class="fa-solid fa-cart-shopping"></i> <span id="cartNumber">0</span> ITEMS</span>
            <span>VIEW CART <i class="fa-solid fa-chevron-right"></i></span>
        </div>

        
    </div>

    <script src="js/script.js"></script>
    <script>
        // Real-time Search Logic (Module IV)
        function searchMenu() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const cards = document.getElementsByClassName('product-card');
            const headers = document.getElementsByClassName('category-header');
            let hasVisibleCards = false;

            // Filter cards
            for (let i = 0; i < cards.length; i++) {
                const name = cards[i].getAttribute('data-name');
                if (name.includes(filter)) {
                    cards[i].classList.remove('hidden');
                    hasVisibleCards = true;
                } else {
                    cards[i].classList.add('hidden');
                }
            }

            // Hide/Show headers based on visible cards in category
            for (let j = 0; j < headers.length; j++) {
                let categoryName = headers[j].getAttribute('data-category').toLowerCase();
                // Check if any visible card exists after this header until the next header
                let nextElement = headers[j].nextElementSibling;
                let foundMatch = false;
                
                while (nextElement && !nextElement.classList.contains('category-header')) {
                    if (!nextElement.classList.contains('hidden')) {
                        foundMatch = true;
                        break;
                    }
                    nextElement = nextElement.nextElementSibling;
                }
                
                if (foundMatch) {
                    headers[j].classList.remove('hidden');
                } else {
                    headers[j].classList.add('hidden');
                }
            }

            // Show "No Results" message
            const noResults = document.getElementById('noResults');
            if (!hasVisibleCards && filter !== "") {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        // Enhancement: Show floating cart if items exist
        function updateFloatingCart() {
            const cartItems = JSON.parse(localStorage.getItem("cart")) || [];
            const floatingCart = document.getElementById('floatingCart');
            const cartNumber = document.getElementById('cartNumber');
            
            if (cartItems.length > 0) {
                floatingCart.style.display = 'block';
                cartNumber.innerText = cartItems.length;
            } else {
                floatingCart.style.display = 'none';
            }
        }

        // Override original addToCart to update UI immediately
        const originalAddToCart = window.addToCart;
        window.addToCart = function(name, price) {
            originalAddToCart(name, price);
            updateFloatingCart();
        };

        document.addEventListener("DOMContentLoaded", updateFloatingCart);
    </script>
</body>
</html>
