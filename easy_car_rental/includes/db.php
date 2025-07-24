<?php
$conn = new mysqli("localhost", "root", "", "easy_car_rental");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
