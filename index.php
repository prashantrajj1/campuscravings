<?php
require_once 'php/db_connect.php';

// Fetch all restaurants
$res_stmt = $conn->prepare("SELECT * FROM restaurants LIMIT 6");
$res_stmt->execute();
$restaurants = $res_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch featured menu items
$menu_stmt = $conn->prepare("
    SELECT m.*, r.name as restaurant_name, c.category_name 
    FROM menu_items m 
    JOIN restaurants r ON m.restaurant_id = r.id 
    JOIN menu_categories c ON m.category_id = c.id
    LIMIT 8
");
$menu_stmt->execute();
$menu_items = $menu_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusCravings - Order Food on Campus</title>

    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="app-container">

        <header class="app-header">
            <div class="logo-desktop">
                <i class="fa-solid fa-utensils"></i> Campus<span>Cravings</span>
            </div>

            <div class="location-selector">
                <p class="label">Location</p>
                <div class="current-location">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>XIM University</span>
                    <i class="fa-solid fa-chevron-down down-icon"></i>
                </div>
            </div>

            <nav class="desktop-nav">
                <a href="index.php" class="active">Home</a>
                <a href="explore.php">Explore</a>
                <a href="cart.html">Cart</a>
                <a href="profile.php">Account</a>
            </nav>

            <button class="notification-btn" title="Notifications"><i class="fa-regular fa-bell"></i><span
                    class="dot"></span></button>
        </header>

        <main class="app-main">

            <section class="hero-section" style="background: var(--text-main); color: #fff; padding: 40px; border-radius: 20px; overflow: hidden; position: relative;">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.3; background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1920&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
                <div class="hero-content" style="position: relative; z-index: 2; text-align: left; max-width: 500px;">
                    <h1 style="font-size: 3rem; margin-bottom: 20px;">Hungry? <span style="color: var(--swiggy-orange);">Get It Fast.</span></h1>
                    <p style="font-size: 1.1rem; margin-bottom: 30px; opacity: 0.9;">Order from the best campus spots right now. Fresh, hot, and delivered to your hostel doorstep.</p>
                    <div class="hero-buttons" style="justify-content: flex-start;">
                        <a href="explore.php" class="btn-primary">Order Now</a>
                        <a href="#popular" class="btn-secondary" style="background: transparent; color: #fff; border-color: rgba(255,255,255,0.3);">View Popular</a>
                    </div>
                </div>
            </section>

            <!-- Categories -->
            <div class="categories-section">
                <div class="category-pills">
                    <button class="pill active">All Dishes</button>
                    <button class="pill">Fast Food</button>
                    <button class="pill">Main Course</button>
                    <button class="pill">Beverages</button>
                    <button class="pill">Cakes & Desserts</button>
                </div>
            </div>

            <!-- Best Choice Section -->
            <div class="section-header" id="popular">
                <h3 style="font-size: 1.6rem; font-weight: 800;">Popular on Campus</h3>
                <a href="explore.php" class="see-all">See all</a>
            </div>

            <div class="products-grid">
                <?php foreach ($menu_items as $item): ?>
                <div class="product-card">
                    <div class="card-image-wrap">
                        <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['item_name']; ?>">
                        <div class="card-badge"><?php echo $item['category_name']; ?></div>
                    </div>
                    <div class="card-info">
                        <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                        <div class="rating"><i class="fa-solid fa-star"></i> 4.5</div>
                        <p style="font-size: 0.8rem; color: #888; margin-top: 5px;">From <?php echo htmlspecialchars($item['restaurant_name']); ?></p>
                        <div class="price-row" style="margin-top: 15px;">
                            <span class="price" style="font-size: 1.2rem;">₹<?php echo number_format($item['price'], 0); ?></span>
                        </div>
                    </div>
                    <button class="add-btn" onclick="addToCart('<?php echo addslashes($item['item_name']); ?>', <?php echo $item['price']; ?>)">+</button>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Restaurants Section -->
            <div class="section-header" style="margin-top: 50px;">
                <h3 style="font-size: 1.6rem; font-weight: 800;">Featured Restaurants</h3>
                <a href="explore.php" class="see-all">View all restaurants</a>
            </div>

            <div class="products-grid">
                <?php foreach ($restaurants as $res): ?>
                <div class="product-card">
                    <div class="card-image-wrap" style="height: 180px;">
                        <img src="<?php echo $res['image_url']; ?>" alt="<?php echo $res['name']; ?>">
                        <div class="card-badge" style="background: var(--swiggy-green); color: #fff;">4.2 ★</div>
                    </div>
                    <div class="card-info">
                        <h4 style="font-size: 1.3rem;"><?php echo htmlspecialchars($res['name']); ?></h4>
                        <p style="color: #686b78; font-size: 0.9rem; margin-bottom: 10px;"><?php echo $res['cuisine_type']; ?></p>
                        <div class="price-row">
                            <span style="font-size: 0.85rem; color: #93959f;">Flat 20% OFF | Use APP20</span>
                        </div>
                    </div>
                    <a href="restaurant_details.php?id=<?php echo $res['id']; ?>" class="add-btn" style="text-decoration: none; color: var(--swiggy-green);"><i class="fa-solid fa-chevron-right"></i></a>
                </div>
                <?php endforeach; ?>
            </div>

        </main>

        <nav class="bottom-nav">
            <a href="index.php" class="nav-item active">
                <div class="nav-icon-bg"><i class="fa-solid fa-house"></i></div>
                <span>Home</span>
            </a>
            <a href="explore.php" class="nav-item">
                <i class="fa-regular fa-compass"></i>
                <span>Explore</span>
            </a>
            <a href="cart.html" class="nav-item">
                <i class="fa-solid fa-basket-shopping"></i>
                <span>Cart</span>
            </a>
            <a href="profile.php" class="nav-item">
                <i class="fa-regular fa-user"></i>
                <span>Account</span>
            </a>
        </nav>

    </div>

    <script src="js/script.js"></script>
</body>

</html>
