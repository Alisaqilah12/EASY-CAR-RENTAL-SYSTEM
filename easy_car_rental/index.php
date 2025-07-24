<?php
session_start();
?>
<?php include 'includes/navbar.php'; ?>

<style>
    @keyframes gradientMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    body {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb, #90caf9);
        background-size: 400% 400%;
        animation: gradientMove 12s ease infinite;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, rgba(30, 60, 114, 0.9), rgba(42, 82, 152, 0.9));
        color: white;
        padding: 50px 25px;
        border-radius: 12px;
        max-width: 950px;
        margin: 0 auto;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }
    .hero-section:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.6);
    }
    .hero-section h1 {
        font-size: 2.2rem;
        font-weight: 700;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.6);
    }
    .hero-section p {
        font-size: 1rem;
        margin-top: 10px;
        color: #e0e0e0;
    }
    .hero-section .btn {
        padding: 10px 25px;
        font-size: 1rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        transition: 0.3s;
    }
    .hero-section .btn:hover {
        background: #28a745;
        transform: scale(1.05);
    }

    /* Why Section */
    .why-section {
        background: linear-gradient(135deg, #2c3e50, #4ca1af);
        padding: 30px 20px;
        border-radius: 12px;
        max-width: 950px;
        margin: 30px auto;
        box-shadow: 0 8px 30px rgba(0,0,0,0.4);
    }
    .why-section h2 {
        color: #fff;
        font-size: 1.8rem;
        text-shadow: 1px 1px 5px rgba(0,0,0,0.6);
    }
    .hover-card {
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .hover-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.3);
    }
    .hover-card i {
        font-size: 2rem;
        color: #2a5298;
        text-shadow: 1px 1px 4px rgba(0,0,0,0.3);
        transition: color 0.3s ease, transform 0.3s ease;
    }
    .hover-card:hover i {
        color: #1565c0;
        transform: scale(1.2);
    }
    .hover-card h5 {
        font-weight: 600;
        margin-top: 10px;
    }
    .hover-card p {
        color: #555;
        font-size: 0.9rem;
    }
</style>

<main class="container my-4">
    <!-- Hero Section -->
    <div class="hero-section text-center shadow-sm">
        <h1 class="fw-bold">Welcome to Easy Car Rental 🚗</h1>
        <p class="col-lg-8 mx-auto">
            Book your car easily and enjoy a smooth experience with our online booking system.
        </p>
        <a class="btn btn-success mt-3" href="booking.php">
            <i class="bi bi-car-front-fill"></i> Start Booking
        </a>
    </div>

    <!-- Why Choose Us Section -->
    <section class="why-section shadow-sm mt-4">
        <h2 class="text-center mb-4 fw-bold">Why Choose Us?</h2>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="hover-card">
                    <i class="bi bi-speedometer2 text-primary"></i>
                    <h5>Fast Service</h5>
                    <p>Quick and hassle-free car booking process for your convenience.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="hover-card">
                    <i class="bi bi-cash-coin text-success"></i>
                    <h5>Affordable Price</h5>
                    <p>Enjoy the best rates with transparent pricing and no hidden fees.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="hover-card">
                    <i class="bi bi-headset text-danger"></i>
                    <h5>24/7 Support</h5>
                    <p>We are available round-the-clock to assist with your needs.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
