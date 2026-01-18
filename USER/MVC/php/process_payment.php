<?php
session_start();
include "../Db/dbregister.php";

/* Security checks */
if (!isset($_SESSION['username']) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header("Location: checkout.php");
    exit();
}

/* Get form data */
$username = $_SESSION['username'];
$name     = trim($_POST['name'] ?? "");
$mobile   = trim($_POST['mobile'] ?? "");
$address  = trim($_POST['address'] ?? "");
$method   = $_POST['payment_method'] ?? "";

$payment_number = "";
