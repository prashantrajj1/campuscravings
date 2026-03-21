<?php
require_once 'php/db_connect.php';

// Fetch all restaurants
$stmt = $conn->prepare("SELECT * FROM restaurants");
$stmt->execute();
$restaurants = $res_stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Restaurants - CampusCravings</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background: var(--bg-main);">

    <div class="app-container">
        <header class="app-header">
            <div class="logo-desktop">
                <i class="fa-solid fa-utensils"></i> Campus<span>Cravings</span>
            </div>
            <nav class="desktop-nav">
                <a href="index.php">Home</a>
                <a href="explore.php" class="active">Explore</a>
                <a href="cart.html">Cart</a>
            </nav>
            <a href="profile.php" class="account-btn" title="Account">
                <i class="fa-regular fa-user"></i>
            </a>
        </header>

        <main class="app-main">
            <div class="section-header" style="padding-top: 20px;">
                <h3 style="font-size: 1.6rem; font-weight: 800;">Explore Restaurants</h3>
            </div>

            <div class="products-grid">
                <?php foreach ($restaurants as $res): ?>
                <a href="restaurant_details.php?id=<?php echo $res['id']; ?>" class="product-card" style="text-decoration: none; color: inherit; display: flex;">
                    <div class="card-image-wrap" style="height: 180px;">
                        <img src="<?php echo $res['image_url']; ?>" alt="<?php echo $res['name']; ?>">
                        <div class="card-badge" style="background: var(--swiggy-green); color: #fff; font-weight: 700;"><?php echo $res['rating']; ?> ★</div>
                    </div>
                    <div class="card-info">
                        <h4 style="font-size: 1.3rem; margin-bottom: 5px;"><?php echo htmlspecialchars($res['name']); ?></h4>
                        <p style="color: #686b78; font-size: 0.9rem; margin-bottom: 15px;"><?php echo $res['cuisine_type']; ?></p>
                        <div class="price-row">
                            <span style="font-size: 0.85rem; color: #93959f;">Flat 50% OFF | Use WELCOME50</span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </main>

        <nav class="bottom-nav">
            <a href="index.php" class="nav-item">
                <i class="fa-solid fa-house"></i>
                <span>Home</span>
            </a>
            <a href="explore.php" class="nav-item active">
                <div class="nav-icon-bg"><i class="fa-regular fa-compass"></i></div>
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

</body>
</html>
