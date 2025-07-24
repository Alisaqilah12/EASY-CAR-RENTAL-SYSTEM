<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Car Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling Brand dengan emoji */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .navbar-brand::before {
            content: "🚗";
            font-size: 1.4rem;
        }

        /* Link Menu */
        .nav-link {
            position: relative;
            color: #fff !important;
            transition: 0.3s ease;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 8px;
        }

        /* Efek timbul bila hover */
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            transform: translateY(-2px);
        }

        /* Efek active link */
        .nav-link.active {
            background: #0d6efd;
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">Easy Car Rental</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
           <ul class="navbar-nav ms-auto">
             <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
             <li class="nav-item"><a class="nav-link" href="booking.php">Booking</a></li>
             <li class="nav-item"><a class="nav-link" href="my_bookings.php">My Bookings</a></li>
             <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
             <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
           </ul>
        </div>
    </div>
</nav>
<div class="container mt-3">
