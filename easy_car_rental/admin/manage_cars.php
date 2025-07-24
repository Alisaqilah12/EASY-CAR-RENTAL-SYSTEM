<?php
session_start();
include '../includes/navbar_admin.php';

// Pastikan admin login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Tambah kereta
if (isset($_POST['add_car'])) {
    $car_name = $_POST['car_name'];
    $car_model = $_POST['car_model'];
    $price = $_POST['price_per_day'];

    // Upload gambar
    $image_name = '';
    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $image_name);
    }

    $stmt = $conn->prepare("INSERT INTO cars (car_name, car_model, price_per_day, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $car_name, $car_model, $price, $image_name);
    $stmt->execute();
    $stmt->close();

    $message = "Car added successfully!";
}

// Delete kereta
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM cars WHERE car_id = $id");
    header("Location: manage_cars.php");
    exit();
}

// Ambil semua kereta
$cars = $conn->query("SELECT * FROM cars ORDER BY car_name ASC");

include '../includes/header.php';
?>

<h2>Manage Cars</h2>
<hr>

<?php if (isset($message)): ?>
    <div class="alert alert-success"><?= $message ?></div>
<?php endif; ?>

<!-- Form Tambah Kereta -->
<form method="POST" enctype="multipart/form-data" class="mb-4">
    <div class="mb-3">
        <label>Car Name</label>
        <input type="text" name="car_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Car Model</label>
        <input type="text" name="car_model" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Price per Day (RM)</label>
        <input type="number" step="0.01" name="price_per_day" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Car Image</label>
        <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" name="add_car" class="btn btn-primary">Add Car</button>
</form>

<!-- Senarai Kereta -->
<h4>Car List</h4>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Name</th>
            <th>Model</th>
            <th>Price/Day</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($cars->num_rows > 0): ?>
            <?php $i=1; while ($car = $cars->fetch_assoc()): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td>
                    <?php if ($car['image']): ?>
                        <img src="../assets/images/<?= $car['image'] ?>" alt="<?= $car['car_name'] ?>" width="80">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
                <td><?= $car['car_name'] ?></td>
                <td><?= $car['car_model'] ?></td>
                <td>RM <?= number_format($car['price_per_day'],2) ?></td>
                <td>
                    <a href="?delete=<?= $car['car_id'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Delete this car?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">No cars found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
