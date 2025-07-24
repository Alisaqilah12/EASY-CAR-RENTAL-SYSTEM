<?php
session_start();
include '../includes/db.php';

// Pastikan admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Dapatkan semua user
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");

// Dapatkan jumlah user
$total_users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];

// Dapatkan user terakhir register
$last_user = $conn->query("SELECT username, created_at FROM users ORDER BY created_at DESC LIMIT 1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #8B5E3C, #D2B48C, #F5DEB3); /* Koko gradient */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #fff;
            font-family: 'Poppins', sans-serif;
        }
        .users-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 30px 10px;
        }
        .users-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 1100px;
            padding: 20px;
            backdrop-filter: blur(10px);
        }
        .card-header {
            border-radius: 18px 18px 0 0;
            background: linear-gradient(135deg, #5C4033, #A0522D); /* dark brown gradient */
            color: #fff;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            font-size: 1.7rem;
            letter-spacing: 1px;
        }
        /* Info cards */
        .info-cards {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
        }
        .info-box {
            background: linear-gradient(135deg, #D2B48C, #C19A6B); /* Soft tan */
            border-radius: 12px;
            padding: 15px;
            flex: 1;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transition: transform 0.3s ease;
        }
        .info-box:hover {
            transform: scale(1.05);
        }
        .info-box h4 {
            margin: 0;
            font-size: 1.4rem;
            color: #4B2E2E; /* Darker brown */
            font-weight: bold;
        }
        .info-box p {
            font-size: 0.9rem;
            margin: 3px 0 0;
            color: #2f1f1f;
        }
        /* Table */
        table th, table td {
            text-align: center;
            vertical-align: middle;
            font-size: 0.95rem;
            color: #2f1f1f;
        }
        table thead th {
            background: #5C4033; /* Brown header */
            color: #fff;
        }
        .table-responsive {
            max-height: 60vh;
            overflow-y: auto;
        }
        .btn-warning, .btn-danger {
            font-size: 0.8rem;
        }
        .btn-warning {
            background-color: #DAA520;
            border: none;
        }
        .btn-warning:hover {
            background-color: #B8860B;
        }
        .btn-danger {
            background-color: #8B0000;
            border: none;
        }
        .btn-danger:hover {
            background-color: #5A0000;
        }
    </style>
</head>
<body>

<?php include '../includes/navbar_admin.php'; ?>

<div class="users-container">
    <div class="users-card">
        <div class="card-header">
            Manage Users
        </div>

        <!-- Info Section -->
        <div class="info-cards">
            <div class="info-box">
                <h4><?= $total_users ?></h4>
                <p>Total Users</p>
            </div>
            <div class="info-box">
                <h4><?= htmlspecialchars($last_user['username']) ?></h4>
                <p>Last Registered (<?= $last_user['created_at'] ?>)</p>
            </div>
        </div>

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users->num_rows > 0): ?>
                        <?php $i = 1; while ($u = $users->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($u['username']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= $u['created_at'] ?></td>
                            <td>
                                <a href="edit_user.php?id=<?= $u['user_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_user.php?id=<?= $u['user_id'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete this user? All related bookings and reviews will also be deleted!')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-dark">No users found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
