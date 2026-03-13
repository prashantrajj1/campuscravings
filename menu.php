<?php
require_once 'php/db_connect.php';

// Specifically fetching 'Green Salad' (ID 1) as requested
$res_id = 1; 

// Fetch restaurant details
$stmt = $conn->prepare("SELECT * FROM restaurants WHERE id = :id");
$stmt->bindParam(':id', $res_id);
$stmt->execute();
$restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$restaurant) {
    die("Restaurant 'Green Salad' not found in database. Please import the SQL file first.");
}

// Fetch menu items with category names
$menu_stmt = $conn->prepare("
    SELECT m.*, c.category_name 
    FROM menu_items m 
    JOIN menu_categories c ON m.category_id = c.id 
    WHERE m.restaurant_id = :res_id 
    ORDER BY c.id ASC
");
$menu_stmt->bindParam(':res_id', $res_id);
$menu_stmt->execute();
$menu_items = $menu_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - <?php echo $restaurant['name']; ?></title>
    <!-- Local Font Setup (Outfit) -->
    <link rel="stylesheet" href="css/style.css">
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
            border-radius: 50px;
            border: 2px solid var(--neon-green);
            background: rgba(30, 30, 30, 0.9);
            color: white;
            font-size: 1rem;
            backdrop-filter: blur(10px);
            outline: none;
        }
        .search-bar::placeholder { color: #888; }
        
        .category-header {
            margin: 30px 0 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--neon-green);
            grid-column: 1 / -1;
        }
        
        .category-header h2 {
            color: var(--neon-green);
            font-size: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hidden { display: none !important; }
        
        /* Premium Floating Cart indicator style */
        .cart-count {
            position: fixed;
            bottom: 100px;
            right: 20px;
            background: #ff7300;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(255,115,0,0.4);
            font-weight: 700;
            z-index: 999;
            cursor: pointer;
            display: none;
        }
    </style>
</head>
<body style="background: #0d0d0d;">

    <div class="app-container">
        <header class="app-header">
            <a href="index.php" style="color: white; text-decoration: none;"><i class="fa-solid fa-arrow-left"></i> Back</a>
            <div class="logo-desktop">Menu: <span><?php echo $restaurant['name']; ?></span></div>
            <a href="cart.html" style="color: white; font-size: 1.5rem;"><i class="fa-solid fa-basket-shopping"></i></a>
        </header>

        <main class="app-main">
            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" id="searchInput" class="search-bar" placeholder="Search for dishes (e.g. Biryani, Noodles)..." onkeyup="searchMenu()">
            </div>

            <div id="menuContainer" class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
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
                    <div class="card-image-wrap" style="height: 120px; background: #222; display: flex; align-items: center; justify-content: center;">
                        <?php if ($item['image_url']): ?>
                            <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['item_name']; ?>">
                        <?php else: ?>
                            <i class="fa-solid fa-utensils" style="font-size: 3rem; color: #444;"></i>
                        <?php endif; ?>
                        <div class="card-badge"><?php echo $item['category_name']; ?></div>
                    </div>
                    <div class="card-info">
                        <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                        <p class="card-desc">Delicious <?php echo strtolower($item['item_name']); ?> from our chefs.</p>
                        <div class="price-row">
                            <span class="price">₹<?php echo number_format($item['price'], 0); ?></span>
                        </div>
                    </div>
                    <button class="add-btn" onclick="addToCart('<?php echo addslashes($item['item_name']); ?>', <?php echo $item['price']; ?>)">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div id="noResults" class="hidden" style="text-align: center; color: #888; padding: 50px;">
                <i class="fa-solid fa-magnifying-glass" style="font-size: 3rem; margin-bottom: 10px;"></i>
                <p>No matches found. Try searching for something else!</p>
            </div>
        </main>

        <!-- Dynamic Cart Counter -->
        <div id="floatingCart" class="cart-count" onclick="window.location.href='cart.html'">
            <i class="fa-solid fa-cart-shopping"></i> <span id="cartNumber">0</span> Items in Cart
        </div>

        <nav class="bottom-nav">
            <a href="index.php" class="nav-item"><i class="fa-solid fa-house"></i><span>Home</span></a>
            <a href="explore.php" class="nav-item active"><div class="nav-icon-bg"><i class="fa-regular fa-compass"></i></div><span>Explore</span></a>
            <a href="cart.html" class="nav-item"><i class="fa-solid fa-basket-shopping"></i><span>Cart</span></a>
            <a href="profile.php" class="nav-item"><i class="fa-regular fa-user"></i><span>Profile</span></a>
        </nav>
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
