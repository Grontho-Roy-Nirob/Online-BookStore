<?php
session_start();
include("../Db/dbregister.php");

/* Must login */
if (!isset($_SESSION['username'])) {
    $_SESSION['login_error'] = "Please login to view order history";
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

/* Basic safety (escape username) */
$usernameEsc = $conn->real_escape_string($username);

/* Fetch orders (OOP) */
$sql = "SELECT order_id, order_date, payment_method, total_amount
        FROM orders
        WHERE username='$usernameEsc'
        ORDER BY order_id DESC";
$result = $conn->query($sql);
?>