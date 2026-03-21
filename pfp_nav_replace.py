import os
import glob

files = glob.glob('*.php')

repl = """<?php
$nav_pfp = 'default.jpeg';
if(isset($_SESSION['user_id']) && isset($conn)) {
    $uid_nav = $_SESSION['user_id'];
    $u_q_nav = mysqli_query($conn, "SELECT profile_picture FROM users WHERE id = '$uid_nav'");
    if($u_q_nav && mysqli_num_rows($u_q_nav) > 0) {
        $u_d_nav = mysqli_fetch_assoc($u_q_nav);
        if(!empty($u_d_nav['profile_picture'])) $nav_pfp = $u_d_nav['profile_picture'];
    }
}
echo '<img src="assets/pfp/'.htmlspecialchars($nav_pfp).'" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block;">';
?>"""

for f in files:
    with open(f, 'r') as file:
        content = file.read()
    
    if '<i class="fa-regular fa-user"></i>' in content:
        content = content.replace('<i class="fa-regular fa-user"></i>', repl)
        with open(f, 'w') as file:
            file.write(content)
        print(f"Updated {f}")
