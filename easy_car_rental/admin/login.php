<?php
session_start();
include '../includes/db.php';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']); // sementara guna MD5

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username=? AND password=? LIMIT 1");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_name'] = $admin['name'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Easy Car Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            background: linear-gradient(-45deg, #0f2027, #203a43, #2c5364, #0d6efd);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
        }

        .login-card .card-header {
            background: rgba(0, 0, 0, 0.5);
            text-align: center;
            padding: 25px;
        }

        .login-card h4 {
            margin: 0;
            font-weight: bold;
            color: #fff;
        }

        .card-body {
            padding: 25px;
            color: #fff;
        }

        .form-control {
            background: rgba(255,255,255,0.2);
            border: none;
            color: #fff;
        }

        .form-control::placeholder {
            color: #e0e0e0;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.3);
            outline: none;
            box-shadow: 0 0 5px #fff;
        }

        .btn-primary {
            background: #ff9800;
            border: none;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #e68900;
        }

        a.text-muted {
            color: #ddd !important;
        }

        a.text-muted:hover {
            color: #fff !important;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="card-header">
        <h4>Admin Login</h4>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required placeholder="Enter your username">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Enter your password">
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
    <div class="text-center py-3">
        <a href="../index.php" class="text-muted">← Back to Home</a>
    </div>
</div>

</body>
</html>
