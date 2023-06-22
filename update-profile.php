<?php
require_once 'user/user.php';
require_once 'connection/connection.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user']['email'];
$user = new User($connection);
$userId = $user->getUserIdByEmail($email);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $profilePic = $_FILES['profile_pic'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($profilePic['type'], $allowedTypes)) {
        echo "Invalid file type. Only JPEG, PNG, and GIF images are allowed.";
        exit();
    }
    $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
    if ($profilePic['size'] > $maxFileSize) {
        echo "File size exceeds the limit. Maximum file size allowed is 5MB.";
        exit();
    }
    $filename = uniqid() . '_' . $profilePic['name'];
    $destination = 'uploads/profile/' . $filename;

    if (move_uploaded_file($profilePic['tmp_name'], $destination)) {
        $user->changeProfilePic($userId, $filename);
        header("Location: my_book.php");
        exit();
    } else {
        // Failed to move the uploaded file
        echo "Error uploading the file. Please try again.";
        exit();
    }
} else {
    // No file uploaded or invalid request
    echo "Invalid request.";
    exit();
}
?>
