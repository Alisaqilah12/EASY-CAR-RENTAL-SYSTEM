<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$car_id = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;

// Semak booking
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id=? AND car_id=?");
$stmt->bind_param("ii", $user_id, $car_id);
$stmt->execute();
$booking = $stmt->get_result();
$stmt->close();

if ($booking->num_rows == 0) {
    die("You can only review cars you have booked.");
}

// Proses review
if(isset($_POST['submit_review'])){
    $rating = (int)$_POST['rating'];
    $comment = trim($_POST['comment']);

    $stmt = $conn->prepare("INSERT INTO reviews (user_id, car_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user_id, $car_id, $rating, $comment);
    $stmt->execute();
    $stmt->close();

    $message = "Review submitted successfully!";
}

// Ambil review
$stmt = $conn->prepare("SELECT r.*, u.username FROM reviews r 
                        JOIN users u ON r.user_id = u.user_id
                        WHERE r.car_id=? ORDER BY r.created_at DESC");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$reviews = $stmt->get_result();
$stmt->close();

// Ambil maklumat kereta
$stmt = $conn->prepare("SELECT * FROM cars WHERE car_id=?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$car = $stmt->get_result()->fetch_assoc();
$stmt->close();

include 'includes/header.php';
?>

<style>
    .reviews-page {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        min-height: calc(100vh - 70px); /* Tolak tinggi header */
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    .review-container {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        max-width: 700px;
        width: 100%;
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
    .review-container h2 {
        font-weight: bold;
        color: #1e3c72;
        text-align: center;
        margin-bottom: 15px;
    }
    .review-form label {
        font-weight: 600;
        color: #333;
    }
    .review-card {
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>

<div class="reviews-page">
    <div class="review-container">
        <h2>Reviews for <?= $car['car_name'] ?> (<?= $car['car_model'] ?>)</h2>
        <hr>

        <?php if(isset($message)): ?>
            <div class="alert alert-success text-center"><?= $message ?></div>
        <?php endif; ?>

        <!-- Form Review -->
        <form method="POST" class="review-form mb-4">
            <div class="mb-3">
                <label>Rating (1-5)</label>
                <select name="rating" class="form-control" required>
                    <option value="">Select</option>
                    <?php for ($i=1; $i<=5; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Comment</label>
                <textarea name="comment" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" name="submit_review" class="btn btn-primary w-100">Submit Review</button>
        </form>

        <!-- Senarai Review -->
        <h4 class="text-center mb-3">All Reviews</h4>
        <?php if ($reviews->num_rows > 0): ?>
            <?php while ($r = $reviews->fetch_assoc()): ?>
                <div class="card mb-2 review-card">
                    <div class="card-body">
                        <strong><?= $r['username'] ?></strong> 
                        <span class="badge bg-success ms-2">Rating: <?= $r['rating'] ?>/5</span>
                        <p class="mt-2"><?= $r['comment'] ?></p>
                        <small class="text-muted"><?= $r['created_at'] ?></small>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info text-center">No reviews yet for this car.</div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
