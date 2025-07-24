<?php
session_start();
include 'includes/db.php';

// Pastikan user sudah login
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user
$stmt = $conn->prepare("SELECT username, email FROM users WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

// Update profile
if (isset($_POST['update'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];

    if (!empty($new_password)) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username=?, email=?, password=? WHERE user_id=?");
        $stmt->bind_param("sssi", $new_username, $new_email, $hashed, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username=?, email=? WHERE user_id=?");
        $stmt->bind_param("ssi", $new_username, $new_email, $user_id);
    }
    $stmt->execute();
    $stmt->close();

    $message = "Profile updated successfully!";
    $username = $new_username;
    $email = $new_email;
}

include 'includes/header.php';
?>

<style>
    body {
        background: linear-gradient(135deg, #c9e5f5, #fdfbfb);
        background-attachment: fixed;
    }
    .profile-container {
        min-height: 80vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    .profile-card {
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        max-width: 420px;
        width: 100%;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    .profile-card h2 {
        text-align: center;
        color: #0d6efd;
        margin-bottom: 15px;
        font-weight: bold;
    }
    .form-label {
        font-weight: 500;
        color: #333;
    }
    .btn-primary {
        background: #0d6efd;
        border: none;
        transition: background 0.3s;
    }
    .btn-primary:hover {
        background: #0b5ed7;
    }
</style>

<div class="profile-container">
    <div class="profile-card">
        <h2><i class="bi bi-person-circle"></i> Edit Profile</h2>
        <hr>
        <?php if (isset($message)): ?>
            <div class="alert alert-success text-center"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= $username ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $email ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">New Password <small>(leave empty if not changing)</small></label>
                <input type="password" name="password" class="form-control">
            </div>
            <button type="submit" name="update" class="btn btn-primary w-100">Update Profile</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 