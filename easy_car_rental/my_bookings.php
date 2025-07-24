<?php
session_start();
include 'includes/db.php';

// Pastikan user login
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Cancel booking jika user klik
if (isset($_GET['cancel'])) {
    $id = (int)$_GET['cancel'];
    $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id=? AND user_id=?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: my_bookings.php");
    exit();
}

// Ambil semua booking milik user
$sql = "
    SELECT b.*, c.car_name, c.car_model, c.price_per_day, c.image
    FROM bookings b
    JOIN cars c ON b.car_id = c.car_id
    WHERE b.user_id = ?
    ORDER BY b.booking_date DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$bookings = $stmt->get_result();

include 'includes/header.php';
?>

<style>
    body {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        background-attachment: fixed;
    }
    .booking-section {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        max-width: 1100px;
        margin: 30px auto;
    }
    h2 {
        text-align: center;
        font-weight: bold;
        color: #0d6efd;
    }
    .table thead th {
        background: #0d6efd;
        color: #fff;
        text-align: center;
    }
    .table tbody td {
        vertical-align: middle;
        text-align: center;
        font-size: 0.95rem;
    }
    .table img {
        border-radius: 5px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
</style>

<div class="container">
    <div class="booking-section">
        <h2><i class="bi bi-calendar-check"></i> My Bookings</h2>
        <hr>

        <?php if ($bookings->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Car</th>
                            <th>Booking Date</th>
                            <th>Return Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php $i=1; while ($b = $bookings->fetch_assoc()): ?>
                       <tr>
                         <td><?= $i++ ?></td>
                         <td>
                             <?php if ($b['image']): ?>
                                <img src="assets/image/<?= $b['image'] ?>" alt="<?= $b['car_name'] ?>" width="70"><br>
                             <?php endif; ?>
                             <strong><?= $b['car_name'] ?></strong> (<?= $b['car_model'] ?>)
                         </td>
                         <td><?= $b['booking_date'] ?></td>
                         <td><?= $b['return_date'] ?></td>
                         <td><span class="badge bg-success">RM <?= number_format($b['total_price'],2) ?></span></td>
                         <td>
                            <span class="badge bg-<?= $b['payment_status'] == 'paid' ? 'success' : 'warning' ?>">
                                <?= ucfirst($b['payment_status']) ?>
                            </span>
                         </td>
                         <td>
                            <a href="reviews.php?car_id=<?= $b['car_id'] ?>" class="btn btn-sm btn-info mb-1">
                                <i class="bi bi-chat-dots"></i> Review
                            </a>
                            <a href="?cancel=<?= $b['booking_id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Cancel this booking?')">
                               <i class="bi bi-x-circle"></i> Cancel
                            </a>
                         </td>
                       </tr>
                       <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">You have no bookings yet.</div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
