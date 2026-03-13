<?php
require_once 'php/db_connect.php';

// Fetch all restaurants
$res_stmt = $conn->prepare("SELECT * FROM restaurants LIMIT 6");
$res_stmt->execute();
$restaurants = $res_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch featured menu items
$menu_stmt = $conn->prepare("SELECT m.*, r.name as restaurant_name FROM menu_items m JOIN restaurants r ON m.restaurant_id = r.id LIMIT 8");
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

            <section class="hero-section">
                <div class="hero-image-container">
                    <div class="hero-bg"
                        style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1920&auto=format&fit=crop');">
                    </div>
                    <div class="hero-overlay"></div>
                </div>
                <div class="hero-content">
                    <h1>Hungry? <span class="highlight">Get It Fast.</span></h1>
                    <p>Order from the best campus spots right now. Fresh, hot, and delivered to your hostel doorstep.</p>
                    <div class="hero-buttons">
                        <a href="menu.php" class="btn-primary"><i class="fa-solid fa-utensils"></i> Order Now</a>
                        <a href="#popular" class="btn-secondary">View Popular</a>
                    </div>
                </div>
            </section>

            <!-- Categories -->
            <div class="categories-section">
                <div class="category-pills">
                    <button class="pill active">All</button>
                    <button class="pill">Burgers</button>
                    <button class="pill">Pizza</button>
                    <button class="pill">Drinks</button>
                    <button class="pill">Snacks</button>
                </div>
            </div>

            <!-- Best Choice Section -->
            <div class="section-header" id="popular">
                <h3>Best Choice</h3>
                <a href="explore.php" class="see-all">See all</a>
            </div>

            <div class="products-grid">
                <?php foreach ($menu_items as $item): ?>
                <div class="product-card">
                    <div class="card-image-wrap">
                        <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>">
                        <div class="card-badge"><?php echo $item['category']; ?></div>
                    </div>
                    <div class="card-info">
                        <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                        <p class="card-desc"><?php echo htmlspecialchars($item['description']); ?></p>
                        <p style="font-size: 0.8rem; color: #888; margin-top: -10px;">By <?php echo htmlspecialchars($item['restaurant_name']); ?></p>
                        <div class="price-row">
                            <span class="price">₹<?php echo number_format($item['price'], 0); ?></span>
                            <div class="rating"><i class="fa-solid fa-star"></i> 4.5</div>
                        </div>
                    </div>
                    <button class="add-btn" onclick="addToCart('<?php echo addslashes($item['name']); ?>', <?php echo $item['price']; ?>)"><i
                            class="fa-solid fa-plus"></i></button>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Restaurants Section -->
            <div class="section-header" style="margin-top: 40px;">
                <h3>Top Restaurants</h3>
                <a href="explore.php" class="see-all">Explore More</a>
            </div>

            <div class="products-grid">
                <?php foreach ($restaurants as $res): ?>
                <div class="product-card" style="min-width: 280px;">
                    <div class="card-image-wrap" style="height: 140px;">
                        <img src="<?php echo $res['image_url']; ?>" alt="<?php echo $res['name']; ?>">
                    </div>
                    <div class="card-info">
                        <h4><?php echo htmlspecialchars($res['name']); ?></h4>
                        <p class="card-desc"><?php echo htmlspecialchars($res['description']); ?></p>
                        <div class="price-row">
                            <span style="font-size: 0.9rem; font-weight: 600; color: var(--neon-green);"><?php echo $res['cuisine_type']; ?></span>
                            <div class="rating"><i class="fa-solid fa-star"></i> <?php echo $res['rating']; ?></div>
                        </div>
                    </div>
                    <a href="restaurant_details.php?id=<?php echo $res['id']; ?>" class="add-btn" style="text-decoration: none;"><i class="fa-solid fa-chevron-right"></i></a>
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
                <span>Baskets</span>
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
