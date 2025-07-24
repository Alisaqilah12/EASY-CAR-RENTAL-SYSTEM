<?php
session_start();
include 'includes/db.php';

// Proses login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: booking.php");
        }
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}

include 'includes/header.php';
?>

<style>
    body {
        background: linear-gradient(-45deg, #1e3c72, #2a5298, #6a11cb, #2575fc);
        background-size: 400% 400%;
        animation: gradientBG 12s ease infinite;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .login-wrapper {
        min-height: calc(100vh - 120px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
        padding: 35px 30px;
        max-width: 380px;
        width: 100%;
        text-align: center;
        color: #fff;
        animation: fadeIn 0.7s ease-in-out;
        transition: transform 0.3s;
    }

    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.7);
    }

    .login-card h2 {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 20px;
        text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.4);
    }

    .form-control {
        border-radius: 8px;
        font-size: 14px;
        background-color: rgba(255, 255, 255, 0.85);
        border: none;
        margin-bottom: 15px;
        padding: 10px;
    }

    .btn-primary {
        background: linear-gradient(45deg, #2a5298, #1e3c72);
        border: none;
        border-radius: 8px;
        font-size: 15px;
        padding: 10px;
        transition: all 0.3s ease;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #1e3c72, #2a5298);
        transform: scale(1.05);
        box-shadow: 0 6px 14px rgba(0,0,0,0.4);
    }

    .login-card a {
        color: #fff;
        text-decoration: underline;
        font-weight: 500;
    }

    .login-card small {
        display: block;
        margin-top: 15px;
        font-size: 0.9rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="mt-3">
            <small>Don't have an account? <a href="register.php">Register here</a></small>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
