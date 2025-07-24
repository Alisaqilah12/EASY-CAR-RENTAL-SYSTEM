<?php
session_start();
include 'includes/db.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();
    $stmt->close();

    header("Location: login.php");
    exit();
}

include 'includes/header.php';
?>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }

    /* Background animasi tapi tak kacau header */
    .register-background {
        background: linear-gradient(-45deg, #1e3c72, #2a5298, #6a11cb, #2575fc);
        background-size: 400% 400%;
        animation: gradientBG 12s ease infinite;
        min-height: calc(100vh - 70px); /* Kurang tinggi navbar */
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .register-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        padding: 35px;
        max-width: 420px;
        width: 100%;
        color: #fff;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .register-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.7);
    }

    .register-card h2 {
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.4);
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.85);
        border: none;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .btn-primary {
        background: linear-gradient(45deg, #2a5298, #1e3c72);
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-weight: 600;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #1e3c72, #2a5298);
    }

    .register-card a {
        color: #fff;
        text-decoration: underline;
    }

    .register-card small {
        display: block;
        margin-top: 15px;
        font-size: 0.9rem;
    }
</style>

<div class="register-background">
    <div class="register-card">
        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
            <small>Already have an account? <a href="login.php">Login here</a></small>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
