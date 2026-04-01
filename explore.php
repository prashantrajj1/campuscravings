<?php
// explore page - shows all restaurants
// prashant & ayush
require_once 'php/db_connect.php';

// fetch every restaurant from db
$allRest = mysqli_query($conn, "SELECT * FROM restaurants");
$restArr = [];
if ($allRest) {
    while ($r = mysqli_fetch_assoc($allRest)) {
    $restArr[] = $r;
    }
}
// echo "found " . count($restArr) . " restaurants"; // debug
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Restaurants - CampusCravings</title>
    <link rel="stylesheet" href="css/home.css">
<link rel="stylesheet" href="css/explore.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍴</text></svg>">
</head>

<body>

<div class="wrapper">
        <header class="topbar">
            <div class="sitename">
            🍴 Campus<span>Cravings</span>
            </div>
            <nav class="links">
                <a href="home.php">Home</a>
            <a href="explore.php" class="active">Explore</a>
                <a href="checkout.php">Cart</a>
            </nav>
            <a href="profile.php" class="profilepic" title="Account">
            <?php
// navbar profile pic (same code as home.php - should make this a function later)
$navPfp = 'default.jpeg';
if (isset($_SESSION['user_id']) && isset($conn)) {
    $uid = $_SESSION['user_id'];
    $pfpQ = mysqli_query($conn, "SELECT profile_picture FROM users WHERE id = '$uid'");
    if ($pfpQ && mysqli_num_rows($pfpQ) > 0) {
    $pfpRow = mysqli_fetch_assoc($pfpQ);
        if (!empty($pfpRow['profile_picture']))
            $navPfp = $pfpRow['profile_picture'];
    }
}
echo '<img src="assets/pfp/' . htmlspecialchars($navPfp) . '" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block;">';
?>
        </a>
        </header>

        <main class="main">
            <div class="heading-row pt-20">
            <h3 class="explore-title">Explore Restaurants</h3>
            </div>

            <div class="grid">
                <?php
                // loop thru restaurants and show cards
                foreach ($restArr as $rest):
                ?>
            <a href="restaurant_details.php?id=<?php echo $rest['id']; ?>" class="card explore-card-link">
                    <div class="imgbox explore-img-wrap">
                        <img src="<?php echo $rest['image_url']; ?>"
                            alt="<?php echo $rest['name']; ?>">
                </div>
                    <div class="info">
                        <h4 class="explore-card-h4"><?php echo htmlspecialchars($rest['name']); ?></h4>
                    <p class="explore-card-p"><?php echo $rest['cuisine_type']; ?></p>
                    </div>
            </a>
                <?php endforeach; ?>
            </div>
        </main>

</div>

</body>

</html>