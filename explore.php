<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'php/db_connect.php';

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
    <title>Explore Restaurants - CampusCravings</title>
    <link rel="stylesheet" href="css/explore.css">
</head>
<body>

<table width="100%" cellpadding="20" class="header-table">
    <tr>
        <td width="30%">
            <a href="home.php" class="logo-text">Campus<span>Cravings</span></a>
        </td>
        <td width="40%" align="center">
            <a href="home.php" class="nav-link">Home</a>
            <a href="explore.php" class="nav-link active">Explore</a>
            <a href="checkout.php" class="nav-link">Cart</a>
        </td>
        <td width="30%" align="right">
            <a href="profile.php" class="nav-link">Account</a>
        </td>
    </tr>
</table>

<div class="layout-container">

    <div class="section-title">Explore Restaurants</div>

    <table width="100%" cellpadding="15">
        <tr>
            <?php 
            $count = 0;
            foreach ($restaurants as $res): 
                if ($count > 0 && $count % 3 == 0) echo "</tr><tr>";
            ?>
            <td width="33%" align="center" valign="top">
                <a href="restaurant_details.php?id=<?php echo $res['id']; ?>">
                    <div class="product-cell">
                        <img src="<?php echo $res['image_url']; ?>" width="100%" height="180" class="product-img">
                        <h4 class="product-title"><?php echo htmlspecialchars($res['name']); ?></h4>
                        <p class="product-desc"><?php echo $res['cuisine_type']; ?></p>
                    </div>
                </a>
            </td>
            <?php 
                $count++;
            endforeach; 
            while ($count > 0 && $count % 3 != 0) {
                echo "<td width='33%'></td>";
                $count++;
            }
            ?>
        </tr>
    </table>

    <br><br>
</div>

</body>
</html>
