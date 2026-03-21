<?php
require_once 'php/db_connect.php';

// Fetch all restaurants
$query = "SELECT * FROM restaurants";
$result = mysqli_query($conn, $query);
$restaurants = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $restaurants[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Restaurants - CampusCravings</title>
    <!-- External CSS -->
    
    
    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/explore.css">
</head>
<body>

    <div class="app-container">
        <header class="app-header">
            <div class="logo-desktop">
                <i class="fa-solid fa-utensils"></i> Campus<span>Cravings</span>
            </div>
            <nav class="desktop-nav">
                <a href="home.php">Home</a>
                <a href="explore.php" class="active">Explore</a>
                <a href="checkout.php">Cart</a>
            </nav>
            <a href="profile.php" class="account-btn" title="Account">
                <i class="fa-regular fa-user"></i>
            </a>
        </header>

        <main class="app-main">
            <div class="section-header pt-20">
                <h3 class="explore-title">Explore Restaurants</h3>
            </div>

            <div class="products-grid">
                <?php foreach ($restaurants as $res): ?>
                <a href="restaurant_details.php?id=<?php echo $res['id']; ?>" class="product-card explore-card-link">
                    <div class="card-image-wrap explore-img-wrap">
                        <img src="<?php echo $res['image_url']; ?>" alt="<?php echo $res['name']; ?>">
                    </div>
                    <div class="card-info">
                        <h4 class="explore-card-h4"><?php echo htmlspecialchars($res['name']); ?></h4>
                        <p class="explore-card-p"><?php echo $res['cuisine_type']; ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </main>

        <nav class="bottom-nav">
            <a href="home.php" class="nav-item">
                <i class="fa-solid fa-house"></i>
                <span>Home</span>
            </a>
            <a href="explore.php" class="nav-item active">
                <div class="nav-icon-bg"><i class="fa-regular fa-compass"></i></div>
                <span>Explore</span>
            </a>
            <a href="checkout.php" class="nav-item">
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
