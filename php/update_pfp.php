<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'upload' && isset($_FILES['pfp']) && $_FILES['pfp']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../assets/pfp/';
        $file_tmp = $_FILES['pfp']['tmp_name'];
        $file_name = basename($_FILES['pfp']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($file_ext, $allowed)) {
            $new_name = 'user_' . $user_id . '_' . time() . '.' . $file_ext;
            $dest = $upload_dir . $new_name;
            
            if (move_uploaded_file($file_tmp, $dest)) {
                $query = mysqli_query($conn, "SELECT profile_picture FROM users WHERE id = $user_id");
                if ($row = mysqli_fetch_assoc($query)) {
                    $old = $row['profile_picture'];
                    if (!empty($old) && $old !== 'default.jpeg' && file_exists($upload_dir . $old)) {
                        unlink($upload_dir . $old);
                    }
                }
                
                $new_name_esc = mysqli_real_escape_string($conn, $new_name);
                mysqli_query($conn, "UPDATE users SET profile_picture = '$new_name_esc' WHERE id = $user_id");
            }
        }
    } elseif ($action === 'remove') {
        $upload_dir = '../assets/pfp/';
        $query = mysqli_query($conn, "SELECT profile_picture FROM users WHERE id = $user_id");
        if ($row = mysqli_fetch_assoc($query)) {
            $old = $row['profile_picture'];
            if (!empty($old) && $old !== 'default.jpeg' && file_exists($upload_dir . $old)) {
                unlink($upload_dir . $old);
            }
        }
        mysqli_query($conn, "UPDATE users SET profile_picture = 'default.jpeg' WHERE id = $user_id");
    }
}

header("Location: ../profile.php");
exit;
?>
