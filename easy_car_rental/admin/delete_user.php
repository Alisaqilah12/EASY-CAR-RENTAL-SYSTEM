<?php
session_start();
include '../includes/db.php';

// Pastikan admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = (int)$_GET['id'];

    // Padam semua review user (jika ada table reviews)
    $stmt = $conn->prepare("DELETE FROM reviews WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Padam semua booking user
    $stmt = $conn->prepare("DELETE FROM bookings WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Akhir sekali padam user
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        header("Location: manage_users.php?msg=deleted");
        exit();
    } else {
        echo "Failed to delete user.";
    }
    $stmt->close();
} else {
    header("Location: manage_users.php");
    exit();
}
