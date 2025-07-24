<?php
session_start();
include '../includes/db.php';

// Pastikan admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}

$user_id = (int)$_GET['id'];

// Ambil data user
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    header("Location: manage_users.php");
    exit();
}

// Update user
if (isset($_POST['update'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $username, $email, $user_id);
    if ($stmt->execute()) {
        header("Location: manage_users.php?msg=updated");
        exit();
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #d9e4f5, #f6f9fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .edit-card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        .edit-card h4 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="edit-card">
        <h4>Edit User</h4>
        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary w-100">Update</button>
            <a href="manage_users.php" class="btn btn-secondary w-100 mt-2">Back</a>
        </form>
    </div>
</body>
</html>
