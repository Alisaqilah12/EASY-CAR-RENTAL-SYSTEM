<?php
session_start();
session_unset();    // Hapus semua data session
session_destroy();  // Musnahkan session
header("Location: index.php");  // Redirect ke homepage
exit();
