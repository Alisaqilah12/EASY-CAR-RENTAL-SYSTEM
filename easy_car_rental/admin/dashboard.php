<?php
session_start();
include '../includes/db.php';

// Pastikan admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Data dashboard
$total_bookings = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];
$total_users    = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$total_reviews  = $conn->query("SELECT COUNT(*) AS total FROM reviews")->fetch_assoc()['total'];
$new_bookings   = $conn->query("SELECT COUNT(*) AS total FROM bookings WHERE is_read=0")->fetch_assoc()['total'];

// Update status booking sudah dibaca
$conn->query("UPDATE bookings SET is_read=1 WHERE is_read=0");

include '../includes/navbar_admin.php';
?>

<style>
    body {
        background: linear-gradient(135deg, #b0b8e0, #d5d5d5); /* Lembut tapi sikit gelap */
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .dashboard-container {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }
    .dashboard-card {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        width: 100%;
        max-width: 1000px;
    }
    .dashboard-card h2 {
        text-align: center;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 20px;
    }
    .dashboard-stats .card {
        border-radius: 10px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .dashboard-stats .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    .alert-info {
        text-align: center;
        font-weight: 500;
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-card">
        <h2 class="mb-4">Admin Dashboard</h2>

        <?php if ($new_bookings > 0): ?>
            <div class="alert alert-info">
                You have <?= $new_bookings ?> new booking(s)!
            </div>
        <?php endif; ?>

        <div class="row dashboard-stats g-4">
            <div class="col-md-4">
                <div class="card shadow text-center border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Total Bookings</h5>
                        <p class="display-5 fw-bold"><?= $total_bookings ?></p>
                        <a href="manage_bookings.php" class="btn btn-outline-primary btn-sm">View Bookings</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow text-center border-0">
                    <div class="card-body">
                        <h5 class="card-title text-success">Total Users</h5>
                        <p class="display-5 fw-bold"><?= $total_users ?></p>
                        <a href="manage_users.php" class="btn btn-outline-success btn-sm">View Users</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow text-center border-0">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Total Reviews</h5>
                        <p class="display-5 fw-bold"><?= $total_reviews ?></p>
                        <a href="manage_reviews.php" class="btn btn-outline-warning btn-sm">View Reviews</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
