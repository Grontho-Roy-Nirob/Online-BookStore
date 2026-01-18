<?php
session_start();
include("../Db/dbregister.php"); // $conn

/* CHECK LOGIN */
if (!isset($_SESSION['username'])) {
    echo "login";
    exit();
}

/* CREATE CART */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    echo "invalid";
    exit();
}
