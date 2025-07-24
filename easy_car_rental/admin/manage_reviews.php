<?php
session_start();
include '../includes/db.php';

// Pastikan admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$reviews = $conn->query("
    SELECT r.*, u.username, c.car_name
    FROM reviews r
    JOIN users u ON r.user_id = u.user_id
    JOIN cars c ON r.car_id = c.car_id
    ORDER BY r.created_at DESC
");
?>
<?php include '../includes/navbar_admin.php'; ?>

<style>
    body {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
        color: #333;
    }
    .manage-reviews-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }
    .manage-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 128, 0, 0.2);
        width: 100%;
        max-width: 1100px;
        overflow: hidden;
        border: 2px solid #4caf50;
    }
    .manage-card .card-header {
        background: linear-gradient(135deg, #43a047, #388e3c);
        color: #fff;
        text-align: center;
        font-size: 1.3rem;
        font-weight: bold;
        padding: 20px;
    }
    table th, table td {
        text-align: center;
        vertical-align: middle;
    }
    table thead th {
        background: #4caf50;
        color: #fff;
        font-size: 1rem;
        letter-spacing: 0.5px;
    }
    table tbody tr:hover {
        background: #f1f8f4;
    }
    .badge.bg-info {
        background-color: #66bb6a !important;
        color: #fff;
        font-size: 0.9rem;
        padding: 6px 10px;
        border-radius: 5px;
    }
</style>

<div class="manage-reviews-container">
    <div class="card manage-card">
        <div class="card-header">
            Manage Reviews
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Car</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($reviews->num_rows > 0): ?>
                            <?php $i = 1; while ($r = $reviews->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($r['username']) ?></td>
                                <td><?= htmlspecialchars($r['car_name']) ?></td>
                                <td><span class="badge bg-info"><?= $r['rating'] ?>/5</span></td>
                                <td><?= htmlspecialchars($r['comment']) ?></td>
                                <td><?= $r['created_at'] ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">No reviews found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
