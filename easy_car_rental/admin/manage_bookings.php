<?php
session_start();
include '../includes/db.php';

// Pastikan admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Jika admin klik "Mark as Paid"
if (isset($_GET['set_paid'])) {
    $booking_id = intval($_GET['set_paid']);
    $stmt = $conn->prepare("UPDATE bookings SET payment_status = 'Paid' WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_bookings.php");
    exit();
}

// Dapatkan semua booking
$bookings = $conn->query("
    SELECT b.*, u.username, c.car_name 
    FROM bookings b
    JOIN users u ON b.user_id = u.user_id
    JOIN cars c ON b.car_id = c.car_id
    ORDER BY b.booking_date DESC
");
?>

<?php include '../includes/navbar_admin.php'; ?>

<style>
    body {
        background: linear-gradient(135deg, #0b0c10, #1f2833, #0d47a1);
        color: #fff;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .manage-bookings-container {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    .manage-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        width: 100%;
        max-width: 1100px;
        overflow: hidden;
    }
    .manage-card .card-header {
        background: linear-gradient(135deg, #1565c0, #0d47a1);
        color: #fff;
        border: none;
        text-align: center;
        font-size: 1.4rem;
        padding: 20px;
        font-weight: bold;
    }
    table th, table td {
        text-align: center;
        vertical-align: middle;
        font-size: 0.9rem;
    }
    table thead th {
        background: #0d47a1;
        color: #fff;
    }
    .badge-success {
        background-color: #28a745;
        color: white;
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 0.85rem;
    }
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 0.85rem;
    }
    .btn-success {
        background-color: #28a745;
        border: none;
        transition: 0.3s;
        font-size: 0.8rem;
        padding: 5px 12px;
        border-radius: 6px;
    }
    .btn-success:hover {
        background-color: #218838;
    }
    .table-responsive {
        max-height: 65vh;
        overflow-y: auto;
    }
</style>

<div class="manage-bookings-container">
    <div class="card manage-card">
        <div class="card-header">
            Manage Bookings
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Car</th>
                            <th>Pickup Date</th>
                            <th>Return Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($bookings->num_rows > 0): ?>
                            <?php $i = 1; while ($b = $bookings->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($b['username']) ?></td>
                                <td><?= htmlspecialchars($b['car_name']) ?></td>
                                <td><?= $b['booking_date'] ?></td>
                                <td><?= $b['return_date'] ?></td>
                                <td>RM <?= number_format($b['total_price'], 2) ?></td>
                                <td>
                                    <?php if (strtolower($b['payment_status']) == 'paid'): ?>
                                        <span class="badge-success">✅ Successful</span>
                                    <?php else: ?>
                                        <span class="badge-warning">❌ Unsuccessful</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (strtolower($b['payment_status']) == 'pending'): ?>
                                        <a href="manage_bookings.php?set_paid=<?= $b['booking_id'] ?>" 
                                           class="btn btn-sm btn-success"
                                           onclick="return confirm('Mark this booking as Paid?')">
                                           Mark as Paid
                                        </a>
                                    <?php else: ?>
                                        <span class="text-success fw-bold">Paid</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center">No bookings found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
