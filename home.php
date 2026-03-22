<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'php/db_connect.php';

// Fetch all restaurants
$res_query = "SELECT * FROM restaurants LIMIT 6";
$res_result = mysqli_query($conn, $res_query);
$restaurants = [];
if ($res_result) {
    while ($row = mysqli_fetch_assoc($res_result)) {
        $restaurants[] = $row;
    }
}

// Fetch categories for the radio button filter
$cat_query = "SELECT * FROM menu_categories LIMIT 5";
$cat_result = mysqli_query($conn, $cat_query);
$categories = [];
if ($cat_result) {
    while ($row = mysqli_fetch_assoc($cat_result)) {
        $categories[] = $row;
    }
}

// Handle category filter
$selected_category = isset($_GET['category']) ? $_GET['category'] : 'all';

// Fetch menu items based on category filter
if ($selected_category === 'all') {
    $menu_query = "
        SELECT m.*, r.name as restaurant_name, c.category_name 
        FROM menu_items m 
        JOIN restaurants r ON m.restaurant_id = r.id 
        JOIN menu_categories c ON m.category_id = c.id
        LIMIT 8
    ";
    $menu_result = mysqli_query($conn, $menu_query);
}
else {
    $cat_id = mysqli_real_escape_string($conn, $selected_category);
    $menu_query = "
        SELECT m.*, r.name as restaurant_name, c.category_name 
        FROM menu_items m 
        JOIN restaurants r ON m.restaurant_id = r.id 
        JOIN menu_categories c ON m.category_id = c.id
        WHERE m.category_id = '$cat_id'
        LIMIT 8
    ";
    $menu_result = mysqli_query($conn, $menu_query);
}
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
    <title>CampusCravings

    </title>

    <!-- External CSS -->


    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍴</text></svg>">
</head>

<body>

    <div class="app-container">

        <header class="app-header">
            <div class="logo-desktop">
                🍴 Campus<span>Cravings</span>
            </div>

            <div class="location-selector">
                <p class="label">Location</p>
                <div class="current-location">
                    <span>📍XIM University</span>
                </div>
            </div>

            <nav class="desktop-nav">
                <a href="home.php" class="active">Home</a>
                <a href="explore.php">Explore</a>
                <a href="checkout.php">Cart</a>
            </nav>

            <a href="profile.php" class="account-btn" title="Account">
                <?php
$nav_pfp = 'default.jpeg';
if (isset($_SESSION['user_id']) && isset($conn)) {
    $uid_nav = $_SESSION['user_id'];
    $u_q_nav = mysqli_query($conn, "SELECT profile_picture FROM users WHERE id = '$uid_nav'");
    if ($u_q_nav && mysqli_num_rows($u_q_nav) > 0) {
        $u_d_nav = mysqli_fetch_assoc($u_q_nav);
        if (!empty($u_d_nav['profile_picture']))
            $nav_pfp = $u_d_nav['profile_picture'];
    }
}
echo '<img src="assets/pfp/' . htmlspecialchars($nav_pfp) . '" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block;">';
?>
            </a>
        </header>

        <main class="app-main">

            <section class="hero-section hero-section-home">
                <div class="hero-img-bg">
                </div>
                <div class="hero-overlay"></div>
                <div class="hero-content hero-content-home">
                    <h1 class="hero-h1-home">Hungry? <span class="hero-highlight">Get It Fast.</span></h1>
                    <p class="hero-p-home">Order from the best campus spots
                        right now. Fresh, hot, and delivered to your Campus Maingate.</p>
                    <div class="hero-buttons hero-buttons-home">
                        <a href="explore.php" class="btn-primary">Order Now</a>
                    </div>
                </div>
            </section>

            <!-- Categories -->
            <div class="categories-section">
                <form action="home.php" method="GET" class="category-radio-group">
                    <div class="category-pills">
                        <label class="pill-label">
                            <input type="radio" name="category" value="all" <?php echo $selected_category === 'all'
    ? 'checked' : ''; ?> onchange="this.form.submit()">
                            <span class="pill">All Dishes</span>
                        </label>
                        <?php foreach ($categories as $cat): ?>
                        <label class="pill-label">
                            <input type="radio" name="category" value="<?php echo $cat['id']; ?>" <?php echo
        (string)$selected_category === (string)$cat['id'] ? 'checked' : ''; ?>
                            onchange="this.form.submit()">
                            <span class="pill">
                                <?php echo htmlspecialchars($cat['category_name']); ?>
                            </span>
                        </label>
                        <?php
endforeach; ?>
                    </div>
                </form>
            </div>

            <!-- Best Choice Section -->
            <div class="section-header" id="popular">
                <h3 class="section-h3">Popular on Campus</h3>
                <a href="explore.php" class="see-all">See all</a>
            </div>

            <div class="products-grid">
                <?php foreach ($menu_items as $item): ?>
                <div class="product-card">
                    <div class="card-image-wrap">
                        <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['item_name']; ?>">
                    </div>
                    <div class="card-info">
                        <h4>
                            <?php echo htmlspecialchars($item['item_name']); ?>
                        </h4>
                        <div class="card-badge">
                            <?php echo $item['category_name']; ?>
                        </div>
                        <p class="card-from-text">From
                            <?php echo htmlspecialchars($item['restaurant_name']); ?>
                        </p>
                        <div class="price-row price-row-home">
                            <span class="price price-home">₹
                                <?php echo number_format($item['price'], 0); ?>
                            </span>
                        </div>
                    </div>
                    <button class="add-btn"
                        onclick="addToCart('<?php echo addslashes($item['item_name']); ?>', <?php echo $item['price']; ?>)">+</button>
                </div>
                <?php
endforeach; ?>
            </div>

            <!-- Restaurants Section -->
            <div class="section-header section-header-padded">
                <h3 class="section-h3">Featured Restaurants</h3>
                <a href="explore.php" class="see-all">View all restaurants</a>
            </div>

            <div class="products-grid">
                <?php foreach ($restaurants as $res): ?>
                <a href="restaurant_details.php?id=<?php echo $res['id']; ?>" class="restaurant-card res-card-link">
                    <div class="card-image-wrap res-card-img-wrap">
                        <img src="<?php echo $res['image_url']; ?>" alt="<?php echo $res['name']; ?>">
                    </div>
                    <div class="card-info">
                        <h4 class="res-card-h4">
                            <?php echo htmlspecialchars($res['name']); ?>
                        </h4>
                        <p class="res-card-p">
                            <?php echo $res['cuisine_type']; ?>
                        </p>
                    </div>
                </a>
                <?php
endforeach; ?>
            </div>

        </main>

        <nav class="bottom-nav">
            <a href="home.php" class="nav-item active">
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