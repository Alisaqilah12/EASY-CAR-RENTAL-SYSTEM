<?php
session_start();

// Buang semua session admin
unset($_SESSION['admin_id']);
unset($_SESSION['admin_name']);
session_destroy();

// Redirect ke halaman login admin
header("Location: login.php");
exit();
