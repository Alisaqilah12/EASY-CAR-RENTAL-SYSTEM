<?php
session_start();
include 'includes/db.php';

// Pastikan user login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Bila user submit booking
if (isset($_POST['book'])) {
    $car_id = (int)$_POST['car_id'];
    $booking_date = $_POST['booking_date'];
    $return_date = $_POST['return_date'];

    // Ambil harga kereta
    $stmt = $conn->prepare("SELECT price_per_day FROM cars WHERE car_id=?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $stmt->bind_result($price_per_day);
    $stmt->fetch();
    $stmt->close();

    // Kira jumlah harga
    $days = (strtotime($return_date) - strtotime($booking_date)) / 86400;
    if ($days <= 0) $days = 1;
    $total_price = $price_per_day * $days;

    // Simpan booking
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, car_id, booking_date, return_date, total_price, payment_status, is_read) 
                            VALUES (?, ?, ?, ?, ?, 'pending', 0)");
    $stmt->bind_param("iissd", $user_id, $car_id, $booking_date, $return_date, $total_price);
    $stmt->execute();
    $stmt->close();

    $message = "Booking successfully created!";
}

// Ambil semua kereta
$cars = $conn->query("SELECT * FROM cars");

include 'includes/header.php';
?>

<style>
    body {
        background: linear-gradient(-45deg, #1e3c72, #2a5298, #6a11cb, #2575fc);
        background-size: 400% 400%;
        animation: gradientBG 12s ease infinite;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        font-family: 'Poppins', sans-serif;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    main {
        flex: 1;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .booking-section {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 20px;
        border-radius: 12px;
        color: #fff;
        text-align: center;
        width: 100%;
        max-width: 900px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.7s ease;
    }

    .booking-section h2 {
        font-weight: 700;
        font-size: 1.8rem;
        text-shadow: 1px 1px 6px rgba(0,0,0,0.4);
    }

    .car-list {
        max-height: 60vh;
        overflow-y: auto;
        padding: 10px;
        width: 100%;
        max-width: 950px;
        margin-top: 15px;
    }

    .car-card {
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        background: #fff;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    .car-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .car-card img {
        height: 150px;
        object-fit: cover;
    }

    .car-card .card-body {
        padding: 10px;
    }

    .car-card h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #1e3c72;
    }

    .car-card p {
        font-size: 0.9rem;
        color: #444;
    }

    .btn-success {
        background: linear-gradient(45deg, #28a745, #218838);
        border: none;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .btn-success:hover {
        background: linear-gradient(45deg, #218838, #28a745);
        transform: scale(1.05);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<main>
    <div class="booking-section shadow">
        <h2>🚗 Book Your Car</h2>
        <p style="font-size: 0.9rem;">Choose your preferred car and fill in your booking details.</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert alert-success text-center mt-2"><?= $message ?></div>
    <?php endif; ?>

    <div class="car-list row g-3 mt-3">
        <?php while ($car = $cars->fetch_assoc()): ?>
            <div class="col-md-4 col-sm-6">
                <div class="card car-card">
                    <?php if ($car['image']): ?>
                        <img src="assets/image/<?= $car['image'] ?>" class="card-img-top" alt="<?= $car['car_name'] ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5><?= $car['car_name'] ?> (<?= $car['car_model'] ?>)</h5>
                        <p>Price: <strong>RM <?= number_format($car['price_per_day'], 2) ?> / day</strong></p>
                        <form method="POST">
                            <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">
                            <div class="mb-2">
                                <label class="form-label" style="font-size: 0.85rem;">Booking Date</label>
                                <input type="date" name="booking_date" class="form-control form-control-sm" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label" style="font-size: 0.85rem;">Return Date</label>
                                <input type="date" name="return_date" class="form-control form-control-sm" required>
                            </div>
                            <button type="submit" name="book" class="btn btn-success btn-sm w-100">Book Now</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
